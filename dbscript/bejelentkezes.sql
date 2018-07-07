-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Júl 07. 11:05
-- Kiszolgáló verziója: 10.1.33-MariaDB
-- PHP verzió: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bejelentkezes`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `fid` int(11) NOT NULL,
  `fnev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `jelszo` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`fid`, `fnev`, `jelszo`) VALUES
(1, 'Admin', '$2y$10$sUz6jMmCd38BxbGfJXXjmupZzUC8aaJVI9R4ZsKhkHJ/oVBO3kaqy'),
(2, 'User1', '$2y$10$Nwrsvl5SJQvLL.LcYBuHrOlMDzyAVgAIaqCHqW57dNljxdI3n6O7a'),
(3, 'User2', '$2y$10$QvGlUFUSqpxEWxQKhP7H/ev2nt6jG2QiaH9tYh5dNIEYO09BtzmE.'),
(4, 'User3', '$2y$10$ugUdMTDB7u3O1YVNXSBVAOZuvTsbnKulo3YZu358rEhfvUrXXjtMa');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok_szerepkor`
--

CREATE TABLE `felhasznalok_szerepkor` (
  `fid` int(11) NOT NULL,
  `szkid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `felhasznalok_szerepkor`
--

INSERT INTO `felhasznalok_szerepkor` (`fid`, `szkid`) VALUES
(1, 1),
(2, 3),
(2, 2),
(3, 3),
(4, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

CREATE TABLE `log` (
  `logid` int(11) NOT NULL,
  `fnev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8_hungarian_ci NOT NULL,
  `datum` date NOT NULL,
  `sikeres` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `log`
--

INSERT INTO `log` (`logid`, `fnev`, `ip`, `datum`, `sikeres`) VALUES
(1, 'Admin', '::1', '2018-07-07', b'1'),
(2, 'Admin', '::1', '2018-07-07', b'0'),
(3, 'Admin', '::1', '2018-07-07', b'0'),
(4, 'Admin', '::1', '2018-07-07', b'0'),
(5, 'Admin', '::1', '2018-07-07', b'1'),
(6, 'Admin', '::1', '2018-07-07', b'0'),
(7, 'Admin', '::1', '2018-07-07', b'0'),
(8, 'Admin', '::1', '2018-07-07', b'0'),
(9, 'User1', '::1', '2018-07-07', b'1'),
(10, 'Admin', '::1', '2018-07-07', b'1');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `session`
--

CREATE TABLE `session` (
  `sid` varchar(35) COLLATE utf8_hungarian_ci NOT NULL,
  `lejar` int(10) NOT NULL,
  `adat` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szerepkor`
--

CREATE TABLE `szerepkor` (
  `szkid` int(11) NOT NULL,
  `megnevezes` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szerepkor`
--

INSERT INTO `szerepkor` (`szkid`, `megnevezes`) VALUES
(1, 'Admin'),
(2, 'Bejelentkezett felhasználó'),
(3, 'Tartalomszerkesztő');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`fid`);

--
-- A tábla indexei `felhasznalok_szerepkor`
--
ALTER TABLE `felhasznalok_szerepkor`
  ADD KEY `fid` (`fid`),
  ADD KEY `szkid` (`szkid`);

--
-- A tábla indexei `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`logid`);

--
-- A tábla indexei `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sid`);

--
-- A tábla indexei `szerepkor`
--
ALTER TABLE `szerepkor`
  ADD PRIMARY KEY (`szkid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `log`
--
ALTER TABLE `log`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `szerepkor`
--
ALTER TABLE `szerepkor`
  MODIFY `szkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok_szerepkor`
--
ALTER TABLE `felhasznalok_szerepkor`
  ADD CONSTRAINT `felhasznalok_szerepkor_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `felhasznalok` (`fid`),
  ADD CONSTRAINT `felhasznalok_szerepkor_ibfk_2` FOREIGN KEY (`szkid`) REFERENCES `szerepkor` (`szkid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
