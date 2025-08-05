-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 05:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ridenowdbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', '2025-04-07 16:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `admin_contact`
--

CREATE TABLE `admin_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_drivers`
--

CREATE TABLE `admin_drivers` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_drivers`
--

INSERT INTO `admin_drivers` (`driver_id`, `name`, `phone`, `vehicle_number`, `vehicle_type`, `status`, `created_at`) VALUES
(2, 'Satish kumar', '1234567890', '111213', 'car premium', 1, '2025-04-07 19:21:00'),
(3, 'Ravi kumar', '9876543210', '987456', 'bike', 1, '2025-04-07 19:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `admin_feedback`
--

CREATE TABLE `admin_feedback` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_general_settings`
--

CREATE TABLE `admin_general_settings` (
  `id` int(11) NOT NULL,
  `night_start` time NOT NULL DEFAULT '22:00:00',
  `night_end` time NOT NULL DEFAULT '05:00:00',
  `max_distance` int(11) NOT NULL DEFAULT 50,
  `cancel_time` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_general_settings`
--

INSERT INTO `admin_general_settings` (`id`, `night_start`, `night_end`, `max_distance`, `cancel_time`) VALUES
(1, '22:00:00', '05:00:00', 50, 5);

-- --------------------------------------------------------

--
-- Table structure for table `admin_vehicle_rates`
--

CREATE TABLE `admin_vehicle_rates` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(20) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `per_km` decimal(10,2) NOT NULL,
  `per_passenger` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_vehicle_rates`
--

INSERT INTO `admin_vehicle_rates` (`id`, `vehicle_type`, `base_price`, `per_km`, `per_passenger`) VALUES
(1, 'car premium', 60.00, 10.00, 10.00),
(2, 'auto', 50.00, 9.00, 20.00),
(3, 'bike', 30.00, 6.00, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ride_type` varchar(50) NOT NULL DEFAULT 'car premium',
  `pickup_location` varchar(255) DEFAULT NULL,
  `drop_location` varchar(255) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `passengers` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(20) DEFAULT 'cash',
  `payment_proof` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT 0,
  `distance` double DEFAULT 0,
  `driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `ride_type`, `pickup_location`, `drop_location`, `booking_date`, `booking_time`, `passengers`, `status`, `created_at`, `payment_method`, `payment_proof`, `amount`, `distance`, `driver_id`) VALUES
(24, 9, '0', 'Ahmedabad Airport', 'Iscon Mall Ahmedabad', '2025-04-10', '06:08:00', 2, 'pending', '2025-04-06 09:07:23', 'cash', NULL, 370, 18.32, NULL),
(25, 9, '0', 'Iscon Mall Ahmedabad', 'Alpha One Mall Ahmedabad', '2025-04-09', '06:55:00', 2, 'pending', '2025-04-06 09:07:47', 'cash', NULL, 150, 0, NULL),
(26, 9, '0', 'Ahmedabad Railway Station', 'Ahmedabad Airport', '2025-04-08', '06:05:00', 3, 'cancelled', '2025-04-06 09:11:40', 'cash', NULL, NULL, NULL, NULL),
(27, 9, '0', 'Iscon Mall Ahmedabad', 'Ahmedabad Airport', '2025-04-11', '06:05:00', 2, 'cancelled', '2025-04-06 09:12:00', 'cash', NULL, NULL, NULL, NULL),
(28, 9, '0', 'Ahmedabad Airport', 'Ahmedabad Railway Station', '2025-04-11', '03:02:00', 2, 'cancelled', '2025-04-06 09:16:37', 'cash', NULL, 0, 0, NULL),
(29, 9, '0', 'Ahmedabad Railway Station', 'Alpha One Mall Ahmedabad', '2025-04-09', '06:05:00', 2, 'pending', '2025-04-06 09:18:15', 'cash', NULL, 0, 0, NULL),
(30, 9, '0', 'Ahmedabad Railway Station', 'Iscon Mall Ahmedabad', '2025-04-11', '06:05:00', 3, 'cancelled', '2025-04-06 09:19:05', 'cash', NULL, 0, 0, NULL),
(31, 9, '0', 'Ahmedabad Airport', 'Ahmedabad Railway Station', '2025-04-10', '06:05:00', 3, 'pending', '2025-04-06 09:23:37', 'cash', NULL, 0, 0, NULL),
(32, 9, '0', 'Ahmedabad Airport', 'Ahmedabad Railway Station', '2025-04-08', '03:56:00', 2, 'cancelled', '2025-04-06 09:27:16', 'cash', NULL, 0, 0, NULL),
(33, 9, '0', 'Iscon Mall', 'Ahmedabad Railway Station', '2025-04-06', '05:55:00', 1, 'pending', '2025-04-06 09:38:34', 'cash', NULL, 0, 0, NULL),
(34, 9, '0', 'Alpha One Mall', 'Sabarmati Ashram', '2025-04-10', '04:44:00', 2, 'pending', '2025-04-06 09:44:16', 'cash', NULL, 0, 0, NULL),
(35, 9, '0', 'Ahmedabad Railway Station', 'Alpha One Mall', '2025-04-07', '02:05:00', 3, 'pending', '2025-04-06 09:56:05', 'cash', NULL, 0, 0, NULL),
(36, 9, '0', 'Ahmedabad Airport', 'Iscon Mall', '2025-04-06', '08:08:00', 2, 'pending', '2025-04-06 10:04:02', 'cash', NULL, 0, 0, NULL),
(37, 9, '0', 'Ahmedabad Railway Station', 'Ahmedabad Airport', '2025-04-08', '05:55:00', 2, 'confirmed', '2025-04-07 05:13:28', 'cash', 'payment_37_1744002845.jpg', 0, 0, NULL),
(38, 9, '0', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-04-09', '06:05:00', 2, 'pending', '2025-04-07 05:20:13', 'cash', NULL, 0, 0, NULL),
(39, 12, '0', 'Ahmedabad Airport', 'Alpha One Mall', '2025-04-08', '06:05:00', 1, 'cancelled', '2025-04-07 05:36:07', 'cash', NULL, 0, 0, NULL),
(40, 12, '0', 'Sabarmati Ashram', 'Ahmedabad Railway Station', '2025-04-10', '05:08:00', 4, 'confirmed', '2025-04-07 05:36:55', 'cash', 'payment_40_1744004235.jpg', 0, 0, NULL),
(41, 12, '0', 'Ahmedabad Airport', 'Iscon Mall', '2025-04-09', '05:04:00', 4, 'confirmed', '2025-04-07 06:05:20', 'cash', 'payment_41_1744005955.jpg', 0, 0, NULL),
(42, 9, '0', 'Ahmedabad Railway Station', 'Alpha One Mall', '2025-04-09', '17:55:00', 2, 'pending', '2025-04-07 07:29:16', 'cash', NULL, 86, 5.95, NULL),
(43, 9, '0', 'Sabarmati Ashram', 'Alpha One Mall', '2025-04-09', '08:08:00', 2, 'confirmed', '2025-04-07 07:30:11', 'cash', 'payment_43_1744011021.jpg', 91, 6.72, NULL),
(44, 9, '0', 'Iscon Mall', 'Ahmedabad Airport', '2025-05-08', '08:55:00', 2, 'cancelled', '2025-04-07 07:38:47', 'cash', NULL, 159, 18.16, NULL),
(45, 9, '0', 'Ahmedabad Airport', 'Ahmedabad Railway Station', '2025-04-10', '17:55:00', 2, 'cancelled', '2025-04-07 07:48:36', 'cash', NULL, 114, 10.54, NULL),
(46, 9, '0', 'Ahmedabad Airport', 'Alpha One Mall', '2025-04-08', '15:33:00', 1, 'completed', '2025-04-07 12:33:59', 'cash', NULL, 280, 15, NULL),
(47, 9, '0', 'Alpha One Mall', 'Ahmedabad Railway Station', '2025-04-09', '17:55:00', 2, 'confirmed', '2025-04-07 12:55:04', 'cash', 'payment_47_1744030515.jpg', 219, 5.71, NULL),
(48, 15, '0', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-09', '05:04:00', 2, 'confirmed', '2025-04-07 14:51:38', 'cash', 'payment_48_1744037524.jpg', 92, 6.92, NULL),
(49, 9, '0', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-08', '22:22:00', 2, 'confirmed', '2025-04-07 16:16:06', 'cash', 'payment_49_1744043000.jpg', 234, 6.92, NULL),
(50, 9, '0', 'Ahmedabad Airport', 'Iscon Mall', '2025-04-18', '03:33:00', 2, 'completed', '2025-04-07 16:38:56', 'cash', 'payment_50_1744043943.jpg', 371, 18.37, NULL),
(57, 1, 'car premium', 'Ahmedabad Airport', 'Iscon Mall', '2024-02-20', '14:30:00', NULL, 'cancelled', '2025-04-07 17:06:52', 'cash', NULL, 450, 0, NULL),
(58, 1, 'car premium', 'Gujarat University', 'Sabarmati Ashram', '2024-02-20', '15:00:00', NULL, 'completed', '2025-04-07 17:06:52', 'cash', NULL, 350, 0, NULL),
(59, 1, 'car premium', 'Maninagar', 'Vastrapur Lake', '2024-02-20', '16:00:00', NULL, 'cancelled', '2025-04-07 17:06:52', 'cash', NULL, 550, 0, NULL),
(60, 18, '0', 'Ahmedabad Airport', 'Ahmedabad Railway Station', '2025-04-08', '16:04:00', 1, 'completed', '2025-04-07 17:19:40', 'cash', 'payment_60_1744046389.jpg', 94, 10.54, NULL),
(61, 1, 'car premium', 'Maninagar', 'Vastrapur Lake', '2024-02-20', '16:00:00', NULL, 'completed', '2025-04-07 17:35:44', 'cash', NULL, 550, 0, NULL),
(62, 18, '0', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-11', '22:02:00', 1, 'completed', '2025-04-07 17:55:09', 'cash', 'payment_62_1744048516.jpg', 72, 6.92, NULL),
(63, 18, '0', 'Iscon Mall', 'Sabarmati Ashram', '2025-04-09', '22:22:00', 1, 'cancelled', '2025-04-07 17:58:45', 'cash', NULL, 136, 10.74, NULL),
(64, 19, '0', 'Ahmedabad Airport', 'Iscon Mall', '2025-04-10', '16:04:00', 1, 'completed', '2025-04-07 18:42:41', 'cash', 'payment_64_1744051369.jpg', 141, 18.37, NULL),
(65, 9, '0', 'Iscon Mall', 'Gujarat University', '2025-04-11', '04:56:00', 1, 'completed', '2025-04-08 05:24:56', 'cash', 'payment_65_1744089914.jpg', 169, 5.71, NULL),
(66, 9, '0', 'Ahmedabad Airport', 'Alpha One Mall', '2025-04-10', '23:01:00', 2, 'completed', '2025-04-09 03:29:15', 'cash', 'payment_66_1744169365.jpg', 330, 15, NULL),
(67, 9, '0', 'Ahmedabad Airport', 'Sabarmati Ashram', '2025-04-12', '14:22:00', 1, 'pending', '2025-04-10 13:10:31', 'cash', NULL, 92, 10.33, NULL),
(68, 9, '0', 'Iscon Mall', 'Maninagar', '2025-04-18', '08:50:00', 2, 'pending', '2025-04-10 13:18:20', 'cash', NULL, 121, 11.83, NULL),
(69, 9, '0', 'Ahmedabad Airport', 'Maninagar', '2025-04-12', '09:59:00', 1, 'cancelled', '2025-04-10 13:27:20', 'cash', NULL, 144, 11.71, NULL),
(70, 9, 'car premium', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-04-17', '08:16:00', 1, 'cancelled', '2025-04-10 13:45:34', 'cash', NULL, 170, 5.78, NULL),
(71, 9, 'auto', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-11', '07:18:00', 1, 'cancelled', '2025-04-10 13:47:10', 'cash', NULL, 106, 6.92, NULL),
(72, 9, 'bike', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-11', '07:18:00', 1, 'cancelled', '2025-04-10 13:47:25', 'cash', NULL, 72, 6.92, NULL),
(73, 9, 'car premium', 'Ahmedabad Railway Station', 'Alpha One Mall', '2025-04-12', '06:54:00', 3, 'cancelled', '2025-04-11 08:56:14', 'cash', NULL, 272, 5.95, NULL),
(74, 9, 'auto', 'Iscon Mall', 'Alpha One Mall', '2025-04-12', '04:44:00', 2, 'completed', '2025-04-11 10:24:00', 'cash', 'payment_74_1744367050.jpg', 109, 3.52, NULL),
(75, 9, 'car premium', 'Ahmedabad Railway Station', 'Ahmedabad Railway Station', '2025-04-25', '04:55:00', 2, 'completed', '2025-04-11 10:28:27', 'cash', 'payment_75_1744367314.jpg', 150, 0, NULL),
(76, 9, 'bike', 'Ahmedabad Airport', 'Sabarmati Ashram', '2025-04-12', '02:55:00', 1, 'completed', '2025-04-11 16:10:26', 'cash', 'payment_76_1744387834.jpg', 92, 10.33, NULL),
(77, 9, 'bike', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-04-12', '15:02:00', 1, 'completed', '2025-04-12 08:50:49', 'cash', 'payment_77_1744447856.jpg', 65, 5.78, NULL),
(78, 9, 'bike', 'Ahmedabad Railway Station', 'Alpha One Mall', '2025-04-12', '14:23:00', 1, 'completed', '2025-04-12 08:52:00', 'cash', 'payment_78_1744447927.jpg', 66, 5.95, NULL),
(79, 9, 'bike', 'Iscon Mall', 'Alpha One Mall', '2025-04-12', '14:25:00', 2, 'completed', '2025-04-12 15:44:18', 'cash', 'payment_79_1744472664.jpg', 72, 3.52, NULL),
(80, 9, 'car premium', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-04-12', '23:03:00', 1, 'completed', '2025-04-12 16:49:43', 'cash', 'payment_80_1744476618.jpg', 170, 5.78, NULL),
(81, 9, 'bike', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-04-12', '23:11:00', 1, 'completed', '2025-04-12 16:50:53', 'cash', NULL, 65, 5.78, 1),
(82, 9, 'bike', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-13', '11:11:00', 1, 'completed', '2025-04-12 17:25:16', 'cash', 'payment_82_1744478722.jpg', 72, 6.92, NULL),
(83, 9, 'car premium', 'Ahmedabad Airport', 'Gujarat University', '2025-04-16', '00:15:00', 4, 'completed', '2025-04-12 18:43:31', 'cash', 'payment_83_1744483495.webp', 412, 13.46, NULL),
(84, 9, 'bike', 'Iscon Mall', 'Alpha One Mall', '2025-04-13', '04:05:00', 1, 'completed', '2025-04-13 07:29:10', 'cash', 'payment_84_1744529357.jpg', 52, 3.52, NULL),
(85, 9, 'bike', 'Alpha One Mall', 'Maninagar', '2025-04-13', '12:56:00', 1, 'completed', '2025-04-13 08:58:50', 'cash', 'payment_85_1744534736.jpg', 97, 11.08, NULL),
(86, 9, 'bike', 'Ahmedabad Airport', 'Alpha One Mall', '2025-04-13', '11:01:00', 2, 'completed', '2025-04-13 13:11:16', 'cash', 'payment_86_1744549890.jpg', 140, 15, NULL),
(87, 9, 'car premium', 'Iscon Mall', 'Ahmedabad Railway Station', '2025-04-13', '08:08:00', 1, 'completed', '2025-04-13 16:23:02', 'cash', 'payment_87_1744561390.jpg', 134, 6.93, NULL),
(88, 9, 'bike', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-04-13', '08:08:00', 2, 'completed', '2025-04-13 16:28:57', 'cash', 'payment_88_1744561744.jpg', 72, 6.92, NULL),
(89, 20, 'auto', 'Ahmedabad Airport', 'Sabarmati Ashram', '2025-04-29', '00:18:00', 2, 'completed', '2025-04-27 15:49:07', 'cash', 'payment_89_1745768966.jpg', 128, 10.33, NULL),
(90, 20, 'bike', 'Ahmedabad Railway Station', 'Sabarmati Ashram', '2025-05-02', '01:14:00', 1, 'completed', '2025-04-30 18:44:08', 'cash', 'payment_90_1746038657.webp', 65, 5.78, NULL),
(91, 20, 'bike', 'Ahmedabad Railway Station', 'Iscon Mall', '2025-05-01', '22:54:00', 1, 'confirmed', '2025-05-01 03:01:09', 'cash', 'payment_91_1746068484.jpg', 72, 6.92, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'riddhi', 'r@gmail.com', 'nice facilities', '2025-04-04 10:20:14'),
(2, 'riddhi', 'r@gmail.com', 'hello i\'m ridhdhi', '2025-04-04 12:02:04'),
(3, 'ridhdhi', 'ridhdhiraval2005@gmail.com', 'hi i\'m ridhdhi', '2025-04-07 05:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `vehicle_type` enum('car','bike','auto') DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `fullname`, `email`, `phone`, `address`, `vehicle_number`, `vehicle_type`, `license_number`, `profile_pic`, `status`) VALUES
(1, 'veer ', 'veer@gmail.com', '1234567890', 'Test Address', 'VEH123', 'car', 'LIC123', 'uploads/driver_1_1745769890.jpg', 'active'),
(2, 'satish', 'satish@gmail.com', '1234567891', 'Ahmedabad ', 'VEH124', 'bike', 'LIC124', 'uploads/driver_2_1744540856.jpg', 'active'),
(3, 'manish', 'manish@gmail.com', '1234567892', 'Ahmedabad ', 'VEH125', 'car', 'LIC125', 'uploads/driver_3_1744541093.jpg', 'active'),
(4, 'veer', 'veer@gmail.com.', '1234567896', 'AAhmedabad ', 'VEH126', 'auto', 'LIC126', NULL, 'active'),
(5, 'anshil', 'anshil@gmail.com', '9632587410', NULL, '112233', 'auto', 'LIC789', '', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `driver_bookings`
--

CREATE TABLE `driver_bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `drop_location` varchar(255) NOT NULL,
  `fare_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','accepted','completed','cancelled') DEFAULT 'pending',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `completion_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_login`
--

CREATE TABLE `driver_login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_login`
--

INSERT INTO `driver_login` (`id`, `email`, `password`, `driver_id`, `status`, `last_login`) VALUES
(1, 'veer@gmail.com', 'veer', 1, 'active', NULL),
(2, 'satish@gmail.com', 'satish', 2, 'active', NULL),
(3, 'manish@gmail.com', 'manish', 3, 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_table`
--

CREATE TABLE `driver_table` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `vehicle_type` enum('Bike','Car','Auto') NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_table`
--

INSERT INTO `driver_table` (`driver_id`, `name`, `email`, `password`, `phone`, `vehicle_type`, `vehicle_number`, `license_number`, `profile_image`, `status`, `created_at`) VALUES
(1, 'Veer Kumar', 'veer@gmail.com', 'veer', '9876543210', 'Bike', 'MP09 BK 1234', 'DL123456', NULL, 'active', '2025-04-12 16:14:47'),
(2, 'Satish Singh', 'satish@gmail.com', 'satish', '9876543211', 'Car', 'MP09 CA 5678', 'DL789012', NULL, 'active', '2025-04-12 16:14:47'),
(3, 'Manish Verma', 'manish@gmail.com', 'manish', '9876543212', 'Auto', 'MP09 AU 9012', 'DL345678', NULL, 'active', '2025-04-12 16:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 9, 2, 'mehhhhhh', '2025-04-08 10:36:25'),
(2, 9, 2, 'mehhhhhh', '2025-04-08 10:42:14'),
(3, 9, 2, 'mehhhhhh', '2025-04-08 10:46:36'),
(4, 9, 2, 'mehhhhhh', '2025-04-08 10:46:41'),
(5, 9, 5, 'excellent', '2025-04-08 10:47:04'),
(6, 20, 5, '', '2025-04-27 21:37:07'),
(7, 20, 1, '', '2025-04-27 21:37:21'),
(8, 20, 1, '', '2025-04-27 22:13:31'),
(9, 20, 3, '', '2025-04-27 22:13:56'),
(10, 20, 1, '', '2025-04-27 22:14:42'),
(11, 20, 1, '', '2025-04-27 22:20:01'),
(12, 20, 1, '', '2025-04-27 22:20:06'),
(13, 20, 2, 'bad', '2025-04-27 22:20:16'),
(14, 20, 2, 'bad', '2025-04-27 22:22:36'),
(15, 20, 4, '', '2025-04-27 22:23:01'),
(16, 20, 4, '', '2025-04-27 22:24:50'),
(17, 20, 3, '', '2025-04-27 22:25:12'),
(18, 20, 4, '', '2025-04-27 22:51:03'),
(19, 20, 4, '', '2025-04-27 22:53:14'),
(20, 20, 4, '', '2025-04-27 22:54:41'),
(21, 20, 3, '', '2025-04-27 22:54:53'),
(22, 20, 3, '', '2025-04-27 22:56:10'),
(23, 20, 1, 'not like it', '2025-04-27 22:56:46'),
(24, 20, 1, 'not like it', '2025-04-27 22:58:25'),
(25, 20, 4, '', '2025-04-27 22:59:51'),
(26, 20, 5, '', '2025-05-01 08:32:03'),
(27, 20, 3, '', '2025-05-01 08:36:34'),
(28, 20, 3, '', '2025-05-01 08:38:26'),
(29, 20, 3, '', '2025-05-01 08:38:28'),
(30, 20, 4, 'good', '2025-05-01 08:39:04'),
(31, 20, 2, 'bad', '2025-05-01 08:40:27'),
(32, 20, 2, 'bad', '2025-05-01 08:41:31'),
(33, 20, 4, 'good', '2025-05-01 08:41:37'),
(34, 20, 4, 'good', '2025-05-01 08:46:53'),
(35, 20, 3, 'okay', '2025-05-01 08:47:02'),
(36, 20, 3, 'okay', '2025-05-01 08:48:12'),
(37, 20, 3, 'okay', '2025-05-01 08:49:13'),
(38, 20, 3, 'okay', '2025-05-01 08:49:44'),
(39, 20, 3, 'okay', '2025-05-01 08:50:34');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(50) DEFAULT 'general',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `post_id`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 1, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(2, 4, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(3, 15, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(4, 11, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(5, 14, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(6, 9, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(7, 19, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(8, 12, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(9, 20, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 1, '2025-04-30 17:00:48'),
(10, 18, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(11, 10, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(12, 8, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(13, 5, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(14, 13, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(15, 7, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(16, 6, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(17, 16, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(18, 17, NULL, 'Price Updates:\nAuto: Base price updated from ₹30.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:00:48'),
(32, 1, NULL, 'Vehicle rates have been updated', 'general', 0, '2025-04-30 17:17:06'),
(33, 1, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(34, 4, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(35, 15, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(36, 11, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(37, 14, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(38, 9, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(39, 19, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(40, 12, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(41, 20, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 1, '2025-04-30 17:18:37'),
(42, 18, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(43, 10, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(44, 8, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(45, 5, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(46, 13, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(47, 7, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(48, 6, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(49, 16, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(50, 17, NULL, 'Price Updates:\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\nBike: Base price updated from ₹20.00 to ₹30, Per KM rate updated from ₹6.00 to ₹6\n', 'price_update', 0, '2025-04-30 17:18:37'),
(64, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(65, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(66, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(67, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(68, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(69, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(70, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(71, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(72, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 1, '2025-04-30 17:26:17'),
(73, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(74, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(75, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(76, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(77, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(78, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(79, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(80, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(81, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹50, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹45.00 to ₹40, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:26:17'),
(95, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(96, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(97, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(98, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(99, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(100, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(101, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(102, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(103, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 1, '2025-04-30 17:27:28'),
(104, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(105, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(106, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(107, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(108, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(109, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(110, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(111, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(112, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹50.00 to ₹60, Per KM rate updated from ₹12.00 to ₹12\n', 'price_update', 0, '2025-04-30 17:27:28'),
(126, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(127, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(128, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(129, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(130, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(131, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(132, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(133, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(134, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 1, '2025-04-30 17:31:57'),
(135, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(136, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(137, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(138, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(139, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(140, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(141, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(142, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(143, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹70, Per KM rate updated from ₹12.00 to ₹12\nAuto: Base price updated from ₹40.00 to ₹45, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 17:31:57'),
(157, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(158, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(159, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(160, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(161, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(162, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(163, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(164, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(165, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 1, '2025-04-30 18:08:40'),
(166, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(167, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(168, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(169, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(170, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(171, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(172, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(173, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(174, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹70.00 to ₹60, Per KM rate updated from ₹12.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:08:40'),
(188, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(189, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(190, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(191, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(192, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(193, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(194, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(195, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(196, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 1, '2025-04-30 18:22:45'),
(197, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(198, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(199, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(200, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(201, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(202, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(203, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(204, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(205, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:22:45'),
(219, 1, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(220, 4, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(221, 15, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(222, 11, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(223, 14, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(224, 9, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(225, 19, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(226, 12, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(227, 20, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 1, '2025-04-30 18:30:14'),
(228, 18, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(229, 10, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(230, 8, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(231, 5, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(232, 13, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(233, 7, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(234, 6, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(235, 16, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(236, 17, NULL, 'Price Updates:\nAuto: Base price updated from ₹45.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:30:14'),
(250, 1, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(251, 4, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(252, 15, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(253, 11, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(254, 14, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(255, 9, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(256, 19, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(257, 12, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(258, 20, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 1, '2025-04-30 18:31:02'),
(259, 18, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(260, 10, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(261, 8, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(262, 5, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(263, 13, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(264, 7, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(265, 6, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(266, 16, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(267, 17, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹8\n', 'price_update', 0, '2025-04-30 18:31:02'),
(281, 1, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(282, 4, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(283, 15, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(284, 11, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(285, 14, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(286, 9, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(287, 19, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(288, 12, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(289, 20, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 1, '2025-04-30 18:31:58'),
(290, 18, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(291, 10, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(292, 8, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(293, 5, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(294, 13, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(295, 7, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(296, 6, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(297, 16, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(298, 17, NULL, 'Price Updates:\nAuto: Base price updated from ₹50.00 to ₹50, Per KM rate updated from ₹8.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:31:58'),
(312, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(313, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(314, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(315, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(316, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(317, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(318, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(319, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(320, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 1, '2025-04-30 18:41:56'),
(321, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(322, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(323, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(324, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(325, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(326, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(327, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(328, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(329, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹10.00 to ₹9\n', 'price_update', 0, '2025-04-30 18:41:56'),
(343, 1, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(344, 4, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(345, 15, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(346, 11, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(347, 14, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(348, 9, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(349, 19, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(350, 12, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(351, 20, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 1, '2025-04-30 18:58:21'),
(352, 18, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(353, 10, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(354, 8, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(355, 5, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(356, 13, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(357, 7, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(358, 6, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(359, 16, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21'),
(360, 17, NULL, 'Price Updates:\nCar premium: Base price updated from ₹60.00 to ₹60, Per KM rate updated from ₹10.00 to ₹10, Per passenger rate updated from ₹9.00 to ₹10\n', 'price_update', 0, '2025-04-30 18:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `base_fare` decimal(10,2) DEFAULT 50.00,
  `per_km_rate` decimal(10,2) DEFAULT 12.00,
  `commission_rate` decimal(5,2) DEFAULT 20.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `base_fare`, `per_km_rate`, `commission_rate`) VALUES
(1, 50.00, 12.00, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `logo_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `homepage_text` text DEFAULT NULL,
  `promo_text` text DEFAULT NULL,
  `promo_discount` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_name`, `setting_value`, `updated_at`, `logo_url`, `banner_url`, `homepage_text`, `promo_text`, `promo_discount`) VALUES
(1, 'primary_color', '#000000', '2025-04-30 12:03:45', NULL, NULL, NULL, NULL, NULL),
(2, 'secondary_color', NULL, '2025-04-30 12:03:34', NULL, NULL, NULL, NULL, NULL),
(3, 'font_family', NULL, '2025-04-30 12:03:34', NULL, NULL, NULL, NULL, NULL),
(4, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(5, 'homepage_text', '', '2025-04-30 11:53:26', NULL, NULL, NULL, NULL, NULL),
(6, 'promo_text', '', '2025-04-30 11:53:26', NULL, NULL, NULL, NULL, NULL),
(7, 'promo_discount', '', '2025-04-30 11:53:26', NULL, NULL, NULL, NULL, NULL),
(8, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(9, 'homepage_text', '', '2025-04-30 11:55:17', NULL, NULL, NULL, NULL, NULL),
(10, 'promo_text', '', '2025-04-30 11:55:17', NULL, NULL, NULL, NULL, NULL),
(11, 'promo_discount', '', '2025-04-30 11:55:17', NULL, NULL, NULL, NULL, NULL),
(12, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(13, 'homepage_text', '', '2025-04-30 11:55:20', NULL, NULL, NULL, NULL, NULL),
(14, 'promo_text', '', '2025-04-30 11:55:20', NULL, NULL, NULL, NULL, NULL),
(15, 'promo_discount', '', '2025-04-30 11:55:20', NULL, NULL, NULL, NULL, NULL),
(16, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(17, 'homepage_text', '', '2025-04-30 11:59:20', NULL, NULL, NULL, NULL, NULL),
(18, 'promo_text', '', '2025-04-30 11:59:20', NULL, NULL, NULL, NULL, NULL),
(19, 'promo_discount', '', '2025-04-30 11:59:20', NULL, NULL, NULL, NULL, NULL),
(20, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(21, 'homepage_text', '', '2025-04-30 12:02:29', NULL, NULL, NULL, NULL, NULL),
(22, 'promo_text', '', '2025-04-30 12:02:29', NULL, NULL, NULL, NULL, NULL),
(23, 'promo_discount', '', '2025-04-30 12:02:29', NULL, NULL, NULL, NULL, NULL),
(24, 'homepage_text', '', '2025-04-30 12:02:46', NULL, NULL, NULL, NULL, NULL),
(25, 'promo_text', '', '2025-04-30 12:02:46', NULL, NULL, NULL, NULL, NULL),
(26, 'promo_discount', '', '2025-04-30 12:02:46', NULL, NULL, NULL, NULL, NULL),
(27, 'homepage_text', '', '2025-04-30 12:02:59', NULL, NULL, NULL, NULL, NULL),
(28, 'promo_text', '', '2025-04-30 12:02:59', NULL, NULL, NULL, NULL, NULL),
(29, 'promo_discount', '', '2025-04-30 12:02:59', NULL, NULL, NULL, NULL, NULL),
(30, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(31, 'primary_color', '#000000', '2025-04-30 12:10:46', NULL, NULL, NULL, NULL, NULL),
(32, 'secondary_color', '#ffffff', '2025-04-30 12:10:46', NULL, NULL, NULL, NULL, NULL),
(33, 'font_family', 'Arial', '2025-04-30 12:10:46', NULL, NULL, NULL, NULL, NULL),
(34, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(35, 'primary_color', '#000000', '2025-04-30 12:14:17', NULL, NULL, NULL, NULL, NULL),
(36, 'secondary_color', '#ffffff', '2025-04-30 12:14:17', NULL, NULL, NULL, NULL, NULL),
(37, 'font_family', 'Arial', '2025-04-30 12:14:17', NULL, NULL, NULL, NULL, NULL),
(38, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(39, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(40, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(41, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(42, 'primary_color', '#000000', '2025-04-30 12:22:08', NULL, NULL, NULL, NULL, NULL),
(43, 'secondary_color', '#ffffff', '2025-04-30 12:22:08', NULL, NULL, NULL, NULL, NULL),
(44, 'font_family', 'Arial', '2025-04-30 12:22:08', NULL, NULL, NULL, NULL, NULL),
(45, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(46, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(47, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(48, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(49, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(50, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(51, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(52, 'primary_color', '#000000', '2025-04-30 12:31:44', NULL, NULL, NULL, NULL, NULL),
(53, 'secondary_color', '#ffffff', '2025-04-30 12:31:44', NULL, NULL, NULL, NULL, NULL),
(54, 'font_family', 'Arial', '2025-04-30 12:31:44', NULL, NULL, NULL, NULL, NULL),
(55, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(56, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(57, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(58, 'primary_color', '#000000', '2025-04-30 12:45:09', NULL, NULL, NULL, NULL, NULL),
(59, 'secondary_color', '#ffffff', '2025-04-30 12:45:09', NULL, NULL, NULL, NULL, NULL),
(60, 'font_family', 'Arial', '2025-04-30 12:45:09', NULL, NULL, NULL, NULL, NULL),
(61, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(62, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(63, 'primary_color', '#000000', '2025-04-30 12:45:31', NULL, NULL, NULL, NULL, NULL),
(64, 'secondary_color', '#ffffff', '2025-04-30 12:45:31', NULL, NULL, NULL, NULL, NULL),
(65, 'font_family', 'Arial', '2025-04-30 12:45:31', NULL, NULL, NULL, NULL, NULL),
(66, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(67, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(68, 'primary_color', '#000000', '2025-04-30 12:55:39', NULL, NULL, NULL, NULL, NULL),
(69, 'secondary_color', '#ffffff', '2025-04-30 12:55:39', NULL, NULL, NULL, NULL, NULL),
(70, 'font_family', 'Arial', '2025-04-30 12:55:39', NULL, NULL, NULL, NULL, NULL),
(71, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(72, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(73, 'primary_color', '#000000', '2025-04-30 12:55:54', NULL, NULL, NULL, NULL, NULL),
(74, 'secondary_color', '#ffffff', '2025-04-30 12:55:54', NULL, NULL, NULL, NULL, NULL),
(75, 'font_family', 'Arial', '2025-04-30 12:55:54', NULL, NULL, NULL, NULL, NULL),
(76, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(77, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(78, 'primary_color', '#000000', '2025-04-30 12:56:37', NULL, NULL, NULL, NULL, NULL),
(79, 'secondary_color', '#ffffff', '2025-04-30 12:56:37', NULL, NULL, NULL, NULL, NULL),
(80, 'font_family', 'Arial', '2025-04-30 12:56:37', NULL, NULL, NULL, NULL, NULL),
(81, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(82, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(83, 'primary_color', '#000000', '2025-04-30 12:56:47', NULL, NULL, NULL, NULL, NULL),
(84, 'secondary_color', '#ffffff', '2025-04-30 12:56:47', NULL, NULL, NULL, NULL, NULL),
(85, 'font_family', 'Arial', '2025-04-30 12:56:47', NULL, NULL, NULL, NULL, NULL),
(86, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(87, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(88, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(89, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(90, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(91, 'primary_color', '#000000', '2025-04-30 13:05:42', NULL, NULL, NULL, NULL, NULL),
(92, 'secondary_color', '#ffffff', '2025-04-30 13:05:42', NULL, NULL, NULL, NULL, NULL),
(93, 'font_family', 'Arial', '2025-04-30 13:05:42', NULL, NULL, NULL, NULL, NULL),
(94, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(95, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(96, 'primary_color', '#000000', '2025-04-30 13:05:54', NULL, NULL, NULL, NULL, NULL),
(97, 'secondary_color', '#ffffff', '2025-04-30 13:05:54', NULL, NULL, NULL, NULL, NULL),
(98, 'font_family', 'Arial', '2025-04-30 13:05:54', NULL, NULL, NULL, NULL, NULL),
(99, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(100, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(101, 'primary_color', '#000000', '2025-04-30 13:06:43', NULL, NULL, NULL, NULL, NULL),
(102, 'secondary_color', '#8000ff', '2025-04-30 13:06:43', NULL, NULL, NULL, NULL, NULL),
(103, 'font_family', 'Arial', '2025-04-30 13:06:43', NULL, NULL, NULL, NULL, NULL),
(104, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(105, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(106, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(107, 'primary_color', '#000000', '2025-04-30 13:09:15', NULL, NULL, NULL, NULL, NULL),
(108, 'secondary_color', '#8080ff', '2025-04-30 13:09:15', NULL, NULL, NULL, NULL, NULL),
(109, 'font_family', 'Arial', '2025-04-30 13:09:15', NULL, NULL, NULL, NULL, NULL),
(110, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(111, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(112, 'primary_color', '#000000', '2025-04-30 13:09:31', NULL, NULL, NULL, NULL, NULL),
(113, 'secondary_color', '#ffffff', '2025-04-30 13:09:31', NULL, NULL, NULL, NULL, NULL),
(114, 'font_family', 'Arial', '2025-04-30 13:09:31', NULL, NULL, NULL, NULL, NULL),
(115, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(116, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(117, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(118, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(119, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(120, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(121, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(122, 'primary_color', '#000000', '2025-04-30 13:22:44', NULL, NULL, NULL, NULL, NULL),
(123, 'secondary_color', '#ffffff', '2025-04-30 13:22:44', NULL, NULL, NULL, NULL, NULL),
(124, 'font_family', 'Arial', '2025-04-30 13:22:44', NULL, NULL, NULL, NULL, NULL),
(125, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(126, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(127, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(128, 'homepage_text', '', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(129, 'promo_text', '', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(130, 'promo_discount', '', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(131, 'primary_color', '#000000', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(132, 'secondary_color', '#ffffff', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(133, 'font_family', 'Arial', '2025-04-30 13:26:50', NULL, NULL, NULL, NULL, NULL),
(134, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(135, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(136, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(137, 'homepage_text', '', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(138, 'promo_text', '', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(139, 'promo_discount', '', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(140, 'primary_color', '#000000', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(141, 'secondary_color', '#ffffff', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(142, 'font_family', 'Arial', '2025-04-30 13:28:48', NULL, NULL, NULL, NULL, NULL),
(143, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(144, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(145, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(146, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(147, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(148, 'homepage_text', '', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(149, 'promo_text', '', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(150, 'promo_discount', '', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(151, 'primary_color', '#000000', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(152, 'secondary_color', '#ffffff', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(153, 'font_family', 'Arial', '2025-04-30 13:30:28', NULL, NULL, NULL, NULL, NULL),
(154, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(155, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(156, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(157, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(158, 'homepage_text', '', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(159, 'promo_text', '', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(160, 'promo_discount', '', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(161, 'primary_color', '#000000', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(162, 'secondary_color', '#ffffff', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(163, 'font_family', 'Arial', '2025-04-30 13:30:45', NULL, NULL, NULL, NULL, NULL),
(164, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(165, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(166, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(167, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(168, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(169, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(170, 'homepage_text', '', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(171, 'promo_text', '', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(172, 'promo_discount', '', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(173, 'primary_color', '#000000', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(174, 'secondary_color', '#ffffff', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(175, 'font_family', 'Arial', '2025-04-30 13:33:40', NULL, NULL, NULL, NULL, NULL),
(176, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(177, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(178, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(179, 'banner_url', 'uploads/1746020037_raval.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(180, 'homepage_text', '', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(181, 'promo_text', '', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(182, 'promo_discount', '', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(183, 'primary_color', '#000000', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(184, 'secondary_color', '#ffffff', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(185, 'font_family', 'Arial', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(186, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(187, 'banner_url', 'uploads/default_banner.jpg', '2025-04-30 13:33:57', NULL, NULL, NULL, NULL, NULL),
(188, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(189, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(190, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(191, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(192, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(193, 'homepage_text', '', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(194, 'promo_text', '', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(195, 'promo_discount', '', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(196, 'primary_color', '#8080ff', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(197, 'secondary_color', '#80ff00', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(198, 'font_family', 'Arial', '2025-04-30 13:49:26', NULL, NULL, NULL, NULL, NULL),
(199, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(200, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(201, 'homepage_text', '', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(202, 'promo_text', '', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(203, 'promo_discount', '', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(204, 'primary_color', '#000000', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(205, 'secondary_color', '#ffffff', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(206, 'font_family', 'Arial', '2025-04-30 13:49:54', NULL, NULL, NULL, NULL, NULL),
(207, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(208, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(209, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(210, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(211, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(212, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(213, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(214, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(215, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(216, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(217, 'homepage_text', '', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(218, 'promo_text', '', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(219, 'promo_discount', '', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(220, 'primary_color', '#000000', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(221, 'secondary_color', '#ffffff', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(222, 'font_family', 'Arial', '2025-04-30 15:37:10', NULL, NULL, NULL, NULL, NULL),
(223, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(224, 'logo_url', 'uploads/1746027443_1r logo.jpg', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(225, 'homepage_text', '', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(226, 'promo_text', '', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(227, 'promo_discount', '', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(228, 'primary_color', '#000000', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(229, 'secondary_color', '#ffffff', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(230, 'font_family', 'Arial', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(231, 'logo_url', 'uploads/default_logo.png', '2025-04-30 15:37:23', NULL, NULL, NULL, NULL, NULL),
(232, 'logo_url', 'uploads/default_logo.png', '2025-04-30 15:56:12', NULL, NULL, NULL, NULL, NULL),
(233, 'logo_url', 'uploads/default_logo.png', '2025-04-30 15:56:31', NULL, NULL, NULL, NULL, NULL),
(234, 'logo_url', 'uploads/default_logo.png', '2025-04-30 16:38:32', NULL, NULL, NULL, NULL, NULL),
(235, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:00:26', NULL, NULL, NULL, NULL, NULL),
(236, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:00:48', NULL, NULL, NULL, NULL, NULL),
(237, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:00:49', NULL, NULL, NULL, NULL, NULL),
(238, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:16:00', NULL, NULL, NULL, NULL, NULL),
(239, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:18:37', NULL, NULL, NULL, NULL, NULL),
(240, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:18:37', NULL, NULL, NULL, NULL, NULL),
(241, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:26:17', NULL, NULL, NULL, NULL, NULL),
(242, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:26:17', NULL, NULL, NULL, NULL, NULL),
(243, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:27:28', NULL, NULL, NULL, NULL, NULL),
(244, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:27:28', NULL, NULL, NULL, NULL, NULL),
(245, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:31:57', NULL, NULL, NULL, NULL, NULL),
(246, 'logo_url', 'uploads/default_logo.png', '2025-04-30 17:31:57', NULL, NULL, NULL, NULL, NULL),
(247, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:08:40', NULL, NULL, NULL, NULL, NULL),
(248, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:08:41', NULL, NULL, NULL, NULL, NULL),
(249, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:22:30', NULL, NULL, NULL, NULL, NULL),
(250, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:22:45', NULL, NULL, NULL, NULL, NULL),
(251, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:22:45', NULL, NULL, NULL, NULL, NULL),
(252, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:30:14', NULL, NULL, NULL, NULL, NULL),
(253, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:30:14', NULL, NULL, NULL, NULL, NULL),
(254, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:31:02', NULL, NULL, NULL, NULL, NULL),
(255, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:31:02', NULL, NULL, NULL, NULL, NULL),
(256, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:31:58', NULL, NULL, NULL, NULL, NULL),
(257, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:31:58', NULL, NULL, NULL, NULL, NULL),
(258, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:41:43', NULL, NULL, NULL, NULL, NULL),
(259, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:41:56', NULL, NULL, NULL, NULL, NULL),
(260, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:41:56', NULL, NULL, NULL, NULL, NULL),
(261, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:58:10', NULL, NULL, NULL, NULL, NULL),
(262, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:58:21', NULL, NULL, NULL, NULL, NULL),
(263, 'logo_url', 'uploads/default_logo.png', '2025-04-30 18:58:21', NULL, NULL, NULL, NULL, NULL),
(264, 'logo_url', 'uploads/default_logo.png', '2025-04-30 19:09:59', NULL, NULL, NULL, NULL, NULL),
(265, 'logo_url', 'uploads/default_logo.png', '2025-04-30 19:10:14', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_type` enum('customer','driver') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'img/default-profile.jpg',
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `dob`, `email`, `password`, `phone`, `user_type`, `created_at`, `profile_pic`, `status`) VALUES
(1, '', '2025-04-04', 'k@gmail.com', '$2y$10$LU/UjeOu.G6rofUSb6H24eSvIP.EmomkW588hAl1Mz9JcCnmwlzrK', '1234567890', 'customer', '2025-04-03 08:14:02', 'img/default-profile.jpg', 1),
(4, 'komal mishra', '2025-04-04', 'k1@gmail.com', '$2y$10$DaKDWqD1t7LPbibn4jO0guFtp5DoFGJCWh3pjaqSJwrF5BAKI7mDm', '1234567892', 'customer', '2025-04-03 08:18:45', 'img/default-profile.jpg', 1),
(5, 'komal mishra', '2025-04-12', 'k2@gmail.com', '$2y$10$ft/8Dc4dvBEI87ixR.C/5eHC6Dkoel0bTBwCown7xRtWyvj0PwF3y', '9664610214', 'customer', '2025-04-03 08:31:07', 'img/default-profile.jpg', 1),
(6, 'komal mishra', '2025-04-12', 'k3@gmail.com', '$2y$10$OlhJ3ZA5uhzDI.HbiXvY5.3THIJ/DeH6nIUwYAO/FTG2MgUl47FJq', '9664610219', 'customer', '2025-04-03 08:31:58', 'img/default-profile.jpg', 1),
(7, 'komal mishra', '2025-04-12', 'k6@gmail.com', '$2y$10$65Tzb0Y0ubrnQhtmFq5Q5OkKDjOZjEXnUW5hjn37OpzsBZCq2pidy', '9664610218', 'customer', '2025-04-03 08:33:19', 'img/default-profile.jpg', 1),
(8, 'komal mishra', '2025-04-12', 'k11@gmail.com', '$2y$10$Oi.LN/Mua2/rSXtDk/kXXO1iYniks/F/yuEs9yLVIXv3oavfW.uIG', '9664610212', 'customer', '2025-04-03 08:34:36', 'img/default-profile.jpg', 1),
(9, 'riddhi raval', '2025-04-12', 'r@gmail.com', '$2y$10$1MG/JR4uOyn.3GkoVPfADOyo3kh4t4XyI4hRFYKRlNJsOeyn669Le', '7043158201', 'customer', '2025-04-03 08:35:39', 'uploads/profile_pics/profile_9_1743768169.png', 1),
(10, '', '2025-04-19', 'komal@gmail.com', '$2y$10$jiFwVX7qjHC/p/BlzryQHey2WoMhPQCgidgWOkw79m2gmV2ea7Xh6', '9664610211', 'customer', '2025-04-03 10:20:00', 'uploads/profile_pics/profile_10_1743678238.jpg', 1),
(11, 'mit', '2025-04-02', 'mit@gmail.com', '$2y$10$9zb0h4EqRubZOWuBP9zt3uOs3YUMYEv8Cfk/rN73L8v5dtfDryPOG', '4567895123', 'customer', '2025-04-05 15:40:57', 'img/default-profile.jpg', 1),
(12, 'ridhdhi raval', '2005-09-07', 'ridhdhiraval2005@gmail.com', '$2y$10$DUbH7YknuXuUnmtVOTEwzuFfQh4FIYV90ZgkoKnaQxz3qNaHiVCIS', '7043185002', 'customer', '2025-04-05 17:11:46', 'uploads/profile_pics/profile_12_1744004362.png', 1),
(13, 'komal', '2025-04-03', 'mishrakomal0108@gmail.com', '$2y$10$3M2Ah8IA2IyKkJZZRHlLfeB0f2O848XqSytCtXTk5AxOcdlxafZJG', '9664610217', 'customer', '2025-04-05 18:06:22', 'uploads/profile_pics/profile_13_1743876407.png', 1),
(14, 'bhumi', '2025-04-02', 'bhumi@gmail.com', '$2y$10$fFGgXMhLe4qoYFPsMOl6dOGZvPwUvE9Wg8orMDedA3rc56CiXIHZW', '4568139548', 'customer', '2025-04-06 08:20:33', 'uploads/profile_pics/profile_14_1743927747.png', 1),
(15, 'mit raval', '2025-04-10', 'meet@gmail.com', '$2y$10$LHPYTDZfUA5wwVxPn578GehuAHRahKmFxZWmb1LzvfekPzTVYW.by', '4561237890', 'customer', '2025-04-07 14:49:08', 'uploads/profile_pics/profile_15_1744037372.png', 1),
(16, 'John Doe', '0000-00-00', 'john@example.com', '482c811da5d5b4bc6d497ffa98491e38', '9876543210', 'customer', '2025-04-07 17:03:09', 'img/default-profile.jpg', 0),
(17, 'Jane Smith', '0000-00-00', 'jane@example.com', '482c811da5d5b4bc6d497ffa98491e38', '9876543211', 'customer', '2025-04-07 17:03:09', 'img/default-profile.jpg', 0),
(18, 'kriyansh mishra', '2025-04-05', 'Kriyansh@gmail.com', '$2y$10$V1I6XMp6PQHrGW6jXAGYp.mDpV1LuPJfqUoEanq8Rh9Io4jkO8/26', '9016443016', 'customer', '2025-04-07 17:19:07', 'img/default-profile.jpg', 1),
(19, 'mishra Krish', '2025-04-04', 'krish@gmail.com', '$2y$10$KOzurwR/xTCgweoMRpTk8eDzclMJgi3KJy1ZM7QUHJ1EhSPpoIMbu', '7043185001', 'customer', '2025-04-07 18:42:18', 'img/default-profile.jpg', 1),
(20, 'ridhdhi', '2025-04-17', 'meetraval@gmail.com', '$2y$10$B9ahEYGjKvG2kal/zx6x5u6kkoWhkgAT53b0Xmsf7XoVST9DommS2', '7894561235', 'customer', '2025-04-27 15:15:52', 'uploads/profile_pics/profile_20_1745768354.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_rates`
--

CREATE TABLE `vehicle_rates` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `base_fare` decimal(10,2) DEFAULT NULL,
  `per_km_rate` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_rates`
--

INSERT INTO `vehicle_rates` (`id`, `vehicle_type`, `base_fare`, `per_km_rate`, `commission_rate`) VALUES
(1, 'Auto', 30.00, 8.00, 15.00),
(2, 'Bike', 20.00, 6.00, 12.00),
(3, 'Car', 50.00, 12.00, 20.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admin_contact`
--
ALTER TABLE `admin_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_drivers`
--
ALTER TABLE `admin_drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `admin_feedback`
--
ALTER TABLE `admin_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_general_settings`
--
ALTER TABLE `admin_general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_vehicle_rates`
--
ALTER TABLE `admin_vehicle_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `driver_bookings`
--
ALTER TABLE `driver_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `driver_login`
--
ALTER TABLE `driver_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `driver_table`
--
ALTER TABLE `driver_table`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `vehicle_rates`
--
ALTER TABLE `vehicle_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_contact`
--
ALTER TABLE `admin_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_drivers`
--
ALTER TABLE `admin_drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_feedback`
--
ALTER TABLE `admin_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_general_settings`
--
ALTER TABLE `admin_general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_vehicle_rates`
--
ALTER TABLE `admin_vehicle_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `driver_bookings`
--
ALTER TABLE `driver_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_login`
--
ALTER TABLE `driver_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_table`
--
ALTER TABLE `driver_table`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vehicle_rates`
--
ALTER TABLE `vehicle_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_feedback`
--
ALTER TABLE `admin_feedback`
  ADD CONSTRAINT `admin_feedback_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `driver_bookings`
--
ALTER TABLE `driver_bookings`
  ADD CONSTRAINT `driver_bookings_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver_table` (`driver_id`);

--
-- Constraints for table `driver_login`
--
ALTER TABLE `driver_login`
  ADD CONSTRAINT `driver_login_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver_table` (`driver_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
