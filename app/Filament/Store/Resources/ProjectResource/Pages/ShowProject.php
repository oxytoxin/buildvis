<?php

namespace App\Filament\Store\Resources\ProjectResource\Pages;

use App\Filament\Store\Resources\ProjectResource;
use App\Models\BudgetEstimate;
use App\Models\BudgetEstimateItem;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkCategory;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Htmlable;
use OpenAI;

/**
 * BudgetEstimate Page
 *
 * This page handles the budget estimation functionality for construction projects
 * using AI to generate practical floor areas and cost estimates based on user input.
 */
class ShowProject extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProjectResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static string $view = 'filament.store.resources.project-resource.pages.show-project';

    public Project $project;

    public function getTitle(): string|Htmlable
    {
        return 'Project:'.$this->project->name;
    }

    protected static ?int $navigationSort = 3;

    public array $quotation = [];

    public int $budget = 2_000_000;

    public string $description = 'two-story residential building';

    public array $messages = [];

    public array $savedEstimates = [];

    public ?int $selectedEstimateId = null;

    public int $lotLength = 20;

    public int $lotWidth = 20;

    public int $floorLength = 15;

    public int $floorWidth = 15;

    public int $numberOfRooms = 3;

    public int $numberOfStories = 1;

    /**
     * Parse project description and extract building specifications using AI
     */
    public function parseDescription(): void
    {
        if (empty($this->description)) {
            Notification::make()
                ->title('No description')
                ->body('Please enter a project description first.')
                ->warning()
                ->send();

            return;
        }

        $client = $this->createOpenAIClient();

        $response = $client->chat()->create([
            'model' => 'o3-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Extract building specifications from this project description: {$this->description}",
                ],
            ],
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'specifications_extraction',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'lot_length' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Lot length in meters. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'lot_width' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Lot width in meters. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'floor_length' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Floor length in meters. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'floor_width' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Floor width in meters. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'number_of_rooms' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Number of rooms/bedrooms. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'number_of_stories' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Number of stories/floors. Return the value if mentioned in the description, otherwise return null.',
                            ],
                            'budget' => [
                                'type' => ['integer', 'null'],
                                'description' => 'Budget in pesos. Return the value if mentioned in the description, otherwise return null.',
                            ],
                        ],
                        'required' => ['lot_length', 'lot_width', 'floor_length', 'floor_width', 'number_of_rooms', 'number_of_stories', 'budget'],
                        'additionalProperties' => false,
                    ],
                ],
            ],
        ]);

        $specifications = json_decode($response->choices[-1]->message->content, true);

        if (! $specifications) {
            throw new \Exception('Failed to parse AI response');
        }

        $updated = false;
        $foundItems = [];

        // Update form fields with extracted specifications (only if found)
        if ($specifications['lot_length'] !== null) {
            $this->lotLength = $specifications['lot_length'];
            $updated = true;
            $foundItems[] = "Lot length: {$specifications['lot_length']}m";
        }

        if ($specifications['lot_width'] !== null) {
            $this->lotWidth = $specifications['lot_width'];
            $updated = true;
            $foundItems[] = "Lot width: {$specifications['lot_width']}m";
        }

        if ($specifications['floor_length'] !== null) {
            $this->floorLength = $specifications['floor_length'];
            $updated = true;
            $foundItems[] = "Floor length: {$specifications['floor_length']}m";
        }

        if ($specifications['floor_width'] !== null) {
            $this->floorWidth = $specifications['floor_width'];
            $updated = true;
            $foundItems[] = "Floor width: {$specifications['floor_width']}m";
        }

        if ($specifications['number_of_rooms'] !== null) {
            $this->numberOfRooms = $specifications['number_of_rooms'];
            $updated = true;
            $foundItems[] = "Rooms: {$specifications['number_of_rooms']}";
        }

        if ($specifications['number_of_stories'] !== null) {
            $this->numberOfStories = $specifications['number_of_stories'];
            $updated = true;
            $foundItems[] = "Stories: {$specifications['number_of_stories']}";
        }

        if ($specifications['budget'] !== null) {
            $this->budget = $specifications['budget'];
            $updated = true;
            $foundItems[] = 'Budget: ₱'.number_format($specifications['budget']);
        }

        if ($updated) {
            $foundText = implode(', ', $foundItems);
            Notification::make()
                ->title('Form updated')
                ->body("Specifications extracted: {$foundText}")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('No specifications found')
                ->body('No building specifications were found in your description. Please enter them manually.')
                ->info()
                ->send();
        }
    }

    /**
     * Validation rules for the form fields
     */
    protected function rules(): array
    {
        return [
            'budget' => ['required', 'numeric', 'min:100000'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'lotLength' => ['required', 'numeric', 'min:5', 'max:100'],
            'lotWidth' => ['required', 'numeric', 'min:5', 'max:100'],
            'floorLength' => ['required', 'numeric', 'min:3', 'max:50'],
            'floorWidth' => ['required', 'numeric', 'min:3', 'max:50'],
            'numberOfRooms' => ['required', 'numeric', 'min:1', 'max:20'],
            'numberOfStories' => ['required', 'numeric', 'min:1', 'max:5'],
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
            'description.required' => 'Please describe your project.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'lotLength.required' => 'Please enter the lot length.',
            'lotLength.numeric' => 'Lot length must be a number.',
            'lotLength.min' => 'Lot length must be at least 5 meters.',
            'lotLength.max' => 'Lot length cannot exceed 100 meters.',
            'lotWidth.required' => 'Please enter the lot width.',
            'lotWidth.numeric' => 'Lot width must be a number.',
            'lotWidth.min' => 'Lot width must be at least 5 meters.',
            'lotWidth.max' => 'Lot width cannot exceed 100 meters.',
            'floorLength.required' => 'Please enter the floor length.',
            'floorLength.numeric' => 'Floor length must be a number.',
            'floorLength.min' => 'Floor length must be at least 3 meters.',
            'floorLength.max' => 'Floor length cannot exceed 50 meters.',
            'floorWidth.required' => 'Please enter the floor width.',
            'floorWidth.numeric' => 'Floor width must be a number.',
            'floorWidth.min' => 'Floor width must be at least 3 meters.',
            'floorWidth.max' => 'Floor width cannot exceed 50 meters.',
            'numberOfRooms.required' => 'Please enter the number of rooms.',
            'numberOfRooms.numeric' => 'Number of rooms must be a number.',
            'numberOfRooms.min' => 'Number of rooms must be at least 1.',
            'numberOfRooms.max' => 'Number of rooms cannot exceed 20.',
            'numberOfStories.required' => 'Please enter the number of stories.',
            'numberOfStories.numeric' => 'Number of stories must be a number.',
            'numberOfStories.min' => 'Number of stories must be at least 1.',
            'numberOfStories.max' => 'Number of stories cannot exceed 5.',
        ];
    }

    /**
     * Reset the messages array with initial prompts and work category data
     */
    public function resetMessages(): void
    {
        $workCategories = WorkCategory::query()
            ->whereHas('product_variations')
            ->with(['product_variations' => function ($query) {
                $query->with('product');
            }])
            ->get();
        $workCategoriesWithProducts = $workCategories
            ->map(function ($wc) {
                return [
                    'name' => $wc->name,
                    'requires_labor' => $wc->requires_labor,
                    'labor_cost_rate' => $wc->labor_cost_rate,
                    'products' => $wc->product_variations->map(function ($pv) {
                        return [
                            'name' => $pv->product_name.' - '.$pv->name,
                            'price' => $pv->price,
                            'unit' => $pv->product->unit,
                            'sku' => $pv->sku,
                        ];
                    })->toArray(),
                ];
            })
            ->filter(function ($wc) {
                return count($wc['products']) > 0;
            })
            ->toArray();
        $items = json_encode($workCategoriesWithProducts);

        $this->messages = [
            [
                'type' => 'text',
                'text' => $this->getInitialPrompt(),
            ],
            [
                'type' => 'text',
                'text' => $this->getWorkCategoriesPrompt($items),
            ],
        ];
    }

    /**
     * Get the initial prompt for the AI
     */
    private function getInitialPrompt(): string
    {
        $totalFloorArea = $this->floorLength * $this->floorWidth * $this->numberOfStories;
        $budgetPerSqm = $this->budget / $totalFloorArea;

        return "Budget: ₱{$this->budget} | Floor: {$totalFloorArea} sq.m | Budget/sq.m: ₱".number_format($budgetPerSqm, 2)." | Rooms: {$this->numberOfRooms} | Stories: {$this->numberOfStories}. Select products from available list and calculate realistic quantities based on floor area. Stay within budget.";
    }

    /**
     * Get the work categories prompt
     */
    private function getWorkCategoriesPrompt(string $items): string
    {
        return "Available work categories with products: {$items}. For each category: select appropriate products, calculate quantities (electrical: 1 outlet/3sqm, plumbing: 1 bathroom/2-3 rooms, steel: 15-20kg/sqm, paint: 0.2-0.3L/sqm/coat, tiles: 1.1x area, formworks: 2.5x area). Add labor costs if required.";
    }

    /**
     * Get the table query
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                BudgetEstimate::query()
                    ->where('project_id', $this->project->id)
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
                    ->color(fn (string $state): string => match ($state) {
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
                    ->action(function (BudgetEstimate $record): void {
                        $this->loadEstimate($record);
                    }),
                ActionGroup::make([
                    Action::make('generateHouse')
                        ->icon('heroicon-o-home')
                        ->url(fn (BudgetEstimate $record) => route('filament.store.resources.projects.house-generator', ['record' => $record]))
                        ->color('success'),
                    Action::make('floorplan')
                        ->icon('heroicon-o-document-text')
                        ->url(fn (BudgetEstimate $record) => route('filament.store.resources.projects.floor-plan', ['record' => $record])),
                    Action::make('delete')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (BudgetEstimate $record): void {
                            $record->delete();
                            Notification::make()
                                ->title('Estimate deleted')
                                ->success()
                                ->send();
                        }),

                ]),

            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Load an estimate into the form
     */
    public function loadEstimate(BudgetEstimate $estimate): void
    {
        $this->selectedEstimateId = $estimate->id;
        $this->description = $estimate->description;
        $this->quotation = $estimate->structured_data;

        // Load dimension data from structured data
        if (isset($estimate->structured_data['budget'])) {
            $this->budget = $estimate->structured_data['budget'];
        } else {
            $this->budget = $estimate->total_amount;
        }
        if (isset($estimate->structured_data['lot_length'])) {
            $this->lotLength = $estimate->structured_data['lot_length'];
        }
        if (isset($estimate->structured_data['lot_width'])) {
            $this->lotWidth = $estimate->structured_data['lot_width'];
        }
        if (isset($estimate->structured_data['floor_length'])) {
            $this->floorLength = $estimate->structured_data['floor_length'];
        }
        if (isset($estimate->structured_data['floor_width'])) {
            $this->floorWidth = $estimate->structured_data['floor_width'];
        }
        if (isset($estimate->structured_data['number_of_rooms'])) {
            $this->numberOfRooms = $estimate->structured_data['number_of_rooms'];
        }
        if (isset($estimate->structured_data['number_of_stories'])) {
            $this->numberOfStories = $estimate->structured_data['number_of_stories'];
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
     * Reset the form state
     */
    private function resetForm(): void
    {
        $this->quotation = [];
        $this->resetMessages();
    }

    /**
     * Generate budget estimate using AI
     */
    public function estimate(): void
    {
        set_time_limit(180); // Set max execution time to 3 minutes

        $this->validate();
        $client = $this->createOpenAIClient();
        $this->resetMessages();

        $response = $client->chat()->create([
            'model' => 'o4-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $this->messages,
                ],
            ],
            'response_format' => $this->getResponseFormat(),
        ]);

        $quotation = json_decode($response->choices[0]->message->content, true);

        if (! $quotation) {
            throw new \Exception('Failed to parse AI response');
        }

        // Save the generated estimate
        $this->saveEstimate($quotation);

        // Update the quotation property with the generated data
        $this->quotation = $quotation;

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
        // Add dimension data to the quotation
        $quotation['lot_length'] = $this->lotLength;
        $quotation['lot_width'] = $this->lotWidth;
        $quotation['floor_length'] = $this->floorLength;
        $quotation['floor_width'] = $this->floorWidth;
        $quotation['number_of_rooms'] = $this->numberOfRooms;
        $quotation['number_of_stories'] = $this->numberOfStories;

        $estimate = BudgetEstimate::create([
            'project_id' => $this->project->id,
            'name' => "Estimate for {$this->description}",
            'description' => $this->description,
            'structured_data' => $quotation,
            'total_amount' => $quotation['total_cost'],
            'status' => 'draft',
        ]);

        // Get all work categories at once to avoid N+1 queries
        $workCategoryNames = collect($quotation['itemized_costs'])->pluck('name')->toArray();
        $workCategories = WorkCategory::whereIn('name', $workCategoryNames)->get()->keyBy('name');

        // Prepare bulk insert data
        $itemsToInsert = [];
        $now = now();

        foreach ($quotation['itemized_costs'] as $category) {
            $workCategory = $workCategories->get($category['name']);

            if (! $workCategory) {
                continue;
            }
            // Add product items
            foreach ($category['products'] as $product) {
                $itemsToInsert[] = [
                    'budget_estimate_id' => $estimate->id,
                    'work_category_id' => $workCategory->id,
                    'name' => $product['product_name'],
                    'description' => "SKU: {$product['sku']}, Unit: {$product['unit']}",
                    'quantity' => $product['quantity'],
                    'unit' => $product['unit'],
                    'unit_price' => $product['unit_price'],
                    'type' => 'material',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Add labor cost if required
            if ($workCategory->requires_labor && isset($category['labor_cost']) && $category['labor_cost'] > 0) {
                $itemsToInsert[] = [
                    'budget_estimate_id' => $estimate->id,
                    'work_category_id' => $workCategory->id,
                    'name' => "Labor - {$category['name']}",
                    'description' => "Labor cost for {$category['name']}",
                    'quantity' => 1,
                    'unit' => 'lump sum',
                    'unit_price' => $category['labor_cost'],
                    'type' => 'labor',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Bulk insert all items at once
        if (! empty($itemsToInsert)) {
            BudgetEstimateItem::insert($itemsToInsert);
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
            ->withHttpClient(new \GuzzleHttp\Client([
                'timeout' => 120, // 2 minutes timeout
                'connect_timeout' => 30, // 30 seconds connection timeout
            ]))
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
                        'lot_length' => ['type' => 'integer'],
                        'lot_width' => ['type' => 'integer'],
                        'floor_length' => ['type' => 'integer'],
                        'floor_width' => ['type' => 'integer'],
                        'number_of_rooms' => ['type' => 'integer'],
                        'number_of_stories' => ['type' => 'integer'],
                        'itemized_costs' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'category_total' => ['type' => 'number'],
                                    'labor_cost' => ['type' => 'number'],
                                    'products' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'product_name' => ['type' => 'string'],
                                                'sku' => ['type' => 'string'],
                                                'unit' => ['type' => 'string'],
                                                'quantity' => ['type' => 'number'],
                                                'unit_price' => ['type' => 'number'],
                                                'total_price' => ['type' => 'number'],
                                            ],
                                            'required' => ['product_name', 'sku', 'unit', 'quantity', 'unit_price', 'total_price'],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                ],
                                'required' => ['name', 'category_total', 'labor_cost', 'products'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'budget' => ['type' => 'number'],
                        'total_cost' => ['type' => 'number'],
                        'materials_cost' => ['type' => 'number'],
                        'labor_cost_total' => ['type' => 'number'],
                    ],
                    'required' => ['length', 'width', 'total_area', 'lot_length', 'lot_width', 'floor_length', 'floor_width', 'number_of_rooms', 'number_of_stories', 'itemized_costs', 'budget', 'total_cost', 'materials_cost', 'labor_cost_total'],
                    'additionalProperties' => false,
                ],
            ],
        ];
    }
}
