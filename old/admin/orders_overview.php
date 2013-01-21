<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
session_register('S_LIST_PAGE');
session_register('S_F_ALL');
session_register('S_F_REF');
session_register('S_F_KUR');
session_register('S_F_DIP');
$S_F_ALL='on';
$S_F_REF='on';
$S_F_KUR='on';
$S_F_DIP='on';
session_register('S_PREDMET_NUM');
if(!isset($S_PASSLOH))
{
  session_register('S_PASSLOH');
  $S_PASSLOH='';
  session_register('S_PAY_TIP');
  $S_PAY_TIP='';
}
session_register('S_ZAKAZ_NUM');
$S_ZAKAZ_NUM=0;
session_register('S_WORK_NUM');
$S_WORK_NUM=0;
session_register('S_ZK_SUMM');
$S_ZK_SUMM=0;
session_register('S_RAD_ORDER');
$S_RAD_ORDER='name';
statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($flag_res=='Y')
{
  $S_PASSLOH=''; write_conf('adm_config.php');
  session_register('S_PASSLOH');
  $S_PASSLOH='';
  session_register('S_PAY_TIP');
  $S_PAY_TIP='';
}

$us_r=mysql_query("SELECT * FROM ri_user");
$us_n=mysql_num_rows($us_r);

$wk_r=mysql_query("SELECT * FROM ri_works");
$wk_all=mysql_num_rows($wk_r);
$wk_r=mysql_query("SELECT * FROM ri_works WHERE enable='N'");
$wk_new=mysql_num_rows($wk_r);
?>
<html>
<head>
<TITLE>БД работ по предметам.</TITLE>
<link href="admin.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
</head>
<body>
  <table width="100%"  border="0">
    <tr>
      <td valign="top" nowrap><h3 style="padding:0">Поиск заказа <img src="../../images/arrows/arrow_small.gif" width="15" height="16" align="absmiddle"></h3>
        <table height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td nowrap><input name="diplom2" type="checkbox" class="checkbox" id="diplom23" value="checkbox" checked>
            Диплом&nbsp;</td>
            <td nowrap><input name="curs2" type="checkbox" class="checkbox" id="curs23" value="checkbox" checked>Курсовая&nbsp;</td>
            <td nowrap><input name="referat2" type="checkbox" class="checkbox" id="referat23" value="checkbox" checked>Реферат&nbsp;</td>
            <td nowrap><input name="other2" type="checkbox" class="checkbox" id="other23" value="checkbox" checked>Другое&nbsp;</td>
          </tr>
        </table></td>
      <td style="padding-top:5px"><strong>Автор:</strong>
	  <select name="select2" style="font-size:100%;">
        <option value="0">-Выберите автора-</option>
        </select></td>
      <td style="padding-top:5px">&nbsp;<strong>ID:</strong>
	  <input name="textfield" type="text" size="3" style="font-size:90%"></td>
      <td nowrap style="padding-top:5px"><strong>Статус ЗАКАЗА:</strong><br>
	  <select name="select">
          <option value="0">-Выберите-</option>
          <option value="1">Заявка</option>
          <option value="2">Оплаченный</option>
          <option value="3">Отосланный</option>
          <option value="4">Полученный</option>
          <option value="5">Архивный</option>
        </select></td>
      <td width="100%" valign="bottom"><strong>Тема работы:</strong> <input name="referat_subj" type="text" class="cells" id="referat_subj4" style="width:100%;">
</td>
      <td valign="bottom"><input name="Submit" type="button" onClick="sendOrder('реферат','referat_subj');" value="Найти!"></td>
    </tr>
  </table>
  <h3 style="padding:0px 0px 4px 0px;margin-top:4px">Обзор заказов:  </h3>
        <table cellpadding="2" cellspacing="1" bgcolor="#cccccc">
  			<tr bgcolor="#e4e4e4">
    		<td nowrap>Всего ЗАКАЗОВ: [<?php echo($wk_all);?>] Неделю назад: [] ( + ...)</td>
    		<td align="center"><strong>&upsih;</strong> Заявки</td>
			<td align="center"><strong>&Omega;</strong> Оплач.</td>
			<td align="center"><strong>@</strong> Отосл.</td>
			<td align="center"><strong>&#8224;</strong> Получ.</td>
			<td align="center"><strong>&Oslash;</strong> Архивн.</td>
  			</tr>
  			<!--<tr bgcolor="#F5F5F5">
    		<td align="right" nowrap>Всего по статусам<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
  			</tr>-->
        <?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY sort, predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  $psort=mysql_result($pr_r,$i,'sort');
  echo("<tr bgColor='#ffffff'><td nowrap><a href='../worx.php?pnum=$pnum'");
  if($psort==9)
  {
    $p0=strpos($ppredmet,'>');
    $ppredmet=substr($ppredmet,$p0+1,9999);
    $p0=strpos($ppredmet,'<');
    $ppredmet=substr($ppredmet,0,$p0);
  }
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE predmet=$pnum AND enable='Y'");
  $wk_n=mysql_num_rows($wk_r);
  echo(">".($i+1).". $ppredmet</a></td>
  <td align='right'>&nbsp;</td>
  <td align='right'>&nbsp;</td>
  <td align='right'>&nbsp;</td>
  <td align='right'>&nbsp;</td>
  <td align='right'>&nbsp;</td>
  </tr>");
}
?>
</table>
</body>
</html>
