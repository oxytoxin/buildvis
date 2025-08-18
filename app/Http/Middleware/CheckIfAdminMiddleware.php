<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class CheckIfAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $is_admin = $request->user()->hasRole(['admin']);
        if (! $is_admin) {
            Notification::make()->title('Unauthorized Access')->body('You are not authorized to access this page.')->warning()->send();

            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
