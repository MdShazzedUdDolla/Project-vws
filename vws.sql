-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 02:45 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vws`
--

-- --------------------------------------------------------

--
-- Table structure for table `aerobic_cardiovascular_fitness`
--

CREATE TABLE `aerobic_cardiovascular_fitness` (
  `ACF_AUTO_KEY` int(11) NOT NULL,
  `FNR_AUTO_KEY` int(11) NOT NULL,
  `time_completed` float NOT NULL,
  `RPE` decimal(5,2) NOT NULL,
  `sex` int(11) NOT NULL,
  `PostWalkHeartRate` int(11) NOT NULL,
  `VO2` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `ARL_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `article_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `abstract` varchar(401) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `basic_info`
--

CREATE TABLE `basic_info` (
  `BSI_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `bloodPressure_sys` int(11) NOT NULL,
  `bloodPressure_dias` int(5) NOT NULL,
  `weight` float NOT NULL,
  `Resting_Heart_Rate` int(5) NOT NULL,
  `date_of_birth` date NOT NULL,
  `TIME_ADD_UPDATE` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consent_form_questions`
--

CREATE TABLE `consent_form_questions` (
  `CNS_AUTO_KEY` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `consent_form_questions`
--

INSERT INTO `consent_form_questions` (`CNS_AUTO_KEY`, `question`) VALUES
(1, 'I give permission for the use of direct quotations'),
(2, 'I give permission for the research team to contact me for future research studies'),
(3, 'I understand that I have the freedom to withdraw from the research study by February 28, 2023. All information collected from you within this study will be deleted'),
(4, 'I understand that no waiver of rights is sought'),
(5, 'I understand that I can keep a copy of the signed and dated consent form'),
(6, 'I understand that the information will be kept confidential within the limits of the law'),
(7, 'I agree to participate in the research study'),
(8, 'I give permission for the use of my data'),
(9, 'I understand that I can contact the UPEI Research Ethics Board at (902) 620-5104, or by email at researchcompliance@upei.ca '),
(10, 'I understand that the program will take place in a group setting so information shared within the group will remain confidential'),
(11, 'participants are reminded to keep information shared during group sessions confidential but that the research team cannot guarantee the confidentiality of group sessions');

-- --------------------------------------------------------

--
-- Table structure for table `consent_record`
--

CREATE TABLE `consent_record` (
  `CNR_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `TIME_ADD_UPDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `consentSigned` tinyint(4) NOT NULL DEFAULT 0,
  `receive_result_email` tinyint(4) NOT NULL DEFAULT 0,
  `email_result` varchar(100) DEFAULT NULL,
  `receive_mail_result` tinyint(1) NOT NULL DEFAULT 0,
  `mail_address` text DEFAULT NULL,
  `sig_participant` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `functional_capacity_gpsex`
-- (See below for the actual view)
--
CREATE TABLE `functional_capacity_gpsex` (
`S_AUTO_KEY` int(11)
,`sex` varchar(20)
,`bloodPressure_sys` decimal(14,4)
,`bloodPressure_dias` decimal(14,4)
,`weight` double
,`Resting_Heart_Rate` decimal(14,4)
,`Lback_scratch` decimal(14,4)
,`Rback_scratch` decimal(14,4)
,`Rgrip_strength` decimal(14,4)
,`Lgrip_strength` decimal(14,4)
,`Plank_Duration` decimal(14,4)
,`Plank_RPE` decimal(14,4)
,`Lankle_test` decimal(14,4)
,`Rankle_test` decimal(14,4)
,`tandon_eye_open` decimal(14,4)
,`tandon_eye_close` decimal(14,4)
,`RLeg_eye_open` decimal(14,4)
,`RLeg_eye_close` decimal(14,4)
,`LLeg_eye_open` decimal(14,4)
,`LLeg_eye_close` decimal(14,4)
,`total_eye_open` decimal(14,4)
,`total_eye_close` decimal(14,4)
,`time_completed` double
,`RPE` decimal(9,6)
,`VO2` decimal(10,6)
,`PostWalkHeartRate` decimal(14,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `functional_capacity_gpsexdate`
-- (See below for the actual view)
--
CREATE TABLE `functional_capacity_gpsexdate` (
`S_AUTO_KEY` int(11)
,`TIME_ADD_UPDATE` timestamp
,`sex` varchar(20)
,`Systolic_Blood_Pressure` decimal(14,4)
,`Diastolic_Blood_Pressure` decimal(14,4)
,`weight` double
,`Resting_Heart_Rate` decimal(14,4)
,`Left_Back_Scratch` decimal(14,4)
,`Right_Back_Scratch` decimal(14,4)
,`Right_Grip_strength` decimal(14,4)
,`Left_Grip_Strength` decimal(14,4)
,`Plank_Duration` decimal(14,4)
,`Plank_RPE` decimal(14,4)
,`Left_Ankle_Test` decimal(14,4)
,`Right_Ankle_Test` decimal(14,4)
,`Tandon_Eye_Open` decimal(14,4)
,`Tandon_Eye_Close` decimal(14,4)
,`Right_Leg_eye_open` decimal(14,4)
,`Right_Leg_Eye_Close` decimal(14,4)
,`Left_Leg_Eye_Open` decimal(14,4)
,`Left_Leg_Eye_Close` decimal(14,4)
,`Total_Eye_Open` decimal(14,4)
,`Total_Eye_Close` decimal(14,4)
,`Time_Completed_1Mile` double
,`RPE` decimal(9,6)
,`VO2` decimal(10,6)
,`Post_Walk_Heartrate` decimal(14,4)
,`DATE_ENTRY` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `functional_capacity_gpuser`
-- (See below for the actual view)
--
CREATE TABLE `functional_capacity_gpuser` (
`USR_AUTO_KEY` int(11)
,`first_name` varchar(256)
,`last_name` varchar(256)
,`bloodPressure_sys` decimal(14,4)
,`bloodPressure_dias` decimal(14,4)
,`weight` double
,`Resting_Heart_Rate` decimal(14,4)
,`Lback_scratch` decimal(14,4)
,`Rback_scratch` decimal(14,4)
,`Rgrip_strength` decimal(14,4)
,`Lgrip_strength` decimal(14,4)
,`Plank_Duration` decimal(14,4)
,`Plank_RPE` decimal(14,4)
,`Lankle_test` decimal(14,4)
,`Rankle_test` decimal(14,4)
,`tandon_eye_open` decimal(14,4)
,`tandon_eye_close` decimal(14,4)
,`RLeg_eye_open` decimal(14,4)
,`RLeg_eye_close` decimal(14,4)
,`LLeg_eye_open` decimal(14,4)
,`LLeg_eye_close` decimal(14,4)
,`total_eye_open` decimal(14,4)
,`total_eye_close` decimal(14,4)
,`time_completed` double
,`RPE` decimal(9,6)
,`VO2` decimal(10,6)
,`PostWalkHeartRate` decimal(14,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `functional_capacity_gpuser_date`
-- (See below for the actual view)
--
CREATE TABLE `functional_capacity_gpuser_date` (
`USR_AUTO_KEY` int(11)
,`TIME_ADD_UPDATE` timestamp
,`first_name` varchar(256)
,`last_name` varchar(256)
,`username` varchar(224)
,`Systolic_Blood_Pressure` decimal(14,4)
,`Diastolic_Blood_Pressure` decimal(14,4)
,`Weight` double
,`Resting_Heart_Rate` decimal(14,4)
,`Left_Back_Scratch` decimal(14,4)
,`Right_Back_scratch` decimal(14,4)
,`Right_Grip_strength` decimal(14,4)
,`Left_Grip_Strength` decimal(14,4)
,`Plank_Duration` decimal(14,4)
,`Plank_RPE` decimal(14,4)
,`Left_Ankle_Test` decimal(14,4)
,`Right_Ankle_Test` decimal(14,4)
,`Tandon_Eye_Open` decimal(14,4)
,`Tandon_Eye_Close` decimal(14,4)
,`Right_Leg_Eye_Open` decimal(14,4)
,`Right_Leg_eye_close` decimal(14,4)
,`Left_Leg_Eye_Open` decimal(14,4)
,`Left_Leg_Eye_Close` decimal(14,4)
,`Total_Eye_Open` decimal(14,4)
,`Total_Eye_Close` decimal(14,4)
,`Time_Completed_1Mile` double
,`RPE` decimal(9,6)
,`VO2` decimal(10,6)
,`Post_Walk_Heartrate` decimal(14,4)
,`DATE_ENTRY` date
);

-- --------------------------------------------------------

--
-- Table structure for table `functional_capacity_questions`
--

CREATE TABLE `functional_capacity_questions` (
  `FNC_AUTO_KEY` int(11) NOT NULL,
  `parameter` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `functional_capacity_record`
--

CREATE TABLE `functional_capacity_record` (
  `FNR_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `BSI_AUTO_KEY` int(11) NOT NULL,
  `TIME_ADD_UPDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `Lback_scratch` int(11) NOT NULL,
  `Rback_scratch` int(11) NOT NULL,
  `Lgrip_strength` int(11) NOT NULL,
  `Rgrip_strength` int(11) NOT NULL,
  `Plank_Duration` int(11) NOT NULL,
  `Plank_RPE` int(11) NOT NULL,
  `Lankle_test` int(11) NOT NULL,
  `Rankle_test` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `link_user_questions`
--

CREATE TABLE `link_user_questions` (
  `LUQ_AUTO_KEY` int(11) NOT NULL,
  `SCQ_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `security_ans` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

