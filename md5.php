<?php
date_default_timezone_set('prc');
  $e=MD5('123123404notfound');
  echo MD5('test@test.com'.$e);
  require 'config.php';
  $row=$DB->row("SELECT * FROM user WHERE email=?", array('test@test.com'));
  $lasttime=$row['last_rest_pass_time'];
  $time=date('y-m-d h:i:s',time());
  echo $time;
  echo $lasttime;
   if((strtotime($time)-strtotime($lasttime))/3600>24)
   {
     echo 0;
   }
   else
   {echo 1;}
   require 'functions.php';
   $url = '1111';

    $time = date('Y-m-d H:i');
    $email='2275277266@qq.com';
    $result = sendmail($time,$email,$url);
?>
