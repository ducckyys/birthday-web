import './bootstrap';

const pad = (value) => String(value).padStart(2, '0');

const setText = (root, selector, value) => {
    const element = root.querySelector(selector);

    if (element) {
        element.textContent = value;
    }
};

const initCountdown = () => {
    const countdown = document.querySelector('[data-countdown-target]');

    if (!countdown) {
        return;
    }

    const targetValue = countdown.dataset.countdownTarget || countdown.dataset.unlockAt;
    const target = new Date(targetValue).getTime();

    if (Number.isNaN(target)) {
        return;
    }

    let hasUnlocked = false;
    let countdownTimer = null;

    const finishCountdown = () => {
        if (hasUnlocked) {
            return;
        }

        hasUnlocked = true;

        if (countdownTimer) {
            window.clearInterval(countdownTimer);
        }

        setText(countdown, '[data-countdown-days]', '00');
        setText(countdown, '[data-countdown-hours]', '00');
        setText(countdown, '[data-countdown-minutes]', '00');
        setText(countdown, '[data-countdown-seconds]', '00');

        const overlay = document.querySelector('[data-unlock-overlay]');

        document.body.classList.add('is-unlocking');

        if (overlay) {
            overlay.classList.add('show');
            overlay.setAttribute('aria-hidden', 'false');
        }

        window.setTimeout(() => {
            window.location.href = countdown.dataset.unlockRedirectUrl || window.location.href;
        }, 2600);
    };

    const render = () => {
        const distance = target - Date.now();

        if (distance <= 0) {
            finishCountdown();
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((distance / (1000 * 60)) % 60);
        const seconds = Math.floor((distance / 1000) % 60);

        setText(countdown, '[data-countdown-days]', pad(days));
        setText(countdown, '[data-countdown-hours]', pad(hours));
        setText(countdown, '[data-countdown-minutes]', pad(minutes));
        setText(countdown, '[data-countdown-seconds]', pad(seconds));
    };

    render();

    if (!hasUnlocked) {
        countdownTimer = window.setInterval(render, 1000);
    }
};

const initRevealAnimation = () => {
    const elements = document.querySelectorAll('.reveal');

    if (!elements.length) {
        return;
    }

    document.querySelectorAll('.hero-section, .section-space, .closing-section').forEach((section) => {
        section.querySelectorAll('.reveal').forEach((element, index) => {
            element.style.setProperty('--reveal-delay', `${Math.min(index * 90, 360)}ms`);
        });
    });

    if (!('IntersectionObserver' in window)) {
        elements.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.16,
    });

    elements.forEach((element) => observer.observe(element));
};

const initSmoothScroll = () => {
    document.querySelectorAll('[data-scroll-target]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.scrollTarget);

            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
};

const initConfetti = () => {
    const container = document.querySelector('[data-confetti-rain]');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!container) {
        return;
    }

    const colors = ['#f7a8bc', '#c9667f', '#ded2ff', '#fff5e9', '#e8bd6a', '#ffffff', '#bba7ff'];
    let rainTimer = null;

    const random = (min, max) => min + Math.random() * (max - min);

    const createPiece = ({
        originX = random(0, 100),
        isInitial = false,
    } = {}) => {
        const shapeRoll = Math.random();
        const piece = document.createElement('span');
        const duration = random(4400, 7600);
        const size = random(7, 14);
        const color = colors[Math.floor(Math.random() * colors.length)];
        const drift = random(-1.35, 1.35);
        const rotation = random(180, 620) * (Math.random() > 0.5 ? 1 : -1);

        piece.className = 'confetti-piece';

        if (shapeRoll > 0.86) {
            piece.classList.add('is-heart');
            piece.textContent = '\u2665';
        } else if (shapeRoll > 0.62) {
            piece.classList.add('is-circle');
        }

        piece.style.left = `${originX}%`;

        piece.style.setProperty('--confetti-color', color);
        piece.style.setProperty('--confetti-size', `${size}px`);
        piece.style.setProperty('--confetti-duration', `${duration}ms`);
        piece.style.setProperty('--confetti-drift', `${drift}rem`);
        piece.style.setProperty('--confetti-rotate', `${rotation}deg`);
        piece.style.animationDelay = isInitial ? `${random(-duration + 500, 0)}ms` : `${random(0, 220)}ms`;

        container.appendChild(piece);
        window.setTimeout(() => piece.remove(), duration + 1800);
    };

    const startRain = () => {
        if (rainTimer) {
            return;
        }

        const initialCount = prefersReducedMotion ? 24 : window.innerWidth < 576 ? 52 : 95;

        for (let index = 0; index < initialCount; index += 1) {
            createPiece({
                originX: random(0, 100),
                isInitial: true,
            });
        }

        rainTimer = window.setInterval(() => {
            const maxPieces = prefersReducedMotion ? 42 : window.innerWidth < 576 ? 95 : 175;
            const amount = prefersReducedMotion ? 1 : window.innerWidth < 576 ? 3 : 6;

            if (container.childElementCount < maxPieces) {
                for (let index = 0; index < amount; index += 1) {
                    createPiece();
                }
            }
        }, prefersReducedMotion ? 520 : 170);
    };

    const extraRain = (count = 80) => {
        for (let index = 0; index < count; index += 1) {
            createPiece({
                originX: random(0, 100),
            });
        }
    };

    startRain();

    document.querySelectorAll('[data-confetti-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => extraRain(90));
    });
};

