<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$transactionID = $json["transactionID"];
$deviceID = $json["deviceID"];
$senderAcc = $json["senderAcc"];
$pickupAddress = $json["pickupAddress"];
$productID = $json["productID"];
$courierAcc = $json["courierAcc"];
$pickedUp = '0';
$receiverAcc = $json["receiverAcc"];
$deliveryAddress = $json["deliveryAddress"];
$deliveryCoord = $json["deliveryCoord"];
$delivered = '0';
$deliveryFunds = $json["deliveryFunds"];


$sql = "INSERT INTO transaction (transactionID, deviceID, senderAcc, pickupAddress, productID, courierAcc, pickedUp, receiverAcc, deliveryAddress, deliveryCoord, delivered, deliveryFunds)
		VALUES 
		('$transactionID', '$deviceID', '$senderAcc', '$pickupAddress', '$productID', '$courierAcc', '$pickedUp', '$receiverAcc', '$deliveryAddress', '$deliveryCoord', '$delivered', '$deliveryFunds')";

if (mysqli_query($con, $sql))
{
    //echo json_encode(array("state" => "Success"));
    echo "Success";
}
else
{
    $error = mysqli_error($con);
    echo json_encode(array("state" => $error));   
}
/*
{	
"transactionID": "T4",
"deviceID": "Module_1",
"senderAcc": "S13",
"pickupAddress": "house4",
"productID": "A1",
"courierAcc": "C1",
"receiverAcc": "R1",
"deliveryAddress": "receiver1Address",
"deliveryCoord": "1.01, 2.02",
"deliveryFunds": "100"
}
*/

mysqli_close($con);
?>
