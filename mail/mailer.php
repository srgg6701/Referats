<? require ("lib_mail_smtp.php"); ?>������� ������ �����������:<br />
<form id="form1" name="form1" method="post" action="" onsubmit="if (!confirm('���������?!')) return false;">
  <textarea name="addresses" rows="26" style="width:90%;">
  dusk18@mail.ru,
totalitarist@mail.ru,
rojasrojas@mail.ru,
gregorianz@inbox.ru,
educationservice@mail.ru,
pastshadowleft@mail.ru,
diplom.com.ru@mail.ru,
the_same_way@mail.ru,
infantalistica@yandex.ru,
diplom.com.ru@yandex.ru,
valentinedaynever@yandex.ru,
random314@yandex.ru,
srgg140201@yandex.ru,
educationservice@yandex.ru,
evolutionare@rambler.ru,
bladerunneragain@rambler.ru,
nebulaMC4@rambler.ru,
educationservice@rambler.ru,
srgg67@gmail.com,
educationservice.ru@gmail.com,
29894257@qip.ru,
cozy44@km.ru,
educationservice@nm.ru,
srgg67@hotmail.com,
srgg67@yahoo.com
  </textarea>
  <div style="padding-top:4px"><input type="submit" name="send_mess" value="���������!" /></div>
</form> 
<?php
#### ����� ��� ��� ���� � ���, �� ���� ��� ������ � �����


$addresses=str_replace(" ","",$_POST['addresses']);
$maillist=explode(",",$addresses);

$content= '�������� ������ ������). ��� ��� ���� - ����������-���?';
$subject='��, �������, ������ � ������� ��������...';

if (isset($_POST['send_mess'])) 
  { for ($i=0;$i<count($maillist);$i++)
	  { //echo $maillist[$i]."<br>";
		smtpmail($maillist[$i],$subject,$content);
	  }
  } ?>
