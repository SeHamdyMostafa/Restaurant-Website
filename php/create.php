<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: view.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
background-color: #457b9d;
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
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
            background-image: url(https://blogger.googleusercontent.com/img/a/AVvXsEiyPFbkqTJlCwFv3wU5P81kwo0XMUQ6V2rrTfv63c4VLYze-wuP8at3Yc5UeDLJityaGfmOzse0Nyi57mCPSe93DHqU4BvDF0hbE9rj_sz3T24uA-Duom1ZzM4dvtuMQyRyqGfeFpYvMlgRfxvo7qS9HGxitwDY8BYCc5Mo0P8887TJFpHeIF37L2xzcQ);
        }

        .title {
            position: absolute;
            margin-left: 210px;
            margin-top: 0px;
            color: black;
        }
        #button {
            position: absolute;
            left: 220px;
            top: 450px;
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
            background-color: orange;
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
        .back{
            margin-left: 40px;
            color: black;
        }


    </style>
</head>
<body>
<a href="http://localhost/registration//php/view.php" class="back">
<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
</svg> </a>
<div class="container">
    
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title" >Create Record</h2>
                    <form style="margin-top: 60px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label class="label">Name</label>
                            <input id="input" type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label class="label" >Address</label>
                            <textarea id="input" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label class="label" >Salary</label>
                            <input id="input" type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input id="button" type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
</div>

</div>
  
    
</body>
</html>