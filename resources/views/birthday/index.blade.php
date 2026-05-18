<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['setting']->girlfriend_name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="birthday-page birthday-index">
    @php
        $rawMusicUrl = trim((string) $data['setting']->music_url);
        $musicSource = null;

        if (($data['setting']->music_enabled ?? true) && $rawMusicUrl !== '') {
            $musicSource = \Illuminate\Support\Str::startsWith($rawMusicUrl, ['http://', 'https://', '/'])
                ? $rawMusicUrl
                : asset($rawMusicUrl);
        }

        $heroDateLabel = $data['setting']->hero_date_label ?: '23 Mei 2026';
        $ageBadgeText = str_replace('{age}', $data['age'], $data['setting']->age_badge_text ?: 'Genap {age} tahun hari ini');
        $heroButtonText = $data['setting']->hero_button_text ?: 'Buka Pesannya';
        $messagesSectionKicker = $data['setting']->messages_section_kicker ?: 'Untuk Nayla';
        $messagesSectionTitle = $data['setting']->messages_section_title ?: 'Pesan yang kusimpan untuk hari ini';
        $photoSectionKicker = $data['setting']->photo_section_kicker ?: 'Surat Foto';
        $photoSectionTitle = $data['setting']->photo_section_title ?: 'Surat Foto Untuk Nayla';
        $photoLetterButtonText = $data['setting']->photo_letter_button_text ?: 'Buka Surat';
        $photoLetterOpenTitle = $data['setting']->photo_letter_open_title ?: 'Sedikit wajah yang selalu ingin kulihat';
        $memoriesSectionKicker = $data['setting']->memories_section_kicker ?: 'Timeline';
        $memoriesSectionTitle = $data['setting']->memories_section_title ?: 'Sedikit Cerita Tentang Kita';
        $reasonsSectionKicker = $data['setting']->reasons_section_kicker ?: 'Alasan';
        $reasonsSectionTitle = $data['setting']->reasons_section_title ?: 'Alasan Aku Sayang Kamu';
        $wishesSectionKicker = $data['setting']->wishes_section_kicker ?: 'Doa';
        $wishesSectionTitle = $data['setting']->wishes_section_title ?: 'Harapan baik untukmu';
    @endphp

    <div class="confetti-rain" data-confetti-rain aria-hidden="true"></div>
    <div class="floating-hearts" data-floating-hearts aria-hidden="true"></div>
    <div class="soft-blob blob-one" aria-hidden="true"></div>
    <div class="soft-blob blob-two" aria-hidden="true"></div>

    @if ($musicSource)
        <button type="button" class="music-toggle music-toggle-btn shadow-sm" data-music-toggle aria-label="Putar Musik">
            <span class="music-toggle-icon" aria-hidden="true">&#9835;</span>
            <span class="music-toggle-text">Putar Musik</span>
            <span class="music-bars" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        <audio data-birthday-audio src="{{ $musicSource }}" data-music-volume="{{ $data['setting']->music_volume ?? 0.5 }}" preload="none" loop></audio>
    @endif

    <div class="sparkle-field" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <header class="hero-section min-vh-100 d-flex align-items-center justify-content-center text-center position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9 col-xl-8">
                    <span class="tiny-label mb-3 d-inline-block reveal">{{ $heroDateLabel }}</span>
                    <h1 class="hero-title fw-semibold mb-4 reveal">{{ $data['setting']->hero_title }}</h1>
                    <p class="hero-subtitle mx-auto mb-4 reveal">{{ $data['setting']->hero_subtitle }}</p>
                    <div class="age-pill d-inline-flex align-items-center justify-content-center rounded-pill shadow-sm mb-4 reveal">
                        {{ $ageBadgeText }}
                    </div>
                    <div class="reveal">
                        <button type="button" class="btn btn-romantic rounded-pill px-4 py-3 shadow-sm" data-scroll-target="#birthday-message" data-confetti-trigger>
                            {{ $heroButtonText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="birthday-message" class="section-space">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8 text-center">
                        <span class="section-kicker reveal">{{ $messagesSectionKicker }}</span>
                        <h2 class="section-title reveal">{{ $messagesSectionTitle }}</h2>
                    </div>
                </div>

                <div class="row justify-content-center g-4">
                    @foreach ($data['messages'] as $message)
                        <div class="col-12 col-lg-10">
                            <article class="card birthday-message-card rounded-4 shadow-sm border-0 reveal">
                                <div class="card-body p-4 p-md-5">
                                    <h3 class="h4 fw-semibold mb-3">{{ $message->title }}</h3>
                                    <p class="message-text mb-0">{!! nl2br(e($message->body)) !!}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if ($data['photos']->isNotEmpty())
            <section class="section-space section-soft photo-letter-section">
                <div class="container">
                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-8 text-center">
                            <span class="section-kicker reveal">{{ $photoSectionKicker }}</span>
                            <h2 class="section-title reveal">{{ $photoSectionTitle }}</h2>
                        </div>
                    </div>

                    <div class="photo-letter-wrap reveal" data-photo-letter>
                        <button type="button" class="photo-envelope" data-photo-letter-toggle aria-expanded="false">
                            <span class="photo-envelope-flap" aria-hidden="true"></span>
                            <span class="photo-envelope-body" aria-hidden="true"></span>
                            <span class="photo-envelope-paper" aria-hidden="true"></span>
                            <span class="photo-envelope-text">{{ $photoLetterButtonText }}</span>
                        </button>

                        <div class="photo-letter-panel" aria-live="polite">
                            <h3 class="photo-letter-title">{{ $photoLetterOpenTitle }}</h3>
                            <div class="photo-polaroid-grid">
                                @foreach ($data['photos'] as $photo)
                                    @php
                                        $photoSource = \Illuminate\Support\Str::startsWith($photo->image_path, ['http://', 'https://', '/'])
                                            ? $photo->image_path
                                            : asset($photo->image_path);
                                        $photoTilt = (($loop->iteration % 5) - 2) * 1.6;
                                    @endphp
                                    <figure class="photo-polaroid" style="--photo-tilt: {{ $photoTilt }}deg;">
                                        <img src="{{ $photoSource }}" alt="{{ $photo->title }}">
                                        <figcaption>
                                            <strong>{{ $photo->title }}</strong>
                                            @if ($photo->caption)
                                                <span>{{ $photo->caption }}</span>
                                            @endif
                                        </figcaption>
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="section-space section-soft story-timeline-section">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8 text-center">
                        <span class="section-kicker reveal">{{ $memoriesSectionKicker }}</span>
                        <h2 class="section-title reveal">{{ $memoriesSectionTitle }}</h2>
                    </div>
                </div>

                <div class="timeline mx-auto">
                    @foreach ($data['memories'] as $memory)
                        <article class="timeline-item reveal">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content rounded-4 shadow-sm">
                                <span class="timeline-number">{{ str_pad($memory->sort_order, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="h5 fw-semibold mb-2">{{ $memory->title }}</h3>
                                <p class="mb-0">{{ $memory->description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-space love-reasons-section">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8 text-center">
                        <span class="section-kicker reveal">{{ $reasonsSectionKicker }}</span>
                        <h2 class="section-title reveal">{{ $reasonsSectionTitle }}</h2>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($data['reasons'] as $reason)
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card reason-card rounded-4 shadow-sm border-0 h-100 reveal">
                                <div class="card-body p-4">
                                    <div class="reason-icon reason-icon-{{ $reason->icon }} d-flex align-items-center justify-content-center rounded-circle mb-3" aria-hidden="true"></div>
                                    <h3 class="h5 fw-semibold mb-2">{{ $reason->title }}</h3>
                                    <p class="mb-0">{{ $reason->description }}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-space section-soft">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8 text-center">
                        <span class="section-kicker reveal">{{ $wishesSectionKicker }}</span>
                        <h2 class="section-title reveal">{{ $wishesSectionTitle }}</h2>
                    </div>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($data['wishes'] as $wish)
                        <div class="col-12 col-md-6">
                            <article class="card wish-card rounded-4 shadow-sm border-0 h-100 reveal">
                                <div class="card-body p-4 p-md-5">
                                    <h3 class="h5 fw-semibold mb-3">{{ $wish->title }}</h3>
                                    <p class="mb-0">{{ $wish->description }}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="closing-section text-center">
            <div class="footer-glow" aria-hidden="true"></div>
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-xl-7">
                        <div class="closing-content reveal">
                            <span class="footer-mark d-inline-flex align-items-center justify-content-center mb-4" aria-hidden="true">&#9825;</span>
                            <p class="closing-message mb-4">{{ $data['setting']->closing_message }}</p>
                            <h2 class="closing-title mb-3">Happy Birthday, Nayla.</h2>
                            <p class="footer-note mb-0">Semoga hari ini terasa lembut, hangat, dan cukup membuatmu tersenyum.</p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="birthday-footer">
                <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-2">
                    <span>Untuk {{ $data['setting']->girlfriend_name }}</span>
                    <span class="footer-separator" aria-hidden="true"></span>
                    <span>{{ $heroDateLabel }}</span>
                </div>
            </footer>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
