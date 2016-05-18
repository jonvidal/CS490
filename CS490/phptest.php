<?php
//Permissions no longer an issue;
//$fontinfo = file_get_contents('php://input');
//$Questions = json_decode($frontinfo);
$java_output="";
exec("javac myjava.java");//creates the Class.class
$filec = "myjava.class";
if(file_exists($filec) == true){ //if it compiled properly it would be there
echo "File was created!<br/>";
$java_output = shell_exec("java myjava"); #save the output of the java code. Only the last line of the output.
}
echo $java_output;
?>
