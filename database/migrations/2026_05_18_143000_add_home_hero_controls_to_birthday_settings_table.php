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
            if (! Schema::hasColumn('birthday_settings', 'hero_date_label')) {
                $table->string('hero_date_label')->default('23 Mei 2026')->after('is_preview_enabled');
            }

            if (! Schema::hasColumn('birthday_settings', 'age_badge_text')) {
                $table->string('age_badge_text')->default('Genap {age} tahun hari ini')->after('hero_subtitle');
            }

            if (! Schema::hasColumn('birthday_settings', 'hero_button_text')) {
                $table->string('hero_button_text')->default('Buka Pesannya')->after('age_badge_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ([
            'hero_date_label',
            'age_badge_text',
            'hero_button_text',
        ] as $column) {
            if (Schema::hasColumn('birthday_settings', $column)) {
                Schema::table('birthday_settings', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
