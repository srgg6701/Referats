<? 
//отправка почты в потоковом режиме через SMTP хостера 
function smtpmail(  $to,				//адрес получателя
					$subject,			//тема сообщения
					$content,			//текст сообщения
					$username,			//***логин отправителя
					$reply_to_email,	//***адрес для ответа
					$reply_to_name,		//***имя получателя ответа
					$sender_address,	//***адрес отправителя
					$sender_name,		//***имя отправителя
					$attach=false,		//если нет аттачмента
					$file_name=false
				 ) { //echo "<h3>host= ".$_SERVER['HTTP_HOST']."</h3>";

//пригодится для тестирования:
if (!$_SESSION['S_ADMIN_EMAIL']) $_SESSION['S_ADMIN_EMAIL']="sale@referats.info";

//логин авторизации для SMTP-СЕРВЕРА:
if (!$username||$username=="default") $username=$_SESSION['S_ADMIN_EMAIL'];
//если имя отправителя не получено, подставим по умолчанию имя заавторизованной компании.
if (!$reply_to_name) $reply_to_name=$_SESSION['S_USER_NAME'];
//если не получили глобальное имя, подставим имя системы:
if (!$reply_to_name) $reply_to_name='Referats.info';
//если не получили имя отправителя, подставим имя получателя или системы:
if (!$sender_name) $sender_name=$reply_to_name;
//если не получили адрес отправителя:
if (!$sender_address) $sender_address=$_SESSION['S_ADMIN_EMAIL'];
//если не получили обратный адрес:
if (!$reply_to_email) $reply_to_email=$_SESSION['S_ADMIN_EMAIL'];
	
//$content
//эмулируем сообщение:					 
if ($_SESSION['TEST_MODE']=="enabled") { 
	echo "<div class='padding4'>ФУНКЦИЯ <strong>smtp_mail()</strong><div style='cursor:pointer; border:solid 1px #cccccc; background-color: #d7eaff; padding: 6px' onclick=\"nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';\">Отправлено сообщение по <strong>емэйлу</strong>:</div>
<div style='display:none;'>
	//логин авторизации на почтовом сервере хостера:       <span style='color:#999999'>$username</span><hr>
	//адрес получателя:        <strong>$to</strong><br><br>
	//тема сообщения:          $subject<br>
	//текст сообщения:         $content<br>
	//адрес для ответа:        $reply_to_email<br>
	//имя получателя ответа:   $reply_to_name<br>
	//адрес отправителя:       $sender_address<br>
	//имя отправителя:         $sender_name<br>
	//если нет аттачмента:     $attach=false<br>
</div>КОНЕЦ ФУНКЦИИ smtp_mail()</div>";
	return "TEST";
}
//отправляем сообщение:
elseif (!strstr($_SERVER['HTTP_HOST'],"localhost"))
  {	//echo ("<h2>Start is here!</h2>".$_SERVER['HTTP_HOST']);
  	//
    require_once('class.phpmailer.php');	
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	try { $mail->Host       = 'referats.info';
		  $mail->SMTPDebug  = '0';
		  $mail->SMTPAuth   = 'TRUE';
		  $mail->Port       = '587';
		  $mail->Username   = $username;//'esys@educationservice.ru';
		  $mail->Password   = 'historical'; //пароль для авторизации на сервере хостера
		  $mail->AddReplyTo($reply_to_email,$reply_to_name);
		  $mail->AddAddress($to);
		  $mail->SetFrom($sender_address, $sender_name);
		  $mail->Subject = htmlspecialchars($subject);
		  $mail->MsgHTML($content);
		  if($attach)  $mail->AddAttachment($attach,$file_name);
		  $mail->Send();
		} 
	catch (phpmailerException $e) { echo $e->errorMessage(); }
	catch (Exception $e) { echo $e->getMessage(); }
  }
} ?>