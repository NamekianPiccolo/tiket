<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('tikets.index'); // Arahkan admin ke dashboard admin
        }

        return $next($request);
    }
}
