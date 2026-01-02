
Краткое описание каждого файла

index.php — точка входа, собирает всю страницу
config.php — константы, языки, подключение переводов, функция e()
functions.php — функции работы с данными (объявления, новости, сохранение)
header.php — шапка (логотип, навигация, кнопки, флаги языков, бургер-меню)
footer.php — футер (донат, GitHub, скачивание, форма обратной связи, правила)
modal-add.php — модалка добавления объявления
map-section.php — блок карты
news-section.php — блок новостей
ads-section.php — блок доски объявлений
process-add.php — обработка POST-запроса от модалки (сохранение JSON + фото)
login.php — вход (email / телефон +47)
register.php — регистрация
personvern.php — политика конфиденциальности (GDPR + норвежский)
css/main.css — все стили в одном файле
lang/ua.php, en.php, no.php — переводы (полные)
ads/ — хранилище JSON-объявлений
uploads/ads/ — хранилище фото

Как это работает

Все файлы лежат в корне (кроме css/ и lang/)
Подключения простые: include 'header.php';, require_once 'config.php';
Нет папки includes/ — всё в корне для удобства
Полная мультиязычность (UA/EN/NO) через $texts
Адаптивность (бургер-меню, флаги языков) — работает на iPhone 16 Pro Max и Android

# MapsMe Norway —

**Безкоштовна платформа для українців у Норвегії** — місце, де можна швидко знайти/розмістити оголошення про:
- роботу
- житло
- авто
- послуги
- майстрів
- подорожі
- події та зустрічі

### Основні можливості
- Додавання оголошень **безкоштовно** та без реєстрації
- Автоматична модерація перед публікацією
- Відображення оголошень на **карті Норвегії** (Leaflet + OpenStreetMap)
- Мультимовність: українська, англійська, норвезька
- Повна адаптивність (iPhone, Android, десктоп)
- Завантаження фото до оголошень
- GDPR-сумісна згода на cookies
- Плаваючий донат-віджет Buy Me a Coffee
- Форма зворотного зв'язку (на мою пошту)

### Для кого цей проєкт?
Для українців, які живуть, працюють або планують переїзд до Норвегії.  
Це зручний інструмент, щоб швидко знайти помічника, житло, роботу або просто познайомитись з іншими українцями.

### Технології
- PHP 8+
- JSON-файли для зберігання оголошень (без бази даних на старті)
- Leaflet.js + OpenStreetMap (карта)
- Font Awesome 6 (іконки)
- CookieConsent (GDPR-сумісний банер)
- Адаптивний дизайн (Mobile First)

### Як запустити у себе?

1. Клонуйте репозиторій:
   ```bash
   git clone https://github.com/Ruslan-Bilohash/boardcms.git

**MapsMe Norway** is a **completely free** platform created especially for Ukrainians living, working, or planning to move to Norway.

Find and post ads quickly and easily:
- Jobs & Work
- Housing & Rentals
- Cars & Vehicles
- Services & Masters
- Beauty & Personal Care
- Travel & Trips
- Events & Community Meetups

### Key Features
- **100% Free** — no hidden fees, no premium features
- Post ads without mandatory registration
- All ads go through **quick moderation** before publishing
- Automatic display on an interactive **map of Norway** (Leaflet + OpenStreetMap)
- Full multilingual support: Ukrainian, English, Norwegian (Bokmål)
- Mobile-first, 100% responsive design (perfect for iPhone & Android)
- Photo upload for ads
- GDPR-compliant cookie consent banner
- Floating "Buy Me a Coffee" donation widget
- Feedback form directly to the developer

### Technologies Used
- PHP 8+ (flat-file, JSON-based — no database required at start)
- Leaflet.js + OpenStreetMap (interactive map)
- Font Awesome 6 (icons)
- CookieConsent (GDPR-compliant)
- Fully responsive & mobile-friendly



### How to Run Locally / on Your Server

1. Clone the repository:
   ```bash
   git clone https://github.com/Ruslan-Bilohash/boardcms.git
