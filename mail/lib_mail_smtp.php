<? 
//�������� ����� � ��������� ������ ����� SMTP ������� 
function smtpmail(  $to,				//����� ����������
					$subject,			//���� ���������
					$content,			//����� ���������
					$username,			//***����� �����������
					$reply_to_email,	//***����� ��� ������
					$reply_to_name,		//***��� ���������� ������
					$sender_address,	//***����� �����������
					$sender_name,		//***��� �����������
					$attach=false,		//���� ��� ����������
					$file_name=false
				 ) { //echo "<h3>host= ".$_SERVER['HTTP_HOST']."</h3>";

//���������� ��� ������������:
if (!$_SESSION['S_ADMIN_EMAIL']) $_SESSION['S_ADMIN_EMAIL']="sale@referats.info";

//����� ����������� ��� SMTP-�������:
if (!$username||$username=="default") $username=$_SESSION['S_ADMIN_EMAIL'];
//���� ��� ����������� �� ��������, ��������� �� ��������� ��� ���������������� ��������.
if (!$reply_to_name) $reply_to_name=$_SESSION['S_USER_NAME'];
//���� �� �������� ���������� ���, ��������� ��� �������:
if (!$reply_to_name) $reply_to_name='Referats.info';
//���� �� �������� ��� �����������, ��������� ��� ���������� ��� �������:
if (!$sender_name) $sender_name=$reply_to_name;
//���� �� �������� ����� �����������:
if (!$sender_address) $sender_address=$_SESSION['S_ADMIN_EMAIL'];
//���� �� �������� �������� �����:
if (!$reply_to_email) $reply_to_email=$_SESSION['S_ADMIN_EMAIL'];
	
//$content
//��������� ���������:					 
if ($_SESSION['TEST_MODE']=="enabled") { 
	echo "<div class='padding4'>������� <strong>smtp_mail()</strong><div style='cursor:pointer; border:solid 1px #cccccc; background-color: #d7eaff; padding: 6px' onclick=\"nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';\">���������� ��������� �� <strong>������</strong>:</div>
<div style='display:none;'>
	//����� ����������� �� �������� ������� �������:       <span style='color:#999999'>$username</span><hr>
	//����� ����������:        <strong>$to</strong><br><br>
	//���� ���������:          $subject<br>
	//����� ���������:         $content<br>
	//����� ��� ������:        $reply_to_email<br>
	//��� ���������� ������:   $reply_to_name<br>
	//����� �����������:       $sender_address<br>
	//��� �����������:         $sender_name<br>
	//���� ��� ����������:     $attach=false<br>
</div>����� ������� smtp_mail()</div>";
	return "TEST";
}
//���������� ���������:
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
		  $mail->Password   = 'historical'; //������ ��� ����������� �� ������� �������
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