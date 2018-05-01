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
        <h3><a href=".">(Refresh)</a></h3>
        <ul>
            <li class="active">
                <a href="#view_grade">View Grades</a>

            </li>
            <li>
                <a href="#report_generation">Report Generation</a>
            </li>
            <li>
                <a href="#section_creation">Section Creation</a>
            </li>
            <li>
                <a href="#timeslot_creation">Timeslot Creation</a>
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
                            echo 'None of your courses are completed!' . " (" . mysqli_error($db) . ")";
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
                        echo "Student data not found"  . " (" . mysqli_error($db) . ")";
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
                        echo '</tbdody></table>';
                    }
                    else {
                        echo "No completed courses" . " (" . mysqli_error($db) . ")";
                    }
                }
            ?>
        </div>

        <div id="section_creation">
            <h1>Create Section</h1>
            <form action="#" method="post">
                Building: <input type="text" name="building"><br>
                Room No: <input type="number" name="roomno"><br>
                Semester: <input type="text" name="semester"><br>
                Year: <input type="number" name="year"><br>
                Time Slot:
                <select name="timeslotid">
                        <?php
                            $sql = "SELECT * FROM time_slot";
                            $result = mysqli_query($db, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo '<option value="' . $row["Time_slot_ID"] . '">';
                                echo $row["Start_time"] . " - " . $row["End_time"] . " (" . $row["day"] . ")";
                                echo '</option>';
                            }
                        ?>
                    </select>      <br>          
                <input type="submit" name="add" value="Add Section" />    
            </form>
            <?php
                    if (isset($_POST["add"])) {
                        $sql = "INSERT INTO section(Building, Room_no, Time_slot_ID,Semester,Year) VALUES (\"". $_POST['building'] . "\"," . $_POST['roomno'] . "," . $_POST['timeslotid'] . ", \"" . $_POST["semester"]."\",".$_POST["year"].")";
                        echo $sql;
                        $result = mysqli_query($db, $sql);
                        if ($result) {
                            echo "Successfully added section";
                        } else {
                            echo "Not successful" . " (" . mysqli_error($db) . ")";
                        }
                    }
                ?>
        </div>
        <div id="timeslot_creation">
            <h1>Create Time Slot</h1>
            <form action="#" method="post">
                Start Time: <input type="time" name="start"><br>
                End Time: <input type="time" name="end"><br>
                Day: <input type="text" name="day"><br>                
                <input type="submit" name="addslot" value="Add Time Slot" />    
            </form>
            <?php
                    if (isset($_POST["addslot"])) {
                        $sql = "INSERT INTO time_slot(Start_time, End_time, day) VALUES (\"". $_POST['start'] . "\",\"" . $_POST['end'] . "\",\"" . $_POST['day'] . "\")";
                        $result = mysqli_query($db, $sql);
                        if ($result) {
                            echo "Successfully added time slot";
                        } else {
                            echo "Not successful" . " (" . mysqli_error($db) . ")";
                        }
                    }
                ?>
        </div>
    </body>

    </html>
