<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class CheckIfProjectManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $is_project_manager = $request->user()->hasRole(['project manager']);
        if (! $is_project_manager) {
            Notification::make()->title('Unauthorized Access')->body('You are not authorized to access this page.')->warning()->send();

            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
