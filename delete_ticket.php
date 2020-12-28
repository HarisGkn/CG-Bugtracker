<?php
session_start();
// Include config file
require_once "config.php";
if (isset($_GET['del'])) {
	$id = $_GET['del'];
	echo $pid;
	mysqli_query($link, "DELETE FROM tickets WHERE id=$id");
	//header('location: index.php');
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>