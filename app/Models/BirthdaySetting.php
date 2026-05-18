<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdaySetting extends Model
{
    protected $fillable = [
        'girlfriend_name',
        'birth_date',
        'unlock_at',
        'hero_title',
        'hero_subtitle',
        'locked_title',
        'locked_subtitle',
        'locked_message',
        'closing_message',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'unlock_at' => 'datetime',
        ];
    }
}
