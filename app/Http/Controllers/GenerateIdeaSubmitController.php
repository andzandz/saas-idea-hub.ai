<?php

namespace App\Http\Controllers;

use App\Models\GeneratedIdea;
use App\Services\SaasGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Throwable;

class GenerateIdeaSubmitController extends Controller
{
    public function __invoke( Request $request )
    {
        try {
            $idea = app( SaasGeneratorService::class )
                ->generateSaaSIdea(
                    idea: $request->input( 'idea' ),
                    notes: $request->input( 'notes' ),
                    model: $request->input( 'model' ),
                    temperature: $request->input( 'use-default-temperature' ) !== 'true'
                        ? $request->input( 'temperature' )
                        : null,
                );
            $this->storeIdea( $idea, $request->input( 'model' ), $request->input( 'public' ) === 'true' );
        } catch ( Throwable $throwable ) {
            report( $throwable );

            Inertia::flash( 'idea-generation-error', true );

            return redirect()->route( 'generate-idea' );
        }

        return redirect()->route( 'your-ideas' );
    }

    private function storeIdea( array $idea, string $model, bool $public ): void
    {
        $user = Auth::user();

        /** @var GeneratedIdea $generated_idea */
        $generated_idea = $user->generatedIdeas()->create( [
            'model' => $model,
            'startup_name' => $idea['startup_name'],
            'summary' => $idea['summary'],
            'investor_pitch' => $idea['investor_pitch'],
            'public' => $public,
        ] );

        $generated_idea->priceTiers()->createMany(
            collect( $idea['price_tiers'] )
                ->map( function ( $price_tier ) {
                    $price_tier['price_cents'] = $price_tier['monthly_price_usd'] * 100;
                    unset( $price_tier['monthly_price_usd'] );

                    return $price_tier;
                } )
        );

        $generated_idea->testimonials()->createMany(
            $idea['testimonials']
        );
    }
}
