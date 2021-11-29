<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$sqlquery = "SELECT * FROM all_devices WHERE currentlyActive = '0'";    

$result = mysqli_query($con, $sqlquery);

$response = array();
$before = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "deviceID" => $row["deviceID"],
    "currentlyActive" => $row["currentlyActive"]
    );

    array_push($response, $before);
}


//echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8');
echo json_encode($response);

/*
Test codes:
{"senderAcc": "S13"}
*/
mysqli_close($con);
?>