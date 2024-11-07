-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 08:23 AM
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
-- Database: `kuevent`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `faculty_id` int(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `faculty_id`) VALUES
(11, 'สาขาวิทยาการคอมพิวเตอร์', 6),
(12, 'ภาควิชาวิทยาการคอมพิวเตอร์และสารสนเทศ2', 6),
(13, 'ภาควิชาวิทยาศาสตร์ทั่วไป', 6),
(14, 'ภาควิชาวิศวกรรมไฟฟ้าและคอมพิวเตอร์', 6),
(15, 'ภาควิชาวิศกรรมโยธาและสิ่งแวดล้อม', 6),
(16, 'ภาควิชาวิศวกรรมเครื่องกลและการผลิต', 6);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `location_id` int(5) DEFAULT NULL,
  `room_id` int(5) DEFAULT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `faculty_id` int(5) DEFAULT NULL,
  `branch_id` int(5) DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `is_notified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `start_date`, `end_date`, `description`, `location_id`, `room_id`, `personnel_id`, `faculty_id`, `branch_id`, `image_path`, `is_notified`) VALUES
(13, 'วันวิทยาศาสตร์', '2024-08-18 00:00:00', '2024-08-19 23:00:00', 'วันวิทยาศาสตร์วันวิทยาศาสตร์วันวิทยาศาสตร์วันวิทยาศาสตร์', 7, 30, 13, 6, 11, 'uploaded_files/วันวิทยาศาสตร์แห่งชาติ-02-scaled.jpg', 0),
(15, 'สอบโปรเจค2', '2024-10-16 14:00:00', '2024-10-16 15:00:00', 'สอบโปรเจค2สอบโปรเจค2สอบโปรเจค2สอบโปรเจค2สอบโปรเจค2', 7, 40, 21, 6, 13, 'uploaded_files/วันวิทยาศาสตร์แห่งชาติ-02-scaled.jpg', 0),
(16, 'ลอยกระทง2', '2024-11-15 21:00:00', '2024-11-16 12:00:00', 'ลอยกระทงลอยกระทงลอยกระทงลอยกระทงลอยกระทงลอยกระทง2', 70, NULL, 41, 6, 11, 'uploaded_files/Loi_Krathong_2010_John_Shedrick.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(5) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`) VALUES
(6, 'คณะวิทยาศาสตร์และวิศวกรรมศาสตร์'),
(8, 'คณะสาธารณสุขศาสตร์'),
(9, 'คณะทรัพยากรธรรมชาติและอุตสาหกรรมเกษตร'),
(10, 'คณะศิลปศาสตร์และวิทยาการจัดการ'),
(11, 'สำนักงานวิทยาเขตฯ'),
(12, 'กองบริหารทั่วไป'),
(13, 'กองบริหารวิชาการและนิสิต'),
(14, 'กองบริหารการวิจัยและบริการวิชาการ'),
(15, 'กองบริหารกลาง');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `building_number` varchar(5) DEFAULT NULL,
  `latitude` varchar(250) DEFAULT NULL,
  `longitude` varchar(250) DEFAULT NULL,
  `isBding` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `building_number`, `latitude`, `longitude`, `isBding`) VALUES
