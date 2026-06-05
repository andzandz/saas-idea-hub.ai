<?php

namespace Tests\Feature;

use App\Models\GeneratedIdea;
use App\Models\User;
use App\Services\OpenRouterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class GenerateIdeaSubmitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_idea_route_calls_openrouter_and_saves_idea_model_when_public_and_no_notes_and_default_temperature(): void
    {
        $user = User::factory()->createOne();

        // $idea, ?string $notes, string $model, ?float $temperature
        $this->mock( OpenRouterService::class )
            ->shouldReceive( 'generateSaaSIdea' )
            ->with(
                Mockery::capture( $captured_idea ),
                Mockery::capture( $captured_notes ),
                Mockery::capture( $captured_model ),
                Mockery::capture( $captured_temperature ),
            )
            ->andReturn( [
                'startup_name' => 'Example Startup Name',
                'summary' => 'Example Summary',
                'investor_pitch' => 'Example Pitch',
                'price_tiers' => [
                    [
                        'name' => 'Example tier',
                        'monthly_price_usd' => 29,
                        'description' => 'Example price description',
                    ],
                ],
                'testimonials' => [
                    [
                        'author' => 'Example author',
                        'comment' => 'Example comment 1',
                    ],
                    [
                        'author' => null,
                        'comment' => 'Example comment 2',
                    ],
                ],
            ] );

        $response = $this->actingAs( $user )
            ->post( route( 'generate-idea.submit' ), [
                'model' => 'openai/example',
                'idea' => 'example idea',
                'use-default-temperature' => 'true',
                'temperature' => '1',
                'public' => 'true',
            ] );

        $response->assertRedirect( route( 'your-ideas' ) );

        $this->assertEquals( 'example idea', $captured_idea );
        $this->assertEquals( null, $captured_notes );
        $this->assertEquals( 'openai/example', $captured_model );
        $this->assertEquals( null, $captured_temperature );

        $this->assertEquals( 1, GeneratedIdea::count() );
        /** @var GeneratedIdea $generated_idea */
        $generated_idea = GeneratedIdea::all()[0];
        $this->assertEquals( $user->id, $generated_idea->user_id );
        $this->assertEquals( 'Example Startup Name', $generated_idea->startup_name );
        $this->assertEquals( 'Example Summary', $generated_idea->summary );
        $this->assertEquals( 'Example Pitch', $generated_idea->investor_pitch );
        $this->assertTrue( $generated_idea->public );

        $this->assertCount( 1, $generated_idea->priceTiers );
        $this->assertEquals( 'Example tier', $generated_idea->priceTiers[0]->name );
        $this->assertEquals( 2900, $generated_idea->priceTiers[0]->price_cents );
        $this->assertEquals( 'Example price description', $generated_idea->priceTiers[0]->description );

        $this->assertCount( 2, $generated_idea->testimonials );
        $testimonials = $generated_idea->testimonials()->orderBy( 'id' )->get();
        $this->assertEquals( 'Example author', $testimonials[0]->author );
        $this->assertEquals( 'Example comment 1', $testimonials[0]->comment );
        $this->assertNull( $testimonials[1]->author );
        $this->assertEquals( 'Example comment 2', $testimonials[1]->comment );
    }

    public function test_generate_idea_route_calls_openrouter_and_saves_idea_model_when_not_public_notes_and_temperature_specified(): void
    {
        $user = User::factory()->createOne();

        // $idea, ?string $notes, string $model, ?float $temperature
        $this->mock( OpenRouterService::class )
            ->shouldReceive( 'generateSaaSIdea' )
            ->with(
                Mockery::capture( $captured_idea ),
                Mockery::capture( $captured_notes ),
                Mockery::capture( $captured_model ),
                Mockery::capture( $captured_temperature ),
            )
            ->andReturn( [
                'startup_name' => 'Example Startup Name',
                'summary' => 'Example Summary',
                'investor_pitch' => 'Example Pitch',
                'price_tiers' => [
                    [
                        'name' => 'Example tier',
                        'monthly_price_usd' => 29,
                        'description' => 'Example price description',
                    ],
                ],
                'testimonials' => [
                    [
                        'author' => 'Example author',
                        'comment' => 'Example comment 1',
                    ],
                    [
                        'author' => null,
                        'comment' => 'Example comment 2',
                    ],
                ],
            ] );

        $response = $this->actingAs( $user )
            ->post( route( 'generate-idea.submit' ), [
                'model' => 'openai/example',
                'idea' => 'example idea',
                'notes' => 'example notes',
                'temperature' => '1.2',
            ] );

        $response->assertRedirect( route( 'your-ideas' ) );

        $this->assertEquals( 'example idea', $captured_idea );
        $this->assertEquals( 'example notes', $captured_notes );
        $this->assertEquals( 'openai/example', $captured_model );
        $this->assertEquals( 1.2, $captured_temperature );

        $this->assertEquals( 1, GeneratedIdea::count() );
        /** @var GeneratedIdea $generated_idea */
        $generated_idea = GeneratedIdea::all()[0];
        $this->assertEquals( $user->id, $generated_idea->user_id );
        $this->assertEquals( 'Example Startup Name', $generated_idea->startup_name );
        $this->assertEquals( 'Example Summary', $generated_idea->summary );
        $this->assertEquals( 'Example Pitch', $generated_idea->investor_pitch );
        $this->assertFalse( $generated_idea->public );

        $this->assertCount( 1, $generated_idea->priceTiers );
        $this->assertEquals( 'Example tier', $generated_idea->priceTiers[0]->name );
        $this->assertEquals( 2900, $generated_idea->priceTiers[0]->price_cents );
        $this->assertEquals( 'Example price description', $generated_idea->priceTiers[0]->description );

        $this->assertCount( 2, $generated_idea->testimonials );
        $testimonials = $generated_idea->testimonials()->orderBy( 'id' )->get();
        $this->assertEquals( 'Example author', $testimonials[0]->author );
        $this->assertEquals( 'Example comment 1', $testimonials[0]->comment );
        $this->assertNull( $testimonials[1]->author );
        $this->assertEquals( 'Example comment 2', $testimonials[1]->comment );
    }
}
