<?php
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
$user = $recieve["username"];
$localdb_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_questionbank.php";
$localdb_auth=curl_init($localdb_url);
curl_setopt_array($localdb_auth, array(
 CURLOPT_POST => true,
 CURLOPT_POSTFIELDS=> json_encode(array("username" => $user)),
 CURLOPT_RETURNTRANSFER => true
));
$localdb_result = curl_exec($localdb_auth);
curl_close($localdb_auth);
$respond=json_decode($localdb_result, true);
//var_dump($localdb_result);
echo json_encode($respond);
?>
