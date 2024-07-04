<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Semestre;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    // Afficher toutes les matières
    public function index()
    {
        $matieres = Matiere::with('anneeScolaire', 'enseignant', 'semestre')->get();
        return response()->json($matieres);
    }
    // Stocker une nouvelle matière
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'semestre_id' => 'nullable|exists:semestres,id',

        ]);

        $matiere = Matiere::create($request->all());

        return response()->json(['message' => 'Matière créée avec succès', 'matiere' => $matiere], 201);
    }
     // Afficher une matière spécifique
     public function show($id)
     {
         $matiere = Matiere::with('anneeScolaire', 'enseignant', 'semestre')->findOrFail($id);
         return response()->json($matiere);
     }
     // Afficher le formulaire de création de matière
    public function create()
    {
        $anneesScolaires = AnneeScolaire::all();
        $enseignants = Enseignant::all();
        $semestres = Semestre::all();
        return view('matieres.create', compact('anneesScolaires', 'enseignants', 'semestres'));
    }
    // Afficher le formulaire d'édition de matière
    public function edit($id)
    {
        $matiere = Matiere::findOrFail($id);
        $anneesScolaires = AnneeScolaire::all();
        $enseignants = Enseignant::all();
        $semestres = Semestre::all();
        return view('matieres.edit', compact('matiere', 'anneesScolaires', 'enseignants', 'semestres'));
    }
    // Mettre à jour une matière
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'semestre_id' => 'nullable|exists:semestres,id',
        ]);

        $matiere = Matiere::findOrFail($id);
        $matiere->update($request->all());

        return response()->json(['message' => 'Matière mise à jour avec succès', 'matiere' => $matiere]);
    }
    // Supprimer une matière
    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);
        $matiere->delete();

        return response()->json(['message' => 'Matière supprimée avec succès']);
    }
}
