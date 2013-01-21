<?php
session_start();
require('../connect_db.php');
require('lib.php');
?>
<html>
<head>
<TITLE>Эккаунт пользователя</TITLE>
<link href="referats.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body style="margin-left: "><? require ("../temp_transparency.php");?>
<script>
function zparam(znum)
{
  parent.setparam(znum);
}
</script>
<?php
if($command=='change_status')
{
  zakaz_status_transmit(0, $znum, 5);
}

$znum=$pass/12345;

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
$zemail=mysql_result($zk_r,0,'email');
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.email='$zemail'");
$zk_n=mysql_num_rows($zk_r);

?>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center">ID</td>
    <td align="center" nowrap>Заявл.</td>
    <td nowrap>Срок</td>
    <td nowrap>Тип.</td>
    <td nowrap>Предмет</td>
    <td width="100%" nowrap>Тема</td>
    <td nowrap>Статус</td>
    <td>Сообщения</td>
  </tr>
  <?php
for($i=0;$i<$zk_n;$i++)
{
  $zid=mysql_result($zk_r,$i,'ri_zakaz.number');
  $zdata=mysql_result($zk_r,$i,'ri_zakaz.data');
  $zwork=mysql_result($zk_r,$i,'ri_zakaz.work');
  $zdata_to=mysql_result($zk_r,$i,'ri_zakaz.data_to');
  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
  $zstatus=mysql_result($zk_r,$i,'ri_zakaz.status');
  $ztip=mysql_result($zk_r,$i,'ri_works.tip');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,$i,'ri_works.name');
  $zs_r=mysql_query("SELECT * FROM ri_zakaz_status WHERE number=$zstatus");
  $zstatus_str=mysql_result($zs_r,0,'name');
  echo("<tr bgcolor='#FFFFFF'><td align='center'>$zid</td><td align='center' nowrap>".rustime($zdata)."</td><td nowrap>".rustime($zdata_to)."</td><td nowrap>$ztip_s</td><td nowrap>$zpredm_s</td><td width='100%'><a href='javascript: zparam($zid);'>$ztema</a></td><td align=center>");
  if($zstatus==4){echo("<a href='zlist.php?pass=$pass&command=change_status&znum=$zid'>Подтвердите получение</a>");}else{echo("$zstatus_str");}
  echo("</td><td nowrap><a href='post_history.php?znum=$zid&pass=$pass'>Просмотреть</a> <a href=''>Новое</a></td></tr>");
}
?>
</table>
</body>
</html>
