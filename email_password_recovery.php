<?php
session_start();
// Include config file
require_once "config.php";
$email = "";
$email_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    if(empty($email_err)){
        $sql = "SELECT email FROM users WHERE email=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $email);
                    if(mysqli_stmt_fetch($stmt)){
                        $email_rec = $email;
                    }
                } else{
                    // Display an error message if username doesn't exist
                    // το username δεν υπαρχει
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        $token = bin2hex(random_bytes(50));
        $sql = "INSERT INTO password_resets (email, token) VALUES (?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_token );
            $param_email = $email_rec;
            $param_token = $token;
            // Attempt to execute the prepared statement
            // προσπαθεια εκτελεσης του statement
            if(mysqli_stmt_execute($stmt)){
                $to = $email_rec;
                $subject = "Reset your password on CG-Bugtracker.com";
                $message = "Hi there, click on this <a href=\"/opt/lampp/htdocs/CG-Bugtracker/email_password_recovery.php/password.php?token=" . $token . "\">link</a> to reset your password on our site";
                $message = wordwrap($message,70);
                mail($to, $subject, $message);
                header('location: pending.php?email=' . $email_rec);
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
    }
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
        <title>Page Title - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="email" type="email" placeholder="Enter email address" />
                                                <span class="help-block"><?php echo $email_err; ?></span>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <input type="submit" name="reset-password" class="btn btn-primary btn-block">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
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
