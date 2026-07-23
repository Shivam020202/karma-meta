<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            background: #fff;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* ── NAV ── */
        .nav {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 1200px;
            z-index: 100;
            padding: 0;
            transition: all .35s;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 24px;
            border-radius: 0;
            transition: all .35s;
        }

        .nav.scrolled .nav-inner {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-radius: 100px;
            box-shadow: 0 4px 28px rgba(0, 0, 0, 0.18);
            padding: 2px 28px;
        }

        .nav.scrolled .logo {
            filter: none;
        }

        .logo {
            filter: brightness(0) invert(1);
            transition: all .35s;
        }

        .logo img {
            height: 64px;
            width: auto;
        }

        .loc {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 100px;
            border: 1px solid rgb(109, 109, 109);
            background: rgb(255, 255, 255);
            color: rgba(129, 129, 129, 0.9);
            font-size: 11px;
            font-weight: 500;
            transition: all .25s;
            cursor: default;
            backdrop-filter: blur(6px);
        }

        .loc:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .loc svg {
            width: 12px;
            height: 12px;
            opacity: 0.8;
        }

        .loc-desktop {
            display: flex;
            gap: 8px;
        }

        .loc-mobile {
            display: none;
        }

        /* ── HERO ── */
        .hero {
            position: relative;
            height: 85vh;
            min-height: 560px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: #2d1b4e;
        }

        .hero video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 2;
            background: linear-gradient(135deg, rgba(26, 43, 74, 0.82) 0%, rgba(118, 60, 152, 0.4) 55%, rgba(26, 43, 74, 0.72) 100%);
        }

        .hero-inner {
            position: relative;
            z-index: 3;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        /* ── BADGE ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
            backdrop-filter: blur(6px);
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: 0.3
            }
        }

        /* ── HEADING ── */
        .hero h1 {
            font-size: clamp(28px, 5vw, 46px);
            font-weight: 900;
            line-height: 1.07;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
            color: #fff;
        }

        .hero h1 em {
            font-style: normal;
            color: #f0d9ff;
        }

        .hero .sub {
            font-size: clamp(13px, 1.5vw, 15px);
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.75;
            max-width: 460px;
            margin-bottom: 28px;
        }

        /* ── STATS ── */
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .st {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 14px 18px;
            text-align: center;
            min-width: 80px;
            transition: all .3s;
        }

        .st:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .st-num {
            display: block;
            font-size: 26px;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
        }

        .st-label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── FORM CARD ── */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        .card h2 {
            font-size: 22px;
            font-weight: 800;
            color: #1a2b4a;
            margin-bottom: 4px;
        }

        .card .card-sub {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 22px;
        }

        .fld {
            margin-bottom: 14px;
        }

        .fld label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 5px;
        }

        .fld label .r {
            color: #ef4444;
        }

        .fld input,
        .fld select,
        .fld textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            color: #1f2937;
            background: #fafafa;
            transition: all .25s;
            outline: none;
            font-family: inherit;
        }

        .fld input::placeholder,
        .fld textarea::placeholder {
            color: #9ca3af;
        }

        .fld input:focus,
        .fld select:focus,
        .fld textarea:focus {
            border-color: #763C98;
            box-shadow: 0 0 0 3px rgba(118, 60, 152, 0.1);
            background: #fff;
        }

        .fld select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .fld textarea {
            resize: none;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.01em;
            background: linear-gradient(135deg, #763C98 0%, #5e3080 100%);
            box-shadow: 0 4px 16px rgba(118, 60, 152, 0.3);
            transition: all .3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(118, 60, 152, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .card .trust {
            text-align: center;
            font-size: 11px;
            color: #c9cdd3;
            margin-top: 10px;
        }

        /* ── FAQ ── */
        .faq-section {
            background: #f8f9fb;
            padding: 64px 0;
        }

        .faq-wrap {
            max-width: 680px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .faq-title {
            text-align: center;
            margin-bottom: 36px;
        }

        .faq-title h2 {
            font-size: clamp(24px, 4vw, 32px);
            font-weight: 800;
            color: #1a2b4a;
        }

        .faq-title p {
            font-size: 14px;
            color: #9ca3af;
            margin-top: 6px;
        }

        .faq-item {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 14px;
            margin-bottom: 8px;
            transition: all .3s;
            overflow: hidden;
        }

        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .faq-q {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 16px 20px;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            gap: 14px;
        }

        .faq-q .icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(118, 60, 152, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .faq-q .icon svg {
            width: 18px;
            height: 18px;
            color: #763C98;
        }

        .faq-q span {
            flex: 1;
            font-size: 14px;
            font-weight: 600;
            color: #1a2b4a;
        }

        .faq-q .chevron {
            width: 18px;
            height: 18px;
            color: #c9cdd3;
            flex-shrink: 0;
            transition: transform .3s;
        }

        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height .4s ease;
        }

        .faq-a.open {
            max-height: 300px;
        }

        .faq-a p {
            padding: 0 20px 18px 70px;
            font-size: 13px;
            line-height: 1.75;
            color: #6b7280;
        }

        /* ── FOOTER ── */
        .footer {
            background: #efefef;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 24px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer p {
            color: rgba(0, 0, 0, 0.6);
            font-size: 12px;
        }

        .footer .copy {
            color: rgba(0, 0, 0, 0.35);
            font-size: 11px;
        }

        /* ── MOBILE FAQ LINK ── */
        .faq-link {
            display: none;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.9);
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(6px);
            transition: all .25s;
        }

        .faq-link:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
        }

        /* ── RESPONSIVE ── */
        @media (max-width:1023px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .hero-left {
                text-align: center;
            }

            .hero .sub {
                margin-left: auto;
                margin-right: auto;
            }

            .stats {
                justify-content: center;
            }

            .loc-desktop {
                display: none !important;
            }

            .faq-link {
                display: inline-flex !important;
            }

            .nav.scrolled .nav-inner {
                padding: 8px 16px;
            }
        }

        @media (max-width:640px) {
            .hero {
                height: auto;
                min-height: auto;
                padding: 70px 0 32px;
            }

            .hero-inner {
                padding: 0 16px;
            }

            .hero-grid {
                gap: 24px;
            }

            .badge {
                font-size: 10px;
                padding: 5px 12px;
                margin-bottom: 16px;
            }

            .hero h1 {
                font-size: 26px;
                margin-bottom: 12px;
            }

            .hero .sub {
                font-size: 13px;
                margin-bottom: 20px;
            }

            .stats {
                gap: 8px;
            }

            .st {
                padding: 10px 12px;
                min-width: 68px;
            }

            .st-num {
                font-size: 20px;
            }

            .st-label {
                font-size: 9px;
            }

            .card {
                padding: 22px 16px;
                border-radius: 14px;
            }

            .card h2 {
                font-size: 18px;
            }

            .form-row {
                display: block !important;
            }

            .form-row .fld {
                margin-bottom: 14px;
            }

            .nav {
                top: 10px;
                width: calc(100% - 24px);
            }

            .nav.scrolled .nav-inner {
                padding: 8px 16px;
            }

            .faq-q {
                padding: 14px 16px;
                gap: 10px;
            }

            .faq-q .icon {
                width: 30px;
                height: 30px;
            }

            .faq-q .icon svg {
                width: 15px;
                height: 15px;
            }

            .faq-a p {
                padding-left: 56px;
                font-size: 12px;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    <!-- Meta Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1943390473007545');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1943390473007545&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body <?php body_class(); ?>>

    <!-- NAV -->
    <nav class="nav" id="nav">
        <div class="nav-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="logo"
                    src="<?php echo esc_url(get_theme_mod('karmadocs_logo', 'https://res.cloudinary.com/de4kw1t2i/image/upload/v1766060387/Karma-Docs-Logo-Horizental_w48ja1.webp')); ?>"
                    alt="<?php bloginfo('name'); ?>">
            </a>
            <div class="loc-desktop">
                <span class="loc"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>Palm Springs</span>
                <span class="loc"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>Rancho Mirage</span>
                <span class="loc"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>Twentynine Palms</span>
            </div>
            <a href="#faq-section" class="faq-link">FAQ</a>
        </div>
    </nav>
