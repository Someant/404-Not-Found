<?php
//header('Content-type: application/json');
require './../config.php';
require './../functions.php';
if($_POST==null)
    exit();

if(post_data('adusername')!=null and post_data('adpassword')==null)
{

    $user=htmlspecialchars($_POST['adusername']);
    $total=count($DB->query("SELECT * FROM ad where user=?", array($user)));
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
    $myusername=$_POST['adusername'];
    $mypassword=$_POST['adpassword'];
    
    $mypassword=MD5($mypassword.'404notfound');
    
    $count=count($DB->query("SELECT * FROM ad WHERE user=? and pass=?", array($myusername,$mypassword)));
    
    if($count==1){
        session_start();
        $_SESSION['aduser']=$myusername;
        $_SESSION['adpass']=$mypassword;
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