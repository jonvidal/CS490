<?php


if(isset($_POST["Publish"])){
  $pub_message='';
  $quizrelease = $_POST["Publish"];
  $csess = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
  curl_setopt_array($csess, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS =>json_encode(array('quiztitle'=>$quizrelease,'username' => $user, 'role' => 'publish')),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $req = curl_exec($csess);
  curl_close($csess);
  $publish_respond=json_decode($req, true);
  //var_dump($publish_respond);
  if ($publish_respond['success']==true){
    $pub_message = "<div class='alert alert-success'>$quizrelease Has Successfully Published</div>";
  }else $pub_message = "<div class='alert alert-danger'>".$publish_respond['message']."</div>";
  echo $pub_message;
}


if(isset($_POST["Unpublish"])){
  $pub_message='';
  $quizrelease = $_POST["Unpublish"];
  $csess = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
  curl_setopt_array($csess, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS =>json_encode(array('quiztitle'=>$quizrelease,'username' => $user, 'role' => 'unpublish')),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $req = curl_exec($csess);
  curl_close($csess);
  $publish_respond=json_decode($req, true);
  //var_dump($publish_respond);
  if ($publish_respond['success']==true){
    $pub_message = "<div class='alert alert-success'>$quizrelease Has Successfully Unublished</div>";
  }else $pub_message = "<div class='alert alert-danger'>".$publish_respond['message']."</div>";
  echo $pub_message;
}


if(isset($_POST["deleteQuiz"])){
  $quizdelete = $_POST["deleteQuiz"];
  $delete_message = "";
  $delete_session = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
  curl_setopt_array($delete_session, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS =>json_encode(array('quiztitle'=>$quizdelete,'username' => $user, 'role' => 'deletemyquiz')),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $response = curl_exec($delete_session);
  curl_close($delete_session);
  $delete_respond=json_decode($response, true);
  //var_dump($delete_respond);

  if($delete_respond['success']==true){
    $delete_message = "<div class='alert alert-success'>$quizdelete Has Successfully Delete </div>";
  }else $delete_message = "<div class='alert alert-danger'>Failed To Delete The $quizdelete</div>";
  echo $delete_message;
}



    $csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS =>json_encode(array('username' => $user, 'role' => 'printQuiz')),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $response=json_decode($request, true);

    if ($response['success']==true){
          $count = count($response['message']);
          for($x = 1; $x<=$count; $x++){
            $name = $response['quizname']["$x"];
            echo "<h3>".$response['quizname']["$x"]."</h3>";

            //checking if quiz is publish
            $res = "";
            $cs = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
            curl_setopt_array($cs, array(
              CURLOPT_POST =>true,
              CURLOPT_POSTFIELDS =>json_encode(array('username' => $user, 'role' => 'checker')),
              CURLOPT_RETURNTRANSFER =>true,
            ));
            $re = curl_exec($cs);
            curl_close($cs);
            $pub=json_decode($re, true);
            //var_dump($pub);
            if ($pub['success']==true){
              $res = $pub['message'];
            }

            $del = '';
            $met = "Publish";
            if ( $res == $name ){
              $del ='disabled'; // if publish disabled the delete button
              $met = 'Unpublish';
            }
            echo "<div class = 'container' style='margin-bottom:15px;'>";
            echo "<form action='' method='post'><button type='submit' name='deleteQuiz' class='btn btn-default' value='$name' style='width:100px;float:right;' $del>Delete</button>"."<span style='float:right;'>&nbsp;</span>"."
            <button type='submit' name=".$met." class='btn btn-default' value='$name' style='width:100px;float:right;'>$met</button>
            <form>";
            echo "<table>";
            $result = $response['message']["$x"];
            for($i = 1; $i<=count($result); $i++){
              $resulted = $result["$i"];
              $type = $resulted['type'];
              if ($type == 'TF'){
                $question = $resulted['question'];
                $answer = $resulted['answer'];
                $points = $resulted['points'];
                if ($answer == 'T'){
                  $TF = 'True';
                } else $TF = 'False';
                //echo "<br/>TRUE OR FALSE<br/>";
                echo "<tr><td colspan=4>$i. ".$question."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Answer:</strong> ".$TF."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Points:</strong> ".$points."</td></tr>";
              }else if($type == 'FB'){
                $question = $resulted['question'];
                $answer = $resulted['answer'];
                $points = $resulted['points'];
                $optionOne = $resulted['opt1'];
                $optionTwo = $resulted['opt2'];
                $optionThree = $resulted['opt3'];
                $optionFour = $resulted['opt4'];
                //echo "<br/>Fill In The Blank<br/>";
                echo "<tr><td colspan=4>$i. ".$question."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Answer:</strong> ".$answer."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Points:</strong> ".$points."</td></tr>";
                echo "<tr><td style='padding-left:10px;padding-right:10px;'>A. ".$optionOne."</td><td style='padding-left:10px;padding-right:10px;'>B. ".$optionTwo."</td><td style='padding-left:10px;padding-right:10px;'>C. ".$optionThree."</td><td style='padding-left:10px;padding-right:10px;'>D. ".$optionFour."</td></tr>";
              }
              else if($type == 'MC'){
                $question = $resulted['question'];
                $answer = $resulted['answer'];
                $points = $resulted['points'];
                $optionOne = $resulted['opt1'];
                $optionTwo = $resulted['opt2'];
                $optionThree = $resulted['opt3'];
                $optionFour = $resulted['opt4'];
                //echo "<br/>MULTIPLE CHOICES<br/>";
                echo "<tr><td colspan=4>$i. ".$question."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Answer:</strong> ".$answer."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Points:</strong> ".$points."</td></tr>";
                echo "<tr><td style='padding-left:10px;padding-right:10px;'>A. ".$optionOne."</td><td style='padding-left:10px;padding-right:10px;'>B. ".$optionTwo."</td><td style='padding-left:10px;padding-right:10px;'>C. ".$optionThree."</td><td style='padding-left:10px;padding-right:10px;'>D. ".$optionFour."</td></tr>";
              }else{
                //var_dump($resulted);
                $question = $resulted['question'];
                $answer = $resulted['answer'];
                $points = $resulted['points'];
                $functionName = $resulted['fuctionName'];

                echo "<tr><td colspan=4>$i. ".$question."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Solution:</strong> ".$answer."</td></tr>";
                echo "<tr><td colspan=4 style='padding-left:10px'><strong>Points:</strong> ".$points."</td></tr>";

                if(!empty($resulted['testcase1'])&&!empty($resulted['answer1'])){
                  $testcase1 = "<tr><td colspan=4 style='padding-left:10px'><strong>Test Case # 1:</strong> ".$resulted['testcase1']." &raquo;  ".$resulted['answer1']."</td></tr>";
                  echo $testcase1;
                }
                if(!empty($resulted['testcase2'])&&!empty($resulted['answer2'])){
                  $testcase2 = "<tr><td colspan=4 style='padding-left:10px'><strong>Test Case # 2:</strong> ".$resulted['testcase2']." &raquo;  ".$resulted['answer2']."</td></tr>";
                  echo $testcase2;
                }
                if(!empty($resulted['testcase3'])&&!empty($resulted['answer3'])){
                  $testcase3 = "<tr><td colspan=4 style='padding-left:10px'><strong>Test Case # 3:</strong> ".$resulted['testcase3']." &raquo;  ".$resulted['answer3']."</td></tr>";
                  echo $testcase3;
                }
                if(!empty($resulted['testcase4'])&&!empty($resulted['answer4'])){
                  $testcase4 = "<tr><td colspan=4 style='padding-left:10px'><strong>Test Case # 4:</strong> ".$resulted['testcase4']." &raquo;  ".$resulted['answer4']."</td></tr>";
                  echo $testcase4;
                }
                if(!empty($resulted['testcase5'])&&!empty($resulted['answer5'])){
                  $testcase5 = "<tr><td colspan=4 style='padding-left:10px'><strong>Test Case # 5:</strong> ".$resulted['testcase5']." &raquo;  ".$resulted['answer5']."</td></tr>";
                  echo $testcase5;
                }


              }

            }
            echo "</table>";
            echo "</div>";

          }
        }


?>
