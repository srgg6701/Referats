<?

class Manager {

public $city;
public $email;
public $email2;
public $family;
public $futhers;
public $icq;
public $login;
public $mobila;
public $number;
public $name;
public $password;
public $skype;
public $status;

	//�������� ������ ����������:
	function getManagerData($number,$login=false,$pass=false) {
		
		global $catchErrors;
		
		//�������� ������ ������:
		$qSel="SELECT * FROM ri_workers WHERE";
		if ($login) $qSel.=" login = '$login'"; 
		if ($number) {
			if ($login) $qSel.=" AND "; 
			$qSel.=" number = '$number'"; 		
		}
		if ($pass) {
			if ($login||$number) $qSel.=" AND "; 
			$qSel.=" password='$pass'";  	
		}
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //������� �������� ���������� ������:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val;
				//echo "<div>$key=>$val</div>";
			} 
			$_SESSION['S_MANAGER_EMAIL']=$this->email; //������ ��� ������ �������� �� �����
			return $arr;
		}
	}
	//
	function updateWorkerData() { //� ������ ������ ��������� ����� ������
		
		global $catchErrors;
		global $Messages;
		
		$qSql="UPDATE ri_workers SET name = '$_REQUEST[name]', 
                  family = '$_REQUEST[family]', 
                 futhers = '$_REQUEST[otch]', 
                   email = '$_REQUEST[email]', 
                  email2 = '$_REQUEST[email2]', 
                  mobila = '$_REQUEST[mobila]', 
                     icq = '$_REQUEST[icq]', 
                   skype = '$_REQUEST[skype]', 
                    city = '$_REQUEST[city]' 
 WHERE number = $_SESSION[S_USER_ID]"; //� ������ ������ ��������� ����� ������

		$catchErrors->update($qSql);
		$Messages->alertReload("������ ���������!","");
	  
	}	
	
}

?>