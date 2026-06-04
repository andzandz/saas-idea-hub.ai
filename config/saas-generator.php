<?php

return [
    'json_schema' => [
        'name' => 'saas',
        'strict' => true,
        'schema' => [
            'type' => 'object',
            'additionalProperties' => false,
            'required' => ['startup_name', 'summary', 'investor_pitch', 'pricing_tiers', 'testimonials'],
            'properties' => [
                'startup_name' => [
                    'type' => 'string',
                ],
                'summary' => [
                    'type' => 'string',
                    'maxLength' => 250,
                ],
                'investor_pitch' => [
                    'type' => 'string',
                    'maxLength' => 500,
                ],
                'pricing_tiers' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'additionalProperties' => false,
                        'required' => ['name', 'monthly_price_usd', 'description'],
                        'properties' => [
                            'name' => [
                                'type' => 'string',
                            ],
                            'monthly_price_usd' => [
                                'type' => 'number',
                                'description' => 'The monthly price in US Dollars, for example 49.99 is $49.99/month.',
                            ],
                            'description' => [
                                'type' => ['null', 'string'],
                            ],
                        ],
                    ],
                    'minItems' => 1,
                ],
                'testimonials' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'additionalProperties' => false,
                        'required' => ['author', 'comment'],
                        'properties' => [
                            'author' => [
                                'type' => ['null', 'string'],
                                'description' => 'The individual or company/organisation who left the testimonial, or null if anonymous',
                            ],
                            'comment' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'minItems' => 1,
                ],
            ],
        ],
    ],
];
