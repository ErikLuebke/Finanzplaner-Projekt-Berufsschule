<?php

namespace App\Http\Controllers;

use App\Models\Sparziel;
use App\Models\Kontobewegung;
use Illuminate\Http\Request;

class SparzielController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'zielbetrag' => 'required|numeric|min:0.01',
            'zieldatum' => 'required|date|after:today',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Ungültige Authentifizierung'], 401);
        }

        $sparziel = new Sparziel();
        $sparziel->sparzielAnlegen($data['zielbetrag'], $data['zieldatum'], $user->id);

        return response()->json([
            'message' => 'Sparziel angelegt',
            'sparziel' => $sparziel,
        ], 201);
    }

    public function index()
    {
        return Sparziel::all();
    }

    public function show($id)
    {
        return Sparziel::findOrFail($id);
    }

    public function preview(Request $request)
    {
        $kontoId = auth()->user()->kontos()->value('kontoid');
        $userid = auth()->user()->value('userid');
        $zielbetrag = Sparziel::where("user_id", $userid)
            ->sum('zielbetrag');
        $aktuellerBetragN = Kontobewegung::where("konto_id", $kontoId)
            ->sum('geldwert');
        $aktuellerBetrag = abs($aktuellerBetragN);
        $restbetrag = $aktuellerBetrag - $zielbetrag;
        $previewData = [
            'zielbetrag' => $zielbetrag,
            'restbetrag' => $restbetrag
        ];
        return response()->json($previewData);
    }
}
