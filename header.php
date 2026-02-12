<?php
// header.php — ФІНАЛЬНА ВЕРСІЯ 02.01.2026 19:30
// ✅ 100% висота мобільного меню на всіх телефонах
// ✅ Флаги мов на десктопі з прапорами та hover-ефектами
// ✅ Текст логотипу "MapsME Board CMS"
// ✅ Надійний бургер-меню (працює на всіх пристроях)
?>

<header class="header">
    <div class="container">
        <div class="header-inner">
            <!-- Логотип -->
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-mountain-sun"></i>
                </div>
                <span class="logo-text">MapsME Board CMS</span>
            </a>

            <!-- Десктопна навігація -->
            <nav class="nav-desktop">
                <a href="#robota"><i class="fa-solid fa-briefcase"></i> 
                    <?= $current_lang === 'no' ? 'Jobb' : ($current_lang === 'en' ? 'Jobs' : 'Робота') ?>
                </a>
                <a href="#zhytlo"><i class="fa-solid fa-home"></i> 
                    <?= $current_lang === 'no' ? 'Bolig' : ($current_lang === 'en' ? 'Housing' : 'Житло') ?>
                </a>
                <a href="#avto"><i class="fa-solid fa-car"></i> 
                    <?= $current_lang === 'no' ? 'Bil' : ($current_lang === 'en' ? 'Cars' : 'Авто') ?>
                </a>
                <a href="#posluhy"><i class="fa-solid fa-wrench"></i> 
                    <?= $current_lang === 'no' ? 'Tjenester' : ($current_lang === 'en' ? 'Services' : 'Послуги') ?>
                </a>
            </nav>

            <!-- Права частина -->
            <div class="header-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/profile.php" class="user-avatar">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= $_SESSION['user_id'] ?>" alt="Профіль" loading="lazy">
                    </a>
                <?php else: ?>
                    <a href="/login.php" class="btn-login">
                        <?= $current_lang === 'no' ? 'Logg inn' : ($current_lang === 'en' ? 'Login' : 'Увійти') ?>
                    </a>
                <?php endif; ?>

                <!-- Перемикач мов на десктопі (з прапорами) -->
                <div class="lang-switch desktop-lang">
                    <a href="?lang=ua" class="<?= $current_lang === 'ua' ? 'active' : '' ?>" title="Українська">
                        <span class="flag">🇺🇦</span> UA
                    </a>
                    <a href="?lang=en" class="<?= $current_lang === 'en' ? 'active' : '' ?>" title="English">
                        <span class="flag">🇬🇧</span> EN
                    </a>
                    <a href="?lang=no" class="<?= $current_lang === 'no' ? 'active' : '' ?>" title="Norsk">
                        <span class="flag">🇳🇴</span> NO
                    </a>
                </div>

                <!-- Бургер-кнопка -->
                <button class="burger-btn" aria-label="Меню" aria-expanded="false" type="button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- МОБІЛЬНЕ МЕНЮ -->
<div class="mobile-menu-overlay" id="mobileMenu">
    <div class="mobile-menu-content">
        <!-- Кнопка закриття -->
        <button class="mobile-close" aria-label="Закрити" type="button">
            <i class="fas fa-times"></i>
        </button>

        <!-- Навігація -->
        <nav class="mobile-nav">
            <a href="#robota" class="nav-item"><i class="fa-solid fa-briefcase"></i> 
                <?= $current_lang === 'no' ? 'Jobb' : ($current_lang === 'en' ? 'Jobs' : 'Робота') ?>
            </a>
            <a href="#zhytlo" class="nav-item"><i class="fa-solid fa-home"></i> 
                <?= $current_lang === 'no' ? 'Bolig' : ($current_lang === 'en' ? 'Housing' : 'Житло') ?>
            </a>
            <a href="#avto" class="nav-item"><i class="fa-solid fa-car"></i> 
                <?= $current_lang === 'no' ? 'Bil' : ($current_lang === 'en' ? 'Cars' : 'Авто') ?>
            </a>
            <a href="#posluhy" class="nav-item"><i class="fa-solid fa-wrench"></i> 
                <?= $current_lang === 'no' ? 'Tjenester' : ($current_lang === 'en' ? 'Services' : 'Послуги') ?>
            </a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/profile.php" class="nav-item"><i class="fas fa-user"></i> Профіль</a>
            <?php else: ?>
                <a href="/login.php" class="nav-item"><i class="fas fa-sign-in-alt"></i> Увійти</a>
            <?php endif; ?>
        </nav>

        <!-- Мови в мобільному меню -->
        <div class="mobile-languages">
            <div class="lang-title">Мова:</div>
            <div class="lang-list">
                <a href="?lang=ua" class="<?= $current_lang === 'ua' ? 'active' : '' ?>">🇺🇦 Українська</a>
                <a href="?lang=en" class="<?= $current_lang === 'en' ? 'active' : '' ?>">🇬🇧 English</a>
                <a href="?lang=no" class="<?= $current_lang === 'no' ? 'active' : '' ?>">🇳🇴 Norsk</a>
            </div>
        </div>
    </div>
