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
                            <a class="nav-link" data-toggle="tab" href="#view_grade">View Grades<span class="sr-only">(current)</span></a>
                            
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#update_grade">Update Grades</a>
                        </li>
                        <li>
                            <a class="nav-link" data-toggle="tab" href="#manage_tickets">Manage Tickets</a>
                        </li>
                         <li>
                            <a class="nav-link" data-toggle="tab" href="#offer_course">Offer Course</a>
                        </li>
                         <li>
                            <a class="nav-link" href="logout.php">Sign Out</a>
                        </li>
                        
                    </ul>
                </div>
            </nav>
            
            
            <div class="tab-content">
                <div id="view_grade" class="tab-pane active">
                    <h3>HOME</h3>
                    <p>View Grades : 
                        
                    
                    </p>
                </div>
                <div id="update_grade" class="tab-pane">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="manage_tickets" class="tab-pane">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="offer_course" class="tab-pane">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div>
            </div>

        </div>

        <!-- Bootstap core Javascripts -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </body>

    </html>