CREATE TABLE `password_reset_temp` (
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perceived_stress_questions`
--

CREATE TABLE `perceived_stress_questions` (
  `PSQ_AUTO_KEY` int(11) NOT NULL,
  `Question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perceived_stress_questions`
--

INSERT INTO `perceived_stress_questions` (`PSQ_AUTO_KEY`, `Question`) VALUES
(1, 'In the last month, how often have you been upset because of something that happened unexpectedly?'),
(2, 'In the last month, how often have you felt that you were unable to control the important things in your life?'),
(3, 'In the last month, how often have you felt nervous and stressed?'),
(4, 'In the last month, how often have you felt confident about your ability to handle your personal problems?'),
(5, 'In the last month, how often have you felt that things were going your way?'),
(6, 'In the last month, how often have you found that you could not cope with all the things that you had to do?'),
(7, 'In the last month, how often have you been able to control irritations in your life?'),
(8, 'In the last month, how often have you felt that you were on top of things?'),
(9, 'In the last month, how often have you been angered because of things that happened that were outside of your control?'),
(10, 'In the last month, how often have you felt difficulties were piling up so high that you could not overcome them?');

-- --------------------------------------------------------

--
-- Table structure for table `perceived_stress_record`
--

CREATE TABLE `perceived_stress_record` (
  `PSR_AUTO_KEY` int(11) NOT NULL,
  `USR_AUTO_KEY` int(11) NOT NULL,
  `Q1_ans` int(11) NOT NULL,
  `Q2_ans` int(11) NOT NULL,
  `Q3_ans` int(11) NOT NULL,
  `Q4_ans` int(11) NOT NULL,
  `Q5_ans` int(11) NOT NULL,
  `Q6_ans` int(11) NOT NULL,
  `Q7_ans` int(11) NOT NULL,
  `Q8_ans` int(11) NOT NULL,
  `Q9_ans` int(11) NOT NULL,
  `Q10_ans` int(11) NOT NULL,
  `calculatedResult` int(3) NOT NULL,
  `TIME_ADD_UPDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `perceived_stress_record_gpuser`
-- (See below for the actual view)
--
CREATE TABLE `perceived_stress_record_gpuser` (
`USR_AUTO_KEY` int(11)
,`TIME_ADD_UPDATE` timestamp
,`first_name` varchar(256)
,`last_name` varchar(256)
,`username` varchar(224)
,`Q1_ans` decimal(11,0)
,`Q2_ans` decimal(11,0)
,`Q3_ans` decimal(11,0)
,`Q4_ans` decimal(11,0)
,`Q5_ans` decimal(11,0)
,`Q6_ans` decimal(11,0)
,`Q7_ans` decimal(11,0)
,`Q8_ans` decimal(11,0)
,`Q9_ans` decimal(11,0)
,`Q10_ans` decimal(11,0)
,`calculatedResult` decimal(13,2)
,`DATE_ENTRY` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `perceived_stress_record_gpuser_date`
-- (See below for the actual view)
--
CREATE TABLE `perceived_stress_record_gpuser_date` (
`USR_AUTO_KEY` int(11)
,`TIME_ADD_UPDATE` timestamp
,`first_name` varchar(256)
,`last_name` varchar(256)
,`username` varchar(224)
,`Q1_ans` decimal(11,0)
,`Q2_ans` decimal(11,0)
,`Q3_ans` decimal(11,0)
,`Q4_ans` decimal(11,0)
,`Q5_ans` decimal(11,0)
,`Q6_ans` decimal(11,0)
,`Q7_ans` decimal(11,0)
,`Q8_ans` decimal(11,0)
,`Q9_ans` decimal(11,0)
,`Q10_ans` decimal(11,0)
,`calculatedResult` decimal(13,2)
,`DATE_ENTRY` date
);

-- --------------------------------------------------------

--
-- Table structure for table `perceived_stress_scale`
--

CREATE TABLE `perceived_stress_scale` (
  `PSS_AUTO_KEY` int(11) NOT NULL,
  `Scale` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Dumping data for table `perceived_stress_scale`
--

INSERT INTO `perceived_stress_scale` (`PSS_AUTO_KEY`, `Scale`, `Description`) VALUES
(1, 0, 'never'),
(2, 1, 'almost'),
(3, 2, 'sometimes'),
(4, 3, 'fairly'),
(5, 4, 'often');


-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE `security_questions` (
  `SCQ_AUTO_KEY` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`SCQ_AUTO_KEY`, `question`) VALUES
(1, 'In what city were you born?'),
(2, 'What is the name of your favorite pet?'),
(3, 'What is your mother\'s maiden name?'),
(4, 'What high school did you attend?'),
(5, 'What was the name of your elementary school?'),
(6, 'What was the make of your first car?'),
(7, 'What was your favorite food as a child?'),
(8, 'Where did you meet your spouse?'),
(9, 'What year was your father (or mother) born?');

-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

CREATE TABLE `sex` (
  `S_AUTO_KEY` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` (`S_AUTO_KEY`, `name`) VALUES
(1, 'male'),
(2, 'female'),
(5, 'binary');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `TRM_AUTO_KEY` int(11) NOT NULL,
  `term` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`TRM_AUTO_KEY`, `term`) VALUES
(1, 'Fall'),
(2, 'Winter'),
(3, 'Summer');

-- --------------------------------------------------------

--
-- Table structure for table `timed_balancing_test`
--

CREATE TABLE `timed_balancing_test` (
  `TBT_AUTO_KEY` int(11) NOT NULL,
  `FNR_AUTO_KEY` int(11) NOT NULL,
  `tandon_eye_open` int(11) NOT NULL,
  `tandon_eye_close` int(11) NOT NULL,
  `LLeg_eye_open` int(11) NOT NULL,
  `LLeg_eye_close` int(11) NOT NULL,
  `RLeg_eye_open` int(11) NOT NULL,
  `RLeg_eye_close` int(11) NOT NULL,
  `total_eye_open` int(11) NOT NULL,
  `total_eye_close` int(11) NOT NULL,
  `TIME_ADD_UPDATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USR_AUTO_KEY` int(11) NOT NULL,
  `username` varchar(224) NOT NULL,
  `username_enc` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `email_hash_Index` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `privilege_level` int(1) NOT NULL DEFAULT 3,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `TIME_ADD_UPDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `UST_AUTO_KEY` int(11) NOT NULL,
  `privilege_name` varchar(50) NOT NULL,
  `privilege_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`UST_AUTO_KEY`, `privilege_name`, `privilege_description`) VALUES
(1, 'admin', 'admin user '),
(2, 'physician', 'physicians'),
(3, 'patients', 'patient users\r\n');

-- --------------------------------------------------------

--
-- Structure for view `functional_capacity_gpsex`
--
DROP TABLE IF EXISTS `functional_capacity_gpsex`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `functional_capacity_gpsex`  AS SELECT `af`.`sex` AS `S_AUTO_KEY`, (select `sex`.`name` from `sex` where `af`.`sex` = `sex`.`S_AUTO_KEY`) AS `sex`, avg(`bi`.`bloodPressure_sys`) AS `bloodPressure_sys`, avg(`bi`.`bloodPressure_dias`) AS `bloodPressure_dias`, avg(`bi`.`weight`) AS `weight`, avg(`bi`.`Resting_Heart_Rate`) AS `Resting_Heart_Rate`, avg(`fc`.`Lback_scratch`) AS `Lback_scratch`, avg(`fc`.`Rback_scratch`) AS `Rback_scratch`, avg(`fc`.`Rgrip_strength`) AS `Rgrip_strength`, avg(`fc`.`Lgrip_strength`) AS `Lgrip_strength`, avg(`fc`.`Plank_Duration`) AS `Plank_Duration`, avg(`fc`.`Plank_RPE`) AS `Plank_RPE`, avg(`fc`.`Lankle_test`) AS `Lankle_test`, avg(`fc`.`Rankle_test`) AS `Rankle_test`, avg(`tb`.`tandon_eye_open`) AS `tandon_eye_open`, avg(`tb`.`tandon_eye_close`) AS `tandon_eye_close`, avg(`tb`.`RLeg_eye_open`) AS `RLeg_eye_open`, avg(`tb`.`RLeg_eye_close`) AS `RLeg_eye_close`, avg(`tb`.`LLeg_eye_open`) AS `LLeg_eye_open`, avg(`tb`.`LLeg_eye_close`) AS `LLeg_eye_close`, avg(`tb`.`total_eye_open`) AS `total_eye_open`, avg(`tb`.`total_eye_close`) AS `total_eye_close`, avg(`af`.`time_completed`) AS `time_completed`, avg(`af`.`RPE`) AS `RPE`, avg(`af`.`VO2`) AS `VO2`, avg(`af`.`PostWalkHeartRate`) AS `PostWalkHeartRate` FROM (((`basic_info` `bi` join `functional_capacity_record` `fc`) join `timed_balancing_test` `tb`) join `aerobic_cardiovascular_fitness` `af`) WHERE `bi`.`BSI_AUTO_KEY` = `fc`.`BSI_AUTO_KEY` AND `tb`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` AND `af`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` GROUP BY `af`.`sex` ;

-- --------------------------------------------------------

--
-- Structure for view `functional_capacity_gpsexdate`
--
DROP TABLE IF EXISTS `functional_capacity_gpsexdate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `functional_capacity_gpsexdate`  AS SELECT `af`.`sex` AS `S_AUTO_KEY`, `bi`.`TIME_ADD_UPDATE` AS `TIME_ADD_UPDATE`, (select `sex`.`name` from `sex` where `af`.`sex` = `sex`.`S_AUTO_KEY`) AS `sex`, avg(`bi`.`bloodPressure_sys`) AS `Systolic_Blood_Pressure`, avg(`bi`.`bloodPressure_dias`) AS `Diastolic_Blood_Pressure`, avg(`bi`.`weight`) AS `weight`, avg(`bi`.`Resting_Heart_Rate`) AS `Resting_Heart_Rate`, avg(`fc`.`Lback_scratch`) AS `Left_Back_Scratch`, avg(`fc`.`Rback_scratch`) AS `Right_Back_Scratch`, avg(`fc`.`Rgrip_strength`) AS `Right_Grip_strength`, avg(`fc`.`Lgrip_strength`) AS `Left_Grip_Strength`, avg(`fc`.`Plank_Duration`) AS `Plank_Duration`, avg(`fc`.`Plank_RPE`) AS `Plank_RPE`, avg(`fc`.`Lankle_test`) AS `Left_Ankle_Test`, avg(`fc`.`Rankle_test`) AS `Right_Ankle_Test`, avg(`tb`.`tandon_eye_open`) AS `Tandon_Eye_Open`, avg(`tb`.`tandon_eye_close`) AS `Tandon_Eye_Close`, avg(`tb`.`RLeg_eye_open`) AS `Right_Leg_eye_open`, avg(`tb`.`RLeg_eye_close`) AS `Right_Leg_Eye_Close`, avg(`tb`.`LLeg_eye_open`) AS `Left_Leg_Eye_Open`, avg(`tb`.`LLeg_eye_close`) AS `Left_Leg_Eye_Close`, avg(`tb`.`total_eye_open`) AS `Total_Eye_Open`, avg(`tb`.`total_eye_close`) AS `Total_Eye_Close`, avg(`af`.`time_completed`) AS `Time_Completed_1Mile`, avg(`af`.`RPE`) AS `RPE`, avg(`af`.`VO2`) AS `VO2`, avg(`af`.`PostWalkHeartRate`) AS `Post_Walk_Heartrate`, cast(`bi`.`TIME_ADD_UPDATE` as date) AS `DATE_ENTRY` FROM (((`aerobic_cardiovascular_fitness` `af` join `functional_capacity_record` `fc`) join `timed_balancing_test` `tb`) join `basic_info` `bi`) WHERE `bi`.`BSI_AUTO_KEY` = `fc`.`BSI_AUTO_KEY` AND `tb`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` AND `af`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` GROUP BY `af`.`sex`, cast(`bi`.`TIME_ADD_UPDATE` as date) ;

-- --------------------------------------------------------

--
-- Structure for view `functional_capacity_gpuser`
--
DROP TABLE IF EXISTS `functional_capacity_gpuser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `functional_capacity_gpuser`  AS SELECT `bi`.`USR_AUTO_KEY` AS `USR_AUTO_KEY`, (select `u`.`first_name` from `user` `u` where `bi`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `first_name`, (select `u`.`last_name` from `user` `u` where `bi`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `last_name`, avg(`bi`.`bloodPressure_sys`) AS `bloodPressure_sys`, avg(`bi`.`bloodPressure_dias`) AS `bloodPressure_dias`, avg(`bi`.`weight`) AS `weight`, avg(`bi`.`Resting_Heart_Rate`) AS `Resting_Heart_Rate`, avg(`fc`.`Lback_scratch`) AS `Lback_scratch`, avg(`fc`.`Rback_scratch`) AS `Rback_scratch`, avg(`fc`.`Rgrip_strength`) AS `Rgrip_strength`, avg(`fc`.`Lgrip_strength`) AS `Lgrip_strength`, avg(`fc`.`Plank_Duration`) AS `Plank_Duration`, avg(`fc`.`Plank_RPE`) AS `Plank_RPE`, avg(`fc`.`Lankle_test`) AS `Lankle_test`, avg(`fc`.`Rankle_test`) AS `Rankle_test`, avg(`tb`.`tandon_eye_open`) AS `tandon_eye_open`, avg(`tb`.`tandon_eye_close`) AS `tandon_eye_close`, avg(`tb`.`RLeg_eye_open`) AS `RLeg_eye_open`, avg(`tb`.`RLeg_eye_close`) AS `RLeg_eye_close`, avg(`tb`.`LLeg_eye_open`) AS `LLeg_eye_open`, avg(`tb`.`LLeg_eye_close`) AS `LLeg_eye_close`, avg(`tb`.`total_eye_open`) AS `total_eye_open`, avg(`tb`.`total_eye_close`) AS `total_eye_close`, avg(`af`.`time_completed`) AS `time_completed`, avg(`af`.`RPE`) AS `RPE`, avg(`af`.`VO2`) AS `VO2`, avg(`af`.`PostWalkHeartRate`) AS `PostWalkHeartRate` FROM (((`basic_info` `bi` join `functional_capacity_record` `fc`) join `timed_balancing_test` `tb`) join `aerobic_cardiovascular_fitness` `af`) WHERE `bi`.`BSI_AUTO_KEY` = `fc`.`BSI_AUTO_KEY` AND `tb`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` AND `af`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` GROUP BY `bi`.`USR_AUTO_KEY` ;

-- --------------------------------------------------------

--
-- Structure for view `functional_capacity_gpuser_date`
--
DROP TABLE IF EXISTS `functional_capacity_gpuser_date`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `functional_capacity_gpuser_date`  AS SELECT `bi`.`USR_AUTO_KEY` AS `USR_AUTO_KEY`, `bi`.`TIME_ADD_UPDATE` AS `TIME_ADD_UPDATE`, (select `u`.`first_name` from `user` `u` where `bi`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `first_name`, (select `u`.`last_name` from `user` `u` where `bi`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `last_name`, (select `u`.`username` from `user` `u` where `bi`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `username`, avg(`bi`.`bloodPressure_sys`) AS `Systolic_Blood_Pressure`, avg(`bi`.`bloodPressure_dias`) AS `Diastolic_Blood_Pressure`, avg(`bi`.`weight`) AS `Weight`, avg(`bi`.`Resting_Heart_Rate`) AS `Resting_Heart_Rate`, avg(`fc`.`Lback_scratch`) AS `Left_Back_Scratch`, avg(`fc`.`Rback_scratch`) AS `Right_Back_scratch`, avg(`fc`.`Rgrip_strength`) AS `Right_Grip_strength`, avg(`fc`.`Lgrip_strength`) AS `Left_Grip_Strength`, avg(`fc`.`Plank_Duration`) AS `Plank_Duration`, avg(`fc`.`Plank_RPE`) AS `Plank_RPE`, avg(`fc`.`Lankle_test`) AS `Left_Ankle_Test`, avg(`fc`.`Rankle_test`) AS `Right_Ankle_Test`, avg(`tb`.`tandon_eye_open`) AS `Tandon_Eye_Open`, avg(`tb`.`tandon_eye_close`) AS `Tandon_Eye_Close`, avg(`tb`.`RLeg_eye_open`) AS `Right_Leg_Eye_Open`, avg(`tb`.`RLeg_eye_close`) AS `Right_Leg_eye_close`, avg(`tb`.`LLeg_eye_open`) AS `Left_Leg_Eye_Open`, avg(`tb`.`LLeg_eye_close`) AS `Left_Leg_Eye_Close`, avg(`tb`.`total_eye_open`) AS `Total_Eye_Open`, avg(`tb`.`total_eye_close`) AS `Total_Eye_Close`, avg(`af`.`time_completed`) AS `Time_Completed_1Mile`, avg(`af`.`RPE`) AS `RPE`, avg(`af`.`VO2`) AS `VO2`, avg(`af`.`PostWalkHeartRate`) AS `Post_Walk_Heartrate`, cast(`bi`.`TIME_ADD_UPDATE` as date) AS `DATE_ENTRY` FROM (((`basic_info` `bi` join `functional_capacity_record` `fc`) join `timed_balancing_test` `tb`) join `aerobic_cardiovascular_fitness` `af`) WHERE `bi`.`BSI_AUTO_KEY` = `fc`.`BSI_AUTO_KEY` AND `tb`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` AND `af`.`FNR_AUTO_KEY` = `fc`.`FNR_AUTO_KEY` GROUP BY `bi`.`USR_AUTO_KEY`, cast(`bi`.`TIME_ADD_UPDATE` as date) ;

-- --------------------------------------------------------

--
-- Structure for view `perceived_stress_record_gpuser`
--
DROP TABLE IF EXISTS `perceived_stress_record_gpuser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `perceived_stress_record_gpuser`  AS SELECT `psr`.`USR_AUTO_KEY` AS `USR_AUTO_KEY`, `psr`.`TIME_ADD_UPDATE` AS `TIME_ADD_UPDATE`, (select `u`.`first_name` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `first_name`, (select `u`.`last_name` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `last_name`, (select `u`.`username` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `username`, round(avg(`psr`.`Q1_ans`),0) AS `Q1_ans`, round(avg(`psr`.`Q2_ans`),0) AS `Q2_ans`, round(avg(`psr`.`Q3_ans`),0) AS `Q3_ans`, round(avg(`psr`.`Q4_ans`),0) AS `Q4_ans`, round(avg(`psr`.`Q5_ans`),0) AS `Q5_ans`, round(avg(`psr`.`Q6_ans`),0) AS `Q6_ans`, round(avg(`psr`.`Q7_ans`),0) AS `Q7_ans`, round(avg(`psr`.`Q8_ans`),0) AS `Q8_ans`, round(avg(`psr`.`Q9_ans`),0) AS `Q9_ans`, round(avg(`psr`.`Q10_ans`),0) AS `Q10_ans`, round(avg(`psr`.`calculatedResult`),2) AS `calculatedResult`, cast(`psr`.`TIME_ADD_UPDATE` as date) AS `DATE_ENTRY` FROM `perceived_stress_record` AS `psr` GROUP BY `psr`.`USR_AUTO_KEY` ;

-- --------------------------------------------------------

--
-- Structure for view `perceived_stress_record_gpuser_date`
--
DROP TABLE IF EXISTS `perceived_stress_record_gpuser_date`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `perceived_stress_record_gpuser_date`  AS SELECT `psr`.`USR_AUTO_KEY` AS `USR_AUTO_KEY`, `psr`.`TIME_ADD_UPDATE` AS `TIME_ADD_UPDATE`, (select `u`.`first_name` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `first_name`, (select `u`.`last_name` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `last_name`, (select `u`.`username` from `user` `u` where `psr`.`USR_AUTO_KEY` = `u`.`USR_AUTO_KEY`) AS `username`, round(avg(`psr`.`Q1_ans`),0) AS `Q1_ans`, round(avg(`psr`.`Q2_ans`),0) AS `Q2_ans`, round(avg(`psr`.`Q3_ans`),0) AS `Q3_ans`, round(avg(`psr`.`Q4_ans`),0) AS `Q4_ans`, round(avg(`psr`.`Q5_ans`),0) AS `Q5_ans`, round(avg(`psr`.`Q6_ans`),0) AS `Q6_ans`, round(avg(`psr`.`Q7_ans`),0) AS `Q7_ans`, round(avg(`psr`.`Q8_ans`),0) AS `Q8_ans`, round(avg(`psr`.`Q9_ans`),0) AS `Q9_ans`, round(avg(`psr`.`Q10_ans`),0) AS `Q10_ans`, round(avg(`psr`.`calculatedResult`),2) AS `calculatedResult`, cast(`psr`.`TIME_ADD_UPDATE` as date) AS `DATE_ENTRY` FROM `perceived_stress_record` AS `psr` GROUP BY `psr`.`USR_AUTO_KEY`, cast(`psr`.`TIME_ADD_UPDATE` as date) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aerobic_cardiovascular_fitness`
--
ALTER TABLE `aerobic_cardiovascular_fitness`
  ADD PRIMARY KEY (`ACF_AUTO_KEY`),
  ADD KEY `functional_cap2_fk` (`FNR_AUTO_KEY`),
  ADD KEY `s_fk` (`sex`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ARL_AUTO_KEY`),
  ADD KEY `user_article` (`USR_AUTO_KEY`);

--
-- Indexes for table `basic_info`
--
ALTER TABLE `basic_info`
  ADD PRIMARY KEY (`BSI_AUTO_KEY`),
  ADD UNIQUE KEY `USR_AUTO_KEY` (`USR_AUTO_KEY`,`TIME_ADD_UPDATE`);

--
-- Indexes for table `consent_form_questions`
--
ALTER TABLE `consent_form_questions`
  ADD PRIMARY KEY (`CNS_AUTO_KEY`);

--
-- Indexes for table `consent_record`
--
ALTER TABLE `consent_record`
  ADD PRIMARY KEY (`CNR_AUTO_KEY`),
  ADD UNIQUE KEY `USR_AUTO_KEY` (`USR_AUTO_KEY`);

--
-- Indexes for table `functional_capacity_questions`
--
ALTER TABLE `functional_capacity_questions`
  ADD PRIMARY KEY (`FNC_AUTO_KEY`);

--
-- Indexes for table `functional_capacity_record`
--
ALTER TABLE `functional_capacity_record`
  ADD PRIMARY KEY (`FNR_AUTO_KEY`),
  ADD UNIQUE KEY `unique_record` (`USR_AUTO_KEY`,`TIME_ADD_UPDATE`) USING BTREE,
  ADD KEY `basic_info_fk` (`BSI_AUTO_KEY`);

--
-- Indexes for table `link_user_questions`
--
ALTER TABLE `link_user_questions`
  ADD PRIMARY KEY (`LUQ_AUTO_KEY`),
  ADD KEY `qts_fk` (`SCQ_AUTO_KEY`),
  ADD KEY `user1_f` (`USR_AUTO_KEY`);

--
-- Indexes for table `perceived_stress_questions`
--
ALTER TABLE `perceived_stress_questions`
  ADD PRIMARY KEY (`PSQ_AUTO_KEY`);

--
-- Indexes for table `perceived_stress_record`
--
ALTER TABLE `perceived_stress_record`
  ADD PRIMARY KEY (`PSR_AUTO_KEY`),
  ADD KEY `fk_user_psy` (`USR_AUTO_KEY`);

--
-- Indexes for table `perceived_stress_scale`
--
ALTER TABLE `perceived_stress_scale`
  ADD PRIMARY KEY (`PSS_AUTO_KEY`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`SCQ_AUTO_KEY`);

--
-- Indexes for table `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`S_AUTO_KEY`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`TRM_AUTO_KEY`);

--
-- Indexes for table `timed_balancing_test`
--
ALTER TABLE `timed_balancing_test`
  ADD PRIMARY KEY (`TBT_AUTO_KEY`),
  ADD UNIQUE KEY `FNR_AUTO_KEY` (`FNR_AUTO_KEY`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USR_AUTO_KEY`),
  ADD KEY `fk_privilege` (`privilege_level`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`UST_AUTO_KEY`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aerobic_cardiovascular_fitness`
--
ALTER TABLE `aerobic_cardiovascular_fitness`
  MODIFY `ACF_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `ARL_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_info`
--
ALTER TABLE `basic_info`
  MODIFY `BSI_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consent_form_questions`
--
ALTER TABLE `consent_form_questions`
  MODIFY `CNS_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `consent_record`
--
ALTER TABLE `consent_record`
  MODIFY `CNR_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `functional_capacity_questions`
--
ALTER TABLE `functional_capacity_questions`
  MODIFY `FNC_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `functional_capacity_record`
--
ALTER TABLE `functional_capacity_record`
  MODIFY `FNR_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `link_user_questions`
--
ALTER TABLE `link_user_questions`
  MODIFY `LUQ_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perceived_stress_questions`
--
ALTER TABLE `perceived_stress_questions`
  MODIFY `PSQ_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `perceived_stress_record`
--
ALTER TABLE `perceived_stress_record`
  MODIFY `PSR_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perceived_stress_scale`
--
ALTER TABLE `perceived_stress_scale`
  MODIFY `PSS_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `SCQ_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sex`
--
ALTER TABLE `sex`
  MODIFY `S_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `TRM_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timed_balancing_test`
--
ALTER TABLE `timed_balancing_test`
  MODIFY `TBT_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USR_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `UST_AUTO_KEY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aerobic_cardiovascular_fitness`
--
ALTER TABLE `aerobic_cardiovascular_fitness`
  ADD CONSTRAINT `functional_cap2_fk` FOREIGN KEY (`FNR_AUTO_KEY`) REFERENCES `functional_capacity_record` (`FNR_AUTO_KEY`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_fk` FOREIGN KEY (`sex`) REFERENCES `sex` (`S_AUTO_KEY`);

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `user_article` FOREIGN KEY (`USR_AUTO_KEY`) REFERENCES `user` (`USR_AUTO_KEY`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `basic_info`
--
ALTER TABLE `basic_info`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`USR_AUTO_KEY`) REFERENCES `user` (`USR_AUTO_KEY`);

--
-- Constraints for table `functional_capacity_record`
--
ALTER TABLE `functional_capacity_record`
  ADD CONSTRAINT `basic_info_fk` FOREIGN KEY (`BSI_AUTO_KEY`) REFERENCES `basic_info` (`BSI_AUTO_KEY`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_function_cap_fk` FOREIGN KEY (`USR_AUTO_KEY`) REFERENCES `user` (`USR_AUTO_KEY`);

--
-- Constraints for table `link_user_questions`
--
ALTER TABLE `link_user_questions`
  ADD CONSTRAINT `qts_fk` FOREIGN KEY (`SCQ_AUTO_KEY`) REFERENCES `security_questions` (`SCQ_AUTO_KEY`),
  ADD CONSTRAINT `user1_f` FOREIGN KEY (`USR_AUTO_KEY`) REFERENCES `user` (`USR_AUTO_KEY`) ON DELETE CASCADE;

--
-- Constraints for table `perceived_stress_record`
--
ALTER TABLE `perceived_stress_record`
  ADD CONSTRAINT `fk_user_psy` FOREIGN KEY (`USR_AUTO_KEY`) REFERENCES `user` (`USR_AUTO_KEY`) ON DELETE CASCADE;

--
-- Constraints for table `timed_balancing_test`
--
ALTER TABLE `timed_balancing_test`
  ADD CONSTRAINT `functional_cap_fk` FOREIGN KEY (`FNR_AUTO_KEY`) REFERENCES `functional_capacity_record` (`FNR_AUTO_KEY`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_privilege` FOREIGN KEY (`privilege_level`) REFERENCES `user_types` (`UST_AUTO_KEY`);
COMMIT;


CREATE DEFINER=`root`@`localhost` EVENT `e_daily` ON SCHEDULE EVERY 1 DAY STARTS '2023-02-07 21:15:21' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Saves total number of sessions then clears the table each day' DO DELETE from user where verified=0 or user.USR_AUTO_KEY in (SELECT cr.USR_AUTO_KEY from consent_record as cr where cr.consentSigned !=1 )

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
