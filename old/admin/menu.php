<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../banking_function.php');

if(access($S_NUM_USER, 'rigths_adm')){//������ ���������� ������ �� ���������

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������������� ����</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function jumpMenu(targ,selObj,restore){ //v3.0
  if (selObj.options[selObj.selectedIndex].value.indexOf('../index.php')==-1)	{
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
  }
  else window.top.location.href=selObj.options[selObj.selectedIndex].value;
}

//-->
</script>
<style type="text/css">
<!--
.style1 {font-family: "Courier New", Courier, mono; text-decoration: none;}
.style1:hover {text-decoration:underline}
-->
</style>
</head>
<body style="margin-right:0px;">
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" nowrap><h4><font face="Courier New, Courier, mono">[<a href="home.php" target="mainFrame" class="style1" title="Go Home, Amogo! :)">Admin</a>].</font><a href="../../index.php" target="_top" class="style1 red" title="������� � ��������� ������">referats.info</a></h4></td>
    <td align="right" nowrap>
      <select name="worx" onChange="MM_jumpMenu('parent.frames[\'mainFrame\']',this,1)">
  <option value="../../admin/0" selected style="background-color:#DEFFCE">-������-</option>
  		<option value="orders_overview.php">&sum; �����</option>
	<option value="applications_paid.php?title=������&amp;where= AND ri_zakaz.status=1">&upsih; ������</option>
  <option value="applications_paid.php?title=������&amp;where= AND ri_zakaz.status=2">&Omega; ����������</option>
  <option value="applications_paid.php?title=����������&amp;where= AND ri_zakaz.status=4">@ ����������</option>
  <option value="applications_paid.php?title=����������&amp;where= AND ri_zakaz.status=5">&#8224; ����������</option>
  <option value="applications_paid.php?title=�����&amp;where= AND ri_zakaz.status=6">&Oslash; �����</option>
  <option value="applications_paid.php?title=��������&amp;where= AND ri_zakaz.status=-2"># ���������</option>
      </select><select name="worx" onChange="MM_jumpMenu('parent.frames[\'mainFrame\']',this,1)">
      <option value="../../admin/0" selected style="background-color:#B7FBD3">-������-</option>
      <option value="worx.php">&infin; �����</option>
      <option value="worx.php?only_new=on">&iquest; ���������.</option>
      <option value="worx.php?only_reconfirm=on">&ne; ����������</option>
      <option value="worx.php?only_new=off"> &#8226; ������������</option>
      </select><select name="select" onChange="MM_jumpMenu('parent.frames[\'mainFrame\']',this,0)">
        <option value="../../admin/0" selected style="background-color:#CCFFFF">-���������-</option>
        <option value="messages.php?status=0&amp;fl=filter">@! �����</option>
        <option value="messages.php?status=1&amp;input=on&amp;output=off&amp;fl=filter">@? ������������</option>
        <option value="messages.php?input=on&amp;output=off&amp;fl=filter&amp;status=-2">@&alpha; ��� ��������</option>
        <option value="messages.php?input=on&amp;output=on&amp;fl=filter&amp;autors=on&amp;zakazs=on&amp;status=-2">@@ ���</option>
        <option value="messages.php?status=-1&amp;input=on&amp;output=on&amp;fl=filter&amp;autors=&amp;last_status=-2">@&loz; �����</option></select><!--if (this.options[this.selectedIndex].value) window.top.mainFrame.location.href=this.options[this.selectedIndex].value; this.selectedIndex=0;--><select name="service" onChange="MM_jumpMenu('parent.frames[\'mainFrame\']',this,1)">
          <option value="../../admin/0" selected style="background-color:#DFDDFF">-������-</option>
          <option value="autors.php">&sect; ������</option>
          <option value="../../admin/!application_customers.php">&Auml; ���������</option>	
          <option value="../../admin/!order_customers.php">&Aring; �������</option>	
          <option value="money.php">$ �������� �/�</option>
		  <option value="../../admin/docs">&part; ������������</option>
      </select><select name="statistics" onChange="MM_jumpMenu('parent.frames[\'mainFrame\']',this,1)">
          <option value="../../admin/0" selected style="background-color:#F2DBF2">-����������-</option>
          <option value="searchers.php">&#8240; ������</option>
          <option value="../../admin/!/!queries.php">&plusmn; �������</option>
          <option value="../../admin/!/!pages_statistics.php">&para; �������</option>
      </select><select name="admin" onChange="jumpMenu('parent.frames[\'mainFrame\']',this,1)">
        <option value="0" selected style="background-color: #FFE9D2">-����������-</option>
        <option value="home.php" style="font-weight:900">&Delta; HOME</option>
		<option value="personal_data.php?unum=<?php echo($S_NUM_USER);?>">&Theta; ���
        ������</option>
        <option value="rigths_adm.php">&theta; ����� �������</option>
        <option value="sheduler_manager.php">&radic; �����������</option>
 	   <option value="customizing.php">&fnof; ���������</option>
 	   <option value="reminder.php">&scaron; �����������</option>
        <option value="../index.php?flag_res=Y">&times; �����</option>
      </select></td>
  </tr>
</table>
</body>
</html>
<?php  
	//This is the end :)
							}?>