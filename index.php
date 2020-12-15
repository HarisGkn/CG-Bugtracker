<?php
session_start();
if(!isset($_SESSION['loggedin'])){ //if login in session is not set
    header("Location: login.php");
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
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">CG-Bugtracker</a>
            <!-- Navbar-->
            <ul class="navbar-nav d-md-inline-block ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a href="account_info.php" class="dropdown-item">Account</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        <div class="dropdown-divider"></div>
                        <div class="small dropdown-item disabled">Logged in as:</div>
                        <div class="dropdown-item disabled">
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
                    </div>
                </li>
            </ul>
        </nav>
        <main>
                    <div class="container-fluid">
                        <br>
                        <br>
                        <?php
                        if($_SESSION["id"] == "1"){
                        ?>
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">
                            <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">id</th>
                                                <th scope="col">project name</th>
                                                <th scope="col">status</th>
                                                <th scope="col">authorized_users</th>
                                                <th scope="col">description</th>
                                            </tr>
                                        </thead>
                                    
                            <?php
                            require_once "config.php";
                            // takes the id, username and email from all users and displays it
                                $sql = "SELECT id, project_name, status, authorized_users, description FROM projects";
                                $result = $link->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    $project_name = $row["project_name"];
                                    $authorized_users = $row["authorized_users"];
                                    $status = $row["status"];
                                    $description = $row["description"];
                            ?>
                                    <tbody>
                                      <th><?php echo $id; ?></th>
                                      <td><?php echo $project_name; ?></td>
                                      <td><?php echo $status; ?></td>
                                      <td><?php echo $authorized_users; ?></td>
                                      <td><?php echo $description; ?></td>
                                      <td><a onclick="location.href='update_project.php?pid=<?php echo $id?>'" class="btn btn-primary">Edit</a></td>
                                      <td><a onclick="location.href='delete_project.php?del=<?php echo $id?>'" class="btn btn-danger">Delete</a></td>
                                      <td><a onclick="location.href='list_tickets.php?inf=<?php echo $id?>'" class="btn btn-info">list Tickets</a></td>
                                    </tbody>
                            <?php
                                  }
                              } 
                            ?>
                            </table>
                        </ol>
                        <a href="add_project.php" class="btn btn-primary">Add a Project</a>
                        <?php
                        }
                        else{
                            ?>
                            <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">
                            <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">id</th>
                                                <th scope="col">project name</th>
                                                <th scope="col">status</th>
                                                <th scope="col">authorized_users</th>
                                                <th scope="col">description</th>
                                            </tr>
                                        </thead>
                                    
                            <?php
                            require_once "config.php";
                            // takes the id, username and email from all users and displays it
                                $user=$_SESSION["email"];
                                $sql = "SELECT id, project_name, status, authorized_users, description FROM projects WHERE authorized_users LIKE'%$user%'";
                                $result = $link->query($sql);
                                if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    $project_name = $row["project_name"];
                                    $authorized_users = $row["authorized_users"];
                                    $status = $row["status"];
                                    $description = $row["description"];
                            ?>
                                    <tbody>
                                      <th><?php echo $id; ?></th>
                                      <td><?php echo $project_name; ?></td>
                                      <td><?php echo $status; ?></td>
                                      <td><?php echo $authorized_users; ?></td>
                                      <td><?php echo $description; ?></td>
                                      <td><a onclick="location.href='list_tickets.php?inf=<?php echo $id?>'" class="btn btn-info">list Tickets</a></td>
                                    </tbody>
                            <?php
                                  }
                              } 
                            ?>
                            </table>
                        </ol>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                
                </main>

                <!-- <footer class="py-4 bg-light mt-auto">
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
                </footer> -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
