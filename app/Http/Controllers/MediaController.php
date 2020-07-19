<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iman\Streamer\VideoStreamer;
use Image;

// Models
use App\Models\File;

class MediaController extends Controller
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
        $file = File::where('users_id', $user->id)->where('slug', $slug)->with('tags')->first();

        if(is_null($file))
        {
            return Redirect::route('home');
        }

        $file_path = storage_path('app/') . $file->storage_location;
        
        if($file->file_type() == 'image')
        {
            return Image::make($file_path)->fit(600, 600)->response();
        }

        VideoStreamer::streamFile($file_path);
    }
}
