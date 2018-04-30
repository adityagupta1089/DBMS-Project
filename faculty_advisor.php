<?php
    include('session.php');
    include("constants.php");
    if (!isset($_SESSION['position']) || $_SESSION['position'] != FACULTY_ADVISOR) {
        echo "Your login does not enatil Faculty Advisor portal";
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


        <ul>
            <li class="active">
                <a href="#view_grade">View Grades</a>

            </li>
            <li>
                <a href="#manage_tickets">Manage Tickets</a>
            </li>
            <li>
                <a href="logout.php">Sign Out</a>
            </li>

        </ul>


        <div id="view_grade">
            <h1>View Grades</h1>
            <form action="#" method="post">
                <?php
                        $sql = "SELECT DISTINCT completed.course_id, completed.semester, year FROM completed,courses WHERE courses.Course_ID = completed.Course_ID AND courses.Department = (SELECT Department FROM
                        faculty WHERE faculty.Faculty_ID = ".$_SESSION["id"].")"; 
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
                            echo 'No of your courses found!' . mysqli_error($db);
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
                        echo "No students" . mysqli_error($db);
                    }
                }
            ?>
        </div>

        <div id="manage_tickets">
            <h1>Manage Tickets</h1>
            <?php
                $sql = "SELECT * FROM ticket,offers,courses WHERE  offers.offer_ID = ticket.offer_id AND courses.Course_ID=offers.Course_ID AND
                courses.Department=(SELECT Department FROM faculty WHERE Faculty_ID =".$_SESSION["id"] ." )
                AND status = ".ACCEPTED_FORWARDED_FACULTY ;
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
                            echo '<input type="submit" name="action" value="Forward"/>';
                        echo '</td>';                        
                        echo '</tr>';
                    }
                    echo '</tbody></table></form>';
                } else {
                    echo "No relevant tickets" . mysqli_error($db);
                }
                if (isset($_POST["action"])) {
                    $student_id = $_POST["student_id"];
                    $offer_id = $_POST["offer_id"];
                    switch ($_POST["action"]) {
                        case 'Accept':
                            $status = ACCEPTED_CLOSED_FA;
                            break;
                        case 'Reject':
                            $status = REJECTED_FA;
                            break;
                        case 'Forward':
                            $status = ACCEPTED_FORWARDED_FA;
                            break;
                    }
                    $sql = "UPDATE ticket SET status=".$status." WHERE Student_ID=".$student_id." AND Offer_ID=".$offer_id;
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo 'Action '.$_POST["action"]." succeeded (Refresh page)";
                    } else {
                        echo 'Action '.$_POST["action"]." failed" . mysqli_error($db);
                    }
                }
            ?>
        </div>



    </body>

    </html>
