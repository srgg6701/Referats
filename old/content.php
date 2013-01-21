<?php
session_start();
require('../connect_db.php');
require('lib.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
$S_WORK_NUM=$wnum;
$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet WHERE ri_works.predmet=diplom_predmet.number AND ri_works.number=$wnum");
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
<TITLE>рефераты дипломные работы купить диплом на заказ рефераты</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<!-- дипломные работы купить диплом -->
<meta name="keywords" content="дипломные работы купить диплом на заказ; экономика; выполнение рефератов; педагогика; написание диплома; биология; заказ курсовой работы; политология; написание диплома на заказ; государственное регулирование; помощь в сдаче сессии; пищевые продукты; рефераты и курсовые работы; промышленность и производство; коллекция рефератов; социология; курсовая работа на заказ; дипломная работа; банк рефератов; коллекция рефератов; реферат бесплатно; написание диссертации; ОБЖ; география; экономическая география; радиоэлектроника; законодательство и право; иностранные языки; литература; социология; физика; химия; программирование; философия; экономика и финансы; охрана природы; экология">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../go_url.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkCells ()  {
if (document.forms[0].elements['name'].value) 
	{
	document.forms[0].email.style.backgroundColor='yellow';
	return emailCheckReferats (document.forms[0].email);
	}
else {alert ('Вы не сообщили нам, как к вам обращаться!'); document.forms[0].elements['name'].style.backgroundColor='yellow'; document.forms[0].elements['name'].focus(); return false;}
}
</script>

<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
    <td style="border-bottom:dotted 1px #ff0000"><a name="work_title"><img src="../images/spacer.gif" width="6" height="6"></a></td>
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
        <tr bgcolor="#F5F5F5">
          <td colspan="2" style="padding:10px"><b>Содержание работы:</b>
              <hr size="1" noshade>
          <?php echo($wannot); ?></td>
        </tr>
      </table>
      <p><b>Если вас заинтересовала эта работа, введите свои данные ниже и щёлкните
            по кнопке &laquo;Заказать!&raquo;. </b>
	  </p>
      <table width="100%"  cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" background="../images/frames/left_orange.gif"><img src="../images/frames/left_top_orange.gif" width="16" height="16"></td>
          <td width="100%" rowspan="3"><table width="100%"  cellspacing="0" cellpadding="0">
              <tr>
                <td style="height:1%" bgcolor="#FF9900"><img src="../images/spacer.gif" width="2" height="2"></td>
              </tr>
              <tr>
                <td style="padding:10px 0px 10px 0px"><h4 class="header6bottom"><font color="#009900"><b><img src="../images/i_gradient.gif" width="22" height="22" hspace="4" align="absmiddle">После оформления заказа
                    вы сможете:</b></font></h4>
                  <ol>
                    <li><b>Поддерживать обратную связь с автором работы и получать
                        любую информацию по ней.</b></li>
                    <li><b>При необходимости &#8212; заказать её доработку до
                        уровня уникальной.</b></li>
                    <li><b>Просматривать историю переписки по данному заказу
                        в своём аккаунте (персональном разделе заказчика).</b></li>
                </ol></td>
              </tr>
              <tr>
                <td bgcolor="#FF9900"><img src="../images/spacer.gif" width="2" height="2"></td>
              </tr>
          </table></td>
          <td valign="top" background="../images/frames/right_orange.gif"><img src="../images/frames/right_top_orange.gif" width="16" height="16"></td>
        </tr>
        <tr>
          <td background="../images/frames/left_orange.gif" style="height:98%">&nbsp;</td>
          <td background="../images/frames/right_orange.gif">&nbsp;</td>
        </tr>
        <tr>
          <td valign="bottom" background="../images/frames/left_orange.gif"><img src="../images/frames/left_bottom_orange.gif" width="16" height="16"></td>
          <td valign="bottom" background="../images/frames/right_orange.gif"><img src="../images/frames/right_bottom_orange.gif" width="16" height="16"></td>
        </tr>
      </table>      
        <p><b><font color="#FF0000">ВНИМАНИЕ!</font></b></p>
        <form action="payment.php" method="post" onSubmit="return checkCells ();" style="padding-top:0px; margin-top:0px"><p>                  
  <?php
if(isset($S_PASSLOH))
{
  $znum=$S_PASSLOH/12345;
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0)
  {
    $zemail=mysql_result($zk_r,0,'email');
    $zuser=mysql_result($zk_r,0,'user');
    $zphone=mysql_result($zk_r,0,'phone');
    $zmobila=mysql_result($zk_r,0,'mobila');
    $zworkphone=mysql_result($zk_r,0,'workphone');
    $zdopphone=mysql_result($zk_r,0,'dopphone');
    $zicq=mysql_result($zk_r,0,'icq');
    echo ('Пожалуйста, проверьте свои регистрационные данные, указанные ниже. Если они верны, укажите крайний срок получения работы и щёлкните по кнопке "Заказать!"');
  }
  else {echo ("Мы настоятельно рекомендуем вам указать свои контактные телефоны, в т.ч. &#8212; мобильный, что позволит нам отсылать вам СМС по поводу ваших заказов.");}
}
else {echo ("Мы настоятельно рекомендуем вам указать свои контактные телефоны, в т.ч. &#8212; мобильный, что позволит нам отсылать вам СМС по поводу ваших заказов.");}
?></p>
                    <table width="100%" cellpadding="4"  cellspacing="0" class="rightTD">
                      <tr>
                        <td width="50%"> <strong>Ваш email:</strong>                        <input name="email" type="text" id="email" style="width:100%" value="<?php echo($zemail);?>"></td>
                        <td><img src="../images/spacer.gif" width="6" height="4"></td>
                        <td width="50%"><strong>Как к вам обращаться</strong> (ФИО и т.п.):
                          <input name="name" type="text" id="name" style="width:100%" onBlur="if (this.value) this.style.backgroundColor='';" value="<?php echo($zuser);?>"></td>
                      </tr>
                      <tr>
                        <td colspan="3"><table width="100%"  cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="25" colspan="7" nowrap><strong>Ваши контактные телефоны:</strong></td>
                          </tr>
                          <tr valign="bottom">
                            <td width="25%" nowrap><span class="arial">    Домашний:<br>
                            <input name="phone" type="text" id="phone" style="width:100%" value="<?php echo($zphone);?>">
                            </span></td>
                            <td><img src="../images/spacer.gif" width="10" height="10"></td>
                            <td width="25%"><span class="arial">Рабочий:<br>
                            <input name="workphone" type="text" id="workphone" style="width:100%" value="<?php echo($zworkphone);?>">
                            </span></td>
                            <td><img src="../images/spacer.gif" width="10" height="10"></td>
                            <td width="25%" nowrap><span class="arial">Мобильный телефон:<br>
                            <input name="mobila" type="text" id="mobila" style="width:100%" value="<?php echo($zmobila);?>">
                            </span></td>
                            <td><img src="../images/spacer.gif" width="10" height="10"></td>
                            <td width="25%" nowrap><span class="arial">Дополнительный:<br>
                            <input name="dopphone" type="text" id="dopphone" style="width:100%" value="<?php echo($zdopphone);?>">
                            </span></td>
                          </tr>
                          <tr valign="bottom">
                            <td colspan="7" nowrap><span class="arial"><strong># ICQ:</strong>                              
                              <input name="icq" type="text" id="icq" value="<?php echo($zicq);?>" size="9">
                            </span></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
      <?php
