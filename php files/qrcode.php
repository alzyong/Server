<?php
include 'DBConfig.php';
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
$json = file_get_contents('php://input');
$findqrcodeid = $_POST["findqrcodeid"];
$sqlquery1 = "SELECT * FROM product_info WHERE productID = $findqrcodeid";
$result = mysqli_query($con, $ $sqlquery1);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);
    $productID = $row["productID"];
    $serialNum = $row["serialNum"];
    $productName = $row["productName"];
    $category = $row["category"];
}
else
{
    $productID = "";
    $serialNum = "";
    $productName = "";
    $category = "";
}
$response[] = array("productID" => $productID, "serialNum" => $serialNum, "productName" => $productName, "category" => $category);
echo json_encode($response);
mysqli_close($con);
?>