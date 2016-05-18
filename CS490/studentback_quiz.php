<?php
require_once("student_connect.php.inc");
$exe = new localDB("connect.ini");
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
switch ($recieve["role"]) {
  case 'printQuiz':
    $student = $recieve["username"];
    $response = $exe->printQuiz($student);
    echo json_encode($response);
    break;

  case 'grade':
   $quiztitle = $recieve["quiztitle"];
   $response = $exe->getAns($quiztitle);
   echo json_encode($response);
   break;

 case 'insert_grade':
  $quiztitle = $recieve["quiztitle"];
  $grade = $recieve["grade"];
  $username = $recieve["username"];
  $response = $exe->insertGrade($quiztitle,$grade,$username);
  echo json_encode($response);
  break;

  case 'mygrade':
   $username = $recieve["username"];
   $response = $exe->myGrade($username);
   echo json_encode($response);
   break;

  case 'feedback':
    $stud_answer = array();
    $feed_feedback= array();
    $quiztitle = $recieve["quiztitle"];
    $grade = $recieve["grade"];
    $username = $recieve["username"];
    $stud_answer = $recieve["stud_answer"];
    $feed_feedback = $recieve["feed_feedback"];
    $response = $exe->feed($quiztitle, $username, $stud_answer,$feed_feedback);
    echo json_encode($response);
    break;

  case 'studentfeedback':
   $username = $recieve["username"];
   $quiztitle = $recieve["quiztitle"];
   $response = $exe->studentFeedback($username,$quiztitle);
   echo json_encode($response);
   break;

 case 'questioninfo':
   $questionID = $recieve['questionID'];
   $questionType = $recieve['questionType'];
   $teacherID = $recieve['teacherID'];
   $exe = new localDB("connect.ini");
   $response = $exe->questionInfo($questionID,$questionType,$teacherID);
   echo json_encode($response);
   break;
  default:
    # code...
    break;
}

?>
