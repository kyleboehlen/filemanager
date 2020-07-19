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
}
