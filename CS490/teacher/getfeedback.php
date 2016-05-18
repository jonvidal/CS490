<?php
list($quiztitle,$student,$grade) = explode('|', $_POST['grade']);
//var_dump($quiztitle);
//var_dump($student);


$curl_feedback = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
curl_setopt_array($curl_feedback, array(
  CURLOPT_POST =>true,
  CURLOPT_POSTFIELDS =>json_encode(array('username'=>$user, 'quiztitle'=>$quiztitle,'student'=>$student,'role' => 'getfeedback')),
  CURLOPT_RETURNTRANSFER =>true,
));
$result_feedback = curl_exec($curl_feedback);
curl_close($curl_feedback);
$results_release = json_decode($result_feedback,true);


//var_dump($result_feedback);
if ($results_release['success']==true){
  $release_respond = count($results_release['message']);
  for($i=1;$i<=$release_respond;$i++){
    $feed = $results_release['message']["$i"];
    $questionID = $feed['questionID'];
    $answer = $feed['answer'];
    $questionType = $feed['questionType'];

    $get_question_info = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
    curl_setopt_array($get_question_info, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS =>json_encode(array('username'=>$user, 'questionID'=>$questionID,'questionType' =>  $questionType, 'role' => 'questioninfo')),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $result = curl_exec($get_question_info);
    curl_close($get_question_info);
    $feedback = json_decode($result,true);

    if ($feedback['success'] == true){
      $myfeedback = $feedback['message'];

      if ($questionType == "TF"){
        if($answer == $myfeedback['correctAns']){
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/checkmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }else{
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/Xmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }
        if($answer == $myfeedback['correctAns']){
          if($answer=='T') $middle .= "<tr><td colspan='2' style='padding-left:20px;'><span style='color:green'>True&nbsp;&nbsp;&nbsp;</span> <span>False</span></td></tr>";
          else $middle .= "<tr><td colspan='2' style='padding-left:20px;'><span>True&nbsp;&nbsp;&nbsp;</span> <span style='color:green'>False</span></td></tr>";
        }else{
          if($answer=='T') $middle .= "<tr><td colspan='2' style='padding-left:20px;'><span style='color:red'>True&nbsp;&nbsp;&nbsp;</span> <span>False</span></td></tr>";
          else $middle .= "<tr><td colspan='2' style='padding-left:20px;'><span>True&nbsp;&nbsp;&nbsp;</span> <span style='color:red'>False</span></td></tr>";
        }
        if ($feedback['message']=='T'){
          $middle .= "<tr><td colspan='2' style='padding-left:20px;'><b>Correct Answer:</b> True</td><td></td></tr>";
       }else{
         $middle .= "<tr><td colspan='2' style='padding-left:20px;'><b>Correct Answer:</b> False</td><td></td></tr>";
       }
      }else if($questionType == "FB"){
        if($answer == $myfeedback['correctAns']){
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/checkmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }else{
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/Xmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }
        if($answer == $myfeedback['correctAns']){
          if($answer=='A'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span style='color:green'>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='B'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:green'>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='C'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:green'>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else {
            $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
              <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
              <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
              <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
              <span style='color:green'>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }
        }else{
          if($answer=='A'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span style='color:red'>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='B'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:red'>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='C'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:red'>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else {
            $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
              <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
              <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
              <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
              <span style='color:red'>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }
        }
        $middle .= "<tr><td colspan='2' style='padding-left:20px;'><b>Correct Answer:</b> ".$myfeedback['correctAns']."</b></td><td></td></tr>";
      }else if($questionType == "MC"){
        if($answer == $myfeedback['correctAns']){
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/checkmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }else{
          $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'><img src='../img/Xmark.png'/ width='20px' height='20px'><span>  $i. ".$myfeedback['question']."</span> (".$myfeedback['points']." pts.)</td><td></td></tr>";
        }
        if($answer == $myfeedback['correctAns']){
          if($answer=='A'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span style='color:green'>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='B'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:green'>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='C'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:green'>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else {
            $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
              <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
              <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
              <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
              <span style='color:green'>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }

        }else {
          if($answer=='A'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span style='color:red'>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='B'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:red'>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else if($answer=='C'){ $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
            <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
            <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
            <span style='color:red'>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
            <span>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }else {
            $middle .= "<tr><td colspan='2' style='padding-left:20px;'>
              <span>A. &nbsp;&nbsp;".$myfeedback['opt1']."&nbsp;&nbsp;&nbsp;</span>
              <span>B. &nbsp;&nbsp;".$myfeedback['opt2']."&nbsp;&nbsp;&nbsp;</span>
              <span>C. &nbsp;&nbsp;".$myfeedback['opt3']."&nbsp;&nbsp;&nbsp;</span>
              <span style='color:red'>D. &nbsp;&nbsp;".$myfeedback['opt4']."&nbsp;&nbsp;&nbsp;</span></td></tr>";
          }
        }
        $middle .= "<tr><td colspan='2' style='padding-left:20px;'><b>Correct Answer:</b> ".$myfeedback['correctAns']."</td><td></td></tr>";
      }else {
        $middle .= "<tr><td colspan='2' style='padding:10px;border-top:1px solid black'>$i. ".$myfeedback['question']." (".$myfeedback['points']." pts.)</td><td></td></tr>";
        $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'><b>Correct Solution:</b></td><td>".$myfeedback["correctAns"]."</td></tr>";
        $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'>Student's Answer:</td><td>".$answer."</td></tr>";
        for ($k=1;$k<=5;$k++){
          if(!empty($myfeedback['testcase'."$k"])&&!empty($myfeedback['answer'."$k"])){
            $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'>Test Case #$k:</td><td>".$myfeedback['testcase'."$k"]."</td></tr>";
            $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'><b>Correct Output:</b></td><td>".$myfeedback['answer'."$k"]."</td></tr>";
            if($feed['feedback'."$k"]==$myfeedback['answer'."$k"]){
              $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'>Student's Output:</td><td><span style = 'color:green'>".$myfeedback['answer'."$k"]."&nbsp;&nbsp;<img src='../img/checkmark.png'/ width='20px' height='20px'></span></td></tr>";// fix this
            }else{ $middle .= "<tr><td style='padding-left:20px;padding-right:20px;'>Student's Output:</td><td><span style = 'color:red'>".$feed['feedback'."$k"]."&nbsp;&nbsp;<img src='../img/Xmark.png'/ width='20px' height='20px'></span></td></tr>";}//fix this
          }
        }
      }

    }


  }
  $header = "<tr><td><span class='lead'>Quiz: $quiztitle</span></td><td><span class='lead'>Student: $student</span></td></tr>";

  echo "<table style='height:100%'>".$header.$middle."</table>";
}

?>
