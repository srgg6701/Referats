<?php
require('../connect_db.php');
require('lib.php');
//require('../send_mail_maker.php');
//require('../work_with_shablon.php');

//������������ ������ ������������ �� 3 ��� ����� �������������� ����� �����
function autodelete_zakaz($znum)
{
  mysql_query("UPDATE ri_zakaz SET status=-2 WHERE number=$znum AND status=1");
  $s="UPDATE ri_zakaz SET status=-2 WHERE number=$znum AND status=1<br>err=".mysql_error();"<br>";
  inmail('esisl@yandex.ru', "��������",$s, "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'PROBL');
}

//����������� ��������� � ������� CSV-������
function makeCSVfile()
{
  //$letter=make_works_list();
  //�� ����� ���� ���� �������� ���� workx.zip
  //$fp=fopen("worx.csv", "w");
  //fputs($fp,$letter,999999);
  //fclose($fp);
  //mail($admin_mail, "work.csv", $letter, "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
}

//����������� ������ ri_shedule
function clear_ri_rating()
{
  mysql_query("DELETE FROM ri_rating");
}

//����������� ���������� �������������� � ���������� ����� �����
function check_new_work()
{
  $wk_r=mysql_query("SELECT * FROM ri_works, ri_user WHERE ri_works.manager=ri_user.number AND ri_works.enable='N'");
  $wk_n=mysql_num_rows($wk_r);
  if($wk_n>0)
  {
    $dt=rustime(date('Y-m-d'));
    $letter="������������!<br><br>�� $dt � ������� $wk_n ����� �����, � �������:<br><table border=1 width=100><tr><td>id</td><td>�������</td><td>����</td><td>�����</td><td>�����</td><td>����</td></tr>";

	for($i=0;$i<$wk_n;$i++)
	{
	  $wnum=mysql_result($wk_r,$i,'ri_works.number');
      $predmet=mysql_result($wk_r,$i,'ri_works.predmet');
      $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$predmet");
	  $pr_n=mysql_num_rows($pr_r);
	  if($pr_n>0){$prstr=mysql_result($pr_r,0,'predmet');}else{$prstr='';}
      $name=mysql_result($wk_r,$i,'ri_works.name');
      $tax=mysql_result($wk_r,$i,'ri_works.tax');  
      $pages=mysql_result($wk_r,$i,'ri_works.pages');  
      $user=mysql_result($wk_r,$i,'ri_user.family');  
	  $letter=$letter."<tr><td>$wnum</td><td>$prstr</td><td>$name</td><td>$user</td><td>$pages</td><td>$tax</td></tr>";
	}
	$letter="$letter</table><br>� ���������<br>���������";
	inmail($admin_mail, "������ ����� �����",$letter, "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'NEWWK');
  }
}

//����������� ���������� �������������� � ���������� ���������� �������
function check_problem_zakaz()
{
  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works, ri_user WHERE ri_zakaz.work=ri_works.number AND ri_works.manager=ri_user.number AND ri_zakaz.status=1 AND ri_zakaz.summ_our>ri_zakaz.summ_user ORDER BY ri_zakaz.number DESC");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0)
  {
    $dt=rustime(date('Y-m-d'));
    $letter="������������!<br><br>�� $dt � ������� $zk_n ���������� �������, � �������:<br><table border=1 width=100><tr><td>id</td><td>��������</td><td>����</td><td>�����</td></tr>";
	for($i=0;$i<$zk_n;$i++)
	{
	  $znum=mysql_result($zk_r,$i,'ri_zakaz.number');
	  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
	  $zemail=mysql_result($zk_r,$i,'ri_zakaz.email');
	  $ztema=mysql_result($zk_r,$i,'ri_works.name');
	  $zautor=mysql_result($zk_r,$i,'ri_user.family');
	  $zaemail=mysql_result($zk_r,$i,'ri_user.email');
	  $letter=$letter."<tr><td>$znum</td><td><a href='mailto: $zemail'>$zuser</a></td><td>$ztema</td><td><a href='mailto: $zaemail'></a></td></tr>";
	}
	$letter="$letter</table><br>� ���������<br>���������";
	inmail($admin_mail, "������ ���������� �������",$letter, "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'PROBL');
  }
}

//������� ��������������� ������ ����������� �������
function autoutv_work($wnum)
{
  mysql_query("UPDATE ri_works SET enable='Y' WHERE number=$wnum");
}

//������� ����������������� ��������� ���������� ������
function autoremember_zakaz($znum)
{
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$znum");
  $zstatus=mysql_result($zk_r,0,'status');
  if($zstatus==2)
  {
    zakaz_status_transmit(0, $znum, 4);
  }
}

//������� ��������������� ���������, ��� ���������� ������ ���� �� �� ����� �������� ;)
function autoreminder_zakaz_pay($znum, $num_remind)
{
  if($num_remind>0)
  {
    $ks_r=mysql_query("SELECT * FROM ri_kassa WHERE zakaz=$znum AND person<>1");
	$ks_n=mysql_num_rows($ks_r);
	if($ks_n==0)
	{
	  //�������� �����������
	  $dt=date('Y-m-d');
	  mysql_query("INSERT INTO ri_shedule( data, kratnost, period, script, remark, enable ) VALUES( '$dt', 0, 24, 'autoreminder_zakaz_pay($znum, ".($num_remind-1).")', '����������� �� ������ Id $znum', 'O' )");
	  //������� �����������
	  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$znum");
	  $zk_n=mysql_num_rows($zk_r);
	  if($zk_n>0)
	  {
	    $email=mysql_result($zk_r,0,'ri_zakaz.email');
		$user=mysql_result($zk_r,0,'ri_zakaz.user');
		$subj=mysql_result($zk_r,0,'ri_works.name');
		$our_summ=mysql_result($zk_r,0,'ri_zakaz.summ_our');
	    inmail($email, '�� ����� ��������� Referats.info', "������������, $user!<P>�� �������� �� ����� referats.info ������ �� ���� <b>'$subj'</b>.</P><P>����������, ��� ��� ��������� ������ ��� ����� �������� $our_summ ���.<hr>� ���������,<br> ������������� �������� <a href=http://www.referats.info>Referats.info</a> � <a href=http://www.diplom.com.ru/>Diplom.com.ru</a></p>P.S. ��� ��������� ���������� ������ ������(�������) ��������� �� ���� ������: <a href='http://referats.info/autorization.php?login=$email&pass=".($znum*12345)."' target='_blank'>http://referats.info/autorization.php?login=$email&pass=".($znum*12345)."</a>.<br>����� ��������� ��� �����������, ��������� �� ������: <a href='http://referats.info/payment/unsubscribe.php?login=$email&pass=".($znum*12345)."' target='_blank'>http://referats.info/payment/unsubscribe.php?login=$email&pass=".($znum*12345)."</a>.","From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251','MONEY');
	  }
	}
  }
}

$sh_r=mysql_query("SELECT * FROM ri_shedule");
$sh_n=mysql_num_rows($sh_r);
for($i=0;$i<$sh_n;$i++)
{
  //�������� ���� �� �����������
  $snum=mysql_result($sh_r,$i,'number');
  $period=mysql_result($sh_r,$i,'period');
  $kratnost=mysql_result($sh_r,$i,'kratnost');
  $script=mysql_result($sh_r,$i,'script');
  $enable=mysql_result($sh_r,$i,'enable');
  $kratnost++;
  $upfl='Y';
  if($kratnost>=$period)
  {
    $kratnost=0;
	//������ ���� ���������� ������
	$script=str_replace("`","'",$script);
	eval($script.";");
	//echo($script.";<br>");
	//���� enable='O' �� ���� ������� ��������-������ ����� ����������
    if($enable=='O')
	{
	  mysql_query("DELETE FROM ri_shedule WHERE number=$snum");
	  $upfl='N';
	}
  }
  if($upfl=='Y'){mysql_query("UPDATE ri_shedule SET kratnost=$kratnost WHERE number=$snum");}
}
?>