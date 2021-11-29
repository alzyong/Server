<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$courierAcc = $json["accountID"];
$deviceID = $json["deviceID"];
$sqlquery = "SELECT accountID, currentlyActive FROM courier_account WHERE accountID = '$courierAcc' AND currentlyActive = 0";

$result = mysqli_query($con, $sqlquery);
$response = new stdClass();
if ((mysqli_num_rows($result)!=0))
{
    $row = mysqli_fetch_array($result);
    $response->state = "True";
    
    $sqlquery = "UPDATE transaction SET pickedUp = 1, courierAcc = '$courierAcc' WHERE pickedUp = 0 AND deviceID = '$deviceID'";
    mysqli_query($con, $sqlquery);
    
    $courierAcc = $row[0];
    $currentlyActive = $row[1];

    $sql = "UPDATE courier_account SET currentlyActive = 1 WHERE accountID = '$courierAcc'";
    mysqli_query($con, $sql);

    
}
else
{
    $response->state = "False";
}

//echo htmlspecialchars(json_encode($response), ENT_QUOTES, "UTF-8");
echo json_encode($response);

/*
Test codes:
{"accountID": "R1", "deviceID":"Module_1"}

{
    "deviceID":"Module_1", 
    "accountID":"R1"
}

*/
mysqli_close($con);
?>