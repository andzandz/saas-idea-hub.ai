<?php

namespace Tests\Feature;

use App\Models\GeneratedIdea;
use App\Models\User;
use Tests\TestCase;

class ViewIdeaControllerTest extends TestCase
{
    private User $user;

    private GeneratedIdea $users_public_idea;

    private GeneratedIdea $users_non_public_idea;

    private GeneratedIdea $another_users_public_idea;

    private GeneratedIdea $another_users_non_public_idea;

    private function seedUsersAndIdeas()
    {
        $this->user = User::factory()->create();
        $another_user = User::factory()->create();

        $this->users_public_idea = GeneratedIdea::factory()
            ->startupName( 'Example Name 1' )
            ->summary( 'Example Summary 1' )
            ->investorPitch( 'Investor Pitch 1' )
            ->model( 'openai/example-model-1' )
            ->public( true )
            ->userId( $this->user->id )
            ->create();

        $this->users_public_idea->priceTiers()->create( [
            'name' => 'Price Tier 1',
            'price_cents' => 1900,
            'description' => 'Tier 1 description',
        ] );

        $this->users_public_idea->testimonials()->create( [
            'author' => 'Person 1',
            'comment' => 'Example testimonial 1',
        ] );

        $this->users_non_public_idea = GeneratedIdea::factory()
            ->startupName( 'Example Name 2' )
            ->summary( 'Example Summary 2' )
            ->investorPitch( 'Investor Pitch 2' )
            ->model( 'openai/example-model-1' )
            ->public( false )
            ->userId( $this->user->id )
            ->create();

        $this->users_non_public_idea->priceTiers()->create( [
            'name' => 'Price Tier 2',
            'price_cents' => 1900,
            'description' => 'Tier 2 description',
        ] );

        $this->users_non_public_idea->testimonials()->create( [
            'author' => 'Person 2',
            'comment' => 'Example testimonial 2',
        ] );

        $this->another_users_public_idea = GeneratedIdea::factory()
            ->startupName( 'Example Name 3' )
            ->summary( 'Example Summary 3' )
            ->investorPitch( 'Investor Pitch 3' )
            ->model( 'openai/example-model-1' )
            ->public( true )
            ->userId( $another_user->id )
            ->create();

        $this->another_users_public_idea->priceTiers()->create( [
            'name' => 'Price Tier 3',
            'price_cents' => 1900,
            'description' => 'Tier 3 description',
        ] );

        $this->another_users_public_idea->testimonials()->create( [
            'author' => 'Person 3',
            'comment' => 'Example testimonial 3',
        ] );

        $this->another_users_non_public_idea = GeneratedIdea::factory()
            ->startupName( 'Example Name 4' )
            ->summary( 'Example Summary 4' )
            ->investorPitch( 'Investor Pitch 4' )
            ->model( 'openai/example-model-1' )
            ->public( false )
            ->userId( $another_user->id )
            ->create();

        $this->another_users_non_public_idea->priceTiers()->create( [
            'name' => 'Price Tier 4',
            'price_cents' => 1900,
            'description' => 'Tier 4 description',
        ] );

        $this->another_users_non_public_idea->testimonials()->create( [
            'author' => 'Person 4',
            'comment' => 'Example testimonial 4',
        ] );
    }

    public function test_idea_page_shows_users_public_idea(): void
    {
        $this->seedUsersAndIdeas();

        $response = $this->actingAs( $this->user )->get(
            route( 'view-idea', [$this->users_public_idea->id, 'foobar'] )
        );

        $response->assertStatus( 200 );

        $response->assertSeeInOrder( [
            'Example Name 1',
            'Price Tier 1',
            'Example testimonial 1',
        ] );
    }

    public function test_idea_page_shows_users_non_public_idea(): void
    {
        $this->seedUsersAndIdeas();

        $response = $this->actingAs( $this->user )->get(
            route( 'view-idea', [$this->users_non_public_idea->id, 'foobar'] )
        );

        $response->assertStatus( 200 );

        $response->assertSeeInOrder( [
            'Example Name 2',
            'Price Tier 2',
            'Example testimonial 2',
        ] );
    }

    public function test_idea_page_shows_another_users_public_idea(): void
    {
        $this->seedUsersAndIdeas();

        $response = $this->actingAs( $this->user )->get(
            route( 'view-idea', [$this->another_users_public_idea->id, 'foobar'] )
        );

        $response->assertStatus( 200 );

        $response->assertSeeInOrder( [
            'Example Name 3',
            'Price Tier 3',
            'Example testimonial 3',
        ] );
    }

    public function test_idea_page_does_not_show_another_users_non_public_idea(): void
    {
        $this->seedUsersAndIdeas();

        $response = $this->actingAs( $this->user )->get(
            route( 'view-idea', [$this->another_users_non_public_idea->id, 'foobar'] )
        );

        $response->assertStatus( 404 );

        $response->assertDontSee( 'Example Name 4' );
    }
}
