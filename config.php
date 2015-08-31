<?php
//数据库配置文件
define('DBHost', 'localhost');
define('DBName', '404');
define('DBUser', '404');
define('DBPassword', '123123');
require(dirname(__FILE__)."/src/PDO.class.php");
$DB = new Db(DBHost, DBName, DBUser, DBPassword);
$beginflow=10240;//初始流量设置 单位MB
$portwidth=[50000,59999];//端口范围
$base_url="127.0.0.1/404new";

//smtp settings
$smtp_settings=array(
	'host' => 'xxxxx',
	'auth' => 'true',
	'mail' => 'xxxxx',
	'password' => 'xxxxxx',
	'srcure' => 'tls',
	'port' => '25',
	'fromname' => '404notfound'
	
);
