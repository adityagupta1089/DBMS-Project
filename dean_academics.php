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
                <?php echo $login_session; ?>
            </h1>

            <div>
                <ul>
                    <li>
                        <a href="#viewgrades">View Grades </a>
                    </li>
                    <li>
                        <a href="#adddelcourses">Add/Delete Courses</a>
                    </li>
                    <li>
                        <a href="#manage_tickets">Manage Tickets</a>
                    </li>
                    <li>
                        <a href="logout.php">Sign Out</a>
                    </li>

                </ul>
            </div>

            <div id="viewgrades">
                <h1>View Grades</h1>
                

            </div>

            <div id="adddelcourses">
                <h1>Register for a course</h1>
                Select Course:
                <form action="#" method="post">
                    Course ID: <input type="text" name="courseid"><br>
                    L: <input type="number" name="l"><br>
                    T: <input type="number" name="t"><br>
                    P: <input type="number" name="p"><br>
                    Name: <input type="text" name="name"><br>
                    Department:
                    <select>
                        <?php
                            $sql = "SELECT * FROM department";
                            $result = mysqli_query($db, $sql);
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo '<option value="' . $row["name"] . '">';
                                echo '</option>';
                            }
                        ?>
                    </select>
                </form>
                <input type="submit" name="add" value="Add Course" />
                <?php
                    if (issset($_POST["add"])) {
                        $sql = "INSERT INTO Courses VALUES (". $_POST['courseid'] . "," . $_POST['l'] . "," . $_POST['t'] . "," . $_POST['p'] . "," . $_POST['name'] . ")";
                        $result = mysqli_query($db, $sql);
                        if ($result) {
                            echo "Successfully added course";
                        } else {
                            echo "Not successful";
                        }
                    }
                ?>
            </div>

            <div id="manage_tickets">
                <h1>Manage Tickets</h1>
                <?php
                $sql = ""; // fetch relevant tickets
                    $result = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        //print row for ticket and add accept reject and forward buttons
                    }
            ?>
            </div>
    </body>

    </html>
