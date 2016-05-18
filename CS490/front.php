<?php
  //recieving the user's input with POST method and placing them in associative array. And encode for middle end to decode.
  $credential = json_encode(array("ucid" => $_POST["ucid"],"pwd" => $_POST["pwd"]));
  $csession = curl_init("http://osl84.njit.edu/~jkv5/CS490/middle.php");
  curl_setopt_array($csession, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS => $credential,
    CURLOPT_FOLLOWLOCATION=>true,
    CURLOPT_RETURNTRANSFER =>true,
    CURLOPT_SSL_VERIFYPEER=>false,
  ));
  $request = curl_exec($csession);
  curl_close($csession);
  //decoding the respond of the middle end
  $respond=json_decode($request, true);

  if($respond['localdb'] == true ) echo "Welcome ".$_POST['ucid'].", to the local database.<br/>";
  else echo "You are not welcome to the local database, ".$_POST['ucid']."!<br/>";

  if($respond['njitdb'] == true ) echo "NJIT knows you. Welcome, ".$_POST['ucid']."!<br/>";
  else echo "NJIT doesn't know you. Goodbye, ".$_POST['ucid']."!<br/>";



?>
