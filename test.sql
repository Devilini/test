-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3305
-- Время создания: Фев 26 2020 г., 16:18
-- Версия сервера: 5.6.34
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client_account`
--

CREATE TABLE `client_account` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `file_hash` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `client_account`
--

INSERT INTO `client_account` (`id`, `name`, `comment`, `file_name`, `file_hash`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Счет 1', 'Комментарий 1', 'Счет1.jpg', 'c1ad7311deb6d66398075f3e49e61756', 0, '2020-02-23 15:49:22', '2020-02-23 15:49:22', 2),
(2, 'Счет 2', 'Комментарий 2', 'Счет2.jpg', '642a3c5fedc79c70266b35e860c45a4f', 0, '2020-02-23 23:50:37', '2020-02-23 23:50:37', 2),
(3, 'Счет 3', 'Комментарий 3', 'Счет3.jpg', 'a4ae1395af2ee1ad02587238b3c4eb87', 0, '2020-02-24 15:50:48', '2020-02-24 15:50:48', 2),
(4, 'Счет 4', 'Комментарий 4', 'Счет4.png', '92b321b35fbffecc037778c7f6b9fea4', 0, '2020-02-25 15:51:38', '2020-02-25 15:51:38', 2),
(5, 'Счет 5', 'Комментарий 5', 'Счет5.jpg', '54a4f8b4535a4e2ec8feb7835b522d79', 0, '2020-02-25 09:51:55', '2020-02-25 09:51:55', 2),
(6, 'Счет 6', 'Комментарий 6', 'Счет6.pdf', 'fe1d670b33e6ff324c5ed11eed76306d', 2, '2020-02-26 15:53:13', '2020-02-26 16:15:21', 2),
(7, 'Счет 7', 'Комментарий 7', 'Счет7.jpg', 'b43630cc89b02c4068bc9b9667b11c9f', 1, '2020-02-26 15:59:27', '2020-02-26 16:15:16', 3),
(8, 'Счет 8', 'Комментарий 8', 'Счет8.jpg', 'b76ff5c6ffb753f482b345db7a76e15e', 1, '2020-02-26 15:59:40', '2020-02-26 16:15:15', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(64) DEFAULT 'Клиент',
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `name`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$aq8CcDcoNcDr2kse8DKXmuxqqzMsvuiLuhYz0FOZ0EsX4LcrzgjHy', 'Admin', 1, '2020-02-23 14:25:04', '2020-02-23 14:25:04'),
(2, 'user', '$2y$10$HLE2gvhzJFbWwUDrXaq48OMs7FFugGBrc31uUy.q4qieWEHfsFuLy', 'User', 0, '2020-02-25 16:27:44', '2020-02-25 16:27:44'),
(3, 'user1', '$2y$10$QmCwCPRbj8NNgX9.ElpP3eRD1bK23WofLpap5YxWCIbJA1iFkdJ7e', 'User1', 0, '2020-02-26 11:29:51', '2020-02-26 11:29:51');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client_account`
--
ALTER TABLE `client_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client_account`
--
ALTER TABLE `client_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `client_account`
--
ALTER TABLE `client_account`
  ADD CONSTRAINT `client_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
