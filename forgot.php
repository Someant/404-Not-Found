<?php


$myusername=NULL;
$errowinfo=NULL;
$row='<form class="form-horizontal" role="form" id="loginForm" method="post">
           <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"><?php echo $errowinfo; ?></span>
                        </div>
                    </div>
									<p class="text-center">请输入您注册时的邮箱</p>
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
      </form>';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$myusername=$_POST['email'];
	require 'config.php';

 //$count=mysql_num_rows($DB);
	$count=count($DB->query("SELECT * FROM user WHERE email=?", array($myusername)));



	if($count==1){
		$row='<form class="form-horizontal" role="form" id="loginForm" method="post">
		           <div class="form-group">
		                        <label class="col-sm-3 control-label"></label>
		                        <div class="col-sm-6">
		                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"><?php echo $errowinfo; ?></span>
		                        </div>
		                    </div>
											<p class="text-center">重设密码邮件已发送，请查收！<!--如果没有收到可以点击 <button type="submit" class="btn btn-primary" name="signup" value="submit">重发</button>--></p>


		      </form>';
    $rowvalue = $DB->row("SELECT * FROM user WHERE email=?", array($myusername));
    $pass=$rowvalue['pass'];



		$reseturl=$token=MD5($myusername.$pass);
    //$httpurl==$_SERVER[HTTP_HOST];
    $url='http://404notfound.cc/reset.php?email='.$myusername.'&token='.$token;
    $time=date('y-m-d h:i:s',time());
    $DB->query("UPDATE user SET last_rest_pass_time =?  WHERE email=?", array($time,$myusername));

    $DB->CloseConnection();

		//mail函数预留
    $to = $myusername;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
    $subject = '404NotFound-密码找回';
    $message = '请点击下面的链接进行密码重置，24小时内有效！'.$url;
    $from = "www@someant.com";
    $headers = "From: $from";
    mail($to,$subject,$message,$headers);
 }
else {
	$errowinfo="请输入正确的邮箱地址！";$DB->CloseConnection();
	$row='<form class="form-horizontal" role="form" id="loginForm" method="post">
						<div class="form-group">
													<label class="col-sm-3 control-label"></label>
													<div class="col-sm-6">
															<span class="label label-danger text-center" style="margin:o auto;font-size:12px">该邮箱没有被注册！</span>
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
				</form>';;

		}
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot-404 Not Found</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="style.css">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
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
            <li role="presentation"><a href="login.php">登陆</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">404 Not Found</h3>
      </div>



      <div class="row marketing">
					<?php echo $row; ?>
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
