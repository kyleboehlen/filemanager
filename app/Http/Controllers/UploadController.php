<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Requests
use App\Http\Requests\Upload\CreateRequest;

class UploadController extends Controller
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

    public function index()
    {
        return view('upload');
    }

    public function create(CreateRequest $request)
    {
        return 'validated';
    }
}
