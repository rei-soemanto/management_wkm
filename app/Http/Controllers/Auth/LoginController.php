<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $roleName = Auth::user()->userRole->name ?? '';

        if ($roleName === 'Admin') {
            return route('admin.dashboard');
        }

        return route('projects.index');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }
}