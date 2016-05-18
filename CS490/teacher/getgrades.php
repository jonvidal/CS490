<?php
$release_respond= "";
if (isset($_POST['submit'])){
  //var_dump($_POST);
  $curl_release_grades = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
  curl_setopt_array($curl_release_grades, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS =>json_encode(array('username'=>$user, 'role' => $_POST['release'])),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $release_grades_request = curl_exec($curl_release_grades);
  curl_close($curl_release_grades);
  $results_release = json_decode($release_grades_request,true);
  if ($results_release['success']==true){
    $release_respond = "<div class='alert alert-success'>Successfully Released The Grades</div>";
  }
  echo $release_respond;

}


$table_grades ="";
$form="";
$csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($csession, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS =>json_encode(array('username'=>$user, 'role' => 'getgrades')),
  CURLOPT_RETURNTRANSFER =>true,
));
$request = curl_exec($csession);
curl_close($csession);
$response=json_decode($request, true);
//var_dump($response);
if ($response['success']==true){
  $count = count($response['message']);
  for ($x = 1; $x<=$count; $x++){
    $count_array = count($response['message']["$x"]);
    $array = $response['message']["$x"];

    for ($j = 0; $j < $count_array; $j=$j+3){
      $one = $j+1;
      $two = $j+2;
      $row_grades .= "<button type='submit' class='btn btn-default' style='width:100%' name='grade' value='".$array["$j"]."|".$array["$one"]."|".$array["$two"]."'><table style='style='padding:5px;padding-right:50px;'><tr><td><b>Quiz Title: </b> ".$array["$j"]."</td><td style='padding:5px;padding-left:50px;'><b>Student: </b> ".$array["$one"]."</td><td style='padding:5px;padding-left:50px;'><b>Grade: </b> ".$array["$two"]."</td></tr></table></button>";
      //$student_grades = "";
    }
  }
  $table_grades = "<form action='results.php' method='post'><div>".$row_grades."</div></form>";

  $form = "<div><form action='' method='post'><input type='hidden' name='release' value='release'><input type='submit' class='btn btn-default' name='submit' value='Release Grades' style='margin-bottom:10px;width:100%;'></form><div>";
  $row_grades="";
}else{
  $table_grades = "<div class='table-responsive'><table class='table'><tr><td>No Grades</td></tr><table></div>";
}
echo $form;
echo $table_grades;



?>
