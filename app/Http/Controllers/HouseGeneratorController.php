<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BudgetEstimate;
use Illuminate\Support\Facades\Auth;

class HouseGeneratorController extends Controller
{
    public function index(Request $request, BudgetEstimate $budgetEstimate)
    {
        // Ensure the budget estimate belongs to the authenticated user
        if ($budgetEstimate->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Unauthorized access to budget estimate');
        }

        return Inertia::render('HouseGen', [
            'budgetEstimate' => $budgetEstimate,
        ]);
    }
}
