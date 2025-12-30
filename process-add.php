<?php
// process-add.php — обробка форми додавання оголошення
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'error' => 'Method Not Allowed']));
}

// Обов'язкові поля
$required = ['title', 'type', 'gdpr_consent'];
$data = [];
$errors = [];

foreach ($required as $field) {
    $data[$field] = trim($_POST[$field] ?? '');
    if ($data[$field] === '') {
        $errors[] = "Поле '$field' обов'язкове";
    }
}

if (!empty($errors)) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'errors' => $errors]));
}

// Додаткові поля (необов'язкові)
$data += [
    'description' => trim($_POST['description'] ?? ''),
    'city'        => trim($_POST['city'] ?? ''),
    'price'       => trim($_POST['price'] ?? ''),
    'contact'     => trim($_POST['contact'] ?? ''),
    'lat'         => floatval($_POST['lat'] ?? 0) ?: null,
    'lng'         => floatval($_POST['lng'] ?? 0) ?: null,
    'created_at'  => date('c'),
    'status'      => 'pending', // pending / approved / rejected
    'ip'          => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
];

// Обробка завантаження фото
$photo_path = null;
if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/ads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $allowed)) {
        $filename = date('Ymd_His') . '_' . uniqid() . '.' . $ext;
        $target = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $photo_path = '/' . $target;
        } else {
            $errors[] = 'Не вдалося завантажити фото';
        }
    } else {
        $errors[] = 'Дозволені формати фото: jpg, jpeg, png, gif';
    }
}
$data['photo'] = $photo_path;

// Збереження в JSON-файл
$ads_dir = 'ads/';
if (!is_dir($ads_dir)) {
    mkdir($ads_dir, 0755, true);
}

$timestamp = date('Ymd_His');
$random = substr(md5(uniqid()), 0, 6);
$filename = $ads_dir . $timestamp . '_' . $random . '.json';

$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($filename, $json) === false) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'error' => 'Не вдалося зберегти оголошення']));
}

// Успіх
echo json_encode([
    'success' => true,
    'message' => 'Оголошення додано безкоштовно! Після модерації з’явиться на сайті та карті.'
]);