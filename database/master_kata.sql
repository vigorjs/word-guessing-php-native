-- -------------------------------------------------------------
-- -------------------------------------------------------------
-- TablePlus 1.2.0
--
-- https://tableplus.com/
--
-- Database: asah_otak
-- Generation Time: 2024-09-28 18:34:37.720166
-- -------------------------------------------------------------

DROP TABLE `asah_otak`.`master_kata`;


CREATE TABLE `master_kata` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kata` varchar(255) DEFAULT NULL,
  `clue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `point_game` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) DEFAULT NULL,
  `total_point` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `asah_otak`.`master_kata` (`id`, `kata`, `clue`) VALUES 
(1, 'Kucing', 'Hewan peliharaan yang suka tidur'),
(2, 'Anjing', 'Hewan yang setia kepada manusia'),
(3, 'Sepeda', 'Alat transportasi yang digerakkan dengan kaki'),
(4, 'Buku', 'Sumber ilmu pengetahuan yang dapat dibaca'),
(5, 'Pensil', 'Alat tulis yang bisa dihapus'),
(6, 'Laut', 'Kumpulan air yang sangat luas'),
(7, 'Gunung', 'Bentuk muka bumi yang tinggi menjulang'),
(8, 'Laptop', 'Alat elektronik yang digunakan untuk komputasi'),
(9, 'Kipas', 'Alat untuk menghasilkan angin sejuk'),
(10, 'Meja', 'Tempat untuk menaruh benda atau bekerja');

