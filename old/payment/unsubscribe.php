<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
$znum=$pass/12345;
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.number=$znum AND ri_works.number=ri_zakaz.work");
$zname=mysql_result($zk_r,0,'ri_works.name');
$zuser=mysql_result($zk_r,0,'ri_zakaz.user');

if($fl=='unsubscribe')
{
  //������� ���������������
  mysql_query("DELETE FROM ri_shedule WHERE script='autoreminder_zakaz_pay($znum, 5)' OR script='autoreminder_zakaz_pay($znum, 4)' OR script='autoreminder_zakaz_pay($znum, 3)' OR script='autoreminder_zakaz_pay($znum, 2)' OR script='autoreminder_zakaz_pay($znum, 1)'");
  //������� ��������� ������
  send_intro_mess(0, 1, $email, "����� Id $znum. �������� ������������ �� �����������", $motive, $znum);
  if($del_autoremind=='on')
  {
    //������� ��� �����!!!
	header("location: unremindered.php?login=$email&pass=".($znum*12345)."&del_zakaz=yes");
  }
  else
  {
    header("location: unremindered.php?login=$email&pass=".($znum*12345));
  }
}
?>
<html>
<head>
<TITLE>��������� �������������� �����������.</TITLE>
<meta name="robots" content="none">
<link href="../referats.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
goToLocation=0;
function goToPage() {

	if (goToLocation!=0) 
	{
	    document.form_summ.action='payment/'+goToLocation+'.php?summ='+document.form_summ.summ.value;
        if(document.form_summ.summ.value<<?php echo($our_summ+1-1);?>)
        {
          //������� �� �������� sorry.php
	      document.form_summ.action='payment/sorry.php?summ='+document.form_summ.summ.value;
        }
		if (!document.form_summ.elements['summ'].value) 
		{	
		alert ('�� �� ������� �����, �� ������� �� ������ ���������� ��� ������');
		document.form_summ.elements['summ'].focus();
		document.form_summ.elements['summ'].style.backgroundColor='yellow'; 
		return false;
		}
		else if (isNaN(document.form_summ.elements['summ'].value)) 
		{	
		alert ('������ ��� ��������� ������ �� ������ ��������� ������, ����� ����!');
		document.form_summ.elements['summ'].focus();
		document.form_summ.elements['summ'].style.backgroundColor='yellow'; 
		return false;
		}
		if (document.form_summ.agree.checked==false)
		{
		alert ('�� �� �������, ��� �������� � ����� ���������������� �����������!');
		document.getElementById('myAgreement').style.backgroundColor='yellow'; 
		return false;
		}
	return true;
	}
	else 
	{alert('�� �� ������� ������ ������!'); return false;}
}//-->
</script>
<script language="JavaScript" type="text/JavaScript">
payBlocks=new Array ('bank','cash','post','wmchange','cards','wallet');
function sh_content(objContent)	{
for (i=0;i<payBlocks.length;i++)	{document.getElementById(payBlocks[i]).style.display='none'}
document.getElementById(objContent).style.display='block';
/*if (document.getElementById(objContent).style.display=='none') 
{document.getElementById(objContent).style.display='block';}
else {document.getElementById(objContent).style.display='none';}*/
}
</script>
<style type="text/css">
<!--
.style3 {font-weight: bold}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif','../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')">
<form name="form_summ" action="unsubscribe.php" method="post"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../../index.php"><img src="../../images/referatsinfo2.gif" 
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
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="70%" valign="top"><p><b><?php echo($zuser);?>, ����� �� ������ ��������� ��������������
        ��������� � ������������� ������ ������ id <?php echo($znum);?> ���� &laquo;<span class="red"><?php echo($zname);?></span>&raquo;.</b></p>
      <p><b>�� ����� ������ ������������ ���, ���� �� �������� ��� � ������� ������
        �� ������ ������.</b></p>
      <h1 class="header6bottom"><b>������� ������: </b></h1>        
      <textarea name="motive" rows="6" id="motive" style="width:100%"></textarea>        
      <input name="del_autoremind" type="checkbox" id="del_autoremind" value="on"> 
      ������� ���������� �� ���� ������ �� ����� ��������. <br>        
      <input name="Submit" type="submit" class="topPad6" value="���������� �� ������!">
      <input name="login" type="hidden" id="login" value="<?php echo($login);?>">
      <input name="pass" type="hidden" id="pass" value="<?php echo($pass);?>"> 
      <input name="fl" type="hidden" id="fl" value="unsubscribe">     
      <h1><hr size="1" noshade>������� ������ �������: </h1>
      <ol>
        <li><a href="javascript:sh_content('bank');"><strong>������������� �����
              �� ��� ���������� ����</strong></a></li>
        <li><a href="javascript:sh_content('cash');"><strong>������������� ��������</strong></a></li>
        <li><a href="javascript:sh_content('post');"><strong>��������/�����������
          �������� ���������</strong></a></li>
        <li><a href="javascript:sh_content('wmchange');"><strong>����� �������e ������ WebMoney </strong></a></li>
        <li><a href="javascript:sh_content('cards');"><strong>���������� ���������� WebMoney ��� ������.������</strong></a></li>
        <li><a href="javascript:sh_content('wallet');"><strong>��������� ����� �� ������ ������������ ��������
            � ���, ���� �� ��� ��������� ��������� ������ WebMoney ��� ������.������ </strong></a></li>
      </ol>
      <span id="bank" style="display:none">
	  <hr size="1" noshade>
      <a name="bank"></a>
        <h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C�����
          ������:&nbsp;</span> ���������� �������</h1>
        <p>�������� ���������: </p>
        <p>��� ��� &quot;�����������&quot; <br>
    �. ������, ��. �������, 14, ���. 2 <br>
    ������ ��� &quot;�����������&quot; (���) � �. ���������, ���. ������, 16 <br>
    ����.���� 30101810000000000978 <br>
    � ��� �. ��������� <br>
    ��� 46013978 <br>
    ��� 7706193043 <br>
    ��� 615402001 <br>
    �/� 42301810401000000879</p>
      </span>
	  <span id="cash" style="display:none">
	  <hr size="1" noshade>
      <a name="cash" id="cash"></a>
      <h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C����� ������:&nbsp;</span> ������������ ��������</h1>
      <p>�������� ���������: </p>
      <ol>
        <li>������������ <a href="#bill">���������</a> (��. ����). ��� �����
          �������� �� ��� ������ ������� ���� � � ����������� ���� �������� ����� &laquo;������
          �������...&raquo;.</li>
        <li>������� ���� ������: ���, �������, ���� � ����� ������� � ���. (���������
          ������ � ��������� ��� ���������), �����������.</li>
        <li>������� ��������� ������� � ����� (������ ��� ����� ��� ����� ������������
          ��������, �� ����� ���� � ������) � ��������� �� ���.</li>
        <li>�� ����� <img src="../../images/mail_payment.gif" width="128" height="13" align="absbottom"> ���������, ����������, ��������� ����������: </li>
      </ol>
      <ul>
        <li>���� ������</li>
        <li> ����� ������</li>
        <li> ���� e-mail </li>
        <li> ��������������� ������� ���������. ��� ������ �� ������� ���, ���������
          � ���������� ������ ������.</li>
      </ul>
	  <a name="bill"></a><img src="http://www.diplom.com.ru/images/kvitancia.gif">
      </span>
	  <span id="post" style="display:none">
	  <hr size="1" noshade>
      <a name="post"></a>
      <h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C����� ������:&nbsp;</span> ��������/����������� �������</h1>
      <p>������ ��� ���������/������������ ��������: </p>
      <p>347900, ���������� ���., �. ��������, �����������, �������� ������ �������������.</p>
	  </span>     
	  <span id="wmchange" style="display:none"><hr size="1" noshade>
      <a name="wmchange"></a>
      <h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C����� ������:&nbsp;</span> �������� ����� WebMoney</h1>
      <img src="../../images/logo_wm.gif" width="113" height="36" align="left" class="rightOffset">
