<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
?>
<html>
<head>
<title>���� ���������� ����������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<hr size="1">
<p><a href="#">������� �� ������������ ���������� ���������</a>.<br>
    <a href="#">������� �� ���� ����������� ���� � ���������� �����</a>.<br>
    <a href="#">������� �� ���� ����������� ���� � ��������� ��</a>. </p>
<table width="550" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
</table>
<p>&nbsp;</p>
<h3>������� �� ������������ ���������� ���������:</h3>
<table width="550" border="0" cellpadding="4" cellspacing="1" style="background:  #C6BF8B">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">����
      ���������:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
				
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������� �� �����c.����� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="��������� �� �����c.����� �����" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���������� �� ���� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="���������� �� ���� �����" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���� ������� %</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="���� ������� %" name="agentpercent" size="3" value="0" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
				
			--></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="�������� �����" maxlength="240" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�����
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="����� �����" maxlength="240" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="��� �����" maxlength="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�����������������
      ���� �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="����������������� ���� �����" maxlength="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">����������</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="CustName" maxlength="110" title="����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���������
      ����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="CustAccount" title="��������� ����" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ����������</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" title="��� ����������" maxlength="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ����������</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="CustKPP" title="��� ����������" maxlength="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<h3>������� �� ���� ����������� ���� � ���������� �����: </h3>
<table width="550" border="0" cellpadding="4" cellspacing="1" style="background:  #C6BF8B">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">����
      ���������:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
				
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������� �� �����c.����� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="��������� �� �����c.����� �����" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���������� �� ���� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="���������� �� ���� �����" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���� ������� %</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="���� ������� %" name="agentpercent" size="3" value="0" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
				
			--></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="�������� �����" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�����
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="����� �����" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="��� �����" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankINN" title="��� �����" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="BankKPP" title="��� �����" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���.
      ���� �����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_9" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="���. ���� �����" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="���������� ����" onClick="document.forms.atm_form.DepositAccount.disabled=false;document.forms.atm_form.FaceAccount.disabled=true;document.forms.atm_form.RubAccount.disabled=true" type="radio" checked name="Account">
      ���������� ����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">� �����������
      �����<br>
        <input value="" id="iF_10" style="border: #C6BF8B 1px solid; width: 100%" name="DepositAccount" maxlength="50" title="� ����������� �����" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="������� ����" onClick="document.forms.atm_form.DepositAccount.disabled=true;document.forms.atm_form.FaceAccount.disabled=false;document.forms.atm_form.RubAccount.disabled=false" type="radio" name="Account">
      ������� ����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">� ������������������
      �����
        <input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="RubAccount" title="� ������������������ �����" maxlength="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
      � ��������� �������� �����
      <input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="FaceAccount" title="� ��������� �������� �����" maxlength="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">������� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="tmpLastName" maxlength="50" title="������� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_14" style="border: #C6BF8B 1px solid; width: 100%" name="tmpFirstName" maxlength="50" title="��� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�������� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_15" style="border: #C6BF8B 1px solid; width: 100%" name="tmpMiddleName" maxlength="50" title="�������� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ���������� (���� ����)</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_16" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" maxlength="12" title="��� ���������� (���� ����)" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<p>���������� ����, ������ ���������� ���� ����������� ���� &#8212; ����, �����������
  ������ ��� ���������� ���, ��� ������� � ����������� �������� ������� �/���
  ��������������� �� ����� ������� ��� �������� �������������.</p>
<p>��������� ����������� ����� ��� ������������ � ����������� ���� ���������
  ����������, � ��� ���������� ����� �� ���������� ���� ����������� ���� �����-����������
  ���������� ����� ������ ����� ����������� ����� ����������� ����. ������, ���
  ������������ ���������� �������� �������� ���������� ��� ����� ����� ���������
  ��� �������� ������� �����.</p>
<p>������� ����, ������ ������� � ������ ������������������ ����������� �����,
  - ���� �����, ��������������� ��� ����� ������� ���������� ���. ��������� ����������
  ������ (������������� �����, ��������� �����, ���������� ����� � �.�.) � �����,
  ����� ����������� �� ����� ���������� ����� ��� ����������, �����������������
  ����� ������� (����) ������, � ��� ������� ������� ����������� ��������� �������
  ���� (�������), � ������ ������������������, �� �������� ������� ������������
  ���� ������� ������� �������.</p>
<h3>������� �� ���� ����������� ���� � �� ��:</h3>
<table border="0" cellspacing="1" cellpadding="4" style="background:  #C6BF8B" width="550">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">����
      ���������:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
        
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������� �� �����c.����� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="��������� �� �����c.����� �����" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���������� �� ���� �����</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="���������� �� ���� �����" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
        
    --></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">������� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" name="tmpLastName" maxlength="50" title="������� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="tmpFirstName" maxlength="50" title="��� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�������� </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="tmpMiddleName" maxlength="50" title="�������� ����������" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ���������� (���� ����)</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" title="��� ����������" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�����
      ��������� �� ��</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="����� ��������� �� ��" MAXLENGTH="30" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">��������
      ��������� �� ��</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="�������� ��������� �� ��" MAXLENGTH="100" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ��������� �� ��</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_9" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="��� ��������� �� ��" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">�/�
      ��������� �� ��</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_10" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="�/� ��������� �� ��" MAXLENGTH="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="���������� ����" onClick="document.forms.atm_form.DepositAccount.disabled=false;document.forms.atm_form.FaceAccount.disabled=true;document.forms.atm_form.RubAccount.disabled=true" type="radio" checked name="Account">
      ���������� ����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">� �����������
      �����<br>
        <input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="DepositAccount" title="� ����������� �����" maxlength="35" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="������� ����" onClick="document.forms.atm_form.DepositAccount.disabled=true;document.forms.atm_form.FaceAccount.disabled=false;document.forms.atm_form.RubAccount.disabled=false" type="radio" name="Account">
      ������� ����</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">� ������������������
      �����
        <input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="RubAccount" title="� ������������������ �����" maxlength="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
      � ��������� �������� �����
      <input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="FaceAccount" title="� ��������� �������� �����" maxlength="35" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">���
      ��������� �� ��</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_14" style="border: #C6BF8B 1px solid; width: 100%" name="BankINN" title="��� ��������� �� ��" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<br>

</body>
</html>
