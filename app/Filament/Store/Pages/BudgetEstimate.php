<?php

namespace App\Filament\Store\Pages;

use App\Models\Product;
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

    public $content = '';
    public $chat = '';
    public $budget = 2_000_000;
    public $description = 'two-story residential building';

    public $messages = [];

    public function mount()
    {
        $this->messages = [
            [
                'type' => 'text',
                'text' => "
                    You are a civil engineer with 20 years of experience in giving accurate quotations. You use the materials in the provided quotation file.
                "
            ],
            [
                'type' => 'text',
                'text' => "
                    List all the materials you have. Do not include the quantities, only the units. 
                    Create categories, and group the materials accordingly. 
                    Only include materials that can be bought in a store.
                    Under each category should be all the items that belong to that category.
                    You are asked to generate an estimate or quotation for a {$this->description} 
                    with a budget of {$this->budget} pesos, using those materials and the sample quotation as reference. 
                    Format the quotation into a table, with each line item including a name, quantity, price and subtotal.
                    Maximize the budget with focus on concrete and painting materials.
                    You should also include a grand total row, and use python to get the sum of all subtotals. 
                    Do not show the python code, only the table in the output.
                "
            ]
        ];
    }

    public function sendChat()
    {
        $this->messages[] = [
            'type' => 'text',
            'text' => $this->chat
        ];
        $this->chat = '';
        $this->estimate();
    }

    public function estimate()
    {
        set_time_limit(120);
        $this->content = "";
        $this->stream('content', $this->content, true);

        $client = OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->make();

        $stream = $client->chat()->createStreamed([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'file',
                            'file' => [
                                'file_id' => 'file-9mCQuA2a9AQdWX191V8sHo'
                            ]
                        ],
                        ...$this->messages
                    ]
                ],
            ]
        ]);

        $config = [];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $converter = new MarkdownConverter($environment);

        foreach ($stream as $response) {
            $content = $response->choices[0]->toArray()['delta']['content'] ?? null;
            if ($content) {
                $this->content .= $content;
                $this->stream('content', $converter->convert($this->content)->getContent(), true);
            }
        }
        $this->content = $converter->convert($this->content)->getContent();
    }
}
