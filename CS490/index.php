<?php
session_start();
include("header.php");
$error="";
if (isset($_POST['login'])){
  if ( empty($_POST['userName']) || empty($_POST['passWord']) ){
    $error = "<div class='alert alert-danger' style=width:500px;'>Please, complete the form</div>";
  }else {
    $credential = json_encode(array("userName" => $_POST["userName"],
                  "passWord" => $_POST["passWord"]));
    $csession = curl_init("http://afsaccess1.njit.edu/~jkv5/CS490/middle.php");
    curl_setopt_array($csession, array(
      CURLOPT_POST =>true,
      CURLOPT_POSTFIELDS => $credential,
      CURLOPT_FOLLOWLOCATION=>true,
      CURLOPT_RETURNTRANSFER =>true,
      CURLOPT_SSL_VERIFYPEER=>false,
    ));
    $request = curl_exec($csession);

    curl_close($csession);
    //decoding the respond of the middle end
    $respond=json_decode($request, true);

    if($respond['validate'] == true){
      if($respond["status"] == 'student'){
        $_SESSION['userName'] = $_POST['userName'];
        header("Location: student/student.php");
      }else if ($respond["status"] == 'teacher'){
        $_SESSION['userName'] = $_POST['userName'];
        header("Location: teacher/teacher.php");
      }else $error = "<div class='alert alert-danger' style=width:500px;'>Something went wrong!</div>";
    }else $error = "<div class='alert alert-danger' style=width:500px;'>Wrong Username/Password. Try Agian!</div>";
  }
}

?>

<div class = "container" style="padding-top:100px;text-align:center;">

  <h1>Welcome to Online Quiz</h1>
  <p class="lead">Use this form to log in to your account</p>
  <form class="form-incline" action="" method="post">
    <table style="margin:auto;">
        <tr><td><?php echo $error; ?></td></tr>
      <tr><td>
    	<div class="form-group">
        <label for="userName"  class="sr-only">Username:</label>
        <input type="text" class="form-control" id="userName" name="userName" placeholder="Username" style="width:500px;"/>
      </div>
    </td></tr>
    <tr><td>
      <div class="form-group">
        <label for="passWord"  class="sr-only">Password:</label>
        <input type="password" class="form-control" id="passWord" name="passWord" placeholder="Password" style="width:500px;"/>
      </div>
    </td></tr>
    <tr><td>
      <input type="submit" name="login" class="btn btn-default" value="Submit" style="width:200px;"/>
    </td></tr>
    </table>
  </form>
</div>
</body>
</html>
