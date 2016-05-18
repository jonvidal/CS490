<?php
	//temp testing
	$user = "jkv5"; 		//temp -- waiting for the front end and back end code
	$pass = "pass123";	//not njit credentials
	$uuid = "0xAC021";
	$njit_url = "https://cp4.njit.edu/cp/home/login";
	$localdb_url = "http://web.njit.edu/~bkp4113/...";

	//Authentication To NJIT
	//WARNING: able to login on njit webpage with user's correct username
	//and password. But running the code with correct njit authentication
	//could disable user's njit account
	$auth_njit = curl_init($njit_url);
	curl_setopt_array($auth_njit, array(
		CURLOPT_POST =>true,
		CURLOPT_POSTFIELDS => "pass=$pass&user=$user&uuid=0xACA021",
		CURLOPT_USERAGENT=> $_SERVER['HTTP_USER_AGENT'],
		CURLOPT_FOLLOWLOCATION=>true,
		CURLOPT_RETURNTRANSFER =>true,
		CURLOPT_SSL_VERIFYHOST=>false,
		CURLOPT_SSL_VERIFYPEER=>false,
		CURLOPT_HEADER => true
	));
	//$last_url=curl_getinfo($auth_njit, CURLINFO_EFFECTIVE_URL);
	//print ($last_url)."<br/>";
	$njit_result = curl_exec($auth_njit);

	//var_dump(curl_exec($auth_njit));
	//print_r(curl_getinfo($auth_njit));

	//false - if there is an error executing the request
	//true - if the request executed without error and CURLOPT_RETURNTRANSFER is set to false
	//$njit_result - if the request executed without error and CURLOPT_RETURNTRANSFER is set to true
	if(!$njit_result){
    die('Error: "' . curl_error($auth_njit) . '" - Code: ' . curl_errno($auth_njit));
}

	$results = strpos($njit_result, "loginok.html") !== false;
	if ($results){
		echo "njit authentication - successfull"."<br/>";
		var_dump($results);
	} else echo "njit authentication - failed"."<br/>".var_dump($results);

	curl_close($auth_njit);
	echo $results;
	// return $results;

	//Authentication To Local DB]
 /*$localdb_auth=curl_init($localdb_url);
 curl_setopt_array($localdb_auth, array(
	 CURLOPT_POST => true,
	 CURLOPT_POSTFIELDS=> array(
		 "user" => $user,
		 "password" => $pass),
	 CURLOPT_RETURNTRANSFER=>true
 ));
 $localdb_result = curl_exec($localdb_auth);
 echo $localdb_results;*/

?>

