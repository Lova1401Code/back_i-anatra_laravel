<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClasseController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:classes',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'enseignant_id' => 'required|exists:enseignants,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $classe = Classe::create([
            'nom' => $request->nom,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'enseignant_id' => $request->enseignant_id,
        ]);
        return response()->json(['message' => 'Classe créée avec succès', 'data' => $classe], 201);
    }
    // Méthode pour ajouter un élève à une classe
    public function addEleveToClasse(Request $request, Classe $classe){
        $validator = Validator::make($request->all(), [
            'eleve_id' => 'required|exists:eleves,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $eleve = Eleve::find($request->eleve_id);
        if ($eleve) {
            $classe->eleves()->attach($eleve);
            return response()->json(['message' => 'Élève ajouté à la classe avec succès']);
        }

        return response()->json(['message' => 'Élève non trouvé'], 404);
    }
    // Méthode pour lister les classes
    public function index()
    {
        $classes = Classe::with('eleves')->get();
        return response()->json($classes);
    }
    // Méthode pour afficher une classe et ses élèves
    public function show(Classe $classe)
    {
        $classe->load('eleves');
        return response()->json($classe);
    }
    //récupérer la listes par une classe
    public function getEleves($classe_id)
    {
        $classe = Classe::find($classe_id);

        if (!$classe) {
            return response()->json(['message' => 'Classe non trouvée'], 404);
        }

        $eleves = $classe->eleves; // Assurez-vous d'avoir défini la relation dans le modèle Classe

        return response()->json($eleves);
    }
}
