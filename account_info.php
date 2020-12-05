<?php
session_start();
// Include config file
require_once "config.php";
echo $_SESSION["email"];  
?>