�������� ������ WebMoney ��������� ��� ����������� ������ � ���-���� �������,
�� ��������� ���������� �������.
<p>� ����� ������ ����� ������ �������� ���: �� ���� ������� ��������� �������������
  ��������� ������, ���� ������������ ��� ������ �� ���������� ���� (��������������
  �������� ������ �� ������� �������), � ��, � ���� �������, ��������� ��� ������
  �� �������� ���� WM ID � ������. </p>
<p>���� ������:</p>
<table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
  <tr bgcolor="#f5f5f5" class="arial">
    <td>��� WM ID</td>
    <td width="25%" align="center">634323190363</td>
  </tr>
  <tr>
    <td width="75%">������ ��� ������ � �������� (USD) </td>
    <td align="center"><font color="#009900">Z975922213018</font></td>
  </tr>
  <tr>
    <td>������ ��� ������ � ������ (RUR) </td>
    <td align="center"><font color="#CC0000">R190496965648</font></td>
  </tr>
  <tr>
    <td>������ ��� ������ � ���� (EUR) </td>
    <td align="center"><font color="#6600CC">E833960008390</font></td>
  </tr>
</table>
<p>��������� ���������� �� ��������� �������� ������� ����� �������� ������ ��������� <a href="http://www.webmoney.ru/rus/cooperation/exchange/interexchange.shtml">�����</a>.</p>
</span>
	  <span id="cards" style="display:none"><hr size="1" noshade>
