<?php
require_once("connect.php.inc");
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
$type = $recieve['type'];
switch ($type) {
    case 'TF':
        $questionTF = $recieve['questionTF'];
        $answerTF = $recieve['answerTF'];
        $username = $recieve['username'];
        $points = $recieve['points'];
        $execute = new localDB("connect.ini");
        $response = $execute->TrueorFalse($questionTF,$answerTF, $username,$points);
        if ($response["success"]===true){
          $return_result = array("success" => true);
          echo json_encode($return_result);
        }
    break;
    case 'MC':
        $questionMC = $recieve['questionMC'];
        $answerMC = $recieve['answerMC'];
        $username = $recieve['username'];
        $points = $recieve['points'];
        $execute = new localDB("connect.ini");
        $optOne = $recieve['optA'];
        $optTwo = $recieve['optB'];
        $optThree = $recieve['optC'];
        $optFour = $recieve['optD'];
        $response = $execute->MultipleChoice($questionMC,$answerMC, $username,$optOne,$optTwo,$optThree,$optFour,$points);
        if ($response["success"]===true){
          $return_result = array("success" => true);
          echo json_encode($return_result);
        }
    break;

    case 'OE':
        $testcase = array();
        $tcanswer = array();
        $questionOE = $recieve['questionOE'];
        $answerOE = $recieve['answerOE'];
        $username = $recieve['username'];
        $functionName = $recieve['functionName'];
        $points = $recieve['points'];
        $tcanswer = $recieve['tcanswer'];
        $testcase = $recieve['testcase'];
        $count = $recieve['count'];
        $execute = new localDB("connect.ini");
        //var_dump($recieve);
        $response = $execute->OpenEnded($questionOE,$answerOE, $username, $testcase, $points, $tcanswer, $functionName,$count);
        if ($response["success"]===true){
          $return_result = array("success" => true);
          echo json_encode($return_result);
        }
      break;
      case 'FB':
          $questionFB = $recieve['questionFB'];
          $answerFB = $recieve['answerFB'];
          $username = $recieve['username'];
          $optOne = $recieve['optA'];
          $optTwo = $recieve['optB'];
          $optThree = $recieve['optC'];
          $optFour = $recieve['optD'];
          $points = $recieve['points'];
          $execute = new localDB("connect.ini");
          $response = $execute->FillInTheBlank($questionFB,$answerFB,$username,$optOne,$optTwo,$optThree,$optFour,$points);
          if ($response["success"]===true){
            $return_result = array("success" => true);
            echo json_encode($return_result);
          }
        break;

  default:
    # code...
    break;
}

?>
