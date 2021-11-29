<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$sqlquery = ""; 

if ($json["accType"] == "Receiver")
{
    $receiverAcc = $json["receiverAcc"];
    $sqlquery = "SELECT * FROM `transaction` WHERE receiverAcc = '$receiverAcc'";
}
elseif ($json["accType"] == "Courier")
{
    $courierAcc = $json["courierAcc"];
    $sqlquery = "SELECT * FROM `transaction` WHERE courierAcc = '$courierAcc'";
}
else
{
    $senderAcc = $json["senderAcc"];
    $sqlquery = "SELECT * FROM `transaction` WHERE senderAcc = '$senderAcc'"; 
}

$result = mysqli_query($con, $sqlquery);

$response = array();
$before = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "transactionID" => $row["transactionID"], 
    "deviceID" => $row["deviceID"],
    "senderAcc" => $row["senderAcc"],
    "pickupAddress" => $row["pickupAddress"],
    "productID" => $row["productID"],
    "courierAcc" => $row["courierAcc"],
    "pickedUp" => $row["pickedUp"],
    "receiverAcc" => $row["receiverAcc"],
    "deliveryAddress" => $row["deliveryAddress"],
    "deliveryCoord" => $row["deliveryCoord"],
    "delivered" => $row["delivered"],
    "deliveryFunds" => $row["deliveryFunds"]
    );

    array_push($response, $before);
}


//echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8');
echo json_encode($response);

/*
Test codes:
{"senderAcc": "S13", "accType":"Sender"}
{"receiverAcc": "R1", "accType":"Receiver"}
*/
mysqli_close($con);
?>