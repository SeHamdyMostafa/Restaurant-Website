<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: logout.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
          body{
background-color: #2C5A84;

        }
        
     

        .error{
            text-align: center;
            color:white;
            font-family: "Brush Script MT", cursive;
            font-size: 24px;
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
            background-image: url(https://blogger.googleusercontent.com/img/a/AVvXsEggF4naPMhi2QoXcvWW1rullo6FQ0DneYq2Po06fuXCX2d4FiyhUXCYRqdFbhWXGfkgtdrcW7za1OsvDuP6x1cXiriogANyxM6CGTCJtMxrQUkM-qNZXgnpsMS9hUd-SKyCPFwrK-uwdf4rlh2nZthK3sKbVn5OvAQKLu_vpWdS74Pn16t8EUsRCoZ30A);
        }

        .title {
            position: absolute;
            margin-left: 260px;
            margin-top: 0px;
            font-size: 40px;
            color: black;
        }
        #button {
            position: absolute;
            left: 280px;
            top: 480px;
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
            color: black;
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
<h2 class="title" >Sign Up</h2>
    <div class="wrapper">
        <form  style="margin-top: 60px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                <label class="label" >Confirm Password</label>
                <input id="input" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input id="button" type="submit" class="btn btn-primary" value="Submit" style="margin-left: 8px;"> <br><br>
            </div>
            <p style="margin-top: -60px; color:black; font-size:24px " >Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
 </div>

</body>

</html>