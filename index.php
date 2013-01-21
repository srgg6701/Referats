<? 	session_start();
header('Content-type: text/html; charset=windows-1251');
//если тупой робот ломится на страницу, которой в реальности нет:
if ( (isset($_REQUEST['work_id'])&&!$_REQUEST['work_id'])||
	 (isset($_REQUEST['show_annotation'])&&!$_REQUEST['show_annotation'])||
	 (isset($_REQUEST['file_index'])&&!$_REQUEST['file_index'])||
	 (isset($_REQUEST['work_table'])&&!$_REQUEST['work_id'])||
	 (isset($_REQUEST['work_table'])&&!$_REQUEST['work_id'])||
	 strstr($_SERVER['REQUEST_URI'],"function.include")||
	 strstr($_SERVER['REQUEST_URI'],"function.unlink")
   ) { 
   header("location: bank-referatov.php");
   die();
}
if (isset($_GET['social_bookmarks'])) {
echo '<html>
	<head>
    	<title>Добавить сайт в социальные закладки</title>
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
    </head>
<body class="padding0 paddingTop6 bgF4FF">' ?>
<div align="center"><?
	if (isset($_REQUEST['go_community_lab'])) $community_link="go_community_lab=1&";
	$sociolink='<a href="index.php?'.$community_link.'article=set_distributor_link" onMouseOver="this.style.textDecoration=\'none\';" target="_parent">';
		
	if (!$_SESSION['S_USER_TYPE']||!$_SESSION['S_USER_ID']){ 
			
		echo $sociolink;?><img alt="Добавить банк рефератов в социальные закладки" border="0" src="images/odnaknopka.png" width="256" height="16"><?
		
	}else{?><noindex><script src="http://odnaknopka.ru/ok3.js" type="text/javascript"></script></noindex><?
	}?>&nbsp;&nbsp;<?=$sociolink?>подробнее...</a></div><?
		
echo '</body>
</html>';
		die();
}
	
require_once('connect_db.php');
//
require_once('classes/class.Actions.php');
$Actions=new Actions;
//
require_once("classes/class.Author.php");
$Author=new Author;
//
require_once('classes/class.Blocks.php');
$Blocks=new Blocks;
require_once('classes/class.dbSearch.php');
//объявляется далее, по условию: if ($work_subject)
require_once('classes/class.Errors.php');
$catchErrors=new catchErrors;
require_once('classes/class.Customer.php');
$Customer=new Customer;
require_once('classes/class.Messages.php');
$Messages=new Messages; 
require_once('classes/class.Money.php');
require_once('classes/class.Navigate.php');
$Money=new Money;
require_once ("classes/class.regUser.php");
$regUser=new regUser;
require_once ("classes/class.Tools.php");
$Tools=new Tools;
require_once ("classes/class.Worx.php");
$Worx=new Worx;

$req_work_id=$Tools->clearToIntegerAndStop($_REQUEST['work_id']);
//echo ("work_id= $req_work_id");
//для корректного перехода на главную страницу на localhost:
$go_index=(strstr($_SERVER['HTTP_HOST'],"localhost"))? "index.php":"/";


//конвертировать значения полей типов работ и предметов в латиницу (конечная цель - создание ЧПУ):
//типы работ:
$where=" WHERE human_friendly_url = ''";
$qSel="SELECT number,predmet,human_friendly_url FROM diplom_worx_topix $where"; 
$rSel=mysql_query($qSel);
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
if (mysql_num_rows($rSel)){
	while ($arr = mysql_fetch_assoc($rSel)) { 
		$cpu=$Tools->convertToLatin($arr['predmet']);                                   
		if ($cpu!=$arr['human_friendly_url']) {
			$qUpd='UPDATE diplom_worx_topix SET human_friendly_url = "'.$cpu.'" WHERE number = '.$arr['number'];
			$catchErrors->update($qUpd);
		}
	}
}
//предметы:
$qSel="SELECT number,`type`,human_friendly_url FROM diplom_worx_types $where"; 
$rSel=mysql_query($qSel);
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
if (mysql_num_rows($rSel)){
	while ($arr = mysql_fetch_assoc($rSel)) { 
		$cpu=$Tools->convertToLatin($arr['type']);
		if ($cpu!=$arr['human_friendly_url']) {
			$qUpd='UPDATE diplom_worx_types SET human_friendly_url = "'.$cpu.'" WHERE number = '.$arr['number'];
			$catchErrors->update($qUpd);
		}
	}
}
//для определения вложенности:
$current_level="index";
//условие для главной страницы:
if ( !$_REQUEST['work_table']&&
	 !$_REQUEST['work_type']&&
	 !$req_work_id &&
	 !$_REQUEST['section']&&
	 !$_REQUEST['article']&&
	 $_REQUEST["mode"]!="skachat-rabotu"
   ) $page_default=true;

//
if ($_REQUEST['mode']=="exit") { echo "<h1>exit</h1>";
	session_unset();
	$Messages->alertReload("","index.php");
}
//если подключили лабораторию сообщества:
if (isset($_REQUEST['go_community_lab'])) {

	include("community.php");
	die();
}

if (isset($_REQUEST['ret'])) $ret=$_REQUEST['ret'];

//если добавляли комментарий к разделу:
if (isset($_REQUEST['comment'])) { 

	$_SESSION['S_LAST_COMMENT']=$_REQUEST['comment']; //потому что можем вернуть
	$_SESSION['S_LAST_NAME']=$_REQUEST['name'];
	$_SESSION['S_LAST_EMAIL']=$_REQUEST['email'];
	//$_SESSION['S_LAST_MOBILA']=$_REQUEST['mobila'];
	//$_SESSION['S_LAST_SKYPE']=$_REQUEST['skype'];
	//$_SESSION['S_LAST_ICQ']=$_REQUEST['icq'];
	
	
	if (isset($_POST['capche'])&& $_POST['capche']==$_SESSION['S_CAPCHE']) {

		$msbj="Комментарий к разделу $_REQUEST[add_comment_type].";
		$mtxt=nl2br($_REQUEST['comment']."<hr>Отправитель: $_REQUEST[name].");
	
		//отправить сообщение по емэйлу
		$Messages->sendEmail( $toAddress,
							  $_REQUEST['email'],
							  $_REQUEST['email'],
							  $msbj,
							  $mtxt,
							  false
							);					
		//добавить запись в таблицу ri_messages
		$Messages->writeMessTbl( $_REQUEST['name'],
								 $ri_basket_id,
								 $toAddress,
								 $receiver_user_id,
								 "admin",
								 $_SERVER['REQUEST_URI'],
								 $msbj,
								 $mtxt
							   );
		unset($_SESSION['S_LAST_COMMENT']);
		unset($_SESSION['S_LAST_NAME']);
		unset($_SESSION['S_LAST_EMAIL']);
		//unset($_SESSION['S_LAST_MOBILA']);
		//unset($_SESSION['S_LAST_SKYPE']);
		//unset($_SESSION['S_LAST_ICQ']);
		
		$mess="Ваше сообщение отправлено!\\nМы постараемся ответить вам в ближайшее время.";

	}else{
	
		$mess="Вы указали неправильный код подтверждения.\\nПожалуйста, повторите!";
		if (!$ret||!strstr($ret,"?")) $ret="index.php";
		$ret.="#message_start";
	}
	if ($mess) {
		$Messages->alertReload($mess,$ret);
	}
}

function warnindSessionVars() {
?><H4>ВНИМАНИЕ! Созданы сессионные переменные.
					<br>Чтобы удалить их, нужно <a href="index.php?mode=exit">закрыть сессию.</a></H4><? 
}
//юзер заавторизован: 
	//добавляем заказ в корзину
