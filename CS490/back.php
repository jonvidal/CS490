<?php
require_once("connect.php.inc");
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
$username = $recieve["userName"];
$password = $recieve["passWord"];
$login = new localDB("connect.ini");
$response = $login->ValidateUserId($username,$password);
echo json_encode($response);
?>
