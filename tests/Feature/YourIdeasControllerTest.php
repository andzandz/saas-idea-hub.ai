<?php

namespace Tests\Feature;

use App\Models\GeneratedIdea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YourIdeasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get( route( 'your-ideas' ) );
        $response->assertRedirect( route( 'login' ) );
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs( $user );

        $response = $this->get( route( 'your-ideas' ) );
        $response->assertOk();
    }

    public function test_your_ideas_page_displays_your_ideas_newest_first()
    {
        $user = User::factory()->create();
        $generated_idea_1 = GeneratedIdea::factory()
            ->startupName( 'Example Name 1' )
            ->summary( 'Example Summary 1' )
            ->investorPitch( 'Investor Pitch 1' )
            ->model( 'openai/example-model-1' )
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

        $user = $user->fresh();

        $response = $this->actingAs( $user )->get( route( 'your-ideas' ) );
        $response->assertSeeInOrder( [
            'Example Name 2',
            'Price Tier 2',
            '29.00',
            'Tier 2 description',
            'Example testimonial 2',
            'Anonymous',

            'Example Name 1',
            'Price Tier 1',
            '19.00',
            'Tier 1 description',
            'Example testimonial 1',
            'Person 1',
        ] );
    }
}
