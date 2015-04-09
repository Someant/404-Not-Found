<?php
session_start();$user=@$_SESSION['aduser'];
date_default_timezone_set('prc');
error_reporting(E_ALL & ~E_NOTICE);
if($user==NULL) header("location:index.html");
//$rowad = $DB->row("SELECT * FROM ad WHERE user=?",array($user));

  require 'config.php';
  require 'functions.php';
  $giftcard='';
  //$email='';


    //处理gift
    $month=1;
    $giftcard=substr(MD5(rand(1,1000)),0,11);
    //$email=isset($_POST['email']);
    //echo $email;
    if($_POST['month']!=NULL)
    {
      $month=$_POST['month'];
    }
    $DB->query("INSERT INTO gift(number,month) VALUES(?,?)", array($giftcard,$month));
    if($_POST['email']!=NULL)
    {
        $email=$_POST['email'];
        $subject='感谢购买404NotFound服务';
        $message = '您的注册码是：'.$giftcard.'登录到404NotFound进行注册，或者复制下面的链接完成注册！如果有任何疑问可以查看主页的帮助文档，或者邮件至:support@404notFound.cc
http://404notfound.cc/sign.php?signcode='.$giftcard;
        sendmail($email,$subject,$message);
    }





  }
?>
<html lang="zh-CN">
 <head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>404 Not Found</title>
   <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" />
   <!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
   <link rel="stylesheet" href="style.css" />
   <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

 </head>
 <body>
<?php

  <div class="container">
   <div class="header">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li><a href="index.html">首页</a></li>
        <li><a href="help.html" target="_blank">使用帮助</a></li>
        <li>
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo $user; ?><span class="caret"></span>
      </a>
        <ul class="dropdown-menu" role="menu">

              <li><a href="logout.php">退出</a></li>
            </ul>

        </li>

      </ul>
    </nav>
    <h3 class="text-muted">404 Not Found</h3>
   </div>
   <div class="row marketing">

     <form class="form-inline" method="post" id="loginForm">
      <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name='email'>
      </div>
      <div class="form-group">
        <label class="sr-only" for="exampleInputPassword3">Month</label>
        <input type="text" class="form-control" id="month" placeholder="Month" name='month'>
      </div>

      <button type="submit" class="btn btn-default">生成</button>
      <span class="label label-success text-center" style="margin-left:20px;font-size:12px;"><?php echo $giftcard; ?></span>
    </form>



   </div>
   <footer class="footer">
    <p style="font-size:.9em">&copy; <a href="http://404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="http://someant.com" target="_blank">Someant</a></span></p>
   </footer>
  </div>
  <!-- /container -->
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
     addflow: {
              message: 'The username is not valid',
              validators: {
                  notEmpty: {
                      message: 'The username is required and can\'t be empty'
                  },

              }
          },

          endtime: {
              validators: {
                  notEmpty: {
                      message: '注册码不能为空'
                  },
                 stringLength: {
                      min: 1,
                      max: 2,
          message:'注册码长度只有6位'
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
