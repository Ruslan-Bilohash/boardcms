<?php
// /admin/header.php — Сучасна шапка адмін-панелі (100% АДАПТИВНА + БУРГЕР, 02.01.2026)
// Автор: Руслан Білогаш

// Масив перекладів
$admin_translations = [
    'ua' => [
        'title' => 'Адмін-панель MapsMe Norway',
        'welcome' => 'Ласкаво просимо, адміністраторе!',
        'nav_home' => 'На сайт',
        'nav_users' => 'Користувачі',
        'nav_ads' => 'Оголошення',
        'nav_news' => 'Новини',
        'nav_logout' => 'Вийти',
        'lang_switch' => 'Мова',
    ],
    'en' => [
        'title' => 'Admin Panel — MapsMe Norway',
        'welcome' => 'Welcome, Administrator!',
        'nav_home' => 'Back to Site',
        'nav_users' => 'Users',
        'nav_ads' => 'Ads',
        'nav_news' => 'News',
        'nav_logout' => 'Logout',
        'lang_switch' => 'Language',
    ],
    'no' => [
        'title' => 'Adminpanel — MapsMe Norway',
        'welcome' => 'Velkommen, administrator!',
        'nav_home' => 'Tilbake til nettstedet',
        'nav_users' => 'Brukere',
        'nav_ads' => 'Annonser',
        'nav_news' => 'Nyheter',
        'nav_logout' => 'Logg ut',
        'lang_switch' => 'Språk',
    ]
];
$t = $admin_translations[$current_lang] ?? $admin_translations['ua'];
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($t['title']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --dark: #0f172a;
            --gray: #6b7280;
            --light: #f1f5f9;
            --success: #10b981;
            --danger: #ef4444;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Manrope', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(135deg, var(--dark) 0%, #172554 100%);
            color: white;
            padding: clamp(0.8rem, 2.5vw, 1.2rem) clamp(4%, 5vw, 5%);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 25px rgba(0,0,0,0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .logo {
            font-size: clamp(1.3rem, 4.2vw, 1.7rem);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            letter-spacing: -0.5px;
        }
        .logo i { font-size: clamp(1.6rem, 4.8vw, 2rem); color: #60a5fa; }

        /* Десктопна навігація */
        .nav-desktop {
            display: flex;
            align-items: center;
            gap: clamp(1.2rem, 3vw, 2.8rem);
        }
        .nav-desktop a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: clamp(0.92rem, 2.1vw, 1rem);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
        }
        .nav-desktop a:hover {
            color: #60a5fa;
            background: rgba(96,165,250,0.15);
            transform: translateY(-2px);
        }

        /* Бургер */
        .burger {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: white;
            padding: 0.6rem;
            border-radius: 8px;
            transition: var(--transition);
        }
        .burger:hover { background: rgba(255,255,255,0.15); transform: rotate(90deg); }

        /* Мобільне меню */
        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 999;
            padding: 5rem 5% 2rem;
            overflow-y: auto;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .mobile-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        .mobile-close {
            position: absolute;
            top: 1.5rem;
            right: 5%;
            font-size: 2.4rem;
            color: white;
            cursor: pointer;
            transition: var(--transition);
        }
        .mobile-close:hover { transform: rotate(90deg); color: #60a5fa; }
        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
            margin-top: 2rem;
        }
        .mobile-nav a {
            color: white;
            text-decoration: none;
            font-size: 1.35rem;
            font-weight: 500;
            padding: 1.2rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            gap: 0.9rem;
            transition: var(--transition);
        }
        .mobile-nav a:hover { color: #60a5fa; padding-left: 1rem; }

        /* Мови */
        .lang-flags {
            display: flex;
            gap: 0.6rem;
        }
        .lang-flag {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 3px solid transparent;
            font-size: 1.7rem;
            line-height: 38px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: rgba(255,255,255,0.08);
        }
        .lang-flag.active {
            border-color: #60a5fa;
            background: rgba(96,165,250,0.35);
            transform: scale(1.15);
            box-shadow: 0 0 0 6px rgba(96,165,250,0.2);
        }
        .lang-flag:hover:not(.active) {
            background: rgba(255,255,255,0.2);
            transform: scale(1.12);
        }

        /* Адаптивність */
        @media (max-width: 992px) {
            .nav-desktop { display: none; }
            .burger { display: block; }
            header { padding: 1rem 5%; }
        }
        @media (max-width: 480px) {
            .logo { font-size: clamp(1.1rem, 5vw, 1.4rem); }
            .lang-flag { width: 34px; height: 34px; font-size: 1.5rem; line-height: 34px; }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <i class="fas fa-shield-halved"></i>
        <?= htmlspecialchars($t['title']) ?>
    </div>

    <div class="nav-desktop">
        <div class="lang-flags" title="<?= $t['lang_switch'] ?>">
            <div class="lang-flag <?= $current_lang === 'ua' ? 'active' : '' ?>" onclick="window.location='?lang=ua'">🇺🇦</div>
            <div class="lang-flag <?= $current_lang === 'en' ? 'active' : '' ?>" onclick="window.location='?lang=en'">EN</div>
            <div class="lang-flag <?= $current_lang === 'no' ? 'active' : '' ?>" onclick="window.location='?lang=no'">🇳🇴</div>
        </div>
        <nav>
            <a href="/index.php"><i class="fas fa-home"></i> <?= $t['nav_home'] ?></a>
            <a href="/admin/users.php"><i class="fas fa-users"></i> <?= $t['nav_users'] ?></a>
            <a href="/admin/ads.php"><i class="fas fa-bullhorn"></i> <?= $t['nav_ads'] ?></a>
            <a href="/admin/news.php"><i class="fas fa-newspaper"></i> <?= $t['nav_news'] ?></a>
            <a href="/admin/logout.php" style="color:#f87171;"><i class="fas fa-sign-out-alt"></i> <?= $t['nav_logout'] ?></a>
        </nav>
    </div>

    <!-- Бургер -->
    <div class="burger" id="burgerBtn">
        <i class="fas fa-bars"></i>
    </div>
</header>

<!-- Мобільне меню -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-close" id="mobileClose">×</div>

    <div class="lang-flags" style="justify-content:center; margin:2rem 0;">
        <div class="lang-flag <?= $current_lang === 'ua' ? 'active' : '' ?>" onclick="window.location='?lang=ua'">🇺🇦</div>
        <div class="lang-flag <?= $current_lang === 'en' ? 'active' : '' ?>" onclick="window.location='?lang=en'">EN</div>
        <div class="lang-flag <?= $current_lang === 'no' ? 'active' : '' ?>" onclick="window.location='?lang=no'">🇳🇴</div>
    </div>

    <nav class="mobile-nav">
        <a href="/index.php"><i class="fas fa-home"></i> <?= $t['nav_home'] ?></a>
        <a href="/admin/users.php"><i class="fas fa-users"></i> <?= $t['nav_users'] ?></a>
        <a href="/admin/ads.php"><i class="fas fa-bullhorn"></i> <?= $t['nav_ads'] ?></a>
        <a href="/admin/news.php"><i class="fas fa-newspaper"></i> <?= $t['nav_news'] ?></a>
        <a href="/admin/logout.php" style="color:#f87171;"><i class="fas fa-sign-out-alt"></i> <?= $t['nav_logout'] ?></a>
    </nav>
</div>

<script>
// Сучасний бургер-меню (touch + плавна анімація)
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('burgerBtn');
    const menu = document.getElementById('mobileMenu');
    const close = document.getElementById('mobileClose');

    if (burger && menu && close) {
        const toggle = () => {
            menu.classList.toggle('show');
            document.body.style.overflow = menu.classList.contains('show') ? 'hidden' : '';
            burger.querySelector('i').classList.toggle('fa-bars');
            burger.querySelector('i').classList.toggle('fa-times');
        };

        ['click', 'touchstart'].forEach(event => {
            burger.addEventListener(event, e => {
                if (event === 'touchstart') e.preventDefault();
                toggle();
            }, { passive: false });

            close.addEventListener(event, toggle);
        });

        menu.addEventListener('click', e => {
            if (e.target === menu) toggle();
        });
    }
});
</script>

<div class="container">
    <!-- Тут продовження сторінки -->