# 404-Not-Found
The front end shadowsocks of user management.
The back-end base on shadowsocks manyuser branch.
https://github.com/mengskysama/shadowsocks/tree/manyuser
You can use it if the back-end  use manyuser

###Note:

Probably will release a new version in September 1, you have any questions you can send e-mail to support@404notfound.cc or sumbit a issues.

* PHP>=5.4
* if you want show server infomation need istall munin
* PDO.Mysql


#About:
我只是想预习一下，然后不不把代码秀出来的话，都不知道自己写得有多烂。

###Demo:<a href="http://404notfound.cc/" target="_blank">404notfound.cc</a>

#Test Data
```bash
Default User account：demo@demo.com    123456
Default Administrator account:demo  123456
Default Gift card:123456
Administrator Page Url:yourdomain.com/admin
```
#UserPanel
<img src="http://ww4.sinaimg.cn/mw690/b1209f59gw1eqzn2nzpq5j20n10jkwfw.jpg">

#Administrator Page
<img src="http://ww1.sinaimg.cn/mw690/b1209f59gw1eqzn2pgcabj20n10jktax.jpg">
<img src="http://ww4.sinaimg.cn/mw690/b1209f59gw1eqzn2ohds6j20n10jkwfy.jpg">

#How do you use it?

* Step 1:
import sql.sql

* Step 2:
edit config.php change mysql connection
```php
define('DBHost', 'localhost');
define('DBName', '404');
define('DBUser', '404');
define('DBPassword', 'password');
require(dirname(__FILE__)."/src/PDO.class.php");
$DB = new Db(DBHost, DBName, DBUser, DBPassword);
$beginflow=10240;//初始流量设置 单位MB
$portwidth=[50000,59999];//端口范围
$base_url="404notfound.cc";
```
<<<<<<< HEAD
* Step 3:
=======
3. Step 3:
>>>>>>> origin/master
Auto stop server when user becoming due,you can using crontab:
```bash
example:15,45 * * * * curl http:yourdomain.com/loop.php
```

#Update
September 1 :Support Ajax

