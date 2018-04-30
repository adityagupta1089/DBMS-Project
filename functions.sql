DELIMITER // 

DROP FUNCTION IF EXISTS `calculateCGPA`;//
CREATE FUNCTION calculateCGPA ( stud_ID INTEGER)  
returns REAL  DETERMINISTIC      

BEGIN

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

END;//

DROP FUNCTION IF EXISTS `getCreditsCompleted`;//
CREATE FUNCTION getCreditsCompleted (gID INTEGER)          
RETURNS REAL DETERMINISTIC
BEGIN
	declare y integer;
 SET @y := (SELECT SUM(getCredits(course_id)) FROM `completed` WHERE student_id = gID);
 RETURN @y;
END;//

DROP FUNCTION IF EXISTS `getCredits`;//
CREATE Function getCredits ( ID varchar(100) )  
RETURNS REAL DETERMINISTIC        

BEGIN

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

END;//





DROP PROCEDURE IF EXISTS updateGrade;//
CREATE PROCEDURE updateGrade (in s_ID INTEGER,in grade INTEGER,in o_ID INTEGER)          

BEGIN
 
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
	
	
END;//




