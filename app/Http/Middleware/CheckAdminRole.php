<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        if ($user->userRole && $user->userRole->name === 'Admin') {
            return $next($request);
        }

        return redirect()->route('projects.index')->with('error', 'Access denied. Admin only.');
    }
}