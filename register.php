<?php
// register.php — Реєстрація (оновлено 30.12.2025 з виправленням збереження)

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /profile.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $login    = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    if (empty($name)) {
        $error = 'Вкажіть ім\'я';
    } elseif (empty($login)) {
        $error = 'Вкажіть email або телефон';
    } elseif (!filter_var($login, FILTER_VALIDATE_EMAIL) && !preg_match('/^\+47[0-9]{8}$/', $login)) {
        $error = 'Некоректний email або телефон (+47xxxxxxxxx)';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль мінімум 6 символів';
    } elseif ($password !== $confirm) {
        $error = 'Паролі не співпадають';
    } else {
        // Шлях до файлу — використовуємо абсолютний для надійності
        $users_file = $_SERVER['DOCUMENT_ROOT'] . '/data/users.json';

        // Перевірка, чи можемо писати в папку
        $data_dir = dirname($users_file);
        if (!is_dir($data_dir)) {
            if (!mkdir($data_dir, 0755, true)) {
                $error = 'Не вдалося створити папку data/. Перевірте права доступу.';
            }
        }

        if (!$error && !is_writable($data_dir)) {
            $error = 'Папка data/ недоступна для запису. Встановіть права 755 або 777.';
        } else {
            $users = file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];

            // Перевірка дублювання
            foreach ($users as $user) {
                if ($user['login'] === $login) {
                    $error = 'Такий email або телефон вже зареєстрований';
                    break;
                }
            }

            if (!$error) {
                $users[] = [
                    'id'       => count($users) + 1,
                    'name'     => $name,
                    'login'    => $login,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'created'  => date('c')
                ];

                // Спроба збереження
                if (file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                    $success = 'Реєстрація успішна! Тепер ви можете <a href="/login.php">увійти</a>.';
                } else {
                    $error = 'Помилка збереження даних. Перевірте права на файл/папку data/.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація — MapsMe Norway</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="/css/main.css?v=<?= time() ?>">
    <style>
        body { background: linear-gradient(135deg, #f0f4ff, #e6f0ff); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .register-box { background:white; border-radius:24px; box-shadow:0 20px 50px rgba(67,97,238,0.18); padding:3rem 2.5rem; width:100%; max-width:480px; margin:1rem; }
        .register-logo { width:90px; height:90px; background:linear-gradient(135deg,#4361ee,#ff006e); border-radius:50%; display:grid; place-items:center; color:white; font-size:2.8rem; margin:0 auto 1.2rem; box-shadow:0 10px 30px rgba(67,97,238,0.35); }
        .register-title { font-family:'Playfair Display',serif; font-size:2.4rem; color:#2b2d42; text-align:center; margin:0 0 0.5rem; }
        .error-msg { background:#ffebee; color:#c62828; padding:0.9rem; border-radius:10px; margin-bottom:1.5rem; text-align:center; }
        .success-msg { background:#d4edda; color:#155724; padding:0.9rem; border-radius:10px; margin-bottom:1.5rem; text-align:center; }
        .form-group { margin-bottom:1.6rem; position:relative; }
        .form-group input { width:100%; padding:1.1rem 1.2rem 1.1rem 3.5rem; border:1px solid #ddd; border-radius:12px; font-size:1rem; }
        .form-group i { position:absolute; left:1.2rem; top:50%; transform:translateY(-50%); color:#8d99ae; }
        .btn-register { width:100%; padding:1.2rem; background:linear-gradient(135deg,#28a745,#218838); color:white; border:none; border-radius:12px; font-size:1.15rem; font-weight:600; cursor:pointer; }
    </style>
</head>
<body>

<div class="register-box">
    <div class="register-header">
        <div class="register-logo"><i class="fa-solid fa-mountain-sun"></i></div>
        <h1 class="register-title">Реєстрація</h1>
    </div>

    <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success-msg"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="name">Ім'я</label>
            <i class="fas fa-user"></i>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="login">Email або телефон (+47)</label>
            <i class="fas fa-envelope"></i>
            <input type="text" id="login" name="login" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm">Підтвердіть пароль</label>
            <i class="fas fa-lock"></i>
            <input type="password" id="confirm" name="confirm" required>
        </div>

        <button type="submit" class="btn-register">Зареєструватися</button>
    </form>

    <div style="text-align:center; margin-top:1.8rem; color:#8d99ae;">
        Вже є акаунт? <a href="/login.php" style="color:#4361ee; font-weight:600;">Увійти</a>
    </div>
</div>

</body>
</html>