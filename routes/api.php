<?php

use App\Http\Controllers\AnneeScolaireController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveAttenteController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/teacher/register', [TeacherController::class, 'register']);

//user
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'show']);

//eleves en Attente
Route::post('/inscription', [EleveAttenteController::class, 'store']);
Route::get('/eleves-attentes', [EleveAttenteController::class, 'index']);
Route::get('/eleves-attentes/{id}', [EleveAttenteController::class, 'show']);
Route::post('/eleves-attentes/{id}/validate', [EleveAttenteController::class, 'validateEleve']);

Route::get('/annees-scolaires', [AnneeScolaireController::class, 'index']);
Route::post('/annees-scolaires', [AnneeScolaireController::class, 'store']);
Route::put('/annees-scolaires/{id}', [AnneeScolaireController::class, 'update']);
Route::delete('/annees-scolaires/{id}', [AnneeScolaireController::class, 'destroy']);
Route::post('/annees-scolaires/{id}/set-active', [AnneeScolaireController::class, 'setActive']);

//classe
Route::post('/classes', [ClasseController::class, 'create']);
Route::post('/classes/{classe}/eleves', [ClasseController::class, 'addEleveToClasse']);
Route::get('/classes', [ClasseController::class, 'index']);
Route::get('/classes/{classe}', [ClasseController::class, 'show']);

//Matiere
Route::get('/matiere', [MatiereController::class, 'index']);
Route::post('/matiere', [MatiereController::class, 'store']);

//semestre
Route::get('/semestre', [SemestreController::class, 'index']);
Route::post('/semestre', [SemestreController::class, 'store']);

//note
Route::get('/note', [NoteController::class, 'index']);
Route::post('/note', [NoteController::class, 'store']);

//Bulletin
Route::get('/bulletin/{eleveId}/{semestreId}', [BulletinController::class, 'show']);
Route::get('/bulletin/{eleveId}', [BulletinController::class, 'showAnnual']);

//Badge
Route::post('/badges/generate/{eleveId}', [BadgeController::class, 'generateBadge']);
Route::get('/badges/{id}', [BadgeController::class, 'show'])->name('badges.show');

//présence
Route::post('/mark-presence/{eleve_id}', [PresenceController::class, 'createBadge']);
Route::get('/classes/{classe_id}/eleves', [ClasseController::class, 'getEleves']);
Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
Route::post('/presences/record', [PresenceController::class, 'recordPresence'])->name('presences.record');


