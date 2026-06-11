<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function showAccount()
    {
        return view('auth.acc');
    }

    public function register(Request $request)
    {
        $request->validateWithBag('register', [
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        Auth::login($user);

        return redirect()->route('account')
            ->with('success', 'Welcome, ' . $user->name . '! Your account has been created.');
    }

    public function login(Request $request)
    {
        $request->validateWithBag('login', [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
        )) {
            $request->session()->regenerate();
            return redirect()->intended(route('forum'));
        }

        return back()
            ->withErrors(['email' => 'These credentials do not match our records.'], 'login')
            ->withInput($request->only('email'))
            ->with('tab', 'login');
    }
