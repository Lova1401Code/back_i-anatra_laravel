<?php

namespace App\Http\Controllers;

use App\Models\Parente;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    //notification vers parent
    public function sendNotifParent(){
        $parent = new Parente();

    }
}
