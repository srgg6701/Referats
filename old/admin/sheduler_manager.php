<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//������ ���������� ������ �� ���������

if(isset($del))
{
  mysql_query("DELETE FROM ri_shedule WHERE number=$del");
}
?>
<html>
<head>
<title>���������� ���������(���������)</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="admin.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="0" marginheight="0">
<p>������ <strong>�������</strong> �� �������� ������������, ������� ����� ����� ��������� �������� �� ����� <strong>�������</strong>:
</p>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr valign="top" bgcolor="#CCCCCC">
    <td width="23%"><strong>remember_zakaz(44)</strong></td>
    <td width="77%">��������� � ������ id 44</td>
  </tr>
  <tr valign="top">
    <td><strong>remember_take_work(396)</strong></td>
    <td>��������� � ��������������� ������������ �������� �������� ��� ������.
      396 � ������ ������ - ��� ���������� ������, ����� ����������� - ����������</td>
  </tr>
  <tr valign="top" bgcolor="#CCCCCC">
    <td><strong> remember_maker_paj(89, 42)</strong></td>
    <td>���������� � ������������� ��������� 42-�� ����������� ������ �� 89-�
      ������</td>
  </tr>
  <tr valign="top">
    <td><strong>remember_zakaz_moscow(44)</strong></td>
    <td>��������� � ������ 44 ��� palmir`�</td>
  </tr>
  <tr valign="top" bgcolor="#CCCCCC">
    <td><strong>notes_toad(193)</strong></td>
    <td>������������� ��������� ��� ����������, ���� � ������� ���� ����� ��
      �������� ���������, �� ���������� �������� ��������� � ����������</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td colspan="2"><font color="#FF0000">*����������. ������� ����������� (���������� &quot;1&quot;), �����
      ������������ ���������� ���������. � ������� ������������ (�������� &quot;�&quot;),
      ����� ���������� ������������ �������, �.�. ���� � ������� ������ ������
      48/11 - ��� ������, ��� ������� ��������� ����� 11, ����� ����� 48, 48,
      48... �����.</font></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="4" cellpadding="1" bgcolor="#CCCCCC">
  <tr>
    <td width="7%" bgcolor="#FFFFFF"><div align="center">����</div></td>
    <td width="12%" bgcolor="#FFFFFF"><div align="center">����/�����-<br>
    �������</div></td>
    <td width="20%" bgcolor="#FFFFFF"><div align="center">����� ������� ����� �����������/���������</div></td>
    <td width="34%" bgcolor="#FFFFFF"><div align="center">������</div></td>
    <td width="25%" bgcolor="#FFFFFF"><div align="center">����������</div></td>
    <td width="2%" bgcolor="#FFFFFF"><div align="center">&nbsp;</div></td>
  </tr>
<?php
$sh_r=mysql_query("SELECT * FROM ri_shedule ORDER BY data");
$sh_n=mysql_num_rows($sh_r);
for($i=0;$i<$sh_n;$i++)
{
  $data=rustime(mysql_result($sh_r,$i,'data'));
  $kratnost=mysql_result($sh_r,$i,'kratnost');
  $snum=mysql_result($sh_r,$i,'number');
  $period=mysql_result($sh_r,$i,'period');
  $script=mysql_result($sh_r,$i,'script');
  $remark=mysql_result($sh_r,$i,'remark');
  $enable=mysql_result($sh_r,$i,'enable');
  echo(" <tr>
    <td bgcolor='#FFFFFF' align='center'>$data</td>
    <td bgcolor='#FFFFFF' align='center'>");
	if($enable=='Y'){echo("M");}else{echo("1");}
	echo("</td>
    <td bgcolor='#FFFFFF' align='center'>$period/$kratnost</td>
    <td bgcolor='#FFFFFF' align='center'>$script</td>
    <td bgcolor='#FFFFFF' align='center'>$remark</td>
    <td bgcolor='#FFFFFF' align='center'><a href='sheduler_manager.php?del=$snum'>�������</a></td>
  </tr>");
}
?>
</table>
</body>
</html>
<?php
}//end work
?>