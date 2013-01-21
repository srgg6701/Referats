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
  header("location: anketa.php?mess=Ошибка! Пользователь под именем'$login' уже зарегистрирован. Выберите себе дргое!");
}
else
{
  $us_r=mysql_query("SELECT * FROM ri_user WHERE family='$family'");
  $us_n=mysql_num_rows($us_r);
  if($us_n>0)
  {
    header("location: anketa2.php?login=$login&mess=Ошибка! Имя '$family' уже занято. Выберите себе другое!");
  }
  else
  {
    $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=".($pass/12345)." AND email='$login'");
    $zk_n=mysql_num_rows($zk_r);
    if($zk_n>0)
	{
	  header("location: anketa.php?mess=Извините, но пароль '$pass' занят!\nВнимание!\nПароль должен содержать, как минимум, 1 (один) буквенный символ.");
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
        //обновить ресурсы (добавить недостающие)
        $rg0_r=mysql_query("SELECT * FROM ri_rights WHERE user=0");
        $rg0_n=mysql_num_rows($rg0_r);
        for($i=0;$i<$rg0_n;$i++)
        {
          $rgpage=mysql_result($rg0_r,$i,'page');
          $rgflag=mysql_result($rg0_r,$i,'right');
          mysql_query("INSERT INTO ri_rights ( user, page, `right` ) VALUES ( $unum, '$rgpage', '$rgflag' )");
        }
        //послать письмо порегистренному
        $letter="<font size='+2'>Здравствуйте!</font><br><br>Поздравляем Вас с успешной регистрацией на торговой площадке <a href='http://www.referats.info' target='_blank'>referats.info</a> в качестве автора творческих работ!</p><p>Ваши регистрационные данные:</p><p>e-mail : <b>$login</b><br>пароль : <b>$pass</b></p><p>Теперь вы обладаете эксклюзивным правом продажи своих дипломных, курсовых работ, рефератов и т.п. в рамках нашего проекта. Ещё раз подчёркиваем &#8212; мы берём на себя обязательство не выкупать ваши работы, <b>правом их продажи обладаете только вы и никто другой</b>.</p>
<p>Мы создали для вас  персональный раздел (эккаунт), позволяющий вам полностью контролировать свою деятельность на нашей торговой площадке.</p>
<h4><strong>Ваш персональный эккаунт, это: </strong></h4>
<ul>
  <li>Отсутствие ограничений на количество продаваемых работ</li>
  <li>Мониторинг конкурирующих заказов, возможность регулировать стоимость своих работ</li>
  <li>Автоматизированная система оповещений</li>
  <li>Подробная справочная система</li>
  <li>Максимально полная статистика о текущем статусе своих работ и история заказов</li>
  <li> Полный контроль прохождения платежей</li>
  <li>Надёжная и быстрая обратная связь с администрацией торговой площадки</li>
  <li>Возможность прямых консультаций с заказчиком</li>
</ul>
<p>Для входа в свой эккаунт щёлкните <a href=http://referats.info/autors.php?login=$login&pass=$pass target=_blank>здесь</a>.
<hr size=1 noshade>Рекомендуем вам посетить раздел <A HREF='http://referats.info/autor_faq.htm' target=_blank>FAQ</a>, в нём вы найдёте ответы на наиболее часто задаваемые вопросы.<p><font size='+2' color='#FF9900'>Надеемся на долгое и плодотворное сотрудничество!</font></p>";
        inmail($login, "Регистрация на referats.info",$letter,"From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'REG00');
        $letter2="Здравствуйте!<p>На торговой площадке referats.info зарегистрирован новый автор.</p>
  <p>Регистрационные данные:</p>
  <p>e-mail : $login
  <br>пароль : $pass
  <br>Nickname: $family
  </p>
  <p>Сайт: $site<br>
Намерен открыть в течение: $time<br>
<table border=1><tr><td>Где исполнители могут давать объявления</td><td>Где заказчики могут давать объявления</td><td>Где можно скачать работы</td></tr><td>".str_replace(';','<br>',$af)."</td><td>".str_replace(';','<br>',$cf)."</td><td>".str_replace(';','<br>',$wf)."</td></tr></table></p>
  <p>Для входа в его эккаунт щёлкните<a href=http://referats.info/autors.php?login=$login&pass=$pass target=_blank>здесь</a>.<hr size=1 noshade>С уважением,<br>Автопилот :)";
        inmail($admin_mail, "REG: Регистрация $login",$letter2,"From: $login".chr(13).chr(10).'Reply-To: '.$login.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251', 'REG01');
        header("location: autors_congratulation.php?login=$login&pass=$pass");
      }
    }
  }
}
?>