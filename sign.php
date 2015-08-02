<?php
//解决date函数时差问题
 date_default_timezone_set('prc');

 $errowinfo=NULL;
 $successinfo=NULL;
 //$signcode=$_GET['signcode'];
 $signcode = isset($_GET['signcode']) ? $_GET['signcode'] : '';
// 获取注册表单的值
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
<<<<<<< HEAD
    $errowinfo=NULL;
    $successinfo=NULL;
    $email=$_POST['email'];
    
    $pass=$_POST['password'];
    $code=$_POST['signcode'];
    if($code==null) $errowinfo= '非法请求，请输入验证码！！！';
    
    
    require 'config.php';
    $tbl_name="user"; // Table name
    
    
    //验证注册码
    // $sqlcode="SELECT * FROM gift WHERE number='".$code."' and status=1";
    $total=count($DB->query("SELECT * FROM gift WHERE number=?", array($code)));
    
    if($total==1)
    {
    
        $total==0;
        //检查是否有相同用户
        $total=count($DB->query("SELECT * FROM user WHERE email=?", array($email)));
        
        if($total==0)
        {
            //更新注册码状态
            
            $time=date('y-m-d h:i:s',time());
            $DB->query("UPDATE gift SET status =? , usetime=? WHERE number=?", array(0,$time,$code));
            
            //密码加密处理
            $pass=MD5($pass.'404notfound');
            
            //创建随机端口 并且给定6位随机密码
            $port=rand($portwidth[0],$portwidth[1]);
            $ranpass=rand(100000,999999);
            //检查端口是否被占用
            $total=1;
            while($total!=1)
            {
            
            $total=count($DB->query("SELECT * FROM user WHERE port=?",array($port)));
            $port=rand(10000,99999);
            }
            $rowmonth = $DB->row("SELECT * FROM gift WHERE number=?",array($code));
            $addtime=$rowmonth['month'];
            $endtime=date('Y-m-d', strtotime ("+$addtime month", strtotime($time)));
            //执行SQL语句 插入数据
            $beginflow=$beginflow*1024*1024;
            $DB->query("INSERT INTO user(email,pass,passwd,transfer_enable,port,type,endtime,signtime,level) VALUES(?,?,?,?,?,?,?,?,?)", array($email,$pass,$ranpass,$beginflow,$port,7,$endtime,$time,1));
            
            $successinfo='<a href="login.php">注册成功！点此跳转到登陆界面！</a>';
            $errowinfo=NULL;
            $DB->CloseConnection();
        }
        else{$errowinfo='邮箱已被注册！';}
    }
    else{$errowinfo='注册码不正确或已被使用';}
=======
 $errowinfo=NULL;
 $successinfo=NULL;
 $email=$_POST['email'];

 $pass=$_POST['password'];
 $code=$_POST['signcode'];
 if($code==null) $errowinfo= '非法请求，请输入验证码！！！';


 require 'config.php';
 $tbl_name="user"; // Table name


 //验证注册码
// $sqlcode="SELECT * FROM gift WHERE number='".$code."' and status=1";
 $total=count($DB->query("SELECT * FROM gift WHERE number=?", array($code)));

 if($total==1)
 {

		 $total==0;
		 //检查是否有相同用户
		// $sqlemail="SELECT * FROM user WHERE email='$email'";
		 $total=count($DB->query("SELECT * FROM user WHERE email=?", array($email)));

		 if($total==0)
		 {

			//更新注册码状态

    		 $time=date('y-m-d h:i:s',time());
    		 $DB->query("UPDATE gift SET status =? , usetime=? WHERE number=?", array(0,$time,$code));
    
    		 //密码加密处理
    		 $pass=MD5($pass.'404notfound');
    
    		 //创建随机端口 并且给定6位随机密码
    		 $port=rand($portwidth[0],$portwidth[1]);
    		 $ranpass=rand(100000,999999);
    		  //检查端口是否被占用
    		 $total=1;
    		 while($total!=1)
    		 {

    			 $port=rand($portwidth[0],$portwidth[1]);
    			 $total=count($DB->query("SELECT * FROM user WHERE port=?",array($port)));
    			 
    		 }
             $rowmonth = $DB->row("SELECT * FROM gift WHERE number=?",array($code));
             $addtime=$rowmonth['month'];
              $endtime=date('Y-m-d', strtotime ("+$addtime month", strtotime($time)));
    		//执行SQL语句 插入数据
              $beginflow=$beginflow*1024*1024;
    		  $DB->query("INSERT INTO user(email,pass,passwd,transfer_enable,port,type,endtime,signtime,level) VALUES(?,?,?,?,?,?,?,?,?)", array($email,$pass,$ranpass,$beginflow,$port,7,$endtime,$time,1));
    
    		  $successinfo='<a href="login.php">注册成功！点此跳转到登陆界面！</a>';
    		  $errowinfo=NULL;
              $DB->CloseConnection();
 			}
 			else{$errowinfo='邮箱已被注册！';}
 }
 else{$errowinfo='注册码不正确或已被使用';}
