<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
$wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$S_WORK_NUM");
$wname=mysql_result($wk_r,0,'name');
$wtax=mysql_result($wk_r,0,'tax');
$our_summ=min_tax($wtax);
$wtip=mysql_result($wk_r,0,'tip');
$wpages=mysql_result($wk_r,0,'pages');
$wpredm=mysql_result($wk_r,0,'predmet');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredm");
$pr_n=mysql_num_rows($pr_r);
if($pr_n>0){$wpredm_s=mysql_result($pr_r,0,'predmet');}
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredm");
$pr_n=mysql_num_rows($pr_r);
if($pr_n>0){$wpredm=mysql_result($pr_r,0,'predmet');}

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE Number=$S_ZAKAZ_NUM");
$zuser=mysql_result($zk_r,0,'user');
$zemail=mysql_result($zk_r,0,'email');
$zphone=mysql_result($zk_r,0,'phone');
$zpay_tip=mysql_result($zk_r,0,'pay_tip');
$zmobila=mysql_result($zk_r,0,'mobila');
$zworkphone=mysql_result($zk_r,0,'workphone');
$zdopphone=mysql_result($zk_r,0,'dopphone');

if($zpay_tip=='bank'){$pay_tip='���������� �������';}
if($zpay_tip=='cards'){$pay_tip='�������� ���������� WebMoney ��� ������.������';}
if($zpay_tip=='cash'){$pay_tip='������������ �������� ';}
if($zpay_tip=='post'){$pay_tip='�������� �������';}
if($zpay_tip=='telegraph'){$pay_tip='����������� �������';}
if($zpay_tip=='wallet'){$pay_tip='������� � ������ WebMoney ��� ������.������';}
if($zpay_tip=='webmoney'){$pay_tip='�������� ����� WebMoney';}

