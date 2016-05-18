<?php
class localDB{
private $db;
public function __construct($iniFile){
  $ini = parse_ini_file($iniFile,true);
	$this->db = new mysqli(
    $ini['loginDB']['host'],
    $ini['loginDB']["user"],
		$ini['loginDB']["password"],
		$ini['loginDB']["db"]);

    if ($this->db->connect_errno > 0 ){
		    return false;
	     }
}

public function __destruct(){
	  $this->db->close();
  }


private function getQuiz($myquiz){
  $query = "select * from $myquiz;";
  $result = $this->db->query($query);
  if (!$result){
    return array('success' => false, 'message' => "Error: Failed to located the $myquiz table");
  }else{
    $list = array();
    $count = 1;
    while ($question = $result->fetch_assoc()){
      $questionID = $question['questionID'];
      $questionType = $question['questionType'];
      if($questionType == 'TF'){
        $queryTF = "select TrueandFalse.question, TrueandFalse.correctAns, TrueandFalse.points from TrueandFalse inner join $myquiz on
                    $myquiz.questionID=TrueandFalse.questionID and $myquiz.questionType=TrueandFalse.questionType
                    where TrueandFalse.questionID = '$questionID';";
        $resultTF = $this->db->query($queryTF);
        if(!$resultTF){
          return array("success"=>false, "message"=>"Fail to connect with TF table");
        }
        $quizQ = $resultTF->fetch_assoc();
        $TFarray = array();
        $quizQuestion = $quizQ['question'];
        $quizAnswer = $quizQ['correctAns'];
        $TFarray["question"] = $quizQuestion;
        $TFarray["answer"] = $quizAnswer;
        $TFarray["points"] = $quizQ['points'];
        $TFarray["type"] = "TF";
        $list["$count"] = $TFarray; //here is where you ended.

      }else if($questionType == 'FB'){
        $queryFB = "select FillTheBlank.question, FillTheBlank.correctAns, FillTheBlank.optionOne, FillTheBlank.optionTwo, FillTheBlank.optionThree, FillTheBlank.optionFour, FillTheBlank.questionID, FillTheBlank.points from FillTheBlank inner join $myquiz on $myquiz.questionID=FillTheBlank.questionID and $myquiz.questionType=FillTheBlank.questionType where FillTheBlank.questionID ='$questionID';";
        $resultFB = $this->db->query($queryFB);
        if(!$resultFB){
          return array("success"=>false, "message"=>"Fail to connect with FB table");
        }
        $quizQ = $resultFB->fetch_assoc();
        $FBarray = array();
        $quizQuestion = $quizQ['question'];
        $quizAnswer = $quizQ['correctAns'];
        $FBarray["question"] = $quizQuestion; //here is where you ended.
        $FBarray["answer"] = $quizAnswer;
        $FBarray["points"] = $quizQ['points'];
        $FBarray["opt1"] = $quizQ['optionOne'];
        $FBarray["opt2"] = $quizQ['optionTwo'];
        $FBarray["opt3"] = $quizQ['optionThree'];
        $FBarray["opt4"] = $quizQ['optionFour'];
        $FBarray["type"] = "FB";
        $list["$count"] = $FBarray;
      }
      else if($questionType == 'MC'){
        $queryMC = "select MultipleChoice.question, MultipleChoice.correctAns, MultipleChoice.optionOne, MultipleChoice.optionTwo, MultipleChoice.optionThree, MultipleChoice.optionFour, MultipleChoice.questionID, MultipleChoice.points from MultipleChoice inner join $myquiz on $myquiz.questionID=MultipleChoice.questionID and $myquiz.questionType=MultipleChoice.questionType where MultipleChoice.questionID='$questionID';";
        $resultMC = $this->db->query($queryMC);
        if(!$resultMC){
          return array("success"=>false, "message"=>"Fail to connect with MC table");
        }
        $quizQ = $resultMC->fetch_assoc();
        $MCarray = array();
        $quizQuestion = $quizQ['question'];
        $quizAnswer = $quizQ['correctAns'];
        $MCarray["question"] = $quizQuestion; //here is where you ended.
        $MCarray["answer"] = $quizAnswer;
        $MCarray["points"] = $quizQ['points'];
        $MCarray["opt1"] = $quizQ['optionOne'];
        $MCarray["opt2"] = $quizQ['optionTwo'];
        $MCarray["opt3"] = $quizQ['optionThree'];
        $MCarray["opt4"] = $quizQ['optionFour'];
        $MCarray["type"] = "MC";
        $list["$count"] = $MCarray;
      }else{
        $queryOE = "select OpenEnded.question, OpenEnded.correctAns, OpenEnded.questionID,
                    OpenEnded.testcase1,OpenEnded.testcase2,OpenEnded.testcase3,OpenEnded.testcase4,OpenEnded.testcase5,
                    OpenEnded.answer1,OpenEnded.answer2,OpenEnded.answer3,OpenEnded.answer4,OpenEnded.answer5,
                    OpenEnded.points,OpenEnded.functionName from OpenEnded inner join $myquiz on
                    $myquiz.questionID=OpenEnded.questionID and $myquiz.questionType=OpenEnded.questionType where OpenEnded.questionID = '$questionID';";
        $resultOE = $this->db->query($queryOE);
        if(!$resultOE){
          return array("success"=>false, "message"=>"Fail to connect with OE table");
        }
        $quizQ = $resultOE->fetch_assoc();
        $OEarray = array();
        $quizQuestion = $quizQ['question'];
        $quizAnswer = $quizQ['correctAns'];
        $OEarray["question"] = $quizQuestion;
        $OEarray["answer"] = $quizAnswer;
        $OEarray["functionName"] = $quizQ['functionName'];
        $OEarray["points"] = $quizQ['points'];
        $OEarray["testcase1"] = $quizQ['testcase1'];
        $OEarray["testcase2"] = $quizQ['testcase2'];
        $OEarray["testcase3"] = $quizQ['testcase3'];
        $OEarray["testcase4"] = $quizQ['testcase4'];
        $OEarray["testcase5"] = $quizQ['testcase5'];
        $OEarray["answer1"] = $quizQ['answer1'];
        $OEarray["answer2"] = $quizQ['answer2'];
        $OEarray["answer3"] = $quizQ['answer3'];
        $OEarray["answer4"] = $quizQ['answer4'];
        $OEarray["answer5"] = $quizQ['answer5'];

        $OEarray["type"] = "OE";
        $list["$count"] = $OEarray;
      }
      ++$count;
    }
    return $list;
  }
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function printQuiz($username){
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"User Does Not Exist");
    }else {
      $userID = $this->getUserID($username);
    }
  $query = "select * from studentDB where userID = '$userID';";
  $results = $this->db->query($query);
  if (!$results){
    return array('success' => false, 'message' => 'Error: Failed to located the student quiz table');
  }else {
    if($results->num_rows == 0){
      return array('success' => false, 'message' => 'No Quiz Assigned/Available');
    }else{
        $quiz_list = array();
        $quizname = array();
        $count = 1;
        while ($row = $results->fetch_assoc()){
          if ($row['permissionID'] == 1){
            $quiztitle = $this->getQuizname($row['quizID']);
            $getQuiz = $this->getQuiz($quiztitle);
            $quizname["$count"] = $quiztitle;
            $quiz_list["$count"] = $getQuiz;
            ++$count;
          }
        }
        return array("success" => true, "message" => $quiz_list,  "quizname" => $quizname);
    }
  }

}
private function getQuizname($quizID){
  $query = "select myQuiz.quizTitle from myQuiz inner join studentDB on myQuiz.quizID=studentDB.quizID where myQuiz.quizID = $quizID;";
  $result = $this->db->query($query);
  if (!$result){
    return false;
  }else {
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $quizTitle = $row['quizTitle'];
      return $quizTitle;
    }else return false;
  }
}

