<?php
    $error="";

    include("config.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = mysqli_real_escape_string($db, $_POST['username']);
        
        $password = mysqli_real_escape_string($db, $_POST['password']);  
        
        $sql = "SELECT id, category FROM admin WHERE username = '$username' and password = '$password'";

        $result = mysqli_query($db, $sql);        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);  
        
        if ($count == 1) {
            $_SESSION['login_user'] = $username;    
            $_SESSION['position'] = $row["category"];
            $_SESSION['id'] = $row["id"];
            if ($_SESSION['position'] == 0) {
                header("location:students.php");
            } elseif ($_SESSION['position'] == 1){
                header("location:teachers.php");
            } elseif ($_SESSION['position'] == 2) {
                header("location:staff.php");
            }
        } else {
            $error = "Your Login Name or Password is invalid";
        }
    }
?>

    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>
            CSL301 Project!
        </title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

        <!-- Custom styles -->
        <link rel="stylesheet" type="text/css" href="css/index.css">

    </head>

    <body>
        <div class="container">

            <!-- Title -->
            <h1 class="display-2 text-center">Login into Academic Portal</h1>

            <!-- Login Form -->
            <div id="login" class="tab-pane active container">
                <!-- Login form -->
                <form id="login-form" action="" method="post">
                    <div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <div style="font-size:11px; color:#cc0000; margin-top:10px">
                            <?php echo $error; ?>
                        </div>
                        <div class="row">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        
        <!-- Bootstap core Javascripts -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

    </body>

    </html>
