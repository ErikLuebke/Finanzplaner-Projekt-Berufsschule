<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konto;

class KontoController extends Controller
{
    public function index()
    {
        return auth()->user()->kontos()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->id();

        return Konto::create($data);
    }

    public function show($id)
    {
        return auth()->user()->kontos()->where('kontoid', $id)->firstOrFail();
    }

    public function update(Request $request, $id)
    {
        $konto = auth()->user()->kontos()->where('kontoid', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $konto->update($data);

        return $konto;
    }

    public function destroy($id)
    {
        $konto = auth()->user()->kontos()->where('kontoid', $id)->firstOrFail();
        $konto->delete();

        return response()->json(['message' => 'Gelöscht']);
    }
}
