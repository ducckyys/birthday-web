<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['setting']->girlfriend_name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="birthday-page locked-page">
    <div class="floating-hearts" data-floating-hearts aria-hidden="true"></div>
    <div class="soft-blob blob-one" aria-hidden="true"></div>
    <div class="soft-blob blob-two" aria-hidden="true"></div>

    <main class="min-vh-100 d-flex align-items-center justify-content-center py-5 position-relative overflow-hidden">
        <section class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-11 col-md-9 col-lg-7 col-xl-6">
                    <div class="card locked-card rounded-4 shadow-sm border-0 text-center reveal">
                        <div class="card-body p-4 p-md-5">
                            <span class="tiny-label mb-3 d-inline-block">23 Mei 2026, 00:00 WIB</span>
                            <h1 class="display-6 fw-semibold mb-3">{{ $data['setting']->locked_title }}</h1>
                            <p class="lead text-muted-soft mb-4">{{ $data['setting']->locked_subtitle }}</p>

                            <div class="countdown-card mx-auto mb-4" data-countdown-target="{{ $data['unlockAtIso'] }}">
                                <div class="countdown-item rounded-4">
                                    <strong data-countdown-days>00</strong>
                                    <span>Hari</span>
                                </div>
                                <div class="countdown-item rounded-4">
                                    <strong data-countdown-hours>00</strong>
                                    <span>Jam</span>
                                </div>
                                <div class="countdown-item rounded-4">
                                    <strong data-countdown-minutes>00</strong>
                                    <span>Menit</span>
                                </div>
                                <div class="countdown-item rounded-4">
                                    <strong data-countdown-seconds>00</strong>
                                    <span>Detik</span>
                                </div>
                            </div>

                            <p class="locked-message mb-0">{{ $data['setting']->locked_message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
