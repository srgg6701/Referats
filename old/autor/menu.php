<?php
session_start();
require('../../connect_db.php');
require('../access.php');

if(access($S_NUM_USER, 'main')){//������ ���������� ������ �� ���������

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'family');

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>����</title>
<link href="autor.css" rel="stylesheet" type="text/css">
<style>
a {text-decoration:none;}
.linkPad {padding-bottom:2px;padding-top:2px}
hr { color:lime}
</style>
<script language="JavaScript" type="text/JavaScript">
function colorizeLink () {
if (event.srcElement.tagName=='A'&&event.srcElement.parentNode.style.backgroundColor!='lime') event.srcElement.parentNode.style.backgroundColor='#B9FFB9'
}
function uncolorizeLink () {
if (event.srcElement.tagName=='A'&&event.srcElement.parentNode.style.backgroundColor!='lime') event.srcElement.parentNode.style.backgroundColor=''
}
document.onmouseover=colorizeLink; document.onmouseout=uncolorizeLink; 
</script>
</head>
<body style="margin-right:0"><? require ("../../temp_transparency_author.php");?>
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="home.php" target="mainFrame"><img src="../../images/a28cmp2.gif" alt="�������� �������� [����� ���������� � ���������]" width="66" height="57" hspace="0" border="1" align="left" onMouseOver="this.style.border='solid 1px lime'" onMouseOut="this.style.border='solid 1px white'" style="border:solid 1px white"></a></td>
    <td width="100%" bgcolor="#ECEFFB" style="padding-left:2px">������,<br>
      <span class="green"><b><?php echo("$name");?><br>
    </b></span>�������� ������! :) </td>
  </tr>
</table>
<hr size="1" noshade>
<b><div class="linkPad" id="home"><a href="home.php" target="mainFrame" title="�������� �������� [����� ���������� � ���������].">Home</a></div></b>
<div class="linkPad" id="ed_works_ed"><a href="ed_works_ed.php?wnum=0&ret=worx.php" target="mainFrame" title="�������� � ��� ������� ��� ���� ���� ������!"><strong><font color="#FF0000">+</font></strong> �������� ������ </a></div>
<hr size="1" noshade>
<div class="linkPad" id="worx"><a href="worx.php" target="mainFrame" title="������ ��� ����������� ���� �����.">������������ ������</a></div>
<hr size="1" noshade>
<div class="linkPad" id="applications"><a href="applications.php" target="mainFrame" class="red" title="������ ���������� �� ���� ������ &#8212; ����������, �������� ���������� � ������������."> &nbsp;<strong>!</strong> ������ ���������� </a></div>
<div class="linkPad" id="applications_paid4"><a href="applications_paid.php?where= AND ri_zakaz.status=4&title=������������ ������" target="mainFrame" title="������, ������� �� ������ ���� �������� ����������.">������������ ������</a></div>
<div class="linkPad" id="applications_paid5"><a href="applications_paid.php?where= AND ri_zakaz.status=5&title=�������������" target="mainFrame" title="������, ������� �� ��� ���� �� ���������. �� ����������� ��������! :)">�������������</a></div>
<div class="linkPad" id="applications_paid6"><a href="applications_paid.php?where= AND ri_zakaz.status=6&title=�������� ������" target="mainFrame" title="������, �� ������� �� � ���� ��������� ������������.">�������� ������</a></div>
<hr size="1" noshade>
<div class="linkPad" id="my_messages"><a href="my_messages.php" target="mainFrame" title="��������� ����� ����, ����������� � ��������������.">���������</a></div>
<div class="linkPad" id="my_param"><a href="my_param.php" target="mainFrame" title="��, ��� �� � ���� ��������. ����� ��������� :)">��� ������</a></div>
<div class="linkPad" id="help"><a href="help.php" target="mainFrame" title="������ 911 :)">������</a></div>
<div class="linkPad" id="faq"><a href="faq.php" target="mainFrame" title="������ �� ����� ������������� �������."><b class="red">?</b>  FAQ</a></div>
<div class="linkPad" id="feedback"><a href="feedback.php" target="mainFrame" title="����� ����� ������� ���������� �����������... :)">��������</a></div>
<hr size="1" noshade>
<div class="linkPad"><a href="../../index.php?flag_res=Y" target="_top" title="�����.">�����</a></div>
<br>
<?php 
$zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE email='$login'");
$zk_n=mysql_num_rows($zk_r);
if($zk_n>0){
$pass=mysql_result($zk_r,0,'number')*12345;
echo("<div class='linkPad'><a href='../autorization.php?login=$login&pass=$pass' target='_top'><img src='../images/switch.gif' alt='������������� �� ���� ������� ���������!' border='0'></a></div>");
}?>
</body>
</html>
<?php
}//end work
?>