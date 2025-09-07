<?php

namespace App\Jobs;

use App\Casts\BudgetEstimateData;
use App\Models\BudgetEstimate;
use App\Models\WorkCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI;

class GenerateBudgetEstimateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 180;

    /**
     * @var array|array[]
     */
    private array $messages = [];

    public function __construct(private readonly BudgetEstimate $budgetEstimate) {}

    public function handle(): void
    {

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
            'response_format' => BudgetEstimateData::getResponseFormat(),
        ]);

        $quotation = json_decode($response->choices[0]->message->content, true);
        $this->budgetEstimate->update(['status' => 'generated', 'structured_data' => $quotation, 'total_amount' => $quotation['total_cost']]);
    }

    private function createOpenAIClient()
    {
        return OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->withHttpClient(new \GuzzleHttp\Client([
                'timeout' => 120,
                'connect_timeout' => 30,
            ]))
            ->make();
    }

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

    private function getInitialPrompt(): string
    {

        return "Budget: ₱{$this->budgetEstimate->budget} | Floor: {$this->budgetEstimate->floor_area} sq.m | Rooms: {$this->budgetEstimate->number_of_rooms} | Stories: {$this->budgetEstimate->number_of_stories}. Select products from available list and calculate realistic quantities based on floor area. Stay within budget.";
    }

    private function getWorkCategoriesPrompt(string $items): string
    {
        return "Available work categories with products: {$items}. For each category: select appropriate products, calculate quantities and add labor costs if required.";
    }
}
