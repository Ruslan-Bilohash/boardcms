<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// index.php — головна сторінка (повна версія, 29.12.2025)

require_once 'config.php';
require_once 'includes/functions.php';
// Отримання схвалених оголошень з БД
$approved_ads = getApprovedAds($pdo);
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <!-- Виправлений viewport для iPhone 16 Pro Max (немає масштабування) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title><?= e($texts['site_title']) ?> — <?= e($texts['site_subtitle']) ?></title>

    <!-- Шрифти -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Іконки -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <!-- Головний CSS -->
    <link rel="stylesheet" href="/css/main.css?v=<?= time() ?>">

    <!-- Cookie Consent -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" defer></script>

    <script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": { "popup": { "background": "#1e1e2f" }, "button": { "background": "#28a745" } },
            "position": "bottom-left",
            "content": {
                "message": "Ми використовуємо cookies для покращення роботи сайту",
                "dismiss": "Прийняти",
                "link": "Детальніше",
                "href": "/personvern.php"
            }
        });
    });
    </script>
</head>
<body>

<?php include 'header.php'; ?>

<?php
$banner_text = [
    'ua' => 'Сайт у розробці — вже скоро на повну потужність!',
    'en' => 'Website under development — coming soon at full power!',
    'no' => 'Nettsiden er under utvikling — snart full funksjon!'
][$current_lang];
?>

<div class="banner" style="background:#ff6b35; color:white; text-align:center; padding:14px; font-weight:bold; font-size:18px;">
    <?= $banner_text ?>
</div>


 <!-- У index.php або де виводяться плитки -->

<div class="tiles" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin: 4rem 0;">
    <?php
    $categories = [
        'ua' => [
            ['name' => 'Майстри',      'icon' => 'fa-wrench',        'color' => '#4361ee'],
            ['name' => 'Краса',        'icon' => 'fa-scissors',      'color' => '#ff006e'],
            ['name' => 'Авто',         'icon' => 'fa-car-side',      'color' => '#06d6a0'],
            ['name' => 'Нерухомість',  'icon' => 'fa-house-chimney', 'color' => '#f39c12'],
            ['name' => 'Подорожі',     'icon' => 'fa-plane-departure','color' => '#8e44ad'],
            ['name' => 'Коло мене',    'icon' => 'fa-location-crosshairs', 'color' => '#e74c3c']
        ],
        'en' => [
            ['name' => 'Masters',      'icon' => 'fa-wrench',        'color' => '#4361ee'],
            ['name' => 'Beauty',       'icon' => 'fa-scissors',      'color' => '#ff006e'],
            ['name' => 'Cars',         'icon' => 'fa-car-side',      'color' => '#06d6a0'],
            ['name' => 'Real Estate',  'icon' => 'fa-house-chimney', 'color' => '#f39c12'],
            ['name' => 'Travel',       'icon' => 'fa-plane-departure','color' => '#8e44ad'],
            ['name' => 'Near Me',      'icon' => 'fa-location-crosshairs', 'color' => '#e74c3c']
        ],
        'no' => [
            ['name' => 'Håndverkere',  'icon' => 'fa-wrench',        'color' => '#4361ee'],
            ['name' => 'Skjønnhet',    'icon' => 'fa-scissors',      'color' => '#ff006e'],
            ['name' => 'Biler',        'icon' => 'fa-car-side',      'color' => '#06d6a0'],
            ['name' => 'Eiendom',      'icon' => 'fa-house-chimney', 'color' => '#f39c12'],
            ['name' => 'Reise',        'icon' => 'fa-plane-departure','color' => '#8e44ad'],
            ['name' => 'Nær meg',      'icon' => 'fa-location-crosshairs', 'color' => '#e74c3c']
        ]
    ][$current_lang];
    ?>

    <?php foreach ($categories as $cat): ?>
        <a href="#" class="tile" style="background:white; padding:2rem 1rem; text-align:center; border-radius:16px; text-decoration:none; color:#333; box-shadow:0 8px 25px rgba(0,0,0,0.08); transition:all 0.3s ease;">
            <i class="fa-solid <?= $cat['icon'] ?>" style="font-size:3.2rem; margin-bottom:1rem; color:<?= $cat['color'] ?>;"></i>
            <div style="font-weight:600; font-size:1.1rem;"><?= $cat['name'] ?></div>
        </a>
    <?php endforeach; ?>
</div>
<div class="container">
<a href="/news_add.php" style="
    display: inline-block;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #4361ee, #3a56d4);
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.2rem;
    box-shadow: 0 8px 25px rgba(67,97,238,0.3);
    transition: all 0.3s;
    margin: 2rem 0;
">
    <i class="fas fa-newspaper"></i> <?= e($texts['add_news'] ?? 'Опублікувати новину / подію') ?>
</a> <?php include 'print-text.php'; ?>
<?php include 'app_norway.php'; ?>
<?php include 'app_norway2.php'; ?>
<?php include 'news-section.php'; ?>
    <?php include 'map-section.php'; ?>
   
    <?php include 'ads-section.php'; ?>


</div>


<!-- Buy Me a Coffee віджет -->
<script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="bilohash" data-description="Support me on Buy me a coffee!" data-message="Дякую за підтримку! ❤️" data-color="#FF813F" data-position="Right" data-x_margin="18" data-y_margin="18"></script>

<?php include 'modal-add.php'; ?>
<?php include 'footer.php'; ?>
<script>
    // Автоматичне визначення місця розташування
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                console.log('Ваше місце: ', lat, lng);
                // Можна передати в форму або карту
                // document.getElementById('lat').value = lat;
                // document.getElementById('lng').value = lng;
            },
            (error) => {
                console.log('Геолокація відключена або помилка: ', error.message);
            }
        );
    } else {
        console.log('Геолокація не підтримується вашим браузером');
    }
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([64.686313, 12.013787], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

const places = <?= json_encode(array_map(function($ad) {
    return [
        'title'   => $ad['title'] ?? 'Оголошення',
        'city'    => $ad['city'] ?? '',
        'price'   => $ad['price'] ?? '',
        'photo'   => $ad['photo'] ?? null,
        'lat'     => $ad['lat'] ?? null,
        'lng'     => $ad['lng'] ?? null,
        'contact' => $ad['contact'] ?? ''
    ];
}, getApprovedAds())) ?>;

places.forEach(p => {
    if (p.lat && p.lng) {
        let popup = `<b>${p.title}</b><br>${p.city}<br><b>Ціна:</b> ${p.price}`;
        if (p.contact) popup += `<br><b>Контакт:</b> ${p.contact}`;
        if (p.photo) popup += `<br><img src="${p.photo}" style="max-width:220px;border-radius:8px;margin-top:8px;">`;
        L.marker([p.lat, p.lng]).addTo(map).bindPopup(popup);
    }
});

function openModal(){document.getElementById('addModal').style.display='block'}
function closeModal(){document.getElementById('addModal').style.display='none'}
window.onclick = e => { if(e.target.classList.contains('modal')) closeModal() }
</script>
</body>
</html>
