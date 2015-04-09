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


$url = "rc4-md5:{$sspass}@sfo.404notfound.cc:{$port}";
$url = "ss://" . base64_encode($url);
$qrCode = new QrCode();
$qrCode->setText($url);
$qrCode->setSize(140);
$qrCode->setPadding(5);
$sfoimg= "<img  src='{$qrCode->getDataUri()}' >";


$url = "aes-256-cfb:{$sspass}@hk.404notfound.cc:{$port}";
$url = "ss://" . base64_encode($url);
$qrCode = new QrCode();
$qrCode->setText($url);
$qrCode->setSize(140);
$qrCode->setPadding(5);
$hkimg="<img  src='{$qrCode->getDataUri()}' >";


?>

							<div role="tabpanel">

								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<?php

									//不会写函数的渣渣
									//权限控制 根据level显示不同的节点信息
									if($lv==1)
									{
										echo '<li role="presentation" class="active"><a href="#sfo" aria-controls="sfo" role="tab" data-toggle="tab">旧金山</a></li>';
										echo '<li role="presentation"><a href="#hk" aria-controls="profile" role="tab" data-toggle="tab">香港</a></li>';
									}
									elseif($lv=4)
									{
										echo '<li role="presentation"><a href="#hk" aria-controls="profile" role="tab" data-toggle="tab">香港</a></li>';
									}
									?>

								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
								<?php
									if($lv==1)
									{
										echo
										'<div role="tabpanel" class="tab-pane active" id="sfo">
	                    <p class="text-center">'
												.$sfoimg.
	                    '<P class="text-center">服务器地址:sfo.404notfound.cc</p>
	                    </p>
										</div>
										<div role="tabpanel" class="tab-pane" id="hk">
											<p class="text-center">'
												.$hkimg.
											'<P class="text-center">服务器地址:hk.404notfound.cc</p>
											</p>
										</div>';
									}
									if($lv==4)
									{
										echo
										'<div role="tabpanel" class="tab-pane active" id="hk">
											<p class="text-center">'
												.$hkimg.
											'<P class="text-center">服务器地址:hk.404notfound.cc</p>
											</p>
										</div>';
									}

							?>

								</div>

							</div>
