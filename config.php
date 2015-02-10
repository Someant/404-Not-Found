<?php
//数据库配置文件
define('DBHost', 'localhost');
define('DBName', 'xxxx');
define('DBUser', 'xxxx');
define('DBPassword', 'xxxxxxx');
require(dirname(__FILE__)."/src/PDO.class.php");
$DB = new Db(DBHost, DBName, DBUser, DBPassword);
?>
