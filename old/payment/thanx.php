<?php
session_start();
require('../../connect_db.php');
require('../lib.php');

//����������� ������
if($fl=='edit')
{
  mysql_query("UPDATE ri_zakaz SET email='$email', phone='$phone', mobila='$mobila', workphone='$workphone', dopphone='$dopphone', icq='$icq' WHERE number=$S_ZAKAZ_NUM");
}

$wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$S_WORK_NUM");
$wname=mysql_result($wk_r,0,'name');
$wtax=mysql_result($wk_r,0,'tax');
$wtip=mysql_result($wk_r,0,'tip');
$wpages=mysql_result($wk_r,0,'pages');
$wpredm=mysql_result($wk_r,0,'predmet');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredm");
$pr_n=mysql_num_rows($pr_r);
if($pr_n>0){$wpredm_s=mysql_result($pr_r,0,'predmet');}
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');

$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE Number=$S_ZAKAZ_NUM");

$zuser=mysql_result($zk_r,0,'user');
$zemail=mysql_result($zk_r,0,'email');
$zphone=mysql_result($zk_r,0,'phone');
$zmobila=mysql_result($zk_r,0,'mobila');
$zdata_to=rustime(mysql_result($zk_r,0,'data_to'));
$zsumm_user=mysql_result($zk_r,0,'summ_user');
$zsumm_our=mysql_result($zk_r,0,'summ_our');
$zworkphone=mysql_result($zk_r,0,'workphone');
$zdopphone=mysql_result($zk_r,0,'dopphone');
$zicq=mysql_result($zk_r,0,'icq');