//...не заавторизован: 
	//сохраняем массив REQUEST в глобальной переменной, чтобы извлечь данные для добавления заказа после авторизации/регистрации юзера
function addWorksToBasket($action) { 
	
	//ДОБАВЛЕНИЕ ЗАКАЗА
	foreach ($_REQUEST as $key=>$val) 
		if (strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_")) {
		
			$orders_stream=true;
			break;
		}
		
	if ( $orders_stream || //несколько заказов
		 //одиночная загрузка
		 $_REQUEST['buy_work'] ||
		 $_REQUEST['order_work'] ||
		 $req_work_id
	   ){
			//$test_function=true;
			if ($test_function&&$_SESSION['TEST_MODE'])	{
				//echo "<h5 class='txtGreen'>addWorksToBasket(\$action=$action) just STARTED</h5>";
				echo "<h5 class='txtGreen'>\$action=$action -> just STARTED!</h5>";
				echo "<div class='txtOrange'>(начало) \$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
			}
		
		global $catchErrors,$Messages,$Worx;
		
			//отладка:
			$test_loop=true; 
	
		//сохраняли данные формы в глобальной пер.:
		if($action=="save") {
						
			$_SESSION['saved_orders']=$_REQUEST;
			if ($test_loop&&$_SESSION['TEST_MODE']) {
				echo "<div><div style='color:red'>Сохранили массив \$_REQUEST в глобальной переменной:</div>";
				foreach ($_SESSION['saved_orders'] as $key=>$val)
					echo "<div style='color:green'>[$key]=>$val</div>";
				//var_dump($_SESSION['saved_orders']);
				echo "</div>";
			}
	
		}elseif ( //добавляли заказ:
				  //ВНИМАНИЕ! 
				  //данные условия необходимы, чтобы идентифицировать момент добавления заказа;
				  //в противном случае таковым воспринимается и загрузка профайла работы
				  $_REQUEST['order_action']=="add_to_basket"
				){	
				
				//отладка:
				if ($test_loop&&$_SESSION['TEST_MODE']) echo "<div><div style='color:red'>добавляем заказ(ы)</div>";
	
			$bsk=0;//для проверки откладываемых в корзину заказов и, соответственно - отображения или сокрытия следующего блока.
			//проверяем, не помещали ли в корзину?
			$add_basket=0; //счётчик добавлений заказов в корзину
			$cancel_basket=0; //счётчик отмены добавлений заказов в корзину
			//передаём массиву данные для извлечения из массива REQUEST (текущего или ранее сохранённого).
			//$_SESSION['saved_orders'] - ранее сохранённый запрос REQUEST (ДО аутентификации заказчика)
			if (isset($_SESSION['saved_orders'])) {
				
				$arrToUse=$_SESSION['saved_orders'];
				$arrBody="SESSION[saved_orders]";
			}
			else {
				
				$arrToUse=$_REQUEST;
				$arrBody="REQUEST";
			}
			
			if (isset($_SESSION['TEST_MODE'])) echo "<div>arrBody= $arrBody</div>";
			
				//$test_arrToUse=true;
				if ($test_arrToUse&&$_SESSION['TEST_MODE']) {
					echo "<div class='txtOrange'>addWorksToBasket(\$action=$action) works!<br>\$arrToUse= "; 
					echo(!$_SESSION['saved_orders'])? "\$_REQUEST":"\$_SESSION['saved_orders']"; 
					echo "</div>";
				}
	
				//
				if ($test_loop&&$_SESSION['TEST_MODE']) {
	
					echo "<hr>\$arrToUse is ";
					if (is_array($arrToUse)) {
						echo "Array: ";
						foreach ($arrToUse as $key=>$val)
							echo "<div>[$key]=> $val</div>";
					}else{ 
						echo "\$arrToUse type is ".gettype($arrToUse);
						//var_dump($arrToUse);
					}
					echo "<hr>";
				}
	
			//если массив создан и он не пуст:
			if (is_array($arrToUse)&&count($arrToUse)) { 
				if(isset($_SESSION['TEST_MODE']))
					echo "<h5>Inside of \$arrToUse...</h5>";
	
				$arrOrderData=array();
				$count_work_table=0;
				$count_work_id=0;
				//			
				foreach ($arrToUse as $key=>$val){ 
					if(isset($_SESSION['TEST_MODE']))
						echo "<div>Inside of foreach(\$arrToUse): [$key]=>$val</div>";
					//пакетное действие 			 
					//условие НЕ ИЗМЕНЯТЬ, иначе подставляются не те переменные!
					if (strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_")) { 
						if(isset($_SESSION['TEST_MODE']))echo "<div><b>[$key]</b>=> $val</div>";
						//указываем таблицы заказов:
						$arrOrderData[$count_work_table]['table']=(strstr($key,"order_diplom_zakaz_"))? "diplom_zakaz":"ri_worx";
						//
						$count_work_table++;
						//указываем id работ:
						$arrOrderData[$count_work_id]['work_id']=$val;
						//
						$count_work_id++;
					
					}else{ //одиночный заказ	//echo "<div><b><em>[$key]</em></b>=> $val</div>";
						
						//ВНИМАНИЕ! 
						//ОБА нижележащих условия должны выполняться последовательно, т.к. оба значения должны быть включены в адрес страницы:	
						if ($key=="work_table") $arrOrderData[0]['table']=$val;
						//echo "<div>[$key]=>$val</div>";
						if ( //переменные массива $_REQUEST (для разных случаев), которые могут содержать id работы
							 ( $key=="order_work"||
							   $key=="buy_work" || //если клацали кнопку "купить", id работы сохраняется здесь
							   $key=="work_id"
							 ) && 
							   $val //иначе может обнулить [0][work_id]
						   ) $arrOrderData[0]['work_id']=$val;
					}
				} //for ($i=0;$i<count($arrOrderData);$i++) foreach($arrOrderData[$i] as $key=>$val) echo "<div>[$i][$key]=> $val</div>";
				
				//если создали массив данных:
				if (count($arrOrderData)) {
					
					$bsk=0;
					foreach ($arrOrderData as $key=>$val) { 
					//echo "<div>[$key]=>$val</div>"; 
					//if (is_array($val)) foreach ($val as $key2=>$val2) echo "<div>[$key2]=>$val2</div>";
					
						//проверить - есть ли такой заказ в корзине. Если нет - добавить:
						$qSel="SELECT number FROM ri_basket
 WHERE user_id = $_SESSION[S_USER_ID] 
   AND work_table = '".$arrOrderData[$bsk]['table']."' 
   AND work_id = ".$arrOrderData[$bsk]['work_id']; 
						//$catchErrors->select($qSel);
						//echo "<hr>buy_work, order_work= ".$_REQUEST['buy_work'].", ".$_REQUEST['order_work']."<hr>"; 
	
						$rSel=mysql_query($qSel);
						$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel (1)",$qSel);
						if(!mysql_num_rows($rSel)) {
					
							########################################################
							//добавляем запись:
							//ПОЛУЧИТЬ id работы из ri_worx
							$qIns="INSERT INTO ri_basket ( user_id, 
                        work_table, 
                        work_id, 
                        datatime 
                      ) VALUES 
                      ( $_SESSION[S_USER_ID], 
                        '".$arrOrderData[$bsk]['table']."', 
                        ".$arrOrderData[$bsk]['work_id'].",
                        '".date('Y-m-d H:i:s')."' 
                      )";
							$catchErrors->insert($qIns);
							$add_basket++;
			
						}else $cancel_basket++;
						$bsk++; //инкременируем счётчик цикла добавлений
					}
				}
			}
		
			//удалить переменную с id id работ:
			unset($_SESSION['saved_orders']);
	
				if ($test_loop&&$_SESSION['TEST_MODE']) {
					echo "<div class='txtRed'>Удалили глобальную переменную \$_SESSION['saved_orders']";
					//:<br>\$_SESSION['saved_orders']=";var_dump($_SESSION['saved_orders']);
					echo "</div>";
				}
			
			//если пытались добавлять заказы в корзину:
			if ($bsk&&($add_basket||$cancel_basket)) {
				
				$add_value=$add_basket-$cancel_basket;
				if ($add_basket) $added="Добавлено заказов: $add_value"; 
				if ($cancel_basket) $cancel="\\nОтменено добавлений (уже есть в вашей корзине): $cancel_basket"; 
				$pageReload="?section=customer";
				//если покупали работу, передадим идентификатор загрузки таблицы оплаты:
				if (isset($_REQUEST['buy_work'])) $pageReload.="&add_payment=".$req_work_id;
	
				if (isset($_SESSION['TEST_MODE'])) {
					
					?><noindex><script language="JavaScript" type="text/JavaScript" src="js.js"></script></noindex><?
					
					$catchErrors->showGetPostDataForeach($mType);
					
					if (isset($_SESSION['S_USER_TYPE'])) warnindSessionVars();
				}
				$Messages->alertReload($added.$cancel,$pageReload); 
			}
		}
	}
}	//КОНЕЦ МЕТОДА addWorksToBasket()