if($fl=='send_mess')
{
  $S_ZK_SUMM=$last_summ;
  $letter="������������!<br><br>�������� $zuser �� ����� ������� �� ������ id $S_ZAKAZ_NUM $our_summ ������, � ���������� $last_summ ������. ������� ���� �������� ������: $Day/$Month/$Year.<hr>��������� ��������� ������:<br>$mess.";
  //echo("$letter<br>");
  send_intro_mess(0, 1, $zemail, "���������� ����� id $S_ZAKAZ_NUM", $letter, $S_ZAKAZ_NUM);
  inmail($admin_mail, "���������� ����� id $S_ZAKAZ_NUM",$letter, "From: $zemail".chr(13).chr(10).'Reply-To: '.$zemail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'O_TAX');
  mysql_query("UPDATE ri_zakaz SET summ_user='$last_summ', pay_tip='$zpay_tip', status=1, summ_our='$our_summ' WHERE number=$S_ZAKAZ_NUM");
  //autoreminder_zakaz_pay($S_ZAKAZ_NUM, 5)
  //���� �������� �� ��������� �����������
  mysql_query("DELETE FROM ri_shedule WHERE script='autoreminder_zakaz_pay($S_ZAKAZ_NUM, 5)'");
  header("location: $zpay_tip.php?summ=$S_ZK_SUMM");
}
?>
<html>
<head>
<title>���������� ������ ������� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="../referats.css" rel="stylesheet" type="text/css"><style type="text/css">
<!--
.style1 {color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../../wctable.js"></script>
</head>
<body onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')">
<form action="other_tax.php" method="post" name="form_tax" onSubmit="if (isNaN(this.last_summ.value)) {alert ('���� ��� ��������� ������ �� ������ ��������� ������, ����� ����!'); this.last_summ.focus(); this.last_summ.style.backgroundColor='yellow'; return false} else return true;"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../../index.php"><img src="../../images/referatsinfo2.gif" 
alt="���� ���������, ��������, ��������� �����." title="�������� �������� Referats.info" 
width="261"  height="38" 
hspace="12" vspace="0" border="0"></a><h1 
class="graphixHeader2"><a href="../../index.php" 
class="nodecorate" style="background-color:">���� ���������, �������� � �������</a><img 
alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" title="" src="../../images/referat_bank.gif" 
width="55" height="16" 
border="0" align="absmiddle"></h1>
<div style="position:absolute; top:0px; left:390" id="navMenus">
  <table width="100%" height="54" align="right" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="65%" valign="top"><table height="42" border="0" align="center" cellspacing="0">
          <tr>
            <td nowrap class="red">������� �����<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="6" border="1" align="absmiddle">&nbsp;&nbsp;</td>
            <td height="38" align="center" nowrap><a href="../autors.php" onMouseOver="MM_swapImage('pyctAccount','','../../images/pyctos/account2_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/account2.gif" alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" name="pyctAccount" width="40" height="40" hspace="1" border="0" id="pyctAccount" title="��� ������������ ������ [�������]
			                       ���� / �����������"></a></td>
            <td height="38" align="center" nowrap><a href="../cooperation.htm" onMouseOver="MM_swapImage('pyctCooperation','','../../images/pyctos/cooperation_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/cooperation.gif" alt="��������������" name="pyctCooperation" width="40" height="40" hspace="1" border="0" id="pyctCooperation"></a></td>
            <td height="38" align="center" nowrap><a href="../faq.htm" onMouseOver="MM_swapImage('pyctFaq','','../../images/pyctos/faq_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/faq.gif" alt="FAQ [����� ���������� �������]" name="pyctFaq" width="40" height="40" hspace="1" border="0" id="pyctFaq"></a></td>
            <td height="38" align="center" nowrap><a href="../agreement.htm" onMouseOver="MM_swapImage('pyctAgreement','','../../images/pyctos/agreement_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/agreement.gif" alt="���������������� ����������" name="pyctAgreement" width="40" height="40" hspace="1" border="0" id="pyctAgreement"></a></td>
            <td height="38" align="center" nowrap><a href="../useful.htm" onMouseOver="MM_swapImage('pyctUseful','','../../images/pyctos/useful_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/useful.gif" alt="��������" name="pyctUseful" width="40" height="40" hspace="1" border="0" id="pyctUseful"></a></td>
            <td align="center" nowrap><a href="../feedback.php" onMouseOver="MM_swapImage('pyctFeedback','','../../images/pyctos/feedback_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../../images/pyctos/feedback.gif" alt="�������� �����" name="pyctFeedback" width="40" height="40" hspace="1" border="0" id="pyctFeedback"></a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<script language="JavaScript" type="text/JavaScript">
(screen.width<=800)? document.getElementById('navMenus').style.left=380:document.getElementById('navMenus').style.left=485;
//���������� ������ ����� ���� � ������������� ����
</script><!-- #EndLibraryItem --><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="border-bottom:dotted 1px #ff0000"><img src="../../images/spacer.gif" width="6" height="6"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td width="70%" valign="top"><!-- #BeginLibraryItem "/Library/block_order_data.lbi" -->
          <p class="header6bottom"><b>���� ������:</b> </p>
          <table width="100%" cellpadding="3"  cellspacing="1" bgcolor="#CC0000">
            <tr>
              <td colspan="2" background="../../images/pyctos-bg-4.gif"><font size="+1"><?php echo($wname);?></font></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">���
                  ������&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
              <td width="100%"><b><?php echo($wtip_s);?></b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">�������&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
              <td><b><?php echo($wpredm);?></b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap bgcolor="#F5F5F5"><span class="header10bottom">�����&nbsp;<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle"></span></td>
              <td><b><?php echo($wpages);?> ������</b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td colspan="2" nowrap bgcolor="#F5F5F5"><span onClick="sh_content('tr_content');" style="text-decoration:underline; color:#0000FF; cursor:hand">����������
                  ���������� ������</span></td>
            </tr>
            <tr bgcolor="#F5F5F5" id="tr_content" style="display:none">
              <td colspan="2" style="padding:10px"><b>���������� ������:</b>
                  <hr size="1" noshade>
                  <?php echo($wannot); ?></td>
            </tr>
          </table>
          <h2>���������� ���� �����: <strong><?php echo($summ);?></strong> ���. </h2>
          <!-- #EndLibraryItem -->
            <p class="header6bottom"><b></b></p>
		    <h5><span class="style1"><?php echo($zuser);?></span>, ����������, �������
		      �����, ������� �� ������ ��������� �� ��� ������:
                <input name="last_summ" type="text" value="<?php echo($our_summ);?>" size="4" onBlur="this.style.backgroundColor='';">
  �. </h5>
		    ������� <span class="style1">�������</span> ���� ��������� ���� ������ <br>
  (<strong>��������!</strong> ������������ ���� ����� ����������� ����������
  �������, ������ &#8212; 1-2 ���).:<br>            <?php
$bDay=date('d')+3;
$bMonth=date('m');
if($bDay>31){$bMonth++;$bDay=$bDay-31;}
$bYear=date('Y');
if($bMonth>12){$bYear++;$bMonth=$bMonth-12;}
?>
		    <p>              <select name="Day">
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
            </p>
		    <hr size="1" noshade>
		    <h3 class="header6bottom">���� �� ������ ������� ������ �������������� ���������, �� �������
            ��� �����:</h3>
	      <br>            <textarea name="mess" rows="5" id="mess" style="width:100%"></textarea>            <input name="Submit" type="submit" class="topPad6" value="��������� �����������">            <input name="fl" type="hidden" id="fl" value="send_mess">            <span class="style1"></span> </td><td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial"> <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>���� � ��� �������� �������, �� ������ ������� ��������� �� <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=305709350&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">305709350</nobr></a>,
            ���� ��������������� ������ �������� �� ����� �����. ��� ����� �������� <a href="../faq.htm#question_form">�����</a>.
              <p>������ �� �������� ����� ������������� ������� �� ������ �����
                �� �������� <a href="../faq.htm" target="_blank">FAQ</a>. </p></td>
    </tr>
  </table>
  <!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
    <tr>
      <td height="24" align="center" nowrap class="topDotted" style="padding-top:2px"><a href="/index.php">�������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><b><a href="/old/autors.php" class="myAccount">��� ������ </a></b></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/cooperation.htm">��������������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/faq.htm">FAQ</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/agreement.htm">����������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/useful.htm">��������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/feedback.php">�������� �����</a> </td>
  </tr>
    <tr valign="bottom">
      <td height="20" colspan="7" align="center" nowrap background="/images/bankreferatov_bg.gif"><b style="font-weight:100">����
          ���������, ��������, ��������� �����. ������� ������, ������� �� �����,
      ��������</b></td>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></form>
</body>
</html>
