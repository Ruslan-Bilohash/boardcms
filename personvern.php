<?php
// personvern.php — Політика конфіденційності (Personvernerklæring)
// MapsMe Norway — Українці в Норвегії
// Актуально на: 30 грудня 2025 року

require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($texts['site_title'] ?? 'MapsMe Norway') ?> — Політика конфіденційності</title>
    
    <!-- Шрифти та стилі -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css?v=<?= time() ?>">
    
    <style>
        .privacy-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            line-height: 1.7;
            color: #333;
        }
        .privacy-container h1, .privacy-container h2 {
            color: #4361ee;
            margin-top: 2.5rem;
        }
        .privacy-container h1 {
            text-align: center;
            font-size: 2.4rem;
        }
        .privacy-container p, .privacy-container li {
            font-size: 1.05rem;
            margin-bottom: 1.2rem;
        }
        .section {
            margin-bottom: 2.5rem;
        }
        .update-date {
            text-align: center;
            color: #666;
            font-style: italic;
            margin-bottom: 3rem;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="privacy-container">
    <h1>Політика конфіденційності (Personvernerklæring)</h1>
    
    <div class="update-date">
        Останнє оновлення: 30 грудня 2025 року
    </div>

    <div class="section">
        <h2>1. Хто є контролером даних?</h2>
        <p>
            Контролером персональних даних є:  
            <strong>MapsMe Norway</strong>  
            Власник: Ruslan Bilohash  
            Email: rbilohash@gmail.com  
            Веб-сайт: https://mapsme.no
        </p>
        <p>
            Ми обробляємо ваші персональні дані відповідно до норвезького законодавства про захист даних (Personopplysningsloven) та Загального регламенту захисту даних ЄС (GDPR).
        </p>
    </div>

    <div class="section">
        <h2>2. Які дані ми збираємо?</h2>
        <p>Ми збираємо та обробляємо такі категорії персональних даних:</p>
        <ul>
            <li>Ім'я та контактні дані (email, телефон, Telegram/WhatsApp) — при додаванні оголошення або реєстрації</li>
            <li>IP-адреса та технічні дані (браузер, пристрій) — для безпеки та аналітики</li>
            <li>Геолокаційні дані (місто, координати) — якщо ви вказали їх в оголошенні</li>
            <li>Фотографії — якщо ви завантажили їх до оголошення</li>
            <li>Інформація з форми зворотного зв'язку (ім'я, email, текст повідомлення)</li>
        </ul>
    </div>

    <div class="section">
        <h2>3. Для яких цілей ми обробляємо ваші дані?</h2>
        <ul>
            <li>Публікація ваших оголошень на сайті та карті</li>
            <li>Модерація та перевірка оголошень</li>
            <li>Зв'язок з вами щодо оголошень або модерації</li>
            <li>Забезпечення безпеки сайту та запобігання зловживанням</li>
            <li>Відповіді на запити через форму зворотного зв'язку</li>
        </ul>
    </div>

    <div class="section">
        <h2>4. Правова основа обробки</h2>
        <p>Ми обробляємо ваші дані на підставі:</p>
        <ul>
            <li>Вашої згоди (GDPR ст. 6.1.a) — при завантаженні фото, контактів, згоди в формі</li>
            <li>Виконання договору (GDPR ст. 6.1.b) — публікація оголошення</li>
            <li>Законний інтерес (GDPR ст. 6.1.f) — модерація, безпека сайту</li>
        </ul>
    </div>

    <div class="section">
        <h2>5. Скільки часу ми зберігаємо дані?</h2>
        <ul>
            <li>Оголошення — до моменту видалення вами або нами (максимум 2 роки після останньої активності)</li>
            <li>Контактні дані з форми зворотного зв'язку — 6 місяців</li>
            <li>IP-адреса та логи — 30 днів</li>
        </ul>
    </div>

    <div class="section">
        <h2>6. Передача даних третім особам</h2>
        <p>Ми не продаємо ваші дані. Дані можуть передаватися:</p>
        <ul>
            <li>Хостинг-провайдеру (для зберігання сайту)</li>
            <li>Сервісу OpenStreetMap (карта — тільки координати та місто)</li>
            <li>Buy Me a Coffee (якщо ви донатите — тільки дані платежу)</li>
        </ul>
        <p>Всі треті сторони знаходяться в ЄС/ЄЕП або мають відповідні гарантії (Standard Contractual Clauses).</p>
    </div>

    <div class="section">
        <h2>7. Ваші права</h2>
        <p>Відповідно до GDPR ви маєте право:</p>
        <ul>
            <li>Отримати доступ до ваших даних</li>
            <li>Виправити неточні дані</li>
            <li>Видалити ваші дані (право бути забутим)</li>
            <li>Обмежити обробку</li>
            <li>Відкликати згоду</li>
            <li>Подати скаргу до Datatilsynet (www.datatilsynet.no)</li>
        </ul>
        <p>Щоб скористатися правами — пишіть на <strong>rbilohash@gmail.com</strong></p>
    </div>

    <div class="section">
        <h2>8. Cookies та трекери</h2>
        <p>Ми використовуємо тільки необхідні cookies (для роботи сайту) та аналітичні (Google Analytics, якщо ввімкнено). Деталі в нашому банері cookies. Ви можете відмовитися в будь-який момент.</p>
    </div>

    <div class="section">
        <h2>9. Зміни до політики</h2>
        <p>Ми можемо оновлювати цю політику. Нова версія буде опублікована на цій сторінці з датою оновлення.</p>
    </div>

    <div class="section">
        <h2>Контактна інформація</h2>
        <p>Якщо у вас є питання щодо обробки даних — пишіть:</p>
        <p><strong>Email:</strong> rbilohash@gmail.com</p>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>