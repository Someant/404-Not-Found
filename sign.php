<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign-404 Not Found</title>
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
            <li role="presentation"><a href="login.php">登录</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">404 Not Found</h3>
      </div>



      <div class="row marketing">


     	<form action="ajax/sign.php" class="form-horizontal" role="form" id="signForm" method="post">
        			<div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"></span>
                            <span class="label label-success text-center" style="margin:o auto;font-size:12px"></span>
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
                            <input type="text" class="form-control" name="signcode"  value="<?php echo isset($_GET['signcode'])?$_GET['signcode']:null; ?>"  />
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary" name="signup" value="submit">注册</button>

                        </div>
                    </div>
      </form>
      <p class="text-center">需要购买注册码请发邮件至</p>
      <p class="text-center">support#404notfound.cc</p>
      <p class="text-center">(请把#替换成@)</p>

      </div>

      <footer class="footer">
        <p style="font-size:.9em">&copy; <a href="//404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="//someant.com" target="_blank">Someant</a></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
    <script src="./js/site.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#signForm')
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
                                    url: 'ajax/sign.php',
                                    message: '邮箱已被注册',
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
                                remote: {
                                    type: 'POST',
                                    url: 'ajax/sign.php',
                                    message: '注册码不存在或已被使用',
                                    delay: 500
                                }                               
                    
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
                    $('.label-success').text('注册成功！3S后将跳转到登录界面');
                    setTimeout("window.location.href='login.php'",3000);

                    
                }
              
            }, 'json');
        });

    });
    </script>

</body>
</html>
