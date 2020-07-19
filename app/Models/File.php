<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Tag;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'storage_location', 'users_id', 'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Returns whether file is an image or video.
     *
     * @return string
     */
    public function fileType()
    {
        $ext_index = strrpos($this->storage_location, '.');
        $ext = substr($this->storage_location, ++$ext_index); // Get file extension by substringing from the index of the last .
        return $ext == 'mp4' ? 'video' : 'image'; // mp4s are supported for video, rest of the supported files are images.
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'files_id');
    }

    public function search($term)
    {
        $term = strtolower($term); // Keep it case insensitive

        // Search title
        if(strpos(strtolower($this->title), $term) !== false)
        {
            return true;
        }

        // Search description
        if(strpos(strtolower($this->description), $term) !== false)
        {
            return true;
        }

        // Serach tags
        $tags = $this->tags->map(function($tag){
            return strtolower($tag->value);
        });

        foreach($tags as $tag)
        {
            if(strpos($tag, $term) !== false)
            {
                return true;
            }
        }

        // Term not found in any fields
        return false;
    }
}
