<?php
session_start();
Header("Content-type: image/gif");


$capche_img=imagecreate(100,20);

$white = ImageColorAllocate($capche_img, 255,255,255);
$black = ImageColorAllocate($capche_img, 0,0,0);


$r=imagefilledrectangle($capche_img, 0, 0, 70, 20, $white); 
$smb = '0987654321abcdefghijklmnopqrstuvwxyz';
if(!isset($_SESSION['S_CAPCHE'])){session_register('S_CAPCHE');}
$_SESSION['S_CAPCHE']='';
for($i=0;$i<7;$i++){
	$_SESSION['S_CAPCHE'].=$smb[rand(0,strlen($smb)-1)];
}
$pos = array(0,1,2,3,4,5);
$x=2;
for($i=0;$i<strlen($_SESSION['S_CAPCHE']);$i++){
	$s=$_SESSION['S_CAPCHE'][$i];
	$y=$pos[rand(0,5)];
	$r=imagestring($capche_img, 5, $x, $y, $s, $black);
	$x+=9;
}
$r=imagegif($capche_img); 
?>