public function getAns($myquiz){
  $query = "select * from $myquiz;";
  $result = $this->db->query($query);
  if (!$result){
    return array('success' => false, 'message' => "Error: Failed to located the $myquiz table");
  }else{
    $list = array();
    $count = 1;
    while ($question = $result->fetch_assoc()){
      $questionID = $question['questionID'];
      $questionType = $question['questionType'];
      if($questionType == 'TF'){
        $queryTF = "select TrueandFalse.question, TrueandFalse.correctAns, TrueandFalse.points from TrueandFalse inner join $myquiz on
                    $myquiz.questionID=TrueandFalse.questionID and $myquiz.questionType=TrueandFalse.questionType
                    where TrueandFalse.questionID = '$questionID';";
        $resultTF = $this->db->query($queryTF);
        if(!$resultTF){
          return array("success"=>false, "message"=>"Fail to connect with TF table");
        }
        $quizQ = $resultTF->fetch_assoc();
        $TFarray = array();
        $quizAnswer = $quizQ['correctAns'];
        $TFarray["type"] = 'TF';
        $TFarray["answer"] = $quizAnswer;
        $TFarray["points"] = $quizQ['points'];
        $list["$count"] = $TFarray; //here is where you ended.

      }else if($questionType == 'FB'){
        $queryFB = "select FillTheBlank.question, FillTheBlank.correctAns, FillTheBlank.optionOne, FillTheBlank.optionTwo, FillTheBlank.optionThree, FillTheBlank.optionFour, FillTheBlank.questionID, FillTheBlank.points from FillTheBlank inner join $myquiz on $myquiz.questionID=FillTheBlank.questionID and $myquiz.questionType=FillTheBlank.questionType where FillTheBlank.questionID ='$questionID';";
        $resultFB = $this->db->query($queryFB);
        if(!$resultFB){
          return array("success"=>false, "message"=>"Fail to connect with FB table");
        }
        $quizQ = $resultFB->fetch_assoc();
        $FBarray = array();
        $quizAnswer = $quizQ['correctAns'];
        $FBarray["type"] = 'FB';
        $FBarray["answer"] = $quizAnswer;
        $FBarray["points"] = $quizQ['points'];
        $list["$count"] = $FBarray;
      }
      else if($questionType == 'MC'){
        $queryMC = "select MultipleChoice.question, MultipleChoice.correctAns, MultipleChoice.optionOne, MultipleChoice.optionTwo, MultipleChoice.optionThree, MultipleChoice.optionFour, MultipleChoice.questionID, MultipleChoice.points from MultipleChoice inner join $myquiz on $myquiz.questionID=MultipleChoice.questionID and $myquiz.questionType=MultipleChoice.questionType where MultipleChoice.questionID='$questionID';";
        $resultMC = $this->db->query($queryMC);
        if(!$resultMC){
          return array("success"=>false, "message"=>"Fail to connect with MC table");
        }
        $quizQ = $resultMC->fetch_assoc();
        $MCarray = array();
        $quizAnswer = $quizQ['correctAns'];
        $MCarray["type"] = 'MC';
        $MCarray["answer"] = $quizAnswer;
        $MCarray["points"] = $quizQ['points'];
        $list["$count"] = $MCarray;
      }else{
        $queryOE = "select OpenEnded.question, OpenEnded.correctAns, OpenEnded.questionID,
                    OpenEnded.testcase1,OpenEnded.testcase2,OpenEnded.testcase3,OpenEnded.testcase4,OpenEnded.testcase5,
                    OpenEnded.answer1,OpenEnded.answer2,OpenEnded.answer3,OpenEnded.answer4,OpenEnded.answer5,
                    OpenEnded.points,OpenEnded.functionName
                    from OpenEnded inner join $myquiz on
                    $myquiz.questionID=OpenEnded.questionID and $myquiz.questionType=OpenEnded.questionType where OpenEnded.questionID = '$questionID';";
        $resultOE = $this->db->query($queryOE);
        if(!$resultOE){
          return array("success"=>false, "message"=>"Fail to connect with OE table");
        }
        $quizQ = $resultOE->fetch_assoc();
        $OEarray = array();
        $quizAnswer = $quizQ['correctAns'];
        $OEarray["type"] = 'OE';
        //$OEarray["testcase"] = $quizQ['testCase'];
        $OEarray["answer"] = $quizAnswer;
        $OEarray['points'] = $quizQ['points'];
        $OEarray["testcase1"] = $quizQ['testcase1'];
        $OEarray["testcase2"] = $quizQ['testcase2'];
        $OEarray["testcase3"] = $quizQ['testcase3'];
        $OEarray["testcase4"] = $quizQ['testcase4'];
        $OEarray["testcase5"] = $quizQ['testcase5'];
        $OEarray["answer1"] = $quizQ['answer1'];
        $OEarray["answer2"] = $quizQ['answer2'];
        $OEarray["answer3"] = $quizQ['answer3'];
        $OEarray["answer4"] = $quizQ['answer4'];
        $OEarray["answer5"] = $quizQ['answer5'];
        $list["$count"] = $OEarray;
      }
      ++$count;
    }
    return $list;
  }
}

