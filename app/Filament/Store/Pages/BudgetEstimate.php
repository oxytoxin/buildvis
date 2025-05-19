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
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

/**
 * BudgetEstimate Page
 * 
 * This page handles the budget estimation functionality for construction projects
 * using AI to generate practical floor areas and cost estimates based on user input.
 */
class BudgetEstimate extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static string $view = 'filament.store.pages.budget-estimate';
    protected static ?int $navigationSort = 3;

    /** @var array */
    public array $quotation = [];

    /** @var string */
    public string $chat = '';

    /** @var int */
    public int $budget = 2_000_000;

    /** @var string */
    public string $description = 'two-story residential building';

    /** @var array */
    public array $messages = [];

    /** @var array */
    public array $additional = [];

    /**
     * Validation rules for the form fields
     */
    protected function rules(): array
    {
        return [
            'budget' => ['required', 'numeric', 'min:100000', 'max:1000000000'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'chat' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom validation messages
     */
    protected function messages(): array
    {
        return [
            'budget.required' => 'Please enter your budget amount.',
            'budget.numeric' => 'Budget must be a number.',
            'budget.min' => 'Budget must be at least ₱100,000.',
            'budget.max' => 'Budget cannot exceed ₱1,000,000,000.',
            'description.required' => 'Please describe your project.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'chat.max' => 'Additional instructions cannot exceed 1000 characters.',
        ];
    }

    /**
     * Reset the messages array with initial prompts and work category data
     */
    public function resetMessages(): void
    {
        $items = json_encode(WorkCategory::query()
            ->get(['id', 'name'])
            ->map(fn($wc) => [
                'name' => $wc->name,
                'items' => []
            ])->toArray());

        $this->messages = [
            [
                'type' => 'text',
                'text' => $this->getInitialPrompt()
            ],
            [
                'type' => 'text',
                'text' => $this->getWorkCategoriesPrompt($items)
            ],
            [
                'type' => 'text',
                'text' => $this->getAreaCalculationPrompt()
            ],
        ];
    }

    /**
     * Get the initial prompt for the AI
     */
    private function getInitialPrompt(): string
    {
        return "
            I have a construction budget of {$this->budget} pesos. 
            The project involves an embankment job with the following unit costs:
            materials:400, labor:350, excavation:500, backfill:500;
            Give me a practical floor area that prefers almost equal width and length.
            Based on this, calculate the total area that is below my budget. 
        ";
    }

    /**
     * Get the work categories prompt
     */
    private function getWorkCategoriesPrompt(string $items): string
    {
        return "
            The project involves an embankment job with the following unit costs:
            {$items}
        ";
    }

    /**
     * Get the area calculation prompt
     */
    private function getAreaCalculationPrompt(): string
    {
        return "
            Give me a practical floor area that prefers almost equal width and length.
            Based on this, calculate the total area that is below my budget. 
        ";
    }

    /**
     * Mount the page and initialize messages
     */
    public function mount(): void
    {
        $this->resetMessages();
    }

    /**
     * Handle chat message submission
     */
    public function sendChat(): void
    {
        try {
            $this->validate([
                'chat' => ['required', 'string', 'max:1000'],
            ], [
                'chat.required' => 'Please enter your additional instructions.',
                'chat.max' => 'Additional instructions cannot exceed 1000 characters.',
            ]);

            $this->additional[] = [
                'type' => 'text',
                'text' => $this->chat
            ];
            $this->chat = '';
            $this->estimate();
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Validation Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Generate budget estimate using AI
     */
    public function estimate(): void
    {
        try {
            $this->validate();

            set_time_limit(120);
            $this->quotation = [];

            $client = $this->createOpenAIClient();
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
                'response_format' => $this->getResponseFormat()
            ]);

            $this->quotation = json_decode($response->choices[0]->message->content, true);

            Notification::make()
                ->title('Success')
                ->body('Estimate generated successfully.')
                ->success()
                ->send();
        } catch (ValidationException $e) {
            Notification::make()
                ->title('Validation Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('Failed to generate estimate. Please try again.')
                ->danger()
                ->send();
        }
    }

    /**
     * Create OpenAI client with configuration
     */
    private function createOpenAIClient()
    {
        return OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->make();
    }

    /**
     * Get the response format schema for the AI
     */
    private function getResponseFormat(): array
    {
        return [
            'type' => 'json_schema',
            'json_schema' => [
                'name' => 'quotation_response',
                'strict' => true,
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'length' => ['type' => 'integer'],
                        'width' => ['type' => 'integer'],
                        'total_area' => ['type' => 'integer'],
                        'itemized_costs' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'line_items' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'description' => ['type' => 'string'],
                                                'unit_cost' => ['type' => 'number'],
                                                'total_cost' => ['type' => 'number']
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
                        'budget' => ['type' => 'number'],
                        'total_cost' => ['type' => 'number'],
                    ],
                    'required' => ['length', 'width', 'total_area', 'itemized_costs', 'budget', 'total_cost'],
                    'additionalProperties' => false
                ]
            ]
        ];
    }
}
