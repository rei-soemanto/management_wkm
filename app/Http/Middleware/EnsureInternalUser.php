<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureInternalUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->userRole->name ?? '';

        if ($role === 'Admin' || $role === 'Employee') {
            return $next($request);
        }

        abort(401, 'Unauthorized access.');
    }
}