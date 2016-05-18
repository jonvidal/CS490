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
$results = json_decode($request,true);
//var_dump($results);

if($results['success']==true){
  $count = count($results['message']);
  $message = $results['message'];
  for ($x=1;$x<=$count;$x++){
    $loop = count($message["$x"]);
    $content = $message["$x"];
    if($content[1]!=false){
      $quiztitle = $content[0];
      $grade = $content[1];
      $row_grade .= "<button type='submit' class='btn btn-default' style='width:100%' name='mygrade' value='".$quiztitle."'><table style='padding:5px;padding-right:50px;'><tr><td></td><td><b>Quiz Title: </b> ".$content[0]."</td></td><td style='padding:5px;padding-left:50px;'><b>Grade: </b> <span>".$grade."</span></td></tr></table></button>";
    }else{
        $row_grade .= "<button type='submit' class='btn btn-default' style='width:100%' name='grade' disabled><table style='padding:5px;padding-right:50px;'><tr><td><b>Quiz Title: </b> ".$content[0]."</td><td style='padding:5px;padding-left:50px;'><b>Grade: </b> Waiting to be released...</td></tr></table></button>";
    }
    $table_grade .= "<form action='myresults.php' method='post'><div>".$row_grade."</div></form>";
    $row_grade="";
  }

}
echo $table.$table_grade;

?>
