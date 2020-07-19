<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;
use Session;
use Str;
use Redirect;

// Models
use App\Models\File;
use App\Models\Tag;

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
        $user = \Auth::user();

        // Save file
        $title = $request->get('title');
        $storage_location = Storage::putFile('media', $request->file('file'));

        // Save model
        $file_upload = new File([
            'title' => $title,
            'description' => $request->get('description'),
            'storage_location' => $storage_location,
            'users_id' => $user->id,
            'slug' => Str::slug($title . ' ' . uniqid()),
        ]);

        if(!$file_upload->save())
        {
            // Log error and redirect user back to upload form with their input and error message
            Log::error("Failed to upload file for user $user->id.");
            return Redirect::back()->withErrors(['file' => 'File failed to upload, please try again.'])->withInput();
        }

        // And save tags any included tags
        $tags = $request->get('tags');
        if(strlen($tags) > 0) // Empty tags get sent over as ""
        {
            $tags =
                array_unique( // Make sure composite PK won't throw an exception
                    explode(',', $request->get('tags')) // Tags are comma delimited by boostrap-tagsinput by default
                );
            foreach($tags as $tag_value)
            {
                $tag = new Tag([
                    'files_id' => $file_upload->id,
                    'value' => $tag_value,
                ]);

                $tag->save();
            }
        }

        // Send back to home
        return Redirect::route('home');
    }
}
