<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
// αρχικοποιηση μεταβλητων 
$project_name = $status = $authorized_users = $description = "";
$project_name_err = $status_err = $authorized_users_err = $description_err = "";
 
// Processing form data when form is submitted
// επεξεργασια δεδομενων φορμας
if($_SERVER["REQUEST_METHOD"] == "POST"){
 


     // making sure the same name isn't used twice
     if(empty(trim($_POST["project_name"]))){
        $project_name_err = "Please enter a name for your project.";
    } else{
        $sql = "SELECT id FROM projects WHERE project_name = ?";      
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_project_name);
            $param_project_name = trim($_POST["project_name"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);              
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $project_name_err = "This name is already taken.";
                } else{
                    $project_name = trim($_POST["project_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }


    


    //status
    if(empty(trim($_POST["status"]))){
        $status_err = "What is the status of your project.";
    } else{
        $sql = "SELECT id FROM projects WHERE status = ?";     
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_status);
            $param_status = trim($_POST["status"]);            
            $status = trim($_POST["status"]);
        }
        mysqli_stmt_close($stmt);
    }


    //authorized users
    if(empty(trim($_POST["authorized_users"]))){
        $authorized_users_err = "enter the names of all the authorized users separated by a comma.";
    } else{
        $sql = "SELECT id FROM projects WHERE authorized_users = ?";     
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_authorized_users);
            $param_authorized_users = trim($_POST["authorized_users"]);            
            $authorized_users = trim($_POST["authorized_users"]);
        }
        mysqli_stmt_close($stmt);
    }


    //description
    if(empty(trim($_POST["description"]))){
        $description_err = "Enter a small description for your project.";
    } else{
        $sql = "SELECT id FROM projects WHERE description = ?";     
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_description);
            $param_description = trim($_POST["description"]);            
            $description = trim($_POST["description"]);
        }
        mysqli_stmt_close($stmt);
    }




    
    // Check input errors before inserting in database
    // ελεγχος για την υπαρξη errors
    if(empty($project_name_err) && empty($status_err) && empty($authorized_users_err) && empty($description_err)){
        
        // Prepare an insert statement
        // sql statement για τα δεδομενα
        $sql = "INSERT INTO projects (project_name, status, authorized_users, description) VALUES (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_project_name, $param_status, $param_authorized_users, $param_description );
            $param_project_name = $project_name;
            $param_status = $status;
            $param_authorized_users = $authorized_users;
            $param_description = $description;
            // Attempt to execute the prepared statement
            // προσπαθεια εκτελεσης του statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to index page 
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        // κλεισιμο
         mysqli_stmt_close($stmt);
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Project</h3></div>
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($project_name_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputProjectName">Project Name</label>
                                                        <input class="form-control py-4" id="inputProjectName" type="text" name="project_name" value="<?php echo $project_name; ?>" placeholder="Enter project name" />
                                                        <span class="help-block"><?php echo $project_name_err; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputStatus">Status</label>
                                                        <input class="form-control py-4" id="inputStatus" value="<?php echo $status; ?>" type="text" name="status" placeholder="Enter status" />
                                                        <span class="help-block"><?php echo $status_err; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group <?php echo (!empty($authorized_users_err)) ? 'has-error' : ''; ?>">
                                                    <label class="small mb-1" for="inputAuthorized_usersAddress">Authorized Users</label>
                                                    <input class="form-control py-4" name="authorized_users" id="inputAuthorized_usersAddress" value="<?php echo $authorized_users; ?>" type="text" placeholder="Enter the users that are authorized separated by a comma" />
                                                    <span class="help-block"><?php echo $authorized_users_err; ?></span>
                                            </div>
                                            <div class="form-group">
                                                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                                                        <label class="small mb-1" for="inputDescription">Description</label>
                                                        <input class="form-control py-4" id="inputDescription" value="<?php echo $description; ?>" type="text" name="description" placeholder="Enter description" />
                                                        <span class="help-block"><?php echo $description_err; ?></span>
                                                    </div>
                                                </div>
                                            <div class="form-group mt-4 mb-0">
                                                <input type="submit" value="Create Project" class="btn btn-primary btn-block">
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
