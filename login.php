<?php
// login.php — Вхід через телефон (+47) або email (оновлено 29.12.2025)

session_start();

// Якщо вже залогінений — на профіль
if (isset($_SESSION['user_id'])) {
    header("Location: /profile.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login'] ?? '');      // email або телефон
    $password = trim($_POST['password'] ?? '');

    // Тимчасова логіка (замініть на справжню перевірку в БД або файлі)
    // Приклад: телефон +47xxxxxxxxx або email
    if (preg_match('/^(\+47)?[0-9]{8}$/', $login) || filter_var($login, FILTER_VALIDATE_EMAIL)) {
        if ($password === '123456') { // ТИМЧАСОВИЙ ТЕСТОВИЙ ПАРОЛЬ — ЗАМІНІТЬ!!!
            $_SESSION['user_id'] = 1;
            $_SESSION['user_login'] = $login;
            header("Location: /profile.php");
            exit;
        } else {
            $error = 'Неправильний пароль';
        }
    } else {
        $error = 'Введіть коректний email або норвезький номер телефону (+47xxxxxxxxx)';
    }
}
$title = [
    'ua' => 'Увійти — MapsMe Norway',
    'en' => 'Login — MapsMe Norway',
    'no' => 'Logg inn — MapsMe Norway'
][$current_lang];

$welcome = [
    'ua' => 'Вітаємо на MapsMe Norway!',
    'en' => 'Welcome to MapsMe Norway!',
    'no' => 'Velkommen til MapsMe Norway!'
][$current_lang];

$email_label = [
    'ua' => 'Email',
    'en' => 'Email',
    'no' => 'E-post'
][$current_lang];

$phone_label = [
    'ua' => 'Телефон (+47)',
    'en' => 'Phone (+47)',
    'no' => 'Telefon (+47)'
][$current_lang];

$password_label = [
    'ua' => 'Пароль',
    'en' => 'Password',
    'no' => 'Passord'
][$current_lang];

$login_btn = [
    'ua' => 'Увійти',
    'en' => 'Log in',
    'no' => 'Logg inn'
][$current_lang];

$no_account = [
    'ua' => 'Немає акаунту?',
    'en' => 'No account yet?',
    'no' => 'Ingen konto ennå?'
][$current_lang];

$register_link = [
    'ua' => 'Зареєструватися',
    'en' => 'Register',
    'no' => 'Registrer deg'
][$current_lang];
?>



<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід — MapsMe Norway</title>

    <!-- Шрифти -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Основний стиль сайту -->
    <link rel="stylesheet" href="/css/main.css?v=<?= time() ?>">

    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Manrope', sans-serif;
        }

        .login-box {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(67,97,238,0.18);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 460px;
            margin: 1rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease;
        }

        .login-box:hover {
            transform: translateY(-8px);
        }

        .login-logo {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #4361ee, #ff006e);
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: white;
            font-size: 2.8rem;
            margin: 0 auto 1.2rem;
            box-shadow: 0 10px 30px rgba(67,97,238,0.35);
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            color: #2b2d42;
            text-align: center;
            margin: 0 0 0.5rem;
        }

        .login-subtitle {
            text-align: center;
            color: #8d99ae;
            font-size: 1.05rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.6rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            color: #2b2d42;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 1.1rem 1.2rem 1.1rem 3.5rem;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67,97,238,0.15);
        }

        .form-group i {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8d99ae;
            font-size: 1.2rem;
        }

        .btn-login {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(67,97,238,0.35);
        }

        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 0.9rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
        }

        .toggle-login {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .toggle-btn {
            padding: 0.7rem 1.4rem;
            border: 2px solid #ddd;
            border-radius: 50px;
            background: transparent;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            background: #4361ee;
            color: white;
            border-color: #4361ee;
        }

        .register-link {
            text-align: center;
            margin-top: 1.8rem;
            color: #8d99ae;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #4361ee;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-header">
        <div class="login-logo">
            <i class="fa-solid fa-mountain-sun"></i>
        </div>
        <h1 class="login-title">Вхід</h1>
        <p class="login-subtitle">Вітаємо на MapsMe Norway!</p>
    </div>
	

               <!-- Прапорці мов -->
            <div class="lang-switch" style="display:flex; gap:1rem; align-items:center;">
                <?php foreach ($available_langs as $code => $lang): ?>
                    <a href="?lang=<?= $code ?>" title="<?= $lang['name'] ?>" class="lang-flag <?= $current_lang === $code ? 'active' : '' ?>" style="font-size:1.8rem; text-decoration:none; transition:transform 0.2s ease;">
                        <?= $lang['flag'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
    <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Перемикач: Email / Телефон -->
    <div class="toggle-login">
        <button class="toggle-btn active" data-type="email">Email</button>
        <button class="toggle-btn" data-type="phone">Телефон (+47)</button>
    </div>

    <form method="POST" id="loginForm">
        <div class="form-group" id="email-group">
            <label for="email">Email</label>
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="login" required placeholder="your@email.com" autocomplete="email">
        </div>

        <div class="form-group" id="phone-group" style="display:none;">
            <label for="phone">Телефон</label>
            <i class="fas fa-phone"></i>
            <input type="tel" id="phone" name="login" pattern="\+47[0-9]{8}|[0-9]{8}" placeholder="+47xxxxxxxxx" autocomplete="tel">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn-login">Увійти</button>
    </form>

    <div class="register-link">
        Немає акаунту? <a href="/register.php">Зареєструватися</a>
    </div>
</div>

<script>
    // Перемикач Email / Телефон
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const type = this.dataset.type;
            document.getElementById('email-group').style.display = type === 'email' ? 'block' : 'none';
            document.getElementById('phone-group').style.display = type === 'phone' ? 'block' : 'none';

            // Очищаємо поле login при зміні типу
            document.querySelector('input[name="login"]').value = '';
        });
    });

    // За замовчуванням — email активний
    document.querySelector('[data-type="email"]').click();
</script>

</body>
</html>