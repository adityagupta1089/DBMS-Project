<?php
    include('session.php');

    if (!isset($_SESSION['position']) || $_SESSION['position'] != 1) {
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

    <body>
        Welcome
        <?php echo $login_session; ?>


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
        </div>
        <div id="update_grade">
            <h1>Update Grades</h1>
        </div>
        <div id="manage_tickets">
            <h1>Manage Tickets</h1>
        </div>
        <div id="offer_course">
            <h1>Offer Course</h1>
        </div>

    </body>

    </html>
