<?php
//echo("$HTTP_REFERER<br>");
session_start();
require('../connect_db.php');
require('lib.php');
statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
?>
<html>
<head>
<TITLE>�������� ��������� ������ ������ ������ �� ����� ��������</TITLE>
<meta name="description" content="�������, �������� ������ � �������� �� �����">
<meta name="keywords" content="��������� ������ ������ ������ �� �����; ���������; ���������� ���������; ����������; ��������� �������; ��������; ����� �������� ������; �����������; ��������� ������� �� �����; ��������������� �������������; ������ � ����� ������; ������� ��������; �������� � �������� ������; �������������� � ������������; ��������� ���������; ����������; �������� ������ �� �����; ��������� ������; ���� ���������; ��������� ���������; ������� ���������; ��������� �����������; ���; ���������; ������������� ���������; ����������������; ���������������� � �����; ����������� �����; ����������; ����������; ������; �����; ����������������; ���������; ��������� � �������; ������ �������; ��������">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
/*function goAccount ()	{
myForm=document.form1;

(myForm.email.value.indexOf('srgg')!=-1)? myForm.action='admin/index.html':myForm.action='autor/index.html'; 

return true;
}*/

function getTruePass()
{
  if(location.href.indexOf('������_2!')!=-1)
  {
    alert('�� ������� ������������ ������ ��� �����������!\n--------------------------------------------------------------------\n������ �� �������� ��� ����� e-mail.');
  }
  if(location.href.indexOf('������_1!')!=-1)
  {
    alert('�� ������� ������������ ������ ��� �����������!\n--------------------------------------------------------------------\n������ �������\n��� �� �����.');
  }
}
//-->
</script>

</head>
<body onLoad="getTruePass(); MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif');document.form1.login.focus()"><? require ("../temp_transparency_author.php");?><form name="form1" method="post" action="autorization.php" onSubmit="return emailCheckReferats(this.login);"><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
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
    <td width="50%" valign="top"><h1>���� � ������������
        �������:</h1>
      <span class="arialEncrised">��� email:</span><span class="arial"><br>
      <input name="login" type="text" id="login" style="width:50%" value="<?php echo($login);?>">
      <br>
      </span>
      <div class="header10pdTop arialEncrised">��� ������:</span><span class="arial"><br>
      <input name="pass" type="password" id="pass" style="width:50%" value="<?php echo($pass);?>"></div>
      <div class="header10pdTop"><input name="Submit" type="submit" value="�����!"></div>                      
      <p><a href="javascript:alert('������� ������ ���� ����� � �������� �� ������ \'�����\'\n� �� ������ ������ �� ���� �����.')" class="arial">��������� ������</a>&nbsp;|&nbsp;<a href="anketa.php" class="arial">����������� <img src="../images/pointer_right_contour.gif" width="13" height="13" border="0" align="absbottom" style="background-color: #FFa933"></a>        <input name="go_next" type="hidden" id="go_next" value="autor/index.html">
        <br>
        <br>
</p>
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
<!-- SpyLOG --><!-- #EndLibraryItem --></form>
</body>
</html>