>>>>>>> origin/master

}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign-404 Not Found</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="style.css">
<!-- Custom styles for this template -->

<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="dist/js/formValidation.min.js"></script>
<script src="dist/fr/bootstrap.min.js"></script>
<script>
//function loginfun(){
	//$.post("email.php",$("#loginForm").serialize());
//}
</script>

</head>

<body>

    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="index.html">首页</a></li>
            <li role="presentation"><a href="about.html">关于</a></li>
            <li role="presentation"><a href="login.php">登陆</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">404 Not Found</h3>
      </div>



      <div class="row marketing">


     	<form class="form-horizontal" role="form" id="signForm" method="post">
        			<div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"><?php echo $errowinfo; ?></span>
                            <span class="label label-sucdess text-center" style="margin:o auto;font-size:12px"><?php echo $successinfo; ?></span>
                        </div>
                    </div>
         			<div class="form-group">
                        <label class="col-sm-3 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="email" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">密码</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">确认密码</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="confirmPassword" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">注册码</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="signcode"  value="<?php echo $signcode; ?>"  />
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary" name="signup" value="submit" onClick="loginfun()">注册</button>

                        </div>
                    </div>
      </form>
      <p class="text-center">需要购买注册码请发邮件至</p>
      <p class="text-center">support#404notfound.cc</p>
      <p class="text-center">(请把#替换成@)</p>

      </div>

      <footer class="footer">
        <p style="font-size:.9em">&copy; <a href="http://404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="http://someant.com" target="_blank">Someant</a></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/site.js"></script>
    <script type="text/javascript">

$(document).ready(function() {
    $('#loginForm').formValidation({
        message: 'This value is not valid',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            email: {
                validators: {
                    notEmpty: {
                        message: '邮箱不能为空！'
                    },
                    emailAddress: {
                        message: '请输入正确的邮箱地址！'
                    }
                }
            }



        }
	});

	$('#signForm').formValidation({
        message: 'This value is not valid',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            email: {
                validators: {
                    notEmpty: {
                        message: '邮箱不能为空！'
                    },
                    emailAddress: {
                        message: '请输入正确的邮箱地址！'
                    }
                }
            },
		 password: {
                validators: {
                    notEmpty: {
						message:'密码不能为空'
						},
                    stringLength: {
                        min: 6,
                        max: 28,
						message:'密码长度不小于6位'
                    },

                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
						message:'密码不能为空'
						},
                    identical: {
                        field: 'password',
                        message: '两次密码输入不一致！'
                    }
                }
            },
			 username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    remote: {
                        type: 'POST',
                        url: 'check.php',
                        message: 'The username is not available',
                        delay: 1000
                    }
                }
            },

			signcode: {
                validators: {
                    notEmpty: {
                        message: '注册码不能为空'
                    },
                   stringLength: {
                        min: 6,
                        max: 12,
						message:'注册码长度为6-12位'
                    },
              /*      remote: {
                        type: 'POST',
                        url: 'check.php',
                        message: 'The email is not available',
                        delay: 2000
                    }
                */



					}


				}


		}
    });



});
</script>

</body>
</html>
