<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategorie;

class KategorieController extends Controller
{
    public function index()
    {
        return Kategorie::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategorieid' => 'required|integer',
            'bezeichnung' => 'required|string|max:255',
        ]);

        return Kategorie::create($data);
    }

    public function show($id)
    {
        return Kategorie::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kategorie = Kategorie::findOrFail($id);

        $data = $request->validate([
            'kategorieid' => 'required|integer',
            'bezeichnung' => 'required|string|max:255',
        ]);

        $kategorie->update($data);

        return $kategorie;
    }

    public function destroy($id)
    {
        $kategorie = Kategorie::findOrFail($id);
        $kategorie->delete();

        return response()->json(['message' => 'Gelöscht']);
    }
}