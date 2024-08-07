-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 04:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eva_hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ap_id` bigint(20) NOT NULL,
  `pa_id` bigint(20) NOT NULL,
  `ap_added_by` bigint(20) NOT NULL,
  `ap_updated_by` bigint(20) NOT NULL,
  `ap_height` varchar(255) DEFAULT NULL,
  `ap_weight` varchar(255) DEFAULT NULL,
  `ap_bp` varchar(255) DEFAULT NULL,
  `ap_doctor` bigint(20) NOT NULL COMMENT 'user id where role is doctor',
  `ap_date` date NOT NULL,
  `ap_book_via` varchar(255) DEFAULT NULL,
  `ap_case_type` varchar(255) NOT NULL COMMENT 'old/new/emergency',
  `ap_charge` varchar(255) NOT NULL,
  `ap_additional_charge` varchar(255) NOT NULL DEFAULT '0' COMMENT 'additional charge total',
  `ap_payment_mode` varchar(255) DEFAULT NULL COMMENT '	cash/card/mediclaim/corporate	',
  `ap_payment_detail` varchar(255) DEFAULT NULL,
  `ap_status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'pending/completed(prescribe)/cancelled',
  `ap_status_reaason` varchar(255) DEFAULT NULL,
  `ap_complaint` text DEFAULT NULL,
  `ap_other_detail` text DEFAULT NULL,
  `ap_any_advice` text DEFAULT NULL,
  `ap_follow_up_date` date DEFAULT NULL,
  `ap_follow_up_note` text DEFAULT NULL,
  `ap_surg_required` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `ap_surg_date` varchar(255) DEFAULT NULL,
  `ap_surg_type` varchar(255) DEFAULT NULL,
  `ap_is_foc` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `ap_is_workshop` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `ap_id`, `pa_id`, `ap_added_by`, `ap_updated_by`, `ap_height`, `ap_weight`, `ap_bp`, `ap_doctor`, `ap_date`, `ap_book_via`, `ap_case_type`, `ap_charge`, `ap_additional_charge`, `ap_payment_mode`, `ap_payment_detail`, `ap_status`, `ap_status_reaason`, `ap_complaint`, `ap_other_detail`, `ap_any_advice`, `ap_follow_up_date`, `ap_follow_up_note`, `ap_surg_required`, `ap_surg_date`, `ap_surg_type`, `ap_is_foc`, `ap_is_workshop`, `created_at`, `updated_at`) VALUES
