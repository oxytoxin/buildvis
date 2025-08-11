<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;

class CheckIfAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $is_admin = $request->user()->hasRole(['admin']);
        if (! $is_admin) {
            Session::invalidate();
            Auth::logout();
            abort(403);
        }

        return $next($request);
    }
}
