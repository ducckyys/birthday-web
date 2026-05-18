<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdayMessage extends Model
{
    protected $fillable = [
        'title',
        'body',
        'sort_order',
    ];
}
