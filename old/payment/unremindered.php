<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
$znum=$pass/12345;
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.number=$znum AND ri_works.number=ri_zakaz.work");
$zname=mysql_result($zk_r,0,'ri_works.name');
$zuser=mysql_result($zk_r,0,'ri_zakaz.user');

if(trim($motive)!='')
{
  //Послать сообщение админу
   send_intro_mess(0, 1, $email, "Заказ Id $znum. Заказчик отписывается от напоминмния", $motive, $znum);
}

if($del_zakaz=='yes')
{
  mysql_query("DELETE FROM ri_zakaz WHERE number=$znum");
  echo("<script>alert('Заказ Id $znum работы на тему \"$zname\" удалён.');</script>");
}
?>
<html>
<head>
<TITLE>Автоматическое напоминание отключено!</TITLE>
<meta name="robots" content="none">
<link href="../referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
goToLocation=0;
function goToPage() {

	if (goToLocation!=0) 
	{
	    document.form_summ.action='payment/'+goToLocation+'.php?summ='+document.form_summ.summ.value;
        if(document.form_summ.summ.value<<?php echo($our_summ+1-1);?>)
        {
          //переход на страницу sorry.php
	      document.form_summ.action='payment/sorry.php?summ='+document.form_summ.summ.value;
        }
		if (!document.form_summ.elements['summ'].value) 
		{	
		alert ('Вы не указали сумму, за которую вы готовы приобрести эту работу');
		document.form_summ.elements['summ'].focus();
		document.form_summ.elements['summ'].style.backgroundColor='yellow'; 
		return false;
		}
		else if (isNaN(document.form_summ.elements['summ'].value)) 
		{	
		alert ('Ячейка для стоимости работы не должна содержать ничего, кроме цифр!');
		document.form_summ.elements['summ'].focus();
		document.form_summ.elements['summ'].style.backgroundColor='yellow'; 
		return false;
		}
		if (document.form_summ.agree.checked==false)
		{
		alert ('Вы не указали, что согласны с нашим пользовательским соглашением!');
		document.getElementById('myAgreement').style.backgroundColor='yellow'; 
		return false;
		}
	return true;
	}
	else 
	{alert('Вы не выбрали способ оплаты!'); return false;}
}//-->
</script>
<script language="JavaScript" type="text/JavaScript">
payBlocks=new Array ('bank','cash','post','wmchange','cards','wallet');
function sh_content(objContent)	{
for (i=0;i<payBlocks.length;i++)	{document.getElementById(payBlocks[i]).style.display='none'}
document.getElementById(objContent).style.display='block';
/*if (document.getElementById(objContent).style.display=='none') 
{document.getElementById(objContent).style.display='block';}
else {document.getElementById(objContent).style.display='none';}*/
}
</script>
<style type="text/css">
<!--
.style3 {font-weight: bold}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif','../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')">
<form name="form_summ" onSubmit="return goToPage()"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../../index.php"><img src="../../images/referatsinfo2.gif" 
alt="Банк рефератов, курсовых, дипломных работ." title="Торговая площадка Referats.info" 
width="261"  height="38" 
hspace="12" vspace="0" border="0"></a><h1 
class="graphixHeader2"><a href="../../index.php" 
class="nodecorate" style="background-color:">Банк рефератов, курсовые и дипломы</a><img 
alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты" title="" src="../../images/referat_bank.gif" 
width="55" height="16" 
border="0" align="absmiddle"></h1>
<div style="position:absolute; top:0px; left:390" id="navMenus">
  <table width="100%" height="54" align="right" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="65%" valign="top"><table height="42" border="0" align="center" cellspacing="0">
          <tr>
            <td nowrap class="red">Разделы сайта<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="6" border="1" align="absmiddle">&nbsp;&nbsp;</td>
            <td height="38" align="center" nowrap><a href="../autors.php" onMouseOver="MM_swapImage('pyctAccount','','../../images/pyctos/account2_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/account2.gif" alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты" name="pyctAccount" width="40" height="40" hspace="1" border="0" id="pyctAccount" title="Мой персональный раздел [эккаунт]
			                       Вход / Регистрация"></a></td>
            <td height="38" align="center" nowrap><a href="../cooperation.htm" onMouseOver="MM_swapImage('pyctCooperation','','../../images/pyctos/cooperation_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/cooperation.gif" alt="Сотрудничество" name="pyctCooperation" width="40" height="40" hspace="1" border="0" id="pyctCooperation"></a></td>
            <td height="38" align="center" nowrap><a href="../faq.htm" onMouseOver="MM_swapImage('pyctFaq','','../../images/pyctos/faq_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/faq.gif" alt="FAQ [часто задаваемые вопросы]" name="pyctFaq" width="40" height="40" hspace="1" border="0" id="pyctFaq"></a></td>
            <td height="38" align="center" nowrap><a href="../agreement.htm" onMouseOver="MM_swapImage('pyctAgreement','','../../images/pyctos/agreement_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/agreement.gif" alt="Пользовательское соглашение" name="pyctAgreement" width="40" height="40" hspace="1" border="0" id="pyctAgreement"></a></td>
            <td height="38" align="center" nowrap><a href="../useful.htm" onMouseOver="MM_swapImage('pyctUseful','','../../images/pyctos/useful_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/useful.gif" alt="Полезное" name="pyctUseful" width="40" height="40" hspace="1" border="0" id="pyctUseful"></a></td>
            <td align="center" nowrap><a href="../feedback.php" onMouseOver="MM_swapImage('pyctFeedback','','../../images/pyctos/feedback_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/feedback.gif" alt="Обратная связь" name="pyctFeedback" width="40" height="40" hspace="1" border="0" id="pyctFeedback"></a></td>
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
    <td style="border-bottom:dotted 1px #ff0000"><img src="../../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="70%" valign="top"><p><b><?php echo($zuser);?>, вы отключили автоматическое
        извещение о необходимости оплаты работы id <?php echo($znum);?> Тема &laquo;<span class="red"><?php echo($zname);?></span>&raquo;. </b></p>
      <p><b>Если вы хотите заказать выполнение уникального дипломного или курсового
          проекта или реферата, рекомендуем вам посетить наш второй проект &#8212; <a href="http://www.diplom.com.ru/order.php">Diplom.com.ru</a>.</b></p>
      <table width="100%"  cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" background="../../images/frames/left_orange.gif"><img src="../../images/frames/left_top_orange.gif" width="16" height="16"></td>
          <td width="100%" rowspan="3"><table width="100%"  cellspacing="0" cellpadding="0">
              <tr>
                <td style="height:1%" bgcolor="#FF9900"><img src="../../images/spacer.gif" width="2" height="2"></td>
              </tr>
              <tr>
                <td style="padding:10px 0px 10px 0px"><table width="100%"  cellspacing="0" cellpadding="0">
                  <tr valign="top">
                    <td><table width="100%" cellpadding="2"  cellspacing="0" bgcolor="#000066">
                        <tr>
                          <td><a href="http://www.diplom.com.ru"><img src="../../images/logo23.gif" width="179" height="67" hspace="6" vspace="8" border="0" class="rightOffset"></a></td>
                        </tr>
                    </table></td>
                    <td width="100%" rowspan="3"><ul style="padding-top:0px; margin-top:0px">
                        <li>Несколько десятков <b>высококлассных</b> исполнителей</li>
                        <li><b>Заказ любой работы</b> на любую тему и по любому предмету</li>
                        <li><b>Отличное качество</b></li>
                        <li><b>Разумная цена</b> заказов</li>
                        <li>Максимально оперативная обратная связь</li>
                        <li>Гибкий персонифицированный подход к вашим нуждам</li>
                        <li><b>Скидки</b> при последующих заказах </li>
                    </ul></td>
                  </tr>
                  <tr valign="top">
                    <td align="center" valign="bottom"><img src="../../images/arrows/inbox.gif" width="31" height="26" vspace="10" border="1" style="border:solid #00BA00 1px"></td>
                  </tr>
                  <tr valign="top">
                    <td align="center" valign="bottom"><input type="button" name="Button" value="     OK     " onClick="location.href='http://www.diplom.com.ru'"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td bgcolor="#FF9900"><img src="../../images/spacer.gif" width="2" height="2"></td>
              </tr>
          </table></td>
          <td valign="top" background="../../images/frames/right_orange.gif"><img src="../../images/frames/right_top_orange.gif" width="16" height="16"></td>
        </tr>
        <tr>
          <td background="../../images/frames/left_orange.gif" style="height:98%">&nbsp;</td>
          <td background="../../images/frames/right_orange.gif">&nbsp;</td>
        </tr>
        <tr>
          <td valign="bottom" background="../../images/frames/left_orange.gif"><img src="../../images/frames/left_bottom_orange.gif" width="16" height="16"></td>
          <td valign="bottom" background="../../images/frames/right_orange.gif"><img src="../../images/frames/right_bottom_orange.gif" width="16" height="16"></td>
        </tr>
      </table>
      <br></td>
    <td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial">    <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>Если у вас возникли вопросы, вы можете послать сообщение на <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=305709350&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">305709350</nobr></a>,
    либо воспользоваться формой отправки на нашем сайте. Для этого щёлкните <a href="../faq.htm#question_form" target="_blank">здесь</a>.
      <p>Ответы на наиболее часто встречающиеся вопросы вы можете найти на странице <a href="../faq.htm" target="_blank">FAQ</a>. </p>      
    </td></tr>
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
