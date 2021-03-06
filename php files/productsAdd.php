<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$userAcc = $json["senderAcc"];
$productID = $json["productID"];
$productName = $json["productName"];
$manufactureDate = $json["manufactureDate"];
$expiryDate = $json["expiryDate"];
$senderAcc = $json["senderAcc"];
$company = $json["company"];
$serialNum = $json["serialNum"];
$category = $json["category"];
$qrCode = $json["qrCode"];


$sql = "INSERT INTO product_info 
    (productID, productName, manufactureDate, expiryDate, senderAcc, company, serialNum, category, qrCode) VALUES (
    '$productID', '$productName', '$manufactureDate', '$expiryDate', '$senderAcc', '$company', '$serialNum', '$category', '$qrCode');";

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
{
"productID": "A1",
"productName": "Testing",
"manufactureDate": "2021/10/27",
"expiryDate": "2022/10/26",
"senderAcc": "S13",
"company": "PHP",
"serialNum": "ALPHA001",
"category": "HVT",
"qrCode": "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"
}
*/

mysqli_close($con);
?>
