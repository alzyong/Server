<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);


$sqlquery = "SELECT COUNT(*) FROM `product_info`"; 

$result=mysqli_query($con,$sqlquery);
$row=mysqli_fetch_array($result);

echo $row[0];

/*
Test codes:
{"senderAcc": "S13"}
*/
mysqli_close($con);
?>