<?php

namespace App\Filament\Store\Pages;

use App\Models\Product;
use App\Models\WorkCategory;
use Filament\Pages\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Http;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use OpenAI;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class BudgetEstimate extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.store.pages.budget-estimate';

    protected static ?int $navigationSort = 3;

    public $quotation = [];
    public $chat = '';
    public $budget = 2_000_000;
    public $description = 'two-story residential building';

    public $messages = [];
    public $additional = [];

    public function resetMessages()
    {
        $items = json_encode(WorkCategory::with(['work_items'])->get(['id', 'name'])->map(fn($wc) => [
            'name' => $wc->name,
            'items' => $wc->work_items->map(fn($wi) => [
                'name' => $wi->name,
                'unit' => $wi->unit,
                'unit_cost' => $wi->unit_cost
            ])->toArray()
        ])->toArray());
        $this->messages = [
            [
                'type' => 'text',
                'text' => "
                  I have a construction budget of {$this->budget} pesos. 
                  The project involves an embankment job with the following unit costs:
                  materials:400, labor:350, excavation:500, backfill:500;
                  Give me a practical floor area that prefers almost equal width and length.
                  Based on this, calculate the total area that is below my budget. 
                "
            ],
            [
                'type' => 'text',
                'text' => "
                  The project involves an embankment job with the following unit costs:
                    {$items}
                "
            ],
            [
                'type' => 'text',
                'text' => "
                  Give me a practical floor area that prefers almost equal width and length.
                  Based on this, calculate the total area that is below my budget. 
                "
            ],
        ];
    }

    public function mount()
    {
        $this->resetMessages();
    }

    public function sendChat()
    {
        $this->additional[] = [
            'type' => 'text',
            'text' => $this->chat
        ];
        $this->chat = '';
        $this->estimate();
    }

    public function estimate()
    {
        set_time_limit(120);
        $this->quotation = [];
        $client = OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->make();

        $this->resetMessages();

        $response = $client->chat()->create([
            'model' => 'o4-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ...$this->messages,
                        ...$this->additional
                    ]
                ],
            ],
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'quotation_response',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'length' => [
                                'type' => 'integer'
                            ],
                            'width' => [
                                'type' => 'integer'
                            ],
                            'total_area' => [
                                'type' => 'integer'
                            ],
                            'itemized_costs' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string'
                                        ],
                                        'line_items' => [
                                            'type' => 'array',
                                            'items' => [
                                                'type' => 'object',
                                                'properties' => [
                                                    'description' => [
                                                        'type' => 'string'
                                                    ],
                                                    'unit_cost' => [
                                                        'type' => 'number'
                                                    ],
                                                    'total_cost' => [
                                                        'type' => 'number'
                                                    ]
                                                ],
                                                'required' => ['description', 'unit_cost', 'total_cost'],
                                                'additionalProperties' => false
                                            ]
                                        ]
                                    ],
                                    'required' => ['name', 'line_items'],
                                    'additionalProperties' => false
                                ]
                            ],
                            'budget' => [
                                'type' => 'number'
                            ],
                            'total_cost' => [
                                'type' => 'number'
                            ],
                        ],
                        'required' => ['length', 'width', 'total_area', 'itemized_costs', 'budget', 'total_cost'],
                        'additionalProperties' => false
                    ]
                ]
            ]

        ]);
        $this->quotation = json_decode($response->choices[0]->message->content, true);
    }
}
