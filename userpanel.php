<?php session_start();$user=@$_SESSION['myusername'];?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>用户中心-404 NOT FOUND</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="style.css">
<!-- Custom styles for this template -->

<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

</head>

<body>
<?php
if($user==NULL) header("location:index.html");

require 'config.php';

$tbl_name="user"; // Table name

$row = $DB->row("SELECT * FROM user WHERE email=?",array($user));


	$sspass=$row['passwd'];
	$ssflow=$row['u']+$row['d'];
	$port=$row['port'];
	$endtime=$row['endtime'];
	$totalflow=$row['transfer_enable'];
	$lv=$row['level'];

	$errowinfo=NULL;
	$successinfo=NULL;
  $ssflow=sprintf("%.2f", $ssflow/(1024*1024));
	$totalflow=sprintf("%.0f", $totalflow/(1024*1024));


 // mysql_close();
	$DB->CloseConnection();
?>
    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li><a href="index.html">首页</a></li>
            <li><a href="help.html" target="_blank">使用帮助</a></li>
            <li>
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo $user;?><span class="caret"></span>
   			 </a>
            <ul class="dropdown-menu" role="menu">
            	  <li><a href="#">到期时间:</a></li>
                  <li><a href="#"><?php echo $endtime ?></a></li>
                  <li><a href="logout.php">退出</a></li>
                </ul>

            </li>

          </ul>
        </nav>
        <h3 class="text-muted">用户中心</h3>
      </div>

<p class="text-center" style="font-size:14px;margin-bottom:-15px">加密方式为:RC4-MD5 取消原来的SGP节点 HK为测试节点 也可以正常使用 加密方式为aes-256-cfb</p>


      <div class="row marketing">
        <div class="col-lg-6">

          <h4>二维码<small> APP可以扫描下面的二维码快速完成配置</small></h4>

					<p><?php require  'qrcode.php'; ?></p>
        </div>


        <div class="col-lg-6">
          <h4>SS端口</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $port ?>" readonly></p>

          <h4>SS密码</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $sspass ?>" readonly></p>

          <h4>流量</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $ssflow.'/'.$totalflow.'MB' ?>" readonly></p>

        </div>

        <div class="col-lg-12">
        	<p class="text-center"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></p>
        	<p class="text-center">x.流量均指本月已使用流量,从本月1号开始计算.</p>
          <p class="text-center">x.流量使用完毕系统将会自动冻结账号.</p>
					<p class="text-center">x.重置密码请使用密码找回功能，同时SS密码将一并重置！</p>
        	<p class="text-center"><a href="forgot.php" target="_blank" type="button" class="btn btn-success">重置密码</a></p>
        </div>
      </div>


      <footer class="footer">
				<p style="font-size:.9em">&copy; <a href="http://404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="http://someant.com" target="_blank">Someant</a></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
