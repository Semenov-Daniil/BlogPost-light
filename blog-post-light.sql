-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 17 2024 г., 19:40
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog-post-light`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` int NOT NULL,
  `posts_id` int NOT NULL,
  `answer_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `users_id`, `posts_id`, `answer_id`, `created_at`) VALUES
(1, 'Comment 1', 4, 5, NULL, '2024-11-17 12:40:35'),
(2, 'Comment 2', 4, 5, NULL, '2024-11-17 12:45:35'),
(3, 'Comment 3', 4, 5, NULL, '2024-11-18 12:45:35'),
(4, 'Answer comment 1', 1, 5, 1, '2024-11-19 09:43:16'),
(5, 'Answer comment 1.2', 1, 5, 1, '2024-11-19 12:43:16'),
(6, 'test', 4, 5, NULL, '2024-11-17 14:51:35'),
(7, 'test', 4, 5, NULL, '2024-11-17 14:52:45'),
(8, 'test', 4, 5, NULL, '2024-11-17 14:53:11'),
(9, 'test', 1, 5, 3, '2024-11-17 15:33:41'),
(10, 'testr2', 1, 5, 8, '2024-11-17 15:33:51'),
(11, 'test', 1, 5, 7, '2024-11-17 15:34:12'),
(12, 'test2', 1, 5, 3, '2024-11-17 15:34:47');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `preview` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `users_id` int NOT NULL,
  `themes_id` int NOT NULL,
  `statuses_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `like` tinyint(1) NOT NULL DEFAULT '0',
  `dislike` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `preview`, `text`, `users_id`, `themes_id`, `statuses_id`, `image`, `created_at`, `like`, `dislike`) VALUES
(2, 'test', 'test', 'test', 1, 4, 2, NULL, '2024-11-15 19:14:27', 0, 0),
(3, 'test', 'test', 'test', 1, 2, 1, 'uploads/posts/f_QNhbb1X33KlejVqTp3Phozg_LY_gbh_1731698084.png', '2024-11-15 19:14:44', 0, 0),
(4, 'test', 'test', 'test', 1, 1, 1, 'uploads/posts/7VxypE1eUi7a6fZJ7xZDGf3qCxS_rVem_1731701206.png', '2024-11-15 20:06:46', 0, 0),
(5, 'А я знаю что ты дрочишь)', 'Вас заметили!', 'Вас спалили с поличным!', 1, 5, 2, 'uploads/posts/rCNkDmoUUxzCi0BjS4iYyIu8ySilFvaI_1731771728.png', '2024-11-16 15:42:08', 11, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'author');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `title`) VALUES
(1, 'Редактирование'),
(2, 'Одобрен'),
(3, 'Запрещен');

-- --------------------------------------------------------

--
-- Структура таблицы `themes`
--

CREATE TABLE `themes` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `themes`
--

INSERT INTO `themes` (`id`, `title`) VALUES
(1, 'Спорт'),
(2, 'Еда'),
(3, 'Игры'),
(4, 'testtesttesttesttesttesttesttesttesttesttesttesttest'),
(5, 'Слив PHP');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `roles_id` int NOT NULL,
  `is_block` tinyint(1) NOT NULL DEFAULT '0',
  `block_time` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `email`, `login`, `password`, `phone`, `auth_key`, `roles_id`, `is_block`, `block_time`, `avatar`, `registered_at`) VALUES
(1, 'Иван', 'Иванов', NULL, 'user@user.ru', 'user', '$2y$13$Ufptnowji5bej9NSkb6ltOu/v141N7Z2aGqNAFbGcH5N5e9TKpdxC', '+7(999)-999-99-99', '9xOs-tJKElGIaORefcY3--kZ0BbbZDJ4', 2, 0, NULL, NULL, '2024-11-14 16:41:26'),
(2, 'Иван', 'Иванов', NULL, 'admin@admin.ru', 'admin', '$2y$13$8V3gaIYO0BREwbu22br3huAPdgt7Gvgc/vJ7QmFxPXt2fa9/0XKYK', '+7(999)-999-99-99', 'HdmoxSZp4oF3OtLGNcdPvegcJZNUzcU-', 1, 0, NULL, NULL, '2024-11-14 16:42:02'),
(4, 'Иван', 'Иванов', NULL, 'user2@user.ru', 'user-file', '$2y$13$5YZkfn1qk5TXQoFRSWE1PeP5kOoctMgAT7VSYOLpw/zCyV2xjB94S', '+7(999)-999-99-99', 'gbWN6fOTzuGnHPC07kC_EFidM54oPshK', 2, 0, NULL, 'uploads/avatars/XxYT2uINTz2ykEM2w69l-DCaeUV4YhbY_1731602661.png', '2024-11-14 16:44:21');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_id` (`answer_id`),
  ADD KEY `posts_id` (`posts_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_id` (`statuses_id`),
  ADD KEY `themes_id` (`themes_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `roles_id` (`roles_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`statuses_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`themes_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
