<footer style="
    background: linear-gradient(to top, #0f172a, #1e293b);
    color: #94a3b8;
    padding: clamp(1.5rem, 4vw, 2.5rem);
    margin-top: clamp(4rem, 10vw, 6rem);
    border-top: 1px solid #334155;
    font-size: clamp(0.85rem, 2vw, 0.95rem);
">
    <div style="
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: clamp(1.5rem, 4vw, 3rem);
        padding: 0 5%;
    ">
        <!-- Ліва частина -->
        <div style="display: flex; flex-direction: column; gap: 0.4rem; text-align: left;">
            <div>© <?= date('Y') ?> Board CMS — безкоштовний скрипт дошки оголошень</div>
            <div style="opacity: 0.7;">
                Швидкість: <strong><?= number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 3) ?> сек</strong>
                · Пам’ять: <strong><?= number_format(memory_get_peak_usage(true) / 1024 / 1024, 2) ?> MB</strong>
            </div>
        </div>

        <!-- Центр — перемикачі мов -->
        <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
            <div style="font-size: 0.85rem; opacity: 0.7;">Мова інтерфейсу</div>
            <div style="display: flex; gap: 0.6rem;">
                <a href="?lang=ua" 
                   style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s; border: 2px solid <?= $current_lang === 'ua' ? '#60a5fa' : 'transparent' ?>;"
                   title="Українська">
                    🇺🇦
                </a>
                <a href="?lang=en" 
                   style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s; border: 2px solid <?= $current_lang === 'en' ? '#60a5fa' : 'transparent' ?>;"
                   title="English">
                    🇬🇧
                </a>
                <a href="?lang=no" 
                   style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s; border: 2px solid <?= $current_lang === 'no' ? '#60a5fa' : 'transparent' ?>;"
                   title="Norsk">
                    🇳🇴
                </a>
            </div>
        </div>

        <!-- Права частина — посилання -->
        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center;">
            <a href="https://github.com/Ruslan-Bilohash/boardcms" target="_blank" rel="noopener noreferrer" style="color:#60a5fa;text-decoration:none;font-weight:600;display:flex;align-items:center;gap:0.5rem;transition:all 0.3s;">
                <i class="fab fa-github" style="font-size:1.4rem;"></i> GitHub
            </a>
            <a href="https://github.com/Ruslan-Bilohash/boardcms/issues/new" target="_blank" rel="noopener noreferrer" style="color:#f59e0b;text-decoration:none;display:flex;align-items:center;gap:0.5rem;transition:all 0.3s;">
                <i class="fas fa-bug"></i> Повідомити про помилку
            </a>
            <a href="https://github.com/Ruslan-Bilohash/boardcms/releases" target="_blank" rel="noopener noreferrer" style="color:#10b981;text-decoration:none;display:flex;align-items:center;gap:0.5rem;transition:all 0.3s;">
                <i class="fas fa-code-branch"></i> Оновлення v1.3
            </a>
        </div>
    </div>

    <!-- Нижній рядок -->
    <div style="margin-top:1.2rem; opacity:0.6; font-size:0.85rem; text-align:center;">
        Зроблено українським ентузіастом · Розповсюджується вільно
    </div>
</footer>

<style>
    footer a:hover {
        color: white;
        transform: translateY(-2px);
    }
    @media (max-width: 768px) {
        footer > div:first-child {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        footer > div:first-child > div:first-child,
        footer > div:first-child > div:last-child {
            text-align: center;
        }
    }
    @media (max-width: 480px) {
        .lang-switch a { width: 32px; height: 32px; font-size: 1.4rem; }
    }
</style>