<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

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
