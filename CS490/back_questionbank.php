<?php
require_once("connect.php.inc");
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
$username = $recieve["username"];
$execute = new localDB("connect.ini");
$response = $execute->printQuestion($username);
echo json_encode($response);
?>
