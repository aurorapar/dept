-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2016 at 12:55 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

DROP DATABASE IF EXISTS 344_project;
CREATE DATABASE 344_project;
USE 344_project;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `344_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` varchar(8) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone_num` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pref_contact_method` varchar(10) NOT NULL,
  `room_num` varchar(6) NOT NULL,
  `building` varchar(15) NOT NULL,
  `alma_mater` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `phone_num`, `email`, `pref_contact_method`, `room_num`, `building`, `alma_mater`) VALUES
('1111', 'Joan Francioni', '5074572336', 'jfrancioni@winona.edu', 'Email', '108D', 'Watkins', 'Florida State University'),
('2222', 'Gerald Cichanowski', '5074575385', 'gcichanowski@winona.edu', 'Phone', '108', 'Watkins', 'Michigan State University'),
('3333', 'Narayan Debnath', '5074575261', 'ndebnath@winona.edu', 'Email', '108F', 'Watkins', 'Jadavpur University'),
('4444', 'Mingrui Zhang', '5074572496', 'mzhang@winona.edu', 'Email', '103A', 'Watkins', 'University of South Florida');

-- --------------------------------------------------------

--
-- Table structure for table `office_hours`
--

CREATE TABLE `office_hours` (
  `faculty_id` int(8) NOT NULL,
  `day` varchar(1) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `office_hours`
--

INSERT INTO `office_hours` (`faculty_id`, `day`, `start_time`, `end_time`) VALUES
(2222, 'W', '08:00:00', '09:00:00'),
(3333, 'R', '11:00:00', '12:00:00'),
(4444, 'M', '09:00:00', '10:00:00'),
(1111, 'F', '13:00:00', '14:00:00'),
(1111, 'M', '15:00:00', '16:00:00'),
(3333, 'T', '11:00:00', '12:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
