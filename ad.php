<?php
session_start();$user=@$_SESSION['aduser'];
date_default_timezone_set('prc');
error_reporting(E_ALL & ~E_NOTICE);
if($user==NULL) header("location:index.html");

//已知BUG 未定义404 将导致翻页超出 还继续显示
require 'config.php';
require 'functions.php';
$giftcard='';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //修正添加流量bug
    $addflow=0;
    if(isset($_POST['id'])==1)
    {
      $id=$_POST['id'];
      $addtime=$_POST['endtime'];
      $addflow=$_POST['addflow'];
      //获取用户现有信息
      $row = $DB->row("SELECT * FROM user WHERE id=?",array($id));
      $time=date('y-m-d',time());

      $addflow=$row['transfer_enable']+($addflow*1024*1024);

         if($addtime!=NULL)
         {
           //判断用户时间状态
           if($time-$row['endtime']>0)
           {

             $endtime=date('Y-m-d',strtotime('+'.$addtime.' month'));
           }
           else
           {
             $endtime=date('Y-m-d', strtotime ("+$addtime month", strtotime($row['endtime'])));
           }

           //修改用户信息
           $DB->query("UPDATE user SET transfer_enable =? , endtime=? WHERE id=?", array($addflow,$endtime,$id));
        }
        else
        {
           $DB->query("UPDATE user SET transfer_enable =?  WHERE id=?", array($addflow,$id));
        }
     }



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
   <!-- Custom styles for this template -->

   <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
   <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

 </head>
 <body>
<?php
//为每个用户生成指定的modal
   foreach($DB->query("SELECT * FROM user order by u+d desc") as $row)
   {


     echo '<div class="modal fade" id="'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">'.$row['email'].'</h4>
             </div>
             <div class="modal-body">
             <P class="text-center">流量限额：'.sprintf("%.0f",$row['transfer_enable']/(1024*1024)).'MB</P>
             <P class="text-center">到期时间：'.$row['endtime'].'</P>
             <form class="form-horizontal" role="form" id="signForm" method="post">

                     <div class="form-group">
                              <label class="col-sm-3 control-label">增加流量</label>
                              <div class="col-sm-6">
                                  <input type="text" class="form-control" name="addflow" placeholder="MB"/>
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-3 control-label">续期</label>
                              <div class="col-sm-6">
                                  <input type="text" class="form-control" name="endtime" placeholder="月" />
                              </div>
                          </div>
                          <div class="form-group" style="display:none">
                              <label class="col-sm-3 control-label">续期</label>
                              <div class="col-sm-6">
                                  <input type="text" class="form-control" name="id" value="'.$row['id'].'" />
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-sm-9 col-sm-offset-3">
                                  <button type="submit" class="btn btn-primary" name="signup" value="submit" onClick="loginfun()">保存</button>

                              </div>
                          </div>


            </form>

             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

             </div>
           </div>
         </div>
       </div>';
 }
?>
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

     <div role="tabpanel">

       <!-- Nav tabs -->
       <ul class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">UserList</a></li>
         <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Gift</a></li>


       </ul>

       <!-- Tab panes -->
       <div class="tab-content">
         <div role="tabpanel" class="tab-pane active" id="home">
           <div class="table-responsive">

             <table class="table table-hover" id="usertable">
               <thead>
                 <tr>
                   <th>Id</th>
                   <th>Email</th>
                   <th>Port</th>
                   <th>Upload</th>
                   <th>Download</th>
                   <th>TotalFlow</th>
                   <th>SignTime</th>
                   <th>Status</th>
                 </tr>
               </thead>
               <tbody>

                 <?php

                    $time=date('y-m-d',time());
                    //分页函数是自己乱琢磨的  撸了一个简单勉强能用的 翻页初始化存在BUG
                    //$b=0;$e=5;

                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                      //$page=$_GET['page'];
                    $b=($page-1)*5;$e=5;//每页显示5

                    $total=count($DB->query("SELECT * FROM user"));
                    $pagemax=$total/5;

                    foreach($DB->query("SELECT * FROM user order by u+d desc limit $b,$e") as $row)
                    {
                      //判定用户状态
                      $status='<a type="button" class="btn btn-success" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'" >冻结</a>';
                      $statusclass='success';
                      if($row['u']+$row['d']>$row['transfer_enable'] or strtotime($time)-strtotime($row['endtime'])>0 or $row['switch']==0)
                      {
                        $status='<a type="button" class="btn btn-danger" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'">激活</a>';
                        $statusclass='danger';
                      }




                         echo '<tr class="'.$statusclass.'">
                           <th scope="row">'.$row['id'].'</th>
                           <td>'.$row['email'].'</td>
                           <td>'.$row['port'].'</td>
                           <td>'.sprintf("%.2f",$row['u']/(1024*1024)).'</td>
                           <td>'.sprintf("%.2f",$row['d']/(1024*1024)).'</td>
                           <td>'.sprintf("%.2f",($row['u']+$row['d'])/(1024*1024)).'MB</td>
                           <td>'.$row['signtime'].'</td>
                           <td>'.$status.'</td>
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
         <div role="tabpanel" class="tab-pane" id="profile">

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
                    foreach($DB->query("SELECT * FROM gift where status=1") as $rowgift)
                    {
                      //判定用户状态
                    //  $status='<a type="button" class="btn btn-success" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'" >冻结</a>';
                      $statusclass='success';
                      if($rowgift['status']==0)
                      {
                        $status='<a type="button" class="btn btn-danger" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'">激活</a>';
                        $statusclass='danger';
                      }

                      if(strtotime($rowgift['usetime'])==0)
                      {
                        $usetime='未使用';
                      }
                      else
                      {
                        $usetime=$rowgift['usetime'];
                      }


                         echo '<tr class="'.$statusclass.'">
                           <th scope="row">'.$rowgift['Id'].'</th>
                           <td>'.$rowgift['number'].'</td>
                           <td>'.$usetime.'</td>
                           <td>'.$rowgift['month'].'</td>
                           <td>'.$rowgift['status'].'</td>
                         </tr>';
                    }
                    $DB->CloseConnection();
                  ?>

             </table>

           </div>
         </div>


       </div>

     </div>

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
