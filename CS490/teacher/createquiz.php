<?php
session_start();
$user = '';
if(isset($_SESSION['userName'])){
  $user = $_SESSION['userName'];
}else{
  header("Location: http://afsaccess1.njit.edu/~jkv5/CS490/unauthorized_error.php");
}
include("sendquestion.php");
include("lastmin.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CS490 - Online Quiz</title>
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">

              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="teacher.php">Online Quiz</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="teacher.php">Home</a>
                    </li>
                    <li class="active">
                        <a href="createquiz.php">Create A Question</a>
                    </li>
                    <li>
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

          </div>

      </nav>
<div class = "container" style="padding-top:50px;">
<h2>Create A Question:</h2>
<p class="lead">Select the type of the question:</p>
<?php echo $error;?>
<?php echo $success;?>
<br/>
<div class="bs-example">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#sectionA">Multiple Choice</a></li>
        <li><a href="#sectionB">True Or False</a></li>
        <li><a href="#sectionC">Fill In The Blank</a></li>
        <li><a href="#sectionD">Open Ended</a></li>
    </ul>
    <div class="tab-content">

      <!-- MULTIPLE CHOICE -->
        <div id="sectionA" class="tab-pane fade in active">
            <h3 style="margin-top:10px;">Multiple Choice</h3>
            <form role="form" action="" method="post">
              <div class="form-group">


                <table style="width:100%;">
                <tr>
                <td style="width:50%; padding:10px;">

                <table style="width:100%;">
                  <tr><td style='width:50%;'>
                    <p class="lead"  >Enter The Question:</p></td>
                  <td>
                    <input type="number" class="form-control" name="points" style='width:100%;' placeholder="Points..."/>
                  </td>
                </tr>
                  <tr><td colspan="2">
                    <textarea class="form-control" name="question" style="height:150px;resize: none;"></textarea>
                  </td><td></td></tr><tr><td colspan="2">
                    <p class="lead" >Enter The Choices &amp; Correct Answer:</p>
                  </td><td></td></tr>
                  <tr><td style="width:50%; padding:5px 5px;">
                    <input type="radio" name="ans" value="A" >&nbsp;A&nbsp;
                    <input type="text" class="form-control" name="optA"/>
                  </td><td style="width:50%;padding:5px 5px;">
                    <input type="radio" name="ans" value="B" >&nbsp;B&nbsp;
                    <input type="text" class="form-control" name="optB" />
                  </td><tr><td style="width:50%;padding:5px 5px;">
                    <input type="radio" name="ans" value="C" >&nbsp;C&nbsp;
                    <input type="text" class="form-control" name="optC" />
                  </td><td style="width:50%;padding:5px 5px;">
                    <input type="radio" name="ans" value="D">&nbsp;D&nbsp;
                    <input type="text" class="form-control" name="optD" />
                  </td><tr><td colspan="2">
                    <input type="hidden" name="questionType" value="MC"/>
                    <input type="submit" name="add" class="btn btn-default" value="Submit" style="width:350px;"/>
              </td><td>
              </td></tr>
              </table>
            </td>
            <td style="vertical-align: text-top; padding-left:10px;border-left:2px solid black;">
              <?php echo $result_table;?>
            </td>
            </tr>
            </table>


              </div>
            </form>
        </div>

        <!-- TRUE OR FALSE -->
        <div id="sectionB"  class="tab-pane fade">
          <h3 style="margin-top:10px;">True or False</h3>
          <form role="form" action="" method="post">
            <div class="form-group">
              <table style="width:100%;"><tr><td style="width:50%;padding:10px;">

              <table style="width:100%;">
                <tr><td style='width:50%;'>
                  <p class="lead"  >Enter The Question:</p></td>
                <td>
                  <input type="number" class="form-control" name="points" style='width:100%;' placeholder="Points..."/>
                </td>
              </tr>
                <tr><td colspan="2">
                  <textarea class="form-control" name="question" style="height:150px;resize:none;"></textarea>
                </td><td></td></tr>
                <tr>
                <td colspan="2">
                  <p class="lead">Enter The Correct Answer:</p>
                  <input type="radio" name="ans" value="T" >&nbsp;<span class="lead">&nbsp;True&nbsp;</span>&nbsp;
                    <br/><br/>
                  <input type="radio" name="ans" value="F" >&nbsp;<span class="lead">&nbsp;False&nbsp;</span>&nbsp;
                    <br/><br/>
                  <input type="hidden" name="questionType" value="TF"/>
                  <input type="submit" name="add" class="btn btn-default" value="Submit" style="width:350px;"/>
            </td><td></td></tr>
          </table>
        </td><td style="vertical-align: text-top; padding-left:10px;border-left:2px solid black;">
          <?php echo $result_tableTF;?>
        </td></tr>
        </table>
            </div>
          </form>
        </div>

        <!-- FILL IN THE BLANK -->
        <div id="sectionC" class="tab-pane fade">
            <h3 style="margin-top:10px;">Fill In The Blank</h3>
            <form role="form" action="" method="post">
              <div class="form-group">
                <table style="width:100%;"><tr><td style="width:50%;padding:10px;">
                <table style="width:100%;">
                  <tr><td style='width:50%;'>
                    <p class="lead"  >Enter The Question:</p></td>
                  <td>
                    <input type="number" class="form-control" name="points" style='width:100%;' placeholder="Points..."/>
                  </td>
                </tr>
                  <tr><td colspan="2" >
                    <textarea class="form-control" name="question" style="height:150px;resize:none;" placeholder="Please use the underscore key ( _ ) for the missing answer..."></textarea>
                  </td><td></td></tr>
                  <tr>
                  <td colspan="2">
                    <p class="lead">Enter The Choices &amp; Correct Answer:</p>
                  </td><td></td></tr>
                  <tr>
                    <td style="width:50%; padding:5px 5px;">
                    <input type="radio" name="ans" value="A" >&nbsp;&nbsp;
                    <input type="text" name="optA" class="form-control"/>
                  </td><td style="width:50%; padding:5px 5px;">
                    <input type="radio" name="ans" value="B" >&nbsp;&nbsp;
                    <input type="text" name="optB" class="form-control"/>
                  </td></tr>
                    <tr>
                    <td style="width:50%; padding:5px 5px;">
                    <input type="radio" name="ans" value="C" >&nbsp;&nbsp;
                    <input type="text" name="optC" class="form-control"/>
                  </td><td style="width:50%; padding:5px 5px;">
                    <input type="radio" name="ans" value="D">&nbsp;&nbsp;
                    <input type="text" name="optD" class="form-control"/>
                  </td></tr>
                  <tr>
                    <td colspan="2">
                    <input type="hidden" name="questionType" value="FB"/>
                    <input type="submit" name="add" class="btn btn-default" value="Submit" style="width:350px;"/>
              </td><td></td></tr>
              </table>
            </td>
            <td style="vertical-align: text-top; padding-left:10px;border-left:2px solid black;">
              <?php echo $result_tableFB;?>
            </td></tr>
            </table>
              </div>
            </form>
        </div>

        <!-- OPEN ENDED -->
        <div id="sectionD" class="tab-pane fade">
            <h3 style="margin-top:10px;">Open Ended</h3>
            <form role="form" action="" method="post">
              <div class="form-group">
                <table style="width:100%;"><tr><td style="width:50%;padding:10px;">
                <table style="width:100%;">
                  <tr><td style='width:50%;'>
                    <p class="lead"  >Enter The Question:</p></td>
                  <td>
                    <input type="number" class="form-control" name="points" style='width:100%;' placeholder="Points..."/>
                  </td>
                </tr>
                  <tr><td colspan="2">
                    <textarea class="form-control" name = "question" maxlength="1000" style="height:150px;resize:none;"></textarea>
                  </td><td></td></tr>
                  <tr>
                  <td colspan="2" style="padding:5px;">
                    <p class="lead">Enter The Correct Solution:</p>
                    <textarea class="form-control" name = "ans" maxlength="1000" style="height:150px;resize:none;" >public static...</textarea>
                  </td>
                  <td></td>
                  <!--<td style="padding:5px;width:50%;">
                    <p class="lead" style="margin-bottom:0px;padding:0xp;">Enter Test Case:</p><span class="small"> Note: Write the function name with the parameters and its data type, e.g., <i>printHello(string hello);</i></span>
                    <textarea class="form-control" name = "testcase" maxlength="1000" style="height:150px;resize:none;"></textarea>
                  </td>-->
                </tr>
                <tr>
                  <td colspan="2"><p class="lead">Enter The Function Name:</p>
                  <input type="type" name="function" class="form-control" style="width:100%;"/></td><td></td>
                </tr>

                    <tr>
                      <td colspan="2">
                      <!--style="width:100%;padding:10px;height:50;overflow:scroll;border:1px solid black;-->
                      <table style="width:100%;">
                      <tr>
                        <td style="padding-left:10px;padding-right:10px;"><p class="lead">Enter Test Cases:</p></td>
                        <td style="padding-left:10px;padding-right:10px;"><p class="lead">Enter Output:</p></td>
                      </tr>
                      <tr>
                      <td style="padding:10px;"><input type="text" name="testcase1" class="form-control" placeholder="Test Cases #1"></td>
                      <td style="padding:10px;"><input type="text" name="answer1" class="form-control" placeholder="Answer #1"></td>
                      </tr>
                      <tr>
                      <td style="padding:10px;"><input type="text" name="testcase2" class="form-control" placeholder="Test Cases #2"></td>
                      <td style="padding:10px;"><input type="text" name="answer2" class="form-control" placeholder="Answer #2"></td>
                      </tr>
                      <tr>
                      <td style="padding:10px;"><input type="text" name="testcase3" class="form-control" placeholder="Test Cases #3"></td>
                      <td style="padding:10px;"><input type="text" name="answer3" class="form-control" placeholder="Answer #3"></td>
                      </tr>
                      <tr>
                      <td style="padding:10px;"><input type="text" name="testcase4" class="form-control" placeholder="Test Cases #4"></td>
                      <td style="padding:10px;"><input type="text" name="answer4" class="form-control" placeholder="Answer #4"></td>
                      </tr>
                      <tr>
                      <td style="padding:10px;"><input type="text" name="testcase5" class="form-control" placeholder="Test Cases #5"></td>
                      <td style="padding:10px;"><input type="text" name="answer5" class="form-control" placeholder="Answer #5"></td>
                      </tr>

                    </table>
                  </td>
                  <td></td>
                    </tr>

                  <tr><td colspan="2" style="padding:5px"> <input type="hidden" name="questionType" value="OE"/>
                    <input type="submit" name="add" class="btn btn-default" value="Submit" style="width:350px;"/></td><td></td></tr>
              </table>
            </td><td style="vertical-align: text-top; padding-left:10px;border-left:2px solid black;">
              <?php echo $result_tableOE;?>
            </td></tr>
            </table>
              </div>
            </form>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#myTab a").click(function(e){
    	e.preventDefault();
    	$(this).tab('show');
    });
});

