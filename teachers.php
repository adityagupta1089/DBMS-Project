<?php
    include('session.php');
    include("constants.php");
    if (!isset($_SESSION['position']) || $_SESSION['position'] != FACULTY) {
        echo "Your login does not entail teacher portal";
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
                echo '<h2>Department: ' . $row['Department'] . '</h2>';
            ?>
        </h1>

        <h3><a href=".">(Refresh)</a></h3>
        <ul>
            <li class="active">
                <a href="#view_grade">View Grades</a>

            </li>
            <li>
                <a href="#update_grade">Update Grades</a>
            </li>
            <li>
                <a href="#manage_tickets">Manage Tickets</a>
            </li>
            <li>
                <a href="#offer_course">Offer Course</a>
            </li>
            <li>
                <a href="logout.php">Sign Out</a>
            </li>

        </ul>


        <div id="view_grade">
            <h1>View Grades</h1>
            <form action="#" method="post">
                <?php
                        $sql = "SELECT DISTINCT course_id, semester, year FROM completed WHERE faculty_id = " . $_SESSION["id"]; 
                        $result = mysqli_query($db, $sql);  
                        if ($result->num_rows>0) {
                            echo '<select name="viewgrades">';
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<option value="'.$row["course_id"].','.$row["semester"] .',' . $row["year"] . '">';
                                echo implode(' ', $row);
                                echo '</option>';
                            }
                            echo '</select>';
                            echo '<input type="submit" name="view" value="View Grades" />';
                        } else {
                            echo 'None of your courses are completed!';
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
                        echo "No students";
                    }
                }
            ?>
        </div>

        <div id="update_grade">
            <h1>Update Grades</h1>
            <form action="#" method="post">
                    <?php
                        $sql = "SELECT * FROM offers WHERE faculty_id = ".$_SESSION["id"]; 
                        $result = mysqli_query($db, $sql);
                        if ($result && $result->num_rows>0) {
                            echo '<select name="getcourse">';
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<option value='.$row["Offer_ID"].'>';
                                echo "Offer# " . $row["Offer_ID"] . " (Section ID ".$row["section_ID"].", Course ".$row["Course_ID"].")";
                                echo '</option>';
                            }
                            echo '</select>';
                            echo '<input type="submit" name="get" value="Get Students" />';
                        } else {
                            echo "No current courses";
                        }
                    ?>
            </form>
            <?php
                if (isset($_POST["get"])) {
                    $sql = "SELECT * from takes WHERE Offer_id = " . $_POST["getcourse"]; 
                    $result = mysqli_query($db, $sql);
                    if ($result && $result->num_rows>0) {
                        echo '<form action="#" method="post"><input type="hidden" name="offer_id" value="'.$_POST["getcourse"].'" /><table border=1>';
                        echo '<thead><tr><th>Student ID</th><th>Grade</th></tr></thead><tbody>';  
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo "<tr>";
                            echo '<th scope="row">' . $row["Student_ID"] . "</th>";
                            echo '<td><input type="number" name="'.$row["Student_ID"].'"></td>';
                            echo "</tr>";
                        }
                        echo '</tbody></table>';
                        echo '<input type="submit" name="submitgrades" value="Submit Grades" /></form>';
                    } else {
                        echo 'No students in this course';
                    }
                }
                if (isset($_POST["submitgrades"])) {
                    $sql = "SELECT * from takes WHERE Offer_id = " . $_POST["offer_id"]; 
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $sql = 'CALL updateGrade('.$row["Student_ID"].','.$_POST[$row["Student_ID"]].','.$_POST["offer_id"].')';
                            $result2 = mysqli_query($db, $sql);
                            if ($result2) {
                                echo "Update grade for Student ID " . $row['Student_ID'];
                            } else {
                                echo "Update grade failed for Student ID " . $row['Student_ID'] . " (".mysqli_error($db).")";
                            }
                        }
                    }
                }
            ?>
        </div>

        <div id="manage_tickets">
            <h1>Manage Tickets</h1>
            <?php
                $sql = "SELECT * FROM ticket, offers WHERE status = ".TICKET_JUST_GENERATED." AND faculty_id = " . $_SESSION["id"] . " AND offers.offer_ID = ticket.offer_id";
                $result = mysqli_query($db, $sql);
                if ($result && $result->num_rows>0) {
                    echo '<form action="#" method="post"><table border=1><thead><tr><th>Course ID</th><th>Student ID</th><th>Section ID</th><th>Student\'s Comments</th><th>Actions</th></tr></thead><tbody>';
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
                            echo '<input type="submit" name="action" value="Forward"/>';
                        echo '</td>';                        
                        echo '</tr>';
                    }
                    echo '</tbody></table></form>';
                } else {
                    echo "No relevant tickets";
                }
                if (isset($_POST["action"])) {
                    $student_id = $_POST["student_id"];
                    $offer_id = $_POST["offer_id"];
                    switch ($_POST["action"]) {
                        case 'Accept':
                            $status = ACCEPTED_CLOSED_FACULTY;
                            break;
                        case 'Reject':
                            $status = REJECTED_CLOSED_FACULTY;
                            break;
                        case 'Forward':
                            $status = ACCEPTED_FORWARDED_FACULTY;
                            break;
                    }
                    $sql = "UPDATE ticket SET status=".$status." WHERE Student_ID=".$student_id." AND Offer_ID=".$offer_id;
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo 'Action '.$_POST["action"]." succeeded (Refresh page)";
                    } else {
                        echo 'Action '.$_POST["action"]." failed";
                    }
                }
            ?>
        </div>

        <div id="offer_course">
            <h1>Offer Course</h1>
            <form action="#" method="post">
                
                    <?php
                        $sql = "SELECT * FROM courses";
                        $result = mysqli_query($db, $sql); 
                        if ($result && $result->num_rows>0){
                            echo '<select name="offercourse">';
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<option value='.$row["Course_ID"].'>'.$row["Course_ID"].': '.$row["Name"].'</option>';
                            }
                            echo '</select>';
                        } else {
                            echo "No courses";
                        }
                    ?>
                <input type="submit" name="offer" value="Offer Course" />
            </form>
            <?php
                if (isset($_POST["offer"])) {
                    $sql = ""; // insert into offer table
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo "Successfully added offer";
                    } else {
                        echo "Unsuccessful offer adding";
                    }
                }
            ?>
        </div>

    </body>

    </html>
