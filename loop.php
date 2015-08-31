<?php
date_default_timezone_set('prc');
//这个一个循环文件 主要用来冻结未续费用户
require 'config.php';
$time=date('y-m-d',time());
//遍历所有已被激活的用户
foreach($DB->query("SELECT * FROM user where switch=1 ") as $row)
{
  $d1=strtotime($time);
  $d2=strtotime($row['endtime']);
  $Days=round(($d1-$d2)/3600/24);
  if($Days>0)
  {
    $DB->query("UPDATE user SET switch=? WHERE id=?", array(0,$row['id']));
  }
}

//每月1号流量清0

if(date('d',time())==1)
{
  $re=$DB->query("UPDATE user SET u=?,d=? ", array(0,0));
  if($re)
  {
    var_dump($re);
  }

  //var_dump(date('d',time()));
}

$DB->CloseConnection();

echo 'test';