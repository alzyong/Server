<?php
include 'dbconfig.php';
$con = mysqli_connect($dhost, $dusername, $dpassword, $database);
$sqlquery = "SELECT gpsData FROM iot_data ORDER BY dateTime DESC";
$result = mysqli_query($con, $sqlquery);
if (mysqli_num_rows($result) > 0)
{
    while ($row[] = mysqli_fetch_assoc($result))
    {
        $gpsData = $row;
        $json = json_encode($gpsData);
    }
}
else
{
    echo 'No Results Found';
}
echo $json;
mysqli_close($con);
?>