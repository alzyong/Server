<?php
	include 'DBConfig.php';

	$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

	//Set timezone
	date_default_timezone_set("Asia/Singapore");
	
	$t = time();
	$dateTime = date("Y-m-d h:i:s", $t);

	$deviceID = $_POST['deviceID'];
	$breachStatus = $_POST['breachStatus'];
	$dhtTempData = $_POST['dhtTempData'];
	$dhtHumidityData = $_POST['dhtHumidityData'];
	$gpsData = $_POST['gpsData'];

    $sql = "INSERT INTO `iot_data`
    		(`deviceID`,  `dateTime`,  `breachStatus`,  `dhtTempData`,  `dhtHumidityData`, 
    			 `gpsData`) 
    VALUES 	('$deviceID', '$dateTime', '$breachStatus', '$dhtTempData', '$dhtHumidityData', 
    			'$gpsData');";
	mysqli_query($con, $sql);
	
	$sqlquery = "SELECT pickedUp, delivered FROM transaction WHERE deviceID = '$deviceID'";
	$result = mysqli_query($con, $sqlquery);

	$rows = mysqli_fetch_array($result);
	$pickedUp = $rows[0];
	$delivered = $rows[1];

	if ($pickedUp == 0 && $delivered == 0)
	{
		echo ("Open");
	}
	elseif($pickedUp == 1 && $delivered == 0)
	{
		echo ("Close");
	}
	else
	{
		echo ("Open");
	}

	/*
	Test data
    deviceID=Module_3&breachStatus=44&dhtTempData=12&dhtHumidityData=100&gpsData=0.000000, 0.000000
	*/	


	$con->close();
 ?>