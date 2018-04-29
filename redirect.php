<?php 
    if ($_SESSION['position'] == 0) {
        header("location:students.php");
    } elseif ($_SESSION['position'] == 1){
        header("location:teachers.php");
    } elseif ($_SESSION['position'] == 2) {
        header("location:staff.php");
    }
?>