<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$userAcc = $json["accountID"];
$accType = $json["accType"];
$sqlquery = "";

if ($accType == "Sender")
{
    $sqlquery = "SELECT * FROM product_info WHERE senderAcc = '$userAcc'";
}
else
{
    $sqlquery = "SELECT * FROM product_info WHERE productID IN (SELECT productID FROM transaction WHERE receiverAcc = '$userAcc'); ";
}



$result = mysqli_query($con, $sqlquery);
$response = array();
$before = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "productID" => $row["productID"], 
    "productName" => $row["productName"],
    "manufactureDate" => $row["manufactureDate"],
    "expiryDate" => $row["expiryDate"],
    "senderAcc" => $row["senderAcc"],
    "company" => $row["company"],
    "serialNum" => $row["serialNum"], 
    "category" => $row["category"],
    "qrCode" => $row["qrCode"]
    );

    array_push($response, $before);
}

//echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8');
echo json_encode($response) ;

/*
Test codes:
{"accountID": "S13", "accType": "Sender"}
{"accountID": "R1", "accType": "Receiver"}
*/
mysqli_close($con);
?>
