<?php
session_start();
require('../connect_db.php');
require('../old/lib.php');
statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
$S_WORK_NUM=$wnum;
$wk_r=mysql_query("SELECT * FROM ri_works, diplom_predmet WHERE ri_works.predmet=diplom_predmet.number AND ri_works.number=$wnum");
$wname=mysql_result($wk_r,0,'ri_works.name');
$wtip=mysql_result($wk_r,0,'ri_works.tip');
$wpages=mysql_result($wk_r,0,'ri_works.pages');
$wpredm=mysql_result($wk_r,0,'diplom_predmet.predmet');
$wannot=nl2br(rawurldecode(mysql_result($wk_r,0,'ri_works.annot')));
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>����� ������� ����������� ��������� �����. ������� �� ����� ��������� �����������.</title>
<meta name="description" content="����� ��������, ��������� ������, ����� ��������, ������
  �� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������.">
<meta name="keywords" content="����� ��������, ����� ��������, ������ �� �����, �������� �� �����, �������� ������, ��������� ������, ������� ��������, �����������, �������� ��������� ������, ���� ��������� �����, ��������."><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<script language="JavaScript" type="text/JavaScript" src="http://www.educationservice.ru/scripts/valid_email.js"></script>
<script language="JavaScript" type="text/JavaScript" src="http://www.educationservice.ru/scripts/standart.js"></script>
<script language="JavaScript" type="text/JavaScript" src="http://www.referats.info/go_url.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function checkCells ()  {
if (document.forms[0].elements['name'].value) 
	{
	document.forms[0].email.style.backgroundColor='yellow';
	return emailCheck (document.forms[0].email);
	}
else {alert ('�� �� �������� ���, ��� � ��� ����������!'); document.forms[0].elements['name'].style.backgroundColor='yellow'; document.forms[0].elements['name'].focus(); return false;}
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
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
<!-- #EndLibraryItem --><h4>��������� ������:</h4>
          <table width="100%" cellpadding="3"  cellspacing="1" bgcolor="#339900">
            <tr background="http://www.educationservice.ru/images/bg_menu_bottom.gif">
              <td colspan="2" background="http://www.educationservice.ru/images/bg_menu_bottom.gif"><b><?php echo($wname);?></b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap="nowrap" bgcolor="#F5F5F5"><span class="header10bottom">���
                ������&nbsp;<img src="http://www.referats.info/images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle" /></span></td>
              <td width="100%"><b><?php echo($wtip_s);?></b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap="nowrap" bgcolor="#F5F5F5"><span class="header10bottom">�������&nbsp;<img src="http://www.referats.info/images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle" /></span></td>
              <td><b><?php echo($wpredm);?></b></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td align="right" nowrap="nowrap" bgcolor="#F5F5F5"><span class="header10bottom">�����&nbsp;<img src="http://www.referats.info/images/arrows/simple_black.gif" width="14" height="12" hspace="2" border="1" align="absmiddle" /></span></td>
              <td><b><?php echo($wpages);?> ������</b></td>
            </tr>
            <tr bgcolor="#F5F5F5">
              <td colspan="2" style="padding:10px"><b>���������� ������:</b>
                  <hr size="1" noshade="noshade" />
                  <?php echo($wannot); ?></td>
            </tr>
          </table>
          <p class=width755><b>���� ��� �������������� ��� ������, ������� ���� ������ ���� �
            �������� �� ������ &laquo;��������!&raquo;. </b> </p>
          <table border="0" cellspacing="0" cellpadding="0" style="background-image:url(images/gradient_green_vertical2.jpg); background-position:bottom; background-repeat:repeat-x">
            <tr>
              <td valign="top"><img src="images/corners/tsx_fr_cor_tl.gif" 
			  width="7" height="9" hspace="0" vspace="0" border="0" /></td>
              <td width="100%" style="border-top:solid 2px #009900;"><img src="images/spacer.gif" width="1" height="1" /></td>
              <td align="right" valign="top"><img src="images/corners/tsx_fr_cor_tr.gif" width="7" height="9" hspace="0" vspace="0" /></td>
            </tr>
            <tr>
              <td style="border-left:solid 2px #339900">&nbsp;</td>
              <td style="padding:0px 5px 0px 5px;"><h4>����� ����������
                ������ �� �������:</h4>
                  <ol>
                    <li><b>������������ �������� ����� � ������� ������ � ��������
                      ����� ���������� �� ���.</b></li>
                    <li><b>��� ������������� &#8212; �������� � ��������� �� ������
                      ����������.</b></li>
                    <li><b>������������� ������� ��������� �� ������� ������ � ����
                      �������� (������������ ������� ���������).</b></li>
                  </ol></td>
              <td style="border-right:solid 2px #339900">&nbsp;</td>
            </tr>
            <tr>
              <td><img src="images/corners/tsx_fr_cor_bl.gif" width="7" height="9" hspace="0" vspace="0" border="0" /></td>
              <td style=" border-bottom:solid 2px #339900"><img src="articles/safety.htm" width="1" height="1" /></td>
              <td><img src="images/corners/tsx_fr_cor_br.gif" width="7" height="9" hspace="0" vspace="0" border="0" /></td>
            </tr>
          </table>
          <form action="http://www.referats.info/old/payment.php" method="post" onsubmit="return checkCells ();" style="padding-top:0px; margin-top:0px">
            <p class="red"> <b>��������!</b> </p>
            <p class=width755>
              <?php
