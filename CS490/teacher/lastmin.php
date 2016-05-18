<?php
$result_table = '';
$row = '';
$send = json_encode(array("username"=>$user, "role"=>"MC"));
$csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($csession, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $send,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));

$request = curl_exec($csession);
curl_close($csession);
$respond=json_decode($request,true);
//echo "<br/><br/><br/>";
//var_dump($respond);
//echo $request;
for($x = 1; $x <=(count($respond)); $x++){

  $row .= "<tr><td align='left' valign='top' ><span>$x.  </span></td><td>".$respond["$x"]."</td></tr>";

}
$result_table = "<table id='mytable' class='table'><thead><th id='sl' class='lead' align='left' valign='top' style='cursor:pointer;'>#</th><th id='nm' class='lead' align='left' valign='top' style='cursor:pointer;'>Question</th></thead><tbody>".$row."</tbody></table>";

/////////////////////////////////////////////////////////////
$result_tableTF = '';
$rowTF = '';
$sendTF = json_encode(array("username"=>$user, "role"=>"TF"));
$csessionTF = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($csessionTF, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $sendTF,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));

$requestTF = curl_exec($csessionTF);
curl_close($csessionTF);
$respondTF=json_decode($requestTF,true);
//echo "<br/><br/><br/>";
//var_dump($respondTF);
//echo $requestTF;
for($x = 1; $x <=(count($respondTF)); $x++){

  $rowTF .= "<tr position='".$respondTF["$x"]."'><td align='left' valign='top' ><span>$x.  </span></td><td>".$respondTF["$x"]."</td></tr>";

}
$result_tableTF = "<table id='mytableTF' class='table'><thead><th id='slTF' class='lead' align='left' valign='top' style='cursor:pointer;'>#</th><th id='nmTF' class='lead' align='left' valign='top' style='cursor:pointer;'>Question</th></thead>".$rowTF."</table>";


/////////////////////////////////////////////////////////////
$result_tableFB = '';
$rowFB = '';
$sendFB = json_encode(array("username"=>$user, "role"=>"FB"));
$csessionFB = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($csessionFB, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $sendFB,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));

$requestFB = curl_exec($csessionFB);
curl_close($csessionFB);
$respondFB=json_decode($requestFB,true);
//echo "<br/><br/><br/>";
//var_dump($respondFB);
//echo $request;
for($x = 1; $x <=(count($respondFB)); $x++){

  $rowFB .= "<tr><td align='left' valign='top' ><span>$x.  </span></td><td>".$respondFB["$x"]."</td></tr>";

}
$result_tableFB = "<table id='mytableFB' class='table'><thead><th id='slFB' class='lead' align='left' valign='top' style='cursor:pointer;'>#</th><th id='nmFB' class='lead' align='left' valign='top' style='cursor:pointer;'>Question</th></thead>".$rowFB."</table>";



/////////////////////////////////////////////////////////////
$result_tableOE = '';
$rowOE = '';
$sendOE = json_encode(array("username"=>$user, "role"=>"OE"));
$csessionOE = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($csessionOE, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $sendOE,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));

$requestOE = curl_exec($csessionOE);
curl_close($csessionOE);
$respondOE=json_decode($requestOE,true);
//echo "<br/><br/><br/>";
//var_dump($respondFB);
//echo $requestOE;
for($x = 1; $x <=(count($respondOE)); $x++){

  $rowOE .= "<tr position='".$respondOE["$x"]."'><td align='left' valign='top' ><span>$x.  </span></td><td>".$respondOE["$x"]."</td></tr>";

}
$result_tableOE = "<table id='mytableOE' class='table'><thead><th id='slOE' class='lead' align='left' valign='top' style='cursor:pointer;'>#</th><th id='nmOE' class='lead' align='left' valign='top' style='cursor:pointer;'>Question</th></thead>".$rowOE."</table>";


 ?>
