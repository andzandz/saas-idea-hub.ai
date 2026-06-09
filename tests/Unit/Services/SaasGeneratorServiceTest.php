<?php

namespace Tests\Unit\Services;

use App\Agents\SaasGeneratorAgent;
use App\Services\SaasGeneratorService;
use Laravel\Ai\Prompts\AgentPrompt;
use Tests\TestCase;

class SaasGeneratorServiceTest extends TestCase
{
    public function test_generates_saas_idea_without_notes_or_temperature(): void
    {
        SaasGeneratorAgent::fake( [
            [ 'example' => 'output' ],
        ] );

        $result = ( new SaasGeneratorService )->generateSaaSIdea( 'Netflix for professionals', null, 'openai/example-model' );

        $this->assertEquals( [ 'example' => 'output' ], $result );

        SaasGeneratorAgent::assertPrompted( function ( AgentPrompt $prompt ) {
            $this->assertSame( 'Idea: Netflix for professionals', $prompt->prompt );
            $this->assertSame( 'openai/example-model', $prompt->model );
            $this->assertNull( $prompt->agent->temperature() );

            return true;
        } );
    }

    public function test_generates_saas_idea_with_notes_and_temperature(): void
    {
        SaasGeneratorAgent::fake( [
            [ 'example' => 'output' ],
        ] );

        $result = ( new SaasGeneratorService )->generateSaaSIdea( 'Netflix for professionals', 'example notes', 'openai/example-model', 1.2 );

        $this->assertEquals( [ 'example' => 'output' ], $result );

        SaasGeneratorAgent::assertPrompted( function ( AgentPrompt $prompt ) {
            $this->assertSame(
                'Idea: Netflix for professionals' . PHP_EOL . 'Notes: example notes',
                $prompt->prompt
            );
            $this->assertSame( 'openai/example-model', $prompt->model );
            $this->assertSame( 1.2, $prompt->agent->temperature() );

            return true;
        } );
    }
}
