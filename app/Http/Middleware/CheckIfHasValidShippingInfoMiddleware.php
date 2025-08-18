<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Route;

class CheckIfHasValidShippingInfoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $has_shipping_info = $request->user()->hasShippingInfo();

        if (! $has_shipping_info && ! Route::is('filament.store.pages.customer-profile')) {
            Notification::make()->title('Missing Shipping Information')->body('Please add your shipping information before continuing.')->warning()->send();

            return redirect()->route('filament.store.pages.customer-profile')->with('error', 'Please add your shipping information before continuing.');
        }

        return $next($request);
    }
}
