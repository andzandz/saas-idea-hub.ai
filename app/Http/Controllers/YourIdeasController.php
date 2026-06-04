<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class YourIdeasController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return Inertia::render( 'your-ideas', [
            'generated_ideas' => $user->generatedIdeas()
                ->with( 'user' )
                ->orderByDesc( 'id' )
                ->get(),
        ] );
    }
}
