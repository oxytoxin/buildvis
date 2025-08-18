<?php

namespace App\Http\Controllers;

use App\Models\BudgetEstimate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetEstimateController extends Controller
{
    public function store(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'budget_estimate_id' => 'required|exists:budget_estimates,id',
            'dimensions' => 'required|array',
            'lotDimensions' => 'required|array',
            'stories' => 'required|array',
            'externalWallColor' => 'required|string',
            'internalWallColor' => 'required|string',
            'groundColor' => 'required|string',
            'roofType' => 'required|string',
            'roofColor' => 'required|string',
            'floorType' => 'required|string',
            'tileSize' => 'required|numeric',
            'tileColor' => 'required|string',
            'groutColor' => 'required|string',
            'carpetColor' => 'required|string',
            'ceilingColor' => 'required|string',
        ]);

        $budgetEstimate = BudgetEstimate::where('id', $validated['budget_estimate_id'])
            ->whereRelation('project', 'user_id', Auth::id())
            ->first();

        if (! $budgetEstimate) {
            return response()->json(['error' => 'Budget estimate not found'], 404);
        }

        // Save house generator data to the house_data column
        $houseData = array_diff_key($validated, ['budget_estimate_id' => '']);
        $budgetEstimate->updateQuietly([
            'house_data' => $houseData,
        ]);

        return response()->json([
            'id' => $budgetEstimate->id,
            'message' => 'House configuration saved to budget estimate successfully',
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $budgetEstimate = BudgetEstimate::where('id', $id)
            ->where('customer_id', Auth::user()->customer->id)
            ->first();

        if (! $budgetEstimate) {
            return response()->json(['error' => 'Budget estimate not found'], 404);
        }

        $houseData = $budgetEstimate->house_data;

        if (! $houseData) {
            return response()->json(['error' => 'No house generator data found'], 404);
        }

        return response()->json($houseData);
    }
}
