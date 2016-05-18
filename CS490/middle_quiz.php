<?php
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
switch ($recieve['role']) {
  case 'createquiztable':
    $quiztitle = $recieve['quiztitle'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle , 'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'add':
    $quiztitle = $recieve['quiztitle'];
    $questionID = $recieve['questionID'];
    $questionType = $recieve['questionType'];
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle, 'questionID' => $questionID,
        'questionType' => $questionType, 'username' => $username, 'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;
  case 'printQuiz':
    $username = $recieve['username'];
    $role = $recieve['role'];
    $quiztitle = $recieve['quiztitle'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('username' => $username, 'role' => $role)),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'publish':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle ,'username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'getgrades':
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'release':
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'checker':
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

  case 'unpublish':
    $quiztitle = $recieve['quiztitle'];
    $username = $recieve['username'];
    $role = $recieve['role'];
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle ,'username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
    break;

 case 'deletemyquiz':
   $quiztitle = $recieve['quiztitle'];
   $username = $recieve['username'];
   $role = $recieve['role'];
   $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
   $csession = curl_init($back_url);
   curl_setopt_array($csession, array(
     CURLOPT_POST =>true,
     CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle ,'username' => $username ,'role' => $role )),
     CURLOPT_RETURNTRANSFER =>true,
   ));
   $request = curl_exec($csession);
   curl_close($csession);
   $respond=json_decode($request, true);
   echo json_encode($respond);
   break;

 case 'getfeedback':
   $quiztitle = $recieve['quiztitle'];
   $username = $recieve['username'];
   $student = $recieve['student'];
   $role = $recieve['role'];
   $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
   $csession = curl_init($back_url);
   curl_setopt_array($csession, array(
     CURLOPT_POST =>true,
     CURLOPT_POSTFIELDS => json_encode(array('quiztitle' => $quiztitle ,'username' => $username, 'student' => $student,'role' => $role )),
     CURLOPT_RETURNTRANSFER =>true,
   ));
   $request = curl_exec($csession);
   //echo $request;
   curl_close($csession);
   $respond=json_decode($request, true);
   echo json_encode($respond);

   break;

case 'questioninfo':
  $questionID = $recieve['questionID'];
  $questionType = $recieve['questionType'];
  $username = $recieve['username'];
  $role = $recieve['role'];
  $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
  $csession = curl_init($back_url);
  curl_setopt_array($csession, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS => json_encode(array('username' => $username, 'questionID'=>$questionID,'questionType' =>  $questionType,'role' => $role )),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $request = curl_exec($csession);
  //echo $request;
  curl_close($csession);
  $respond=json_decode($request, true);
  echo json_encode($respond);
  break;
case 'split':
  $username = $recieve['username'];
  $role = $recieve['role'];
  $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
  $csession = curl_init($back_url);
  curl_setopt_array($csession, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $request = curl_exec($csession);
  curl_close($csession);
  $respond=json_decode($request, true);
  echo json_encode($respond);
  break;

case 'MC':
  $username = $recieve['username'];
  $role = $recieve['role'];
  //var_dump($recieve);
  $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
  $csession = curl_init($back_url);
  curl_setopt_array($csession, array(
    CURLOPT_POST =>true,
    CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
    CURLOPT_RETURNTRANSFER =>true,
  ));
  $request = curl_exec($csession);
  curl_close($csession);
  $respond=json_decode($request, true);
  echo json_encode($respond);
 break;

 case 'TF':
   $username = $recieve['username'];
   $role = $recieve['role'];
   //var_dump($recieve);
   $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
   $csession = curl_init($back_url);
   curl_setopt_array($csession, array(
     CURLOPT_POST =>true,
     CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
     CURLOPT_RETURNTRANSFER =>true,
   ));
   $request = curl_exec($csession);
   curl_close($csession);
   $respond=json_decode($request, true);
   //echo $request;
   echo json_encode($respond);
  break;

  case 'FB':
    $username = $recieve['username'];
    $role = $recieve['role'];
    //var_dump($recieve);
    $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
    $csession = curl_init($back_url);
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);
    echo json_encode($respond);
   break;


 case 'OE':
   $username = $recieve['username'];
   $role = $recieve['role'];
   //var_dump($recieve);
   $back_url = "http://afsaccess1.njit.edu/~jkv5/CS490/back_quiz.php";
   $csession = curl_init($back_url);
   curl_setopt_array($csession, array(
     CURLOPT_POST =>true,
     CURLOPT_POSTFIELDS => json_encode(array('username' => $username ,'role' => $role )),
     CURLOPT_RETURNTRANSFER =>true,
   ));
   $request = curl_exec($csession);
   curl_close($csession);
   $respond=json_decode($request, true);
   echo json_encode($respond);
  break;

  
  default:
    # code...
    break;
}



  ?>
