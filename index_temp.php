<? 

 //error_reporting(E_ALL); 
 error_reporting(E_ERROR); 
 error_reporting(E_PARSE); 
 error_reporting(E_CORE_ERROR); 
 error_reporting(E_STRICT); 
 error_reporting(E_DEPRECATED); 
 ini_set('display_errors', '1'); 
 ini_set('display_startup_errors', '1'); 
 
 session_start();
 
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
		
		$sociolink='<a href="index.php?article=set_distributor_link" onMouseOver="this.style.textDecoration=\'none\';" target="_parent">';
		
		if (!$_SESSION['S_USER_TYPE']||!$_SESSION['S_USER_ID']){ 
			
			echo $sociolink;?><img border="0" src="images/odnaknopka.png" width="256" height="16"><?
		
		}else{?><script src="http://odnaknopka.ru/ok3.js" type="text/javascript"></script><?
		}?>&nbsp;&nbsp;<?=$sociolink?>подробнее...</a></div><?
		
echo '</body>
</html>';
		die();
	}
	
require_once('connect_db.php');
//
require_once('classes/class.Actions.php');
$Actions=new Actions;
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
$Money=new Money;
require_once ("classes/class.regUser.php");
$regUser=new regUser;
require_once ("classes/class.Tools.php");
$Tools=new Tools;
require_once ("classes/class.Worx.php");
$Worx=new Worx;

if ($_REQUEST['mode']=="exit") { echo "<h1>exit</h1>";
	session_unset();
	$Messages->alertReload("","index.php");
}
	
//если добавляли комментарий к разделу:
if (isset($_REQUEST['comment'])) { 

	$msbj="Комментарий к разделу $_REQUEST[add_comment_type].";
	$mtxt=$_REQUEST['comment']."<hr>Отправитель: $_REQUEST[name].";

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
}
//юзер заавторизован: 
	//добавляем заказ в корзину
//...не заавторизован: 
	//сохраняем массив REQUEST в глобальной переменной, чтобы извлечь данные для добавления заказа после авторизации/регистрации юзера
