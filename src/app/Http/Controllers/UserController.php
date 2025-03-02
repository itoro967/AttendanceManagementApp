<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function login()
    {
        return view('auth.login');
    }
}
