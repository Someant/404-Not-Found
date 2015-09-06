<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license, |
// | that is bundled with this package in the file LICENSE, and is |
// | available through the world-wide-web at the following url: |
// | http://www.php.net/license/3_0.txt. |
// | If you did not receive a copy of the PHP license and are unable to |
// | obtain it through the world-wide-web, please send a note to |
// | license@php.net so we can mail you a copy immediately. |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com> |
// | Your Name <you@example.com> |
// +----------------------------------------------------------------------+
//
// $Id:$
namespace Endroid\Tests\QrCode;
include('QrCode/Endroid/QrCode/QrCode.php');
use Endroid\QrCode\QrCode;

$msg = 0;
$msgtype = 0;
$node=$DB->query("select * from node where status=1");

//显示二维码
function qr_node($sspass,$port)
{
	$url = "rc4-md5:{$sspass}@jp01.playss.me:{$port}";
	$url = "ss://" . base64_encode($url);
	$qrCode = new QrCode();
	$qrCode->setText($url);
	$qrCode->setSize(140);
	$qrCode->setPadding(5);
	$img= $qrCode->getDataUri();
	return $img;
}
?>
			<div role="tabpanel">

              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <?php foreach($node as $key=>$val){ ?>
                <li role="presentation" <?php if($key==0) echo 'class="active"' ;?>><a href="#<?php echo explode('.',$val['url'])[0]; ?>" aria-controls="<?php echo explode('.',$val['url'])[0]; ?>" role="tab" data-toggle="tab"><?php echo $val['name']; ?></a></li>
                <?php } ?>

              </ul>
            
              <!-- Tab panes -->
              <div class="tab-content">
                <?php foreach($node as $key=>$val){ ?>
                <div role="tabpanel" class="tab-pane <?php if($key==0) echo 'active'; ?>" id="<?php echo explode('.',$val['url'])[0]; ?>">
                   <p class="text-center"><img src="<?php echo qr_node($val['url'],$sspass,$port); ?>"></br>服务器地址:<?php echo $val['url']; ?></p>
                </div>
                <?php } ?>
              </div>
            
      </div>

