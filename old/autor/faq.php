<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');
if(access($S_NUM_USER, 'main')){//������ ���������� ������ �� ���������

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'family');

if($fl=='send')
{
  send_intro_mess($S_NUM_USER, 1, $login, "FAQ: $tip_mess", $letter, 0);
  //mail($admin_mail,"FAQ: $tip_mess","�� $name<hr>$letter","From: $login".chr(13).chr(10).'Reply-To: '.$login.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  echo("<script>alert('�� ��������� ��������� �� ���� $tip_mess');</script>");
}
?>
<html>
<head>
<TITLE>FAQ</TITLE>
<meta name="description" content="�������, �������� ������ � �������� �� �����">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="autor.css" rel="stylesheet" type="text/css">
<style type="text/css">
.LR_pad {padding-left:10px; padding-right:10px}
LI {padding-right:10px;}
h4 { font-size:120% }
</style>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('faq');
visitorStat=0;
var payment='"������� ������",';
var technicalProblem=' "����������� ��������",';
var other=' "������".';
</script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="send_mess" action="faq.php" method="post" onSubmit='if (visitorStat==0) {alert ("�� �� ������� ���� ������� &#8212; "+payment+technicalProblem+other); document.all.radios.style.backgroundColor="yellow"; return false}'>
  <a name="top"></a> 
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><h3 class="dLime">FAQ&nbsp;&nbsp;</h3></td>
      <td width="100%"> (������ �� �������� ����� ���������� �������). </td>
    </tr>
  </table>
  
  <hr size="1" noshade>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	<ol style="font-weight:800; padding-top:10px">
      <li><a href="#sale_beg">��� ������ ��������� ���� ������?</a></li>
      <li><a href="#potential">� ��� �������� ������� �����-�� &laquo;�������������&raquo; ������.
        ��� ��� �����?</a> </li>
      <li><a href="#your_profit">������ ���� ������ �� ������� ���� �����?</a></li>
      <li><a href="#all_money">������ ��, ��� � ���� ��������� ���� ������ ��� ������ ����� ������������ � ������� 3 �������?</a></li>
      <li><a href="#short_time">�� �����������, ���  ��� ������� ��������� ��� ����� ������ �����
          �� ���������� ���������� �������. ��������, ������?</a></li>
      <li><a href="#time_to_add">� ���� ����� 300 ������� �����. �������, ������� ������� ����� ��� ���������� �� � ����� ��������?</a></li>
      <li><a href="#yourself">��� ����� �������� ��� ���� � ���� ����, �� � ���� ���������� ��� ������� �� ���������� ����� �����... ������ �� �������� ��� ���� ������, ����� �� ������� ��� ����?</a></li>
      <li><a href="#noreccomend">������ �� � ��������� ����� ������������� �� ����� �� ������� ������?</a></li>
      <li><a href="#checking">������ ������������ ���� �� ������� ������ �� �����������
          � ����� �������� �������������? ������ �� �� �� ��������� ��?</a> </li>
      <li><a href="#unical_worx">���� �� � ��������  �� ����� ����� ������ �� ���������� ���������� ���������� �����?</a></li>
      <li><a href="#money_back">��� �� ��������, ���� �������� ��������� ������� ��� ������ �� ��� ������?</a></li>
      <li><a href="#plagiat">������� �� �� ��������� ��� ������ �� ������������ ����?</a></li>
      <li><a href="#fee_order">��� �� ��������������� � ��������?</a></li>
      <li><a href="#communication">� ��� �� ����� �� ������ �� ���� ���������� email! ������? � ��� � ���� ���������?</a></li>
      <li><a href="#noanswer">� ������� ��� ��������� �� ������ ��������, �� �� ������� �� ������
            ������! ������?</a></li>
      <li><a href="#add_profit">���� �� � ��� �����-������ �������������� ������ ��� ������������ Diplom.com.ru?</a></li>
    </ol>      
        <table width="100%"  cellspacing="0" cellpadding="0">
      <tr>
        <td rowspan="2" valign="top"><img src="../../images/customer1.jpg" width="64" height="64" hspace="4" vspace="0" border="1"></td>
        <td width="100%" height="25" align="center" bgcolor="#DEFFCE"> <a href="#add_question"><strong>�������� ���� ������.</strong></a> �� ����������� �������� �� ���� � ������� 24 �����.</td>
      </tr>
      <tr>
        <td valign="top" style="padding:4px"><strong>��������!</strong> ����������, �� ��������� � ���� ������� ������� �� ������-���� <strong>�����������</strong> ������. ������� ��� <a href="#new_message">�� ���������, ��� ������ ������ ����������</a>. ������� ������ ������������ ��� ������� �� ����� �������. </td>
      </tr>
      <tr>
        <td height="30" colspan="2"><hr size="1" noshade></td>
        </tr>
    </table>
      <ol start="1" style="padding-top:0px; margin-top:0px">
          <h4>
            <li><a name="sale_beg"></a>��� ������ ��������� ���� ������?
        </li>
          </h4>
          <p>��� �� ������, � <b>����� ������</b>! :)</p>
          ��� ����� ��� �����:
        <ul style="padding:10px; margin:10px">
          <li>ٸ������ �� ������ &laquo;+�������� ������ &raquo;</li>
          <li>�� ������������� �������� ������� ��������� ������ � �����������
            ��, ����� ������ &laquo;�����������!&raquo;</li>
        </ul>
        ����� ����������� ���������� ���� ������ ���������������, �� � �������
        ������ �������� ������ ������������� ���������, � ��� �� ������ <b>�������������</b> ����������������. 
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        
          <h4><li><a name="potential">� ��� �������� ������� �����-�� &laquo;�������������&raquo; ������.
        ��� ��� �����?</a></li></h4>
            <p>��� ��������� � ��� ������. ��� ������ ��
              ��������� ��� �����������. ��� ��������� ��� ������
              ����, ���� ��� �� ������������, ��������� :) </p>
            <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
            <h4><li><a name="your_profit"></a>������ ���� ������ �� ������� ����
                �����?</li>
          </h4>
        
            <p>��� �, �� ������ � ��� ��� �������, ����� ��, ����������, ��
              ����� �� ���������� �������� ������ � ������ � ��� web-����. </p>
            <P>� ������ ������� (�� ����������� ������� ����������� ������������),
              �� �������� ���� ������������ � ������� �� 10% �� 20%. ������ �����
              ������� ������� �� ������� ���������� ������� ����� ���������������
              ����� ����� ��������������, � �������������� ����, ����� �� ��
              �������� ������� � ������������� �������������. </P>
            <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        
          <h4><li><a name="all_money"></a>������ ��, ��� � ���� ��������� ����
              ������ ��� ������ ����� ������������ � ������� 3 �������?</li></h4>
        
          <p>����� ���������� �� ����� 1000 �����, �� ������ ����������� ������������
            ��� ��� ����� ������ �����. ��� �������� �� ������ ������� � ����
            �������:</p>
          <a name="tblProfit"></a>          <!-- #BeginLibraryItem "/Library/block_tbl_author_ctat.lbi" -->
          <table width="1%" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC" class="solidGray">
            <tr bgcolor="#FFFFFF">
              <td colspan="3"><h4 class="header6bottom"><strong>������� �����
                    ����� :))) </strong></h4>
              </td>
            </tr>
            <tr>
              <td width="78" bgcolor="#E4E4E4"><strong> ���������� ������������
                  ����� </strong></td>
              <td width="95" bgcolor="#E4E4E4"><strong style="cursor:default" title="���������� �� ���������� ���� ��������� �����.">�������� <nobr>��
                    �������</nobr> (%%) </strong></td>
              <td width="164"><strong style="cursor:default" title="������, � ������� �������� ��� ������� �� ������� ����� ����� ������� � ���.">������
                  ����������� ������������</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> �� 50 </td>
              <td width="95" align="right"> 25</td>
              <td width="164" align="right"> ��� </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> 51-200 </td>
              <td width="95" align="right"> 18 </td>
              <td width="164" align="right"> 2 ������ </td>
            </tr>
            <tr bgcolor="#FFFFFF" title="��� ������� ������">
              <td width="78" align="right"> 201-500 </td>
              <td width="95" align="right"> 15 </td>
              <td width="164" align="right"> 1 ����� </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> 501-1000 </td>
              <td width="95" align="right"> 13</td>
              <td width="164" align="right"> 2 ������ </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right">&gt;1000 </td>
              <td width="95" align="right"> 10 </td>
              <td width="164" align="right"> 3 ������ </td>
            </tr>
          </table>
          <!-- #EndLibraryItem -->
          <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
          <h4><li><a name="short_time"></a>�� �����������, ��� ��� ������� ���������
            ��� ����� ������ ����� �� ���������� ���������� �������. ��������,
            ������?</li></h4>
        
          <p>�� ����� ������. ������� ������� ��� �� ���������� �������. </p>
          <p>����, �����������, ��� � ��� ���� 503 ������� ������. �����������
            ������, ��� �� ����� �� ���������� � ����� �������� ������ 100 ��
            ���, ����� ���� ������ ������ �������. ����� �������, �� ���������
            ������ 2 ������ ����������� ������������ (<a href="#tblProfit">��.
            �������</a>). ����� ����, ��������� ������ �������� ������ �� <strong>���
            �����������</strong> ���� 100 �����. � ��� ���� �� �� ����������
            ��� 503 ������ (���, ���� ��, 501 :), ��, ��-������, �������� ��
            2 ������ ����������� ������������ (�.�. &#8212; � 4 ���� ������!)
            � ��-������, � ������� ����� ����� ����� (��� � � ����������, ����������),
            ���� ������ �������� �� ������� ���� (500 ����� ������ 100!). �������
            �������������� ������� ���������� �������� ������ ��� ��� �� ������
            ������ &#8212; ����� ���������� ������ ���������� �� ��� �������� <strong>�
            20 ���!!! </strong></p>
          <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
		<h4>
          <li><a name="time_to_add"></a>� ���� ����� 300 ������� �����. �������,
            ������� ������� ����� ��� ���������� �� � ����� ��������?</li>
		</h4>
		<p>��� ������� �� ���� �������� �������� &#8212; ����� ���������������� ����������
		  � �������� ������ ����������� � ��������. �� ��� ����� ���������� ��
		  15 �� 70 �����. ����� �������, ����� ��� ����� ������������� �� 4 ��
		  20 �����. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
		<h4>
		    <li><a name="yourself"></a>��� ����� �������� ��� ���� � ���� ����, ��
		      � ���� ���������� ��� ������� �� ���������� ����� �����... ������
		      �� �������� ��� ���� ������, ����� �� ������� ��� ����?</li>
		  </h4>
		<p>� �������� ���������� ��� ��������, �� � ���� ������ ���� ������������ ����������
		  �� 50%. ����� ����, �� ������� ����� �� ������ ����������� ������������. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
		<h4><li></li>
		  <a name="checking">������ ������������ ���� �� ������� ������
              �� ����������� � ����� �������� �������������? ������ �� �� ��
          ��������� ��?</a></li></h4>
		<p>������ ��� �� ������� ������ ��������� ���������� ���� ������ �� �������
		  ������. ���� �� �� �� ���������, �������� ���� ������. � ���������
		  ������ �� ���� �������� ��, ���� �������� � ���� ��� ���������� �������
		  ��������.</p>
		<p>���� �� ������ �� ������ � ����� �������, �� ����� 3 ����� ��� ������������
		  ������������� (�������� ����� ���� ������ �������). �� ����� �� ���������
		  ���� ������, ���� �� ������� � ��������� ������ ���� ���������� ������,
		  ���� ������ ����������, �� ������� ����������������� ��������� � ������
		  ������. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="noreccomend"></a>������ �� � ��������� ����� �������������
            �� ����� �� ������� ������?</li></h4>
        <p>���, �� �������. �� ������ ������������� ����������� ����. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="unical_worx"></a>���� �� � �������� �� ����� ����� ������
            �� ���������� ���������� ���������� �����?</li></h4>
        <p>�� ������ ���������� ���� ����� ��������� ������, ������� ��� ��������
          �� ������ ����������� �� ������� ������ ���������. ����� ����, �� ������
          ����������� � �������� ����������� ���������� ���������� ����� � �����
          ������ ������� &#8212; <a href="http://www.diplom.com.ru" target="_blank">Diplom.com.ru</a>.</p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="money_back"></a>��� �� ��������, ���� �������� ���������
            ������� ��� ������ �� ��� ������?</li></h4>
        <p>�������� ������ ���������������� ����� <a href="../agreement.htm" target="_blank">����������������
            �����������</a>.
          ���� �������������� ����� ������ ������������� ���������� ���� ����������,
          ������ ��������� �� ������������. ��������������, �� �� ����� ���������
          �������� ����� � ���. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="plagiat"></a>������� �� �� ��������� ��� ������ �� ������������
            ����?</li></h4>
        <p>�� � ���� ������! �������� ������� ������ � ���� �������������� �����������
            � ���, ��� �� ������� ���� �������������� ����� ������������� �� ����
            ������ � ������������� ��� ������������ ����� �� �������. ���� �� ���������
            ������ <a href="#tblProfit">�������� �� �������</a>.        </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="fee_order"></a>��� �� ��������������� � ��������?</li></h4>
        <p>�������� ���������������� ������� &#8212; ����� �������� ������� <a href="http://www.money.yandex.ru">������.������</a> ���
            ���������� ���������. �� ��������� ������������� � � ��������������
          ������� �������� ������ ����� ��������. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="communication"></a>� ��� �� ����� �� ������ �� ����
            ���������� email! ������? � ��� � ���� ���������?</li></h4>
        <p>��� ������� ��� ������ ����� ������� �� �����. � ���������, � ���������
          ����� ����� �������������� email ������ ���������� ������� ��������. </p>
        <p>������ ��������� � ���� �� �������� ��� ��� �������� �����. �� ������
            ������� ��� �� ������� <a href="feedback.php">��������</a>, ���� <a href="#add_question">�
            ���� ��������</a>, ���� ��� ��������� �������� ����������, �� ���������
            � �����-���� ���������� �������. � ��������� ������� ��� �������
            ����� � ������ � ������ ������� (��� ������� ����������� � �����������
            �� <a href="#">�������
            �����</a>) � �������� �� ������ &laquo;�����&raquo; � ������� &laquo;���������&raquo; �
          ������ � ���� �������:<a name="new_message"></a></p>
        <p><img src="../../images/illustrations/new_message.gif" width="484" height="156" border="1"></p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
        <h4><li><a name="noanswer"></a>� ������� ��� ��������� �� ������ ��������,
            �� �� ������� �� ������ ������! ������?</li></h4>
		<p>������ �����, ������ ������ ��������� �� ������������� ��� ����������. ����������,
		  ��� ���� ��������� ����� ���� ���� ������� � �����-������ ����������
		  �������, ���� ��� (��������, ������� ������ ���������, ������ �� ������
		  � �������� � �.�.).</p>
		<p>� ������ ������ �� ������ �������� ��������� �� ��������, ��� ����������
		  ������ ������ (<a href="#new_message">��. ����</a>). �� ������ &#8212; �����
		  <a href="#add_question">����� ��������</a> � ����� ����� �������. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
          <h4><li><a name="add_profit"></a>���� �� � ��� �����-������ ��������������
              ������ ��� ������������ <a href="http://diplom.com.ru/job.htm">Diplom.com.ru</a>?</li>
        </h4>
        <p>��. ��� ���������� ������������� ������ � ������ ������� <a href="http://diplom.com.ru/">Diplom.com.ru</a> ���
            �� �������� � �� ������������� (������ ������ ������ �� �� ��������).
            ����������� �������� ������������ ����� �� ������� �� ����� ��������
          ��������, ���� ����� ���������� �� ���. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">�����</a></p>
      </ol>
      <a name="add_question"></a>
      <table width="100%" cellpadding="6"  cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#F5F5F5">
          <td width="100%" bgcolor="#FFFFFF"><h3><b> �������� ���� ������. </b></h3>
            �� ����������� �������� �� ���� � ������� 24 �����            </td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td bgcolor="#DEFFCE"><p>.<span class="red"><strong>��������!</strong></span><br>
            ����������, ��
              ��������� � ���� ������� ������� �� ������-���� <strong>�����������</strong> ������.
              ������� ��� <a href="#new_message">�� ���������, ��� ������ ������
              ����������</a>. ������ ������ ������������ ��� ������� �� �����
            �������. </p></td>
        </tr>
        <tr valign="top" bgcolor="#F5F5F5">
          <td nowrap bgcolor="#F5F5F5" id="radios" class="arial"><strong>���� �������: </strong>
		  <input name="tip_mess" type="radio" value="������ ������"
		   onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">������� ������ 
          <input name="tip_mess" type="radio" value="����������� ��������" 
		   onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">����������� �������� 
          <input name="tip_mess" type="radio" value="������" 
		  onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">������             
		  </td>
        </tr>
        <tr valign="top" bgcolor="#F5F5F5">
          <td nowrap bgcolor="#E4E4E4"><span class="arial">��� ������:</span> <br>
            <textarea name="letter" rows="10" id="letter" style="width:100%"></textarea>
            <br>
            <input type="submit" name="Submit" value="��������� ������!">
            <input name="fl" type="hidden" id="fl" value="send"></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//end work
?>