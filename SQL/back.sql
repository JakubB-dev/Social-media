-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Wrz 2021, 19:00
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `back`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `name` text NOT NULL,
  `mail` text DEFAULT NULL,
  `hash` text NOT NULL,
  `avatar` int(11) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`id`, `login`, `name`, `mail`, `hash`, `avatar`, `created_at`, `updated_at`) VALUES
(16, 'kubaphp', 'Syriusz', 'bronowicki.kuba@wp.pl', '378ddd71f913bb94c930773bdfc490d9e6d3cb85', 5, '2021-05-16 09:38:23', '2021-05-21 18:25:50'),
(17, 'admin', 'Syriusz Black', 'bronowicki.kub@wp.pl', 'd033e22ae348aeb5660fc2140aec35850c4da997', 47, '2021-05-18 21:27:43', '2021-05-19 21:24:38'),
(18, 'moderator', 'Remus Lupin', NULL, '79f52b5b92498b00cb18284f1dcb466bd40ad559', 42, '2021-05-21 21:44:44', '2021-05-22 12:47:26'),
(19, 'gracek', 'Gracjan R', NULL, '4650869c3def36ba7e56c7e7a5c111626ce3d69b', 40, '2021-05-22 17:52:43', '2021-05-22 17:52:43'),
(20, 'elmo123', 'elmo', NULL, 'e9576a35c8876c39c135ff84232330803ed6ce5f', 1, '2021-05-23 10:58:30', '2021-05-23 10:58:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `nameAvatar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `avatars`
--

INSERT INTO `avatars` (`id`, `nameAvatar`) VALUES
(1, 'default.png'),
(5, 'Syriusz161621681110.png'),
(40, 'Gracjan R191621698803.jpg'),
(42, 'Remus Lupin181621715663.jpg'),
(47, 'Syriusz Black171630760778.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `userSender` int(11) NOT NULL,
  `userRecipient` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `friends`
--

INSERT INTO `friends` (`id`, `userSender`, `userRecipient`, `date`) VALUES
(6, 19, 16, '2021-05-22 18:51:38'),
(7, 19, 18, '2021-05-22 20:02:20'),
(8, 17, 19, '2021-05-22 20:02:56'),
(9, 20, 19, '2021-05-23 08:58:57');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `invites`
--

CREATE TABLE `invites` (
  `id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `invites`
--

INSERT INTO `invites` (`id`, `sender`, `recipient`) VALUES
(19, 17, 16);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING HASH,
  ADD UNIQUE KEY `mail` (`mail`) USING HASH,
  ADD UNIQUE KEY `login` (`login`) USING HASH,
  ADD KEY `avatar` (`avatar`);

--
-- Indeksy dla tabeli `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userRecipient` (`userRecipient`),
  ADD KEY `userSender` (`userSender`);

--
-- Indeksy dla tabeli `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient` (`recipient`),
  ADD KEY `sender` (`sender`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT dla tabeli `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `invites`
--
ALTER TABLE `invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`avatar`) REFERENCES `avatars` (`id`);

--
-- Ograniczenia dla tabeli `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`userRecipient`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`userSender`) REFERENCES `accounts` (`id`);

--
-- Ograniczenia dla tabeli `invites`
--
ALTER TABLE `invites`
  ADD CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`recipient`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `invites_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
