<header class="header" style="background:#ffffff; padding:1.5rem 0; box-shadow:0 4px 20px rgba(0,0,0,0.06); position:sticky; top:0; z-index:1000;">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.5rem;">

            <!-- Логотип + кнопка ДОДАТИ зліва -->
            <div style="display:flex; align-items:center; gap:2rem; flex-wrap:wrap;">
                <a href="/" style="display:flex; align-items:center; gap:16px; text-decoration:none; color:#4361ee;">
                    <div style="width:60px; height:60px; background:linear-gradient(135deg,#4361ee,#ff006e); border-radius:18px; display:grid; place-items:center; color:white; font-size:1.8rem;">
                        <i class="fa-solid fa-mountain-sun"></i>
                    </div>
                    <div>
                        <span style="font-family:'Playfair Display',serif; font-weight:800; font-size:2rem; display:block;">Mapsme</span>
                        <span style="font-size:1rem; opacity:0.8; letter-spacing:2px;">Board CMS</span>
                    </div>
                </a>

                <button onclick="openModal()" style="padding:0.9rem 1.8rem; font-size:1.1rem; background:#28a745; color:white; border:none; border-radius:50px; cursor:pointer; font-weight:600; box-shadow:0 4px 12px rgba(40,167,69,0.25);">
                    <i class="fas fa-plus-circle"></i> <?= e($texts['add_free']) ?>
                </button>
            </div>

            <!-- Навігація -->
            <nav style="display:flex; gap:2rem; justify-content:center; flex:1;">
                <a href="#robota" style="color:#2b2d42; text-decoration:none; font-weight:600;"><i class="fa-solid fa-briefcase"></i> Робота</a>
                <a href="#zhytlo" style="color:#2b2d42; text-decoration:none; font-weight:600;"><i class="fa-solid fa-home"></i> Житло</a>
                <a href="#avto" style="color:#2b2d42; text-decoration:none; font-weight:600;"><i class="fa-solid fa-car"></i> Авто</a>
            </nav>

            <!-- Права частина: Вхід + Флаги мов -->
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/profile.php" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= $_SESSION['user_id'] ?>" alt="Профіль" style="width:44px;height:44px;border-radius:50%;border:3px solid #4361ee;">
                    </a>
                <?php else: ?>
                    <a href="/login.php" style="background:transparent; color:#4361ee; border:2px solid #4361ee; padding:0.8rem 1.8rem; border-radius:50px; text-decoration:none; font-weight:600;">Увійти</a>
                <?php endif; ?>

               <!-- Прапорці мов -->
            <div class="lang-switch" style="display:flex; gap:1rem; align-items:center;">
                <?php foreach ($available_langs as $code => $lang): ?>
                    <a href="?lang=<?= $code ?>" title="<?= $lang['name'] ?>" class="lang-flag <?= $current_lang === $code ? 'active' : '' ?>" style="font-size:1.8rem; text-decoration:none; transition:transform 0.2s ease;">
                        <?= $lang['flag'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
                </div>
            </div>
        </div>
    </div>
</header>