private function getUserID($user){
  $query = "select * from userLogin where userName = '$user';";
  $results = $this->db->query($query);
  if ($results->num_rows > 0){
    $IDnumber = $results->fetch_assoc();
    return $IDnumber["userID"];
  }else return 0;
}

private function getquizID($quiztitle){
  $query = "select * from myQuiz where quizTitle= '$quiztitle';";
  $results = $this->db->query($query);
  if ($results->num_rows > 0){
    $IDnumber = $results->fetch_assoc();
    return $IDnumber["quizID"];
  }else return 0;
}

public function insertGrade($quiztitle,$grade,$studentuser){
  if ($this->getUserID($studentuser) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($studentuser);
  }

  if ($this->getquizID($quiztitle) == 0){
    return array("success"=>false, "message"=>"Quiz Does Not Exist");
  }else {
    $quizID = $this->getquizID($quiztitle);
  }

  $teacher = "select teacherID from studentDB where quizID = '$quizID';";
  $teacherresult = $this->db->query($teacher);
  $row = $teacherresult->fetch_assoc();
  $teacherID = $row['teacherID'];

  $check = "select * from studentGrades where userID = '$userID' and quizID = '$quizID';";
  $checker = $this->db->query($check);
  if($checker->num_rows == 0){
    $query = "insert into studentGrades(grades,userID,quizID,quizTitle,teacherID,permissionID) values('$grade','$userID','$quizID','$quiztitle','$teacherID', '0');";
    $results = $this->db->query($query);
    if (!$results){
      return array('success' => false, 'message' => "Error: Failed to located the studentGrades table");
    }else{
      $denyquiz = "update studentDB set permissionID = FALSE where quizID = $quizID AND userID = $userID;";
      $removed = $this->db->query($denyquiz);
      if (!$removed){
        return array("success"=>false, "message"=>"Error: Failed to located the studentDB table");
      }else {
        return array("success"=>true, "message"=>"Successfully removed");
      }
    }
  }else {
    $rw = "update studentGrades set grades = '$grade', permissionID = '0' where userID = '$userID' and quizID = '$quizID';";
    $rw_result = $this->db->query($rw);
    if (!$rw_result){
      return array('success' => false, 'message' => "Error: Updated");
    }else {
      $denyquiz = "update studentDB set permissionID = FALSE where quizID = $quizID AND userID = $userID;";
      $removed = $this->db->query($denyquiz);
      if (!$removed){
        return array("success"=>false, "message"=>"Error: Failed to located the studentDB table");
      }else {
        return array("success"=>true, "message"=>"Successfully removed");
      }

    }
  }
}


