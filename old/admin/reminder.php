<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//������ ���������� ������ �� ���������

$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.status=1");
$zk_n=mysql_num_rows($zk_r);

if($fl=='change')
{
  //�������� ����� �������� ����������
  $sh_r=mysql_query("SELECT * FROM ri_shedule WHERE number=$shed_num");
  $script=mysql_result($sh_r,0,'script');
  //������� �����
  $p0=strpos($script,'(');
  $p1=strpos($script,',');
  $znum=substr($script,$p0+1,$p1-$p0-1);
  mysql_query("UPDATE ri_shedule SET script='autoreminder_zakaz_pay($znum, $reminds)' WHERE number=$shed_num");
}
if($fl=='send')
{
  //��������� �������� � �������������� ����� �������� ����������
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>��������� ����������� ���������</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
tr2colorize=new Array ();
function colorizeTR ()	{
if (event.srcElement.tagName=='A') {
	for (i=0;i<tr2colorize.length;i++)
		{

document.getElementById(tr2colorize[i]).style.backgroundColor='';		
		}
event.srcElement.parentNode.parentNode.style.backgroundColor='yellow';
	}
}	
</script>
</head>
<body>
<form name="form_change" action="reminder.php" method="post">
<script>
function SendMess()
{
  document.form_change.fl.value='send';
  document.form_change.submit();
}

function ChangeKolvo()
{
  document.form_change.fl.value='change';
  document.form_change.submit();
}

function SetParam(script,shnum,shrem)
{
  document.form_change.reminds.value=script;
  document.form_change.remark.value=shrem;
  document.form_change.shed_num.value=shnum;
}
</script>
<div class="bottomPad6"><b><b>��������� �������������� </b>����������� ���������</b></div>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td align="center"><a href="#">ID</a></td>
    <td align="center" nowrap><a href="#">�����.</a></td>
    <td nowrap><a href="#">����</a></td>
    <td nowrap><a href="#">��������</a></td>
    <td nowrap><a href="#">���.</a></td>
    <td width="100%" nowrap><a href="#">����</a></td>
    <td nowrap><a href="#">���������</a></td>
    <td align="center" nowrap><a href="#">���������</a></td>
    <td align="center" nowrap><a href="#">����</a></td>
    <td align="center" nowrap><a href="#">���������</a></td>
    <td align="center" nowrap><a href="#">����</a></td>
    <td nowrap><a href="#">�����</a></td>
  </tr>
<?php
$ii=0;
for($i=0;$i<$zk_n;$i++)
{
  $znum=mysql_result($zk_r,$i,'ri_zakaz.number');
  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
  $zemail=mysql_result($zk_r,$i,'ri_zakaz.email');
  $zour_summ=mysql_result($zk_r,$i,'ri_zakaz.summ_our');
  $zdata=rustime(mysql_result($zk_r,$i,'ri_zakaz.data'));
  $zdata_to=rustime(mysql_result($zk_r,$i,'ri_zakaz.data_to'));
  $zsubj=mysql_result($zk_r,$i,'ri_works.name');
  $wtip=mysql_result($zk_r,$i,'ri_works.tip');
  $tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $wtip_s=mysql_result($tw_r,0,'tip');
  //����������� ���� ���������� ��� ���
  $ts="autoreminder_zakaz_pay($znum,";
  $sh_r=mysql_query("SELECT * FROM ri_shedule WHERE script LIKE '%$ts%'");
  $sh_n=mysql_num_rows($sh_r);
  if($sh_n>0)
  {
    $script=mysql_result($sh_r,0,'script');
	$p0=strpos($script,',');
	$script=substr($script,$p0+1,99);
	$p0=strpos($script,')');
	$script=substr($script,0,$p0);
	$shnum=mysql_result($sh_r,0,'number');
	$shrem=mysql_result($sh_r,0,'remark');
	$ts="������������, $zuser!<br><br>�� �������� �� ����� referats.info ������ �� ���� \'$zsubj\'.<br>����������, ��� ��� ��������� ������ ��� ����� �������� $zour_summ ���.<hr>� ���������<br>�������������<br><br>P.S. ��� ��������� ���������� ������ ������(�������) ���������, �� ���� <a href=\'http://referats.info/autorization.php?login=$zemail&pass=".($znum*12345)."\'>������</a>";
    echo("<tr bgcolor='#FFFFFF' id='tr_$ii'>
    <td align='right'>$znum<script>tr2colorize[$ii]='tr_$ii';</script></td>
    <td align='right'>$zdata</td>
    <td><a href='#' class='green'>$zdata_to</a></td>
    <td><a href='mailto:$zemail'>$zuser</a></td>
    <td><a href='#' title='������� � ��������� ���������� ������' class='green'>$wtip_s</a></td>
    <td><a href='zakaz_datas.php?znum=$znum' title='$zsubj'>$zsubj</a></td>
	<td><a href=\"#\" onClick=\"SetParam($script,$shnum,'$ts'); colorizeTR();\">��������</a></td>
    <td align='right'><a href='#' class='green'>1000</a></td>
    <td align='right'><a href='#' class='green'>750</a></td>
    <td align='right'>250</td>
    <td align='center'>25</td>
    <td><a href=''>?</a></td>
	</tr>");
	$ii++;
  }
}
?>
  <tr bgcolor="#FFFFFF">
    <td colspan="12"><table width="100%"  cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" nowrap><b>�����������:</b>
          <div style="background-color:#CCCCCC ">
��������
  <input name="reminds" type="text" id="reminds" value="5" size="3">
</div>
          <input name="Submit" type="button" class="topPad6" value="��������" onClick="ChangeKolvo();">          
          <input name="shed_num" type="hidden" id="shed_num"></td>
        <td valign="top"><img src="../../images/spacer.gif" width="10" height="10"></td>
        <td width="100%" valign="top"><b>������� �����������</b>          <textarea name="remark" rows="5" id="remark" style="width:100%"></textarea></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<div align="right">
  <input name="fl" type="hidden" id="fl">
  <input name="Submit" type="button" class="topPad6" value="�������� ����������������� ��������� ������" onClick="SendMess();">
</div>
</form>
</body>
</html>
<?php
}//end work
?>