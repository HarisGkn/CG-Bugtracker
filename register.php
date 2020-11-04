<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
// αρχικοποιηση μεταβλητων 
$password = $confirm_password = $email = $name= $surname = "";
$password_err = $confirm_password_err = $email_err= $name_err= $surname_err = "";
 
// Processing form data when form is submitted
// επεξεργασια δεδομενων φορμας
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     //name
     //ονομα
     if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        $sql = "SELECT id FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            $param_name = trim($_POST["name"]);            
            $name = trim($_POST["name"]);
        }
        mysqli_stmt_close($stmt);
    }

    




    //surname
    //επιθετο
    if(empty(trim($_POST["surname"]))){
        $surname_err = "Please enter a surname.";
    } else{
        $sql = "SELECT id FROM users WHERE surname = ?";     
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_surname);
            $param_surname = trim($_POST["surname"]);            
            $surname = trim($_POST["surname"]);
        }
        mysqli_stmt_close($stmt);
    }



     // Validate email
     // ελεγχος εγκυροτητας για το email
     if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        $sql = "SELECT id FROM users WHERE email = ?";      
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);              
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }






    
    // Validate password
    // ελεγχος εγκυροτητας για το password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    // ελεγχος εγκυροτητας για το confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    // ελεγχος για την υπαρξη errors
    if(empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($name_err) && empty($surname_err)){
        
        // Prepare an insert statement
        // sql statement για τα δεδομενα
        $sql = "INSERT INTO users (password, email, name, surname) VALUES (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_password, $param_email, $param_name, $param_surname);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_name = $name;
            $param_surname = $surname;
            // Attempt to execute the prepared statement
            // προσπαθεια εκτελεσης του statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // στελνει τον χρηστη στη login 
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        // κλεισιμο
        // mysqli_stmt_close($stmt);
    }
    
    // Close connection
    // κλεισιμο
    mysqli_close($link);
}
?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CG-BUGTRACKER</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4" id="inputFirstName" type="text" value="<?php echo $name; ?>" name="name" placeholder="Enter first name" />
                                                        <span class="help-block"><?php echo $name_err; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" name="surname" id="inputLastName" value="<?php echo $surname; ?>" type="text" placeholder="Enter last name" />
                                                        <span class="help-block"><?php echo $surname_err; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                    <input class="form-control py-4" name="email" id="inputEmailAddress" value="<?php echo $email; ?>" type="text" aria-describedby="emailHelp" placeholder="Enter email address" />
                                                    <span class="help-block"><?php echo $email_err; ?></span>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4" name="password" id="inputPassword" value="<?php echo $password; ?>" type="password" placeholder="Enter password" />
                                                        <span class="help-block"><?php echo $password_err; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input class="form-control py-4" name="confirm_password" id="inputConfirmPassword" value="<?php echo $confirm_password; ?>" type="password" placeholder="Confirm password" />
                                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <input type="submit" value="Create Account" class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
