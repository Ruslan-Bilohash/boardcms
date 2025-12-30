<?php
// admin/login.php — Форма входа

session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Замените на свои данные!
    if ($login === 'admin' && $password === 'supersecret123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неправильний логін або пароль';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід в адмінку</title>
    <style>
        body { font-family: 'Manrope', sans-serif; background:#f0f4ff; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
        .login-box { background:white; padding:3rem; border-radius:16px; box-shadow:0 20px 50px rgba(0,0,0,0.15); max-width:400px; width:90%; text-align:center; }
        h2 { color:#4361ee; margin-bottom:2rem; }
        input { width:100%; padding:1rem; margin:1rem 0; border:1px solid #ddd; border-radius:10px; font-size:1.1rem; }
        button { width:100%; padding:1rem; background:#4361ee; color:white; border:none; border-radius:10px; font-size:1.1rem; cursor:pointer; }
        .error { color:#e74c3c; margin:1rem 0; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Вхід в адмін-панель</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="login" placeholder="Логін" required autofocus>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Увійти</button>
        </form>
    </div>
</body>
</html>