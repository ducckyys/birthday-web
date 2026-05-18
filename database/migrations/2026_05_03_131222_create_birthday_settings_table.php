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
        Schema::create('birthday_settings', function (Blueprint $table) {
            $table->id();
            $table->string('girlfriend_name');
            $table->date('birth_date');
            $table->dateTime('unlock_at');
            $table->string('hero_title');
            $table->string('hero_subtitle');
            $table->string('locked_title');
            $table->string('locked_subtitle');
            $table->text('locked_message');
            $table->text('closing_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birthday_settings');
    }
};
