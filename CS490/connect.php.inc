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

public function ValidateUserId($username,$password){
    $username = $this->db->real_escape_string($username);
    $password =  $this->db->real_escape_string($password);
    $query = "select * from userLogin where userName = '$username';";
	  $results = $this->db->query($query);
	  if (!$results){
	    return "error with results: ".$this->db->error;
	   }
    if ($results->num_rows > 0){
      $user = $results->fetch_assoc();
      if ($user['passWord'] == sha1($password)){
        if ($user['status'] == 'teacher'){
          return array('validate' =>  true, 'status' => 'teacher');
        }else {
          return array('validate' =>  true, 'status' => 'student');
        }

       }
    }else return false;
  }

private function getUserID($user){
  $query = "select * from userLogin where userName = '$user';";
  $results = $this->db->query($query);
  if ($results->num_rows > 0){
    $IDnumber = $results->fetch_assoc();
    return $IDnumber["userID"];
  }else return 0;
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function TrueorFalse($question, $correctAns, $username, $points){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  //$points = $this->db->real_escape_string($points);
  $question = $this->db->real_escape_string($question);
  $correctAns = $this->db->real_escape_string($correctAns);
  $queryTF = "insert into TrueandFalse(question,correctAns,questionType,userID,points)
            values('$question','$correctAns','TF','$userID','$points');";
  $resultsTF = $this->db->query($queryTF);
  if (!$resultsTF){
    return array("success"=>false,"message"=>"Error on connection to TF database");
  }else{
    $qTeachDB = "select * from TrueandFalse where userID = '$userID' and question = '$question';";
    $reTeachDB = $this->db->query($qTeachDB);
    if (!$reTeachDB){
      return array("success"=>false,"message"=>"Error on connection to TF database!");
    }
    if ($reTeachDB->num_rows > 0){
      $inTeachDB = $reTeachDB->fetch_assoc();
      $inquestionID = $inTeachDB['questionID'];
      $inquestionType = $inTeachDB['questionType'];
      $teachDBquery = "insert into teacherDB(userID, questionID, questionType) values('$userID', '$inquestionID',
                        '$inquestionType');";
      $results = $this->db->query($teachDBquery);
      if (!$results){
        return array("success"=>false,"message"=>"Error on connection to TeachDB!");
      }
    }
  }
  return array("success"=>true,"message"=>"Successful");
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function MultipleChoice($questionMC,$answerMC, $username,$optOne,$optTwo,$optThree,$optFour,$points){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $questionMC = $this->db->real_escape_string($questionMC);
  $answerMC = $this->db->real_escape_string($answerMC);
  $optOne = $this->db->real_escape_string($optOne);
  $optTwo = $this->db->real_escape_string($optTwo);
  $optThree = $this->db->real_escape_string($optThree);
  $optFour = $this->db->real_escape_string($optFour);
  $queryMC = "insert into MultipleChoice(question,correctAns,optionOne,optionTwo,optionThree,optionFour,questionType,userID,points)
            values('$questionMC','$answerMC','$optOne','$optTwo','$optThree','$optFour','MC','$userID','$points');";
  $resultsMC = $this->db->query($queryMC);
  if (!$resultsMC){
    return array("success"=>false,"message"=>"Error on connection to MC database");
  }else{
    $qTeachDB = "select * from  MultipleChoice where userID = '$userID' and question = '$questionMC';";
    $reTeachDB = $this->db->query($qTeachDB);
    if (!$reTeachDB){
      return array("success"=>false,"message"=>"Error on connection to MC database!");
    }
    if ($reTeachDB->num_rows > 0){
      $inTeachDB = $reTeachDB->fetch_assoc();
      $inquestionID = $inTeachDB['questionID'];
      $inquestionType = $inTeachDB['questionType'];
      $teachDBquery = "insert into teacherDB(userID, questionID, questionType) values('$userID', '$inquestionID',
                        '$inquestionType');";
      $results = $this->db->query($teachDBquery);
      if (!$results){
        return array("success"=>false,"message"=>"Error on connection to TeachDB!");
      }
    }
  }
  return array("success"=>true,"message"=>"Successful");
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function FillInTheBlank($questionFB,$answerFB,$username,$optOne,$optTwo,$optThree,$optFour,$points){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $questionFB = $this->db->real_escape_string($questionFB);
  $answerFB = $this->db->real_escape_string($answerFB);
  $optOne = $this->db->real_escape_string($optOne);
  $optTwo = $this->db->real_escape_string($optTwo);
  $optThree = $this->db->real_escape_string($optThree);
  $optFour = $this->db->real_escape_string($optFour);
  $queryFB = "insert into FillTheBlank(question,correctAns,optionOne,optionTwo,optionThree,optionFour,questionType,userID,points)
            values('$questionFB','$answerFB','$optOne','$optTwo','$optThree','$optFour','FB','$userID','$points');";
  $resultsFB = $this->db->query($queryFB);
  if (!$resultsFB){
    return array("success"=>false,"message"=>"Error on connection to FB database");
  }else{
    $qTeachDB = "select * from  FillTheBlank where userID = '$userID' and question = '$questionFB';";
    $reTeachDB = $this->db->query($qTeachDB);
    if (!$reTeachDB){
      return array("success"=>false,"message"=>"Error on connection to FB database!");
    }
    if ($reTeachDB->num_rows > 0){
      $inTeachDB = $reTeachDB->fetch_assoc();
      $inquestionID = $inTeachDB['questionID'];
      $inquestionType = $inTeachDB['questionType'];
      $teachDBquery = "insert into teacherDB(userID, questionID, questionType) values('$userID', '$inquestionID',
                        '$inquestionType');";
      $results = $this->db->query($teachDBquery);
      if (!$results){
        return array("success"=>false,"message"=>"Error on connection to TeachDB!");
      }
    }
  }
  return array("success"=>true,"message"=>"Successful");
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function OpenEnded($questionOE,$answerOE, $username, $testcase , $points, $tcanswer, $functionName, $count){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $questionOE = $this->db->real_escape_string($questionOE);
  $answerOE = $this->db->real_escape_string($answerOE);
  $points = $this->db->real_escape_string($points);
  $functionName = $this->db->real_escape_string($functionName);

  $testcase1 ='';$testcase2 ='';$testcase3 ='';$testcase4 ='';$testcase5 ='';
  $answer1 = '';$answer2 = '';$answer3 = '';$answer4 = '';$answer5 = '';

//this is the stupid solution, but work
  if($count==0) return array("success"=>false,"message"=>"no stestcase/answer");
  else if ($count==1){ $testcase1=$testcase[1]; $answer1=$tcanswer[1]; }
  else if ($count==2){ $testcase1=$testcase[1]; $answer1=$tcanswer[1];$testcase2=$testcase[2]; $answer2=$tcanswer[2]; }
  else if ($count==3){ $testcase1=$testcase[1]; $answer1=$tcanswer[1];$testcase2=$testcase[2]; $answer2=$tcanswer[2];$testcase3=$testcase[3]; $answer3=$tcanswer[3]; }
  else if ($count==4){ $testcase1=$testcase[1]; $answer1=$tcanswer[1];$testcase2=$testcase[2]; $answer2=$tcanswer[2];$testcase3=$testcase[3]; $answer3=$tcanswer[3]; $testcase4=$testcase[4]; $answer4=$tcanswer[4]; }
  else { $testcase1=$testcase[1]; $answer1=$tcanswer[1];$testcase2=$testcase[2]; $answer2=$tcanswer[2];$testcase3=$testcase[3]; $answer3=$tcanswer[3]; $testcase4=$testcase[4]; $answer4=$tcanswer[4]; $testcase5=$testcase[5];
    $answer5=$tcanswer[5]; }

  $queryOE = "insert into OpenEnded(question,correctAns,questionType,userID,points,functionName,
              testcase1,answer1,testcase2,answer2,testcase3,answer3,testcase4,answer4,testcase5,answer5)
            values('$questionOE','$answerOE','OE','$userID','$points','$functionName','$testcase1','$answer1',
            '$testcase2','$answer2','$testcase3','$answer3','$testcase4','$answer4','$testcase5','$answer5');";
  $resultsOE = $this->db->query($queryOE);
  if (!$resultsOE){
    return array("success"=>false,"message"=>"Error on connection to OEs database");
  }else{
    $qTeachDB = "select * from  OpenEnded where userID = '$userID' and question = '$questionOE';";
    $reTeachDB = $this->db->query($qTeachDB);
    if (!$reTeachDB){
      return array("success"=>false,"message"=>"Error on connection to OE database!");
    }
    if ($reTeachDB->num_rows > 0){
      $inTeachDB = $reTeachDB->fetch_assoc();
      $inquestionID = $inTeachDB['questionID'];
      $inquestionType = $inTeachDB['questionType'];
      $teachDBquery = "insert into teacherDB(userID, questionID, questionType) values('$userID', '$inquestionID',
                        '$inquestionType');";
      $results = $this->db->query($teachDBquery);
      if (!$results){
        return array("success"=>false,"message"=>"Error on connection to TeachDB!");
      }
    }
  }
  return array("success"=>true,"message"=>"Successful");
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function printQuestion($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB;";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }
  $count = "1";
  while ($row = $results->fetch_assoc()){
    if ($row['questionType']=='TF'){
      $question = $row['questionID'];
      $queryType = "select * from TrueandFalse where questionID = '$question';";
      $result_question = $this->db->query($queryType);
      if (!$result_question){
        return array("success" => false, "message" => "failed connecting TF DB");
      }
      if ($result_question->num_rows > 0){
        $getquestion = $result_question->fetch_assoc();
        $result_array["$count"] = $getquestion["question"];
        $result_array["$count"."ID"] = $getquestion["questionID"];
        $result_array["$count"."points"] = $getquestion["points"];
        $result_array["$count"."type"] = $getquestion["questionType"];
      }
    }else if ($row['questionType']=='FB'){
      $question = $row['questionID'];
      $queryType = "select * from FillTheBlank where questionID = '$question';";
      $result_question = $this->db->query($queryType);
      if (!$result_question){
        return array("success" => false, "message" => "failed connecting FB DB");
      }
      if ($result_question->num_rows > 0){
        $getquestion = $result_question->fetch_assoc();
        $result_array["$count"] = $getquestion["question"];
        $result_array["$count"."ID"] = $getquestion["questionID"];
        $result_array["$count"."points"] = $getquestion["points"];
        $result_array["$count"."type"] = $getquestion["questionType"];
      }
    }else if ($row['questionType']=='MC'){
      $question = $row['questionID'];
      $queryType = "select * from MultipleChoice where questionID = '$question';";
      $result_question = $this->db->query($queryType);
      if (!$result_question){
        return array("success" => false, "message" => "failed connecting MC DB");
      }
      if ($result_question->num_rows > 0){
        $getquestion = $result_question->fetch_assoc();
        $result_array["$count"] = $getquestion["question"];
        $result_array["$count"."ID"] = $getquestion["questionID"];
        $result_array["$count"."points"] = $getquestion["points"];
        $result_array["$count"."type"] = $getquestion["questionType"];
      }
    }else {
      $question = $row['questionID'];
      $queryType = "select * from OpenEnded where questionID = '$question';";
      $result_question = $this->db->query($queryType);
      if (!$result_question){
        return array("success" => false, "message" => "failed connecting OE DB");
      }
      if ($result_question->num_rows > 0){
        $getquestion = $result_question->fetch_assoc();
        $result_array["$count"] = $getquestion["question"];
        $result_array["$count"."ID"] = $getquestion["questionID"];
        $result_array["$count"."points"] = $getquestion["points"];
        $result_array["$count"."type"] = $getquestion["questionType"];
      }
    }
    ++$count;
  }
  return $result_array;
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function createQuiz($quizName, $questionID, $questionType, $username){
if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }

  $name = preg_replace('/\s+/', '', $quizName);

  $createQuiz = "create table $name(quizID int(11) primary key not null auto_increment, questionID int(11) not null, questionType varchar(2) not null, userID int(11) not null) auto_increment=500;";
  $results = $this->db->query($createQuiz);
  if (!$results){
    $query = "insert into $name(questionID,questionType,userID) values('$questionID', '$questionType', '$userID');";
    $exist = $this->db->query($query);
    if (!$exist){
      return array("success" => false, "message" => "fail inserting on created table");
    }
    return array("success" => true, "message" => "Successful created quiz");
  }else {
    $query1 = "insert into $name(questionID,questionType,userID) values('$questionID', '$questionType', '$userID');";
    $exist1 = $this->db->query($query1);
    if (!$exist1){
      return array("success" => false, "message" => "fail inserting on newly added table");
    } else {
      $myquiz = "insert into myQuiz(quizTitle,userID) values('$name','$userID');";
      $result_myquiz = $this->db->query($myquiz);
      return array("success" => true, "message" => "Successful created quiz");
    }
  }

}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function createQuizTable($quizName){
  $name = preg_replace('/\s+/', '', $quizName);
  $query = "select * from $name;";
  $result = $this->db->query($query);
  if (!$result){
    return array("success" => true);
  }else return array("success" => false);
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
public function MyQuiz($username){
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"User Does Not Exist");
    }else {
      $userID = $this->getUserID($username);
    }
  $query = "select myQuiz.quizTitle from myQuiz inner join userLogin on userLogin.userID=myQuiz.userID where userLogin.userID = $userID;";
  $result = $this->db->query($query);
  if (!$result){
    return array("success"=>false, "message"=>"Failed to connect");
  }else{
    if($result->num_rows > 0){
      $list = array();
      $quizname = array();
      $count = 1;
      while($title = $result->fetch_assoc()){
        $myquiz = $title['quizTitle'];

        $quizname["$count"] = $myquiz;
        $quiz = $this->printMyQuiz($myquiz);
        $list["$count"] = $quiz;
        ++$count;
      }
      return array("success" => true, "message" => $list,  "quizname" => $quizname);
    }else return array("success"=>false, "message"=>"No results");

  }
}
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
private function printMyQuiz($myquiz){
  $query = "select * from $myquiz;";
  $result = $this->db->query($query);
  if (!$result){
    return array("success"=>false, "message"=>"Fail to connect with table");
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
          //echo $count." ".$questionType." ".$questionID." ".$myquiz;
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
        $MCarray["question"] = htmlspecialchars($quizQuestion); //here is where you ended.
        $MCarray["answer"] = htmlspecialchars($quizAnswer);
        $MCarray["points"] = $quizQ['points'];
        $MCarray["opt1"] = $quizQ['optionOne'];
        $MCarray["opt2"] = $quizQ['optionTwo'];
        $MCarray["opt3"] = $quizQ['optionThree'];
        $MCarray["opt4"] = $quizQ['optionFour'];
        $MCarray["type"] = "MC";
        $list["$count"] = $MCarray;
      }else{
        $queryOE = "select OpenEnded.question, OpenEnded.correctAns,
                    OpenEnded.testcase1,OpenEnded.testcase2,OpenEnded.testcase3,OpenEnded.testcase4,OpenEnded.testcase5,
                    OpenEnded.answer1,OpenEnded.answer2,OpenEnded.answer3,OpenEnded.answer4,OpenEnded.answer5,
                    OpenEnded.points,OpenEnded.functionName,
                    OpenEnded.questionID from OpenEnded inner join $myquiz on
                    $myquiz.questionID=OpenEnded.questionID and $myquiz.questionType=OpenEnded.questionType where OpenEnded.questionID = '$questionID';";
        $resultOE = $this->db->query($queryOE);
        if(!$resultOE){
          return array("success"=>false, "message"=>"Fail to connect with OE table");
        }
        $quizQ = $resultOE->fetch_assoc();
        $OEarray = array();
        $quizQuestion = htmlspecialchars($quizQ['question']);
        $quizAnswer =  htmlspecialchars($quizQ['correctAns']);

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


public function publishQuiz($quizname,$username){
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"User Does Not Exist");
    }else {
      $teacherID = $this->getUserID($username);
    }
  $search = "select quizID from myQuiz where quizTitle = '$quizname' and userID = '$teacherID';";
  $result_search = $this->db->query($search);
  if (!$result_search){
    return array("success" =>false,"message" => "failed to connect to myQuiz");
  }else{
    if($result_search->num_rows > 0){
      $row = $result_search->fetch_assoc();
      $qID = $row['quizID'];
      $que = "select userID from userLogin where status = 'student';";
      $rec = $this->db->query($que);
      if($rec->num_rows > 0){
        $check = "select * from studentDB where teacherID = $teacherID;"; //where quizID = '$qID' and userID = '$userID';";
        $checker = $this->db->query($check);
        if(!$checker){
          return array("success" =>false,"message" => "failed to connect to studentDB");
        }else {
          if ($checker->num_rows == 0){
            while ($row = $rec->fetch_assoc()){
              $userID = $row['userID'];
              $query = "insert into studentDB(quizID,userID,permissionID,teacherID) values('$qID','$userID',TRUE,'$teacherID');";
              $result = $this->db->query($query);
              if(!$result){
                return array("success"=>false, "message"=>"Failed to insert to studentDB");
              }

              /*$publish = "update studentDB set permissionID = 1 where userID = '$userID' and quizID = '$qID';";
              $republish = $this->db->query($publish);
              if(!$republish){
                return array("success" =>false,"message" => "failed to update permission");}*/
              }
              return array("success" => true, "message"=>"Success to insert to studentDB");
            }else {
              $row1 = $checker->fetch_assoc();
              $exist = $row1['quizID'];
              $existquery = "select quizTitle from myQuiz where quizID = $exist;";
              $existresult = $this->db->query($existquery);
              $existrow = $existresult->fetch_assoc();
              $existname = $existrow['quizTitle'];
              return array("success" =>false, "message" => "Quiz/Test is already assigned - $existname");
            }
            }
          }
        } else return array("success" => false, "message"=>"Quiz is not found on your myQuiz table");
  }
}


