<?php
    include('session.php');
    include("constants.php");
    if (!isset($_SESSION['position']) || $_SESSION['position'] != STUDENTS) {
        echo "Your login does not entail student portal";
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
        <div class="container">

            <h1>Welcome
                <?php 
                    echo $login_session; 
                    $sql = "SELECT * FROM students WHERE id = " . $_SESSION["id"];
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    echo '<h2>ID: ' . $row['ID'] . '</h2>';
                    echo '<h2>Department: ' . $row['Department'] . '</h2>';
                    echo '<h2>Batch Year: ' . $row['Batch_Year'] . '</h2>';
                    $sql = "SELECT getCreditsCompleted(".$_SESSION["id"].") AS X";
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    echo '<h2>Completed Credits: ';
                    if (is_null($row["X"])) {
                        echo "0";
                    } else {
                        echo $row["X"];
                    }
                    echo '</h2>';
                    $sql = "SELECT calculateCGPA(".$_SESSION["id"].") AS X";
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    echo '<h2>CGPA: ';
                    if (is_null($row["X"])) {
                        echo "0";
                    } else {
                        echo $row["X"];
                    }
                    echo '</h2>';
                ?>
            </h1>

            <h3><a href=".">(Refresh)</a></h3>
            <ul>
                <li>
                    <a href="#acadperf">Academic Performance</a>
                </li>
                <li>
                    <a href="#regcourse">Register for a Course</a>
                </li>
                <li>
                    <a href="#genticket">Generate Ticket</a>
                </li>
                <li>
                    <a href="logout.php">Sign Out</a>
                </li>

            </ul>

            <div id="acadperf">
                <h1>Academic Performance</h1>
                <h2>Current Courses</h2>
                <table border=1>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Minimum CGPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $sql = "SELECT offers.course_id, offers.minimum_cgpa FROM takes, offers WHERE offers.offer_id = takes.offer_id AND takes.student_id = " .  $_SESSION["id"];
                                $result = mysqli_query($db, $sql);                            
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                    echo "<tr>";
                                    echo '<th scope="row">' . $row["course_id"] . "</th>";
                                    echo '<td>' . $row["minimum_cgpa"] . '</td>';
                                    echo "</tr>";
                                }
                    ?>
                    </tbody>
                </table>
                <h2>Completed Courses</h2>
                <table border=1>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Faculty</th>
                            <th>Semester</th>
                            <th>Year</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $sql = "SELECT * FROM completed, faculty WHERE completed.Student_ID = ". $_SESSION["id"] . " ORDER BY Year, Semester ASC";
                                $result = mysqli_query($db, $sql); 
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                    echo "<tr>";                                    
                                    echo '<th scope="row">' . $row["Course_ID"] . "</th>";
                                    echo '<td>' . $row["Name"] . '</td>';
                                    echo '<td>' . $row["Semester"] . '</td>';
                                    echo '<td>' . $row["Year"] . '</td>';
                                    echo '<td>' . $row["grade"] . '</td>';
                                    echo "</tr>";
                                }
                    ?>
                    </tbody>
                </table>

            </div>

            <div id="regcourse">
                <h1>Register for a course</h1>
                Select Course:
                <?php
                    if(isset($_POST['register'])){
                        $oid = $_POST['course_register'];  
                    } else {
                        $oid = -1;
                    }
                ?>
                    <form action="#" method="post">
                        <select name="course_register">
                            <?php
                                $sql = "SELECT offers.offer_id, offers.course_id, courses.name FROM offers, courses WHERE offers.course_id = courses.course_id";
                                $result = mysqli_query($db, $sql);
                                if ($result){
                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        echo "<option value=\"" . $row["offer_id"] ."\"";
                                        if ($oid == $row["offer_id"]) echo "selected";
                                        echo ">";
                                        echo "Offer #" . $row["offer_id"] . ":   " . $row["course_id"] . "(" . $row["name"] . ")";
                                        echo "</option>";
                                    }
                                } else {
                                    echo "No offered courses";
                                }
                            ?>
                        </select>
                        <input type="submit" name="register" value="Register" />
                    </form>
                    <?php
                        if (isset($_POST['register'])){
                            $sql = "INSERT INTO Takes(offer_id, student_id) VALUES (" . $oid . "," . $_SESSION["id"] . ")";
                            $result = mysqli_query($db, $sql);
                            if ($result) {
                                echo "Course successfully registered";
                            } else {
                                echo "Error registering course: " . mysqli_error($db) . " (Try generating a aticket)";
                            }
                        }
                    ?>

            </div>

            <div id="genticket">
                <h1>Generate a ticket.</h1>
            </div>
            <form action="#" method="post">
                <select name="ticket">
                    <?php
                        $sql = "SELECT offers.offer_id, offers.course_id, courses.name FROM offers, courses WHERE offers.course_id = courses.course_id";
                        $result = mysqli_query($db, $sql); 
                        if ($result){
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                echo "<option value=\"" . $row["offer_id"] ."\"";
                                if ($oid == $row["offer_id"]) echo "selected";
                                echo "><a href=\"#\" class=\"dropdown-item\">";
                                echo "Offer #" . $row["offer_id"] . ":   " . $row["course_id"] . "(" . $row["name"] . ")";
                                echo "</a></option>";
                            }
                        } else {
                            echo "No offered courses";
                        }
                    ?>
                </select><br>
                <textarea name="comment" placeholder="Comments" style="margin-top:20px;width:400px;height:70px;"></textarea><br>
                <input type="submit" name="ticket-submit" value="Submit Ticket" style="margin-top:20px;" />
            </form>
            <?php
                if (isset($_POST['ticket-submit'])) {
                    $sql = "INSERT INTO Ticket(Offer_ID, Student_ID, Comment, Status) VALUES (" . $oid . "," . $_SESSION["id"] . ",\"" . $_POST["comment"] . "\"," . TICKET_JUST_GENERATED . ")";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo "Ticket successfully submitted";
                    } else {
                        echo "Error submitting ticket: " . mysqli_error($db);
                    }
                }
            ?>

        </div>
    </body>

    </html>
