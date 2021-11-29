<?php

$servername = "localhost";

$dbname = "delivery_sys";
$username = "esp32";
$password = "esp322021";

$deviceID = $dateTime = $temperature =$humidity =$latitude =$longitude =$altitude =$breachStat = "";

#Required if not used with SIM7600X
date_default_timezone_set("Asia/Singapore");
$t = time();
$dateTime = date("Y-m-d h:i:s", $t);

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    #For using with SIM7600X
    #$_POST=json_decode(file_get_contents("php://input"), true);
    
    #echo "The post array: \n";
    #print_r($_POST);
    
    $deviceID       = test_input($_POST["espIpAddress"]);
    $dateTime       = test_input($_POST["dateTime"]);
    $temperature    = test_input($_POST["temperature"]);
    $humidity       = test_input($_POST["humidity"]);
    $longitude      = test_input($_POST["longitude"]);
    $latitude       = test_input($_POST["latitude"]);
    $breachStat     = test_input($_POST["breachStat"]);
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO iot_data (deviceID, dateTime, temperature, humidity, latitude, longitude, breachStat)
    VALUES ('"  . $deviceID . "','" 
                . $dateTime . "','" 
                . $temperature . "', '" 
                . $humidity . "', '" 
                . $latitude . "', '" 
                . $longitude . "', '" 
                . $breachStat . "')";

    if ($conn->query($sql) === TRUE) 
    {
        echo "Inserted Record";
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    
}
else 
{
    echo ("No data posted with HTTP POST.");
/*
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "SELECT COUNT(*) FROM transaction";

    if($result = $conn -> query($sql))
    {
        $sql = "SELECT 'delivered' FROM transaction where 'transactionID' =";
        if ($result = $conn->query($sql))
        {
            while($data = $result->fetch_row())
            {
               if($data[9] == 0)
                {
                    echo json_encode("Close");
                }
                else
                {
                    echo json_encode("Close");
                }
            }
        }
    }
    else
    {
        echo("No data in transaction");
    }
*/
}

function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