<a name="cards"></a>
<h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C����� ������:&nbsp;</span> ��������
  ���������� WebMoney ��� ������.������</h1>

<p>��� ����������: </p>
<p>���������� WM ��� ������.������ �����(�) (��� ���������� &#8212;��. � ������
  ����� ��������) � ��������� �� <img src="../../images/mail_payment.gif" align="absbottom"> (����
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
      </ol>
    </td>
    <td valign="top"><ol>
        <li>����� �����;</li>
        <li> ����� �������;</li>
        <li>������ (����� ������� ���, � ���� ����� ������� �������� ��������)</li>
        <li>��� �������� (� ���� ����� ����� ������� �������� ��������)</li>
        <li>������� � ���� ������</li>
      </ol>
    </td>
  </tr>
</table>
<br>
<H4 class="leftHeader">��������� � ������ ���������� WebMoney � ������.������:</H4>
<hr size="1" noshade>
<H4>WM-�����</H4>
<P>�&nbsp;������ ������ �&nbsp;������� WebMoney Transfer ������������ ������������� <NOBR>WM-�����</NOBR> ����
  �����: WMZ,&nbsp;WMR � WMU.</P>
<P><NOBR>WMZ-�����</NOBR> ����� �������� 10, 20, 50 �&nbsp;100&nbsp;WMZ (����������&nbsp;USD).
  ��� ������������ ���������� <NOBR>Z-���������</NOBR> ���������� �������, �&nbsp;�����
  ������������ �&nbsp;�������� �������� ����� <NOBR>WMZ-����</NOBR> ���&nbsp;��������
  �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>
<P><IMG title="WMZ-�����, ������� �������" height=175 
                  src="../../images/cards/card_faces.jpg" width=350><IMG 
                  title="WMZ-�����, �������� �������" height=135 
                  src="../../images/cards/card_backz.gif" width=210></P>
<P><NOBR>WMR-�����</NOBR> ����� �������� 500, 1000, 3000 �&nbsp;5000&nbsp;WMR
  (����������&nbsp;RUR). ��� ������������ ���������� <NOBR>R-���������</NOBR> ����������
  �������, �&nbsp;����� ������������ �&nbsp;�������� �������� ����� <NOBR>WMR-����</NOBR> ���&nbsp;��������
  �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>
<P><IMG title="WMR-�����, ������� �������" height=175 
                  src="../../images/cards/card_facer.jpg" width=350><IMG 
                  title="WMR-�����, �������� �������" height=135 
                  src="../../images/cards/card_backr.gif" width=210></P>
<P><NOBR>WMU-�����</NOBR> ����� �������� 50, 100, 200 � 500 WMU (���������� UAH).
  ��� ������������ ���������� <NOBR>U-���������</NOBR> ���������� �������, �&nbsp;�����
  ������������ �&nbsp;�������� �������� ����� <NOBR>WMU-����</NOBR> ���&nbsp;��������
  �&nbsp;������� <A 
                  href="http://www.paymer.ru/" target=_blank>Paymer</A>.</P>
<P><IMG title="WMU-�����, ������� �������" height=193 
                  src="../../images/cards/card_faceu.jpg" width=371><IMG 
                  title="WMU-�����, �������� �������" height=146 
                  src="../../images/cards/card_backu.gif" width=210></P>
<hr size="1" noshade>
<p><b>������.������-�����:</b> </p>
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
  ��� ������ ���� ����� &#8212;����������� � �����������. ����������� �������� &laquo;������.������&raquo; ����������
  �� ����������� �������� &laquo;������.������&raquo; ������ �������� ������������
  �������� � �������� ������-�����. </p>
<p>����������� �������� "������.������" ����� ������ � ������, ����������, ��������-���������,
  ������� ���������� ��������-�������� � ��. </p>
<P>����������� �������� "������.������" ����� ������ � ����������, ���������
  ����������, ������� �����, ������� �����, ��������-���������, � ��.</P>
</span>  
  
<span id="wallet" style="display:none"><hr size="1" noshade>
<a name="wallet"></a>
<h1><span class="solidGray" style="font-weight:100; background-color:#FFFF00">&nbsp;C����� ������:&nbsp;</span> �������
  � ������ WebMoney ��� ������.������</h1>
<table width="85%" border="0" cellpadding="2" cellspacing="1" bgcolor="#4A7DB2">
  <tr bgcolor="#FFFFFF">
    <td rowspan="3"><img src="../../images/logo_wm.gif" width="113" height="36" align="left" class="rightOffset"></td>
    <td width="100%" height="20" align="right">��� ������ � ��������
      (USD) </td>
    <td><font color="#009900" size="2">Z975922213018</font></td>
  </tr>
  <tr valign="bottom" bgcolor="#FFFFFF">
    <td height="20" align="right">��� ������ � ������ (RUR) </td>
    <td><font color="#CC0000" size="2">R190496965648</font></td>
  </tr>
  <tr valign="bottom" bgcolor="#FFFFFF">
    <td height="20" align="right">��� ������ � ���� (EUR) </td>
    <td><font color="#6600CC" size="2">E833960008390</font></td>
  </tr>
</table>
<br>
<table width="85%" border="0" cellpadding="2" cellspacing="1" bgcolor="#9B072A">
  <tr bgcolor="#FFFFFF">
    <td><img src="../../images/ya.gif" width="44" height="27" vspace="6"><img src="../../images/logo-yandex.gif" width="64" height="28" align="absmiddle" class="rightOffset"> </td>
    <td width="100%" height="20" align="right"><font size="2">����� ������ �������� � <a href="http://money.yandex.ru">������-������</a>:</font></td>
    <td align="center"><p>4100141649572</p></td>
  </tr>
</table>
</span>
	  <hr size="1" noshade>
      <h1>��������! <span class="red">����� ������ ������ ����������� ��������
        ��� �� ����</span>.</h1>
      <strong>
      </strong>
      <br></td>
    <td width="30%" valign="top" class="rightTD" style="border-left:dotted 1px #ffcc00"><span class="arial">    <span class="style3"></span><img src="../../images/calling.jpg" width="79" height="98" align="left" style="padding-right:10px; margin-right:10px"></span>���� � ��� �������� �������, �� ������ ������� ��������� �� <a href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=305709350&action=message"><nobr>icq <img src="../../images/pyctos/icq.gif" width="18" height="18" hspace="0" vspace="0" border="0" align="absmiddle">305709350</nobr></a>,
    ���� ��������������� ������ �������� �� ����� �����. ��� ����� �������� <a href="../faq.htm#question_form" target="_blank">�����</a>.
      <p>������ �� �������� ����� ������������� ������� �� ������ ����� �� �������� <a href="../faq.htm" target="_blank">FAQ</a>. </p>      
    </td></tr>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></form></body>
</html>
