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
<title>������ ���������� ���������� WebMoney ��� ������.������</title>
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
<h2>���������� ���� �����: <strong><?php echo($summ);?></strong> ���.              </h2>
<!-- #EndLibraryItem --><h5 class="header10bottom"><span style="font-weight:200">
			  ��������� ������ ������:</span> �������� ���������� WebMoney ��� ������.������</h5>
			  <p>��� ����������: </p>
              <p>���������� WM ��� ������.������ �����(�) (��� ���������� &#8212; ��.
                � ������ ����� ��������) � ��������� �� <img src="../../images/mail_payment.gif" align="absbottom"> (����
                �������� ��� �� �������� (88634)38-35-28) ��������� ����������:</p>
              <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
                <tr align="center">
                  <td bgcolor="whitesmoke"><b>��� WM-����:</b></td>
                  <td bgcolor="whitesmoke"><b>��� ������.������-����:</b></td>
                </tr>
                <tr>
                  <td valign="top"><ol>
                      <li>����� ����� � PIN (��� �����������);</li>
                      <li> ����� ������;</li>
                      <li>������� � ���� ������</li>
                      </ol></td>
                  <td valign="top"><ol>
                      <li>����� �����;</li>
                      <li> ����� �������;</li>
                      <li>������ (����� ������� ���, � ���� ����� ������� ��������
                        ��������)</li>
                      <li>��� �������� (� ���� ����� ����� ������� �������� ��������)</li>
                      <li>������� � ���� ������</li>
                      </ol></td>
                </tr>
              </table>
              <br>
              <H4 class="leftHeader">��������� � ������ ���������� WebMoney �
                ������.������:</H4>
				<hr size="1" noshade>			<H4>WM-�����</H4>
				<P>�&nbsp;������ ������ �&nbsp;������� WebMoney Transfer ������������
                  ������������� <NOBR>WM-�����</NOBR> ���� �����: WMZ,&nbsp;WMR
                  � WMU.</P>            <P><NOBR>WMZ-�����</NOBR> ����� �������� 10, 20, 50 �&nbsp;100&nbsp;WMZ
                  (����������&nbsp;USD). ��� ������������ ���������� <NOBR>Z-���������</NOBR> ����������
                  �������, �&nbsp;����� ������������ �&nbsp;�������� ��������
                  ����� <NOBR>WMZ-����</NOBR> ���&nbsp;�������� �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>
				  <P><IMG title="WMZ-�����, ������� �������" height=175 
                  src="../../images/cards/card_faces.jpg" width=350><IMG 
                  title="WMZ-�����, �������� �������" height=135 
                  src="../../images/cards/card_backz.gif" width=210></P>            <P><NOBR>WMR-�����</NOBR> ����� �������� 500, 1000, 3000 �&nbsp;5000&nbsp;WMR
                  (����������&nbsp;RUR). ��� ������������ ���������� <NOBR>R-���������</NOBR> ����������
                  �������, �&nbsp;����� ������������ �&nbsp;�������� ��������
                  ����� <NOBR>WMR-����</NOBR> ���&nbsp;�������� �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>            <P><IMG title="WMR-�����, ������� �������" height=175 
                  src="../../images/cards/card_facer.jpg" width=350><IMG 
                  title="WMR-�����, �������� �������" height=135 
                  src="../../images/cards/card_backr.gif" width=210></P>            <P><NOBR>WMU-�����</NOBR> ����� �������� 50, 100, 200 � 500 WMU
                  (���������� UAH). ��� ������������ ���������� <NOBR>U-���������</NOBR> ����������
                  �������, �&nbsp;����� ������������ �&nbsp;�������� ��������
                  ����� <NOBR>WMU-����</NOBR> ���&nbsp;�������� �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>            <P><IMG title="WMU-�����, ������� �������" height=193 
                  src="../../images/cards/card_faceu.jpg" width=371><IMG 
                  title="WMU-�����, �������� �������" height=146 
                  src="../../images/cards/card_backu.gif" width=210></P>            
                  <hr size="1" noshade>                  <p><b>������.������-�����:</b> </p>            
                  <p>����������� ��������� 500, 1000, 3000 � 10000 ������. </p>
              <table border="0" cellpadding="4" cellspacing="0">
                <tr align="center" bgcolor="#f5f5f5">
                  <td>������� 500 �.</td>
                  <td>������� 1000 �.</td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td><img src="../../images/cards/card500m.jpg" width="150" height="100" vspace="4"></td>
                  <td><img src="../../images/cards/card1000m.jpg" width="151" height="100" vspace="4"></td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td bgcolor="#f5f5f5">������� 3000 �.</td>
                  <td bgcolor="#f5f5f5">������� 10000 �.</td>
                </tr>
                <tr align="center" bgcolor="#FFFFFF">
                  <td><img src="../../images/cards/card3000m.jpg" width="158" height="100" vspace="4"></td>
                  <td><img src="../../images/cards/card10000m.jpg" width="151" height="100" vspace="4"></td>
                </tr>
              </table>
              <p><br>
  �� ��������� &laquo;������.�����&raquo; ������� ����� �������, ����� � ������.
  ��� ������ ���� ����� &#8212; ����������� � �����������. ����������� �������� &laquo;������.������&raquo; ����������
  �� ����������� �������� &laquo;������.������&raquo; ������ �������� ������������
  �������� � �������� ������-�����. </p>
              <p>����������� �������� "������.������" ����� ������ � ������,
                ����������, ��������-���������, ������� ���������� ��������-��������
                � ��. </p>
              <P>����������� �������� "������.������" ����� ������ � ����������,
                ��������� ����������, ������� �����, ������� �����, ��������-���������,
                � ��.</P>
                        <input type="button" name="Button" value="�����������!" onClick="location.href='thanx.php?srok=cards'">
