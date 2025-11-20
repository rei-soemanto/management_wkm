<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\UserRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected function redirectTo()
    {
        $roleName = Auth::user()->userRole->name ?? '';

        if ($roleName === 'Admin') {
            return route('admin.dashboard');
        }
        return route('projects.index');
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        // 1. Find the ID for the 'Employee' role
        // Fallback to ID 2 if not found (based on your migration)
        $employeeRole = UserRole::where('name', 'Employee')->first();
        $roleId = $employeeRole ? $employeeRole->id : 2;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId, // NEW: Mandatory role_id
        ]);
    }
    
    /**
     * Show the application registration form.
     * Note: We usually show the same login view because of the Tabs
     */
    public function showRegistrationForm()
    {
        return view('login');
    }
}