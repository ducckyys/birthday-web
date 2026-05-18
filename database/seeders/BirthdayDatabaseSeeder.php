<?php

namespace Database\Seeders;

use App\Models\BirthdayMessage;
use App\Models\BirthdaySetting;
use App\Models\Memory;
use App\Models\Reason;
use App\Models\Wish;
use Illuminate\Database\Seeder;

class BirthdayDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BirthdayMessage::query()->delete();
        Memory::query()->delete();
        Reason::query()->delete();
        Wish::query()->delete();
        BirthdaySetting::query()->delete();

        BirthdaySetting::query()->create([
            'girlfriend_name' => 'Nayla Rabiatul Hanifa',
            'birth_date' => '2004-05-23',
            'unlock_at' => '2026-05-23 00:00:00',
            'is_timer_active' => true,
            'is_preview_enabled' => false,
            'hero_date_label' => '23 Mei 2026',
            'hero_title' => 'Selamat Ulang Tahun, Nayla Rabiatul Hanifa',
            'hero_subtitle' => 'Untuk seseorang yang selalu punya tempat paling hangat di hati.',
            'age_badge_text' => 'Genap {age} tahun hari ini',
            'hero_button_text' => 'Buka Pesannya',
            'locked_title' => 'Ada sesuatu untuk Nayla…',
            'locked_subtitle' => 'Tapi belum waktunya dibuka.',
            'locked_message' => 'Tunggu sampai hari spesialmu tiba ya, Nayla.',
            'closing_message' => 'Mungkin kita belum punya banyak foto bersama, belum banyak waktu yang bisa diabadikan, tapi aku selalu berharap suatu hari nanti kita punya lebih banyak cerita yang bisa kita simpan, bukan cuma di galeri, tapi juga di hati.',
            'music_enabled' => true,
            // Letakkan file di public/audio lalu isi dari admin, misalnya: /audio/nayla-lofi.mp3
            'music_url' => null,
            'music_volume' => 0.50,
        ]);

        BirthdayMessage::query()->create([
            'title' => 'Untuk Hari Spesialmu',
            'body' => 'Selamat ulang tahun, Nayla. Hari ini aku ingin kamu tahu bahwa kehadiranmu selalu punya arti yang tenang dan hangat buatku. Kita memang tidak selalu dekat secara jarak. Ada hari-hari ketika rindu cuma bisa disimpan di chat, doa, dan suara yang tidak selalu cukup menggantikan temu. Tapi entah bagaimana, kamu tetap terasa dekat di bagian hidupku yang paling sederhana.',
            'sort_order' => 1,
        ]);

        BirthdayMessage::query()->create([
            'title' => 'Tentang Jarak, Kita, dan Rasa yang Tetap Tinggal',
            'body' => 'Aku tahu hubungan jarak jauh tidak selalu mudah. Kita jarang bertemu, dan sekalinya bertemu pun waktunya sering terasa terlalu sebentar. Kita juga tidak punya banyak foto atau video untuk membuktikan semua momen itu pernah ada. Tapi buatku, sedikitnya dokumentasi bukan berarti sedikit rasa. Ada pertemuan singkat yang tetap aku ingat baik-baik, ada percakapan kecil yang membuat hari terasa lebih ringan, dan ada kamu yang tetap aku syukuri meski tidak selalu bisa aku lihat langsung. Semoga di umurmu yang baru ini, kamu selalu dikelilingi hal-hal baik, diberi hati yang kuat, dan tetap menjadi Nayla yang lembut dengan caramu sendiri.',
            'sort_order' => 2,
        ]);

        $memories = [
            [
                'title' => 'Awal Mengenal',
                'description' => 'Dari awal, ada hal sederhana yang membuatmu terasa berbeda. Bukan karena semuanya langsung sempurna, tapi karena pelan-pelan kamu menjadi seseorang yang nyaman untuk diajak berbagi hari.',
            ],
            [
                'title' => 'Percakapan yang Terasa Dekat',
                'description' => 'Ada chat yang mungkin terlihat biasa saja, tapi terasa berarti karena datang darimu. Dari percakapan kecil itu, jarak sering terasa sedikit lebih ramah.',
            ],
            [
                'title' => 'Pertemuan Singkat yang Berharga',
                'description' => 'Kita mungkin tidak sering bertemu, dan waktunya pun tidak pernah terasa cukup lama. Tapi justru karena singkat, setiap pertemuan punya tempatnya sendiri untuk dikenang.',
            ],
            [
                'title' => 'Hari-hari LDR',
                'description' => 'Ada rindu yang harus sabar, ada waktu yang harus diatur, dan ada perasaan yang tetap dijaga meski tidak selalu mudah. Terima kasih sudah bertahan sejauh ini.',
            ],
            [
                'title' => 'Harapan untuk Lebih Sering Bertemu',
                'description' => 'Semoga nanti ada lebih banyak waktu untuk duduk berdua, tertawa lebih lama, dan menyimpan cerita yang tidak hanya lewat layar.',
            ],
        ];

        foreach ($memories as $index => $memory) {
            Memory::query()->create([
                'title' => $memory['title'],
                'description' => $memory['description'],
                'sort_order' => $index + 1,
            ]);
        }

        $reasons = [
            [
                'title' => 'Caramu Hadir Meski Jauh',
                'description' => 'Kamu bisa membuat jarak terasa tidak terlalu kosong, cukup dengan kabar kecil atau perhatian yang datang di waktu yang tepat.',
                'icon' => 'heart',
            ],
            [
                'title' => 'Sederhanamu yang Menenangkan',
                'description' => 'Tidak perlu banyak hal besar. Kadang caramu bicara, mendengar, dan memahami sudah cukup membuat hari terasa lebih baik.',
                'icon' => 'sparkle',
            ],
            [
                'title' => 'Ketabahanmu',
                'description' => 'Aku melihat kamu sebagai seseorang yang terus berusaha kuat, bahkan saat tidak semua hal berjalan mudah.',
                'icon' => 'moon',
            ],
            [
                'title' => 'Senyummu',
                'description' => 'Ada senyum yang sederhana, tapi bisa tinggal lama di pikiran. Senyummu salah satunya.',
                'icon' => 'smile',
            ],
            [
                'title' => 'Caramu Bertahan',
                'description' => 'Aku menghargai caramu tetap berjalan, tetap mencoba, dan tetap menjadi dirimu sendiri.',
                'icon' => 'leaf',
            ],
        ];

        foreach ($reasons as $index => $reason) {
            Reason::query()->create([
                'title' => $reason['title'],
                'description' => $reason['description'],
                'icon' => $reason['icon'],
                'sort_order' => $index + 1,
            ]);
        }

        $wishes = [
            [
                'title' => 'Semoga Hatimu Selalu Tenang',
                'description' => 'Semoga kamu diberi hari-hari yang lebih ringan, pikiran yang lebih lapang, dan alasan yang cukup untuk tersenyum setiap hari.',
            ],
            [
                'title' => 'Semoga Langkahmu Dimudahkan',
                'description' => 'Apa pun yang sedang kamu perjuangkan, semoga Allah mudahkan jalannya dan kuatkan hatimu sampai sampai di tujuan.',
            ],
            [
                'title' => 'Semoga Kamu Selalu Dikelilingi Kebaikan',
                'description' => 'Semoga orang-orang baik selalu hadir di sekitarmu, menjaga bahagiamu, dan mengingatkan bahwa kamu berharga.',
            ],
            [
                'title' => 'Semoga Kita Punya Lebih Banyak Waktu',
                'description' => 'Semoga suatu hari nanti jarak menjadi lebih ramah, dan kita bisa punya lebih banyak cerita yang benar-benar kita jalani bersama.',
            ],
        ];

        foreach ($wishes as $index => $wish) {
            Wish::query()->create([
                'title' => $wish['title'],
                'description' => $wish['description'],
                'sort_order' => $index + 1,
            ]);
        }
    }
}
