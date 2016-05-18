<?php
require_once("connect.php.inc");
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
switch ($recieve['role']) {
  case 'createquiztable':
    $quiztitle = $recieve['quiztitle'];
    $exe = new localDB("connect.ini");
    $response = $exe->createQuizTable($quiztitle);
    echo json_encode($response);
    break;
  case 'add':
    $quiztitle = $recieve['quiztitle'];
    $questionID = $recieve['questionID'];
    $questionType = $recieve['questionType'];
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->createQuiz($quiztitle, $questionID, $questionType, $username);
    echo json_encode($response);
    break;
  case 'printQuiz':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->MyQuiz($username);
    echo json_encode($response);
    break;
  case 'publish':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->publishQuiz($quiztitle,$username);
    echo json_encode($response);
    break;

  case 'getgrades':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->printStuGrad($username);
    echo json_encode($response);
    break;

  case 'release':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->releaseGrades($username);
    echo json_encode($response);
    break;

  case 'checker':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->checker($username);
    echo json_encode($response);
    break;

  case 'unpublish':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->unpublishQuiz($quiztitle,$username);
    echo json_encode($response);
    break;

  case 'deletemyquiz':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->deletemyQuiz($quiztitle,$username);
    echo json_encode($response);
    break;
  case 'getfeedback':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $student = $recieve['student'];
    $exe = new localDB("connect.ini");
    $response = $exe->feedback_teacher($quiztitle,$username,$student);
    echo json_encode($response);
    break;
  case 'questioninfo':
    $questionID = $recieve['questionID'];
    $questionType = $recieve['questionType'];
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->questionInfo($questionID,$questionType,$username);
    echo json_encode($response);
    break;
  case 'split':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->splitScreen($username);
    echo json_encode($response);
    break;
  case 'MC':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->printMC($username);
    echo json_encode($response);
    break;

  case 'TF':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->printTF($username);
    //var_dump($response);
    echo json_encode($response);
    break;

  case 'FB':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->printFB($username);
    echo json_encode($response);
    break;

  case 'OE':
    $username = $recieve['username'];
    $exe = new localDB("connect.ini");
    $response = $exe->printOE($username);
    echo json_encode($response);
    break;

  default:
    # code...
    break;
}


?>
