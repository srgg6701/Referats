<?php
session_start();
require('../connect_db.php');
require('lib.php');

if(isset($setparam))
{
  mysql_query("UPDATE ri_zakaz SET data_to='".$eYear."-".$eMonth."-".$eDay."' WHERE number=$setparam");
}

if($command=='change_status')
{
  zakaz_status_transmit(0, $znum, 5);
}

$znum=$S_PASSLOH/12345;

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
$zemail=mysql_result($zk_r,0,'email');
$zuser=mysql_result($zk_r,0,'user');
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.status>=0 AND ri_zakaz.work=ri_works.number AND ri_zakaz.email='$zemail'");
$zk_n=mysql_num_rows($zk_r);

?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<link href="referats.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?>
<iframe name="query" width="0" height="0"></iframe>
<script>
var el=new Array();
el[0]=0;

function month_name(n)
{
  if(n==1){ts='январь';}
  if(n==2){ts='февраль';}
  if(n==3){ts='март';}
  if(n==4){ts='апрель';}
  if(n==5){ts='май';}
  if(n==6){ts='июнь';}
  if(n==7){ts='июль';}
  if(n==8){ts='август';}
  if(n==9){ts='сентябрь';}
  if(n==10){ts='октябрь';}
  if(n==11){ts='ноябрь';}
  if(n==12){ts='декабрь';}
  return(ts);
}

function visual_param(zdata, zdata_to, zuser, zstatus, ztip_s, zpredm_s, zs_r, zname,znum)
{
  d=zdata_to.substring(0,2);
  m=zdata_to.substring(3,5);
  y=zdata_to.substring(6,10);
  ts='Уважаемый <b>'+zuser+',  '+zdata+'</b> Вы заказали работу<br><b>'+zname+'</b> ('+ztip_s+')<br>по предмету '+zpredm_s+'.<br>Работа должна быть готова к '+zdata_to+'.<br><br>Если Вы хотите изменить какие-либо параметры работы, то сообщите об этом администратору.<hr>';
  ts=ts+'Если Вы хотите отправить администратору сообщение относительно данного заказа, то нажмите <input type=button value="Вопрос о заказе" onClick="javascript: location.href=\'ask_admin.php?about='+znum+'&pass=<?php echo($pass);?>\';"><hr>Если Вы хотите задать администратору произвольный вопрос, то нажмите <input type=button value="Произвольный вопрос" onClick="javascript: location.href=\'ask_admin.php?about=0&pass=<?php echo($pass);?>\';">';
  ts=ts+'<input type=hidden name=pass value=<?php echo($pass);?>><input type=hidden name=setparam value='+znum+'>';
  document.getElementById('param_div').innerHTML=ts;
}

function setparam(znum)
{
  query.location.href='get_zakaz_param.php?znum='+znum;
  //window.setTimeout('ifload(0,"visual_param();");', 100);
}

function ifload(n,script)
{
  //alert(n+','+script+' el='+el[n]);
  if(el[n]==1)
  {
    el[n]=0;
	eval(script);
  }
  else
  {
    window.setTimeout('ifload('+n+',"'+script+'");', 100);
  }
}
</script><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
    <td nowrap><h2 style="padding:0px 10px 0px 10px; margin:10px 10px 10px 0px">Привет, <span class="style1"><?php echo($zuser);?></span>.
    Ваши заказы перечислены ниже.</h2></td>
    <td width="100%" align="right"><!-- #BeginLibraryItem "/Library/menu_customer.lbi" --><strong><a href="/index.php" class="arial">Заказать
    новую работу</a>&nbsp;| <a href="/old/user_account.php" class="arial">Мой эккаунт</a> | <a href="/index.php?flag_res=Y" class="arial">Выход <img src="/images/pointer_right_contour.gif" width="13" height="13" border="0" align="absmiddle" style="background-color:ffa933"></a> </strong><!-- #EndLibraryItem --></td>
  </tr>
</table>
<table width="99%" cellpadding="0"  cellspacing="0">
  <form name="form_mess" action="user_account.php" method="post">
    <tr>
      <td align="left"><img src="../images/spacer.gif" width="10" height="10"></td>
      <td width="100%" align="left" valign="top">
        <script>
function zparam(znum)
{
  setparam(znum);
}
        </script>
        <table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
          <tr bgcolor="#CCFFCC" class="arialEncrised">
            <td align="center"><a href="#">ID</a></td>
            <td align="center" nowrap><a href="#">Заявл.</a></td>
            <td nowrap><a href="#">Срок</a></td>
            <td nowrap><a href="#">Тип.</a></td>
            <td nowrap><a href="#">Предмет</a></td>
            <td width="100%" nowrap><a href="#">Тема</a></td>
            <td nowrap><a href="#">Статус</a></td>
            <td colspan="2" nowrap><img src="../images/pyctos/develope.gif" width="18" height="10" hspace="2"><img src="../images/arrows/arrow_sm_up_blue.gif" width="14" height="12"><img src="../images/arrows/arrow_sm_down_green.gif" width="14" height="12"></td>
          </tr>
          <?php
