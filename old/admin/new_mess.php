<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//������ ���������� ������ �� ���������

if($fl=='send_new')
{
  //��������
  send_intro_mess(1, $dlya, $memail, $subj, $mess, $zakaz);
  if(trim($ret)!=''){header("location: $ret");}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>����� ���������</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../../add_html.js"> </script>
</head>
<body>
<form name="send_new" action="new_mess.php">
<table width="100%" border="0" cellpadding="6" cellspacing="1" bgcolor="#F5F5F5">
<tr>
  <td colspan="3" style="padding:0px" bgColor="#F5F5F5">
  	<table width="100%" cellspacing="0" cellpadding="0">
      <tr>
    	<td width="100%">
<?php
//������� �� ������ ������ ����������
if($resp=='autor')
{
  $wk_r=mysql_query("SELECT * FROM ri_works, ri_user WHERE ri_works.manager=ri_user.number AND ri_works.number=$about");
  $wk_n=mysql_num_rows($wk_r);
  if($wk_n>0)
  {
    //�������� ������������ ������ ������ � ������
	$email=mysql_result($wk_r,0,'ri_user.login');
	$unum=mysql_result($wk_r,0,'ri_user.number');
	$mobila=mysql_result($wk_r,0,'ri_user.mobila');	
	$icq=mysql_result($wk_r,0,'ri_user.icq');	
	$komu=mysql_result($wk_r,0,'ri_user.family');
	$zakaz=0;
	$tema=mysql_result($wk_r,0,'ri_works.name');
	$id_work=mysql_result($wk_r,0,'ri_works.number');
	$dlya=mysql_result($wk_r,0,'ri_user.number');
	echo("������ ������ <a style='font-weight:bold' href='personal_data.php?unum=$unum' target='_blank' title='�������� ������ ������ (����������� � ����� ����)'>$komu</a>, �� ������� ������ Id $id_work �� ���� <b>'$tema'</b>");
  }
}
if($resp=='zakaz')
{
  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$about");
  //echo("SELECT * FROM ri_zakaz, ri_work WHERE ri_zakaz.work=ri_work.number AND ri_zakaz.number=$about<br>$zk_r<br>");
  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0)
  {
    //������������ ���������
	$email=mysql_result($zk_r,0,'ri_zakaz.email');
	$komu=mysql_result($zk_r,0,'ri_zakaz.user');
	$zakaz=mysql_result($zk_r,0,'ri_zakaz.number');
	$tema=mysql_result($zk_r,0,'ri_works.name');
	$id_work=mysql_result($zk_r,0,'ri_zakaz.work');
	$dlya=0;
	echo("������ ��������� $komu ($email), �� ������� <a href='zakaz_datas.php?znum=$zakaz'>������ Id $zakaz</a> (<a href='adm_works_ed.php?wnum=$id_work'>������ Id $id_work �� ���� '$tema'</a>)");
  }
}
?>
<input name="memail" type="hidden" id="memail" value="<?php echo($email);?>">
<input name="dlya" type="hidden" id="dlya" value="<?php echo($dlya);?>">
<input name="zakaz" type="hidden" id="zakaz" value="<?php echo($zakaz);?>">
<input name="ret" type="hidden" id="ret" value="<?php echo($ret);?>"></td>
		<td nowrap="nowrap">
    	<?php if(!$m_icq) /*���� ��� icq*/ {?><img src="http://www.diplom.com.ru/images/icq_unknown.gif" border="0" hspace="6" align="absmiddle" width="11" height="11" title="icq uin ����������" onerror="this.src='images/icq_error.gif';"><?php } else { ?><a href="http://chat.mirabilis.com/scripts/contact.dll?msgto=<? echo($icq); ?>" class="link1"><img src="http://status.icq.com/online.gif?icq=<? echo($icq); ?>&img=7" border="0" align="absmiddle" hspace="8" title="������� ������" onerror="this.src='images/icq_error.gif';">icq:</a><? }?></td>
    	<td nowrap="nowrap"><img src="http://www.diplom.com.ru/images/mobila.gif" width="16" height="16"> <?php echo($mobila);?></td>
      </tr>
    </table></td>
  <tr>
  <td nowrap><h4>��������� <?php if($resp=='autor'){echo("������");}else{echo("���������");}?> </h4></td>
  <td nowrap bgcolor="#FFFFFF" style="padding:0px"><h4><img src="../../images/outbox.gif" width="51" height="42" vspace="0" align="absmiddle" style="padding-right:6px; margin-right:6px">���� ��������� <img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></h4></td>
  <td width="100%"><input name="subj" type="text" id="subj" style="width:100%; border:solid #666666 1px" value="�� �������� �������� Referats.info: <?php echo($tema);?>"></td>
  <tr bgcolor="#F5F5F5">
    <td colspan="3" valign="top" id="txtInside"><table width="100%"  cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" valign="top"><textarea name="mess" 
