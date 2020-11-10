<?php
session_start();
 
// Unset all of the session variables
// "ακυρωνει" τις μεταβλητες του session
$_SESSION = array();
 
session_destroy();
 
// Redirect to home page
// στελνει τον χρηστη στην αρχικη
header("location: login.php");
exit;
?>