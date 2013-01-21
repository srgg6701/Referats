<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if(isset($del))
{
  mysql_query("DELETE FROM ri_works WHERE number=$del");
}

if($fl=='filter')
{
  //построим фильтр
  $S_F_WL_TIP=$tip;
  $S_F_WL_PR=$predmet;
  $S_F_WL_USER=$S_NUM_USER;//$user;
  $S_F_WL_ENABLE=$see_what;
}
$where="WHERE manager=$S_NUM_USER";
if($S_F_WL_TIP!=0){$where=$where." AND tip=$S_F_WL_TIP";}
if($S_F_WL_PR!=0){$where=$where." AND predmet=$S_F_WL_PR";}
if($S_F_WL_USER!=0){$where=$where." AND manager=$S_F_WL_USER";}
if($S_F_WL_ENABLE=='not'){$where=$where." AND enable='N'";}
if($S_F_WL_ENABLE=='yes'){$where=$where." AND enable='Y'";}

$wk_r=mysql_query("SELECT number FROM ri_works $where ORDER BY name");
$wk_n=mysql_num_rows($wk_r);
if($fl=='del')
{
  for($i=0;$i<$wk_n;$i++)
  {
    $wnum=mysql_result($wk_r,$i,'number');
	//echo("wdl[$wnum]='$wdl[$wnum]'<br>");
	if($wdl[$wnum]=='on')
	{
	  mysql_query("DELETE FROM ri_works WHERE number=$wnum");
	  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
	}
  }
  $wk_r=mysql_query("SELECT number FROM ri_works $where ORDER BY name");
  $wk_n=mysql_num_rows($wk_r);
}
if(isset($command))
{
  if($command=='prev')
  {
    $S_PAGE=$S_PAGE-100;
	if($S_PAGE<0){$S_PAGE=0;}
  }
  if($command=='next')
  {
    $S_PAGE=$S_PAGE+100;
	if($S_PAGE>$wk_n){$S_PAGE=$wk_n-99;}
	if($S_PAGE<0){$S_PAGE=0;}
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Выставленные работы</title>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../../colorize_row.js"></script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('worx');
function delSelect2()
{
  document.filter.fl.value='del';
  document.filter.submit();
}
</script>
<link href="autor.css" rel="stylesheet" type="text/css">
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="filter" action="worx.php" method="post">
  <table width="100%"  cellspacing="0" cellpadding="0">
    <tr>
      <td nowrap><h3 class="dLime">Выставленные работы</h3></td>
      <td align="center" bgcolor="#F5F5F5">отображать:
        <input name="see_what" type="radio" value="all" <?php if($S_F_WL_ENABLE!='not' && $S_F_WL_ENABLE!='yes'){echo("checked");}?>>
Все
  <input name="see_what" type="radio" value="not" <?php if($S_F_WL_ENABLE=='not'){echo("checked");}?>>
Неутверждённые
<input name="see_what" type="radio" value="yes" <?php if($S_F_WL_ENABLE=='yes'){echo("checked");}?>>
Утверждённые</td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td nowrap>Тип работы:&nbsp;</td>
    <td>
<select name="tip" style="font-size:9px">
<option value="0">-Все-</option>
<?php
$tw_r=mysql_query("SELECT * FROM ri_typework ORDER BY number");
$tw_n=mysql_num_rows($tw_r);
for($i=0;$i<$tw_n;$i++)
{
  $wnum=mysql_result($tw_r,$i,'number');
  $wtip=mysql_result($tw_r,$i,'tip');
  echo("<option value='$wnum'");
  if($S_F_WL_TIP==$wnum){echo(" selected");}
  echo(">$wtip</option>\n");
}
?>
</select></td>
    <td align="center">&nbsp;Предмет:&nbsp;</td>
    <td width="100%">
      <select name="predmet" style="font-size:9px">
<option value="0">-Все-</option>
<?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<option value='$pnum'");
  if($S_F_WL_PR==$pnum){echo(" selected");}
  echo(">$ppredmet</option>\n");
}
?>
</select></td>
    <td style="padding-bottom:3px"><input type="submit" value="Отфильтровать">
      <input name="fl" type="hidden" id="fl" value="filter"></td>
  </tr>
</table>
<div align="right"></div>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center"><a href="#">ID</a></td>
    <td align="center" nowrap><a href="#">Заявл.</a></td>
    <td nowrap><a href="#">Тип.</a></td>
    <td width="100%" nowrap bgcolor="#CCFFCC"><a href="#">Тема</a></td>
    <td nowrap bgcolor="#CCFFCC"><a href="#">Предмет</a></td>
    <td nowrap bgcolor="#CCFFCC"><a href="#">Статус</a></td>
    <td nowrap bgcolor="#FFFFFF" colspan="2">&nbsp;<img src="../../images/pyctos/develope.gif" width="18" height="10" hspace="0" border="0"><img src="../../images/arrows/arrow_sm_up_blue.gif" border="0"><img src="../../images/arrows/arrow_sm_down_green.gif" width="14" height="12" border="0" align="absmiddle"></td>
    <td align="center" nowrap bgcolor="#CCFFCC"><a href="#">Цена</a></td>
    <td align="center" nowrap><img src="../../images/prioritet10.gif" width="8" height="8" border="1"></td>
  </tr>
<?php
$wk_r=mysql_query("SELECT * FROM ri_works $where ORDER BY name LIMIT $S_PAGE,100");
//echo("SELECT * FROM ri_works $where ORDER BY name LIMIT $S_PAGE,100<br>");
$wk_n=mysql_num_rows($wk_r);
for($i=0;$i<$wk_n;$i++)
{
  $wnum=mysql_result($wk_r,$i,'number');
  $wdata=mysql_result($wk_r,$i,'data');
  $wtip=mysql_result($wk_r,$i,'tip');
  $wpredmet=mysql_result($wk_r,$i,'predmet');
  $wname=mysql_result($wk_r,$i,'name');
  $wkeywords=mysql_result($wk_r,$i,'keywords');
  $wtax=mysql_result($wk_r,$i,'tax');
  $wenable=mysql_result($wk_r,$i,'enable');
  $wmanager=mysql_result($wk_r,$i,'manager');
  $tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $tw_n=mysql_num_rows($tw_r);
  if($tw_n>0){$wtip_s=mysql_result($tw_r,0,'tip');}else{$wtip_s="";}
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredmet");
  $pr_n=mysql_num_rows($pr_r);
  if($pr_n>0){$wpredmet_s=mysql_result($pr_r,0,'predmet');}else{$wpredmet_s="";}
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$wmanager");
  $wmanager_s=mysql_result($us_r,0,'login');
  if($wenable=='N'){$bgc='#FFFFCC';}else{$bgc='#FFFFFF';}
  echo("<tr bgcolor='$bgc'><td align='right'>$wnum</td><td>".rustime($wdata)."</td><td><a href='#' class='green'>$wtip_s</a></td><td><a href='ed_works_ed.php?wnum=$wnum&ret=worx.php'>$wname</a></td><td>$wpredmet_s</td><td nowrap align='center'");
    if($wenable=='N'){echo(" class='red' title='Не утверждена администратором'>не утв.");}else{echo("  title='Утверждена администратором и доступна для заказчиков'>утв.");}
  echo("</td><td bgColor='yellow'><a href='mess_form.php?wnum=$wnum' title='Отправить сообщение по этой работе'><span class='red'><b>+</b></span><img src='../images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle'></a></td><td><a href='all_messages.php?work=$wnum' title='Просмотреть историю сообщений по этой работе'><img src='../images/pyctos/eye.gif' width='18' height='11' border='0'></a></td><td align='right'>$wtax</td><td><input name='wdl[$wnum]' type='checkbox' class='checkbox' value='on'></td></tr>");
}
?>
</table>
<div class="topPad6">
  <div align="right">
    Отмеченные работы:
      <input type="button" name="Submit" value="Удалить из БД" style="color:#FF0000;font-weight:700;" onClick="delSelect2();">
  </div>
</div>
</form>
</body>
</html>
<?php
}//end  work
?>