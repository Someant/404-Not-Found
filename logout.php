<?php 
// Put this code in first line of web page. 
 session_start();
 session_destroy();
 
 header("location:index.html");
 ?>