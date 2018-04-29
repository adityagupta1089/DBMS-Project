-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2018 at 08:33 AM
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
-- Table structure for table `allowed_batches`
--

CREATE TABLE `allowed_batches` (
  `Offer_ID` int(11) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Batch_year` int(11) NOT NULL,
  Key `Offer_ID` (`Offer_ID`)
  key `Department` (`Department`)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowed_batches`
--


-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `Building` varchar(100) NOT NULL,
  `Room_no.` int(11) NOT NULL,
  `Capacity` int(11) NOT NULL,
  PRIMARY KEY (`Building`,`Room_no.`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classroom`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Course_ID` int(11) NOT NULL,
  `L` int(11) NOT NULL,
  `T` int(11) NOT NULL,
  `P` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  PRIMARY KEY (`Course_ID`),
  KEY  `department`(`department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `dean`
--

CREATE TABLE `dean` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dean`
--


-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Name` varchar(100) NOT NULL,
  `Building` varchar(100) NOT NULL,
  primary key(`Name`),
  KEY `Building` (`Building`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--


-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `Faculty_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  PRIMARY KEY (`Faculty_ID`),
  key `Department` (`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `faculty`
--


-- --------------------------------------------------------

--
-- Table structure for table `faculty_advisor`
--

CREATE TABLE `faculty_advisor` (
  `Faculty_ID` int(11) NOT NULL,
  `Batch_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_advisor`
--


-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod`
--


-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `Course_ID` int(11) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  `section_ID` int(11) NOT NULL,
  `Minimum_CGPA` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`offer_ID`,`course_ID`,`faculty_ID`)
  KEY  `section_att` (`section_ID`,`Semester`,`Year`),


) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--


-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

CREATE TABLE `prerequisites` (
  `Course_ID` int(11) NOT NULL,
  `Prerequisite_ID` int(11) NOT NULL,
  PRIMARY Key (`Course_ID`,`Prerequisite_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prerequisites`
--


-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `Section_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Building` varchar(100) NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `Room_no` int(11) NOT NULL,
  `Time_slot_ID` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Semester` varchar(50) NOT NULL,
  PRIMARY KEY (`Section_ID`,`Course_ID`,`semester`,`year`),
  KEY `Time_slot_ID` (`Time_slot_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `section`
--


-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Faculty_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Staff_ID`)
  KEY `Faculty_ID`(`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `staff`
--


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Batch_Year` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
  KEY `Department`(`Department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `students`
--


-- --------------------------------------------------------

--
-- Table structure for table `takes`
--

CREATE TABLE `takes` (
  `Student_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  `Grade` int(11) NOT NULL,
  PRIMARY KEY (`Student_ID`,`Offer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `takes`
--


-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `Offer_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY Key (`Offer_ID`,`Student_ID`)
  KEY `Course_ID`(`Course_ID`)
  KEY `Faculty_ID`(`Faculty_ID`)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--


-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  `Time_slot_ID` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  PRIMARY KEY (`Start_time`,`Time_slot_ID`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_slot`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`);
  
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_fk1` FOREIGN KEY (`section_ID`,`Course_ID`,`semester`,`year`) REFERENCES `section` (`section_ID`,`Course_ID`,`semester`,`year`);
  
ALTER TABLE `section`
  ADD CONSTRAINT `section_fk3` FOREIGN KEY (`Building`,`room_no`) REFERENCES `classroom`` (`Building`,`room_no`);
