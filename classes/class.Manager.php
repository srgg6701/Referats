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

	//получить данные сотрудника:
	function getManagerData($number,$login=false,$pass=false) {
		
		global $catchErrors;
		
		//извлечём массив данных:
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
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //получим значение переменных класса:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val;
				//echo "<div>$key=>$val</div>";
			} 
			$_SESSION['S_MANAGER_EMAIL']=$this->email; //потому что массив доступен не везде
			return $arr;
		}
	}
	//
	function updateWorkerData() { //в данном случае передаётся логин автора
		
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
 WHERE number = $_SESSION[S_USER_ID]"; //в данном случае передаётся логин автора

		$catchErrors->update($qSql);
		$Messages->alertReload("Данные обновлены!","");
	  
	}	
	
}

?>