<?php
// /admin/index.php — Головна сторінка адмін-панелі MapsMe Norway
// 100% АДАПТИВНА ВЕРСІЯ з бургер-меню (оновлено 02.01.2026)
// Автор: Руслан Білогаш

session_start();

// Тимчасово для діагностики (в продакшені прибери)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Проста авторизація — ЗМІНИ ПАРОЛЬ!
define('ADMIN_PASSWORD', 'supersecret2026'); // ← ЗМІНИ НА СКЛАДНИЙ ПАРОЛЬ!
if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['pass']) && $_POST['pass'] === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        // Адаптивна форма входу
        ?>
        <!DOCTYPE html>
        <html lang="uk">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
            <title>Вхід в адмін-панель</title>
            <style>
                body {font-family:system-ui,sans-serif;background:linear-gradient(135deg,#0f172a,#172554);color:white;height:100vh;margin:0;display:flex;align-items:center;justify-content:center;padding:clamp(1rem,5vw,2rem);box-sizing:border-box;}
                .login-box {background:#1e293b;padding:clamp(2rem,6vw,3rem);border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.6);width:100%;max-width:420px;text-align:center;}
                input {width:100%;padding:1rem;margin:1rem 0;border:none;border-radius:8px;font-size:clamp(1rem,4vw,1.2rem);}
                button {width:100%;padding:1rem;background:#4361ee;color:white;border:none;border-radius:8px;font-size:clamp(1rem,4vw,1.2rem);cursor:pointer;transition:all 0.3s;}
                button:hover {background:#3b82f6;transform:translateY(-2px);}
                @media(max-width:480px){.login-box{padding:2rem 1.5rem;}}
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>Адмін-панель</h2>
                <form method="post">
                    <input type="password" name="pass" placeholder="Пароль" required autofocus autocomplete="off">
                    <button type="submit">Увійти</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Вихід
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /admin/index.php");
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Мови
$current_lang = $_GET['lang'] ?? ($_SESSION['admin_lang'] ?? 'ua');
$_SESSION['admin_lang'] = $current_lang;

// Переклади
$texts = [
    'ua' => [
        'title' => 'Адмін-панель — MapsMe Norway',
        'welcome' => 'Ласкаво просимо, Адміністратор!',
        'subtitle' => 'Керуйте MapsMe Norway легко та швидко',
        'db_status' => 'Підключення до БД',
        'pending_ads' => 'Оголошень на модерації',
        'published_ads' => 'Опублікованих оголошень',
        'total_users' => 'Зареєстровано користувачів',
        'new_today' => 'Нових сьогодні',
        'pending_news' => 'Новин на модерації',
        'published_news' => 'Опублікованих новин',
        'nav_home' => 'На сайт',
        'nav_users' => 'Користувачі',
        'nav_ads' => 'Оголошення',
        'nav_news' => 'Новини',
        'nav_logout' => 'Вийти',
        'db_ok' => 'OK',
        'db_error' => 'ПОМИЛКА'
    ],
    'en' => [
        'title' => 'Admin Panel — MapsMe Norway',
        'welcome' => 'Welcome, Administrator!',
        'subtitle' => 'Manage MapsMe Norway easily and fast',
        'db_status' => 'Database connection',
        'pending_ads' => 'Pending ads',
        'published_ads' => 'Published ads',
        'total_users' => 'Total users',
        'new_today' => 'New today',
        'pending_news' => 'Pending news',
        'published_news' => 'Published news',
        'nav_home' => 'Back to site',
        'nav_users' => 'Users',
        'nav_ads' => 'Ads',
        'nav_news' => 'News',
        'nav_logout' => 'Logout',
        'db_ok' => 'OK',
        'db_error' => 'ERROR'
    ],
    'no' => [
        'title' => 'Adminpanel — MapsMe Norway',
        'welcome' => 'Velkommen, Administrator!',
        'subtitle' => 'Administrer MapsMe Norway enkelt og raskt',
        'db_status' => 'Databaseforbindelse',
        'pending_ads' => 'Ventende annonser',
        'published_ads' => 'Publiserte annonser',
        'total_users' => 'Totalt brukere',
        'new_today' => 'Nye i dag',
        'pending_news' => 'Ventende nyheter',
        'published_news' => 'Publiserte nyheter',
        'nav_home' => 'Tilbake til nettstedet',
        'nav_users' => 'Brukere',
        'nav_ads' => 'Annonser',
        'nav_news' => 'Nyheter',
        'nav_logout' => 'Logg ut',
        'db_ok' => 'OK',
        'db_error' => 'FEIL'
    ]
];
$t = $texts[$current_lang] ?? $texts['ua'];

// Статистика з захистом
$stats = array_fill_keys(['pending_ads','published_ads','total_users','new_users_today','pending_news','published_news'], 0);
$stats['db_connected'] = $pdo ? $t['db_ok'] : $t['db_error'];

if ($pdo) {
    try {
        $stats['pending_ads']     = $pdo->query("SELECT COUNT(*) FROM ads WHERE status='pending'")->fetchColumn() ?: 0;
        $stats['published_ads']   = $pdo->query("SELECT COUNT(*) FROM ads WHERE status='published'")->fetchColumn() ?: 0;
        $stats['total_users']     = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() ?: 0;
        $today = date('Y-m-d 00:00:00');
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE created_at >= ?");
        $stmt->execute([$today]);
        $stats['new_users_today'] = $stmt->fetchColumn() ?: 0;
        $stats['pending_news']    = $pdo->query("SELECT COUNT(*) FROM news WHERE status='pending'")->fetchColumn() ?: 0;
        $stats['published_news']  = $pdo->query("SELECT COUNT(*) FROM news WHERE status='published'")->fetchColumn() ?: 0;
    } catch (Exception $e) {
        error_log("Admin stats error: " . $e->getMessage());
    }
}
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
            --success: #10b981;
            --warning: #f59e0b;
            --light: #f8f9ff;
            --dark: #0f172a;
            --gray: #6b7280;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Manrope', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, var(--dark), #172554);
            color: white;
            padding: clamp(0.8rem, 3vw, 1.2rem) clamp(4%, 5vw, 5%);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .logo {
            font-size: clamp(1.3rem, 4.5vw, 1.7rem);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .logo i { font-size: clamp(1.6rem, 5vw, 2rem); color: #60a5fa; }

        /* Десктопна навігація */
        .nav-desktop {
            display: flex;
            align-items: center;
            gap: clamp(1rem, 3vw, 2.5rem);
        }
        .nav-desktop a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            font-size: clamp(0.9rem, 2.2vw, 1rem);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .nav-desktop a:hover { color: #60a5fa; transform: translateY(-2px); }

        /* Бургер */
        .burger {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: white;
            padding: 0.6rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .burger:hover { background: rgba(255,255,255,0.15); }

        /* Мобільне меню */
        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.98);
            backdrop-filter: blur(10px);
            z-index: 999;
            padding: 5rem 5% 2rem;
            overflow-y: auto;
        }
        .mobile-menu.show { display: block; }
        .mobile-close {
            position: absolute;
            top: 1.5rem;
            right: 5%;
            font-size: 2.2rem;
            color: white;
            cursor: pointer;
        }
        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .mobile-nav a {
            color: white;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 500;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        /* Контент */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: clamp(1rem, 5vw, 2.5rem) 5%;
        }
        .welcome {
            text-align: center;
            padding: clamp(4rem, 12vw, 6rem) 0 4rem;
        }
        .welcome h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 10vw, 5rem);
            margin-bottom: 1rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(280px, 45vw, 350px), 1fr));
            gap: clamp(1.5rem, 4vw, 2.5rem);
            margin: 3rem 0;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: clamp(1.5rem, 5vw, 2.5rem);
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.4s;
        }
        .stat-card:hover { transform: translateY(-10px) scale(1.02); }
        .stat-icon { font-size: clamp(3rem, 10vw, 4.2rem); margin-bottom: 1rem; }
        .stat-number { font-size: clamp(2.2rem, 8vw, 3.5rem); font-weight: 800; }
        .stat-title { font-size: clamp(1rem, 3vw, 1.3rem); color: var(--gray); }

        /* Адаптивність */
        @media (max-width: 992px) {
            .nav-desktop { display: none; }
            .burger { display: block; }
            header { padding: 1rem 5%; }
        }
        @media (max-width: 480px) {
            .stat-card { padding: 1.5rem; min-height: 160px; }
            .welcome h1 { font-size: clamp(2rem, 12vw, 3.5rem); }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <i class="fas fa-shield-halved"></i>
        <?= htmlspecialchars($t['welcome']) ?>
    </div>

    <div class="nav-desktop">
        <nav>
            <a href="/admin/index.php?lang=<?= $current_lang ?>"><?= $t['nav_home'] ?></a>
            <a href="/admin/users.php?lang=<?= $current_lang ?>"><?= $t['nav_users'] ?></a>
            <a href="/admin/ads.php?lang=<?= $current_lang ?>"><?= $t['nav_ads'] ?></a>
            <a href="/admin/news.php?lang=<?= $current_lang ?>"><?= $t['nav_news'] ?></a>
        </nav>
        <a href="?logout=1" style="color:#f87171; margin-left:1.5rem; font-weight:bold;">× <?= $t['nav_logout'] ?></a>
    </div>

    <div class="burger" id="burgerBtn"><i class="fas fa-bars"></i></div>
</header>

<!-- Мобільне меню -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-close" id="mobileClose">×</div>
    <nav class="mobile-nav">
        <a href="/admin/index.php?lang=<?= $current_lang ?>"><?= $t['nav_home'] ?></a>
        <a href="/admin/users.php?lang=<?= $current_lang ?>"><?= $t['nav_users'] ?></a>
        <a href="/admin/ads.php?lang=<?= $current_lang ?>"><?= $t['nav_ads'] ?></a>
        <a href="/admin/news.php?lang=<?= $current_lang ?>"><?= $t['nav_news'] ?></a>
        <a href="?logout=1" style="color:#f87171;">× <?= $t['nav_logout'] ?></a>
    </nav>
</div>

<div class="container">
    <div class="welcome">
        <h1><?= htmlspecialchars($t['welcome']) ?></h1>
        <p><?= htmlspecialchars($t['subtitle']) ?></p>
        <small style="color:#666;">DB: <?= $stats['db_connected'] ?></small>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="color:var(--warning);">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-number"><?= $stats['pending_ads'] ?></div>
            <div class="stat-title"><?= $t['pending_ads'] ?></div>
        </div>
        <div class="stat-card" style="color:var(--success);">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-number"><?= $stats['published_ads'] ?></div>
            <div class="stat-title"><?= $t['published_ads'] ?></div>
        </div>
        <div class="stat-card" style="color:var(--primary);">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-number"><?= $stats['total_users'] ?></div>
            <div class="stat-title"><?= $t['total_users'] ?></div>
        </div>
        <div class="stat-card" style="color:#ec4899;">
            <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
            <div class="stat-number"><?= $stats['new_users_today'] ?></div>
            <div class="stat-title"><?= $t['new_today'] ?></div>
        </div>
        <div class="stat-card" style="color:var(--warning);">
            <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-number"><?= $stats['pending_news'] ?></div>
            <div class="stat-title"><?= $t['pending_news'] ?></div>
        </div>
        <div class="stat-card" style="color:var(--success);">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-number"><?= $stats['published_news'] ?></div>
            <div class="stat-title"><?= $t['published_news'] ?></div>
        </div>
    </div>
</div>
<!-- Google Translate плаваюча кнопка в лівому нижньому кутку -->
<div id="google_translate_element" style="
    position: fixed;
    bottom: clamp(15px, 5vw, 25px);
    left: clamp(15px, 5vw, 25px);
    z-index: 9999;
    transition: all 0.3s ease;
"></div>

<style>
    /* Стилі для кнопки та випадаючого списку */
    #google_translate_element img { display: none !important; } /* прибираємо логотип */
    .goog-te-combo {
        background: #4361ee;
        color: white;
        border: none;
        padding: clamp(8px, 3vw, 12px) clamp(12px, 4vw, 18px);
        border-radius: 50px;
        font-size: clamp(0.9rem, 3vw, 1rem);
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(67,97,238,0.4);
        appearance: none;
        -webkit-appearance: none;
        outline: none;
    }
    .goog-te-combo:hover {
        background: #3b82f6;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(67,97,238,0.5);
    }
    .goog-te-banner-frame { display: none !important; } /* прибираємо верхній банер */
    body { top: 0 !important; } /* фікс для sticky header */
</style>

<!-- Скрипт Google Translate -->
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'uk',
        includedLanguages: 'uk,en,no,ru,pl,de,fr',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
    }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/footer.php'; ?>

<script>
// Бургер-меню (touch-friendly)
const burger = document.getElementById('burgerBtn');
const menu = document.getElementById('mobileMenu');
const closeBtn = document.getElementById('mobileClose');

if (burger && menu && closeBtn) {
    const toggle = () => {
        menu.classList.toggle('show');
        document.body.style.overflow = menu.classList.contains('show') ? 'hidden' : '';
        burger.querySelector('i').classList.toggle('fa-bars');
        burger.querySelector('i').classList.toggle('fa-times');
    };

    ['click', 'touchstart'].forEach(evt => {
        burger.addEventListener(evt, e => {
            if (evt === 'touchstart') e.preventDefault();
            toggle();
        }, { passive: false });

        closeBtn.addEventListener(evt, toggle);
    });

    menu.addEventListener('click', e => {
        if (e.target === menu) toggle();
    });
}
</script>
</body>
</html>
