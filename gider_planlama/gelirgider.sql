-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Nis 2025, 11:05:11
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gelirgider`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hareketler`
--

CREATE TABLE `hareketler` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tip` varchar(20) NOT NULL,
  `tutar` decimal(10,2) NOT NULL,
  `aciklama` varchar(255) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hareketler`
--

INSERT INTO `hareketler` (`id`, `user_id`, `tip`, `tutar`, `aciklama`, `tarih`) VALUES
(1, 1, 'gelir', 15000.00, 'kira', '2025-04-24 00:00:00'),
(2, 1, 'gider', 5000.00, 'kurs', '2025-06-25 00:00:00'),
(3, 2, 'gelir', 15000.00, 'kira', '2025-04-29 00:00:00'),
(4, 2, 'gider', 5000.00, 'kurs', '2025-04-29 00:00:00'),
(5, 2, 'gelir', 120000.00, 'maaş', '2025-04-24 00:00:00'),
(6, 2, 'gider', 10000.00, 'yakıt', '2025-04-29 00:00:00'),
(8, 2, 'gelir', 50000.00, 'satış', '2025-04-30 00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `tarih`, `user_id`) VALUES
(1, 'kerem', 'root@email.com', '$2y$10$JlgRi9/Kmlx5c7NfcsSkOeSGmFccsgfQLTlV20MOSpQijwHZLoLfC', '2025-04-26 00:05:13', 0),
(2, 'admin', 'kerem@gurbuz.com', '$2y$10$v9KqToMIASyXK.NXet5Ta.9NJIWaiJ31v7Q7Tty.Sn5NWwOgf/kHO', '2025-04-26 00:10:59', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `hareketler`
--
ALTER TABLE `hareketler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `hareketler`
--
ALTER TABLE `hareketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
