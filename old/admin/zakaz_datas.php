<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

//изменить данные
if($fl=='change')
{
  mysql_query("UPDATE ri_zakaz SET user='$user', data_to='$wYear-$wMonth-$wDay', status=$status, email='$email', phone='$phone', mobila='$mobila', workphone='$workphone', dopphone='$dopphone', pay_tip='$pay_tip', summ_user='$summ_user', summ_our='$summ_our' WHERE number=$znum");
  $ret=str_replace('{and}','&',$ret);
  header("location: $ret");
}
//удалить заказ
if($fl=='delete')
{
  mysql_query("UPDATE ri_zakaz SET status=-2 WHERE number=$znum");
  $ret=str_replace('{and}','&',$ret);
  header("location: $ret");
}

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
$zk_n=mysql_num_rows($zk_r);
if($zk_n>0)
{
  $zuser=mysql_result($zk_r,0,'user');
  $zwork=mysql_result($zk_r,0,'work');
  $zdata=mysql_result($zk_r,0,'data');
  $zdata_to=mysql_result($zk_r,0,'data_to');
  $zstatus=mysql_result($zk_r,0,'status');
  $zemail=mysql_result($zk_r,0,'email');
  $zphone=mysql_result($zk_r,0,'phone');
  $zmobila=mysql_result($zk_r,0,'mobila');
  $zworkphone=mysql_result($zk_r,0,'workphone');
  $zdopphone=mysql_result($zk_r,0,'dopphone');
  $zpay_tip=mysql_result($zk_r,0,'pay_tip');
  $zsumm_user=mysql_result($zk_r,0,'summ_user');
  $zsumm_our=mysql_result($zk_r,0,'summ_our');
  $zs_r=mysql_query("SELECT * FROM ri_zakaz_status ORDER BY number");
  $zs_n=mysql_num_rows($zs_r);
}
else
{
  echo("<center>Извините! Заказа № $znum не существует!</center><br>");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Заявки</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function delSelect()
{
  document.form_update.fl.value='delete';
  document.form_update.submit();
}
</script>
</head>
<body>
<div class="bottomPad6"><!--  -->
<form name="form_update" action="zakaz_datas.php" method="post">
<div class="bottomPad6"><strong>Параметры <?php
if($zstatus==1){echo("заявки");}
if($zstatus==2){echo("заказа");}
if($zstatus==6){echo("выполненного заказа");}
?></strong></div>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#00CC00">
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Заказчик/клиент<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><?php echo($zuser);?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>E-mail заказчика/клиента <img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td width="100%"><input name="email" type="text" id="email" value="<?php echo($zemail);?>" size="40"></td>
    </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>ID работы, тип и предмет<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><?php
$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet, ri_typework WHERE ri_works.predmet=diplom_predmet.number AND ri_works.tip=ri_typework.number AND ri_works.number=$zwork");
$wk_n=mysql_num_rows($wk_r);
if($wk_n>0)
{
  $wnum=mysql_result($wk_r,0,'ri_works.number');
  $wname=mysql_result($wk_r,0,'ri_works.name');
  $wpredmet=mysql_result($wk_r,0,'diplom_predmet.predmet');
  $wtip=mysql_result($wk_r,0,'ri_typework.tip');
}
echo("ID $wnum&nbsp;$wtip по предмету '$wpredmet'");
	?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap> Тема работы<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><?php echo("<a href='adm_works_ed.php?wnum=$wnum&ret=zakaz_datas.php?znum=$znum'>$wname</a>");?></td>
  </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Дата заказа<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><?php echo(rustime($zdata));?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Дата к исполнению<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><select name="wDay"><?php
$bDay=$zdata_to[8].$zdata_to[9];
for($i=1;$i<32;$i++)
{
  echo("<option value=");
  if($i<10){echo("0");}
  echo("$i");
  if($i==$bDay){echo(" selected");}
  echo(">$i</option>\n");
}
?></select>
<select name="wMonth"><?php
$bMonth=$zdata_to[5].$zdata_to[6];
for($i=1;$i<=12;$i++)
{
  echo("<option value=");
  if($i<10){echo("0");}
  echo("$i");
  if($bMonth==$i){echo(" selected");}
  echo(">".rus_month($i)."</option>\n");
}
$bYear=$zdata_to[0].$zdata_to[1].$zdata_to[2].$zdata_to[3];
?></select>
<select name="wYear">
 <option value="2004" <?php if($bYear==2004){echo(" selected");}?>>2004</option>
 <option value="2005" <?php if($bYear==2005){echo(" selected");}?>>2005</option>
 <option value="2006" <?php if($bYear==2006){echo(" selected");}?>>2006</option>
 <option value="2007" <?php if($bYear==2007){echo(" selected");}?>>2007</option>
</select>
      </td>
  </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Статус<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><select name="status">
<?php
for($i=0;$i<$zs_n;$i++)
{
  $snum=mysql_result($zs_r,$i,'number');
  $sname=mysql_result($zs_r,$i,'name');
  echo("<option value=$snum");
  if($snum==$zstatus){echo(" selected");}
  echo(">$sname</option>\n");
}
?>
</select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="phone" type="text" id="phone" value="<?php echo($zphone);?>" size="40"></td>
  </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Мобильный телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"> </td>
    <td><input name="mobila" type="text" id="mobila" value="<?php echo($zmobila);?>" size="40"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Рабочий телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="workphone" type="text" id="workphone" value="<?php echo($zworkphone);?>" size="40"></td>
  </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Дополнительный телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"> </td>
    <td><input name="dopphone" type="text" id="dopphone" value="<?php echo($zdopphone);?>" size="40"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Тип оплаты<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><select name="pay_tip">
	  <option value="bank" <?php if($zpay_tip=='bank'){echo("selected");}?>>банковский перевод</option>
	  <option value="cards" <?php if($zpay_tip=='cards'){echo("selected");}?>>карточки предоплаты WebMoney или Яндекс.деньги</option>
	  <option value="cash" <?php if($zpay_tip=='cash'){echo("selected");}?>>перечисление наличных</option>
	  <option value="post" <?php if($zpay_tip=='post'){echo("selected");}?>>почтовый перевод</option>
	  <option value="telegraph" <?php if($zpay_tip=='telegraph'){echo("selected");}?>>телеграфный перевод</option>
	  <option value="wallet" <?php if($zpay_tip=='wallet'){echo("selected");}?>>перевод в кошелёк WebMoney или Яндекс.деньги</option>
	  <option value="webmoney" <?php if($zpay_tip=='webmoney'){echo("selected");}?>>обменный пункт WebMoney</option>
	</select></td>
  </tr>
  <tr bgcolor="#EAFFEA">
    <td align="right" nowrap>Предложенная заказчиком сумма<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="summ_user" type="text" id="summ_user" value="<?php echo($zsumm_user);?>" size="6"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Наша сумма<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="summ_our" type="text" id="summ_our" value="<?php echo($zsumm_our);?>" size="6"></td>
  </tr>
</table>
<div align="right" class="topPad6">
  <input name="ret" type="hidden" id="ret" value="<?php echo($ret);?>">
  <input name="znum" type="hidden" id="znum" value="<?php echo($znum);?>">
  <input name="fl" type="hidden" id="fl" value="change">
  <input type="submit" value="Подтвердить">
  <input type="button" name="delItem" value="Удалить из БД" style="color:#FF0000;font-weight:700;" onClick="if (confirm('Вы уверены, что хотите удалить этот ЗАКАЗ из БД?\n--------------------------------------------------------------------\nСтатус &#8212; <?php echo ($sname); ?>')) delSelect();">
</div>
</form>
</div>
<div class="bottomPad6"></div>
</body>
</html>
<?php
}//end  work
?>