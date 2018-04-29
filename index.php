<?php
    $error="";

    include("config.php");
    session_start();

    if(isset($_SESSION['login_user'])){
      header("location:redirect.php");
   }

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
            header("location:redirect.php");
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

    </head>

    <body>
        <!-- Title -->
        <h1 class>Login into Academic Portal</h1>

        <!-- Login Form -->
        <div id="login">
            <!-- Login form -->
            <form id="login-form" action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    <?php echo $error; ?>
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>

    </body>

    </html>
