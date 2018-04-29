<?php
    include('session.php');

    if (!isset($_SESSION['position']) || $_SESSION['position'] != 0) {
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
                <?php echo $login_session; ?>
            </h1>

            <div>
                <ul>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#acadperf">Academic Performance</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#regcourse">Register for a Course</a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#genticket">Generate Ticket</a>
                    </li>
                    <li>
                        <a class="nav-link" href="logout.php">Sign Out</a>
                    </li>

                </ul>
            </div>

            <div id="acadperf">
                <h1>Academic Performance</h1>
                <table border=1>
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Minimum CGPA</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $sql = "SELECT offers.course_id, offers.minimum_cgpa, takes.grade FROM takes, offers WHERE offers.offer_id = takes.offer_id AND takes.student_id =" .  $_SESSION["id"];
                                $result = mysqli_query($db, $sql);                            
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                    echo "<tr>";
                                    echo '<th scope="row">' . $row["course_id"] . "</th>";
                                    echo '<td>' . $row["minimum_cgpa"] . '</td>';
                                    if ($row["grade"]) {
                                        echo '<td>' . $row["grade"] . '</td>';
                                    } else {
                                        echo '<td>Not Yet Completed</td>';
                                    }
                                    echo "</tr>";
                                }
                    ?>
                    </tbody>
                </table>

            </div>
            <div id="regcourse" class="tab-pane">
                <h1>Register for a course</h1>
                Select Course:
                <select>
                            <?php
                                $sql = "SELECT offers.course_id, courses.name FROM offers, courses WHERE offers.course_id = courses.course_id";
                                $result = mysqli_query($db, $sql);                            
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                    echo "<option><a href=\"#\" class=\"dropdown-item\">";
                                    echo $row["course_id"] . ": " . $row["name"];
                                    echo "</a></option>";
                                }
                    ?>
                    </select>
            </div>
            <div id="genticket" class="tab-pane" style="padding:50px;">
                <h1>Generate a ticket.</h1>
            </div>

        </div>
    </body>

    </html>
