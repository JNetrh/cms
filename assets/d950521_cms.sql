-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 29. bře 2018, 20:14
-- Verze serveru: 10.1.30-MariaDB
-- Verze PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `d950521_cms`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `block_articles`
--

CREATE TABLE `block_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading_1` varchar(255) NOT NULL DEFAULT '',
  `heading_2` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_article` varchar(255) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_articles`
--

INSERT INTO `block_articles` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `text`, `image`, `image_article`, `active`, `position`) VALUES
(4, '{\"heading_1_color\":\"#48d598\",\"heading_2_color\":\"#17d987\",\"text_color\":\"#000000\",\"background_color\":\"#b1f056\",\"_submit\":\"Send\",\"_token_\":\"dojc1lvoiir3\\/L1Kaf39H+vdAbU\\/955cYjEqw=\",\"_do\":\"articlesForm-submit\"}', 'color', 'qwertz', 'qwedsf', '<p>asdasd dfgfdg ewrwr</p>', './img/repo/35abbdea1b75925.87183676.jpg', './img/repo/75abbdea1b7d621.26503413.jpg', 1, 60);

-- --------------------------------------------------------

--
-- Struktura tabulky `block_contacts`
--

CREATE TABLE `block_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading_1` varchar(255) NOT NULL DEFAULT '',
  `heading_2` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `adress` varchar(255) NOT NULL DEFAULT '',
  `gpsx` double NOT NULL DEFAULT '0',
  `gpsy` double NOT NULL DEFAULT '0',
  `instagram` text,
  `facebook` text,
  `twitter` text,
  `linkedin` text,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_contacts`
--

INSERT INTO `block_contacts` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `image`, `email`, `phone`, `adress`, `gpsx`, `gpsy`, `instagram`, `facebook`, `twitter`, `linkedin`, `active`, `position`) VALUES
(1, '{\"heading_1_color\":\"#dd89f0\",\"heading_2_color\":\"#e42fe4\",\"text_color\":\"#000000\",\"background_color\":\"#bd61bc\",\"block_background_color\":\"#f8b0eb\",\"_submit\":\"Send\",\"_token_\":\"i4fkitb15eWPYL0k8nYEww68K4xoPz21b4XhQ=\",\"_do\":\"contactsForm-submit\"}', 'image', 'qwertz', 'lkjhjkj', './img/repo/135abbdcd9ce08e6.10911340.jpg', 'asdasd', '789456123', 'fgfgfg, praha 13, tady je dobře', 55.36, 200.1, 'qwe', 'qwe', '', '', 1, 50);

-- --------------------------------------------------------

--
-- Struktura tabulky `block_events`
--

CREATE TABLE `block_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_events`
--

INSERT INTO `block_events` (`id`, `style`, `bg_type`, `heading`, `image`, `active`, `position`) VALUES
(1, '{\"heading_color\":\"#d51010\",\"background_color\":\"#b2cf3f\",\"text_color\":\"#000000\",\"block_background_color\":\"#d9d9d9\",\"time_color\":\"#0202c0\",\"_submit\":\"Send\",\"_token_\":\"kiv02l2usz+qQN7a9od7cI1YEHhUDH0L57Gic=\",\"_do\":\"eventsForm-submit\"}', 'image', 'poipo', './img/repo/135abbdb0a875b32.66448848.jpg', 1, 30);

-- --------------------------------------------------------

--
-- Struktura tabulky `block_header`
--

CREATE TABLE `block_header` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading_1` varchar(255) NOT NULL DEFAULT '',
  `heading_2` varchar(255) NOT NULL DEFAULT '',
  `button_1` varchar(255) NOT NULL DEFAULT '',
  `button_2` varchar(255) NOT NULL DEFAULT '',
  `button_1_link` text NOT NULL,
  `button_2_link` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_header`
--

INSERT INTO `block_header` (`id`, `style`, `bg_type`, `heading_1`, `heading_2`, `button_1`, `button_2`, `button_1_link`, `button_2_link`, `image`, `active`, `position`) VALUES
(3, '{\"heading_1_color\":\"#d170eb\",\"heading_2_color\":\"#0e1cc4\",\"button_1_color\":\"#98b238\",\"button_1_background_color\":\"#000000\",\"button_1_border_color\":\"#e42525\",\"button_2_color\":\"#d6cd85\",\"button_2_background_color\":\"#ea81c8\",\"button_2_border_color\":\"#cde84f\",\"background_color\":\"#891f1f\",\"_submit\":\"Odeslat\",\"_token_\":\"ph0ffdwpjkM0sBetDys0w\\/V+JW4eC2sbB28Rc=\",\"_do\":\"headerForm-submit\"}', 'color', 'ljklljkl', 'hjfghfgh', 'rewwe', 'qwewq', 'www.nic.cz', '#', './img/repo/85abbd9dc4cb148.47843133.jpg', 1, 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `block_members`
--

CREATE TABLE `block_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading_1` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_members`
--

