<?php
session_start();$user=@$_SESSION['aduser'];
date_default_timezone_set('prc');
error_reporting(E_ALL & ~E_NOTICE);
if($user==NULL) header("location:index.html");

require '../config.php';
require '../functions.php';
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
           if(time()-strtotime($row['endtime'])>0)
           {

             $endtime=date('Y-m-d',strtotime('+'.$addtime.' day'));
             //$endtime=date('Y-m-d', strtotime ("+$addtime month", strtotime($row['endtime'])));
         
           }
           else
           {
             $endtime=date('Y-m-d', strtotime ("+$addtime day", strtotime($row['endtime'])));
             
           }
           
           if($row['switch']==0 and $addtime>0)
           {
             $DB->query("UPDATE user SET switch=? WHERE id=?", array(1,$id));
           }
        
           //修改用户信息
           $DB->query("UPDATE user SET transfer_enable =? , endtime=? WHERE id=?", array($addflow,$endtime,$id));
        }
        else
        {
           $DB->query("UPDATE user SET transfer_enable =?  WHERE id=?", array($addflow,$id));
        }
     }
}

$time=date('y-m-d',time());
//分页函数是自己乱琢磨的  撸了一个简单勉强能用的 翻页初始化存在BUG
//$b=0;$e=5;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
//$page=$_GET['page'];
$a=5;  
$b=($page-1)*$a;$e=$a;//每页显示5
$total=count($DB->query("SELECT * FROM user"));
$pagemax=$total/$a;
$userlist=$DB->query("SELECT * FROM user order by u+d desc limit $b,$e");
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
      <?php
      //为每个用户生成指定的modal
      foreach($userlist as $row)
      {
      ?>

     <div class="modal fade" id="<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel"><?php echo $row['email'];?></h4>
             </div>
             <div class="modal-body">
             <P class="text-center">流量限额：<?php echo sprintf("%.0f",$row['transfer_enable']/(1024*1024));?>MB</P>
             <P class="text-center">到期时间：<?php echo $row['endtime'];?></P>
             <P class="text-center">均支持负值</P>
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
                                  <input type="text" class="form-control" name="endtime" placeholder="天" />
                              </div>
                          </div>
                          <div class="form-group" style="display:none">
                              <label class="col-sm-3 control-label">续期</label>
                              <div class="col-sm-6">
                                  <input type="text" class="form-control" name="id" value="<?php echo $row['id'];?>" />
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
       </div>
  <?php } ?>
  <div class="container">
   <div class="header">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li class="active"><a href="//<?php echo $base_url; ?>/admin/home.php">首页</a></li>
        <li><a href="//<?php echo $base_url; ?>/admin/gift.php">优惠码</a></li>
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
                    if(isset($_GET['page']) and $_GET['page']*$a-$a>$total and $_GET['page']!=1)
                    {
                        echo '<tr><td>无更多数据!</td></tr>';
                    }
                    
                    foreach($userlist as $row)
                    {
                      //判定用户状态
                      $status='<a type="button" class="btn btn-success" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'" >冻结</a>';
                      $statusclass='success';
                      if($row['switch']==0)
                      {
                        $status='<a type="button" class="btn btn-danger" style="font-size:.8em;" data-toggle="modal" data-target="#'.$row['id'].'">激活</a>';
                        $statusclass='danger';
                      }

                      ?>


                      <tr class="<?php echo $statusclass;?>">
                      <th scope="row"><?php echo $row['id'];?></th>
                      <td><?php echo $row['email'];?></td>
                      <td><?php echo $row['port'];?></td>
                      <td><?php echo sprintf("%.2f",$row['u']/(1024*1024));?></td>
                      <td><?php echo sprintf("%.2f",$row['d']/(1024*1024));?></td>
                      <td><?php echo sprintf("%.2f",($row['u']+$row['d'])/(1024*1024));?>MB</td>
                      <td><?php echo $row['signtime'];?></td>
                      <td><?php echo $status;?></td>
                      </tr>
                    

                  <?php } ?>
                  
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
                <a href="home.php?page=<?php echo $pagemax; ?>" aria-label="Next">
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
