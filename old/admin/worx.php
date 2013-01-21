<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

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
  $S_PAGE=0;
}
if($fl=='utv')
{
  $wk_r=mysql_query("SELECT number FROM ri_works");
  $wk_n=mysql_num_rows($wk_r);
  for($i=0;$i<$wk_n;$i++)
  {
    $wnum=mysql_result($wk_r,$i,'number');
    if($utv[$wnum]=='on')
	{
	  //утвердить
	  mysql_query("UPDATE ri_works SET enable='Y' WHERE number=$wnum");
	}
  }
}
if($fl=='del')
{
  $wk_r=mysql_query("SELECT number FROM ri_works");
  $wk_n=mysql_num_rows($wk_r);
  for($i=0;$i<$wk_n;$i++)
  {
    $wnum=mysql_result($wk_r,$i,'number');
    if($utv[$wnum]=='on')
	{
	  //удалить
	  mysql_query("DELETE FROM ri_works WHERE number=$wnum");
	}
  }
}
$where="WHERE number>0";
if($S_F_WL_TIP!=0){$where=$where." AND tip=$S_F_WL_TIP";}
if($S_F_WL_PR!=0){$where=$where." AND predmet=$S_F_WL_PR";}
if($unum>0){$where=$where." AND manager=$unum"; $S_F_WL_USER=$unum;}
if($unum==-1){$S_F_WL_USER=0;}
if($S_F_WL_USER!=0){$where=$where." AND manager=$S_F_WL_USER";}
if($only_new=='on'){$where=$where." AND enable='N'";}
if($only_new=='off'){$where=$where." AND enable='Y'";}

if(isset($order)){$order=" ORDER BY ".$order;}else
{$order=" ORDER BY ri_works.enable, ri_works.name";}

