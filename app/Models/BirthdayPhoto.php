<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdayPhoto extends Model
{
    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'sort_order',
    ];
}