if(isset($S_PASSLOH))
{
  $znum=$S_PASSLOH/12345;
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0)
  {
    $zemail=mysql_result($zk_r,0,'email');
    $zuser=mysql_result($zk_r,0,'user');
    $zphone=mysql_result($zk_r,0,'phone');
    $zmobila=mysql_result($zk_r,0,'mobila');
    $zworkphone=mysql_result($zk_r,0,'workphone');
    $zdopphone=mysql_result($zk_r,0,'dopphone');
    $zicq=mysql_result($zk_r,0,'icq');
    echo ('����������, ��������� ���� ��������������� ������, ��������� ����. ���� ��� �����, ������� ������� ���� ��������� ������ � �������� �� ������ "��������!"');
  }
  else {echo ("�� ������������ ����������� ��� ������� ���� ���������� ��������, � �.�. &#8212; ���������, ��� �������� ��� �������� ��� ��� �� ������ ����� �������.");}
}
else {echo ("�� ������������ ����������� ��� ������� ���� ���������� ��������, � �.�. &#8212; ���������, ��� �������� ��� �������� ��� ��� �� ������ ����� �������.");}
?>
            </p>
            <table width="100%" cellpadding="0"  cellspacing="0">
              <tr>
                <td width="50%"><strong>��� email:</strong>
                    <input name="email" type="text" class="greenBorder" id="email" style="width:100%" value="<?php echo($zemail);?>" /></td>
                <td><img src="images/spacer.gif" width="6" height="4" /></td>
                <td width="50%"><strong>��� � ��� ����������</strong> (��� � �.�.):
                  <input name="name" type="text" class="greenBorder" id="name" style="width:100%" onblur="if (this.value) this.style.backgroundColor='';" value="<?php echo($zuser);?>" /></td>
              </tr>
              <tr>
                <td colspan="3"><table width="100%"  cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="25" colspan="7" nowrap="nowrap"><strong>���� ����������
                        ��������:</strong></td>
                    </tr>
                    <tr valign="bottom">
                      <td width="25%" nowrap="nowrap"> ��������:<br />
                          <input name="phone" type="text" class="greenBorder" id="phone" style="width:100%" value="<?php echo($zphone);?>" />
                      </td>
                      <td><img src="images/spacer.gif" width="10" height="10" /></td>
                      <td width="25%">�������:<br />
                          <input name="workphone" type="text" class="greenBorder" id="workphone" style="width:100%" value="<?php echo($zworkphone);?>" />
                      </td>
                      <td><img src="images/spacer.gif" width="10" height="10" /></td>
                      <td width="25%" nowrap="nowrap">��������� �������:<br />
                          <input name="mobila" type="text" class="greenBorder" id="mobila" style="width:100%" value="<?php echo($zmobila);?>" />
                      </td>
                      <td><img src="images/spacer.gif" width="10" height="10" /></td>
                      <td width="25%" nowrap="nowrap">��������������:<br />
                          <input name="dopphone" type="text" class="greenBorder" id="dopphone" style="width:100%" value="<?php echo($zdopphone);?>" />
                      </td>
                    </tr>
                    <tr valign="bottom">
                      <td colspan="7" nowrap="nowrap"><strong># ICQ:</strong>
                          <input name="icq" type="text" class="greenBorder" id="icq" value="<?php echo($zicq);?>" size="9" />
                          <input name="myWorxNum" type="hidden" id="myWorxNum" value="<?php echo($S_WORK_NUM);?>" />
                      </td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <?php
$bDay=date('d')+3;
$bMonth=date('m');
if($bDay>31){$bMonth++;$bDay=$bDay-31;}
$bYear=date('Y');
if($bMonth>12){$bYear++;$bMonth=$bMonth-12;}
?>
            ������� ���� ��������� ������:
  <select name="Day">
    <?php
for($i=1;$i<32;$i++)
{
  echo("<option value=$i");
  if($i==$bDay){echo(" selected");}
  echo(">$i</option>");
}
?>
  </select>
  <select name="Month">
    <?php
for($i=1;$i<13;$i++)
{
  echo("<option value=$i");
  if($i==$bMonth){echo(" selected");}
  echo(">".rus_month($i)."</option>");
}
?>
  </select>
  <select name="Year">
    <?php
for($i=2004;$i<2010;$i++)
{
  echo("<option value=$i");
  if($i==$bYear){echo(" selected");}
  echo(">$i</option>");
}
?>
  </select>
  <div style="padding-top:10px; padding-bottom:10px">
    <input type="submit" name="Submit" value="��������!" />
  </div>
  <hr size="1" noshade="noshade" color="#339900" />
          </form>
          <p class=width755>����� ��������, ��������� ������, ����� ��������, ������
  �� �����, �������� �� �����, �������� ������, ������� ��������, �����������,
�������� ��������� ������.</p>
</body>
</html>
