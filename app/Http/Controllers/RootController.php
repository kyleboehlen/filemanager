<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootController extends Controller
{
    public function index()
    {
        // Simple redirect over to the home route, which is also used after login/registration
        return redirect()->route('home');
    }
}