$passloh=$S_ZAKAZ_NUM*12345;
if($fl!='edit' || !isset($fl))
{
  //��������� ������� ��� ��������������� � ������������� ��������
  if($S_ZAKAZ_NUM+1-1>0)
  {
    $dt=date('Y-m-d');
	if($summ_out<=$summ_user)
	{
	  mysql_query("INSERT INTO ri_shedule( data, kratnost, period, script, remark, enable ) VALUES( '$dt', 0, 24, 'autoreminder_zakaz_pay($S_ZAKAZ_NUM, 5)', '����������� �� ������ Id $S_ZAKAZ_NUM', 'O' )");
    //���������� �������� � ��������� ������ � �������� ������!
	  inmail($zemail, "����������� ������ �� referats.info","������������, $zuser!<br><br>�� �������� �� ����� ����� $wtip_s �� ���� '$wname' ������� $wpages �������.<br>��� ����� ������ ���� ��������� � $zdata_to.<br>��������� ������ $S_ZK_SUMM ���.<br><br>��� ��������� ���������� � ����� �������, �������������� ���������������� ��������� �� ������: <a href='http://referats.info/autors.php?login=$zemail&pass=".($S_ZAKAZ_NUM*12345)."' target='_blank'>http://referats.info/autors.php</a><br>����� �����: $zemail<br>������: ".($S_ZAKAZ_NUM*12345)."<hr>� ���������<br>�������������", "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'REGZK');
	}
	else
	{
	  //���������� �������������� � ������ � ������� �����
	  inmail($admin_mail, "���������� ������ Id_$S_ZAKAZ_NUM", "������������!<br><br>�������� $zuser ������� �� ����� referats.info $wtips �� ���� '$wname' ���������� $summ_our, ������ ��������� �� ���� ������ $summ_our.<hr>� ���������<br>���������", "From: $zemail".chr(13).chr(10).'Reply-To: '.$zemail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'PROBL');
	}
	
	//��������� ������������ (� �����) ������ ����� 3 ��� ����� ����� ���������
	//����� ���� ����������, ���� ���������� � ��� �� �������
	$lastday=mktime(0,0,0,$zdata_to[3].$zdata_to[4], $zdata_to[0].$zdata_to[1], $zdata_to[6].$zdata_to[7].$zdata_to[8].$zdata_to[9]);
	$thisday=mktime(0,0,0,date("m"),date("d"),date("Y"));
    $delhour=round(24*3+($lastday-$thisday)/3600);
	mysql_query("INSERT INTO ri_shedule( data, kratnost, period, script, remark, enable ) VALUES( '$dt', 0, $delhour, 'autodelete_zakaz($S_ZAKAZ_NUM)', '�������� ������������� ������ Id $S_ZAKAZ_NUM', 'O' )");
	mail('esisl@yandex.ru','������� �����! �����!!',"INSERT INTO ri_shedule( data, kratnost, period, script, remark, enable ) VALUES( '$dt', 0, $delhour, 'autodelete_zakaz($S_ZAKAZ_NUM)', '�������� ������������� ������ Id $S_ZAKAZ_NUM', 'O' )<br>","From: $admin_mail".chr(13).chr(10).'Reply-To: '.$email.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  }
}

//��������� �����
mysql_query("UPDATE ri_zakaz SET summ_user='$S_ZK_SUMM', pay_tip='$S_PAY_TIP', status=1 WHERE number=$S_ZAKAZ_NUM");

if($S_PAY_TIP=='bank'){$pay_tip='���������� �������';}
if($S_PAY_TIP=='cards'){$pay_tip='�������� ���������� WebMoney ��� ������.������';}
if($S_PAY_TIP=='cash'){$pay_tip='������������ �������� ';}
if($S_PAY_TIP=='post'){$pay_tip='�������� �������';}
if($S_PAY_TIP=='telegraph'){$pay_tip='����������� �������';}
if($S_PAY_TIP=='wallet'){$pay_tip='������� � ������ WebMoney ��� ������.������';}
if($S_PAY_TIP=='webmoney'){$pay_tip='�������� ����� WebMoney';}
?>
<html>
<head>
<title>����� ������! :)</title>
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
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js">
</script>
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
          <td width="70%" valign="top"><h4 class="style3 header6bottom"><strong><span class="style1"><?php echo($zuser);?></span>, ������� �� �����! </strong></h4>
            <!-- #BeginLibraryItem "/Library/block_order_data.lbi" -->
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
            <h5 class="header6bottom"><strong>�� �������
              ��������� ���������� ������:
            </strong></h5>
            <table width="100%" cellpadding="4"  cellspacing="0" class="solidGray">
              <tr>
                <td width="40%" class="rightTD">��� email: <b><?php echo($zemail);?></b><br>
��� �������� �������: <nobr><b><?php if($zphone==''){echo("�� ������");}else{echo($zphone);}?></b></nobr><br>
��� ������� �������: <nobr><b><?php if($zworkphone==''){echo("�� ������");}else{echo($zworkphone);}?></b></nobr><br>
��� ��������� �������: <nobr><b><?php if($zmobila==''){echo("�� ������");}else{echo($zmobila);}?></b><br></nobr>
��� �������������� �������: <nobr><b><?php if($zdopphone==''){echo("�� ������");}else{echo($zdopphone);}?></b></nobr><br>
��� #ICQ: <nobr><b><?php if($zicq==''){echo(": �� ������");}else{echo($zicq);}?></b></nobr></td>
                <td rowspan="2"><table width="70%" align="center" cellpadding="0"  cellspacing="0">
                  <tr>
                    <td class="header10bottom"><h3 class="header6bottom">��������!</h3>
                        �� ��������� ���� �����
                      �������� ������ � ������ ���������������� �������. </td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B2E6E6">
                      <tr>
                        <td bgcolor="#FFFFFF"><img src="../../images/get_mail.gif" width="51" height="42" hspace="4" vspace="0" border="0" align="absmiddle"></td>
                        <td align="center" background="../../images/bg_author.gif" style="padding:4px"><strong>�������
                            �����, ����������!</strong></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFFF00">��� ��������� ������  �������� <a href="../userdata.php">�����</a>.</td>
              </tr>
            </table>            
                        <p>����� ����� ��������� ����� ����� (<?php 
						if ($srok=='cash'||$srok=='bank') {echo("������ &#8212; � ������� 2-3 ����");}
						if ($srok=='cards') {echo("����������� �����������, ����� �������� �� ������");}
						if ($srok=='post') {echo("������ &#8212; � ������� 2-7 ����");}
						if ($srok=='telegraph') {echo("��� �������, � ������� 1 ���");}
						if ($srok=='webmoney'||$srok=='wallet') {echo("����������� ���������, � ������ ��-����");}
						?>) �� ������
              ���������� ���� ������ �� ��������� �����,			  <strong>� ��� ��
              ����� �������� ���-���������.</strong></p>
            <!-- #BeginLibraryItem "/Library/block_good%20services.lbi" --><h4 class="style3"><img src="../../images/juniors.jpg" width="110" height="110" hspace="20" vspace="0" border="1" align="left" style="border-color:#009900 "><b>�� ���������� �������� ����� ��������! </b></h4>
              <p>������ �� �������� ����� ������������� ������� �� ������ ������
              � ������� <a href="../faq.htm">FAQ</a>.</p>
              <input type="button" name="Button" value="����� � ���� �������" onClick="location.href='../autorization.php<?php echo("?login=$zemail&pass=$passloh");?>'"> 
              <span title="����������/�������� ������� ���������" style="color:#0000FF; text-decoration:underline; font-size: 120%; cursor:hand" onClick="(document.getElementById('accHelp').innerHTML=='')? document.getElementById('accHelp').innerHTML='<table bgColor=yellow cellPadding=4 cellSpacing=0 border=0><tr><td>��� ������� &#8212; ��� ��� ������������ ������, ����������� ��� ������ ���������� ����� �������, � ����� ������������ �������� ����� � ���� � ������ ���������� ����� ������.</td></tr></table>':document.getElementById('accHelp').innerHTML='';">[?]</span><span id="accHelp"></span><!-- #EndLibraryItem --></td>
          <td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00">            <span class="arial">          <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>���� � ��� �������� �������, �� ������ ������� ��������� �� <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=305709350&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">305709350</nobr></a>,
          ���� ��������������� ������ �������� �� ����� �����. ��� ����� �������� <a href="../faq.htm#question_form">�����</a>.
            <p>������ �� �������� ����� ������������� ������� �� ������ �����
          �� �������� <a href="../faq.htm" target="_blank">FAQ</a>. </p></td></tr>
      </table>        
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
    <tr valign="bottom">
      <td height="22" align="center" nowrap class="topDotted">&nbsp;</td>
    </tr>
    <tr valign="bottom">
      <td height="20" align="center" nowrap background="../../images/bankreferatov_bg.gif"><b style="font-weight:100">����
          ���������, ��������, ��������� �����. ������� ������, ������� �� �����,
          ��������</b></td>
    </tr>
  </table>
</body>
</html>
