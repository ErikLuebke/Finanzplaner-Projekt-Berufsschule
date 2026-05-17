<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontobewegung;

class KontobewegungController extends Controller
{
    public function index(Request $request)
    {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $query = Kontobewegung::with(['konto', 'kategorie'])
            ->whereIn('konto_id', $kontoIds);

        if ($request->has('konto_id')) {
            $query->where('konto_id', $request->konto_id);
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'konto_id' => 'required|integer',
            'kategorie_id' => 'required|integer',
            'date'=> 'required|date',
            'fix'=> 'required|boolean',
            'geldwert'=> 'required|numeric',
        ]);

        $kontoIds = auth()->user()->kontos()->pluck('kontoid')->toArray();
        abort_unless(in_array($data['konto_id'], $kontoIds), 403);

        return Kontobewegung::create($data);
    }

    public function show($id)
    {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');
        return Kontobewegung::whereIn('konto_id', $kontoIds)->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');
        $eintrag = Kontobewegung::whereIn('konto_id', $kontoIds)->findOrFail($id);

        $data = $request->validate([
            'konto_id' => 'required|integer',
            'kategorie_id' => 'required|integer',
            'date'=> 'required|date',
            'fix'=> 'required|boolean',
            'geldwert'=> 'required|numeric',
        ]);

        abort_unless(in_array($data['konto_id'], $kontoIds->toArray()), 403);

        $eintrag->update($data);

        return $eintrag;
    }

    public function destroy($id)
    {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');
        Kontobewegung::whereIn('konto_id', $kontoIds)->findOrFail($id)->delete();

        return response()->json(['message'=> 'Gelöscht']);
    }

    public function pieChartData(Request $request)
    {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $daten = Kontobewegung::with('kategorie')
            ->whereIn('konto_id', $kontoIds)
            ->get()
            ->groupBy('kategorie_id')
            ->map(function ($group) {
                return[
                    'name' => $group->first()->kategorie->bezeichnung,
                    'value' => $group->sum('geldwert')
                ];
            })
            ->values();
        return response()->json($daten);
    }

    public function history(Request $request) {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $data = Kontobewegung::with(['konto', 'kategorie'])
            ->whereIn('konto_id', $kontoIds)
            ->get();

        return response()->json($data);
    }

    public function historyPreview(Request $request) {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $data = Kontobewegung::with(['konto', 'kategorie'])
            ->whereIn('konto_id', $kontoIds)
            ->take(5)
            ->get();

        return response()->json($data);
    }

    public function fixCosts(Request $request) {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $data = Kontobewegung::with(['konto', 'kategorie'])
            ->whereIn('konto_id', $kontoIds)
            ->where('fix', 1)
            ->get();

            return response()->json($data);
    }

    public function fixCostsDestroy(Request $request, $id) {
        $kontoIds = auth()->user()->kontos()->pluck('kontoid');

        $data = Kontobewegung::whereIn('konto_id', $kontoIds)->findOrFail($id)->delete();

            return response()->json(['message' => 'Fixkosten erfolgreich gelöscht.']);
    
    }

    public function fixCostsStore(Request $request)
{
    $kontoIds = auth()->user()->kontos()->pluck('kontoid');
    $data = $request->validate([
        'konto_id' => 'required|integer',
        'kategorie_id' => 'required|integer',
        'date' => 'required|date',
        'geldwert' => 'required|numeric',
        'fix' => 'required|boolean',
    ]);

    $eintrag = Kontobewegung::create($data);

    return response()->json($eintrag->load(['konto', 'kategorie']));
}
}
