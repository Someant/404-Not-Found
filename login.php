<?php 
    session_start();$user=@$_SESSION['myusername'];
    if($user!=null)
    {
        header('location:userpanel.php');
    }

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login-404 Not Found</title>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="style.css">
<!-- Custom styles for this template -->

<script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
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
     	<form action="ajax/login.php" class="form-horizontal" role="form" id="loginForm" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"></span>
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
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary" name="signup" value="submit">登录</button>
							<span><a href="forgot.php"> -忘记密码-</a></span>
                        </div>
                    </div>
        </form>
      </div>

      <footer class="footer">
        <p>&copy; 404NOTFOUND 2015</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/site.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#loginForm')
            .formValidation({
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
                                },
                                remote: {
                                    type: 'POST',
                                    url: 'ajax/login.php',
                                    message: '邮箱不存在',
                                    delay: 500
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
                        }
  
                }
            }).on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the FormValidation instance
            var bv = $form.data('formValidation');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                //console.log(result);
                if(result.message=='success')
                {
                    window.location.href='userpanel.php';                    
                }
                else
                {
                    $('.label-danger').text('密码错误！');
                }
              
            }, 'json');
        });

    });
    </script>

</body>
</html>
