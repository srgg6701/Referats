<?php
if (strstr($_SERVER['HTTP_HOST'],"localhost"))
  { $server='localhost';
  	$user="root";
    $pass="";
	$_SESSION['DOC_ROOT']=$_SERVER['DOCUMENT_ROOT']."/Referats";
	$_SESSION['DOC_ROOT_DIPLOM']="D:/WebServers/home/localhost/www/diplom/";
	$_SESSION['SITE_ROOT']="http://localhost/Referats/";
  } 
else
  { $server='mysql74.1gb.ru';
  	$user="gb_x_educa6af";/*rossorig_agbook1*/
    $pass="417429ff12";/*history67*/
	$_SESSION['DOC_ROOT']="/home/rossorig/domains/referats.info/public_html";
	$_SESSION['DOC_ROOT_DIPLOM']="/home/rossorig/domains/diplom.com.ru/public_html/";
	$_SESSION['SITE_ROOT']="http://www.referats.info/";
  }
mysql_connect ($server,"$user","$pass"); 
mysql_select_db ("gb_x_educa6af") or die("ОШИБКА ПОДКЛЮЧЕНИЯ К БД<hr>".mysql_error());

###################################################
//ДАННАЯ СТРОКА НУЖНА ИСКЛЮЧИТЕЛЬНО ПРИ ГЛЮКАХ КОДИРОВКИ В phpMyAdmin:
if ($user=="root") mysql_query( 'SET NAMES cp1251');

//отправка сообщения админу об ошибке:
if (mysql_error()) mail("test@educationservice.ru","ОШИБКА соединения с сервером MySQL.","Ошибка: ".mysql_error()."<hr>user= $user, pass= $pass<br>SERVER['HTTP_HOST']= ".$_SERVER['HTTP_HOST']."<br>SERVER['REQUEST_URI']= ".$_SERVER['REQUEST_URI']."<BR>SERVER['HTTP_REFERER']= ".$_SERVER['HTTP_REFERER'],"From: sale@referats.info".chr(13).chr(10)."Reply-To: sale@referats.info".chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');

##########################################
require_once("classes/class.Worx.php");
###############		25%
//наценка на стоимость работ:
$price_ratio=Worx::setPriceRatio();
//коэффициент стоимости собственных работ:
Worx::setPriceAverage();

//статус заказа:
if (isset($_REQUEST['order_status'])) {
	$_SESSION['FILTER_ORDER_STATUS']=$_GET['order_status'];
	if (isset($_POST['order_status'])) $_SESSION['FILTER_ORDER_STATUS']=$_POST['order_status'];
	//echo "<div>FILTER_WORX_AFFILIATION= $_SESSION[FILTER_WORX_AFFILIATION]</div>";
}?>