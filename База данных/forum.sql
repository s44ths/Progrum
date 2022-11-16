-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 26 2021 г., 22:15
-- Версия сервера: 10.4.21-MariaDB
-- Версия PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `forum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bans`
--

CREATE TABLE `bans` (
  `ban_id` int(11) NOT NULL,
  `banned_id` int(11) NOT NULL,
  `moder_id` int(11) NOT NULL,
  `BlockEnd` datetime NOT NULL,
  `Explaination` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bans`
--

INSERT INTO `bans` (`ban_id`, `banned_id`, `moder_id`, `BlockEnd`, `Explaination`) VALUES
(1, 5, 2, '2021-11-27 17:29:33', 'Бот'),
(2, 5, 2, '2021-11-28 19:31:19', 'Тест2'),
(3, 5, 2, '3021-11-27 23:29:26', 'Спам-аккаунт'),
(6, 6, 2, '2021-11-29 15:43:13', 'Спам'),
(7, 6, 2, '3021-11-29 15:42:33', '-'),
(8, 7, 2, '2021-12-26 23:30:36', 'Странный аккаунт');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `ComContent` text NOT NULL,
  `ComDate` datetime NOT NULL,
  `post_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`com_id`, `ComContent`, `ComDate`, `post_id`, `u_id`) VALUES
(1, 'К этому обновлению было приложено очень много сил!', '2021-11-28 03:09:53', 2, 2),
(2, '1', '2021-11-29 15:45:00', 3, 2),
(4, 'Спасибо за обновление!', '2021-12-26 23:41:44', 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `forumposts`
--

CREATE TABLE `forumposts` (
  `post_id` int(11) NOT NULL,
  `Title` varchar(45) NOT NULL,
  `Content` text NOT NULL,
  `PostDate` datetime NOT NULL,
  `LastComment` datetime NOT NULL,
  `topic_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `isClosed` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `forumposts`
--

INSERT INTO `forumposts` (`post_id`, `Title`, `Content`, `PostDate`, `LastComment`, `topic_id`, `u_id`, `isClosed`) VALUES
(1, 'Открытие форума: Прогрум!', 'Друзья! Рад приветствовать вас на нашем сайте!<br />\r\nПрогрум позволяет программистам общаться, делиться знаниями и опытом. Спасибо, что являетесь частью нашего комьюнити :)<br />\r\n<br />\r\nСайт будет активно обновляться и развиваться. Впереди ещё много всего!', '2021-11-28 02:36:53', '2021-11-28 02:36:53', 8, 1, 0),
(2, 'Обновление сайта: список пользователей', 'Добрый день!<br />\r\n<br />\r\nНа сайт добавлена новый раздел: список пользователей. Теперь мы можете найти любого пользователя на сайте, а также узнать, когда он в последний раз был в сети. <br />\r\n<br />\r\nЧтобы перейти в новый раздел, нажмите на \"Зарегистрировано x пользователей\" в шапке профиля.', '2021-11-28 02:39:08', '2021-11-28 03:09:53', 8, 1, 0),
(3, 'Обновление сайта: личные сообщения', 'Ура-ура! Очень важный апдейт :)<br />\r\n<br />\r\nТеперь вы можете отправлять пользователям приватные сообщения. Никто, кроме вас и вашего собеседника, не будет иметь к ним доступ!<br />\r\n<br />\r\nДля того, чтобы отправить сообщения, перейдите в профиль пользователя и нажмите на кнопку \"сообщение\". Или вы можете нажать на значок сообщения в шапке сайта, чтобы открыть центр сообщений и отправить сообщение оттуда.<br />\r\n<br />\r\nПрочитанные сообщения отмечаются синей галочкой. Непрочитанные -- восклицательным знаком.', '2021-11-28 02:42:06', '2021-12-26 23:41:44', 8, 1, 0),
(4, 'Обновление сайта: блокировки', 'Наш сайт нуждается в модерации, поэтому теперь у нас есть собственная система блокировок.', '2021-11-28 03:05:03', '2021-11-28 03:05:03', 8, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `globaltopics`
--

CREATE TABLE `globaltopics` (
  `topic_id` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `globaltopics`
--

INSERT INTO `globaltopics` (`topic_id`, `Name`) VALUES
(1, 'Веб'),
(2, 'Базы данных'),
(3, 'Микроконтроллеры'),
(4, ' Java'),
(5, 'C#'),
(6, 'C++'),
(7, 'PHP'),
(8, 'Новости сайта'),
(9, 'Флудилка');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `m_id` int(11) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `Content` text NOT NULL,
  `isRead` tinyint(4) NOT NULL,
  `u_id_s` int(11) NOT NULL,
  `u_id_r` int(11) NOT NULL,
  `MessageSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`m_id`, `Title`, `Content`, `isRead`, `u_id_s`, `u_id_r`, `MessageSent`) VALUES
(1, 'Тестирование сообщений', 'Ура, всё работает :)', 0, 2, 1, '2021-11-29 13:43:15'),
(2, 'Ещё тест', 'Тестик', 1, 2, 1, '2021-11-29 13:48:56'),
(3, 'Re: Ещё тест', '1', 1, 1, 2, '2021-11-29 15:39:42'),
(4, 'Привет!', 'Пока', 1, 2, 3, '2021-12-26 23:25:14'),
(5, 'Re: Привет!', 'Пока!', 0, 3, 2, '2021-12-26 23:34:32');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `uLogin` varchar(15) NOT NULL,
  `uPassword` varchar(50) NOT NULL,
  `Moder` tinyint(4) NOT NULL,
  `Avatar` int(11) NOT NULL,
  `LastSeen` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`u_id`, `uLogin`, `uPassword`, `Moder`, `Avatar`, `LastSeen`) VALUES
