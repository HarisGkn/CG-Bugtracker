<?php
session_start();
// Include config file
require_once "config.php";
if($_SESSION["id"] == "1"){
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($link, "DELETE FROM projects WHERE id=$id");
	$_SESSION['message'] = "Address deleted!"; 
	header('location: index.php');
}
}
else{
	header("Location: index.php");
}
?>