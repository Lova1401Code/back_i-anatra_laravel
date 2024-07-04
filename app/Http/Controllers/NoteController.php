<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Semestre;
use App\Models\AnneeScolaire;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['eleve', 'matiere', 'semestre', 'anneeScolaire'])->get();
        return response()->json($notes);
    }

    public function create()
    {
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        $semestres = Semestre::all();
        $anneesScolaires = AnneeScolaire::all();
        return view('notes.create', compact('eleves', 'matieres', 'semestres', 'anneesScolaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'semestre_id' => 'required|exists:semestres,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'note_interro1' => 'required|numeric|min:0|max:20',
            'note_interro2' => 'required|numeric|min:0|max:20',
            'note_examen' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $note = Note::create($request->all());

        return response()->json(['message' => 'Note créée avec succès', 'note' => $note], 201);
    }

    public function show($id)
    {
        $note = Note::with(['eleve', 'matiere', 'semestre', 'anneeScolaire'])->findOrFail($id);
        return response()->json($note);
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        $semestres = Semestre::all();
        $anneesScolaires = AnneeScolaire::all();
        return view('notes.edit', compact('note', 'eleves', 'matieres', 'semestres', 'anneesScolaires'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'semestre_id' => 'required|exists:semestres,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $note = Note::findOrFail($id);
        $note->update($request->all());

        return response()->json(['message' => 'Note mise à jour avec succès', 'note' => $note]);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Note supprimée avec succès']);
    }
}