</td><td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><h5 class="header10bottom">���
              ����� ���������� �������� ���������� <a href="#wm">WebMoney</a> ��� <a href="#ya">������.������</a>:</h5>            
            <span class="arial"><b><a name="wm"></a>����� ���������� WebMoney</b><a 
                  name=1></a>
            </span>            <A 
                  name=1>&nbsp;</A>            <P>���������� <NOBR>WM-�����</NOBR> �� ������ �&nbsp;�������:</P>
            <UL>
              <LI><A 
                    href="http://www-2.webmoney.ru/carddostavka.shtml"><STRONG>��������
                    ����</STRONG> ��&nbsp;��� �&nbsp;�&nbsp;����: ��������� ������
                    ������, �������, ������, �����-���������, ����, Online (�����������
                    ���-����).</A><BR>
                            <BR>
                            <SCRIPT src="http://keeper.webmoney.ru/dilregionsget.asp" type=text/javascript></SCRIPT>
              </LI>
            </UL>
            <P>���� �&nbsp;������ ������ ��&nbsp;����������� ��� ������ ���&nbsp;�����,
              ��&nbsp;������ ����� �������������� ������ ���������� ��������
              (��������� �������� �����, �������� ���������, �������, ����� ������ <NOBR>WM-����</NOBR> ���&nbsp;�����
              ���������� ���������) ����� ��&nbsp;����� ������������������ ������� <IMG height=16 alt="" 
                  src="../../images/cards/sglobe.gif" width=16 align=top> <A 
                  href="http://geo.webmoney.ru/">geo.webmoney.ru</A>.</P>
            <P>C����� ������� ��������������� <NOBR>WM-����</NOBR> ���������
              �����������. ��� ���������������� �&nbsp;���������� <NOBR>WM-����</NOBR> �����������,
              ��������������� �&nbsp;������� ���� ����� ���������� ��&nbsp;�����������
              ����� ��&nbsp;����� <A 
                  href="mailto:wmcards@webmoney.ru">wmcards@webmoney.ru</A>.</P>
            <P class="arial">��� ���������� �� ������ ���������� WebMoney �� ������ ���������� <a href="http://www.webmoney.ru/cardmain.shtml" target="_blank">�����</a>.</P>
            <p class="arial"><b><a name="ya" id="ya"></a>����� ���������� ������.������</b></p>
            <p class="arial">����������� �������� &laquo;������.������&raquo; �����
                ������ � ������, ����������, ��������-���������, ������� ����������
              ��������-�������� � ��. </p>
            <p class="arial">����������� �������� &laquo;������.������&raquo; �����
                ������ � ����������, ��������� ����������, ������� �����, �������
              �����, ��������-���������, � ��.</p>
            <p class="arial">������ �������������� �������:</p>
            <ul>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236747','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">������</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237284','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">����������
                  �������</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236673','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">�����-���������</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236739','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">�����������</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237381','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">��������</a> </li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=236946','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">�������
                  ������</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237008','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">��������</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237070','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">������-������</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237079','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">������-�����</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237115','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">������</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237195','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">����</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237256','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">�����</a></li>
              <li class="arial"><a href="javascript:MM_openBrWindow('http://yandex.ru/redir/?dtype=money&amp;url=http://money.yandex.ru/point/?current_id=237321','','status=yes,scrollbars=yes,resizable=yes,width=750,height=500')">��</a></li>
            </ul>
            <p class="arial">���������� ��������-�������� �������� &laquo;������.������&raquo;:</p>
            <ul>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241432">� ������</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241433">� �����-����������</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=280313">� �����������
                    � ���������� �������</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241434">� �����</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=412625">� �������������</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=241779">� �������</A></SPAN>
              <LI><SPAN class="arial" style="COLOR: #000000"><A href="http://money.yandex.ru/?id=309076">� ��������</A></SPAN> </LI>
            </ul>
            <p class="arial"> ��� ���������� �� ������������� ���� ���������� ������.������
              �� ������ �������� <a href="http://money.yandex.ru/?id=242313" target="_blank">�����</a>. </p>
            <h5 class="header10bottom">��������!</h5>
            <span class="arial"><font color="#FF0000">�� � ���� ������ ��
                  ��������� ����� ���������� &laquo;�
                ���&raquo;. �� ������ ��������� ������ �� ��������!</font></span><!-- #BeginLibraryItem "/Library/block_if_questions.lbi" --><span class="arial"><hr size="1" noshade color="#FF9900">
            <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>���� � ��� �������� �������, �� ������ ������� ��������� �� <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=29894257&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">29894257</nobr></a>,  ���� ��������������� ������ �������� �� ����� �����. ��� ����� �������� <a href="../faq.htm#question_form">�����</a>. 
            <p>������ �� �������� ����� ������������� ������� �� ������ ����� �� �������� <a href="../faq.htm" target="_blank">FAQ</a>. </p>
<!-- #EndLibraryItem --></td>
        </tr>
      </table>        </td>
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
