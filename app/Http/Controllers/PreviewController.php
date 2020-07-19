<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

// Models
use App\Models\File;

class PreviewController extends Controller
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

    public function index($slug)
    {
        $user = \Auth::user();
        $file = File::where('users_id', $user->id)->where('slug', $slug)->with('tags')->first(); // Eager load tags

        if(is_null($file))
        {
            return Redirect::route('home');
        }

        return view('preview')->with(['file' => $file]);
    }
}