public function myGrade($studentuser){
  if ($this->getUserID($studentuser) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($studentuser);
  }
 $query = "select * from studentGrades where userID = '$userID';";
 $results = $this->db->query($query);
 if(!$results){
   return array('success' => false, 'message' => 'Error: fail to connect');
 }else{
   if ($results->num_rows > 0){
     $list = array();
     $count = 1;
     while($row = $results->fetch_assoc()){
       if ($row['permissionID'] == 1){
         $grade = $row['grades'];
       }else $grade = false;

       $quiztitle = $row['quizTitle'];
       $list["$count"] = array($quiztitle, $grade);
       $count++;
     }
     return array('success' => TRUE, 'message' => $list);
   }else return array('success' => FALSE, 'message' => "Have Not Take Any Quiz?");
 }
}

public function feed($quiztitle, $username, $stud_answer, $feed_feedback){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  //for($x=1;$x<=sizeof($stud_answer);$x++){}
  $reference = "select * from $quiztitle;";
  $result = $this->db->query($reference);
  if(!$result){
    return array("success"=>false, "message"=>"$quiztitle is not found");
  }else {
    $count = 0;
    while($row = $result->fetch_assoc()){
      $count++;
      $quizID = $row['quizID'];
      $questionID = $row['questionID'];
      $questionType = $row['questionType'];
      $teacherID = $row['userID'];
      $answer = $this->db->real_escape_string($stud_answer["$count"]);
      $feedback1 = $this->db->real_escape_string($feed_feedback["testcase1"]);
      $feedback2 = $this->db->real_escape_string($feed_feedback["testcase2"]);
      $feedback3 = $this->db->real_escape_string($feed_feedback["testcase3"]);
      $feedback4 = $this->db->real_escape_string($feed_feedback["testcase4"]);
      $feedback5 = $this->db->real_escape_string($feed_feedback["testcase5"]);
      $check = "select * from feedbackTable where questionID = $questionID and questionType = '$questionType' and quizID = $quizID and userID = $userID;";
      $result_check = $this->db->query($check);
      if (!$result_check){
        return array("success"=>false, "message"=> "Feedback table is not found");
      }else{
        if ($result_check->num_rows==0){
          if($questionType=="OE"){
            $query = "insert into feedbackTable(userID,teacherID,questionID,questionType,quizID,answer,feedback,quizTitle,testans1, testans2, testans3, testans4, testans5) values('$userID','$teacherID','$questionID','$questionType','$quizID', '$answer','NULL','$quiztitle','$feedback1','$feedback2','$feedback3','$feedback4','$feedback5');";
          } else{
            $query = "insert into feedbackTable(userID,teacherID,questionID,questionType,quizID,answer,feedback,quizTitle) values('$userID','$teacherID','$questionID','$questionType','$quizID', '$answer','NULL','$quiztitle');";
          }
          $out = $this->db->query($query);
          if(!$out){
            return array("success"=>false, "message"=>"Fail to Insert in Feedback");
          }
        }else{
          if($questionType=="OE"){
          $exec = "update feedbackTable set answer = '$answer',testans1 = '$feedback1',testans2 = '$feedback2',testans3 = '$feedback3',testans4 = '$feedback4',testans5 = '$feedback5' where questionID = '$questionID' and questionType = '$questionType' and quizTitle = '$quiztitle' and userID = '$userID';";
        }else {$exec = "update feedbackTable set answer = '$answer' where questionID = '$questionID' and questionType = '$questionType' and quizTitle = '$quiztitle' and  userID = '$userID';";}
          $run = $this->db->query($exec);
          if(!$run){
            return array("success"=>false, "message"=>"Fail to Update in Feedback");
          }
        }
      }
    }
    return array("success"=>true, "message"=>"Successfully Inserted");
  }
}