const initSoftMusic = () => {
    const button = document.querySelector('[data-music-toggle]');
    const audio = document.querySelector('[data-birthday-audio]');

    if (!button || !audio) {
        return;
    }

    let isPlaying = false;
    let isStarting = false;
    const requestedVolume = Number.parseFloat(audio.dataset.musicVolume ?? '0.5');
    const musicVolume = Number.isFinite(requestedVolume)
        ? Math.min(1, Math.max(0, requestedVolume))
        : 0.5;

    const updateButton = () => {
        button.classList.toggle('is-playing', isPlaying);
        button.setAttribute('aria-label', isPlaying ? 'Jeda Musik' : 'Putar Musik');

        const text = button.querySelector('.music-toggle-text');

        if (text) {
            text.textContent = isPlaying ? 'Jeda Musik' : 'Putar Musik';
        }
    };

    const startMusic = async () => {
        if (isPlaying || isStarting) {
            return;
        }

        isStarting = true;

        try {
            audio.volume = musicVolume;
            await audio.play();
            isPlaying = true;
            updateButton();
            button.blur();
        } finally {
            isStarting = false;
        }
    };

    const stopMusic = () => {
        audio.pause();
        isPlaying = false;
        updateButton();
    };

    button.addEventListener('click', async () => {
        if (isPlaying) {
            stopMusic();
            return;
        }

        try {
            await startMusic();
        } catch (error) {
            isPlaying = false;
            updateButton();
            console.warn('Musik belum bisa diputar. Pastikan music_url mengarah ke file audio yang valid.', error);
        }
    });

    audio.addEventListener('ended', () => {
        isPlaying = false;
        updateButton();
    });

    updateButton();
};

const initFloatingHearts = () => {
    const containers = document.querySelectorAll('[data-floating-hearts]');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!containers.length || prefersReducedMotion) {
        return;
    }

    containers.forEach((container) => {
        const createHeart = () => {
            const heart = document.createElement('span');
            const size = 14 + Math.random() * 16;
            const duration = 8500 + Math.random() * 5000;

            heart.className = 'floating-heart';
            heart.textContent = '\u2661';
            heart.style.left = `${Math.random() * 100}%`;
            heart.style.fontSize = `${size}px`;
            heart.style.animationDuration = `${duration}ms`;
            heart.style.animationDelay = `${Math.random() * 700}ms`;

            container.appendChild(heart);
            setTimeout(() => heart.remove(), duration + 1200);
        };

        for (let index = 0; index < 8; index += 1) {
            setTimeout(createHeart, index * 450);
        }

        setInterval(createHeart, 1800);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initCountdown();
    initRevealAnimation();
    initSmoothScroll();
    initConfetti();
    initSoftMusic();
    initFloatingHearts();
});
