<?php
$grade = "";
$mygrade = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/studentmiddle_quiz.php");
curl_setopt_array($mygrade, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS =>json_encode(array('username' => $user, 'role' => 'mygrade')),
  CURLOPT_RETURNTRANSFER =>true,
));
$request = curl_exec($mygrade);
curl_close($mygrade);
$results = json_decode($request);
var_dump($results);

?>
