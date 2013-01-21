<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if($fl=='transmit'){zakaz_status_transmit($S_NUM_USER, $znum, 0);}

$loc_where=" ri_works.manager=$S_NUM_USER";
if(isset($where)){$loc_where=$loc_where.$where;}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Заявки</title>
<link href="autor.css" rel="stylesheet" type="text/css">
</head>

<body><? require ("../../temp_transparency_author.php");?>
<div class="bottomPad6"><b><?php echo($title);
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE  ri_zakaz.work=ri_works.number AND $loc_where");
$zk_n=mysql_num_rows($zk_r);
?>:</b></div>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center"><a href="#">ID</a></td>
    <td align="center" nowrap><a href="#">Заявл.</a></td>
    <td nowrap><a href="#">Срок</a></td>
    <td nowrap><a href="#">Заказчик</a></td>
    <td nowrap><a href="#">Тип.</a></td>
    <td nowrap><a href="#">Предмет</a></td>
    <td width="100%" nowrap><a href="#">Тема</a></td>
    <td nowrap><a href="#">Стоимость</a></td>
  </tr>
  <?php
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE  ri_zakaz.work=ri_works.number AND $loc_where");
$zk_n=mysql_num_rows($zk_r);
for($i=0;$i<$zk_n;$i++)
{
  $zid=mysql_result($zk_r,$i,'ri_zakaz.number');
  $zdata=mysql_result($zk_r,$i,'ri_zakaz.data');
  $zdata_to=mysql_result($zk_r,$i,'ri_zakaz.data_to');
  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
  $ztip=mysql_result($zk_r,$i,'ri_works.tip');
  $zstatus=mysql_result($zk_r,$i,'ri_zakaz.status');
  $wtax=mysql_result($zk_r,$i,'ri_works.tax');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,$i,'ri_works.name');
  echo("<tr bgcolor='#FFFFFF'><td align='center'><a href='#'>$zid</a></td><td align='center' nowrap><a href='#'>".rustime($zdata)."</a></td><td nowrap><a href='#'>".rustime($zdata_to)."</a></td><td nowrap><a href='#'>$zuser</a></td><td nowrap><a href='#'>$ztip_s</a></td><td nowrap><a href='#'>$zpredm_s</a></td><td width='100%'>");
  echo("<a href='#'>$ztema</a>");
   if($zid>$S_LAST_ZAKAZ){echo("<sup><i><font color=#FF0000 size=1>New</font></i></sup>");}
  echo("</td><td align='right'>");
  if($zstatus=='2')
  {
    echo("<a href='applications_paid.php?fl=transmit&znum=$zid&where=$where&title=$title'>Подтвердить отправку</a>");
  }
  if($zstatus=='5' || $zstatus=='6')
  {
    echo("<b>".round($wtax*0.75)." руб.</b>");
  }
  else{echo("&nbsp;");}
  echo("</td></tr>");
}
?>
</table>
<div class="bottomPad6"><b>Неоплаченные заявки:</b></div>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center"><a href="#">ID</a></td>
    <td align="center" nowrap><a href="#">Заявл.</a></td>
    <td nowrap><a href="#">Срок</a></td>
    <td nowrap><a href="#">Заказчик</a></td>
    <td nowrap><a href="#">Тип.</a></td>
    <td nowrap><a href="#">Предмет</a></td>
    <td width="100%" nowrap><a href="#">Тема</a></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">1025</td>
    <td align="right">12.10.04</td>
    <td><a href="#">18.12.04</a></td>
    <td><a href="../../autor/message_new.php">Петька</a></td>
    <td><a href="#" title="Переход к просмотру содержания работы">Курсовая</a></td>
    <td><a href="#">Криминалистика</a></td>
    <td><a href="content3.php" title="Разведение членистокрылых в домашних условиях">Фольклор
        в уголовном мире </a> </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
}//end work
?>