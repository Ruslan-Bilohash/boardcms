<?php
// admin/index.php — Главная страница админ-панели

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Подключаем конфиг и функции из корня
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions.php';

// Получаем все объявления (не только approved)
$all_ads = [];
$dir = __DIR__ . '/../ads/';
if (is_dir($dir)) {
    $files = glob($dir . '*.json');
    foreach ($files as $file) {
        $json = @file_get_contents($file);
        if ($json === false) continue;
        $ad = json_decode($json, true);
        if (!is_array($ad)) continue;
        $ad['id'] = basename($file);
        $all_ads[] = $ad;
    }
}

// Сортировка: новые сверху
usort($all_ads, function($a, $b) {
    return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
});

$message = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель — MapsMe Norway</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body { font-family: 'Manrope', sans-serif; background:#f8f9fc; color:#333; margin:0; padding:0; }
        .container { max-width:1200px; margin:3rem auto; padding:0 1.5rem; }
        h1 { color:#4361ee; text-align:center; margin-bottom:2rem; }
        .logout { float:right; color:#e74c3c; font-weight:600; text-decoration:none; }
        .msg { padding:1rem; border-radius:8px; margin-bottom:1.5rem; text-align:center; background:#d4edda; color:#155724; }
        table { width:100%; border-collapse:collapse; background:white; box-shadow:0 8px 30px rgba(0,0,0,0.1); border-radius:12px; overflow:hidden; }
        th, td { padding:1.2rem; text-align:left; border-bottom:1px solid #eee; }
        th { background:#4361ee; color:white; }
        tr:hover { background:#f8f9fa; }
        .status-pending  { color:#f39c12; font-weight:bold; }
        .status-approved { color:#27ae60; font-weight:bold; }
        .status-rejected { color:#c0392b; font-weight:bold; }
        .btn { padding:0.6rem 1.2rem; border-radius:8px; color:white; text-decoration:none; margin-right:0.5rem; font-size:0.9rem; }
        .btn-approve { background:#27ae60; }
        .btn-reject  { background:#e74c3c; }
        .btn-delete  { background:#7f8c8d; }
    </style>
</head>
<body>

<div class="container">
    <h1>Адмін-панель — Модерація оголошень</h1>
    <a href="logout.php" class="logout">Вийти <i class="fas fa-sign-out-alt"></i></a>

    <?php if ($message): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($all_ads)): ?>
        <p style="text-align:center; color:#666;">Немає оголошень для модерації</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Заголовок</th>
                    <th>Місто</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_ads as $ad): ?>
                    <tr>
                        <td><?= date('d.m.Y H:i', strtotime($ad['created_at'] ?? '')) ?></td>
                        <td><?= e($ad['title'] ?? '—') ?></td>
                        <td><?= e($ad['city'] ?? '—') ?></td>
                        <td class="status-<?= $ad['status'] ?? 'pending' ?>">
                            <?= $ad['status'] === 'approved' ? 'Схвалено' : ($ad['status'] === 'rejected' ? 'Відхилено' : 'На модерації') ?>
                        </td>
                        <td>
                            <?php if (($ad['status'] ?? 'pending') !== 'approved'): ?>
                                <a href="moderate.php?action=approve&id=<?= urlencode($ad['id']) ?>" class="btn btn-approve">Схвалити</a>
                            <?php endif; ?>

                            <?php if (($ad['status'] ?? 'pending') !== 'rejected'): ?>
                                <a href="moderate.php?action=reject&id=<?= urlencode($ad['id']) ?>" class="btn btn-reject">Відхилити</a>
                            <?php endif; ?>

                            <a href="moderate.php?action=delete&id=<?= urlencode($ad['id']) ?>" class="btn btn-delete" onclick="return confirm('Ви дійсно хочете видалити?')">Видалити</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>
</body>
</html>