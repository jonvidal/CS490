<?php
session_start();
$user = '';
if(isset($_SESSION['userName'])){
  $user = $_SESSION['userName'];
}else{
  header("Location: http://afsaccess1.njit.edu/~jkv5/CS490/unauthorized_error.php");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CS490 - Online Quiz</title>
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="teacher.php">Online Quiz</a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="teacher.php">Home</a>
                    </li>
                    <li>
                        <a href="createquiz.php">Create A Question</a>
                    </li>
                    <li>
                        <a href="questionbank.php">Question Bank</a>
                    </li>
                    <li>
                        <a href="makequiz.php">myQuiz</a>
                    </li>
                    <li class="active">
                        <a href="grades.php">Students' Grades</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a>Welcome, <?php echo $user;?></a>
                  </li>
                  <li>
                      <a href="../logout.php">Logout</a>
                  </li>
                </ul>
              </div>
              <!-- /.navbar-collapse -->
          </div>
          <!-- /.container -->
      </nav>

<div class = "container" style="padding-top:50px;">
<h2>Students' Grades</h2>
<br/>
<?php include('getgrades.php')?>
</div>
</body>
</html>
