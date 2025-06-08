<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HouseGeneratorController extends Controller
{
    public function index(Request $request)
    {
        $width = $request->query('width', 5);
        $length = $request->query('length', 5);

        return Inertia::render('HouseGenerator', [
            'width' => $width,
            'length' => $length,
        ]);
    }
}
