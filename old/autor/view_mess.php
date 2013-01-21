<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

echo($_NUM_USER);
if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE number=$mnum");
$ms_n=mysql_num_rows($ms_r);
$mdata=rustime(mysql_result($ms_r,0,'data'));
$mzakaz=mysql_result($ms_r,0,'zakaz');
$mfrom=mysql_result($ms_r,0,'from_user');
$mto=mysql_result($ms_r,0,'to_user');
$memail=mysql_result($ms_r,0,'email');
$msubj=mysql_result($ms_r,0,'subj');
$mmess=rawurldecode(mysql_result($ms_r,0,'mess'));
$mstatus=mysql_result($ms_r,0,'status');
if($mstatus==0){mysql_query("UPDATE ri_mess SET status=1 WHERE number=$mnum");}
//опеределим респондента и тип(вх./исх.)
//определяем респондента
if($mfrom!=$S_NUM_USER){$resp=$mfrom;}
if($mto!=$S_NUM_USER){$resp=$mto;}
//респондент

if($fl=='send_answer')
{
  mysql_query("UPDATE ri_mess SET status=2 WHERE number=$mnum AND to_user=$S_NUM_USER");
  //послание
  send_intro_mess($S_NUM_USER, 1, 'admin@referats.info', $insubj, $inmess, $mzakaz);
  header("location: http://www.referats.info/autor/my_messages.php?status=$status");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Просмотр сообщения</title>
<link href="autor.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
function sendAnswer (selfButton) {
document.getElementById('txtArea').style.display='block';
//Делает видимым поле для ввода текста

document.getElementById('2send').style.display='block';
//Делает видимой кнопку "Отправить"

selfButton.style.display='none';
//Делает невидимой кнопку "Ответить"

document.getElementById('txtLetter').style.display='none';
//Делает невидимым статический текст входящего сообщения
}

delMessVar=0;
function delMess()	{
if (delMessVar==1)//Определяет, был ли щелчок по кнопке "Удалить сообщение".	
	{if (confirm("Вы уверены, что хотите удалить это сообщение НАВСЕГДА?")) return true;
	else {delMessVar=0;return false;}}
else return true;		
}	
</script>

</head>
<body style="margin-right:0px"><? require ("../../temp_transparency_author.php");?>
<form name="send_ans" action="view_mess.php" method="post" onSubmit="return delMess();">
<table width="100%" border="0" cellpadding="6" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<?php
$bgc='#FFFFFF';
$picdirect='../images/arrows/arrow_sm_down_green.gif';
if($mfrom!=1) //Если сообщение исходящее
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
  <table border="0" cellpadding="4" cellspacing="0">
<?php 
echo("<tr>
 <td nowrap><b>Дата сообщения:</b> $mdata</td>
  <td><table cellspacing='0' cellpadding='0' bgColor='#ffffff'>
  <tr>
    <td><img src=$picdirect border='1' align='absmiddle'></td>
  </tr>
</table>
</td>
 <td nowrap>$messevent в: __:__</td>
 <!--<td align=center nowrap>&nbsp;&nbsp;<b>ID:</b> $mnum</td>-->
 <td nowrap>&nbsp;<a href='' target='_blank' title='Просмотреть все связанные сообщения'><img src='../images/pyctos/eye.gif' border='1'></a> (колич.)</td>
 <td>
 ");
if($msubj==''){$ts="&lt;без темы&gt;";}else{$ts=$msubj;}
echo("</td></tr>");
?>
</table>
</td>
  <tr>
  <td nowrap>Тема<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
  <td width="100%" bgcolor=<?php echo ($bgctopic); ?>><input name="insubj" type="hidden" id="insubj" value="<?php echo($msubj);?>"><b><?php echo($ts);?></b></td>
<tr bgcolor="#F5F5F5">
  <td colspan="2" valign="top" id="txtInside"><input name="inmess" type="hidden" value=""><pre><span id="txtLetter"><?php echo($mmess);?></span></pre></td>
</tr>
</table>
<span id="txtArea" style="display:none">
<textarea name="inmess" style="width:100%"; rows=14>


Вы писали такого-то числа:
--------------------------------------------------------------------------------------------------
<?php echo($mmess);?>
</textarea>
</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
4.Делает невидимым поле со статическим текстом письма (document.getElementById('txtLetter').style.display='none')-->
	
	<!--document.getElementById('txtArea').innerHTML='<textarea name=\'inmess\' style=\'width:100%\'; rows=14>Вы писали такого-то числа:\n--------------------------------------------------------------------------------------------------\n'-->
	<input name="answButton" type="button" class="topPad6" onClick="sendAnswer(this);" value="Ответить">        
    <span id="2send" style="display:none">
    <input name="submit" type="submit" class="topPad6" value="Отправить">
    </span>    <?php if($mfrom!=1)
{
echo ("<script language='JavaScript' type='text/JavaScript'>document.getElementById('answButton').style.display='none'; 
//alert();> 
</script>");
} 
?>
</td>
    <td align="right" nowrap><input name="Submit" type="submit" class="topPad6" style="color:#FF0000;font-weight:700;" onClick="delMessVar=1;" value="Удалить сообщение">
<input type="submit" name="Submit" value="Переместить в архив">
      <input name="status" type="hidden" id="status" value="<?php echo($status);?>">
        <input name="fl" type="hidden" id="fl3" value="send_answer">
<input name="mnum" type="hidden" id="mnum3" value="<?php echo($mnum);?>">
</td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//work end
?>