if (isset($_SESSION['TEST_MODE'])) {?><noindex><script language="JavaScript" type="text/JavaScript" src="js.js"></script></noindex>
<noindex><script language="JavaScript" type="text/JavaScript" src="email_check.js"></script></noindex><? }

//добавить заказы в корзину (если id id работ содержатся в массиве $_REQUEST):
if ($_SESSION['S_USER_TYPE']=="customer") addWorksToBasket("insert");

//регистрировали или аутентифицировали субъекта:
elseif (isset($_REQUEST['user_login'])) { 

	//Передавали значение поля логина юзера, но не получили (ещё или вообще) подтверждения предложения аутентификации
	if (!$_REQUEST['apply_register']) {
		
		 //проверить указанный емэйл (он же - логин):
		//если не щарегистрирован:
		if (!$Customer->checkCustomerReg($_REQUEST['user_login'])) {//юзер НЕ обнаружен
			
			if (isset($_SESSION['TEST_MODE'])) echo "<h5>addWorksToBasket(save)</h5>";
			//если нет такого юзера, но (возможно) он пытался добавить в корзину заказы:
			addWorksToBasket("save");//сохранить массив REQUEST  в сессионной переменной ДО регистрации юзера...
			
			//die("<a href='?section=customer&amp;user_login=$_REQUEST[user_login]&amp;apply_register=yes'>?section=customer&amp;user_login=$_REQUEST[user_login]&amp;apply_register=yes</a>");
			
			//1. перегрузнть страницу
			//2. указать емэйл юзера в качестве логина (снова загрузит данный внешний блок
			//3. передать метку подтверждения процедуры аутентификации, что выполненит следующий (параллельный) блок 
			$alert_mess="Емэйл $_REQUEST[user_login] в нашей БД не обнаружен!\\nЖелаете зарегистрироваться с этим емэйлом?";
			$go_page="?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes";
			if (isset($_REQUEST['buy_work'])) $go_page.="&buy_work=$_REQUEST[buy_work]";
			if (isset($_REQUEST['order_work'])) $go_page.="&order_work=$_REQUEST[order_work]";
			if (isset($_REQUEST['work_table'])) $go_page.="&work_table=$_REQUEST[work_table]";
			if ($_REQUEST['order_action']=="add_to_basket") $go_page.="&order_action=add_to_basket";

			if (isset($_SESSION['TEST_MODE'])){
        
				if (isset($_SESSION['S_USER_TYPE'])) warnindSessionVars();
				
				$catchErrors->showGetPostDataForeach($mType); //вывод переменных в тестовом режиме
				echo "<div><hr><b>alert:</b> $alert_mess<hr>location.href= <a href='$go_page'>$go_page</a></div>";
		    
			}else{?>
<noindex><script type="text/javascript">

goPage=(confirm('<?=$alert_mess?>'))? "<?=$go_page?>":"<?=$_SERVER['REQUEST_URI']?>";
	//window.open(goPage,'appl');
location.href=goPage;
</script></noindex>
	<?		}
			die();	
		
		}else{ //юзер обнаружен:
			
			//проверим, тот ли пароль:
			$_SESSION['S_USER_ID']=$Customer->checkCustomerReg($_REQUEST['user_login'],$_REQUEST['password']);
			//пароль не тот:
			if (!$_SESSION['S_USER_ID']) {
				
				$Messages->alertReload("Пароль указан неверно!","?section=customer"); 
				die();
	
			}else{ //пароль правильный
	
				$_SESSION['S_USER_TYPE']="customer";
				//получить глобальные переменные:
				$Customer->getCustomerData($_SESSION['S_USER_ID'],true);
			}
		}
	
	//передавали метку регистрации нового юзера (уже после подтверждения регистрации с неизвестным емэйлом):
	}else{		//echo "<div>\$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
		//if (isset($_SESSION['TEST_MODE'])) 
		//если нет такого юзера, но (возможно) он пытался добавить в корзину заказы:
		$regUser->regCustomer($_REQUEST['user_login']);
		
	}	
}?>
  
<html>
<head>
<title><?
if ($req_work_id&&$_REQUEST['work_table']) { 
	
		//получить тему:
		if ($_REQUEST['work_table']=="ri_worx"){
			//
			$qSel="SELECT work_name, work_type FROM ri_worx WHERE number = $req_work_id"; 
			//$catchErrors->select($qSel);
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			if (mysql_num_rows($rSel)) {
				
				$work_name=mysql_result($rSel,0,'work_name');
				$wtype=mysql_result($rSel,0,'work_type');
				
			}
		
		}elseif($_REQUEST['work_table']=="diplom_zakaz"){

			$qSel="SELECT subject, typework 
  FROM diplom_zakaz, diplom_worx_topix 
 WHERE diplom_zakaz.predmet = diplom_worx_topix.number
   AND diplom_zakaz.number = $req_work_id";
			//$catchErrors->select($qSel);
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			if (mysql_num_rows($rSel)) {
				
				$work_name=mysql_result($rSel,0,'subject');
				$wtype=mysql_result($rSel,0,'typework');
			}
		}	
	echo $work_name.", скачать ".strtolower($wtype).".";

}else{
	
	if (isset($_REQUEST['work_type'])) {
	
		echo $Tools->convertField2CPU("diplom_worx_types",
							   "type", //имя поля c данными на кириллице (predmet/typework)
							   $_REQUEST['work_type'] //входящее значение поля для конвертации
							 ).", скачать";
		
	
	}else{
	
		?>Банк рефератов. Скачать курсовую, диплом, реферат. <? echo $_REQUEST['work_area'];
	
	}
	
}?></title>
<?
if (strstr($_SERVER['REQUEST_URI'],"bank-referatov.php")){
	echo "\n";?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"><? 
	echo "\n";
}?>
<meta name="description" content="<?
if ($work_name) {
	
	$load_work_name=$work_name;
	echo "$load_work_name. ";
}
?>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
<noindex><script language="JavaScript" type="text/JavaScript" src="js.js"></script></noindex>
<noindex><script language="JavaScript" type="text/JavaScript" src="email_check.js"></script></noindex>
<noindex><script type="text/javascript">
//пакетная проверка отмеченных чекбоксов
function checkAllBoxes(reg_area) {
var un=0;
var allBoxes=document.getElementById('tbl_customer').getElementsByTagName('INPUT');
for (i=1;i<allBoxes.length;i++) if (allBoxes.item(i).checked==true) un++;
	if (un==0) {
		alert('Вы не отметили ни одной работы!');
		return false;
	}
<?  //если не аутентифицирован, как заказчик:
	if ($_SESSION['S_USER_TYPE']!="customer"){?>
	else return showAuthForm(reg_area);
<? } echo "\n";?>
}

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24990263-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script></noindex>

