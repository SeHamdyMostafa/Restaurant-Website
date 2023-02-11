<?php


// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: home.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         body{
background-color: #153C52;
        }
        
        .container {
            border: 1px solid;
            width: 700px;
            height: 550px;
            padding: 20px 60px 30px 40px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 70px;
            left: 275px;
            
            background-image: url(https://blogger.googleusercontent.com/img/a/AVvXsEi1zkhP7r6v9VicKnrJDSDxEcYRqlSNhGtiH0RHQwRAzSmSPB4h0AC9Nw4TL18--NbtS6BGnVgHsap_iVNByuvQWurtea6l4FVJ--cDmM3sKM8JfsDK1vmB3HI6Md2B358cWhfyUnrluqcvtcBEBcCJwLFh4fCGmzuVX6LGBdRPnciknX0EV-NIhoyKyA);
        }

        .error{
            text-align: center;
            color:white;
            font-family: "Brush Script MT", cursive;
            font-size: 24px;
        }
       

        .title {
            position: absolute;
            margin-left: 270px;
            margin-top: 0px;
            font-size: 40px;
            color: black;
        }
        #button {
            position: absolute;
            left: 280px;
            top: 470px;
            font-size: 20px;
            border: 1px solid orange;
            border-radius: 10px;
            padding: 10px;
            background-color: rgb(39, 39, 39);
            color: white;
            font-family: "Brush Script MT", cursive;
            width: 150px;
        }
        
        #button:hover {
            background-color: #a3b18a;
        }
        .label{
            color: white;
            font-family: "Brush Script MT", cursive;
            font-size: 26px;

        }
        #input{

            background-color: transparent;
            border: none;
            color: white;
            border-bottom: 4px solid #283618;          
            
        }
    </style>
</head>

<body>
<div class="container">
<h2 class="title" >Login</h2>
    <div class="wrapper">
        <form style="margin-top: 60px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label class="label" >Username</label>
                <input id="input" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label class="label" >Password</label>
                <input id="input" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <input id="button" type="submit" class="btn btn-primary" value="Login">
            </div>
            <?php
        if (!empty($login_err)) {
            echo '<div class="error">' . $login_err . '</div>';
        }
        ?>
            <p style="margin-top: 60px; color:black; font-size:24px ">Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</div>
</div>
</body>

</html>