<?
class Author {

//public $author_id;
public $BankAcc;
public $city;
public $email;
public $family;
public $howmach; 
public $icq;
public $login;
public $mobila;
public $name;
public $number;
public $opphone;
public $pass;
public $phone;
public $workphone;
public $myurl;
public $WMR;
public $WMZ;
public $WME;
public $YmoneY;

	//�������� ����� �������� ������ - �� ���� ������� ��� ����������:
	function calculateAuthorPayOuts($arrAuthorOrdersIDs,$order_id=false) {
	
		if ($arrAuthorOrdersIDs||$order_id) {

			global $catchErrors;
		
			//�������� ������ ������:
			$qSel="SELECT summ FROM ri_payouts WHERE ri_basket_id ";
			if ($order_id) $qSel.="= $order_id";
			else $qSel.="IN (".implode(",",$arrAuthorOrdersIDs).")";
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); 
			$payout_summ=0;
			while ($arr = mysql_fetch_assoc($rSel)) $payout_summ+=$arr['summ'];
		}
		return($payout_summ)? $payout_summ:"0";
	}	
	//���������, �� �������� �� �������������� ����� ������������:    
	function checkAuthorAsMaker($email) {  
		
		if ($email) { //�.�. ����� ����������� �� ���������

			global $catchErrors;
			//
			$qSel="SELECT login,
		   name,
		   pass,
		   phone,
		   mobila,
		   icq,
		   town,
		   WMR,
		   WMZ,
		   WME,
		   YmoneY,
		   BankAcc
	  FROM diplom_maker WHERE email='$email' OR email2='$email'";
			//die($qSel);
			//$catchErrors->select($qSel);
			$dus_r=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			$mkrws=mysql_num_rows($dus_r);
			if ($mkrws) {
				$arrMkData=array(); //echo "<h5>".$arrMkData['']."</h5>";
				$arrMkData['login']=mysql_result($dus_r,0,'login');
				$arrMkData['name']=mysql_result($dus_r,0,'name');
				$arrMkData['pass']=mysql_result($dus_r,0,'pass');
				$arrMkData['phone']=mysql_result($dus_r,0,'phone');
				$arrMkData['mobila']=mysql_result($dus_r,0,'mobila');
				$arrMkData['icq']=mysql_result($dus_r,0,'icq');
				$arrMkData['city']=mysql_result($dus_r,0,'town');
				$arrMkData['WMR']=mysql_result($dus_r,0,'WMR');
				$arrMkData['WMZ']=mysql_result($dus_r,0,'WMZ');
				$arrMkData['WME']=mysql_result($dus_r,0,'WME');
				$arrMkData['YmoneY']=mysql_result($dus_r,0,'YmoneY'); 
				$arrMkData['BankAcc']=mysql_result($dus_r,0,'BankAcc');		
				return $arrMkData;
			}
		}
	}	
	//������ � ������������ � �������� ��������� ������:
	####################################################

	//1. ��� ������ ������� ������:
	function getAllAuthorsWorxNumbers($author_id=false) { //echo "<div>author_id(getAllAuthorsWorxNumbers)= $author_id</div>";	
	
		global $catchErrors;
	
		$qSel="SELECT number FROM ri_worx";
		if ($author_id) $qSel.="
 WHERE author_id = $author_id"; 
		//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel,"��� ��������� ������");
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		$arrAuthorWorks=array();
		while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorWorks[]=$arr['number'];
		return $arrAuthorWorks;
	} //����� ������
	//2. ��� ������ (ri_basket.number) ������� ������:
	function getAllAuthorsOrdersNumbers($arrAuthorWorks) {	

		if (count($arrAuthorWorks)) {
			
			global $catchErrors;
		
			$qSel="SELECT number FROM ri_basket
 WHERE work_id IN (".implode(",",$arrAuthorWorks).")"; 
			//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel,"��� ��������� ������ (���������� �� ������� ������/������)");
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			$arrAuthorOrders=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorOrders[]=$arr['number'];
			return array_unique($arrAuthorOrders);
		}
	} //����� ������
	/*//3. ��� ���������� � ������� ������ (work_id) ������:
	function getAllAuthorsWorxIdInBasket ($arrAuthorOrders) {
		
		global $catchErrors;
		
		if (count($arrAuthorOrders)) {
			$qSel="SELECT work_id FROM ri_basket WHERE number IN (".implode(",",$arrAuthorOrders).")"; 
 			echo "<div>��� <b>����������</b> ��������� <b>������</b>:</div>"; $catchErrors->select($qSel);
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			$arrAuthorsWorkIDsInBasket=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorsWorkIDsInBasket[]=$arr['work_id'];
			$arrAuthorsWorkIDsInBasket=array_unique($arrAuthorsWorkIDsInBasket); 
			return $arrAuthorsWorkIDsInBasket;

		}
	}*/ //����� ������
	//������ ������ ��� �����������:
	function getAuthorDataAuth($email,$pass) {
	  
	  if ($email) {
		
		global $catchErrors;
		
		//�������� ������ ������:
		$qSel="SELECT * FROM ri_user WHERE login='$email'"; 
		if ($pass) $qSel.=" AND pass='$pass'";  	
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //������� �������� ���������� ������:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val; //echo "<div>$key=>$val</div>";
			} return $arr;
		}
	  }
	}	//����� ������
	//������ ������ �� ��� id:
	function getAuthorDataById($author_id) {
	  
		global $catchErrors;
		
		//�������� ������ ������:
		$qSel="SELECT * FROM ri_user WHERE number = $author_id";  	
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //������� �������� ���������� ������:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val; //echo "<div>$key=>$val</div>";
			} return $arr;
		}
	}	//����� ������
	//email (login) ������ �� ��� ID:
	function getAuthorLoginById($author_id) {
	  
	  if ($author_id) {
		
		global $catchErrors;
		
		//�������� ������ ������:
		$qSel="SELECT login FROM ri_user WHERE number = $author_id"; 
		//$catchErrors->select($qSel);
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'login');
	  }
	}	//����� ������
	//�������� id ������ id ������:
	function getAuthorIdByOrderId($ri_basket_id) {
	
		global $catchErrors;
		
		$qSel="SELECT ri_user.number FROM ri_basket, ri_user, ri_worx 
 WHERE ri_worx.number = ri_basket.work_id
   AND ri_worx.author_id = ri_user.number
   AND ri_basket.number = $ri_basket_id 
   AND work_table = 'ri_worx'"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//�������� id ������:
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'number');

	}	//����� ������
	//�������� id ������ �� id ������:
	function getAuthorIdByWorkId($work_id) {
	
		global $catchErrors,$Tools;
		$work_id=$Tools->clearToIntegerAndStop($work_id); 
		
		$qSel="SELECT author_id FROM ri_worx WHERE number = $work_id"; 
		//$catchErrors->select($qSel,true);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//�������� id ������:
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'author_id');
		//$this->author_id=$author_id;

	}	//����� ������
	//��������� ������:
	function rememberPassword($email,$actor,$table=false) {
		
		global $catchErrors;
		global $Messages;
		
		$selFrom="SELECT pass,name FROM ";
		//echo "<br>$_SERVER[REQUEST_URI]= ".$_SERVER['REQUEST_URI']."<hr>";
		//get pass:
		echo "<div>actor= $actor</div>";
		//���� �����:
		if ($actor=="author") {
			
			$qSel=($table)? 
			"$selFrom diplom_maker
 WHERE email = '$email' OR email = '$email'"
 			:
			"$selFrom ri_user
 WHERE login = '$email'"; 
			$field="pass";
			//$_SESSION['S_USER_TYPE']="author";
	
		}else{ //���� ��������:
	
			$qSel="SELECT password, name FROM ri_customer
 WHERE email = '$email' 
    OR email2 = '$email' "; 
			$field="password";
			//$_SESSION['S_USER_TYPE']="customer";
		}
	
		$rSel=mysql_query($qSel);
		//$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);	
		//��� ������ ������:
		if(!mysql_num_rows($rSel)) $Messages->alertReload("����� $email � ����� �� �� ���������.","");
		//���� ����� �����:
		elseif ($_REQUEST['pass_current']!=mysql_result($rSel,0,'pass')){
			
			$_SESSION['S_USER_NAME']=mysql_result($rSel,0,'name');
			//$catchErrors->select($qSel);
			//�������� ��������� �� ������ � ������� ����� � ��:
			$Messages->sendEmail( $email,
								  "",
								  "",
								  "�������������� ������, Referats.info",
								  "<h4>������������, ".$_SESSION['S_USER_NAME']."!</h4>
								  ��� ������ ������� � ������� �� �������� �������� <a href=\"http://www.referats.info\">Referats.info</a>: ".mysql_result($rSel,0,$field).".<p>� �������� ������ �����������, ����������, ���� �����.</p>������������� <a href=\"http://www.referats.info\">Referats.info</a>.",
								  "������ ��������� �� ����� $email."
								);
		}
	}	
	//
	function updateAuthorData($email) { //� ������ ������ ��������� ����� ������
		
		global $catchErrors;
		global $Messages;
		
		$qSql="UPDATE ri_user SET name = '$_REQUEST[name]', 
                  family = '$_REQUEST[family]', 
                    otch = '$_REQUEST[otch]', 
                   email = '$_REQUEST[email]', 
                   phone = '$_REQUEST[phone]', 
                  mobila = '$_REQUEST[mobila]', 
                     icq = '$_REQUEST[icq]', 
                    city = '$_REQUEST[city]', 
               workphone = '$_REQUEST[workphone]', 
                dopphone = '$_REQUEST[dopphone]', 
                     WMR = '$_REQUEST[WMR]', 
                     WMZ = '$_REQUEST[WMZ]', 
                     WME = '$_REQUEST[WME]', 
                  YmoneY = '$_REQUEST[YmoneY]', 
                 BankAcc = '$_REQUEST[BankAcc]', 
                 howmach = '$_REQUEST[howmach]',
				   myurl = '$_REQUEST[myurl]'
 WHERE login = '$email'"; //� ������ ������ ��������� ����� ������

		$catchErrors->update($qSql);
		$Messages->alertReload("������ ���������!","");
	  
	}	
}?>