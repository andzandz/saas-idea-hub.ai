<?php

namespace App\Http\Controllers;

use App\Models\GeneratedIdea;
use Inertia\Inertia;

class AllIdeasController extends Controller
{
    public function __invoke()
    {
        return Inertia::render( 'all-ideas', [
            'generated_ideas' => GeneratedIdea::where( 'public', true )
                ->with( 'user' )
                ->orderByDesc( 'id' )
                ->get(),
        ] );
    }
}