private function getUsername($userID){
  $query = "select userName from userLogin where userID = '$userID';";
  $results = $this->db->query($query);
  if ($results->num_rows > 0){
    $IDnumber = $results->fetch_assoc();
    return $IDnumber["userName"];
  }else return 0;
}


public function printStuGrad($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $query = "select * from studentGrades where teacherID = '$userID';";
  $result = $this->db->query($query);
  if(!$result){
    return array('success'=>false, 'message'=> "fail to execute query");
  }else {
    if ($result->num_rows > 0){
      $list = array();
      $count = 1;
      while ($row = $result->fetch_assoc()){
        $grade = $row['grades'];
        $student = $this->getUsername($row['userID']);
        $examname = $row['quizTitle'];
        $list["$count"] = array($examname,$student,$grade);
        $count++;
      }
      return array('success' => true, 'message'=> $list);
    }else return array('success'=>false, 'message'=> "No Grades");

  }


}

public function releaseGrades($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $query = "update studentGrades set permissionID = TRUE where teacherID = '$userID';";
  $results = $this->db->query($query);
  if (!$results){
    return array('success'=>false, 'message'=> "fail to execute query");
  }else {
    return array('success'=>true, 'message'=> "successful");
  }
}


public function deletemyQuiz($quizname, $username){
  $username = $this->db->real_escape_string($username);
  $quizname =  $this->db->real_escape_string($quizname);
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $teacherID = $this->getUserID($username);
  }

  $query = "select * from myQuiz where quizTitle = '$quizname';";
  $result = $this->db->query($query);
  if(!$result){
    return array("success"=>false,"message"=>"failed to connect with myQuiz table");
  }else{
    $row = $result->fetch_assoc();
    $quizID = $row['quizID'];
    $delete = "delete from myQuiz where quizTitle = '$quizname' and quizID = '$quizID';";
    $delete_result = $this->db->query($delete);
    if(!$delete_result){
      return array("success"=>false,"message"=>"$quizname is not found on myQuiz table");
    }else{
      $drop = "drop table $quizname;";
      $result_drop = $this->db->query($drop);
      if(!$result_drop){
        return array("success"=>false,"message"=>"$quizname's table is not found");
      }else return array("success"=>true, "message"=>"$quizname is successfully delete");
    }
  }
}

