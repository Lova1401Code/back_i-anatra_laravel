<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Presence;
use App\Models\User;
use App\Notifications\ElevePresenceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
class PresenceController extends Controller
{
    public function markPresence(Request $request, $eleve_id)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $eleve = Eleve::findOrFail($eleve_id);
        $date = $request->date;

        // Vérifiez si la présence est déjà enregistrée pour aujourd'hui
        $existingPresence = Presence::where('eleve_id', $eleve->id)
                                     ->whereDate('date', $date)
                                     ->first();

        if ($existingPresence) {
            return response()->json(['message' => 'La présence a déjà été enregistrée pour aujourd\'hui.'], 400);
        }

        // Enregistrer la présence
        Presence::create([
            'eleve_id' => $eleve->id,
            'enseignant_id' => 1,
            'date' => $date,
            'present' => 1
        ]);

        // Trouver le parent de l'élève
        // $parent = User::find($eleve->parent_id);
        $parent = "lova.ramiharisoa@gmail.com";

        // Envoyer la notification par e-mail
        Notification::send($parent, new ElevePresenceNotification($eleve, $date));

        return response()->json(['message' => 'Présence enregistrée avec succès et notification envoyée.']);
    }
    // Afficher la liste des présences
    public function index()
    {
        $presences = Presence::with('eleve')->get();
        return response()->json($presences);
    }
    // Enregistrer la présence d'un élève
    public function recordPresence(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'date' => 'required|date',
            'type' => 'required|string', // Validation du champ type
        ]);

        $presence = Presence::create([
            'eleve_id' => $request->eleve_id,
            'date' => $request->date,
            'type' => $request->type,
        ]);
        // Envoyer une notification au parent
        $eleve = Eleve::find($request->eleve_id);
        $parentUser = User::where('id', $eleve->parent_id)->first();

        if ($parentUser) {
            Mail::to($parentUser->email)->send(new \App\Mail\PresenceNotification($eleve, $request->type));
        }

        return response()->json([
            'message' => 'Présence enregistrée avec succès',
            'presence' => $presence,
        ]);
    }
}
