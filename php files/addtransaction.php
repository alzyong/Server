<?php

// Importing DBConfig.php file.
include 'dbconfig.php';

// Creating connection.
$con = mysqli_connect($dhost, $dusername, $dpassword, $database);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

$deviceID = $obj['deviceID'];
$senderacc = $obj['senderacc'];
$pickupaddress = $obj['pickupaddress'];
$productID = $obj['productID'];
$receiveracc = $obj['receiveracc'];
//Applying User Login query with email and password match.
$sqlquery1 = "INSERT INTO transaction (deviceID, senderAcc, pickupAddress, productID, receiverAcc) values ('$deviceID', '$senderacc', '$pickupaddress', '$productID', '$receiveracc')";
if (mysqli_query($con, $sqlquery))
{
    $successmessage = 'New Transaction Created Successfully';
    $json = json_encode($successmessage);
    echo $json;
}
else
{
    echo 'ERROR, Please Try Again';
}


mysqli_close($con);
?>