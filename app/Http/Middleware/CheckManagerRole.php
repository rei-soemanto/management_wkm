<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckManagerRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $allowedRoles = ['Admin', 'Manager'];
        
        if ($user->userRole && in_array($user->userRole->name, $allowedRoles)) {
            return $next($request);
        }

        abort(401, 'Unauthorized action.');
    }
}