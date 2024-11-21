-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2024 at 08:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sis`
--

-- --------------------------------------------------------

--
-- Table structure for table `bukti_pembayaran`
--

CREATE TABLE `bukti_pembayaran` (
  `id_bukti` int NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_iuran` int UNSIGNED NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `nomor_referensi` varchar(100) DEFAULT NULL,
  `bukti_file` varchar(255) NOT NULL,
  `status` enum('Menunggu Konfirmasi','Dikonfirmasi','Ditolak') DEFAULT 'Menunggu Konfirmasi',
  `metode_pembayaran` enum('Manual','Otomatis') DEFAULT NULL,
  `bulan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iuran`
--

CREATE TABLE `iuran` (
  `id_iuran` int UNSIGNED NOT NULL,
  `nama_iuran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun` year NOT NULL,
  `iuran_bulanan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iuran`
--

INSERT INTO `iuran` (`id_iuran`, `nama_iuran`, `tahun`, `iuran_bulanan`) VALUES
(1, 'Iuran Bulanan', 2024, '50000.00'),
(2, 'Iuran Kebersihan', 2024, '30000.00'),
(16, 'tesss', 2024, '233.00'),
(17, 'hhhh', 2024, '200.00'),
(18, 'sepuluribu', 2024, '20000.00');

-- --------------------------------------------------------

--
-- Table structure for table `iuran_warga`
--

CREATE TABLE `iuran_warga` (
  `id_iuran_warga` int NOT NULL,
  `id_iuran` int UNSIGNED NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `januari` decimal(10,2) NOT NULL DEFAULT '0.00',
  `februari` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maret` decimal(10,2) NOT NULL DEFAULT '0.00',
  `april` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mei` decimal(10,2) NOT NULL DEFAULT '0.00',
  `juni` decimal(10,2) NOT NULL DEFAULT '0.00',
  `juli` decimal(10,2) NOT NULL DEFAULT '0.00',
  `agustus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `september` decimal(10,2) NOT NULL DEFAULT '0.00',
  `oktober` decimal(10,2) NOT NULL DEFAULT '0.00',
  `november` decimal(10,2) NOT NULL DEFAULT '0.00',
  `desember` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Belum Lunas',
  `nominal_khusus` decimal(10,2) DEFAULT NULL COMMENT 'Nominal iuran khusus untuk warga per iuran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iuran_warga`
--

INSERT INTO `iuran_warga` (`id_iuran_warga`, `id_iuran`, `id_user`, `januari`, `februari`, `maret`, `april`, `mei`, `juni`, `juli`, `agustus`, `september`, `oktober`, `november`, `desember`, `total`, `keterangan`, `nominal_khusus`) VALUES
(9, 1, 1, '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '240000.00', 'Lunas', '20000.00'),
(10, 1, 2, '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '240000.00', 'Lunas', '20000.00'),
(11, 2, 1, '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '30000.00', '360000.00', 'Lunas', NULL),
(12, 2, 2, '30000.00', '0.00', '30000.00', '0.00', '15000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '75000.00', 'Belum Lunas', '15000.00'),
(13, 16, 1, '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '500.00', '6000.00', 'Lunas', '500.00'),
(14, 16, 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(25, 1, 8, '50000.00', '50000.00', '20000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '120000.00', 'Belum Lunas', '25000.00'),
(26, 2, 8, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(27, 16, 8, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(28, 17, 1, '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '100.00', '1200.00', 'Lunas', '100.00'),
(29, 17, 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(32, 17, 8, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(33, 1, 21, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(34, 2, 21, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(35, 16, 21, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(36, 17, 21, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(37, 1, 22, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(38, 2, 22, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(39, 16, 22, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(40, 17, 22, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(41, 1, 23, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(42, 2, 23, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(43, 16, 23, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(44, 17, 23, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(45, 18, 1, '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '20000.00', '240000.00', 'Lunas', NULL),
(46, 18, 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(47, 18, 8, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(48, 18, 21, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(49, 18, 22, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(50, 18, 23, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(57, 1, 24, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(58, 2, 24, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(59, 16, 24, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(60, 17, 24, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(61, 18, 24, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(67, 1, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(68, 2, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(69, 16, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(70, 17, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(71, 18, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(77, 1, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(78, 2, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(79, 16, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(80, 17, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(81, 18, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(82, 1, 29, '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '50000.00', '600000.00', 'Lunas', NULL),
(83, 2, 29, '30000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '30000.00', 'Lunas', NULL),
(84, 16, 29, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(85, 17, 29, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL),
(86, 18, 29, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Belum Lunas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-10-03-034705', 'App\\Database\\Migrations\\CreateSuperadminTable', 'default', 'App', 1727927630, 1),
(2, '2024-10-03-041101', 'App\\Database\\Migrations\\CreateWargaTable', 'default', 'App', 1727928702, 2),
(3, '2024-10-10-045311', 'App\\Database\\Migrations\\CreateIuranTable', 'default', 'App', 1728536588, 3),
(11, '2024-10-10-070513', 'App\\Database\\Migrations\\CreateWargaTable', 'default', 'App', 1728547728, 4),
(12, '2024-10-10-070805', 'App\\Database\\Migrations\\CreateIuranTable', 'default', 'App', 1728547728, 4),
(13, '2024-10-10-080607', 'App\\Database\\Migrations\\CreateIuranWargaTable', 'default', 'App', 1728547729, 4),
(14, '2024-10-31-045418', 'App\\Database\\Migrations\\UpdateRoleColumnInWargaTable', 'default', 'App', 1730350481, 5),
(15, '2024-11-02-040517', 'App\\Database\\Migrations\\AddNominalKhususToWarga', 'default', 'App', 1730520341, 6),
(16, '2024-11-02-070530', 'App\\Database\\Migrations\\AddNominalKhususToIuranWarga', 'default', 'App', 1730531150, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `id_iuran` int DEFAULT NULL,
  `nama_iuran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tahun` int NOT NULL,
  `bulan` text NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('Manual','Otomatis') NOT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Dikonfirmasi','Ditolak','Pending','Settlement','Expire','Cancel','Failure') NOT NULL DEFAULT 'Pending',
  `tanggal_pembayaran` date NOT NULL,
  `nomor_referensi` varchar(100) DEFAULT NULL,
  `bukti_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `confirmed_by` int UNSIGNED DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_transaksi`, `id_user`, `id_iuran`, `nama_iuran`, `tahun`, `bulan`, `nominal`, `metode_pembayaran`, `snap_token`, `status`, `tanggal_pembayaran`, `nomor_referensi`, `bukti_file`, `created_at`, `updated_at`, `confirmed_by`, `confirmed_at`) VALUES
(1, 'TRX-673AE4430DCBF', 1, 17, 'hhhh', 2024, 'September', '200.00', 'Manual', NULL, 'Ditolak', '2024-11-18', '4lggg', '1731912771_85c2b44f6db7bf30e848.jpg', '2024-11-18 06:52:51', '2024-11-18 09:30:14', 2, '2024-11-18 09:30:14'),
(2, 'TRX-673AE4430DCBF', 1, 17, 'hhhh', 2024, 'Desember', '200.00', 'Manual', NULL, 'Ditolak', '2024-11-18', '4lggg', '1731912771_85c2b44f6db7bf30e848.jpg', '2024-11-18 06:52:51', '2024-11-18 09:30:14', 2, '2024-11-18 09:30:14'),
(3, 'TRX-673AE4430DCBF', 1, 18, 'sepuluribu', 2024, 'November', '20000.00', 'Manual', NULL, 'Ditolak', '2024-11-18', '4lggg', '1731912771_85c2b44f6db7bf30e848.jpg', '2024-11-18 06:52:51', '2024-11-18 09:30:14', 2, '2024-11-18 09:30:14'),
(4, 'TRX-673AE4430DCBF', 1, 18, 'sepuluribu', 2024, 'Desember', '20000.00', 'Manual', NULL, 'Ditolak', '2024-11-18', '4lggg', '1731912771_85c2b44f6db7bf30e848.jpg', '2024-11-18 06:52:51', '2024-11-18 09:30:14', 2, '2024-11-18 09:30:14'),
(87, 'TRX-673ecb26a8ea9', 1, 18, 'sepuluribu', 2024, 'November', '20000.00', 'Otomatis', 'e9225d8c-b003-42cd-8296-78de7030ebea', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 05:54:46', '2024-11-21 05:54:55', NULL, NULL),
(88, 'TRX-673ecb26a8ea9', 1, 18, 'sepuluribu', 2024, 'Desember', '20000.00', 'Otomatis', 'e9225d8c-b003-42cd-8296-78de7030ebea', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 05:54:46', '2024-11-21 05:54:55', NULL, NULL),
(89, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Januari', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(90, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Februari', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(91, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Maret', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(92, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'April', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(93, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Mei', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(94, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Juni', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(95, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Juli', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(96, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Agustus', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(97, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'September', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(98, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Oktober', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(99, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'November', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(100, 'TRX-673ed9aa553dc', 29, 1, 'Iuran Bulanan', 2024, 'Desember', '50000.00', 'Otomatis', '2b7cf139-2fe8-49bf-a777-e999b85e11de', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 06:56:42', '2024-11-21 06:57:03', NULL, NULL),
(101, 'TRX-673edca3b6942', 29, 2, 'Iuran Kebersihan', 2024, 'Januari', '30000.00', 'Otomatis', '0d1f68a0-f3f1-4128-b4e1-d37166aa2bd6', 'Dikonfirmasi', '2024-11-21', NULL, NULL, '2024-11-21 07:09:23', '2024-11-21 07:09:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rekening_bank`
--

CREATE TABLE `rekening_bank` (
  `id_rekening` int NOT NULL,
  `bank` varchar(100) NOT NULL,
  `nomor_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening_bank`
--

INSERT INTO `rekening_bank` (`id_rekening`, `bank`, `nomor_rekening`, `atas_nama`, `created_at`, `updated_at`) VALUES
(1, 'Jago', '1234', 'aaku', '2024-11-16 07:45:38', '2024-11-16 07:51:08'),
(2, 'Mandiri', '112233', 'Ananana', '2024-11-16 07:57:09', '2024-11-16 07:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `id_superadmin` int UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`id_superadmin`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$W2tOrSwRYPpoSrfRLF.EVuMZOnLf2G4g9ac2omvojM.2agqQ2/nw.');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL,
  `snap_token` varchar(255) NOT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id_user` int UNSIGNED NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_kk` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `blok_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dawis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telpon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `status_pernikahan` enum('Belum Menikah','Menikah','Cerai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Budha','Konghucu') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_anggota_keluarga` enum('Kepala Keluarga','Istri','Anak','Lainnya') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kewarganegaraan` enum('WNI','WNA') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('ketua','wakil','sekretaris','bendahara','pengurus','warga') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'warga',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id_user`, `nik`, `password`, `no_kk`, `nama_lengkap`, `alamat`, `blok_no`, `dawis`, `no_telpon`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `status_pernikahan`, `agama`, `status_anggota_keluarga`, `kewarganegaraan`, `pekerjaan`, `role`, `created_at`, `updated_at`) VALUES
(1, '1111111111111111', '$2y$10$ohZXGcaxxKmO8fg0PoTgWeEZDqEqkmUlQ8z2T2SBCT9ggmJvQBWO2', '4444444444444444', 'wargawwaann', 'Alamat Warga Aaa', 'A1/01', 'Dawis 1', '081234567890', 'Laki-Laki', 'Kota A', '1990-01-01', 'Menikah', 'Hindu', 'Kepala Keluarga', 'WNI', 'Pegawai', 'warga', NULL, '2024-11-20 23:55:02'),
(2, '2222222222222222', '$2y$10$G1Vd7GS.D7sFIpEYiK9AnOuiHXUYRwKyrVHpNtyT0UmepNYj5PHha', '5555555555555555', 'Bendahara B', 'Alamat Bendahara B', 'B2/02', 'Dawis 2', '081234567891', 'Perempuan', 'Kota B', '1985-02-02', 'Menikah', 'Kristen', 'Istri', 'WNI', 'Guru', 'bendahara', NULL, '2024-10-13 22:53:18'),
(8, '3333333333333333', '$2y$10$onWi8LoYuz0HQfFXOONviu7rmfGIwPsJFF6wTSaB9SMoS/51BVBPy', '3333333333333333', 'Pengurusyagesyayay', ' pengarusus', '2/4', '1', '21212121', 'Laki-Laki', 'sidoarjo', '2024-10-09', 'Belum Menikah', 'Islam', 'Kepala Keluarga', 'WNI', 'asa', 'pengurus', '2024-10-16 20:51:20', '2024-11-12 01:44:31'),
(21, '4444444444444444', '$2y$10$2JX3XCu40zpZHpdUH9lCmevtdf9AU4nBZosuIyLCqw5WqIifeoco2', '4444444444444445', 'sekretaris', ' sekrett', 'a1', 'b3', '0892873736', 'Laki-Laki', 'sdar', '2024-11-20', 'Menikah', 'Katolik', 'Istri', 'WNI', 'ass', 'sekretaris', '2024-11-01 17:41:14', '2024-11-01 20:39:09'),
(22, '5555555555555555', '$2y$10$WbRnWmfvS0KVOGT4./0Es.Q4MKIB7VlYUYtHq0f8UJSk05EQRF5AO', '5555555555655555', 'ketua erte', ' pakerte', 'a1', 'b2', '086636737373', 'Laki-Laki', 'ssdd', '2024-11-22', 'Menikah', 'Kristen', 'Kepala Keluarga', 'WNI', 'ssss', 'ketua', '2024-11-01 17:42:07', '2024-11-01 20:39:16'),
(23, '6666666666666666', '$2y$10$3.PJaJMl3Gs6hg.DCFOzZOETGP8xJqAXXzrSyRluflwxE1qeK6BMy', '6666666566666666', 'wakilketuwaaaayaka', ' sadasda', 'aa1', 'b3', '425252534324', 'Laki-Laki', 'sshggh', '2024-11-23', 'Belum Menikah', 'Kristen', 'Istri', 'WNI', 'ddd', 'wakil', '2024-11-01 17:43:06', '2024-11-11 23:23:40'),
(24, '1234123412341234', '$2y$10$aURcqw96DmA629A1G3j3LurbAY.kv1XwRLiDL9jB7z7KjaPBB9QYa', '1234123412341235', 'sekrettttt', ' 1234123412341234', '1', 'a1', '213123', 'Laki-Laki', 'sadas', '2024-11-05', 'Belum Menikah', 'Islam', 'Anak', 'WNA', 'asda', 'warga', '2024-11-08 01:07:46', '2024-11-08 01:07:46'),
(26, '1222222222222222', '$2y$10$lHazmxRwHvfif04cA2ARFekZCHuPSyFNjJxTDVAtYt4aknGdk/n4S', '1222222222222222', 'tesahaajaa', ' aa', 'aa', 'a', '44', 'Laki-Laki', 'adasd', '2024-11-06', 'Belum Menikah', 'Islam', 'Kepala Keluarga', 'WNI', 'sss', 'warga', '2024-11-08 01:33:06', '2024-11-08 01:34:53'),
(28, '6666666667777777', '$2y$10$Vyblj8203DX.gYe6WYenx.61sJu2LZaVCeq.xoyeOrVmQ0D.Fve1e', '6666666667777777', 'tesnotiaaa', ' asdasd', '3a', 'a1', '2131243', 'Laki-Laki', 'asas', '2024-10-30', 'Belum Menikah', 'Islam', 'Kepala Keluarga', 'WNI', 'sss', 'warga', '2024-11-08 01:39:55', '2024-11-20 23:53:07'),
(29, '9999999999999999', '$2y$10$9fVBi7fz6XJdv7aMqn3El.2N5u5ENJ6z4jrVPcAkj1kQr1N7Pkum.', '9999999999999997', 'kolpi', ' aaa', '1', 'a1', '8912738912', 'Laki-Laki', 'sda', '2024-11-14', 'Menikah', 'Islam', 'Kepala Keluarga', 'WNI', 'aaa', 'warga', '2024-11-20 23:55:39', '2024-11-20 23:55:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD PRIMARY KEY (`id_bukti`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_iuran` (`id_iuran`);

--
-- Indexes for table `iuran`
--
ALTER TABLE `iuran`
  ADD PRIMARY KEY (`id_iuran`);

--
-- Indexes for table `iuran_warga`
--
ALTER TABLE `iuran_warga`
  ADD PRIMARY KEY (`id_iuran_warga`),
  ADD KEY `iuran_warga_id_iuran_foreign` (`id_iuran`),
  ADD KEY `iuran_warga_id_user_foreign` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_confirmed_by` (`confirmed_by`);

--
-- Indexes for table `rekening_bank`
--
ALTER TABLE `rekening_bank`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`id_superadmin`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id_bukti` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iuran`
--
ALTER TABLE `iuran`
  MODIFY `id_iuran` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `iuran_warga`
--
ALTER TABLE `iuran_warga`
  MODIFY `id_iuran_warga` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `rekening_bank`
--
ALTER TABLE `rekening_bank`
  MODIFY `id_rekening` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `id_superadmin` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD CONSTRAINT `bukti_pembayaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `warga` (`id_user`),
  ADD CONSTRAINT `bukti_pembayaran_ibfk_2` FOREIGN KEY (`id_iuran`) REFERENCES `iuran` (`id_iuran`);

--
-- Constraints for table `iuran_warga`
--
ALTER TABLE `iuran_warga`
  ADD CONSTRAINT `iuran_warga_id_iuran_foreign` FOREIGN KEY (`id_iuran`) REFERENCES `iuran` (`id_iuran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iuran_warga_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `warga` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_confirmed_by` FOREIGN KEY (`confirmed_by`) REFERENCES `warga` (`id_user`),
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `warga` (`id_user`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `warga` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