public function studentFeedback($studentuser,$quiztitle){
  if ($this->getUserID($studentuser) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($studentuser);
  }

  $query = "select * from feedbackTable where userID = '$userID' and quizTitle = '$quiztitle';";
  $result = $this->db->query($query);
  if(!$result){
    return array("success"=>false, "message"=>"Fail to connect to feedback");
  }else{
    if ($result->num_rows > 0){
      $feed_array = array();
      $counter = 0;
      while($row = $result->fetch_assoc()){
        $result_array = array();
        $counter++;
        $result_array['questionID'] = $row['questionID'];
        $result_array['questionType'] = $row['questionType'];
        $result_array['answer'] = $row['answer'];
        $result_array['teacherID'] = $row['teacherID'];
        $result_array['feedback1'] = $row['testans1'];
        $result_array['feedback2'] = $row['testans2'];
        $result_array['feedback3'] = $row['testans3'];
        $result_array['feedback4'] = $row['testans4'];
        $result_array['feedback5'] = $row['testans5'];
        $feed_array["$counter"] = $result_array;
      }
      return array("success"=>true,"message"=>$feed_array);
    }else return array("success"=>false, "message"=>"$quiztitle and $student not found in feedback table");
  }

}

public function questionInfo($questionID,$questionType,$teacherID){
  if ($questionType=='TF'){
    $query = "select * from TrueandFalse where userID = '$teacherID' and questionID = '$questionID';";
    $result = $this->db->query($query);
    if(!$result){
      return array("success"=>false, "message"=>"Fail to True and False table");
    }else{
      if ($result->num_rows > 0){
        $infoTF = array();
        $info = $result->fetch_assoc();
        $infoTF["question"] = $info["question"];
        $infoTF["correctAns"] = $info["correctAns"];
        $infoTF["points"] = $info["points"];
        return array("success"=>true, "message"=>$infoTF);
      }else return array("success"=>false, "message"=>"Question is not found in True and False table");
    }
  }else if ($questionType=='FB'){
    $query = "select * from FillTheBlank where userID = '$teacherID' and questionID = '$questionID';";
    $result = $this->db->query($query);
    if(!$result){
      return array("success"=>false, "message"=>"Fail to Fill In The Blank table");
    }else{
      if ($result->num_rows > 0){
        $infoFB = array();
        $info = $result->fetch_assoc();
        $infoFB["question"] = $info["question"];
        $infoFB["correctAns"] = $info["correctAns"];
        $infoFB["points"] = $info["points"];
        $infoFB["points"] = $info["points"];
        $infoFB["opt1"] = $info["optionOne"];
        $infoFB["opt2"] = $info["optionTwo"];
        $infoFB["opt3"] = $info["optionThree"];
        $infoFB["opt4"] = $info["optionFour"];
        return array("success"=>true, "message"=>$infoFB);
      }else return array("success"=>false, "message"=>"Question is not found in Fill In The Blank table");
    }
  }else if ($questionType=='MC'){
    $query = "select * from MultipleChoice where userID = '$teacherID' and questionID = '$questionID';";
    $result = $this->db->query($query);
    if(!$result){
      return array("success"=>false, "message"=>"Fail to Multiple Choice table");
    }else{
      if ($result->num_rows > 0){
        $infoMC = array();
        $info = $result->fetch_assoc();
        $infoMC["question"] = $info["question"];
        $infoMC["correctAns"] = $info["correctAns"];
        $infoMC["points"] = $info["points"];
        $infoMC["opt1"] = $info["optionOne"];
        $infoMC["opt2"] = $info["optionTwo"];
        $infoMC["opt3"] = $info["optionThree"];
        $infoMC["opt4"] = $info["optionFour"];
        return array("success"=>true, "message"=>$infoMC);
      }else return array("success"=>false, "message"=>"Question is not found in Multiple Choice table");
    }
  }else {
    $query = "select * from OpenEnded where userID = '$teacherID' and questionID = '$questionID';";
    $result = $this->db->query($query);
    if(!$result){
      return array("success"=>false, "message"=>"Fail to Open Ended table");
    }else{
      if ($result->num_rows > 0){
        $infoOE = array();
        $info = $result->fetch_assoc();
        $infoOE["question"] = $info["question"];
        $infoOE["correctAns"] = $info["correctAns"];
        $infoOE["points"] = $info["points"];
        $infoOE["testcase1"] = $info["testcase1"];
        $infoOE["testcase2"] = $info["testcase2"];
        $infoOE["testcase3"] = $info["testcase3"];
        $infoOE["testcase4"] = $info["testcase4"];
        $infoOE["testcase5"] = $info["testcase5"];
        $infoOE["answer1"] = $info["answer1"];
        $infoOE["answer2"] = $info["answer2"];
        $infoOE["answer3"] = $info["answer3"];
        $infoOE["answer4"] = $info["answer4"];
        $infoOE["answer5"] = $info["answer5"];
        return array("success"=>true, "message"=>$infoOE);
      }else return array("success"=>false, "message"=>"Question is not found in Open Ended table");
    }
  }

}




}
?>
