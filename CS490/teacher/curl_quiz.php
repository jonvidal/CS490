<?php
$comment = '';
if (isset($_POST['questionID'])) {
    $check = $_POST['quiztitle'];
    $csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS =>json_encode(array('quiztitle' => $check, 'role' => 'createquiztable' )),
      CURLOPT_RETURNTRANSFER =>true,
    ));
    $request = curl_exec($csession);
    curl_close($csession);
    $respond=json_decode($request, true);

    if ($respond['success']==true){
        $optionArray = $_POST['questionID'];
        for ($i=0; $i<count($optionArray); $i++) {
          list($value1,$value2) = explode('|', $optionArray[$i]);
          $csession1 = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle_quiz.php");
          $send1 = array('quiztitle' => $_POST['quiztitle'], 'questionID' => $value1, 'questionType' => $value2, 'username' => $user, 'role' => 'add' );
          curl_setopt_array($csession1, array(
            CURLOPT_POST =>true,
            CURLOPT_POSTFIELDS => json_encode($send1),
            CURLOPT_RETURNTRANSFER =>true,
          ));
          $request1 = curl_exec($csession1);
          curl_close($csession1);
          $respond1=json_decode($request1, true);

          if ($respond1['success']==false){
            $i=count($optionArray);
          }
      }
      $comment = "<div class='alert alert-success'>Successfully Created Quiz</div>";
    }else $comment = "<div class='alert alert-danger'>Failed To Create Quiz: Duplicate Title</div>";
}








 ?>
