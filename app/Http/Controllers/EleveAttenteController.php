<?php

namespace App\Http\Controllers;

use App\Models\AnneeScolaire;
use App\Models\Eleve;
use App\Models\EleveAttente;
use App\Models\Inscription;
use App\Models\Parente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EleveAttenteController extends Controller
{
    //récupération de la liste des eleves en attente
    public function index()
    {
        $eleves = EleveAttente::all();
        return response()->json($eleves);
    }
    //inscription d'un eleve
    public function store(Request $request){
        $request->validate([
            'matricule' => 'required|string|unique:eleve_attentes',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|string|email|unique:eleve_attentes',
            'date_naissance' => 'required|date',
            'photo_profil' => 'nullable|image|max:2048',
            'pere_nom' => 'nullable|string',
            'pere_prenom' => 'nullable|string',
            'profession_pere' => 'nullable|string',
            'pere_contact' => 'nullable|string',
            'mere_nom' => 'nullable|string',
            'mere_prenom' => 'nullable|string',
            'profession_mere' => 'nullable|string',
            'mere_contact' => 'nullable|string',
            'tuteur_nom' => 'nullable|string',
            'tuteur_prenom' => 'nullable|string',
            'tuteur_contact' => 'nullable|string',
            'emailParent' => 'required|string|email|unique:eleve_attentes',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo_profil')) {
            $path = $request->file('photo_profil')->store('photos_profil');
            $data['photo_profil'] = $path;
        }

        EleveAttente::create($data);

        return response()->json(['message' => 'Inscription réussie. Votre demande est en attente de validation.'], 201);
     }
     //récupération des détails d'un eleve spécifique
     public function show($id)
    {
        $eleve = EleveAttente::find($id);

        if (!$eleve) {
            return response()->json(['message' => 'Élève non trouvé'], 404);
        }

        return response()->json($eleve);
    }
    //validation d'un eleves
    public function validateEleve($id){
        $eleveAttente = EleveAttente::find($id);
        if (!$eleveAttente) {
            return response()->json(['message' => 'Élève non trouvé'], 404);
        }
        // Générer des mots de passe aléatoires
        $elevePassword = str::random(8);
        $parentPassword = Str::random(8);
            // Créer un utilisateur pour l'élève
            $eleveUser = User::create([
                'name' => $eleveAttente->nom . ' ' . $eleveAttente->prenom,
                'email' => $eleveAttente->email,
                'password' => Hash::make($elevePassword), // Vous pouvez générer un mot de passe aléatoire ou utiliser un autre moyen sécurisé
                'role' => 'eleve',
            ]);
            // Créer un utilisateur pour le parent
            $parentUser = User::create([
                'name' => $eleveAttente->pere_nom . ' ' . $eleveAttente->pere_prenom,
                'email' => $eleveAttente->emailParent, // Utiliser l'email du parent si disponible
                'password' => Hash::make($parentPassword), // Idem pour le mot de passe
                'role' => 'parent',
            ]);
            // Créer un enregistrement pour l'élève
            $eleve = Eleve::create([
                'user_id' => $eleveUser->id,
                'classe' => "4eme",
                'adresse' => "Ambohimanga",
            ]);
            // Créer un enregistrement pour le parent
            Parente::create([
                'user_id' => $parentUser->id,
                'telephone' => $eleveAttente->pere_contact,
            ]);
            // Créer une inscription pour l'élève
            $anneeScolaire = AnneeScolaire::current(); // Méthode à implémenter pour obtenir l'année scolaire en cours
            Inscription::create([
                'eleve_id' => $eleve->id,
                'annee_scolaire_id' => $anneeScolaire->id,
                'montant' => "4400",
                'date_inscription' => now(),
            ]);
        return response()->json([
            'message' => 'Élève validé et inscrit avec succès.',
            'mot de passe eleve' => $elevePassword,
            'mot de passe parent' => $parentPassword,
        ]);

    }
    //liste des eleves qui sont inscrit
    public function listeEleveIncrit(){
        $eleveInscrit = Inscription::with('eleve', 'anneeScolaire')->get();
        return response()->json([
            'eleveInscrit' => $eleveInscrit
        ]);
    }
    //liste des eleves validé
    public function listeEleveValidee(){
        $eleveValidee = Eleve::with('inscriptions', 'classes', 'user')->get();
        return response()->json([
            'eleveValidee' => $eleveValidee
        ]);
    }
}
