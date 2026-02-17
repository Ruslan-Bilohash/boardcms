-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 02 2026 г., 20:02
-- Версия сервера: 10.11.15-MariaDB
-- Версия PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Структура таблицы `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `currency` char(3) DEFAULT 'NOK',
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `status` enum('draft','pending','active','rejected','expired','deleted') DEFAULT 'pending',
  `views` int(10) UNSIGNED DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `published_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Оголошення користувачів';

-- --------------------------------------------------------

--
-- Структура таблицы `ad_images`
--

CREATE TABLE `ad_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ad_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `order` smallint(5) UNSIGNED DEFAULT 10,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Фотографії до оголошень';

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `name_ua` varchar(120) NOT NULL,
  `name_en` varchar(120) NOT NULL,
  `name_no` varchar(120) NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` smallint(5) UNSIGNED DEFAULT 10,
  `icon` varchar(100) DEFAULT NULL COMMENT 'Наприклад: fas fa-briefcase',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Категорії оголошень';

-- --------------------------------------------------------

--
-- Структура таблицы `moderation_log`
--

CREATE TABLE `moderation_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `moderator_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(80) NOT NULL COMMENT 'approve, reject, delete, edit, warn...',
  `target_type` varchar(50) NOT NULL COMMENT 'ad, user, news...',
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Журнал дій модераторів';

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ua` varchar(180) NOT NULL,
  `title_en` varchar(180) NOT NULL,
  `title_no` varchar(180) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `published_at` datetime DEFAULT NULL,
  `description_ua` mediumtext NOT NULL DEFAULT '',
  `description_en` mediumtext NOT NULL DEFAULT '',
  `description_no` mediumtext NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Новини, події, анонси';

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title_ua`, `title_en`, `title_no`, `content`, `event_date`, `location`, `lat`, `lng`, `photo`, `status`, `created_at`, `updated_at`, `published_at`, `description_ua`, `description_en`, `description_no`) VALUES
(5, 'Заголовок українською', '', '', NULL, NULL, NULL, NULL, NULL, '/uploads/news/news_1767368308_6957e674a5d15.jpg', 'published', '2026-01-02 16:38:28', '2026-01-02 16:55:24', NULL, '<p><span style=\"background-color: rgb(255, 255, 255); color: rgb(55, 65, 81);\">Текст новини українською&nbsp;</span><span style=\"background-color: rgb(255, 255, 255); color: rgb(239, 68, 68);\">★ обов’язково</span></p>', '', ''),
(6, 'Краєвиди норвегії', '', '', NULL, NULL, 'Trolltunga', NULL, NULL, '/uploads/news/news_1767377275_6958097b2b2a8.jpg', 'published', '2026-01-02 18:14:34', '2026-01-02 19:07:55', NULL, '<p>Краєвиди норвегії</p>', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Глобальні налаштування сайту';

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL COMMENT 'Ім’я користувача',
  `login` varchar(255) NOT NULL COMMENT 'Email або номер телефону',
  `password` varchar(255) NOT NULL COMMENT 'Хеш пароля',
  `role` enum('user','moderator','admin','superadmin') DEFAULT 'user',
  `status` enum('active','blocked','pending','deleted') DEFAULT 'active',
  `lang` varchar(10) DEFAULT 'ua' COMMENT 'Мова інтерфейсу: ua/en/no',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'Шлях до аватарки',
  `balance` decimal(10,2) DEFAULT 0.00 COMMENT 'Баланс у NOK (для майбутніх платних послуг)',
  `phone_verified` tinyint(1) DEFAULT 0 COMMENT 'Номер телефону верифіковано',
  `email_verified` tinyint(1) DEFAULT 0 COMMENT 'Email верифіковано',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Користувачі сайту';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published` (`published_at`);
ALTER TABLE `ads` ADD FULLTEXT KEY `ft_title_desc` (`title`,`description`);

--
-- Индексы таблицы `ad_images`
--
ALTER TABLE `ad_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ad` (`ad_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_parent` (`parent_id`),
  ADD KEY `idx_active` (`is_active`);

--
-- Индексы таблицы `moderation_log`
--
ALTER TABLE `moderation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_target` (`target_type`,`target_id`),
  ADD KEY `idx_moderator` (`moderator_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_published` (`published_at`);
ALTER TABLE `news` ADD FULLTEXT KEY `ft_title_content` (`title_ua`,`title_en`,`title_no`,`content`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `idx_login` (`login`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_last_login` (`last_login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ad_images`
--
ALTER TABLE `ad_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `moderation_log`
--
ALTER TABLE `moderation_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ads_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `ad_images`
--
ALTER TABLE `ad_images`
  ADD CONSTRAINT `ad_images_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `moderation_log`
--
ALTER TABLE `moderation_log`
  ADD CONSTRAINT `moderation_log_ibfk_1` FOREIGN KEY (`moderator_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
