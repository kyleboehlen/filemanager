<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = \Auth::user();
        $files = File::where('users_id', $user->id);
           
        return view('home')->with(['files' => $files->paginate(10)]);
    }
}
