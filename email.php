<?php

/*$username=$_POST['username'];
$password=$_POST['password'];

if($username==NULL) exit();

//database

$con = mysql_connect("localhost","vpn","123");


if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code
mysql_select_db("vpn", $con);

//select infomation

$sql = mysql_query("SELECT * FROM userinfo where user=’".$username."' && usepass='".$password."'");

$result = $db -> exec_SQL($sql); 
 $total=mysql_num_rows($result); 
 if($total==1)
 {
	 echo 'success';
	 }
	 else{
		 echo 'false';}
 /*if($total==0){ 
  DBClose(); 
  Go_Msg("注册用户还没有通过管理员审核或用户名及密码不符！请重新输入！","../default.html"); 
  exit; 
 }else{ 
  $Rs = $db -> fetch_array($result); 
  //附值，并登录 
  session_register("username"); 
  session_register("usertype"); 
  $_SESSION["usertype"]=$Rs['UserType']; 
  $_SESSION["username"]=$username; 
  //echo $_SESSION["username"]; 
  if ($_SESSION["usertype"]==1){ 
    Go_Msg("登陆成功！","default.php"); 

    //header('Location:http://163.com'); 
  } 
  if ($_SESSION["usertype"]==2){ 
     Go_Msg("登陆成功！","../user2/default_1.php"); 
  } 
  if ($_SESSION["usertype"]==3){ 

     Go_Msg("登陆成功！","../user3/default_2.php"); 
  } 
  // header('Location:default.php'); 
 } */

//mysql_close($con)*/

// username and password sent from form 
 $myusername=$_POST['email']; 
 $mypassword=$_POST['password']; 
 
 if($myusername==NULL) exit();

//$host="127.0.0.1"; // Host name 
//$username="vpn"; // Mysql username 
//$password="p35XYcd7M536Y8hr"; // Mysql password 
//$db_name="vpn"; // Database name 
require 'config.php';
$tbl_name="user"; // Table name 



// Connect to server and select databse.
 mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
 mysql_select_db("$db_name")or die("cannot select DB");







// To protect MySQL injection (more detail about MySQL injection)
 $myusername = stripslashes($myusername);
 $mypassword = stripslashes($mypassword);
 $myusername = mysql_real_escape_string($myusername);
 $mypassword = mysql_real_escape_string($mypassword);

 $sql="SELECT * FROM $tbl_name WHERE email='$myusername' and pass='$mypassword'";
 $result=mysql_query($sql);



// Mysql_num_row is counting table row
 $count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
echo '登陆成功';
// Register $myusername, $mypassword and redirect to file "login_success.php"
 //session_register("myusername");
 session_start();
 $_SESSION['myusername']=$myusername;
  $_SESSION['mypassword']=$mypassword;
// session_register("mypassword"); 
 header("location:userpanel.php");
 }
 else {
 echo "Wrong Username or Password";
 }

?>
