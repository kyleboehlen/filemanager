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
        $file = $request->file('file');
        $file_size = $file->getSize();
        
        // Verify file doesn't max out users storage
        $storage_left = config('accept.max_user_storage') - $user->storageUsed();
        if($file_size > $storage_left)
        {
            $formated_storage_left = \formatBytes($storage_left);
            return Redirect::back()->withErrors(["You do not have enough storage left to upload this file ($formated_storage_left bytes left)"])->withInput();
        }

        $storage_location = Storage::putFile('media', $file);

        // Save model
        $file_upload = new File([
            'title' => $title,
            'description' => $request->get('description'),
            'storage_location' => $storage_location,
            'users_id' => $user->id,
            'slug' => Str::slug($title . ' ' . uniqid()),
            'size' => $file_size,
        ]);

        if($request->has('attr-name') && $request->has('attr-url'))
        {
            $file_upload->attribution_name = $request->get('attr-name');
            $file_upload->attribution_url = $request->get('attr-url');
        }

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