$plen=22;
$wk_r=mysql_query("SELECT number FROM ri_works $where $order");
$wk_n=mysql_num_rows($wk_r);
$kolvo=$wk_n;
if(isset($command))
{
  if($command=='prev')
  {
    $S_PAGE=$S_PAGE-$plen;
	if($S_PAGE<0){$S_PAGE=0;}
  }
  if($command=='next')
  {
    $S_PAGE=$S_PAGE+$plen;
	if($S_PAGE>$wk_n){$S_PAGE=$wk_n-$plen+1;}
	if($S_PAGE<0){$S_PAGE=0;}
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Заявки</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../../colorize_row.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../../check_all_boxes.js"></script>
</head>
<body>
<script>
function utv()
{
  document.filter.fl.value='utv';
  document.filter.submit();
}

function delSelect2()
{
  document.filter.fl.value='del';
  if (confirm("Вы уверены, что хотите удалить отмеченную работу (работы)?")) document.filter.submit();
}
</script>
<form name="filter" action="worx.php" method="post">
  <table width="100%" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="20%" valign="bottom" nowrap style="padding-bottom:6px"><b>Все работы авторов
          (<span  id="all_w"></span>) </b></td>
      <td width="20%" align="right" valign="bottom" style="padding-bottom:6px"><input name="only_new" type="checkbox" class="checkboxFilter" value="on" <?php if($only_new=='on'){echo("checked");}?>>
	  Только неутверждённые&nbsp;</td>
      <td width="39%" align="center" valign="bottom" nowrap bgcolor="#F5F5F5" style="padding-bottom:6px">&nbsp;&nbsp;Тип:
        <select name="tip">
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
?>        </select>Предмет:&nbsp;<select name="predmet">
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
</select>&nbsp;Автор: <select name="unum"><option value="-1">-- Все --</option><?php
$us_r=mysql_query("SELECT * FROM ri_user ORDER BY family");
$us_n=mysql_num_rows($us_r);
for($i=0;$i<$us_n;$i++)
{
  $unum=mysql_result($us_r,$i,'number');
  $ufamily=mysql_result($us_r,$i,'family');
  echo("<option value='$unum'");
  if($unum==$S_F_WL_USER){echo(" selected");}
  echo(">$ufamily</option>\n");
}
?></select></td>
      <td width="21%" align="right" valign="bottom"><input name="fl" type="hidden" id="fl" value="filter">        <!-- #BeginLibraryItem "/Library/bt_%CE%F2%F4%E8%EB%FC%F2%F0%EE%E2%E0%F2%FC.lbi" -->
        <input type="submit" value="Отфильтровать" class="bottomPad6" style="width:120px">
      <!-- #EndLibraryItem --></td>
    </tr>
  </table>
  <table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center" bgcolor="#CCFFCC"><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.number");?>">ID</a></td>
    <td align="center" nowrap bgcolor="#CCFFCC"><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.data");?>">Заявл.</a></td>
    <td nowrap bgcolor="#CCFFCC"><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.manager");?>">Автор</a></td>
    <td nowrap bgcolor="#CCFFCC"><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.tip");?>">Тип</a></td>
    <td nowrap bgcolor="#CCFFCC"><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.predmet");?>">Предмет</a></td>
    <td align="center" nowrap bgcolor="#CCFFCC"><a href="#">Цена</a></td>
    <td width="100%" nowrap bgcolor="#CCFFCC">
      <table width="100%" cellpadding="0"  cellspacing="0">
        <tr>
          <td><a href="<?php echo("worx.php?only_new=$only_new&only_reconfirm=$only_reconfirm&order=ri_works.name");?>">Тема</a></td>
          <td width="50%" align="right" nowrap><?php if($S_PAGE>=$plen){echo("<a href=worx.php?command=prev><img src='../images/arrows/to_left.gif' align='absmiddle' border='1'>  предыдущие</a>");}?></td>
          <td align="center" nowrap><?php if($kolvo>$plen){echo("&nbsp;&nbsp;$S_PAGE&nbsp;&nbsp;");}?></td>
          <td width="50%" nowrap><?php if($S_PAGE+$plen<$kolvo){echo("<a href=worx.php?command=next>следующие <img src='../images/arrows/to_right.gif' align='absmiddle' border='1'></a>");}?></td>
        </tr>
      </table></td>
    <td nowrap bgcolor="#CCFFCC" colspan="2">Сообщения</td>
    <td align="center" nowrap><!-- #BeginLibraryItem "/Library/check_all_boxes.lbi" -->
      <input type="checkbox" name="checkbox" value="checkbox" onClick="checkAllBoxes()">
    <!-- #EndLibraryItem --></td>
  </tr>
<?php
$wk_r=mysql_query("SELECT * FROM ri_works $where $order LIMIT $S_PAGE,$plen");
$wk_n=mysql_num_rows($wk_r);
for($i=0;$i<$wk_n;$i++)
{
  $wnum=mysql_result($wk_r,$i,'number');
  $wdata=mysql_result($wk_r,$i,'data');
  $wtip=mysql_result($wk_r,$i,'tip');
  $wpredmet=mysql_result($wk_r,$i,'predmet');
  $wname=mysql_result($wk_r,$i,'name');
  $wtax=mysql_result($wk_r,$i,'tax');
  $wenable=mysql_result($wk_r,$i,'enable');
  $wmanager=mysql_result($wk_r,$i,'manager');
  $tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $tw_n=mysql_num_rows($tw_r);
  if($tw_n>0){$wtip_s=mysql_result($tw_r,0,'tip');}
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredmet");
  $pr_n=mysql_num_rows($pr_r);
  if($pr_n>0){$wpredmet_s=mysql_result($pr_r,0,'predmet');}
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$wmanager");
  $us_n=mysql_num_rows($us_r);
  $wmanager_s='&lt;нет в базе&gt;';
  $wmanager_n='&lt;нет в базе&gt;';
  if($us_n>0)
  {
    $wmanager_s=mysql_result($us_r,0,'login');
    $wmanager_n=mysql_result($us_r,0,'family');
  }
  
  if($wenable=='N'){$bgc='#F4FFDF';$nmark='font-weight:600';$autoconfirm='и настройкам её автоутверждения';}else{$bgc='#FFFFFF';$nmark='" "';$autoconfirm='';}
  $tolocat='adm_works_ed.php?wnum='.$wnum.'&ret=worx.php';
	
	//Начало строки, ID работы:
  	?><tr bgcolor='<? echo($bgc);?>'>
  		<td align='right'><? echo($wnum);?></td>
  		<td><? /*Дата заявки:*/ echo(rustime($wdata));?></td>
		<td><? //Автор работы
	if($wmanager_s=='&lt;нет в базе&gt;') echo($wmanager_n);
	else echo("<a href='personal_data.php?unum=$wmanager&ret=worx.php'>$wmanager_n</a>");?></td>
		<td><? /*Тип работы:*/ echo($wtip_s);?></td>
		<td nowrap><? /*Предмет:*/ echo($wpredmet_s);?></td>
		<td align='right'><? /*Цена автора:*/ echo($wtax);?></td>
		<td>
	<? //Тема работы:
		if(trim($wname)==''){$wname="&lt;не указана&gt;";}
		if(strlen($wname)>60)
		{
		  echo("<a href=$tolocat style=$nmark title='Переход к параметрам работы $autoconfirm на тему $wname'>".substr($wname,0,60)."...");
		}
		else{echo("<a href=$tolocat style=$nmark title='Переход к параметрам работы $autoconfirm'>$wname");
		}
		echo("</a>");?>
		</td>
		<td nowrap align='center'><a href='new_mess.php?resp=autor&about=<? /*Отправить сообщение по работе:*/ echo($wnum);?>' title='Отправить сообщение по этой работе'><span class='red'><b>+</b></span><img src='../../images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle'></a></td>
	<!--//История сообщений по работе:-->
		<td align='center'><a href='' title='Просмотреть историю сообщений по этой работе'><img src='../../images/pyctos/eye.gif' width='18' height='11' border='0'></a></td>
		<td><input name='utv[<? /*Чекбокс:*/ echo($wnum);?>]' type='checkbox' value='on' class='checkbox'><script language='JavaScript'>arCheckboxes[<? echo($i);?>]='utv[<? echo($wnum);?>]'</script>
		</td>
		</tr><? } ?>
<script language="JavaScript" type="text/JavaScript">document.getElementById("all_w").innerHTML="<? echo($kolvo);?>"</script>
	  </table>
  <div class="topPad6" align="center">
  <table width="100%" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="50%" align="right" nowrap><?php if($S_PAGE>=$plen){echo("<a href=worx.php?command=prev><img src='../images/arrows/to_left.gif' align='absmiddle' border='1'>  предыдущие</a>");}?></td>
      <td align="center" nowrap><?php if($kolvo>$plen){echo("&nbsp;&nbsp;$S_PAGE&nbsp;&nbsp;");}?></td>
      <td width="50%" nowrap><?php if($S_PAGE+$plen<$kolvo){echo("<a href=worx.php?command=next>следующие <img src='../images/arrows/to_right.gif' align='absmiddle' border='1'></a>");}?></td>
      <td width="50%" nowrap>Отмеченные работы:
        <input type="button" name="Submit" value="Удалить из БД" style="color:#FF0000;font-weight:700;" onClick="delSelect2();">
        <input type="button" name="Submit" value="Утвердить!" onClick="javascript: utv();"></td>
    </tr>
  </table>
  </div>
  <div class="topPad6" align="right">  </div>
</form>
</body>
</html>
<?php
}//end  work
?>