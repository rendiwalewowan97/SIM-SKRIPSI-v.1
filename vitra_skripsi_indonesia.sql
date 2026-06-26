-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2026 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vitra_skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_aplikasi`
--

CREATE TABLE `pengaturan_aplikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kunci` varchar(255) NOT NULL,
  `nilai` text DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_sidang`
--

CREATE TABLE `pendaftaran_sidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_sidang` enum('seminar_proposal','sidang_skripsi') NOT NULL,
  `file_utama` varchar(255) DEFAULT NULL,
  `berkas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`berkas`)),
  `status` enum('diajukan','diverifikasi','dijadwalkan','ditolak','selesai') NOT NULL DEFAULT 'diajukan',
  `jadwal_sidang` datetime DEFAULT NULL,
  `ruangan` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL,
  `pembimbing_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pembimbing_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penguji_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penguji_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penguji_3_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ketua_sidang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sekretaris_sidang_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token_fcm`
--

CREATE TABLE `token_fcm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `token` text NOT NULL,
  `nama_perangkat` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `token_fcm`
--

INSERT INTO `token_fcm` (`id`, `pengguna_id`, `token`, `nama_perangkat`, `dibuat_pada`, `diperbarui_pada`) VALUES
(627, 3, 'eWzKAI0fkLi_AWl1Dk10eB:APA91bFpNaQb-6FX2emmmYoWPo0IfDjgaDFvKKYykLy2z8KwyY_HBzELugG_1eEVz6CaPWt85gGJ0QjykS1hj2a3nInxfGNRxZNs4zu2Fg640sl1nulogQ4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-22 09:33:18', '2026-06-22 09:33:18'),
(628, 10, 'dnRFzaE-TNXzwU5rpw87_x:APA91bE23X47-N9pmwJxeAr4Xd0bFdlYdEy00h4vH5YQ6wggvMs0GX5XlGJNWTKII-b0okYHqQtWZP2gcgnZZSiGr7osv_jUsJnBHqOwU5AMFUtOZub-Jv0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-06-22 09:33:18', '2026-06-22 09:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `sesi_bimbingan`
--

CREATE TABLE `sesi_bimbingan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_bimbingan` enum('proposal','skripsi') NOT NULL DEFAULT 'proposal',
  `tanggal_bimbingan` date NOT NULL,
  `bab` varchar(255) DEFAULT NULL,
  `catatan_mahasiswa` longtext NOT NULL,
  `catatan_dosen` longtext DEFAULT NULL,
  `file_bimbingan` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','direview','selesai','revisi') NOT NULL DEFAULT 'menunggu',
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengirim_id` bigint(20) UNSIGNED NOT NULL,
  `penerima_id` bigint(20) UNSIGNED NOT NULL,
  `isi_pesan` text NOT NULL,
  `dibaca_pada` timestamp NULL DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_000001_create_thesis_tables', 1),
(5, '2026_06_16_193726_create_pesan_table', 2),
(6, '2026_06_17_000001_add_missing_features_to_sim_skripsi', 3),
(7, '2026_06_17_000002_adjust_business_flow_skripsi', 4),
(8, '2026_06_18_000001_add_ketua_jurusan_role_to_users_table', 5),
(9, '2026_06_18_182440_update_role_enum_on_users_table', 5),
(10, '2026_06_18_000002_use_jabatan_for_ketua_jurusan', 6),
(11, '2026_06_20_000001_add_fcm_token_to_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_notifikasi` text NOT NULL,
  `tautan` varchar(255) DEFAULT NULL,
  `dibaca_pada` timestamp NULL DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Gm2u0id7SNkZHi7EjFtNdUN7pjArPahz1K1x59Xm', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVBlVjRjQXFhVk12c1laVGF4VlJYWkN6a3FscjJncks1YzM0RnZjciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ndWlkYW5jZXMiO3M6NToicm91dGUiO3M6MTU6Imd1aWRhbmNlcy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO30=', 1782120798),
