<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{        
      
             background-image: url(https://blogger.googleusercontent.com/img/a/AVvXsEixhgR7wDlsvW24C-Do8yix58NVD60nTrZi9r3yU0Ep6N05noTILa14weU4x9Fgw9yBTgNydTjJFy1thuOzFlsexqVWyqWCvlOeHdyDRozYx-Q8pq7183sg0P8VUoqov7lZNeEOvuWZY_PiDPjVTtkKxm6UO2-35XPGH6fsacKqbWo5cae_vHQ7g_M0cg);
             

        }
        #navbarNav {
            margin-left: 800px;
        }
        #nav_bt{
            border: 1px solid orange;
            border-radius: 25px;
            color: white;
            margin: 10px; 
            text-align: center ;
            width: 100px;
        }
        
    </style>
</head>
<body>
       <!-------- part of nav-bar-->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <!-------- Food button -->
                    <li class="nav-item">
                    <a class="nav-link" href="http://localhost/registration/html/hamd.html" id="nav_bt" >home</a>

                    <!-------- Drinks & Sweets button -->
                    <li class="nav-item">
                    <a class="nav-link" href="http://localhost/registration/html/Contact_Page.html" id="nav_bt" >Contacts</a></li>

                    <!-------- home button -->
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/registration/php/logout.php" id="nav_bt" >Logout</a>
                    </li>
                    <div class="Image"></div>

                </ul>
                
            </div>
        </div>
    </nav>
</body>
</html>