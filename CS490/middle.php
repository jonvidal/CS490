<?php
	//temp testing
	$request = file_get_contents("php://input");
	$recieve = json_decode($request, true);
	$user = $recieve["userName"];
	$pass = $recieve["passWord"];
	$localdb_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back.php";
	//Associative Array
	$return_result = array();

	//Authentication To Local DB]
 $localdb_auth=curl_init($localdb_url);
 curl_setopt_array($localdb_auth, array(
	 CURLOPT_POST => true,
	 CURLOPT_POSTFIELDS=> json_encode(array("userName" => $user,"passWord" => $pass)),
	 CURLOPT_RETURNTRANSFER => true
 ));
 $localdb_result = curl_exec($localdb_auth);
 curl_close($localdb_auth);
 $results = json_decode($localdb_result,true);
 echo json_encode($results);
?>
