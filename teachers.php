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
            <?php echo $login_session; ?>
        </h1>


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
                <select name="viewgrades">
                    <?php
                        $sql = ""; // select all those courses which this teacher has completed
                        $result = mysqli_query($db, $sql);                            
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            //insert into select
                        }
                    ?>
                </select>
                <input type="submit" name="view" value="View Grades" />
            </form>
            <?php
                if (isset($_POST["view"])) {
                    $sql = ""; //select grades of students from that course
                    $result = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        //print row
                    }
                }
            ?>
        </div>

        <div id="update_grade">
            <h1>Update Grades</h1>
            <form action="#" method="post">
                <select name="getcourse">
                    <?php
                        $sql = ""; // select all those courses which are offered by this teacher
                        $result = mysqli_query($db, $sql);                            
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            //insert into select
                        }
                    ?>
                </select>
                <input type="submit" name="get" value="View Grades" />
            </form>
            <?php
                if (isset($_POST["get"])) {
                    $sql = ""; // select students from course
                    $result = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        //print row & a text area for grade
                    }
                    echo '<input type="submit" name="submitgrades" value="Submit Grades" />';
                }
                if (isset($_POST["submitgrades"])) {
                    $sql = ""; // move values from takes to completed.
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo "Successfully Submitted grades";
                    } else {
                        echo "Error submitting grades";
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

        <div id="offer_course">
            <h1>Offer Course</h1>
            <form action="#" method="post">
                <select name="offercourse">
                    <?php
                        $sql = ""; // select all courses
                        $result = mysqli_query($db, $sql);                            
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            //insert into select
                        }
                    ?>
                </select>
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