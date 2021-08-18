<?php
define('DB_SERVER', 'remotemysql.com');
define('DB_USERNAME', 'XC2QsFQrD3');
define('DB_PASSWORD', 'qhYN3EeVE1');
define('DB_NAME', 'XC2QsFQrD3');
 
/* Attempt to connect to MySQL database */
// αποπειρα συνδεσης στη βαση
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
// ελεγχος συνδεσης
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