</div>

<style>
/* ОСНОВНІ СТИЛІ ХЕДЕРА */
.header {
    background: rgba(255,255,255,0.95);
    backdrop-filter: saturate(180%) blur(20px);
    padding: clamp(0.8rem, 2vw, 1.2rem) 0;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 500;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 clamp(1rem, 4vw, 1.5rem);
}

.header-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    text-decoration: none;
    color: #4361ee;
}

.logo-text {
    font-weight: 700;
    font-size: clamp(1.1rem, 2.5vw, 1.4rem);
}

.logo-icon {
    width: clamp(44px, 6vw, 52px);
    height: clamp(44px, 6vw, 52px);
    background: linear-gradient(135deg, #4361ee, #3b82f6);
    border-radius: 12px;
    display: grid;
    place-items: center;
    color: white;
    font-size: clamp(1.3rem, 4vw, 1.7rem);
}

.nav-desktop {
    display: flex;
    gap: clamp(1.5rem, 3vw, 2.2rem);
    flex: 1;
    justify-content: center;
}

.nav-desktop a {
    color: #1e293b;
    text-decoration: none;
    font-weight: 600;
    font-size: clamp(0.95rem, 2vw, 1.05rem);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
}

.nav-desktop a:hover { color: #4361ee; }

.header-right {
    display: flex;
    align-items: center;
    gap: clamp(0.8rem, 2vw, 1.2rem);
}

.btn-login {
    padding: clamp(0.6rem, 2vw, 0.8rem) clamp(1.2rem, 3vw, 1.5rem);
    background: linear-gradient(135deg, #4361ee, #3b82f6);
    color: white !important;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    font-size: clamp(0.85rem, 2vw, 0.95rem);
    transition: all 0.3s;
}

.btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(67,97,238,0.4);
}

/* БУРГЕР-КНОПКА */
.burger-btn {
    display: none;
    flex-direction: column;
    gap: 4px;
    background: none;
    border: none;
    cursor: pointer;
    padding: clamp(0.4rem, 2vw, 0.8rem);
}

.burger-btn span {
    width: 26px;
    height: 3px;
    background: #4361ee;
    border-radius: 3px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.burger-btn[aria-expanded="true"] span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}
.burger-btn[aria-expanded="true"] span:nth-child(2) {
    opacity: 0;
    transform: translateX(8px);
}
.burger-btn[aria-expanded="true"] span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* МОБІЛЬНЕ МЕНЮ */
.mobile-menu-overlay {
    position: fixed !important;
    inset: 0 !important;
    height: 100vh !important;
    width: 100vw !important;
    background: rgba(0,0,0,0.6);
    z-index: 999999 !important;
    opacity: 0;
    visibility: hidden;
    transform: translateX(100%);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    display: flex !important;
    align-items: stretch;
    overflow: hidden;
}

.mobile-menu-overlay.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateX(0) !important;
}

.mobile-menu-content {
    background: #ffffff;
    width: 85vw;
    max-width: 380px;
    height: 100vh !important;
    padding: 6rem 2.5rem 3rem;
    overflow-y: auto;
    transform: translateX(20px);
    transition: transform 0.4s ease;
    box-shadow: -8px 0 40px rgba(0,0,0,0.25);
}

.mobile-menu-overlay.show .mobile-menu-content {
    transform: translateX(0);
}

.mobile-close {
    position: sticky;
    top: 1.5rem;
    right: 1.5rem;
    background: none;
    border: none;
    font-size: 2.2rem;
    color: #64748b;
    cursor: pointer;
    margin-bottom: 2rem;
    z-index: 10;
}

.mobile-nav {
    display: flex;
    flex-direction: column;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.4rem 0;
    color: #1e293b;
    text-decoration: none;
    font-size: clamp(1.1rem, 3vw, 1.25rem);
    font-weight: 500;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.nav-item:hover {
    color: #4361ee;
    padding-left: 1rem;
}

.mobile-languages {
    margin-top: auto;
    padding-top: 2.5rem;
    margin-bottom: 2rem;
}

.lang-title {
    font-size: 1rem;
    color: #64748b;
    margin-bottom: 1.2rem;
    font-weight: 600;
}

.lang-list {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.lang-list a {
    color: #4361ee;
    text-decoration: none;
    padding: 0.8rem 0;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 8px;
    transition: all 0.3s;
}

.lang-list a:hover, .lang-list a.active {
    background: #4361ee10;
    padding-left: 1rem;
}

/* ПЕРЕМИКАЧ МОВ НА ДЕСКТОПІ */
.desktop-lang {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    background: rgba(67, 97, 238, 0.08);
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    backdrop-filter: blur(8px);
}

.desktop-lang a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.9rem;
    border-radius: 8px;
    text-decoration: none;
    color: #4361ee;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.25s ease;
}

.desktop-lang a .flag {
    font-size: 1.4rem;
    line-height: 1;
}

.desktop-lang a:hover,
.desktop-lang a.active {
    background: rgba(67, 97, 238, 0.15);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(67,97,238,0.2);
}

.desktop-lang a.active {
    font-weight: 800;
    background: rgba(67, 97, 238, 0.25);
}

/* АДАПТИВНІСТЬ */
@media (max-width: 1024px) {
    .nav-desktop,
    .desktop-lang {
        display: none !important;
    }
    .burger-btn {
        display: flex !important;
    }
}

@media (max-width: 480px) {
    .mobile-menu-content {
        width: 92vw;
        padding: 5rem 1.8rem 2rem;
    }
    .nav-item {
        padding: 1.6rem 0;
    }
}
</style>

<script>
// СУПЕРНАДІЙНИЙ СКРИПТ ДЛЯ БУРГЕР-МЕНЮ
(function() {
    'use strict';
    
    let menuOpen = false;
    const burger = document.querySelector('.burger-btn');
    const menu = document.getElementById('mobileMenu');
    const closeBtn = document.querySelector('.mobile-close');

    if (!burger || !menu) return;

    function openMenu() {
        if (menuOpen) return;
        menuOpen = true;
        
        burger.setAttribute('aria-expanded', 'true');
        menu.classList.add('show');
        
        document.body.classList.add('menu-open');
        document.documentElement.classList.add('menu-open');
    }

    function closeMenu() {
        if (!menuOpen) return;
        menuOpen = false;
        
        burger.setAttribute('aria-expanded', 'false');
        menu.classList.remove('show');
        
        document.body.classList.remove('menu-open');
        document.documentElement.classList.remove('menu-open');
    }

    ['click', 'touchstart'].forEach(event => {
        burger.addEventListener(event, openMenu, { passive: true });
        if (closeBtn) closeBtn.addEventListener(event, closeMenu, { passive: true });
    });

    menu.addEventListener('click', (e) => {
        if (e.target === menu || e.target.classList.contains('mobile-menu-overlay')) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menuOpen) closeMenu();
    });

    // Додатковий CSS для блокування скролу
    const scrollBlockStyle = document.createElement('style');
    scrollBlockStyle.textContent = `
        body.menu-open, html.menu-open {
            overflow: hidden !important;
            position: fixed !important;
            width: 100% !important;
            height: 100% !important;
        }
    `;
    document.head.appendChild(scrollBlockStyle);
})();
</script>
