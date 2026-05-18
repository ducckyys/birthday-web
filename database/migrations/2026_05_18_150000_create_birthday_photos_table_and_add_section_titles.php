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
        if (! Schema::hasTable('birthday_photos')) {
            Schema::create('birthday_photos', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('caption')->nullable();
                $table->string('image_path');
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        Schema::table('birthday_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('birthday_settings', 'messages_section_kicker')) {
                $table->string('messages_section_kicker')->default('Untuk Nayla')->after('hero_button_text');
            }

            if (! Schema::hasColumn('birthday_settings', 'messages_section_title')) {
                $table->string('messages_section_title')->default('Pesan yang kusimpan untuk hari ini')->after('messages_section_kicker');
            }

            if (! Schema::hasColumn('birthday_settings', 'photo_section_kicker')) {
                $table->string('photo_section_kicker')->default('Surat Foto')->after('messages_section_title');
            }

            if (! Schema::hasColumn('birthday_settings', 'photo_section_title')) {
                $table->string('photo_section_title')->default('Surat Foto Untuk Nayla')->after('photo_section_kicker');
            }

            if (! Schema::hasColumn('birthday_settings', 'photo_letter_button_text')) {
                $table->string('photo_letter_button_text')->default('Buka Surat')->after('photo_section_title');
            }

            if (! Schema::hasColumn('birthday_settings', 'photo_letter_open_title')) {
                $table->string('photo_letter_open_title')->default('Sedikit wajah yang selalu ingin kulihat')->after('photo_letter_button_text');
            }

            if (! Schema::hasColumn('birthday_settings', 'memories_section_kicker')) {
                $table->string('memories_section_kicker')->default('Timeline')->after('photo_letter_open_title');
            }

            if (! Schema::hasColumn('birthday_settings', 'memories_section_title')) {
                $table->string('memories_section_title')->default('Sedikit Cerita Tentang Kita')->after('memories_section_kicker');
            }

            if (! Schema::hasColumn('birthday_settings', 'reasons_section_kicker')) {
                $table->string('reasons_section_kicker')->default('Alasan')->after('memories_section_title');
            }

            if (! Schema::hasColumn('birthday_settings', 'reasons_section_title')) {
                $table->string('reasons_section_title')->default('Alasan Aku Sayang Kamu')->after('reasons_section_kicker');
            }

            if (! Schema::hasColumn('birthday_settings', 'wishes_section_kicker')) {
                $table->string('wishes_section_kicker')->default('Doa')->after('reasons_section_title');
            }

            if (! Schema::hasColumn('birthday_settings', 'wishes_section_title')) {
                $table->string('wishes_section_title')->default('Harapan baik untukmu')->after('wishes_section_kicker');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ([
            'messages_section_kicker',
            'messages_section_title',
            'photo_section_kicker',
            'photo_section_title',
            'photo_letter_button_text',
            'photo_letter_open_title',
            'memories_section_kicker',
            'memories_section_title',
            'reasons_section_kicker',
            'reasons_section_title',
            'wishes_section_kicker',
            'wishes_section_title',
        ] as $column) {
            if (Schema::hasColumn('birthday_settings', $column)) {
                Schema::table('birthday_settings', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        Schema::dropIfExists('birthday_photos');
    }
};
