<?php

// Importing DBConfig.php file.
include 'dbconfig.php';

// Creating connection.
$con = mysqli_connect($dhost, $dusername, $dpassword, $database);

// decoding the received JSON and store into $obj variable.
$obj = json_decode(file_get_contents('php://input'),true);

// Populate User email from JSON $obj array and store into $email.
$phoneNum = $obj["phoneNum"];

// Populate Password from JSON $obj array and store into $password.
$password = $obj["password"];
$password = hash('sha256', $password);
//Applying User Login query with email and password match.
$sqlquery = "SELECT * FROM all_accounts WHERE phoneNum = '$phoneNum' AND password = '$password'";

// Executing SQL Query.
$verify = mysqli_fetch_array(mysqli_query($con, $sqlquery));

if(isset($verify)){

$successmessage = array("state"=>"Success") + $verify;

}

else {

$successmessage = array("state" => "Failure");

// Echo the message.

}

// Converting the message into JSON format.
// Echo the message.
echo json_encode($successmessage);

/*
{"phoneNum": "0123456789", "password" : "pass"}
{"phoneNum": "0987654321", "password" : "pass"}
*/

mysqli_close($con);
?>