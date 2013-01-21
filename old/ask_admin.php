<?php
session_start();
require('../connect_db.php');
require('lib.php');

$zid=$S_PASSLOH/12345;

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$zid");
$zemail=mysql_result($zk_r,0,'email');
if($about>0)
{
  //прочитать данные
  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.number=$about AND ri_zakaz.work=ri_works.number");
  $zdata=rustime(mysql_result($zk_r,0,'ri_zakaz.data'));
  $zemail=mysql_result($zk_r,0,'ri_zakaz.email');
  $zwork=mysql_result($zk_r,0,'ri_zakaz.work');
  $zdata_to=rustime(mysql_result($zk_r,0,'ri_zakaz.data_to'));
  $zuser=mysql_result($zk_r,0,'ri_zakaz.user');
  $zstatus=mysql_result($zk_r,0,'ri_zakaz.status');
  $ztip=mysql_result($zk_r,0,'ri_works.tip');
  $zname=mysql_result($zk_r,0,'ri_works.name');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,0,'ri_works.name');
  $zs_r=mysql_query("SELECT * FROM ri_zakaz_status WHERE number=$zstatus");
  $zstatus_str=mysql_result($zs_r,0,'name');
}

if($fl=='send')
{
  //послание
  send_intro_mess(0, 1, $zemail, $subj, $message, $about);
}
?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../go_url.js">
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js">
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?>
<form name="form_mess" action="ask_admin.php" method="post"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
</script><!-- #EndLibraryItem --><!-- #EndLibraryItem --><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="99%"  cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><h2 style="padding:0px 10px 0px 10px; margin:10px 10px 10px 0px"><span class="style1">
	<?php 
	echo($zuser);
	if($about!=0) 
{
$contenthelp='Чтобы отправить сообщение произвольного характера (не связанное ни с какой конкретной работой), щёлкните <a href=ask_admin.php?about=$about&pass=$pass>здесь</a>. Так же, вы всегда можете сделать это из своего <a href=user_account.php>эккаунта</a>.';
} 
else 
{
$contenthelp='Чтобы отправить сообщение по конкретной работе, <a href=user_account.php>вернитесь в свой эккаунт</a> и щёлкните по ссылке &quot;НОВОЕ&quot; в столбце &quot;СООБЩЕНИЯ&quot; в строке с данной работой.';
}	
?></span>,
        отсюда вы можете отправить нам сообщение. <span title="Развернуть/свернуть быструю подсказку" style="color:#0000FF; text-decoration:underline; font-size: 120%; cursor:hand; font-weight:200" onClick="(document.getElementById('accHelp').innerHTML=='')? document.getElementById('accHelp').innerHTML='<table bgColor=yellow cellPadding=10 cellSpacing=0 border=0 width=98% align=center><tr><td><?php
echo ($contenthelp); ?></td></tr></table>':document.getElementById('accHelp').innerHTML='';">[?]</h2></td>
    <td width="100%" align="right"><!-- #BeginLibraryItem "/Library/menu_customer.lbi" --><strong><a href="/index.php" class="arial">Заказать
    новую работу</a>&nbsp;| <a href="/old/user_account.php" class="arial">Мой эккаунт</a> | <a href="/index.php?flag_res=Y" class="arial">Выход <img src="/images/pointer_right_contour.gif" width="13" height="13" border="0" align="absmiddle" style="background-color:ffa933"></a> </strong><!-- #EndLibraryItem --></td>
  </tr>
</table><span id="accHelp"></span>
<table width="100%" height="68%" border="0" cellpadding="10" cellspacing="0">
  <tr>
    <td nowrap style="height:1%;padding: 0px 0px 10px 10px">
      <?php
