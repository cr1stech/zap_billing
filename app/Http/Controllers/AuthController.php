<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function attempt(Request $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::attempt($credentials)) {
            Session::regenerateToken();
            return to_route('dashboard');
        }

        return back()
            ->withErrors([
                'message' => 'Los datos proporcionados no coinciden!'
            ])->withInput($request->only(['email']));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return to_route('login');
    }
}
