<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('birthday_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('birthday_settings', 'is_timer_active')) {
                $table->boolean('is_timer_active')->default(true)->after('unlock_at');
            }

            if (! Schema::hasColumn('birthday_settings', 'is_preview_enabled')) {
                $table->boolean('is_preview_enabled')->default(false)->after('is_timer_active');
            }

            if (! Schema::hasColumn('birthday_settings', 'music_enabled')) {
                $table->boolean('music_enabled')->default(true)->after('closing_message');
            }

            if (! Schema::hasColumn('birthday_settings', 'music_url')) {
                $table->string('music_url')->nullable()->after('music_enabled');
            }

            if (! Schema::hasColumn('birthday_settings', 'music_volume')) {
                $table->decimal('music_volume', 3, 2)->default(0.50)->after('music_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ([
            'is_timer_active',
            'is_preview_enabled',
            'music_enabled',
            'music_url',
            'music_volume',
        ] as $column) {
            if (Schema::hasColumn('birthday_settings', $column)) {
                Schema::table('birthday_settings', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
