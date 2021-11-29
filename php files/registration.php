<?php
// Importing DBConfig.php file.
include 'dbconfig.php';

// Creating connection.
$con = mysqli_connect($dhost, $dusername, $dpassword, $database);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// decoding the received JSON and store into $obj variable.

$obj = json_decode($json,true);
$sql = "";
$sql1 = "";

$accountID = $obj['accountID'];
	$username = $obj['username'];
	$pnumber = $obj['phoneNum'];
	$password = $obj['password'];
	$password = hash('sha256', $password);
	$name = $obj['name'];
	$email = $obj['email'];
	$address = $obj['address'];
	$accType = $obj['accType'];

if ($obj['accType'] == "Sender")
{
	
	$company = $obj['company'];

	$sql = "
	INSERT INTO all_accounts (accountID, username, phoneNum, password, name, email, address, accType) 
	VALUES ('$accountID', '$username', '$pnumber', '$password', '$name', '$email', '$address', '$accType');";
	
	$sql1 = "INSERT INTO sender_account (accountID, company) VALUES('$accountID', '$company');";
}

elseif ($obj['accType'] == "Courier")
{
	$company = $obj['company'];
	$empID = $obj['empID'];

	$sql = "INSERT INTO all_accounts 
	(accountID, username, phoneNum, password, name, email, address, accType) VALUES (
    '$accountID', '$username', '$pnumber', '$password', '$name', '$email', '$address', '$accType');";

    $sql1 = "
    INSERT INTO courier_account
    (accountID, company, empID) VALUES
    ('$accountID', '$company', '$empID');";
}
else
{
	$altContactPerson = $obj['altContactPerson'];
	$altPhoneNum = $obj['altPhoneNum'];

	$sql = "INSERT INTO all_accounts 
	(accountID, username, phoneNum, password, name, email, address, accType) VALUES (
    '$accountID', '$username', '$pnumber', '$password', '$name', '$email', '$address', '$accType');";

    $sql1 = "
    INSERT INTO receiver_account
    (accountID, altContactPerson, altPhoneNum) VALUES
    ('$accountID', '$altContactPerson', '$altPhoneNum');";
}

if (mysqli_query($con, $sql) AND mysqli_query($con, $sql1))
    echo json_encode(array("state" => "Success"));
else
{
    $error = mysqli_error($con);
    echo json_encode(array("state" => $error));   
}

//Insert into db

/* Sender/Courier
{
"accountID" : "T100",
"username":"T10",
"phoneNum":"0123456",
"password":"pass",
"name":"Jack",
"email":"Thisemail",
"address":"thisaddress",
"accType" :"Sender",
"company":"ABC inc"
}

Receiver
{
"accountID" : "T101",
"username":"T11",
"phoneNum":"012654",
"password":"pass",
"name":"Jack",
"email":"Thisemail",
"address":"thisaddress",
"accType" :"Receiver",
"altContactPerson":"Jack13",
"altPhoneNum":"0129876543"
}
*/
mysqli_close($con);
?>