(1, 6963429058, 8561981100, 9622814060, 9622814060, '5\'3\'', '68', '120', 8022048049, '2024-07-01', 'asdqwe', 'new', '500', '1000', '', '', 'completed', '', 'asd', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'qwe', '2024-07-06', NULL, 'yes', '2024-07-12', 'qwe', 'no', 'no', '2024-06-28 20:22:25', '2024-07-03 09:35:30'),
(2, 5634636981, 6625798458, 9622814060, 9622814060, '5\'4\'\'', '69', '121', 6636406942, '2024-07-02', 'asdqwe1', 'emergency', '700', '1450', NULL, NULL, 'pending', NULL, NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-06-29 01:19:08', '2024-07-01 23:12:43'),
(3, 3701918849, 6625798458, 9622814060, 9622814060, '5\'3\'\'', '68', '120', 5962819849, '2024-07-01', 'asdqwe', 'new', '500', '2563', 'cash', 'asd qwe 12', 'pending', NULL, NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, '2024-07-03', NULL, 'no', NULL, NULL, 'no', 'no', '2024-06-29 04:51:04', '2024-07-10 16:05:16'),
(4, 1203444812, 8059577479, 9622814060, 8022048049, '5\'3\'\'', '69', '121', 5962819849, '2024-07-01', 'asdqwe', 'old', '200', '0', 'cash', 'asdqwe', 'completed', '', 'asdqwe', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asd\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'qwezxc', '2024-07-03', '', 'no', NULL, NULL, 'no', 'no', '2024-07-02 06:13:59', '2024-08-04 10:40:50'),
(5, 9513724655, 1945164148, 9622814060, 8022048049, '5\'4\'\'', '69', '121', 7308573809, '2024-07-01', 'asdqwe1', 'new', '500', '480', 'cash', 'asdqwe', 'completed', '', 'dasd', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'swe', '2024-07-03', NULL, 'no', NULL, NULL, 'no', 'no', '2024-07-02 06:15:56', '2024-08-04 11:05:30'),
(6, 7693448549, 8059577479, 9622814060, 9622814060, '5\'3\'\'', '70', '120', 6636406942, '2024-07-07', 'asdqwe', 'old', '200', '400', 'cash', 'asdz qwe', 'cancelled', 'asd', NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-07-06 11:36:20', '2024-08-04 02:01:51'),
(7, 6627154988, 8823312118, 9622814060, 8022048049, '5\'3\'\'', '70', '120', 8022048049, '2024-07-07', 'asdqwe', 'old', '200', '300', 'card', 'asd', 'completed', '', NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-07-07 06:30:18', '2024-08-05 14:31:29'),
(8, 2666185699, 3197211687, 3507097541, 3507097541, '5\'3\'\'', '70', '120', 8022048049, '2024-08-04', 'asdqwe12', 'new', '500', '0', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-08-04 05:02:35', '2024-08-04 05:02:35'),
(9, 9247888596, 5981076475, 3507097541, 3507097541, '5\'4\'\'', '70', '121', 6636406942, '2024-08-04', 'asdqwe1', 'new', '500', '760', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-08-04 05:03:37', '2024-08-04 05:37:44'),
(10, 9881264608, 3197211687, 8022048049, 8022048049, '5\'3\'\'', '67', '120', 8022048049, '2024-08-04', 'asdqwe1', 'old', '200', '150', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', '2024-08-04 09:34:44', '2024-08-04 09:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_additional_charges`
--

CREATE TABLE `appointment_additional_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apac_id` bigint(20) NOT NULL,
  `ap_id` bigint(20) NOT NULL COMMENT 'appointment table id',
  `apac_added_by` bigint(20) NOT NULL COMMENT 'user id',
  `apac_desc` varchar(255) NOT NULL,
  `apac_qty` varchar(255) NOT NULL,
  `apac_charge` varchar(255) NOT NULL COMMENT 'single quantity charge',
  `apac_final_charge` varchar(255) NOT NULL COMMENT 'charge muliply with quantity',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_additional_charges`
--

INSERT INTO `appointment_additional_charges` (`id`, `apac_id`, `ap_id`, `apac_added_by`, `apac_desc`, `apac_qty`, `apac_charge`, `apac_final_charge`, `created_at`, `updated_at`) VALUES
(1, 7553850535, 3701918849, 9622814060, 'asd', '2', '200', '400', '2024-07-01 05:37:32', '2024-07-01 05:37:32'),
(2, 6619249790, 3701918849, 9622814060, 'asd', '2', '200', '400', '2024-07-01 05:37:58', '2024-07-01 05:37:58'),
(3, 8262964947, 3701918849, 9622814060, 'asd', '2', '200', '400', '2024-07-01 05:38:22', '2024-07-01 05:38:22'),
(4, 7226695866, 3701918849, 9622814060, 'asd', '2', '100', '200', '2024-07-01 05:39:10', '2024-07-01 05:39:10'),
(5, 3761772163, 3701918849, 9622814060, 'asd', '2', '100', '200', '2024-07-01 05:39:34', '2024-07-01 05:39:34'),
(6, 7812841552, 3701918849, 9622814060, 'xc', '1', '100', '100', '2024-07-01 05:43:46', '2024-07-01 05:43:46'),
(7, 6049170224, 3701918849, 9622814060, 'er', '1', '100', '100', '2024-07-01 05:43:58', '2024-07-01 05:43:58'),
(8, 6321234879, 3701918849, 9622814060, 'asd123', '3', '121', '363', '2024-07-01 06:23:08', '2024-07-01 06:23:08'),
(9, 6075198274, 5634636981, 9622814060, 'as 12', '2', '300', '600', '2024-07-01 06:34:26', '2024-07-01 06:34:26'),
(10, 6923939991, 5634636981, 9622814060, 'asd', '3', '150', '450', '2024-07-01 06:35:43', '2024-07-01 06:35:43'),
(11, 8468978176, 6963429058, 9622814060, 'qw 12', '2', '300', '600', '2024-07-01 06:38:37', '2024-07-01 06:38:37'),
(12, 3801257810, 6963429058, 9622814060, 'zx 12', '1', '150', '150', '2024-07-01 06:39:47', '2024-07-01 06:39:47'),
(13, 3268195809, 6963429058, 9622814060, 'as qw 1', '1', '150', '150', '2024-07-01 06:40:52', '2024-07-01 06:40:52'),
(14, 4179020825, 5634636981, 9622814060, 'as121', '1', '100', '100', '2024-07-01 07:13:33', '2024-07-01 07:13:33'),
(15, 6900098851, 5634636981, 9622814060, 'a1', '1', '100', '100', '2024-07-01 07:52:58', '2024-07-01 07:52:58'),
(16, 1719063496, 5634636981, 9622814060, 'a2', '1', '100', '100', '2024-07-01 07:54:22', '2024-07-01 07:54:22'),
(17, 2528921714, 5634636981, 9622814060, 'a2', '1', '100', '100', '2024-07-01 07:54:44', '2024-07-01 07:54:44'),
(18, 1536680571, 6963429058, 9622814060, 'b1', '1', '100', '100', '2024-07-01 07:57:48', '2024-07-01 07:57:48'),
(19, 3637009867, 3701918849, 9622814060, 'c1', '1', '100', '100', '2024-07-01 08:02:44', '2024-07-01 08:02:44'),
(20, 2094952395, 3701918849, 9622814060, 'c2', '1', '100', '100', '2024-07-01 08:10:08', '2024-07-01 08:10:08'),
(21, 5022246873, 3701918849, 9622814060, 'adw', '1', '100', '100', '2024-07-04 04:36:49', '2024-07-04 04:36:49'),
(22, 6381211964, 3701918849, 9622814060, 'wer', '1', '100', '100', '2024-07-04 04:37:43', '2024-07-04 04:37:43'),
(23, 1066457234, 9513724655, 9622814060, 'asa', '1', '100', '100', '2024-07-04 04:40:54', '2024-07-04 04:40:54'),
(24, 4410803802, 9513724655, 9622814060, 'adcz', '2', '140', '280', '2024-07-04 04:41:37', '2024-07-04 04:41:37'),
(25, 8071746970, 9513724655, 9622814060, 'qwe', '1', '100', '100', '2024-07-04 04:42:31', '2024-07-04 04:42:31'),
(26, 1434313457, 7693448549, 9622814060, 'saqwe qw', '2', '150', '300', '2024-07-06 11:38:13', '2024-07-06 11:38:13'),
(27, 7941472983, 7693448549, 9622814060, 'qw 12', '1', '100', '100', '2024-07-06 11:57:56', '2024-07-06 11:57:56'),
(28, 6964534858, 9247888596, 3507097541, 'x-ray', '1', '150', '150', '2024-08-04 05:37:17', '2024-08-04 05:37:17'),
(29, 2266385308, 9247888596, 3507097541, 'sugar report', '2', '130', '260', '2024-08-04 05:37:27', '2024-08-04 05:37:27'),
(30, 9115168396, 9247888596, 3507097541, 'blood report', '1', '350', '350', '2024-08-04 05:37:44', '2024-08-04 05:37:44'),
(31, 1780065192, 9881264608, 8022048049, 'sugar report', '1', '150', '150', '2024-08-04 09:41:35', '2024-08-04 09:41:35'),
(34, 9576559398, 6627154988, 9622814060, 'x-ray', '2', '150', '300', '2024-08-05 14:31:29', '2024-08-05 14:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_medicines`
--

CREATE TABLE `appointment_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `am_id` bigint(20) NOT NULL,
  `ap_id` bigint(20) NOT NULL COMMENT 'appointment id',
  `am_added_by` bigint(20) NOT NULL,
  `gm_id` bigint(20) NOT NULL COMMENT 'General medicine id',
  `am_days` int(11) NOT NULL,
  `am_timing` varchar(255) NOT NULL COMMENT 'ex - before food or after food',
  `am_morning` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `am_afternoon` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `am_evening` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_medicines`
--

INSERT INTO `appointment_medicines` (`id`, `am_id`, `ap_id`, `am_added_by`, `gm_id`, `am_days`, `am_timing`, `am_morning`, `am_afternoon`, `am_evening`, `created_at`, `updated_at`) VALUES
(1, 6096809996, 3701918849, 9622814060, 5299484431, 2, 'after food', 'yes', 'no', 'yes', '2024-06-30 05:22:13', '2024-06-30 05:22:13'),
(2, 4680280128, 3701918849, 9622814060, 5299484431, 1, 'asd', 'no', 'yes', 'no', '2024-06-30 05:23:26', '2024-06-30 05:23:26'),
(5, 2208865152, 3701918849, 9622814060, 2118327182, 1, '2', 'yes', 'no', 'yes', '2024-06-30 05:48:56', '2024-06-30 05:48:56'),
(6, 9777899963, 3701918849, 9622814060, 2118327182, 3, 'before food', 'yes', 'yes', 'no', '2024-06-30 05:53:03', '2024-06-30 05:53:03'),
(7, 7830526293, 3701918849, 9622814060, 5299484431, 3, 'after food', 'yes', 'no', 'no', '2024-06-30 05:53:35', '2024-06-30 05:53:35'),
(11, 4403888796, 1203444812, 9622814060, 2118327182, 2, 'after launch', 'no', 'yes', 'no', '2024-07-02 06:15:10', '2024-07-02 06:15:10'),
(12, 1885446246, 9513724655, 9622814060, 5299484431, 1, 'after dinner', 'no', 'no', 'yes', '2024-07-02 06:16:36', '2024-07-02 06:16:36'),
(13, 1132197926, 7693448549, 9622814060, 5299484431, 1, 'after food', 'yes', 'yes', 'no', '2024-07-06 11:59:00', '2024-07-06 11:59:00'),
(14, 9912818168, 6627154988, 9622814060, 5299484431, 2, 'after eat food', 'no', 'yes', 'yes', '2024-07-07 06:40:48', '2024-07-07 06:40:48');

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
-- Table structure for table `general_medicines`
--

CREATE TABLE `general_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gm_id` bigint(20) NOT NULL,
  `gm_added_by` bigint(20) NOT NULL,
  `gm_updated_by` bigint(20) NOT NULL,
  `gm_name` varchar(255) NOT NULL,
  `gm_company_name` varchar(255) NOT NULL,
  `gm_description` text DEFAULT NULL,
  `gm_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active, 0-disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_medicines`
--

INSERT INTO `general_medicines` (`id`, `gm_id`, `gm_added_by`, `gm_updated_by`, `gm_name`, `gm_company_name`, `gm_description`, `gm_status`, `created_at`, `updated_at`) VALUES
(1, 2118327182, 9622814060, 9622814060, 'lamolate', 'Mexica Pharma', 'lamolate generate by Alpha', 1, '2024-06-24 23:44:31', '2024-06-24 23:53:13'),
(2, 5299484431, 9622814060, 9622814060, 'paracetamol', 'Alpha Pharma', 'paracetamol created by Alpha', 1, '2024-06-24 23:52:40', '2024-06-24 23:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_charges`
--

CREATE TABLE `ipd_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ic_id` bigint(20) NOT NULL,
  `ipd_id` bigint(20) NOT NULL COMMENT 'ipd detail id',
  `ic_added_by` bigint(20) NOT NULL COMMENT 'user table id',
  `ic_text` varchar(255) NOT NULL,
  `ic_amount` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_charges`
--

INSERT INTO `ipd_charges` (`id`, `ic_id`, `ipd_id`, `ic_added_by`, `ic_text`, `ic_amount`, `created_at`, `updated_at`) VALUES
(1, 3411201538, 7418463651, 9622814060, 'asd', 1200, '2024-07-18 01:45:05', '2024-07-18 01:45:05'),
(2, 7135433949, 7418463651, 9622814060, 'qwe', 300, '2024-07-18 01:45:10', '2024-07-18 01:45:10'),
(3, 3110254481, 7418463651, 9622814060, 'zxc', 400, '2024-07-18 01:45:17', '2024-07-18 02:09:00'),
(6, 7697540200, 3245365631, 9622814060, 'x-ray', 2000, '2024-07-27 04:34:33', '2024-07-27 04:34:33'),
(7, 9670897507, 3245365631, 9622814060, 'report`', 3000, '2024-07-27 05:22:39', '2024-07-27 05:22:39'),
(9, 1154107661, 3245365631, 3507097541, 'Blood', 500, '2024-08-04 05:46:16', '2024-08-04 05:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_details`
--

CREATE TABLE `ipd_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipd_id` bigint(20) NOT NULL,
  `ipd_added_by` bigint(20) NOT NULL,
  `ipd_updated_by` bigint(20) NOT NULL,
  `pa_id` bigint(20) NOT NULL,
  `ipd_admit_date` date NOT NULL,
  `ipd_doctor` bigint(20) NOT NULL COMMENT 'user id of doctor',
  `ipd_surgery_date` date DEFAULT NULL,
  `ipd_surgery_text` varchar(255) DEFAULT NULL,
  `rm_id` bigint(20) NOT NULL COMMENT 'Room id',
  `ipd_status` varchar(255) NOT NULL DEFAULT 'admit' COMMENT 'admit/discharged/cancelled',
  `ipd_discharge_date` date DEFAULT NULL COMMENT 'when status discharge',
  `ipd_follow_up_date` date DEFAULT NULL,
  `ipd_follow_up_note` text DEFAULT NULL,
  `ipd_cancel_reason` varchar(255) DEFAULT NULL,
  `ipd_diagnosis` varchar(255) DEFAULT NULL,
  `ipd_investigations` varchar(255) DEFAULT NULL,
  `ipd_treatment_given` text DEFAULT NULL,
  `ipd_treatment_discharge` text DEFAULT NULL,
  `ipd_operation_medicine` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ipd_operation_medicine`)),
  `ipd_operation_medicine_date` date DEFAULT NULL,
  `ipd_bill_amount` varchar(255) NOT NULL DEFAULT '0',
  `ipd_received_amount` varchar(255) NOT NULL DEFAULT '0',
  `ipd_mediclaim` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `ipd_is_foc` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_details`
--

INSERT INTO `ipd_details` (`id`, `ipd_id`, `ipd_added_by`, `ipd_updated_by`, `pa_id`, `ipd_admit_date`, `ipd_doctor`, `ipd_surgery_date`, `ipd_surgery_text`, `rm_id`, `ipd_status`, `ipd_discharge_date`, `ipd_follow_up_date`, `ipd_follow_up_note`, `ipd_cancel_reason`, `ipd_diagnosis`, `ipd_investigations`, `ipd_treatment_given`, `ipd_treatment_discharge`, `ipd_operation_medicine`, `ipd_operation_medicine_date`, `ipd_bill_amount`, `ipd_received_amount`, `ipd_mediclaim`, `ipd_is_foc`, `created_at`, `updated_at`) VALUES
(1, 1288742033, 9622814060, 9622814060, 8059577479, '2024-07-20', 8022048049, '2024-07-22', 'asd qwe', 7012967793, 'admit', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, '70000', '0', 'no', 'no', '2024-07-06 05:21:48', '2024-08-03 09:38:37'),
(2, 7418463651, 9622814060, 9622814060, 1945164148, '2024-07-20', 6636406942, '2024-07-20', 'asd qwe', 4560129688, 'discharged', '2024-07-23', '2024-08-01', NULL, '', 'asd', 'qwe', 'zxc', 'asqwzx', '[{\"medicine_id\":7691745383,\"medicine_val\":\"1\"},{\"medicine_id\":2543858207,\"medicine_val\":\"2\"},{\"medicine_id\":8996985293,\"medicine_val\":\"3\"}]', '2024-07-07', '15000', '530', 'no', 'no', '2024-07-06 05:22:13', '2024-08-04 11:05:15'),
(4, 3245365631, 9622814060, 9622814060, 8823312118, '2024-07-27', 8022048049, '2024-07-31', 'appendix', 8735526459, 'admit', NULL, NULL, NULL, '', '', '', '', '', '[{\"medicine_id\":7691745383,\"medicine_val\":\"3\"},{\"medicine_id\":2543858207,\"medicine_val\":\"3\"}]', '2024-07-27', '16000', '5000', 'no', 'no', '2024-07-27 04:30:31', '2024-08-06 14:39:40'),
(5, 1576522958, 3507097541, 8022048049, 3197211687, '2024-08-04', 8022048049, '2024-08-15', 'appendix', 4867399090, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 'no', 'no', '2024-08-04 05:54:20', '2024-08-04 08:59:29'),
(6, 7326186155, 3507097541, 3507097541, 5981076475, '2024-08-04', 6636406942, '2024-08-13', 'appendix', 5671800060, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 'no', 'no', '2024-08-04 05:54:50', '2024-08-04 05:54:50'),
(7, 1652346691, 9622814060, 9622814060, 2575834800, '2024-08-05', 8022048049, '2024-08-09', 'kidney change', 5704770808, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 'no', 'no', '2024-08-05 14:39:03', '2024-08-05 14:39:03'),
(8, 7311788032, 9622814060, 9622814060, 1945164148, '2024-08-05', 8022048049, '2024-08-07', 'kidney change', 4560129688, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 'no', 'no', '2024-08-05 14:49:04', '2024-08-05 14:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_operative_notes`
--

CREATE TABLE `ipd_operative_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ion_id` bigint(20) NOT NULL,
  `ipd_id` bigint(20) NOT NULL,
  `ion_date` date DEFAULT NULL,
  `ion_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_operative_notes`
--

INSERT INTO `ipd_operative_notes` (`id`, `ion_id`, `ipd_id`, `ion_date`, `ion_note`, `created_at`, `updated_at`) VALUES
(1, 8209026183, 1288742033, '2024-08-03', 'asd sds dsdssddsdsd', '2024-07-06 05:21:48', '2024-08-03 09:39:14'),
(2, 3705381418, 7418463651, '2024-07-07', 'asd qwe', '2024-07-06 05:22:13', '2024-07-06 06:42:29'),
(3, 8215596252, 2807037968, NULL, NULL, '2024-07-14 05:18:50', '2024-07-14 05:18:50'),
(4, 4188429135, 3245365631, '2024-07-27', 'lorem ipsum dolor sit amet adipiscing', '2024-07-27 04:30:31', '2024-07-27 04:32:36'),
(5, 7396691835, 1576522958, NULL, NULL, '2024-08-04 05:54:20', '2024-08-04 05:54:20'),
(6, 3573337733, 7326186155, NULL, NULL, '2024-08-04 05:54:50', '2024-08-04 05:54:50'),
(7, 4002979504, 1652346691, NULL, NULL, '2024-08-05 14:39:03', '2024-08-05 14:39:03'),
(8, 6253198686, 7311788032, NULL, NULL, '2024-08-05 14:49:04', '2024-08-05 14:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_payment_lists`
--

CREATE TABLE `ipd_payment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipl_id` bigint(20) NOT NULL,
  `ipd_id` bigint(20) NOT NULL COMMENT 'ipd detail id',
  `ipl_added_by` bigint(20) NOT NULL COMMENT 'user table id',
  `ipl_paid_by` varchar(255) NOT NULL,
  `ipl_received_by` varchar(255) NOT NULL DEFAULT 'cash' COMMENT 'cash/card/mediclaim/corporate',
  `ipl_amount` int(11) NOT NULL DEFAULT 0,
  `ipl_desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_payment_lists`
--

INSERT INTO `ipd_payment_lists` (`id`, `ipl_id`, `ipd_id`, `ipl_added_by`, `ipl_paid_by`, `ipl_received_by`, `ipl_amount`, `ipl_desc`, `created_at`, `updated_at`) VALUES
(3, 5621270042, 7418463651, 9622814060, 'asd', 'cash', 110, 'asd asd', '2024-07-20 08:28:19', '2024-07-20 08:28:19'),
(4, 7620775439, 7418463651, 9622814060, 'qwe', 'cash', 120, 'asd sd sdsd asd', '2024-07-20 08:28:29', '2024-07-20 08:28:29'),
(7, 3821730557, 7418463651, 9622814060, 'qwe', 'cash', 170, 'aada sdasd', '2024-07-20 08:32:14', '2024-07-20 08:46:23'),
(8, 2110761802, 7418463651, 9622814060, 'asdqwe', 'cheque', 130, 'asda sd sdd asdsd sdsdsd dsdsds d ds as as s as sdf', '2024-07-20 08:41:14', '2024-07-20 08:45:49'),
(14, 3711986254, 3245365631, 9622814060, 'janak soni', 'cash', 2000, 'lorem ipsum', '2024-07-27 04:35:07', '2024-07-27 04:35:07'),
(15, 1573682780, 3245365631, 9622814060, 'tushar', 'card', 3000, 'lorem ipsum', '2024-07-27 04:35:52', '2024-07-27 04:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `mac_addresses`
--

CREATE TABLE `mac_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ma_id` bigint(20) NOT NULL,
  `ma_pc_name` varchar(255) NOT NULL,
  `ma_address` varchar(255) NOT NULL,
  `ma_status` int(11) NOT NULL DEFAULT 1 COMMENT '0-disable/1-enable',
  `ma_added_by` bigint(20) NOT NULL,
  `ma_updated_by` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mac_addresses`
--

INSERT INTO `mac_addresses` (`id`, `ma_id`, `ma_pc_name`, `ma_address`, `ma_status`, `ma_added_by`, `ma_updated_by`, `created_at`, `updated_at`) VALUES
(2, 8255466891, 'ab-pc', '84-EF-18-45-C8-46', 1, 9622814060, 9622814060, '2024-07-01 22:02:04', '2024-07-06 07:00:20'),
(4, 1918881308, 'asdwe', 'asdqwe12', 1, 9622814060, 9622814060, '2024-07-09 14:25:34', '2024-07-09 14:26:24');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_17_104526_create_user_categories_table', 1),
(6, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(7, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(8, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(9, '2016_06_01_000004_create_oauth_clients_table', 2),
(10, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(11, '2024_06_18_030944_add_column_to_user_categories_table', 3),
(12, '2024_06_18_102648_create_visiting_fees_table', 4),
(13, '2024_06_19_062540_create_permission_tables', 5),
(14, '2024_06_19_063619_add_column_to_permissions_table', 6),
(15, '2024_06_19_070913_add_column_to_roles_table', 7),
(16, '2024_06_19_083309_add_column_to_roles_table', 8),
(17, '2024_06_19_112008_create_trainees_table', 9),
(18, '2024_06_20_075240_create_rooms_table', 10),
(19, '2024_06_25_033427_create_general_medicines_table', 11),
(20, '2024_06_25_033436_create_operation_medicines_table', 11),
(21, '2024_06_25_062504_create_referred_doctors_table', 12),
(22, '2024_06_25_073525_create_patients_table', 13),
(23, '2024_06_28_084828_create_appointments_table', 14),
(24, '2024_06_30_082929_create_appointment_medicines_table', 15),
(25, '2024_07_01_103847_create_appointment_additional_charges_table', 16),
(26, '2024_07_02_012320_create_mac_addresses_table', 17),
(27, '2024_07_04_093040_create_ipd_details_table', 18),
(28, '2024_07_06_103053_create_ipd_operative_notes_table', 19),
(29, '2024_07_06_133429_add_column_to_ipd_details_table', 20),
(30, '2024_07_06_143712_add_column_ipd_medicine_to_ipd_details_table', 21),
(31, '2024_07_06_144601_add_column_ipd_medicine_date_to_ipd_details_table', 22),
(32, '2024_07_06_173228_create_ipd_charges_table', 23),
(33, '2024_07_06_173240_create_ipd_payment_lists_table', 23),
(34, '2024_07_06_180451_add_column_mediclaim_foc_to_ipd_details_table', 24),
(35, '2024_08_04_152645_add_column_ap_follow_up_note_to_appointments_table', 25),
(36, '2024_08_04_162205_add_column_ap_follow_up_note_to_ipd_details_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'qvHLji6RGh9gUvM3UIK7f61btVoAAGprGpMEO5N9', NULL, 'http://localhost', 1, 0, 0, '2024-06-17 05:43:28', '2024-06-17 05:43:28'),
(2, NULL, 'Laravel Password Grant Client', '09qk3H446cVb8tQf2fUpQpIi0VTSXlhWlayIfij0', 'users', 'http://localhost', 0, 1, 0, '2024-06-17 05:43:29', '2024-06-17 05:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-17 05:43:28', '2024-06-17 05:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operation_medicines`
--

CREATE TABLE `operation_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `om_id` bigint(20) NOT NULL,
  `om_added_by` bigint(20) NOT NULL,
  `om_updated_by` bigint(20) NOT NULL,
  `om_name` varchar(255) NOT NULL,
  `om_company_name` varchar(255) NOT NULL,
  `om_description` text DEFAULT NULL,
  `om_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active, 0-disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operation_medicines`
--

INSERT INTO `operation_medicines` (`id`, `om_id`, `om_added_by`, `om_updated_by`, `om_name`, `om_company_name`, `om_description`, `om_status`, `created_at`, `updated_at`) VALUES
(1, 8996985293, 9622814060, 9622814060, 'lamolate op', 'New Alpha', 'lamolate op generate by newAlpha', 1, '2024-06-25 00:06:39', '2024-06-25 00:08:40'),
(2, 2543858207, 9622814060, 9622814060, 'op med 2', 'op med com 2', 'asd qwezxc zasd', 1, '2024-06-25 00:08:55', '2024-06-25 01:40:00'),
(3, 7691745383, 9622814060, 9622814060, 'fizer', 'a to b', 'asd asdasasddasd', 1, '2024-07-06 09:39:17', '2024-07-06 09:39:17');

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
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_id` bigint(20) NOT NULL,
  `pa_added_by` bigint(20) NOT NULL COMMENT 'user table id user_id',
  `pa_updated_by` bigint(20) NOT NULL COMMENT 'user table id user_id',
  `pa_name` varchar(255) NOT NULL,
  `pa_contact_no` varchar(255) DEFAULT NULL,
  `pa_alt_contact_no` varchar(255) DEFAULT NULL,
  `pa_email` varchar(255) DEFAULT NULL,
  `pa_address` varchar(255) DEFAULT NULL,
  `pa_city` varchar(255) DEFAULT NULL,
  `pa_pincode` varchar(255) DEFAULT NULL,
  `pa_state` varchar(255) DEFAULT NULL,
  `pa_dob` date NOT NULL,
  `pa_age` varchar(255) DEFAULT NULL,
  `pa_gender` varchar(255) DEFAULT NULL COMMENT 'male/female',
  `pa_marital_status` varchar(255) DEFAULT NULL COMMENT 'married/single/divorced/widow',
  `pa_occupation` varchar(255) DEFAULT NULL,
  `pa_last_monestrual_period` varchar(255) DEFAULT NULL,
  `pa_pregnancy_no` varchar(255) DEFAULT NULL,
  `pa_miscarriages_no` varchar(255) DEFAULT NULL,
  `pa_abortion_no` varchar(255) DEFAULT NULL,
  `pa_children_no` varchar(255) DEFAULT NULL,
  `pa_photo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `pa_tobacco` varchar(255) DEFAULT NULL COMMENT 'no/regular/occasional',
  `pa_smoking` varchar(255) DEFAULT NULL COMMENT 'no/regular/occasional',
  `pa_alcohol` varchar(255) DEFAULT NULL COMMENT 'no/regular/occasional',
  `pa_medical_history` varchar(255) DEFAULT NULL,
  `pa_family_medical_history` varchar(255) DEFAULT NULL,
  `pa_referred_by` varchar(255) DEFAULT NULL COMMENT 'doctor/other',
  `pa_referred_doctor` varchar(255) DEFAULT NULL,
  `pa_referred_text` varchar(255) DEFAULT NULL,
  `pa_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active/0-disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `pa_id`, `pa_added_by`, `pa_updated_by`, `pa_name`, `pa_contact_no`, `pa_alt_contact_no`, `pa_email`, `pa_address`, `pa_city`, `pa_pincode`, `pa_state`, `pa_dob`, `pa_age`, `pa_gender`, `pa_marital_status`, `pa_occupation`, `pa_last_monestrual_period`, `pa_pregnancy_no`, `pa_miscarriages_no`, `pa_abortion_no`, `pa_children_no`, `pa_photo`, `pa_tobacco`, `pa_smoking`, `pa_alcohol`, `pa_medical_history`, `pa_family_medical_history`, `pa_referred_by`, `pa_referred_doctor`, `pa_referred_text`, `pa_status`, `created_at`, `updated_at`) VALUES
(1, 1929125286, 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 06:55:53', '2024-06-25 06:55:53'),
(2, 6900526422, 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-01', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:06:17', '2024-06-25 07:06:17'),
(3, 6687313469, 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, 'asd@gmail.com', NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:34:18', '2024-06-25 07:34:18'),
(4, 9331608184, 9622814060, 9622814060, 'Abhay Luva', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:34:55', '2024-06-25 07:34:55'),
(5, 2866803113, 9622814060, 9622814060, 'Abhay Luva', NULL, '1234567890', NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:35:48', '2024-06-25 07:35:48'),
(6, 7605637159, 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-25', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:36:35', '2024-06-25 07:36:35'),
(7, 7800965725, 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, 'asd1@gmail.com', NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:36:53', '2024-06-26 07:43:24'),
(8, 6625798458, 9622814060, 9622814060, 'Ab Lov', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2008-01-01', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:21:27', '2024-06-27 23:21:27'),
(9, 2575834800, 9622814060, 9622814060, 'ab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2005-01-01', '19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'doctor', 'ab', NULL, 1, '2024-06-27 23:23:02', '2024-06-27 23:23:02'),
(10, 2926564244, 9622814060, 8022048049, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-28', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:25:35', '2024-08-06 02:27:18'),
(11, 4151464738, 9622814060, 9622814060, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-05', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"4151464738-6068944068.png\"]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:26:49', '2024-06-27 23:26:49'),
(12, 8561981100, 9622814060, 9622814060, 'Ab Luva', '1234567891', '1234567891', 'asd2@gmail.com', 'b-4, anand nagar, dwarkadhish society', 'upleta', '360490', 'gujarat', '1997-01-01', '27', 'male', 'married', 'IT Employee', 'asd', '1', '1', '0', '0', '[\"8561981100-3018767396.jpg\"]', 'no', 'occational', 'regular', 'yes, corona sergery', 'yes, corona hospitality', 'other', NULL, 'as dqwq 1', 1, '2024-06-27 23:33:01', '2024-07-01 02:15:23'),
(13, 1945164148, 9622814060, 9622814060, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-05', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"1945164148-4916246574.jpg\"]', NULL, NULL, NULL, NULL, NULL, 'other', NULL, 'asd qwe', 1, '2024-06-28 01:08:14', '2024-06-28 01:30:35'),
(14, 8059577479, 9622814060, 9622814060, 'asd 123', NULL, NULL, NULL, 'b-4, anand nagar, dwarkadhish society', 'upleta', '360490', 'gujarat', '2012-01-05', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"[\\\\\\\"\\\\\\\"]\\\"]\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-28 05:33:02', '2024-07-06 11:45:43'),
(15, 8823312118, 9622814060, 9622814060, 'Janak Soni', '1234567894', NULL, 'janaka@gmail.com', 'asd qwe zxc', 'gandhinagar', '123456', 'gujarat', '2012-12-31', '11', 'male', 'married', 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Side', NULL, 1, '2024-07-07 06:19:53', '2024-07-07 06:21:45'),
(16, 6007062775, 9622814060, 9622814060, 'patient 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1987-12-28', '36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"[\\\\\\\"\\\\\\\"]\\\"]\"]', NULL, NULL, NULL, NULL, NULL, 'other', NULL, 'ab aca', 1, '2024-07-09 15:54:45', '2024-07-09 15:55:25'),
(17, 8029440359, 9622814060, 9622814060, 'patient 2', '1234567890', '1234567890', 'asd@gmail.com', NULL, NULL, NULL, NULL, '2003-01-01', '21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"[\\\\\\\"\\\\\\\"]\\\"]\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-07-09 16:00:37', '2024-07-09 16:01:15'),
(18, 3197211687, 3507097541, 3507097541, 'Bijal Patel', '12345679890', NULL, 'bijal@gmail.com', 'b-4, drwarkadhish, west gate', 'ahmedabad', '360005', 'gujarat', '1987-01-01', '37', 'female', 'married', 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"3197211687-9089431884.png\"]', 'no', 'no', 'occational', 'no', 'no', 'doctor', 'Raj Mehta', NULL, 1, '2024-08-04 04:57:55', '2024-08-04 04:57:55'),
(19, 5981076475, 3507097541, 8022048049, 'Khyaati Parekh', '1234567890', NULL, 'khyati@gmail.com', 'b-4, anand nagar, dwarkadhish society', NULL, NULL, NULL, '1991-01-01', '33', 'female', NULL, 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"5981076475-1084817721.png\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-04 04:59:09', '2024-08-06 02:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `guard_name`, `section`, `created_at`, `updated_at`) VALUES
(5, 'category-read', 'Read Category', 'web', 'category', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(6, 'category-create', 'Create Category', 'web', 'category', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(7, 'category-update', 'Update Category', 'web', 'category', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(8, 'category-status', 'Status Category', 'web', 'category', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(9, 'user-read', 'Read User', 'web', 'user', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(10, 'user-create', 'Create User', 'web', 'user', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(11, 'user-update', 'Update User', 'web', 'user', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(13, 'user-status', 'Status User', 'web', 'user', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(14, 'visiting-fee-read', 'Read Visiting Fee', 'web', 'visiting-fee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(15, 'visiting-fee-update', 'Update Visiting Fee', 'web', 'visiting-fee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(16, 'trainee-read', 'Read Trainee', 'web', 'trainee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(17, 'trainee-create', 'Create Trainee', 'web', 'trainee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(18, 'trainee-update', 'Update Trainee', 'web', 'trainee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(19, 'trainee-status', 'Status Trainee', 'web', 'trainee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(20, 'trainee-certificate', 'Certificate Trainee', 'web', 'trainee', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(21, 'room-read', 'Read Room', 'web', 'room', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(22, 'room-create', 'Create Room', 'web', 'room', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(23, 'room-update', 'Update Room', 'web', 'room', '2024-06-19 06:54:52', '2024-06-19 06:54:52'),
(24, 'room-status', 'Status Room', 'web', 'room', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(25, 'general-medicine-read', 'Read General Medicine', 'web', 'general-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(26, 'general-medicine-create', 'Create General Medicine', 'web', 'general-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(27, 'general-medicine-update', 'Update General Medicine', 'web', 'general-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(28, 'general-medicine-status', 'Status General Medicine', 'web', 'general-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(30, 'operation-medicine-read', 'Read Operation Medicine', 'web', 'operation-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(31, 'operation-medicine-create', 'Create Operation Medicine', 'web', 'operation-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(32, 'operation-medicine-update', 'Update Operation Medicine', 'web', 'operation-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(33, 'operation-medicine-status', 'Status Operation Medicine', 'web', 'operation-medicine', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(34, 'referred-doctor-read', 'Read Referred Doctor', 'web', 'referred-doctor', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(35, 'referred-doctor-create', 'Create Referred Doctor', 'web', 'referred-doctor', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(36, 'referred-doctor-update', 'Update Referred Doctor', 'web', 'referred-doctor', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(38, 'patient-read', 'Read Patient', 'web', 'patient', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(39, 'patient-create', 'Create Patient', 'web', 'patient', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(40, 'patient-update', 'Update Patient', 'web', 'patient', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(41, 'patient-status', 'Status Patient', 'web', 'patient', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(42, 'mac-address-read', 'Read Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(43, 'mac-address-create', 'Create Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(44, 'mac-address-update', 'Update Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(45, 'mac-address-status', 'Status Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(46, 'mac-address-remove', 'Remove Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referred_doctors`
--

CREATE TABLE `referred_doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rd_id` bigint(20) NOT NULL,
  `rd_added_by` bigint(20) NOT NULL,
  `rd_updated_by` bigint(20) NOT NULL,
  `rd_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referred_doctors`
--

INSERT INTO `referred_doctors` (`id`, `rd_id`, `rd_added_by`, `rd_updated_by`, `rd_name`, `created_at`, `updated_at`) VALUES
(1, 3751581945, 9622814060, 9622814060, 'Anuj Mehta 1', '2024-06-25 01:53:07', '2024-06-25 01:56:26'),
(2, 5782071877, 9622814060, 9622814060, 'Raj Mehta', '2024-06-25 04:11:44', '2024-06-25 04:11:44'),
(3, 6286740018, 9622814060, 9622814060, 'Bhuvan Bam', '2024-06-25 04:12:00', '2024-06-25 04:12:00'),
(4, 3724492770, 9622814060, 9622814060, 'Shreya Mahajan', '2024-06-25 04:12:13', '2024-06-25 04:12:13'),
(5, 9868413309, 9622814060, 9622814060, 'Dash Babu', '2024-06-25 04:12:21', '2024-06-25 04:12:21'),
(6, 9519267796, 9622814060, 9622814060, 'Aniket Sharma', '2024-06-25 04:12:29', '2024-06-25 04:12:29'),
(7, 1780005901, 9622814060, 9622814060, 'Ab Lov', '2024-06-27 23:21:27', '2024-06-27 23:21:27'),
(8, 1679696064, 9622814060, 9622814060, 'ab', '2024-06-27 23:23:02', '2024-06-27 23:23:02'),
(9, 6882550336, 9622814060, 9622814060, 'asd wqe', '2024-07-07 06:07:54', '2024-07-07 06:07:54'),
(10, 1702802074, 9622814060, 9622814060, 'Ab Side', '2024-07-07 06:19:53', '2024-07-07 06:19:53'),
(11, 5877398144, 9622814060, 9622814060, 'axa', '2024-07-09 15:54:45', '2024-07-09 15:54:45'),
(12, 3457506543, 9622814060, 9622814060, 'ab aca', '2024-07-09 15:55:07', '2024-07-09 15:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `role_status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `guard_name`, `role_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'web', 1, '2024-06-19 02:46:26', '2024-06-19 02:46:26'),
(2, 'doctor', 'Doctor', 'web', 1, '2024-06-19 02:48:06', '2024-06-19 02:48:06'),
(3, 'assistant_doctor', 'Asisstand Doctor', 'web', 1, '2024-06-19 02:52:29', '2024-06-19 02:52:29'),
(4, 'accountant', 'Accountant', 'web', 1, '2024-06-19 02:52:57', '2024-06-19 02:52:57'),
(5, 'receptionist', 'Receptionist', 'web', 1, '2024-06-19 02:53:19', '2024-06-19 02:53:19'),
(6, 'administration', 'Administration', 'web', 1, '2024-06-19 03:08:12', '2024-06-19 04:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 6),
(6, 1),
(6, 6),
(7, 1),
(8, 1),
(9, 1),
(9, 2),
(9, 4),
(9, 6),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 6),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(25, 5),
(26, 1),
(26, 5),
(27, 1),
(27, 5),
(28, 1),
(28, 5),
(30, 1),
(30, 5),
(31, 1),
(31, 5),
(32, 1),
(32, 5),
(33, 1),
(33, 5),
(34, 1),
(35, 1),
(36, 1),
(38, 1),
(38, 2),
(38, 5),
(39, 1),
(39, 2),
(39, 5),
(40, 1),
(40, 2),
(40, 5),
(41, 1),
(41, 2),
(41, 5),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rm_id` bigint(20) NOT NULL,
  `rm_added_by` bigint(20) NOT NULL,
  `rm_updated_by` bigint(20) NOT NULL,
  `rm_building` varchar(255) NOT NULL,
  `rm_floor` varchar(255) NOT NULL,
  `rm_ward` varchar(255) NOT NULL,
  `rm_no` varchar(255) NOT NULL,
  `rm_charge` int(11) NOT NULL,
  `rm_busy` int(11) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `rm_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active, 0-Disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `rm_id`, `rm_added_by`, `rm_updated_by`, `rm_building`, `rm_floor`, `rm_ward`, `rm_no`, `rm_charge`, `rm_busy`, `rm_status`, `created_at`, `updated_at`) VALUES
(1, 2019521619, 9622814060, 9622814060, 'A', '1', 'A', '1001', 1025, 0, 1, '2024-06-20 06:40:34', '2024-06-22 01:29:18'),
(2, 3270399048, 9622814060, 9622814060, 'A', '1', 'A', '1002', 1050, 0, 1, '2024-06-20 06:48:26', '2024-06-22 01:23:02'),
(3, 3808088254, 9622814060, 9622814060, 'A', '1', 'A', '1003', 1050, 0, 1, '2024-06-22 01:31:49', '2024-06-22 01:31:49'),
(4, 5470180138, 9622814060, 9622814060, 'B', '1', 'A', '1001', 750, 0, 1, '2024-06-23 22:00:25', '2024-06-23 22:00:25'),
(5, 4731515019, 9622814060, 9622814060, 'B', '1', 'A', '1002', 750, 0, 1, '2024-06-23 22:00:56', '2024-06-23 22:00:56'),
(6, 1763176195, 9622814060, 9622814060, 'B', '1', 'B', '101', 450, 0, 1, '2024-06-23 22:01:19', '2024-06-23 22:01:19'),
(7, 9657298017, 9622814060, 9622814060, 'B', '1', 'B', '102', 450, 0, 1, '2024-06-23 22:01:29', '2024-06-23 22:01:29'),
(8, 3939260528, 9622814060, 9622814060, 'B', '2', 'A', '101', 450, 0, 1, '2024-06-23 22:01:44', '2024-06-23 22:01:44'),
(9, 8346064090, 9622814060, 9622814060, 'B', '2', 'A', '102', 450, 0, 1, '2024-06-23 22:02:17', '2024-06-23 22:02:17'),
(10, 3532694461, 9622814060, 9622814060, 'A', '1', 'B', '101', 450, 0, 1, '2024-06-23 22:02:30', '2024-06-23 22:02:30'),
(11, 9318726306, 9622814060, 9622814060, 'A', '1', 'B', '102', 450, 0, 1, '2024-06-23 22:02:37', '2024-06-23 22:02:37'),
(12, 7623041434, 9622814060, 9622814060, 'A', '2', 'B', '101', 450, 0, 1, '2024-06-23 22:02:49', '2024-06-23 22:02:49'),
(13, 6013882173, 9622814060, 9622814060, 'A', '2', 'B', '102', 500, 0, 1, '2024-06-23 22:02:57', '2024-06-23 22:02:57'),
(14, 5671800060, 9622814060, 9622814060, 'C', '1', 'A', '101', 700, 1, 1, '2024-06-23 22:03:25', '2024-08-04 05:54:50'),
(15, 1745383720, 9622814060, 9622814060, 'C', '1', 'A', '102', 700, 0, 1, '2024-06-23 22:03:30', '2024-06-23 22:03:30'),
(16, 4867399090, 9622814060, 9622814060, 'C', '1', 'A', '103', 700, 1, 1, '2024-06-23 22:03:38', '2024-08-04 08:59:29'),
(17, 7626108364, 9622814060, 9622814060, 'C', '2', 'A', '101', 700, 0, 1, '2024-06-23 22:03:54', '2024-06-23 22:03:54'),
(18, 5704770808, 9622814060, 9622814060, 'C', '3', 'A', '101', 700, 1, 1, '2024-06-23 22:04:03', '2024-08-05 14:39:03'),
(19, 8735526459, 9622814060, 9622814060, 'C', '1', 'B', '101', 700, 1, 1, '2024-06-23 22:04:16', '2024-08-03 09:34:49'),
(20, 4560129688, 9622814060, 9622814060, 'C', '1', 'B', '102', 700, 1, 1, '2024-06-23 22:04:21', '2024-08-05 14:49:04'),
(21, 7012967793, 9622814060, 9622814060, 'C', '1', 'B', '103', 700, 1, 1, '2024-06-23 22:04:26', '2024-07-16 02:45:32'),
(22, 3125880756, 9622814060, 9622814060, 'A', '1', 'A', '1004', 123, 1, 1, '2024-07-07 05:56:45', '2024-07-14 05:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `trainees`
--

CREATE TABLE `trainees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tr_id` bigint(20) NOT NULL,
  `tr_added_by` bigint(20) NOT NULL COMMENT 'user table id user_id',
  `tr_updated_by` bigint(20) NOT NULL COMMENT 'first time same as tr_added_by and next time updated user_id',
  `tr_real_id` bigint(20) NOT NULL,
  `tr_name` varchar(255) NOT NULL,
  `tr_address` varchar(255) NOT NULL,
  `tr_contact_no` varchar(255) NOT NULL,
  `tr_start_date` date NOT NULL,
  `tr_end_date` date NOT NULL,
  `tr_total_amount` int(11) NOT NULL,
  `tr_paid_amount` int(11) DEFAULT NULL,
  `tr_is_advance_received` int(11) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `tr_advance_received_date` date DEFAULT NULL,
  `tr_remarks` text DEFAULT NULL,
  `tr_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tr_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-pending, 2-completed, 3-cancelled',
  `tr_reason_cancel` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainees`
--

INSERT INTO `trainees` (`id`, `tr_id`, `tr_added_by`, `tr_updated_by`, `tr_real_id`, `tr_name`, `tr_address`, `tr_contact_no`, `tr_start_date`, `tr_end_date`, `tr_total_amount`, `tr_paid_amount`, `tr_is_advance_received`, `tr_advance_received_date`, `tr_remarks`, `tr_documents`, `tr_status`, `tr_reason_cancel`, `created_at`, `updated_at`) VALUES
(1, 8752977292, 9622814060, 9622814060, 202406200422057865, 'trainee 1', 'asdqweqw', '1234567890', '2024-06-21', '2024-06-22', 123, 12, 0, '2024-06-20', 'zxc', '', 2, NULL, '2024-06-19 22:52:45', '2024-06-19 23:38:28'),
(2, 5304220658, 9622814060, 9622814060, 202406200459003857, 'trainee 2', 'asd qwe', '1234523456', '2024-06-21', '2024-06-23', 1234, 123, 1, '2024-06-20', 'zxc asd', '', 1, '', '2024-06-19 23:29:28', '2024-06-20 01:36:37'),
(3, 1809272463, 9622814060, 9622814060, 2024062007301719, 'trainee 3', 'asd qwezxc', '1234565432', '2024-06-29', '2024-06-30', 1234, 121, 1, '2024-06-20', 'zczs a s', '', 1, NULL, '2024-06-20 02:13:12', '2024-06-20 02:13:12'),
(5, 3873229805, 9622814060, 9622814060, 2024062211834683, 'trainee 4', 'asd', '1234567890', '2024-06-22', '2024-06-23', 123, NULL, 0, NULL, '', '[\"2024062211834683-6709272792.jpg\",\"2024062211834683-8344738238.jpg\"]', 1, NULL, '2024-06-22 05:46:34', '2024-06-22 07:25:26'),
(6, 1770634799, 9622814060, 9622814060, 2024062212717757, 'trainee 5', 'asds', '1234567890', '2024-06-23', '2024-06-24', 123, NULL, 0, NULL, '', NULL, 1, NULL, '2024-06-22 07:06:04', '2024-06-22 07:06:04'),
(7, 8409699172, 9622814060, 9622814060, 2024070711919847, 'ab trainee', 'asd', '1234567890', '2024-07-10', '2024-07-16', 15000, 3000, 1, '2024-07-07', 'qwe', '[\"2024070711919847-6442725842.png\"]', 1, NULL, '2024-07-07 05:43:31', '2024-07-07 05:43:31'),
(8, 4843724109, 9622814060, 9622814060, 2024070711919847, 'ab trainee', 'asd', '1234567890', '2024-07-10', '2024-07-16', 15000, 3000, 1, '2024-07-07', 'qwe', '[\"2024070711919847-2283185294.png\"]', 1, NULL, '2024-07-07 05:43:31', '2024-07-07 05:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `contactno` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `added_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1 COMMENT '0-disable,1-enable',
  `show_to_doctor_list` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `email_verified_at`, `password`, `person_name`, `contactno`, `address`, `added_by`, `updated_by`, `user_status`, `show_to_doctor_list`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 9622814060, 'super_admin', 'superadmin@gmail.com', '2024-06-17 06:27:21', '$2y$12$.OnlOXKQC.UlJqRQc2n5Hue9evXhVsxA8nYW2t6fBPnJ/OR/r2eeW', 'Super Admin', 1234567890, 'EVA hospital, Ahmedabad', 9622814060, 9622814060, 1, 1, 'Nv3Cx1YofsL4rL7OlTXnjY82nI9SxOuR17GMWhJQwBbxnmC3S3bLYwzHo7OO', '2024-06-17 06:27:21', '2024-07-27 07:52:16'),
(2, 5962819849, 'abhay_luva', 'ablov@gmail.com', NULL, '$2y$12$uJN2Ddjob97F7vqw2ufkROYVoNYa1JNOVEb4QYX3xpoS3Wuu8bsgG', 'Abhay Luva', 1245784251, 'dwarkadhish so, anand nagar, beind vrajwihar, rajkot', 9622814060, 9622814060, 1, 1, NULL, '2024-06-18 03:29:40', '2024-06-28 06:09:51'),
(3, 8022048049, 'haresh_bhai', 'hr@gmail.com', NULL, '$2y$12$lxNz9YPwZN6lJpCdg4Q3reDnW4xDdaC6ZIBvNJzerSDKgKdJEguH2', 'Haresh Bhai', 1245784251, 'asasds sas adsd', 5962819849, 9622814060, 1, 1, NULL, '2024-06-18 03:47:03', '2024-06-28 06:08:36'),
(4, 6636406942, 'raj', 'raj@gmail.com', NULL, '$2y$12$jmAFeQGPaIgM.DhK.dGrM.sVk7ODQ4ufKVqKXpzJ7DCwRRYokVtyG', 'Raj Bhai', 1234567890, 'asd as dasdasda', 9622814060, 9622814060, 1, 1, NULL, '2024-06-19 04:20:03', '2024-06-28 06:09:42'),
(5, 7308573809, 'pankit', 'pk@gmail.com', NULL, '$2y$12$k.pdzDXoH5nfTQVLUUG6HOFla1y7M8f4E5nI25KbySMhhPdeKqyWa', 'pankit', 1234567890, 'asd qwe zxc', 9622814060, 9622814060, 1, 1, NULL, '2024-06-28 06:09:26', '2024-06-28 06:09:26'),
(7, 3507097541, 'akshar_shah', 'akshar@gmail.com', NULL, '$2y$12$d1vYivDld.c2lnc/zA2da.8Ob4./8z7cFuThQCcvDjOMrYTU1vC7G', 'Akshar Shah', 1234567890, 'as dsdasdsdadasd asdasd asdas', 9622814060, 9622814060, 1, 1, NULL, '2024-08-04 04:45:34', '2024-08-04 04:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `visiting_fees`
--

CREATE TABLE `visiting_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vf_id` bigint(20) NOT NULL,
  `vf_added_by` bigint(20) NOT NULL,
  `vf_updated_by` bigint(20) NOT NULL,
  `vf_case_type` varchar(255) NOT NULL COMMENT 'old/new/emergency',
  `vf_fees` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visiting_fees`
--

INSERT INTO `visiting_fees` (`id`, `vf_id`, `vf_added_by`, `vf_updated_by`, `vf_case_type`, `vf_fees`, `created_at`, `updated_at`) VALUES
(1, 9934151253, 9622814060, 9622814060, 'old', 200, '2024-06-18 10:36:43', '2024-06-18 10:36:43'),
(2, 8104572865, 9622814060, 9622814060, 'new', 500, '2024-06-18 10:36:43', '2024-06-18 10:36:43'),
(3, 7406112400, 9622814060, 9622814060, 'emergency', 700, '2024-06-18 10:37:54', '2024-07-27 05:17:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_ap_id_index` (`ap_id`),
  ADD KEY `appointments_pa_id_index` (`pa_id`),
  ADD KEY `appointments_ap_doctor_index` (`ap_doctor`),
  ADD KEY `appointments_ap_date_index` (`ap_date`),
  ADD KEY `appointments_ap_case_type_index` (`ap_case_type`),
  ADD KEY `appointments_ap_status_index` (`ap_status`),
  ADD KEY `appointments_ap_surg_required_index` (`ap_surg_required`),
  ADD KEY `appointments_ap_is_foc_index` (`ap_is_foc`),
  ADD KEY `appointments_ap_is_workshop_index` (`ap_is_workshop`);

--
-- Indexes for table `appointment_additional_charges`
--
ALTER TABLE `appointment_additional_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_additional_charges_ap_id_index` (`ap_id`);

--
-- Indexes for table `appointment_medicines`
--
ALTER TABLE `appointment_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_medicines_gm_id_index` (`gm_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_medicines`
--
ALTER TABLE `general_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `general_medicines_gm_id_index` (`gm_id`),
  ADD KEY `general_medicines_gm_name_index` (`gm_name`),
  ADD KEY `general_medicines_gm_company_name_index` (`gm_company_name`);

--
-- Indexes for table `ipd_charges`
--
ALTER TABLE `ipd_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_details`
--
ALTER TABLE `ipd_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ipd_details_pa_id_index` (`pa_id`),
  ADD KEY `ipd_details_ipd_admit_date_index` (`ipd_admit_date`);

--
-- Indexes for table `ipd_operative_notes`
--
ALTER TABLE `ipd_operative_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ipd_operative_notes_ipd_id_index` (`ipd_id`);

--
-- Indexes for table `ipd_payment_lists`
--
ALTER TABLE `ipd_payment_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mac_addresses`
--
ALTER TABLE `mac_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mac_addresses_ma_addresses_index` (`ma_address`),
  ADD KEY `ma_pc_name` (`ma_pc_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `operation_medicines`
--
ALTER TABLE `operation_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operation_medicines_om_id_index` (`om_id`),
  ADD KEY `operation_medicines_om_name_index` (`om_name`),
  ADD KEY `operation_medicines_om_company_name_index` (`om_company_name`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_pa_id_index` (`pa_id`),
  ADD KEY `patients_pa_name_index` (`pa_name`),
  ADD KEY `patients_pa_contact_no_index` (`pa_contact_no`),
  ADD KEY `patients_pa_alt_contact_no_index` (`pa_alt_contact_no`),
  ADD KEY `patients_pa_email_index` (`pa_email`),
  ADD KEY `patients_pa_dob_index` (`pa_dob`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `referred_doctors`
--
ALTER TABLE `referred_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_rm_id_index` (`rm_id`),
  ADD KEY `rooms_rm_no_index` (`rm_no`),
  ADD KEY `rooms_rm_charge_index` (`rm_charge`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainees_tr_name_index` (`tr_name`),
  ADD KEY `trainees_tr_contact_no_index` (`tr_contact_no`),
  ADD KEY `trainees_tr_start_date_index` (`tr_start_date`),
  ADD KEY `trainees_tr_end_date_index` (`tr_end_date`),
  ADD KEY `trainees_tr_status_index` (`tr_status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_user_id_index` (`user_id`),
  ADD KEY `name` (`name`,`person_name`);

--
-- Indexes for table `visiting_fees`
--
ALTER TABLE `visiting_fees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `appointment_additional_charges`
--
ALTER TABLE `appointment_additional_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `appointment_medicines`
--
ALTER TABLE `appointment_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_medicines`
--
ALTER TABLE `general_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ipd_charges`
--
ALTER TABLE `ipd_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ipd_details`
--
ALTER TABLE `ipd_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ipd_operative_notes`
--
ALTER TABLE `ipd_operative_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ipd_payment_lists`
--
ALTER TABLE `ipd_payment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mac_addresses`
--
ALTER TABLE `mac_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `operation_medicines`
--
ALTER TABLE `operation_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referred_doctors`
--
ALTER TABLE `referred_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `trainees`
--
ALTER TABLE `trainees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `visiting_fees`
--
ALTER TABLE `visiting_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
