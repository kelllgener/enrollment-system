-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2024 at 01:20 PM
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
-- Database: `enroll`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `section_sum_view`
-- (See below for the actual view)
--
CREATE TABLE `section_sum_view` (
`Section_1` decimal(22,0)
,`Section_2` decimal(22,0)
,`Pending` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_info`
--

CREATE TABLE `tbl_admin_info` (
  `ADMIN_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(50) NOT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `MIDDLENAME` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_info`
--

INSERT INTO `tbl_admin_info` (`ADMIN_ID`, `USER_ID`, `FIRSTNAME`, `LASTNAME`, `MIDDLENAME`) VALUES
(2, 2, 'Micheal Adrian', 'Gener', 'Valizado'),
(3, 15, 'Soara', 'Vlad', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `CLASS_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `DAY_OF_WEEK` varchar(20) DEFAULT NULL,
  `START_TIME` varchar(25) DEFAULT NULL,
  `END_TIME` varchar(25) DEFAULT NULL,
  `SECTION_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`CLASS_ID`, `SUBJECT_ID`, `DAY_OF_WEEK`, `START_TIME`, `END_TIME`, `SECTION_ID`) VALUES
(63, 405, 'Monday', '8:20 am', '9:00 am', 1),
(64, 404, 'Monday', '9:15 am', '9:50 am', 1),
(65, 406, 'Monday', '9:50 am', '10:20 am', 1),
(66, 403, 'Monday', '10:20 am', '11:00 am', 1),
(67, 401, 'Tuesday', '8:20 am', '9:00 am', 1),
(68, 408, 'Tuesday', '9:15 am', '9:50 am', 1),
(69, 406, 'Tuesday', '9:50 am', '10:20 am', 1),
(70, 407, 'Tuesday', '10:20 am', '11:00 am', 1),
(71, 405, 'Wednesday', '8:20 am', '9:00 am', 1),
(72, 404, 'Wednesday', '9:15 am', '9:50 am', 1),
(73, 406, 'Wednesday', '9:50 am', '10:20 am', 1),
(74, 402, 'Wednesday', '10:20 am', '11:00 am', 1),
(75, 401, 'Thursday', '8:20 am', '9:00 am', 1),
(76, 405, 'Thursday', '9:15 am', '9:50 am', 1),
(77, 406, 'Thursday', '9:50 am', '10:20 am', 1),
(78, 407, 'Thursday', '10:20 am', '11:00 am', 1),
(79, 401, 'Friday', '8:20 am', '9:00 am', 1),
(80, 408, 'Friday', '9:15 am', '9:50 am', 1),
(81, 403, 'Friday', '9:50 am', '10:20 am', 1),
(82, 407, 'Friday', '10:20 am', '11:00 am', 1),
(83, 405, 'Monday', '1:20 pm', '2:00 pm', 2),
(84, 404, 'Monday', '2:15 pm', '2:50 pm', 2),
(85, 406, 'Monday', '2:50 pm', '3:20 pm', 2),
(86, 403, 'Monday', '3:20 pm', '4:00 pm', 2),
(87, 401, 'Tuesday', '1:20 pm', '2:00 pm', 2),
(88, 408, 'Tuesday', '2:15 pm', '2:50 pm', 2),
(89, 406, 'Tuesday', '2:50 pm', '3:20 pm', 2),
(90, 407, 'Tuesday', '3:20 pm', '4:00 pm', 2),
(91, 405, 'Wednesday', '1:20 pm', '2:00 pm', 2),
(92, 404, 'Wednesday', '2:15 pm', '2:50 pm', 2),
(93, 406, 'Wednesday', '2:50 pm', '3:20 pm', 2),
(94, 402, 'Wednesday', '3:20 pm', '4:00 pm', 2),
(95, 401, 'Thursday', '1:20 pm', '2:00 pm', 2),
(96, 405, 'Thursday', '2:15 pm', '2:50 pm', 2),
(97, 406, 'Thursday', '2:50 pm', '3:20 pm', 2),
(98, 407, 'Thursday', '3:20 pm', '4:00 pm', 2),
(99, 401, 'Friday', '1:20 pm', '2:00 pm', 2),
(100, 408, 'Friday', '2:15 pm', '2:50 pm', 2),
(101, 403, 'Friday', '2:50 pm', '3:20 pm', 2),
(102, 407, 'Friday', '3:20 pm', '4:00 pm', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_father`
--

CREATE TABLE `tbl_father` (
  `FATHER_ID` int(11) NOT NULL,
  `FATHER_NAME` varchar(100) NOT NULL,
  `FATHER_OCCUPATION` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_father`
--

INSERT INTO `tbl_father` (`FATHER_ID`, `FATHER_NAME`, `FATHER_OCCUPATION`) VALUES
(7, 'sample', 'sample'),
(8, 'sample', 'sample'),
(10, 'sample', 'sample'),
(11, 'sample', 'sample'),
(13, 'sample', 'sample'),
(26, 'sample', 'sample'),
(27, 'sample', 'sample'),
(30, 'sample', 'sample'),
(31, 'sample', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guardian`
--

CREATE TABLE `tbl_guardian` (
  `GUARDIAN_ID` int(11) NOT NULL,
  `GUARDIAN_NAME` varchar(100) NOT NULL,
  `RELATIONSHIP_ID` int(11) NOT NULL,
  `GUARDIAN_OCCUPATION` varchar(100) NOT NULL,
  `CONTACT_NO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_guardian`
--

INSERT INTO `tbl_guardian` (`GUARDIAN_ID`, `GUARDIAN_NAME`, `RELATIONSHIP_ID`, `GUARDIAN_OCCUPATION`, `CONTACT_NO`) VALUES
(7, 'sample', 501, 'sample', '09894758753'),
(8, 'sample', 502, 'sample', '09894758753'),
(10, 'sample', 504, 'sample', '09894758753'),
(11, 'sample', 502, 'sample', '09894758753'),
(13, 'sample', 501, 'sample', '09894758753'),
(26, 'sample', 502, 'sample', '09894758753'),
(27, 'sample', 501, 'sample', '09894758753'),
(30, 'sample', 502, 'sample', '09894758753'),
(31, 'sample', 502, 'sample', '09894758753');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mother`
--

CREATE TABLE `tbl_mother` (
  `MOTHER_ID` int(11) NOT NULL,
  `MOTHER_NAME` varchar(100) NOT NULL,
  `MOTHER_OCCUPATION` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mother`
--

INSERT INTO `tbl_mother` (`MOTHER_ID`, `MOTHER_NAME`, `MOTHER_OCCUPATION`) VALUES
(7, 'sample', 'sample'),
(8, 'sample', 'sample'),
(10, 'sample', 'sample'),
(11, 'sample', 'sample'),
(13, 'sample', 'sample'),
(26, 'sample', 'sample'),
(27, 'sample', 'sample'),
(30, 'sample', 'sample'),
(31, 'sample', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_relationship`
--

CREATE TABLE `tbl_relationship` (
  `RELATIONSHIP_ID` int(11) NOT NULL,
  `RELATIONSHIP` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_relationship`
--

INSERT INTO `tbl_relationship` (`RELATIONSHIP_ID`, `RELATIONSHIP`) VALUES
(501, 'Father'),
(502, 'Mother'),
(503, 'Grandfather'),
(504, 'Grandmother'),
(505, 'Uncle'),
(506, 'Aunt'),
(507, 'Brother'),
(508, 'Sister'),
(509, 'Cousin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `ROLE_ID` int(11) NOT NULL,
  `ROLE_NAME` varchar(50) NOT NULL,
  `ROLE_DESCRIPTION` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`ROLE_ID`, `ROLE_NAME`, `ROLE_DESCRIPTION`) VALUES
(1, 'Administrator', 'sample'),
(2, 'Teacher', 'sample'),
(3, 'Student', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `SECTION_ID` int(11) NOT NULL,
  `SECTION` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`SECTION_ID`, `SECTION`) VALUES
(1, 'Section 1'),
(2, 'Section 2'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `STATUS_ID` int(11) NOT NULL,
  `STATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`STATUS_ID`, `STATUS`) VALUES
(301, 'Pending'),
(302, 'Enrolled'),
(303, 'Dropped');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_info`
--

CREATE TABLE `tbl_student_info` (
  `STUDENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LRN` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(50) DEFAULT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `MIDDLENAME` varchar(50) DEFAULT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `SEX` varchar(20) DEFAULT NULL,
  `BIRTH_DATE` date DEFAULT NULL,
  `PLACE_OF_BIRTH` varchar(75) DEFAULT NULL,
  `AGE` int(5) DEFAULT NULL,
  `NATIONALITY` varchar(30) DEFAULT NULL,
  `RELIGION` varchar(30) DEFAULT NULL,
  `STATUS_ID` int(5) DEFAULT NULL,
  `SECTION_ID` int(11) DEFAULT NULL,
  `BIRTH_CERTIFICATE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_info`
--

INSERT INTO `tbl_student_info` (`STUDENT_ID`, `USER_ID`, `LRN`, `LASTNAME`, `FIRSTNAME`, `MIDDLENAME`, `ADDRESS`, `SEX`, `BIRTH_DATE`, `PLACE_OF_BIRTH`, `AGE`, `NATIONALITY`, `RELIGION`, `STATUS_ID`, `SECTION_ID`, `BIRTH_CERTIFICATE`) VALUES
(2, 7, '110239102391', 'Garais', 'Lorelyn', '', 'sample', 'Female', '2013-01-21', 'sample', 11, 'sample', 'sample', 301, 3, '../certificate/steam avatar.jpg'),
(3, 8, '', 'Tolentino', 'Nikkaleen', '', 'sample', 'Female', '2014-01-30', 'sample', 12, 'sample', 'sample', 301, 3, '../certificate/steam avatar.jpg'),
(5, 10, '', 'Jose', 'Rizal', '', 'sample', 'Male', '2013-05-25', 'sample', 12, 'sample', 'sample', 301, 3, '../certificate/steam avatar.jpg'),
(6, 11, '123012390123', 'Rizal', 'Paciano', '', 'sample', 'Male', '2012-02-23', 'sample', 12, 'sample', 'sample', 302, 1, '../certificate/steam avatar.jpg'),
(8, 13, '164011080004', 'Viola', 'Maximo', 'uy', 'sample', 'Female', '2010-05-23', 'sample', 8, 'sample', 'sample', 302, 2, '../certificate/steam avatar.jpg'),
(15, 26, NULL, 'Del Pilar', 'Marcelo', 'as', 'sample', 'Male', '2017-05-25', 'sample', 8, 'sample', 'sample', 301, 3, '../certificate/steam avatar.jpg'),
(16, 27, '', 'Blumentritt', 'Ferdinand', 'as', 'sample', 'Male', '2017-03-25', 'sample', 8, 'sample', 'sample', 301, 3, '../certificate/steam avatar.jpg'),
(19, 30, NULL, 'hello', 'world', 'as', 'sample', 'Female', '2017-11-20', 'sample', 8, 'sample', 'sample', 301, 3, ''),
(20, 31, '103990000002', 'Student', 'Student', 'as', 'sample', 'Male', '2017-02-21', 'sample', 8, 'sample', 'sample', 302, 1, '../certificate/birth certificate.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `SUBJECT_ID` int(11) NOT NULL,
  `SUBJECT_NAME` varchar(50) NOT NULL,
  `SUBJECT_CODE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`SUBJECT_ID`, `SUBJECT_NAME`, `SUBJECT_CODE`) VALUES
(401, 'Kalusugan, Pangangatwan at Kasanayang Motor', 'KPKM'),
(402, 'Sosyo-emosyonal at kakayahang makipagugnay', 'SKM'),
(403, 'Language, Literacy and Communication', 'LLC'),
(404, 'Pagsasalita', 'SALITA'),
(405, 'Pagbasa', 'BASA'),
(406, 'Pagsulat', 'SULAT'),
(407, 'Matematika', 'MATH'),
(408, 'Pag-unawa sa Pisikal at Kapaligiran', 'PPKK');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher_info`
--

CREATE TABLE `tbl_teacher_info` (
  `TEACHER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(50) NOT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `MIDDLENAME` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teacher_info`
--

INSERT INTO `tbl_teacher_info` (`TEACHER_ID`, `USER_ID`, `FIRSTNAME`, `LASTNAME`, `MIDDLENAME`) VALUES
(2, 4, 'Christian', 'Fabroquez', ''),
(3, 5, 'Mary Joy', 'Base', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `USER_ID` int(11) NOT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PROFILE` varchar(255) NOT NULL,
  `ENTRY_DATETIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`USER_ID`, `USERNAME`, `PASSWORD`, `EMAIL`, `PROFILE`, `ENTRY_DATETIME`) VALUES
(2, 'admin', '$2y$10$u2p5diKJufNrxO5sa02uJ.glOmhch1UFvmADjfQUPQ7mMHrKQCTAq', 'admin@gmail.com', 'profile.jpg', '2024-01-27 11:16:17'),
(4, 'teach', '$2y$10$6Hg7nCn.0Vvy5i0A5NdGkuxIY3hl3TxNkCGcXgk06A0.z1idZ6h6K', 'teacher@gmail.com', 'profile.jpg', '2024-01-27 11:49:38'),
(5, 'base', '$2y$10$xjXRpGwb591Whjr.AltMZuiMNWbbqZhH0WukmfUjDcjgGaQjUjz62', 'base@gmail.com', 'profile.jpg', '2024-01-27 11:51:24'),
(7, 'lore', '$2y$10$XKvcS6ibxbZ1UZkS2l3Zl.SzYuPgDVJH5NczpSZOw680JG3hfv8mG', 'lore@gmail.com', 'steam avatar.jpg', '2024-01-27 12:15:54'),
(8, 'nikka', '$2y$10$09HS0k.emJaRpvS2ldv11.JYC2.TQjxBMrqupOg3bXIHeLKluwpHe', 'nikka@gmail.com', 'profile.jpg', '2024-01-27 13:13:15'),
(10, 'jose', '$2y$10$zcOW7rVgv6dPO.QPLEtVzewwfXi5a35W6KAI2Inh2xfocakZiSGgS', 'jose@gmail.com', 'profile.jpg', '2024-02-13 16:00:30'),
(11, 'Rizal', '$2y$10$ZcB9mAwQ5kA9j/EaVuh9DeKqKczsumG9gABeTNsF3/CE40yWZrOCW', 'Rizal@gmail.com', 'profile.jpg', '2024-02-17 12:59:43'),
(13, 'Viola', '$2y$10$Do/FuTQzVMRu/W8p9gslz.Al0abRqE.s2UK5nkXELYHxh8pOwsY2.', 'Viola@gmail.com', 'profile.jpg', '2024-02-17 13:04:53'),
(15, 'vlad', '$2y$10$Nkxf/Dk.eLyYcaWWEYtez.N5j/rWAKeDtd99Ol6sdJHHN0UroW0nG', 'vlad@gmail.com', 'steam avatar.jpg', '2024-02-20 12:47:32'),
(26, 'Marcelo', '$2y$10$nUe6199a6y5RmpwkSQGCYuJ/ZjcmP2IhoIVeInpiSLAo4ILO5HqGu', 'Marcelo@gmail.com', 'profile.jpg', '2024-02-20 18:48:03'),
(27, 'Ferdinand', '$2y$10$cINOzWuYAQ5qXTr8Vyl1GuYg37l7GO.48XzVYLjEE9HkLQbr4wUUa', 'Ferdinand@gmail.com', 'steam avatar.jpg', '2024-02-20 18:50:04'),
(30, 'hello', '$2y$10$pQddxfsyl3gL7ynK1EIGheyb8ybJdFDAytaw4wk4T0n3/lXYUU/0i', 'hello@gmail.com', 'profile.jpg', '2024-02-20 19:15:27'),
(31, 'student', '$2y$10$MeMXDd9Zz49gP2wNJDw2pugAwSqOrPEl8ZVouCRBUKHnGzjAFRJCy', 'student@gmail.com', 'profile.jpg', '2024-02-21 18:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `USER_ROLE_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ROLE_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`USER_ROLE_ID`, `USER_ID`, `ROLE_ID`) VALUES
(2, 2, 1),
(4, 4, 2),
(5, 5, 2),
(7, 7, 3),
(8, 8, 3),
(10, 10, 3),
(11, 11, 3),
(13, 13, 3),
(15, 15, 1),
(26, 26, 3),
(27, 27, 3),
(30, 30, 3),
(31, 31, 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_enrolled_students`
-- (See below for the actual view)
--
CREATE TABLE `vw_enrolled_students` (
`STUDENT_ID` int(11)
,`USER_ID` int(11)
,`LRN` varchar(50)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
,`MIDDLENAME` varchar(50)
,`ADDRESS` varchar(50)
,`SEX` varchar(20)
,`BIRTH_DATE` date
,`PLACE_OF_BIRTH` varchar(75)
,`AGE` int(5)
,`NATIONALITY` varchar(30)
,`RELIGION` varchar(30)
,`STATUS` varchar(20)
,`SECTION` varchar(50)
,`MOTHER_NAME` varchar(100)
,`MOTHER_OCCUPATION` varchar(100)
,`FATHER_NAME` varchar(100)
,`FATHER_OCCUPATION` varchar(100)
,`GUARDIAN_NAME` varchar(100)
,`RELATIONSHIP_ID` int(11)
,`GUARDIAN_OCCUPATION` varchar(100)
,`CONTACT_NO` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_new_enrollees`
-- (See below for the actual view)
--
CREATE TABLE `vw_new_enrollees` (
`STUDENT_ID` int(11)
,`USER_ID` int(11)
,`LRN` varchar(50)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
,`MIDDLENAME` varchar(50)
,`ADDRESS` varchar(50)
,`SEX` varchar(20)
,`BIRTH_DATE` date
,`PLACE_OF_BIRTH` varchar(75)
,`AGE` int(5)
,`NATIONALITY` varchar(30)
,`RELIGION` varchar(30)
,`STATUS` varchar(20)
,`SECTION` varchar(50)
,`MOTHER_NAME` varchar(100)
,`MOTHER_OCCUPATION` varchar(100)
,`FATHER_NAME` varchar(100)
,`FATHER_OCCUPATION` varchar(100)
,`GUARDIAN_NAME` varchar(100)
,`RELATIONSHIP` varchar(30)
,`GUARDIAN_OCCUPATION` varchar(100)
,`CONTACT_NO` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_role_sum`
-- (See below for the actual view)
--
CREATE TABLE `vw_role_sum` (
`role_name` varchar(13)
,`role_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_schedule`
-- (See below for the actual view)
--
CREATE TABLE `vw_schedule` (
`CLASS_ID` int(11)
,`SECTION_ID` int(11)
,`SECTION` varchar(50)
,`SUBJECT_ID` int(11)
,`SUBJECT_NAME` varchar(50)
,`SUBJECT_CODE` varchar(20)
,`DAY_OF_WEEK` varchar(20)
,`START_TIME` varchar(25)
,`END_TIME` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section`
-- (See below for the actual view)
--
CREATE TABLE `vw_section` (
`SECTION_ID` int(11)
,`SECTION` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section_count`
-- (See below for the actual view)
--
CREATE TABLE `vw_section_count` (
`section_name` varchar(9)
,`section_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section_one`
-- (See below for the actual view)
--
CREATE TABLE `vw_section_one` (
`PROFILE` varchar(255)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section_one_schedule`
-- (See below for the actual view)
--
CREATE TABLE `vw_section_one_schedule` (
`SECTION` varchar(50)
,`DAY_AND_TIME` mediumtext
,`SUBJECT_NAME` varchar(50)
,`SUBJECT_CODE` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section_two`
-- (See below for the actual view)
--
CREATE TABLE `vw_section_two` (
`PROFILE` varchar(255)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_section_two_schedule`
-- (See below for the actual view)
--
CREATE TABLE `vw_section_two_schedule` (
`SECTION` varchar(50)
,`DAY_AND_TIME` mediumtext
,`SUBJECT_NAME` varchar(50)
,`SUBJECT_CODE` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_student_info`
-- (See below for the actual view)
--
CREATE TABLE `vw_student_info` (
`STUDENT_ID` int(11)
,`USER_ID` int(11)
,`LRN` varchar(50)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
,`MIDDLENAME` varchar(50)
,`ADDRESS` varchar(50)
,`SEX` varchar(20)
,`BIRTH_DATE` date
,`PLACE_OF_BIRTH` varchar(75)
,`AGE` int(5)
,`NATIONALITY` varchar(30)
,`RELIGION` varchar(30)
,`STATUS` varchar(20)
,`SECTION` varchar(50)
,`MOTHER_NAME` varchar(100)
,`MOTHER_OCCUPATION` varchar(100)
,`FATHER_NAME` varchar(100)
,`FATHER_OCCUPATION` varchar(100)
,`GUARDIAN_NAME` varchar(100)
,`RELATIONSHIP` varchar(30)
,`GUARDIAN_OCCUPATION` varchar(100)
,`CONTACT_NO` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_student_info_1`
-- (See below for the actual view)
--
CREATE TABLE `vw_student_info_1` (
`STUDENT_ID` int(11)
,`USER_ID` int(11)
,`LRN` varchar(50)
,`LASTNAME` varchar(50)
,`FIRSTNAME` varchar(50)
,`MIDDLENAME` varchar(50)
,`ADDRESS` varchar(50)
,`SEX` varchar(20)
,`BIRTH_DATE` date
,`PLACE_OF_BIRTH` varchar(75)
,`AGE` int(5)
,`NATIONALITY` varchar(30)
,`RELIGION` varchar(30)
,`BIRTH_CERTIFICATE` varchar(255)
,`STATUS` varchar(20)
,`SECTION` varchar(50)
,`MOTHER_NAME` varchar(100)
,`MOTHER_OCCUPATION` varchar(100)
,`FATHER_NAME` varchar(100)
,`FATHER_OCCUPATION` varchar(100)
,`GUARDIAN_NAME` varchar(100)
,`RELATIONSHIP` varchar(30)
,`GUARDIAN_OCCUPATION` varchar(100)
,`CONTACT_NO` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user_roles`
-- (See below for the actual view)
--
CREATE TABLE `vw_user_roles` (
`USER_ID` int(11)
,`USERNAME` varchar(100)
,`EMAIL` varchar(100)
,`PASSWORD` varchar(255)
,`FIRSTNAME` varchar(50)
,`LASTNAME` varchar(50)
,`MIDDLENAME` varchar(100)
,`ROLE` varchar(50)
,`PROFILE` varchar(255)
,`ENTRY_DATETIME` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `section_sum_view`
--
DROP TABLE IF EXISTS `section_sum_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `section_sum_view`  AS SELECT sum(case when `tbl_student_info`.`SECTION_ID` = '1' then 1 else 0 end) AS `Section_1`, sum(case when `tbl_student_info`.`SECTION_ID` = '2' then 1 else 0 end) AS `Section_2`, sum(case when `tbl_student_info`.`SECTION_ID` = '3' then 1 else 0 end) AS `Pending` FROM `tbl_student_info` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_enrolled_students`
--
DROP TABLE IF EXISTS `vw_enrolled_students`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_enrolled_students`  AS SELECT `s`.`STUDENT_ID` AS `STUDENT_ID`, `s`.`USER_ID` AS `USER_ID`, `s`.`LRN` AS `LRN`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME`, `s`.`MIDDLENAME` AS `MIDDLENAME`, `s`.`ADDRESS` AS `ADDRESS`, `s`.`SEX` AS `SEX`, `s`.`BIRTH_DATE` AS `BIRTH_DATE`, `s`.`PLACE_OF_BIRTH` AS `PLACE_OF_BIRTH`, `s`.`AGE` AS `AGE`, `s`.`NATIONALITY` AS `NATIONALITY`, `s`.`RELIGION` AS `RELIGION`, `stat`.`STATUS` AS `STATUS`, `sec`.`SECTION` AS `SECTION`, `mot`.`MOTHER_NAME` AS `MOTHER_NAME`, `mot`.`MOTHER_OCCUPATION` AS `MOTHER_OCCUPATION`, `fat`.`FATHER_NAME` AS `FATHER_NAME`, `fat`.`FATHER_OCCUPATION` AS `FATHER_OCCUPATION`, `guar`.`GUARDIAN_NAME` AS `GUARDIAN_NAME`, `guar`.`RELATIONSHIP_ID` AS `RELATIONSHIP_ID`, `guar`.`GUARDIAN_OCCUPATION` AS `GUARDIAN_OCCUPATION`, `guar`.`CONTACT_NO` AS `CONTACT_NO` FROM (((((`tbl_student_info` `s` left join `tbl_status` `stat` on(`s`.`STATUS_ID` = `stat`.`STATUS_ID`)) left join `tbl_section` `sec` on(`s`.`SECTION_ID` = `sec`.`SECTION_ID`)) left join `tbl_mother` `mot` on(`s`.`USER_ID` = `mot`.`MOTHER_ID`)) left join `tbl_father` `fat` on(`s`.`USER_ID` = `fat`.`FATHER_ID`)) left join `tbl_guardian` `guar` on(`s`.`USER_ID` = `guar`.`GUARDIAN_ID`)) WHERE `s`.`STATUS_ID` = 302 ORDER BY `s`.`USER_ID` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_new_enrollees`
--
DROP TABLE IF EXISTS `vw_new_enrollees`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_new_enrollees`  AS SELECT `s`.`STUDENT_ID` AS `STUDENT_ID`, `s`.`USER_ID` AS `USER_ID`, `s`.`LRN` AS `LRN`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME`, `s`.`MIDDLENAME` AS `MIDDLENAME`, `s`.`ADDRESS` AS `ADDRESS`, `s`.`SEX` AS `SEX`, `s`.`BIRTH_DATE` AS `BIRTH_DATE`, `s`.`PLACE_OF_BIRTH` AS `PLACE_OF_BIRTH`, `s`.`AGE` AS `AGE`, `s`.`NATIONALITY` AS `NATIONALITY`, `s`.`RELIGION` AS `RELIGION`, `stat`.`STATUS` AS `STATUS`, `sec`.`SECTION` AS `SECTION`, `mot`.`MOTHER_NAME` AS `MOTHER_NAME`, `mot`.`MOTHER_OCCUPATION` AS `MOTHER_OCCUPATION`, `fat`.`FATHER_NAME` AS `FATHER_NAME`, `fat`.`FATHER_OCCUPATION` AS `FATHER_OCCUPATION`, `guar`.`GUARDIAN_NAME` AS `GUARDIAN_NAME`, `tbl_relationship`.`RELATIONSHIP` AS `RELATIONSHIP`, `guar`.`GUARDIAN_OCCUPATION` AS `GUARDIAN_OCCUPATION`, `guar`.`CONTACT_NO` AS `CONTACT_NO` FROM ((((((`tbl_student_info` `s` left join `tbl_status` `stat` on(`s`.`STATUS_ID` = `stat`.`STATUS_ID`)) left join `tbl_section` `sec` on(`s`.`SECTION_ID` = `sec`.`SECTION_ID`)) left join `tbl_mother` `mot` on(`s`.`USER_ID` = `mot`.`MOTHER_ID`)) left join `tbl_father` `fat` on(`s`.`USER_ID` = `fat`.`FATHER_ID`)) left join `tbl_guardian` `guar` on(`s`.`USER_ID` = `guar`.`GUARDIAN_ID`)) left join `tbl_relationship` on(`guar`.`RELATIONSHIP_ID` = `tbl_relationship`.`RELATIONSHIP_ID`)) WHERE `stat`.`STATUS_ID` = 301 ORDER BY `s`.`USER_ID` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_role_sum`
--
DROP TABLE IF EXISTS `vw_role_sum`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_role_sum`  AS SELECT 'Student' AS `role_name`, count(case when `tbl_user_roles`.`ROLE_ID` = 3 then 1 end) AS `role_count` FROM `tbl_user_roles`union all select 'Administrator' AS `role_name`,count(case when `tbl_user_roles`.`ROLE_ID` = 1 then 1 end) AS `role_count` from `tbl_user_roles` union all select 'Teacher' AS `role_name`,count(case when `tbl_user_roles`.`ROLE_ID` = 2 then 1 end) AS `role_count` from `tbl_user_roles`  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_schedule`
--
DROP TABLE IF EXISTS `vw_schedule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_schedule`  AS SELECT `c`.`CLASS_ID` AS `CLASS_ID`, `sec`.`SECTION_ID` AS `SECTION_ID`, `sec`.`SECTION` AS `SECTION`, `sub`.`SUBJECT_ID` AS `SUBJECT_ID`, `sub`.`SUBJECT_NAME` AS `SUBJECT_NAME`, `sub`.`SUBJECT_CODE` AS `SUBJECT_CODE`, `c`.`DAY_OF_WEEK` AS `DAY_OF_WEEK`, `c`.`START_TIME` AS `START_TIME`, `c`.`END_TIME` AS `END_TIME` FROM ((`tbl_class` `c` left join `tbl_subjects` `sub` on(`c`.`SUBJECT_ID` = `sub`.`SUBJECT_ID`)) left join `tbl_section` `sec` on(`c`.`SECTION_ID` = `sec`.`SECTION_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section`
--
DROP TABLE IF EXISTS `vw_section`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section`  AS SELECT `tbl_section`.`SECTION_ID` AS `SECTION_ID`, `tbl_section`.`SECTION` AS `SECTION` FROM `tbl_section` WHERE `tbl_section`.`SECTION_ID` = 1 OR `tbl_section`.`SECTION_ID` = 2 ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section_count`
--
DROP TABLE IF EXISTS `vw_section_count`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section_count`  AS SELECT 'Section 1' AS `section_name`, count(case when `tbl_student_info`.`SECTION_ID` = 1 then 1 end) AS `section_count` FROM `tbl_student_info`union all select 'Section 2' AS `section_name`,count(case when `tbl_student_info`.`SECTION_ID` = 2 then 1 end) AS `section_count` from `tbl_student_info` union all select 'Pending' AS `section_name`,count(case when `tbl_student_info`.`SECTION_ID` = 3 then 1 end) AS `section_count` from `tbl_student_info`  ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section_one`
--
DROP TABLE IF EXISTS `vw_section_one`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section_one`  AS SELECT `u`.`PROFILE` AS `PROFILE`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME` FROM (`tbl_users` `u` left join `tbl_student_info` `s` on(`s`.`USER_ID` = `u`.`USER_ID`)) WHERE `s`.`SECTION_ID` = 1 ORDER BY `s`.`LASTNAME` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section_one_schedule`
--
DROP TABLE IF EXISTS `vw_section_one_schedule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section_one_schedule`  AS SELECT `sec`.`SECTION` AS `SECTION`, group_concat(concat(`c`.`DAY_OF_WEEK`,' ',`c`.`START_TIME`,'-',`c`.`END_TIME`) separator ', ') AS `DAY_AND_TIME`, `s`.`SUBJECT_NAME` AS `SUBJECT_NAME`, `s`.`SUBJECT_CODE` AS `SUBJECT_CODE` FROM ((`tbl_class` `c` left join `tbl_subjects` `s` on(`c`.`SUBJECT_ID` = `s`.`SUBJECT_ID`)) left join `tbl_section` `sec` on(`c`.`SECTION_ID` = `sec`.`SECTION_ID`)) WHERE `c`.`SECTION_ID` = 1 GROUP BY `c`.`SUBJECT_ID`, `c`.`SECTION_ID` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section_two`
--
DROP TABLE IF EXISTS `vw_section_two`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section_two`  AS SELECT `u`.`PROFILE` AS `PROFILE`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME` FROM (`tbl_users` `u` left join `tbl_student_info` `s` on(`s`.`USER_ID` = `u`.`USER_ID`)) WHERE `s`.`SECTION_ID` = 2 ORDER BY `s`.`LASTNAME` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_section_two_schedule`
--
DROP TABLE IF EXISTS `vw_section_two_schedule`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_section_two_schedule`  AS SELECT `sec`.`SECTION` AS `SECTION`, group_concat(concat(`c`.`DAY_OF_WEEK`,' ',`c`.`START_TIME`,'-',`c`.`END_TIME`) separator ', ') AS `DAY_AND_TIME`, `s`.`SUBJECT_NAME` AS `SUBJECT_NAME`, `s`.`SUBJECT_CODE` AS `SUBJECT_CODE` FROM ((`tbl_class` `c` left join `tbl_subjects` `s` on(`c`.`SUBJECT_ID` = `s`.`SUBJECT_ID`)) left join `tbl_section` `sec` on(`c`.`SECTION_ID` = `sec`.`SECTION_ID`)) WHERE `c`.`SECTION_ID` = 2 GROUP BY `c`.`SUBJECT_ID`, `c`.`SECTION_ID` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_student_info`
--
DROP TABLE IF EXISTS `vw_student_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_student_info`  AS SELECT `s`.`STUDENT_ID` AS `STUDENT_ID`, `s`.`USER_ID` AS `USER_ID`, `s`.`LRN` AS `LRN`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME`, `s`.`MIDDLENAME` AS `MIDDLENAME`, `s`.`ADDRESS` AS `ADDRESS`, `s`.`SEX` AS `SEX`, `s`.`BIRTH_DATE` AS `BIRTH_DATE`, `s`.`PLACE_OF_BIRTH` AS `PLACE_OF_BIRTH`, `s`.`AGE` AS `AGE`, `s`.`NATIONALITY` AS `NATIONALITY`, `s`.`RELIGION` AS `RELIGION`, `stat`.`STATUS` AS `STATUS`, `sec`.`SECTION` AS `SECTION`, `mot`.`MOTHER_NAME` AS `MOTHER_NAME`, `mot`.`MOTHER_OCCUPATION` AS `MOTHER_OCCUPATION`, `fat`.`FATHER_NAME` AS `FATHER_NAME`, `fat`.`FATHER_OCCUPATION` AS `FATHER_OCCUPATION`, `guar`.`GUARDIAN_NAME` AS `GUARDIAN_NAME`, `tbl_relationship`.`RELATIONSHIP` AS `RELATIONSHIP`, `guar`.`GUARDIAN_OCCUPATION` AS `GUARDIAN_OCCUPATION`, `guar`.`CONTACT_NO` AS `CONTACT_NO` FROM ((((((`tbl_student_info` `s` left join `tbl_status` `stat` on(`s`.`STATUS_ID` = `stat`.`STATUS_ID`)) left join `tbl_section` `sec` on(`s`.`SECTION_ID` = `sec`.`SECTION_ID`)) left join `tbl_mother` `mot` on(`s`.`USER_ID` = `mot`.`MOTHER_ID`)) left join `tbl_father` `fat` on(`s`.`USER_ID` = `fat`.`FATHER_ID`)) left join `tbl_guardian` `guar` on(`s`.`USER_ID` = `guar`.`GUARDIAN_ID`)) left join `tbl_relationship` on(`guar`.`RELATIONSHIP_ID` = `tbl_relationship`.`RELATIONSHIP_ID`)) ORDER BY `s`.`USER_ID` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_student_info_1`
--
DROP TABLE IF EXISTS `vw_student_info_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_student_info_1`  AS SELECT `s`.`STUDENT_ID` AS `STUDENT_ID`, `s`.`USER_ID` AS `USER_ID`, `s`.`LRN` AS `LRN`, `s`.`LASTNAME` AS `LASTNAME`, `s`.`FIRSTNAME` AS `FIRSTNAME`, `s`.`MIDDLENAME` AS `MIDDLENAME`, `s`.`ADDRESS` AS `ADDRESS`, `s`.`SEX` AS `SEX`, `s`.`BIRTH_DATE` AS `BIRTH_DATE`, `s`.`PLACE_OF_BIRTH` AS `PLACE_OF_BIRTH`, `s`.`AGE` AS `AGE`, `s`.`NATIONALITY` AS `NATIONALITY`, `s`.`RELIGION` AS `RELIGION`, `s`.`BIRTH_CERTIFICATE` AS `BIRTH_CERTIFICATE`, `stat`.`STATUS` AS `STATUS`, `sec`.`SECTION` AS `SECTION`, `mot`.`MOTHER_NAME` AS `MOTHER_NAME`, `mot`.`MOTHER_OCCUPATION` AS `MOTHER_OCCUPATION`, `fat`.`FATHER_NAME` AS `FATHER_NAME`, `fat`.`FATHER_OCCUPATION` AS `FATHER_OCCUPATION`, `guar`.`GUARDIAN_NAME` AS `GUARDIAN_NAME`, `tbl_relationship`.`RELATIONSHIP` AS `RELATIONSHIP`, `guar`.`GUARDIAN_OCCUPATION` AS `GUARDIAN_OCCUPATION`, `guar`.`CONTACT_NO` AS `CONTACT_NO` FROM ((((((`tbl_student_info` `s` left join `tbl_status` `stat` on(`s`.`STATUS_ID` = `stat`.`STATUS_ID`)) left join `tbl_section` `sec` on(`s`.`SECTION_ID` = `sec`.`SECTION_ID`)) left join `tbl_mother` `mot` on(`s`.`USER_ID` = `mot`.`MOTHER_ID`)) left join `tbl_father` `fat` on(`s`.`USER_ID` = `fat`.`FATHER_ID`)) left join `tbl_guardian` `guar` on(`s`.`USER_ID` = `guar`.`GUARDIAN_ID`)) left join `tbl_relationship` on(`guar`.`RELATIONSHIP_ID` = `tbl_relationship`.`RELATIONSHIP_ID`)) ORDER BY `s`.`USER_ID` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vw_user_roles`
--
DROP TABLE IF EXISTS `vw_user_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user_roles`  AS SELECT `u`.`USER_ID` AS `USER_ID`, `u`.`USERNAME` AS `USERNAME`, `u`.`EMAIL` AS `EMAIL`, `u`.`PASSWORD` AS `PASSWORD`, coalesce(`a`.`FIRSTNAME`,`s`.`FIRSTNAME`,`t`.`FIRSTNAME`) AS `FIRSTNAME`, coalesce(`a`.`LASTNAME`,`s`.`LASTNAME`,`t`.`LASTNAME`) AS `LASTNAME`, coalesce(`a`.`MIDDLENAME`,`s`.`MIDDLENAME`,`t`.`MIDDLENAME`) AS `MIDDLENAME`, coalesce(`r`.`ROLE_NAME`,'Unknown') AS `ROLE`, `u`.`PROFILE` AS `PROFILE`, `u`.`ENTRY_DATETIME` AS `ENTRY_DATETIME` FROM (((((`tbl_users` `u` left join `tbl_user_roles` `ur` on(`u`.`USER_ID` = `ur`.`USER_ID`)) left join `tbl_roles` `r` on(`ur`.`ROLE_ID` = `r`.`ROLE_ID`)) left join `tbl_admin_info` `a` on(`u`.`USER_ID` = `a`.`USER_ID` and `r`.`ROLE_NAME` = 'Administrator')) left join `tbl_student_info` `s` on(`u`.`USER_ID` = `s`.`USER_ID` and `r`.`ROLE_NAME` = 'Student')) left join `tbl_teacher_info` `t` on(`u`.`USER_ID` = `t`.`USER_ID` and `r`.`ROLE_NAME` = 'Teacher')) ORDER BY `u`.`USER_ID` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  ADD PRIMARY KEY (`ADMIN_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`CLASS_ID`),
  ADD KEY `SUBJECT_ID` (`SUBJECT_ID`),
  ADD KEY `SECTION_ID` (`SECTION_ID`);

--
-- Indexes for table `tbl_father`
--
ALTER TABLE `tbl_father`
  ADD PRIMARY KEY (`FATHER_ID`);

--
-- Indexes for table `tbl_guardian`
--
ALTER TABLE `tbl_guardian`
  ADD PRIMARY KEY (`GUARDIAN_ID`);

--
-- Indexes for table `tbl_mother`
--
ALTER TABLE `tbl_mother`
  ADD PRIMARY KEY (`MOTHER_ID`);

--
-- Indexes for table `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  ADD PRIMARY KEY (`RELATIONSHIP_ID`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`ROLE_ID`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`SECTION_ID`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`STATUS_ID`);

--
-- Indexes for table `tbl_student_info`
--
ALTER TABLE `tbl_student_info`
  ADD PRIMARY KEY (`STUDENT_ID`),
  ADD KEY `tbl_student_info_ibfk_1` (`USER_ID`),
  ADD KEY `tbl_student_info_ibfk_2` (`STATUS_ID`),
  ADD KEY `tbl_student_info_ibfk_3` (`SECTION_ID`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`SUBJECT_ID`);

--
-- Indexes for table `tbl_teacher_info`
--
ALTER TABLE `tbl_teacher_info`
  ADD PRIMARY KEY (`TEACHER_ID`),
  ADD KEY `tbl_teacher_info_ibfk_1` (`USER_ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`USER_ROLE_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `ROLE_ID` (`ROLE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  MODIFY `ADMIN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_class`
--
ALTER TABLE `tbl_class`
  MODIFY `CLASS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `SECTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `STATUS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `tbl_student_info`
--
ALTER TABLE `tbl_student_info`
  MODIFY `STUDENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

--
-- AUTO_INCREMENT for table `tbl_teacher_info`
--
ALTER TABLE `tbl_teacher_info`
  MODIFY `TEACHER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `USER_ROLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  ADD CONSTRAINT `tbl_admin_info_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_user_roles` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD CONSTRAINT `tbl_class_ibfk_1` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `tbl_subjects` (`SUBJECT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_class_ibfk_2` FOREIGN KEY (`SECTION_ID`) REFERENCES `tbl_section` (`SECTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_father`
--
ALTER TABLE `tbl_father`
  ADD CONSTRAINT `tbl_father_ibfk_1` FOREIGN KEY (`FATHER_ID`) REFERENCES `tbl_student_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_guardian`
--
ALTER TABLE `tbl_guardian`
  ADD CONSTRAINT `tbl_guardian_ibfk_1` FOREIGN KEY (`GUARDIAN_ID`) REFERENCES `tbl_student_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_mother`
--
ALTER TABLE `tbl_mother`
  ADD CONSTRAINT `tbl_mother_ibfk_1` FOREIGN KEY (`MOTHER_ID`) REFERENCES `tbl_student_info` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_student_info`
--
ALTER TABLE `tbl_student_info`
  ADD CONSTRAINT `tbl_student_info_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_user_roles` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_info_ibfk_2` FOREIGN KEY (`STATUS_ID`) REFERENCES `tbl_status` (`STATUS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_info_ibfk_3` FOREIGN KEY (`SECTION_ID`) REFERENCES `tbl_section` (`SECTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_teacher_info`
--
ALTER TABLE `tbl_teacher_info`
  ADD CONSTRAINT `tbl_teacher_info_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_user_roles` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD CONSTRAINT `tbl_user_roles_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `tbl_users` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_user_roles_ibfk_2` FOREIGN KEY (`ROLE_ID`) REFERENCES `tbl_roles` (`ROLE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
