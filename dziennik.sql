-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Lut 2018, 20:12
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dziennik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`id`, `login`, `password`, `role`) VALUES
(1, 'nauczyciel', '$2y$10$YMalznXdBF/nz4KvQybjJuR83TmC6uiCrUNrWETbdQdLlX7f.Yc9e', 1),
(2, 'uczen', '$2y$10$5stFxYetMmSswH.jIVBbPOuk8ZvSDXCukmXPj/JWlE3NwzpNN29WK', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(8, 'Biologia'),
(1, 'Geografia'),
(5, 'Historia'),
(3, 'Informatyka'),
(7, 'Język angielski'),
(4, 'Matematyka'),
(6, 'WF');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `teachers`
--

INSERT INTO `teachers` (`id`, `name`) VALUES
(1, 'Adam Nowak'),
(2, 'Joanna Wieczorek'),
(3, 'Ignacy Mazurek'),
(4, 'Julia Kowal'),
(5, 'Amelia Stępień'),
(6, 'Wiktor Szczepański'),
(7, 'Sonia Tomczak'),
(8, 'Natalia Lewandowska'),
(9, 'Stanisław Wojciechowski');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `times`
--

CREATE TABLE `times` (
  `id` int(11) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `times`
--

INSERT INTO `times` (`id`, `start`, `end`) VALUES
(1, '07:10:00', '07:55:00'),
(2, '08:00:00', '08:45:00'),
(3, '08:55:00', '09:40:00'),
(4, '09:50:00', '10:35:00'),
(5, '10:50:00', '11:35:00'),
(6, '11:45:00', '12:30:00'),
(7, '12:50:00', '13:35:00'),
(8, '13:45:00', '14:30:00'),
(9, '14:40:00', '15:25:00'),
(10, '15:35:00', '16:20:00'),
(11, '16:30:00', '17:15:00'),
(12, '17:25:00', '18:10:00'),
(13, '18:20:00', '19:05:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `timetable`
--

INSERT INTO `timetable` (`id`, `time_id`, `class_id`, `teacher_id`, `day`) VALUES
(1, 1, 1, 1, 1),
(3, 3, 3, 3, 1),
(4, 4, 3, 3, 1),
(5, 5, 4, 4, 5),
(6, 7, 5, 5, 1),
(7, 7, 6, 6, 4),
(8, 8, 7, 7, 1),
(9, 1, 8, 8, 2),
(10, 2, 5, 5, 2),
(11, 3, 4, 4, 2),
(12, 5, 4, 4, 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_id` (`time_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `timetable_ibfk_3` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `times`
--
ALTER TABLE `times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`time_id`) REFERENCES `times` (`id`),
  ADD CONSTRAINT `timetable_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `timetable_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
