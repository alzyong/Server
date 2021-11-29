<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$userAcc = $json["accountID"];
$accType = substr($userAcc, 0, 1);
if ( $accType == "S")
{
    $sqlquery = "SELECT allAcc.*, sender.*
            FROM all_accounts AS allAcc
            INNER JOIN sender_account AS sender
            ON allAcc.accountID = sender.accountID
            WHERE allAcc.accountID = '$userAcc'";

    $result = mysqli_query($con, $sqlquery);
    $response;
    $before = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $before = array(
        "accountID" => $row["accountID"], 
        "username" => $row["username"],
        "phoneNum" => $row["phoneNum"],
        "password" => $row["password"],
        "name" => $row["name"],
        "email" => $row["email"],
        "address" => $row["address"], 
        "company" => $row["company"]
        );
    }
    $response = $before;
    
}
elseif ($accType == "C")
{
    
    $sqlquery = "SELECT allAcc.*, courier.*
            FROM all_accounts AS allAcc
            INNER JOIN courier_account AS courier
            ON allAcc.accountID = courier.accountID
            WHERE allAcc.accountID = '$userAcc'";
            
    $result = mysqli_query($con, $sqlquery);
    $response;
    $before = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $before = array(
        "accountID" => $row["accountID"], 
        "username" => $row["username"],
        "phoneNum" => $row["phoneNum"],
        "password" => $row["password"],
        "name" => $row["name"],
        "email" => $row["email"],
        "address" => $row["address"], 
        "company" => $row["company"],
        "empID" => $row["empID"],
        "totalEarnings" => $row["totalEarnings"],
        "currentlyActive" => $row["currentlyActive"]
        );
    }
    $response = $before;
}
else
{
    $sqlquery = "SELECT allAcc.*, receiver.*
            FROM all_accounts AS allAcc
            INNER JOIN receiver_account AS receiver
            ON allAcc.accountID = receiver.accountID
            WHERE allAcc.accountID = '$userAcc'";
            
    $result = mysqli_query($con, $sqlquery);
    $response;
    $before = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $before = array(
        "accountID" => $row["accountID"], 
        "username" => $row["username"],
        "phoneNum" => $row["phoneNum"],
        "password" => $row["password"],
        "name" => $row["name"],
        "email" => $row["email"],
        "address" => $row["address"], 
        "altContactPerson" => $row["altContactPerson"],
        "altPhoneNum" => $row["altPhoneNum"]
        );
    }
    $response = $before;
}

//echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8');
echo json_encode($response) ;

/*
Test codes:
{"accountID": "S13"}
*/
mysqli_close($con);
?>
