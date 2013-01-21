<?php
session_start();
require('../connect_db.php');
require('lib.php');
if($myWorxNum!='')
{
  session_register('S_LIST_PAGE');
  session_register('S_F_ALL');
  session_register('S_F_REF');
  session_register('S_F_KUR');
  session_register('S_F_DIP');
  session_register('S_F_ARCHIVE'); //флаг "показать архивные"
  $S_F_ARCHIVE='status>=0';
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
  session_register('S_ZK_SUMM');
  $S_ZK_SUMM=0;
  session_register('S_RAD_ORDER');
  $S_RAD_ORDER='name';
  statistic($S_NUM_USER, 'index.php', $HTTP_REFERER);
  $S_WORK_NUM=$myWorxNum;
}
$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet WHERE ri_works.predmet=diplom_predmet.number AND ri_works.number=$S_WORK_NUM");
$wname=mysql_result($wk_r,0,'ri_works.name');
$wtip=mysql_result($wk_r,0,'ri_works.tip');
$wtax=mysql_result($wk_r,0,'ri_works.tax');
$our_summ=min_tax($wtax);
$wpages=mysql_result($wk_r,0,'ri_works.pages');
$wpredm=mysql_result($wk_r,0,'diplom_predmet.predmet');
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'ri_works.annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');

$dt=$Year."-".$Month."-".$Day;
if($fl!='edit')
{
  //проверить. Вдруг такой заказ уже есть! Тогда надо сообщить, что нет нужды его заказывать еще раз!
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE work=$S_WORK_NUM AND email='$email'");
  //echo("SELECT * FROM ri_zakaz WHERE work=$S_WORK_NUM AND email='$email'<br>");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n==0)
  {
    $id=mysql_query("INSERT INTO ri_zakaz ( user, work, data, data_to, status, email, phone, mobila, workphone, dopphone, icq, summ_our ) VALUES ( '$name', $S_WORK_NUM, '".date('Y-m-d')."', '$dt', 7, '$email', '$phone', '$mobila', '$workphone', '$dopphone', '$icq', '$our_summ' )");
    $S_ZAKAZ_NUM=mysql_insert_id();
  }
  else
  {
    $S_PASSLOH=mysql_result($zk_r,0,'number')*12345;
    echo("<script>alert('Вы уже заказывали работу \"$wname\"!');\nlocation.href='user_account.php';</script>");
  }
}
else
{
  mysql_query("UPDATE ri_zakaz SET email='$email', phone='$phone', mobila='$mobila', workphone='$workphone', dopphone='$dopphone', icq='$icq' WHERE number=$S_ZAKAZ_NUM");
}
?>
<html>
<head>
<TITLE>рефераты дипломные работы купить диплом на заказ рефераты</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<!-- дипломные работы купить диплом -->
<meta name="keywords" content="дипломные работы купить диплом на заказ; экономика; выполнение рефератов; педагогика; написание диплома; биология; заказ курсовой работы; политология; написание диплома на заказ; государственное регулирование; помощь в сдаче сессии; пищевые продукты; рефераты и курсовые работы; промышленность и производство; коллекция рефератов; социология; курсовая работа на заказ; дипломная работа; банк рефератов; коллекция рефератов; реферат бесплатно; написание диссертации; ОБЖ; география; экономическая география; радиоэлектроника; законодательство и право; иностранные языки; литература; социология; физика; химия; программирование; философия; экономика и финансы; охрана природы; экология">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../go_url.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
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
<script language="JavaScript" type="text/JavaScript" src="../wctable.js"></script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {color: #CC66CC}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><form name="form_summ" onSubmit="return goToPage()"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="70%" valign="top"><p class="header6bottom"><b>Ваша заявка:</b> </p>
      <table width="100%" cellpadding="3"  cellspacing="1" bgcolor="#CC0000">
        <tr>
          <td colspan="2" background="../images/pyctos-bg-4.gif"><font size="+1"><?php echo($wname);?></font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Тип
              работы&nbsp;<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
          <td width="100%"><b><?php echo($wtip_s);?></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Предмет&nbsp;<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
          <td><b><?php echo($wpredm);?></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Объём&nbsp;<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
          <td><b><?php echo($wpages);?> листов</b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="2" nowrap bgcolor="#F5F5F5"><span onClick="sh_content('tr_content');" style="text-decoration:underline; color:#0000FF; cursor:hand">Отобразить
              содержание работы</span></td>
        </tr>
        <tr bgcolor="#FFFFFF" id="tr_content" style="display:none">
          <td colspan="2" bgcolor="#F5F5F5" style="padding:10px"><b>Содержание
              работы:</b>
              <hr size="1" noshade>
              <?php echo($wannot); ?></td>
        </tr>
      </table>
      <p>1. Сообщите, пожалуйста, какую сумму Вы готовы заплатить за данную работу:
        <input name="summ" type="text" id="summ" size="4" onBlur="if (this.value) this.style.backgroundColor='';">
руб. <br>
2. Выберите способ оплаты: </p>      
      <table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#E4E4E4">
            <tr>
              <td><input type="radio" name="pay_tip" value="bank" onClick="goToLocation='bank'">
       перечислением денег на наш банковский счёт <br>
      <input type="radio" name="pay_tip" value="cash" onClick="goToLocation='cash'">
      перечислением наличных <br>
      <input type="radio" name="pay_tip" value="post" onClick="goToLocation='post'">
      почтовым денежным переводом <br>
      <input type="radio" name="pay_tip" value="telegraph" onClick="goToLocation='telegraph'">
      телеграфным переводом <br>
      <input type="radio" name="pay_tip" value="webmoney" onClick="goToLocation='webmoney'">
      через обменныe пункты WebMoney <br>
      <input type="radio" name="pay_tip" value="cards" onClick="goToLocation='cards'">
      карточками предоплаты WebMoney или Яндекс.деньги<br>
      <input type="radio" name="pay_tip" value="wallet" onClick="goToLocation='wallet'">
      переводом денег из вашего электронного кошелька в наш, если вы уже являетесь
      клиентами систем WebMoney или Яндекс.деньги </td>
            </tr>
      </table>
	  <table width="100%"  cellspacing="0" cellpadding="4">
          <tr>
            <td id="myAgreement"><input name="agree" type="checkbox" id="agree" value="checkbox" checked onClick="if (this.checked==true) this.parentNode.style.backgroundColor='';">
Я согласен (согласна) и принимаю условия <a href="agreement.htm" target="_blank">пользовательского
соглашения</a>.</td>
          </tr>
        </table>            
      <input type="submit" name="Submit" value="Выбрать!"></td>
    <td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial">    <span class="style3"></span><img src="../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>Если у вас возникли вопросы, вы можете послать сообщение на <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=219335286&action=message"><nobr>icq <img src="../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">219335286</nobr></a>,
    либо воспользоваться формой отправки на нашем сайте. Для этого щёлкните <a href="faq.htm#question_form" target="_blank">здесь</a>.
      <p>Ответы на наиболее часто встречающиеся вопросы вы можете найти на странице <a href="faq.htm" target="_blank">FAQ</a>. </p>      
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
