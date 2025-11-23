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
    use RegistersUsers;

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
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $employeeRole = UserRole::where('name', 'Employee')->first();
        $roleId = $employeeRole ? $employeeRole->id : 2;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);
    }
    
    public function showRegistrationForm()
    {
        return view('login');
    }
}