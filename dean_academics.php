<?php
    include('session.php');
    include("constants.php");
    if (!isset($_SESSION['position']) || $_SESSION['position'] != DEAN_ACADEMICS) {
        echo "Your login does not entail Dean Academics portal";
        die();
    }
?>

    <html>

    <head>

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Welcome</title>
    </head>

    <body style="margin:50px;">
        <h1>Welcome
            <?php 
                echo $login_session; 
                $sql = "SELECT * FROM faculty WHERE faculty_id = " . $_SESSION["id"];
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                echo '<h2>ID: ' . $row['Faculty_ID'] . '</h2>';
               
            ?>
        </h1>

        <h3><a href=".">(Refresh)</a></h3>
        <div>
            <ul>
                <li>
                    <a href="#viewgrades">View Grades </a>
                </li>
                <li>
                    <a href="#addcourses">Add Courses</a>
                </li>
                <li>
                    <a href="#editcourses">Edit Courses</a>
                </li>
                <li>
                    <a href="#manage_tickets">Manage Tickets</a>
                </li>
                <li>
                    <a href="logout.php">Sign Out</a>
                </li>

            </ul>
        </div>

        <div id="view_grade">
            <h1>View Grades</h1>
            <form action="#" method="post">
                <?php
                        $sql = "SELECT DISTINCT course_id, semester, year FROM completed " ; 
                        $result = mysqli_query($db, $sql);  
                        if ($result && $result->num_rows>0) {
                            echo '<select name="viewgrades">';
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<option value="'.$row["course_id"].','.$row["semester"] .',' . $row["year"] . '">';
                                echo implode(' ', $row);
                                echo '</option>';
                            }
                            echo '</select>';
                            echo '<input type="submit" name="view" value="View Grades" />';
                        } else {
                            echo 'None of your courses are completed!' . " (" . mysqli_error($db) . ")";
                        }
                    ?>

            </form>
            <?php
                if (isset($_POST["view"])) {
                    $vals = explode(',',$_POST['viewgrades']);
                    $sql = "SELECT student_id, grade FROM completed WHERE course_id=\"".$vals[0]."\" AND semester=\"".$vals[1]."\" AND year=".$vals[2];
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo '<table border=1>';
                        echo '<thead><tr><th>Student ID</th><th>Grade</th></tr></thead><tbody>';  
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            echo "<tr>";
                            echo '<th scope="row">' . $row["student_id"] . "</th>";
                            echo '<td>' . $row["grade"] . '</td>';
                            echo "</tr>";
                        }
                        echo '</tbody></table>';
                    } else {
                        echo "No students" . " (" . mysqli_error($db) . ")";
                    }
                }
            ?>
        </div>

        <div id="editcourses">
            <h1>Edit a course</h1>
            Select Course:
            <form action="#" method="post">
                <select name="course_edit">
                    <?php
                        $sql = "SELECT * FROM courses";
                        $result = mysqli_query($db, $sql);
                        if ($result){
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo "<option value=\"" . $row["Course_ID"] ."\" >";
                                echo $row["Course_ID"] . ": " . $row["Name"];
                                echo "</option>";
                            }
                        } else {
                            echo "No courses" . " (" . mysqli_error($db) . ")";
                        }
                    ?>
                </select>
                <br>
                <input type="submit" name="edit" value="Select Course" />
            </form>
            <?php 
                if (isset($_POST["edit"])) {
                    $sql = "SELECT * FROM courses WHERE courses.Course_ID = \"".$_POST["course_edit"]."\"";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo '<form action="#" method="post">';
                        echo 'Course ID: <input type="text" name="ecourseid" value="'.$_POST["course_edit"].'"><br>';
                        echo '<input type="hidden" name="ocourseid" value="'.$_POST["course_edit"].'">';
                        echo 'L: <input type="number" name="el" value="'.$row["L"].'"><br>';
                        echo 'T: <input type="number" name="et" value="'.$row["T"].'"><br>';
                        echo 'P: <input type="number" name="ep" value="'.$row["P"].'"><br>';
                        echo 'Name: <input type="text" name="ename" value="'.$row["Name"].'"><br>';
                        echo 'Department:';
                        echo '<select name="editdep">';
                        $sql2 = "SELECT * FROM department";
                        $result2 = mysqli_query($db, $sql2);
                        while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                            echo '<option value="' . $row2["Name"] . '"';
                            if ($row2["Name"] == $row["Department"]) echo 'selected';
                            echo '>';
                            echo $row2["Name"];
                            echo '</option>';
                        }
                        echo '</select><br>';
                        echo '<input type="submit" name="edit2" value="Edit Course"></form>';
                    } else {
                        echo "Course details not present. (" . mysqli_error($db) . ")";
                    }
                }
            ?>
            <?php
                    if (isset($_POST["edit2"])) {
                        $sql = "UPDATE Courses SET Course_ID = \"".$_POST["ecourseid"]."\",L=".$_POST["el"].",T=".$_POST["et"].",P=".$_POST["ep"].",Name=\"".$_POST["ename"]."\",Department=\"".$_POST["editdep"]."\" WHERE courses.Course_ID =  \"".$_POST["ocourseid"]."\"";
                        $result = mysqli_query($db, $sql);
                        if ($result) {
                            echo "Successfully edited course";
                        } else {
                            echo "Not successful" . " (" . mysqli_error($db) . ")";
                        }
                    }
                ?>
        </div>

        <div id="addcourses">
            <h1>Add a new course</h1>
            <form action="#" method="post">
                Course ID: <input type="text" name="courseid"><br> L: <input type="number" name="l"><br> T: <input type="number" name="t"><br> P: <input type="number" name="p"><br> Name: <input type="text" name="name"><br> Department:
                <select name="adddep">
                        <?php
                            $sql = "SELECT * FROM department";
                            $result = mysqli_query($db, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo '<option value="' . $row["Name"] . '">';
                                echo $row["Name"];
                                echo '</option>';
                            }
                        ?>
                    </select> Prerequisites: <br>
                <?php
                        $sql = "SELECT * FROM courses";
                        $result = mysqli_query($db, $sql);
                        if($result && $result->num_rows>0) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<input type="checkbox" name="prereq[]" value="'.$row["Course_ID"].'" />'.$row["Course_ID"].": ".$row["Name"].'</input><br>';
                            }
                        } else {
                            echo "No courses (" . mysqli_error($db) . ")";
                        }
                        
                    ?>
                    <br>
                    <input type="submit" name="add" value="Add Course" />
            </form>
            <?php
                    if (isset($_POST["add"])) {
                        $sql = "INSERT INTO Courses(Course_ID,L,T,P,Name,Department) VALUES (\"". $_POST['courseid'] . "\"," . $_POST['l'] . "," . $_POST['t'] . "," . $_POST['p'] . ",\"" . $_POST['name'] . "\",\"".$_POST["adddep"]."\")";
                        $result = mysqli_query($db, $sql);
                        if ($result) {
                            echo "Successfully added course";
                        } else {
                            echo "Not successful" . " (" . mysqli_error($db) . ")";
                        }
                        foreach ($_POST["prereq"] as $p) {
                            $sql = "INSERT INTO prerequisites VALUES (\"".$_POST["offercourse"]."\",\"".$p."\")";
                            $result = mysqli_query($db, $sql);
                            if ($result) {
                                echo "Successfully added prerequisite: " . $p;
                            } else {
                                echo "Unsuccessful adding prerequisite: " . $p . " (" . mysqli_error($db) . ")<br>";
                            }
                        }
                    }
                ?>
        </div>

        <div id="manage_tickets">
            <h1>Manage Tickets</h1>
            <?php
                $sql = "SELECT * FROM ticket,offers WHERE  offers.offer_ID = ticket.offer_id AND offers.completed=0 AND status = ".ACCEPTED_FORWARDED_HOD ;
                $result = mysqli_query($db, $sql);
                if ($result && $result->num_rows>0) {
                    echo '<form action="#" method="post">
                    <table border=1><thead><tr><th>Course ID</th><th>Student ID</th><th>Section ID</th><th>Student\'s Comments</th><th>Actions</th></tr></thead><tbody>';
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . $row["Course_ID"] . '</td>';
                        echo '<td>' . $row["Student_ID"] . '</td>';
                        echo '<td>' . $row["section_ID"] . '</td>';
                        echo '<td>' . $row["Comment"] . '</td>';
                        echo '<input type="hidden" name="student_id" value="'.$row["Student_ID"].'" />';
                        echo '<input type="hidden" name="offer_id" value="'.$row["Offer_ID"].'" />';
                        echo '<td>';
                            echo '<input type="submit" name="action" value="Accept"/>';
                            echo '<input type="submit" name="action" value="Reject"/>';
                            
                        echo '</td>';                        
                        echo '</tr>';
                    }
                    echo '</tbody></table></form>';
                } else {
                    echo "No relevant tickets" . " (" . mysqli_error($db) . ")";
                }
                if (isset($_POST["action"])) {
                    $student_id = $_POST["student_id"];
                    $offer_id = $_POST["offer_id"];
                    switch ($_POST["action"]) {
                        case 'Accept':
                            $status = ACCEPTED_CLOSED_DEAN;
                            break;
                        case 'Reject':
                            $status = REJECTED_DEAN;
                            break;
                        
                    }
                    $sql = "UPDATE ticket SET status=".$status." WHERE Student_ID=".$student_id." AND Offer_ID=".$offer_id;
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo 'Action '.$_POST["action"]." succeeded (Refresh page)";
                    } else {
                        echo 'Action '.$_POST["action"]." failed" . " (" . mysqli_error($db) . ")";
                    }
                }
            ?>
        </div>
    </body>

    </html>
