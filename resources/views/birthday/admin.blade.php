<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Ulang Tahun Nayla</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-page">
    @php
        $timerActive = old('is_timer_active', $setting?->is_timer_active ?? true);
        $previewEnabled = old('is_preview_enabled', $setting?->is_preview_enabled ?? false);
        $musicEnabled = old('music_enabled', $setting?->music_enabled ?? true);
        $musicVolume = old('music_volume', $setting?->music_volume ?? '0.50');
        $reasonIcons = [
            'heart' => 'Heart',
            'sparkle' => 'Sparkle',
            'moon' => 'Moon',
            'smile' => 'Smile',
            'leaf' => 'Leaf',
        ];
    @endphp

    <main class="admin-shell py-4 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-9">
                    <div class="admin-card shadow-sm">
                        <div class="admin-card-header d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                            <div>
                                <p class="admin-kicker mb-1">Private Admin</p>
                                <h1 class="admin-title mb-0">Pengaturan Website Ulang Tahun</h1>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <a class="admin-preview-link" href="{{ route('birthday.index') }}" target="_blank" rel="noopener">
                                    Buka Website
                                </a>
                                <a class="admin-preview-link" href="{{ route('birthday.preview') }}" target="_blank" rel="noopener">
                                    Preview Halaman Utama
                                </a>
                            </div>
                        </div>

                        <div class="admin-card-body">
                            @if (session('success'))
                                <div class="admin-alert mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="admin-alert admin-alert-danger mb-4">
                                    Ada input yang perlu diperiksa lagi.
                                </div>
                            @endif

                            <form action="{{ route('birthday.admin.update') }}" method="POST" class="admin-form">
                                @csrf

                                <section class="admin-form-section">
                                    <h2 class="admin-section-title">Kontrol Timer</h2>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="unlock_date" class="admin-label form-label">Tanggal buka</label>
                                            <input type="date" id="unlock_date" name="unlock_date" class="form-control admin-form-control @error('unlock_date') is-invalid @enderror" value="{{ old('unlock_date', $unlockDate) }}" required>
                                            @error('unlock_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="unlock_time" class="admin-label form-label">Jam buka</label>
                                            <input type="time" id="unlock_time" name="unlock_time" class="form-control admin-form-control @error('unlock_time') is-invalid @enderror" value="{{ old('unlock_time', $unlockTime) }}" required>
                                            @error('unlock_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <input type="hidden" name="is_timer_active" value="0">
                                            <label class="admin-check">
                                                <input type="checkbox" name="is_timer_active" value="1" @checked($timerActive)>
                                                <span>Timer aktif</span>
                                            </label>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <input type="hidden" name="is_preview_enabled" value="0">
                                            <label class="admin-check">
                                                <input type="checkbox" name="is_preview_enabled" value="1" @checked($previewEnabled)>
                                                <span>Mode preview halaman utama</span>
                                            </label>
                                        </div>
                                    </div>
                                </section>

                                <section class="admin-form-section">
                                    <h2 class="admin-section-title">Teks Utama</h2>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="girlfriend_name" class="admin-label form-label">Nama pacar</label>
                                            <input type="text" id="girlfriend_name" name="girlfriend_name" class="form-control admin-form-control @error('girlfriend_name') is-invalid @enderror" value="{{ old('girlfriend_name', $setting?->girlfriend_name ?? 'Nayla Rabiatul Hanifa') }}" required>
                                            @error('girlfriend_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="birth_date" class="admin-label form-label">Tanggal lahir</label>
                                            <input type="date" id="birth_date" name="birth_date" class="form-control admin-form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $setting?->birth_date?->format('Y-m-d') ?? '2004-05-23') }}" required>
                                            @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="hero_date_label" class="admin-label form-label">Label tanggal di hero</label>
                                            <input type="text" id="hero_date_label" name="hero_date_label" class="form-control admin-form-control @error('hero_date_label') is-invalid @enderror" value="{{ old('hero_date_label', $setting?->hero_date_label ?? '23 Mei 2026') }}" required>
                                            @error('hero_date_label')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="hero_title" class="admin-label form-label">Hero title</label>
                                            <input type="text" id="hero_title" name="hero_title" class="form-control admin-form-control @error('hero_title') is-invalid @enderror" value="{{ old('hero_title', $setting?->hero_title ?? 'Selamat Ulang Tahun, Nayla Rabiatul Hanifa') }}" required>
                                            @error('hero_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="hero_subtitle" class="admin-label form-label">Hero subtitle</label>
                                            <input type="text" id="hero_subtitle" name="hero_subtitle" class="form-control admin-form-control @error('hero_subtitle') is-invalid @enderror" value="{{ old('hero_subtitle', $setting?->hero_subtitle ?? 'Untuk seseorang yang selalu punya tempat paling hangat di hati.') }}" required>
                                            @error('hero_subtitle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="age_badge_text" class="admin-label form-label">Teks badge umur</label>
                                            <input type="text" id="age_badge_text" name="age_badge_text" class="form-control admin-form-control @error('age_badge_text') is-invalid @enderror" value="{{ old('age_badge_text', $setting?->age_badge_text ?? 'Genap {age} tahun hari ini') }}" required>
                                            <p class="admin-help mb-0 mt-2">Gunakan {age} kalau ingin umur terisi otomatis.</p>
                                            @error('age_badge_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="hero_button_text" class="admin-label form-label">Teks tombol hero</label>
                                            <input type="text" id="hero_button_text" name="hero_button_text" class="form-control admin-form-control @error('hero_button_text') is-invalid @enderror" value="{{ old('hero_button_text', $setting?->hero_button_text ?? 'Buka Pesannya') }}" required>
                                            @error('hero_button_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="closing_message" class="admin-label form-label">Closing message</label>
                                            <textarea id="closing_message" name="closing_message" rows="4" class="form-control admin-form-control @error('closing_message') is-invalid @enderror" required>{{ old('closing_message', $setting?->closing_message ?? '') }}</textarea>
                                            @error('closing_message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <section class="admin-form-section">
                                    <h2 class="admin-section-title">Teks Locked Page</h2>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label for="locked_title" class="admin-label form-label">Locked title</label>
                                            <input type="text" id="locked_title" name="locked_title" class="form-control admin-form-control @error('locked_title') is-invalid @enderror" value="{{ old('locked_title', $setting?->locked_title ?? 'Ada sesuatu untuk Nayla...') }}" required>
                                            @error('locked_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="locked_subtitle" class="admin-label form-label">Locked subtitle</label>
                                            <input type="text" id="locked_subtitle" name="locked_subtitle" class="form-control admin-form-control @error('locked_subtitle') is-invalid @enderror" value="{{ old('locked_subtitle', $setting?->locked_subtitle ?? 'Tapi belum waktunya dibuka.') }}" required>
                                            @error('locked_subtitle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="locked_message" class="admin-label form-label">Locked message</label>
                                            <textarea id="locked_message" name="locked_message" rows="3" class="form-control admin-form-control @error('locked_message') is-invalid @enderror" required>{{ old('locked_message', $setting?->locked_message ?? 'Tunggu sampai hari spesialmu tiba ya, Nayla.') }}</textarea>
                                            @error('locked_message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <section class="admin-form-section">
                                    <h2 class="admin-section-title">Musik</h2>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <input type="hidden" name="music_enabled" value="0">
                                            <label class="admin-check">
                                                <input type="checkbox" name="music_enabled" value="1" @checked($musicEnabled)>
                                                <span>Musik aktif</span>
                                            </label>
                                        </div>

                                        <div class="col-12">
                                            <label for="music_url" class="admin-label form-label">URL musik/audio</label>
                                            <input type="text" id="music_url" name="music_url" class="form-control admin-form-control @error('music_url') is-invalid @enderror" value="{{ old('music_url', $setting?->music_url) }}" placeholder="/audio/nayla-lofi.mp3">
                                            <p class="admin-help mb-0 mt-2">
                                                Jika ingin pakai musik lokal: buat folder public/audio, masukkan file misalnya nayla-lofi.mp3, lalu isi music_url dengan /audio/nayla-lofi.mp3.
                                            </p>
                                            @error('music_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="music_volume" class="admin-label form-label">Volume musik: {{ $musicVolume }}</label>
                                            <input type="range" id="music_volume" name="music_volume" class="form-range admin-form-control @error('music_volume') is-invalid @enderror" min="0" max="1" step="0.05" value="{{ $musicVolume }}">
                                            @error('music_volume')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <div class="admin-actions">
                                    <button type="submit" class="admin-button">Simpan Pengaturan</button>
                                    <a class="admin-secondary-link" href="{{ route('birthday.preview') }}" target="_blank" rel="noopener">Preview Halaman Utama</a>
                                </div>
                            </form>

                            <section class="admin-content-block">
                                <div class="admin-content-heading">
                                    <p class="admin-kicker mb-1">CRUD Konten</p>
                                    <h2 class="admin-title admin-title-small mb-0">Birthday Messages</h2>
                                </div>

                                <form action="{{ route('birthday.admin.messages.store') }}" method="POST" class="admin-create-form">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-7">
                                            <label for="message_title" class="admin-label form-label">Judul pesan baru</label>
                                            <input type="text" id="message_title" name="title" class="form-control admin-form-control" placeholder="Untuk Hari Spesialmu" required>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="message_sort_order" class="admin-label form-label">Urutan</label>
                                            <input type="number" id="message_sort_order" name="sort_order" class="form-control admin-form-control" min="0" placeholder="Auto">
                                        </div>
                                        <div class="col-12">
                                            <label for="message_body" class="admin-label form-label">Isi pesan</label>
                                            <textarea id="message_body" name="body" rows="5" class="form-control admin-form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="admin-button">Tambah Birthday Message</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="admin-crud-list">
                                    @forelse ($messages as $message)
                                        <article class="admin-crud-item">
                                            <form action="{{ route('birthday.admin.messages.update', $message) }}" method="POST" class="admin-crud-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-12 col-md-7">
                                                        <label for="message_title_{{ $message->id }}" class="admin-label form-label">Judul</label>
                                                        <input type="text" id="message_title_{{ $message->id }}" name="title" class="form-control admin-form-control" value="{{ $message->title }}" required>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <label for="message_sort_order_{{ $message->id }}" class="admin-label form-label">Urutan</label>
                                                        <input type="number" id="message_sort_order_{{ $message->id }}" name="sort_order" class="form-control admin-form-control" value="{{ $message->sort_order }}" min="0">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="message_body_{{ $message->id }}" class="admin-label form-label">Isi pesan</label>
                                                        <textarea id="message_body_{{ $message->id }}" name="body" rows="5" class="form-control admin-form-control" required>{{ $message->body }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="admin-secondary-button">Simpan Birthday Message</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('birthday.admin.messages.destroy', $message) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Hapus birthday message ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-button">Hapus Birthday Message</button>
                                            </form>
                                        </article>
                                    @empty
                                        <p class="admin-empty mb-0">Belum ada birthday message.</p>
                                    @endforelse
                                </div>
                            </section>

                            <section class="admin-content-block">
                                <div class="admin-content-heading">
                                    <p class="admin-kicker mb-1">CRUD Konten</p>
                                    <h2 class="admin-title admin-title-small mb-0">Memories</h2>
                                </div>

                                <form action="{{ route('birthday.admin.memories.store') }}" method="POST" class="admin-create-form">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-5">
                                            <label for="memory_title" class="admin-label form-label">Judul memory baru</label>
                                            <input type="text" id="memory_title" name="title" class="form-control admin-form-control" placeholder="Awal Mengenal" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="memory_sort_order" class="admin-label form-label">Urutan</label>
                                            <input type="number" id="memory_sort_order" name="sort_order" class="form-control admin-form-control" min="0" placeholder="Auto">
                                        </div>
                                        <div class="col-12">
                                            <label for="memory_description" class="admin-label form-label">Cerita</label>
                                            <textarea id="memory_description" name="description" rows="3" class="form-control admin-form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="admin-button">Tambah Memory</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="admin-crud-list">
                                    @forelse ($memories as $memory)
                                        <article class="admin-crud-item">
                                            <form action="{{ route('birthday.admin.memories.update', $memory) }}" method="POST" class="admin-crud-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-12 col-md-7">
                                                        <label for="memory_title_{{ $memory->id }}" class="admin-label form-label">Judul</label>
                                                        <input type="text" id="memory_title_{{ $memory->id }}" name="title" class="form-control admin-form-control" value="{{ $memory->title }}" required>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <label for="memory_sort_order_{{ $memory->id }}" class="admin-label form-label">Urutan</label>
                                                        <input type="number" id="memory_sort_order_{{ $memory->id }}" name="sort_order" class="form-control admin-form-control" value="{{ $memory->sort_order }}" min="0">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="memory_description_{{ $memory->id }}" class="admin-label form-label">Cerita</label>
                                                        <textarea id="memory_description_{{ $memory->id }}" name="description" rows="3" class="form-control admin-form-control" required>{{ $memory->description }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="admin-secondary-button">Simpan Memory</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('birthday.admin.memories.destroy', $memory) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Hapus memory ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-button">Hapus Memory</button>
                                            </form>
                                        </article>
                                    @empty
                                        <p class="admin-empty mb-0">Belum ada memory.</p>
                                    @endforelse
                                </div>
                            </section>

                            <section class="admin-content-block">
                                <div class="admin-content-heading">
                                    <p class="admin-kicker mb-1">CRUD Konten</p>
                                    <h2 class="admin-title admin-title-small mb-0">Reasons</h2>
                                </div>

                                <form action="{{ route('birthday.admin.reasons.store') }}" method="POST" class="admin-create-form">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-5">
                                            <label for="reason_title" class="admin-label form-label">Judul alasan baru</label>
                                            <input type="text" id="reason_title" name="title" class="form-control admin-form-control" placeholder="Caramu Hadir Meski Jauh" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="reason_icon" class="admin-label form-label">Icon</label>
                                            <select id="reason_icon" name="icon" class="form-select admin-form-control">
                                                @foreach ($reasonIcons as $iconValue => $iconLabel)
                                                    <option value="{{ $iconValue }}">{{ $iconLabel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="reason_sort_order" class="admin-label form-label">Urutan</label>
                                            <input type="number" id="reason_sort_order" name="sort_order" class="form-control admin-form-control" min="0" placeholder="Auto">
                                        </div>
                                        <div class="col-12">
                                            <label for="reason_description" class="admin-label form-label">Isi alasan</label>
                                            <textarea id="reason_description" name="description" rows="3" class="form-control admin-form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="admin-button">Tambah Alasan</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="admin-crud-list">
                                    @forelse ($reasons as $reason)
                                        <article class="admin-crud-item">
                                            <form action="{{ route('birthday.admin.reasons.update', $reason) }}" method="POST" class="admin-crud-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-12 col-md-5">
                                                        <label for="reason_title_{{ $reason->id }}" class="admin-label form-label">Judul</label>
                                                        <input type="text" id="reason_title_{{ $reason->id }}" name="title" class="form-control admin-form-control" value="{{ $reason->title }}" required>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="reason_icon_{{ $reason->id }}" class="admin-label form-label">Icon</label>
                                                        <select id="reason_icon_{{ $reason->id }}" name="icon" class="form-select admin-form-control">
                                                            @foreach ($reasonIcons as $iconValue => $iconLabel)
                                                                <option value="{{ $iconValue }}" @selected($reason->icon === $iconValue)>{{ $iconLabel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <label for="reason_sort_order_{{ $reason->id }}" class="admin-label form-label">Urutan</label>
                                                        <input type="number" id="reason_sort_order_{{ $reason->id }}" name="sort_order" class="form-control admin-form-control" value="{{ $reason->sort_order }}" min="0">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="reason_description_{{ $reason->id }}" class="admin-label form-label">Isi alasan</label>
                                                        <textarea id="reason_description_{{ $reason->id }}" name="description" rows="3" class="form-control admin-form-control" required>{{ $reason->description }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="admin-secondary-button">Simpan Alasan</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('birthday.admin.reasons.destroy', $reason) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Hapus alasan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-button">Hapus Alasan</button>
                                            </form>
                                        </article>
                                    @empty
                                        <p class="admin-empty mb-0">Belum ada alasan.</p>
                                    @endforelse
                                </div>
                            </section>

                            <section class="admin-content-block">
                                <div class="admin-content-heading">
                                    <p class="admin-kicker mb-1">CRUD Konten</p>
                                    <h2 class="admin-title admin-title-small mb-0">Wishes</h2>
                                </div>

                                <form action="{{ route('birthday.admin.wishes.store') }}" method="POST" class="admin-create-form">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12 col-md-5">
                                            <label for="wish_title" class="admin-label form-label">Judul wish baru</label>
                                            <input type="text" id="wish_title" name="title" class="form-control admin-form-control" placeholder="Semoga Hatimu Selalu Tenang" required>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label for="wish_sort_order" class="admin-label form-label">Urutan</label>
                                            <input type="number" id="wish_sort_order" name="sort_order" class="form-control admin-form-control" min="0" placeholder="Auto">
                                        </div>
                                        <div class="col-12">
                                            <label for="wish_description" class="admin-label form-label">Isi doa/harapan</label>
                                            <textarea id="wish_description" name="description" rows="3" class="form-control admin-form-control" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="admin-button">Tambah Wish</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="admin-crud-list">
                                    @forelse ($wishes as $wish)
                                        <article class="admin-crud-item">
                                            <form action="{{ route('birthday.admin.wishes.update', $wish) }}" method="POST" class="admin-crud-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-12 col-md-7">
                                                        <label for="wish_title_{{ $wish->id }}" class="admin-label form-label">Judul</label>
                                                        <input type="text" id="wish_title_{{ $wish->id }}" name="title" class="form-control admin-form-control" value="{{ $wish->title }}" required>
                                                    </div>
                                                    <div class="col-12 col-md-5">
                                                        <label for="wish_sort_order_{{ $wish->id }}" class="admin-label form-label">Urutan</label>
                                                        <input type="number" id="wish_sort_order_{{ $wish->id }}" name="sort_order" class="form-control admin-form-control" value="{{ $wish->sort_order }}" min="0">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="wish_description_{{ $wish->id }}" class="admin-label form-label">Isi doa/harapan</label>
                                                        <textarea id="wish_description_{{ $wish->id }}" name="description" rows="3" class="form-control admin-form-control" required>{{ $wish->description }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="admin-secondary-button">Simpan Wish</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('birthday.admin.wishes.destroy', $wish) }}" method="POST" class="admin-delete-form" onsubmit="return confirm('Hapus wish ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-button">Hapus Wish</button>
                                            </form>
                                        </article>
                                    @empty
                                        <p class="admin-empty mb-0">Belum ada wish.</p>
                                    @endforelse
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
