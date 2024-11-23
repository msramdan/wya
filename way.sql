-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Nov 2024 pada 04.08
-- Versi server: 8.0.30
-- Versi PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `way`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `aduans`
--

CREATE TABLE `aduans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `type` enum('Public','Private') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Dalam Penanganan','Ditolak','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aduans`
--

INSERT INTO `aduans` (`id`, `nama`, `email`, `judul`, `keterangan`, `tanggal`, `type`, `is_read`, `status`, `token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', 'Bullying di Kelas', 'Laporan mengenai tindakan bullying yang terjadi di kelas X-A.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(2, 'Jane Smith', 'janesmith@example.com', 'Tindak Bullying di Lapangan', 'Laporan mengenai insiden bullying yang terjadi saat olahraga.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Selesai', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(3, 'Ramdan', 'ramdan@example.com', 'Tindak Bullying di kantin', 'Laporan mengenai insiden bullying yang terjadi saat di kantin.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Ditolak', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(4, 'Ali Reza', 'alireza@example.com', 'Penganiayaan di Koridor', 'Laporan mengenai penganiayaan yang terjadi di koridor sekolah.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(5, 'Maya Lestari', 'mayalestari@example.com', 'Penipuan oleh Teman Kelas', 'Laporan mengenai penipuan yang dilakukan oleh teman sekelas.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(6, 'Budi Santoso', 'budisantoso@example.com', 'Pelecehan oleh Guru', 'Laporan mengenai pelecehan yang dilakukan oleh seorang guru.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(7, 'Citra Wulandari', 'citrawulandari@example.com', 'Makanan Berbahaya di Kantin', 'Laporan mengenai makanan yang dijual di kantin yang berbahaya untuk kesehatan.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Selesai', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(8, 'Dwi Prasetyo', 'dwiprasetyo@example.com', 'Kekerasan Fisik oleh Senior', 'Laporan mengenai kekerasan fisik yang dilakukan oleh senior di sekolah.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(9, 'Rina Amalia', 'rinaamalia@example.com', 'Penyebaran Hoaks di Grup WhatsApp', 'Laporan mengenai penyebaran hoaks yang terjadi di grup WhatsApp sekolah.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(10, 'Fauzi Alif', 'fauzialif@example.com', 'Pencurian Uang di Kelas', 'Laporan mengenai pencurian uang yang terjadi di kelas X-B.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Selesai', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(11, 'Ika Sari', 'ikasari@example.com', 'Buliing di Media Sosial', 'Laporan mengenai bullying yang terjadi melalui media sosial.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(12, 'Yusuf Hidayat', 'yusukhidayat@example.com', 'Tindak Kekerasan di Lapangan Olahraga', 'Laporan mengenai tindak kekerasan yang terjadi di lapangan olahraga.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Ditolak', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(13, 'Siti Nurhaliza', 'sitinarhaliza@example.com', 'Penghinaan oleh Teman Kelas', 'Laporan mengenai penghinaan yang dilakukan oleh teman sekelas.', '2024-11-22 12:20:37', 'Public', 'No', 'Dalam Penanganan', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(14, 'Andi Supriyadi', 'andisupriyadi@example.com', 'Penipuan Uang oleh Teman', 'Laporan mengenai penipuan yang dilakukan oleh teman sekelas terkait uang.', '2024-11-22 12:20:37', 'Public', 'Yes', 'Ditolak', NULL, '2024-11-22 05:20:37', '2024-11-22 05:20:37'),
(15, 'kira', 'kira@example.com', 'Penipuan Uang oleh Teman', 'Laporan mengenai penipuan yang dilakukan oleh teman sekelas terkait uang.', '2024-11-22 12:20:37', 'Private', 'Yes', 'Selesai', '111111', '2024-11-22 05:20:37', '2024-11-22 05:20:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `aduan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `aduan_id`, `user_id`, `komentar`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 'dsad', '2024-11-22 05:45:44', NULL, NULL),
(2, 15, 1, 'dsadsa', '2024-11-22 05:45:49', NULL, NULL),
(3, 15, 1, 'dasdd', '2024-11-22 05:45:52', NULL, NULL),
(4, 15, 1, 'Laporan mengenai penipuan yang dilakukan oleh teman sekelas terkait uang.', '2024-11-22 05:46:20', NULL, NULL),
(5, 15, 1, 'dsad', '2024-11-22 05:46:48', NULL, NULL),
(6, 15, 1, 'dsadsad', '2024-11-22 05:50:31', NULL, NULL),
(7, 14, 1, 'Oke kalo begitu tolong di tindak lanjuti', '2024-11-22 05:54:01', NULL, NULL),
(8, 14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-22 06:00:16', NULL, NULL),
(9, 14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-22 06:00:18', NULL, NULL),
(10, 14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-22 06:00:21', NULL, NULL),
(11, 14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-22 06:00:23', NULL, NULL),
(12, 14, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-22 06:00:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_01_12_130803_create_permission_tables', 1),
(7, '2023_03_07_072209_create_setting_apps_table', 1),
(8, '2024_07_04_182047_create_activity_log_table', 1),
(9, '2024_07_04_182048_add_event_column_to_activity_log_table', 1),
(10, '2024_07_04_182049_add_batch_uuid_column_to_activity_log_table', 1),
(11, '2024_11_22_075806_create_aduans_table', 1),
(12, '2024_11_22_123813_create_comments_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user view', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(2, 'user create', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(3, 'user edit', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(4, 'user delete', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(5, 'role & permission view', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(6, 'role & permission create', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(7, 'role & permission edit', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(8, 'role & permission delete', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(9, 'setting app view', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(10, 'setting app edit', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(11, 'backup database view', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(12, 'aduan view', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(13, 'aduan delete', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(14, 'update aduan', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36'),
(15, 'respon aduan', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', '2024-11-22 05:20:36', '2024-11-22 05:20:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_apps`
--

CREATE TABLE `setting_apps` (
  `id` bigint UNSIGNED NOT NULL,
  `aplication_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `setting_apps`
--

INSERT INTO `setting_apps` (`id`, `aplication_name`, `logo`, `favicon`, `created_at`, `updated_at`) VALUES
(1, 'With You Always', 'YU5uL97UgATqiVDYp2YQbQVZFvp4AlEv6ZzACxbs.png', '7FjZy5Znior5ipkdTPZ5WdEMwe7O1CdpFxSttKE6.png', '2024-11-22 05:20:37', '2024-11-22 05:31:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `no_hp`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'saepulramdan244@gmail.com', '6283874731480', '2024-11-22 05:20:36', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'bbf8afwiOYEGFeuuN1eGeShIkXvCmkMo8pO1E7Ug.png', '1SCY0c7hpm', '2024-11-22 05:20:36', '2024-11-22 05:50:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indeks untuk tabel `aduans`
--
ALTER TABLE `aduans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aduans_email_unique` (`email`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_aduan_id_foreign` (`aduan_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `setting_apps`
--
ALTER TABLE `setting_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `aduans`
--
ALTER TABLE `aduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `setting_apps`
--
ALTER TABLE `setting_apps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_aduan_id_foreign` FOREIGN KEY (`aduan_id`) REFERENCES `aduans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
