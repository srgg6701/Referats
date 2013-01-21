<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE number=$mnum");
$ms_n=mysql_num_rows($ms_r);
$mdata=rustime(mysql_result($ms_r,0,'data'));
$mzakaz=mysql_result($ms_r,0,'zakaz');
$mtimer=mysql_result($ms_r,0,'timer');

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$mzakaz");
$zk_n=mysql_num_rows($zk_r);

$mfrom=mysql_result($ms_r,0,'from_user');
$mto=mysql_result($ms_r,0,'to_user');
$memail=mysql_result($ms_r,0,'email');
$msubj=mysql_result($ms_r,0,'subj');
$mmess=rawurldecode(mysql_result($ms_r,0,'mess'));
$mstatus=mysql_result($ms_r,0,'status');
if($mstatus==0){mysql_query("UPDATE ri_mess SET status=1 WHERE number=$mnum");}
//опеределим респондента и тип(вх./исх.)
//определяем респондента
if($mfrom>1){$resp=$mfrom;}
if($mto>1){$resp=$mto;}
if($mfrom<2 && $mto<2)
{
  //респондент - заказнический
  if($zk_n>0)
  {
    $resp=mysql_result($zk_r,0,'user');
	$wnum=mysql_result($zk_r,0,'work');
	$us_r=mysql_query("SELECT * FROM ri_user, ri_works WHERE ri_user.number=ri_works.manager AND ri_works.number=$wnum");
	$us_n=mysql_num_rows($us_r);
	if($us_n>0)
	{
	  $ulogin=mysql_result($us_r,0,'login');
	  $unum=mysql_result($us_r,0,'number');
	  $uphone=mysql_result($us_r,0,'phone');
	  $umobila=mysql_result($us_r,0,'mobila');
	  $uicq=mysql_result($us_r,0,'icq');
	}
  }
  else
  {$resp="<b>&lt;Заказ Id $mzakaz удалён!&gt;</b>";}
  //$resp=$memail;
  $stat='Заказчик';
  $contrresp='Автору';
  $dlya=0;
  $mailresp=$memail;
}
else
{
  //респондент - авторский
  $stat='Автор';
  $contrresp='Заказчику';
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$resp");
  $dlya=$resp;
  $resp=mysql_result($us_r,0,'family');
  if($mstatus==-2){$resp=$resp." (удален)";}
  $mailresp=mysql_result($us_r,0,'login');
}

