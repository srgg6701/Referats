<?php
session_start();
require('../connect_db.php');
require('lib.php');

$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet WHERE ri_works.predmet=diplom_predmet.number AND ri_works.number=$S_WORK_NUM");
$wname=mysql_result($wk_r,0,'ri_works.name');
$wtip=mysql_result($wk_r,0,'ri_works.tip');
$wpages=mysql_result($wk_r,0,'ri_works.pages');
$wpredm=mysql_result($wk_r,0,'diplom_predmet.predmet');
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'ri_works.annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE Number=$S_ZAKAZ_NUM");
$zuser=mysql_result($zk_r,0,'user');
$zemail=mysql_result($zk_r,0,'email');
$zphone=mysql_result($zk_r,0,'phone');
$zmobila=mysql_result($zk_r,0,'mobila');
$zworkphone=mysql_result($zk_r,0,'workphone');
$zdopphone=mysql_result($zk_r,0,'dopphone');
$zicq=mysql_result($zk_r,0,'icq');
//поправить заказ
mysql_query("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$pay_tip' WHERE number=$S_ZAKAZ_NUM");
?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link href="referats.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style3 {color: #009900;}
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../wctable.js"></script>
</head>
<body bgcolor="#FFFFFF" topmargin="0" marginheight="0" lang=RU onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><form name="ed_form" method="post" action='payment/thanx.php' onSubmit="return emailCheckReferats(this.email);"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
</script><!-- #EndLibraryItem --><!-- #EndLibraryItem -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td width="70%" valign="top"><h4 class="style3"><strong><?php echo($zuser);?>,
              Вы сделали заказ со следующими параметрами:</strong></h4>
            
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
                <tr bgcolor="#F5F5F5" id="tr_content" style="display:none">
                  <td colspan="2" style="padding:10px"><b>Содержание работы:</b>
                      <hr size="1" noshade>
                      <?php echo($wannot); ?></td>
                </tr>
              </table>
			  <h2>Вы указали следующие контактные данные:</h2>
                <table  cellspacing="0" cellpadding="0">
                <tr>
                  <td>Ваш email:
                    <input name="email" type="text" id="email" value="<?php echo($zemail);?>" size="50"></td>
                  <td rowspan="6" valign="bottom"><input type="submit" name="Submit" value="Подтвердить!"></td>
                </tr>
                <tr>
                  <td>Ваш домашний телефон:
                    <input name="phone" type="text" id="phone" value="<?php echo($zphone);?>">
                    <input name="fl" type="hidden" id="fl" value="edit"></td>
                </tr>
                <tr>
                  <td>Ваш рабочий телефон:
                    <input name="workphone" type="text" id="workphone" value="<?php echo($zworkphone);?>"></td>
                </tr>
                <tr>
                  <td>Ваш мобильный телефон:
                  <input name="mobila" type="text" id="mobila" value="<?php echo($zmobila);?>"></td>
                </tr>
                <tr>
                  <td>Ваш дополнительный телефон:
                  <input name="dopphone" type="text" id="dopphone" value="<?php echo($zdopphone);?>"></td>
                </tr>
                <tr>
                  <td>Ваш ICQ:
                  <input name="icq" type="text" id="icq" value="<?php echo($zicq);?>"></td>
                </tr>
              </table>              
              <br>
              <hr size="1" noshade><!-- #BeginLibraryItem "/Library/block_good%20services.lbi" --><h4 class="style3"><img src="../images/juniors.jpg" width="110" height="110" hspace="20" vspace="0" border="1" align="left" style="border-color:#009900 "><b>Вы останетесь довольны нашим сервисом! </b></h4>
              <p>Ответы на наиболее часто встречающиеся вопросы Вы можете узнать
              в разделе <a href="faq.htm">FAQ</a>.</p>
              <input type="button" name="Button" value="Зайти в свой эккаунт" onClick="location.href='../autorization.php<?php echo("?login=$zemail&pass=$passloh");?>'"> 
              <span title="Развернуть/свернуть быструю подсказку" style="color:#0000FF; text-decoration:underline; font-size: 120%; cursor:hand" onClick="(document.getElementById('accHelp').innerHTML=='')? document.getElementById('accHelp').innerHTML='<table bgColor=yellow cellPadding=4 cellSpacing=0 border=0><tr><td>Ваш эккаунт &#8212; это ваш персональный раздел, позволяющий вам видеть статистику своих заказов, а также поддерживать обратную связь с нами и быстро заказывать новые работы.</td></tr></table>':document.getElementById('accHelp').innerHTML='';">[?]</span><span id="accHelp"></span><!-- #EndLibraryItem --></td>
          <td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial">            <span class="style3"></span><img src="../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>Если у вас возникли вопросы, вы можете послать сообщение на <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=219335286&action=message"><nobr>icq <img src="../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">219335286</nobr></a>,
              либо воспользоваться формой отправки на нашем сайте. Для этого щёлкните <a href="faq.htm#question_form">здесь</a>. 
              <p>Ответы на наиболее часто встречающиеся вопросы вы можете найти
                на странице <a href="faq.htm" target="_blank">FAQ</a>. </p>
              <h2 class="header6bottom"><span class="style3"></span>
            </h2></td></tr>
      </table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
  <tr valign="bottom">
    <td height="22" align="center" nowrap class="topDotted">&nbsp;</td>
    </tr>
  <tr valign="bottom">
    <td height="20" align="center" nowrap background="../images/bankreferatov_bg.gif"><b style="font-weight:100">Банк
        рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ,
        рефераты</b></td>
  </tr>
</table>
</form>
</body>
</html>
