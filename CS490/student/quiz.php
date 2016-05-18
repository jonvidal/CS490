<?php

$comment="";
if (isset($_POST['submit'])){

  if ((!(count($_POST)==($_POST['numberofquestion']+3)))){
    foreach ($_POST as $key => $value){
      if (empty($key)){
        $comment = "<div class='alert alert-danger'>Please, answer all questions. Try again!</div>";
      }
    }
    $comment = "<div class='alert alert-danger'>Please, answer all questions. Try again!</div>";
  }else{

    $answer = array();
    for ($i = 1; $i<=$_POST['numberofquestion']; $i++){
      $answer["$i"] = $_POST["$i"];
    }
    $answer['quiztitle'] = $_POST['quizname'];
    $answer['numberofquestions'] = $_POST['numberofquestion'];
    $answer['username'] = $user;
    $answer['role'] = 'grade';
    $session = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/studentmiddle_quiz.php");
    curl_setopt_array($session, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS =>json_encode($answer),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $req = curl_exec($session);
    curl_close($session);
    $res=json_decode($req, true);
    //echo $req;
    if ($res['success']==true){
      $comment = "<div class='alert alert-success'>Successfully submitted!</div>";
    }
  }
 }
echo $comment;



$csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/studentmiddle_quiz.php");
curl_setopt_array($csession, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS =>json_encode(array('username'=>$user, 'role' => 'printQuiz')),
  CURLOPT_RETURNTRANSFER =>true,
));
$request = curl_exec($csession);
curl_close($csession);
$response=json_decode($request, true);

//var_dump($response);

