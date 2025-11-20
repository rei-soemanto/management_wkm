<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Check if user is logged in
        if (!$user) {
            return redirect('login');
        }

        // 2. Check the Relationship (New Logic)
        // We assume the relationship in User.php is named 'userRole'
        // and the role name in the database is 'Admin'
        if ($user->userRole && $user->userRole->name === 'Admin') {
            return $next($request);
        }

        // 3. Redirect if not Admin (e.g., to the Employee dashboard)
        return redirect()->route('projects.index')->with('error', 'Access denied. Admin only.');
    }
}