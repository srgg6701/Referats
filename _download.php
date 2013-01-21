<? session_start();

header('Content-type: text/html; charset=windows-1251');
if (strstr($_SESSION['SITE_ROOT'],"diplom")) {

	$sroot=(strstr($_SERVER['HTTP_HOST'],"localhost"))? "localhost/diplom":"www.diplom.com.ru";
	$dir="zip";

}else{

	$sroot=(strstr($_SERVER['HTTP_HOST'],"localhost"))? "localhost/referats":"www.referats.info";
	$dir=$_REQUEST['author_id'];
}
$real_file_name=rawurlencode($_REQUEST['file_to_download']);

if (isset($_GET['test'])) {?>Переход по адресу: 

<!--<div>
	<a href="<?	/*="http://$sroot/$dir/".$_REQUEST['file_to_download']?>"><?="http://$sroot/$dir/".$_REQUEST['file_to_download']*/?></a>
</div>-->

<div>
	<a href="<?="http://$sroot/$dir/".$real_file_name?>"><?="http://$sroot/$dir/".$_REQUEST['file_to_download']?></a></div>
<? 
}else{	
	header("location: http://$sroot/$dir/".$real_file_name);
}?>