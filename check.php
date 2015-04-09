<?php
// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:
// http://domain.com/demo/remote.html

//header('Content-type: application/json');


//sleep(5);

$valid = false;
$code='HARNUFA123';
require 'config.php';
 $sqlcode=mysql_query("SELECT * FROM gift WHERE number='".isset($_POST['username'])."' and status=1");

 //$total=mysql_num_rows($result); 


// if($total==1)
 //{
 // 		$code=$_POST['username'];
//  }


$users = array(
    $code         => 'admin@domain.com',

);


if (isset($_POST['username']) && array_key_exists($_POST['username'], $users)) {
    $valid = true;
} 
echo json_encode(array(
    'valid' => $valid,
));

?>
