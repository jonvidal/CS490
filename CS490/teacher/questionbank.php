<?php
session_start();
$user = '';

if(isset($_SESSION['userName'])){
  $user = $_SESSION['userName'];
}else{
  header("Location: http://afsaccess1.njit.edu/~jkv5/CS490/unauthorized_error.php");
}
include("getquestions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
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
                    <li class="active">
                        <a href="questionbank.php">Question Bank</a>
                    </li>
                    <li>
                        <a href="makequiz.php">myQuiz</a>
                    </li>
                    <li>
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
  <h2>Question Bank</h2>
  <form role="form" action="makequiz.php" method="post">
  <div class="form-group">
  <p class="lead">Select question(s):</p>

  <table  style="width:100%;margin-bottom:20px;"><p>Create Quiz:</p><tr><td style="width:70%;">

  <input type="text" class="form-control" name="quiztitle" placeholder="Enter the title of the quiz..."/></td><td style="width:30%;padding-left:10px;">
  <input type="submit" name="add" class="btn btn-default" value="Submit" style="width:100%;"/></td></tr></table>

  <div class="optionsDiv">
    <table style="width:100%;"><tr><td style="width:50%;padding:10px;">
      Search For Question
      <input type="text" class="form-control" id="search" placeholder="Type to search">

      </td>
      <td>Filter By Question Type
      <select id="selectField" class="form-control">
          <option value="All" selected>All</option>
          <option value="TF">True or False</option>
          <option value="MC">Multiple Choice</option>
          <option value="FB">Fill in the Blank</option>
          <option value="OE">Open Ended</option>
          </select>
      </td>
    </tr></table>
      <div>
    </div>
  <div class="table-responsive">

  <table id='myTable' class='table'>
      <tr>
        <th tyle="width:10%;">#</th>
        <th tyle="width:50%;">Question</th>
        <th tyle="width:30%;">Type</th>
        <th tyle="width:30%;">Points</th>
        <th style="width:10%;">Add</th>
      </tr>

    <body>
      <?php echo $result_table;?>
    </body>
  </table>
  </div>
  </div>
</form>
</div>
<script >

$(document).ready(function() {

    function addRemoveClass(theRows) {

        theRows.removeClass("odd even");
        theRows.filter(":odd").addClass("odd");
        theRows.filter(":even").addClass("even");
    }

    var rows = $("table#myTable tr:not(:first-child)");

    addRemoveClass(rows);


    $("#selectField").on("change", function() {

        var selected = this.value;

        if (selected != "All") {

            rows.filter("[position=" + selected + "]").show();
            rows.not("[position=" + selected + "]").hide();
            var visibleRows = rows.filter("[position=" + selected + "]");
            addRemoveClass(visibleRows);
        } else {

            rows.show();
            addRemoveClass(rows);

        }

    });
});

var $rows = $('#myTable tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>
</body>
</html>