if($fl!='send')
{
?>
      <b><?php 
if($about!=0)
{
echo('<b>Сообщение по работе</b>
 </td>
 <td width="100%" style="padding-top:0px">
 <input name="subj" type="hidden" value=""><span style="color:#009900; font-weight:900; background-color:#FFFFcc; padding: 4px;" class="arial"> ID '.$about.' &quot;'.$zname."&quot; </span><input name=subj type=hidden id=subj value='Сообщение по работе Id $about, $zname'>"
);
} 
else
{
echo('<b>Произвольное сообщение</b>
	</td>
	<td width="100%" style="padding-top:0px">
	<input name="subj" type="text" value="" style="width:100%">');
}
echo($ts);
	?>
      </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="height:98%; padding-top:0px; padding-bottom:0px"><textarea name="message" style="width:100%; height:100%"><?php
	if($about>0)
	{
	  echo("Относительно заказа Id $about\nпо теме '$zname'");
	}
	?>
      </textarea>      </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="height:1%"><input type="submit" name="Submit" value="Отправить">
      <?php
}
else
{
?>      <!--<a href='user_account.php?pass=<?php echo($pass);?>' title="Вернуться в эккаунт пользователя">Сообщение отправлено</a>-->      <table width="80%" align="center" cellpadding="4"  cellspacing="1">
    <tr bgcolor="#FFFFFF">
      <td width="31%"><a href="javascript:location.href='ask_admin.php?about=0&pass=<?php echo($S_PASSLOH);?>';"><img src="../images/outbox.gif" width="83" height="68" hspace="6" vspace="2" border="1" align="left"></a>Написать
        новое сообщение произвольного характера </td>
      <td width="4%">&nbsp;</td>
      <td width="31%"><a href="../index.php"><img src="../images/hard3.jpg" width="87" height="68" hspace="6" vspace="2" border="1" align="left"></a>Заказать
        новую работу </td>
      <td width="4%">&nbsp;</td>
      <td width="31%"><a href="user_account.php?pass=<?php echo($pass);?>"><img src="../images/data_wrench.gif" width="68" height="68" hspace="6" vspace="2" border="1" align="left">Вернуться
          в свой аккаунт </a></td>
    </tr>
      </table>      
      <?php
}
?>
      <input name="fl" type="hidden" id="fl" value="send">
      <input name="pass" type="hidden" id="pass" value="<?php echo($pass);?>">
      <input name="about" type="hidden" id="about" value="<?php echo($about);?>"></td>
  </tr>
</table>
<!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
    <tr>
      <td height="24" align="center" nowrap class="topDotted" style="padding-top:2px"><a href="/index.php">Главная</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><b><a href="/old/autors.php" class="myAccount">Мой раздел </a></b></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/cooperation.htm">Сотрудничество</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/faq.htm">FAQ</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/agreement.htm">Соглашения</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/useful.htm">Полезное</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/feedback.php">Обратная связь</a> </td>
  </tr>
    <tr valign="bottom">
      <td height="20" colspan="7" align="center" nowrap background="/images/bankreferatov_bg.gif"><b style="font-weight:100">Банк
          рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ,
      рефераты</b></td>
  </tr>
</table><div style="height:4px"><img src="/images/spacer.gif"></div>
<!-- SpyLOG f:0211 -->
<script language="javascript"><!--
Md=document;Mnv=navigator;Mp=1;
Mn=(Mnv.appName.substring(0,2)=="Mi")?0:1;Mrn=Math.random();
Mt=(new Date()).getTimezoneOffset();
Mz="p="+Mp+"&rn="+Mrn+"&t="+Mt;
Md.cookie="b=b";Mc=0;if(Md.cookie)Mc=1;Mz+='&c='+Mc;
Msl="1.0";
//--></script><script language="javascript1.1"><!--
Mpl="";Msl="1.1";Mj = (Mnv.javaEnabled()?"Y":"N");Mz+='&j='+Mj;
//--></script>
<script language="javascript1.2"><!-- 
Msl="1.2";
//--></script><script language="javascript1.3"><!--
Msl="1.3";//--></script><script language="javascript"><!--
Mu="u6940.51.spylog.com";My="";
My+="<a href='http://"+Mu+"/cnt?cid=694051&f=3&p="+Mp+"&rn="+Mrn+"' target='_blank'>";
My+="<img src='http://"+Mu+"/cnt?cid=694051&"+Mz+"&sl="+Msl+"&r="+escape(Md.referrer)+"&pg="+escape(window.location.href)+"' border=0 width=88 height=31 alt='SpyLOG'>";
My+="</a>";Md.write(My);//--></script><noscript>
<a href="http://u6940.51.spylog.com/cnt?cid=694051&f=3&p=1" target="_blank">
<img src="http://u6940.51.spylog.com/cnt?cid=694051&p=1" alt='SpyLOG' border='0' width=88 height=31 >
</a></noscript>
<!-- SpyLOG --><!-- #EndLibraryItem --></form></body>
</html>
