<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
$S_PAY_TIP='cards';
$S_ZK_SUMM=$summ;

$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet WHERE ri_works.predmet=diplom_predmet.number AND ri_works.number=$S_WORK_NUM");
$wname=mysql_result($wk_r,0,'ri_works.name');
$wtip=mysql_result($wk_r,0,'ri_works.tip');
$wpages=mysql_result($wk_r,0,'ri_works.pages');
$wpredm=mysql_result($wk_r,0,'diplom_predmet.predmet');
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'ri_works.annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');
?>
<html>
<head>
<title>Оплата карточками предоплаты WebMoney или Яндекс.деньги</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link href="../referats.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../../wctable.js"></script>
</head>
<body bgcolor="#FFFFFF" topmargin="0" marginheight="0" lang=RU onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif','../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../../index.php"><img src="../../images/referatsinfo2.gif" 
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td width="70%" valign="top"><!-- #BeginLibraryItem "/Library/block_order_data.lbi" -->
<p class="header6bottom"><b>Ваша заявка:</b> </p>
<table width="100%" cellpadding="3"  cellspacing="1" bgcolor="#CC0000">
  <tr>
    <td colspan="2" background="../../images/pyctos-bg-4.gif"><font size="+1"><?php echo($wname);?></font></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Тип
        работы&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
    <td width="100%"><b><?php echo($wtip_s);?></b></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Предмет&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
    <td><b><?php echo($wpredm);?></b></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">Объём&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
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
<h2>Заявленная Вами сумма: <strong><?php echo($summ);?></strong> руб.              </h2>
<!-- #EndLibraryItem --><h5 class="header10bottom"><span style="font-weight:200">
			  Выбранный способ оплаты:</span> карточки предоплаты WebMoney или Яндекс.деньги</h5>
			  <p>Вам необходимо: </p>
              <p>Приобрести WM или Яндекс.деньги карту(ы) (где приобрести &#8212; см.
                в правой части страницы) и отправить на <img src="../../images/mail_payment.gif" align="absbottom"> (либо
                сообщить нам по телефону (88634)38-35-28) следующую информацию:</p>
              <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
                <tr align="center">
                  <td bgcolor="whitesmoke"><b>Для WM-карт:</b></td>
                  <td bgcolor="whitesmoke"><b>Для Яндекс.деньги-карт:</b></td>
                </tr>
                <tr>
                  <td valign="top"><ol>
                      <li>Номер карты и PIN (код авторизации);</li>
                      <li> Сумму оплаты;</li>
                      <li>Предмет и тему работы</li>
                      </ol></td>
                  <td valign="top"><ol>
                      <li>Номер карты;</li>
                      <li> Серия выпуска;</li>
                      <li>Пароль (чтобы увидеть его, с него нужно стереть защитное
                        покрытие)</li>
                      <li>Код проверки (с него также нужно стереть защитное покрытие)</li>
                      <li>Предмет и тему работы</li>
                      </ol></td>
                </tr>
              </table>
              <br>
              <H4 class="leftHeader">Подробнее о картах предоплаты WebMoney и
                Яндекс.деньги:</H4>
				<hr size="1" noshade>			<H4>WM-карты</H4>
				<P>В&nbsp;данный момент в&nbsp;системе WebMoney Transfer используются
                  универсальные <NOBR>WM-карты</NOBR> трех типов: WMZ,&nbsp;WMR
                  и WMU.</P>            <P><NOBR>WMZ-карты</NOBR> имеют номиналы 10, 20, 50 и&nbsp;100&nbsp;WMZ
                  (эквивалент&nbsp;USD). Они обеспечивают пополнение <NOBR>Z-кошельков</NOBR> участников
                  системы, а&nbsp;также используются в&nbsp;качестве цифровых
                  чеков <NOBR>WMZ-типа</NOBR> для&nbsp;расчетов в&nbsp;системе <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>
				  <P><IMG title="WMZ-карты, лицевая сторона" height=175 
                  src="../../images/cards/card_faces.jpg" width=350><IMG 
                  title="WMZ-карта, обратная сторона" height=135 
                  src="../../images/cards/card_backz.gif" width=210></P>            <P><NOBR>WMR-карты</NOBR> имеют номиналы 500, 1000, 3000 и&nbsp;5000&nbsp;WMR
                  (эквивалент&nbsp;RUR). Они обеспечивают пополнение <NOBR>R-кошельков</NOBR> участников
                  системы, а&nbsp;также используются в&nbsp;качестве цифровых
                  чеков <NOBR>WMR-типа</NOBR> для&nbsp;расчетов в&nbsp;системе <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>            <P><IMG title="WMR-карты, лицевая сторона" height=175 
                  src="../../images/cards/card_facer.jpg" width=350><IMG 
                  title="WMR-карта, обратная сторона" height=135 
                  src="../../images/cards/card_backr.gif" width=210></P>            <P><NOBR>WMU-карты</NOBR> имеют номиналы 50, 100, 200 и 500 WMU
                  (эквивалент UAH). Они обеспечивают пополнение <NOBR>U-кошельков</NOBR> участников
                  системы, а&nbsp;также используются в&nbsp;качестве цифровых
                  чеков <NOBR>WMU-типа</NOBR> для&nbsp;расчетов в&nbsp;системе <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>            <P><IMG title="WMU-карты, лицевая сторона" height=193 
                  src="../../images/cards/card_faceu.jpg" width=371><IMG 
                  title="WMU-карта, обратная сторона" height=146 
                  src="../../images/cards/card_backu.gif" width=210></P>            
                  <hr size="1" noshade>                  <p><b>Яндекс.деньги-карты:</b> </p>            
                  <p>выпускаются номиналом 500, 1000, 3000 и 10000 рублей. </p>
              <table border="0" cellpadding="4" cellspacing="0">
                <tr align="center" bgcolor="#f5f5f5">
                  <td>номинал 500 р.</td>
                  <td>номинал 1000 р.</td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td><img src="../../images/cards/card500m.jpg" width="150" height="100" vspace="4"></td>
                  <td><img src="../../images/cards/card1000m.jpg" width="151" height="100" vspace="4"></td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td bgcolor="#f5f5f5">номинал 3000 р.</td>
                  <td bgcolor="#f5f5f5">номинал 10000 р.</td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td><img src="../../images/cards/card3000m.jpg" width="158" height="100" vspace="4"></td>
                  <td><img src="../../images/cards/card10000m.jpg" width="151" height="100" vspace="4"></td>
                </tr>
              </table>
              <p><br>
  На карточках &laquo;Яндекс.Денег&raquo; указана серия выпуска, номер и пароль.
  Они бывают двух видов &#8212; пластиковые и виртуальные. Пластиковые карточки &laquo;Яндекс.Деньги&raquo; отличаются
  от виртуальных карточек &laquo;Яндекс.Деньги&raquo; только наличием пластикового
  носителя и защитных скретч-полос. </p>
              <p>Пластиковые карточки "Яндекс.Деньги" можно купить в банках,
                картоматах, интернет-магазинах, службах курьерской экспресс-доставки
                и пр. </p>
              <P>Виртуальные карточки "Яндекс.Деньги" можно купить в банкоматах,
                платежных терминалах, салонах связи, игровых залах, интернет-магазинах,
                и пр.</P>
                        <input type="button" name="Button" value="Подтвердить!" onClick="location.href='thanx.php?srok=cards'">
