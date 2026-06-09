<?php

namespace Tests\Unit\Clients;

use App\Agents\SaasGeneratorAgent;
use App\Clients\OpenRouterClient;
use Laravel\Ai\Prompts\AgentPrompt;
use Tests\TestCase;

class OpenRouterClientTest extends TestCase
{
    public function test_open_router_client_sends_the_expected_prompt_and_parameters_and_returns_correctly_without_temperature(): void
    {
        SaasGeneratorAgent::fake( [
            [ 'output foo' => 'output bar' ],
        ] );

        $response = ( new OpenRouterClient )->generateArrayWithSchema(
            prompt: 'Example prompt',
            model: 'openai/gpt-5.4-mini',
        );

        $this->assertEquals( [ 'output foo' => 'output bar' ], $response );

        SaasGeneratorAgent::assertPrompted( function ( AgentPrompt $prompt ) {
            $this->assertSame( 'Example prompt', $prompt->prompt );
            $this->assertSame( 'openai/gpt-5.4-mini', $prompt->model );
            $this->assertNull( $prompt->agent->temperature() );

            return true;
        } );
    }

    public function test_open_router_client_sends_the_expected_prompt_and_parameters_and_returns_correctly_when_temperature_specified(): void
    {
        SaasGeneratorAgent::fake( [
            [ 'output foo' => 'output bar' ],
        ] );

        $response = ( new OpenRouterClient )->generateArrayWithSchema(
            prompt: 'Example prompt',
            model: 'openai/gpt-5.4-mini',
            temperature: 1.3,
        );

        $this->assertEquals( [ 'output foo' => 'output bar' ], $response );

        SaasGeneratorAgent::assertPrompted( function ( AgentPrompt $prompt ) {
            $this->assertSame( 'Example prompt', $prompt->prompt );
            $this->assertSame( 'openai/gpt-5.4-mini', $prompt->model );
            $this->assertSame( 1.3, $prompt->agent->temperature() );

            return true;
        } );
    }
}
