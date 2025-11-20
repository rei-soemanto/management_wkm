<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // New Logic: Check relationship name
        $roleName = Auth::user()->userRole->name ?? '';

        if ($roleName === 'Admin') {
            return route('admin.dashboard'); // Redirect to Admin Panel
        }

        // Default for Employees: Go to Project Management
        return route('projects.index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     * Note: Updated to point to the correct view location
     */
    public function showLoginForm()
    {
        return view('login');
    }
}