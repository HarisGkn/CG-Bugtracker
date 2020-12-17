<?php
session_start();
// Include config file
require_once "config.php"; 
 
$password = $confirm_password = "";
$password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){


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
    

    if(empty($password_err) && empty($confirm_password_err)){
        $email=$_SESSION["email"];
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($link, "UPDATE users SET password='$password' WHERE email='$email'");
        header('location: logout.php');
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Account</h3></div>
                                    <div class="card-body">
                                        <?php
                                            require_once "config.php";
                                            $id = $_SESSION["id"];
                                            $sql = "SELECT name, surname FROM users WHERE id=$id";
                                            $result = $link->query($sql);
                                            if ($result->num_rows > 0){
                                                while($row = $result->fetch_assoc()){
                                                    $name = $row["name"];
                                                    $surname = $row["surname"];
                                                }
                                            }
                                            echo $name, " ", $surname;
                                            ?>
                                            <br>
                                            <?php
                                            echo $_SESSION["email"];
                                        ?>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div >
                                                <div >
                                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4" name="password" id="inputPassword" value="<?php echo $password; ?>" type="password" placeholder="Enter password" />
                                                        <span class="help-block"><?php echo $password_err; ?></span>
                                                    </div>
                                                </div>
                                                <div >
                                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input class="form-control py-4" name="confirm_password" id="inputConfirmPassword" value="<?php echo $confirm_password; ?>" type="password" placeholder="Confirm password" />
                                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <input type="submit" value="Change Password" class="btn btn-primary btn-block">
                                            </div>
                                        </form>
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