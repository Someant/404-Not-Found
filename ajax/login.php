<?php
//header('Content-type: application/json');
require './../config.php';
require './../functions.php';
if($_POST==null)
    exit();

if(post_data('email')!=null and post_data('password')==null)
{
    $email=htmlspecialchars($_POST['email']);
    $total=count($DB->query("SELECT * FROM user WHERE email=?", array($email)));
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
else
{
    $myusername=$_POST['email'];
    $mypassword=$_POST['password'];
    
    $mypassword=MD5($mypassword.'404notfound');
    
    $count=count($DB->query("SELECT * FROM user WHERE email=? and pass=?", array($myusername,$mypassword)));
    
    if($count==1){
        session_start();
        $_SESSION['myusername']=$myusername;
        $_SESSION['mypassword']=$mypassword;
        $result['message']="success";
        // session_register("mypassword");
        //header("location:userpanel.php");
    }
    else 
    {
        $result['message']="errow";
    }
    
}


echo json_encode($result);  
$DB->CloseConnection();
?>