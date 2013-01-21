<?php
session_start();
require('../connect_db.php');
require('lib.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($fl=='send_mail')
{
  if($who==0){$frm='Потенциальный заказчик';}
  if($who==1){$frm='Сделавший заказ клиент';}
  if($who==2){$frm='Кандидат в авторы';}
  if($subj==0){$sbj="Выберите из списка";}
  if($subj==1){$sbj="Деньги";}
  if($subj==2){$sbj="Технические вопросы";}
  if($subj==3){$sbj="Вопросы сотрудничества";}
  if($subj==4){$sbj="Другое";}
  send_intro_mess(0, 1, $email, "Feedback:$who:$subj $sbj;$frm", nl2br("<b>На тему:</b> $sbj<br><b>Статус:</b> $frm<br>$letter"), 0);
  mail($admin_mail, "Feedback:$who:$subj $sbj;$frm", nl2br("<b>На тему:</b> $sbj<br><b>Статус:</b> $frm<br>$letter"), "From: $email".chr(13).chr(10)."Reply-To: $email".chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  //послать письмо и свалить на index.php
  header("location: index.php?alert=Ваш вопрос администратору отправлен!");
}
?>
<html>
<head>
<TITLE>Рефераты, дипломные, курсовые работы на заказ, банк рефератов</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript">
visitorStat=0;
function checkStat() {
if (visitorStat==0) 
	{
	alert ('Вы не указали свой статус отправителя!\n\nОтметьте галочкой один из пунктов:\n------------------------------------------------\n- "Потенциальный заказчик"\n- "Сделавший заказ клиент"\n- "Кандидат в авторы"');
	return false;
	}
if (document.form1.subj.options[0].selected)
	{
	alert ('Вы не выбрали тему вопроса!');
	return false;
	}
if (!document.form1.letter.value)
	{
	alert ('Вы не задали свой вопрос!');
	return false;
	} 
    //return 
	var x;
	//Есть true или false (возврат значения валидности емэйла)
	x=emailCheckReferats(document.form1.email);
	if(x && document.form1.checkSMS.checked)
	{
	  window.open('http://rocc.ru/cgi-bin/sms33.cgi?Prefix=7904&phone=4428447&message=Вам сообщение с referats.info!');
	}
	return x;
	
}
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif'); if (document.referrer.indexOf('cooperation.htm')!=-1) document.form1.style.display='block'"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
    <td width="50%" valign="top"><h1>Обратная связь </h1>
      <p>Из этого раздела вы можете отослать нам сообщение. Сделать это вы можете
        двумя способами. Для этого щёлкните по нужной ссылке. </p>
		<p><img src="../images/send_email.gif" width="73" height="38" hspace="6" align="left"><span style="color:#0000FF; text-decoration:underline; cursor:hand" onClick="document.forms['form1'].style.display='block';document.forms['Send_Message'].style.display='none';">Через форму отправки</span> (сообщение придёт к нам по емэйлу). Причём,
          если вы хотите, чтобы мы сразу же узнали о вашем сообщении, вы можете
          отметить галочкой пункт &laquo;Уведомить с СМС&raquo;. </p>
        <p><img src="../images/send_sms.gif" width="73" height="38" hspace="6" align="left">Собственно, <span style="color:#0000FF; text-decoration:underline; cursor:hand" onClick="document.forms['form1'].style.display='none';document.forms['Send_Message'].style.display='block';">отправкой СМС</span> с этой страницы (для коротких срочных сообщений).<br>
          <br>
          <br>
        </p>
        
        <form action="feedback.php" name="form1" method="post" onSubmit="return checkStat()" style="display:none"><br>
<hr size="1" noshade color="#ffa993">      
          <h2 class="header6bottom"><b>Заполните форму отправки сообщения. Мы постараемся ответить вам в течение 24 часов.</b></h2>
          <table width="100%" cellpadding="6"  cellspacing="0" bgcolor="#CCCCCC">
        <tr valign="top" bgcolor="#F5F5F5">
          <td width="1%" nowrap bgcolor="#E4E4E4"><h1 class="header6bottom"><strong>Кто вы?</strong></h1>              
            <input name="who" type="radio" value="0" onClick="visitorStat=1">
        Потенциальный заказчик<br>        <input name="who" type="radio" value="1" onClick="visitorStat=1">
        Сделавший заказ клиент <br>        <input name="who" type="radio" value="2" onClick="visitorStat=1">
        Кандидат в авторы<br>        <span class="arial">Ваш email:</span><br>        <input name="email" type="text" value="" style="width:100%">        <br>        
        <span class="arial">Тема сообщения:</span><br>        <select name="subj" id="subj">
                <option value="0">-Выберите из списка-</option>
                <option value="1">Деньги</option>
                <option value="2">Технические вопросы</option>
                <option value="3">Вопросы сотрудничества</option>
		        <option value="4">Другое</option>
        </select>            </td>
          <td><span class="arial">Ваше сообщение:</span> <br>
              <textarea name="letter" rows="10" id="letter" style="width:100%"></textarea>
              <input type="submit" name="Submit" value="Отправить вопрос!">
              <input name="fl" type="hidden" id="fl" value="send_mail"></td>
        </tr>
      </table>        <input name="checkSMS" type="checkbox" id="checkSMS" value="on">
      Уведомить с СМС
      <input type="hidden" name="hiddenField">      
      </form>
            <form name=Send_Message action=http://rocc.ru/cgi-bin/sms33.cgi 
            method=post  style="display: none">
			  <br>
              <hr size="1" noshade color="#ffa993">
              <h2 class="header6bottom"><b></b></h2>
              <INPUT type=hidden value=7904 name=Prefix>
      <h2 class="header6bottom"><strong>Отошлите СМС с этой страницы (до 160 символов).</strong> </h2>
      <div style="position:absolute;top:-1000;"><INPUT type=hidden value=7904 name=Prefix>
Номер телефона:<BR>
            +7904
            <INPUT maxLength=7 size=7 name=phone value=4428447></div>
                        Текст сообщения (осталось символов:
                        <INPUT name=remainchars style="border:none; background-color: yellow" value=160 
                  size=1 readOnly>
                        ):<BR>
			<SCRIPT language="JavaScript">
var MaxLength = 160;

function DisplayLength(){

  if ( Send_Message.message.value.length > MaxLength )

    Send_Message.message.value = Send_Message.message.value.substr( 0, MaxLength );

  Send_Message.remainchars.value = MaxLength - Send_Message.message.value.length;

}

function CheckLength(){

  event.returnValue = Send_Message.message.value.length < MaxLength || document.selection.type != "None";

}
</SCRIPT>
            <textarea name=message cols="40" rows=6 onKeyPress=DisplayLength();CheckLength(); onpaste=CheckLength(); onpropertychange=DisplayLength(); style="background-color:ccffcc; border:solid 1px #999999"></textarea>
            <br>
            <INPUT name="submit" type=submit class="topPad6" value=Отправить СМС!>
            <INPUT name="reset" type=reset class="topPad6" value=Очистить>            
            </form>
    </td>
  </tr>
</table>
<p><a href="http://www.order.referats.info">Диплом на заказ. Заказать диплом. Написать дипломную работу.</a></p> <!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
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
  <img src="http://u6940.51.spylog.com/cnt?cid=694051&p=1" alt='SpyLOG' border='0' width=88 height=31 ></a></noscript>
  <!-- SpyLOG -->
  <!-- #EndLibraryItem -->
    <SCRIPT language=JavaScript>
<!--

if (telekaks.isSupported()) {
var ms = new mtDropDownSet(telekaks.direction.down, 0, 2, telekaks.reference.bottomLeft);

var menucompany = ms.addMenu(document.getElementById("company"));
menucompany.addItem("О компании", "http://editorial.rostov.tele2.ru/?page=telerurost_about_comp&t2page=company_about");
menucompany.addItem("Новости", "http://news.rostov.tele2.ru/index.phtml/category/teleru_rov?t2page=company_news");
menucompany.addItem("Зона покрытия", "http://editorial.rostov.tele2.ru/?page=telerurost_coverage&t2page=company_coverage");
menucompany.addItem("Кто есть кто", "http://editorial.rostov.tele2.ru/?page=telerurost_whoiswho&t2page=company_whoiswho");
menucompany.addItem("Вакансии", "http://editorial.rostov.tele2.ru/?page=telerurost_vacancy_no&t2page=company_vacancy");
menucompany.addItem("Публичный договор", "http://editorial.rostov.tele2.ru/?page=telerurost_about_agreem&t2page=company_dog");
menucompany.addItem("Реквизиты", "http://editorial.rostov.tele2.ru/?page=telerurost_essential&t2page=company_essent");
var menutarifs = ms.addMenu(document.getElementById("tarifs"));
menutarifs.addItem("Тарифы", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_about&t2page=tarifs_tariffs");
var menutariffs = menutarifs.addMenu(menutarifs.items[0]);
menutariffs.addItem("TELE2 Экспреcc", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_express&t2page=tarifs_tariffs_express");
menutariffs.addItem("TELE2 Контракт", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_contract&t2page=tarifs_tariffs_kontrakt");
menutarifs.addItem("Междугородние и международные вызовы", "http://editorial.rostov.tele2.ru/?page=teleruall_construction&t2page=tarifs_mgorod");
var menuphones = ms.addMenu(document.getElementById("phones"));
menuphones.addItem("Телефоны", "http://editorial.rostov.tele2.ru/?page=telerurost_phones&t2page=phones_phoneprice");
var menuservices = ms.addMenu(document.getElementById("services"));
menuservices.addItem("Общая информация", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_about&t2page=services_infoserv");
menuservices.addItem("Роуминг", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_roaming&t2page=services_roaming");
menuservices.addItem("Голосовая почта", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_voicemail&t2page=services_voicemail");
menuservices.addItem("Детализация", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_detalization&t2page=services_details");
menuservices.addItem("Информационно - развлекательные", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi&t2page=services_randi");
var menurandi = menuservices.addMenu(menuservices.items[4]);
menurandi.addItem("Логотипы и мелодии", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_logotones&t2page=services_randi_logosandtones");
menurandi.addItem("SMS-общение", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_smstalk&t2page=services_randi_smsob");
menurandi.addItem("SMS-трансляции спортивных соревнований", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_sport&t2page=services_randi_smssport");
menurandi.addItem("Персональные SMS-услуги", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_personal&t2page=services_randi_smspers");
menurandi.addItem("Информационные SMS-услуги", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_info&t2page=services_randi_smsinfo");
menurandi.addItem("SMS-игры", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_games&t2page=services_randi_smsgames");
menurandi.addItem("Развлекательные SMS-услуги", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_ent&t2page=services_randi_smsentertainment");
menuservices.addItem("Дополнительные услуги", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_extended&t2page=services_dopusl");
menuservices.addItem("Отправить SMS", "http://editorial.rostov.tele2.ru/?page=teleruspb_serv_sendsms&t2page=services_smsform");
var menuwhereto = ms.addMenu(document.getElementById("whereto"));
menuwhereto.addItem("Магазины", "http://editorial.rostov.tele2.ru/?page=telerurost_where_shops&t2page=whereto_shops");
menuwhereto.addItem("Карты предоплаты", "http://editorial.rostov.tele2.ru/?page=telerurost_where_cards&t2page=whereto_cards");
menuwhereto.addItem("Рекламные акции", "http://editorial.rostov.tele2.ru/?page=teleruall_construction&t2page=whereto_special");
var menuhelp = ms.addMenu(document.getElementById("help"));
menuhelp.addItem("Общая информация", "http://editorial.rostov.tele2.ru/?page=telerurost_help_about&t2page=help_infohelp");
menuhelp.addItem("Вопросы и ответы", "http://editorial.rostov.tele2.ru/?page=telerurost_help_faq&t2page=help_faq");
menuhelp.addItem("Справочник абонента", "http://editorial.rostov.tele2.ru/?page=telerurost_help_customer&t2page=help_customer");
menuhelp.addItem("Обратная связь", "http://editorial.rostov.tele2.ru/?page=telerurost_help_feedback&t2page=help_feedback");


telekaks.renderAll();
}

function init ( ) {
if (telekaks.isSupported()) {
telekaks.initialize();


}
}

-->
    </SCRIPT>
</p>
</body>
</html>
