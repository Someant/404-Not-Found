<?php
$myusername=NULL;
$errowinfo=NULL;
$row=0;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$myusername=$_POST['email'];
	require 'config.php';
    require 'functions.php';

	$count=count($DB->query("SELECT * FROM user WHERE email=?", array($myusername)));

	if($count==1){
        $row=1;
        $rowvalue = $DB->row("SELECT * FROM user WHERE email=?", array($myusername));
        $pass=$rowvalue['pass'];
		$reseturl=$token=MD5($myusername.$pass);
         //$httpurl==$_SERVER[HTTP_HOST];
        $url='//404notfound.cc/reset.php?email='.$myusername.'&token='.$token;
        $time=date('y-m-d h:i:s',time());
        $DB->query("UPDATE user SET last_rest_pass_time =?  WHERE email=?", array($time,$myusername));

        $DB->CloseConnection();

		//mail函数预留
        $subject = '404NotFound-密码找回';
        $message = '请点击下面的链接进行密码重置，24小时内有效！'.$url;
        sendmail($myusername,$subject,$message);
    }
    else {
	    $errowinfo="请输入正确的邮箱地址！";$DB->CloseConnection();
	    $row=2;

    }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot-404 Not Found</title>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="style.css">
<!-- Custom styles for this template -->

<script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="dist/js/formValidation.min.js"></script>
<script src="dist/fr/bootstrap.min.js"></script>


</head>

<body>

    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="index.html">首页</a></li>
            <li role="presentation"><a href="about.html">关于</a></li>
            <li role="presentation"><a href="login.php">登录</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">404 Not Found</h3>
      </div>



      <div class="row marketing">
          <form class="form-horizontal" role="form" id="loginForm" method="post">
              <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-6">
                      <span class="label label-danger text-center" style="margin:0 auto;font-size:12px"><?php echo $errowinfo; ?></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">邮箱</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name="email" />
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-9 col-sm-offset-3">
                      <button type="submit" class="btn btn-primary" name="signup" value="submit">找回</button>
                  </div>
              </div>
          </form>
      </div>

      <footer class="footer">
        <p style="font-size:.9em">&copy; <a href="//404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="//someant.com" target="_blank">Someant</a></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/site.js"></script>

</body>
</html>
