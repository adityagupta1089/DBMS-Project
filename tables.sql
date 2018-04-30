-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2018 at 09:55 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms_project`
--
CREATE DATABASE IF NOT EXISTS `dbms_project` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbms_project`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `updateGrade`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateGrade` (IN `s_ID` INTEGER, IN `grade` INTEGER, IN `o_ID` INTEGER)  BEGIN
 
DECLARE f_ID Integer;
DECLARE sem varchar(100);
DECLARE yr integer;
DECLARE c_ID varchar(100);

IF grade<0 OR grade >10

THEN 
 
 SIGNAL SQLSTATE '45000'
 SET MESSAGE_TEXT = 'INVALID GRADE(0-10 ALLOWED) !!';

END IF;

	set @f_ID := (select faculty_ID from offers where offers.offer_ID=o_ID);
	set @c_ID := (select course_ID from offers where offers.offer_ID=o_ID);
	set @sem := (select semester from section,offers where section.section_ID = offers.section_ID 
	AND offers.offer_ID=o_ID);
	set @yr := (select year from section,offers where section.section_ID = offers.section_ID 
	AND offers.offer_ID=o_ID);

	INSERT INTO completed(Course_ID, Faculty_ID, Semester, Year, grade, Student_ID) 
	VALUES (@c_ID,@f_ID,@sem,@yr,grade,s_ID);
	delete from takes where takes.student_ID = s_ID AND takes.offer_ID=o_ID;
	
	
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `calculateCGPA`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `calculateCGPA` (`stud_ID` INTEGER) RETURNS DOUBLE BEGIN

DECLARE x REAL;
DECLARE y REAL;
DECLARE LSum REAL;
DECLARE TSum REAL;
DECLARE PSum REAL;


 SET @x := 0;
 SET @y := 0;
 SET @LSum := 0;
 SET @TSum := 0;
 SET @PSum := 0;
   
    SET @x := (SELECT sum( grade * getCredits(Completed.course_ID) )
	FROM Completed
	Where Completed.student_ID = stud_ID );

	SET @LSum := (SELECT sum(Courses.L)
	FROM Courses,Completed
	Where Completed.student_ID = stud_ID AND Completed.Course_ID = Courses.Course_ID);
	
	SET @TSum := (SELECT sum(Courses.T) 
	FROM Courses,Completed
	Where Completed.student_ID = stud_ID AND Completed.Course_ID = Courses.Course_ID);
	
	SET @PSum := (SELECT sum(Courses.P)
	FROM Courses,Completed
	Where Completed.student_ID = stud_ID AND Completed.Course_ID = Courses.Course_ID);

SET @y :=  @LSum + @TSum + @PSum/2;

SET @x := @x/@y;

return @x;

END$$

DROP FUNCTION IF EXISTS `getCredits`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getCredits` (`ID` VARCHAR(100)) RETURNS DOUBLE BEGIN

DECLARE y REAL;
DECLARE LSum REAL ;
DECLARE TSum REAL ;
DECLARE PSum REAL ;



 SET @y := 0;
   
      
	
	SET @LSum := (SELECT courses.L  
	FROM Courses
	Where ID = Courses.Course_ID);
	
	SET @TSum := (SELECT courses.T  
	FROM Courses
	Where ID = Courses.Course_ID);
	
	SET @PSum := (SELECT courses.P  
	FROM Courses
	Where ID = Courses.Course_ID);
	
	

SET @y := @LSum + @TSum + @PSum/2;

return @y;

END$$

DROP FUNCTION IF EXISTS `getCreditsCompleted`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getCreditsCompleted` (`gID` INTEGER) RETURNS DOUBLE BEGIN
	declare y integer;
 SET @y := (SELECT SUM(getCredits(course_id)) FROM `completed` WHERE student_id = gID);
 RETURN @y;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `Username` varchar(100) NOT NULL,
  `Password` char(32) NOT NULL,
  `Category` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Username`, `Password`, `Category`, `ID`) VALUES
