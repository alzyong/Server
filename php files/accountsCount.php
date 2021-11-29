<?php
// Importing DBConfig.php file.
include 'dbconfig.php';

// Creating connection.
$con = mysqli_connect($dhost, $dusername, $dpassword, $database);

$sqlquery = "SELECT COUNT(*) FROM `all_accounts`"; 

$result=mysqli_query($con,$sqlquery);
$row=mysqli_fetch_array($result);

echo $row[0];

mysqli_close($con);
?>