('IEPtsyIVFFPG7EQpWYs96zKCkwP3KhpfDHixET28', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmVNWHF3R2VtNFhtckFrRGZ4bUJ5ellhWlRhZ2RZMmExbHMzdlR2MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1782210501),
('QP7d6dMPkm3pAtjVrmHCgjdOPwFWyebztWKd11c6', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidlZNa0EzbmlWRExyUzJUenQzb3dDSUZPaklqam1YNUFzY1FNOXM3TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90aXRsZXMiO3M6NToicm91dGUiO3M6MTI6InRpdGxlcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1782120798);

-- --------------------------------------------------------

--
-- Table structure for table `arsip_skripsi`
--

CREATE TABLE `arsip_skripsi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `kata_kunci` varchar(255) DEFAULT NULL,
  `file_abstrak` varchar(255) DEFAULT NULL,
  `file_skripsi` varchar(255) NOT NULL,
  `dipublikasikan` tinyint(1) NOT NULL DEFAULT 1,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_judul`
--

CREATE TABLE `pengajuan_judul` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `pembimbing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pembimbing_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pembimbing_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `sks` smallint(5) UNSIGNED DEFAULT NULL,
  `latar_belakang` text DEFAULT NULL,
  `status` enum('diajukan','disetujui','ditolak','revisi') NOT NULL DEFAULT 'diajukan',
  `catatan` text DEFAULT NULL,
  `tanggal_disetujui` timestamp NULL DEFAULT NULL,
  `tanggal_ditetapkan` timestamp NULL DEFAULT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voting_judul`
--

CREATE TABLE `voting_judul` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengajuan_judul_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_id` bigint(20) UNSIGNED NOT NULL,
  `suara` enum('setuju','tidak_setuju') NOT NULL,
  `dibuat_pada` timestamp NULL DEFAULT NULL,
  `diperbarui_pada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','dosen','jurusan') NOT NULL DEFAULT 'mahasiswa',
  `position` varchar(255) DEFAULT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `fcm_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `position`, `identifier`, `phone`, `remember_token`, `fcm_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Jurusan', 'jurusan@unmus.ac.id', '$2y$12$rjKXeAqWxBuHiqgJZwSQ9.B5Nw5fj03qJF8igu3yyzK8TaANnxZDe', 'jurusan', NULL, NULL, NULL, NULL, NULL, '2026-06-06 00:23:38', '2026-06-06 00:23:38'),
