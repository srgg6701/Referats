<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

echo($_NUM_USER);
if(access($S_NUM_USER, 'main')){//������ ���������� ������ �� ���������

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE number=$mnum");
$ms_n=mysql_num_rows($ms_r);
$mdata=rustime(mysql_result($ms_r,0,'data'));
$mzakaz=mysql_result($ms_r,0,'zakaz');
$mfrom=mysql_result($ms_r,0,'from_user');
$mto=mysql_result($ms_r,0,'to_user');
$memail=mysql_result($ms_r,0,'email');
$msubj=mysql_result($ms_r,0,'subj');
$mmess=rawurldecode(mysql_result($ms_r,0,'mess'));
$mstatus=mysql_result($ms_r,0,'status');
if($mstatus==0){mysql_query("UPDATE ri_mess SET status=1 WHERE number=$mnum");}
//���������� ����������� � ���(��./���.)
//���������� �����������
if($mfrom!=$S_NUM_USER){$resp=$mfrom;}
if($mto!=$S_NUM_USER){$resp=$mto;}
//����������

if($fl=='send_answer')
{
  mysql_query("UPDATE ri_mess SET status=2 WHERE number=$mnum AND to_user=$S_NUM_USER");
  //��������
  send_intro_mess($S_NUM_USER, 1, 'admin@referats.info', $insubj, $inmess, $mzakaz);
  header("location: http://www.referats.info/autor/my_messages.php?status=$status");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>�������� ���������</title>
<link href="autor.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
function sendAnswer (selfButton) {
document.getElementById('txtArea').style.display='block';
//������ ������� ���� ��� ����� ������

document.getElementById('2send').style.display='block';
//������ ������� ������ "���������"

selfButton.style.display='none';
//������ ��������� ������ "��������"

document.getElementById('txtLetter').style.display='none';
//������ ��������� ����������� ����� ��������� ���������
}

delMessVar=0;
function delMess()	{
if (delMessVar==1)//����������, ��� �� ������ �� ������ "������� ���������".	
	{if (confirm("�� �������, ��� ������ ������� ��� ��������� ��������?")) return true;
	else {delMessVar=0;return false;}}
else return true;		
}	
</script>

</head>
<body style="margin-right:0px"><? require ("../../temp_transparency_author.php");?>
<form name="send_ans" action="view_mess.php" method="post" onSubmit="return delMess();">
<table width="100%" border="0" cellpadding="6" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<?php
$bgc='#FFFFFF';
$picdirect='../images/arrows/arrow_sm_down_green.gif';
if($mfrom!=1) //���� ��������� ���������
{
$bgc='#66CCFF'; //��� ����� ���������
$bgctopic='#00ffff'; //��� ���� ���������
$picdirect='../images/arrows/outbox.gif'; //��������-������ ����������� ��������� (��������/���������)
$messevent='����������'; //��������� ��� �������� ������� �������� ���������
} 
else 
{
$bgc='#99FFCC'; 
$bgctopic='#CCFFCC'; 
$picdirect='../images/arrows/inbox.gif';
$messevent='��������'; //��������� ��� �������� ������� ��������� ���������
}
?>
  <td colspan="2" style="padding:0px" bgColor="<?php echo ($bgc); ?>">
  <table border="0" cellpadding="4" cellspacing="0">
<?php 
echo("<tr>
 <td nowrap><b>���� ���������:</b> $mdata</td>
  <td><table cellspacing='0' cellpadding='0' bgColor='#ffffff'>
  <tr>
    <td><img src=$picdirect border='1' align='absmiddle'></td>
  </tr>
</table>
</td>
 <td nowrap>$messevent �: __:__</td>
 <!--<td align=center nowrap>&nbsp;&nbsp;<b>ID:</b> $mnum</td>-->
 <td nowrap>&nbsp;<a href='' target='_blank' title='����������� ��� ��������� ���������'><img src='../images/pyctos/eye.gif' border='1'></a> (�����.)</td>
 <td>
 ");
if($msubj==''){$ts="&lt;��� ����&gt;";}else{$ts=$msubj;}
echo("</td></tr>");
?>
</table>
</td>
  <tr>
  <td nowrap>����<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
  <td width="100%" bgcolor=<?php echo ($bgctopic); ?>><input name="insubj" type="hidden" id="insubj" value="<?php echo($msubj);?>"><b><?php echo($ts);?></b></td>
<tr bgcolor="#F5F5F5">
  <td colspan="2" valign="top" id="txtInside"><input name="inmess" type="hidden" value=""><pre><span id="txtLetter"><?php echo($mmess);?></span></pre></td>
</tr>
</table>
<span id="txtArea" style="display:none">
<textarea name="inmess" style="width:100%"; rows=14>


�� ������ ������-�� �����:
--------------------------------------------------------------------------------------------------
<?php echo($mmess);?>
</textarea>
</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap>
	<!--  
������ �� ������ "��������" ���������� ��������� ���������:
1.��������� ����������� ����� ������ � ���������� <span id='txtLetter'> � ��������� ���� <textarea name='inmess'> �� ������� �������, ������ ���������� <span id='txtArea'>, ��� �������������� ������ ��� ������ ����������� ���� ��������� ������ ����������������.
2.����������� � ��� ���� ���������:
"�� ������ ������-�� �����:"
[������� ������]
"-----------------------------------------------------------------------------------------------------"
[������� ������]
����� ������������ ��������� (document.getElementById('txtLetter').innerHTML)
3.������ ���� ���� ��������� (this.style.display='none'), � ���������� ������ "���������!", �������� - ������� (document.getElementById('2send').style.display='block'). ����� �������, ������ ������� ����������� ����� ������ � ������. ��� ���� �� �������������� ����������.
4.������ ��������� ���� �� ����������� ������� ������ (document.getElementById('txtLetter').style.display='none')-->
	
	<!--document.getElementById('txtArea').innerHTML='<textarea name=\'inmess\' style=\'width:100%\'; rows=14>�� ������ ������-�� �����:\n--------------------------------------------------------------------------------------------------\n'-->
	<input name="answButton" type="button" class="topPad6" onClick="sendAnswer(this);" value="��������">        
    <span id="2send" style="display:none">
    <input name="submit" type="submit" class="topPad6" value="���������">
    </span>    <?php if($mfrom!=1)
{
echo ("<script language='JavaScript' type='text/JavaScript'>document.getElementById('answButton').style.display='none'; 
//alert();> 
</script>");
} 
?>
</td>
    <td align="right" nowrap><input name="Submit" type="submit" class="topPad6" style="color:#FF0000;font-weight:700;" onClick="delMessVar=1;" value="������� ���������">
<input type="submit" name="Submit" value="����������� � �����">
      <input name="status" type="hidden" id="status" value="<?php echo($status);?>">
        <input name="fl" type="hidden" id="fl3" value="send_answer">
<input name="mnum" type="hidden" id="mnum3" value="<?php echo($mnum);?>">
</td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//work end
?>