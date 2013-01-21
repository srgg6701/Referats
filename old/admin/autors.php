<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

if($fl=='del_or_black')
{
  $at_r=mysql_query("SELECT * FROM ri_user");
  $at_n=mysql_num_rows($at_r);
  for($i=0;$i<$at_n;$i++)
  {
    $unum=mysql_result($at_r,$i,'number');
	if($del[$unum]=='on')
	{
	  mysql_query("DELETE FROM ri_user WHERE number=$unum");
	  //echo("DELETE FROM ri_user WHERE number=$unum<br>");
	}
  }
  header("location: autors.php");
}

$at_r=mysql_query("SELECT * FROM ri_user ORDER BY ri_user.Family");
$at_n=mysql_num_rows($at_r);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Авторы</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">

boxes=new Array ();
//массив ников авторов

function checkTargetRow ()	{
var del='yellow';
//Цвет строки чекбокса для удаления авторов
var black='#ff6600';
//Цвет строки чекбокса для занесения авторов в чёрный список
var ese=event.srcElement;
//Элемент, который вызывает событие
if (ese.type=='checkbox') 
//Если тип элемента, вызвавшего событие - чекбокс
	{
	var yellowNumb=ese.parentNode.id.substring(2,ese.parentNode.id.length);
	//Индекс жёлтого чекбокса
	var yellowIDENT='del['+yellowNumb+']';
	//Идентификатор жёлтого чекбокса
		if (ese.checked==true)	
		{//Если отмечаем чекбокс...
			if (ese.name.indexOf('del[')==-1) 
			//...если щёлкаем по чёрному списку....
			{
			ese.parentNode.parentNode.style.backgroundColor=black;
			//Делаем строку красной
			document.all[yellowIDENT].checked=true;
			//отмечаем "жёлтый" чекбокс
			document.all[yellowIDENT].disabled=true;
			//делаем disabled для "жёлтого" чекбокса
			}	
			else 
			{//Если не по чёрному списку...
					if (ese.parentNode.parentNode.style.backgroundColor!=black)
					//Если строка, содержащая этот чекбокс не красная...
						ese.parentNode.parentNode.style.backgroundColor=del;
						//...делаем строку жёлтой...
			}
		}
	
		else 
		//Если разотмечаем его (чекбокс)
		{
			if (ese.name.indexOf('del[')==-1) 
			//Если щёлкаем по чёрному списку
				{
				document.all[yellowIDENT].disabled=false;
				//делаем enabled для "жёлтого" чекбокса
				document.all[yellowIDENT].parentNode.parentNode.style.backgroundColor=del;
				//делаем строку жёлтой
				}
			else  ese.parentNode.parentNode.style.backgroundColor='';
			//делаем строку бесцветной
		}
	}
}
function showContacts (hTel,wTel,mTel)	{
var nContainer=event.srcElement.nextSibling;
(nContainer.innerHTML=='')? nContainer.innerHTML='<table width=100% cellPadding=2 cellSpacing=0><tr bgColor="#f5f5f5"><td nowrap>Дом. тел: <b>'+hTel+'</b></td></tr><tr><td nowrap>Раб. тел: <b>'+wTel+'</b></td></tr><tr bgColor="#f5f5f5"><td nowrap>Моб. тел: <b>'+mTel+'</b></td></tr></table>':nContainer.innerHTML='';
}
document.onclick=checkTargetRow;
</script>
<style type="text/css">
<!--
.author_contacts {background-image:url(../../images/pyctos/eye_big.gif); width:22px; height:15px; cursor:default;}
-->
</style>
</head>
<body><form action="autors.php" method="post" name="del_autor" onSubmit="if (confirm('Вы уверены, что хотите занести этого автора в Чёрный Список и/или удалить его из БД?')) return true; else return false;">
 <table width="100%"  cellspacing="0" cellpadding="0">
    <tr>
      <td> <div class="bottomPad6"><b>Авторы</b> (всего - <?php echo($at_n);?>)</div></td>
      <td align="right">        <input name="fl" type="hidden" id="fl" value="del_or_black">
        <!-- #BeginLibraryItem "/Library/bt_OK%20small.lbi" -->
      <input type="submit" name="Submit" value="     OK     " style="font-size:75%">
      <!-- #EndLibraryItem --></td>
    </tr>
  </table>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td nowrap><table width="100%" cellpadding="0" cellspacing="0" >
      <tr>
        <td nowrap><a href="#">Nickname</a></td>
        <td align="right"><span class="bottomPad6"><img src="../../images/pyctos/phone.gif" width="16" height="13" hspace="2"><img src="../../images/pyctos/phone2.gif" width="16" height="15" hspace="2"><img src="../../images/pyctos/cellular.gif" width="7" height="16" hspace="2"></span></td>
      </tr>
    </table>      </td>
    <td width="1%" nowrap><a href="#">Дата. рег. </a></td>
    <td nowrap><a href="#">Email</a></td>
    <td nowrap>icq</td>
    <td align="center" nowrap><a href="#" title="Статус исполнителя на Diplom.com.ru">Исп-ль.</a></td>
    <td nowrap>Декл</td>
    <td nowrap><a href="#" title="Выставлено на продажу">Выст.</a></td>
    <td nowrap><a href="#" title="Отправленные работы">Отпр.</a></td>
    <td nowrap><a href="#" title="Оплаченные работы">Расчёт</a></td>
    <td nowrap><a href="#" title="Баланс расчётов">Баланс</a></td>
    <td align="center" nowrap><a href="#" title="претензии заказчиков">Пр.</a></td>
    <td align="center" nowrap><a href="#" title="Рейтинг">Рейт.</a></td>
    <td align="center" nowrap class="red">Del</td>
    <td align="center" nowrap bgcolor="#000000"><b class="red">ЧС</b></td>
  </tr>
