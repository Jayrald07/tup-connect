-- Project: TUP Connect
-- Created On: Nov. 11, 2021

CREATE DATABASE db_tupconnect
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE db_tupconnect;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2022 at 03:10 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tupconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `announcement_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_block`
--

CREATE TABLE `tbl_block` (
  `block_id` varchar(15) NOT NULL,
  `block_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campus`
--

CREATE TABLE `tbl_campus` (
  `campus_id` int(11) NOT NULL,
  `campus_name` varchar(60) NOT NULL,
  `campus_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_campus`
--

INSERT INTO `tbl_campus` (`campus_id`, `campus_name`, `campus_code`) VALUES
(1, 'Technological University of the Philippines - Manila', 'TUPM'),
(2, 'Technological University of the Philippines - Taguig', 'TUPT'),
(3, 'Technological University of the Philippines - Cavite', 'TUPC'),
(4, 'Technological University of the Philippines - Visayas', 'TUPV');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campus_organization`
--

CREATE TABLE `tbl_campus_organization` (
  `co_id` varchar(15) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `organization_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(1, 'Engineering'),
(2, 'Programming'),
(3, 'Arts'),
(4, 'Education'),
(5, 'Music'),
(6, 'Film'),
(7, 'Mathematics'),
(8, 'Science'),
(9, 'Memes'),
(10, 'Physical Sports'),
(11, 'Games'),
(12, 'Books');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college`
--

CREATE TABLE `tbl_college` (
  `college_id` int(11) NOT NULL,
  `college_name` varchar(60) NOT NULL,
  `college_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_college`
--

INSERT INTO `tbl_college` (`college_id`, `college_name`, `college_code`) VALUES
(1, 'College of Science', 'COS'),
(2, 'College of Fine Arts', 'CAFA'),
(3, 'College of Engineering', 'COE'),
(4, 'College of Industrial Education', 'CIE'),
(5, 'College of Industrial Technology', 'CIT'),
(6, 'College of Liberal Arts', 'CLA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `comment_id` varchar(15) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_up_vote` int(3) NOT NULL,
  `comment_down_vote` int(3) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `date_time_stamp` datetime NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_image`
--

CREATE TABLE `tbl_comment_image` (
  `comment_image_id` varchar(15) NOT NULL,
  `comment_id` varchar(15) NOT NULL,
  `comment_image_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_reply`
--

CREATE TABLE `tbl_comment_reply` (
  `comment_reply_id` varchar(15) NOT NULL,
  `comment_id` varchar(15) NOT NULL,
  `reply_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment_report`
--

CREATE TABLE `tbl_comment_report` (
  `comment_report_id` varchar(15) NOT NULL,
  `comment_id` varchar(15) NOT NULL,
  `report_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(60) NOT NULL,
  `course_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_name`, `course_code`) VALUES
(1, 'Bachelor of Science in Civil Engineering', 'BSCE'),
(2, 'Bachelor of Science in Electrical Engineering', 'BSEE'),
(3, 'Bachelor of Science in Mechanical Engineering', 'BSME'),
(4, 'Bachelor of Science in Electronics Engineering', 'BSEE'),
(5, 'Bachelor of Applied Science in Laboratory Technology', 'BASLT'),
(6, 'Bachelor of Science in Computer Science', 'BSCS'),
(7, 'Bachelor of Science in Environmental Science', 'BSES'),
(8, 'Bachelor of Science in Information System', 'BSIS'),
(9, 'Bachelor of Science in Information Technology', 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum`
--

CREATE TABLE `tbl_forum` (
  `forum_id` varchar(15) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_freedom_wall`
--

CREATE TABLE `tbl_freedom_wall` (
  `fw_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `post_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gender`
--

CREATE TABLE `tbl_gender` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_gender`
--

INSERT INTO `tbl_gender` (`gender_id`, `gender`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Lesbian'),
(4, 'Gay'),
(5, 'Bisexual'),
(6, 'Transgender'),
(7, 'Queer'),
(8, 'Questioning'),
(9, 'Intersex'),
(10, 'Asexual'),
(11, 'Ally'),
(12, 'Pansexual'),
(13, 'Demisexual');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `group_id` varchar(15) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `group_owner` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_user`
--

CREATE TABLE `tbl_group_user` (
  `group_user_id` int(11) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `role_id` varchar(15) NOT NULL,
  `group_id` varchar(15) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lobby`
--

CREATE TABLE `tbl_lobby` (
  `lobby_id` varchar(15) NOT NULL,
  `group_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `college_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lobby_post`
--

CREATE TABLE `tbl_lobby_post` (
  `lobby_post_id` int(11) NOT NULL,
  `lobby_id` varchar(15) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization`
--

CREATE TABLE `tbl_organization` (
  `organization_id` varchar(15) NOT NULL,
  `organization_name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `organization_image` varchar(100) NOT NULL,
  `organization_owner` varchar(15) NOT NULL,
  `organization_type` varchar(10) NOT NULL,
  `ref_id` int(5) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization_post`
--

CREATE TABLE `tbl_organization_post` (
  `organization_post_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `organization_id` varchar(15) NOT NULL,
  `post_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization_user`
--

CREATE TABLE `tbl_organization_user` (
  `ou_id` int(11) NOT NULL,
  `organization_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pass_manage`
--

CREATE TABLE `tbl_pass_manage` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `hash_expiry` varchar(50) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `post_id` varchar(15) NOT NULL,
  `post_text` varchar(2000) NOT NULL,
  `post_up_vote` int(3) NOT NULL,
  `post_down_vote` int(3) NOT NULL,
  `date_time_stamp` datetime NOT NULL,
  `status` varchar(15) NOT NULL,
  `report_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_image`
--

CREATE TABLE `tbl_post_image` (
  `post_image_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `post_image_path` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_report`
--

CREATE TABLE `tbl_post_report` (
  `post_report_id` varchar(15) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `report_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_report`
--

CREATE TABLE `tbl_report` (
  `report_id` varchar(15) NOT NULL,
  `report_description` varchar(100) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `member_request` tinyint(1) NOT NULL,
  `reported_content` tinyint(1) NOT NULL,
  `manage_roles` tinyint(1) NOT NULL,
  `manage_permission` tinyint(1) NOT NULL,
  `id_ref` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` varchar(15) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `status` varchar(15) NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `hash_expiry` varchar(50) NOT NULL,
  `pass_status` enum('1','0') NOT NULL,
  `date_created` varchar(40) NOT NULL,
  `is_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_email`, `user_name`, `user_password`, `user_detail_id`, `status`, `hash_key`, `hash_expiry`, `pass_status`, `date_created`, `is_admin`) VALUES
('rl8DBaEbVy1k9oc', 'admin.admin@tup.edu.ph', 'admin', 'admin123', 'ghktiHAwfTeRaK2', 'registered', 'e7a36746e0df99976d149cdf2258bb6872ae366345311459ed3e27585e9301d4', '2022-02-05 14:0', '1', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_block`
--

CREATE TABLE `tbl_user_block` (
  `user_block_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `blocked_user_id` varchar(15) NOT NULL,
  `block_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_cor`
--

CREATE TABLE `tbl_user_cor` (
  `user_cor_id` varchar(15) NOT NULL,
  `cor_path` varchar(50) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_detail`
--

CREATE TABLE `tbl_user_detail` (
  `user_detail_id` varchar(15) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `year_level` tinyint(4) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `college_id` int(11) NOT NULL,
  `campus_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_cor_id` varchar(15) NOT NULL,
  `image_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user_detail`
--

INSERT INTO `tbl_user_detail` (`user_detail_id`, `first_name`, `middle_name`, `last_name`, `birthday`, `year_level`, `gender_id`, `college_id`, `campus_id`, `course_id`, `user_cor_id`, `image_path`) VALUES
('ghktiHAwfTeRaK2', 'Jayrald', 'Bulleser', 'Empino', '2001-04-27', 3, 1, 1, 1, 1, 'AAA', 'XFSd0uAIgGJYzpl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_interest`
--

CREATE TABLE `tbl_user_interest` (
  `user_interest_id` int(11) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_post`
--

CREATE TABLE `tbl_user_post` (
  `user_post_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `reference_id` varchar(15) NOT NULL,
  `type` int(1) NOT NULL,
  `date_time_stamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_report`
--

CREATE TABLE `tbl_user_report` (
  `user_report_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `reported_user_id` varchar(15) NOT NULL,
  `report_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_verification`
--

CREATE TABLE `tbl_user_verification` (
  `user_verification_id` int(11) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `code` varchar(6) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_vote`
--

CREATE TABLE `tbl_user_vote` (
  `user_vote_id` int(11) NOT NULL,
  `post_id` varchar(15) NOT NULL,
  `user_detail_id` varchar(15) NOT NULL,
  `user_vote` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `tbl_block`
--
ALTER TABLE `tbl_block`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `tbl_campus`
--
ALTER TABLE `tbl_campus`
  ADD PRIMARY KEY (`campus_id`);

--
-- Indexes for table `tbl_campus_organization`
--
ALTER TABLE `tbl_campus_organization`
  ADD PRIMARY KEY (`co_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_college`
--
ALTER TABLE `tbl_college`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_comment_image`
--
ALTER TABLE `tbl_comment_image`
  ADD PRIMARY KEY (`comment_image_id`);

--
-- Indexes for table `tbl_comment_reply`
--
ALTER TABLE `tbl_comment_reply`
  ADD PRIMARY KEY (`comment_reply_id`);

--
-- Indexes for table `tbl_comment_report`
--
ALTER TABLE `tbl_comment_report`
  ADD PRIMARY KEY (`comment_report_id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_forum`
--
ALTER TABLE `tbl_forum`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `tbl_freedom_wall`
--
ALTER TABLE `tbl_freedom_wall`
  ADD PRIMARY KEY (`fw_id`);

--
-- Indexes for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `tbl_group_user`
--
ALTER TABLE `tbl_group_user`
  ADD PRIMARY KEY (`group_user_id`);

--
-- Indexes for table `tbl_lobby`
--
ALTER TABLE `tbl_lobby`
  ADD PRIMARY KEY (`lobby_id`);

--
-- Indexes for table `tbl_lobby_post`
--
ALTER TABLE `tbl_lobby_post`
  ADD PRIMARY KEY (`lobby_post_id`);

--
-- Indexes for table `tbl_organization`
--
ALTER TABLE `tbl_organization`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `tbl_organization_post`
--
ALTER TABLE `tbl_organization_post`
  ADD PRIMARY KEY (`organization_post_id`);

--
-- Indexes for table `tbl_organization_user`
--
ALTER TABLE `tbl_organization_user`
  ADD PRIMARY KEY (`ou_id`);

--
-- Indexes for table `tbl_pass_manage`
--
ALTER TABLE `tbl_pass_manage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_post_image`
--
ALTER TABLE `tbl_post_image`
  ADD PRIMARY KEY (`post_image_id`);

--
-- Indexes for table `tbl_post_report`
--
ALTER TABLE `tbl_post_report`
  ADD PRIMARY KEY (`post_report_id`);

--
-- Indexes for table `tbl_report`
--
ALTER TABLE `tbl_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_block`
--
ALTER TABLE `tbl_user_block`
  ADD PRIMARY KEY (`user_block_id`);

--
-- Indexes for table `tbl_user_cor`
--
ALTER TABLE `tbl_user_cor`
  ADD PRIMARY KEY (`user_cor_id`);

--
-- Indexes for table `tbl_user_detail`
--
ALTER TABLE `tbl_user_detail`
  ADD PRIMARY KEY (`user_detail_id`);

--
-- Indexes for table `tbl_user_interest`
--
ALTER TABLE `tbl_user_interest`
  ADD PRIMARY KEY (`user_interest_id`);

--
-- Indexes for table `tbl_user_post`
--
ALTER TABLE `tbl_user_post`
  ADD PRIMARY KEY (`user_post_id`);

--
-- Indexes for table `tbl_user_report`
--
ALTER TABLE `tbl_user_report`
  ADD PRIMARY KEY (`user_report_id`);

--
-- Indexes for table `tbl_user_verification`
--
ALTER TABLE `tbl_user_verification`
  ADD PRIMARY KEY (`user_verification_id`);

--
-- Indexes for table `tbl_user_vote`
--
ALTER TABLE `tbl_user_vote`
  ADD PRIMARY KEY (`user_vote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_campus`
--
ALTER TABLE `tbl_campus`
  MODIFY `campus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_college`
--
ALTER TABLE `tbl_college`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_group_user`
--
ALTER TABLE `tbl_group_user`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_lobby_post`
--
ALTER TABLE `tbl_lobby_post`
  MODIFY `lobby_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tbl_organization_user`
--
ALTER TABLE `tbl_organization_user`
  MODIFY `ou_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_pass_manage`
--
ALTER TABLE `tbl_pass_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_post_image`
--
ALTER TABLE `tbl_post_image`
  MODIFY `post_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_user_interest`
--
ALTER TABLE `tbl_user_interest`
  MODIFY `user_interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_user_post`
--
ALTER TABLE `tbl_user_post`
  MODIFY `user_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_user_verification`
--
ALTER TABLE `tbl_user_verification`
  MODIFY `user_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tbl_user_vote`
--
ALTER TABLE `tbl_user_vote`
  MODIFY `user_vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;