for($i=0;$i<$zk_n;$i++)
{
  $zid=mysql_result($zk_r,$i,'ri_zakaz.number');
  $zdata=mysql_result($zk_r,$i,'ri_zakaz.data');
  $zwork=mysql_result($zk_r,$i,'ri_zakaz.work');
  $zdata_to=mysql_result($zk_r,$i,'ri_zakaz.data_to');
  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
  $zstatus=mysql_result($zk_r,$i,'ri_zakaz.status');
  $ztip=mysql_result($zk_r,$i,'ri_works.tip');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,$i,'ri_works.name');
  $zs_r=mysql_query("SELECT * FROM ri_zakaz_status WHERE number=$zstatus");
  $zstatus_str=mysql_result($zs_r,0,'name');
  echo("<tr bgcolor='#FFFFFF'><td align='center'>$zid</td><td align='center' nowrap>".rustime($zdata)."</td><td nowrap>".rustime($zdata_to)."</td><td nowrap>$ztip_s</td><td nowrap>$zpredm_s</td><td width='100%'><a href='view_work.php?znum=$zid'>$ztema</a></td><td align=center>");
  if($zstatus==4){echo("<a href='user_account.php?pass=$pass&command=change_status&znum=$zid'>Подтвердите получение</a>");}else{echo("$zstatus_str");}
  echo("</td><td bgColor='yellow'><a href='ask_admin.php?pass=$pass&about=$zid' target='_parent' title='Отправить сообщение по этой работе'><span class='red'><b>+</b></span><img src='images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle'></a></td><td nowrap>");
  $ms_r=mysql_query("SELECT * FROM ri_mess WHERE zakaz=$zid AND ((ri_mess.direct=0 AND ri_mess.from_user=1) OR (ri_mess.direct=1 AND ri_mess.to_user=1))");
  $ms_n=mysql_num_rows($ms_r);
  if($ms_n>0){echo("<a href='post_history.php?znum=$zid' title='Просмотреть историю сообщений по этой работе'><img src='images/pyctos/eye.gif' width='18' height='11' border='0'></a>");}
  else{echo("&nbsp;");}
  echo("</td></tr>");
}
?>
        </table></td>
    </tr>
  </form>
</table>
<br>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" nowrap><img src="../images/spacer.gif" width="10" height="10"></td>
    <td nowrap><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>Если Вы хотите отправить администрации проекта сообщение <strong>произвольного характера</strong>, щёлкните&nbsp;&nbsp;&nbsp;</td>
          <td><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td><img src="../images/frames/left_top_orange.gif" width="16" height="16"></td>
                <td rowspan="2"><table cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="2" bgcolor="#FF9900"></td>
                    </tr>
                    <tr>
                      <td height="28" align="center"><strong><a href="javascript:location.href='ask_admin.php?about=0&pass=<?php echo($S_PASSLOH);?>';" style="text-decoration:none;font-family:Arial, Helvetica, sans-serif" title="Отправка сообщения ПРОИЗВОЛЬНОГО характера администрации торговой площадки Referats.info">&nbsp;&nbsp;здесь&nbsp;&nbsp;</a></strong></td>
                    </tr>
                    <tr>
                      <td height="2" bgcolor="#FF9900"></td>
                    </tr>
                </table></td>
                <td><img src="../images/frames/right_top_orange.gif" width="16" height="16"></td>
              </tr>
              <tr>
                <td><img src="../images/frames/left_bottom_orange.gif" width="16" height="16"></td>
                <td><img src="../images/frames/right_bottom_orange.gif" width="16" height="16"></td>
              </tr>
          </table></td>
        </tr>
    </table></td>
    <td rowspan="2" align="center" bgcolor="#FFFFFF"><?php
$us_r=mysql_query("SELECT * FROM ri_user WHERE login='$zemail'");
$us_n=mysql_num_rows($us_r);
if($us_n>0){
  $login=mysql_result($us_r,0,'login');
  $pass=mysql_result($us_r,0,'pass');
?>
        <a href="<?php echo("autorization.php?login=$login&pass=$pass&go_next=autor/index.html"); ?>"><img src="../images/switch.gif" width="54" height="48" hspace="20" border="0" alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты" title="Переключиться на авторский эккаунт"></a>
        <?php }?></td>
  </tr>
  <tr>
    <td>Чтобы отправить сообщение по какой-либо <strong class="style1">конкретной работе</strong>, щёлкните по ссылке &laquo;<strong>Новое</strong>&raquo; в строке с нужной темой.</td>
  </tr>
</table>
<?php
if(isset($setparam))
{
  echo("<script>\nsetparam($setparam)\n</script>");
}
?>
<br><!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
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
