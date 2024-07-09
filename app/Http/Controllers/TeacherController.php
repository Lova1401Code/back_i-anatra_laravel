<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use App\Notifications\SendParentNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'specialite' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
         // Handle file upload
         if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }
        //création de l'utilisateur
        $user = User::create([
            'name' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Type_utilisateur' => 'teacher',
            'profile_photo_path' => $profilePhotoPath ?? null,
        ]);
        //création d'un teacher
         Enseignant::create([
            'user_id' => $user->id,
            'specialite' => $request->specialite,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
        if ($user){
            try {
                $user->notify(new SendParentNotification());
            } catch (Exception $e) {
                return response()->json(['message' => $e]);
            }
        }
        //renvoi la réponse json
        return response()->json(['message' => 'Enseignant inscrit avec succès'], 201);

    }
}
