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

	//получить сумму платежей автору - по всем заказам или выбранному:
	function calculateAuthorPayOuts($arrAuthorOrdersIDs,$order_id=false) {
	
		if ($arrAuthorOrdersIDs||$order_id) {

			global $catchErrors;
		
			//извлечём массив данных:
			$qSel="SELECT summ FROM ri_payouts WHERE ri_basket_id ";
			if ($order_id) $qSel.="= $order_id";
			else $qSel.="IN (".implode(",",$arrAuthorOrdersIDs).")";
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
			$payout_summ=0;
			while ($arr = mysql_fetch_assoc($rSel)) $payout_summ+=$arr['summ'];
		}
		return($payout_summ)? $payout_summ:"0";
	}	
	//проверить, не является ли регистрируемый автор исполнителем:    
	function checkAuthorAsMaker($email) {  
		
		if ($email) { //т.к. метод срабатывает по умолчанию

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
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
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
	//Методы в соответствии с порядком получения данных:
	####################################################

	//1. все работы данного автора:
	function getAllAuthorsWorxNumbers($author_id=false) { //echo "<div>author_id(getAllAuthorsWorxNumbers)= $author_id</div>";	
	
		global $catchErrors;
	
		$qSel="SELECT number FROM ri_worx";
		if ($author_id) $qSel.="
 WHERE author_id = $author_id"; 
		//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel,"ВСЕ АВТОРСКИЕ РАБОТЫ");
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		$arrAuthorWorks=array();
		while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorWorks[]=$arr['number'];
		return $arrAuthorWorks;
	} //КОНЕЦ МЕТОДА
	//2. все заказы (ri_basket.number) данного автора:
	function getAllAuthorsOrdersNumbers($arrAuthorWorks) {	

		if (count($arrAuthorWorks)) {
			
			global $catchErrors;
		
			$qSel="SELECT number FROM ri_basket
 WHERE work_id IN (".implode(",",$arrAuthorWorks).")"; 
			//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel,"ВСЕ АВТОРСКИЕ ЗАКАЗЫ (независимо от статуса оплаты/выплат)");
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			$arrAuthorOrders=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorOrders[]=$arr['number'];
			return array_unique($arrAuthorOrders);
		}
	} //КОНЕЦ МЕТОДА
	/*//3. все отложенные в корзину работы (work_id) автора:
	function getAllAuthorsWorxIdInBasket ($arrAuthorOrders) {
		
		global $catchErrors;
		
		if (count($arrAuthorOrders)) {
			$qSel="SELECT work_id FROM ri_basket WHERE number IN (".implode(",",$arrAuthorOrders).")"; 
 			echo "<div>ВСЕ <b>ЗАКАЗАННЫЕ</b> АВТОРСКИЕ <b>РАБОТЫ</b>:</div>"; $catchErrors->select($qSel);
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			$arrAuthorsWorkIDsInBasket=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrAuthorsWorkIDsInBasket[]=$arr['work_id'];
			$arrAuthorsWorkIDsInBasket=array_unique($arrAuthorsWorkIDsInBasket); 
			return $arrAuthorsWorkIDsInBasket;

		}
	}*/ //КОНЕЦ МЕТОДА
	//данные автора при авторизации:
	function getAuthorDataAuth($email,$pass) {
	  
	  if ($email) {
		
		global $catchErrors;
		
		//извлечём массив данных:
		$qSel="SELECT * FROM ri_user WHERE login='$email'"; 
		if ($pass) $qSel.=" AND pass='$pass'";  	
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //получим значение переменных класса:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val; //echo "<div>$key=>$val</div>";
			} return $arr;
		}
	  }
	}	//КОНЕЦ МЕТОДА
	//данные автора по его id:
	function getAuthorDataById($author_id) {
	  
		global $catchErrors;
		
		//извлечём массив данных:
		$qSel="SELECT * FROM ri_user WHERE number = $author_id";  	
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//$catchErrors->select($qSel);
	    //получим значение переменных класса:
		$arr = mysql_fetch_assoc($rSel);
		//var_dump($arr);
		if (mysql_num_rows($rSel)) {
			foreach($arr as $key=>$val) {
				$this->$key=$val; //echo "<div>$key=>$val</div>";
			} return $arr;
		}
	}	//КОНЕЦ МЕТОДА
	//email (login) автора по его ID:
	function getAuthorLoginById($author_id) {
	  
	  if ($author_id) {
		
		global $catchErrors;
		
		//извлечём массив данных:
		$qSel="SELECT login FROM ri_user WHERE number = $author_id"; 
		//$catchErrors->select($qSel);
	    $rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'login');
	  }
	}	//КОНЕЦ МЕТОДА
	//получить id автора id заказа:
	function getAuthorIdByOrderId($ri_basket_id) {
	
		global $catchErrors;
		
		$qSel="SELECT ri_user.number FROM ri_basket, ri_user, ri_worx 
 WHERE ri_worx.number = ri_basket.work_id
   AND ri_worx.author_id = ri_user.number
   AND ri_basket.number = $ri_basket_id 
   AND work_table = 'ri_worx'"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//получить id автора:
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'number');

	}	//КОНЕЦ МЕТОДА
	//получить id автора по id работы:
	function getAuthorIdByWorkId($work_id) {
	
		global $catchErrors,$Tools;
		$work_id=$Tools->clearToIntegerAndStop($work_id); 
		
		$qSel="SELECT author_id FROM ri_worx WHERE number = $work_id"; 
		//$catchErrors->select($qSel,true);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//получить id автора:
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'author_id');
		//$this->author_id=$author_id;

	}	//КОНЕЦ МЕТОДА
	//напомнить пароль:
	function rememberPassword($email,$actor,$table=false) {
		
		global $catchErrors;
		global $Messages;
		
		$selFrom="SELECT pass,name FROM ";
		//echo "<br>$_SERVER[REQUEST_URI]= ".$_SERVER['REQUEST_URI']."<hr>";
		//get pass:
		echo "<div>actor= $actor</div>";
		//если автор:
		if ($actor=="author") {
			
			$qSel=($table)? 
			"$selFrom diplom_maker
 WHERE email = '$email' OR email = '$email'"
 			:
			"$selFrom ri_user
 WHERE login = '$email'"; 
			$field="pass";
			//$_SESSION['S_USER_TYPE']="author";
	
		}else{ //если заказчик:
	
			$qSel="SELECT password, name FROM ri_customer
 WHERE email = '$email' 
    OR email2 = '$email' "; 
			$field="password";
			//$_SESSION['S_USER_TYPE']="customer";
		}
	
		$rSel=mysql_query($qSel);
		//$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);	
		//нет такого емэйла:
		if(!mysql_num_rows($rSel)) $Messages->alertReload("Емэйл $email в нашей БД не обнаружен.","");
		//есть такой емэйл:
		elseif ($_REQUEST['pass_current']!=mysql_result($rSel,0,'pass')){
			
			$_SESSION['S_USER_NAME']=mysql_result($rSel,0,'name');
			//$catchErrors->select($qSel);
			//отправим сообщение по емэйлу и запишем копию в БД:
			$Messages->sendEmail( $email,
								  "",
								  "",
								  "Восстановление пароля, Referats.info",
								  "<h4>Здравствуйте, ".$_SESSION['S_USER_NAME']."!</h4>
								  Ваш пароль доступа в аккаунт на торговой площадке <a href=\"http://www.referats.info\">Referats.info</a>: ".mysql_result($rSel,0,$field).".<p>В качестве логина используйте, пожалуйста, свой емэйл.</p>Администрация <a href=\"http://www.referats.info\">Referats.info</a>.",
								  "Пароль отправлен на адрес $email."
								);
		}
	}	
	//
	function updateAuthorData($email) { //в данном случае передаётся логин автора
		
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
 WHERE login = '$email'"; //в данном случае передаётся логин автора

		$catchErrors->update($qSql);
		$Messages->alertReload("Данные обновлены!","");
	  
	}	
}?>