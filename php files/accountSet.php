<?php
include 'DBConfig.php';

$con = mysqli_connect($dhost,$dusername,$dpassword,$database);

$json = json_decode(file_get_contents('php://input'), true);

$userAcc = $json["accountID"];

$username = $json["username"];
$phoneNum = $json["phoneNum"];
$password = hash('sha256', $json["password"]) ;
$name = $json["name"];
$email = $json["email"];
$address = $json["address"];
$accType = $json["accType"];
$company = "";
$empId = "";
$altContactPerson  = "";
$altPhoneNum = "";
$sql = "";

if ($accType == "Receiver")
{
    $altContactPerson  = $json["altContactPerson"];
    $altPhoneNum = $json["altPhoneNum"];

    $sql = "UPDATE all_accounts SET
        username = '$username',
        phoneNum = '$phoneNum',
        password = '$password',
        name = '$name',
        email = '$email',
        address = '$address'
        WHERE accountID = '$userAcc';";

    

    $sql1 = "UPDATE receiver_account SET
            altContactPerson = '$altContactPerson',
            altPhoneNum = '$altPhoneNum'
            WHERE accountID = '$userAcc'";
    
    if (mysqli_query($con, $sql) AND mysqli_query($con, $sql1))
        echo json_encode(array("state" => "Success"));

}else
{
    $sql = "UPDATE all_accounts SET
    username = '$username',
    phoneNum = '$phoneNum',
    password = '$password',
    name = '$name',
    email = '$email',
    address = '$address'
    WHERE accountID = '$userAcc';";

    mysqli_query($con, $sql);

    if ($json["accType"] == "Sender")
    {
        $sql1 = "UPDATE sender_account SET
            company = '$company'
            WHERE accountID = '$userAcc'";
    
        mysqli_query($con, $sql1);

        if (mysqli_query($con, $sql) AND mysqli_query($con, $sql1))
        echo json_encode(array("state" => "Success"));
    }

    else 
    {
        $sql1 = "UPDATE receiver_account SET
            altContactPerson = '$altContactPerson',
            altPhoneNum = '$altPhoneNum'
            WHERE accountID = '$userAcc'";
    
        mysqli_query($con, $sql1);

        if (mysqli_query($con, $sql) AND mysqli_query($con, $sql1))
        echo json_encode(array("state" => "Success"));
    }
}


/*
{
"accountID" : "S1",
"username":"Sender01",
"phoneNum":"0123456789",
"password":"passing",
"name":"Jack",
"email":"Thisemail",
"address":"Bandar Pinggiran Subang, 40150, Shah Alam, Selangor",
"accType" :"Sender",
"company":"ABC inc"
}
*/

mysqli_close($con);
?>