public function checker($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $teacherID = $this->getUserID($username);
  }
  $check = "select * from studentDB where teacherID = $teacherID;"; //where quizID = '$qID' and userID = '$userID';";
  $checker = $this->db->query($check);
  if(!$checker){
    return array("success" =>false,"message" => "failed to connect to studentDB");
  }else {
    $row1 = $checker->fetch_assoc();
    $exist = $row1['quizID'];
    $existquery = "select quizTitle from myQuiz where quizID = $exist;";
    $existresult = $this->db->query($existquery);
    if ($existresult->num_rows  > 0){
      $existrow = $existresult->fetch_assoc();
      $existname = $existrow['quizTitle'];
      return array("success"=>true, "message"=>$existname);
    }else return array("success"=>false);
  }
}

public function unpublishQuiz($quizname,$username){
  $username = $this->db->real_escape_string($username);
  $quizname =  $this->db->real_escape_string($quizname);
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"User Does Not Exist");
    }else {
      $teacherID = $this->getUserID($username);
    }
  $query = "select * from studentDB where teacherID = $teacherID;";
  $result = $this->db->query($query);
  if(!$result){
    return array("success"=>false,"message"=>"failed to connect to studentDB");
  }else{
    if ($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $quizID = $row['quizID'];
      $querydelete = "select quizTitle from myQuiz where quizID = $quizID;";
      $results = $this->db->query($querydelete);
      if(!$results){
        return array("success"=>false,"message"=>"failed to connect to studentDB");
      }else{
        $rowdelete = $results->fetch_assoc();
        if ($rowdelete['quizTitle'] == $quizname){
          $statement = "delete from studentDB where quizID = $quizID and teacherID = $teacherID;";
          $query_statement = $this->db->query($statement);
          if (!$query_statement){
            return array("success"=>false,"message"=>"quiz table is not found");
          }else return array("success"=>true,"message"=>"successful unpublish");
        }else return array("success"=>false,"message"=>"quiz is not found in myQuiz");
        /*if ($rowdelete['quizTitle'] == $quizname){
          $statement = "drop table $quizname;";
          $query_statement = $this->db->query($statement);
          if (!$query_statement){
            return array("success"=>false,"message"=>"quiz table is not found");
          }else{
            $statement1 = "delete from myQuiz where quizID = $quizID and teacherID = $teacherID;";
            $query_statement1 = $this->db->query($statement1);
            if (!$query_statement1){
              return array("success"=>false,"message"=>"quiz is not found in myQuiz");
            }
          }
        }*/
      }
    }else return array("success"=>false,"message"=>"quiz is not found studentDB");
  }

}

