<?php

namespace App\Http\Controllers;

use App\Models\BudgetEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HouseGeneratorController extends Controller
{
    public function index(Request $request, BudgetEstimate $budgetEstimate)
    {
        // Ensure the budget estimate belongs to the authenticated user
        if ($budgetEstimate->project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to budget estimate');
        }

        return Inertia::render('HouseGen', [
            'budgetEstimate' => $budgetEstimate,
        ]);
    }
}
