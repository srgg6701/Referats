<?
class Customer {

public $customer_id;
public $customer_name;
public $customer_email;
public $customer_email2;
public $customer_password;
public $customer_mobila;
public $customer_datatime;

	function customerAuth($style){ //echo "<h5>customerAuth starts here!</h5>";
	
	global $regUser;
	global $catchErrors;?>

<? if ($_SESSION['S_USER_TYPE']!="customer"){ 
		//�������� ������ ������:
		$qSel="SELECT email,email2,password,name FROM ri_customer";
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);?>
<script type="text/javascript">        
//��������� ���� ������� ������, ����� ��������, ����������� �� ����-������ �� ��� ��������� �����
var allMails=new Array(<?
	
$i=0;
while ($arr = mysql_fetch_assoc($rSel)) { 
    if ($i) echo ",";
    echo "'".$arr['email']."'";
	if ($arr['email2']){
		if ($arr['email']) echo ",";
		echo "'".$arr['email2']."'";
	} $i++;		//die('<h1>here</h1>');
}
?>);

user_login=0;
function checkMailExisting(tmail) { 
	var uPass=document.getElementById('user_pass');
	//
	for (i=0;i<allMails.length;i++) {
		if (allMails[i]==tmail) {
			uPass.style.display='block';
		 	user_login=tmail;
		}
	}
	//
	if (user_login==0) uPass.style.display='none';
	//	
	user_login=0;
}
</script>
<? }?>

            <hr size="1" noshade />
             
            <div class="paddingTop4"<?=$style?>>
            <nobr>��� e-mail: 
            <input name="user_login" id="user_login" type="text" onMouseOver="this.title=this.value" onKeyUp="checkMailExisting(this.value);" onBlur="checkMailExisting(this.value);" size="40">
            </nobr> &nbsp;&nbsp;&nbsp;&nbsp;
            	<!--���� ���� �����-->
            	<!--<div id="new_user_name">
            	  <nobr>��� ��� �����?: <input name="user_name" type="text" size="40"></nobr>
                </div>-->
            	<!--���� ���� ���������������-->
            	<div id="user_pass" style="display:<?="none"?>;padding:4px;">
                	<img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" hspace="4" vspace="4" align="absmiddle">��������� ���� ����� ����������� ������ �� ������������������ �������������. <nobr>������� ������: 
                	<input name="password" id="password" type="password" size="40">&nbsp;&nbsp;<a href="#" onClick="sendMailAgain('customer');return false;">��������� ������</a>.</nobr><?
					
					$regUser->remPassIframe();
					
					?><br /></div>
            <span class="paddingTop8"><input name="enter" type="submit" value="�����������"  onClick="return emailCheckReferats(document.getElementById('user_login'));"></span>
            </div>    
<?  } //����� ������
	//
	function checkCustomerReg($login,$password=false) {
		
		global $catchErrors;	
		//���������, �� ��������������� �� ���:
		$qSel="SELECT number,name,email FROM ri_customer
  WHERE ( email = '$login' 
	 OR email2 = '$login'
   )"; 	
		if ($password) $qSel.="
   AND password = '$password'";
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'number');
	}
	//������� ������ ���������:
	function getCustomerData($user_id,$set_global) {
		global $catchErrors;
		//�������� ������ ������:
		$qSel="SELECT * FROM ri_customer WHERE number = $user_id";
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); 
		//		
		while ($arr = mysql_fetch_assoc($rSel)) { 
			if ($set_global) {
				//some code...
				$_SESSION['S_USER_ID']=$arr['number'];
				$_SESSION['S_USER_NAME']=$arr['name'];
				$_SESSION['S_USER_EMAIL']=$arr['email'];
				$_SESSION['S_USER_EMAIL2']=$arr['email2'];
				$_SESSION['S_USER_MOBILA']=$arr['mobila'];
			
			}else{ //����� ������ ������� ������ ���������:
			
				$this->customer_id=$arr['number'];
				$this->customer_name=$arr['name'];
				$this->customer_email=$arr['email'];
				$this->customer_email2=$arr['email2'];
				$this->customer_password=$arr['password'];
				$this->customer_mobila=$arr['mobila'];
				$this->customer_datatime=$arr['datatime'];
			
			}
		}
	}
	//�������� id ��������� �� id ������:
	function getCustomerIdByOrderID($order_id) {
		
		global $catchErrors;
		$qSel="SELECT user_id FROM ri_basket WHERE number = $order_id"; 
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'user_id');
	
	}
}
?>