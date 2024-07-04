<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use Illuminate\Http\Request;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $annees = AnneeScolaire::all();
        return response()->json($annees);
    }
    public function store(Request $request){
        $request->validate([
            'annee' => 'required|string|unique:annees_scolaires',
            'debut' => 'required|date',
            'fin' => 'required|date'
        ]);
        $annee = AnneeScolaire::create($request->all());
        return response()->json($annee, 201);
    }
    public function update(Request $request, $id)
    {
        $annee = AnneeScolaire::find($id);

        if (!$annee) {
            return response()->json(['message' => 'Année scolaire non trouvée'], 404);
        }

        $request->validate([
            'annee' => 'string|unique:annee_scolaires,annee,' . $annee->id,
            'debut' => 'date',
            'fin' => 'date',
        ]);

        $annee->update($request->all());
        return response()->json($annee);
    }
    public function destroy($id)
    {
        $annee = AnneeScolaire::find($id);

        if (!$annee) {
            return response()->json(['message' => 'Année scolaire non trouvée'], 404);
        }

        $annee->delete();
        return response()->json(['message' => 'Année scolaire supprimée avec succès']);
    }
    public function setActive($id)
    {
        // Désactiver toutes les années scolaires
        AnneeScolaire::where('statut', 'active')->update(['statut' => 'inactive']);

        // Activer l'année scolaire spécifiée
        $annee = AnneeScolaire::find($id);

        if (!$annee) {
            return response()->json(['message' => 'Année scolaire non trouvée'], 404);
        }

        $annee->update(['statut' => 'active']);
        return response()->json(['message' => 'Année scolaire activée avec succès']);
    }
}
