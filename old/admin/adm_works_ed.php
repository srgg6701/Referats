<?php
session_start();
require('../../connect_db.php');
require('../access.php');
if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей
if ($linkto=='esys') mysql_query("INSERT diplom_ready_works SET referats_id = $wnum");
if(mysql_error()!='') echo("error=".mysql_error()."<br>");
if($fl=='change')
{
  //изменить
  //echo(" процесс изменения<br>");
  if($enable=='on')
  {
    $enable='Y';
	//отослать оповещение автору об утверждении работы на продажу
  }
  else{$enable='N';}
  mysql_query("UPDATE ri_works SET tip=$tip, predmet=$predmet, tax='$tax', name='$name', annot='".rawurlencode($annot)."', keywords='$keywords', data='".date('Y-m-d')."', enable='$enable', pages=$pages WHERE number=$wnum");
  
  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
  //закачать файл, опеределять есть он или нет будем в каждом частном случае
  if(isset($work_file) && ($work_file!='none'))
  {
    copy($work_file,"download/$wnum.zip");
  }
  header("location: $ret");
}

if($wnum==0)
{
  $tip=0;
  $predmet=0;
  $name='';
  $annot='';
  $rem='';
  $man=0;
}
else
{
  if($fl=='not_auto')
  {
    mysql_query("DELETE FROM ri_shedule WHERE script='autoutv_work($wnum)'");
  }
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$wnum");
  $tip=mysql_result($wk_r,0,'tip');
  $predmet=mysql_result($wk_r,0,'predmet');
  $name=mysql_result($wk_r,0,'name');
  $annot=rawurldecode(mysql_result($wk_r,0,'annot'));
  $keywords=mysql_result($wk_r,0,'keywords');  
  $tax=mysql_result($wk_r,0,'tax');  
  $pages=mysql_result($wk_r,0,'pages');  
  $man=mysql_result($wk_r,0,'manager');  
  $enable=mysql_result($wk_r,0,'enable');
  
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$man");
  $man_s=mysql_result($us_r,0,'login').' ('.mysql_result($us_r,0,'family').' '.mysql_result($us_r,0,'name').' '.mysql_result($us_r,0,'otch').')';
  $unum=mysql_result($us_r,0,'number');
  $uemail=mysql_result($us_r,0,'login');
  //оповестить о факте утверждения работы
  if($enable=='Y' && $hidden_enable=='N')
  {
    inmail($uemail,'Утверждение работы', "Здравствуйте!<br><br>Ваша работа на тему '$name' утверждена администратором и выставлена на продажу.<hr>С уважением<br>Администратор", "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'UTWWK');
  }
  
  //изменение срока автоутверждения
  if(isset($timeorder))
  {
    $sh_r=mysql_query("SELECT * FROM ri_shedule WHERE script='autoutv_work($wnum)'");
    $sh_n=mysql_num_rows($sh_r);
    if($sh_n>0)
	{
	  mysql_query("UPDATE ri_shedule SET period=$timeorder, kratnost=0 WHERE script='autoutv_work($wnum)'");
	}
	else
	{
	  mysql_query("INSERT INTO ri_shedule ( data, kratnost, period, script, remark, enable ) VALUES ( '".date('Y-m-d')."', 0, $timeorder, 'autoutv_work($wnum)', 'Автоутверждение работы для выставления на продажу', 'O' )");

	}
  }
  //срок автоутверждения
  $sh_r=mysql_query("SELECT * FROM ri_shedule WHERE script='autoutv_work($wnum)'");
  $sh_n=mysql_num_rows($sh_r);
  if($sh_n>0)
  {$timeorder=mysql_result($sh_r,0,'period')-mysql_result($sh_r,0,'kratnost');}
  else{$timeorder=0;}
}
?>
<html>
<head>
<title>Административный редактор аннотации</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
//checkSending=0;
function send2Author() {
/*if (checkSending==0)	{
	(confirm ('Вы уверены, что не хотите отложить автоматическое утверждение этой работы?'))? ':document.getElementById('cBoxTbl').style.backgroundColor='yellow';
	}*/
//location.href='new_mess.php?email=<?php echo("$uemail&dlya=$man&zakaz=0&ret=worx.php");?>';
location.href='new_mess.php?resp=autor&about=<?php echo($wnum);?>';
//new_mess.php?resp=autor&about=4685
}
function submitChanges()	{
(checkSending==0)? alert('Вы не согласились ни выставить работу на продажу, ни отложить её автоматическое изменение.\n\nОтправка подтверждения в этом случае бессмысленна.'):document.forms[0].submit();
}
</script>

</head>
<body>

<form action="adm_works_ed.php" method="post" enctype="multipart/form-data">
  <div class="bottomPad6"><span class="red">Статус работы:</span> <strong><?php if($enable=='Y'){echo("утвержденная");}else{echo("неутвержденная");}?></strong></div>
  
  <table width="100%" height="85%" border="0" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC">
  <tr bgcolor="#F5F5F5">
    <td align="right"><strong>Автор</strong><img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle">      </td>
    <td width="100%" height="1%"><strong>
      <?php
	  echo('<a href="personal_data.php?unum='.$unum.'" target="_blank" title="Просмотр данных автора (открывается в новом окне)">');
	  echo($man_s."</a>");
?>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF"><font color="#000000">Тип работы<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></font></td>
    <td height="1%" bgcolor="#FFFFFF"><font color="#000000">
      <select name="tip">
        <option value="0">-Все-</option>
        <?php
$tw_r=mysql_query("SELECT * FROM ri_typework ORDER BY number");
$tw_n=mysql_num_rows($tw_r);
for($i=0;$i<$tw_n;$i++)
{
  $lwnum=mysql_result($tw_r,$i,'number');
  $lwtip=mysql_result($tw_r,$i,'tip');
  echo("<option value='$lwnum'");
  if($tip==$lwnum){echo(" selected");}
  echo(">$lwtip</option>\n");
}
?>
      </select>
    </font></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right"><font color="#000000">Предмет<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></font></td>
    <td height="1%"><font color="#000000">
      <select name="predmet">
        <option value="0">-Все-</option>
        <?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<option value='$pnum'");
  if($predmet==$pnum){echo(" selected");}
  echo(">$ppredmet</option>\n");
}
?>
      </select>
    </font></td>
  </tr>
  <tr>
    <td align="right" nowrap bgcolor="#FFFFFF">Тема<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%" bgcolor="#FFFFFF"><input name="name" type="text" id="name" size="70" value="<?php echo($name);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Содержание (план)<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"> </td>
    <td height="94%"><textarea name="annot" id="annot" style="width:100%;height:100%"><?php echo($annot);?></textarea></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF">Число страниц <img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%" bgcolor="#FFFFFF"><?php echo($pages);?>
      <input name="pages" type="hidden" id="pages" value="<?php echo($pages);?>">