<?php
for($i=0;$i<$at_n;$i++)
{
  $uemail=mysql_result($at_r,$i,'ri_user.login');
  $unum=mysql_result($at_r,$i,'ri_user.number');
  $uicq=mysql_result($at_r,$i,'ri_user.icq');
  $ufamily=mysql_result($at_r,$i,'ri_user.family');
  $uname=mysql_result($at_r,$i,'ri_user.name');
  $uotch=mysql_result($at_r,$i,'ri_user.otch');
  $ucity=mysql_result($at_r,$i,'ri_user.city');
  $udata=rustime(mysql_result($at_r,$i,'ri_user.data'));
  $uphone=mysql_result($at_r,$i,'ri_user.phone');
  $uhowmach=mysql_result($at_r,$i,'ri_user.howmach');
  $umobila=mysql_result($at_r,$i,'ri_user.mobila');
  
  //опеределяем сколько работ выставлено
  //сколько отправленое, сколько оплачено
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE manager=$unum");
  $wk_n=mysql_num_rows($wk_r);
  $zk_r0=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.status=5");
  $zk_n0=mysql_num_rows($zk_r0);
  $zk_r1=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.status=6");
  $zk_n1=mysql_num_rows($zk_r1);
  
  echo("<tr bgcolor='#FFFFFF'>
  <td><table width=100% cellSpacing=0 cellPadding=0><tr><td><a href='personal_data.php?unum=$unum&ret=autors.php' 
title='Город проживания: $ucity
Дата регистрации: $udata
Имя-отчество'>");
  if(trim($ufamily.$uname.$uotch)==''){echo("Не указано");}else{echo($ufamily.' '.$uname.' '.$uotch);}
  echo("</a></td>
  		    <td align='right' nowrap><span class='author_contacts' onClick='showContacts(");
  echo('"'.$uphone.'"," ","'.$umobila.'")');
  echo("'  title='Дом. тел: $uphone
Раб. тел: 
Моб. тел: $umobila'>&nbsp;</span><span></span><script>boxes[$i]='$ufamily".$i."';</script></td></tr></table>
	</td>
    <td>$udata</td>
	<td nowrap><a href='new_mess.php?resp=autor&about=0&dlya=$unum&email=$uemail&zakaz=0&ret=autors.php' title='Щёлкните для отправки сообщения по емэйлу'>$uemail</a></td>
    <td nowrap><a href='http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=$uicq&action=message#' title='Щёлкните для отправки сообщения по ICQ'>$uicq</a></td>
    <td align='center' nowrap><a href='#'>Да</a></td>
    <td nowrap>$uhowmach</td>
    <td align='right' nowrap><a href='worx.php?unum=$unum'>$wk_n</a></td>
    <td align='right' nowrap><a href='#'>$zk_n0</a></td>
    <td align='right' nowrap><a href='#'>$zk_n1</a></td>
    <td align='right' nowrap><a href='money.php?author=$unum&zakaz=0&fl=filter&bYear=2004&bMonth=01&bDay=01&wYear=2006&wMonth=01&wDay=01'>?</a></td>
    <td align='center' nowrap><a href='#'>&nbsp;</a></td>
    <td align='center' nowrap><a href='#'>&nbsp;</a></td>
    <td align='center' id=td$unum><input name='del[$unum]' type='checkbox' class='checkbox' value='on'></td>
    <td align='center' id=tt$unum><input name='$ufamily".$i."Black' type='checkbox' class='checkbox'></td>
	</tr>
");
}
?>
</table>
<table width="100%" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="right"><input class="topPad6" type="submit" name="Submit" value="     OK     " style="font-size:75%"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}
?>