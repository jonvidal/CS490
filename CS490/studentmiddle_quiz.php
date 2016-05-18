<?php
/*
$cod = '';
$filename = realpath("myjava.java");
$cod = "import java.util.*; public class myjava{public static void main (String[] args){System.out.println(sumDouble(1, 2));}public static int sumDouble(int a, int b) { int sum = a + b; if (a == b) { sum = sum * 2; } return sum; }}";
var_dump(file_put_contents($filename,$cod, FILE_APPEND));
$output="";
exec("javac $filename");

//echo exec("whoami")."<br/>";
$file = "myjava.class";
if(file_exists($file) == true){
  $count++;
  $output = shell_exec("java myjava");
  exec("rm myjava.class");
}
file_put_contents($filename, "");
echo $output;
*/

$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
switch ($recieve['role']) {
  case 'printQuiz':
    $role = 'printQuiz';
    $username = $recieve['username'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/studentback_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('role' => $role,'username'=>$username)),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'grade':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $role = $recieve['role'];
    $numberofquestions = $recieve['numberofquestions'];
    $answer = array();
    for ($i=1;$i<=$numberofquestions;$i++){
      $answer["$i"] = $recieve["$i"];
    }
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/studentback_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle, 'role' => $role)),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);

//***************GRADING SYSTEMT******************
    $points = 0; $totalpoints = 0; $feed_answer = array(); $feed_feedback = array();
    //var_dump($respond);
    for ($x=1;$x<=$numberofquestions;$x++){
      $feed_answer["$x"] = $answer["$x"];
      $totalpoints+=$respond["$x"]["points"];
      if ($respond["$x"]["type"] == 'TF') {
        if($respond["$x"]["answer"]==$answer["$x"]) $points+=$respond["$x"]["points"];
      }else if ($respond["$x"]["type"] == 'FB'){
        if($respond["$x"]["answer"]==$answer["$x"]) $points+=$respond["$x"]["points"];
      }
      else if ($respond["$x"]["type"] == 'MC'){
        if($respond["$x"]["answer"]==$answer["$x"]) $points+=$respond["$x"]["points"];
      }else{
        $filename = "openended.java";
        $class = "import java.util.*;
                 public class openended{";
        $header = "public static void main (String[] args){";

        $quiz_points = $respond["$x"]["points"];
        $counter = 0;
        $count = 0;
        $openended_grade = 0;

       if(!empty($respond["$x"]["testcase1"])&&!empty($respond["$x"]["answer1"])){
          $java = '';
          $counter+=2;
          $testcase1 = "System.out.println(".$respond["$x"]["testcase1"].");}";
          $function = $answer["$x"]."}";
          $answer1 = $respond["$x"]["answer1"];
          $java = $class.$header.$testcase1.$function;


          file_put_contents($filename,$java, FILE_APPEND);
          $output="";
          exec("javac openended.java 2>&1",$out,$ret);
          if($ret !== 0) {
            $feed_feedback["testcase1"] = $out[0];
          }else{
          //echo exec("whoami")."<br/>";
            $file = "openended.class";
            if(file_exists($file) == true){
              $output = exec("java openended");
              exec("rm openended.class");
              $count++;
            }
            file_put_contents($filename, "");
            //$output = preg_replace('/\s+/', '', $output);
            if($output == $answer1){
              $feed_feedback["testcase1"] = $output;
              $count++;
              //echo "TestCase #1 <br/>";
            }else $feed_feedback["testcase1"] = $output;
          }
         //echo "Output #1= ".$output."<br/>";
         //echo "Answer #1 = ".$answer1."<br/>";

        }

        if(!empty($respond["$x"]["testcase2"])&&!empty($respond["$x"]["answer2"])){
          $java = '';
          $counter+=2;
          $testcase2 =  "System.out.println(".$respond["$x"]["testcase2"].");}";
          $function = $answer["$x"]."}";
          $answer2 = $respond["$x"]["answer2"];
          $java = $class.$header.$testcase2.$function;
          //echo $testcase2." = ".$answer2."<br/>";

          file_put_contents($filename,$java, FILE_APPEND);
          $output="";
          exec("javac openended.java 2>&1",$out,$ret);
          if($ret !== 0) {
            $feed_feedback["testcase2"] = $out[0];
          }else {
            $file = "openended.class";
            if(file_exists($file) == true){

              $output = exec("java openended");
              exec("rm openended.class");
              $count++;
            }
            file_put_contents($filename, "");
            //$output = preg_replace('/\s+/', '', $output);
            if($output == $answer2){
              $feed_feedback["testcase2"] = $output;
              $count++;
              //echo "TestCase #2 <br/>";
            }else $feed_feedback["testcase2"] = $output;
          }
          //echo "Output #2= ".$output."<br/>";
          //echo "Answer #2 = ".$answer2."<br/>";
        }

        if(!empty($respond["$x"]["testcase3"])&&!empty($respond["$x"]["answer3"])){
          $java = '';
          $counter+=2;
          $testcase3 = "System.out.println(".$respond["$x"]["testcase3"].");}";
          $function = $answer["$x"]."}";
          $answer3 = $respond["$x"]["answer3"];
          $java = $class.$header.$testcase3.$function;
          //echo $testcase3." = ".$answer3."<br/>";

          file_put_contents($filename,$java, FILE_APPEND);
          $output="";
          exec("javac openended.java 2>&1",$out,$ret);
          if($ret !== 0) {
            $feed_feedback["testcase3"] = $out[0];
          }else {
            $file = "openended.class";
            if(file_exists($file) == true){
              $output = exec("java openended");

              exec("rm openended.class");
              $count++;
            }
            file_put_contents($filename, "");
            //$output = preg_replace('/\s+/', '', $output);
            if($output == $answer3){
              $feed_feedback["testcase3"] = $output;
              $count++;
              //echo "TestCase #3 <br/>";
            }else $feed_feedback["testcase3"] = $output;
          }
          //echo "Output #3= ".$output."<br/>";
          //echo "Answer #3 = ".$answer3."<br/>";

        }
        if(!empty($respond["$x"]["testcase4"])&&!empty($respond["$x"]["answer4"])){
          $java = '';
          $counter+=2;
          $testcase4 =  "System.out.println(".$respond["$x"]["testcase4"].");}";
          $function = $answer["$x"]."}";
          $answer4 = $respond["$x"]["answer4"];
          $java = $class.$header.$testcase4.$function;
          //echo $testcase4." = ".$answer4."<br/>";

          file_put_contents($filename,$java, FILE_APPEND);
          $output="";
          exec("javac openended.java 2>&1",$out,$ret);
          if($ret !== 0) {
            $feed_feedback["testcase4"] = $out[0];
          }else{
            $file = "openended.class";
            if(file_exists($file) == true){
              $output = shell_exec("java openended");
              exec("rm openended.class");
              $count++;
            }
            file_put_contents($filename, "");
            $output = preg_replace('/\s+/', '', $output);
            if($output == $answer4){
              $feed_feedback["testcase4"] = $output;
              $count++;
            }else $feed_feedback["testcase4"] = $output;
          }
          //echo "TestCase #4 <br/>";
          //echo "Output #4= ".$output."<br/>";
          //echo "Answer #4 = ".$answer4."<br/>";

        }
        if(!empty($respond["$x"]["testcase5"])&&!empty($respond["$x"]["answer5"])){
          $java = '';
          $counter+=2;
          $testcase5 =  "System.out.println(".$respond["$x"]["testcase5"].");}";
          $function = $answer["$x"]."}";
          $answer5 = $respond["$x"]["answer5"];
          $java = $class.$header.$testcase5.$function;
          //echo $testcase5." = ".$answer5."<br/>";

          file_put_contents($filename,$java, FILE_APPEND);
          $output="";
          exec("javac openended.java 2>&1",$out,$ret);
          if($ret !== 0) {
            $feed_feedback["testcase5"] = $out[0];
          }else {
            $file = "openended.class";
            if(file_exists($file) == true){
              $output = shell_exec("java openended");
              exec("rm openended.class");
              $count++;
            }
            file_put_contents($filename, "");
            $output = preg_replace('/\s+/', '', $output);

            if($output == $answer5){
              $feed_feedback["testcase5"] = $output;
              $count++;
            }else $feed_feedback["testcase5"] = $output;
          }
          //echo "TestCase #5 <br/>";
          //echo "Output #5= ".$output."<br/>";
          //echo "Answer #5 = ".$answer5."<br/>";

        }
        $score = 0;
        $openended_grade = ($count/$counter)*100;
        $score = round(($openended_grade/100)*$quiz_points);
        //echo $score."<br/>";
        $points+=$score;

      }
   }
   //echo "hello";
   //var_dump($feed_feedback);
   $quizgrade = round(($points/$totalpoints)*100);

   //var_dump( $quizgrade);

    $gradesession = curl_init($back_url);
    curl_setopt_array($gradesession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle, 'role' => 'insert_grade', 'grade' => $quizgrade, 'username'=>$username)),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $resulting = curl_exec($gradesession);
    curl_close($gradesession);
    $outcome=json_decode($resulting, true);
    //var_dump($outcome);
    if($outcome['success']==true){    //insert the student's answers to feedback table
      $feedback = curl_init($back_url);
      curl_setopt_array($feedback, array(
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle, 'role' => 'feedback', 'stud_answer'=>$feed_answer,
                              'feed_feedback'=>$feed_feedback,'username'=>$username)),
        CURLOPT_RETURNTRANSFER =>true,
      ));
      $result = curl_exec($feedback);
      curl_close($feedback);
      $out = json_decode($result, true);
      //var_dump($out);
    }

    break;

    case 'mygrade':
      $role = 'mygrade';
      $username = $recieve['username'];
      $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/studentback_quiz.php";
      $csession = curl_init($back_url);
      curl_setopt_array($csession, array(
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => json_encode(array('role' => $role,'username'=>$username)),
        CURLOPT_RETURNTRANSFER =>true,
      ));
      $request = curl_exec($csession);
      curl_close($csession);
      $respond=json_decode($request, true);
      echo json_encode($respond);
      break;

    case 'studentfeedback':
      $role = 'studentfeedback';
      $username = $recieve['username'];
      $quiztitle = $recieve['quiztitle'];
      $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/studentback_quiz.php";
      $csession = curl_init($back_url);
      curl_setopt_array($csession, array(
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => json_encode(array('role' => $role,'username'=>$username,'quiztitle'=>$quiztitle)),
        CURLOPT_RETURNTRANSFER =>true,
      ));
      $request = curl_exec($csession);
      curl_close($csession);
      $respond=json_decode($request, true);
      echo json_encode($respond);
      break;

    case 'questioninfo':
      $questionID = $recieve['questionID'];
      $questionType = $recieve['questionType'];
      $teacherID = $recieve['teacherID'];
      $role = $recieve['role'];
      $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/studentback_quiz.php";
      $csession = curl_init($back_url);
      curl_setopt_array($csession, array(
        CURLOPT_POST =>true,
        CURLOPT_POSTFIELDS => json_encode(array('teacherID' => $teacherID, 'questionID'=>$questionID,'questionType' =>  $questionType,'role' => $role )),
        CURLOPT_RETURNTRANSFER =>true,
      ));
      $request = curl_exec($csession);
      //echo $request;
      curl_close($csession);
      $respond=json_decode($request, true);
      echo json_encode($respond);
      break;


  default:
    # code...
    break;
}



  ?>
