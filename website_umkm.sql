-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2025 pada 05.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website_umkm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(8, 'admin123', '$2y$10$bhBYlP9zNAKsn0z.J2THm.uIxm2XULGhX9w.k6HLImrDUmlzISIza');

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `posisi_antrian` int(11) DEFAULT NULL,
  `status_antrian` enum('antri','diproses','siap kirim','selesai') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `id_pesanan`, `posisi_antrian`, `status_antrian`) VALUES
(1, 1, 1, 'selesai'),
(2, 2, 2, 'siap kirim'),
(3, 3, 3, 'diproses'),
(4, 4, 4, 'selesai'),
(5, 5, 5, 'selesai'),
(6, 54, 6, 'antri'),
(7, 55, 7, 'antri'),
(8, 55, 8, 'antri'),
(9, 56, 9, 'antri'),
(10, 57, 10, 'selesai'),
(11, 58, 11, 'selesai'),
(12, 59, 12, 'selesai'),
(13, 60, 13, 'selesai'),
(14, 61, 14, 'selesai'),
(15, 62, 15, 'selesai'),
(16, 63, 16, 'selesai'),
(17, 64, 17, 'selesai'),
(18, 65, 18, 'selesai'),
(19, 66, 19, 'selesai'),
(20, 67, 20, 'selesai'),
(21, 68, 21, 'selesai'),
(22, 69, 22, 'selesai'),
(23, 70, 23, 'selesai'),
(24, 71, 24, 'selesai'),
(25, 72, 25, 'selesai'),
(26, 73, 26, 'selesai'),
(27, 74, 27, 'selesai'),
(28, 75, 28, 'selesai'),
(29, 76, 29, 'selesai'),
(30, 77, 30, 'selesai'),
(31, 78, 31, 'selesai'),
(32, 79, 32, 'selesai'),
(33, 80, 33, 'selesai'),
(34, 81, 34, 'selesai'),
(35, 82, 35, 'selesai'),
(36, 83, 36, 'selesai'),
(37, 84, 37, 'selesai'),
(38, 85, 38, 'selesai'),
(39, 86, 39, 'selesai'),
(40, 87, 40, 'selesai'),
(41, 88, 41, 'selesai'),
(42, 89, 42, 'selesai'),
(43, 90, 43, 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya`
--

CREATE TABLE `biaya` (
  `id_biaya` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori_biaya` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biaya`
--

INSERT INTO `biaya` (`id_biaya`, `tanggal`, `kategori_biaya`, `deskripsi`, `nominal`) VALUES
(1, '2025-06-15', 'Bahan Baku', 'Beli ayam dan beras', 150000),
(2, '2025-06-15', 'Operasional', 'Gas dan listrik', 80000),
(3, '2025-06-15', 'Gaji', 'Gaji karyawan harian', 300000),
(4, '2025-06-16', 'Bahan Baku', 'Beli sayur dan telur', 120000),
(5, '2025-06-16', 'Lainnya', 'Perbaikan kipas', 50000),
(6, '2025-06-25', 'Gaji Karyawan', 'kitchen', 3000000),
(7, '2025-07-17', 'Gaji Karyawan', 'rina karyawan delivery', 2500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `harga_satuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `subtotal`, `harga_satuan`) VALUES
(1, 1, 1, 1, 20000, 0),
(2, 1, 4, 1, 5000, 0),
(3, 2, 3, 2, 44000, 0),
(4, 3, 2, 1, 18000, 0),
(5, 4, 1, 1, 20000, 0),
(6, 4, 5, 1, 7000, 0),
(7, 5, 6, 1, 15000, 0),
(8, 8, 1, 1, NULL, 20000),
(9, 9, 1, 1, NULL, 20000),
(10, 9, 4, 1, NULL, 5000),
(11, 10, 1, 1, NULL, 20000),
(12, 10, 4, 1, NULL, 5000),
(13, 11, 1, 1, NULL, 20000),
(14, 11, 4, 1, NULL, 5000),
(15, 11, 7, 1, NULL, 8000),
(16, 12, 1, 3, NULL, 20000),
(17, 12, 2, 2, NULL, 18000),
(18, 12, 4, 5, NULL, 5000),
(19, 13, 3, 2, NULL, 22000),
(20, 13, 4, 5, NULL, 5000),
(21, 13, 7, 3, NULL, 8000),
(22, 14, 1, 1, NULL, 20000),
(23, 14, 2, 3, NULL, 18000),
(24, 14, 3, 2, NULL, 22000),
(25, 14, 4, 5, NULL, 5000),
(26, 14, 5, 1, NULL, 7000),
(27, 14, 6, 1, NULL, 15000),
(28, 14, 7, 2, NULL, 8000),
(29, 14, 8, 3, NULL, 10000),
(30, 14, 9, 1, NULL, 12000),
(31, 14, 10, 2, NULL, 10000),
(32, 15, 2, 3, NULL, 18000),
(33, 15, 3, 2, NULL, 22000),
(34, 15, 4, 5, NULL, 5000),
(35, 15, 7, 2, NULL, 8000),
(36, 15, 8, 3, NULL, 10000),
(37, 15, 9, 1, NULL, 12000),
(38, 15, 10, 2, NULL, 10000),
(39, 16, 1, 5, NULL, 20000),
(40, 16, 4, 3, NULL, 5000),
(41, 16, 6, 2, NULL, 15000),
(42, 17, 1, 2, NULL, 20000),
(43, 17, 2, 2, NULL, 18000),
(44, 17, 3, 2, NULL, 22000),
(45, 17, 4, 2, NULL, 5000),
(46, 17, 5, 2, NULL, 7000),
(47, 17, 6, 2, NULL, 15000),
(48, 17, 7, 2, NULL, 8000),
(49, 17, 8, 2, NULL, 10000),
(50, 17, 9, 2, NULL, 12000),
(51, 17, 10, 2, NULL, 10000),
(52, 18, 1, 5, NULL, 20000),
(53, 18, 2, 2, NULL, 18000),
(54, 18, 3, 2, NULL, 22000),
(55, 18, 4, 4, NULL, 5000),
(56, 18, 5, 1, NULL, 7000),
(57, 22, 1, 5, 100000, 20000),
(58, 22, 2, 5, 90000, 18000),
(59, 22, 3, 5, 110000, 22000),
(60, 22, 4, 15, 75000, 5000),
(61, 23, 1, 1, 20000, 20000),
(62, 23, 9, 1, 12000, 12000),
(63, 25, 1, 1, 20000, 20000),
(64, 25, 2, 1, 18000, 18000),
(65, 25, 5, 1, 7000, 7000),
(66, 25, 6, 1, 15000, 15000),
(67, 27, 1, 1, 20000, 20000),
(68, 27, 2, 1, 18000, 18000),
(69, 27, 5, 2, 14000, 7000),
(70, 28, 1, 1, 20000, 20000),
(71, 28, 4, 5, 25000, 5000),
(72, 28, 10, 2, 20000, 10000),
(73, 29, 1, 5, 100000, 20000),
(74, 29, 2, 7, 126000, 18000),
(75, 29, 3, 9, 198000, 22000),
(76, 30, 1, 4, 80000, 20000),
(77, 30, 2, 2, 36000, 18000),
(78, 30, 4, 6, 30000, 5000),
(79, 31, 6, 1, 15000, 15000),
(80, 32, 12, 1, 30000, 30000),
(81, 32, 4, 1, 5000, 5000),
(82, 33, 11, 3, 120000, 40000),
(83, 33, 12, 2, 60000, 30000),
(84, 33, 5, 5, 35000, 7000),
(85, 34, 12, 1, 30000, 30000),
(86, 34, 5, 1, 7000, 7000),
(87, 35, 1, 1, 20000, 20000),
(88, 35, 12, 1, 30000, 30000),
(89, 35, 5, 2, 14000, 7000),
(90, 36, 11, 5, 200000, 40000),
(91, 36, 12, 5, 150000, 30000),
(92, 36, 5, 7, 49000, 7000),
(93, 36, 6, 3, 45000, 15000),
(94, 37, 3, 1, 22000, 22000),
(95, 37, 11, 2, 80000, 40000),
(96, 37, 12, 2, 60000, 30000),
(97, 37, 5, 3, 21000, 7000),
(98, 37, 6, 2, 30000, 15000),
(99, 37, 10, 5, 50000, 10000),
(100, 38, 1, 1, 20000, 20000),
(101, 38, 5, 1, 7000, 7000),
(102, 39, 1, 1, 20000, 20000),
(103, 40, 5, 1, 7000, 7000),
(104, 40, 6, 4, 60000, 15000),
(105, 41, 2, 5, 90000, 18000),
(106, 41, 5, 5, 35000, 7000),
(107, 42, 1, 1, 20000, 20000),
(108, 42, 2, 1, 18000, 18000),
(109, 42, 5, 2, 14000, 7000),
(110, 43, 1, 2, 40000, 20000),
(111, 43, 2, 2, 36000, 18000),
(112, 43, 12, 2, 60000, 30000),
(113, 44, 1, 1, 20000, 20000),
(114, 44, 11, 1, 40000, 40000),
(115, 44, 12, 1, 30000, 30000),
(116, 44, 5, 2, 14000, 7000),
(117, 45, 1, 1, 20000, 20000),
(118, 46, 12, 2, 60000, 30000),
(119, 46, 4, 2, 10000, 5000),
(120, 47, 11, 2, 80000, 40000),
(121, 47, 12, 2, 60000, 30000),
(122, 47, 4, 5, 25000, 5000),
(123, 48, 11, 2, 80000, 40000),
(124, 48, 12, 2, 60000, 30000),
(125, 48, 4, 2, 10000, 5000),
(126, 48, 10, 4, 40000, 10000),
(127, 48, 9, 2, 24000, 12000),
(128, 49, 1, 2, 40000, 20000),
(129, 49, 2, 2, 36000, 18000),
(130, 49, 4, 4, 20000, 5000),
(131, 50, 2, 2, 36000, 18000),
(132, 50, 12, 2, 60000, 30000),
(133, 50, 4, 4, 20000, 5000),
(134, 51, 11, 2, 80000, 40000),
(135, 51, 12, 2, 60000, 30000),
(136, 51, 4, 2, 10000, 5000),
(137, 52, 1, 2, 40000, 20000),
(138, 52, 4, 2, 10000, 5000),
(139, 53, 1, 1, 20000, 20000),
(140, 53, 12, 1, 30000, 30000),
(141, 54, 1, 4, 80000, 20000),
(142, 54, 2, 4, 72000, 18000),
(143, 54, 12, 2, 60000, 30000),
(144, 54, 4, 10, 50000, 5000),
(145, 55, 1, 1, 20000, 20000),
(146, 55, 4, 1, 5000, 5000),
(147, 56, 3, 5, 110000, 22000),
(148, 56, 4, 5, 25000, 5000),
(149, 57, 2, 1, 18000, 18000),
(150, 58, 1, 2, 40000, 20000),
(151, 58, 2, 2, 36000, 18000),
(152, 58, 4, 4, 20000, 5000),
(153, 59, 1, 1, 20000, 20000),
(154, 59, 2, 1, 18000, 18000),
(155, 59, 4, 2, 10000, 5000),
(156, 60, 1, 1, 20000, 20000),
(157, 60, 2, 1, 18000, 18000),
(158, 60, 3, 2, 44000, 22000),
(159, 60, 4, 2, 10000, 5000),
(160, 60, 5, 2, 14000, 7000),
(161, 61, 3, 2, 44000, 22000),
(162, 61, 11, 2, 80000, 40000),
(163, 61, 4, 4, 20000, 5000),
(164, 62, 3, 2, 44000, 22000),
(165, 62, 11, 2, 80000, 40000),
(166, 62, 4, 2, 10000, 5000),
(167, 62, 5, 2, 14000, 7000),
(168, 63, 3, 2, 44000, 22000),
(169, 63, 11, 2, 80000, 40000),
(170, 63, 4, 2, 10000, 5000),
(171, 63, 5, 2, 14000, 7000),
(172, 64, 3, 2, 44000, 22000),
(173, 64, 11, 2, 80000, 40000),
(174, 64, 4, 2, 10000, 5000),
(175, 64, 5, 2, 14000, 7000),
(176, 65, 3, 2, 44000, 22000),
(177, 65, 11, 2, 80000, 40000),
(178, 65, 4, 2, 10000, 5000),
(179, 65, 5, 2, 14000, 7000),
(180, 66, 3, 2, 44000, 22000),
(181, 66, 11, 2, 80000, 40000),
(182, 66, 4, 2, 10000, 5000),
(183, 66, 5, 2, 14000, 7000),
(184, 67, 2, 2, 36000, 18000),
(185, 67, 3, 2, 44000, 22000),
(186, 67, 4, 4, 20000, 5000),
(187, 68, 3, 2, 44000, 22000),
(188, 69, 1, 1, 20000, 20000),
(189, 69, 10, 4, 40000, 10000),
(190, 70, 1, 1, 20000, 20000),
(191, 70, 10, 4, 40000, 10000),
(192, 71, 1, 1, 20000, 20000),
(193, 71, 10, 4, 40000, 10000),
(194, 72, 2, 1, 18000, 18000),
(195, 72, 3, 1, 22000, 22000),
(196, 72, 12, 2, 60000, 30000),
(197, 72, 5, 4, 28000, 7000),
(198, 73, 2, 2, 36000, 18000),
(199, 73, 5, 2, 14000, 7000),
(200, 74, 1, 1, 20000, 20000),
(201, 74, 4, 1, 5000, 5000),
(202, 75, 2, 1, 18000, 18000),
(203, 75, 5, 1, 7000, 7000),
(204, 76, 2, 1, 18000, 18000),
(205, 76, 4, 1, 5000, 5000),
(206, 77, 1, 3, 60000, 20000),
(207, 77, 2, 2, 36000, 18000),
(208, 77, 4, 5, 25000, 5000),
(209, 78, 2, 2, 36000, 18000),
(210, 78, 5, 2, 14000, 7000),
(211, 79, 2, 2, 36000, 18000),
(212, 79, 3, 2, 44000, 22000),
(213, 79, 4, 4, 20000, 5000),
(214, 80, 2, 2, 36000, 18000),
(215, 80, 3, 2, 44000, 22000),
(216, 80, 4, 4, 20000, 5000),
(217, 81, 3, 3, 66000, 22000),
(218, 81, 5, 3, 21000, 7000),
(219, 82, 1, 2, 40000, 20000),
(220, 82, 4, 2, 10000, 5000),
(221, 83, 2, 2, 36000, 18000),
(222, 83, 3, 2, 44000, 22000),
(223, 83, 4, 4, 20000, 5000),
(224, 84, 2, 2, 36000, 18000),
(225, 84, 3, 2, 44000, 22000),
(226, 84, 4, 4, 20000, 5000),
(227, 85, 2, 2, 36000, 18000),
(228, 85, 3, 2, 44000, 22000),
(229, 85, 4, 4, 20000, 5000),
(230, 86, 3, 1, 22000, 22000),
(231, 86, 9, 1, 12000, 12000),
(232, 87, 1, 2, 40000, 20000),
(233, 87, 2, 2, 36000, 18000),
(234, 88, 1, 2, 40000, 20000),
(235, 88, 2, 2, 36000, 18000),
(236, 88, 4, 4, 20000, 5000),
(237, 89, 1, 1, 20000, 20000),
(238, 89, 2, 1, 18000, 18000),
(239, 89, 4, 2, 10000, 5000),
(240, 90, 2, 2, 36000, 18000),
(241, 90, 4, 2, 10000, 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` enum('kitchen','kasir','delivery') DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `jabatan`, `no_hp`) VALUES
(1, 'Andi Santoso', 'kitchen', '0899110001'),
(2, 'Dewi', 'kasir', '0899110002'),
(3, 'Andi', 'delivery', '0899110003'),
(4, 'Rina', 'delivery', '0899110004'),
(5, 'ardi', 'delivery', '08991100010'),
(6, 'faqih', 'delivery', '089911000070');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Snack'),
(4, 'Dessert');

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `nomor_meja` varchar(10) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `status` enum('tersedia','terisi') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meja`
--

INSERT INTO `meja` (`id_meja`, `nomor_meja`, `kapasitas`, `status`) VALUES
(1, 'M1', 2, 'tersedia'),
(2, 'M2', 4, 'tersedia'),
(3, 'M3', 2, 'tersedia'),
(4, 'M4', 6, 'tersedia'),
(5, 'M5', 8, 'tersedia'),
(8, 'M11', 2, 'tersedia'),
(9, 'M12', 2, 'tersedia'),
(10, 'M13', 2, 'tersedia'),
(11, 'M14', 2, 'tersedia'),
(12, 'M15', 2, 'tersedia'),
(13, 'M16', 2, 'tersedia'),
(14, 'M17', 2, 'tersedia'),
(15, 'M18', 2, 'tersedia'),
(16, 'M19', 2, 'tersedia'),
(17, 'M21', 4, 'tersedia'),
(18, 'M22', 4, 'tersedia'),
(19, 'M23', 4, 'tersedia'),
(20, 'M24', 4, 'tersedia'),
(21, 'M25', 4, 'tersedia'),
(22, 'M26', 4, 'tersedia'),
(23, 'M27', 4, 'tersedia'),
(24, 'M28', 4, 'tersedia'),
(25, 'M29', 4, 'tersedia'),
(26, 'M41', 6, 'tersedia'),
(27, 'M42', 6, 'tersedia'),
(28, 'M43', 6, 'tersedia'),
(29, 'M44', 6, 'tersedia'),
(30, 'M45', 6, 'tersedia'),
(31, 'M46', 6, 'tersedia'),
(32, 'M47', 6, 'tersedia'),
(33, 'M48', 6, 'tersedia'),
(34, 'M49', 6, 'tersedia'),
(35, 'M51', 8, 'tersedia'),
(36, 'M52', 8, 'tersedia'),
(37, 'M53', 8, 'tersedia'),
(38, 'M54', 8, 'tersedia'),
(39, 'M55', 8, 'tersedia'),
(40, 'M56', 6, 'tersedia'),
(41, 'M57', 8, 'tersedia'),
(42, 'M58', 8, 'tersedia'),
(43, 'M59', 8, 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `umur` int(3) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `umur`, `no_hp`, `alamat`) VALUES
(1, 'Aldi', 21, '0812345001', 'Jl. Melati 1'),
(2, 'Rina', 25, '0812345002', 'Jl. Anggrek 2'),
(3, 'Dimas', 28, '0812345003', 'Jl. Mawar 3'),
(4, 'Lina', 23, '0812345004', 'Jl. Kenanga 4'),
(5, 'Fajar', 26, '0812345005', 'Jl. Dahlia 5'),
(6, 'Nina', 24, '0812345006', 'Jl. Teratai 6'),
(7, 'Bayu', 30, '0812345007', 'Jl. Cempaka 7'),
(8, 'Eka', 27, '0812345008', 'Jl. Flamboyan 8'),
(9, 'Wahyu', 22, '0812345009', 'Jl. Angsana 9'),
(10, 'Santi', 29, '0812345010', 'Jl. Cemara 10'),
(11, 'yarr', 19, NULL, ''),
(12, 'yarr', 19, NULL, ''),
(13, 'yarr', 19, NULL, ''),
(14, 'yarr', 19, NULL, ''),
(15, 'yarr', 19, NULL, ''),
(16, 'yarr', 19, NULL, ''),
(17, 'yarr', 19, NULL, ''),
(18, 'Akhyar mualif ', 19, NULL, ''),
(19, 'yar', 19, NULL, ''),
(20, 'Akhyar mualif ', 19, NULL, ''),
(21, 'vraxen', 20, NULL, ''),
(22, 'faqih', 17, NULL, 'Blimbing,kuncen 005/002'),
(23, 'zahra', 16, NULL, ''),
(24, 'zahra', 19, NULL, ''),
(25, 'bree', 20, NULL, ''),
(26, 'Akhyar mualif ', 19, NULL, ''),
(27, 'Akhyar mualif ', 18, NULL, ''),
(28, '', 0, '', ''),
(29, 'Akhyar mualif ', 20, '089530123608', ''),
(30, 'zahra', 15, '09887875567', ''),
(31, 'vraxen', 19, '089530123608', ''),
(32, 'kenzie', 15, '08976666666', 'mandiraja'),
(33, 'afkar', 19, '08976666669', ''),
(34, 'afwa', 17, '08976666698', ''),
(35, 'salsa', 18, '09887875587', ''),
(36, 'chili', 16, '089766666690', 'blimbing,mandiraja'),
(37, 'yarr', 19, '089530123608', 'blimbing'),
(38, 'kenz', 21, '08976666699', ''),
(39, 'virya', 19, '089530123609', ''),
(40, 'zahra', 14, '09887875560', ''),
(41, 'zahra', 17, '098878755697', 'blimbing'),
(42, 'afkar', 17, '08976666667', ''),
(43, 'indra', 24, '089766666698', 'blimbing'),
(44, 'viera', 24, '0895301236790', 'purwasaba'),
(45, 'Akhyar mualif ', 19, '09887875560', ''),
(46, 'zahra', 18, '089766666909', 'mandiraja'),
(47, 'afkar', 19, '089530123690', 'kuncen'),
(48, 'vraxen', 20, '089530123697', 'blimbing'),
(49, 'hadza', 25, '089530123674', 'dieng'),
(50, 'yarr', 15, '089530123691', ''),
(51, 'akhyar mualif', 23, '09887875598', ''),
(52, 'yarr', 23, '09887875562', ''),
(53, 'zahra', 23, '098878755609', ''),
(54, 'vraxen', 23, '089530123698', ''),
(55, 'Budi Santoso', 35, '0899777666', 'Jl. Mawar Baru'),
(56, 'rendi', 24, '', ''),
(57, 'andi', 24, '', ''),
(58, 'zahra', 24, '089530123698', 'banjarnegara'),
(59, 'afkar', 23, '089530123609', 'blimbing'),
(60, 'fik', 23, '', ''),
(61, 'min', 25, '', ''),
(62, 'indi', 20, '', ''),
(63, 'dani', 20, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `metode` enum('Cash','QRIS','Transfer BRI','Transfer BTN','DANA','Gopay','ShopeePay','USDT','Ethereum','Solana','Binance QR') DEFAULT NULL,
  `status_pembayaran` enum('belum','lunas') DEFAULT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `status_konfirmasi` enum('pending','disetujui') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pesanan`, `metode`, `status_pembayaran`, `waktu_bayar`, `bukti`, `status_konfirmasi`) VALUES
(1, 1, 'QRIS', 'lunas', '2025-06-16 11:10:00', NULL, 'pending'),
(2, 2, 'Cash', 'lunas', '2025-06-16 11:20:00', NULL, 'pending'),
(3, 3, '', 'lunas', '2025-06-24 20:50:41', NULL, 'pending'),
(4, 4, 'QRIS', 'lunas', '2025-06-16 12:35:00', NULL, 'pending'),
(5, 5, 'Cash', 'lunas', '2025-06-16 13:10:00', NULL, 'pending'),
(6, 27, '', 'lunas', '2025-06-24 20:50:29', NULL, 'pending'),
(7, 25, '', 'lunas', '2025-06-24 20:50:35', NULL, 'pending'),
(8, 23, '', 'lunas', '2025-06-24 20:50:37', NULL, 'pending'),
(9, 22, '', 'lunas', '2025-06-24 20:50:38', NULL, 'pending'),
(10, 28, '', 'lunas', '2025-06-25 09:20:39', NULL, 'pending'),
(11, 29, '', 'lunas', '2025-06-25 09:54:00', NULL, 'pending'),
(12, 30, '', 'lunas', '2025-06-25 10:26:18', NULL, 'pending'),
(13, 26, '', 'lunas', '2025-06-25 11:14:48', NULL, 'pending'),
(14, 24, '', 'lunas', '2025-06-25 11:14:49', NULL, 'pending'),
(15, 21, '', 'lunas', '2025-06-25 11:14:50', NULL, 'pending'),
(16, 6, '', 'lunas', '2025-06-25 11:14:53', NULL, 'pending'),
(17, 7, '', 'lunas', '2025-06-25 11:14:55', NULL, 'pending'),
(18, 8, '', 'lunas', '2025-06-25 11:14:59', NULL, 'pending'),
(19, 20, '', 'lunas', '2025-06-25 11:15:00', NULL, 'pending'),
(20, 19, '', 'lunas', '2025-06-25 11:15:01', NULL, 'pending'),
(21, 18, '', 'lunas', '2025-06-25 11:15:02', NULL, 'pending'),
(22, 17, '', 'lunas', '2025-06-25 11:15:03', NULL, 'pending'),
(23, 14, '', 'lunas', '2025-06-25 11:15:05', NULL, 'pending'),
(24, 15, '', 'lunas', '2025-06-25 11:15:07', NULL, 'pending'),
(25, 16, '', 'lunas', '2025-06-25 11:15:08', NULL, 'pending'),
(26, 13, '', 'lunas', '2025-06-25 11:15:11', NULL, 'pending'),
(27, 12, '', 'lunas', '2025-06-25 11:15:19', NULL, 'pending'),
(28, 11, '', 'lunas', '2025-06-25 11:15:21', NULL, 'pending'),
(29, 10, '', 'lunas', '2025-06-25 11:15:23', NULL, 'pending'),
(30, 9, '', 'lunas', '2025-06-25 11:15:25', NULL, 'pending'),
(31, 31, '', 'lunas', '2025-06-25 16:54:19', NULL, 'pending'),
(32, 32, 'QRIS', 'lunas', '2025-06-25 12:15:00', NULL, 'pending'),
(33, 32, 'QRIS', 'lunas', '2025-06-25 12:15:52', NULL, 'pending'),
(34, 33, 'QRIS', 'lunas', '2025-06-25 17:28:09', NULL, 'pending'),
(35, 34, 'QRIS', 'lunas', '2025-06-25 19:06:45', NULL, 'pending'),
(36, 35, 'QRIS', 'lunas', '2025-06-25 20:41:31', NULL, 'pending'),
(37, 36, 'QRIS', 'lunas', '2025-06-25 22:01:33', NULL, 'pending'),
(38, 37, 'QRIS', 'lunas', '2025-06-26 08:29:22', NULL, 'pending'),
(39, 38, 'QRIS', 'lunas', '2025-06-26 09:08:25', NULL, 'pending'),
(40, 39, 'QRIS', 'lunas', '2025-06-26 09:29:52', NULL, 'pending'),
(41, 40, '', 'lunas', '2025-06-26 09:38:25', NULL, 'pending'),
(42, 41, 'QRIS', 'lunas', '2025-06-26 09:40:10', NULL, 'pending'),
(43, 42, '', 'lunas', '2025-06-26 09:54:23', NULL, 'pending'),
(44, 43, 'QRIS', 'lunas', '2025-06-26 09:57:22', NULL, 'pending'),
(45, 44, 'QRIS', 'lunas', '2025-06-26 18:30:11', NULL, 'pending'),
(46, 45, 'QRIS', 'lunas', '2025-06-26 18:55:16', NULL, 'pending'),
(47, 46, 'QRIS', 'lunas', '2025-06-30 10:06:14', NULL, 'pending'),
(48, 47, 'QRIS', 'lunas', '2025-06-30 10:08:14', NULL, 'pending'),
(49, 48, 'QRIS', 'lunas', '2025-06-30 10:10:06', NULL, 'pending'),
(50, 49, 'QRIS', 'lunas', '2025-06-30 10:22:30', NULL, 'pending'),
(51, 50, 'QRIS', 'lunas', '2025-06-30 10:30:21', NULL, 'pending'),
(52, 51, '', 'lunas', '2025-06-30 10:38:49', NULL, 'pending'),
(53, 52, 'QRIS', 'lunas', '2025-06-30 10:49:38', NULL, 'pending'),
(54, 53, 'QRIS', 'lunas', '2025-07-01 12:17:38', NULL, 'pending'),
(55, 54, 'QRIS', 'lunas', '2025-07-04 23:37:26', NULL, 'pending'),
(56, 55, 'QRIS', 'lunas', '2025-07-04 23:48:43', NULL, 'pending'),
(57, 56, 'QRIS', 'lunas', '2025-07-05 00:00:27', NULL, 'pending'),
(58, 57, 'QRIS', 'lunas', '2025-07-05 00:27:22', NULL, 'pending'),
(59, 58, 'QRIS', 'lunas', '2025-07-05 09:13:49', NULL, 'pending'),
(60, 59, '', 'lunas', '2025-07-10 13:56:47', NULL, 'pending'),
(61, 60, '', 'lunas', '2025-07-10 18:40:35', NULL, 'pending'),
(62, 60, '', 'lunas', '2025-07-10 18:40:35', NULL, 'pending'),
(63, 60, '', 'lunas', '2025-07-10 18:40:35', NULL, 'pending'),
(64, 60, '', 'lunas', '2025-07-10 18:40:35', NULL, 'pending'),
(65, 60, '', 'lunas', '2025-07-10 18:40:35', NULL, 'pending'),
(66, 61, '', 'lunas', '2025-07-10 20:39:13', '', 'pending'),
(67, 62, '', 'lunas', '2025-07-10 20:41:55', '', 'pending'),
(68, 63, '', 'lunas', '2025-07-10 21:34:23', '', 'pending'),
(69, 64, '', 'lunas', '2025-07-10 21:38:13', 'bukti_1752158232_6572.png', 'pending'),
(70, 65, 'Cash', 'lunas', '2025-07-10 21:42:57', '', 'pending'),
(71, 66, '', 'lunas', '2025-07-11 07:26:55', 'bukti_1752161328_5581.png', 'pending'),
(72, 67, 'Cash', 'lunas', '2025-07-11 07:27:57', '', 'pending'),
(73, 68, 'Cash', 'lunas', '2025-07-11 07:44:23', '', 'pending'),
(74, 69, 'Cash', 'lunas', '2025-07-11 09:00:08', '', 'pending'),
(75, 70, '', 'lunas', '2025-07-12 08:33:45', 'bukti_1752284021_8324.png', 'pending'),
(76, 72, '', 'lunas', '2025-07-13 21:30:43', 'bukti_1752378339_1477.png', 'pending'),
(77, 71, '', 'lunas', '2025-07-13 21:30:44', NULL, 'pending'),
(78, 73, 'Solana', 'lunas', '2025-07-13 21:31:54', 'bukti_1752417106_4729.png', 'pending'),
(79, 74, 'Transfer BTN', 'lunas', '2025-07-14 00:37:19', 'bukti_1752428204_7868.png', 'pending'),
(80, 75, 'Cash', 'lunas', '2025-07-14 01:01:08', NULL, 'pending'),
(81, 76, 'Cash', 'lunas', '2025-07-14 01:09:55', NULL, 'pending'),
(82, 77, 'Cash', 'lunas', '2025-07-14 01:11:11', NULL, 'pending'),
(83, 78, 'Cash', 'lunas', '2025-07-14 01:30:25', NULL, 'disetujui'),
(84, 79, 'Cash', 'lunas', '2025-07-14 13:37:46', NULL, 'disetujui'),
(85, 80, 'Cash', 'lunas', '2025-07-14 13:37:48', NULL, 'disetujui'),
(86, 81, 'Cash', 'lunas', '2025-07-14 13:49:17', NULL, 'disetujui'),
(87, 82, 'Cash', 'lunas', '2025-07-16 23:33:18', NULL, 'disetujui'),
(88, 83, 'Cash', 'lunas', '2025-07-16 23:39:44', NULL, 'disetujui'),
(89, 84, 'Cash', 'lunas', '2025-07-16 23:40:52', NULL, 'disetujui'),
(90, 85, 'Cash', 'lunas', '2025-07-17 00:49:26', NULL, 'disetujui'),
(91, 86, 'Transfer BRI', 'lunas', '2025-07-17 20:21:57', 'bukti_1752758456_6152.png', 'disetujui'),
(92, 87, 'Cash', 'lunas', '2025-07-17 20:31:29', NULL, 'disetujui'),
(93, 88, 'DANA', 'lunas', '2025-07-19 11:46:54', 'bukti_1752899838_9066.png', 'disetujui'),
(94, 89, 'Cash', 'lunas', '2025-07-19 13:10:54', NULL, 'disetujui'),
(95, 90, 'Cash', 'lunas', '2025-07-19 15:42:33', NULL, 'disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_meja` int(11) DEFAULT NULL,
  `id_karyawan_delivery` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `metode` varchar(30) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_pesanan` enum('diproses','diantar','selesai') DEFAULT 'diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `id_meja`, `id_karyawan_delivery`, `tanggal`, `metode`, `catatan`, `status_pesanan`) VALUES
(1, 1, 1, NULL, '2025-06-16 11:00:00', '', NULL, 'selesai'),
(2, 2, NULL, 3, '2025-06-16 11:15:00', '', NULL, 'selesai'),
(3, 3, 2, NULL, '2025-06-16 12:00:00', '', NULL, 'selesai'),
(4, 4, NULL, 4, '2025-06-16 12:30:00', '', NULL, 'selesai'),
(5, 5, 3, NULL, '2025-06-16 13:00:00', '', NULL, 'selesai'),
(6, 15, NULL, NULL, '2025-06-19 10:30:08', 'Makan di Tempat', NULL, 'selesai'),
(7, 16, NULL, NULL, '2025-06-19 10:30:23', 'Makan di Tempat', NULL, 'selesai'),
(8, 17, NULL, NULL, '2025-06-19 10:35:32', 'Makan di Tempat', NULL, 'selesai'),
(9, 18, NULL, NULL, '2025-06-19 11:34:23', 'Makan di Tempat', NULL, 'selesai'),
(10, 19, NULL, NULL, '2025-06-20 02:06:36', 'Makan di Tempat', NULL, 'selesai'),
(11, 20, NULL, NULL, '2025-06-20 02:12:06', 'Makan di Tempat', NULL, 'selesai'),
(12, 21, NULL, NULL, '2025-06-21 05:01:13', 'Makan di Tempat', NULL, 'selesai'),
(13, 22, NULL, NULL, '2025-06-21 05:21:08', 'Diantar', NULL, 'selesai'),
(14, 23, NULL, NULL, '2025-06-21 06:06:19', 'Makan di Tempat', NULL, 'selesai'),
(15, 24, NULL, NULL, '2025-06-21 06:16:18', 'Makan di Tempat', NULL, 'selesai'),
(16, 25, NULL, NULL, '2025-06-21 06:22:18', 'Makan di Tempat', NULL, 'selesai'),
(17, 26, NULL, NULL, '2025-06-22 08:09:48', 'Makan di Tempat', NULL, 'selesai'),
(18, 27, NULL, NULL, '2025-06-24 10:08:58', 'Makan di Tempat', NULL, 'selesai'),
(19, 28, NULL, NULL, '2025-06-24 10:47:27', '', NULL, 'selesai'),
(20, 28, NULL, NULL, '2025-06-24 10:47:42', '', NULL, 'selesai'),
(21, 28, NULL, NULL, '2025-06-24 10:47:58', '', NULL, 'selesai'),
(22, 29, NULL, NULL, '2025-06-24 10:51:45', 'Makan di Tempat', NULL, 'selesai'),
(23, 30, NULL, NULL, '2025-06-24 10:56:17', 'Makan di Tempat', NULL, 'selesai'),
(24, 28, NULL, NULL, '2025-06-24 12:06:51', '', NULL, 'selesai'),
(25, 31, NULL, NULL, '2025-06-24 15:02:15', 'Makan di Tempat', NULL, 'selesai'),
(26, 28, NULL, NULL, '2025-06-24 15:12:20', '', NULL, 'selesai'),
(27, 29, NULL, NULL, '2025-06-24 15:21:00', 'Makan di Tempat', NULL, 'selesai'),
(28, 32, NULL, NULL, '2025-06-24 16:02:33', 'Diantar', NULL, 'selesai'),
(29, 29, NULL, NULL, '2025-06-25 04:53:50', 'Makan di Tempat', NULL, 'selesai'),
(30, 29, NULL, NULL, '2025-06-25 05:26:01', 'Makan di Tempat', NULL, 'selesai'),
(31, 33, NULL, NULL, '2025-06-25 11:53:26', 'Makan di Tempat', NULL, 'selesai'),
(32, 34, NULL, NULL, '2025-06-25 12:12:42', 'Makan di Tempat', NULL, 'selesai'),
(33, 35, NULL, NULL, '2025-06-25 12:25:51', 'Makan di Tempat', NULL, 'selesai'),
(34, 36, NULL, 3, '2025-06-25 14:06:29', 'Diantar', NULL, 'selesai'),
(35, 37, NULL, 3, '2025-06-25 15:41:12', 'Diantar', NULL, 'selesai'),
(36, 38, NULL, NULL, '2025-06-25 17:00:53', 'Makan di Tempat', NULL, 'selesai'),
(37, 39, NULL, 3, '2025-06-26 03:28:53', 'Makan di Tempat', NULL, 'selesai'),
(38, 29, 1, NULL, '2025-06-26 04:07:50', 'Makan di Tempat', NULL, 'selesai'),
(39, 40, 1, NULL, '2025-06-26 04:29:32', 'Makan di Tempat', NULL, 'selesai'),
(40, 29, 2, NULL, '2025-06-26 04:38:13', 'Makan di Tempat', NULL, 'selesai'),
(41, 41, NULL, NULL, '2025-06-26 04:40:00', 'Diantar', NULL, 'selesai'),
(42, 42, 2, 3, '2025-06-26 04:53:56', 'Makan di Tempat', NULL, 'selesai'),
(43, 43, NULL, 3, '2025-06-26 04:57:00', 'Diantar', NULL, 'selesai'),
(44, 44, NULL, 4, '2025-06-26 13:29:59', 'Diantar', NULL, 'selesai'),
(45, 45, 1, NULL, '2025-06-26 13:54:28', 'Makan di Tempat', NULL, 'selesai'),
(46, 29, NULL, 5, '2025-06-30 05:06:01', 'Diantar', NULL, 'selesai'),
(47, 46, NULL, NULL, '2025-06-30 05:08:06', 'Diantar', NULL, 'selesai'),
(48, 47, NULL, NULL, '2025-06-30 05:09:55', 'Diantar', NULL, 'selesai'),
(49, 48, NULL, 6, '2025-06-30 05:22:04', 'Diantar', NULL, 'selesai'),
(50, 49, NULL, NULL, '2025-06-30 05:24:12', 'Diantar', NULL, 'selesai'),
(51, 50, 3, NULL, '2025-06-30 05:38:36', 'Makan di Tempat', NULL, 'selesai'),
(52, 51, 2, 3, '2025-06-30 05:49:19', 'Makan di Tempat', NULL, 'selesai'),
(53, 29, 4, 4, '2025-07-01 07:17:18', 'Makan di Tempat', NULL, 'selesai'),
(54, 29, 2, 5, '2025-07-04 18:37:17', 'Makan di Tempat', NULL, 'selesai'),
(55, 52, 1, NULL, '2025-07-04 18:48:26', 'Makan di Tempat', NULL, 'selesai'),
(56, 53, 4, NULL, '2025-07-04 19:00:16', 'Makan di Tempat', NULL, 'selesai'),
(57, 54, NULL, 6, '2025-07-04 19:27:10', 'Makan di Tempat', NULL, 'selesai'),
(58, 29, NULL, 3, '2025-07-05 04:12:26', 'Diantar', NULL, 'selesai'),
(59, 56, 3, 4, '2025-07-10 06:49:43', 'Makan di Tempat', NULL, 'selesai'),
(60, 57, 5, NULL, '2025-07-10 09:02:44', 'Makan di Tempat', NULL, 'selesai'),
(61, 23, 9, NULL, '2025-07-10 13:41:41', 'Makan di Tempat', NULL, 'selesai'),
(62, 33, 17, NULL, '2025-07-10 15:41:05', 'Makan di Tempat', NULL, 'selesai'),
(63, 33, 17, NULL, '2025-07-10 16:33:59', 'Makan di Tempat', NULL, 'selesai'),
(64, 33, 17, NULL, '2025-07-10 16:37:03', 'Makan di Tempat', NULL, 'selesai'),
(65, 33, 17, NULL, '2025-07-10 16:42:46', 'Makan di Tempat', NULL, 'selesai'),
(66, 33, 17, NULL, '2025-07-10 17:28:30', 'Makan di Tempat', NULL, 'selesai'),
(67, 18, 8, NULL, '2025-07-11 02:27:24', 'Makan di Tempat', NULL, 'selesai'),
(68, 18, 10, NULL, '2025-07-11 02:44:03', 'Makan di Tempat', NULL, 'selesai'),
(69, 23, 11, NULL, '2025-07-11 03:59:32', 'Makan di Tempat', NULL, 'selesai'),
(70, 23, 11, 5, '2025-07-12 03:30:51', 'Makan di Tempat', NULL, 'selesai'),
(71, 58, NULL, NULL, '2025-07-12 03:38:40', 'Diantar', NULL, 'selesai'),
(72, 59, NULL, NULL, '2025-07-13 05:45:14', 'Diantar', NULL, 'selesai'),
(73, 33, 12, NULL, '2025-07-13 16:31:30', 'Makan di Tempat', NULL, 'selesai'),
(74, 21, 1, 6, '2025-07-13 19:36:28', 'Makan di Tempat', NULL, 'selesai'),
(75, 33, 1, 3, '2025-07-13 20:00:42', 'Makan di Tempat', NULL, 'selesai'),
(76, 60, 1, 4, '2025-07-13 20:09:42', 'Makan di Tempat', NULL, 'selesai'),
(77, 11, 1, 5, '2025-07-13 20:11:02', 'Makan di Tempat', NULL, 'selesai'),
(78, 18, 1, NULL, '2025-07-13 20:30:10', 'Makan di Tempat', NULL, 'selesai'),
(79, 11, 1, NULL, '2025-07-14 08:36:28', 'Makan di Tempat', NULL, 'selesai'),
(80, 61, 2, NULL, '2025-07-14 08:37:35', 'Makan di Tempat', NULL, 'selesai'),
(81, 23, 3, NULL, '2025-07-14 08:49:07', 'Makan di Tempat', NULL, 'selesai'),
(82, 23, 2, NULL, '2025-07-16 18:33:06', 'Makan di Tempat', NULL, 'selesai'),
(83, 23, 2, NULL, '2025-07-16 18:39:24', 'Makan di Tempat', NULL, 'selesai'),
(84, 23, 2, 5, '2025-07-16 18:40:46', 'Makan di Tempat', NULL, 'selesai'),
(85, 23, 2, 3, '2025-07-16 19:47:15', 'Makan di Tempat', NULL, 'selesai'),
(86, 62, 2, 5, '2025-07-17 15:18:54', 'Makan di Tempat', NULL, 'selesai'),
(87, 23, 1, 5, '2025-07-17 15:31:17', 'Makan di Tempat', NULL, 'selesai'),
(88, 23, 1, 4, '2025-07-19 06:35:33', 'Makan di Tempat', NULL, 'selesai'),
(89, 18, 1, 6, '2025-07-19 08:10:19', 'Makan di Tempat', 'mie ayam nggak pake muncang', 'selesai'),
(90, 63, 1, 3, '2025-07-19 10:42:20', 'Makan di Tempat', 'satu tidak pake cesim', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_kategori`, `harga`, `deskripsi`, `gambar`) VALUES
(1, 'Nasi Goreng Spesial', 1, 20000, 'Nasi goreng dengan telur dan ayam', 'nasi.JPEG'),
(2, 'Mie Ayam Bakso', 1, 18000, 'Mie ayam dengan tambahan bakso', 'mie.JPEG'),
(3, 'Ayam Geprek Level 5', 1, 22000, 'Ayam geprek super pedas', 'geprek.JPEG'),
(4, 'Es Teh Manis', 2, 5000, 'Es teh manis dingin', 'esteh.JPEG'),
(5, 'Teh Botol', 2, 7000, 'Minuman botol segar', 'tehbotol.JPEG'),
(6, 'Kopi Susu Gula Aren', 2, 15000, 'Kopi dengan susu dan gula aren', 'kopi.JPEG'),
(7, 'Cimol Pedas', 3, 8000, 'Cimol isi sambal pedas', 'cimol.JPEG'),
(8, 'Pisang Coklat', 4, 10000, 'Pisang goreng isi coklat', 'pisang.png'),
(9, 'Es Krim Coklat', 4, 12000, 'Es krim rasa coklat lembut', 'eskrim.png'),
(10, 'Sate Usus', 3, 10000, 'Sate usus gurih dan pedas', 'sate.png'),
(11, 'Gurame Bakar', 1, 40000, 'Guarame bakar asam manis', 'Gemini_Generated_Image_r2y6vjr2y6vjr2y6.png'),
(12, 'Nila Bakar', 1, 30000, 'Nila bakar lembut gurih', 'Gemini_Generated_Image_vag1cwvag1cwvag1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `rasa` int(11) DEFAULT NULL CHECK (`rasa` between 1 and 5),
  `pelayanan` int(11) DEFAULT NULL CHECK (`pelayanan` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `tanggal_review` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `review`
--

INSERT INTO `review` (`id_review`, `id_pesanan`, `rasa`, `pelayanan`, `komentar`, `tanggal_review`) VALUES
(1, 1, 5, 5, 'mantap', '2025-06-19 11:33:21'),
(2, 9, 5, 5, 'mantap', '2025-06-19 11:34:37'),
(3, 12, 5, 5, 'enak sekali', '2025-06-21 05:02:17'),
(4, 17, 5, 5, 'enak dan ramah', '2025-06-22 08:10:12'),
(5, 28, 5, 5, '🤩', '2025-06-25 04:46:34'),
(6, 29, 5, 5, '☺️', '2025-06-25 05:00:25'),
(7, 30, 5, 5, '😍', '2025-06-25 06:23:14'),
(8, 31, 5, 5, 'kopinya harum', '2025-06-25 11:55:02'),
(9, 33, 5, 5, 'lembut,gutrih,enak pelayannya ramah', '2025-06-25 12:33:25'),
(10, 34, 5, 5, 'enak bangeet', '2025-06-25 14:42:21'),
(11, 35, 5, 5, '😄', '2025-06-25 15:42:23'),
(12, 36, 5, 5, 'murah, ramah', '2025-06-25 17:02:42'),
(13, 37, 5, 5, 'enak dan sangat terjangkau', '2025-06-26 03:31:48'),
(14, 38, 5, 5, 'enak, ramah, indah ', '2025-06-26 04:09:08'),
(15, 39, 5, 5, '☺️', '2025-06-26 04:30:13'),
(16, 40, 5, 5, 'enak, harum', '2025-06-26 04:39:02'),
(17, 41, 5, 5, '😇', '2025-06-26 04:41:10'),
(18, 43, 5, 5, '', '2025-06-26 13:29:16'),
(19, 44, 5, 5, '', '2025-06-26 13:30:45'),
(20, 45, 5, 5, '', '2025-06-26 13:55:54'),
(21, 46, 5, 5, '', '2025-06-30 05:06:50'),
(22, 47, 5, 5, '', '2025-06-30 05:08:38'),
(23, 48, 5, 5, '', '2025-06-30 05:10:29'),
(24, 49, 5, 5, '', '2025-06-30 05:23:13'),
(25, 50, 5, 5, '', '2025-06-30 05:37:44'),
(26, 51, 5, 5, '', '2025-06-30 05:48:35'),
(27, 52, 5, 5, '', '2025-06-30 05:51:35'),
(28, 53, 5, 5, '', '2025-07-01 07:20:19'),
(29, 54, 5, 5, '', '2025-07-04 18:38:10'),
(30, 55, 5, 5, '', '2025-07-04 18:50:13'),
(31, 56, 5, 5, '', '2025-07-04 19:00:57'),
(32, 57, 5, 5, '', '2025-07-04 19:28:27'),
(33, 58, 5, 5, 'enak ,mantap\r\n', '2025-07-05 04:15:34'),
(34, 60, 5, 5, '', '2025-07-10 13:41:15'),
(35, 61, 5, 5, '', '2025-07-10 15:40:26'),
(36, 67, 5, 5, '', '2025-07-11 02:28:42'),
(37, 69, 5, 5, 'yar', '2025-07-13 05:18:38'),
(38, 69, 5, 5, 'yar', '2025-07-13 05:25:39'),
(39, 69, 5, 5, 'yar', '2025-07-13 05:25:47'),
(40, 69, 5, 5, 'yar', '2025-07-13 05:26:31'),
(41, 69, 5, 5, 'yar', '2025-07-13 05:26:34'),
(42, 69, 5, 5, 'yar', '2025-07-13 05:26:36'),
(43, 69, 5, 5, 'yar', '2025-07-13 05:27:26'),
(44, 69, 5, 5, 'yar', '2025-07-13 05:27:47'),
(45, 69, 5, 5, 'yar', '2025-07-13 05:27:59'),
(46, 69, 5, 5, 'yar', '2025-07-13 05:28:12'),
(47, 73, 5, 5, 'enak, murah, pelayanan bagus', '2025-07-13 16:35:10'),
(48, 74, 5, 5, 'enak, murah', '2025-07-13 19:38:49'),
(49, 86, 5, 5, 'enak , tempatnya nyaman\r\n', '2025-07-17 15:24:57'),
(50, 90, 5, 5, 'makanan enak ,pemandangannya bagus banget', '2025-07-19 10:45:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_meja` (`id_meja`),
  ADD KEY `fk_pesanan_karyawan` (`id_karyawan_delivery`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD UNIQUE KEY `id_review` (`id_review`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_biaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_karyawan` FOREIGN KEY (`id_karyawan_delivery`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
