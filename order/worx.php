<?php
session_start();
require('../connect_db.php');
require('../old/lib.php');
statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($fl=='filter')
{
  $S_F_DIP=$dip;
  $S_F_KUR=$kur;
  $S_F_REF=$ref;
  $S_F_ALL=$all;
  $S_RAD_ORDER=$rad_order;
}
else
{
  $S_RAD_ORDER="name";
  //����� ��������
  if($pnum+1-1>0){$S_PREDMET_NUM=$pnum;}else{if($pnum!=-1){$S_PREDMET_NUM=0;}}
  $dp_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$S_PREDMET_NUM");
  $dp_n=mysql_num_rows($dp_r);
  if($dp_n>0){$predmet_name=mysql_result($dp_r,0,'predmet');}
}
$order="ORDER BY ri_works.".$S_RAD_ORDER;

$where="WHERE ";
if($S_PREDMET_NUM!=0){$where=$where."ri_works.predmet=$S_PREDMET_NUM AND ";}
$where=$where."enable='Y' AND ( ri_works.Number=0 ";
if($S_F_DIP=='on'){$where=$where."OR ri_works.tip=3 ";}
if($S_F_KUR=='on'){$where=$where."OR ri_works.tip=2 ";}
if($S_F_REF=='on'){$where=$where."OR ri_works.tip=1 ";}
if($S_F_ALL=='on'){$where=$where."OR ri_works.tip>3 ";}
if(!isset($S_F_ALL)){$where=$where."OR ri_works.Number<>0 ";}
$where=$where.")";
if(($author+1-1)>0){$where=$where." AND ri_works.manager=$author";}
$wk_r=mysql_query("SELECT * FROM ri_works $where");
//echo("SELECT * FROM ri_works $where<br>");

$kolvo=mysql_num_rows($wk_r);
//��������������
$S_LIST_PAGE=$S_LIST_PAGE+1-1;
if($command=='next'){$S_LIST_PAGE=$S_LIST_PAGE+20;}
if($command=='prev'){$S_LIST_PAGE=$S_LIST_PAGE-20;}
if($S_LIST_PAGE>=$kolvo){$S_LIST_PAGE=$kolvo-20;}
if($S_LIST_PAGE<0){$S_LIST_PAGE=0;}
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
<style type="text/css">
<!--
.style1 {color: #FF0000;
	font-weight: bold;
}
-->
</style>
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
<!-- #EndLibraryItem --><h4>������
            ����� �� �������� <span class="style1"><?php echo($predmet_name);?></span></h4>
          <table width="100%" cellspacing="0" cellpadding="0">
            <form action="worx.php" method="post" name="form_filter" id="form_filter">
              <tr>
                <td width="100%" nowrap="nowrap"><span>����������:</span>
                    <input name="dip" type="checkbox" id="dip" value="on" <?php if($S_F_DIP=='on'){echo("checked");}?> />
                  �������
                  <input name="kur" type="checkbox" id="kur" value="on" <?php if($S_F_KUR=='on'){echo("checked");}?> />
                  ��������
                  <input name="ref" type="checkbox" id="ref" value="on" <?php if($S_F_REF=='on'){echo("checked");}?> />
                  ��������
                  <input name="all" type="checkbox" id="all" value="on" <?php if($S_F_ALL=='on'){echo("checked");}?> />
                  ������</td>
                <td rowspan="2" align="center"><input name="fl" type="hidden" id="fl" value="filter" />
                    <input type="submit" name="Submit" value="�������������" /></td>
              </tr>
              <tr>
                <td width="100%" height="25" valign="top" nowrap="nowrap"><span>�����������
                  ��:</span>
                    <input name="rad_order" type="radio" value="name" <?php if($S_RAD_ORDER=='name'){echo("checked");}?> />
                  ����������� �������
                  <input name="rad_order" type="radio" value="tip" <?php if($S_RAD_ORDER=='tip'){echo("checked");}?> />
                  ���� ������</td>
              </tr>
            </form>
          </table>
          <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#339900">
            <tr background="http://www.educationservice.ru/images/bg_menu_bottom.gif">
              <td height="26" background="http://www.educationservice.ru/images/bg_menu_bottom.gif"><b>��������
                ������ </b></td>
              <td align="center" nowrap="nowrap" background="http://www.educationservice.ru/images/bg_menu_bottom.gif"><b>���
                ������ </b></td>
            </tr>
            <?php
$wk_r=mysql_query("SELECT * FROM ri_works $where $order LIMIT $S_LIST_PAGE, 20");
$wk_n=mysql_num_rows($wk_r);
for($i=0;$i<$wk_n;$i++)
{
  $wnum=mysql_result($wk_r,$i,'ri_works.number');
  $wname=mysql_result($wk_r,$i,'ri_works.name');
  $wtip=mysql_result($wk_r,$i,'ri_works.tip');
  
  $tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $wtype=mysql_result($tw_r,0,'tip');
  echo("<tr bgcolor='#FFFFFF'><td><a href='content.php?wnum=$wnum'><span>$wname</span></a></td><td align='center'>$wtype</td></tr>");
}
?>
            <tr align="center" bgcolor="#F5F5F5">
              <td colspan="2"><?php
if($S_LIST_PAGE>0){?>
                  <a href="worx.php?command=prev&amp;pnum=-1">&lt; ���������� 20</a>
                  <?php }?>
                &nbsp;<b>������� <?php echo("$S_LIST_PAGE-");
if($S_LIST_PAGE+20<$kolvo){echo($S_LIST_PAGE+20);}else{echo($kolvo);}
echo(" �� $kolvo");?></b>
                <?php
if($S_LIST_PAGE+20<$kolvo){
?>
                <a href="worx.php?command=next&amp;pnum=-1">&nbsp;��������� 20 &gt;</a>
                <?php }?></td>
            </tr>
          </table>
          <p class=width755>����� ��������, ��������� ������, ����� ��������, ������
�� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������.</p>
</body>
</html>