function addWorksToBasket($action) { 
	
		//$test_function=true;
		if ($test_function)	{
			//echo "<h5 class='txtGreen'>addWorksToBasket(\$action=$action) just STARTED</h5>";
			echo "<h5 class='txtGreen'>\$action=$action -> just STARTED!</h5>";
			echo "<div class='txtOrange'>(начало) \$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
		}
	
	global $catchErrors;
	global $Messages;
	
	//сохраняли данные формы в глобальной пер.:
	if($action=="save") {
					
		$_SESSION['saved_orders']=$_REQUEST;
		//отладка:
		//$test_loop=true; 
		if ($test_loop) {
			echo "<div><div style='color:red'>Сохранили массив \$_REQUEST в глобальной переменной:</div>";
			foreach ($_SESSION['saved_orders'] as $key=>$val)
				echo "<div style='color:green'>[$key]=>$val</div>";
			//var_dump($_SESSION['saved_orders']);
			echo "</div>";
		}

	}else{	//добавляли заказ:

		//выясним, существуют ли условия выполнения функции
		//для пакетного режима:
		if (!$_REQUEST['buy_work']&&!$_REQUEST['order_work']) {
			foreach ($_REQUEST as $key=>$val)
				if (strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_")) {
					$keys_exist=true; 
					break;
				}
		} //echo "<div>keys_exist= $keys_exist</div>";
		//если покупаем/добавляем/сохраняем единственную работу или - в пакетном режиме:
		if ($_REQUEST['buy_work']||$_REQUEST['order_work']||$keys_exist) {

			$bsk=0;//для проверки откладываемых в корзину заказов и, соответственно - отображения или сокрытия следующего блока.
			//проверяем, не помещали ли в корзину?
			$add_basket=0; //счётчик добавлений заказов в корзину
			$cancel_basket=0; //счётчик отмены добавлений заказов в корзину
			//передаём массиву данные для извлечения из массива REQUEST (текущего или ранее сохранённого).
			//$_SESSION['saved_orders'] - ранее сохранённый запрос REQUEST (ДО аутентификации заказчика)
			$arrToUse=(!$_SESSION['saved_orders'])? $_REQUEST:$_SESSION['saved_orders'];
			
				//$test_arrToUse=true;
				if ($test_arrToUse) {
					echo "<div class='txtOrange'>addWorksToBasket(\$action=$action) works!<br>\$arrToUse= "; 
					echo(!$_SESSION['saved_orders'])? "\$_REQUEST":"\$_SESSION['saved_orders']"; 
					echo "</div>";
				}

				//$test_loop=true;
				if ($test_loop) {
	
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
			if (is_array($arrToUse)&&count($arrToUse)) { //echo "<h5>Inside of \$arrToUse...</h5>";

				$arrOrderData=array();
				$count_work_table=0;
				$count_work_id=0;
				foreach ($arrToUse as $key=>$val){ //echo "<h5>Inside of foreach(\$arrToUse)...</h5>$key=>$val";
					
					//таблица, id работы:
					if ( strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_") //пакетное действие
						 //одиночный заказ
						 || $key=="work_table" /*|| $key=="work_id" */|| $key=="buy_work" || $key=="order_work"
					   ) {
						
						if ((strstr($key,"order_diplom_zakaz_") || strstr($key,"order_ri_worx_")))
							{ //echo "<div><b>[$key]</b>=> $val</div>";
						
							$arrOrderData[$count_work_table]['table']=(strstr($key,"order_diplom_zakaz_"))? "diplom_zakaz":"ri_worx";
							$count_work_table++;
							$arrOrderData[$count_work_id]['work_id']=$val;
							$count_work_id++;
						
						}else{ //echo "<div><b><em>[$key]</em></b>=> $val</div>";
							
							//ВНИМАНИЕ! Необходимо исключить создание дублирующих элементов массива, возникающих из-за выполнения условия:
							if ($key=="work_table"/*&&!$arrOrderData[$count_work_table-1]['table']*/) {
								$arrOrderData[$count_work_table]['table']=$val;
								$count_work_table++;
							}
							if (($key=="buy_work"||$key=="order_work")&&$val) {
								$arrOrderData[$count_work_id]['work_id']=$val;
								$count_work_id++;
							}
						}
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
						$rSel=mysql_query($qSel);
						$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
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
	
				if ($test_loop) {
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
				if (isset($_REQUEST['buy_work'])) $pageReload.="&add_payment=".$_REQUEST['buy_work'];
				$Messages->alertReload($added.$cancel,$pageReload); 
			}
		}
	}
}	//КОНЕЦ МЕТОДА addWorksToBasket()

		//вывод переменных в тестовом режиме:
		$catchErrors->showGetPostDataForeach($mType);
		if (isset($_SESSION['TEST_MODE'])) {?><script language="JavaScript" type="text/JavaScript" src="js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="email_check.js"></script><? }

//регистрировали или аутентифицировали субъекта:
if (isset($_REQUEST['user_login'])) {

	//Передавали значение поля логина юзера, но не получили (ещё или вообще) подтверждения предложения аутентификации
	if (!isset($_REQUEST['apply_register'])) {
		
		 //проверить указанный емэйл (он же - логин):
	
		//основная подстрока запроса:
		//проверить, не зарегистрирован ли уже:
		$qSel="SELECT number,name,email FROM ri_customer
  WHERE ( email = '$_REQUEST[user_login]' 
	 OR email2 = '$_REQUEST[user_login]'
   )"; 	
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		//если не щарегистрирован:
		if (!mysql_num_rows($rSel)) {//юзер НЕ обнаружен
			
			//если нет такого юзера, но (возможно) он пытался добавить в корзину заказы:
			addWorksToBasket("save");//сохранить массив REQUEST  в сессионной переменной ДО регистрации юзера...
			
			//die("<a href='?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes'>?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes</a>");
			
			//1. перегрузнть страницу
			//2. указать емэйл юзера в качестве логина (снова загрузит данный внешний блок
			//3. передать метку подтверждения процедуры аутентификации, что выполненит следующий (параллельный) блок 
			$alert_mess="Емэйл $_REQUEST[user_login] в нашей БД не обнаружен!\\nЖелаете зарегистрироваться с этим емэйлом?";
			$go_page="?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes";
			if (isset($_REQUEST['buy_work'])) $go_page.="&buy_work=$_REQUEST[buy_work]";
			if (isset($_REQUEST['order_work'])) $go_page.="&order_work=$_REQUEST[order_work]";
			if (isset($_SESSION['TEST_MODE'])){
        
				echo "<div><hr><b>alert:</b> $alert_mess<hr>location.href= <a href='$go_page'>$go_page</a></div>";
		    
			}else{?>
<script type="text/javascript">
if (confirm('<?=$alert_mess?>')) {
	var goPage="<?=$go_page?>";
	//window.open(goPage,'appl');
	location.href=goPage;
}
</script>
	<?		}
			die();	
		
		}else{ //юзер обнаружен:
			
			//проверим, тот ли пароль:
			$qSel.="
   AND password = '$_REQUEST[password]'";
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			//пароль не тот:
			if (!mysql_num_rows($rSel)) {
				
				$Messages->alertReload("Пароль указан неверно!","?section=customer");
				die();
	
			}else{ //пароль правильный
	
				$_SESSION['S_USER_TYPE']="customer";
				$_SESSION['S_USER_ID']=mysql_result($rSel,0,'number');
				//получить глобальные переменные:
				$Customer->getCustomerData($_SESSION['S_USER_ID'],true);
	
			}
		}
	
	//передавали метку регистрации нового юзера (уже после подтверждения регистрации с неизвестным емэйлом):
	}else{		//echo "<div>\$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
		
		//если нет такого юзера, но (возможно) он пытался добавить в корзину заказы:
		$regUser->regCustomer($_REQUEST['user_login']);
		
	}	
}
//добавить заказы в корзину (если id id работ содержатся в массиве $_REQUEST):
if ($_SESSION['S_USER_TYPE']=="customer") addWorksToBasket("insert");?>
  
<html>
<head>
<title>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</title>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="email_check.js"></script>
<script type="text/javascript">
function searchWork(work_type) {
	document.getElementById('work_type').value=work_type;
	document.forms['form1'].action="index.php";
	document.forms['form1'].submit();
}
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

dg="@";
realm=".";
realm+="info";
var mContent="sale"+dg+"referats"+realm;
function showFeedBack(fcontent) {
	var tBlock=document.getElementById('feedbak_container');
	if (fcontent=="email") fcontent=mContent;
tBlock.innerHTML=fcontent;
}
function sendEmail() {
	location.href="mailto: "+mContent;
}
function callViaSkipe(dSkipe) {
	location.href="skype:"+dSkipe;
}
//добавить запись в поле:
function addOrderNote(mtype,order_id) {
var set_subject;
	switch(mtype) {
		case "order":
		set_subject="Сообщение по заказу id "+order_id;
		document.getElementById('ri_basket_id').value=order_id;
		break;
		
		default: set_subject="Новое сообщение администрации Referats.info.";
	}
document.getElementById('comment').value=set_subject+':\n----------------------------------------\n';
document.getElementById('set_subject').value=set_subject;
}
</script>
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24990263-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body<? if($_REQUEST['section']=="register") echo ' bgcolor="#E1E1FF"';?> onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');"><?

//echo "\$_SESSION['S_USER_TYPE']=".$_SESSION['S_USER_TYPE'];?>
<table width="100%" cellspacing="0" cellpadding="0" style="display:none;">
  <tr class="borderBottom4 borderColorGray">
    <td width="25%" height="82" align="center" nowrap bgcolor="#003399" class="padding10"><a href="index.php" class="txtWhite header"><img src="images/logo_docs.png" alt="Рефераты, курсовые, дипломные работы скачать. Готовые работы, дипломы на заказ рефераты" width="61" height="32" hspace="4" border="0" align="absmiddle">Referats.<span style="color:#ffcc00;">info</span></a></td>
    <td width="52%" align="center" bgcolor="#FFCC00" class="padding10">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border:none;" class="txt100"><strong>Уникальные готовые творческие работы:</strong></td>
      </tr>
      <tr>
        <td style="border:none;">
        <h1 class="padding0 noBold txt110 Cambria"><a href="#" onClick="searchWork('Дипломная работа');return false;">Дипломные работы</a>, <a href="#" onClick="searchWork('Диплом MBA');return false;">дипломы MBA</a>, <a href="#" onClick="searchWork('Курсовая');return false;">курсовые работы</a>, <a href="#" onClick="searchWork('Реферат');return false;">рефераты</a> и <a href="#" onClick="searchWork('Диссертация');return false;">диссертации</a>!</h1></td>
      </tr>
    </table>      </td>
    <td width="23%" align="center" bgcolor="#E1E1FF" id="tdConnect">
    <a href="javascript:callViaSkipe('+79044428447');" title="Звонок на мобильный телефон по скайпу"><img src="images/phone_sound.png" width="32" height="32" border="0" onMouseOver="showFeedBack('+7 904 442 84 47');"></a>
    <a href="javascript:sendEmail();"><img src="images/message.png" width="28" height="28" border="0" onMouseOver="showFeedBack('email');"></a>
    <a href="javascript:callViaSkipe('eduservice');" title="Вызов по скайпу"><img src="images/Skype-32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('eduservice');"></a>
    <a href="javascript:callViaSkipe('29894257');" title="Вызов по icq"><img src="images/licq_32x32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('29894257');"></a>
    <div class="paddingTop2" id="feedbak_container"><strong class="txtRed">Всегда на связи с Вами!</strong></div>
    </td>
  </tr>
</table>
<? if($_REQUEST['section']!="register")
     {?>
<table width="100%" cellspacing="0" cellpadding="10">
  <tr align="center" class="txt120 borderBottom2 borderColorGray bgPanel">
    <td height="55"><a href="bank-referatov.php">Выбрать работу</a></td>
    <td><a href="index_temp.php?section=payment">Способы оплаты</a></td>
    <td><a href="index_temp.php?section=faq">FAQ</a></td>
    <td><a href="index_temp.php?article=all">Полезное</a></td>
    <td><a href="index_temp.php?section=agreement">Соглашение об услугах</a></td>
    <td><a href="index_temp.php?section=authors" title="Сотрудничество<?="\n"?>Соглашение<?="\n"?>FAQ<?="\n"?>Регистрация">Авторам<img src="images/i_triangle.png" width="15" height="15" hspace="4" vspace="4" border="0" align="absmiddle"></a> <a href="author/" title="Вход в аккаунт"><img src="images/home.gif" width="14" height="14" hspace="3" vspace="4" border="0" align="absmiddle"></a></td>
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
<form method="post" name="form1" class="padding0">
  <tr bgcolor="#E1E1FF">
    <td height="52" bgcolor="#E1E1FF" class="paddingRight0"><? 
	//построим список типов работ:
	$Worx->buildWorxTypesList(' style="background-color:#FFFFCC;" class="widthFull"',false,false); ?></td>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap class="txt100 paddingLeft4">Укажите тему работы:</td>
          <td><img src="images/1295963445_search.png" width="16" height="16" hspace="4"></td>
          <td width="100%"><input style="height:24px;" name="work_subject" type="text" class="widthFull" id="work_subject" value="<?=$_REQUEST['work_subject']?>" title="Оставьте поле пустым, если хотите найти работу по указанному в списке типу предмета на любую тему."></td>
          <td><input style="height:26px;" type="submit" name="find_work" id="find" value="  Найти!  "></td>
        </tr>
      </table> </td>
    <td align="center" class="bgF4FF"><a href="index_temp.php?section=register"><strong><img src="images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle">Продать готовую работу...</strong></a></td>
  </tr>
</form>  
  <tr>
    <td width="15%" valign="top" class="contentColumn borderTop1 borderColorGray"><?
	
	if (!$_REQUEST['work_id']) {
		//
		$arrDplomZakazIDsWithFiles=$Worx->getDplomZakazIDsWithFiles();
		echo "<div>=".count($arrDplomZakazIDsWithFiles)."=</div>";
			
			?>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">Найти все работы с файлами:</div>
			<div style="display:<?="none"?>;"><? 
		if ( $_REQUEST['section']=="authors" ||
				 $_REQUEST['section']=="author_agreement" ||
				 $_REQUEST['section']=="faq_authors"
		   ) $author_sections=true;	?></div>
		   <hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">ВСЕГО РАБОТ: <?
			
			$right_stat="SELECT number FROM diplom_zakaz
		   WHERE ( status_cycle = 'closed' OR 
				 status_cycle = 'made' OR
				 status_cycle = 'remade' OR
				 status_cycle = 'processed' )
		   AND number IN (";
			
			$wAll=$Worx->arrWorksFilesAll;
			echo count($wAll);?>
	  <?  $wAll2=array_unique($wAll);
			echo " : ".count($wAll2);?></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wAll2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">Допущено к продаже: <?
			
			$qSel=$right_stat.implode(",",$wAll2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) { 
				echo $arr['number'].", ";
				$arrToSale[]=$arr['number'];
			 }
			?></div>
			
			<hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">С файлами в дир. zip: <?
			$wZip=$Worx->arrWorksFilesZip;
			if (is_array($wZip)) {
				echo count($wZip);
				$wZip2=array_unique($wZip);
				echo " : ".count($wZip2);
			}else echo " 0";?></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wZip2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">Допущено к продаже: <?
			
			$qSel=$right_stat.implode(",",$wZip2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div>
			
			<hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';"><nobr>С приаттаченными файлами: <?
			$wMail=$Worx->arrWorksFilesMail;
			echo count($wMail);
			$wMail2=array_unique($wMail);
			echo " : ".count($wMail2);
			?></nobr></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wMail2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">Допущено к продаже: <?
			
			$qSel=$right_stat.implode(",",$wMail2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div>
			
	  <hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">C архивами: <?
			
			$qSel=$right_stat.implode(",",$wMail2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
	<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div><?
	}else {?><h4><a href="index_temp.php">На главную тестовую</a></h4><? }?></td>

    <td valign="top" class="padding0 paddingBottom10 paddingLeft10 borderTop1 borderColorGray"><?
if ($_REQUEST['section']!="customer"){?>
    <div align="center" class="iborder borderColorGray" style="border-top:none;">
      <table align="center" cellpadding="0" cellspacing="0" class="bgYellowFadeTop"<? if ($author_sections){?> width="100%"<? }?>>
  <tr>
<? if (!$author_sections) {?>
    <td align="center" class="padding10">
        <table cellspacing="0" cellpadding="0" class="iborder2 bgWhite" style="border-color:#003399;">
          <tr>
            <td colspan="4" align="left" class="paddingTop10 paddingBottom6 paddingRight10"><table cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="images/kopeteavailable.png" width="32" height="32" hspace="4"></td>
                <td><a href="index_temp.php?section=customer" class="arial">Личный кабинет</a></td>
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
            <td colspan="4" align="right" bgcolor="#003399" class="padding6"><a href="index_temp.php?section=customer&mode=exit" class="txtWhite"><strong>выйти...</strong></a></td>
            </tr>
    <? }?>        
        </table>
      </td>
<? }?>  
    <td width="100%" align="center" valign="top">
      <div class="padding10 txt120 bold" style="height:60px; padding-top:14px;"> <img src="images/piggy_cash_time.png" width="32" height="32" hspace="8" align="absmiddle">Хотите получать
<? if ($author_sections){?>
        <span class="txtRed">дополнительный</span>
        <? } else{?>постоянный<? }?> доход от продажи наших работ?</div>
        <div class="padding10"><span class="txtRed">Для этого не нужно ничего делать! </span><br>
Просто добавьте ссылку на наш сайт в свою социальную сеть: </div>
	</td>
  </tr>
  <tr class="borderTop1 borderColorGray bgF4FF">
<?   if (!$author_sections){?>
    <td align="center" class="padding10">&nbsp;</td>
<?   }?>    
    <td align="center" valign="top" class="padding10">
<?	 if (!isset($_SESSION['TEST_MODE'])){ 
		
		?><iframe src="index.php?social_bookmarks=yes<?
        
		if ($_SESSION['S_USER_TYPE']&&$_SESSION['S_USER_ID']) {?>&user_type=<?=$_SESSION['S_USER_TYPE'];?>&user_id=<? echo $_SESSION['S_USER_ID']; }
		
		?>" class="widthFull" style="height:26px;" frameborder="0"></iframe><?	   
		
	 }else{?>Скрипт добавления в социальные закладки odnaknopka.ru<? }?></td>
  </tr>
      </table>
    </div><?
}?><form name="works" method="post" class="padding0"><!--
    
  	ОСНОВНОЙ КОНТЕНТ
    
  --><? 
//сбросить результаты фильтра (ТОЛЬКО, ЕСЛИ ПЕРЕДАЁТСЯ ИМЯ ПЕРЕМЕННЫХ, НО НЕ ЗНАЧЕНИЕ)
//тип работы:
$request_work_type_all=($_POST['work_type'])? $_POST['work_type']:$_GET['work_type'];
//предмет:
$request_work_area_all=($_POST['work_area'])? $_POST['work_area']:$_GET['work_area'];

	//echo "<div class='txtGreen'>
		//	Проверка сброса результатов фильтра:
		  //<div>request_work_type_all=".$request_work_type_all."</div>";
	//echo "<div>request_work_area_all=".$request_work_area_all."</div>";

//S_WORK_TYPE_ALL - сохраняемое значение активного типа работы
//S_WORK_AREA_ALL - сохраняемое значение активного предмета

//если получили запрос
//если у входящей переменной есть значение, присваиваем его глобальной пер.:
if ($request_work_type_all) $_SESSION['S_WORK_TYPE_ALL']=$request_work_type_all;
//если значения нет, но есть имя, сбрасываем значение глоб. переменной:
elseif (isset($_POST['work_type_all'])||isset($_GET['work_type_all'])) unset($_SESSION['S_WORK_TYPE_ALL']);

//если получили запрос (аналогично предыдущему)
if ($request_work_area_all) $_SESSION['S_WORK_AREA_ALL']=$request_work_area_all;
elseif (isset($_POST['work_area_all'])||isset($_GET['work_area_all'])) unset($_SESSION['S_WORK_AREA_ALL']);

	//echo "<hr>";
	//echo "<div>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]</div>";
	//echo "<div>S_WORK_AREA_ALL= $_SESSION[S_WORK_AREA_ALL]</div></div>";


if($_REQUEST['work_table']&&!$_REQUEST['work_type']) { 
	
	$work_id=$_REQUEST['work_id'];
	$work_table=$_REQUEST['work_table']; //echo "<div>work_table= $work_table</div>";
	include("sections/work_data.php");
	
}elseif (!$_REQUEST['section']&&!$_REQUEST['article']){ //echo "<h1>IF!</h1>"; 
		   		
	$limit_finish=(strstr($_SERVER['HTTP_HOST'],"localhost"))? 50:500;
	$Worx->setPagesLimit($limit_finish,$limit_start);
	  
	$work_subject=$_REQUEST['work_subject'];	
	
	if ($work_subject) $dbSearch=new dbSearch;
	
	//определить аргумент для типа работы - искомой по теме или выбор для всех:
	$work_type=($_REQUEST['work_type'])? $_REQUEST['work_type']:$_SESSION['S_WORK_TYPE_ALL'];
	$work_area=($_REQUEST['work_area'])? $_REQUEST['work_area']:$_SESSION['S_WORK_AREA_ALL'];
	
	//echo "<div>isset(\$request_work_type_all)=".isset($request_work_type_all).", work_type= $work_type</div>";
	//echo "<div>isset(\$request_work_area_all)=".isset($request_work_area_all).", work_area= $work_area</div>";
	//echo "<hr>";
	//echo "<div>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]</div>";
	//echo "<div>S_WORK_AREA_ALL= $_SESSION[S_WORK_AREA_ALL]</div>";

	$arrAll=$Worx->findAllWorx( $work_subject,
								$work_type,
								$work_area,
								$arrDplomZakazIDsWithFiles,
								$arr //массив отсортированных найденных по искомой теме значений
							  );
	$all_worx=count($arrAll);?><img src="images/spacer.gif" width="100%" height="12"><table width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td width="100%" class="bgPanel borderBottom1 borderColorGray paddingLeft10"><h1 class="txt130" style="margin-bottom:14px;"><img src="images/shopping_plus-32.png" width="32" height="32" hspace="4" align="absbottom"><?
	    if ($work_subject) {?>Найденные<? $wcnt=count($arr);}
        else {?>Готовые<? $wcnt=$all_worx; }?> работы (<? echo $wcnt;?>):</h1></td>
      <td nowrap class="iborder borderColorGray padding10 bgPale"><a href="#worx_rest">Оставшиеся работы</a></td>
    </tr>
</table>
<div class="paddingBottom6 paddingTop6">
<? if (!$work_subject) {?>
<? if ($test_worx_filter){?>{Отобразить таблицу выбора типа и предмета работ (фильтр)}<? }
$Worx->setFilterToWorxCriteria();?>
<? }?>
</div>
<!--<img src="images/spacer.gif" width="100%" height="14">--><table width="100%" border="1" cellpadding="4" cellspacing="0" rules="rows" id="tbl_customer">
  	  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale">
  	    <td height="36" class="cellPassive<? //echo($_SESSION['S_SORT']=="subject")? "Active":"Passive";?>"><input type="checkbox" name="checAll" id="checkAll" onClick="manageCheckBoxes(this,'tbl_customer');"></td>
  	    <td bgcolor="#003399" class="padding6 cellPassive<? 
		
		//echo($_SESSION['S_SORT']=="subject"||$work_subject)? "Active":"Passive";
		
		?>"><strong><a>id</a></strong></td>
    	<td bgcolor="#003399" class="padding6 cellPassive<? 
		
		//echo($_SESSION['S_SORT']=="subject"||$work_subject)? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=subject"<? }*/
		
		?>>Тема</a></strong></td>
    	
        <td class="padding6 cellPassive<? 
		
		//echo(($_SESSION['S_SORT']=="typework"&&!$work_subject)||$_REQUEST['work_type'])? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=typework"<? }*/
		
		?>>Тип</a></strong></td>
    	
        <td class="padding6 cellPassive<? 
		
		//echo(strstr($_SESSION['S_SORT'],"predmet")&&!$work_subject)? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=diplom_worx_topix.predmet"<? }*/
		
		?>>Предмет</a></strong></td>

  	  </tr>
	<?	//выясним, есть ли заказ в корзине; - выведем title, заблокируем чекбокс
		function findOrder($work_id,&$title_busy) {
			//проверим, нет ли уже у заказчика такого заказа в корзине:
			$qFindOrder="SELECT number FROM ri_basket WHERE user_id = $_SESSION[S_USER_ID] AND work_id = $work_id";
			if ($_SESSION['S_USER_TYPE']=='customer'&&mysql_num_rows(mysql_query($qFindOrder))) $checked_disabled=" checked disabled";

			//выведем title об отложенном в корзину заказе:
			if ($checked_disabled) $title_busy=' title="Заказ отложен в вашу корзину"'; 
			return $checked_disabled;
		}
		
		$bg_count=0; //background
        //errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
        //если загружаем результаты поиска:
        if ($work_subject) { 
            for ($r=0;$r<count($arr);$r++) {
				//сбрасываем метку заказа, отложенного в корзину:
				unset($checked_disabled); 
                $work_id=$arr[$r]['item_id'];
				//выясним, не находится ли заказ уже в корзине:
				$checked_disabled=findOrder($work_id,$title_busy);
				//если не давали команду добавить заказы из кабинета:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {
				
                	$work_subject=$arr[$r]['item_name'];
                	
					//predmet//typework:
					$work_table=$arr[$r]['item_table'];
					$Worx->getWorkAreaAndType($work_table,$work_id);
					$work_area=$Worx->work_area;
					$work_type=$Worx->work_type;?>
                    
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>

    <td><input type="checkbox" 
    		   name="order_<?=$work_table?>_<?=$work_id?>" 
    		   id="order_<?=$work_table?>_<?=$work_id?>" 
               value="<?=$work_id?>"<?=$checked_disabled?>></td>
    <td>&nbsp;</td>
    <td><a href="index_temp.php?work_table=<?=$work_table?>&work_id=<?=$work_id?>"><?=$work_subject?></a></td>
    <td><?=$work_type?></td>
    <td><?=$work_area?></td>
  </tr>
	  <?			$bg_count++; //инкременируем счётчик бэкграундов
	  			}
            }

        }elseif($all_worx){ //если загружаем список по умолчанию:

			//установим текущий лимит отображения записей на стр.:
			$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
			for ($i=$limit_start;$i<$current_limit;$i++) {
				//сбрасываем метку заказа, отложенного в корзину:
				unset($checked_disabled); 
				//выясним, не находится ли заказ уже в корзине:
				$checked_disabled=findOrder($arrAll[$i]['work_id'],$title_busy);
				//если не давали команду добавить заказы из кабинета:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {?>
		
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>
        
    <td><input type="checkbox" 
    		   name="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               id="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               value="<?=$arrAll[$i]['work_id']?>"<?=$checked_disabled?>>
   </td>
    <td><?=$arrAll[$i]['work_id']?></td>
    <td><a href="index_temp.php?work_table=<?=$arrAll[$i]['work_table']?>&work_id=<?=$arrAll[$i]['work_id']?>"><?=$arrAll[$i]['work_subject']?></a></td>
    <td><?=$arrAll[$i]['work_type']?></td>
    <td><?=$arrAll[$i]['work_area']?></td>
  </tr>
		
<?					$bg_count++;
					if ($arrAll[$i]['work_table']=="diplom_zakaz") $arrDiplomZakaz[]=$arrAll[$i]['work_id'];
				}
    		} 
		}?>
    </table>
	<? 
	
	//а теперь получим все закрытые/выданные работы, вычтем ранее полученные и выясним, по каким у нас нет файлов...
	echo "<div>[".count($arrDiplomZakaz)."]</div>";
	//var_dump($arrDiplomZakaz);
	//извлечём массив данных:
$qSel="SELECT number, status_cycle, subject FROM diplom_zakaz
   WHERE ( status_cycle = 'closed' OR 
         status_cycle = 'made' OR
		 status_cycle = 'remade' OR
		 status_cycle = 'processed' ) 
ORDER BY number DESC";
$rSel=mysql_query($qSel); 
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); ?>
<div onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';"><h4><span class="link">Всего к продаже: <?
$allToSale=mysql_num_rows($rSel); echo $allToSale;?>, допущено, с файлами: <? echo count($arrToSale);?>; <? 
?><a name="worx_rest">Остальные работы</a></span> (<?=$allToSale-count($arrToSale)?>):</h4></div>
<div style="display:<?="none"?>;">
<?  
while ($arr = mysql_fetch_assoc($rSel)) { 

	if (!in_array($arr['number'],$wAll2)) {
		
		echo "<div>[".$arr['number']."][".$arr['status_cycle']."][files: ";
		//
		$arrFiles=$Worx->getDplomZakazIDsWithFiles();
		if (count($arrFiles)&&is_array($arrFiles)) foreach ($arrFiles as $file) echo "<div>/$file/</div>";
		
		echo "] $arr[subject]</div>";
		//$empty++;

	} 
}?></div><? //echo "<h5>[=$empty=]</h5>";

	$Blocks->authorizeToAddToBasket();?>
    <table cellspacing="0" cellpadding="0">
  <tr>
    <td class="paddingBottom8 paddingTop8"><input type="submit" value="Добавить в корзину заказов!" style="padding:8px; width:240px;" onClick="return checkAllBoxes('reg_area');"></td>
<?  if ($work_subject) {?>
	<td class="paddingLeft10">[<a href="index.php">сбросить результат поиска</a>]</td>
<? }?>
  </tr>
</table><?	  
	  //$test_pages=true;
	  if ($test_pages){?>{ Переход по страницам... }<? }
	  $Blocks->makePagesNext($all_worx,$limit_finish);

	}
		//если статьи:
		if (isset($_REQUEST['article'])) include("articles/index.php");
		if (isset($_REQUEST['section'])) include("sections/index_sections.php");
	
?></form></td>
    <td width="23%" valign="top" class="contentColumn borderTop1 borderColorGray paddingLeft20">&nbsp;</td>
  </tr>
  <tr bgcolor="#E1E1FF">
    <td height="50" colspan="2" valign="top" bgcolor="#E1E1FF" class="txt100" id="flat"><a href="index.php">&#8226; Главная</a> &nbsp;<a href="index_temp.php?section=payment">&#8226; Способы оплаты</a> &nbsp;<a href="index_temp.php?section=faq">&#8226; FAQ</a> &nbsp;<a href="index_temp.php?section=useful">&#8226; Полезное</a> &nbsp;<a href="index_temp.php?section=agreement">&#8226; Пользовательское соглашение</a> &nbsp;<a href="index_temp.php?section=partnership">&#8226; Сотрудничество</a></td>
    <td valign="top" class="paddingTop14">&copy;<a href="http://www.eduservice.biz">EducationService</a> 2003-<? echo date("Y");?></td>
  </tr>
</table>
<? 
  }
else include("sections/register.php");?></body>
</html>