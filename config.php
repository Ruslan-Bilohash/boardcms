<?php
// config.php — Конфігурація сайту

define('SITE_NAME', 'Board CMS Norway Script Free (Free Norway Classifieds Script)');
define('SITE_URL',  'https://mapsme.no');

// Мови
$available_langs = [
    'ua' => ['name' => 'Українська', 'flag' => '🇺🇦'],
    'en' => ['name' => 'English',    'flag' => '🇬🇧'],
    'no' => ['name' => 'Norsk',      'flag' => '🇳🇴']
];

$current_lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'ua');

if (!array_key_exists($current_lang, $available_langs)) {
    $current_lang = 'ua';
}

setcookie('lang', $current_lang, time() + (86400 * 30), '/', '', false, true);

// Завантаження перекладів
$lang_file = __DIR__ . '/lang/' . $current_lang . '.php';
if (!file_exists($lang_file)) {
    $lang_file = __DIR__ . '/lang/ua.php';
}

$texts = include $lang_file;

// Функція екранування
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}