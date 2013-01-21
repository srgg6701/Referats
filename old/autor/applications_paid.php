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
<title><?php echo($title); ?></title>
<link href="autor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="lime_div.js"></script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<script language="JavaScript" type="text/JavaScript">
var appl='applications_paid';
if ((location.href.indexOf("status=1")==-1)&&(location.href.indexOf("status=2")==-1))
  {
	if (location.href.indexOf("status=4")!=-1) appl+='4';
	if (location.href.indexOf("status=5")!=-1) appl+='5';
	if (location.href.indexOf("status=6")!=-1) appl+='6';
	colorizePoint(appl);
  }
</script>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h3 class="dLime"><?php echo($title); ?>&nbsp;&nbsp;</h3></td>
    <td><span id="question_sign" style="color:#0000FF; text-decoration:underline; cursor:hand; display:none" onClick="javascript:if (document.getElementById('autor_note').style.display=='none') document.getElementById('autor_note').style.display='block'; else document.getElementById('autor_note').style.display='none';" title="Развернуть/свернуть подсказку!">[?]</span><script language="JavaScript" type="text/JavaScript">
if (document.title=="Оплаченные заказы (нужно отправить)") document.getElementById('question_sign').style.display='block';
</script>
</td>
  </tr>
</table>

<span id="autor_note" style="display:none"><table width="100%" cellpadding="4"  cellspacing="0" bgcolor="#FFFF00">
  <tr>
    <td><strong><span class="red">Внимание!</span></strong><br> 
      В данном разделе указаны работы, которые вы должны
      были к этому моменту  отправить заказчикам. Если вы их действительно отправили, щёлкните по ссылке &quot;<b>ДА!</b>&quot;
      в строке с нужной работой в последнем столбце таблицы. </td></tr><tr><td bgColor="FFFFFF"><!-- Чтобы получить более детальную справку, щёлкните <a href="faq.php#sent_worx" target="_blank">здесь</a> (откроется в новом окне). --> 
	  </td>
  </tr>
</table><!--<input name="hide_mess" type="checkbox" value="" onClick="if (this.checked==true){if (confirm('Вы уверены в том, что прочли и осмыслили подсказку и больше в ней не нуждаетесь :) ?')) {return true;}; else return false;}">Больше не показывать это сообщение!--></span>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center"><a href="#">ID</a></td>
    <td align="center" nowrap><a href="#">Заявл.</a></td>
    <td nowrap><a href="#">Срок</a></td>
    <td nowrap><a href="#">Заказчик</a></td>
    <td nowrap><a href="#">Тип.</a></td>
    <td nowrap><a href="#">Предмет</a></td>
    <td width="50%" nowrap bgcolor="#CCFFCC"><a href="#">Тема</a></td>
    <td nowrap bgcolor="#FFFFFF" colspan="2">&nbsp;<img src="../../images/pyctos/develope.gif" width="18" height="10" hspace="0" border="0"><img src="../../images/arrows/arrow_sm_up_blue.gif" border="0"><img src="../../images/arrows/arrow_sm_down_green.gif" width="14" height="12" border="0" align="absmiddle"></td>
    <td nowrap bgcolor="#CCFFCC"><a href="#">Цена</a></td>
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
  $wnum=mysql_result($zk_r,$i,'ri_works.number');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,$i,'ri_works.name');
	if ($zstatus=='2') {
	echo('<td nowrap bgcolor="#CCFFCC"><img src="../images/arrows/work_sent_question.gif" width="19" height="16">
	<script language="JavaScript" type="text/JavaScript">
//document.getElementById("autor_note").style.display="block";
</script>
</td>');
	}  
	?>
  </tr>
  <?php 
  echo("<tr bgcolor='#FFFFFF'>
  <td align='center'>$zid</td>
  <td align='center' nowrap>".rustime($zdata)."</td>
  <td nowrap>".rustime($zdata_to)."</td>
  <td nowrap>$zuser</td>
  <td nowrap>$ztip_s</td>
  <td nowrap>$zpredm_s</td>
  <td width='100%'><a href='ed_works_ed.php?wnum=$wnum' target='_parent'>$ztema</a>");
  if($zid>$S_LAST_ZAKAZ)  {
  echo("<sup><i><font color=#FF0000 size=1>New</font><i></sup>");}
echo("</td>
  <td bgColor='yellow'><a href='mess_form.php?wnum=$wnum&znum=$zid' target='_parent' title='Отправить сообщение по этой работе'><span class='red'><b>+</b></span><img src='../images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle'></a></td>
  <td><a href='all_messages.php?zakaz=$zid' title='Просмотреть историю сообщений по этой работе'><img src='../images/pyctos/eye.gif' width='18' height='11' border='0'></a></td>
  <td align='right'>$wtax</td>"); 
  if ($zstatus=='2') {
  echo("<td align='center'><a href='applications_paid.php?fl=transmit&znum=$zid&where=$where&title=$title'>ДА!</a></td>");
  }
  if($zstatus=='5' || $zstatus=='6')  {
  echo("<td align='center'><b>".round($wtax*0.75)." руб.</b></td>");
  }
  echo("</tr>");
}
?>
</table>

</body>
</html>
<?php
}//end work
?>