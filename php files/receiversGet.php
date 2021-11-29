<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$sqlquery = "SELECT all_accounts.*, receiver_account.altContactPerson, receiver_account.altPhoneNum FROM all_accounts INNER JOIN receiver_account WHERE all_accounts.accountID = receiver_account.accountID AND all_accounts.accType = 'Receiver' ;";

$result = mysqli_query($con, $sqlquery);

$response = array();
$before = array();

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $before = array(
    "accountID" => $row["accountID"], 
    "username" => $row["username"],
    "phoneNum" => $row["phoneNum"],
    "email" => $row["email"],
    "address" => $row["address"],
    "altContactPerson" => $row["altContactPerson"],
    "altPhoneNum" => $row["altPhoneNum"]
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