<?php
session_start();
require('../../connect_db.php');
require('../access.php');

if(access($S_NUM_USER, 'rigths_adm')){//������ ���������� ������ �� ���������

if($fl=='new')
{
  //�������� ����� ������
  echo("�������� ����� $page<br>");
  $flag='N';
  if(isset($new_rts)){$flag='Y';}
  mysql_query("INSERT INTO ri_rights ( user, page, `right` ) VALUES ( 0, '$page', '$flag' )");
  $fl='refresh';
}
if($fl=='refresh')
{
  //�������� ������� (�������� �����������)
  $rg0_r=mysql_query("SELECT * FROM ri_rights WHERE user=0");
  $rg0_n=mysql_num_rows($rg0_r);
  for($i=0;$i<$rg0_n;$i++)
  {
    //��������� ��� ������� �����!
	$rgpage=mysql_result($rg0_r,$i,'page');
	//echo("�������� $rgpage<br>");
	$rgflag=mysql_result($rg0_r,$i,'right');
	$us_r=mysql_query("SELECT * FROM ri_user");
	$us_n=mysql_num_rows($us_r);
	for($j=0;$j<$us_n;$j++)
	{
	  $unum=mysql_result($us_r,$j,'number');
	  $rg_r=mysql_query("SELECT * FROM ri_rights WHERE user=$unum AND page='$rgpage'");
	  $rg_n=mysql_num_rows($rg_r);
	  if($rg_n==0)
	  {
	    //��������!
	    mysql_query("INSERT INTO ri_rights ( user, page, `right` ) VALUES ( $unum, '$rgpage', '$rgflag' )");
	  }
	}
  }
}

if($fl=='change')
{
  //�������� ��������� ������� ���� ��� ���������� ������������
  $rg_r=mysql_query("SELECT * FROM ri_rights WHERE user=$user");
  $rg_n=mysql_num_rows($rg_r);
  for($i=0;$i<$rg_n;$i++)
  {
    $rgnum=mysql_result($rg_r,$i,'number');
    if(isset($rts[$rgnum]))
	{
	  mysql_query("UPDATE ri_rights SET `right`='Y' WHERE number=$rgnum");
	}
	else
	{
	  mysql_query("UPDATE ri_rights SET `right`='N' WHERE number=$rgnum");
	}
  }
}
?>
<html>
<head>
<title>����������������� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="2" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#FFFFFF">�������� ������������ �� ������ ��� ��������� � �������������� ��� ����:
<form action="rigths_adm.php" method="post">
<select name="user" onChange="location.href='rigths_adm.php?user='+this.options[this.selectedIndex].value">
<option value="rigths_adm.php?user=0">-�����-</option>
<?php
$us_r=mysql_query("SELECT * FROM ri_user ORDER BY login");
$us_n=mysql_num_rows($us_r);
for($i=0;$i<$us_n;$i++)
{
  $unum=mysql_result($us_r,$i,'number');
  $login=mysql_result($us_r,$i,'login');
  $name=mysql_result($us_r,$i,'family').' '.mysql_result($us_r,$i,'name').' '.mysql_result($us_r,$i,'otch');
  echo("<option value='$unum'");
  if($user==$unum){echo(" selected");}
  echo(">$login ($name)</option>\n");
}
?>
</select><br>
<?php
$user=$user+1-1;
$rg_r=mysql_query("SELECT * FROM ri_rights WHERE user=$user");
$rg_n=mysql_num_rows($rg_r);
for($i=0;$i<$rg_n;$i++)
{
  $rgnum=mysql_result($rg_r,$i,'number');
  $rgpage=mysql_result($rg_r,$i,'page');
  $rgight=mysql_result($rg_r,$i,'right');
  if($rgight=='Y'){$rgight='checked';}else{$rgight='';}
  echo("<span style='background-color:#88FF88'><input type=checkbox name=rts[$rgnum] value='on' $rgight>&nbsp;$rgpage</span>&nbsp;");
}
?><br>
<input name="fl" type="hidden" value="change">
<input type="submit" value="����������� ���������">
</form>
</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
	  <a href="rigths_adm.php?fl=refresh">�������� ������</a>
	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">�������� ����� ������:
<form action="rigths_adm.php" method="post">
��� �������: <input type="text" name="page"> ��������� �� ��������� <input type="checkbox" value="on" name="new_rts"> <input type="submit" value="��������">
<input name="fl" type="hidden" id="fl" value="new">
</form>
</td>
  </tr>
</table>

</body>
</html>
<?php
}//end work
else
{echo("<head><title>����������������� ����</title><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></head><center><h2>��������, �� � ��� ��� ���� ��� ������ � ���� ��������!</h2></center>");}
?>