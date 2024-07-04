<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Note;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    //bulletin pour une semestre
    public function show($eleveId, $semestreId){
        $eleve = Eleve::findOrFail($eleveId);
        $classe = $eleve->classe;

        $notes = Note::where('eleve_id', $eleveId)
                     ->where('semestre_id', $semestreId)
                     ->with('matiere')
                     ->get();
                     //calcul de la moyenne
                     $totalNotes = 0;
                     $totalCoefficients = 0;
                     foreach ($notes as $note) {
                        $moyenneNote = ((($note->note_interro1 + $note->note_interro2) /2) + $note->note_examen) / 2;
                        $totalNotes += $moyenneNote * $note->matiere->coefficient;
                        $totalCoefficients += $note->matiere->coefficient;
                        }
                        $moyenneEleve = $totalNotes / $totalCoefficients;
                   //calcul la moyenne de la classe
                    $notesClasse = Note::where('semestre_id', $semestreId)
                                      ->whereHas('eleve', function ($query) use ($classe) {
                                            $query->where('classe', $classe);
                                      })
                                      ->get();
                                      $totalNotesClasse = 0;
                                      $totalEleves = $notesClasse->groupBy('eleve_id')->count();

                                      foreach ($notesClasse->groupBy('eleve_id') as $notesEleve) {
                                          $totalNotesEleve = 0;
                                          $totalCoefficientsEleve = 0;

                                          foreach ($notesEleve as $note) {
                                              $moyenneNote = ($note->note_interro1 + $note->note_interro2 + $note->note_examen) / 3;
                                              $totalNotesEleve += $moyenneNote * $note->matiere->coefficient;
                                              $totalCoefficientsEleve += $note->matiere->coefficient;
                                          }

                                          $moyenneEleveClasse = $totalNotesEleve / $totalCoefficientsEleve;
                                          $totalNotesClasse += $moyenneEleveClasse;
                                      }
                                      $moyenneClasse = $totalNotesClasse / $totalEleves;

                                      // Calculer le rang de l'élève
                                    $eleveNotes = $notesClasse->groupBy('eleve_id')->map(function ($notesEleve) {
                                        $totalNotesEleve = 0;
                                        $totalCoefficientsEleve = 0;

                                        foreach ($notesEleve as $note) {
                                            $moyenneNote = ($note->note_interro1 + $note->note_interro2 + $note->note_examen) / 3;
                                            $totalNotesEleve += $moyenneNote * $note->matiere->coefficient;
                                            $totalCoefficientsEleve += $note->matiere->coefficient;
                                        }

                                        return $totalNotesEleve / $totalCoefficientsEleve;
                                    });
                                    $sortedNotes = $eleveNotes->sortDesc();
                                    $rang = $sortedNotes->keys()->search($eleveId) + 1;
                    return response()->json($rang);
                    }
    //bulletin pour les fins de l'années scolaire
    public function showAnnual($eleveId){
        $eleve = Eleve::findOrFail($eleveId);
        $classe = $eleve->classe;

        // Récupérer les notes de l'élève pour tous les semestres de l'année scolaire en cours
        $notes = Note::where('eleve_id', $eleveId)
                     ->with('matiere')
                     ->get();
        $totalNotes = 0;
        $totalCoefficients = 0;
        $moyennesMatieres = [];
        foreach ($notes as $note) {
            $moyenneNote = ($note->note_interro1 + $note->note_interro2 + $note->note_examen) / 3;
            $totalNotes += $moyenneNote * $note->matiere->coefficient;
            $totalCoefficients += $note->matiere->coefficient;

            if (!isset($moyennesMatieres[$note->matiere_id])) {
                $moyennesMatieres[$note->matiere_id] = [
                    'total' => 0,
                    'coeff' => $note->matiere->coefficient,
                    'count' => 0,
                ];
            }
            $moyennesMatieres[$note->matiere_id]['total'] += $moyenneNote;
            $moyennesMatieres[$note->matiere_id]['count'] += 1;
        }
        $moyenneGenerale = $totalNotes / $totalCoefficients;
        // Calculer la moyenne de la classe
        $notesClasse = Note::whereHas('eleve', function ($query) use ($classe) {
                            $query->where('classe', $classe);
                            })
                        ->get();
        $totalNotesClasse = 0;
        $totalEleves = $notesClasse->groupBy('eleve_id')->count();
        foreach ($notesClasse->groupBy('eleve_id') as $notesEleve) {
            $totalNotesEleve = 0;
            $totalCoefficientsEleve = 0;

            foreach ($notesEleve as $note) {
                $moyenneNote = ($note->note_interro1 + $note->note_interro2 + $note->note_examen) / 3;
                $totalNotesEleve += $moyenneNote * $note->matiere->coefficient;
                $totalCoefficientsEleve += $note->matiere->coefficient;
            }

            $moyenneEleveClasse = $totalNotesEleve / $totalCoefficientsEleve;
            $totalNotesClasse += $moyenneEleveClasse;
        }
        $moyenneClasse = $totalNotesClasse / $totalEleves;

        // Calculer le rang de l'élève
        $eleveNotes = $notesClasse->groupBy('eleve_id')->map(function ($notesEleve) {
            $totalNotesEleve = 0;
            $totalCoefficientsEleve = 0;

            foreach ($notesEleve as $note) {
                $moyenneNote = ($note->note_interro1 + $note->note_interro2 + $note->note_examen) / 3;
                $totalNotesEleve += $moyenneNote * $note->matiere->coefficient;
                $totalCoefficientsEleve += $note->matiere->coefficient;
            }

            return $totalNotesEleve / $totalCoefficientsEleve;
        });
        $sortedNotes = $eleveNotes->sortDesc();
        $rang = $sortedNotes->keys()->search($eleveId) + 1;
        return response()->json($rang);
    }

}