(1, 'อาคารบริหาร', '1', '17.289059656736196', '104.11516465653273', 1),
(2, 'อาคารเรียนรวม', '2', '17.291084949564375', '104.10977945138222', 1),
(3, 'อาคารชุดพักอาศัยบุคลากร', '3', '17.295979691106897', '104.11536668021463', 1),
(4, 'หอพักนิสิตชายอินทนิล', '4', '17.29638497238565', '104.11448858949606', 1),
(5, 'หอพักนิสิตหญิงนนทรี', '5', '17.294968779098898', '104.11626421186435', 1),
(6, 'อาคารปฏิบัติการรวม', '6', '17.285842181947793', '104.10610532103448', 1),
(7, 'อาคารวิทยาศาสตร์และเทคโนโลยี', '7', '17.28632427996044', '104.10662192045775', 1),
(8, 'อาคารปฏิบัติการวิศวกรรมเครื่องกล/เทคโนโลยีการอาหาร', '8', '17.286092353720118', '104.10764359208052', 1),
(9, 'อาคารเทคโนโลยีสารสนเทศ', '9', '17.288464483902555', '104.10834337529579', 1),
(10, 'โรงอาหารกลาง', '10', '17.2906561088165', '104.11339424821101', 1),
(11, 'โรงกรองน้ำและหอวิทยาเขต', '11', '17.28551709515309', '104.10869554120765', 1),
(12, 'อาคารสนามกีฬา', '12', '17.293545704361023', '104.11211346922975', 1),
(13, 'พิพิธภัณฑ์องค์ความรู้', '13', '17.2899963358006', '104.11464863274637', 1),
(14, 'อาคารวิทยาเขตเฉลิมพระเกียรติ', '14', '17.28935910904363', '104.11272931036955', 1),
(15, 'อาคารถิ่นมั่นในพุทธธรรม', '15', '17.286596337545454', '104.10933852205768', 1),
(16, 'อาคารสถานพยาบาล', '16', '17.29280428462071', '104.11517147046241', 1),
(17, 'อาคารชุดพักอาศัยบุคลากร 2', '17', '17.294448252216167', '104.1177860327468', 1),
(18, 'หอพักนิสิตหญิงตาลฟ้า', '18', '17.29585838799626', '104.11830716584689', 1),
(19, 'อาคารสนามกีฬาใหม่', '19', '17.29087219818995', '104.11449038241426', 1),
(20, 'อาคารสังคมศาสตร์และวิทยาศาสตร์สุขภาพ', '20', '17.292537550093826', '104.11103231246935', 1),
(21, 'อาคารวิทยาศาสตร์และเทคโนโลยี 2', '21', '17.286800017772546', '104.10732304392839', 1),
(22, 'อาคารวิทยาศาสตร์และเทคโนโลยี', '23', '17.287568331679765', '104.10722648440351', 1),
(70, 'พระพิรุณทรงนาค', NULL, '17.288120096933373', '104.11244038490597', 0),
(71, 'อ่างสกลนคร', NULL, '17.288120096933373', '104.11244038490597', 0);

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `id` int(5) NOT NULL,
  `personnel_number` int(10) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `branch_id` int(10) DEFAULT NULL,
  `faculty_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`id`, `personnel_number`, `password`, `first_name`, `last_name`, `email`, `position`, `branch_id`, `faculty_id`) VALUES
(12, 11223344, NULL, 'พชรมงคล', 'ไตรยสุทธิ์', NULL, NULL, 11, 6),
(13, 999, NULL, 'วไลลักษณ์', 'วงษ์รื่น', NULL, NULL, 11, 6),
(15, 11223344, NULL, 'พชรมงคล', 'ไตรยสุทธิ์', NULL, NULL, 11, 6),
(16, 1, NULL, 'อ.ดร.สาวิณี', 'แสงสุริยันต์', NULL, NULL, 11, 6),
(17, 2, NULL, 'ผศ.ฐาปนี', 'เฮงสนั่นกูล', NULL, NULL, 11, 6),
(18, 3, NULL, 'ผศ.ศิริพร', 'ทับทิม', NULL, NULL, 11, 6),
(19, 4, NULL, 'รศ.ดร.พีระ', 'ลิ่วลม', NULL, NULL, 11, 6),
(20, 5, NULL, 'ผศ.ดร.สุภาพ', 'กัญญาคำ', NULL, NULL, 11, 6),
(21, 6, NULL, 'ผศ.ดร.จักรนรินทร์', 'คงเจริญ', NULL, NULL, 11, 6),
(22, 7, NULL, 'ผศ.วไลลักษณ์', 'วงษ์รื่น', NULL, NULL, 11, 6),
(23, 8, NULL, 'อ.ดร.ศศิธร', 'สุชัยยะ', NULL, NULL, 11, 6),
(24, 9, NULL, 'ผศ.ดร.ถนอมศักดิ์', 'วงศ์มีแก้ว', NULL, NULL, 11, 6),
(25, 10, NULL, 'ผศ.อัจฉรา', 'นามบุรี', NULL, NULL, 11, 6),
(26, 11, NULL, 'ผศ.ดร.สุรศักดิ์', 'ตั้งสกุล', NULL, NULL, 11, 6),
(27, 12, NULL, 'ผศ.จิตสราญ', 'สีกู่กา', NULL, NULL, 11, 6),
(28, 13, NULL, 'ผศ.ดร.จารุวัฒน์', 'ไพใหล', NULL, NULL, 11, 6),
(29, 14, NULL, 'อ.ดร.บวรรัตน์', 'ศรีมาน', NULL, NULL, 11, 6),
(30, 15, NULL, 'นายวีรชาติ', 'อักษรศักดิ์', NULL, NULL, 11, 6),
(31, 16, NULL, 'นายพรศักดิ์', 'ขวากุพันธ์', NULL, NULL, 11, 6),
(32, 1, NULL, 'อ.ดร.สาวิณี', 'แสงสุริยันต์', NULL, NULL, 11, 6),
(33, 2, NULL, 'ผศ.ฐาปนี', 'เฮงสนั่นกูล', NULL, NULL, 11, 6),
(34, 3, NULL, 'ผศ.ศิริพร', 'ทับทิม', NULL, NULL, 11, 6),
(35, 4, NULL, 'รศ.ดร.พีระ', 'ลิ่วลม', NULL, NULL, 11, 6),
(36, 5, NULL, 'ผศ.ดร.สุภาพ', 'กัญญาคำ', NULL, NULL, 11, 6),
(37, 6, NULL, 'ผศ.ดร.จักรนรินทรา', 'หมูเด้ง', NULL, NULL, 11, 6),
(38, 7, NULL, 'ผศ.วไลลักษณ์', 'วงษ์รื่น', NULL, NULL, 11, 6),
(39, 8, NULL, 'อ.ดร.ศศิธร', 'สุชัยยะ', NULL, NULL, 11, 6),
(40, 9, NULL, 'ผศ.ดร.ถนอมศักดิ์', 'วงศ์มีแก้ว', NULL, NULL, 11, 6),
(41, 10, NULL, 'ผศ.อัจฉรา', 'นามบุรี', NULL, NULL, 11, 6),
(42, 11, NULL, 'ผศ.ดร.สุรศักดิ์', 'ตั้งสกุล', NULL, NULL, 11, 6),
(43, 12, NULL, 'ผศ.จิตสราญ', 'สีกู่กา', NULL, NULL, 11, 6),
(44, 13, NULL, 'ผศ.ดร.จารุวัฒน์', 'ไพใหล', NULL, NULL, 11, 6),
(45, 14, NULL, 'อ.ดร.บวรรัตน์', 'ศรีมาน', NULL, NULL, 11, 6),
(46, 15, NULL, 'นายวีรชาติ', 'อักษรศักดิ์', NULL, NULL, 11, 6),
(47, 16, NULL, 'นายพรศักดิ์', 'ขวากุพันธ์', NULL, NULL, 11, 6);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(5) NOT NULL,
  `name` varchar(250) NOT NULL,
  `room_number` varchar(250) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `max_occupancy` int(10) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `room_number`, `location_id`, `max_occupancy`, `type`) VALUES
(2, 'MBA 1-401', '1-401', 1, 40, 'ห้องบรรยาย'),
(3, 'MBA 1-405', '1-405', 1, 50, 'ห้องบรรยาย'),
(4, 'MBA 1-407', '1-407', 1, 37, 'ห้องบรรยาย'),
(5, '2-110', '2-110', 2, 40, 'ห้องบรรยาย'),
(6, '2-201', '2-201', 2, 120, 'ห้องบรรยาย'),
(7, '2-202', '2-202', 2, 120, 'ห้องบรรยาย'),
(8, '2-203', '2-203', 2, 110, 'ห้องบรรยาย'),
(9, '2-204', '2-204', 2, 120, 'ห้องบรรยาย'),
(10, '2-205', '2-205', 2, 110, 'ห้องบรรยาย'),
(11, '2-206', '2-206', 2, 120, 'ห้องบรรยาย'),
(12, '2-207', '2-207', 2, 240, 'ห้องบรรยาย'),
(13, '2-301', '2-301', 2, 290, 'ห้องบรรยาย'),
(14, '2-302', '2-302', 2, 270, 'ห้องบรรยาย'),
(15, '2-303', '2-303', 2, 350, 'ห้องบรรยาย'),
(16, '2-304', '2-304', 2, 270, 'ห้องบรรยาย'),
(17, '6-103', '6-103', 6, 60, 'ห้องปฏิบัติการ'),
(18, '6-104', '6-104', 6, 60, 'ห้องปฏิบัติการ'),
(19, '6-203', '6-203', 6, 24, 'ห้องปฏิบัติการ'),
(20, '6-204', '6-204', 6, 24, 'ห้องปฏิบัติการ'),
(21, 'ฟาร์มสัตว์', '7-1(1)', 7, 50, 'ห้องปฏิบัติการ'),
(22, 'ฟาร์มพืช', '7-1(3)', 7, 45, 'ห้องปฏิบัติการ'),
(23, '7-112', '7-112', 7, 100, 'ห้องบรรยาย'),
(24, '7-112/1', '7-112/1', 7, 60, 'ห้องปฏิบัติการ'),
(25, '7-114/1', '7-114/1', 7, 40, 'ห้องปฏิบัติการ'),
(26, '7-114/2', '7-114/2', 7, 50, 'ห้องปฏิบัติการ'),
(27, '7-114/3', '7-114/3', 7, 20, 'ห้องปฏิบัติการ'),
(28, '7-114/4-2', '7-114/4-2', 7, 10, 'ห้องปฏิบัติการ'),
(29, '7-114/4-3', '7-114/4-3', 7, 10, 'ห้องปฏิบัติการ'),
(30, 'ห้องสว่างแดนดิน', '7-212', 7, 100, 'ห้องบรรยาย'),
(31, '7-221', '7-221', 7, 40, 'ห้องปฏิบัติการ'),
(32, '7-223', '7-223', 7, 60, 'ห้องปฏิบัติการ'),
(33, '7-224', '7-224', 7, 60, 'ห้องปฏิบัติการ'),
(34, '7-225', '7-225', 7, 60, 'ห้องปฏิบัติการ'),
(35, '7-227', '7-227', 7, 60, 'ห้องปฏิบัติการ'),
(36, 'ห้อง ป.เอก', '7-308', 7, 10, 'ห้องบรรยาย'),
(37, '7-309', '7-309', 7, 81, 'ห้องบรรยาย'),
(38, '7-310', '7-310', 7, 50, 'ห้องบรรยาย'),
(39, '7-311', '7-311', 7, 240, 'ห้องบรรยาย'),
(40, '7-311/1', '7-311/1', 7, 60, 'ห้องบรรยาย'),
(41, '7-312', '7-312', 7, 70, 'ห้องบรรยาย'),
(42, '7-313', '7-313', 7, 60, 'ห้องบรรยาย'),
(43, '7-314', '7-314', 7, 170, 'ห้องบรรยาย'),
(44, '7-315', '7-315', 7, 70, 'ห้องบรรยาย'),
(45, '7-321', '7-321', 7, 60, 'ห้องปฏิบัติการ'),
(46, '7-322', '7-322', 7, 60, 'ห้องปฏิบัติการ'),
(47, '7-323', '7-323', 7, 60, 'ห้องปฏิบัติการ'),
(48, '7-409', '7-409', 7, 140, 'ห้องบรรยาย'),
(49, '7-410', '7-410', 7, 79, 'ห้องบรรยาย'),
(50, '7-411', '7-411', 7, 140, 'ห้องบรรยาย'),
(51, '7-411/1', '7-411/1', 7, 60, 'ห้องบรรยาย');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`fname`, `lname`, `username`, `password`, `id`) VALUES
('admin', 'admin', 'admin', '$2y$10$3ILF/9d7jkJ3Wpci8pUsrexhU8al9IL868pMz9qWX45fR9oRv0cP6', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `personnel_id` (`personnel_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`id`),
  ADD CONSTRAINT `events_ibfk_4` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`),
  ADD CONSTRAINT `events_ibfk_5` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `personnel_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
