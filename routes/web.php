<?php

use App\Http\Controllers\AllIdeasController;
use App\Http\Controllers\GenerateIdeaController;
use App\Http\Controllers\GenerateIdeaSubmitController;
use App\Http\Controllers\ViewIdeaController;
use App\Http\Controllers\YourIdeasController;
use Illuminate\Support\Facades\Route;

Route::inertia( '/', 'welcome' )->name( 'home' );

Route::middleware( ['auth', 'verified'] )->group( function () {
    Route::get( 'all-ideas', AllIdeasController::class )->name( 'all-ideas' );
    Route::get( 'your-ideas', YourIdeasController::class )->name( 'your-ideas' );
    Route::get( 'generate-idea', GenerateIdeaController::class )->name( 'generate-idea' );
    Route::post( 'generate-idea', GenerateIdeaSubmitController::class )->name( 'generate-idea.submit' );
    Route::get( 'idea/{generated_idea}/{slug}', ViewIdeaController::class )->name( 'view-idea' );
} );

require __DIR__ . '/settings.php';
