<?php
session_start();
require('../connect_db.php');
?>
<html>
<head>
<TITLE>����������� ������ � �������� ������������� ��������, ��� 1.</TITLE>
<meta name="description" content="�������, �������� ������ � �������� �� �����">
<!-- ��������� ������ ������ ������ -->
<meta name="keywords" content="��������� ������ ������ ������ �� �����; ���������; ���������� ���������; ����������; ��������� �������; ��������; ����� �������� ������; �����������; ��������� ������� �� �����; ��������������� �������������; ������ � ����� ������; ������� ��������; �������� � �������� ������; �������������� � ������������; ��������� ���������; ����������; �������� ������ �� �����; ��������� ������; ���� ���������; ��������� ���������; ������� ���������; ��������� �����������; ���; ���������; ������������� ���������; ����������������; ���������������� � �����; ����������� �����; ����������; ����������; ������; �����; ����������������; ���������; ��������� � �������; ������ �������; ��������">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript">
function diplom_hint ()	{
var job="<a href=http://www.diplom.com.ru/job.htm target=_blank>�����</a>";
var collapse="";
if (document.getElementById('diplom_maker').innerHTML=='') 
	{
	document.getElementById('diplom_maker').innerHTML='<br>&nbsp;����������� � ������� Diplom.com.ru ���� ��� ����������� ��������� �� ����� ���������� ���������� ������ ��� ��� ����������. ����������� �������� '+job+'.&nbsp;<br><br>';
	document.getElementById('clps').innerHTML="�������� ���������</span><br>";
	}
	else {
	document.all['diplom_maker'].innerHTML='';
	}
}
//-->
</script>

<style type="text/css">
<!--
.style5 {color: #CC0000}
-->
</style>
</head>

<body><? require ("../temp_transparency_author.php");?><form action="anketa2.php" method="post" name="registration" onSubmit="return emailCheckReferats(this.login);">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" background="../images/bg2.jpg">
    <tr>
      <td><img src="../images/logo2.gif"  alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������." width="257" height="56" hspace="10" border="0"></td>
      <td width="100%">&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="50%" valign="top"><h1>����������� � �������� �������������
        �������� ������.
    </h1>
      <p style="color:#FF6600;font-size:125%;font-weight:600" class="arial">��� 1 �� 2.</p>
      <p>����������� � ����� ������� ������� �� 2-� ������� �����
          � ����� � ��� ������� �������. �����
          ����� �� �������� ������ �� ���� �������� ����� �������. </p>
      <p class="header6bottom"><strong>����������, ������� ���� <nobr>e-mail:</nobr>        <?php
if(isset($mess))
{
  echo("<br><font size=+2 color='Red'>$mess</font><br>");
}
?>
      </strong> </p>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%"><span class="arial">
            <input name="login" type="text" id="login" style="width:100%">
          </span></td>
          <td><input type="submit" name="Submit" value="���������� &rsaquo;&rsaquo;" ></td>
        </tr>
      </table>      
      <span class="arial">        </span>      <p>        ����� ������� �����
        ������ ������ �� ������� �������� ������ ��������� <b>�����������</b> ������������
        �� 2-� ������ �� 3-� �������!       </p></td>
    <td width="50%" valign="top" style="padding:10px;"><table width="100%"  cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" background="../images/frames/left_orange.gif"><img src="../images/frames/left_top_orange.gif" width="16" height="16"></td>
        <td width="100%" rowspan="3"><table width="100%"  cellspacing="0" cellpadding="0">
            <tr>
              <td style="height:1%" bgcolor="#FF9900"><img src="../images/spacer.gif" width="2" height="2"></td>
            </tr>
            <tr>
              <td style="padding-top:10px"><h2><font color="#FF9900">��� ������������
                    �������, ���:</font></h2>
                  <ul type="square">
                    <li>����� ������ � ����������� ���������� � ����������, �����,
                      ��������� ����� ����� � ������� �� ������ </li>
                    <li><span class="header10bottom"></span>����������������
                      �������� ����� � ����������</li>
                    <li>���������� ����������� �� ���������� ����������� �����</li>
                    <li><span class="header10bottom"><font color="#FFffff"><img src="../images/key_money.jpg" width="163" height="108" align="right" style="border:solid 1px #FF9900; padding:16px 4px 0px 10px; margin:16px 4px 0px 10px"></font></span>���������� ������������� �������, ����������� ������������
                      ��������� ����� �����</li>
                    <li><span class="header10bottom"></span>������������������
                      ������� ����������</li>
                    <li><span class="header10bottom"></span> ������ ��������
                      ����������� ��������</li>
                    <li><span class="header10bottom"></span>������� � �������
                      �������� ����� � �������������� �������� ��������</li>
                    <li><span class="header10bottom"></span>��������� ����������
                      �������</li>
                  </ul></td>
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
      </td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
  <tr valign="bottom">
    <td height="22" align="center" nowrap class="topDotted"><b>���� �������?</b> ��������
      ������ <a href="autor_faq.htm" target="_blank">FAQ</a> ��� �������. � ��
      �� ������ ������ �� ����������� �� ���. </td>
    </tr>
  <tr valign="bottom">
    <td height="20" align="center" nowrap background="../images/bankreferatov_bg.gif"><b style="font-weight:100">����
        ���������, ��������, ��������� �����. ������� ������, ������� �� �����,
        ��������</b></td>
  </tr>
</table>
</form>
</body>
</html>