public function feedback_teacher($quiztitle,$username,$student){
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"Teacher: User Does Not Exist");
    }else {
      $teacherID = $this->getUserID($username);
    }
  if ($this->getUserID($student) == 0){
      return array("success"=>false, "message"=>"Student: User Does Not Exist");
    }else {
      $studentID = $this->getUserID($student);
    }
  $query = "select * from feedbackTable where userID = '$studentID' and quizTitle = '$quiztitle' and teacherID = '$teacherID';";
  $result = $this->db->query($query);
  if(!$result){
    return array("success"=>false, "message"=>"Fail to connect to feedback table");
  }else{
    if($result->num_rows > 0){
      $feed_array = array();
      $counter=0;
      while($row = $result->fetch_assoc()){
        $result_array = array();
        $counter++;
        $result_array['questionID'] = $row['questionID'];
        $result_array['questionType'] = $row['questionType'];
        $result_array['answer'] = $row['answer'];
        $result_array['feedback1'] = $row['testans1'];
        $result_array['feedback2'] = $row['testans2'];
        $result_array['feedback3'] = $row['testans3'];
        $result_array['feedback4'] = $row['testans4'];
        $result_array['feedback5'] = $row['testans5'];
        $feed_array["$counter"] = $result_array;
      }
      return array("success"=>true, "message"=>$feed_array);
    }else return array("success"=>false, "message"=>"$quiztitle and $student not found in feedback table");
  }
}

