<?php
    include("config.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = mysqli_real_escape_string($db, $_POST['uesrname']);
        
        $password = mysqli_real_escape_string($db, $_POST['password']);
        
        $sql = "SELECT id FROm admin WHERE username = '$username' and password = '$password'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        
        if ($count == 1) {
            session_register("username");
            $_SESSION['login_user'] = $username;
            
            header("location:welcome.php");
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

            <!-- Navigation bar -->
            <ul class="nav nav-tabs" id="nav-login-register">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#register">Register</a>
                </li>
            </ul>

            <!-- Tab contents -->
            <div class="tab-content" id="data-login-register">
                <div id="login" class="tab-pane active container">
                    <!-- Login form -->
                    <form id="login-form">
                        <div>
                            <div class="form-group">
                                <label for="login-name">User name</label>
                                <input type="text" class="form-control" id="login-name" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="login-pass">Password</label>
                                <input type="password" class="form-control" id="login-pass" placeholder="Password">
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
                <div id="register" class="tab-pane container">
                    <!-- Register Form -->
                    <form id="register-form">
                        <div>
                            <div class="form-group">
                                <label for="register-name">User name</label>
                                <input type="text" class="form-control" id="register-name" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="register-pass">Password</label>
                                <input type="password" class="form-control" id="register-pass" placeholder="Password">
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="post">Student</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="post">Teaching Faculty</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="post">Staff</label>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bootstap core Javascripts -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
        </div>
    </body>

    </html>
