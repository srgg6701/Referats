<?php
session_start();
require('../connect_db.php');
require('lib.php');

$zknum=$S_PASSLOH/12345;
$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$zknum");
$zemail=mysql_result($zk_r,0,'email');


$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum AND email='$zemail'");
//$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
$zemail=mysql_result($zk_r,0,'email');
$zuser=mysql_result($zk_r,0,'user');
$zwork=mysql_result($zk_r,0,'work');
?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<link href="referats.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../go_url.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
alt="Банк рефератов, курсовых, дипломных работ." title="Торговая площадка Referats.info" 
width="261"  height="38" 
hspace="12" vspace="0" border="0"></a><h1 
class="graphixHeader2"><a href="../index.php" 
class="nodecorate" style="background-color:">Банк рефератов, курсовые и дипломы</a><img 
alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты" title="" src="../images/referat_bank.gif" 
width="55" height="16" 
border="0" align="absmiddle"></h1>
<div style="position:absolute; top:0px; left:390" id="navMenus">
  <table width="100%" height="54" align="right" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="65%" valign="top"><table height="42" border="0" align="center" cellspacing="0">
          <tr>
            <td nowrap class="red">Разделы сайта<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="6" border="1" align="absmiddle">&nbsp;&nbsp;</td>
            <td height="38" align="center" nowrap><a href="autors.php" onMouseOver="MM_swapImage('pyctAccount','','../images/pyctos/account2_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/account2.gif" alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты" name="pyctAccount" width="40" height="40" hspace="1" border="0" id="pyctAccount" title="Мой персональный раздел [эккаунт]
			                       Вход / Регистрация"></a></td>
            <td height="38" align="center" nowrap><a href="cooperation.htm" onMouseOver="MM_swapImage('pyctCooperation','','../images/pyctos/cooperation_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/cooperation.gif" alt="Сотрудничество" name="pyctCooperation" width="40" height="40" hspace="1" border="0" id="pyctCooperation"></a></td>
            <td height="38" align="center" nowrap><a href="faq.htm" onMouseOver="MM_swapImage('pyctFaq','','../images/pyctos/faq_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/faq.gif" alt="FAQ [часто задаваемые вопросы]" name="pyctFaq" width="40" height="40" hspace="1" border="0" id="pyctFaq"></a></td>
            <td height="38" align="center" nowrap><a href="agreement.htm" onMouseOver="MM_swapImage('pyctAgreement','','../images/pyctos/agreement_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/agreement.gif" alt="Пользовательское соглашение" name="pyctAgreement" width="40" height="40" hspace="1" border="0" id="pyctAgreement"></a></td>
            <td height="38" align="center" nowrap><a href="useful.htm" onMouseOver="MM_swapImage('pyctUseful','','../images/pyctos/useful_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/useful.gif" alt="Полезное" name="pyctUseful" width="40" height="40" hspace="1" border="0" id="pyctUseful"></a></td>
            <td align="center" nowrap><a href="feedback.php" onMouseOver="MM_swapImage('pyctFeedback','','../images/pyctos/feedback_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/feedback.gif" alt="Обратная связь" name="pyctFeedback" width="40" height="40" hspace="1" border="0" id="pyctFeedback"></a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<script language="JavaScript" type="text/JavaScript">
(screen.width<=800)? document.getElementById('navMenus').style.left=380:document.getElementById('navMenus').style.left=485;
//регулируем отступ слева слоя с навигационным меню
</script><!-- #EndLibraryItem --><!-- #EndLibraryItem --><table width="99%"  cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><h2 style="padding:0px 10px 0px 10px; margin:10px 10px 10px 0px"><span class="style1"><?php echo($zuser);?></span>, это &#8212; статистика ваших сообщений.</h2></td>
    <td width="100%" align="right"><!-- #BeginLibraryItem "/Library/menu_customer.lbi" --><strong><a href="../index.php" class="arial">Заказать
    новую работу</a>&nbsp;| <a href="user_account.php" class="arial">Мой эккаунт</a> | <a href="../index.php?flag_res=Y" class="arial">Выход <img src="../images/pointer_right_contour.gif" width="13" height="13" border="0" align="absmiddle" style="background-color:ffa933"></a> </strong><!-- #EndLibraryItem --></td>
  </tr>
</table>
<div style="padding:0px 10px 10px 10px; width:100%">
  <?php
//echo("<!--<table width=100%><tr><td><a href=user_account.php?pass=$pass>Вернуться в эккаунт пользователя</a></td><td align=right><a href=ask_admin.php?pass=$pass&about=$znum target=_top>Написать</a>&gt;&gt;&gt;</td></tr></table>-->");
$zid=$S_PASSLOH/12345;

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$zid");
$zemail=mysql_result($zk_r,0,'email');
$ms_r=mysql_query("SELECT * FROM ri_mess WHERE ri_mess.zakaz=$znum AND ((ri_mess.direct=0 AND ri_mess.from_user=1) OR (ri_mess.direct=1 AND ri_mess.to_user=1))");
$ms_n=mysql_num_rows($ms_r);

$wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$zwork");
$wtema=mysql_result($wk_r,0,'name');
echo("Заказ id $znum, тема: '$wtema'");
?>
  <table cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
    <tr bgcolor="#CCFFCC">
      <td align="center"><a href="#">Сообщение</a></td>
      <td width="100%" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60%"><a href="#">Содержание</a> </td>
            <td width="40%" align="right"><a href='ask_admin.php?pass=<?php echo("$S_PASSLOH&about=$znum");?>'>Новое сообщение</a></td>
          </tr>
        </table></td>
      <td nowrap><a href="#">Статус</a></td>
    </tr>
    <?php
for($i=0;$i<$ms_n;$i++)
{
  $mnum=mysql_result($ms_r,$i,'ri_mess.number');
  $mdata=rustime(mysql_result($ms_r,$i,'ri_mess.data'));
  $mtimer=mysql_result($ms_r,$i,'ri_mess.timer');
  $msubj=mysql_result($ms_r,$i,'ri_mess.subj');
  $mfrom=mysql_result($ms_r,$i,'ri_mess.from_user');
  $mzakaz=mysql_result($ms_r,$i,'ri_mess.zakaz');
  $mmess=rawurldecode(mysql_result($ms_r,$i,'ri_mess.mess'));

  $bgc='#EEEEEE';$inout='Исходящее';
  if($mfrom==1){$bgc='#EEEEFF';$inout='Входящее';}
  echo("<tr valign='top' bgcolor=$bgc><td>Отправлено:<br>$mdata<br>$mtimer<br>$inout</td><td><b>$msubj</b><br>".nl2br($mmess)."</td><td>&nbsp;</td></tr>");
}
?>
  </table>
</div>
</body>
</html>