public function questionInfo($questionID,$questionType,$username){
  if ($this->getUserID($username) == 0){
      return array("success"=>false, "message"=>"Teacher: User Does Not Exist");
    }else {
      $teacherID = $this->getUserID($username);
    }

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

public function splitScreen($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB where userID = '$userID';";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }
}


public function printMC($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB where questionType = 'MC' and userID = $userID;";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }else {
    $count = 1;
    while ($row = $results->fetch_assoc()){
        $question = $row['questionID'];
        $queryType = "select * from MultipleChoice where questionID = '$question';";
        $result_question = $this->db->query($queryType);
        if (!$result_question){
          return array("success" => false, "message" => "failed connecting MC DB");
        }
        if ($result_question->num_rows > 0){
          $getquestion = $result_question->fetch_assoc();
          $result_array["$count"] = $getquestion["question"];
        }
        $count++;
      }
  }
    return $result_array;
}

public function printTF($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB where questionType = 'TF' and userID = $userID;";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }else {
    $count = 1;
    while ($row = $results->fetch_assoc()){
        $question = $row['questionID'];
        $queryType = "select * from TrueandFalse where questionID = '$question';";
        $result_question = $this->db->query($queryType);
        if (!$result_question){
          return array("success" => false, "message" => "failed connecting TF DB");
        }
        if ($result_question->num_rows > 0){
          $getquestion = $result_question->fetch_assoc();
          $result_array["$count"] = $getquestion["question"];
        }
        $count++;
      }
  }
    return $result_array;
}

