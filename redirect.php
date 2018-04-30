<?php 
    include("constants.php");
    session_start();
    if ($_SESSION['position'] == STUDENTS) {
        header("location:students.php");
    } elseif ($_SESSION['position'] == FACULTY){
        header("location:teachers.php");
    } elseif ($_SESSION['position'] == STAFF) {
        header("location:staff.php");
    } elseif ($_SESSION['position'] == HOD) {
        header("location:hod.php");
    } elseif ($_SESSION['position'] == DEAN_ACADEMICS) {
        header("location:dean_academics.php");
    } elseif ($_SESSION['position'] == FACULTY_ADVISOR) {
        header("location:faculty_advisor.php");
    }
?>