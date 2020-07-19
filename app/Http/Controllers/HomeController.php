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
        $term = null;
        $user = \Auth::user();
        $files = File::where('users_id', $user->id)->paginate(10); // Get all users files and paginate to 10 records

        if($request->has('search'))
        {
            $term = $request->get('search'); // Get search term from request
            if(strlen($term)) // Verify we are not passing an empty needle
            {
                $search_files = $files->getCollection(); // Get the collection to search on as to not ruin pagination
                $filtered_files = $search_files->filter->search($term); // Filter using the File class search function
                $files->setCollection($filtered_files); // Use the filtered colletion to set the pagination collection
                $files->appends(['search' => $term]); // And make sure that the pagination links include the search term as a GET param
            }
        }
           
        return view('home')->with(['files' => $files, 'search' => $term]);
    }
}