(3, 'Vitra Mahasiswa', 'mahasiswa@unmus.ac.id', '$2y$12$inRbO3JAWQav5H8IGRc0je.mX2FAbupu17ZXs2JV9bx4LreIvFKbG', 'mahasiswa', NULL, '2026001', NULL, NULL, NULL, '2026-06-06 00:23:38', '2026-06-06 00:23:38'),
(5, 'Dedy Abdianto Nggego, S.SI, M.Kom', 'dedyabdianto@unmus.com', '$2y$12$juSJuRPt3RHB0gRbH3ei9eHBQN3lMzvLLm/qz5vSYa9S9xigHbBoO', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:42:50', '2026-06-16 11:42:50'),
(6, 'Dr. Heru Ismanto, S.Si., M.Cs', 'heruismanto@unmus.com', '$2y$12$E0LxEsZUCI9pBhTvR1QILOL8BaPeObZKA1OcsYurPVJrHIwOAp64a', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:43:34', '2026-06-16 11:43:34'),
(7, 'Yuliana Kolyaan, S.Kom., M.T', 'yuliana@unmus.com', '$2y$12$mV3xeOlyq.Tp.DidUt.ntOzRa1lJwY159vPSESzjLMtDZKk5hST.a', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:44:10', '2026-06-16 11:44:10'),
(8, 'Chusnul Chotimah, S.Kom., M.Kom', 'chusnul@unmus.com', '$2y$12$LrzfY/XtesZLZh.FkPW1WeZOG8VnCCdGBfzvgi7gKOftjV2YOHRsu', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:45:11', '2026-06-16 11:45:11'),
(9, 'Susanto, S.Kom., M.T', 'susanto@unmus.com', '$2y$12$bejI.T8yzuSK9ZP4kRFd1OzGGQZxNy18pcWVoDrgdtPABQTq1HVr.', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:45:36', '2026-06-16 11:45:36'),
(10, 'Izak Habel Wayangkau, S.T., M.T', 'izak@unmus.com', '$2y$12$i1c7MKLClmIEzuiW2MtrfO91WO0RRBEtiWGlp.pkPnc2q5bveRpAe', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:46:22', '2026-06-16 11:46:22'),
(11, 'Dr. Fransiskus X Manggau, S.Kom., M.T', 'fransiskus@unmus.com', '$2y$12$1Ol4z6sJZflVTPDYOa8Swe1y3CinV99NaJ3CIukwDbT0T68dN251.', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:46:55', '2026-06-16 11:46:55'),
(12, 'Suwarjono, S.Kom., M.T', 'suwarjono@unmus.com', '$2y$12$LjnCjTRyZQioSeCwgYzxdOni50xxfCl4Q1HJIQsdBTt.miw7BIOC.', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:47:25', '2026-06-16 11:47:25'),
(13, 'Rachmat, S.Kom., M.Kom', 'rachmat@unmus.com', '$2y$12$ryZLixInA5eO/Tv1njk3aOkzFiBEwb3wU5Tz4y2l3fPVtflrG/w7y', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:47:50', '2026-06-16 11:47:50'),
(14, 'Lilik Sumaryanti, S.Kom., M.Cs', 'lilik@unmus.com', '$2y$12$F.szlG.r.qBxVzxqFEtt8eN/q0TK803mferAK95nO/WDIA/X7DDLW', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:48:22', '2026-06-16 11:48:22'),
(15, 'Agus Prayitno, S.Kom., M.Cs', 'agus@unmus.com', '$2y$12$KZLC97YUerNBQDnAdXZnp.zeWmTbz4gqq2GI3mlFLh5/trJuQjZ2S', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:48:51', '2026-06-16 11:48:51'),
(16, 'Nilfred Patawaran, S.Kom., M.Kom', 'nilfred@unmus.com', '$2y$12$xZ7HNdrA/4BUWvnZf3PexOCFSXb8g8/ydTOC/vMwNh9xw7CDkKWLm', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:49:20', '2026-06-16 11:49:20'),
(17, 'Syaiful Nugraha, S.Kom., M.Kom', 'syaiful@unmus.com', '$2y$12$hXFwvVQVpXVWQrUM6nCfK..3nfUdcxHWeVdDhj942jXMaUmf289E6', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:49:52', '2026-06-16 11:49:52'),
(18, 'Teddy Istanto, S.Kom., M.Kom', 'teddy@unmus.com', '$2y$12$oCxghbZzzdtBZ7Ae8vofJ.ShLDg.bKRhOMPEUlpsw3gtuicYuUCdy', 'dosen', NULL, '12345678', '081200001234', NULL, NULL, '2026-06-16 11:50:39', '2026-06-19 03:04:08'),
(20, 'Marsujitullah, S.Kom.,M.T', 'marsujitullah@unmus.com', '$2y$12$94ZEUmhJ.KEfGiTyoopD9eAwxeYE7zRqR36IVX/1xYE92fzCSeUh.', 'dosen', 'ketua_jurusan', '12345678', '081200001234', NULL, NULL, '2026-06-18 09:35:38', '2026-06-19 03:04:13'),
(21, 'Mahasiswa A', 'siswa@unmus.com', '$2y$12$A/o8VmSZ.9/OWc534/iL3.ovi8idzYh3wEcOv.X5Sigx3c7lGwLdy', 'mahasiswa', NULL, '1234567', '081200001234', NULL, NULL, '2026-06-20 00:46:45', '2026-06-20 00:46:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengaturan_aplikasi`
--
ALTER TABLE `pengaturan_aplikasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaturan_aplikasi_key_unique` (`kunci`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `pendaftaran_sidang`
--
ALTER TABLE `pendaftaran_sidang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_sidang_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `pendaftaran_sidang_pembimbing_1_id_foreign` (`pembimbing_1_id`),
  ADD KEY `pendaftaran_sidang_pembimbing_2_id_foreign` (`pembimbing_2_id`),
  ADD KEY `pendaftaran_sidang_penguji_1_id_foreign` (`penguji_1_id`),
  ADD KEY `pendaftaran_sidang_penguji_2_id_foreign` (`penguji_2_id`),
  ADD KEY `pendaftaran_sidang_penguji_3_id_foreign` (`penguji_3_id`),
  ADD KEY `pendaftaran_sidang_ketua_sidang_id_foreign` (`ketua_sidang_id`),
  ADD KEY `pendaftaran_sidang_sekretaris_sidang_id_foreign` (`sekretaris_sidang_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `token_fcm`
--
ALTER TABLE `token_fcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token_fcm_pengguna_id_foreign` (`pengguna_id`);

--
-- Indexes for table `sesi_bimbingan`
--
ALTER TABLE `sesi_bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sesi_bimbingan_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `sesi_bimbingan_dosen_id_foreign` (`dosen_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesan_pengirim_id_foreign` (`pengirim_id`),
  ADD KEY `pesan_penerima_id_foreign` (`penerima_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_pengguna_id_foreign` (`pengguna_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `arsip_skripsi`
--
ALTER TABLE `arsip_skripsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsip_skripsi_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `pengajuan_judul`
--
ALTER TABLE `pengajuan_judul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_judul_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `pengajuan_judul_dosen_id_foreign` (`pembimbing_id`),
  ADD KEY `pengajuan_judul_pembimbing_1_id_foreign` (`pembimbing_1_id`),
  ADD KEY `pengajuan_judul_pembimbing_2_id_foreign` (`pembimbing_2_id`);

--
-- Indexes for table `voting_judul`
--
ALTER TABLE `voting_judul`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voting_judul_pengajuan_judul_id_dosen_id_unique` (`pengajuan_judul_id`,`dosen_id`),
  ADD KEY `voting_judul_dosen_id_foreign` (`dosen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengaturan_aplikasi`
--
ALTER TABLE `pengaturan_aplikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran_sidang`
--
ALTER TABLE `pendaftaran_sidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token_fcm`
--
ALTER TABLE `token_fcm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

--
-- AUTO_INCREMENT for table `sesi_bimbingan`
--
ALTER TABLE `sesi_bimbingan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `arsip_skripsi`
--
ALTER TABLE `arsip_skripsi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `pengajuan_judul`
--
ALTER TABLE `pengajuan_judul`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `voting_judul`
--
ALTER TABLE `voting_judul`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran_sidang`
--
ALTER TABLE `pendaftaran_sidang`
  ADD CONSTRAINT `pendaftaran_sidang_ketua_sidang_id_foreign` FOREIGN KEY (`ketua_sidang_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_penguji_1_id_foreign` FOREIGN KEY (`penguji_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_penguji_2_id_foreign` FOREIGN KEY (`penguji_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_penguji_3_id_foreign` FOREIGN KEY (`penguji_3_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_sekretaris_sidang_id_foreign` FOREIGN KEY (`sekretaris_sidang_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_sidang_pembimbing_1_id_foreign` FOREIGN KEY (`pembimbing_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendaftaran_sidang_pembimbing_2_id_foreign` FOREIGN KEY (`pembimbing_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `token_fcm`
--
ALTER TABLE `token_fcm`
  ADD CONSTRAINT `token_fcm_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sesi_bimbingan`
--
ALTER TABLE `sesi_bimbingan`
  ADD CONSTRAINT `sesi_bimbingan_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sesi_bimbingan_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `arsip_skripsi`
--
ALTER TABLE `arsip_skripsi`
  ADD CONSTRAINT `arsip_skripsi_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_judul`
--
ALTER TABLE `pengajuan_judul`
  ADD CONSTRAINT `pengajuan_judul_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_judul_pembimbing_1_id_foreign` FOREIGN KEY (`pembimbing_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_judul_pembimbing_2_id_foreign` FOREIGN KEY (`pembimbing_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengajuan_judul_dosen_id_foreign` FOREIGN KEY (`pembimbing_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `voting_judul`
--
ALTER TABLE `voting_judul`
  ADD CONSTRAINT `voting_judul_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `voting_judul_pengajuan_judul_id_foreign` FOREIGN KEY (`pengajuan_judul_id`) REFERENCES `pengajuan_judul` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
