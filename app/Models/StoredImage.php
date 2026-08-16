<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoredImage extends Model
{
    protected $fillable = [
        'public_path',
        'mime',
        'contents',
    ];

    protected $hidden = [
        'contents',
    ];
}
