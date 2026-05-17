<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontobewegung;

class ProgressController extends Controller
{
    public function progress(Request $request)
    {
        $kontoId = auth()->user()->kontos()->pluck('kontoid');

        $sumPos = Kontobewegung::where('konto_id', $kontoId)
            ->where('geldwert', '>', '0')
            ->sum('geldwert');

        $sumNeg = Kontobewegung::where('konto_id', $kontoId)
            ->where('geldwert', '<', '0')
            ->sum('geldwert');

        return response()->json([
            'sumPos' => (float) $sumPos,
            'sumNeg' => (float) $sumNeg,
        ]);
    }
}
