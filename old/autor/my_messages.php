<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if($status=='-1'){$S_F_ARCHIVE='status=-1';}
if($status=='0'){$S_F_ARCHIVE='status>=0';}
if($S_F_ARCHIVE==''){$S_F_ARCHIVE='status>=0';}
if(isset($mark) && $mark!=''){$S_F_ARCHIVE='status>=0';}
//echo("status='$status'<br>S_F_ARCHIVE='$S_F_ARCHIVE'<br>");
$plen=20;
if(isset($mark) && $mark!='')
{
  if($mark=='out')
  {$where="from_user=$S_NUM_USER";}
  else
  {$where="to_user=$S_NUM_USER";}
}
else{$where="(from_user=$S_NUM_USER OR to_user=$S_NUM_USER)";}

if($zakaz+1-1>0){$where=$where." AND zakaz=$zakaz";}
if($work+1-1>0){$where=$where." AND (subj LIKE '%Id_$work%')";}
$where=$where." AND ((ri_mess.direct=0 AND ri_mess.from_user=1) OR (ri_mess.direct=1 AND ri_mess.to_user=1)) AND $S_F_ARCHIVE";

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE $where");
$ms1_n=mysql_num_rows($ms_r);
if(mysql_error()!=''){echo("err=".mysql_error()."<br>SELECT * FROM ri_mess WHERE $where<br>");}

//удаление и перемещение в архив
if($fl=='del')
{
  for($i=0;$i<$ms1_n;$i++)
  {
    $mnum=mysql_result($ms_r,$i,'number');
	if($sel[$mnum]=='on')
	{
	  mysql_query("DELETE FROM ri_mess WHERE number=$mnum");
	}
  }
  $ms_r=mysql_query("SELECT * FROM ri_mess WHERE $where");
  $ms1_n=mysql_num_rows($ms_r);
}

if($fl=='arch')
{
  for($i=0;$i<$ms1_n;$i++)
  {
    $mnum=mysql_result($ms_r,$i,'number');
	if($sel[$mnum]=='on')
	{
	  mysql_query("UPDATE ri_mess SET status=-1 WHERE number=$mnum");
	  //echo("UPDATE ri_mess SET status=-1 WHERE number=$mnum<br>");
	}
  }
  $ms_r=mysql_query("SELECT * FROM ri_mess WHERE $where");
  $ms1_n=mysql_num_rows($ms_r);
}

if(isset($command))
{
  if($command=='prev')
  {
    $S_PAGE2=$S_PAGE2-$plen;
	if($S_PAGE2<0){$S_PAGE2=0;}
  }
  if($command=='next')
  {
    $S_PAGE2=$S_PAGE2+$plen;
	if($S_PAGE2>$ms1_n){$S_PAGE1=$ms1_n-$plen+1;}
	if($S_PAGE2<0){$S_PAGE2=0;}
  }
}
$ms_r=mysql_query("SELECT * FROM ri_mess WHERE $where ORDER BY number DESC LIMIT $S_PAGE2,$plen");
$ms_n=mysql_num_rows($ms_r);
if(mysql_error()!=''){echo("err=".mysql_error()."<br>SELECT * FROM ri_mess WHERE $where ORDER BY number DESC LIMIT $S_PAGE2,$plen<br>");}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>История сообщений</title>
<link href="autor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('my_messages');
function checkTargetRow ()	{
//пометка всех строк таблицы с сообщением
evEl=event.srcElement;
tRow=event.srcElement.parentNode.parentNode;
//строка
  if (evEl.id!='check_all'&&evEl.type=='checkbox'&&evEl.className.indexOf('Filter')==-1) 
	{
	(evEl.checked==true)? curColor='yellow':curColor='';
		tRow.style.backgroundColor=curColor; 
		tRow.nextSibling.style.backgroundColor=curColor;
	}
}

