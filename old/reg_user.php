<?php
session_start();
require('../connect_db.php');
require('lib.php');
$admin_mail='info@referats.info';

$howmach=$howmach+1-1;
$us_r=mysql_query("SELECT * FROM ri_user WHERE login='$login'");
$us_n=mysql_num_rows($us_r);
if($us_n>0)
{
  header("location: anketa.php?mess=������! ������������ ��� ������'$login' ��� ���������������. �������� ���� �����!");
}
else
{
  $us_r=mysql_query("SELECT * FROM ri_user WHERE family='$family'");
  $us_n=mysql_num_rows($us_r);
  if($us_n>0)
  {
    header("location: anketa2.php?login=$login&mess=������! ��� '$family' ��� ������. �������� ���� ������!");
  }
  else
  {
    $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=".($pass/12345)." AND email='$login'");
    $zk_n=mysql_num_rows($zk_r);
    if($zk_n>0)
	{
	  header("location: anketa.php?mess=��������, �� ������ '$pass' �����!\n��������!\n������ ������ ���������, ��� �������, 1 (����) ��������� ������.");
	}
    else
    {
      $dt=date("Y-m-d");
	  $af='';$cf='';$wf='';
	  for($i=1;$i<=16;$i++)
	  {
	    if(trim($authors_free[$i])!=''){$af=$af.$authors_free[$i].';';}
		if(trim($customer_free[$i])!=''){$cf=$cf.$customer_free[$i].';';}
		if(trim($worx_free[$i])!=''){$wf=$wf.$worx_free[$i].';';}
	  }
      mysql_query("INSERT INTO ri_user ( data, login, pass, name, family, otch, email, phone, mobila, city, icq, WMR, WMZ, WME, YmoneY, BankAcc, workphone, dopphone, howmach, myurl, myurltime, authors_free, customer_free, worx_free ) VALUES ( '$dt', '$login', '$pass', '$name', '$family', '$otch', '$email', '$phone', '$mobila', '$city', '$ICQ', '$WMR', '$WMZ', '$WME', '$YmoneY', '$BankAcc', '$workphone', '$dopphone', $howmach, '$site', '$time', '$af', '$cf', '$wf' )");
      $unum=mysql_insert_id();
      if(mysql_error()!='')
	  {echo("err=".mysql_error()."<br>");}
      else
      {
        //�������� ������� (�������� �����������)
        $rg0_r=mysql_query("SELECT * FROM ri_rights WHERE user=0");
        $rg0_n=mysql_num_rows($rg0_r);
        for($i=0;$i<$rg0_n;$i++)
        {
          $rgpage=mysql_result($rg0_r,$i,'page');
          $rgflag=mysql_result($rg0_r,$i,'right');
          mysql_query("INSERT INTO ri_rights ( user, page, `right` ) VALUES ( $unum, '$rgpage', '$rgflag' )");
        }
        //������� ������ ���������������
        $letter="<font size='+2'>������������!</font><br><br>����������� ��� � �������� ������������ �� �������� �������� <a href='http://www.referats.info' target='_blank'>referats.info</a> � �������� ������ ���������� �����!</p><p>���� ��������������� ������:</p><p>e-mail : <b>$login</b><br>������ : <b>$pass</b></p><p>������ �� ��������� ������������ ������ ������� ����� ���������, �������� �����, ��������� � �.�. � ������ ������ �������. ��� ��� ������������ &#8212; �� ���� �� ���� ������������� �� �������� ���� ������, <b>������ �� ������� ��������� ������ �� � ����� ������</b>.</p>
<p>�� ������� ��� ���  ������������ ������ (�������), ����������� ��� ��������� �������������� ���� ������������ �� ����� �������� ��������.</p>
<h4><strong>��� ������������ �������, ���: </strong></h4>
<ul>
  <li>���������� ����������� �� ���������� ����������� �����</li>
  <li>���������� ������������� �������, ����������� ������������ ��������� ����� �����</li>
  <li>������������������ ������� ����������</li>
  <li>��������� ���������� �������</li>
  <li>����������� ������ ���������� � ������� ������� ����� ����� � ������� �������</li>
  <li> ������ �������� ����������� ��������</li>
  <li>������� � ������� �������� ����� � �������������� �������� ��������</li>
  <li>����������� ������ ������������ � ����������</li>
</ul>
<p>��� ����� � ���� ������� �������� <a href=http://referats.info/autors.php?login=$login&pass=$pass target=_blank>�����</a>.
<hr size=1 noshade>����������� ��� �������� ������ <A HREF='http://referats.info/autor_faq.htm' target=_blank>FAQ</a>, � �� �� ������ ������ �� �������� ����� ���������� �������.<p><font size='+2' color='#FF9900'>�������� �� ������ � ������������ ��������������!</font></p>";
        inmail($login, "����������� �� referats.info",$letter,"From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'REG00');
        $letter2="������������!<p>�� �������� �������� referats.info ��������������� ����� �����.</p>
  <p>��������������� ������:</p>
  <p>e-mail : $login
  <br>������ : $pass
  <br>Nickname: $family
  </p>
  <p>����: $site<br>
������� ������� � �������: $time<br>
<table border=1><tr><td>��� ����������� ����� ������ ����������</td><td>��� ��������� ����� ������ ����������</td><td>��� ����� ������� ������</td></tr><td>".str_replace(';','<br>',$af)."</td><td>".str_replace(';','<br>',$cf)."</td><td>".str_replace(';','<br>',$wf)."</td></tr></table></p>
  <p>��� ����� � ��� ������� ��������<a href=http://referats.info/autors.php?login=$login&pass=$pass target=_blank>�����</a>.<hr size=1 noshade>� ���������,<br>��������� :)";
        inmail($admin_mail, "REG: ����������� $login",$letter2,"From: $login".chr(13).chr(10).'Reply-To: '.$login.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'REG01');
        header("location: autors_congratulation.php?login=$login&pass=$pass");
      }
    }
  }
}
?>