**Готовий повний опис проєкту для GitHub (README.md)**  
(Версія 1.3 — 12 лютого 2026)

Скопіюйте весь текст нижче і вставте у свій `README.md`

---

# 📋 **Board CMS v1.3** — Скрипт Дошка оголошень

**Повністю безкоштовний відкритий скрипт дошки оголошень** з інтерактивною картою, новинами, модерацією та сучасною адмін-панеллю.

**Дата оновлення:** 12 лютого 2026  
**Версія PHP:** 8.1+ (рекомендовано 8.2+)  
**База даних:** MySQL 5.7+ / MariaDB 10.5+  
**Розробник:** Ruslan Bilohash (rbilohash@gmail.com)  
**Ліцензія:** MIT License

---

### 🇺🇦 Українська версія

**Загальний огляд**  
Board CMS — це сучасний, швидкий і повністю безкоштовний скрипт дошки оголошень. Створений для швидкого запуску локальних дощок оголошень, бізнес-каталогів, дощок для спільнот тощо. Має вбудовану інтерактивну карту, багатомовні новини, повноцінну адмін-панель і підтримку 3 мов.

**Основні можливості**
- Додавання оголошень (4 типи: Майстер/Послуга, Продам/Куплю, Подія/Зустріч, Інше)
- Інтерактивна карта з маркерами оголошень (Leaflet + OpenStreetMap)
- Новини та події з повною підтримкою 3 мов (окремі заголовки та тексти)
- Реєстрація та особистий кабінет користувача
- Адмін-панель з модерацією оголошень і новин
- Повна локалізація інтерфейсу: Українська · English · Norsk
- GDPR-сумісність + політика конфіденційності
- Автоматичне визначення координат при додаванні оголошення
- Адаптивний сучасний дизайн (мобільний + десктоп)
- CAPTCHA, cookie-банер, захист від brute-force

**Структура проєкту**

```
boardcms/
├── admin/                  ← Адмін-панель (логін, головна, новини, оголошення)
├── lang/                   ← Переклади (ua.php, en.php, no.php)
├── uploads/ads/            ← Фото оголошень
├── uploads/news/           ← Фото новин
├── config.php              ← Основні налаштування + підключення БД
├── index.php               ← Головна сторінка сайту
├── add.php                 ← Форма додавання оголошення
├── process-add.php         ← Обробка оголошення
├── news-section.php        ← Блок новин на головній
├── ads-section.php         ← Блок оголошень на головній
├── map-section.php         ← Інтерактивна карта
├── about.php               ← Сторінка "Про нас" + демо адмінки
├── personvern.php          ← Політика конфіденційності
├── login.php / register.php / profile.php
├── header.php / footer.php
├── functions.php           ← Допоміжні функції
└── README.md
```

**Ключові модулі**

- **Головна сторінка** — карта, оголошення, новини, категорії
- **Додавання оголошень** — форма + автоматичне визначення координат
- **Новини та події** — підтримка 3 мов, модерація, фото
- **Адмін-панель** — повне керування сайтом (демо: admin / 12345)
- **Локалізація** — 3 мови (легко додати нові)
- **Користувачі** — реєстрація, вхід, особистий кабінет

---

### 🇬🇧 English Version

**General Overview**  
Board CMS is a modern, fast and completely free open-source bulletin board script. Designed for quick deployment of local ad boards, business directories and community boards. Includes interactive map, multilingual news, full admin panel and support for 3 languages.

**Main Features**
- Post ads (4 types: Services/Masters, Buy/Sell, Events/Meetings, Other)
- Interactive map with markers (Leaflet + OpenStreetMap)
- News & events with full 3-language support
- User registration and profile
- Admin panel with moderation
- Full interface localization: Ukrainian · English · Norsk
- GDPR compliant + privacy policy
- Automatic coordinate detection
- Fully responsive design

**Project Structure** — (same as above)

**Key Modules**
- Main page (map + ads + news)
- Ad submission form
- Multilingual news module
- Full admin panel
- 3-language localization system
- User system

---

### 🇳🇴 Norsk Versjon

**Generell Oversikt**  
Board CMS er en moderne, rask og helt gratis åpen kildekode-oppslagstavle. Laget for rask opprettelse av lokale annonsetavler, bedriftskataloger og fellesskapsnettsteder. Inneholder interaktivt kart, flerspråklige nyheter, full adminpanel og støtte for 3 språk.

**Hovedfunksjoner**
- Legge ut annonser (4 typer)
- Interaktivt kart med markører
- Nyheter og hendelser på 3 språk
- Brukerregistrering og profil
- Adminpanel med moderering
- Full lokalisering: Ukrainsk · English · Norsk
- GDPR-kompatibel
- Automatisk koordinatbestemmelse
- Responsivt design

**Prosjektstruktur** — (samme som over)

**Hovedmoduler**
- Hovedside (kart + annonser + nyheter)
- Skjema for å legge ut annonser
- Flerspråklig nyhetsmodul
- Full adminpanel
- 3-språk lokaliseringssystem
- Brukersystem

---

**Готовий до використання!**

Хочете, щоб я додав ще:
- Покрокову інструкцію встановлення?
- Вимоги до сервера?
- Скріншоти (опис для них)?

Напишіть — зроблю відразу.
