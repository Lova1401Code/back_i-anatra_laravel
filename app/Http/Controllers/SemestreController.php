<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Semestre;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
     // Afficher tous les semestres
     public function index()
     {
         $semestres = Semestre::with('anneeScolaire')->get();
         return response()->json($semestres);
     }
     // Stocker un nouveau semestre
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
        ]);

        $semestre = Semestre::create($request->all());

        return response()->json(['message' => 'Semestre créé avec succès', 'semestre' => $semestre], 201);
    }
    // Afficher un semestre spécifique
    public function show($id)
    {
        $semestre = Semestre::with('anneeScolaire')->findOrFail($id);
        return response()->json($semestre);
    }
    // Afficher le formulaire d'édition de semestre
    public function edit($id)
    {
        $semestre = Semestre::findOrFail($id);
        $anneesScolaires = AnneeScolaire::all();
        return view('semestres.edit', compact('semestre', 'anneesScolaires'));
    }
    // Supprimer un semestre
    public function destroy($id)
    {
        $semestre = Semestre::findOrFail($id);
        $semestre->delete();

        return response()->json(['message' => 'Semestre supprimé avec succès']);
    }

}