rows="16" id="mess" style="width:100%;font-size:9pt" onKeyDown="document.getElementById('view_message').innerHTML=this.value" onDblClick='this.rows+=14' title='������� ������ �������� ������� ����� ������.'>������������.<br><br>
<?php if($resp=='autor') {?>
�� ��������� �� ����� �������� �������� <a href=http://www.referats.info>Referats.info</a> ���������� ������ <a href=http://www.referats.info/content.php?wnum=<?php echo($id_work);?>>'<?php echo($tema);?>'<a>.

 <? } ?>
</textarea></td>
        <td width="50%" valign="top" bgcolor="#FFFFFF" style="padding:6px"><span id="view_message"></span></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<span id="txtArea"></span>
<b>�������:</b>
<br>
<span class="link" onClick="addHTML('<P></P>');">&lt;P&gt;</span> | <span class="link" onClick="addHTML('<BR>');">&lt;BR&gt;</span> | <span class="link" onClick="addHTML('<B></B>');">&lt;B&gt;</span> | <span style="color:red; text-decoration:underline; cursor:hand" onClick="addHTML('<span style=color:red></span>');">color=&quot;red&quot;</span> |<br> 
<span class="link" onClick="addHTML('<p>�� ���������� �� ����� ����� ���������� ������ <?php echo ('<a href=http://www.referats.info/content.php?wnum='.$id_work.'><b>'.$tema.'</b></a>'); ?>. �� ������ ������� � ��� � ������� 1-3-� ���� � ������� � ������.</p><p>�������� �� ��������� ������ ������� ��������� �����: <a href=http://www.referats.info/payment/payment_info.htm>http://www.referats.info/payment/payment_info.htm</a>. ����������, ����� ������ ����������� ��������� ��� �� ����!</p><p>���� ��� ����� ���������� ���������� ������, �� ������ �������� � �����:<a href=http://www.diplom.com.ru/order.php>http://www.diplom.com.ru/order.php</a></p>');"><b class="green">��
������ ������� ��� ���������� �� ����� ����� ���������� ������ � ������� 1-3
���� � ������� � ������...</b></span>
<br>
<span class="link" onClick="addHTML('<p>�������� �� ��������� ������ ������� ��������� �����:<a href=http://www.referats.info/payment/payment_info.htm>http://www.referats.info/payment/payment_info.htm</a>.</p>');"><strong>������
�� �������� �� ��������� ������</strong></span> | <span class="link" onClick="addHTML('<P>� ���������, ������������� �������� �������� <a href=http://www.referats.info>Referats.info</a>.</P>');"><strong>Good
Bye!</strong></span>
      <input name="fl" type="hidden" id="fl3" value="send_new">
      <br>
      <input name="Button" type="submit" class="topPad6" value="�������">
</form>
<!-- ����� ���� ������� ������ ��������� �� ������ ������/������ -->
<?php
if($about>0)
{
  //������� ������ ���� ��������� �� ������� ������
  $ms_r=mysql_query("SELECT * FROM ri_mess WHERE zakaz=$about AND direct='1' ORDER BY number DESC");
  $ms_n=mysql_num_rows($ms_r);
  echo("<table width=100% border=0 cellpadding=2 cellspacing=1 bgcolor=#CCCCCC>");
  for($i=0;$i<$ms_n;$i++)
  {
    $mnum=mysql_result($ms_r,$i,'number');
    $mdata=rustime(mysql_result($ms_r,$i,'data'));
    $mtimer=mysql_result($ms_r,$i,'timer');
    $mfrom=mysql_result($ms_r,$i,'from_user');
    $mto=mysql_result($ms_r,$i,'to_user');
    $mdirect=mysql_result($ms_r,$i,'direct');
    $memail=mysql_result($ms_r,$i,'email');
    $msubj=mysql_result($ms_r,$i,'subj');
    $mmess=rawurldecode(mysql_result($ms_r,$i,'mess'));
	$bgc='#FFFFFF';
	$imgg='<img src=../images/arrows/arrow_sm_down_green.gif align=absmiddle border=1 hSpace=4>';
	if($mfrom==1)
	{
	  $bgc='#EEEEFF';
	  $imgg='<img src=../images/arrows/arrow_sm_up_blue.gif align=absmiddle border=1 hSpace=4>';
	}
	echo("<tr bgcolor=$bgc><td>$imgg</td><td><b>$msubj</b><br>$mmess</td></tr>");
  }
  echo("</table>");
}
?>
</body>
</html>
<?php
}//work end
?>