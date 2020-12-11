<?php
session_start();
// Include config file
require_once "config.php";
if($_SESSION["id"] != "1"){
    header("Location: index.php");
}
	// initialize variables
	$project_name = "";
    $status = "";
    $authorized_users = "";
    $description = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$project_name = $_POST['project_name'];
        $status = $_POST['status'];
        $authorized_users = $_POST['authorized_users'];
        $description = $_POST['description'];

        $checkbox1=$_POST['techno'];  
        $chk=""; 
        foreach($checkbox1 as $chk1)  
        {  
           $chk .= $chk1.",";  
        }  
		mysqli_query($link, "INSERT INTO projects (project_name, status, authorized_users, description) VALUES ('$project_name', '$status', '$chk', '$description')"); 
		$_SESSION['message'] = "Address saved"; 
		header('location: index.php');
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
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
	                                    	<div class="form-group">
                                                <label class="small mb-1">Project Name</label>
	                                    		<input class="form-control py-4" type="text" name="project_name" placeholder="Enter a name for your project" value="">
	                                    	</div>
	                                    	<div class="form-group">
                                                <label class="small mb-1">Status</label>
                                                <select class="form-control" name="status"  value="" >
                                                    <option value="development">Development</option>
                                                    <option value="release">Release</option>
                                                    <option value="stable">Stable</option>
                                                    <option value="obsolete">Obsolete</option>
                                                </select>
	                                    	</div>
                                            <div class="form-group">
                                                <label class="small mb-1">Authorized Users</label>
                                                    <?php
                                                        $sql = "SELECT email FROM users";
                                                        $result = $link->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                $email = $row["email"];
                                                    ?>
                                                    <br>
                                                                <input type="checkbox" name="techno[]" value="<?php echo $email.''; ?>"><?php echo $email.''; ?></input>
                                                    <?php
                                                            }
                                                        } 
                                                    ?>
	                                    	</div>
                                            <div class="form-group">
                                                <label class="small mb-1">description</label>
	                                    		<input class="form-control py-4" type="text" name="description" placeholder="Describe your project" value="">
	                                    	</div>
	                                    	<div class="form-group mt-4 mb-0">
	                                    		<button class="btn btn-primary btn-block" type="submit" name="save" >Save</button>
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
