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

if($fl=='NO' || $fl=='YES')
{
  if($fl=='NO')
  {
    //���������� �� ������, ������� ��� � ������� � �������, ���� ��� ����������, �� �� ������� ��������
	mysql_query("DELETE FROM ri_zakaz WHERE number=$S_ZAKAZ_NUM");
	$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE email='$zemail'");
	$zk_n=mysql_num_rows($zk_r);
	if($zk_n>0)
	{
	  $S_PASSLOH=mysql_result($zk_r,0,'number')*12345;
      header("location: ../user_account.php");
	}
	else
	{
	  header("location: ../index.php");
	}
  }
  if($fl=='YES')
  {
    //������� ����� �� ����������� ����
	$S_ZK_SUMM=$our_summ;
    mysql_query("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$zpay_tip', status=1, summ_our='$wtax' WHERE number=$S_ZAKAZ_NUM");
    //echo("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$zpay_tip', status=1, summ_our='$wtax' WHERE number=$S_ZAKAZ_NUM<br>");
	header("location: $zpay_tip.php?summ=$S_ZK_SUMM");
  }
  if(trim($zpay_tip)!=''){$pay_tip=$zpay_tip;}
}
else
{
  //��������� �����
  $S_PAY_TIP=$pay_tip;
  $S_ZK_SUMM=$summ;
  mysql_query("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$pay_tip', status=1, summ_our='$wtax' WHERE number=$S_ZAKAZ_NUM");
  //echo("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$pay_tip', status=1, summ_our='$wtax' WHERE number=$S_ZAKAZ_NUM<br>");
  
}

if($pay_tip=='bank'){$pay_tip='���������� �������';}
if($pay_tip=='cards'){$pay_tip='�������� ���������� WebMoney ��� ������.������';}
if($pay_tip=='cash'){$pay_tip='������������ �������� ';}
if($pay_tip=='post'){$pay_tip='�������� �������';}
if($pay_tip=='telegraph'){$pay_tip='����������� �������';}
if($pay_tip=='wallet'){$pay_tip='������� � ������ WebMoney ��� ������.������';}
if($pay_tip=='webmoney'){$pay_tip='�������� ����� WebMoney';}
?>
<html>
<head>
<title>��������� ������</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<link href="../referats.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {	color: #FF0000;
	font-weight: bold;
}
.style3 {color: #009900;}
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../../wctable.js"></script>
</head>
<body bgcolor="#FFFFFF" topmargin="0" marginheight="0" lang=RU onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif','../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../../index.php"><img src="../../images/referatsinfo2.gif" 
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
            <h5 class="style3 header10bottom"><span class="style1"><?php echo($zuser);?></span>,
    � ���������, ��������� ���� ����� ������ ���������� ����������, ������� ��
    ���� ������ ���������� <?php echo($our_summ);?> �. </h5>
              <h1 style="padding:0px; margin-top:0px">�������� 1 �� 3-� ���������� ��������:</h1>
              <table width="100%" cellpadding="4"  cellspacing="2" style=" border:solid 1px #cccccc">
                <tr valign="top">
                  <td colspan="2" bgcolor="#F5F5F5" class="arial" style="color:#FF6600;font-size:90%;font-weight:600">1.
                  ����������� � ������� ����� � <nobr><?php echo($our_summ);?> ���.</nobr></td>
                  <td colspan="2" bgcolor="#E4E4E4" class="arial" style="color:#cc0000;font-size:90%;font-weight:600">2.
                  ���������� ������ ������� ���� </td>
                  <td colspan="2" bgcolor="#CCCCCC" class="arial" style="font-size:90%;font-weight:600">3. ���������� �� ������ </td>
                </tr>
                <tr valign="top">
                  <td align="right" bgcolor="#F5F5F5" style="padding:1px 1px 0px 10px"><img src="../../images/man-order.gif" width="119" height="135" vspace="0" style="border:solid 1px #999999"></td>
                  <td>� ���� ������ �� <span class="style1"><strong>����������� ���</strong></span> �������� ������ ����� �
                    ��������� ���� ����! </td>
                  <td align="right" bgcolor="#E4E4E4" style="padding:1px 1px 0px 10px"><img src="../../images/man-question.gif" width="84" height="98" vspace="0" style="border:solid 1px #999999"></td>
                  <td>�� ������ ������� ������ ����������� ������� ���� ����. ������
                    ������������� ����� �� ��� �� �����. </td>
                  <td align="right" bgcolor="#CCCCCC" style="padding:1px 1px 0px 10px"><img src="../../images/headache_big.jpg" width="67" height="98" vspace="0"></td>
                  <td><span class="red">�� �� ������� �������� ���
                      ������</span> � ��� ���������� ����-��
                    �������...</td>
                </tr>
                <tr valign="top">
                  <td colspan="2" style="padding:0px"><input type="button" name="Button" value="�����������!" onClick="location.href='sorry.php?fl=YES';"></td>
                  <td colspan="2" style="padding:0px"><input type="button" name="Button" value="������������ ����" onClick="location.href='other_tax.php'"></td><!-- window.open('other_tax.php','new_price','status=yes,scrollbars=yes,resizable=yes,width=650,height=400'); -->
                  <td colspan="2" style="padding:0px"><input type="button" name="Button" value="����� �� ������" onClick="location.href='sorry.php?fl=NO';"></td>
                </tr>
              </table>            
          </td><td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial">            <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>���� � ��� �������� �������, �� ������ ������� ��������� �� <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=305709350&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">305709350</nobr></a>,
            ���� ��������������� ������ �������� �� ����� �����. ��� ����� �������� <a href="../faq.htm#question_form">�����</a>. 
            <p>������ �� �������� ����� ������������� ������� �� ������ �����
          �� �������� <a href="../faq.htm" target="_blank">FAQ</a>. </p></td>
        </tr>
      </table>        
      </td>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></body>
</html>