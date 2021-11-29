<?php
	//https://www.anakkendali.com/belajar-esp32-tutorial-kirim-data-ke-database-mysql/
	$servername = "localhost";
	$username = "esp32";
	$password = "esp322021";
	$database = "delivery_sys";

	$conn = mysqli_connect($servername, $username, $password, $database);

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

    //echo $sql . "<br><br><br><br>";  //DO NOT ECHO OUT ANYTHING ELSE APART FROM WHAT'S ECHOED OUT BELOW!, IT MESSES THINGS UP!!!
	if ($conn->query($sql) === TRUE) 
	{
		echo json_encode("Close");
		//Open
		//Close

		// $sql = "SELECT COUNT(*) FROM transaction";

	 //    if($result = $conn -> query($sql))
	 //    {
	 //        $sql = "SELECT 'pickedUp' FROM transaction where 'transactionID' =";
	 //        if ($result = $conn->query($sql))
	 //        {
	 //            while($data = $result->fetch_row())
	 //            {
	 //               if($data[9] == 0)
	 //                {
	 //                    echo json_encode("Close");
	 //                }
	 //                else
	 //                {
	 //                    echo json_encode("Close");
	 //                }
	 //            }
	 //        }
	 //    }
	 //    else
	 //    {
	 //        echo("No data in transaction");
	 //    }
	}
	    
	else 
	    echo "Error: " . $sql . "<br>" . $conn->error;

/*
    
*/


	$conn->close();
 ?>