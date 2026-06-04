<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class GenerateIdeaController extends Controller
{
    public function __invoke()
    {
        return Inertia::render( 'generate-idea' );
    }
}
