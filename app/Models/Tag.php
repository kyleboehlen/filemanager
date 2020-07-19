<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Traits
use App\Models\Traits\HasCompositePrimaryKey;

class Tag extends Model
{
    use HasCompositePrimaryKey;

    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'files_id', 'value',
    ];

    /**
     * The fields that make up the composite primary key
     *
     * @var array
     */
    protected $primaryKey = [
        'files_id', 'value'
    ];
}
