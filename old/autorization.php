<?php
session_start();
require('access.php');
require('lib.php');
session_register('S_NUM_USER');
session_register('S_MASTER_STEP');
session_register('S_SOURCE_ACC_TIP');
session_register('S_SOURCE_ACC');
session_register('S_DEST_ACC_TIP');
session_register('S_DEST_ACC');
session_register('S_TRANZACT_SUMM');
session_register('S_LAST_ZAKAZ');
session_register('S_F_KASSA');//фильтр для кассовой книги
session_register('S_F_MESS');//фильтр для сообщений
session_register('S_F_WL_TIP'); //фильтр для листа работ "тип"
session_register('S_F_WL_PR');  // -//- "предмет"
session_register('S_F_WL_USER');  // -//- "владелец"
session_register('S_F_WL_ENABLE'); // -//- утвержденность
session_register('S_PAGE');  // номер записи начала страницы (для длинннннных листингов)
session_register('S_PAGE1');
session_register('S_PAGE2');
session_register('S_PAGE4');
session_register('S_PAGE5');
session_register('S_PAGE6');
session_register('S_PASSLOH');
session_register('S_F_US_TIP'); //фильтр для юзер-листа работ "тип"
session_register('S_F_US_PR');  // -//- "предмет"
session_register('S_F_US_UCH');  // -//- "учебное заведение"
session_register('S_SEL_ACC_TIP');  // выбранный тип счетов
session_register('S_SEL_ACC');  // выбранный счет
require('adm_config.php');

require('../connect_db.php');
$us_r=mysql_query("SELECT * FROM ri_user WHERE login='$login' AND pass='$pass'");
$us_n=mysql_num_rows($us_r);
if($us_n==0)
{
  //проверить, а вдруг это заказчик??
  $passloh=$pass/12345;
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$passloh AND email='$login'");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0){$S_PASSLOH=$pass;header("location: user_account.php?pass=$pass");}
  else
  {
    //проверить может быть ошибка пароля и его выслать по е-майл?
	$us_r=mysql_query("SELECT * FROM ri_user WHERE login='$login'");
    $us_n=mysql_num_rows($us_r);
    if($us_n>0)
	{
	  //у! надо пароль отправить
	  $upass=mysql_result($us_r,0,'pass');
	  mail($login,'Пароль регистрации на referats.info',"Здравствуйте!<br><br>При попытке авторизоваться на сайте referats.info Вы ввели не правильный пароль.<br>Ваш пароль: $upass<hr>С уважением<br>Администратор","From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
	  header("location: autors.php?mess=Ошибка_1! Пароль не правилен!");
	}
	else{header("location: autors.php?mess=Ошибка_2! Нет такого пользователя...");}
  }
}
else
{
  $S_LAST_ZAKAZ=mysql_result($us_r,0,'last_zakaz');
  $S_NUM_USER=mysql_result($us_r,0,'number');
  $zk_r=mysql_query("SELECT * FROM ri_zakaz ORDER BY number DESC LIMIT 0,1");
  $lz=mysql_result($zk_r,0,'number');
  mysql_query("UPDATE ri_user SET last_zakaz=$lz WHERE number=$S_NUM_USER");
  $S_F_WL_USER=$S_NUM_USER;
  //установить последний заказ
  

  if(access($S_NUM_USER,'rigths_adm') && $go_next=='autor/index.html')
  {
    header("location: admin/index.html");
  }
  else
  {
    header("location: $go_next");
  }
}
?>