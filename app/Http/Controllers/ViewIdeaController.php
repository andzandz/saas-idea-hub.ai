<?php

namespace App\Http\Controllers;

use App\Models\GeneratedIdea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ViewIdeaController extends Controller
{
    public function __invoke( Request $request, GeneratedIdea $generated_idea )
    {
        $user = Auth::user();

        if ( $generated_idea->public === false && $generated_idea->user_id !== $user->id ) {
            abort( 404 );
        }

        $generated_idea->load( 'user' );

        return Inertia::render( 'view-idea', [
            'generated_idea' => $generated_idea,
        ] );
    }
}
