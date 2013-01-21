<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Почтовая отправка</title>
</head>

<body><? require ("../temp_transparency.php");?>
<?php
if($pass=='ze$Sa4va')
{
  if($fl=='on')
  {
    mail($email,$subj,$mess,"From: $backemail".chr(13).chr(10).'Reply-To: $backemail'.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  }
  echo("$fl<br>Вы отправили письмо:<hr>To: $email<br>From: $backemail<br>Subject: $subj<br>Letter:<br>".nl2br($mess));
}
?>
</body>
</html>