function sortTable(f,n){
	var rows = $('#mytable tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getVal(a);
		var B = getVal(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getVal(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#mytable').children('tbody').append(row);
	});
}
var f_sl = 1;
var f_nm = 1;
$("#sl").click(function(){
    f_sl *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_sl,n);
});
$("#nm").click(function(){
    f_nm *= -1;
    var n = $(this).prevAll().length;
    sortTable(f_nm,n);
});


function sortTableTF(f,n){
	var rows = $('#mytableTF tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getValTF(a);
		var B = getValTF(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getValTF(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#mytableTF').children('tbody').append(row);
	});
}
var f_sl = 1;
var f_nm = 1;
$("#slTF").click(function(){
    f_sl *= -1;
    var n = $(this).prevAll().length;
    sortTableTF(f_sl,n);
});
$("#nmTF").click(function(){
    f_nm *= -1;
    var n = $(this).prevAll().length;
    sortTableTF(f_nm,n);
});

function sortTableFB(f,n){
	var rows = $('#mytableFB tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getValFB(a);
		var B = getValFB(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getValFB(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#mytableFB').children('tbody').append(row);
	});
}
var f_sl = 1;
var f_nm = 1;
$("#slFB").click(function(){
    f_sl *= -1;
    var n = $(this).prevAll().length;
    sortTableFB(f_sl,n);
});
$("#nmFB").click(function(){
    f_nm *= -1;
    var n = $(this).prevAll().length;
    sortTableFB(f_nm,n);
});

function sortTableOE(f,n){
	var rows = $('#mytableOE tbody  tr').get();

	rows.sort(function(a, b) {

		var A = getValOE(a);
		var B = getValOE(b);

		if(A < B) {
			return -1*f;
		}
		if(A > B) {
			return 1*f;
		}
		return 0;
	});

	function getValOE(elm){
		var v = $(elm).children('td').eq(n).text().toUpperCase();
		if($.isNumeric(v)){
			v = parseInt(v,10);
		}
		return v;
	}

	$.each(rows, function(index, row) {
		$('#mytableOE').children('tbody').append(row);
	});
}
var f_sl = 1;
var f_nm = 1;
$("#slOE").click(function(){
    f_sl *= -1;
    var n = $(this).prevAll().length;
    sortTableOE(f_sl,n);
});
$("#nmOE").click(function(){
    f_nm *= -1;
    var n = $(this).prevAll().length;
    sortTableOE(f_nm,n);
});

</script>
</body>
</html>
