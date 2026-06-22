-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 11:33 AM
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
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `exam_registrations`
--

CREATE TABLE `exam_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('seminar_proposal','sidang_skripsi') NOT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `status` enum('diajukan','diverifikasi','dijadwalkan','ditolak','selesai') NOT NULL DEFAULT 'diajukan',
  `scheduled_at` datetime DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supervisor_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `examiner_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `examiner_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `examiner_3_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `secretary_id` bigint(20) UNSIGNED DEFAULT NULL
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
-- Table structure for table `fcm_tokens`
--

CREATE TABLE `fcm_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` text NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fcm_tokens`
--

INSERT INTO `fcm_tokens` (`id`, `user_id`, `token`, `device_name`, `created_at`, `updated_at`) VALUES
(627, 3, 'eWzKAI0fkLi_AWl1Dk10eB:APA91bFpNaQb-6FX2emmmYoWPo0IfDjgaDFvKKYykLy2z8KwyY_HBzELugG_1eEVz6CaPWt85gGJ0QjykS1hj2a3nInxfGNRxZNs4zu2Fg640sl1nulogQ4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-22 09:33:18', '2026-06-22 09:33:18'),
(628, 10, 'dnRFzaE-TNXzwU5rpw87_x:APA91bE23X47-N9pmwJxeAr4Xd0bFdlYdEy00h4vH5YQ6wggvMs0GX5XlGJNWTKII-b0okYHqQtWZP2gcgnZZSiGr7osv_jUsJnBHqOwU5AMFUtOZub-Jv0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', '2026-06-22 09:33:18', '2026-06-22 09:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `guidance_sessions`
--

CREATE TABLE `guidance_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('proposal','skripsi') NOT NULL DEFAULT 'proposal',
  `session_date` date NOT NULL,
  `chapter` varchar(255) DEFAULT NULL,
  `student_note` longtext NOT NULL,
  `supervisor_note` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','direview','selesai','revisi') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(5, '2026_06_16_193726_create_messages_table', 2),
(6, '2026_06_17_000001_add_missing_features_to_sim_skripsi', 3),
(7, '2026_06_17_000002_adjust_business_flow_skripsi', 4),
(8, '2026_06_18_000001_add_ketua_jurusan_role_to_users_table', 5),
(9, '2026_06_18_182440_update_role_enum_on_users_table', 5),
(10, '2026_06_18_000002_use_jabatan_for_ketua_jurusan', 6),
(11, '2026_06_20_000001_add_fcm_token_to_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
('QP7d6dMPkm3pAtjVrmHCgjdOPwFWyebztWKd11c6', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidlZNa0EzbmlWRExyUzJUenQzb3dDSUZPaklqam1YNUFzY1FNOXM3TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC90aXRsZXMiO3M6NToicm91dGUiO3M6MTI6InRpdGxlcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1782120798);

-- --------------------------------------------------------

--
-- Table structure for table `thesis_archives`
--

CREATE TABLE `thesis_archives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `abstract_path` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `title_submissions`
--

CREATE TABLE `title_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_1_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_2_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `sks` smallint(5) UNSIGNED DEFAULT NULL,
  `background` text DEFAULT NULL,
  `status` enum('diajukan','disetujui','ditolak','revisi') NOT NULL DEFAULT 'diajukan',
  `notes` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `title_votes`
--

CREATE TABLE `title_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_submission_id` bigint(20) UNSIGNED NOT NULL,
  `dosen_id` bigint(20) UNSIGNED NOT NULL,
  `vote` enum('setuju','tidak_setuju') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_settings_key_unique` (`key`);

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
-- Indexes for table `exam_registrations`
--
ALTER TABLE `exam_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_registrations_student_id_foreign` (`student_id`),
  ADD KEY `exam_registrations_supervisor_1_id_foreign` (`supervisor_1_id`),
  ADD KEY `exam_registrations_supervisor_2_id_foreign` (`supervisor_2_id`),
  ADD KEY `exam_registrations_examiner_1_id_foreign` (`examiner_1_id`),
  ADD KEY `exam_registrations_examiner_2_id_foreign` (`examiner_2_id`),
  ADD KEY `exam_registrations_examiner_3_id_foreign` (`examiner_3_id`),
  ADD KEY `exam_registrations_chairman_id_foreign` (`chairman_id`),
  ADD KEY `exam_registrations_secretary_id_foreign` (`secretary_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fcm_tokens`
--
ALTER TABLE `fcm_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fcm_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidance_sessions_student_id_foreign` (`student_id`),
  ADD KEY `guidance_sessions_supervisor_id_foreign` (`supervisor_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

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
-- Indexes for table `thesis_archives`
--
ALTER TABLE `thesis_archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_archives_student_id_foreign` (`student_id`);

--
-- Indexes for table `title_submissions`
--
ALTER TABLE `title_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_submissions_student_id_foreign` (`student_id`),
  ADD KEY `title_submissions_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `title_submissions_supervisor_1_id_foreign` (`supervisor_1_id`),
  ADD KEY `title_submissions_supervisor_2_id_foreign` (`supervisor_2_id`);

--
-- Indexes for table `title_votes`
--
ALTER TABLE `title_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_votes_title_submission_id_dosen_id_unique` (`title_submission_id`,`dosen_id`),
  ADD KEY `title_votes_dosen_id_foreign` (`dosen_id`);

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
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_registrations`
--
ALTER TABLE `exam_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcm_tokens`
--
ALTER TABLE `fcm_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

--
-- AUTO_INCREMENT for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `thesis_archives`
--
ALTER TABLE `thesis_archives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `title_submissions`
--
ALTER TABLE `title_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `title_votes`
--
ALTER TABLE `title_votes`
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
-- Constraints for table `exam_registrations`
--
ALTER TABLE `exam_registrations`
  ADD CONSTRAINT `exam_registrations_chairman_id_foreign` FOREIGN KEY (`chairman_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_examiner_1_id_foreign` FOREIGN KEY (`examiner_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_examiner_2_id_foreign` FOREIGN KEY (`examiner_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_examiner_3_id_foreign` FOREIGN KEY (`examiner_3_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_secretary_id_foreign` FOREIGN KEY (`secretary_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_registrations_supervisor_1_id_foreign` FOREIGN KEY (`supervisor_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_registrations_supervisor_2_id_foreign` FOREIGN KEY (`supervisor_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `fcm_tokens`
--
ALTER TABLE `fcm_tokens`
  ADD CONSTRAINT `fcm_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  ADD CONSTRAINT `guidance_sessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guidance_sessions_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thesis_archives`
--
ALTER TABLE `thesis_archives`
  ADD CONSTRAINT `thesis_archives_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `title_submissions`
--
ALTER TABLE `title_submissions`
  ADD CONSTRAINT `title_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `title_submissions_supervisor_1_id_foreign` FOREIGN KEY (`supervisor_1_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `title_submissions_supervisor_2_id_foreign` FOREIGN KEY (`supervisor_2_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `title_submissions_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `title_votes`
--
ALTER TABLE `title_votes`
  ADD CONSTRAINT `title_votes_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `title_votes_title_submission_id_foreign` FOREIGN KEY (`title_submission_id`) REFERENCES `title_submissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
