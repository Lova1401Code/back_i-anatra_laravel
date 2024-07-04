<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(){
        {
            $user = Auth::user();
        $profile = $user;

        if ($user->type_utilisateur === 'teacher') {
            $profile = $user->teacher->with('user')->first();
        } elseif ($user->type_utilisateur === 'admin') {
            $profile = $user->admin->with('user')->first();
        }

        return response()->json($profile);

        }
    }
}
