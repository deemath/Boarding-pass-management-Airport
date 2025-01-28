-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 08:06 AM
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
-- Database: `boardingpassdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines_details`
--

CREATE TABLE `airlines_details` (
  `id` int(11) NOT NULL,
  `ICAO` varchar(4) DEFAULT NULL,
  `IATA` varchar(4) DEFAULT NULL,
  `AirlineName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airlines_details`
--

INSERT INTO `airlines_details` (`id`, `ICAO`, `IATA`, `AirlineName`) VALUES
(2, 'ABY', 'G9', 'Air Arabia'),
(3, 'AIC', 'AI', 'Air India'),
(4, 'ALK', 'UL', 'Srilankan Airlines'),
(5, 'AUI', 'PS', 'Ukraine International'),
(6, 'AXM', 'AK', 'Air Asia Berhad'),
(7, 'CCA', 'CA', 'Air China'),
(8, 'CES', 'MU', 'China Eastern'),
(9, 'CPA', 'CX', 'Cathay Pacific'),
(10, 'CSN', 'CZ', 'China Southern Airlines'),
(11, 'ETD', 'EY', 'Etihad Airways'),
(12, 'FDB', 'FZ', 'Fly Dubai'),
(13, 'GFA', 'GF', 'Gulf Air'),
(14, 'IGO', '6E', 'Indigo Airlines'),
(15, 'JAI', '9W', 'Jet Airways'),
(16, 'KAC', 'KU', 'Kuwait Airways'),
(17, 'KAL', 'KE', 'Korean Airways'),
(18, 'MAS', 'MH', 'Malaysia Airlines'),
(19, 'MXD', 'OD', 'Batik Air'),
(20, 'OMA', 'WY', 'Oman Air'),
(21, 'QTR', 'QR', 'Qatar Airways'),
(22, 'SEJ', 'SG', 'SpiceJet'),
(23, 'SIA', 'SQ', 'Singapore Airlines'),
(24, 'SLK', 'MI', 'Silk Air'),
(25, 'SVA', 'SV', 'Saudi Arabian Airlines'),
(26, 'THA', 'TG', 'Thai Airways'),
(27, 'THY', 'TK', 'Turkish Airlines'),
(28, 'UAE', 'EK', 'Emirates'),
(29, 'AUA', 'OS', 'Austria Airlines'),
(30, 'ABG', 'RL', 'Royal Flight'),
(31, 'SJY', 'SJ', 'Sriwijaya Airlines'),
(32, 'SWR', 'LX', 'Swiss Air'),
(33, 'TOM', 'BY', 'TUI Airways'),
(34, 'AFL', 'SU', 'Aeroflot'),
(35, 'KTK', 'ZF', 'Azur Air'),
(36, 'TML', 'SL', 'Thai Lion Air'),
(38, 'EDW', 'WK', 'Edelweiss Air'),
(39, 'FIN', 'AY', 'Finnair Airlines'),
(40, 'ACA', 'AC', 'Air Canada'),
(41, 'VTI', 'UK', 'Vistara Air'),
(42, 'LOT', 'LO', 'LOT Polish Airlines'),
(43, 'AFR', 'AF', 'Air France'),
(44, 'JZR', 'J9', 'Jazeera Airways'),
(45, 'KZR', 'KC', 'Air Astana'),
(46, 'THD', 'WE', 'Thai Smile'),
(47, 'EXV', '8D', 'Fits Air'),
(48, 'BAW', 'BA', 'British Airways'),
(49, 'OMS', 'OV', 'Salam Air'),
(50, 'SEY', 'HM', 'Air Seychelles'),
(51, 'ETH', 'ET', 'Ethiopian Airlines'),
(52, 'AIQ', 'FD', 'THAI AIR ASIA'),
(53, 'TEST', 'TST', 'TEST FLIGHT'),
(54, 'TST', 'TS', 'TEST FLIGHT'),
(55, 'NOS', 'NO', 'Neos S.p.A.'),
(56, 'EN', 'EN', 'Enter Air'),
(57, 'TTT', 'TTT', 'sdfsdfsdf'),
(58, 'TO', 'TO', 'TUI Airways'),
(59, 'ADY', '3L', 'Air Arabia'),
(60, 'SDM', 'FV', 'ROSSIYA AIR LINE'),
(61, 'TVS', '7O', 'Smartwings'),
(62, 'AIZ', 'IZ', 'ISRAELI AIRLINE'),
(63, 'DQA', 'Q2', 'Maldivian Airline'),
(64, 'AAR', 'OZ', 'Asiana Airlines'),
(65, 'QFA', 'QF', 'Qantas Airways'),
(66, 'JAL', 'JL', 'Japan Airlines'),
(67, 'CQN', 'OQ', 'Chongqing Airlines'),
(68, 'IRA', 'IR', 'Iran Air'),
(69, 'DE', 'DE', 'Default Airline');

-- --------------------------------------------------------

--
-- Table structure for table `airlines_email`
--

CREATE TABLE `airlines_email` (
  `ae_id` int(11) NOT NULL,
  `IATA` varchar(11) NOT NULL,
  `airline_email` varchar(250) NOT NULL,
  `entered_by` varchar(50) NOT NULL,
  `cap_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `airlines_email`
--

INSERT INTO `airlines_email` (`ae_id`, `IATA`, `airline_email`, `entered_by`, `cap_time`) VALUES
(5, 'AI', 'sachithra.it@airport.lk', 'admin', '11/28/2024 16:08:44'),
(6, 'AI', 'janindu.it@airport.lk', 'admin', '11/28/2024 22:21:47'),
(12, 'UL', 'ceylonparadise123@gmail.com', 'admin', '11/28/2024 23:24:57'),
(13, 'UL', 'janidugaurinda2020@gmail.com', 'admin', '11/28/2024 23:25:12'),
(14, 'SU', 'Teat.ae@mail.com', 'admin', '12/10/2024 08:49:42');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `card_id` int(11) NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `card_number` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `card_details`
--

INSERT INTO `card_details` (`card_id`, `card_name`, `card_number`) VALUES
(1, 'HSBC', '1'),
(2, 'HNB', '2'),
(3, 'Classic Travel\n', '3'),
(4, 'Acorn Travels', '4'),
(5, 'Test Card 1', NULL),
(6, 'Test Card 2', NULL),
(7, 'Traveller Global', NULL),
(8, 'Amex', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passengerdetails`
--

CREATE TABLE `passengerdetails` (
  `id` int(11) NOT NULL,
  `passenger_name` varchar(100) NOT NULL,
  `from_city_code` varchar(10) NOT NULL,
  `to_city_code` varchar(10) NOT NULL,
  `flight_number` varchar(20) NOT NULL,
  `date_of_flight` date NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `airline_numeric_code` varchar(10) NOT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `captured_time` varchar(20) NOT NULL,
  `captured_date` date DEFAULT NULL,
  `no_of_iv` int(11) NOT NULL DEFAULT 1,
  `no_of_pax` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(1250) NOT NULL,
  `entered_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `update_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengerdetails`
--

INSERT INTO `passengerdetails` (`id`, `passenger_name`, `from_city_code`, `to_city_code`, `flight_number`, `date_of_flight`, `seat_number`, `airline_numeric_code`, `card_number`, `captured_time`, `captured_date`, `no_of_iv`, `no_of_pax`, `remarks`, `entered_by`, `updated_by`, `update_time`) VALUES
(1, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-12-11', '001F', ' 13', 'Airlines', '15:22:44', '2024-12-11', 1, 1, '', 'admin', '', ''),
(3, 'BOULUD/BENJAMIN', 'CMB', 'MLE', 'FZ 1026', '2024-12-12', '003C', ' 13', 'Airlines', '08:28:28', '2024-12-12', 1, 1, '', 'admin', '', ''),
(4, 'TEST 9', 'BIA', 'CMB', 'AI 1026', '2024-12-12', 'B10', '1', 'HSBC', '08:31:20', '2024-12-12', 1, 1, '', 'admin', '', ''),
(5, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-08-12', '001F', ' 13', 'Airlines', '09:46:53', '2024-12-12', 1, 1, '', 'admin', '', ''),
(6, 'BEHRENDTMESdd/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-08-12', '001F', ' 13', 'Airlines', '12:19:06', '2024-12-15', 1, 1, '', 'admin', '', ''),
(7, 'TANIMURA/KOJI', 'CMB', 'BKK', 'TG 0308', '2024-08-13', '031K', ' 37', 'Airlines', '12:52:23', '2024-12-15', 1, 1, '', 'admin', '', ''),
(8, 'BOULUD/BENJAMIN', 'CMB', 'MLE', 'FZ 1026', '2024-08-12', '003C', ' 13', 'Airlines', '13:00:33', '2024-12-15', 1, 1, '', 'admin', '', ''),
(9, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ1026', '2024-01-25', '01F0', '136', 'Airlines', '13:01:02', '2024-12-15', 1, 1, '', 'admin', '', ''),
(10, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZx1026', '2024-08-12', '001F', ' 13', 'Airlines', '13:01:08', '2024-12-15', 1, 1, '', 'admin', '', ''),
(11, 'ABDUL LATHIF/MASKUR', 'CMB', 'DXB', 'UL 0225', '2024-07-08', '060K', ' 33', 'Airlines', '13:04:34', '2024-12-15', 1, 1, '', 'admin', '', ''),
(12, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ  102', '2024-08-12', 'J001', '5 1', 'Airlines', '13:04:54', '2024-12-15', 1, 1, '', 'admin', '', ''),
(13, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ 1102', '2024-08-12', 'J001', '5 1', 'Airlines', '13:06:18', '2024-12-15', 1, 1, '', 'admin', '', ''),
(14, 'BEHRENDTMESxs/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-08-12', '001F', ' 13', 'Airlines', '08:43:46', '2024-12-16', 1, 1, '', 'admin', '', ''),
(15, 'BEHRENDTMEScc/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-08-12', '001F', ' 13', 'Classic Travel\r\n', '09:06:11', '2024-12-16', 1, 1, '', 'admin', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `passengerdetails_old`
--

CREATE TABLE `passengerdetails_old` (
  `pd_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `passenger_name` varchar(100) NOT NULL,
  `from_city_code` varchar(10) NOT NULL,
  `to_city_code` varchar(10) NOT NULL,
  `flight_number` varchar(20) NOT NULL,
  `date_of_flight` date NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `airline_numeric_code` varchar(10) NOT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `captured_time` varchar(20) NOT NULL,
  `captured_date` date DEFAULT NULL,
  `no_of_iv` int(11) NOT NULL DEFAULT 1,
  `no_of_pax` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(1250) NOT NULL,
  `entered_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `update_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengerdetails_old`
--

INSERT INTO `passengerdetails_old` (`pd_id`, `id`, `passenger_name`, `from_city_code`, `to_city_code`, `flight_number`, `date_of_flight`, `seat_number`, `airline_numeric_code`, `card_number`, `captured_time`, `captured_date`, `no_of_iv`, `no_of_pax`, `remarks`, `entered_by`, `updated_by`, `update_time`) VALUES
(1, 2, 'BEHRENDTMESIA/CLAUD', 'CMB', 'MLE', 'FZ 1026', '2024-12-12', '001F', ' 13', 'Airlines', '15:23:45', '2024-12-11', 1, 1, '', 'admin', 'admin', '2024-12-12 08:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `displayName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tele` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `displayName`, `email`, `tele`, `password`, `user_type`) VALUES
(1, 'admin', 'admin', 'admin@admin', '1234567890', 'admin', 'Admin'),
(7, 'janindu', 'janindu', 'janindu@it', '0702106938', 'admin', 'User'),
(8, 'gaurinda', 'gaurinda', 'janindu@it', '1234567890', 'admin', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airlines_details`
--
ALTER TABLE `airlines_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airlines_email`
--
ALTER TABLE `airlines_email`
  ADD PRIMARY KEY (`ae_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `passengerdetails`
--
ALTER TABLE `passengerdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengerdetails_old`
--
ALTER TABLE `passengerdetails_old`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airlines_details`
--
ALTER TABLE `airlines_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `airlines_email`
--
ALTER TABLE `airlines_email`
  MODIFY `ae_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `card_details`
--
ALTER TABLE `card_details`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `passengerdetails`
--
ALTER TABLE `passengerdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `passengerdetails_old`
--
ALTER TABLE `passengerdetails_old`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
