<?php
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
switch ($recieve['type']) {
  case 'TF':
    $questionTF = $recieve['questionTF'];
    $answerTF = $recieve['answerTF'];
    $username = $recieve['username'];
    $points = $recieve['points'];
    $adding_db = "http://afsaccess1.njit.edu/~jkv5/CS490/back_addquestion.php";

  	//Authentication To Local DB]
   $localdb=curl_init($adding_db);
   curl_setopt_array($localdb, array(
  	 CURLOPT_POST => true,
  	 CURLOPT_POSTFIELDS=> json_encode(array("questionTF" => $questionTF,"answerTF" => $answerTF, "type" => $recieve['type'], "username" => $username,"points"=>$points)),
  	 CURLOPT_RETURNTRANSFER => true
   ));
   $localdb_result = curl_exec($localdb);
   curl_close($localdb);
   echo json_encode($localdb_result);
   break;

  case 'OE':
    $testcase = array();
    $tcanswer = array();
    $questionOE = $recieve['questionOE'];
    $answerOE = $recieve['answerOE'];
    $username = $recieve['username'];
    $functionName = $recieve['functionName'];
    $pointsOE = $recieve['points'];
    $testcase = $recieve['testcase'];
    $tcanswer = $recieve['tcanswer'];
    $count = $recieve['count'];
    $adding_db = "http://afsaccess1.njit.edu/~jkv5/CS490/back_addquestion.php";
    $localdb=curl_init($adding_db);

    curl_setopt_array($localdb, array(
     	 CURLOPT_POST => true,
     	 CURLOPT_POSTFIELDS=> json_encode(array("questionOE" => $questionOE,"answerOE" => $answerOE, "type" => $recieve['type'], "username" => $username, "testcase" => $testcase, "functionName"=>$functionName,"tcanswer"=>$tcanswer,"points"=>$pointsOE, "count"=>$count)),
     	 CURLOPT_RETURNTRANSFER => true
    ));
    //var_dump($recieve);
    $localdb_result = curl_exec($localdb);
    curl_close($localdb);
    $respond=json_decode($localdb_result, true);
    echo json_encode($respond);
    //var_dump($localdb_result);
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
    $adding_db = "http://afsaccess1.njit.edu/~jkv5/CS490/back_addquestion.php";

    $localdb=curl_init($adding_db);

    curl_setopt_array($localdb, array(
     	 CURLOPT_POST => true,
     	 CURLOPT_POSTFIELDS=> json_encode(array("questionFB" => $questionFB,"answerFB" => $answerFB, "type" => $recieve['type'], "username" => $username,
                    "optA"=>$optOne,"optB"=>$optTwo,"optC"=>$optThree,"optD"=>$optFour,"points"=>$points)),
     	 CURLOPT_RETURNTRANSFER => true
    ));
    $localdb_result = curl_exec($localdb);
    curl_close($localdb);
    echo json_encode($localdb_result);

    break;

  case 'MC':
    $questionMC = $recieve['questionMC'];
    $answerMC = $recieve['answerMC'];
    $username = $recieve['username'];
    $optOne = $recieve['optA'];
    $optTwo = $recieve['optB'];
    $optThree = $recieve['optC'];
    $optFour = $recieve['optD'];
    $points = $recieve['points'];
    $adding_db = "http://afsaccess1.njit.edu/~jkv5/CS490/back_addquestion.php";
    $localdb=curl_init($adding_db);

    curl_setopt_array($localdb, array(
       CURLOPT_POST => true,
       CURLOPT_POSTFIELDS=> json_encode(array("questionMC" => $questionMC,"answerMC" => $answerMC, "type" => $recieve['type'], "username" => $username,
                    "optA"=>$optOne,"optB"=>$optTwo,"optC"=>$optThree,"optD"=>$optFour,"points"=>$points)),
       CURLOPT_RETURNTRANSFER => true
    ));
    $localdb_result = curl_exec($localdb);
    curl_close($localdb);
    echo json_encode($localdb_result);
    break;

  default:
    # code...
    break;
}

 ?>
