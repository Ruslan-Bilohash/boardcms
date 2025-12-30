<?php
// admin/moderate.php — Обработка действий

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? '';
$id = basename($_GET['id'] ?? '');

if (!$id || !preg_match('/^[0-9]{8}_[0-9]{6}_[a-f0-9]{6}\.json$/', $id)) {
    header('Location: index.php?msg=Неправильний ідентифікатор');
    exit;
}

$file = __DIR__ . '/../ads/' . $id;
if (!file_exists($file)) {
    header('Location: index.php?msg=Оголошення не знайдено');
    exit;
}

$data = json_decode(file_get_contents($file), true);
if (!$data) {
    header('Location: index.php?msg=Пошкоджений файл');
    exit;
}

switch ($action) {
    case 'approve':
        $data['status'] = 'approved';
        $data['moderated_at'] = date('c');
        break;
    case 'reject':
        $data['status'] = 'rejected';
        $data['moderated_at'] = date('c');
        break;
    case 'delete':
        unlink($file);
        header('Location: index.php?msg=Оголошення видалено');
        exit;
    default:
        header('Location: index.php?msg=Невідома дія');
        exit;
}

if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    header('Location: index.php?msg=Не вдалося оновити статус');
    exit;
}

header('Location: index.php?msg=Статус змінено');
exit;