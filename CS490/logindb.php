<?php
  echo "Testing<br/>";
	//$username = $_POST['ucid'];
	//$password = $_POST['password'];
  $username = "jkv5";
  $username = "pass123";
	$login = new studentDB();
	$response = $login->validateStudent($username,$password);
	if ($response===true){
		$response = "Login Successful!<p>";
	}else{
		$response = "Login Failed:<p>";
	}
  echo $response;

?>
