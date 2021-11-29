<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$sqlquery = "SELECT all_accounts.*, courier_account.currentlyActive, courier_account.totalEarnings FROM all_accounts INNER JOIN courier_account WHERE all_accounts.accountID = courier_account.accountID AND all_accounts.accType = 'Courier' and courier_account.currentlyActive= '0'"; 

$result = mysqli_query($con, $sqlquery);

$response = array();
$before = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "accountID" => $row["accountID"], 
    "username" => $row["username"],
    "phoneNum" => $row["phoneNum"],
    "name" => $row["name"],
    "email" => $row["email"],
    "address" => $row["address"],
    "currentlyActive" => $row["currentlyActive"],
    "totalEarnings" => $row["totalEarnings"]
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