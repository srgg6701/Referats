<?php
session_start();
require('../connect_db.php');
require('lib.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($fl=='new_search')
{
  //echo("make_find($referat_subj, \"WHERE ri_works.enable='Y'\");");
  if($find_type=='subj' || !isset($find_type))
  {make_find($referat_subj, "WHERE ri_works.enable='Y'");}
  else
  {make_find_by_id($referat_subj);}
}
$sid=session_id();
$where=' AND ( ri_works.tip=0';
if($diplom=='on'){$where=$where." OR ri_works.tip=3";}
if($curs=='on'){$where=$where." OR ri_works.tip=2";}
if($referat=='on'){$where=$where." OR ri_works.tip=1";}
if($other=='on'){$where=$where." OR ri_works.tip>3";}
$where=$where." )";

$sc_r=mysql_query("SELECT * FROM ri_rating, ri_works WHERE ri_rating.work=ri_works.number AND ri_rating.sessionid='$sid' $where ORDER BY ri_rating.wordindex DESC, ri_works.name");
$sc_n=mysql_num_rows($sc_r);
?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="referats.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
</head>
<body onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
</script><!-- #EndLibraryItem --><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--; border-top:solid 3px #ff0000-->
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
<td style="padding: 10px"><h1 class="header6bottom"><b>Результат поиска работы:</b></h1>
      <table width="100%" cellpadding="4"  cellspacing="1" bgcolor="#CC0000">
      <tr class="arial">
        <td height="26" background="../images/pyctos-bg-1.gif"><b>Тип</b></td>
        <td background="../images/pyctos-bg-1.gif"><b>Предмет</b></td>
        <td width="100%" background="../images/pyctos-bg-1.gif"><b>Тема</b></td>
      </tr>
      <?php
for($i=0;$i<$sc_n;$i++)
{
  $wnum=mysql_result($sc_r,$i,'ri_works.number');
  $wname=mysql_result($sc_r,$i,'ri_works.name');
  $wpredmet=mysql_result($sc_r,$i,'ri_works.predmet');
  $wtip=mysql_result($sc_r,$i,'ri_works.tip');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredmet");
  $str_predmet=mysql_result($pr_r,0,'predmet');
  $tp_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $str_tip=mysql_result($tp_r,0,'tip');
  echo("<tr bgcolor=#FFFFFF>
    <td nowrap>$str_tip</td>
    <td nowrap>$str_predmet</td>
    <td><a href='content.php?wnum=$wnum'>$wname</a></td>
	</tr>");
}
?>
    </table>
      <form action="search_list.php" method="post" name="search_form" style="padding-top:0; margin-top:10px">
        <b>Новый поиск:</b>        
        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td nowrap><strong>
              <input name="diplom" type="checkbox" id="diplom" value="on" checked>
        Диплом</strong></td>
            <td nowrap><strong>
              <input name="curs" type="checkbox" id="curs" value="on" checked>
        Курсовая</strong></td>
            <td nowrap><strong>
              <input name="referat" type="checkbox" id="referat" value="on" checked>
        Реферат</strong></td>
            <td nowrap><input name="other" type="checkbox" id="other" value="on" checked>
        Другое
          <input name="fl" type="hidden" id="fl" value="new_search"></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%"><input name="referat_subj" type="text" class="cells" id="referat_subj2" style="width:100%"></td>
            <td align="center"><input type="submit" name="Submit" value="Найти!">
                <!-- onClick="sendOrder('реферат','referat_subj');"> -->
            </td>
          </tr>
        </table>
    </form>
      Если вы не нашли интересующую вас работу, вы можете <a href="http://www.diplom.com.ru/order.php">получить
      её, заказав нашим исполнителям <strong><a href="cooperation.htm"><img src="../images/pointer_right_contour.gif" width="13" height="13" border="0" align="middle" style="background-color: #FFa933"></a></td>
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
