<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;

class CheckIfProjectManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $is_project_manager = $request->user()->hasRole(['project manager']);
        if (! $is_project_manager) {
            Session::invalidate();
            Auth::logout();
            abort(403);
        }

        return $next($request);
    }
}
