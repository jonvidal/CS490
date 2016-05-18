<?php
$result_table = '';
$send = json_encode(array("username"=>$user));
$csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_questionbank.php");
curl_setopt_array($csession, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $send,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));

$request = curl_exec($csession);
curl_close($csession);
$respond=json_decode($request, true);
for($x = 1; $x <=(count($respond)/4); $x++){

  $row .= "<tr position='".$respond["$x"."type"]."'><td>$x</td><td>".$respond["$x"]."</td><td>".$respond["$x"."type"]."</td><td>".$respond["$x"."points"]."</td><td>
            <input type='checkbox' name='questionID[]' value='".$respond["$x"."ID"]."|".$respond["$x"."type"]."''/></td></tr>";

}
$result_table = $row;


 ?>
