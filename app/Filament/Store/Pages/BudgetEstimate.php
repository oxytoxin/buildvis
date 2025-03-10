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

    public function save()
    {
        $this->content = "";
        $this->reasoning = "";
        $materials = Product::get()->map(function ($product) {
            return [
                'name' => $product->name,
                'price' => $product->price,
                'unit' => $product->unit,
            ];
        })->toJson();
        $client = OpenAI::factory()
            ->withApiKey(config('services.deepseek.api_key'))
            ->withBaseUri('https://api.deepseek.com/v1')
            ->make();

        $stream = $client->chat()->createStreamed([
            'model' => 'deepseek-reasoner',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Given a list of materials: ' . $materials . ', suggest a house size and generate a bill of materials accounting for labor cost which is 50% of material cost. I have a budget of ' . $this->budget . '.'
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