</td><td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><h5 class="header10bottom">Где
              можно приобрести карточки предоплаты <a href="#wm">WebMoney</a> или <a href="#ya">Яндекс.деньги</a>:</h5>            
            <span class="arial"><b><a name="wm"></a>Карты предоплаты WebMoney</b><a 
                  name=1></a>
            </span>            <A 
                  name=1>&nbsp;</A>            <P>Приобрести <NOBR>WM-карты</NOBR> вы можете у&nbsp;дилеров:</P>
            <UL>
              <LI><A 
                    href="http://www-2.webmoney.ru/carddostavka.shtml"><STRONG>Доставка
                    карт</STRONG> на&nbsp;дом и&nbsp;в&nbsp;офис: областные центры
                    России, Украины, Москва, Санкт-Петербург, Киев, Online (виртуальные
                    пин-коды).</A><BR>
                            <BR>
                            <SCRIPT src="http://keeper.webmoney.ru/dilregionsget.asp" type=text/javascript></SCRIPT>
              </LI>
            </UL>
            <P>Если в&nbsp;данном списке не&nbsp;представлен Ваш регион или&nbsp;город,
              то&nbsp;быстро найти альтернативный способ пополнения кошелька
              (ближайший обменный пункт, почтовое отделение, магазин, точку продаж <NOBR>WM-карт</NOBR> или&nbsp;пункт
              пополнения наличными) можно на&nbsp;сайте геоинформационного сервиса <IMG height=16 alt="" 
                  src="../../images/cards/sglobe.gif" width=16 align=top> <A 
                  href="http://geo.webmoney.ru/">geo.webmoney.ru</A>.</P>
            <P>Cписок пунктов распространения <NOBR>WM-карт</NOBR> постоянно
              пополняется. Все заинтересованные в&nbsp;реализации <NOBR>WM-карт</NOBR> организации,
              предприниматели и&nbsp;частные лица могут обращаться по&nbsp;электронной
              почте на&nbsp;адрес <A 
                  href="mailto:wmcards@webmoney.ru">wmcards@webmoney.ru</A>.</P>
            <P class="arial">Всю информацию по картам предоплаты WebMoney Вы можете посмотреть <a href="http://www.webmoney.ru/cardmain.shtml" target="_blank">здесь</a>.</P>
            <p class="arial"><b><a name="ya" id="ya"></a>Карты предоплаты Яндекс.деньги</b></p>
            <p class="arial">Пластиковые карточки &laquo;Яндекс.Деньги&raquo; можно
                купить в банках, картоматах, интернет-магазинах, службах курьерской
              экспресс-доставки и пр. </p>
            <p class="arial">Виртуальные карточки &laquo;Яндекс.Деньги&raquo; можно
                купить в банкоматах, платежных терминалах, салонах связи, игровых
              залах, интернет-магазинах, и пр.</p>
            <p class="arial">Адреса авторизованных дилеров:</p>
            <ul>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236747','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Москва</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237284','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Московская
                  область</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236673','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Санкт-Петербург</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236739','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Новосибирск</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237381','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Интернет</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236946','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Дальний
                  Восток</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237008','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Поволжье</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237070','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Северо-Восток</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237079','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Северо-Запад</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237115','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Сибирь</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237195','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Урал</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237256','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Центр</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237321','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">Юг</a></li>
            </ul>
            <p class="arial">КУРЬЕРСКАЯ ЭКСПРЕСС-ДОСТАВКА КАРТОЧЕК &laquo;ЯНДЕКС.ДЕНЬГИ&raquo;:</p>
            <ul>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241432">В Москве</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241433">В Санкт-Петербурге</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=280313">В Зеленограде
                    и Московской области</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241434">В Киеве</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=412625">В Екатеринбурге</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241779">В Ереване</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=309076">В Харькове</A></SPAN> </LI>
            </ul>
            <p class="arial"> Всю информацию по использованию карт предоплаты Яндекс.деньги
              Вы можете получить <a href="http://money.yandex.ru/?id=242313" target="_blank">здесь</a>. </p>
            <h5 class="header10bottom">ВНИМАНИЕ!</h5>
            <span class="arial"><font color="#FF0000">Ни в коем случае не
                  покупайте карты предоплаты &laquo;с
                рук&raquo;. Вы можете заплатить деньги за подделку!</font></span><!-- #BeginLibraryItem "/Library/block_if_questions.lbi" --><span class="arial"><hr size="1" noshade color="#FF9900">
            <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>Если у вас возникли вопросы, вы можете послать сообщение на <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=29894257&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">29894257</nobr></a>,  либо воспользоваться формой отправки на нашем сайте. Для этого щёлкните <a href="../faq.htm#question_form">здесь</a>. 
            <p>Ответы на наиболее часто встречающиеся вопросы вы можете найти на странице <a href="../faq.htm" target="_blank">FAQ</a>. </p>
<!-- #EndLibraryItem --></td>
        </tr>
      </table>        </td>
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
</table><div style="height:4px"><img src="../../images/spacer.gif"></div>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></body>
</html>