public function printFB($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB where questionType = 'FB' and userID = $userID;";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }else {
    $count = 1;
    while ($row = $results->fetch_assoc()){
        $question = $row['questionID'];
        $queryType = "select * from FillTheBlank where questionID = '$question';";
        $result_question = $this->db->query($queryType);
        if (!$result_question){
          return array("success" => false, "message" => "failed connecting FB DB");
        }
        if ($result_question->num_rows > 0){
          $getquestion = $result_question->fetch_assoc();
          $result_array["$count"] = $getquestion["question"];
        }
        $count++;
      }
  }
    return $result_array;
}


public function printOE($username){
  if ($this->getUserID($username) == 0){
    return array("success"=>false, "message"=>"User Does Not Exist");
  }else {
    $userID = $this->getUserID($username);
  }
  $result_array = array();
  $teachDBquery = "select * from teacherDB where questionType = 'OE' and userID = $userID;";
  $results= $this->db->query($teachDBquery);
  if (!$results){
    return array("success" => false, "message" => "error connecting teacherDB");
  }else {
    $count = 1;
    while ($row = $results->fetch_assoc()){
        $question = $row['questionID'];
        $queryType = "select * from OpenEnded where questionID = '$question';";
        $result_question = $this->db->query($queryType);
        if (!$result_question){
          return array("success" => false, "message" => "failed connecting OE DB");
        }
        if ($result_question->num_rows > 0){
          $getquestion = $result_question->fetch_assoc();
          $result_array["$count"] = $getquestion["question"];
        }
        $count++;
      }
  }
    return $result_array;
}




}


?>
