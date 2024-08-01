<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    //get all salle
    public function index(){
        $salle = Salle::all();
        return response()->json($salle);
    }
    public function store(Request $request){
        $request->validate([
            'nom' => 'required|string|max:255',
            'nombreMax' => 'required|max:255',
            'nombreBanc' => 'required|max:255',

        ]);
        $salle = Salle::create($request->all());

        return response()->json(['message' => 'Salle créée avec succès', 'salle' => $salle], 201);
    }
}