<!-- Put this script tag to the <head> of your page -->
<noindex><script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?11" charset="windows-1251"></script></noindex>

</head>
<body<? if($_REQUEST['section']=="register") echo ' bgcolor="#E1E1FF"';?> onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');"><?

if (isset($_SESSION['TEST_MODE'])){
	?>Режим тестирования включён. <a href="<? echo $_SERVER['REQUEST_URI'];
	echo(strstr($_SERVER['REQUEST_URI'],"?"))? "&":"?";
	?>test_mode=off">Отключить...</a><? //echo "[TEST_MODE]= ".$_SESSION['TEST_MODE'];
}

//echo "\$_SESSION['S_USER_TYPE']=".$_SESSION['S_USER_TYPE'];?>
<table width="100%" cellspacing="0" cellpadding="0">
  <tr class="borderBottom4 borderColorGray">
    <td width="25%" height="82" align="center" nowrap bgcolor="#003399" style="background-image:url(images/corners/top_blue.gif); background-position:top; background-repeat:repeat-x;" class="padding10"><?
	
	if (!$page_default){
    	
		?><a href="<? echo $_SESSION['SITE_ROOT'];
	
	}else echo "<span style=\"cursor:pointer;\" onClick=\"location.href='$_SESSION[SITE_ROOT]'";?>" class="txtWhite header" title="На главную"><img src="images/logo_docs.png" alt="Рефераты, курсовые, дипломные работы скачать. Готовые работы, дипломы на заказ рефераты" width="61" height="32" hspace="4" border="0" align="absmiddle">Referats.<span style="color:#ffcc00;">info</span><?
	
	if (!$page_default){
    	
		?></a><?
	}else echo "</span>";?></td>
    <td width="52%" align="center" bgcolor="#FFCC00" style="background-image:url(images/corners/top_orange.gif); background-position:top; background-repeat:repeat-x;" class="padding10">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border:none;" class="txt100"><strong><h1 style="display:inline; font-size:100%;"><a href="?section=authors" onClick="location.href='?mode=skachat-rabotu'; return false">БАНК РЕФЕРАТОВ</a></h1> 
          &nbsp;компании <script type="text/javascript">
dwrite('EducationService');
</script>. Готовые творческие работы:</strong></td>
      </tr>
      <tr>
        <td style="border:none;">
        <h1 class="padding0 noBold txt110 Cambria"><a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Дипломная работа");?>">Дипломные работы</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Диплом MBA");?>">дипломы MBA</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Курсовая работа");?>">курсовые работы</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Реферат");?>">рефераты</a> и <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Диссертация");?>">диссертации</a>!</h1></td>
      </tr>
    </table>      </td>
    <td width="23%" align="center" valign="bottom" bgcolor="#FFCC00" id="tdConnect" style="background-image:url(images/corners/top_orange.gif); background-position:top; background-repeat:repeat-x;">
    <a href="javascript:callViaSkipe('+79044428447');" title="Звонок на мобильный телефон по скайпу"><img src="images/phone_sound.png" width="32" height="32" border="0" onMouseOver="showFeedBack('+7 904 442 84 47');"></a>
    <a href="javascript:sendEmail();"><img src="images/message.png" width="28" height="28" border="0" onMouseOver="showFeedBack('email');"></a>
    <a href="javascript:callViaSkipe('eduservice');" title="Вызов по скайпу"><img src="images/Skype-32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('eduservice');"></a>
    <a href="javascript:callViaSkipe('29894257');" title="Вызов по icq"><img src="images/licq_32x32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('29894257');"></a>
    <div class="paddingTop2 paddingBottom6" id="feedbak_container"><strong class="txtRed">Всегда на связи с Вами!</strong></div>
    </td>
  </tr>
