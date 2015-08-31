<?php
//header('Content-type: application/json');
require './../config.php';
require './../functions.php';
if($_POST==null)
    exit();
//valid signcode
if(post_data('signcode')!=NULL)
{
    $code=htmlspecialchars($_POST['signcode']);
    $total=count($DB->query("SELECT * FROM gift WHERE number=? and status=1", array($code)));
    if($total==1)
    {
        $result=array(
            'valid'=>'true'
        );
    }
    else
    {
        $result=array(
            'valid'=>'false'
        );
    }
    
 
}
//exit user
if(post_data('email')!=NULL)
{

    $email=htmlspecialchars($_POST['email']);
    $total=count($DB->query("SELECT * FROM user WHERE email=?", array($email)));
    if($total!=1)
    {
        $result=array(
            'valid'=>'true'
        );
    }
    else
    {
        $result=array(
            'valid'=>'false'
        );
    }
        
}

if(post_data('password'))
{
    $total==0;
    //检查是否有相同用户
    // $sqlemail="SELECT * FROM user WHERE email='$email'";
    $pass=htmlspecialchars($_POST['password']);
    $total=count($DB->query("SELECT * FROM user WHERE email=?", array($email)));
    if($total==0)
    {
    
        //更新注册码状态
        
        $time=date('y-m-d h:i:s',time());
        // $status=$DB->query("select * from gift where number = ?", array($code));
                    
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
            $port=rand($portwidth[0],$portwidth[1]);
        }
        $rowmonth = $DB->row("SELECT * FROM gift WHERE number=?",array($code));
        $addtime=$rowmonth['month'];
        $endtime=date('Y-m-d', strtotime ("+$addtime month", strtotime($time)));
        //执行SQL语句 插入数据
        $beginflow=$beginflow*1024*1024;
        $DB->query("INSERT INTO user(email,pass,passwd,transfer_enable,port,type,endtime,signtime,level) VALUES(?,?,?,?,?,?,?,?,?)", array($email,$pass,$ranpass,$beginflow,$port,7,$endtime,$time,1));
            
        $successinfo='<a href="login.php">注册成功！点此跳转到登录界面！</a>';
        $errowinfo=NULL;
        $result['message']="success";

    }
    else{$errowinfo='邮箱已被注册！';}
}

echo json_encode($result);  
$DB->CloseConnection();
?>