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
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

</head>

<body>
<?php
if($user==NULL) header("location:index.html");

require 'config.php';

$tbl_name="user"; // Table name

$vpnflow=NULL;
$vpnflow=NULL;
$vpnpass=NULL;
$row = $DB->row("SELECT * FROM user WHERE email=?",array($user));

	  $vpnuser=$row['vpnuser'];
	  $vpnpass=$row['vpnpass'];
	  //$vpnflow=$row['vpnflow'];
	  $sspass=$row['passwd'];
	  $ssflow=$row['u']+$row['d'];
	  $port=$row['port'];
	  $endtime=$row['endtime'];

  $totalflow=$ssflow+$vpnflow;

  $ssflow=sprintf("%.2f", $ssflow/(1024*1024));
  if($vpnuser==null)
  {

	  $vpnuser='该账户并未开通VPN服务';
	  $vpnpass='需要开通请与管理员联系';
	  $vpnflow='暂无数据';
	  $totalflow='VPN数据暂时无法统计';
  }



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

<p class="text-center" style="font-size:14px;margin-bottom:-15px">加密方式为:RC4-MD5 旧金山(电信用户):sfo.404notfound.cc 新加坡(联通及铁通用户):
	sgp.404notfound.cc</p>
      <div class="jumbotron" style="background-color:#FFF">

            <div role="tabpanel">

              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">旧金山</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">新加坡</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">洛杉矶</a></li>

              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                	<img class="img-responsive" src="http://info.404notfound.cc/sfo/sfo/fw_conntrack-day.png" style="margin:5px auto;">
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                	<img class="img-responsive" src="http://info.404notfound.cc/sgp/sgp/fw_packets-day.png" style="margin:5px auto;">
                </div>
                <div role="tabpanel" class="tab-pane" id="messages"><p class="text-center">暂无数据</p></div>

              </div>

            </div>
      </div>

      <div class="row marketing">
        <div class="col-lg-6">

          <h4>VPN账号</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $vpnuser ?>" name="vpnuser"></p>

          <h4>VPN密码</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $vpnpass ?>" name="vpnpass"></p>

          <h4>VPN流量</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $vpnflow ?>" readonly></p>
        </div>


        <div class="col-lg-6">
          <h4>SS密码</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $sspass ?>" name="vpnpass"></p>

          <h4>SS端口及流量</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $port.' : '.$ssflow.'MB' ?>" readonly></p>

          <h4>总流量</h4>
          <p><input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo $totalflow ?>" readonly></p>

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
        <p>&copy; 404NOTFOUND 2015</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