if ($response['success']==true){
      $count = count($response['message']);
      if (!count($response['message'])==0){
        for($x = 1; $x<=$count; $x++){
          $middle = "";
          $name = $response['quizname']["$x"];
          $heading = "<div class='lead'>".$response['quizname']["$x"]."</div><div class='panel' style='padding:0px !important; margin:0px !important;overflow: scroll;overflow-x: hidden;'><p><form action='' method='post'><table>";
          $result = $response['message']["$x"];
          for($i = 1; $i<=count($result); $i++){
            $resulted = $result["$i"];
            $type = $resulted['type'];
            $echo = '';
            if ($type == 'TF'){
              $question = $resulted['question'];
              $answer = $resulted['answer'];
              $points = $resulted['points'];
              $true = "<input type='radio' name='".$i."' value='T'><span> True</span></input><span>&nbsp;&nbsp;</span>";
              $false = "<input type='radio' name='".$i."' value='F'><span> False</span></input>";
              //echo "<br/>TRUE OR FALSE<br/>";
              $middle .= "<tr><td style='padding:10px;' colspan=4>$i. ".$question." (".$points." pts.) </td></tr><tr><td colspan=4 style='padding-left:10px;padding-right:10px;'>".$true.$false."</td></tr>";
            }else if($type == 'FB'){
              $question = $resulted['question'];
              $answer = $resulted['answer'];
              $points = $resulted['points'];
              $optionOne = "<input type='radio' name='".$i."' value ='A'>"."<span>&nbsp;&nbsp;A)&nbsp;&nbsp;".$resulted['opt1']."</span>";
              $optionTwo =  "<input type='radio' name='".$i."' value ='B'>"."<span>&nbsp;&nbsp;B)&nbsp;&nbsp;".$resulted['opt2']."</span>";
              $optionThree =  "<input type='radio' name='".$i."' value ='C'>"."<span>&nbsp;&nbsp;C)&nbsp;&nbsp;".$resulted['opt3']."</span>";
              $optionFour =  "<input type='radio' name='".$i."' value ='D'>"."<span>&nbsp;&nbsp;D)&nbsp;&nbsp;".$resulted['opt4']."</span>";
              //echo "<br/>Fill In The Blank<br/>";
              $middle .= "<tr><td style='padding:10px;' colspan=4>$i. ".$question." (".$points." pts.) </td></tr>"."<tr><td style='padding-left:10px;'>".$optionOne."</td><td style='padding-left:10px;'> ".$optionTwo."</td><td style='padding-left:10px;'>".$optionThree."</td><td style='padding-left:10px;'>".$optionFour."</td></tr>";
            }
            else if($type == 'MC'){
              $question = $resulted['question'];
              $answer = $resulted['answer'];
              $points = $resulted['points'];
              $optionOne = "<input type='radio' name='".$i."' value ='A'>"."<span>&nbsp;&nbsp;A)&nbsp;&nbsp;".$resulted['opt1']."</span>";
              $optionTwo =  "<input type='radio' name='".$i."' value ='B'>"."<span>&nbsp;&nbsp;B)&nbsp;&nbsp;".$resulted['opt2']."</span>";
              $optionThree =  "<input type='radio' name='".$i."' value ='C'>"."<span>&nbsp;&nbsp;C)&nbsp;&nbsp;".$resulted['opt3']."</span>";
              $optionFour =  "<input type='radio' name='".$i."' value ='D'>"."<span>&nbsp;&nbsp;D)&nbsp;&nbsp;".$resulted['opt4']."</span>";
              //echo "<br/>MULTIPLE CHOICES<br/>";
              $middle .= "<tr><td style='padding:10px;' colspan=4>$i. ".$question." (".$points." pts.) </td></tr>"."<tr><td style='padding-left:10px;'>".$optionOne."</td><td style='padding-left:10px;'>".$optionTwo."</td><td style='padding-left:10px;'>".$optionThree."</td><td style='padding-left:10px;'>".$optionFour."</td></tr>";
            }else{
              $question = $resulted['question'];
              $answer = $resulted['answer'];
              $functionName = $resulted['functionName'];
              $points = $resulted['points'];
              $testcase1 = $resulted['testcase1'];
              $testcase2 = $resulted['testcase2'];
              $testcase3 = $resulted['testcase3'];
              $testcase4 = $resulted['testcase4'];
              $testcase5 = $resulted['testcase5'];
              $answer1 = $resulted['answer1'];
              $answer2 = $resulted['answer2'];
              $answer3 = $resulted['answer3'];
              $answer4 = $resulted['answer4'];
              $answer5 = $resulted['answer5'];
              $test1='';$test2='';$test3='';$test4='';$test5='';
              if(!empty($testcase1)&&!empty($answer1)){
                $test1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$testcase1." = ".$answer1."<br/>";
              }
              if(!empty($testcase2)&&!empty($answer2)){
                $test2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$testcase2." = ".$answer2."<br/>";
              }
              if(!empty($testcase3)&&!empty($answer3)){
                $test3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$testcase3." = ".$answer3."<br/>";
              }
              if(!empty($testcase4)&&!empty($answer4)){
                $test4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$testcase4." = ".$answer4."<br/>";
              }
              if(!empty($testcase5)&&!empty($answer5)){
                $test5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$testcase5." = ".$answer5."<br/>";
              }

              $middle .= "<tr><td colspan=4 style='padding:10px'>$i. ".$question." (".$points." pts.) <br/>".$test1.$test2.$test3.$test4.$test5."</td></tr>";
              $middle .= "<tr><td colspan=4 style='padding-left:10px;'><textarea name='".$i."' class='form-control' style='resize:none;height:300px;'>public static [data type] ".$functionName."(...){&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;}</textarea></td></tr>";
            }

          }
          $ending = "<tr><td colspan=4 style='padding-top:10px;padding-left:10px;'><input type='hidden' name='quizname' value='".$name."'><input type='hidden' name='numberofquestion' value='".($i-1)."'><input type='submit' class='btn btn-default' name='submit' value='Submit'></td></tr></table></form></p></div>";
          $echo .= $heading.$middle.$ending;
        }
      }else $echo = "<div class='container'><p class='lead'>No Quiz Assigned</p></div>";
    }else $echo = "<div class='container'><p class='lead'>No Quiz Assigned</p></div>";

    echo $echo;

 ?>
