<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$receiverAcc =$senderAcc = $json["accountID"];
$sqlquery = "";
if ($json["accType"] == "Sender")
{
	$sqlquery = "	SELECT data.deviceID, data.dateTime, data.breachStatus, data.dhtTempData, 
				data.dhtHumidityData, data.gpsData
				FROM iot_data AS data 
				INNER JOIN transaction AS t 
				ON t.deviceID = data.deviceID 
				WHERE t.senderAcc = '$senderAcc' AND t.delivered IS FALSE
				ORDER BY data.dateTime DESC
				LIMIT 1";
}
else{
	$sqlquery = "	SELECT data.deviceID, data.dateTime, data.breachStatus, data.dhtTempData, 
				data.dhtHumidityData, data.gpsData
				FROM iot_data AS data 
				INNER JOIN transaction AS t 
				ON t.deviceID = data.deviceID 
				WHERE t.receiverAcc = '$receiverAcc' AND t.delivered IS FALSE
				ORDER BY data.dateTime DESC
				LIMIT 1";
}



$result = mysqli_query($con, $sqlquery);
$response = array();
$before = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "deviceID" => $row["deviceID"], 
    "dateTime" => $row["dateTime"],
    "breachStatus" => $row["breachStatus"],
    "dhtTempData" => $row["dhtTempData"],
    "dhtHumidityData" => $row["dhtHumidityData"],
    "gpsData" => $row["gpsData"]
    );

    array_push($response, $before);
}

//echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8');


if (mysqli_query($con, $sqlquery))
{
	echo json_encode($response);
}
else 
{
	$error = mysqli_error($con);
	echo json_encode(array("state"=>error));
}
/*
{
	"accountID":"S13",
	"username":"AARON",
	"accType":"Sender"
}

{
	"accountID":"R1",
	"username":"Jack",
	"accType":"Receiver"
}
*/
mysqli_close($con);
?>