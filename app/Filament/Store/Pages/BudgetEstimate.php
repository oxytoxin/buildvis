<?php

namespace App\Filament\Store\Pages;

use App\Models\Product;
use Filament\Pages\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Http;
use OpenAI;

class BudgetEstimate extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.store.pages.budget-estimate';

    protected static ?int $navigationSort = 3;

    public $content = '';
    public $reasoning = '';
    public $budget = 2_000_000;

    public function format()
    {
        $this->js('formatmd');
    }

    public function calculate()
    {
        set_time_limit(120);
        $this->content = "";
        $this->reasoning = "";
        $this->stream('content', $this->content, true);
        $this->stream('reasoning', $this->reasoning, true);

        $materials = Product::get()->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'unit' => $product->unit,
            ];
        })->toJson();
        $client = OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->make();

        $stream = $client->chat()->createStreamed([
            'model' => 'o1-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $materials
                ],
                [
                    'role' => 'user',
                    'content' =>
                    "
                    Suggest a house size and generate a bill of materials accounting for labor cost which is 50% of material cost. 
                    Try to exhaust the budget by creating a larger or multistorey house if necessary. All prices in the materials list is in PHP.
                    The total cost should be at least 80% of the budget. I have a budget of {$this->budget}.
                    Show subtotals of each material category and the grand total.
                    "
                ],
            ]
        ]);

        foreach ($stream as $response) {
            $content = $response->choices[0]->toArray()['delta']['content'] ?? null;
            $reasoning =  $response->choices[0]->toArray()['delta']['reasoning_content'] ?? null;
            if ($content) {
                $this->content .= $content;
                $this->stream('content', $content);
            }
            if ($reasoning) {
                $this->reasoning .= $reasoning;
                $this->stream('reasoning', $reasoning);
            }
        }
    }
}
