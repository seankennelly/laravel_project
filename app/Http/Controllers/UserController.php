<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
      return view('users.register');
    }

    // Create New User
    public function store(Request $request) {
      $formFields = $request->validate([
        'name' => ['required', 'min:3'],
        'email' => ['required', 'email', Rule::unique('users', 'email')],
        'password' => ['required', 'confirmed', 'min:6'],
      ]);

      // Hash password
      $formFields['password'] = bcrypt($formFields['password']);

      // Create User
      $user = User::create($formFields);

      // auth()->login($user);
      Auth::login($user);

      return redirect('/')->with('message', 'User created. You are now logeed in');
    }
}