</table>
<? if($_REQUEST['section']!="register")
     {?>
<table width="100%" cellspacing="0" cellpadding="10">
  <tr align="center" class="txt120 borderBottom2 borderColorGray bgPanel">
    <td height="55" align="center" nowrap class="paddingLeft10"><h1 class="txt100 padding0"><a href="?mode=skachat-rabotu" style="color: #0000A0"><img src="images/arrows/to_right.gif" alt="<? 
		if ($load_work_name) echo "$load_work_name.";
		else{?>Скачать реферат, курсовую, диплом<? }?>" width="19" height="18" hspace="4" border="0" align="absmiddle">Скачать реферат, курсовую, диплом</a></h1></td>
    <td align="center" class="padding0"><img style="background-color:#999;" src="images/spacer.gif" width="1" height="26"></td>
    <td>&nbsp;</td>
    <td><a href="<?=$go_index?>?article=all">Полезное</a></td>
    <td><a href="<?=$go_index?>?section=agreement">Соглашение об услугах</a></td>
    <!--<td><a href="<?=$go_index?>?section=payment">Способы оплаты</a></td>-->
    <td><a href="<?=$go_index?>?section=faq">FAQ</a></td>
    <td><a href="<?=$go_index?>?section=authors" title="Сотрудничество<?="\n"?>Соглашение<?="\n"?>FAQ<?="\n"?>Регистрация">Авторам<img alt="Банк рефератов для авторов" src="images/i_triangle.png" width="15" height="15" hspace="4" vspace="4" border="0" align="absmiddle"></a> <a href="author/" title="Вход в аккаунт"><img src="images/home.gif" width="14" height="14" hspace="3" vspace="4" border="0" align="absmiddle"></a></td>
  </tr>
</table>
<!--

входящие переменные:

typework
	diploma
    diplomaMBA
    course
    referat
    dissertation
section
	payment
    faq
    useful
    agreement
    sale
    set_distributor_link
    payment
    partnership
sort
	subject
    typework
    predmet
work_id
article
	plagiat
    affair
    bad_teacher
    recruits
    set_distributor_link
find_work
    work_subject
    work_type    
-->
<table width="100%" cellspacing="0" cellpadding="10">
<form method="post" name="form1" class="padding0" action="<?=$go_index?>?mode=skachat-rabotu">
  <tr bgcolor="#E1E1FF">
    <td height="52" bgcolor="#E1E1FF" class="paddingRight0"><? 
	//построим список типов работ:
	$Worx->buildWorxTypesList(' style="background-color:#FFFFCC;" class="widthFull"',false,false); ?></td>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap class="txt100 paddingLeft4">Укажите тему работы:</td>
          <td><img alt="Найти и скачать реферат, курсовую, диплом" src="images/1295963445_search.png" width="16" height="16" hspace="4"></td>
          <td width="100%"><input style="height:24px;" name="work_subject" type="text" class="widthFull" id="work_subject" value="<?=$_REQUEST['work_subject']?>" title="Оставьте поле пустым, если хотите найти работу по указанному в списке типу предмета на любую тему."></td>
          <td><input style="height:26px;" type="submit" name="find_work" id="find" value="  Найти!  "></td>
        </tr>
      </table> </td>
    <td align="center" class="bgF4FF"><a href="<?=$go_index?>?section=register"><strong><img alt="Закачать реферат, курсовую, дипломную работу" src="images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle">Продать готовую работу...</strong></a></td>
  </tr>
</form>  
  <tr>
    <td width="15%" valign="top" class="contentColumn borderTop1 borderColorGray"><?
    
	if (!$page_default) {
		
		?><noindex><? 
	
		if (isset($_SESSION['TEST_MODE'])) {?><h4 class="txtOrange">{&lt;NOINDEX&gt;}</h4><? }
	
	}?><!--  
    
    СМ. СХЕМУ КОМПОНОВКИ БЛОКОВ В Dosc/menu_layout.xls
    
    --><!--
    
    ЛЕВАЯ КОЛОНКА top
    
    --><strong class="txt120"><?
    
	if ( isset($_REQUEST['typework']) ||
	     $_REQUEST['section']!="partnership" ||
		 !isset($_REQUEST['article'])
	   )
	  { $left_column_default=true;
	?><img alt="Банк рефератов" src="images/account_apps.gif" width="32" height="32" hspace="2" align="absmiddle">Как получить:<?
	  }	?></strong>

<?  if ($left_column_default)
	  {?>    

    <ol class="paddingLeft0">
      <li>Выберите работу</li>
      <li>Просмотрите её аннотацию</li>
      <li>Отметьте её для приобретения</li>
      <li>Оплатите</li>
      <li>Сообщите нам об оплате</li>
      <li>Получите готовую работу!</li>
    </ol>

<?	  } ?>    

    <div class="paddingTop10 paddingBottom10"><hr noshade></div>

    <!--
    
    КОНЕЦ ЛЕВОЙ КОЛОНКИ top
    
    --><!--
	
    ЛЕВАЯ КОЛОНКА bottom
	
	--><?    
    
	if ( isset($_REQUEST['typework']) ||
	     $_REQUEST['section']=="partnership" ||
		 $_REQUEST['article']=="set_distributor_link"
	   )
	  {
?><strong><img alt="Банк рефератов" class="paddingRight4" src="images/kopeteavailable.png" width="32" height="32" align="left">Вы &#8212; автор или владелец нескольких работ?<br>
    <a href="<?=$go_index?>?section=sale">Узнайте</a>, почему наше предложение является для вас наиболее:</strong>
    <ul>
      <li>...выгодным с финансовой точки зрения</li>
      <li>...безопасным</li>
      <li>...гибким</li>
      <li>...перспективным</li>
    </ul><?
	
	  }
	
	?><!--
    
    КОНЕЦ ЛЕВОЙ КОЛОНКИ bottom
    
    --><a href="http://lib.2-all.com"><img alt="скачать книги бесплатно" src="images/logo_social_portal.png" width="188" height="152" vspace="20" border="0"></a>    

    <div class="paddingTop10"><? 
			if ($temp_banner||$_SESSION['TEST_MODE']) {?><img src="images/skyscraper_160x600.png" width="160" height="600" border="0"><? }
			else {?><noindex><script type="text/javascript"><!--
google_ad_client = "ca-pub-5247843693787522";
/* Левый небоскрёб */
google_ad_slot = "7683083786";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script></noindex>
<noindex><script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></noindex><? }?>
   	  </div><?
    
	if (!$page_default) {
		
		?></noindex><? 
	
		if (isset($_SESSION['TEST_MODE'])) {?><h4 class="txtOrange">{&lt;/NOINDEX&gt;}</h4><? }
	
	}?></td>
<? ######################################################################################################################

//echo "<hr>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]<hr>";

//получить все доступные к продаже заказы с файлами (учтены в директории заказа, приаттаченные, а также - статус заказа): 
if ($_REQUEST["mode"]=="skachat-rabotu"&&!$req_work_id) { 
	$showcase=true;
	$arrDplomZakazIDsWithFiles=$Worx->getDplomZakazIDsWithFiles();
}

//echo "<hr>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]<hr>";

if ( $_REQUEST['section']=="authors" ||
		 $_REQUEST['section']=="author_agreement" ||
		 $_REQUEST['section']=="faq_authors"
   ) $author_sections=true;	?>

    <td valign="top" class="padding0 paddingBottom10 paddingLeft10 borderTop1 borderColorGray"><?
if ($_REQUEST['section']!="customer"){?>
    <div align="center" class="iborder borderColorGray" style="border-top:none;">
      <table align="center" cellpadding="0" cellspacing="0" class="bgYellowFadeBottom"<? if ($author_sections){?> width="100%"<? }?>>
  <tr>
    <td rowspan="2" align="center" class="padding10">
<? if (!$author_sections) {?>
        <table cellspacing="0" cellpadding="0" class="iborder2 bgWhite" style="border-color:#003399;">
          <tr>
            <td colspan="4" align="left" class="paddingTop10 paddingBottom6 paddingRight10"><table cellspacing="0" cellpadding="0">
              <tr>
                <td><img alt="Банк рефератов" src="images/kopeteavailable.png" width="32" height="32" hspace="4"></td>
                <td><a href="<?=$go_index?>?section=customer" class="arial">Личный кабинет</a></td>
              </tr>
            </table>              </td>
            </tr>
          <tr align="center">
            <td><img src="images/home_24x24.png" width="24" height="24" vspace="4"></td>
            <td><img src="images/basket_middle.png" width="21" height="20"></td>
            <td><img src="images/calculator.gif" width="16" height="16" hspace="4"></td>
            <td><img src="images/all.png" width="20" height="16" hspace="4"></td>
          </tr>
	<? if ($_SESSION['S_USER_TYPE']=="customer") {?>          
          <tr align="center">
            <td colspan="4" align="right" bgcolor="#003399" class="padding6"><a href="<?=$go_index?>?section=customer&amp;mode=exit" class="txtWhite"><strong>выйти...</strong></a></td>
            </tr>
    <? }?>        
        </table>
<? }?>  
      </td>
    <td colspan="2" align="center" class="txt110 bold"><img src="images/piggy_cash_time.png" width="32" height="32" hspace="8" vspace="10" align="absmiddle">Хотите получать
  <? 	if ($author_sections){?>
        <span class="txtRed">дополнительный</span>
  	<? 	} else{?>постоянный<? }?> доход от продажи наших работ?</td>
    </tr>
  <tr>
    <td align="center" valign="bottom" style="padding-bottom:14px;"><!-- Put this script tag to the place, where the Share button will be -->
      <noindex><script type="text/javascript"><!--
document.write(VK.Share.button(false,{type: "round", text: "Сохранить"}));
--></script></noindex></td>
    <td width="100%" align="center" style="padding-bottom:10px;"><span class="txtRed">Для этого не нужно ничего делать! </span><br>
      Просто добавьте ссылку на наш сайт в свою социальную сеть.<?
	  	if ($_REQUEST['article']!="set_distributor_link") {?> <a href="?article=set_distributor_link">Подробнее...</a><? }?></td>
  </tr>
<? //зарезервировано до внедрения механизма учёта дистрибьюторских ссылок:
	/*?>  
  <tr class="borderTop1 borderColorGray bgF4FF">
<?   if (!$author_sections){?>
    <td align="center" class="padding10">&nbsp;</td>
    <td colspan="2" align="center" valign="top" class="padding10">
<?	 if (!isset($_SESSION['TEST_MODE'])){ 
		
		?><iframe src="index.php?social_bookmarks=yes<?
        
		if ($_SESSION['S_USER_TYPE']&&$_SESSION['S_USER_ID']) {?>&amp;user_type=<?=$_SESSION['S_USER_TYPE'];?>&amp;user_id=<? echo $_SESSION['S_USER_ID']; }
		
		?>" class="widthFull" style="height:26px;" frameborder="0"></iframe><?	   
		
	 }else{?>Скрипт добавления в социальные закладки odnaknopka.ru<? }?></td>
<?   }?>    
    </tr>
<?*/ ?>  
</table>
    </div><?
}?><form name="works" method="post" class="padding0"><!--
    
  	ОСНОВНОЙ КОНТЕНТ
    
  --><? 

function setWorksFilterParams($param){ //type,area

	global $Tools;
	//сбросить результаты фильтра (ТОЛЬКО, ЕСЛИ ПЕРЕДАЁТСЯ ИМЯ ПЕРЕМЕННЫХ, НО НЕ ЗНАЧЕНИЕ)
	//тип/предмет работы:
	$request_to_all=(isset($_POST['work_'.$param]))? $_POST['work_'.$param]:$_GET['work_'.$param];
	//если получили входящий параметр на кириллице - конвертировать в латиницу	
	if (preg_match("/[а-яА-Я]/",$request_to_all)) $request_to_all=$Tools->setWorkParamCpuLink($request_to_all,$param); //по умолчанию - ТИП работы
	//если получили запрос
	//если у входящей переменной есть значение, присваиваем его глобальной пер.:
	
	/* #СПЕЦИАЛЬНО ДЛЯ ПОИСКА присвоения значения глоб. переменной!
	
	$_SESSION['S_WORK_TYPE_ALL']=$request_to_all; 	СМ. НИЖЕ!!!
	$_SESSION['S_WORK_AREA_ALL']=$request_to_all; 	СМ. НИЖЕ!!!
	
	*/
	if ($request_to_all) $_SESSION['S_WORK_'.strtoupper($param).'_ALL']=$request_to_all;
	//если значения нет, но есть имя, сбрасываем значение глоб. переменной:
	elseif ( isset($_POST['work_'.$param]) || //передали нулевое значение списка типов работ
			 isset($_POST['work_'.$param.'_all']) ||
			 isset($_GET['work_'.$param.'_all'])
		   ) unset($_SESSION['S_WORK_'.strtoupper($param).'_ALL']);
}

setWorksFilterParams('type');
setWorksFilterParams('area');

if($_REQUEST['work_table']&&!$_REQUEST['work_type']) { 

	$work_id=$req_work_id;
	$work_table=$_REQUEST['work_table']; //echo "<div>work_table= $work_table</div>";
	include("sections/work_data.php");

}elseif (!$_REQUEST['section']&&!$_REQUEST['article']){
	
	//echo "<hr>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]<hr>";
	
	if ($showcase) include("showcase.php");	 
	else {?><div style="padding:20px">
      <h1 class="txt140" style="margin:24px 0px 10px 0px;"><img src="images/juniors_mini.jpg" alt="Заказать диплом, курсовую, реферат" width="90" height="90" hspace="12" align="left" class="iborder2 borderColorOrangePale"><div><img src="images/spacer.gif" width="10" height="10"></div>ДАЁМ  <a href="?mode=skachat-rabotu">СКАЧАТЬ</a>, <a href="/" onClick="location.href='http://www.diplom.com.ru/?menu=order'; return false;">ЗАКАЗАТЬ</a> И <a href="http://www.diplom.com.ru/referee/">ЗАРАБОТАТЬ</a>!</h1>
      Дипломные работы, курсовые, рефераты, дипломы MBA, диссертации, контрольные &#8212; вы можете как покупать их, так и продавать без ограничений по сумме и времени.<a href="?section=authors"> Цену назначаете вы сами</a>. Все права интеллектуальной собственности<a href="?section=authors"> остаются только за вами</a>!</div>
<div class="borderBottom2" align="center" style="border-color:#003399; padding-top:24px;">
<noindex><script type="text/javascript" src="http://www.referats.info/share42/share42.js"></script></noindex>
<noindex><script type="text/javascript">share42('http://www.referats.info/share42/','http://www.referats.info','Скачать диплом, курсовую, реферат, диссертацию, диплом MBA')</script></noindex>
</div>
<br>
<br>
<table width="96%" align="center" cellpadding="10" cellspacing="0">
  <tr valign="top">
    <td class="targerSubjInfo"><table width="100%" cellspacing="0" cellpadding="0" style="background-image:url(images/corners/green.gif);">
      <tr>
        <td><img src="images/spacer.gif" width="13" height="73"></td>
        <td width="100%" align="center" class="padding20 txt140 bold txtWhite"><nobr><img src="images/document_edit_invert.png" width="32" height="32" align="absmiddle"> <a href="<?=$go_index?>?section=authors" class="txtWhite">Для авторов</a></nobr></td>
        <td><img src="images/corners/green_right.gif" width="13" height="73"></td>
      </tr>
    </table>
      <div>
        <ul class="paddingLeft0 paddingTop0" style="margin-top:0;">
          <li>Автоматизированная подготовка аннотаций работ и их &laquo;<strong>мгновенное</strong>&raquo; размещение</li>
          <li><span class="txtRed">100% сохранение</span> прав интеллектуальной собственности</li>
          <li>Все необходимые инструменты для контроля заказов, движения д/с, расчётов и проч.</li>
          <li>Самостоятельное назначение цены</li>
          <li>Увеличение дохода за счёт доработок проданного материала</li>
          <!--<li>Повышение прибыльности за счёт &laquo;социальных&raquo; продаж</li>-->
        </ul>
        
      </div><table width="100%" cellpadding="0" cellspacing="0">
  <tr valign="bottom">
    <td style="padding:10px 0px 0px 34px;"><strong><a href="?section=authors">Подробнее...</a></strong></td>
    <td align="right"><a href="author/">Вход/Регистрация</a></td>
  </tr>
</table></td>
    <td>&nbsp;</td>
    <td class="targerSubjInfo"><table width="100%" cellspacing="0" cellpadding="0" style="background-image:url(images/corners/orange.gif);">
      <tr>
        <td><img src="images/spacer.gif" width="13" height="73"></td>
        <td width="100%" align="center" class="padding20 txt140 bold"><nobr><img src="images/student.png" width="32" height="32" align="absmiddle"> Для студентов</nobr></td>
        <td><img src="images/corners/orange_right.gif" width="13" height="73"></td>
      </tr>
    </table>
      <div>
        Думайте о нашем сайте, как о магазине, в котором вы можете быть и <strong><a href="?mode=skachat-rabotu">покупателем</a></strong>, и <a href="?section=authors">продавцом</a>, и менеджером, и совладельцем!
<ul class="paddingLeft0">
          <li>Возможность выбирать из большого количества уникальных творческих работ &#8212; <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Дипломная работа");?>">дипломов</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Курсовая работа");?>">курсовых</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Реферат");?>">рефератов</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Диссертация");?>">диссертаций</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink("Диплом MBA");?>">дипломов MBA</a></li>
          <li>Возможность выставлять на продажу собственные работы</li>
          <li>Возможность увеличения дохода за счёт &laquo;социальных&raquo; продаж</li>
        </ul>
        </div></td>
  </tr>
  <!--<tr valign="top" class="paddingTop0">
    <td><img style="background-color:#999;" src="images/spacer.gif" width="100%" height="1"></td>
    <td><img src="images/spacer.gif" width="100%" height="1"></td>
    <td><img style="background-color:#999;" src="images/spacer.gif" width="100%" height="1"></td>
    </tr>-->
  <tr valign="top" class="paddingBottom0">
    <td class="targerSubjInfo"><table width="100%" cellspacing="0" cellpadding="0" style="background-image:url(images/corners/blue.gif);">
      <tr>
        <td><img src="images/spacer.gif" width="13" height="73"></td>
        <td width="100%" align="center" class="padding20 txt140 bold txtWhite"><nobr><img src="images/document_search_invert.png" width="32" height="32" align="absmiddle"> Для покупателей</nobr></td>
        <td><img src="images/corners/blue_right.gif" width="13" height="73"></td>
        </tr>
      </table>
      <div>
        <ul class="paddingLeft0 paddingTop0" style="margin-top:0;">
          <li>Широкий выбор готовых <a href="?mode=skachat-rabotu&amp;work_type=<? 
		  echo $Tools->setWorkParamCpuLink("Дипломная работа");?>">дипломных работ</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		  echo $Tools->setWorkParamCpuLink("Курсовая работа");?>">курсовых</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		  echo $Tools->setWorkParamCpuLink("Реферат");?>">рефератов</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		  echo $Tools->setWorkParamCpuLink("Диплом MBA");?>">дипломов MBA</a>, <a href="?mode=skachat-rabotu&amp;work_type=<? 
		  echo $Tools->setWorkParamCpuLink("Диссертация");?>">диссертаций</a></li>
          <li>Возможность   скачать бесплатно аннотацию (до 30% от полного объёма текста) любой работы</li>
          <li>Оплата заказа множеством способов</li>
          <li>Оперативная обратная связь и бесплатные консультации</li>
          <li>Связь с авторами работ</li>
        </ul>
        </div></td>
    <td>&nbsp;</td>
    <td class="targerSubjInfo"><table width="100%" cellspacing="0" cellpadding="0" style="background-image:url(images/corners/red.gif);">
      <tr>
        <td><img src="images/spacer.gif" width="13" height="73"></td>
        <td width="100%" align="center" class="padding20 txt140 bold txtWhite"><nobr><img src="images/order_code.png" width="32" height="32" align="absmiddle"> Для продавцов</nobr></td>
        <td><img src="images/corners/red_right.gif" width="13" height="73"></td>
        </tr>
      </table>
      <div>
        <ul class="paddingLeft0 paddingTop0" style="margin-top:0;">
          <li>Ускоренное размещение товара</li>
          <li>Полная защищённость  доступа к материалу </li>
          <li>Предоставление всей статистики деятельности</li>
          <li>Отсутствие ограничений на количество продаваемых работ </li>
          <li>Бесплатная реализация пожеланий по внедрению дополнительных инструментов управления</li>
          <li>Быстрая оплата реализованного товара</li>
        </ul>
      </div></td>
  </tr>
  <!--<tr valign="top" class="paddingTop0">
    <td><img style="background-color:#999;" src="images/spacer.gif" width="100%" height="1"></td>
    <td><img src="images/spacer.gif" width="100%" height="1"></td>
    <td><img style="background-color:#999;" src="images/spacer.gif" width="100%" height="1"></td>
    </tr>-->
</table>
<hr size="1" color="#003399" style="margin-top:10px;">
<br>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" valign="top" class="paddingTop10"><img src="images/champagne.jpg" width="106" height="91" hspace="10" border="1" style="border-color:#F9C""></td>
    <td height="40" class="padding10"><h1 class="txt110 padding0"><a href="#" onClick="location.href='http://www.educationservice.ru'; return false;">Дипломы, диссертации, курсовые работы, дипломы MBA, рефераты &#8212; все виды творческих работ на заказ.</a></h1></td>
  </tr>
  <tr>
    <td class="paddingLeft10 txt110" valign="top"><strong><span class="txtGreen"><script type="text/javascript">
dwrite('Education');
</script></span><span class="txtRed"><script type="text/javascript">
dwrite('Service');
</script></span></strong>.ru &#8212; 8 лет безупречного удовлетворения заказчика :)     </td>
    </tr>
  <tr>
    <td height="60" colspan="2" valign="top" class="padding10 borderBottom2" style="font-size:190%; background-image:url(images/corazons.png); background-position:left; background-repeat:no-repeat; border-color:#F9C">Вы полюбите наш сервис!</td>
    </tr>
</table>      
<? }
	
}
		//если статьи:
		if (isset($_REQUEST['article'])) include("articles/index.php");
		if (isset($_REQUEST['section'])) include("sections/index_sections.php");
	
?></form>
<!--

  	КОНЕЦ ОСНОВНОГО КОНТЕНТА

-->

<div class="txt120 padding20">Хотите всегда быть в курсе хорошего? Используйте кнопки:</div>
<noindex><script type="text/javascript" src="http://www.referats.info/share42/share42.js"></script></noindex>
<noindex><script type="text/javascript">share42('http://www.referats.info/share42/','http://www.referats.info','Скачать диплом, курсовую, реферат, диссертацию, диплом MBA')</script></noindex>
<hr>
<div class="padding10 txt110">
<h3 style="display:inline">Хотите задать вопрос/поделиться мнением?</h3><br>
Сообщите его нам:</div><a name="message_start"></a>
<br>
<form name="form_add_comment" method="post" style="text-align:left;margin-bottom:0px;" class="paddingBottom0">
  <? 	//ЗАавторизован заказчик и раздел заказов:
	if ( $_SESSION['S_USER_TYPE']=="customer" &&
		 $_REQUEST['section']=="customer" &&
 		(!$_REQUEST['mode']||$_REQUEST['mode']=="orders"||$_REQUEST['mode']=="messages")
	  ){?><!-- принудительно устанавливаемая тема сообщения (блокирует тему по умолчанию) --><input type="hidden" name="set_subject" id="set_subject" />
<!-- передаём id заказа --><input type="hidden" name="ri_basket_id" id="ri_basket_id" /><? 
	}?>Укажите свой емэйл, если хотите получить персональный ответ: <input name="email" type="text" size="40" value="<?
	
	echo ($_SESSION['S_LAST_EMAIL'])? $_SESSION['S_LAST_EMAIL']:$_SESSION['S_USER_EMAIL'];
	unset($_SESSION['S_LAST_EMAIL']);
	
	?>" class="iborder" style="border-color:#374890;"><div class="paddingTop4 paddingBottom4">Как вас зовут? <input name="name" type="text" size="40" value="<?
	
	echo ($_SESSION['S_LAST_NAME'])? $_SESSION['S_LAST_NAME']:$_SESSION['S_USER_NAME'];
	unset($_SESSION['S_LAST_NAME']);
	
	?>" class="iborder" style="border-color:#374890;"></div>
    <input name="ret" type="hidden" value="<?=$_SERVER['REQUEST_URI']?>"> 
    <textarea name="comment" id="comment" rows="10" class="widthFull iborder2 padding6" style="border-color: #C69A88;"><?
    
		echo $_SESSION['S_LAST_COMMENT']; 
		unset($_SESSION['S_LAST_COMMENT']);
	
	?></textarea>
    <nofollow>
    	<noindex>
    <table width="100%" cellspacing="0" cellpadding="4">
          <tr class="paddingTop10">
            <td nowrap style="padding-right:0; margin-right:0;">Контрольный код: &nbsp;&nbsp;<img src="capche.php?dt=<?=microtime()?>" hspace="0" align="absmiddle"></td>
            <td nowrap style="padding-left:0; margin-left:0;"><input name="capche" id="capche" type="text" size="6" style="border:solid 1px #374890; background-color:#FFC;"></td>
            <td width="100%"><input type="submit" value="Отправить!" onClick="if(!document.getElementById('capche').value) {alert('Вы не ввели контрольный код!');return false;}"><input name="add_comment_type" type="hidden" value="<?
	$add_comment_type=$_SERVER['REQUEST_URI'];
	if (isset($_REQUEST['section'])) $add_comment_type="section=".$_REQUEST['section'];
	if (isset($req_work_id)) $add_comment_type="work_id=".$req_work_id;
	if (isset($_REQUEST['article'])) $add_comment_type="article=".$_REQUEST['article'];
	if ($work_subject) $add_comment_type="find_work=".$work_subject;
	echo $add_comment_type;	
	?>"></td>
          </tr>
        </table>
        </noindex>
    </nofollow></form>


    <br></td>
    <td width="23%" valign="top" class="contentColumn borderTop1 borderColorGray paddingLeft20"><!--
    
    ПРАВАЯ КОЛОНКА top
    
    --><strong class="txt120"><?
    
	
	?><img src="images/account_faq.gif" width="32" height="32" align="absmiddle">Спроси эксперта:<?
    
	
	?></strong><?
	  
	  $avoid_plagio="Как избежать плагиата";
	  $avoid_troubles="Как не стать жертовой обмана";
	  $bad_teacher="Если препод к вам неровно дышит...";
	  $get_money="Как сделать свою творческую работу источником постоянного дохода";
	  $get_more_money="Как сделать ЧУЖИЕ творческие работы источником СВОЕГО дохода";
	  ?><!--<ul>
      <li><? if ($test_article){?>Как избежать плагиата<? }?><a href="#<? echo "avoid_plagio";?>"><?=$avoid_plagio?></a></li>
      <li><? if ($test_article){?>Как не стать жертовой обмана<? } ?><a href="#<? echo "avoid_troubles";?>"><?=$avoid_troubles?></a></li>
      <li><? if ($test_article){?>Если препод к вам неровно дышит...<? }?><a href="#<? echo "bad_teacher";?>"><?=$bad_teacher?></a></li>
      <li><? if ($test_article){?>Как сделать свою творческую работу источником постоянного дохода<? } ?><a href="#<? echo "get_money";?>"><?=$get_money?></a></li>
      <li><? if ($test_article){?>Как сделать ЧУЖИЕ творческие работы источником СВОЕГО дохода<? } ?><a href="#<? echo "get_more_money";?>"><?=$get_more_money?></a></li>
      </ul>-->

      <div class="paddingTop10 paddingBottom10"><hr noshade></div>

      	<!--Как избежать плагиата-->
        <strong><a name="avoid_plagio"></a><img src="images/question.gif" width="16" height="16" hspace="4" align="absmiddle"><A href="<?=$go_index?>?article=plagiat" class="txtDarkBlue"><?=$avoid_plagio?></A></strong>      
<div class="article">Прежде
                всего, необходимо определить разницу между плагиатом и «использованием
                материалов»<BR>
        <A href="<?=$go_index?>?article=plagiat">плагиат это...</A></div>

        <!--Как не стать жертовой обмана-->
    	<strong><a name="avoid_troubles"></a><img src="images/question.gif" width="16" height="16" hspace="4" align="absmiddle"><A href="<?=$go_index?>?article=affair" class="txtDarkBlue"><?=$avoid_troubles?></A></strong>
      <div class="article">За
                то время, пока мы занимаемся этим бизнесом, мы пришли к ряду
                не очень радостных выводов по поводу его состояния. Сайтов, оказывающих
                услуги профессионально — ничтожный процент, что же касается независимых
                исполнителей, то тут, вообще, творится невообразимое...<BR>
      	<A href="<?=$go_index?>?article=affair">принимаем меры...</A></div>

    	<!--Если препод к вам неровно дышит...-->
    	<strong><a name="bad_teacher"></a><img src="images/question.gif" width="16" height="16" hspace="4" align="absmiddle"><A href="<?=$go_index?>?article=bad_teacher" class="txtDarkBlue"><?=$bad_teacher?></A></strong>
      <div class="article">Наверное, самое неприятное, что может случиться со студентом...<BR>
      <A href="<?=$go_index?>?article=bad_teacher">ищем выход из ситуации...</A></div>
      
    	<!--Как сделать свою творческую работу источником постоянного дохода-->
        <strong><a name="get_money"></a><img src="images/question.gif" width="16" height="16" hspace="4" align="absmiddle"><A href="<?=$go_index?>?article=recruits" class="txtDarkBlue"><?=$get_money?></A></strong>
      <div class="article"> А
                вам приходила в голову мысль не просто защитить дипломную или
                курсовую работу, и &laquo;забыть навсегда&raquo;, но и получить
                за неё деньги?<BR>
      <A href="<?=$go_index?>?article=recruits">зарабатываем &laquo;своим умом&raquo;&nbsp;...</A></div>
    	
        <!--Как сделать ЧУЖИЕ творческие работы источником СВОЕГО дохода-->
        <strong><a name="get_more_money"></a><img src="images/question.gif" width="16" height="16" hspace="4" align="absmiddle"><A href="<?=$go_index?>?article=set_distributor_link" class="txtDarkBlue"><?=$get_more_money?></A></strong>
      <div class="article">А
                вам приходила в голову другая мысль? Что деньги можно зарабатывать ещё более простым способом?<BR>
                      <A href="<?=$go_index?>?article=set_distributor_link">зарабатываем &laquo;своим умом&raquo; ещё больше!...</A></div>

      <div class="padding4">Все статьи <a href="<?=$go_index?>?article=all"><strong>здесь</strong></a>.</div>

<hr noshade>     

      <div class="paddingTop10"><?
	  if ($test_banner_right||$_SESSION['TEST_MODE']){
		  ?><img class="cellPassive" src="images/spacer.gif" width="200" height="200" border="0"><? 
	  }else{
		  
		  ?><noindex><script type="text/javascript"><!--
google_ad_client = "ca-pub-5247843693787522";
/* Правый квадрат */
google_ad_slot = "0518295189";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script></noindex>
<noindex><script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></noindex><?	
	  }?></div>
   
   <br>
<!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=8798899&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/8798899/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onClick="try{Ya.Metrika.informer({i:this,id:8798899,type:0,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter8798899 = new Ya.Metrika({id:8798899, enableAll: true, webvisor:true});
        }
        catch(e) { }
    });
})(window, "yandex_metrika_callbacks");
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer></script>
<noscript><div><img src="//mc.yandex.ru/watch/8798899" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --><!-- 
            
    КОНЕЦ ПРАВОЙ КОЛОНКИ top
      
    --></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="borderBottom4 borderColorGray"><? 
	
	if ($temp_banner||$_SESSION['TEST_MODE']) {?>
      <img src="images/horizontal_728x90.png" width="728" height="90" border="0">
 <? }else {
	 
	 ?><noindex><script type="text/javascript"><!--
google_ad_client = "ca-pub-5247843693787522";
/* Нижний длинный */
google_ad_slot = "4786019313";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script></noindex>
<noindex><script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></noindex><?
	
	}?></td>
  </tr>
  <tr bgcolor="#E1E1FF">
    <td height="50" colspan="2" valign="top" bgcolor="#E1E1FF" class="txt100" id="flat"><a href="index.php">&#8226; Главная</a> &nbsp;<a href="<?=$go_index?>?section=payment">&#8226; Способы оплаты</a> &nbsp;<a href="<?=$go_index?>?section=faq">&#8226; FAQ</a> &nbsp;<a href="<?=$go_index?>?section=useful">&#8226; Полезное</a> &nbsp;<a href="<?=$go_index?>?section=agreement">&#8226; Пользовательское соглашение</a> &nbsp;<a href="<?=$go_index?>?section=partnership">&#8226; Сотрудничество</a></td>
    <td valign="top" class="paddingTop14">&copy;<noindex><a href="http://www.eduservice.biz"><script type="text/javascript">
dwrite('EducationService');
</script></a></noindex> 2003-<? echo date("Y");?></td>
  </tr>
</table>
<? 
  }
else include("sections/register.php");
		//вывод переменных в тестовом режиме:
		$catchErrors->showGetPostDataForeach($mType);
?></body>
</html>