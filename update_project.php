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
<body>

<?php
    session_start();
    require_once "config.php";
  // takes the id, username and email from all users and displays it
  $sql = "SELECT id, project_name, status, authorized_users, description FROM projects";
  $result = $link->query($sql);
  $x=$_GET['ProjId'];
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      $project_name = $row["project_name"];
      $authorized_users = $row["authorized_users"];
      $status = $row["status"];
      $description = $row["description"];
      if($id==$x){?>
        <div class="list-group">
            <button class="list-group-item disabled">ID: <?php echo $id; ?></button>
            <button class="list-group-item disabled">Project Name: <?php echo $project_name; ?></button>
            <button class="list-group-item list-group-item-primary">Status: <?php echo $status; ?></button>
            <button class="list-group-item list-group-item-primary">Authorized Users: <?php echo $authorized_users; ?></button>
            <button class="list-group-item list-group-item-primary">Description: <?php echo $description; ?></button>
        </div>
    <?php
      }
    }
} 
?>

     

</body>
</html>