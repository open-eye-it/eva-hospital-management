-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 03:58 PM
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
  `pa_id` varchar(255) NOT NULL,
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
  `ap_charge_status` varchar(255) NOT NULL DEFAULT '''pending''' COMMENT 'pending, paid',
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
  `pa_last_monestrual_period` varchar(255) DEFAULT NULL,
  `pa_pregnancy_no` varchar(255) DEFAULT NULL,
  `pa_miscarriages_no` varchar(255) DEFAULT NULL,
  `pa_abortion_no` varchar(255) DEFAULT NULL,
  `pa_children_no` varchar(255) DEFAULT NULL,
  `pa_tobacco` varchar(255) DEFAULT NULL,
  `pa_smoking` varchar(255) DEFAULT NULL,
  `pa_alcohol` varchar(255) DEFAULT NULL,
  `pa_medical_history` varchar(255) DEFAULT NULL,
  `pa_family_medical_history` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `ap_id`, `pa_id`, `ap_added_by`, `ap_updated_by`, `ap_height`, `ap_weight`, `ap_bp`, `ap_doctor`, `ap_date`, `ap_book_via`, `ap_case_type`, `ap_charge`, `ap_charge_status`, `ap_additional_charge`, `ap_payment_mode`, `ap_payment_detail`, `ap_status`, `ap_status_reaason`, `ap_complaint`, `ap_other_detail`, `ap_any_advice`, `ap_follow_up_date`, `ap_follow_up_note`, `ap_surg_required`, `ap_surg_date`, `ap_surg_type`, `ap_is_foc`, `ap_is_workshop`, `pa_last_monestrual_period`, `pa_pregnancy_no`, `pa_miscarriages_no`, `pa_abortion_no`, `pa_children_no`, `pa_tobacco`, `pa_smoking`, `pa_alcohol`, `pa_medical_history`, `pa_family_medical_history`, `created_at`, `updated_at`) VALUES
