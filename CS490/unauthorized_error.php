<?php
include("header.php");

?>

<script type="text/javascript">
  function countDown(secs){
    if (secs < 1){
      clearTimeout(timer);
      window.location = 'http://afsaccess1.njit.edu/~jkv5/CS490/index.php';
    }
    secs--;
    var timer = setTimeout('countDown('+secs+')',1000);
  }
</script>
<div class = "container" style="padding-top:100px;text-align:center;"><h1>Access Denied!</h1><br/>
<script type="text/javascript">countDown(1);</script>
