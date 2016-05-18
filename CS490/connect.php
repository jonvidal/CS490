<?php
$request = file_get_contents("php://input");
$recieve = json_decode($request, true);
$ucid = $recieve["ucid"];
$pass = $recieve["pwd"];

$localhost = "sql1.njit.edu";
$root = "jkv5";
$password = "buddhist6";
$db = "jkv5";
//setting up salt manually
$salt ="q23hfvrnc34r89nxqwmr1p3yr1834yriq";

function saltPass($password,$salt){
  return sha1($password.$salt); // where the password is beign hash/salt
}
//validates if the user is in our database
function studentAuth($conn,$ucid, $pass){
  $query = "select * from login where ucid = '$ucid';";
  $results = mysqli_query($conn, $query);
  if (!$results){
    echo "error with results: ".mysqli_error();
    return 0;
  }
  $login = mysqli_fetch_assoc($results); //currently, the password in the db is not hash/salt. therefore we manually salt the value of the potential user's password in our database. Then, we compare the salt password of the user in our db and salt inputted password 
  if ($login["ucid"] == "$ucid" && saltPass($login["pass"]) == saltPass("$pass")){
    echo "true";
  }else echo "false";
  }

$conn = mysqli_connect($localhost, $root, $password, $db);
if (!$conn){
  die ("mysql connection fail: ".mysqli_connect_error());
}

studentAuth($conn,$ucid, $pass);

mysqli_close($conn);


?>
