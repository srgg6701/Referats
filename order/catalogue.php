<?php
session_start();
require('../connect_db.php');
require('../old/lib.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>����� ������� ����������� ��������� �����. ������� �� ����� ��������� �����������.</title>
<meta name="description" content="����� ��������, ��������� ������, ����� ��������, ������
  �� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������.">
<meta name="keywords" content="����� ��������, ����� ��������, ������ �� �����, �������� �� �����, �������� ������, ��������� ������, ������� ��������, �����������, �������� ��������� ������, ���� ��������� �����, ��������.">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<script language="JavaScript" type="text/JavaScript" src="http://www.educationservice.ru/scripts/valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript" src="http://www.educationservice.ru/scripts/standart.js"></script>
<link href="order.css" rel="stylesheet" type="text/css" />

</head>
<body onload="MM_preloadImages('images/buttons/order_.jpg','images/buttons/faq_.jpg','images/buttons/contacts_.jpg')"><!-- #BeginLibraryItem "/Library/topPanel.lbi" --><table width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="index.html"><img src="images/logo.gif" alt="����� �������, ������� �� �����, �������� ������, �������� ������, ��������� �������, ����� ��������� ������, ��������� �� �����, �������� ��������� ������." width="309" height="26" hspace="0" vspace="1" border="0" title="�� �������." /></a></td>
    <td width="100%" align="center" valign="bottom"><a href="http://www.educationservice.ru#take_order" onmouseover="MM_swapImage('order','','images/buttons/order_.jpg',1)" onmouseout="MM_swapImgRestore()" style="cursor:default"><img src="images/buttons/order.jpg" title="��������!" alt="����� �������, ������� �� �����, �������� ������, �������� ������, ��������� �������, ����� ��������� ������, ��������� �� �����, �������� ��������� ������." name="order" width="127" height="24" hspace="1" vspace="1" border="0" id="order" /></a><a href="faq.htm" onmouseover="MM_swapImage('faq','','images/buttons/faq_.jpg',1)" onmouseout="MM_swapImgRestore()"  style="cursor:default"><img src="images/buttons/faq.jpg" alt="����� �����������." title="�������� ����� ������������� ������� � ������ �� ���." name="faq" width="109" height="24" vspace="1" border="0" id="faq" /></a><a href="contacts.htm" onmouseover="MM_swapImage('contacts','','images/buttons/contacts_.jpg',1)" onmouseout="MM_swapImgRestore()" style="cursor:default"><img src="images/buttons/contacts.jpg" alt="����� ���������, �������� ������." title="��������. ��������� � ����!" name="contacts" width="128" height="24" hspace="1" vspace="1" border="0" id="contacts" /></a></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#84B77B" style="border-top:solid 2px #009900"><img src="images/spacer.gif" width="8" height="6" /></td>
  </tr>
</table>
<!-- #EndLibraryItem --><p class=width755>
            <a href="index.html">����� ��������</a>, ��������� ������, ����� ��������, ������
�� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������.</p>
          
<?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY sort, predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  $psort=mysql_result($pr_r,$i,'sort');
  echo("<li><a href='worx.php?pnum=$pnum'");
  if($psort==9)
  {
    $p0=strpos($ppredmet,'>');
    $ppredmet=substr($ppredmet,$p0+1,9999);
    $p0=strpos($ppredmet,'<');
    $ppredmet=substr($ppredmet,0,$p0);
    echo(" class='myAccount'");
  }
  echo(">$ppredmet</a></li>\n");
}
?>
<p class=width755><a href="index.html">����� ��������</a>, ��������� ������, ����� ��������, ������
�� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������. </p>
</body>
</html>
