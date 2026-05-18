<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdaySetting extends Model
{
    protected $fillable = [
        'girlfriend_name',
        'birth_date',
        'unlock_at',
        'is_timer_active',
        'is_preview_enabled',
        'hero_date_label',
        'hero_title',
        'hero_subtitle',
        'age_badge_text',
        'hero_button_text',
        'locked_title',
        'locked_subtitle',
        'locked_message',
        'closing_message',
        'music_enabled',
        'music_url',
        'music_volume',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'unlock_at' => 'datetime',
        'is_timer_active' => 'boolean',
        'is_preview_enabled' => 'boolean',
        'music_enabled' => 'boolean',
        'music_volume' => 'float',
    ];
}
