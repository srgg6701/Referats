<?php
session_start();
require('../connect_db.php');
require('lib.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($fl=='send_mail')
{
  if($who==0){$frm='������������� ��������';}
  if($who==1){$frm='��������� ����� ������';}
  if($who==2){$frm='�������� � ������';}
  if($subj==0){$sbj="�������� �� ������";}
  if($subj==1){$sbj="������";}
  if($subj==2){$sbj="����������� �������";}
  if($subj==3){$sbj="������� ��������������";}
  if($subj==4){$sbj="������";}
  send_intro_mess(0, 1, $email, "Feedback:$who:$subj $sbj;$frm", nl2br("<b>�� ����:</b> $sbj<br><b>������:</b> $frm<br>$letter"), 0);
  mail($admin_mail, "Feedback:$who:$subj $sbj;$frm", nl2br("<b>�� ����:</b> $sbj<br><b>������:</b> $frm<br>$letter"), "From: $email".chr(13).chr(10)."Reply-To: $email".chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  //������� ������ � ������� �� index.php
  header("location: index.php?alert=��� ������ �������������� ���������!");
}
?>
<html>
<head>
<TITLE>��������, ���������, �������� ������ �� �����, ���� ���������</TITLE>
<meta name="description" content="�������, �������� ������ � �������� �� �����">
<meta name="keywords" content="���� ���������, ��������, ������, �������, ��������, ������ �� �����, �������� ������ �� ����, ������ ������, �������� ��, ������� �� ����, ����������, �����, ��������, ���������, �����������, �������, ����������, �������� � ��������, ����������, ��������� ���������, ����������, ���������, ��������� ���������, �����������, ���, ���������, ����������� �����, ����������, ����������, ������, �����, ���������">
<meta name="description" content="���� ���������, ��������, ��������� �����. ������� ������, ������� �� �����.">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript">
visitorStat=0;
function checkStat() {
if (visitorStat==0) 
	{
	alert ('�� �� ������� ���� ������ �����������!\n\n�������� �������� ���� �� �������:\n------------------------------------------------\n- "������������� ��������"\n- "��������� ����� ������"\n- "�������� � ������"');
	return false;
	}
if (document.form1.subj.options[0].selected)
	{
	alert ('�� �� ������� ���� �������!');
	return false;
	}
if (!document.form1.letter.value)
	{
	alert ('�� �� ������ ���� ������!');
	return false;
	} 
    //return 
	var x;
	//���� true ��� false (������� �������� ���������� ������)
	x=emailCheckReferats(document.form1.email);
	if(x && document.form1.checkSMS.checked)
	{
	  window.open('http://rocc.ru/cgi-bin/sms33.cgi?Prefix=7904&phone=4428447&message=��� ��������� � referats.info!');
	}
	return x;
	
}
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif'); if (document.referrer.indexOf('cooperation.htm')!=-1) document.form1.style.display='block'"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
alt="���� ���������, ��������, ��������� �����." title="�������� �������� Referats.info" 
width="261"  height="38" 
hspace="12" vspace="0" border="0"></a><h1 
class="graphixHeader2"><a href="../index.php" 
class="nodecorate" style="background-color:">���� ���������, �������� � �������</a><img 
alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" title="" src="../images/referat_bank.gif" 
width="55" height="16" 
border="0" align="absmiddle"></h1>
<div style="position:absolute; top:0px; left:390" id="navMenus">
  <table width="100%" height="54" align="right" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="65%" valign="top"><table height="42" border="0" align="center" cellspacing="0">
          <tr>
            <td nowrap class="red">������� �����<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="6" border="1" align="absmiddle">&nbsp;&nbsp;</td>
            <td height="38" align="center" nowrap><a href="autors.php" onMouseOver="MM_swapImage('pyctAccount','','../images/pyctos/account2_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/account2.gif" alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" name="pyctAccount" width="40" height="40" hspace="1" border="0" id="pyctAccount" title="��� ������������ ������ [�������]
			                       ���� / �����������"></a></td>
            <td height="38" align="center" nowrap><a href="cooperation.htm" onMouseOver="MM_swapImage('pyctCooperation','','../images/pyctos/cooperation_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/cooperation.gif" alt="��������������" name="pyctCooperation" width="40" height="40" hspace="1" border="0" id="pyctCooperation"></a></td>
            <td height="38" align="center" nowrap><a href="faq.htm" onMouseOver="MM_swapImage('pyctFaq','','../images/pyctos/faq_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/faq.gif" alt="FAQ [����� ���������� �������]" name="pyctFaq" width="40" height="40" hspace="1" border="0" id="pyctFaq"></a></td>
            <td height="38" align="center" nowrap><a href="agreement.htm" onMouseOver="MM_swapImage('pyctAgreement','','../images/pyctos/agreement_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/agreement.gif" alt="���������������� ����������" name="pyctAgreement" width="40" height="40" hspace="1" border="0" id="pyctAgreement"></a></td>
            <td height="38" align="center" nowrap><a href="useful.htm" onMouseOver="MM_swapImage('pyctUseful','','../images/pyctos/useful_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/useful.gif" alt="��������" name="pyctUseful" width="40" height="40" hspace="1" border="0" id="pyctUseful"></a></td>
            <td align="center" nowrap><a href="feedback.php" onMouseOver="MM_swapImage('pyctFeedback','','../images/pyctos/feedback_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/feedback.gif" alt="�������� �����" name="pyctFeedback" width="40" height="40" hspace="1" border="0" id="pyctFeedback"></a></td>
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
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="50%" valign="top"><h1>�������� ����� </h1>
      <p>�� ����� ������� �� ������ �������� ��� ���������. ������� ��� �� ������
        ����� ���������. ��� ����� �������� �� ������ ������. </p>
		<p><img src="../images/send_email.gif" width="73" height="38" hspace="6" align="left"><span style="color:#0000FF; text-decoration:underline; cursor:hand" onClick="document.forms['form1'].style.display='block';document.forms['Send_Message'].style.display='none';">����� ����� ��������</span> (��������� ����� � ��� �� ������). ������,
          ���� �� ������, ����� �� ����� �� ������ � ����� ���������, �� ������
          �������� �������� ����� &laquo;��������� � ���&raquo;. </p>
        <p><img src="../images/send_sms.gif" width="73" height="38" hspace="6" align="left">����������, <span style="color:#0000FF; text-decoration:underline; cursor:hand" onClick="document.forms['form1'].style.display='none';document.forms['Send_Message'].style.display='block';">��������� ���</span> � ���� �������� (��� �������� ������� ���������).<br>
          <br>
          <br>
        </p>
        
        <form action="feedback.php" name="form1" method="post" onSubmit="return checkStat()" style="display:none"><br>
<hr size="1" noshade color="#ffa993">      
          <h2 class="header6bottom"><b>��������� ����� �������� ���������. �� ����������� �������� ��� � ������� 24 �����.</b></h2>
          <table width="100%" cellpadding="6"  cellspacing="0" bgcolor="#CCCCCC">
        <tr valign="top" bgcolor="#F5F5F5">
          <td width="1%" nowrap bgcolor="#E4E4E4"><h1 class="header6bottom"><strong>��� ��?</strong></h1>              
            <input name="who" type="radio" value="0" onClick="visitorStat=1">
        ������������� ��������<br>        <input name="who" type="radio" value="1" onClick="visitorStat=1">
        ��������� ����� ������ <br>        <input name="who" type="radio" value="2" onClick="visitorStat=1">
        �������� � ������<br>        <span class="arial">��� email:</span><br>        <input name="email" type="text" value="" style="width:100%">        <br>        
        <span class="arial">���� ���������:</span><br>        <select name="subj" id="subj">
                <option value="0">-�������� �� ������-</option>
                <option value="1">������</option>
                <option value="2">����������� �������</option>
                <option value="3">������� ��������������</option>
		        <option value="4">������</option>
        </select>            </td>
          <td><span class="arial">���� ���������:</span> <br>
              <textarea name="letter" rows="10" id="letter" style="width:100%"></textarea>
              <input type="submit" name="Submit" value="��������� ������!">
              <input name="fl" type="hidden" id="fl" value="send_mail"></td>
        </tr>
      </table>        <input name="checkSMS" type="checkbox" id="checkSMS" value="on">
      ��������� � ���
      <input type="hidden" name="hiddenField">      
      </form>
            <form name=Send_Message action=http://rocc.ru/cgi-bin/sms33.cgi 
            method=post  style="display: none">
			  <br>
              <hr size="1" noshade color="#ffa993">
              <h2 class="header6bottom"><b></b></h2>
              <INPUT type=hidden value=7904 name=Prefix>
      <h2 class="header6bottom"><strong>�������� ��� � ���� �������� (�� 160 ��������).</strong> </h2>
      <div style="position:absolute;top:-1000;"><INPUT type=hidden value=7904 name=Prefix>
����� ��������:<BR>
            +7904
            <INPUT maxLength=7 size=7 name=phone value=4428447></div>
                        ����� ��������� (�������� ��������:
                        <INPUT name=remainchars style="border:none; background-color: yellow" value=160 
                  size=1 readOnly>
                        ):<BR>
			<SCRIPT language="JavaScript">
var MaxLength = 160;

function DisplayLength(){

  if ( Send_Message.message.value.length > MaxLength )

    Send_Message.message.value = Send_Message.message.value.substr( 0, MaxLength );

  Send_Message.remainchars.value = MaxLength - Send_Message.message.value.length;

}

function CheckLength(){

  event.returnValue = Send_Message.message.value.length < MaxLength || document.selection.type != "None";

}
</SCRIPT>
            <textarea name=message cols="40" rows=6 onKeyPress=DisplayLength();CheckLength(); onpaste=CheckLength(); onpropertychange=DisplayLength(); style="background-color:ccffcc; border:solid 1px #999999"></textarea>
            <br>
            <INPUT name="submit" type=submit class="topPad6" value=��������� ���!>
            <INPUT name="reset" type=reset class="topPad6" value=��������>            
            </form>
    </td>
  </tr>
</table>
<p><a href="http://www.order.referats.info">������ �� �����. �������� ������. �������� ��������� ������.</a></p> <!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
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
  <img src="http://u6940.51.spylog.com/cnt?cid=694051&p=1" alt='SpyLOG' border='0' width=88 height=31 ></a></noscript>
  <!-- SpyLOG -->
  <!-- #EndLibraryItem -->
    <SCRIPT language=JavaScript>
<!--

if (telekaks.isSupported()) {
var ms = new mtDropDownSet(telekaks.direction.down, 0, 2, telekaks.reference.bottomLeft);

var menucompany = ms.addMenu(document.getElementById("company"));
menucompany.addItem("� ��������", "http://editorial.rostov.tele2.ru/?page=telerurost_about_comp&t2page=company_about");
menucompany.addItem("�������", "http://news.rostov.tele2.ru/index.phtml/category/teleru_rov?t2page=company_news");
menucompany.addItem("���� ��������", "http://editorial.rostov.tele2.ru/?page=telerurost_coverage&t2page=company_coverage");
menucompany.addItem("��� ���� ���", "http://editorial.rostov.tele2.ru/?page=telerurost_whoiswho&t2page=company_whoiswho");
menucompany.addItem("��������", "http://editorial.rostov.tele2.ru/?page=telerurost_vacancy_no&t2page=company_vacancy");
menucompany.addItem("��������� �������", "http://editorial.rostov.tele2.ru/?page=telerurost_about_agreem&t2page=company_dog");
menucompany.addItem("���������", "http://editorial.rostov.tele2.ru/?page=telerurost_essential&t2page=company_essent");
var menutarifs = ms.addMenu(document.getElementById("tarifs"));
menutarifs.addItem("������", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_about&t2page=tarifs_tariffs");
var menutariffs = menutarifs.addMenu(menutarifs.items[0]);
menutariffs.addItem("TELE2 ������cc", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_express&t2page=tarifs_tariffs_express");
menutariffs.addItem("TELE2 ��������", "http://editorial.rostov.tele2.ru/?page=telerurost_tarifs_contract&t2page=tarifs_tariffs_kontrakt");
menutarifs.addItem("������������� � ������������� ������", "http://editorial.rostov.tele2.ru/?page=teleruall_construction&t2page=tarifs_mgorod");
var menuphones = ms.addMenu(document.getElementById("phones"));
menuphones.addItem("��������", "http://editorial.rostov.tele2.ru/?page=telerurost_phones&t2page=phones_phoneprice");
var menuservices = ms.addMenu(document.getElementById("services"));
menuservices.addItem("����� ����������", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_about&t2page=services_infoserv");
menuservices.addItem("�������", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_roaming&t2page=services_roaming");
menuservices.addItem("��������� �����", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_voicemail&t2page=services_voicemail");
menuservices.addItem("�����������", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_detalization&t2page=services_details");
menuservices.addItem("������������� - ���������������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi&t2page=services_randi");
var menurandi = menuservices.addMenu(menuservices.items[4]);
menurandi.addItem("�������� � �������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_logotones&t2page=services_randi_logosandtones");
menurandi.addItem("SMS-�������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_smstalk&t2page=services_randi_smsob");
menurandi.addItem("SMS-���������� ���������� ������������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_sport&t2page=services_randi_smssport");
menurandi.addItem("������������ SMS-������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_personal&t2page=services_randi_smspers");
menurandi.addItem("�������������� SMS-������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_info&t2page=services_randi_smsinfo");
menurandi.addItem("SMS-����", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_games&t2page=services_randi_smsgames");
menurandi.addItem("��������������� SMS-������", "http://editorial.rostov.tele2.ru/?page=teleruall_serv_randi_ent&t2page=services_randi_smsentertainment");
menuservices.addItem("�������������� ������", "http://editorial.rostov.tele2.ru/?page=telerurost_serv_extended&t2page=services_dopusl");
menuservices.addItem("��������� SMS", "http://editorial.rostov.tele2.ru/?page=teleruspb_serv_sendsms&t2page=services_smsform");
var menuwhereto = ms.addMenu(document.getElementById("whereto"));
menuwhereto.addItem("��������", "http://editorial.rostov.tele2.ru/?page=telerurost_where_shops&t2page=whereto_shops");
menuwhereto.addItem("����� ����������", "http://editorial.rostov.tele2.ru/?page=telerurost_where_cards&t2page=whereto_cards");
menuwhereto.addItem("��������� �����", "http://editorial.rostov.tele2.ru/?page=teleruall_construction&t2page=whereto_special");
var menuhelp = ms.addMenu(document.getElementById("help"));
menuhelp.addItem("����� ����������", "http://editorial.rostov.tele2.ru/?page=telerurost_help_about&t2page=help_infohelp");
menuhelp.addItem("������� � ������", "http://editorial.rostov.tele2.ru/?page=telerurost_help_faq&t2page=help_faq");
menuhelp.addItem("���������� ��������", "http://editorial.rostov.tele2.ru/?page=telerurost_help_customer&t2page=help_customer");
menuhelp.addItem("�������� �����", "http://editorial.rostov.tele2.ru/?page=telerurost_help_feedback&t2page=help_feedback");


telekaks.renderAll();
}

function init ( ) {
if (telekaks.isSupported()) {
telekaks.initialize();


}
}

-->
    </SCRIPT>
</p>
</body>
</html>