if($fl=='send_answer')
{
  mysql_query("UPDATE ri_mess SET status=2 WHERE number=$mnum");
  //послание
  send_intro_mess(1, $dlya, $memail, $insubj, $inmess, $mzakaz);
  header("location: messages.php");
}
if($fl=='resend')
{
  //надо выяснить чего кому перепослать
  if($mto==1 && $mzakaz!=0)//только для входящих и известен id заказа!
  {
    if($fl_ed=='not'){$inmess=$mmess;$insubj=$msubj;}
    if($mfrom==0)
	{
	  //если от заказчика, то переслать автору
	  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$mzakaz");
	  $dlya=mysql_result($zk_r,0,'ri_works.manager');
	  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$dlya");
	  $outmail=mysql_result($us_r,0,'login');
	}
	else
	{
	  //если от автора, то переслать заказчику
	  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE ri_zakaz.number=$mzakaz");
	  $dlya=0;
	  $outmail=mysql_result($zk_r,0,'email');
	}
    send_intro_mess(1,$dlya,$outmail,$insubj,$inmess,$mzakaz);
  }
  header("location: messages.php");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Просмотр сообщения</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
/*<?php echo ($inmess); ?>*/

function toHideObjects (sendButtonStat,answButtonStat)	{
document.getElementById('txtLetter').style.display='none';
//Делаем невидимым контейнер с текстом статического сообщения, отображаемого при первоначальной загрузке страницы
document.getElementById('2send').style.display=sendButtonStat; 
//Состояние кнопки "Отправить"
document.getElementById('answButton').style.display=answButtonStat;
//Состояние кнопки "Ответить"
}

function createHTML (sourceTxT)	{
document.getElementById('txtArea').style.display='block';
//document.getElementById('txtArea').innerHTML='<table width=100%><tr><td width=50%><textarea id="inmess" name="inmess" style="width:100%"; rows=14>'+sourceTxT+'<hr>'+document.getElementById('txtLetter').innerHTML+'</textarea></td><td valign=top bgcolor=#FFFFFF style=padding:6px width=50%><span id=view_message>'+document.getElementById('txtLetter').innerHTML+'</span></td></tr></table>'; 
//Переносим в контейнер для редактирования сообщения текст статического сообщения, отображаемый при первоначальной загрузке страницы
}

function answLetter ()	{
//вызывается при щелчке по кнопке "ответить"
createHTML ('Вы писали:');
toHideObjects ('block','none');
//показываем кнопку "Отправить", прячем кнопку "Ответить"
document.getElementById('insertFormat').style.display='block';
//отображаем "панель форматирования"
document.getElementById('2send').style.display='block';
//делаем видимой кнопку "Отправить респонденту"
}

function editLetter(direct) {
//вызывается при щелчке по ссылке "с редактированием"
//inbox=0, outbox=1
//<span id='txtArea'> - контейнер, в который будет переноситься текст статического сообщения при ответе, либо редактировании для пересылки письма контрреспонденту.
//<span id='txtLetter'> - контейнер, содержащий текст статического сообщения при загрузке страницы.
var corr='<?php echo ($stat);?>';
//Определяем статус респондента - Кустомер('Заказчик') или Автор.
var preAnnotation;
if (direct==0) 
{
//Если сообщение входящее
	(corr=='Заказчик')? preAnnotation='Сообщение кустомера:':preAnnotation='Сообщение автора:';
	//Если статус респондента - 'Заказчик', пишем 'Сообщение кустомера:'
	//Если статус респондента - не 'Заказчик', пишем 'Сообщение автора:'
}
else 
{
	//Если сообщение НЕ входящее (стало быть, - исходящее)
	(corr=='Заказчик')? preAnnotation='Сообщение кустомеру:':preAnnotation='Сообщение автору:';
	//Если статус респондента - 'Заказчик', пишем 'Сообщение кустомеру:'
	//Если статус респондента - не 'Заказчик', пишем 'Сообщение автору:'
	//Кнопку "Отправить" делаем видимой
}	
document.getElementById('sendButton').style.display='block';
//Делаем кнопку "Отослать" видимой

createHTML (preAnnotation);
toHideObjects ('none','none');
//прячем кнопки "Ответить", "Отправить". Вместо последней показываем кнопку "Отослать" (см. выше)
}

function seeHTML ()	{
 if (event.srcElement.tagName=='TEXTAREA') document.getElementById('view_message').innerHTML=event.srcElement.value;
}
document.onkeypress=seeHTML;
</script>
<script language="JavaScript" type="text/JavaScript" src="../../add_html.js"> </script>
</head>
<body style="margin-right:0px">
<a href="http://referats.info/admin/index.html">К Админу</a>
<form name="send_ans" action="view_mess.php">
<table width="100%" border="0" cellpadding="6" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<?php
$bgc='#FFFFFF';
$picdirect='../images/arrows/arrow_sm_down_green.gif';
if($mfrom==1) //Если сообщение исходящее
{
$bgc='#66CCFF'; //Фон шапки сообщения
$bgctopic='#00ffff'; //Фон темы сообщения
$picdirect='../images/arrows/outbox.gif'; //Картинка-символ направления сообщения (входящие/исходящие)
$messevent='отправлено'; //подстрока для указания времени отправки сообщения
} 
else 
{
$bgc='#99FFCC'; 
$bgctopic='#CCFFCC'; 
$picdirect='../images/arrows/inbox.gif';
$messevent='получено'; //подстрока для указания времени получения сообщения
}
?>
  <td colspan="2" style="padding:0px" bgColor="<?php echo ($bgc); ?>">
  <table border="0" cellpadding="4" cellspacing="0" width="100%">
<?php 
echo("<tr>
 <td nowrap><b>Дата сообщения:</b> $mdata</td>
  <td><table cellspacing='0' cellpadding='0' bgColor='#ffffff'>
  <tr>
    <td><img src=$picdirect border='1' align='absmiddle'></td>
  </tr>
</table>
</td>
 <td nowrap>$messevent в: $mtimer</td>
<!--ID СООБЩЕНИЯ
 <td align=center nowrap>&nbsp;&nbsp;<b>ID:</b> $mnum</td>-->
 <td nowrap>&nbsp;&nbsp;<b>Респондент:</b> <a href='");
 if($dlya>0){echo("personal_data.php?unum=$dlya&ret=view_mess.php?mnum=$mnum");}
 echo("' title='$mailresp'>$resp</a></td>
 <td nowrap>&nbsp;<b>Статус респондента:</b> $stat </td>
 <td nowrap>&nbsp;<a href='messages.php?linking=$mzakaz&status=-1&input=on&output=on&fl=filter&autors=on&zakazs=on' target='_blank'>Связанные сообщения (ХХХ)</a>&nbsp;</td>
 <td>
 ");
if($msubj==''){$ts="&lt;без темы&gt;";}else{$ts=$msubj;}
//if($mstatus==0){echo("<b>$ts</b>");}
//if($mstatus==1){echo("$ts <b>?</b>");}
//if($mstatus==2){echo($ts);}
echo("</td></tr>");
?>
</table>
</td>
  <tr>
  <td nowrap>Тема<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
  <td width="100%" bgcolor=<?php echo ($bgctopic); ?>><input name="insubj" type="hidden" id="insubj" value="<?php echo(str_replace("'", '`', $msubj));?>"><b><?php echo($ts);?></b></td>
<tr bgcolor="#F5F5F5">
<td colspan="2" valign="top" id="txtInside">
        <span id="txtLetter"><?php echo($mmess);?></span>
<span id="txtArea" style="display:none">
<table width=100%>
 <tr>
	<td width=50%>
	<textarea id="inmess" name="inmess" style="width:100%" rows="14"><h4 class="bottomPad6">Здравствуйте<?php //echo($resp);?>.
	</h4>
	Исходное сообщение от <?php echo($mdata." (статус респондента &#8212; $stat)");?>: <div class="bgApplication" style="padding:10px;">
	<span class="green"><?php echo($mmess);?></span>
	</div>
	

	</textarea>
	</td>
	<td valign=top bgcolor=#FFFFFF style="padding:6px" width="50%">
	<span id=view_message><?php echo($mmess);?></span>
	</td>
 </tr>
</table>
</span></td></tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr id="insertFormat" style="display:none">
    <td colspan="2" nowrap style="padding:6px">&nbsp;<strong>Вставить:</strong> <span class="link" onClick="addHTML('<P></P>');">&lt;P&gt;</span> | <span class="link" onClick="addHTML('<BR>');">&lt;BR&gt;</span> | <span class="link" onClick="addHTML('<B></B>');">&lt;B&gt;</span> | <span style="color:red; text-decoration:underline; cursor:hand" onClick="addHTML('<span style=color:red></span>');">color=&quot;red&quot;</span> | <span class="link" onClick="addHTML('<p>Страница со способами оплаты заказов находится <a href=http://www.referats.info/payment/payment_info.htm>здесь</a>.</p>');"><strong>Ссылка
          на страницу со способами оплаты</strong></span> | <span class="link" onClick="addHTML('<P>С уважением, администрация торговой площадки <a href=http://www.referats.info>Referats.info</a>.</P>');"><strong>Good
      Bye!</strong></span></td>
    </tr>
  <tr>
    <td nowrap>
	<!--  
Щелчок по кнопке "Ответить" инициирует следующие процедуры:
1.Переносит статический текст письма в контейнере <span id='txtLetter'> в текстовое поле <textarea name='inmess'> за пределы таблицы, внутрь контейнера <span id='txtArea'>, для редактирования текста при ответе респонденту либо пересылке письма контрреспонденту.
2.Прописывает в это поле следующее:
"Вы писали такого-то числа:"
[перенос строки]
"-----------------------------------------------------------------------------------------------------"
[перенос строки]
текст статического сообщения (document.getElementById('txtLetter').innerHTML)
3.Делает саму себя невидимой (this.style.display='none'), а спрятанную кнопку "Отправить!", наоборот - видимой (document.getElementById('2send').style.display='block'). Таким образом, создаёт иллюзию превращения одной кнопки в другую. При этом их предназначение изменяется.
4.Делает невидимым поле со статическим текстом письма (document.getElementById('txtLetter').style.display='none')
	 "
	
	-->
	<input name="answButton" type="button" class="topPad6" id="answButton" onClick="answLetter(this);" value="Ответить">
	<input type="submit" name="sendButton" id="sendButton" class="topPad6" value="Переслать <?php echo($contrresp);?>" style="display:none">
	<input type="submit" name="2send" id="2send" class="topPad6" value="Отправить респонденту" style="display:none">
	<?php if($mfrom==1)
{
echo ("<script language='JavaScript' type='text/JavaScript'>document.getElementById('answButton').style.display='none'; 
//alert();> 
</script>");
} 
?>
</td>
    <td align="right" nowrap>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td>Логин</td>
    <td><a href="personal_data.php?unum=<?php echo($unum);?>"><?php echo($ulogin);?></a></td>
  </tr>
  <tr>
    <td>Телефон</td>
    <td><?php echo($uphone);?></td>
  </tr>
  <tr>
    <td>Мобила</td>
    <td><?php echo($umobila);?></td>
  </tr>
  <tr>
    <td>ICQ</td>
    <td><?php echo($uicq);?></td>
  </tr>
</table>
<!--
Ссылка "с редактированием" [Переслать] инициирует процедуры, описанные в объявлении функции editLetter(direct). См. блок JavaScript в заголовке страницы.
-->
<?php
if($mzakaz>0 && $zk_n>0){
?>
	Переслать <strong><?php echo($contrresp);?></strong>:&nbsp;<span style="color:blue; text-decoration:underline; cursor:hand" onClick="javascript: document.send_ans.fl.value='resend';editLetter(<?php echo ($mfrom); ?>); document.all('insertFormat').style.display='block'">с
        редактированием</span> | <a href="view_mess.php?fl_ed=not&fl=resend&mnum=<?php echo($mnum);?>">без
        редактирования</a><?php }?>
        <input name="fl_ed" type="hidden" id="fl_ed" value="yes">
        <input name="fl" type="hidden" id="fl3" value="send_answer">
        <input name="mnum" type="hidden" id="mnum3" value="<?php echo($mnum);?>">
</td>
  </tr>
</table>
</form>
<!-- Здесь надо втюхать тексты сообщение по данной работе/заказу -->
<?php
if($mzakaz>0)
{
  //выведем тексты всех сообщений по данному заказу
  $ms_r=mysql_query("SELECT * FROM ri_mess WHERE zakaz=$mzakaz AND direct='1' ORDER BY number DESC");
  $ms_n=mysql_num_rows($ms_r);
  echo("<table width=100% border=0 cellpadding=2 cellspacing=1 bgcolor=#CCCCCC>");
  for($i=0;$i<$ms_n;$i++)
  {
    $mnum=mysql_result($ms_r,$i,'number');
    $mdata=rustime(mysql_result($ms_r,$i,'data'));
    $mtimer=mysql_result($ms_r,$i,'timer');
    $mfrom=mysql_result($ms_r,$i,'from_user');
    $mto=mysql_result($ms_r,$i,'to_user');
    $mdirect=mysql_result($ms_r,$i,'direct');
    $memail=mysql_result($ms_r,$i,'email');
    $msubj=mysql_result($ms_r,$i,'subj');
    $mmess=rawurldecode(mysql_result($ms_r,$i,'mess'));
	$bgc='#FFFFFF';
	$imgg='<img src=../images/arrows/arrow_sm_down_green.gif align=absmiddle border=1 hSpace=4>';
	if($mfrom==1)
	{
	  $bgc='#EEEEFF';
	  $imgg='<img src=../images/arrows/arrow_sm_up_blue.gif align=absmiddle border=1 hSpace=4>';
	}
	echo("<tr bgcolor=$bgc><td>$imgg</td><td><b>$msubj</b><br>$mmess</td></tr>");
  }
  echo("</table>");
}
?>

</body>
</html>
<?php
}//work end
?>