<? $actor=$_REQUEST['actor'];?>
<a<? if($actor=="author"){?> class="bold"<? }else{?> href="?menu=agreements&amp;actor=author"<? }?>><img src="../images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Автор</a> &nbsp;| &nbsp;<a<? if($actor=="customer"){?> class="bold"<? }else{?> href="?menu=agreements&amp;actor=customer"<? }?>><img src="../images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle" />Заказчик</a>
<hr noshade>
<?
if ($actor) {
	$agr="../sections/";
	if ($actor=="author") $agr.="author_";
	include($agr."agreement.php");
}else{?>

<div class="txt110">Выберите субъекта соглашения.</div>

<? }?>