<?php
// includes/functions.php
// Набор полезных функций для работы с данными сайта
// Окончательная версия — 30 декабря 2025 года
// Автор: Ruslan Bilohash

/**
 * Получает все одобренные объявления из папки ads/
 *
 * @return array Массив объявлений с добавленным полем 'id' (имя файла)
 */
function getApprovedAds() {
    $ads = [];
    $dir = __DIR__ . '/../ads/';

    if (!is_dir($dir)) {
        return $ads; // Папка не существует — возвращаем пустой массив
    }

    $files = glob($dir . '*.json');
    if ($files === false) {
        return $ads; // Ошибка чтения директории
    }

    foreach ($files as $file) {
        $json = @file_get_contents($file);
        if ($json === false) {
            continue; // Не удалось прочитать файл
        }

        $ad = json_decode($json, true);
        if (!is_array($ad)) {
            continue; // Некорректный JSON
        }

        // Показываем только одобренные
        if (($ad['status'] ?? 'pending') === 'approved') {
            $ad['id'] = basename($file);
            $ads[] = $ad;
        }
    }

    // Сортировка: новые сверху (стабильная)
    usort($ads, function ($a, $b) {
        $dateA = $a['created_at'] ?? '1970-01-01T00:00:00Z';
        $dateB = $b['created_at'] ?? '1970-01-01T00:00:00Z';
        return strcmp($dateB, $dateA);
    });

    return $ads;
}

/**
 * Получает все объявления (независимо от статуса) — для админки
 *
 * @return array Массив всех объявлений
 */
function getAllAds() {
    $ads = [];
    $dir = __DIR__ . '/../ads/';

    if (!is_dir($dir)) {
        return $ads;
    }

    $files = glob($dir . '*.json');
    if ($files === false) {
        return $ads;
    }

    foreach ($files as $file) {
        $json = @file_get_contents($file);
        if ($json === false) {
            continue;
        }

        $ad = json_decode($json, true);
        if (!is_array($ad)) {
            continue;
        }

        $ad['id'] = basename($file);
        $ads[] = $ad;
    }

    // Сортировка: новые сверху
    usort($ads, function ($a, $b) {
        $dateA = $a['created_at'] ?? '1970-01-01T00:00:00Z';
        $dateB = $b['created_at'] ?? '1970-01-01T00:00:00Z';
        return strcmp($dateB, $dateA);
    });

    return $ads;
}

/**
 * Получает все новости/события из папки news/
 *
 * @return array Массив новостей
 */
function getNews() {
    $news = [];
    $dir = __DIR__ . '/../news/';

    if (!is_dir($dir)) {
        return $news;
    }

    $files = glob($dir . '*.json');
    if ($files === false) {
        return $news;
    }

    foreach ($files as $file) {
        $json = @file_get_contents($file);
        if ($json === false) {
            continue;
        }

        $item = json_decode($json, true);
        if (!is_array($item)) {
            continue;
        }

        $item['id'] = basename($file);
        $news[] = $item;
    }

    // Сортировка: новые сверху
    usort($news, function ($a, $b) {
        $dateA = $a['created_at'] ?? '1970-01-01T00:00:00Z';
        $dateB = $b['created_at'] ?? '1970-01-01T00:00:00Z';
        return strcmp($dateB, $dateA);
    });

    return $news;
}

/**
 * Сохраняет объявление в JSON-файл (резервное сохранение)
 *
 * @param array $data Данные объявления
 * @return string|bool Имя файла при успехе, false при ошибке
 */
function saveAdToJson($data) {
    $ads_dir = __DIR__ . '/../ads/';
    if (!is_dir($ads_dir)) {
        if (!mkdir($ads_dir, 0755, true)) {
            error_log("Не удалось создать директорию ads/");
            return false;
        }
    }

    $timestamp = date('Ymd_His');
    $random = substr(md5(uniqid(microtime(true), true)), 0, 6);
    $filename = $ads_dir . $timestamp . '_' . $random . '.json';

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($filename, $json) === false) {
        error_log("Не удалось записать файл: $filename");
        return false;
    }

    return basename($filename);
}

/**
 * Проверяет существование пользователя по логину (email/телефон)
 *
 * @param string $login Email или телефон
 * @return bool true — если существует
 */
function userExists($login) {
    $users_file = __DIR__ . '/../data/users.json';
    if (!file_exists($users_file)) {
        return false;
    }

    $users = json_decode(file_get_contents($users_file), true) ?? [];
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

/**
 * Получает пользователя по логину
 *
 * @param string $login Email или телефон
 * @return array|null Данные пользователя или null
 */
function getUserByLogin($login) {
    $users_file = __DIR__ . '/../data/users.json';
    if (!file_exists($users_file)) {
        return null;
    }

    $users = json_decode(file_get_contents($users_file), true) ?? [];
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return $user;
        }
    }
    return null;
}

/**
 * Добавляет нового пользователя в JSON-файл (для регистрации)
 *
 * @param string $name Имя
 * @param string $login Email или телефон
 * @param string $password Пароль (нехешированный)
 * @return bool true — успешно, false — ошибка
 */
function addUser($name, $login, $password) {
    $users_file = __DIR__ . '/../data/users.json';
    $users = file_exists($users_file) ? json_decode(file_get_contents($users_file), true) : [];

    // Проверка дублирования
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return false; // Пользователь уже существует
        }
    }

    $users[] = [
        'id'       => count($users) + 1,
        'name'     => $name,
        'login'    => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created'  => date('c')
    ];

    return file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/**
 * Авторизация пользователя (для login.php)
 *
 * @param string $login Email или телефон
 * @param string $password Пароль
 * @return array|bool Данные пользователя или false
 */
function loginUser($login, $password) {
    $users_file = __DIR__ . '/../data/users.json';
    if (!file_exists($users_file)) {
        return false;
    }

    $users = json_decode(file_get_contents($users_file), true) ?? [];
    foreach ($users as $user) {
        if ($user['login'] === $login && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}
