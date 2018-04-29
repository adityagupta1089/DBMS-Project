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
        <div class="container">

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
            </ul>


            <div id="view_grade">
                <h1>View Grades</h1>
            </div>

            <div id="report_generation">
                <h1>Generate Reports</h1>
            </div>

        </div>
    </body>

    </html>