</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF">Цена<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%" bgcolor="#FFFFFF"><input name="tax" type="text" id="tax" size="4" value="<?php echo($tax);?>"> руб.</td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Ключевые слова<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%"><input name="rem" type="text" id="rem" size="70" value="<?php echo($keywords);?>" style="width:100%"></td>
  </tr>
</table>
  <table  cellspacing="0" cellpadding="6">
    <tr>
      <td nowrap><input name="enable" type="checkbox" class="checkbox" value="on" <?php if($enable=='Y'){echo("checked");} ?> onClick="if (this.checked==true) document.getElementById('cBoxTbl').style.backgroundColor='';">
        <input name="hidden_enable" type="hidden" id="hidden_enable" value="<?php echo($enable);?>">
       <!-- <input name="after" id="after" type="radio" value="on" onClick="if (this.checked==true) document.getElementById('cBoxTbl').style.backgroundColor=''; checkSending=1;"> --> 
Выставить на продажу</td>
      <td nowrap id="cBoxTbl"><!--<input name="after" type="checkbox" id="after" value="checkbox">  <input name="after" id="after" type="radio" value="after" onClick="checkSending=1; if(this.checked==true) document.getElementById('auto_confirm').style.display='none';">-->

<a href="javascript: if(confirm('Вы уверены, что хотите отключить автоутверждение для данной работы?')){location.href='<?php echo("adm_works_ed.php?wnum=$wnum&fl=not_auto&man=$man&ret=$ret");?>';}">Отменить автоутверждение работы</a></td>
      <td align="right" nowrap>
<?php if($enable=='N' && $timeorder>0){?>
	  <span id="auto_confirm" class="red" style="display:block;">&nbsp;&nbsp;Работа будет утверждена автоматически через <input name="timeorder" type="text" id="timeorder" value="<?php echo($timeorder);?>" size="3">
        часов</span><?php }?></td>
    </tr>
  </table>
    <input name="Submit" type="submit" value="Подтвердить изменения...">
    <input type="button" name="Button" value="Послать сообщение автору" onClick="send2Author();">
    <input type="button" name="Submit2" value="Разослать исполнителям" onClick="if (confirm('Опубликовать заявку на вполнение работы в эккаунтах исполнителей Esys?')) location.href+='&linkto=esys';">
  
    <input type="button" name="Submit" value="Удалить из БД" style="color:#FF0000;font-weight:700;" onClick="delSelect();">
  <input name="fl" type="hidden" id="fl2" value="change">
      <input name="wnum" type="hidden" id="wnum2" value="<?php echo($wnum);?>">
      <input name="man" type="hidden" id="man2" value="<?php echo($man);?>">
      <input name="ret" type="hidden" id="ret2" value="<?php echo($ret);?>">
      <br>
</form>
</body>
</html>
<?php
//echo("<br><a href='$ret'>Возврат</a>");
}//end works
?>