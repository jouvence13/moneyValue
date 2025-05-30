<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PairController;

// Groupe pour les routes d'authentification (login, register, etc.)
Route::prefix('auth')->group(function () {
    // Route pour se connecter
    Route::post('/login', [AuthController::class, 'login']);
    // Route pour s'enregistrer
    Route::post('/register', [AuthController::class, 'register']);
    // Route pour se déconnecter
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route pour rafraîchir le token JWT
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route pour récupérer le profil utilisateur connecté
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

// Vérifie si l'API est active
Route::get('/status', function () {
    return response()->json(['message' => 'API is working']);
});

// Liste de tous les pairs avec leurs devises associées
Route::get('/pairs', [PairController::class, 'index']);

// Détails d'une paire spécifique
Route::get('/pairs/{pair}', [PairController::class, 'show']);

// Effectue une conversion d'une devise vers une autre
Route::post('/convert', [PairController::class, 'convert']);


// Liste de toutes les devises disponibles
Route::get('/currencies', [PairController::class, 'currencies']);

// Groupe de routes protégées par JWT (authentification requise)
Route::middleware('auth:api')->group(function () {
    // Crée une nouvelle paire
    Route::post('/pairs', [PairController::class, 'store']);
    // Met à jour une paire existante
    Route::put('/pairs/{pair}', [PairController::class, 'update']);
    // Supprime une paire existante
    Route::delete('/pairs/{pair}', [PairController::class, 'destroy']);
});
