<?php

class regUser {
	//гененрируем пароль:
	function generate_password($number) {
		$arr = array('a','b','c','d','e','f',
					 'g','h','i','j','k','l',
					 'm','n','o','p','r','s',
					 't','u','v','x','y','z',
					 'A','B','C','D','E','F',
					 'G','H','I','J','K','L',
					 'M','N','O','P','R','S',
					 'T','U','V','X','Y','Z',
					 '1','2','3','4','5','6',
					 '7','8','9','0');
		// Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++){
		  // Вычисляем случайный индекс массива
		  $index = rand(0, count($arr) - 1);
		  $pass .= $arr[$index];
		}
		return $pass;
	} //КОНЕЦ МЕТОДА
	//зарегистрировать автора:
	function regAuthor() {

		global $catchErrors;
	  	global $Messages;
		
		//получим или сгенерируем пароль:
		//если исполнитель с diplom.com.ru:
		$pass=$_REQUEST['pass_current'];
		//не получили поле с текущим паролем:
		if (!$pass) {
			//если регистировали нового автора
			if (isset($_REQUEST['pass2'])) {
				//обнаружено несовпадение паролей (вообще-то быть не должно, т.к. проверяется клиентским скриптом):
				if ($_REQUEST['pass']!=$_REQUEST['pass2']) {
					//тестовый режим учтён:
					$Messages->sendEmail (  "test@educationservice.ru",
										  	"sale@referats.info",
										  	"test@educationservice.ru",
										  	"Внештатная ситуация при регистрации нового исполнителя",
										  	nl2br("Не сработала проверка совпадения паролей клиентским скриптом.
											email/login: $_REQUEST[email]
											name: $_REQUEST[name]"),
										  	false	//текст алерта не указываем, т.к. будем выводить на стр.
										 );
					die("<div><b class='txtRed'>ОШИБКА!</b></div>Указанные вами пароли не совпадают!");
				
				}else $pass=$_REQUEST['pass'];
			} //elseif(!$_REQUEST['new_author']) $this->generate_password(10); ПРИ РЕГИСТРАЦИИ АВТОРА НЕ ИСПОЛЬЗУЕТСЯ (зарезервировано)
		}
		//добавляем данные:		
		$qSql="INSERT INTO ri_user ( data, 
                      login, 
                      pass, 
                      name, 
                      family, 
                      otch, 
                      phone, 
                      mobila, 
                      city, 
                      icq, 
                      WMR, 
                      WMZ, 
                      WME, 
                      YmoneY, 
                      BankAcc, 
                      workphone, 
                      dopphone, 
                      howmach, 
                      myurl, 
                      myurltime 
                    ) 
					  VALUES 
                    ( '".date("Y-m-d")."]', 
                      '$_REQUEST[email]', 
                      '$pass', 
                      '$_REQUEST[family]', ". //пережиток прошлого
"
                      '$_REQUEST[real_family]', ". //пока не используется
"
                      '$_REQUEST[otch]', 
                      '$_REQUEST[phone]', 
                      '$_REQUEST[mobila]', 
                      '$_REQUEST[city]', 
                      '$_REQUEST[ICQ]', 
                      '$_REQUEST[WMR]', 
                      '$_REQUEST[WMZ]', 
                      '$_REQUEST[WME]', 
                      '$_REQUEST[YmoneY]', 
                      '$_REQUEST[BankAcc]', 
                      '$_REQUEST[workphone]', 
                      '$_REQUEST[dopphone]', 
                      '$_REQUEST[howmach]', 
                      '$_REQUEST[site]', 
                      '$_REQUEST[time]'
                    )";	  

		  $catchErrors->insert($qSql);
	  	  
		  $unum=mysql_insert_id();

		//послать письмо порегистренному
		$letter="<h4>Здравствуйте, $_REQUEST[name]!</h4>
		Поздравляем Вас с успешной регистрацией на торговой площадке <a href='http://www.referats.info' target='_blank'>referats.info</a> в качестве автора творческих работ!</p>
		<p>Ваши регистрационные данные:</p>
		<p>Логин: <b>$_REQUEST[email]</b>
		<br>Пароль : <b>$pass</b></p>
		
		<p>Теперь вы обладаете эксклюзивным правом продажи своих дипломных, курсовых работ, рефератов и т.п. в рамках нашего проекта. Ещё раз подчёркиваем &#8212; мы берём на себя обязательство не выкупать ваши работы, <b>правом их продажи обладаете только вы и никто другой</b>.</p>
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
<p>Для входа в свой эккаунт щёлкните <a href=http://referats.info/author/?login=$_REQUEST[email]&amp;pass=$pass target=_blank>здесь</a>.
		
		<hr size=1 noshade>Рекомендуем вам посетить раздел <A HREF='http://referats.info/?section=faq_authors' target=_blank>FAQ</a>, в нём вы найдёте ответы на наиболее часто задаваемые вопросы.
		<h3>Надеемся на долгое и плодотворное сотрудничество!</h3>";
		//Сообщение автору:
		//тестовый режим учтён:
		$Messages->sendEmail ( $_REQUEST['email'],
							  $fromAddress,
							  $replyTo,
							  "Регистрация в качестве автора-собственника творческих работ на торговой площадке Referats.info",
							  $letter,
							  false	//текст алерта не указываем, т.к. будем выводить на стр.
					   		);

		
		$letter2="Здравствуйте!<p>На торговой площадке referats.info зарегистрирован новый автор.</p>
  <p>Регистрационные данные:</p>
  <p>e-mail : $_REQUEST[email]
  <br>пароль : $pass
  <br>Nickname: $_REQUEST[family]
  </p>
  <p>Сайт: $_REQUEST[site]<br>
Намерен открыть в течение: $_REQUEST[time]</p>";
/*<!--<table border=1><tr><td>Где исполнители могут давать объявления</td><td>Где заказчики могут давать объявления</td><td>Где можно скачать работы</td></tr><td>".str_replace(';','<br>',$af)."</td><td>".str_replace(';','<br>',$cf)."</td><td>".str_replace(';','<br>',$wf)."</td></tr></table>-->*/
  $letter2.="<p>Для входа в его эккаунт щёлкните <a href='http://referats.info/author/?login=$login&amp;pass=$pass' target=_blank>здесь</a>.<hr size=1 noshade>С уважением,<br>Автопилот :)";		
  		
		//Сообщение админу:
		//тестовый режим учтён:
		$Messages->sendEmail ( $toAddress,
							  $fromAddress,
							  $replyTo,
							  "Регистрация нового автора на Referats.info",
							  $letter2,
							  false	//текст алерта не указываем, т.к. будем выводить на стр.
					   		);
	} //КОНЕЦ МЕТОДА
	//зарегистрировать заказчика:
	function regCustomer($login) {

		global $catchErrors,$Customer,$Messages;
		
		if (!$Customer->checkCustomerReg($login)) {

			$pass=$this->generate_password(10);
			//добавляем данные:		
			$qSql="INSERT INTO ri_customer ( name, 
                      email, 
                      email2, 
                      password, 
                      mobila, 
                      datatime 
                    ) 
                      VALUES 
                    ( '$_REQUEST[name]', 
                      '$login', 
                      '$_REQUEST[email2]', 
                      '$pass', 
                      '$_REQUEST[mobila]', 
                      '".date("Y-m-d")."'
                    )";	  

			if (!$catchErrors->insert($qSql)&&!$_SESSION['TEST_MODE']) die('ОШИБКА! Запрос не выполнен!<hr><pre>'.$qSql.'</pre>');
			  
			$_SESSION['S_USER_ID']=($_SESSION['TEST_MODE'])? mysql_result(mysql_query("SELECT number FROM ri_customer ORDER BY number DESC"),'0','number')+1:mysql_insert_id();
			  
			$_SESSION['S_USER_TYPE']="customer";
			$_SESSION['S_USER_NAME']=$_REQUEST['name'];
			$_SESSION['S_USER_EMAIL']=$login;
			$_SESSION['S_USER_EMAIL2']=$_REQUEST['email2'];
			$_SESSION['S_USER_MOBILA']=$_REQUEST['mobila'];
			$unum=$_SESSION['S_USER_ID'];
	
			//послать письмо порегистренному
			$letter="<h4>Здравствуйте";
			if (isset($_REQUEST['name'])) $letter.=", $_REQUEST[name]";
			$letter.="!</h4>
			Поздравляем Вас с успешной регистрацией на торговой площадке <a href='http://www.referats.info' target='_blank'>referats.info</a> в качестве нашего клиента!</p>
			<p>Ваши регистрационные данные:</p>
			<p>Логин: <b>$login</b>
			<br>Пароль: <b>$pass</b> (вы всегда сможете изменить его в своём <a href='http://referats.info/?section=customer&amp;login=$login&amp;password=$pass'>личном кабинете</a>)</p>
			
			<p>Теперь вы можете: 
			  <ol>
				<li>Приобретать готовые творческие работы в неограниченном количестве.
				<li><a href='http://referats.info/?article=set_distributor_link'>Получать ПОСТОЯННЫЙ доход от продажи наших работ</a>.
			  </ol>";
			//Сообщение заказчику:
			//тестовый режим учтён:
			$Messages->sendEmail ( $_REQUEST['user_login'],
								   $fromAddress,
								   $replyTo,
								   "Регистрация в качестве заказчика творческих работ на торговой площадке Referats.info",
								   $letter,
								   false	//текст алерта не указываем, т.к. будем выводить на стр.
								 );
	
			
			$letter2="Здравствуйте!<p>На торговой площадке referats.info зарегистрирован новый заказчик.</p>
	  <p>Регистрационные данные:</p>
	  <p>e-mail : $login
	  <br>пароль : $pass
	  </p>
	  <hr size=1 noshade>С уважением,<br>Автопилот :)";		
			
			//Сообщение админу:
			//тестовый режим учтён:
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "Регистрация нового заказчика на Referats.info",
								   $letter2,
								   false	//текст алерта не указываем, т.к. будем выводить на стр.
								 );
			return true;
		}else $Messages->alertReload("Вы уже зарегистрированы!",false);
	} //КОНЕЦ МЕТОДА
	//для отсылки пароля в скрытом режиме:
	function remPassIframe() {
		?><iframe name="sendPassword" height="240" class="widthFull" style="display:<?
		if (!isset($_SESSION['TEST_MODE'])) echo "none";?>;"></iframe><?	
	} //КОНЕЦ МЕТОДА	
}?>