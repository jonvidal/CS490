<?php

$split_curl = curl_init("http://osl81.njit.edu/~jkv5/CS490/middle_quiz.php");
$split_question = json_encode(array('username' => $user, 'role' => 'split'));
curl_setopt_array($split_curl, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS => $split_question,
  CURLOPT_FOLLOWLOCATION=>true,
  CURLOPT_RETURNTRANSFER =>true,
  CURLOPT_SSL_VERIFYPEER=>false,
));
$question_results = curl_exec($split_curl);
curl_close($split_curl);
$question_responds=json_decode($question_results, true);


$error = "";
$success = "";
if (isset($_POST['add'])){
  if (empty($_POST['question']) || empty($_POST['ans'])){
    $error = "<div class='alert alert-danger'>Please Complete The Form</div>";
  }else{
    switch ($_POST['questionType']) {
      case 'TF':
        $questionTF = $_POST['question'];
        $answerTF = $_POST['ans'];
        $typeTF = $_POST['questionType'];
        if (!empty($_POST['points'])){
          $points = $_POST['points'];
          $send = json_encode(array("questionTF"=>$questionTF,"answerTF"=>$answerTF,"type"=>$typeTF,"username"=>$user,"points"=>$points));
          $csession = curl_init("http://osl81.njit.edu/~jkv5/CS490/middle_sending.php");
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
          if ($respond['success'] == true){
            $success = "<div class='alert alert-success'>Added Successfully!</div>";
          }
        }else $error = "<div class='alert alert-danger'>Please Enter The Points For This Question</div>";
        break;

      case 'MC':
        $questionMC = $_POST['question'];
        $answerMC = $_POST['ans'];
        $typeMC = $_POST['questionType'];
        if ( empty($_POST['optA']) || empty($_POST['optB']) || empty($_POST['optC']) || empty($_POST['optD']) ){
          $error = "<div class='alert alert-danger'>Please Complete The Form</div>";
        }else{
          if (!empty($_POST['points'])){
            $points = $_POST['points'];
            $optOne = $_POST['optA'];
            $optTwo = $_POST['optB'];
            $optThree = $_POST['optC'];
            $optFour = $_POST['optD'];

            $send = json_encode(array("questionMC"=>$questionMC,"answerMC"=>$answerMC,"type"=>$typeMC,"username"=>$user,"optA"=>$optOne,
                  "optB"=>$optTwo,"optC"=>$optThree,"optD"=>$optFour,"points"=>$points));
            $csession = curl_init("http://osl81.njit.edu/~jkv5/CS490/middle_sending.php");
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
              if ($respond['success'] == true){
                $success = "<div class='alert alert-success'>Added Successfully!</div>";
              }
            }else $error = "<div class='alert alert-danger'>Please Enter The Points For This Question</div>";
          }
        break;

      case 'OE':
        $questionOE = $_POST['question'];
        $answerOE = $_POST['ans'];
        $typeOE = $_POST['questionType'];
        $functionName = $_POST['function'];
        $testcase  = array();
        $tcanswer = array();
        if (!empty($_POST['points'])){
          $points = $_POST['points'];
          $count = 0;
          //echo "<br/><br/><br/>";
          for ($i = 1; $i<=5; $i++){
            if ((!empty($_POST['testcase'.$i]))&&(!empty($_POST['answer'.$i]))){
              $testcase["$i"] = $_POST["testcase".$i];
              $tcanswer["$i"] = $_POST['answer'.$i];
              $count ++;
            }
          }
          if($count != 0){
            $send = json_encode(array("questionOE"=>$questionOE,"answerOE"=>$answerOE,"type"=>$typeOE,"username"=>$user, "functionName"=>$functionName,"tcanswer"=>$tcanswer,"points"=>$points,"testcase"=>$testcase, "count"=>$count));
              $csession = curl_init("http://osl81.njit.edu/~jkv5/CS490/middle_sending.php");
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
              if ($respond['success'] == true){
                $success = "<div class='alert alert-success'>Added Successfully!</div>";
              }
              //echo "<br/><br/><br/>";
              //echo $request;

            //echo $functionName."<br/>";
            //echo $points."<br/>";
          }else $error = "<div class='alert alert-danger'>Please, Include One Test Case and Answer</div>";
        }else $error = "<div class='alert alert-danger'>Please Enter The Points For This Question</div>";
      break;

      case 'FB':
        $questionFB = $_POST['question'];
        $answerFB = $_POST['ans'];
        $typeFB = $_POST['questionType'];
        if ( empty($_POST['optA']) || empty($_POST['optB']) || empty($_POST['optC']) || empty($_POST['optD']) ){
          $error = "<div class='alert alert-danger'>Please Complete The Form</div>";
        }else{
          if (!empty($_POST['points'])){
            $points = $_POST['points'];
            $optOne = $_POST['optA'];
            $optTwo = $_POST['optB'];
            $optThree = $_POST['optC'];
            $optFour = $_POST['optD'];

            $send = json_encode(array("questionFB"=>$questionFB,"answerFB"=>$answerFB,"type"=>$typeFB,"username"=>$user,"optA"=>$optOne,
                  "optB"=>$optTwo,"optC"=>$optThree,"optD"=>$optFour,"points"=>$points));
            $csession = curl_init("http://osl81.njit.edu/~jkv5/CS490/middle_sending.php");
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
            if ($respond['success'] == true){
              $success = "<div class='alert alert-success'>Added Successfully!</div>";
            }
          }else $error = "<div class='alert alert-danger'>Please Enter The Points For This Question</div>";
        }
        break;



      default:
        # code...
        break;
    }

  }

}





 ?>
