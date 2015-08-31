<?php
session_start();$user=@$_SESSION['aduser'];
if($user!=NULL)
{
    header("location:home.php");
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
<link rel="stylesheet" href="../style.css">
<!-- Custom styles for this template -->

<script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="../dist/js/formValidation.min.js"></script>
<script src="../dist/fr/bootstrap.min.js"></script>
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
            <li role="presentation"><a href="../index.html">首页</a></li>
            <li role="presentation"><a href="../about.html">关于</a></li>
            <li role="presentation"><a href="../sign.php">注册</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">404 Not Found</h3>
      </div>



      <div class="row marketing">
     	<form action="ajax.php" class="form-horizontal" role="form" id="loginForm" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <span class="label label-danger text-center" style="margin:o auto;font-size:12px"></span>
                        </div>
                    </div>

         			<div class="form-group">
                        <label class="col-sm-3 control-label">用户名</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="adusername" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">密码</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="adpassword" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" class="btn btn-primary" name="signup" value="submit">登陆</button>
                        </div>
                    </div>
        </form>
      </div>

      <footer class="footer">
	   <p style="font-size:.9em">&copy; <a href="//404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="//someant.com" target="_blank">Someant</a></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/site.js"></script>
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
                    adusername: {
                            validators: {
                                notEmpty: {
                                    message: '用户名不能为空！'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\.]+$/,
                                    message: '用户名不支持特殊字符！'
                                },
                                remote: {
                                    type: 'POST',
                                    url: 'ajax.php',
                                    message: '用户不存在',
                                    delay: 500
                                }
                            }
                        },
                    adpassword: {
                        validators: {
                                notEmpty: {
                                    message:'密码不能为空！'
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
                    window.location.href='home.php';                    
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