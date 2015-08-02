<?php
date_default_timezone_set('prc');
$successinfo=NULL;
$myusername=$_GET['email'];
$token=$_GET['token'];
if($myusername==NULL || $token==NULL)
{
	$errowinfo='非法请求';
	exit;
}
else
{
	$errowinfo='请输入您要更改的密码';
}
require 'config.php';
$row=$DB->row("SELECT * FROM user WHERE email=?", array($myusername));
$lasttime=$row['last_rest_pass_time'];
$time=date('y-m-d h:i:s',time());
$mt=MD5($row['email'].$row['pass']);
if($mt==$token)
{

	$errowinfo='请输入您要更改的密码';
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$pass=$_POST['password'];
		$conpass=$_POST['confirmPassword'];
		if($pass==$conpass and (strtotime($time)-strtotime($lasttime))/3600<24)
		{
			$DB->query("UPDATE user SET pass =?  WHERE email=?", array(MD5($pass.'404notfound'),$myusername));
			$DB->CloseConnection();
			$errowinfo=NULL;
			$successinfo='<a href="login.php">重置成功！点此跳转到登陆界面！</a>';
		}

	}
}
else
{
	$errowinfo='失效链接或者链接错误！';

}


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ResetPassword-404 Not Found</title>
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
            <li role="presentation"><a href="sign.php">注册</a></li>
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
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary" name="signup" value="submit">重置</button>

                        </div>
                    </div>
      </form>
      </div>

      <footer class="footer">
        <p>&copy; 404NOTFOUND 2015</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/site.js"></script>
    <script type="text/javascript">

$(document).ready(function() {
	// Generate a simple captcha
function randomNumber(min, max) {
return Math.floor(Math.random() * (max - min + 1) + min);
};
$('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
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
            },
						captcha: {
										validators: {
										callback: {
										message: 'Wrong answer',
										callback: function(value, validator, $field) {
										var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
										return value == sum;
										}
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
															max: 18,
															message:'密码长度在6-18位'
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
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    },
                    remote: {
                        type: 'POST',
                        url: 'remote.php',
                        message: 'The email is not available',
                        delay: 2000
                    }




					}


				}


		}
    });



});
</script>

</body>
</html>
