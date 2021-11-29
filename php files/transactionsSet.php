<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$transactionID = $json["transactionID"];
$deivceID = $json["deivceID"];
$senderAcc = $json["senderAcc"];
$pickupAddress = $json["pickupAddress"];
$productID = $json["productID"];
$courierAcc = $json["manufactureDate"];
$pickedUp = '0';
$receiverAcc = $json["receiverAcc"];
$deliveryAddress = $json["deliveryAddress"];
$deliveryCoord = $json["deliveryCoord"];
$delivered = '0';
$deliveryFunds = $json["deliveryFunds"];


$sql = "INSERT INTO transaction ('transactionID','deviceID', 'pickupAddress', 'productID', 'courierAcc', 'pickedUp', 'receiverAcc', 'deliveryAddress', 'deliveryCoord', 'delivered', 'deliveryFunds')
		VALUES 
		($transactionID, $deviceID, $pickupAddress, $productID, $courierAcc, $pickedUp, $receiverAcc, $deliveryAddress, deliveryCoord, delivered, deliveryFunds)";

if (mysqli_query($con, $sql))
{
    echo json_encode(array("state" => "Success"));
}
else
{
    $error = mysqli_error($con);
    echo json_encode(array("state" => $error));   
}
/*
{	"transactionID": "Test 1",
	"deviceID": "Module_NOT_REAL",
	"pickupAddress": "Lot 13, Jalan Bad Luck, Taman MALANG, 54321, City, Malaysia",
	"productID": "P18",
	"courierAcc": "C13",
	"receiverAcc": "R1",
	"deliveryAddress": "Lot 666, Jln Tak Bagus, Tmn Kematian, 123456, Cukai, Malaysia",
	"deliveryCoord": "1.23015, 101.25678465";
	"deliveryFunds": "69.42"
}
*/

mysqli_close($con);
?>