$bDay=date('d')+3;
$bMonth=date('m');
if($bDay>31){$bMonth++;$bDay=$bDay-31;}
$bYear=date('Y');
if($bMonth>12){$bYear++;$bMonth=$bMonth-12;}
?>
                    Крайний срок получения работы:
                    <select name="Day">
      <?php
for($i=1;$i<32;$i++)
{
  echo("<option value=$i");
  if($i==$bDay){echo(" selected");}
  echo(">$i</option>");
}
?>
                    </select>
                    <select name="Month">
      <?php
for($i=1;$i<13;$i++)
{
  echo("<option value=$i");
  if($i==$bMonth){echo(" selected");}
  echo(">".rus_month($i)."</option>");
}
?>
                    </select>
                    <select name="Year">
      <?php
for($i=2004;$i<2010;$i++)
{
  echo("<option value=$i");
  if($i==$bYear){echo(" selected");}
  echo(">$i</option>");
}
?>
                    </select>
                      <br>
                      <br>
                      <input type="submit" name="Submit" value="Заказать!">
        </form>
      <hr size="1" noshade color="#FF9900">    
      <div class="topPad6 header6bottom"><strong>Если вы не нашли нужную вам работу, укажите её тему здесь:</strong></div>
          <input name="referat_subj" type="text" class="cells" id="referat_subj2" style="width:100%">    
          <input name="Button" type="button" class="topPad6" onClick="sendOrder2('referat_subj');" value="Получить!">    
    </td>
    <td width="30%" valign="top" style="border-left:dotted 1px #ffcc00"><!-- #BeginLibraryItem "/Library/block_topic_chapters.lbi" --><form action="/old/search_list.php" method="post" name="search_form" style=" padding-bottom:0px; margin-bottom:0px"><table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#E4E4E4">
      <tr>
        <td colspan="2">Быстрый поиск:
          <b><nobr>введите тему работы</nobr></b>          <input name="referat_subj" type="text" class="cells" id="referat_subj" style="width:100%">          </td>
  </tr>
      <tr>
        <td rowspan="2"><a name="wtypes"></a>
          <input name="diplom" type="checkbox" id="diplom" value="on" checked>
  Диплом<br>
  <input name="curs" type="checkbox" id="curs" value="on" checked>
  Курсовая<br>
  <input name="referat" type="checkbox" id="referat" value="on" checked>
  Реферат<br>
  <input name="other" type="checkbox" id="other" value="on" checked> 
  Другое </td><td align="center"><!-- <input type="button" name="Submit" value="Найти!" onClick="sendOrder('реферат','referat_subj');">   --><input type="submit" name="Submit" value="Найти!">          </td>
      </tr>
      <tr>
        <td align="center"><span title="Развернуть/свернуть быструю подсказку" style="color:#0000FF; text-decoration:underline; font-size: 120%; cursor:hand" onClick="(document.getElementById('accHelp').innerHTML=='')? document.getElementById('accHelp').innerHTML='<table  bgColor=#FFFF00 width=100% cellPadding=4 cellSpacing=0><tr><td><ol><li>Если вы хотите найти работу какого-то конкретного типа (диплом/курсовая/реферат/другое), отметьте галочкой соответствующий пункт (см. <a href=#wtypes>вверху</a>).</li> <li>Если вы хотите сузить область поиска не только типом работы, но и предметом (предметами), отметьте галочкой соответствующую строку (строки) в <a href=#wchapters>списке (каталоге) предметов ниже;</a> щелчок по названию предмета просто перенесёт вас в соответствующий раздел. </li> </ol> <p>Например: если вы отметите галочкой тип работы &laquo;<b>Диплом</b>&raquo; и предметы &laquo;<b>География, Экономическая география</b>&raquo; и &laquo;<b>Геодезия, геология</b>&raquo;, то наша система, соответственно, будет искать для вас только дипломы по этим предметам. По умолчению, она ищет среди всех предметов и всех типов работ (всё отмечено галочками).</p> <p>Если вы просто щёлкните по предмету &laquo;География, Экономическая география&raquo;, попадёте в список тем по данному (как и любому другому) предмету. </p></td></tr></table>':document.getElementById('accHelp').innerHTML='';">[?]</span></td>
      </tr>
    </table><span id="accHelp"></span></form>
      <span class="arial"><img src="/images/arrows/inbox.gif" width="31" height="26" vspace="6" align="absmiddle" style="border:solid 1px #00ae00; padding-right: 4px; margin-right:4px">Отметьте галочкой раздел для поиска: </span>
      <div class="arial" style="padding-left:2px"><a name="wchapters"></a>

  <?php
/*$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY sort, predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<input name='checkbox$pnum' type='checkbox' value='on' checked><a href='../worx.php?pnum=$pnum'>$ppredmet</a><br>\n");
}*/
?><script language="JavaScript" type="text/JavaScript" src="/create_topix.js">
</script>
</div>
<!-- #EndLibraryItem --></td>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></body>
</html>
