<?php
    include('session.php');
    include("constants.php");
    if (!isset($_SESSION['position']) || $_SESSION['position'] != STAFF) {
        echo "Your login does not entail staff portal";
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
            <?php echo $login_session; ?>
        </h1>

        <ul>
            <li class="active">
                <a href="#view_grade">View Grades</a>

            </li>
            <li>
                <a href="#report_generation">Report Generation</a>
            </li>
            <li>
                <a href="logout.php">Sign Out</a>
            </li>
        </ul>


        <div id="view_grade">
            <h1>View Grades</h1>
            <form action="#" method="post">
                <?php
                        $sql = "SELECT DISTINCT course_id, semester, year FROM completed"; 
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
                            echo 'None of your courses are completed!' . mysqli_error($db);
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
        <div id="report_generation">
            <h1>Generate Reports</h1>
            <form action="#" method="post">
                <?php
                        $sql = "SELECT ID, Name FROM students"; 
                        $result = mysqli_query($db, $sql);  
                        if ($result && $result->num_rows>0) {
                            echo '<select name="viewreport">';
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo '<option value="'.$row["ID"].'">';
                                echo $row["ID"]." ".$row["Name"];
                                echo '</option>';
                            }
                            echo '</select>';
                            echo '<input type="submit" name="view2" value="View Grades" />';
                        } else {
                            echo 'None of your courses are completed!' . mysqli_error($db);
                        }
                    ?>

            </form>
            <?php
                if (isset($_POST["view2"])) {
                    $val = $_POST['viewreport'];
                    $sql = 'select * FROM students where ID='.$val;
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        echo "<h3>Name : ".$row["Name"].'</h3>';
                        echo "<h3>ID : ".$row["ID"].'</h3>';
                        echo "<h3>Department : ".$row["Department"].'</h3>';
                        echo "<h3>Batch : ".$row["Batch_Year"].'</h3>';
                    } else {
                        echo "Student data not found"  . mysqli_error($db);
                    }
                    $sql2 = 'select * from completed where Student_ID='.$row["ID"];
                    $result2 = mysqli_query($db, $sql2);
                    if ($result2) {
                         echo '<table border=1>';
                        echo '<thead><tr><th>Course ID</th><th>Semester</th><th>Year</th><th>Grade</th></tr></thead><tbody>'; 
                        while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC))
                        {
                            
                            echo "<tr>";
                            echo '<th scope="row">' . $row2["Course_ID"] . "</th>";
                            echo '<td>' . $row2["Semester"] . '</td>';
                            echo '<td>' . $row2["Year"] . '</td>';
                            echo '<td>' . $row2["grade"] . '</td>';
                            echo "</tr>";                           
                        }                       
                        
                    }
                    else {
                        echo "No completed courses" . mysqli_error($db);
                    }
                    
                    
                    
                }
            ?>
        </div>

        </div>
    </body>

    </html>
