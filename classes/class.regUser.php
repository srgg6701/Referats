<?php

class regUser {
	//����������� ������:
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
		// ���������� ������
		$pass = "";
		for($i = 0; $i < $number; $i++){
		  // ��������� ��������� ������ �������
		  $index = rand(0, count($arr) - 1);
		  $pass .= $arr[$index];
		}
		return $pass;
	} //����� ������
	//���������������� ������:
	function regAuthor() {

		global $catchErrors;
	  	global $Messages;
		
		//������� ��� ����������� ������:
		//���� ����������� � diplom.com.ru:
		$pass=$_REQUEST['pass_current'];
		//�� �������� ���� � ������� �������:
		if (!$pass) {
			//���� ������������� ������ ������
			if (isset($_REQUEST['pass2'])) {
				//���������� ������������ ������� (������-�� ���� �� ������, �.�. ����������� ���������� ��������):
				if ($_REQUEST['pass']!=$_REQUEST['pass2']) {
					//�������� ����� ����:
					$Messages->sendEmail (  "test@educationservice.ru",
										  	"sale@referats.info",
										  	"test@educationservice.ru",
										  	"���������� �������� ��� ����������� ������ �����������",
										  	nl2br("�� ��������� �������� ���������� ������� ���������� ��������.
											email/login: $_REQUEST[email]
											name: $_REQUEST[name]"),
										  	false	//����� ������ �� ���������, �.�. ����� �������� �� ���.
										 );
					die("<div><b class='txtRed'>������!</b></div>��������� ���� ������ �� ���������!");
				
				}else $pass=$_REQUEST['pass'];
			} //elseif(!$_REQUEST['new_author']) $this->generate_password(10); ��� ����������� ������ �� ������������ (���������������)
		}
		//��������� ������:		
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
                      '$_REQUEST[family]', ". //��������� ��������
"
                      '$_REQUEST[real_family]', ". //���� �� ������������
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

		//������� ������ ���������������
		$letter="<h4>������������, $_REQUEST[name]!</h4>
		����������� ��� � �������� ������������ �� �������� �������� <a href='http://www.referats.info' target='_blank'>referats.info</a> � �������� ������ ���������� �����!</p>
		<p>���� ��������������� ������:</p>
		<p>�����: <b>$_REQUEST[email]</b>
		<br>������ : <b>$pass</b></p>
		
		<p>������ �� ��������� ������������ ������ ������� ����� ���������, �������� �����, ��������� � �.�. � ������ ������ �������. ��� ��� ������������ &#8212; �� ���� �� ���� ������������� �� �������� ���� ������, <b>������ �� ������� ��������� ������ �� � ����� ������</b>.</p>
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
<p>��� ����� � ���� ������� �������� <a href=http://referats.info/author/?login=$_REQUEST[email]&amp;pass=$pass target=_blank>�����</a>.
		
		<hr size=1 noshade>����������� ��� �������� ������ <A HREF='http://referats.info/?section=faq_authors' target=_blank>FAQ</a>, � �� �� ������ ������ �� �������� ����� ���������� �������.
		<h3>�������� �� ������ � ������������ ��������������!</h3>";
		//��������� ������:
		//�������� ����� ����:
		$Messages->sendEmail ( $_REQUEST['email'],
							  $fromAddress,
							  $replyTo,
							  "����������� � �������� ������-������������ ���������� ����� �� �������� �������� Referats.info",
							  $letter,
							  false	//����� ������ �� ���������, �.�. ����� �������� �� ���.
					   		);

		
		$letter2="������������!<p>�� �������� �������� referats.info ��������������� ����� �����.</p>
  <p>��������������� ������:</p>
  <p>e-mail : $_REQUEST[email]
  <br>������ : $pass
  <br>Nickname: $_REQUEST[family]
  </p>
  <p>����: $_REQUEST[site]<br>
������� ������� � �������: $_REQUEST[time]</p>";
/*<!--<table border=1><tr><td>��� ����������� ����� ������ ����������</td><td>��� ��������� ����� ������ ����������</td><td>��� ����� ������� ������</td></tr><td>".str_replace(';','<br>',$af)."</td><td>".str_replace(';','<br>',$cf)."</td><td>".str_replace(';','<br>',$wf)."</td></tr></table>-->*/
  $letter2.="<p>��� ����� � ��� ������� �������� <a href='http://referats.info/author/?login=$login&amp;pass=$pass' target=_blank>�����</a>.<hr size=1 noshade>� ���������,<br>��������� :)";		
  		
		//��������� ������:
		//�������� ����� ����:
		$Messages->sendEmail ( $toAddress,
							  $fromAddress,
							  $replyTo,
							  "����������� ������ ������ �� Referats.info",
							  $letter2,
							  false	//����� ������ �� ���������, �.�. ����� �������� �� ���.
					   		);
	} //����� ������
	//���������������� ���������:
	function regCustomer($login) {

		global $catchErrors,$Customer,$Messages;
		
		if (!$Customer->checkCustomerReg($login)) {

			$pass=$this->generate_password(10);
			//��������� ������:		
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

			if (!$catchErrors->insert($qSql)&&!$_SESSION['TEST_MODE']) die('������! ������ �� ��������!<hr><pre>'.$qSql.'</pre>');
			  
			$_SESSION['S_USER_ID']=($_SESSION['TEST_MODE'])? mysql_result(mysql_query("SELECT number FROM ri_customer ORDER BY number DESC"),'0','number')+1:mysql_insert_id();
			  
			$_SESSION['S_USER_TYPE']="customer";
			$_SESSION['S_USER_NAME']=$_REQUEST['name'];
			$_SESSION['S_USER_EMAIL']=$login;
			$_SESSION['S_USER_EMAIL2']=$_REQUEST['email2'];
			$_SESSION['S_USER_MOBILA']=$_REQUEST['mobila'];
			$unum=$_SESSION['S_USER_ID'];
	
			//������� ������ ���������������
			$letter="<h4>������������";
			if (isset($_REQUEST['name'])) $letter.=", $_REQUEST[name]";
			$letter.="!</h4>
			����������� ��� � �������� ������������ �� �������� �������� <a href='http://www.referats.info' target='_blank'>referats.info</a> � �������� ������ �������!</p>
			<p>���� ��������������� ������:</p>
			<p>�����: <b>$login</b>
			<br>������: <b>$pass</b> (�� ������ ������� �������� ��� � ���� <a href='http://referats.info/?section=customer&amp;login=$login&amp;password=$pass'>������ ��������</a>)</p>
			
			<p>������ �� ������: 
			  <ol>
				<li>����������� ������� ���������� ������ � �������������� ����������.
				<li><a href='http://referats.info/?article=set_distributor_link'>�������� ���������� ����� �� ������� ����� �����</a>.
			  </ol>";
			//��������� ���������:
			//�������� ����� ����:
			$Messages->sendEmail ( $_REQUEST['user_login'],
								   $fromAddress,
								   $replyTo,
								   "����������� � �������� ��������� ���������� ����� �� �������� �������� Referats.info",
								   $letter,
								   false	//����� ������ �� ���������, �.�. ����� �������� �� ���.
								 );
	
			
			$letter2="������������!<p>�� �������� �������� referats.info ��������������� ����� ��������.</p>
	  <p>��������������� ������:</p>
	  <p>e-mail : $login
	  <br>������ : $pass
	  </p>
	  <hr size=1 noshade>� ���������,<br>��������� :)";		
			
			//��������� ������:
			//�������� ����� ����:
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "����������� ������ ��������� �� Referats.info",
								   $letter2,
								   false	//����� ������ �� ���������, �.�. ����� �������� �� ���.
								 );
			return true;
		}else $Messages->alertReload("�� ��� ����������������!",false);
	} //����� ������
	//��� ������� ������ � ������� ������:
	function remPassIframe() {
		?><iframe name="sendPassword" height="240" class="widthFull" style="display:<?
		if (!isset($_SESSION['TEST_MODE'])) echo "none";?>;"></iframe><?	
	} //����� ������	
}?>