(1, 'Администратор', 'админ1', 1, 0, '2021-11-29 15:39:42'),
(2, 'Nitro1', '123', 1, 14, '2021-12-26 23:27:12'),
(3, 'Programmer', 'qwe321', 0, 8, '2021-12-26 23:43:07'),
(4, 'I_love_code', 'code', 0, 13, '2021-11-27 13:02:07'),
(5, 'Bot', 'bot', 0, 15, '2021-11-27 23:17:30'),
(6, 'Spamer', 'spam', 0, 15, '2021-11-27 23:42:56'),
(7, 'Lol', 'lol1', 0, 15, '2021-12-18 23:19:02'),
(8, 'Imsotired', 'qwert', 0, 15, '2021-12-26 23:48:00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ban_id`),
  ADD KEY `R_39` (`banned_id`),
  ADD KEY `R_41` (`moder_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `R_24` (`post_id`),
  ADD KEY `R_26` (`u_id`);

--
-- Индексы таблицы `forumposts`
--
ALTER TABLE `forumposts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `R_23` (`topic_id`),
  ADD KEY `R_25` (`u_id`);

--
-- Индексы таблицы `globaltopics`
--
ALTER TABLE `globaltopics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `R_27` (`u_id_s`),
  ADD KEY `R_30` (`u_id_r`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bans`
--
ALTER TABLE `bans`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `forumposts`
--
ALTER TABLE `forumposts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `globaltopics`
--
ALTER TABLE `globaltopics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `R_39` FOREIGN KEY (`banned_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `R_41` FOREIGN KEY (`moder_id`) REFERENCES `user` (`u_id`);

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `R_24` FOREIGN KEY (`post_id`) REFERENCES `forumposts` (`post_id`),
  ADD CONSTRAINT `R_26` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Ограничения внешнего ключа таблицы `forumposts`
--
ALTER TABLE `forumposts`
  ADD CONSTRAINT `R_23` FOREIGN KEY (`topic_id`) REFERENCES `globaltopics` (`topic_id`),
  ADD CONSTRAINT `R_25` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `R_27` FOREIGN KEY (`u_id_s`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `R_30` FOREIGN KEY (`u_id_r`) REFERENCES `user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