arCheckboxes=new Array ();
function checkAllBoxes()	{
//пометка всех таблиц с сообщениями
var def_value;
var stroke_color;
if (event.srcElement.checked==false) {def_value=false; stroke_color='';}
else	{def_value=true; stroke_color='yellow'}
for (i=0;i<arCheckboxes.length;i++)	
	{
	document.forms[0].elements[arCheckboxes[i]].checked=def_value;
	document.forms[0].elements[arCheckboxes[i]].parentNode.parentNode.style.backgroundColor=stroke_color;
	document.forms[0].elements[arCheckboxes[i]].parentNode.parentNode.nextSibling.style.backgroundColor=stroke_color;
	}
event.srcElement.parentNode.style.backgroundColor='';	
event.srcElement.parentNode.parentNode.style.backgroundColor='';	
}
document.onclick=checkTargetRow;
</script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="sel_form" action="my_messages.php" method="post">
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><?php
if($mark=='in'){$title="Входящие";}
if($mark=='out'){$title="Исходящие";}
if($zakaz+1-1>0)
{
  $zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$zakaz");
  $zk_n=mysql_num_rows($zk_r);
  $title=$title." (по заказу)";
  if($zk_n>0){$zk_name=mysql_result($zk_r,0,'ri_works.name');$title=$title." '$zk_name'";}
}
if($work+1-1>0)
{
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$work");
  $wk_n=mysqk_num_rows($wk_r);
  $title=$title." (по работе)";
  if($wk_n>0){$wk_name=mysql_result($wk_r,0,'name');$title=$title." '$wk_name'";}
}
if($mark!='in' && $mark!='out')
{
  if($S_F_ARCHIVE=='status>=0'){$title="Все сообщения";}else{$title="Архив сообщений";}
}
echo("<h3 class='dLime'>$title</h3>");
?></td>
    <td width="100%" nowrap><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" nowrap><?php if($S_PAGE2>=$plen){echo("<a href=my_messages.php?command=prev&fl=$fl&status=$status&mark=$mark><img src='../images/arrows/to_left.gif' align='absmiddle' border='1'>  предыдущие</a>");}?></td>
        <td align="center" nowrap><?php if($ms1_n>$plen){ echo("&nbsp;&nbsp;".($S_PAGE2+1)."&nbsp;&nbsp;");}?></td>
        <td nowrap><?php if($S_PAGE2+$plen<$ms1_n){echo("<a href=my_messages.php?command=next&fl=$fl&status=$status&mark=$mark>следующие <img src='../images/arrows/to_right.gif' align='absmiddle' border='1'></a>");}?></td>
        <td width="100%" align="center" nowrap>
		<input type="checkbox" name="checkbox" 
		value="checkbox" onClick="checkAllBoxes()" id="check_all"> Отметить все сообщения для удаления или
        перемещения в архив</td>
      </tr>
    </table>
      </td>
    <td align="right" nowrap><?php if($S_F_ARCHIVE=='status>=0'){?>
      <a href="my_messages.php?status=-1">Архив сообщений</a>
      <?php }else{ ?>
      <a href="my_messages.php?status=0">Текущие сообщения</a>
      <?php }?></td>
  </tr>
</table>
    <?php
for($i=0;$i<$ms_n;$i++)
{
  $mnum=mysql_result($ms_r,$i,'number');
  $mdata=rustime(mysql_result($ms_r,$i,'data'));
  $mzakaz=mysql_result($ms_r,$i,'zakaz');
  $mfrom=mysql_result($ms_r,$i,'from_user');
  $mto=mysql_result($ms_r,$i,'to_user');
  $memail=mysql_result($ms_r,$i,'email');
  $msubj=mysql_result($ms_r,$i,'subj');
  $mmess=rawurldecode(mysql_result($ms_r,$i,'mess'));
  $mstatus=mysql_result($ms_r,$i,'status');
  $bgc='#CCFFCC';
  $picdirect='../images/arrows/inbox.gif';
  if($mstatus==1 || $mstatus==0){$bgc='#FFFFCC'; $picdirect='../images/arrows/unanswered_big.gif';}
  if($mfrom==$S_NUM_USER){$bgc='#CCFFFF'; $picdirect='../images/arrows/outbox.gif';}
  echo("<table width='100%' border='0' cellpadding='2' cellspacing='1' bgcolor='#CCCCCC'>
  <tr bgcolor=$bgc>
  <td valign=top width='100%'>$mdata &nbsp;<img src=$picdirect border='1' hspace='2' align='absmiddle'  width='31' height='26'>&nbsp;<a href='view_mess.php?mnum=$mnum&status=$mstatus'>");
  if($msubj==''){$ts="&lt;без темы&gt;";}else{$ts=$msubj;}
  if($mstatus==0 && $mfrom!=$S_NUM_USER){echo("<span style='color:red'><b>$ts</b></span>");}
  if($mstatus==1 && $mfrom!=$S_NUM_USER){echo("<span style='color:red'>$ts</span>");}  
  if($mstatus==2 || $mfrom==$S_NUM_USER){echo($ts);}
  echo("</a></td>
  <td valign=top>");
  if($mzakaz!=0){echo("<a href='my_messages.php?zakaz=$mzakaz&title=История сообщений по заказу id $mzakaz'><img src='../images/pyctos/eye.gif' border='1' hspace='2' align='absmiddle' title='Просмотреть историю сообщений по данной работе'></a>");}
  echo("&nbsp;<input name='sel[$mnum]' type='checkbox' class='checkbox' value='on'><script language='JavaScript'>arCheckboxes[$i]='sel[$mnum]'</script></td>
  </tr>
  <tr bgcolor=$bgc>
  <td colSpan='2' style='padding:4px'>".nl2br($mmess)."</td>
  </tr>
  <tr bgcolor=$bgc>
  <td colSpan='2' bgColor='#ffffff' style='padding:2x 0px 4px 2px;' >Конец сообщения</td>
  </tr>
  </table><img src='../images/spacer.gif' height=4 width=2>");
}
?>

<div align="right" class="topPad6">
  <input name="fl" type="hidden" id="fl" value="del">
  Отмеченые сообщения:<!-- #BeginLibraryItem "/Library/bt_%D3%E4%E0%EB%E8%F2%FC%20%E8%E7%20%C1%C4!.lbi" -->
<input name="Submit" type="submit" style="color:#FF0000; font-weight:600; width:140px" value="Удалить из БД!">
<!-- #EndLibraryItem -->
<?php if($S_F_ARCHIVE=='status>=0'){?>
<input type="button" name="Button" value="Переместить в архив" onClick="document.sel_form.fl.value='arch'; document.sel_form.submit();"><?php }?>
</div>
</form>
</body>
</html>
<?php
}//end work
?>