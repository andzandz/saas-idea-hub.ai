<?php

namespace Tests\Feature;

use App\Models\GeneratedIdea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllIdeasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_your_ideas_page_displays_your_ideas_newest_first()
    {
        $user = User::factory()->create();
        $generated_idea_1 = GeneratedIdea::factory()
            ->startupName( 'Example Name 1' )
            ->summary( 'Example Summary 1' )
            ->investorPitch( 'Investor Pitch 1' )
            ->model( 'openai/example-model-1' )
            ->public( true )
            ->userId( $user->id )
            ->create();

        $generated_idea_1->priceTiers()->create( [
            'name' => 'Price Tier 1',
            'price_cents' => 1900,
            'description' => 'Tier 1 description',
        ] );

        $generated_idea_1->testimonials()->create( [
            'author' => 'Person 1',
            'comment' => 'Example testimonial 1',
        ] );

        $generated_idea_2 = GeneratedIdea::factory()
            ->startupName( 'Example Name 2' )
            ->summary( 'Example Summary 2' )
            ->investorPitch( 'Investor Pitch 2' )
            ->model( 'openai/example-model-2' )
            ->public( false )
            ->userId( $user->id )
            ->create();

        $generated_idea_2->priceTiers()->create( [
            'name' => 'Price Tier 2',
            'price_cents' => 2900,
            'description' => 'Tier 2 description',
        ] );

        $generated_idea_2->testimonials()->create( [
            'author' => null,
            'comment' => 'Example testimonial 2',
        ] );

        $another_user = User::factory()->create();

        $generated_idea_3 = GeneratedIdea::factory()
            ->startupName( 'Example Name 3' )
            ->summary( 'Example Summary 3' )
            ->investorPitch( 'Investor Pitch 3' )
            ->model( 'openai/example-model-3' )
            ->public( true )
            ->userId( $another_user->id )
            ->create();

        $generated_idea_3->priceTiers()->create( [
            'name' => 'Price Tier 3',
            'price_cents' => 3900,
            'description' => 'Tier 3 description',
        ] );

        $generated_idea_3->testimonials()->create( [
            'author' => null,
            'comment' => 'Example testimonial 3',
        ] );

        $generated_idea_4 = GeneratedIdea::factory()
            ->startupName( 'Example Name 4' )
            ->summary( 'Example Summary 4' )
            ->investorPitch( 'Investor Pitch 4' )
            ->model( 'openai/example-model-4' )
            ->public( false )
            ->userId( $another_user->id )
            ->create();

        $generated_idea_4->priceTiers()->create( [
            'name' => 'Price Tier 4',
            'price_cents' => 4900,
            'description' => 'Tier 4 description',
        ] );

        $generated_idea_4->testimonials()->create( [
            'author' => null,
            'comment' => 'Example testimonial 4',
        ] );

        $response = $this->actingAs( $user )->get( route( 'all-ideas' ) );
        $response->assertSeeInOrder( [
            'Example Name 3',
            'Price Tier 3',
            'Example testimonial 3',

            'Example Name 1',
            'Price Tier 1',
            'Example testimonial 1',
        ] );

        $response->assertDontSee( 'Example Name 2' );
        $response->assertDontSee( 'Price Tier 2' );
        $response->assertDontSee( 'Price Tier 2' );

        $response->assertDontSee( 'Example Name 4' );
        $response->assertDontSee( 'Price Tier 4' );
        $response->assertDontSee( 'Price Tier 4' );
    }
}
