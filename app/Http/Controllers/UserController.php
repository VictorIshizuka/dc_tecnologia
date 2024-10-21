<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('products.home');
        }
        return view('auth.login');
    }

    public function login_action(LoginRequest $r)
    {
        $loginData = $r->only(['email', 'password']);
        if (Auth::attempt($loginData)) {
            Auth::user();
            return redirect()->route('products.home');
        } else {
            return redirect()->back()
                ->with('message', 'Usuário e/ou senha inválido')
                ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // public function register()
    // {
    //     return view('auth.register');
    // }

    // public function register_action(RegisterRequest $r)
    // {

    //     $userData = $r->only(['name', 'email', 'phone', 'document', 'password']);
    //     $userData['password'] = Hash::make($userData['password']);
    //     $user = User::create($userData);

    //     Auth::login($user);

    //     return redirect()->route('home');
    // }
}