(1, 6963429058, '8561981100', 9622814060, 9622814060, '5\'3\'', '68', '120', 8022048049, '2024-07-01', 'asdqwe', 'new', '500', 'paid', '1000', 'card', '', 'completed', '', 'asd', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'qwe', '2024-07-06', NULL, 'yes', '2024-07-12', 'qwe', 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-28 20:22:25', '2024-07-03 09:35:30'),
(2, 5634636981, '6625798458', 9622814060, 9622814060, '5\'4\'\'', '69', '121', 6636406942, '2024-07-02', 'asdqwe1', 'emergency', '700', 'paid', '1450', 'mediclaim', NULL, 'pending', NULL, NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-29 01:19:08', '2024-07-01 23:12:43'),
(3, 3701918849, '6625798458', 9622814060, 9622814060, '5\'3\'\'', '68', '120', 5962819849, '2024-07-01', 'asdqwe', 'new', '500', 'paid', '2500', 'cash', 'asd qwe 12', 'pending', NULL, NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, '2024-07-03', NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-29 04:51:04', '2024-12-01 04:22:00'),
(4, 1203444812, '8059577479', 9622814060, 8022048049, '5\'3\'\'', '69', '121', 5962819849, '2024-07-01', 'asdqwe', 'old', '200', 'paid', '0', 'cash', 'asdqwe', 'completed', '', 'asdqwe', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asd\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'qwezxc', '2024-07-03', '', 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-02 06:13:59', '2024-08-04 10:40:50'),
(5, 9513724655, '1945164148', 9622814060, 8022048049, '5\'4\'\'', '69', '121', 7308573809, '2024-07-01', 'asdqwe1', 'new', '500', 'paid', '480', 'cash', 'asdqwe', 'completed', '', 'dasd', 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', 'swe', '2024-07-03', NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-02 06:15:56', '2024-08-04 11:05:30'),
(6, 7693448549, '8059577479', 9622814060, 9622814060, '5\'3\'\'', '70', '120', 6636406942, '2024-07-07', 'asdqwe', 'old', '200', 'paid', '400', 'cash', 'asdz qwe', 'cancelled', 'asd', NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-06 11:36:20', '2024-08-04 02:01:51'),
(7, 6627154988, '8823312118', 9622814060, 8022048049, '5\'3\'\'', '70', '120', 8022048049, '2024-07-07', 'asdqwe', 'old', '200', 'paid', '300', 'card', 'asd', 'completed', '', NULL, 'MENSTRUAL HISTORY\n- LMP : asd\n- CYCLES : REGULAR / IRREGULAR\n- NO. OF DAYS : qwe\n- LASTING FOR : zxc\n- BLOOD FLOW : AVERAGE / NORMAL / HEAVY\n- CLOTS : Yes / No\n- DYSMENNORHAGIA : asdqwe\n\nOBSTETRIC HISTORY : qwezxc\n\nPERSONAL HISTORY : zxcasd\n\nPAST HISTORY : asqw\n\nFAMILY HISTORY : qwzx\n\nEXAMINATION : zxas\n\nINVESTIGATIONS\n- USG : asdqw\n- CT/MRI : qwezx\n\nPROVISIONAL DIAGNOSIS : zxcas', NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-07 06:30:18', '2024-08-05 14:31:29'),
(8, 2666185699, '3197211687', 3507097541, 3507097541, '5\'3\'\'', '70', '120', 8022048049, '2024-08-04', 'asdqwe12', 'new', '500', 'paid', '0', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-04 05:02:35', '2024-08-04 05:02:35'),
(9, 9247888596, '5981076475', 3507097541, 3507097541, '5\'4\'\'', '70', '121', 6636406942, '2024-08-04', 'asdqwe1', 'new', '500', 'paid', '760', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-04 05:03:37', '2024-12-04 01:44:53'),
(10, 9881264608, '3197211687', 8022048049, 8022048049, '5\'3\'\'', '67', '120', 8022048049, '2024-08-04', 'asdqwe1', 'old', '200', 'paid', '150', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-04 09:34:44', '2024-08-04 09:41:35'),
(13, 5745563744, '5981076475', 9622814060, 9622814060, NULL, NULL, NULL, 8022048049, '2024-08-12', 'asdqwe', 'emergency', '700', 'paid', '0', 'cash', NULL, 'pending', '', NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-12 15:56:21', '2024-08-12 16:02:43'),
(19, 8435299711, '5981076475', 9622814060, 9622814060, '5\'3\'\'', '56', '120', 8022048049, '2024-08-15', 'asdqwe', 'new', '500', 'paid', '1150', 'corporate', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-14 01:52:41', '2024-12-01 06:55:48'),
(20, 6655705781, '6625798458', 9152073037, 9152073037, '5\'3\'\'', '56', '120', 9152073037, '2024-12-01', 'asdqwe', 'emergency', '700', 'paid', '0', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 08:45:36', '2024-12-01 08:45:36'),
(21, 5749515670, 'EVA202412011', 9622814060, 9622814060, '5\'3\'\'', '56', '120', 6636406942, '2024-12-01', 'asdqwe', 'old', '200', 'paid', '0', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-01 10:46:48', '2024-12-04 01:54:18'),
(22, 7141925655, 'EVA202412281', 9622814060, 9622814060, '5\'3\'\'', '56', '120', 8022048049, '2025-01-12', 'asdqwe', 'foc', '200', 'pending', '0', 'card', 'asd qwe zxc', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-12 07:33:34', '2025-01-12 07:59:23'),
(24, 9566903699, 'EVA202501131', 9622814060, 9622814060, '5\'3\'\'', '56', '120', 8022048049, '2025-01-13', 'asdqwe', 'new', '500', 'pending', '0', 'cash', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'no', NULL, NULL, 'no', 'no', 'asd sd', '1', '0', NULL, '1', 'no', 'no', 'no', 'asd qwe zxc', 'asdqwe qwezxc', '2025-01-13 12:04:28', '2025-01-13 12:11:24');

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
  `apac_payment_mode` varchar(255) NOT NULL DEFAULT '''cash''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_additional_charges`
--

INSERT INTO `appointment_additional_charges` (`id`, `apac_id`, `ap_id`, `apac_added_by`, `apac_desc`, `apac_qty`, `apac_charge`, `apac_final_charge`, `apac_payment_mode`, `created_at`, `updated_at`) VALUES
(1, 7553850535, 3701918849, 9622814060, 'asd', '2', '200', '400', 'cash', '2024-07-01 05:37:32', '2024-07-01 05:37:32'),
(2, 6619249790, 3701918849, 9622814060, 'asd', '2', '200', '400', 'cash', '2024-07-01 05:37:58', '2024-07-01 05:37:58'),
(3, 8262964947, 3701918849, 9622814060, 'asd', '2', '200', '400', 'card', '2024-07-01 05:38:22', '2024-07-01 05:38:22'),
(4, 7226695866, 3701918849, 9622814060, 'asd', '2', '100', '200', 'card', '2024-07-01 05:39:10', '2024-07-01 05:39:10'),
(5, 3761772163, 3701918849, 9622814060, 'asd', '2', '100', '200', 'cash', '2024-07-01 05:39:34', '2024-07-01 05:39:34'),
(6, 7812841552, 3701918849, 9622814060, 'xc', '1', '100', '100', 'cash', '2024-07-01 05:43:46', '2024-07-01 05:43:46'),
(7, 6049170224, 3701918849, 9622814060, 'er', '1', '100', '100', 'cash', '2024-07-01 05:43:58', '2024-07-01 05:43:58'),
(9, 6075198274, 5634636981, 9622814060, 'as 12', '2', '300', '600', 'mediclaim', '2024-07-01 06:34:26', '2024-07-01 06:34:26'),
(10, 6923939991, 5634636981, 9622814060, 'asd', '3', '150', '450', 'mediclaim', '2024-07-01 06:35:43', '2024-07-01 06:35:43'),
(11, 8468978176, 6963429058, 9622814060, 'qw 12', '2', '300', '600', 'corporate', '2024-07-01 06:38:37', '2024-07-01 06:38:37'),
(12, 3801257810, 6963429058, 9622814060, 'zx 12', '1', '150', '150', 'corporate', '2024-07-01 06:39:47', '2024-07-01 06:39:47'),
(13, 3268195809, 6963429058, 9622814060, 'as qw 1', '1', '150', '150', 'corporate', '2024-07-01 06:40:52', '2024-07-01 06:40:52'),
(14, 4179020825, 5634636981, 9622814060, 'as121', '1', '100', '100', 'cash', '2024-07-01 07:13:33', '2024-07-01 07:13:33'),
(15, 6900098851, 5634636981, 9622814060, 'a1', '1', '100', '100', 'cash', '2024-07-01 07:52:58', '2024-07-01 07:52:58'),
(16, 1719063496, 5634636981, 9622814060, 'a2', '1', '100', '100', 'cash', '2024-07-01 07:54:22', '2024-07-01 07:54:22'),
(17, 2528921714, 5634636981, 9622814060, 'a2', '1', '100', '100', 'cash', '2024-07-01 07:54:44', '2024-07-01 07:54:44'),
(18, 1536680571, 6963429058, 9622814060, 'b1', '1', '100', '100', 'card', '2024-07-01 07:57:48', '2024-07-01 07:57:48'),
(19, 3637009867, 3701918849, 9622814060, 'c1', '1', '100', '100', 'cash', '2024-07-01 08:02:44', '2024-07-01 08:02:44'),
(20, 2094952395, 3701918849, 9622814060, 'c2', '1', '100', '100', 'cash', '2024-07-01 08:10:08', '2024-07-01 08:10:08'),
(21, 5022246873, 3701918849, 9622814060, 'adw', '1', '100', '100', 'cash', '2024-07-04 04:36:49', '2024-07-04 04:36:49'),
(22, 6381211964, 3701918849, 9622814060, 'wer', '1', '100', '100', 'cash', '2024-07-04 04:37:43', '2024-07-04 04:37:43'),
(23, 1066457234, 9513724655, 9622814060, 'asa', '1', '100', '100', 'cash', '2024-07-04 04:40:54', '2024-07-04 04:40:54'),
(24, 4410803802, 9513724655, 9622814060, 'adcz', '2', '140', '280', 'cash', '2024-07-04 04:41:37', '2024-07-04 04:41:37'),
(25, 8071746970, 9513724655, 9622814060, 'qwe', '1', '100', '100', 'cash', '2024-07-04 04:42:31', '2024-07-04 04:42:31'),
(26, 1434313457, 7693448549, 9622814060, 'saqwe qw', '2', '150', '300', 'cash', '2024-07-06 11:38:13', '2024-07-06 11:38:13'),
(27, 7941472983, 7693448549, 9622814060, 'qw 12', '1', '100', '100', 'cash', '2024-07-06 11:57:56', '2024-07-06 11:57:56'),
(28, 6964534858, 9247888596, 3507097541, 'x-ray', '1', '150', '150', 'cash', '2024-08-04 05:37:17', '2024-08-04 05:37:17'),
(29, 2266385308, 9247888596, 3507097541, 'sugar report', '2', '130', '260', 'cash', '2024-08-04 05:37:27', '2024-08-04 05:37:27'),
(30, 9115168396, 9247888596, 3507097541, 'blood report', '1', '350', '350', 'cash', '2024-08-04 05:37:44', '2024-08-04 05:37:44'),
(31, 1780065192, 9881264608, 8022048049, 'sugar report', '1', '150', '150', 'cash', '2024-08-04 09:41:35', '2024-08-04 09:41:35'),
(34, 9576559398, 6627154988, 9622814060, 'x-ray', '2', '150', '300', 'cash', '2024-08-05 14:31:29', '2024-08-05 14:31:29'),
(36, 5527263502, 8435299711, 9622814060, 'qw 12', '1', '50', '50', 'cash', '2024-11-20 14:33:55', '2024-11-20 14:33:55'),
(37, 5260281963, 8435299711, 9622814060, 'asd123', '2', '100', '200', 'cash', '2024-11-27 16:05:54', '2024-11-27 16:05:54'),
(39, 4225078387, 8435299711, 9622814060, 'as 12', '1', '50', '50', 'cash', '2024-11-28 02:10:15', '2024-11-28 02:10:15'),
(55, 4093249954, 3701918849, 9622814060, 'asd123', '3', '100', '300', 'cash', '2024-12-01 04:22:00', '2024-12-01 04:22:00'),
(56, 4151676760, 8435299711, 9622814060, 'asd123 121', '1', '100', '100', 'cash', '2024-12-01 06:35:42', '2024-12-01 06:35:42'),
(57, 7073288811, 8435299711, 9622814060, 'adas d', '1', '100', '100', 'cash', '2024-12-01 06:42:33', '2024-12-01 06:42:33'),
(58, 4658227965, 8435299711, 9622814060, 'asdsd', '1', '100', '100', 'cash', '2024-12-01 06:43:19', '2024-12-01 06:43:19'),
(59, 4569125255, 8435299711, 9622814060, 's dsadqw', '1', '100', '100', 'cash', '2024-12-01 06:44:11', '2024-12-01 06:44:11'),
(60, 6968936952, 8435299711, 9622814060, 'sdds', '1', '100', '100', 'cash', '2024-12-01 06:46:59', '2024-12-01 06:46:59'),
(61, 5335201842, 8435299711, 9622814060, 'asdasas', '1', '150', '150', 'cash', '2024-12-01 06:52:26', '2024-12-01 06:52:26'),
(64, 6846530698, 8435299711, 9622814060, 'as sad as', '1', '200', '200', 'cash', '2024-12-01 06:55:48', '2024-12-01 06:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_documents`
--

CREATE TABLE `appointment_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ap_id` bigint(20) NOT NULL COMMENT 'appoointment detail id',
  `ap_doc_name` text NOT NULL,
  `ap_doc` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_documents`
--

INSERT INTO `appointment_documents` (`id`, `ap_id`, `ap_doc_name`, `ap_doc`, `created_at`, `updated_at`) VALUES
(3, 5749515670, 'asd', '[\"5749515670-6609085772.pdf\"]', '2024-12-11 01:19:01', '2024-12-11 01:19:01'),
(4, 5749515670, 'qwe', '[\"5749515670-8978217381.pdf\"]', '2024-12-11 01:20:03', '2024-12-11 01:20:03'),
(5, 5749515670, 'asd', '[\"5749515670-9406727702.pdf\"]', '2024-12-11 01:24:57', '2024-12-11 01:24:57'),
(6, 5749515670, 'asd 123', '[\"abhayluva-1-8841895.jpg\"]', '2024-12-23 14:36:10', '2024-12-23 14:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_medicines`
--

CREATE TABLE `appointment_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `am_id` bigint(20) DEFAULT NULL,
  `ap_id` bigint(20) NOT NULL COMMENT 'appointment id',
  `am_added_by` bigint(20) NOT NULL,
  `gm_id` bigint(20) NOT NULL COMMENT 'General medicine id',
  `am_days` int(11) DEFAULT NULL,
  `am_timing` varchar(255) DEFAULT NULL COMMENT 'ex - before food or after food',
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
(14, 9912818168, 6627154988, 9622814060, 5299484431, 2, 'after eat food', 'no', 'yes', 'yes', '2024-07-07 06:40:48', '2024-07-07 06:40:48'),
(16, 4340085467, 5749515670, 9622814060, 4511744713, NULL, NULL, 'no', 'no', 'no', '2024-12-15 15:40:43', '2024-12-15 15:40:43'),
(17, 1638019181, 5749515670, 9622814060, 5299484431, NULL, NULL, 'no', 'no', 'no', '2024-12-15 15:41:21', '2024-12-15 15:41:21'),
(18, 8205742465, 5749515670, 9622814060, 5299484431, NULL, NULL, 'no', 'no', 'no', '2024-12-15 15:41:52', '2024-12-15 15:41:52'),
(19, 8650187861, 5749515670, 9622814060, 8937077390, 2, 'asd', 'no', 'no', 'no', '2024-12-16 03:19:46', '2024-12-16 03:19:46'),
(20, 9298387663, 5749515670, 9622814060, 2243854738, 1, 'xcv', 'yes', 'yes', 'yes', '2024-12-16 03:20:58', '2024-12-16 03:20:58'),
(21, 1389823042, 5749515670, 9622814060, 2118327182, 3, 'asdwqe', 'yes', 'yes', 'yes', '2024-12-16 03:25:51', '2024-12-16 03:25:51'),
(22, 9868002218, 5749515670, 9622814060, 2937047202, 4, 'asds', 'yes', 'yes', 'yes', '2024-12-16 03:26:10', '2024-12-16 03:26:10');

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
  `gm_company_name` varchar(255) DEFAULT NULL,
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
(2, 5299484431, 9622814060, 9622814060, 'paracetamol', 'Alpha Pharma', 'paracetamol created by Alpha', 1, '2024-06-24 23:52:40', '2024-06-24 23:52:40'),
(3, 4511744713, 9622814060, 9622814060, 'lamolate 1', NULL, 'as sad as sa asds d', 1, '2024-12-15 14:35:25', '2024-12-15 14:35:39'),
(5, 8937077390, 9622814060, 9622814060, 'asd', '', '', 1, '2024-12-16 03:19:46', '2024-12-16 03:19:46'),
(6, 2243854738, 9622814060, 9622814060, 'qwe', '', '', 1, '2024-12-16 03:20:58', '2024-12-16 03:20:58'),
(7, 2937047202, 9622814060, 9622814060, 'zxc', '', '', 1, '2024-12-16 03:26:10', '2024-12-16 03:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `indoor_sheets`
--

CREATE TABLE `indoor_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_id` bigint(20) NOT NULL,
  `ipd_id` bigint(20) NOT NULL,
  `is_added_by` bigint(20) NOT NULL,
  `is_date` date NOT NULL,
  `is_findings` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indoor_sheets`
--

INSERT INTO `indoor_sheets` (`id`, `is_id`, `ipd_id`, `is_added_by`, `is_date`, `is_findings`, `created_at`, `updated_at`) VALUES
(1, 5699078272, 2787176627, 9622814060, '2024-12-22', 'asd 1\nqwe\nzxc', '2024-12-22 03:37:21', '2024-12-22 03:39:07'),
(2, 9117761374, 2787176627, 9622814060, '2024-12-22', 'as qw\nqw zx\nzx as', '2024-12-22 03:37:42', '2024-12-22 03:38:07'),
(3, 5850277011, 2787176627, 9622814060, '2024-12-22', 'asd\nqwe', '2024-12-22 03:44:16', '2024-12-22 03:44:22'),
(4, 3797128049, 2787176627, 9622814060, '2024-12-23', 'this is my custom testing of findings 12\nmedicine 1 - dose 2 times launch and dinner\nmedicine 2 - dose 2 times launch and dinner', '2024-12-23 14:47:18', '2024-12-23 14:47:38'),
(5, 9875321826, 2787176627, 9622814060, '2024-12-23', 'this is my custom testing of findings 123\nmedicine 1 - dose 2 times launch and dinner 123\nmedicine 2 - dose 2 times launch and dinner', '2024-12-23 14:47:50', '2024-12-23 14:47:50'),
(6, 6661941522, 2787176627, 9622814060, '2024-12-23', 'new findings', '2024-12-23 15:47:28', '2024-12-23 15:47:28'),
(7, 4496010784, 2787176627, 9622814060, '2024-12-24', 'asd qwe', '2024-12-24 14:48:50', '2024-12-24 14:48:50'),
(8, 4316323913, 5125310699, 9622814060, '2025-01-12', 'asd s d', '2025-01-12 15:32:50', '2025-01-12 15:32:50'),
(10, 8159111750, 9137402867, 9622814060, '2025-01-13', 'General', '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(11, 1583197854, 8506616452, 9622814060, '2025-01-14', 'General', '2025-01-14 10:04:01', '2025-01-14 10:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `indoor_sheet_medicines`
--

CREATE TABLE `indoor_sheet_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ism_id` text NOT NULL,
  `is_id` text NOT NULL,
  `ism_recommendation` text NOT NULL,
  `ism_added_by` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indoor_sheet_medicines`
--

INSERT INTO `indoor_sheet_medicines` (`id`, `ism_id`, `is_id`, `ism_recommendation`, `ism_added_by`, `created_at`, `updated_at`) VALUES
(1, '9350470385', '5699078272', 'asd 1', '9622814060', '2024-12-22 03:38:30', '2024-12-22 03:39:25'),
(2, '1658206246', '5699078272', 'asd 2', '9622814060', '2024-12-22 03:38:45', '2024-12-22 03:39:28'),
(3, '7300718478', '5699078272', 'asd 3', '9622814060', '2024-12-22 03:44:56', '2024-12-22 03:45:00'),
(5, '4617573792', '9875321826', 'medicine 2 - dos of cough syrun at launch', '9622814060', '2024-12-23 14:48:42', '2024-12-23 14:48:53'),
(6, '4786324432', '9875321826', 'medicine 1 - frist deso given at launch', '9622814060', '2024-12-23 14:50:27', '2024-12-23 14:50:27'),
(7, '5503325551', '9875321826', 'new dose given', '9622814060', '2024-12-23 15:44:45', '2024-12-23 15:44:45'),
(8, '6646138827', '6661941522', 'asd', '9622814060', '2024-12-23 15:48:35', '2024-12-23 15:48:35'),
(9, '4527109762', '6661941522', 'qwe', '9622814060', '2024-12-23 15:48:39', '2024-12-23 15:48:39'),
(10, '6703564554', '6661941522', 'zxc', '9622814060', '2024-12-23 15:48:43', '2024-12-23 15:48:43'),
(11, '4479781599', '6661941522', 'asd1', '9622814060', '2024-12-23 15:56:38', '2024-12-23 15:57:05'),
(12, '1292604413', '4316323913', 'sad dsad', '9622814060', '2025-01-12 15:32:58', '2025-01-12 15:32:58'),
(14, '5391820949', '8159111750', 'zxc', '9622814060', '2025-01-13 05:21:43', '2025-01-13 05:25:10'),
(15, '4696588196', '8159111750', 'qwe', '9622814060', '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(16, '6949488961', '8159111750', 'asd', '9622814060', '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(17, '8134145598', '1583197854', 'zxc', '9622814060', '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(18, '9440227225', '1583197854', 'qwe', '9622814060', '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(19, '4887197994', '1583197854', 'asd', '9622814060', '2025-01-14 10:04:01', '2025-01-14 10:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `indoor_sheet_medicine_examinations`
--

CREATE TABLE `indoor_sheet_medicine_examinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `isme_id` text NOT NULL,
  `is_id` text NOT NULL,
  `ism_recommendation` text NOT NULL,
  `isme_given_datetime` datetime DEFAULT NULL,
  `isme_created_datetime` datetime NOT NULL,
  `remark` text DEFAULT NULL,
  `isme_added_by` text NOT NULL COMMENT 'user id who has add deta',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indoor_sheet_medicine_examinations`
--

INSERT INTO `indoor_sheet_medicine_examinations` (`id`, `isme_id`, `is_id`, `ism_recommendation`, `isme_given_datetime`, `isme_created_datetime`, `remark`, `isme_added_by`, `created_at`, `updated_at`) VALUES
(1, '6834817329', '5699078272', 'asd 1', '2024-12-22 10:40:00', '2024-12-23 08:45:17', 'sad\nqwe', '9622814060', '2024-12-22 05:07:25', '2024-12-23 03:15:17'),
(2, '7122303578', '5699078272', 'asd 2', '2024-12-22 10:41:00', '2024-12-23 08:13:30', 'qwe\nasd', '9622814060', '2024-12-22 05:07:25', '2024-12-23 02:43:30'),
(3, '7380284594', '5699078272', 'asd 1', '2024-12-22 13:20:00', '2024-12-22 13:20:55', 'asd 1', '9622814060', '2024-12-22 07:50:55', '2024-12-22 07:50:55'),
(4, '5135197365', '5699078272', 'asd 1', '2024-12-22 14:15:00', '2024-12-22 14:12:07', 'asd 12', '9622814060', '2024-12-22 08:42:07', '2024-12-22 08:42:07'),
(5, '2742002419', '5699078272', 'asd 3', '2024-12-22 14:17:00', '2024-12-22 14:12:07', 'qwe 12', '9622814060', '2024-12-22 08:42:07', '2024-12-22 08:42:07'),
(6, '8166360799', '5699078272', 'asd 1', '2024-12-22 14:19:00', '2024-12-22 14:13:12', 'asd 123', '9622814060', '2024-12-22 08:43:12', '2024-12-22 08:43:12'),
(7, '3974057511', '5699078272', 'asd 2', '2024-12-22 14:16:00', '2024-12-22 14:13:12', 'qwe 123', '9622814060', '2024-12-22 08:43:12', '2024-12-22 08:43:12'),
(8, '1117539173', '5699078272', 'asd 1', '2024-12-22 14:17:00', '2024-12-22 14:15:45', 'asd 124', '9622814060', '2024-12-22 08:45:45', '2024-12-22 08:45:45'),
(12, '8108616238', '9875321826', 'medicine 2 - dos of cough syrun at launch', '2024-12-23 21:11:00', '2024-12-23 21:07:11', 'asd 12\nqwe', '9622814060', '2024-12-23 15:36:13', '2024-12-23 15:37:11'),
(13, '6658481374', '6661941522', 'asd', '2024-12-23 21:22:00', '2024-12-23 21:22:55', 'asd qwe', '9622814060', '2024-12-23 15:52:55', '2024-12-23 15:52:55'),
(14, '5677575400', '6661941522', 'qwe', '2024-12-23 21:23:00', '2024-12-23 21:22:55', 'asd zzxc', '9622814060', '2024-12-23 15:52:55', '2024-12-23 15:52:55'),
(15, '1663146244', '6661941522', 'asd', '2024-12-23 21:25:00', '2024-12-23 21:23:13', 'asd 1', '9622814060', '2024-12-23 15:53:13', '2024-12-23 15:53:13'),
(16, '8339838106', '6661941522', 'qwe', '2024-12-23 21:26:00', '2024-12-23 21:23:13', 'qwe 1', '9622814060', '2024-12-23 15:53:13', '2024-12-23 15:53:13'),
(17, '6967559173', '6661941522', 'asd', '2024-12-23 21:30:00', '2024-12-23 21:26:21', 'asd 2', '9622814060', '2024-12-23 15:55:55', '2024-12-23 15:56:21'),
(18, '1081424621', '6661941522', 'qwe', '2024-12-23 21:31:00', '2024-12-23 21:25:56', 'qwe 2', '9622814060', '2024-12-23 15:55:56', '2024-12-23 15:55:56');

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
(10, 2056674209, 1576522958, 9622814060, 'asd', 1000, '2024-12-10 03:17:50', '2024-12-10 03:17:50'),
(11, 9892926906, 1576522958, 9622814060, 'qwe', 200, '2024-12-10 03:17:55', '2024-12-10 03:17:55'),
(12, 2644032286, 1576522958, 9622814060, 'zxc', 300, '2024-12-10 03:18:00', '2024-12-10 03:18:00'),
(13, 4272144642, 2787176627, 9622814060, 'asd qwe', 1000, '2024-12-27 02:44:41', '2024-12-27 02:44:41'),
(14, 2224568992, 6091410780, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(15, 8375369203, 6091410780, 9622814060, 'THEATRE CHARGES', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(16, 7179520821, 6091410780, 9622814060, '3D CAMERS CHARGE', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(17, 1850583272, 6091410780, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(18, 2827614904, 6091410780, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(19, 1962772038, 6091410780, 9622814060, 'DOCTOR CHARGE', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(20, 5738274171, 6091410780, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(21, 3660693827, 5125310699, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 100, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(22, 5928023623, 5125310699, 9622814060, 'THEATRE CHARGES', 200, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(23, 3855184207, 5125310699, 9622814060, '3D CAMERS CHARGE', 300, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(24, 8547673405, 5125310699, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(25, 6461038703, 5125310699, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(26, 9824533633, 5125310699, 9622814060, 'DOCTOR CHARGE', 0, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(27, 9748880618, 5125310699, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(28, 4470484620, 6086108016, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(29, 6997950925, 6086108016, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(30, 4094835797, 6086108016, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(31, 2713622441, 6086108016, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(32, 9984052770, 6086108016, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(33, 6598126640, 6086108016, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(34, 4255248101, 6086108016, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(35, 2220618197, 1003765709, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(36, 4125223448, 1003765709, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(37, 3613385113, 1003765709, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(38, 2390273526, 1003765709, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(39, 4851860561, 1003765709, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(40, 1766625218, 1003765709, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(41, 9798907889, 1003765709, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(42, 7558962964, 9049531256, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(43, 7468511409, 9049531256, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(44, 3785660612, 9049531256, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(45, 8149471409, 9049531256, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(46, 1461863580, 9049531256, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(47, 8101853562, 9049531256, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(48, 4185090473, 9049531256, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(49, 5024511842, 8764516108, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(50, 2374516876, 8764516108, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(51, 7348382938, 8764516108, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(52, 2852416004, 8764516108, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(53, 2708711313, 8764516108, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(54, 3325969414, 8764516108, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(55, 1310480860, 8764516108, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(56, 8058215923, 8813103812, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(57, 9137404785, 8813103812, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(58, 5903231295, 8813103812, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(59, 9681905029, 8813103812, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(60, 1634809502, 8813103812, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(61, 5451149517, 8813103812, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(62, 1041148341, 8813103812, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(63, 7965791186, 6130885780, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(64, 7928911093, 6130885780, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(65, 7493890563, 6130885780, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(66, 2107505354, 6130885780, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(67, 8676606441, 6130885780, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(68, 6633355350, 6130885780, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(69, 6509075351, 6130885780, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(70, 3482346417, 3032541127, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(71, 2796998023, 3032541127, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(72, 4088104365, 3032541127, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(73, 9872153125, 3032541127, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(74, 1134812225, 3032541127, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(75, 9512755799, 3032541127, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(76, 6981408182, 3032541127, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(77, 3391027430, 6339043214, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(78, 2312951869, 6339043214, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(79, 9916651944, 6339043214, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(80, 7314763365, 6339043214, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(81, 8291927538, 6339043214, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(82, 6859226903, 6339043214, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(83, 5526096243, 6339043214, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(84, 7828812377, 5466227336, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(85, 2148916549, 5466227336, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(86, 3571974010, 5466227336, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(87, 8100558514, 5466227336, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(88, 8078207603, 5466227336, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(89, 1823207555, 5466227336, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(90, 9735102331, 5466227336, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(91, 3524054272, 2581818593, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(92, 9478198973, 2581818593, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(93, 7382912199, 2581818593, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(94, 5282357567, 2581818593, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(95, 5327308560, 2581818593, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:20:13', '2025-01-13 05:20:13'),
(96, 4350642221, 2581818593, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:20:13', '2025-01-13 05:20:13'),
(97, 9515353905, 2581818593, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:20:13', '2025-01-13 05:20:13'),
(98, 4832268161, 9137402867, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(99, 1810938224, 9137402867, 9622814060, 'THEATRE CHARGES', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(100, 7704138169, 9137402867, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(101, 6552552117, 9137402867, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(102, 7770145901, 9137402867, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(103, 3572262812, 9137402867, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(104, 7886337907, 9137402867, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(105, 8412627699, 8506616452, 9622814060, 'OPERATION CHARGES (SURGEON CHARGES)', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(106, 7857282006, 8506616452, 9622814060, 'THEATRE CHARGES', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(107, 3577300061, 8506616452, 9622814060, '3D CAMERS CHARGE', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(108, 7811117925, 8506616452, 9622814060, 'HARMONIC INSTRUMENT CHARGE', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(109, 1815520032, 8506616452, 9622814060, 'ANESTHESIA CHARGE DR. KAMLESH PTEL-REG. NO.G9826.', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(110, 5324110179, 8506616452, 9622814060, 'DOCTOR CHARGE', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01'),
(111, 1735231974, 8506616452, 9622814060, 'ROOM CHARGE (3 DAYS * 2000 RS)', 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_details`
--

CREATE TABLE `ipd_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipd_id` bigint(20) NOT NULL,
  `ipd_added_by` bigint(20) NOT NULL,
  `ipd_updated_by` bigint(20) NOT NULL,
  `pa_id` varchar(255) NOT NULL,
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
  `ipd_discount` text NOT NULL,
  `ipd_discount_approved_by` text DEFAULT NULL,
  `ipd_mediclaim` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `ipd_is_foc` varchar(255) NOT NULL DEFAULT 'no' COMMENT 'yes/no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_details`
--

INSERT INTO `ipd_details` (`id`, `ipd_id`, `ipd_added_by`, `ipd_updated_by`, `pa_id`, `ipd_admit_date`, `ipd_doctor`, `ipd_surgery_date`, `ipd_surgery_text`, `rm_id`, `ipd_status`, `ipd_discharge_date`, `ipd_follow_up_date`, `ipd_follow_up_note`, `ipd_cancel_reason`, `ipd_diagnosis`, `ipd_investigations`, `ipd_treatment_given`, `ipd_treatment_discharge`, `ipd_operation_medicine`, `ipd_operation_medicine_date`, `ipd_bill_amount`, `ipd_received_amount`, `ipd_discount`, `ipd_discount_approved_by`, `ipd_mediclaim`, `ipd_is_foc`, `created_at`, `updated_at`) VALUES
(1, 1288742033, 9622814060, 9622814060, '8059577479', '2024-11-27', 8022048049, '2024-07-22', 'asd qwe', 7012967793, 'admit', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, '70000', '1100', '0', NULL, 'no', 'no', '2024-07-06 05:21:48', '2024-12-04 02:53:00'),
(2, 7418463651, 9622814060, 9622814060, '1945164148', '2024-11-27', 6636406942, '2024-07-20', 'asd qwe', 4560129688, 'discharged', '2024-07-23', '2024-08-01', NULL, '', 'asd', 'qwe', 'zxc', 'asqwzx', '[{\"medicine_id\":7691745383,\"medicine_val\":\"1\"},{\"medicine_id\":2543858207,\"medicine_val\":\"2\"},{\"medicine_id\":8996985293,\"medicine_val\":\"3\"}]', '2024-07-07', '15000', '6000', '0', NULL, 'no', 'no', '2024-07-06 05:22:13', '2024-12-04 02:54:20'),
(4, 3245365631, 9622814060, 9622814060, '8823312118', '2024-07-27', 8022048049, '2024-07-31', 'appendix', 8735526459, 'admit', NULL, NULL, NULL, '', '', '', '', '', '[{\"medicine_id\":7691745383,\"medicine_val\":\"3\"},{\"medicine_id\":2543858207,\"medicine_val\":\"3\"}]', '2024-07-27', '16000', '8000', '0', NULL, 'no', 'no', '2024-07-27 04:30:31', '2024-12-04 02:54:01'),
(5, 1576522958, 3507097541, 8022048049, '3197211687', '2024-08-04', 8022048049, '2024-08-15', 'appendix', 4867399090, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10000', '6000', '500', NULL, 'no', 'no', '2024-08-04 05:54:20', '2024-12-10 03:25:47'),
(6, 7326186155, 3507097541, 3507097541, '5981076475', '2024-08-04', 6636406942, '2024-08-13', 'appendix', 5671800060, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-08-04 05:54:50', '2024-08-04 05:54:50'),
(7, 1652346691, 9622814060, 9622814060, '2575834800', '2024-08-05', 8022048049, '2024-08-09', 'kidney change', 5704770808, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-08-05 14:39:03', '2024-08-05 14:39:03'),
(8, 7311788032, 9622814060, 9622814060, '1945164148', '2024-08-05', 8022048049, '2024-08-07', 'kidney change', 4560129688, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-08-05 14:49:04', '2024-08-05 14:49:04'),
(9, 7334697627, 9622814060, 9622814060, '6625798458', '2024-08-12', 8022048049, '2024-08-16', 'kidney change', 7626108364, 'discharged', '2024-08-12', '2024-08-16', NULL, '', 'asd', '', '', '', NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-08-12 16:00:55', '2024-08-12 16:09:21'),
(10, 3224913712, 9622814060, 9622814060, '8561981100', '2024-08-15', 8022048049, '2024-08-19', 'appendix', 7626108364, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-08-14 01:54:59', '2024-08-14 01:54:59'),
(11, 7990051110, 9622814060, 9622814060, '6625798458', '2024-12-01', 9152073037, '2024-12-01', 'asd qwe', 1745383720, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-12-01 08:59:09', '2024-12-01 08:59:09'),
(12, 3002857808, 9622814060, 9622814060, '2926564244', '2024-12-01', 6636406942, '2024-12-01', 'asd qwe', 6013882173, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '2000', NULL, 'no', 'no', '2024-12-01 10:47:23', '2024-12-10 03:25:35'),
(13, 5740513748, 9622814060, 9622814060, 'EVA202412101', '2024-12-10', 6636406942, '2024-12-10', 'kidney change', 7623041434, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-12-10 14:51:49', '2024-12-10 14:51:49'),
(14, 2787176627, 9622814060, 9622814060, 'EVA202412012', '2024-12-10', 9152073037, '2024-12-10', 'kidney change', 9318726306, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2024-12-10 14:57:47', '2024-12-10 14:57:47'),
(17, 6091410780, 9622814060, 9622814060, 'EVA202412151', '2024-12-27', 8022048049, '2024-12-27', 'kidney change', 3532694461, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '1000', 'Dr. Limbachiya', 'no', 'no', '2024-12-27 03:02:09', '2024-12-27 03:12:38'),
(18, 5125310699, 9622814060, 9622814060, 'EVA202412281', '2024-12-28', 8022048049, '2025-02-02', 'kidney change', 8346064090, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '100', 'asd', 'no', 'no', '2024-12-28 13:53:12', '2024-12-28 14:34:37'),
(29, 9137402867, 9622814060, 9622814060, 'EVA202412123', '2025-01-13', 8022048049, '2025-01-13', 'kidney change', 1763176195, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '1000', '0', NULL, 'no', 'no', '2025-01-13 05:21:43', '2025-01-13 06:31:41'),
(30, 8506616452, 9622814060, 9622814060, '6900526422', '2025-01-14', 8022048049, '2025-01-14', 'sa saa sa sa', 9657298017, 'admit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, 'no', 'no', '2025-01-14 10:04:01', '2025-01-14 10:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_documents`
--

CREATE TABLE `ipd_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipd_id` bigint(20) NOT NULL COMMENT 'ipd detail id',
  `ipd_doc_name` text NOT NULL,
  `ipd_doc` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_documents`
--

INSERT INTO `ipd_documents` (`id`, `ipd_id`, `ipd_doc_name`, `ipd_doc`, `created_at`, `updated_at`) VALUES
(1, 3002857808, 'asd', '[\"3002857808-2274982011.pdf\"]', '2024-12-05 03:00:14', '2024-12-05 03:00:14'),
(2, 3002857808, 'asd', '[\"3002857808-5094728951.pdf\"]', '2024-12-05 03:01:36', '2024-12-05 03:01:36'),
(3, 3002857808, 'asd', '[\"3002857808-6418335365.pdf\"]', '2024-12-05 03:02:01', '2024-12-05 03:02:01'),
(4, 3002857808, 'asd', '[\"3002857808-5290873420.pdf\"]', '2024-12-05 03:02:53', '2024-12-05 03:02:53'),
(5, 3002857808, 'asd', '[\"3002857808-8741802231.pdf\"]', '2024-12-05 03:03:46', '2024-12-05 03:03:46'),
(6, 3002857808, 'asd', '[\"3002857808-3022905328.pdf\"]', '2024-12-05 03:03:57', '2024-12-05 03:03:57'),
(7, 3002857808, 'asd', '[\"3002857808-6285477062.pdf\"]', '2024-12-05 03:04:14', '2024-12-05 03:04:14'),
(8, 3002857808, 'qwe', '[\"3002857808-9796143208.pdf\"]', '2024-12-05 03:19:32', '2024-12-05 03:19:32'),
(11, 3002857808, 'asd 1', '[\"3002857808-8053960031.pdf\"]', '2024-12-11 01:25:38', '2024-12-11 01:25:38'),
(12, 2787176627, 'asd 1', '[\"Proposal---PartTime-1221983.pdf\"]', '2024-12-16 16:02:12', '2024-12-16 16:02:12'),
(13, 2787176627, 'abhay', '[\"abhayluva-1-6579699.jpg\"]', '2024-12-24 14:49:11', '2024-12-24 14:49:11'),
(14, 2787176627, 'bhay', '[\"abhayluva-3534634.jpg\"]', '2024-12-24 14:50:59', '2024-12-24 14:50:59');

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
(8, 6253198686, 7311788032, NULL, NULL, '2024-08-05 14:49:04', '2024-08-05 14:49:04'),
(9, 2174312271, 7334697627, NULL, NULL, '2024-08-12 16:00:55', '2024-08-12 16:00:55'),
(10, 4263261767, 3224913712, NULL, NULL, '2024-08-14 01:54:59', '2024-08-14 01:54:59'),
(11, 3478384687, 7990051110, NULL, NULL, '2024-12-01 08:59:09', '2024-12-01 08:59:09'),
(12, 5741146072, 3002857808, NULL, NULL, '2024-12-01 10:47:23', '2024-12-01 10:47:23'),
(13, 2603074380, 5740513748, NULL, NULL, '2024-12-10 14:51:49', '2024-12-10 14:51:49'),
(14, 3805148069, 2787176627, NULL, NULL, '2024-12-10 14:57:47', '2024-12-10 14:57:47'),
(15, 1051405724, 6736169145, NULL, NULL, '2024-12-27 02:59:06', '2024-12-27 02:59:06'),
(16, 4530789836, 1692597487, NULL, NULL, '2024-12-27 03:00:51', '2024-12-27 03:00:51'),
(17, 2088363675, 6091410780, NULL, NULL, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(18, 1318471754, 5125310699, NULL, NULL, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(19, 4051164801, 6086108016, NULL, NULL, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(20, 7266678505, 1003765709, NULL, NULL, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(21, 3132248260, 9049531256, NULL, NULL, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(22, 6982167683, 8764516108, NULL, NULL, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(23, 3324818554, 8813103812, NULL, NULL, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(24, 5088316652, 6130885780, NULL, NULL, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(25, 5706520921, 3032541127, NULL, NULL, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(26, 6323144032, 6339043214, NULL, NULL, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(27, 1468754420, 5466227336, NULL, NULL, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(28, 3752646424, 2581818593, NULL, NULL, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(29, 9381501088, 9137402867, NULL, NULL, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(30, 3566642111, 8506616452, NULL, NULL, '2025-01-14 10:04:01', '2025-01-14 10:04:01');

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
(25, 8362842992, 1288742033, 9622814060, '500', 'cash', 100, 'as sdad', '2024-12-04 02:52:41', '2024-12-04 02:52:41'),
(26, 9278818960, 1288742033, 9622814060, 'qwe', 'cheque', 1000, 'as sdsad', '2024-12-04 02:53:00', '2024-12-04 02:53:00'),
(27, 1860959817, 1576522958, 9622814060, 'asds', 'card', 5000, 'asd asd', '2024-12-04 02:53:20', '2024-12-04 02:53:20'),
(28, 1686151410, 1576522958, 9622814060, 'weqwe', 'cash', 1000, 'asd asdad', '2024-12-04 02:53:28', '2024-12-04 02:53:28'),
(29, 4856603186, 3245365631, 9622814060, 'ad sd asd', 'cash', 3000, 'as da', '2024-12-04 02:53:52', '2024-12-04 02:53:52'),
(30, 2220360082, 3245365631, 9622814060, 'qwe', 'cheque', 5000, 'dasdsd asd', '2024-12-04 02:54:01', '2024-12-04 02:54:01'),
(31, 5097461631, 7418463651, 9622814060, 'as dsd', 'card', 6000, 'asd asd asd s', '2024-12-04 02:54:20', '2024-12-04 02:54:20'),
(32, 9007270739, 9137402867, 9622814060, 'asd qwe', 'cash', 1000, 'asd s as s dsad sad', '2025-01-13 06:31:41', '2025-01-13 06:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `ipd_pre_operative_medicines`
--

CREATE TABLE `ipd_pre_operative_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipom_id` text NOT NULL,
  `ipd_id` text NOT NULL,
  `pom_added_by` text NOT NULL,
  `pom_updated_by` text NOT NULL,
  `recommendation` text NOT NULL,
  `description` text DEFAULT NULL,
  `given_or_not` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-yes, 0-no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ipd_pre_operative_medicines`
--

INSERT INTO `ipd_pre_operative_medicines` (`id`, `ipom_id`, `ipd_id`, `pom_added_by`, `pom_updated_by`, `recommendation`, `description`, `given_or_not`, `created_at`, `updated_at`) VALUES
(2, '4334628381', '9137402867', '9622814060', '9622814060', 'asd', 'asd sd sa asdd asd', 0, '2025-01-14 09:29:58', '2025-01-14 09:49:33'),
(3, '3291280665', '9137402867', '9622814060', '9622814060', 'qwe', 'as sas saads as das', 1, '2025-01-14 09:49:41', '2025-01-14 09:49:41'),
(4, '9864489816', '8506616452', '9622814060', '9622814060', 'qwe 1', 'as sas saads as das 1', 1, '2025-01-14 10:04:01', '2025-01-14 10:08:16'),
(5, '3061892334', '8506616452', '9622814060', '9622814060', 'asd 1', 'asd sd sa asdd asd', 0, '2025-01-14 10:04:01', '2025-01-14 10:08:24');

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
(4, 1918881308, 'my pc', '192.168.146.218', 1, 9622814060, 9622814060, '2024-07-09 14:25:34', '2024-12-28 03:11:04');

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
(36, '2024_08_04_162205_add_column_ap_follow_up_note_to_ipd_details_table', 26),
(37, '2024_08_12_200732_create_notifications_table', 27),
(38, '2024_12_04_205925_create_ipd_documents_table', 28),
(39, '2024_12_08_090022_create_trainee_payment_lists_table', 29),
(40, '2024_12_11_062011_create_appointment_documents_table', 30),
(41, '2024_12_20_073222_create_indoor_sheets_table', 31),
(42, '2024_12_21_100132_create_indoor_sheet_medicines_table', 32),
(43, '2024_12_22_091559_create_indoor_sheet_medicine_examinations_table', 33),
(44, '2025_01_12_214758_create_pre_operative_medicines_table', 34),
(45, '2025_01_12_222259_create_ppost_operative_medicines_table', 35),
(46, '2025_01_12_222259_create_post_operative_medicines_table', 36),
(47, '2025_01_14_141424_create_ipd_pre_operative_medicine_table', 37),
(48, '2025_01_14_141424_create_ipd_pre_operative_medicines_table', 38);

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
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(5, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_id` bigint(20) NOT NULL,
  `ap_id` bigint(20) DEFAULT NULL COMMENT 'Appointment id',
  `ipd_id` bigint(20) DEFAULT NULL COMMENT 'IPD id',
  `no_type` text DEFAULT NULL COMMENT '1-opd, 2-ipd',
  `no_subject` text NOT NULL COMMENT 'New Appoitnemtn, New Patient Admit, Patient Discharged',
  `no_message` text NOT NULL COMMENT 'New appointment added',
  `no_icon` text NOT NULL COMMENT 'Notification related icon',
  `no_action` text NOT NULL,
  `no_created_for` bigint(20) NOT NULL COMMENT 'User ID',
  `no_created_by` bigint(20) NOT NULL COMMENT 'User ID',
  `no_read` int(11) NOT NULL DEFAULT 0 COMMENT '0-unread, 1-read',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `no_id`, `ap_id`, `ipd_id`, `no_type`, `no_subject`, `no_message`, `no_icon`, `no_action`, `no_created_for`, `no_created_by`, `no_read`, `created_at`, `updated_at`) VALUES
(1, 9667857410, 5745563744, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 8022048049, 9622814060, 0, '2024-08-12 15:56:21', '2024-08-12 15:56:21'),
(2, 3568159663, NULL, 7334697627, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-08-12 16:00:55', '2024-08-12 16:00:55'),
(3, 2155449654, NULL, 7334697627, '2', 'Patient Discharged', 'Patient has discharged', 'la la-bed', 'ipd_discharge', 8022048049, 9622814060, 0, '2024-08-12 16:09:21', '2024-08-12 16:09:21'),
(4, 4708908730, 8435299711, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 8022048049, 9622814060, 0, '2024-08-14 01:52:41', '2024-08-14 01:52:41'),
(5, 5588787428, NULL, 3224913712, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-08-14 01:54:59', '2024-08-15 02:06:23'),
(6, 3528576773, 6655705781, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 9152073037, 9152073037, 0, '2024-12-01 08:45:36', '2024-12-01 08:45:36'),
(7, 2847935333, NULL, 7990051110, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 9152073037, 9622814060, 0, '2024-12-01 08:59:09', '2024-12-01 08:59:09'),
(8, 3586954645, 5749515670, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 6636406942, 9622814060, 0, '2024-12-01 10:46:48', '2024-12-01 10:46:48'),
(9, 6354523919, NULL, 3002857808, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 6636406942, 9622814060, 0, '2024-12-01 10:47:23', '2024-12-01 10:47:23'),
(10, 1279107110, NULL, 5740513748, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 6636406942, 9622814060, 0, '2024-12-10 14:51:49', '2024-12-10 14:51:49'),
(11, 5106684766, NULL, 2787176627, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 9152073037, 9622814060, 0, '2024-12-10 14:57:47', '2024-12-10 14:57:47'),
(12, 5863577490, NULL, 6736169145, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-12-27 02:59:06', '2024-12-27 02:59:06'),
(13, 7625912391, NULL, 1692597487, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-12-27 03:00:51', '2024-12-27 03:00:51'),
(14, 8387603591, NULL, 6091410780, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-12-27 03:02:09', '2024-12-27 03:02:09'),
(15, 8442166223, NULL, 5125310699, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2024-12-28 13:53:12', '2024-12-28 13:53:12'),
(16, 6540907471, 7141925655, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 8022048049, 9622814060, 0, '2025-01-12 07:33:34', '2025-01-12 07:33:34'),
(17, 3809983142, NULL, 6086108016, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:08:33', '2025-01-13 05:08:33'),
(18, 5401013310, NULL, 1003765709, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:08:56', '2025-01-13 05:08:56'),
(19, 2546348583, NULL, 9049531256, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:09:39', '2025-01-13 05:09:39'),
(20, 4331551660, NULL, 8764516108, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:10:08', '2025-01-13 05:10:08'),
(21, 6323361591, NULL, 8813103812, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:11:47', '2025-01-13 05:11:47'),
(22, 2040780437, NULL, 6130885780, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:12:48', '2025-01-13 05:12:48'),
(23, 4164618929, NULL, 3032541127, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:13:42', '2025-01-13 05:13:42'),
(24, 5655444316, NULL, 6339043214, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:17:39', '2025-01-13 05:17:39'),
(25, 3064879154, NULL, 5466227336, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:18:23', '2025-01-13 05:18:23'),
(26, 9914198127, NULL, 2581818593, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:20:12', '2025-01-13 05:20:12'),
(27, 7074432256, NULL, 9137402867, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 05:21:43', '2025-01-13 05:21:43'),
(28, 7286299597, 7462743470, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 12:01:47', '2025-01-13 12:01:47'),
(29, 4908516434, 9566903699, NULL, '1', 'New Appointment', 'New appointment has beed created', 'flaticon-calendar-2', 'opd_add_doctor', 8022048049, 9622814060, 0, '2025-01-13 12:04:28', '2025-01-13 12:04:28'),
(30, 6468442785, NULL, 8506616452, '2', 'New Patient Admit', 'New patient has beedn admitted', 'la la-bed', 'ipd_add_doctor', 8022048049, 9622814060, 0, '2025-01-14 10:04:01', '2025-01-14 10:04:01');

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
  `om_company_name` varchar(255) DEFAULT NULL,
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
(3, 7691745383, 9622814060, 9622814060, 'fizer', 'a to b', 'asd asdasasddasd', 1, '2024-07-06 09:39:17', '2024-07-06 09:39:17'),
(4, 8886831125, 9622814060, 9622814060, 'lamolate op 1', NULL, 'sad asa asd sd asa asd as', 1, '2024-12-15 14:36:01', '2024-12-15 14:36:25');

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
  `pa_id` varchar(255) NOT NULL,
  `pa_added_by` bigint(20) NOT NULL COMMENT 'user table id user_id',
  `pa_updated_by` bigint(20) NOT NULL COMMENT 'user table id user_id',
  `pa_name` varchar(255) NOT NULL,
  `pa_contact_no` varchar(255) DEFAULT NULL,
  `pa_alt_contact_no` varchar(255) DEFAULT NULL,
  `pa_email` varchar(255) DEFAULT NULL,
  `pa_address` varchar(255) DEFAULT NULL,
  `pa_pan_card` varchar(255) DEFAULT NULL,
  `pa_city` varchar(255) DEFAULT NULL,
  `pa_pincode` varchar(255) DEFAULT NULL,
  `pa_state` varchar(255) DEFAULT NULL,
  `pa_dob` date DEFAULT NULL,
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

INSERT INTO `patients` (`id`, `pa_id`, `pa_added_by`, `pa_updated_by`, `pa_name`, `pa_contact_no`, `pa_alt_contact_no`, `pa_email`, `pa_address`, `pa_pan_card`, `pa_city`, `pa_pincode`, `pa_state`, `pa_dob`, `pa_age`, `pa_gender`, `pa_marital_status`, `pa_occupation`, `pa_last_monestrual_period`, `pa_pregnancy_no`, `pa_miscarriages_no`, `pa_abortion_no`, `pa_children_no`, `pa_photo`, `pa_tobacco`, `pa_smoking`, `pa_alcohol`, `pa_medical_history`, `pa_family_medical_history`, `pa_referred_by`, `pa_referred_doctor`, `pa_referred_text`, `pa_status`, `created_at`, `updated_at`) VALUES
(1, '1929125286', 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-01-01', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 06:55:53', '2024-06-25 06:55:53'),
(2, '6900526422', 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-01', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:06:17', '2024-06-25 07:06:17'),
(3, '6687313469', 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, 'asd@gmail.com', NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:34:18', '2024-06-25 07:34:18'),
(4, '9331608184', 9622814060, 9622814060, 'Abhay Luva', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:34:55', '2024-06-25 07:34:55'),
(5, '2866803113', 9622814060, 9622814060, 'Abhay Luva', NULL, '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:35:48', '2024-06-25 07:35:48'),
(6, '7605637159', 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-25', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:36:35', '2024-06-25 07:36:35'),
(7, '7800965725', 9622814060, 9622814060, 'Abhay Luva', NULL, NULL, 'asd1@gmail.com', NULL, NULL, NULL, NULL, NULL, '2019-12-31', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-25 07:36:53', '2024-06-26 07:43:24'),
(8, '6625798458', 9622814060, 9622814060, 'Ab Lov', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2008-01-01', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[null]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:21:27', '2024-12-26 16:41:06'),
(9, '2575834800', 9622814060, 9622814060, 'ab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2005-01-01', '19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'doctor', 'ab', NULL, 1, '2024-06-27 23:23:02', '2024-06-27 23:23:02'),
(10, '2926564244', 9622814060, 8022048049, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-28', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:25:35', '2024-08-06 02:27:18'),
(11, '4151464738', 9622814060, 9622814060, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-05', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"4151464738-6068944068.png\"]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Lov', NULL, 1, '2024-06-27 23:26:49', '2024-06-27 23:26:49'),
(12, '8561981100', 9622814060, 9622814060, 'Ab Luva', '1234567891', '1234567891', 'asd2@gmail.com', 'b-4, anand nagar, dwarkadhish society', NULL, 'upleta', '360490', 'gujarat', '1997-01-01', '27', 'male', 'married', 'IT Employee', 'asd', '1', '1', '0', '0', '[\"8561981100-3018767396.jpg\"]', 'no', 'occational', 'regular', 'yes, corona sergery', 'yes, corona hospitality', 'other', 'as dqwq 1', NULL, 1, '2024-06-27 23:33:01', '2024-07-01 02:15:23'),
(13, '1945164148', 9622814060, 9622814060, 'asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-05', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"1945164148-4916246574.jpg\"]', NULL, NULL, NULL, NULL, NULL, 'other', 'asd qwe', NULL, 1, '2024-06-28 01:08:14', '2024-06-28 01:30:35'),
(14, '8059577479', 9622814060, 9622814060, 'asd 123', NULL, NULL, NULL, 'b-4, anand nagar, dwarkadhish society', NULL, 'upleta', '360490', 'gujarat', '2012-01-05', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-28 05:33:02', '2024-07-06 11:45:43'),
(15, '8823312118', 9622814060, 9622814060, 'Janak Soni', '1234567894', NULL, 'janaka@gmail.com', 'asd qwe zxc', NULL, 'gandhinagar', '123456', 'gujarat', '2012-12-31', '11', 'male', 'married', 'IT Employee', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Ab Side', NULL, 1, '2024-07-07 06:19:53', '2024-07-07 06:21:45'),
(16, '6007062775', 9622814060, 9622814060, 'patient 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1987-12-28', '36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 'other', 'ab aca', NULL, 1, '2024-07-09 15:54:45', '2024-07-09 15:55:25'),
(17, '8029440359', 9622814060, 9622814060, 'patient 2', '1234567890', '1234567890', 'asd@gmail.com', NULL, NULL, NULL, NULL, NULL, '2003-01-01', '21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-07-09 16:00:37', '2024-07-09 16:01:15'),
(18, '3197211687', 3507097541, 3507097541, 'Bijal Patel', '12345679890', NULL, 'bijal@gmail.com', 'b-4, drwarkadhish, west gate', NULL, 'ahmedabad', '360005', 'gujarat', '1987-01-01', '37', 'female', 'married', 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"3197211687-9089431884.png\"]', 'no', 'no', 'occational', 'no', 'no', 'doctor', 'Raj Mehta', NULL, 1, '2024-08-04 04:57:55', '2024-08-04 04:57:55'),
(19, '5981076475', 3507097541, 8022048049, 'Khyaati Parekh', '1234567890', NULL, 'khyati@gmail.com', 'b-4, anand nagar, dwarkadhish society', NULL, NULL, NULL, NULL, '1991-01-01', '33', 'female', NULL, 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"5981076475-1084817721.png\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-04 04:59:09', '2024-08-06 02:23:16'),
(24, 'EVA202411271', 9622814060, 9622814060, 'test patient 1', '1234567890', '1234567890', 'testpatient1@gmail.com', 'asd sdasd asdsd asd asd as', NULL, 'upleta', '360490', 'gujarat', '2020-01-01', '4', 'male', 'married', 'IT Employee', 'asd sd', '1', '1', '0', '0', '', 'no', 'occational', 'occational', 'as sds d', 'asd asd s ds', 'other', 'as dqwq', NULL, 1, '2024-11-27 17:55:04', '2024-11-27 17:55:04'),
(25, 'EVA202412011', 9152073037, 9152073037, 'asd qwe', '1234567890', '1234567890', 'asd@gmail.com', 'b-4, anand nagar, dwarkadhish society', NULL, 'upleta', '360490', 'gujarat', '2024-12-01', '0', 'female', 'married', 'IT Employee', 'asd sd', '1', '1', '0', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-01 04:12:35', '2024-12-01 04:12:35'),
(26, 'EVA202412012', 9622814060, 9622814060, 'test patient 11', '1234567890', '1234567891', 'testpatient11@gmail.com', NULL, NULL, NULL, NULL, NULL, '2007-01-01', '17', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-01 04:26:20', '2024-12-01 04:26:20'),
(27, 'EVA202412013', 9622814060, 9622814060, 'patient 121', '1234567890', '1234567890', 'patient121@gmail.com', NULL, NULL, NULL, NULL, NULL, '2004-01-01', '20', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-01 07:20:16', '2024-12-01 07:20:16'),
(28, 'EVA202412101', 9622814060, 9622814060, 'Shilpa Shetty', '1234567890', '1234567890', 'shiplashetty@gmail.com', 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, NULL, NULL, NULL, '1991-01-10', '33', 'female', 'married', 'IT Employee', NULL, NULL, NULL, NULL, NULL, '[\"EVA202412101-9435383550.jpg\"]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'Dash Babu', NULL, 1, '2024-12-10 02:06:40', '2024-12-10 15:10:41'),
(29, 'EVA202412121', 9622814060, 9622814060, 'Roxane Rosy', '1234567890', '1234567890', 'roxanerosy@gmail.com', 'asd sdasd asdsd asd asd as as sd ssd', NULL, 'upleta', '360490', 'gujarat', '1987-01-12', '37', 'female', 'married', 'IT Employee', 'asd sd', '1', '1', '0', '0', '[\"\"]', 'no', 'no', 'no', 'asd s asdd asd as', 'as  sad as a s sa sdasd', 'doctor', 'as dqwq', NULL, 1, '2024-12-12 02:29:32', '2024-12-12 02:29:32'),
(30, 'EVA202412122', 9622814060, 9622814060, 'Murugan Shah', '1234567890', '1234567890', 'muruganshah@gmail.com', 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, 'upleta', '360490', 'gujarat', '1987-01-12', '37', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, NULL, NULL, NULL, 'other', 'as dqwq 1', '', 1, '2024-12-12 02:31:23', '2024-12-12 02:31:23'),
(31, 'EVA202412123', 9622814060, 9622814060, 'Mrudali verma', '1234567890', '1234567890', 'mrudali@gmail.com', 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, NULL, NULL, NULL, '1990-01-01', '34', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, NULL, NULL, NULL, 'doctor', 'as dqwq 2', NULL, 1, '2024-12-12 02:32:19', '2024-12-12 02:32:19'),
(32, 'EVA202412141', 9622814060, 9622814060, 'asd qwe', '1234567890', '1234567890', 'asd@gmail.com', 'b-4, anand nagar, dwarkadhish society', NULL, 'upleta', '360490', NULL, '2024-12-14', '0', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"abhayluva-13291523237.jpg\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-14 16:32:46', '2024-12-14 16:32:46'),
(33, 'EVA202412151', 9622814060, 9622814060, 'test patient 1', '1234567890', '1234567890', 'asd@gmail.com', 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, 'upleta', '360490', 'gujarat', '1992-12-29', '31', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-15 14:18:26', '2024-12-15 14:18:26'),
(35, 'EVA202412281', 9622814060, 9622814060, 'Sammy Sharma', '1234567890', NULL, 'sammy@gmail.com', 'b-4, anand nagar, dwarkadhish society', 'albpl56789', 'upleta', '360490', 'gujarat', '2007-01-03', '17', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"[\\\\\\\"\\\\\\\"]\\\"]\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-28 13:47:05', '2024-12-28 13:57:37'),
(36, 'EVA202501131', 9622814060, 9622814060, 'Saumya Vedic', '1234567890', '1234523456', NULL, 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, 'upleta', '360490', 'gujarat', NULL, '35', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"\\\"]\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 05:43:42', '2025-01-13 11:19:03'),
(37, 'EVA202501132', 9622814060, 9622814060, 'Rameswari Krishnan', '1234567890', '1234567891', NULL, 'asa s asd sd as asd as as as asas asa sdd asdas sd ds s d a sd asd asd', NULL, 'upleta', '360490', 'gujarat', NULL, '37', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"[\\\"\\\"]\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-01-13 12:14:15', '2025-01-13 12:14:33');

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
(46, 'mac-address-remove', 'Remove Mac Address', 'web', 'mac-address', '2024-06-24 08:51:15', '2024-06-24 08:51:15'),
(47, 'appointment-read', 'Read Appointment', 'web', 'appointment', NULL, NULL),
(48, 'appointment-create', 'Create Appointment', 'web', 'appointment', NULL, NULL),
(49, 'appointment-edit', 'Edit Appointment', 'web', 'appointment', NULL, NULL),
(50, 'appointment-status', 'Status Appointment', 'web', 'appointment', NULL, NULL),
(51, 'appointment-prescription', 'Prescription Appointment', 'web', 'appointment', NULL, NULL),
(52, 'appointment-full-view', 'Full View Appointment', 'web', 'appointment', NULL, NULL),
(53, 'appointment-bill-print', 'Bill Print Appointment', 'web', 'appointment', NULL, NULL),
(54, 'appointment-additional-charge', 'Additional Charge Appointment', 'web', 'appointment', NULL, NULL),
(55, 'ipd-read', 'Read IPD', 'web', 'ipd', NULL, NULL),
(56, 'ipd-create', 'Create IPD', 'web', 'ipd', NULL, NULL),
(57, 'ipd-edit', 'Edit IPD', 'web', 'ipd', NULL, NULL),
(58, 'ipd-status', 'Status IPD', 'web', 'ipd', NULL, NULL),
(59, 'ipd-opd-history', 'OPD History IPD', 'web', 'ipd', NULL, NULL),
(60, 'ipd-ipd-history', 'IPD History IPD', 'web', 'ipd', NULL, NULL),
(61, 'ipd-full-view', 'Full View IPD', 'web', 'ipd', NULL, NULL),
(62, 'ipd-bill-amount', 'Bill Amount IPD', 'web', 'ipd', NULL, NULL),
(63, 'ipd-operative-note', 'Operative Note IPD', 'web', 'ipd', NULL, NULL),
(64, 'ipd-prescribe', 'Prescribe IPD', 'web', 'ipd', NULL, NULL),
(65, 'ipd-detail-print', 'Detail Print IPD', 'web', 'ipd', NULL, NULL),
(66, 'follow-up-opd-read', 'Read OPD Follow Up', 'web', 'follow-up-opd', NULL, NULL),
(67, 'follow-up-opd-note', 'Note OPD Follow Up', 'web', 'follow-up-opd', NULL, NULL),
(68, 'follow-up-ipd-read', 'Read IPD Follow Up', 'web', 'follow-up-ipd', NULL, NULL),
(69, 'follow-up-ipd-note', 'Note IPD Follow Up', 'web', 'follow-up-ipd', NULL, NULL),
(70, 'follow-up-ipd-opd-history', 'Opd History IPD Follow Up', 'web', 'follow-up-ipd', NULL, NULL),
(71, 'follow-up-ipd-ipd-history', 'IPD History IPD Follow Up', 'web', 'follow-up-ipd', NULL, NULL),
(72, 'account-detail-opd-read', 'Read OPD Account Detail', 'web', 'account-detail-opd', NULL, NULL),
(73, 'account-detail-opd-additional-charge', 'Additional Charge OPD Account Detail', 'web', 'account-detail-opd', NULL, NULL),
(74, 'account-detail-ipd-read', 'Read IPD Account Detail', 'web', 'account-detail-ipd', NULL, NULL),
(75, 'account-detail-ipd-bill-amount', 'Bill Amount IPD Account Detail', 'web', 'account-detail-ipd', NULL, NULL),
(76, 'account-detail-ipd-print-bill', 'Print Bill IPD Account Detail', 'web', 'account-detail-ipd', NULL, NULL),
(77, 'balance-read', 'Balance Show', 'web', 'balance', NULL, NULL),
(78, 'trainee-payment', 'Payment Trainee', 'web', 'trainee', '2024-12-08 05:18:48', '2024-12-08 05:18:48'),
(79, 'ipd-indoor-sheet', 'Indoor Sheet IPD', 'web', 'ipd', '2024-12-08 05:18:48', '2024-12-08 05:18:48'),
(80, 'ipd-examination-sheet', 'Examination Sheet IPD', 'web', 'ipd', '2024-12-08 05:18:48', '2024-12-08 05:18:48'),
(81, 'ipd-documents', 'Documents IPD', 'web', 'ipd', '2024-12-08 05:18:48', '2024-12-08 05:18:48'),
(82, 'post-operative-medicine-read', 'Read Post Operative Medicine', 'web', 'post-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(83, 'post-operative-medicine-create', 'Create Post Operative Medicine', 'web', 'post-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(84, 'post-operative-medicine-update', 'Update Post Operative Medicine', 'web', 'post-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(85, 'post-operative-medicine-status', 'Status Post Operative Medicine', 'web', 'post-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(86, 'pre-operative-medicine-read', 'Read Pre Operative Medicine', 'web', 'pre-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(87, 'pre-operative-medicine-create', 'Create Pre Operative Medicine', 'web', 'pre-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(88, 'pre-operative-medicine-update', 'Update Pre Operative Medicine', 'web', 'pre-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(89, 'pre-operative-medicine-status', 'Status Pre Operative Medicine', 'web', 'pre-operative-medicine', '2025-01-13 04:40:51', '2025-01-13 04:40:51'),
(90, 'ipd-pre-operative-medicine', 'Pre Operative Medicine IPD', 'web', 'ipd', '2024-12-08 05:18:48', '2024-12-08 05:18:48');

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
-- Table structure for table `post_operative_medicines`
--

CREATE TABLE `post_operative_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poom_id` text NOT NULL,
  `poom_added_by` text NOT NULL,
  `poom_updated_by` text NOT NULL,
  `recommendation` text NOT NULL,
  `poom_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active, 0-disable	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_operative_medicines`
--

INSERT INTO `post_operative_medicines` (`id`, `poom_id`, `poom_added_by`, `poom_updated_by`, `recommendation`, `poom_status`, `created_at`, `updated_at`) VALUES
(1, '5725626428', '9622814060', '9622814060', 'asd', 1, '2025-01-12 17:05:41', '2025-01-13 05:21:04'),
(2, '5762865835', '9622814060', '9622814060', 'qwe', 1, '2025-01-13 05:21:11', '2025-01-13 05:21:11'),
(3, '1074365478', '9622814060', '9622814060', 'zxc', 1, '2025-01-13 05:21:18', '2025-01-13 05:21:18');

-- --------------------------------------------------------

--
-- Table structure for table `pre_operative_medicines`
--

CREATE TABLE `pre_operative_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pom_id` text NOT NULL,
  `pom_added_by` text NOT NULL,
  `pom_updated_by` text NOT NULL,
  `recommendation` text NOT NULL,
  `description` text DEFAULT NULL,
  `given_or_not` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-yes, 0-no',
  `pom_status` int(11) NOT NULL DEFAULT 1 COMMENT '	1-active, 0-disable	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pre_operative_medicines`
--

INSERT INTO `pre_operative_medicines` (`id`, `pom_id`, `pom_added_by`, `pom_updated_by`, `recommendation`, `description`, `given_or_not`, `pom_status`, `created_at`, `updated_at`) VALUES
(1, '8334174072', '9622814060', '9622814060', 'asd', 'asdas asd sa das', 0, 1, '2025-01-14 04:48:51', '2025-01-14 04:48:51'),
(2, '1933716568', '9622814060', '9622814060', 'asd qwe', 'as sa sa as as ss sa as ads sasad as as as sa sa sa sa sa sa sa', 1, 1, '2025-01-14 04:50:33', '2025-01-14 05:01:07');

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
(12, 3457506543, 9622814060, 9622814060, 'ab aca', '2024-07-09 15:55:07', '2024-07-09 15:55:07'),
(13, 6818228222, 9622814060, 9622814060, 'as dqwq 1', '2024-11-27 15:30:59', '2024-11-27 15:30:59'),
(14, 4186257664, 9622814060, 9622814060, 'as dqwq', '2024-11-27 17:53:41', '2024-11-27 17:53:41'),
(15, 5379687346, 9622814060, 9622814060, 'as dqwq 2', '2024-12-12 02:32:19', '2024-12-12 02:32:19');

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
(46, 1),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1);

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
(6, 1763176195, 9622814060, 9622814060, 'B', '1', 'B', '101', 450, 1, 1, '2024-06-23 22:01:19', '2025-01-13 05:21:43'),
(7, 9657298017, 9622814060, 9622814060, 'B', '1', 'B', '102', 450, 1, 1, '2024-06-23 22:01:29', '2025-01-14 10:04:01'),
(8, 3939260528, 9622814060, 9622814060, 'B', '2', 'A', '101', 450, 1, 1, '2024-06-23 22:01:44', '2025-01-13 05:10:08'),
(9, 8346064090, 9622814060, 9622814060, 'B', '2', 'A', '102', 450, 1, 1, '2024-06-23 22:02:17', '2024-12-28 13:53:12'),
(10, 3532694461, 9622814060, 9622814060, 'A', '1', 'B', '101', 450, 1, 1, '2024-06-23 22:02:30', '2024-12-27 03:02:09'),
(11, 9318726306, 9622814060, 9622814060, 'A', '1', 'B', '102', 450, 1, 1, '2024-06-23 22:02:37', '2024-12-10 14:57:47'),
(12, 7623041434, 9622814060, 9622814060, 'A', '2', 'B', '101', 450, 1, 1, '2024-06-23 22:02:49', '2024-12-10 14:51:49'),
(13, 6013882173, 9622814060, 9622814060, 'A', '2', 'B', '102', 500, 1, 1, '2024-06-23 22:02:57', '2024-12-01 10:47:23'),
(14, 5671800060, 9622814060, 9622814060, 'C', '1', 'A', '101', 700, 1, 1, '2024-06-23 22:03:25', '2024-08-04 05:54:50'),
(15, 1745383720, 9622814060, 9622814060, 'C', '1', 'A', '102', 700, 1, 1, '2024-06-23 22:03:30', '2024-12-01 08:59:09'),
(16, 4867399090, 9622814060, 9622814060, 'C', '1', 'A', '103', 700, 1, 1, '2024-06-23 22:03:38', '2024-08-04 08:59:29'),
(17, 7626108364, 9622814060, 9622814060, 'C', '2', 'A', '101', 700, 1, 1, '2024-06-23 22:03:54', '2024-08-14 01:54:59'),
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
  `tr_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-pending, 2-on going, 3-completed, 4-cancelled',
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
(8, 4843724109, 9622814060, 9622814060, 2024070711919847, 'ab trainee', 'asd', '1234567890', '2024-07-10', '2024-07-16', 15000, 3000, 1, '2024-07-07', 'qwe', '[\"2024070711919847-2283185294.png\"]', 1, NULL, '2024-07-07 05:43:31', '2024-07-07 05:43:31'),
(9, 6073912718, 9622814060, 9622814060, 2024120808254860, 'asd 11', 'ad sdaasdsdas d asasdd asd', '1234567890', '2024-12-08', '2025-02-23', 30000, 2200, 0, '2024-12-08', 'qwe w qw qw qe qwe qqwe', '[\"2024120808254860-6198185709.docx\"]', 4, '', '2024-12-08 03:27:21', '2024-12-16 16:14:00'),
(10, 7412563426, 9622814060, 9622814060, 2024121422808390, 'asd', 'asdsd as asd sda', '1234567890', '2024-12-19', '2025-01-02', 12000, NULL, 0, '2024-12-14', 'ad asd as ds s', '[\"abhayluva-16839908.jpg\",\"abhayluva6823224.jpg\",\"WhatsApp-Image-2024-03-30-at-89792512.jpeg\"]', 3, '', '2024-12-14 16:41:29', '2024-12-16 16:12:34'),
(11, 1586281750, 9622814060, 9622814060, 2024121422693085, 'asd', 'asasd a sd d das dad asd', '1234567890', '2024-12-14', '2025-01-02', 13000, NULL, 0, '2024-12-14', 'd asd as dasd asd asd sd s', '[\"abhayluva-1663477.jpg\",\"WhatsApp-Image-2024-03-30-at-8-6087208.jpeg\",\"ab-1581172.jpg\",\"img1-9416739.jpg\"]', 3, '', '2024-12-14 16:43:59', '2024-12-16 16:12:41'),
(12, 5688142680, 9622814060, 9622814060, 2024121519749216, 'asd', 'asd s', '1234567890', '2024-12-15', '2025-02-16', 12000, NULL, 0, '2024-12-15', 'asd as', NULL, 2, '', '2024-12-15 14:15:50', '2024-12-16 16:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `trainee_payment_lists`
--

CREATE TABLE `trainee_payment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tpl_id` bigint(20) NOT NULL,
  `tr_id` bigint(20) NOT NULL COMMENT 'trainee id',
  `tpl_added_by` bigint(20) NOT NULL,
  `tpl_desc` text NOT NULL,
  `tpl_amount` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainee_payment_lists`
--

INSERT INTO `trainee_payment_lists` (`id`, `tpl_id`, `tr_id`, `tpl_added_by`, `tpl_desc`, `tpl_amount`, `created_at`, `updated_at`) VALUES
(10, 5563949229, 6073912718, 9622814060, 'asd', '2000', '2024-12-08 05:15:09', '2024-12-08 05:15:09'),
(12, 5492027352, 6073912718, 9622814060, 'qwe', '100', '2024-12-14 15:11:49', '2024-12-14 15:11:49'),
(13, 3456219690, 6073912718, 9622814060, 'qwe', '100', '2024-12-14 15:12:19', '2024-12-14 15:12:19');

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
  `contactno` text NOT NULL,
  `address` varchar(255) DEFAULT NULL,
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
(1, 9622814060, 'super_admin', 'superadmin@gmail.com', '2024-06-17 06:27:21', '$2y$12$.OnlOXKQC.UlJqRQc2n5Hue9evXhVsxA8nYW2t6fBPnJ/OR/r2eeW', 'Super Admin', '1234567890', 'EVA hospital, Ahmedabad', 9622814060, 9622814060, 1, 1, 'QmxjPEKKu7eUd5EX5vhvVPQkl3zrCzB14JI8gahdu7lO6gxSwXdO2rApuFha', '2024-06-17 06:27:21', '2024-07-27 07:52:16'),
(2, 5962819849, 'abhay_luva', 'ablov@gmail.com', NULL, '$2y$12$uJN2Ddjob97F7vqw2ufkROYVoNYa1JNOVEb4QYX3xpoS3Wuu8bsgG', 'Abhay Luva', '1245784251', 'dwarkadhish so, anand nagar, beind vrajwihar, rajkot', 9622814060, 9622814060, 1, 1, NULL, '2024-06-18 03:29:40', '2024-06-28 06:09:51'),
(3, 8022048049, 'haresh_bhai', 'hr@gmail.com', NULL, '$2y$12$lxNz9YPwZN6lJpCdg4Q3reDnW4xDdaC6ZIBvNJzerSDKgKdJEguH2', 'Haresh Bhai', '1245784251', 'asasds sas adsd', 5962819849, 9622814060, 1, 1, NULL, '2024-06-18 03:47:03', '2024-06-28 06:08:36'),
(4, 6636406942, 'raj', 'raj@gmail.com', NULL, '$2y$12$jmAFeQGPaIgM.DhK.dGrM.sVk7ODQ4ufKVqKXpzJ7DCwRRYokVtyG', 'Raj Bhai', '1234567890', 'asd as dasdasda', 9622814060, 9622814060, 1, 1, NULL, '2024-06-19 04:20:03', '2024-06-28 06:09:42'),
(5, 7308573809, 'pankit', 'pk@gmail.com', NULL, '$2y$12$k.pdzDXoH5nfTQVLUUG6HOFla1y7M8f4E5nI25KbySMhhPdeKqyWa', 'pankit', '1234567890', 'asd qwe zxc', 9622814060, 9622814060, 1, 1, NULL, '2024-06-28 06:09:26', '2024-06-28 06:09:26'),
(7, 3507097541, 'akshar_shah', 'akshar@gmail.com', NULL, '$2y$12$d1vYivDld.c2lnc/zA2da.8Ob4./8z7cFuThQCcvDjOMrYTU1vC7G', 'Akshar Shah', '1234567890', 'as dsdasdsdadasd asdasd asdas', 9622814060, 9622814060, 1, 1, NULL, '2024-08-04 04:45:34', '2024-08-04 04:45:34'),
(8, 9152073037, 'doctor', 'doctor@gmail.com', NULL, '$2y$12$9OyjS6ykE9OAbkyubZt7sOOZhdmDsMVwDxUtgJQs49ngYHKwvKsiy', 'Doctor Name', '1234567890', 'as d asd asd a', 9622814060, 9622814060, 1, 1, NULL, '2024-11-20 14:01:16', '2024-11-20 14:01:16'),
(9, 6922981237, 'accountant', 'accountant@gmail.com', NULL, '$2y$12$B6okHNHuD5WNOuN5Z/oWKuVXreWqM3iISLpfvqywMgt37tlq9Xlw.', 'acc', '1234567890', 'asd asd asd sd', 9622814060, 9622814060, 1, 1, NULL, '2024-11-20 14:07:11', '2024-11-20 14:07:11'),
(10, 7639639325, 'acc', 'accountant1@gmail.com', NULL, '$2y$12$MeGPw0c0/1s60VX3rIUMuORYMd9fJNNGOmiRwizZFqyVvNm1eyiK2', 'acc 1', '1245784251', NULL, 9622814060, 9622814060, 1, 1, NULL, '2024-11-20 14:09:03', '2024-11-20 14:09:03'),
(11, 2037845628, 'test user 1', 'testuser1@gmail.com', NULL, '$2y$12$AVq1MPtZ..oVFqX/TeUs1e4vECiH8HongF6rX8xFa1ykg5xN.uIKq', 'test user 1', '9252412513', NULL, 9622814060, 9622814060, 1, 1, NULL, '2024-11-27 17:24:17', '2024-11-27 17:24:17'),
(12, 2851649046, 'haresh_bhai', 'asd@gmail.com', NULL, '$2y$12$/IntfLvDw8KUooNDU2fBc.Wsfc/DdujB.8Ls2M7c6tSElGJE.wVr.', 'Haresh Bhai', '9710234567', 'asasd asds', 9152073037, 9622814060, 1, 1, NULL, '2024-12-01 04:10:34', '2024-12-01 08:29:48');

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
(3, 7406112400, 9622814060, 9622814060, 'emergency', 700, '2024-06-18 10:37:54', '2024-07-27 05:17:43'),
(4, 7406112401, 9622814060, 9622814060, 'foc', 0, '2024-06-17 10:39:54', '2024-07-27 05:17:43'),
(5, 7406112403, 9622814060, 9622814060, 'follow up', 0, '2024-06-17 10:39:54', '2024-07-27 05:17:43');

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
-- Indexes for table `appointment_documents`
--
ALTER TABLE `appointment_documents`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `indoor_sheets`
--
ALTER TABLE `indoor_sheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indoor_sheet_medicines`
--
ALTER TABLE `indoor_sheet_medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indoor_sheet_medicine_examinations`
--
ALTER TABLE `indoor_sheet_medicine_examinations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `ipd_documents`
--
ALTER TABLE `ipd_documents`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `ipd_pre_operative_medicines`
--
ALTER TABLE `ipd_pre_operative_medicines`
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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `post_operative_medicines`
--
ALTER TABLE `post_operative_medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_operative_medicines`
--
ALTER TABLE `pre_operative_medicines`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `trainee_payment_lists`
--
ALTER TABLE `trainee_payment_lists`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `appointment_additional_charges`
--
ALTER TABLE `appointment_additional_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `appointment_documents`
--
ALTER TABLE `appointment_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment_medicines`
--
ALTER TABLE `appointment_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_medicines`
--
ALTER TABLE `general_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `indoor_sheets`
--
ALTER TABLE `indoor_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `indoor_sheet_medicines`
--
ALTER TABLE `indoor_sheet_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `indoor_sheet_medicine_examinations`
--
ALTER TABLE `indoor_sheet_medicine_examinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ipd_charges`
--
ALTER TABLE `ipd_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `ipd_details`
--
ALTER TABLE `ipd_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ipd_documents`
--
ALTER TABLE `ipd_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ipd_operative_notes`
--
ALTER TABLE `ipd_operative_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ipd_payment_lists`
--
ALTER TABLE `ipd_payment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ipd_pre_operative_medicines`
--
ALTER TABLE `ipd_pre_operative_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mac_addresses`
--
ALTER TABLE `mac_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_operative_medicines`
--
ALTER TABLE `post_operative_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pre_operative_medicines`
--
ALTER TABLE `pre_operative_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `referred_doctors`
--
ALTER TABLE `referred_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `trainee_payment_lists`
--
ALTER TABLE `trainee_payment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `visiting_fees`
--
ALTER TABLE `visiting_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
