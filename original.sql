-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 06:39 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `project_reports`
--
-- --------------------------------------------------------
--
-- Table structure for table `daily`
--
CREATE TABLE `daily` (
  `Id` int(255) NOT NULL,
  `Collage_id` varchar(20) NOT NULL,
  `Title` varchar(40) NOT NULL,
  `Description` text NOT NULL,
  `Group_id` int(20) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `daily`
--
INSERT INTO
  `daily` (
    `Id`,
    `Collage_id`,
    `Title`,
    `Description`,
    `Group_id`,
    `Date`
  )
VALUES
  (
    18,
    '22IT054',
    'Daily Title Demo',
    'Daily Description Demo ',
    55,
    '2024-03-11'
  ),
  (
    19,
    '22IT054',
    'Daily Title Demo',
    'Daily Description Demo',
    55,
    '2024-03-17'
  );

-- --------------------------------------------------------
--
-- Table structure for table `faculty`
--
CREATE TABLE `faculty` (
  `id` int(20) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--
INSERT INTO
  `faculty` (`id`, `Name`, `Email`, `Password`)
VALUES
  (
    1,
    'ParthShah',
    'parthshah.ce@charusat.ac.in',
    '123456'
  ),
  (
    2,
    'JalpeshVasa',
    'jalpeshvasa@charusat.ac.in\n',
    '123456'
  ),
  (
    3,
    'RaviPatel',
    'ravipatel.it@charusat.ac.in',
    '123456'
  ),
  (
    4,
    'NishatShaikh',
    'nishatshaikh.it@charusat.ac.in\n',
    '123456'
  ),
  (
    5,
    'PriyankaPatel',
    'priyankapatel.it@charusat.ac.in\n',
    '123456'
  );

-- --------------------------------------------------------
--
-- Table structure for table `image`
--
CREATE TABLE `image` (
  `id` int(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_data` mediumblob NOT NULL,
  `Group_id` int(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `Collage_id` varchar(20) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `indevidual`
--
CREATE TABLE `indevidual` (
  `id` int(200) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `work` varchar(200) NOT NULL,
  `week_id` int(200) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `indevidual`
--
INSERT INTO
  `indevidual` (`id`, `user_id`, `work`, `week_id`)
VALUES
  (0, '22IT054', 'Work Data', 44);

-- --------------------------------------------------------
--
-- Table structure for table `members`
--
CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `member_id` varchar(15) NOT NULL,
  `Designation` varchar(10) NOT NULL DEFAULT 'Member'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `members`
--
INSERT INTO
  `members` (`id`, `project_id`, `member_id`, `Designation`)
VALUES
  (0, 55, '22IT054', 'Leader'),
  (0, 56, '22IT042', 'Leader');

-- --------------------------------------------------------
--
-- Table structure for table `notifications`
--
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` varchar(255) DEFAULT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'not seen'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `openproject`
--
CREATE TABLE `openproject` (
  `id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `projectName` varchar(255) NOT NULL,
  `projectTechnology` varchar(255) DEFAULT NULL,
  `projectMembers` varchar(255) DEFAULT NULL,
  `projectStatus` varchar(255) DEFAULT NULL,
  `projectDuration` varchar(255) DEFAULT NULL,
  `projectAbstract` text DEFAULT NULL,
  `technologyKeywords` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `projects`
--
CREATE TABLE `projects` (
  `id` int(100) NOT NULL,
  `project_name` text DEFAULT NULL,
  `Description` text NOT NULL,
  `start_date` date DEFAULT current_timestamp(),
  `end_date` date DEFAULT '2023-09-05',
  `member_count` int(11) DEFAULT NULL,
  `f_id` int(100) NOT NULL,
  `open_project_id` int(20) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--
INSERT INTO
  `projects` (
    `id`,
    `project_name`,
    `Description`,
    `start_date`,
    `end_date`,
    `member_count`,
    `f_id`,
    `open_project_id`,
    `status`
  )
VALUES
  (
    55,
    'Kavya s Project',
    'Description',
    '2024-03-03',
    '2024-09-05',
    1,
    1,
    0,
    1
  ),
  (
    56,
    'App developement',
    'Description',
    '2024-03-15',
    '2024-09-05',
    1,
    1,
    0,
    1
  );

-- --------------------------------------------------------
--
-- Table structure for table `student`
--
CREATE TABLE `student` (
  `Id` int(100) NOT NULL,
  `Collage_id` varchar(10) NOT NULL,
  `First_name` varchar(20) NOT NULL,
  `Last_name` varchar(20) NOT NULL,
  `Email` varchar(35) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `student`
--
INSERT INTO
  `student` (
    `Id`,
    `Collage_id`,
    `First_name`,
    `Last_name`,
    `Email`,
    `Password`
  )
VALUES
  (
    1,
    '22IT001',
    'KHYATI ',
    'AMIN ',
    '22IT001@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    2,
    '22IT002',
    'BHAVYAKUMAR  ',
    'BHAGAT ',
    '22IT002@charusat.edu.in',
    '$2y$10$0c.YwYCSE/AsRkfsxrAAIuwwSGX9sp7sfx6/10ZUUALrLh2A5NHvO'
  ),
  (
    3,
    '22IT003',
    'DHAIRYA',
    'BHAVSAR ',
    '22IT003@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    4,
    '22IT004',
    'YUVRAJSINH  ',
    'BODANA ',
    '22IT004@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    5,
    '22IT005',
    'ANMOL  ',
    'CHAUHAN ',
    '22IT005@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    6,
    '22IT006',
    'FORAM  ',
    'DALSANIYA ',
    '22IT006@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    7,
    '22IT007',
    'DAKSHKUMAR  ',
    'DARJI ',
    '22IT007@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    8,
    '22IT008',
    'IKRAMALI  ',
    'DEDHROTIYA ',
    '22IT008@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    9,
    '22IT009',
    'ARPIT  ',
    'GHODASARA ',
    '22IT009@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    10,
    '22IT010',
    'AYUSH  ',
    'GHODASARA ',
    '22IT010@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    11,
    '22IT011',
    'VAIDEHI  ',
    'GHODASARA ',
    '22IT011@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    12,
    '22IT012',
    'DHAIRYA  ',
    'GOHIL ',
    '22IT012@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    13,
    '22IT013',
    'AYUSHI  ',
    'GONDALIYA ',
    '22IT013@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    14,
    '22IT014',
    'SHIKHA  ',
    'GOTHI ',
    '22IT014@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    15,
    '22IT015',
    'DHRUV  ',
    'HARANIYA ',
    '22IT015@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    16,
    '22IT016',
    'HARSHIV  ',
    'KINARIWALA ',
    '22IT016@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    17,
    '22IT017',
    'HELI  ',
    'HINGRAJIYA ',
    '22IT017@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    18,
    '22IT019',
    'MANAV  ',
    'JETHVA ',
    '22IT019@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    19,
    '22IT020',
    'KUSH  ',
    'JIVANI ',
    '22IT020@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    20,
    '22IT021',
    'JAY  ',
    'KANZARIYA ',
    '22IT021@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    21,
    '22IT022',
    'KHUSHI ',
    'KATHIRIYA ',
    '22IT022@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    22,
    '22IT023',
    'MEET  ',
    'KOTHARI',
    '22IT023@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    23,
    '22IT024',
    'DRASHTI',
    'MAHYAVANSHI ',
    '22IT024@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    24,
    '22IT025',
    'JAIMIN',
    'MAKADIA ',
    '22IT025@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    25,
    '22IT026',
    'HARSHAL  ',
    'MAKWANA ',
    '22IT026@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    26,
    '22IT027',
    'MILAP  ',
    'MAKWANA ',
    '22IT027@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    27,
    '22IT028',
    'HAMIR  ',
    'MANDHA ',
    '22IT028@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    28,
    '22IT029',
    'VINAS  ',
    'MANGROLIYA ',
    '22IT029@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    29,
    '22IT030',
    'BHAVYEN ',
    'MEHTA ',
    '22IT030@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    30,
    '22IT031',
    'HEMISH  ',
    'MEHTA ',
    '22IT031@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    31,
    '22IT032',
    'MAHIMA  ',
    'MEHTA ',
    '22IT032@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    32,
    '22IT033',
    'VRUSHALI  ',
    'MHASKAR ',
    '22IT033@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    33,
    '22IT034',
    'KARAN  ',
    'MOTIANI ',
    '22IT034@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    34,
    '22IT035',
    'DEV  ',
    'PADALIYA ',
    '22IT035@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    35,
    '22IT036',
    'SAMARTH  ',
    'PANDYA ',
    '22IT036@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    36,
    '22IT037',
    'JINESHKUMAR  ',
    'PAREKH ',
    '22IT037@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    37,
    '22IT038',
    'ARYAN  ',
    'PATEL ',
    '22IT038@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    38,
    '22IT039',
    'BHAVI  ',
    'PATEL ',
    '22IT039@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    39,
    '22IT040',
    'DHRUV  ',
    'PATEL ',
    '22IT040@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    40,
    '22IT041',
    'DHRUV  ',
    'PATEL ',
    '22IT041@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    41,
    '22IT042',
    'PRATHVI  ',
    'HIRAPARA ',
    '22IT042@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    42,
    '22IT044',
    'RAHUL  ',
    'MISTRY ',
    '22IT044@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    43,
    '22IT045',
    'JEEL  ',
    'PATEL ',
    '22IT045@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    44,
    '22IT047',
    'VEDKUMAR  ',
    'PATEL ',
    '22IT047@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    45,
    '22IT048',
    'SHREEDHAR  ',
    'PATIL ',
    '22IT048@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    46,
    '22IT049',
    'SUJAL ',
    'POKIYA',
    '22IT049@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    47,
    '22IT051',
    'NIRAV  ',
    'PRAJAPATI ',
    '22IT051@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    48,
    '22IT052',
    'VRAJ  ',
    'PRAJAPATI ',
    '22IT052@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    49,
    '22IT053',
    'JAY  ',
    'RABARI ',
    '22IT053@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    50,
    '22IT054',
    'KAVYA ',
    'KARIA ',
    '22IT054@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    51,
    '22IT055',
    'YASHU  ',
    'RANPARIA ',
    '22IT055@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    52,
    '22IT056',
    'RHYTHM  ',
    'RATHOD ',
    '22IT056@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    53,
    '22IT057',
    'HARSH  ',
    'SACHAPARA ',
    '22IT057@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    54,
    '22IT058',
    'PRUSHTI  ',
    'KATHROTIYA ',
    '22IT058@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    55,
    '22IT059',
    'ADITYA  ',
    'SHAH ',
    '22IT059@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    56,
    '22IT060',
    'DEVANSH  ',
    'SHAH ',
    '22IT060@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    57,
    '22IT062',
    'JOY  ',
    'SHAH ',
    '22IT062@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    58,
    '22IT063',
    'MANAN ',
    'SHAH ',
    '22IT063@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    59,
    '22IT064',
    'SAKSHI  ',
    'SHAH ',
    '22IT064@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  ),
  (
    60,
    '22IT065',
    'VRAJ  ',
    'SHAH ',
    '22IT065@charusat.edu.in',
    '$2y$10$O8Y.FK82KWfv2X6Mc5R6oeupp1aQaJS/yMabc1tN0GOmZ.0kZtFhi'
  );

-- --------------------------------------------------------
--
-- Table structure for table `weekly`
--
CREATE TABLE `weekly` (
  `id` int(200) NOT NULL,
  `this_week` text NOT NULL,
  `project_id` int(200) NOT NULL,
  `next_week` text NOT NULL,
  `Faculty_input` text DEFAULT '--',
  `marks` int(10) NOT NULL DEFAULT 0,
  `status` int(3) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `weekly`
--
INSERT INTO
  `weekly` (
    `id`,
    `this_week`,
    `project_id`,
    `next_week`,
    `Faculty_input`,
    `marks`,
    `status`
  )
VALUES
  (44, 'hello ', 55, 'fb ffg fb f', NULL, 0, 1);

--
-- Indexes for dumped tables
--
--
-- Indexes for table `daily`
--
ALTER TABLE
  `daily`
ADD
  PRIMARY KEY (`Id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE
  `faculty`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE
  `image`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `openproject`
--
ALTER TABLE
  `openproject`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE
  `projects`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE
  `student`
ADD
  PRIMARY KEY (`Id`);

--
-- Indexes for table `weekly`
--
ALTER TABLE
  `weekly`
ADD
  PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `daily`
--
ALTER TABLE
  `daily`
MODIFY
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE
  `faculty`
MODIFY
  `id` int(20) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE
  `image`
MODIFY
  `id` int(200) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 16;

--
-- AUTO_INCREMENT for table `openproject`
--
ALTER TABLE
  `openproject`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE
  `projects`
MODIFY
  `id` int(100) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 57;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE
  `student`
MODIFY
  `Id` int(100) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 93;

--
-- AUTO_INCREMENT for table `weekly`
--
ALTER TABLE
  `weekly`
MODIFY
  `id` int(200) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 45;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;