('DeanSA', 'abcd', 4, 6),
('facy', 'abcd', 5, 4),
('hoodie', 'abcd', 3, 1),
('mudgal', 'abcd', 1, 1),
('raghu', 'abcd', 2, 41),
('vinit', 'abcd', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `allowed_batches`
--

DROP TABLE IF EXISTS `allowed_batches`;
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

INSERT INTO `allowed_batches` (`Offer_ID`, `Department`, `Batch_year`) VALUES
(1, 'CSE', 2015),
(5, 'CSE', 2015),
(3, 'EE', 2014),
(2, 'MECH', 2015),
(9, 'MECH', 2011),
(9, 'MECH', 2015),
(2, 'MECH', 2011);

-- --------------------------------------------------------

--
-- Table structure for table `completed`
--

DROP TABLE IF EXISTS `completed`;
CREATE TABLE IF NOT EXISTS `completed` (
  `Course_ID` varchar(100) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Semester` varchar(100) NOT NULL,
  `Year` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  KEY `Student_ID` (`Student_ID`),
  KEY `Course_ID` (`Course_ID`),
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`Course_ID`, `Faculty_ID`, `Semester`, `Year`, `grade`, `Student_ID`) VALUES
('MEL101', 2, 'fall', 2016, 8, 2),
('EEL101', 3, 'spring', 2017, 7, 5),
('CSL101', 1, 'spring', 2015, 9, 1),
('CSL101', 1, 'spring', 2015, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
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
('CSL100', 1, 1, 0, 'Intro to CSE', 'CSE'),
('CSL101', 2, 2, 2, 'DS', 'CSE'),
('CSL202', 3, 0, 1, 'AI', 'CSE'),
('EEL101', 1, 2, 2, 'EM', 'EE'),
('MEL101', 2, 1, 2, 'TOM', 'MECH'),
('MEL202', 2, 1, 2, 'Fluid mechanics', 'MECH');

-- --------------------------------------------------------

--
-- Table structure for table `dean`
--

DROP TABLE IF EXISTS `dean`;
CREATE TABLE IF NOT EXISTS `dean` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dean`
--

INSERT INTO `dean` (`Faculty_ID`, `Start_time`, `End_time`) VALUES
(3, '00:00:01', '00:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
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

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `Faculty_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  PRIMARY KEY (`Faculty_ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`Faculty_ID`, `Name`, `Department`) VALUES
(1, 'Mudgal', 'CSE'),
(2, 'Das', 'MECH'),
(3, 'ROY', 'EE'),
(4, 'Iyenger', 'CSE'),
(5, 'Sahambi', 'EE'),
(6, 'Dhiraj', 'MECH');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_advisor`
--

DROP TABLE IF EXISTS `faculty_advisor`;
CREATE TABLE IF NOT EXISTS `faculty_advisor` (
  `Faculty_ID` int(11) NOT NULL,
  `Batch_year` int(11) NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_advisor`
--

INSERT INTO `faculty_advisor` (`Faculty_ID`, `Batch_year`) VALUES
(4, 2015),
(6, 2016),
(5, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

DROP TABLE IF EXISTS `hod`;
CREATE TABLE IF NOT EXISTS `hod` (
  `Faculty_ID` int(11) NOT NULL,
  `Start_time` time NOT NULL,
  `End_time` time NOT NULL,
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`Faculty_ID`, `Start_time`, `End_time`) VALUES
(1, '00:00:01', '00:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `Course_ID` varchar(100) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `section_ID` int(11) NOT NULL,
  `Minimum_CGPA` int(11) NOT NULL DEFAULT '0',
  `Completed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Offer_ID`,`Course_ID`,`Faculty_ID`),
  KEY `section_att` (`section_ID`),
  KEY `Faculty_ID` (`Faculty_ID`),
  KEY `Course_ID` (`Course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`Course_ID`, `Faculty_ID`, `Offer_ID`, `section_ID`, `Minimum_CGPA`, `Completed`) VALUES
('CSL101', 1, 1, 1, 0, 1),
('MEL101', 2, 2, 1, 0, 1),
('EEL101', 3, 3, 1, 0, 0),
('CSL202', 4, 5, 2, 10, 0),
('CSL100', 1, 8, 1, 0, 0),
('MEL202', 6, 9, 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

DROP TABLE IF EXISTS `prerequisites`;
CREATE TABLE IF NOT EXISTS `prerequisites` (
  `Course_ID` varchar(100) NOT NULL,
  `Prerequisite_ID` varchar(100) NOT NULL,
  PRIMARY KEY (`Course_ID`,`Prerequisite_ID`),
  KEY `Prerequisite_ID` (`Prerequisite_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prerequisites`
--

INSERT INTO `prerequisites` (`Course_ID`, `Prerequisite_ID`) VALUES
('CSL202', 'CSL101'),
('MEL202', 'MEL101');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`Section_ID`, `Building`, `Room_no`, `Time_slot_ID`, `Year`, `Semester`) VALUES
(1, 'B1', 1, 1, 2015, 'spring'),
(2, 'B2', 1, 2, 2015, 'fall'),
(3, 'B1', 2, 3, 2017, 'fall'),
(4, 'B1', 1, 4, 2018, 'spring');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `Staff_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Faculty_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Staff_ID`),
  KEY `Faculty_ID` (`Faculty_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Faculty_ID`, `Name`) VALUES
(2, 2, 'sujit'),
(41, 1, 'Raghu'),
(43, 4, 'Riya');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Batch_Year` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Department` (`Department`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `Name`, `Department`, `Batch_Year`) VALUES
(1, 'Vinit', 'CSE', 2015),
(2, 'Shubham', 'MECH', 2015),
(3, 'Durgesh', 'EE', 2015),
(4, 'Aditya', 'CSE', 2016),
(5, 'Snigdha', 'EE', 2014),
(6, 'Parth', 'MECH', 2011);

-- --------------------------------------------------------

--
-- Table structure for table `takes`
--

DROP TABLE IF EXISTS `takes`;
CREATE TABLE IF NOT EXISTS `takes` (
  `Student_ID` int(11) NOT NULL,
  `Offer_ID` int(11) NOT NULL,
  PRIMARY KEY (`Student_ID`,`Offer_ID`),
  KEY `Offer_ID` (`Offer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `takes`
--

INSERT INTO `takes` (`Student_ID`, `Offer_ID`) VALUES
(2, 9);

--
-- Triggers `takes`
--
DROP TRIGGER IF EXISTS `delete_OFFERS`;
DELIMITER $$
CREATE TRIGGER `delete_OFFERS` AFTER DELETE ON `takes` FOR EACH ROW BEGIN

UPDATE  `Offers` SET  `Completed` =  '1' 
WHERE Offers.Offer_ID = OLD.Offer_ID AND NOT EXISTS(SELECT * FROM Takes
WHERE Takes.Offer_ID = OLD.Offer_ID);


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `Offer_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`Offer_ID`,`Student_ID`),
  KEY `Student_ID` (`Student_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`Offer_ID`, `Student_ID`, `Status`, `Comment`) VALUES
(1, 1, 4, 'hi sir'),
(3, 2, 6, 'jus lyk that'),
(8, 1, 0, 'hello. pls accept');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

DROP TABLE IF EXISTS `time_slot`;
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
('00:00:01', '00:00:02', 1, 'monday'),
('00:00:02', '00:00:04', 4, 'thursday'),
('00:00:05', '00:00:06', 2, 'wednesday'),
('00:00:10', '00:00:11', 3, 'tuesday');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowed_batches`
--
ALTER TABLE `allowed_batches`
  ADD CONSTRAINT `allowed_batches_ibfk_1` FOREIGN KEY (`Offer_ID`) REFERENCES `offers` (`Offer_ID`),
  ADD CONSTRAINT `allowed_batches_ibfk_2` FOREIGN KEY (`Department`) REFERENCES `department` (`Name`);

--
-- Constraints for table `completed`
--
ALTER TABLE `completed`
  ADD CONSTRAINT `completed_ibfk_1` FOREIGN KEY (`Faculty_ID`) REFERENCES `faculty` (`Faculty_ID`),
  ADD CONSTRAINT `completed_ibfk_2` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `completed_ibfk_3` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`);

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
  ADD CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`),
  ADD CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`Prerequisite_ID`) REFERENCES `courses` (`Course_ID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
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
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`Offer_ID`) REFERENCES `offers` (`Offer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
