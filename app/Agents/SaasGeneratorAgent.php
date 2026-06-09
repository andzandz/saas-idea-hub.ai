<?php

namespace App\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class SaasGeneratorAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function __construct( private ?float $temperature = null ) {}

    public function instructions(): Stringable|string
    {
        return 'You are a SaaS (Software as a Service) Generator. Generate a startup name, summary (max 250 characters),'
            . ' price tiers, fake testimonials and investor pitch (max 500 characters) for the given idea.';
    }

    public function temperature(): ?float
    {
        return $this->temperature;
    }

    public function maxTokens(): int
    {
        return 3000;
    }

    public function schema( JsonSchema $schema ): array
    {
        return [
            'startup_name' => $schema->string()->required(),
            'summary' => $schema->string()->max( 250 )->required(),
            'investor_pitch' => $schema->string()->max( 500 )->required(),
            'price_tiers' => $schema->array()->items(
                $schema->object( [
                    'name' => $schema->string()->required(),
                    'monthly_price_usd' => $schema->number()
                        ->description( 'The monthly price in US Dollars, for example 49.99 is $49.99/month.' )
                        ->required(),
                    'description' => $schema->string()->nullable()->required(),
                ] )
            )->min( 1 )->required(),
            'testimonials' => $schema->array()->items(
                $schema->object( [
                    'author' => $schema->string()->nullable()
                        ->description( 'The individual or company/organisation who left the testimonial, or null if anonymous' )
                        ->required(),
                    'comment' => $schema->string()->required(),
                ] )
            )->min( 1 )->required(),
        ];
    }
}
