-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2018 at 01:20 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbms_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Username` varchar(100) NOT NULL,
  `Password` char(32) NOT NULL,
  `Catagory` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--


-- --------------------------------------------------------

--
-- Table structure for table `allowed_batches`
--

CREATE TABLE IF NOT EXISTS `allowed_batches` (
  `Offer_ID` int(11) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Batch_year` int(11) NOT NULL,
  KEY `Offer_ID` (`Offer_ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowed_batches`
--


-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE IF NOT EXISTS `classroom` (
  `Building` varchar(100) NOT NULL,
  `Room_no.` int(11) NOT NULL,
  `Capacity` int(11) NOT NULL,
  PRIMARY KEY (`Building`,`Room_no.`),
  KEY `Room_no.` (`Room_no.`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`Building`, `Room_no.`, `Capacity`) VALUES
('B1', 1, 100),
('B2', 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `Course_ID` varchar(100) NOT NULL,
  `L` int(11) NOT NULL,
  `T` int(11) NOT NULL,
  `P` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  PRIMARY KEY (`Course_ID`),
  KEY `department` (`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`Course_ID`, `L`, `T`, `P`, `Name`, `Department`) VALUES
('CSL101', 2, 2, 2, 'DS', 'CSE'),
('CSL202', 3, 0, 1, 'AI', 'CSE'),
('EEL101', 1, 2, 2, 'EM', 'EE'),
('MEL101', 2, 1, 2, 'TOM', 'MECH');

-- --------------------------------------------------------

--
-- Table structure for table `dean`
--

CREATE TABLE IF NOT EXISTS `dean` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dean`
--


-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Name` varchar(100) NOT NULL,
  `Building` varchar(100) NOT NULL,
  PRIMARY KEY (`Name`),
  KEY `Building` (`Building`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Name`, `Building`) VALUES
('CSE', 'B1'),
('EE', 'B1'),
('MECH', 'B2');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `Faculty_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  PRIMARY KEY (`Faculty_ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Faculty_ID`, `Name`, `Department`) VALUES
(1, 'Mudgal', 'CSE'),
(2, 'Das', 'MECH'),
(3, 'ROY', 'EE');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_advisor`
--

CREATE TABLE IF NOT EXISTS `faculty_advisor` (
  `Faculty_ID` int(11) NOT NULL,
  `Batch_year` int(11) NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_advisor`
--


-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE IF NOT EXISTS `hod` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod`
--


-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `Course_ID` varchar(100) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  `section_ID` int(11) NOT NULL,
  `Minimum_CGPA` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Offer_ID`,`Course_ID`,`Faculty_ID`),
  KEY `section_att` (`section_ID`),
  KEY `Faculty_ID` (`Faculty_ID`),
  KEY `Course_ID` (`Course_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`Course_ID`, `Faculty_ID`, `Offer_ID`, `section_ID`, `Minimum_CGPA`) VALUES
('CSL101', 1, 1, 1, 0),
('MEL101', 2, 2, 1, 0),
('EEL101', 3, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

CREATE TABLE IF NOT EXISTS `prerequisites` (
  `Course_ID` varchar(100) NOT NULL,
  `Prerequisite_ID` varchar(100) NOT NULL,
  PRIMARY KEY (`Course_ID`,`Prerequisite_ID`),
  KEY `Prerequisite_ID` (`Prerequisite_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prerequisites`
--


-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `Section_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Building` varchar(100) NOT NULL,
  `Room_no` int(11) NOT NULL,
  `Time_slot_ID` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Semester` varchar(50) NOT NULL,
  PRIMARY KEY (`Section_ID`,`Semester`,`Year`),
  KEY `Time_slot_ID` (`Time_slot_ID`),
  KEY `Room_no` (`Room_no`),
  KEY `Building` (`Building`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`Section_ID`, `Building`, `Room_no`, `Time_slot_ID`, `Year`, `Semester`) VALUES
(1, 'B1', 1, 1, 2015, 'spring');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `Staff_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Faculty_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Staff_ID`),
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `staff`
--


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Batch_Year` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `Name`, `Department`, `Batch_Year`) VALUES
(1, 'Vinit', 'CSE', 2015),
(2, 'Shubham', 'MECH', 2015),
(3, 'Durgesh', 'EE', 2015);

-- --------------------------------------------------------

--
-- Table structure for table `takes`
--

CREATE TABLE IF NOT EXISTS `takes` (
  `Student_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  `Grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`Student_ID`,`Offer_ID`),
  KEY `Offer_ID` (`Offer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `takes`
--

INSERT INTO `takes` (`Student_ID`, `Offer_ID`, `Grade`) VALUES
(1, 1, NULL),
(2, 2, NULL),
(3, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `Offer_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Course_ID` varchar(100) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`Offer_ID`,`Student_ID`),
  KEY `Course_ID` (`Course_ID`),
  KEY `Faculty_ID` (`Faculty_ID`),
  KEY `Student_ID` (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--


-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE IF NOT EXISTS `time_slot` (
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  `Time_slot_ID` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  PRIMARY KEY (`Start_time`,`Time_slot_ID`,`day`),
  KEY `Time_slot_ID` (`Time_slot_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`Start_time`, `End_time`, `Time_slot_ID`, `day`) VALUES
('00:00:01', '00:00:02', 1, 'monday');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowed_batches`
--
ALTER TABLE `allowed_batches`
  ADD CONSTRAINT `allowed_batches_ibfk_2` FOREIGN KEY (`Department`) REFERENCES `department` (`Name`),
  ADD CONSTRAINT `allowed_batches_ibfk_1` FOREIGN KEY (`Offer_ID`) REFERENCES `offers` (`Offer_ID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`Name`);

--
-- Constraints for table `dean`
--
ALTER TABLE `dean`
  ADD CONSTRAINT `dean_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`Name`);

--
-- Constraints for table `faculty_advisor`
--
ALTER TABLE `faculty_advisor`
  ADD CONSTRAINT `faculty_advisor_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`);

--
-- Constraints for table `hod`
--
ALTER TABLE `hod`
  ADD CONSTRAINT `hod_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`),
  ADD CONSTRAINT `offers_ibfk_3` FOREIGN KEY (`section_ID`) REFERENCES `section` (`Section_ID`),
  ADD CONSTRAINT `offers_ibfk_4` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`);

--
-- Constraints for table `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`Prerequisite_ID`) REFERENCES `courses` (`Course_ID`),
  ADD CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`Building`) REFERENCES `classroom` (`Building`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`Room_no`) REFERENCES `classroom` (`Room_no.`),
  ADD CONSTRAINT `section_ibfk_4` FOREIGN KEY (`Time_slot_ID`) REFERENCES `time_slot` (`Time_slot_ID`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`Department`) REFERENCES `department` (`Name`);

--
-- Constraints for table `takes`
--
ALTER TABLE `takes`
  ADD CONSTRAINT `takes_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `takes_ibfk_2` FOREIGN KEY (`Offer_ID`) REFERENCES `offers` (`Offer_ID`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_5` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`),
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`Offer_ID`) REFERENCES `offers` (`Offer_ID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`Student_ID`) REFERENCES `section` (`Section_ID`),
  ADD CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`);
