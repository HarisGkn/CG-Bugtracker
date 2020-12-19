<?php
session_start();
// Include config file
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
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                                <div class="card shadow-lg border-0 rounded-lg mt-5 w-100" style="overflow-x:auto;">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th scope="col">Ticket Id</th>
                                                <th scope="col">Summary</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">To User</th>
                                                <th scope="col">Priority</th>
                                                <th scope="col">Description</th>
                                            </tr>
                                        </thead>
                                        <?php
                                                require_once "config.php";
                                                $projId = $_GET['inf'];
                                                $sql = "SELECT id, summary, status, to_user, priority, description FROM tickets WHERE proj_id=$projId";
                                                $result = $link->query($sql);
                                                if ($result->num_rows > 0) {
                                                  while($row = $result->fetch_assoc()) {
                                                    $id = $row["id"];
                                                    $summary = $row["summary"];
                                                    $status = $row["status"];
                                                    $to_user = $row["to_user"];
                                                    $priority = $row["priority"];
                                                    $description = $row["description"];
                                            ?>
                                                    <tbody>
                                                      <th><?php echo $id; ?></th>
                                                      <th><?php echo $summary; ?></th>
                                                      <td><?php echo $status; ?></td>
                                                      <td><?php echo $to_user; ?></td>
                                                      <td><?php echo $priority; ?></td>
                                                      <td><?php echo $description; ?></td>
                                                      <?php
                                                        if($_SESSION["id"] == "1"){
                                                      ?>
                                                      <td><a onclick="location.href='update_ticket.php?ticketId=<?php echo $id?>'" class="btn btn-primary">Edit</a></td>
                                                      <td><a onclick="location.href='delete_ticket.php?del=<?php echo $id?>'" class="btn btn-danger">Delete</a></td>
                                                      <?php
                                                        }
                                                      ?>
                                                    </tbody>
                                            <?php
                                                  }
                                              } 
                                            ?>
                                    </table>
                                    <a class="btn btn-primary" href="submit_ticket.php?inf=<?php echo $projId ?>">Submit a new ticket</a>
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