INSERT INTO `block_members` (`id`, `style`, `bg_type`, `heading_1`, `image`, `active`, `position`) VALUES
(1, '{\"heading_1_color\":\"#d33c3c\",\"background_color\":\"#c40808\",\"text_color\":\"#000000\",\"name_color\":\"#b57373\",\"_submit\":\"Send\",\"_token_\":\"dkbsbsux4exyM2ioVByOvqrAJgaZTG9AiWR8Q=\",\"_do\":\"membersForm-submit\"}', 'color', 'polka', './img/repo/115abbda33c93491.39635592.jpg', 1, 20);

-- --------------------------------------------------------

--
-- Struktura tabulky `block_references`
--

CREATE TABLE `block_references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `style` text,
  `bg_type` varchar(255) NOT NULL DEFAULT 'color',
  `heading` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `block_references`
--

INSERT INTO `block_references` (`id`, `style`, `bg_type`, `heading`, `image`, `active`, `position`) VALUES
(1, '{\"heading_color\":\"#45a90a\",\"background_color\":\"transparent\",\"text_color\":\"#000000\",\"name_color\":\"#999485\",\"block_background_color\":\"#f7f3f3\",\"_submit\":\"Send\",\"_token_\":\"a9neohhmmdhx341h06fbaLeJBP81dK74P+IY4=\",\"_do\":\"referencesForm-submit\"}', 'image', 'fghfgh', './img/repo/25abbdbeadd40b3.45006041.jpg', 0, 40);

-- --------------------------------------------------------

--
-- Struktura tabulky `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading` varchar(255) NOT NULL DEFAULT '',
  `event_time` datetime DEFAULT NULL,
  `text` text NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '#',
  `image` varchar(255) DEFAULT NULL,
  `owner` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '696969'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `events`
--

INSERT INTO `events` (`id`, `heading`, `event_time`, `text`, `link`, `image`, `owner`, `active`, `position`) VALUES
(1, 'qweqwe', '2018-03-22 13:13:13', '<p>ahoj kubi :)</p>', 'www.fb.com', './img/repo/85abbdb6c2f9bc8.08911667.jpg', 1, 1, 1),
(2, 'rtzrtz', '2018-03-22 13:13:13', '<p>ahoj Adi</p>', '#', './img/repo/195abbdb8adb6c83.47267667.jpg', 1, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `owner` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `members`
--

INSERT INTO `members` (`id`, `name`, `text`, `image`, `owner`, `active`) VALUES
(2, 'asd', 'asdasdasd', './img/repo/165abbdac966b560.34531189.jpg', 1, 1),
(3, 'asdas', 'asdasdasdasd', './img/repo/175abbdad4d0d342.42325799.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `referencese`
--

CREATE TABLE `referencese` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `owner` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `reference` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `referencese`
--

INSERT INTO `referencese` (`id`, `name`, `text`, `image`, `owner`, `active`, `reference`) VALUES
(1, 'karel', 'good!', './img/repo/65abbdc072590b5.95578963.jpeg', 1, 0, '<p>reference</p>');

-- --------------------------------------------------------

--
-- Struktura tabulky `rights`
--

CREATE TABLE `rights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `rights`
--

INSERT INTO `rights` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'headers'),
(3, 'members'),
(4, 'references');

-- --------------------------------------------------------

--
-- Struktura tabulky `userrights`
--

CREATE TABLE `userrights` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `rightId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `userrights`
--

INSERT INTO `userrights` (`userId`, `rightId`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'netj01@vse.cz', '$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa'),
(2, 'example@example.cz', '$2y$10$4iP5iusxv7MAYDaB92moYuZdhEK.51V4j9mv7pSQbJnjP5NBG4BMa');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `block_articles`
--
ALTER TABLE `block_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `block_contacts`
--
ALTER TABLE `block_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `block_events`
--
ALTER TABLE `block_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `block_header`
--
ALTER TABLE `block_header`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `block_members`
--
ALTER TABLE `block_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `block_references`
--
ALTER TABLE `block_references`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Klíče pro tabulku `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner` (`owner`);

--
-- Klíče pro tabulku `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner` (`owner`);

--
-- Klíče pro tabulku `referencese`
--
ALTER TABLE `referencese`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `owner` (`owner`);

--
-- Klíče pro tabulku `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `unique_rights` (`name`);

--
-- Klíče pro tabulku `userrights`
--
ALTER TABLE `userrights`
  ADD PRIMARY KEY (`userId`,`rightId`),
  ADD KEY `FK_commonRights_rig` (`rightId`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `block_articles`
--
ALTER TABLE `block_articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `block_contacts`
--
ALTER TABLE `block_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `block_events`
--
ALTER TABLE `block_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `block_header`
--
ALTER TABLE `block_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `block_members`
--
ALTER TABLE `block_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `block_references`
--
ALTER TABLE `block_references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `referencese`
--
ALTER TABLE `referencese`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `rights`
--
ALTER TABLE `rights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `block_events` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `block_members` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `referencese`
--
ALTER TABLE `referencese`
  ADD CONSTRAINT `referencese_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `block_references` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `userrights`
--
ALTER TABLE `userrights`
  ADD CONSTRAINT `FK_commonRights_rig` FOREIGN KEY (`rightId`) REFERENCES `rights` (`id`),
  ADD CONSTRAINT `FK_commonRights_usr` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
