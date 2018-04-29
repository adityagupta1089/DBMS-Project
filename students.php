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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Welcome</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    </head>

    <body>
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Welcome <?php echo $login_session; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav mr-auto nav-tabs">
                        <li class="active">
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
            </nav>

            <div class="tab-content">
                <div id="acadperf" class="tab-pane active">
                    <table class="table table-striped">
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
                                    echo "<tr>";
                                }
                    ?>
                        </tbody>
                    </table>
                    
                </div>
                <div id="regcourse" class="tab-pane">
                    Register for a course.
                </div>
                <div id="genticket" class="tab-pane">
                    Generate a ticket.
                </div>
            </div>

        </div>

        <!-- Bootstap core Javascripts -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </body>

    </html>
