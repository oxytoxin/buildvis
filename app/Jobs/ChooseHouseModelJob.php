<?php

namespace App\Jobs;

use App\Models\BudgetEstimate;
use App\Models\HouseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI;

class ChooseHouseModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 180;

    public function __construct(private readonly BudgetEstimate $budgetEstimate) {}

    public function handle(): void
    {
        $houseModels = HouseModel::all()->toArray();

        $prompt = '
            You are given a list of house models, each with fields:
            id, name, floor_length, floor_width, number_of_stories, number_of_rooms, budget.

            You are also given a budget estimate with the same fields except model_url.
            Your task: return ONLY the house_model_id that best fits the budget estimate based on similarity of budget and layout.
            Prioritize the number_of_stories and budget fields. Budget of the house model should be closest to the budget estimate.
            House Models:
            '.json_encode($houseModels, JSON_PRETTY_PRINT).'

            Budget Estimate:
            '.json_encode($this->budgetEstimate, JSON_PRETTY_PRINT).'

            Return strictly only the id of the house model.
        ';

        $response = OpenAI::factory()
            ->withApiKey(config('services.ai.api_key'))
            ->withBaseUri(config('services.ai.base_uri'))
            ->withHttpClient(new \GuzzleHttp\Client([
                'timeout' => 120,
                'connect_timeout' => 30,
            ]))->make()
            ->chat()->create([
                'model' => 'o4-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant that matches budget estimates to the closest house model.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

        $house_model_id = $response->choices[0]->message->content;
        $house_model = HouseModel::find($house_model_id);
        if ($house_model) {
            $this->budgetEstimate->update(['house_model_id' => $house_model_id]);
        }
    }
}
