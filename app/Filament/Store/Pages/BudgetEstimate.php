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
use App\Models\BudgetEstimate as BudgetEstimateModel;
use App\Models\BudgetEstimateItem;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Actions\Action as PageAction;

/**
 * BudgetEstimate Page
 * 
 * This page handles the budget estimation functionality for construction projects
 * using AI to generate practical floor areas and cost estimates based on user input.
 */
class BudgetEstimate extends Page implements HasTable
{
    use InteractsWithTable;

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

    /** @var array */
    public array $savedEstimates = [];

    /** @var ?int */
    public ?int $selectedEstimateId = null;

    /**
     * Validation rules for the form fields
     */
    protected function rules(): array
    {
        return [
            'budget' => ['required', 'numeric'],
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
     * Get the table query
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                BudgetEstimateModel::query()
                    ->where('customer_id', Auth::user()->customer->id)
                    ->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('load')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (BudgetEstimateModel $record): void {
                        $this->loadEstimate($record);
                    }),
                Action::make('generateHouse')
                    ->icon('heroicon-o-home')
                    ->url(fn(BudgetEstimateModel $record) => route('house-generator.index', [
                        'width' => $record->structured_data['width'] ?? 40,
                        'length' => $record->structured_data['length'] ?? 40,
                    ]))
                    ->color('success'),
                Action::make('delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (BudgetEstimateModel $record): void {
                        $record->delete();
                        Notification::make()
                            ->title('Estimate deleted')
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Load an estimate into the form
     */
    public function loadEstimate(BudgetEstimateModel $estimate): void
    {
        $this->selectedEstimateId = $estimate->id;
        $this->description = $estimate->description;
        $this->budget = $estimate->total_amount;
        $this->quotation = $estimate->structured_data;

        // Load any additional instructions from notes
        if ($estimate->notes && str_starts_with($estimate->notes, 'Additional instructions:')) {
            $this->chat = substr($estimate->notes, 24); // Remove "Additional instructions: " prefix
        }

        Notification::make()
            ->title('Estimate loaded')
            ->success()
            ->send();
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
    }

    /**
     * Reset the form state
     */
    private function resetForm(): void
    {
        $this->quotation = [];
        $this->additional = [];
        $this->chat = '';
        $this->resetMessages();
    }

    /**
     * Generate budget estimate using AI
     */
    public function estimate(): void
    {
        $this->validate();

        // Reset form state
        $this->resetForm();

        DB::beginTransaction();
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

        $quotation = json_decode($response->choices[0]->message->content, true);
        // Save the generated estimate
        $this->saveEstimate($quotation);

        // Update the quotation property after successful save
        $this->quotation = $quotation;

        DB::commit();

        Notification::make()
            ->title('Success')
            ->body('Estimate generated and saved successfully.')
            ->success()
            ->send();
    }

    /**
     * Save the generated estimate to the database
     */
    private function saveEstimate(array $quotation): void
    {

        $estimate = BudgetEstimateModel::create([
            'customer_id' => Auth::user()->customer->id,
            'name' => "Estimate for {$this->description}",
            'description' => $this->description,
            'structured_data' => $quotation,
            'total_amount' => $quotation['total_cost'],
            'status' => 'draft',
            'notes' => $this->chat ? "Additional instructions: {$this->chat}" : null,
        ]);

        foreach (array_chunk($quotation['itemized_costs'], 10) as $categoryChunk) {
            foreach ($categoryChunk as $category) {
                $workCategory = WorkCategory::firstOrCreate(
                    ['name' => $category['name']],
                    ['requires_labor' => true, 'labor_cost_rate' => 1]
                );
                foreach ($category['line_items'] as $item) {
                    BudgetEstimateItem::create([
                        'budget_estimate_id' => $estimate->id,
                        'work_category_id' => $workCategory->id,
                        'name' => $item['description'],
                        'description' => "Unit cost: ₱{$item['unit_cost']}",
                        'quantity' => $quotation['total_area'],
                        'unit' => 'square meters',
                        'unit_price' => $item['unit_cost'],
                        'type' => 'material',
                    ]);
                }
            }
        }
        $this->selectedEstimateId = $estimate->id;
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
