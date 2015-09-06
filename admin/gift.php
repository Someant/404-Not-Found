<?php
session_start();$user=@$_SESSION['aduser'];
date_default_timezone_set('prc');
error_reporting(E_ALL & ~E_NOTICE);
if($user==NULL) header("location:index.html");

//已知BUG 未定义404 将导致翻页超出 还继续显示
require '../config.php';
require '../functions.php';
$giftcard='';
$data=$DB->query("select * from gift");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    


    //处理giftcar
    
    $month=1;
    $giftcard=substr(MD5(rand(1,1000000000)+strtotime(date('Y-m-d H:i:s'))),0,11);
   
   
   /*
    $totalgift=count($DB->query("SELECT * FROM gift WHERE number=?", $giftcard));
    while($totalgift>0)
    {
      $giftcard=substr(MD5(rand(1,1000000000)),0,11);
      $totalgift=count($DB->query("SELECT * FROM user WHERE gift=?", $giftcard));
    }*/
    
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
//404notfound.cc/sign.php?signcode='.$giftcard;
        sendmail($email,$subject,$message);
    }





}
?>
<html lang="zh-CN">
 <head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>404 Not Found</title>
   <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" />
   <!--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
   <link rel="stylesheet" href="../style.css" />
   <!-- Custom styles for this template -->

   <script src="//cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
   <script src="//cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

 </head>
 <body>

  <div class="container">
   <div class="header">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li><a href="//<?php echo $base_url; ?>/admin/home.php">首页</a></li>
        <li class="active"><a href="//<?php echo $base_url; ?>/admin/gift.php">优惠码</a></li>
        <li><a href="//<?php echo $base_url; ?>/admin/node.php">节点</a></li>
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

       <!-- Tab panes -->
       <div class="tab-content">
         <div role="tabpanel" class="tab-pane active" id="home">
           <div class="table-responsive">

             <table class="table table-hover" id="usertable">
               <thead>
                 <tr>
                   <th>Id</th>
                   <th>Number</th>
                   <th>Usetime</th>
                   <th>Time</th>
                   <th>Status</th>
                 </tr>
               </thead>
               <tbody>

                 <?php


                    $time=date('y-m-d',time());
                    //$b=0;$e=5;

                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                      //$page=$_GET['page'];
                    $a=5;  
                    $b=($page-1)*$a;$e=$a;//每页显示5

                    $total=count($DB->query("SELECT * FROM gift"));
                    $pagemax=$total/$a;

                    if(isset($_GET['page']) and $_GET['page']*$a-$a>$total and $_GET['page']!=1)
                    {
                        echo '<tr><td>无更多数据!</td></tr>';
                    }
                    
                    foreach($DB->query("SELECT * FROM gift order by id desc limit $b,$e") as $key=>$row)
                    {
                         echo '<tr class="'.$statusclass.'">
                           <th scope="row">'.($key+1).'</th>
                           <td>'.$row['number'].'</td>
                           <td>'.$row['usetime'].'</td>
                           <td>'.$row['month'].'</td>
                           <td>'.$row['status'].'</td>
                         </tr>';
                    }

                  ?>

             </table>
           </div>
           <nav class="text-center">
            <ul class="pagination">
              <li>
                <a href="?page=1" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php
              for($i=1;$i<$pagemax+1;$i++)
              {
                $class='';
                if($i==$page)
                {
                  $class='class="active"';
                }

                echo '<li '.$class.'><a href="?page='.$i.'">'.$i.'</a></li>';
              }

              ?>
              <li>
                <a href="<?php echo $pagemax; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>

            </ul>
          </nav>
         </div>
        
     </div>

   </div>
   <footer class="footer">
    <p style="font-size:.9em">&copy; <a href="//404notfound.cc" target="_blank" >404NOTFOUND</a> 2015 <span style="float:right;font-size:.8em">by <a href="//someant.com" target="_blank">Someant</a></span></p>
   </footer>
  </div>
  <!-- /container -->
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../js/ie10-viewport-bug-workaround.js"></script>
  <script src="../js/site.js"></script>
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
