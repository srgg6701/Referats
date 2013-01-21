<?
class Orders {

public $all_orders_exists;//общее количество заказов
//массивы заказов:
public $arrAllOrders; //все
public $arrAuthorOrders; //авторские
public $arrOrdersUnpaid; //...по которым не было ни одной проплаты
public $arrOrdersPaidNoPrice; //...без цены, но с проводками
public $arrOrdersPaidPartly; //...оплаченные частично
public $arrOrdersPaidNotSent; //...полностью оплаченные, но не отосланные
public $arrOrdersPaidSent; //...отосланные заказчику или открытые для скачивания
public $arrOrdersToPay; //...по которым должны быть выплаты автору
public $arrOrdersPaidUp; //ПОЛНОСТЬЮ выплаченные авторам
### резерв:
public $arrOrdersPaidFull; //...оплаченные полностью
public $arrOrdersPaid; //***...по которым были проводки (не обязательно подтверждённые)

	
	function buildOrdersTable() {
		
		global $Blocks;
		global $catchErrors;
		global $Money;
		global $Tools;
		global $Worx;
		
		$order_status=($_REQUEST['order_status'])? $_REQUEST['order_status']:"paid_notsent";
		if (isset($_REQUEST['work_id'])) $work_id=$Tools->clearToIntegerAndStop($_REQUEST['work_id']);
		
		//если заавторизован автор, будем фильровать его заказы:
		if ($_SESSION['S_USER_TYPE']=="author") {
			
			global $Author;
			
			//if (isset($_SESSION['TEST_MODE'])) echo "<div>method buildOrdersTable</div>";
			$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']));
			$this->arrAuthorOrders=$arrAuthorOrders;
			
			if ($arrAuthorOrders) {
				//для таблицы проводок:
				$inAuthorOrdersPayment=" WHERE ri_basket_id IN (".implode(",",$arrAuthorOrders).")";
				//для таблицы заказов:
				$inAuthorOrders=" WHERE number IN (".implode(",",$arrAuthorOrders).")";
			}
		}
		
		########################################
		//создать фильтр записей:
		  //unpaid/			Не оплачен
		  //paid_partly/	Оплачен не полностью
		  //paid_notsent/	Оплачен полностью, не отослан
		  //paid_sent/		Оплачен и отослан
		//$arrOrdersAll=array();//все заказы
		$arrRiBasketSumms=array();//сумма проплат по заказам
		//все заказы, по которым были проводки:
		$arrOrdersPaid=array();
		//все заказы БЕЗ ЦЕНЫ по которым были проводки:
		$arrOrdersPaidNoPrice=array();
		//все заказы, оплаченные ПОЛНОСТЬЮ:
		$arrOrdersPaidFull=array();
		//выясним состояние оплаты - частично или полностью.
		//ВНИМАНИЕ! Полностью оплаченным считается только тот заказ, ПОДТВЕРЖДЁННАЯ сумма проводок по которому не менее его стоимости.
		$arrOrdersPaidPartly=array(); //частично
		$arrOrdersPaidNotSent=array(); //полностью, не отослан
		$arrOrdersPaidSent=array(); //полностью оплачен и отослан
		$arrOrdersPaidUp=array(); //выплачен автору

		$this->getOrdersArraysByTypes($inAuthorOrders);
		//getAllOrders($inAuthorOrders);
		//все заказы:
		$all_orders_exists=$this->all_orders_exists;
		
		if ($all_orders_exists) { //echo "<h2>all_orders_exists</h2>";

			$arrAuthorOrders=$this->arrAuthorOrders;
			$arrOrdersUnpaid=$this->arrOrdersUnpaid;
			$arrOrdersPaidPartly=$this->arrOrdersPaidPartly;
			$arrOrdersPaidNotSent=$this->arrOrdersPaidNotSent;
			$arrOrdersPaidSent=$this->arrOrdersPaidSent;
			$arrOrdersPaidNoPrice=$this->arrOrdersPaidNoPrice;
			$arrOrdersToPay=$this->arrOrdersToPay;
			$arrOrdersPaidUp=$this->arrOrdersPaidUp;
			
			switch ($_SESSION['FILTER_ORDER_STATUS']) {
			  
				case "all":
				  if (!$inAuthorOrders) unset($inArray);
				  else $inArray=$arrAuthorOrders;
					break;
					
				case "unpaid": //неоплаченные
				  $inArray=$arrOrdersUnpaid;
					break;
			
				case "paid_partly": //оплаченные не полностью*
				  $inArray=$arrOrdersPaidPartly;
					break;
			
				case "paid_notsent": //оплаченные, не отосланные*
				  $inArray=$arrOrdersPaidNotSent;
					break;
			
				case "paid_sent": //оплаченные и отосланные
				  $inArray=$arrOrdersPaidSent;
					break;
			
				case "paid_no_price": //оплаченные и отосланные
				  $inArray=$arrOrdersPaidNoPrice;
					break;
			
				case "to_pay": //к выплате
				  $inArray=$arrOrdersToPay;
					break;
					
				case "paid_up": //к выплате
				  $inArray=$arrOrdersPaidUp;
					break;
					
				default:
			
					if (!$_SESSION['FILTER_ORDER_STATUS']) {
			
						if (count($arrOrdersPaidNotSent)) {
							$inArray=$arrOrdersPaidNotSent;
							$_SESSION['FILTER_ORDER_STATUS']="paid_notsent";
						}
						else {
							if (count($arrOrdersPaidPartly)) {
								$inArray=$arrOrdersPaidPartly;
								$_SESSION['FILTER_ORDER_STATUS']="paid_partly";
							}
							else {
								if (count($arrOrdersUnpaid)) {
									$inArray=$arrOrdersUnpaid;
									$_SESSION['FILTER_ORDER_STATUS']="unpaid";
								}
								else {
									$inArray=$arrOrdersPaidSent;
									$_SESSION['FILTER_ORDER_STATUS']="paid_sent";
								}
							}
						}
			
					}
			}

			//извлечём массив данных всех заказов:
			$qSelOrders="SELECT ri_basket.* FROM ri_basket"; 
			
			if ($work_id) $qSelOrders.=" WHERE  work_id = $work_id";
			else {
				
				if ($_REQUEST['author_id']||$_REQUEST['customer_id']) {
				
					$qSelOrders.=($_REQUEST['author_id'])? ", ri_worx 
			  WHERE  ri_worx.number = ri_basket.work_id
			   AND ri_worx.author_id = $_REQUEST[author_id]":" WHERE  user_id = $_REQUEST[customer_id]";
				
				}else {
				
					if( ( $_SESSION['FILTER_ORDER_STATUS'] && $_SESSION['FILTER_ORDER_STATUS']!="all" ) ||
						  $inAuthorOrders
					  ) {
					
						$inNumber=(count($inArray)&&is_array($inArray))? implode(",",$inArray):"0";		
						$qSelOrders.=" WHERE number IN ($inNumber)";
			
					}
				}
			}
		
			$qSelOrders.="
			ORDER BY ri_basket.number DESC";
			//$catchErrors->select($qSelOrders);
			$rSelOrders=mysql_query($qSelOrders); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelOrders",$qSelOrders); 
			$rw_orders=mysql_num_rows($rSelOrders);
		}?>
<script type="text/javascript">
function go_orders_choice(selVal) {
if (selVal) var go_page='?menu=orders&amp;order_status='+selVal;
location.href=go_page;
}
</script>
		
		<table cellspacing="0"<? if ($_SESSION['S_USER_TYPE']=="worker"){?> height="100%"<? }?> cellpadding="4">
		  <tr<? if ($_SESSION['S_USER_TYPE']=="worker"){?> style="height:auto;"<? }?>>
			<td class="paddingTop0"><? 
			if ($work_id||$_REQUEST['author_id']||$_REQUEST['customer_id']) { 
		
				if ($work_id) $for_work="работе";
				else {
					if (isset($_REQUEST['author_id'])) {
						
						$user_id=$_REQUEST['author_id'];
						$user_type="author";
					
					}else{
						
						$user_id=$_REQUEST['customer_id'];
						$user_type="customer";
					
					} 
				}	
				$Blocks->showFilterResults( "orders", 	//тип полученных объектов
											  $for_work,			//объект, по которому фильтровали
											  $work_id,		//...его id...
											  $user_type,		//если фильтровали по Заказчику/Сотруднику/Автору
											  $user_id	//...его id...
										);
				
				}else{
				
					?>Состояние: <img src="<?=$_SESSION['SITE_ROOT']?>images/filter_order.png" width="22" height="16" hspace="4" align="absmiddle" />
		<select name="order_status" id="order_status" onChange="go_orders_choice(this.options[this.selectedIndex].value);">
				
				<option value="all"<? if(!$_SESSION['FILTER_ORDER_STATUS']){?> selected<? }?>>Все заказы: <?=($all_orders_exists)? $all_orders_exists:"0"?></option>
				
				<option value="unpaid"<? if($_SESSION['FILTER_ORDER_STATUS']=="unpaid"){?> selected<? }?>>Не оплачен: <? echo(count($arrOrdersUnpaid)&&is_array($arrOrdersUnpaid))? count($arrOrdersUnpaid):"0";?></option>
			<? if (count($arrOrdersPaidNoPrice)&&is_array($arrOrdersPaidNoPrice)){?>				
				<option value="paid_no_price"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_no_price"){?> selected<? }?> class="txtRed">Оплачен, без стоимости: <? echo count($arrOrdersPaidNoPrice);?></option>
			<? }?>				
				<option value="paid_partly"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_partly"){?> selected<? }?> style="background-color:#F7F7F7">Оплачен не полностью: <? echo(count($arrOrdersPaidPartly)&&is_array($arrOrdersPaidPartly))? count($arrOrdersPaidPartly):"0";?></option>
				
				<option value="paid_notsent"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_notsent"){?> selected<? }?> style="background-color:#FFFF99">Оплачен полностью, не отослан: <? echo(count($arrOrdersPaidNotSent)&&is_array($arrOrdersPaidNotSent))? count($arrOrdersPaidNotSent):"0";?></option>
				
				<option value="paid_sent"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_sent"){?> selected<? }?> style="background-color:#CCFFCC">Оплачен и отослан<? if ($_SESSION['S_USER_TYPE']=="worker"){?>/открыт доступ<? }?>: <? echo(count($arrOrdersPaidSent)&&is_array($arrOrdersPaidSent))? count($arrOrdersPaidSent):"0";?></option>
			
				<option value="to_pay"<? if($_SESSION['FILTER_ORDER_STATUS']=="to_pay"){?> selected<? }?> style="background-color:#FFCC00">Продан, но не выплачен: <? echo(count($arrOrdersToPay)&&is_array($arrOrdersToPay))? count($arrOrdersToPay):"0";?></option>

				<option value="paid_up"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_up"){?> selected<? }?> style="background-color:#EAF8F8">Выплачен автору: <? echo(count($arrOrdersPaidUp)&&is_array($arrOrdersPaidUp))? count($arrOrdersPaidUp):"0";?></option>

			</select>

		<?	}?></td>
		  </tr>    
		  <tr class="txt110 authorTblRowHeader"<? if ($_SESSION['S_USER_TYPE']=="worker"){?> style="height:auto;"<? }?>>
			<td nowrap="nowrap" class="paddingLeft0">
			<img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" title="id Заказа" />id,    
			<img src="<?=$_SESSION['SITE_ROOT']?>images/order_wait.png" width="20" height="16" hspace="4" align="absmiddle" title="Статус заказа" />Статус,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" border="0" align="absmiddle" title="Проводки по заказу" />Проводки,
        <? }?>
            <img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" border="0" align="absmiddle" title="id Работы" />id,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" align="absmiddle" title="Собственник работы" />Владелец,
        <? }?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/calendar_clock.gif" width="19" height="15" hspace="4" align="absmiddle" title="Дата и время создания заказа" />Создан,
			<img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" title="Название работы" />Название,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="18" hspace="4" align="absmiddle" />Заказчик,
        <? }?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" align="absmiddle" />Цена,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" align="absmiddle" />Перечислено,
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_applied.gif" width="17" height="15" hspace="4" border="0" align="absmiddle" />Подтверждено,
			<img onClick="alert('Чтобы добавить проводку по заказу, выберите соответствующий заказ в таблице и щёлкните по значку \'+\' (плюс) в последнем столбце строки заказа.');" title="Добавить проводку по заказу..." src="../images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />...
        <? }?>
            </td>
		  </tr>
		  <tr<? if ($_SESSION['S_USER_TYPE']=="worker"){?> height="100%"<? }?>>
			<td class="padding0">
			  <div<? if ($_SESSION['S_USER_TYPE']=="worker"){?> style="height:100%; overflow:auto;"<? }?>>
		<table width="100%" cellpadding="4" cellspacing="0" id="tbl_orders" rules="rows">
	<?  //
		if ($rw_orders)
		while ($arr = mysql_fetch_assoc($rSelOrders)) { 
			
				//рассчитать/извлечь стоимость работы:
				$work_price=$Worx->calculateWorkPrice ($arr['work_table'],$arr['work_id'],false);
				//пропишем сумму всех входящих платежей по заказу
				$all_summ=$Money->allPaymentsInbox($arr['number']);	
				//получим сумму всех ПОДТВЕРЖДЁННЫХ входящих платежей по заказу
				$all_summ2=$Money->allPaymentsInbox($arr['number'],true);	?>
		  <tr<?
			
			unset($state);
			if ($all_summ||!$work_price){?> bgcolor="#<? //
				
				//не указана стоимость работы:
				if (!$work_price){
					
					$state="no_price";
					
					?>FFCCFF<? $title="Не указана стоимость работы";
					
				}else{
					
				$title="Работа ";
					
					//сумма подтверждённых платежей не меньше стоимости работы:
					if($all_summ2>=$work_price) {
						
						if (is_array($arrOrdersToPay)&&in_array($arr['number'],$arrOrdersToPay)) {
							?>FFFFFF<?
							
							$state="to_pay";
							$title.="продана, ";
							$title.=($arr['work_table']=="ri_worx")? "автору не выплачены деньги":"открыт доступ на скачивание файлов";
						
						}else{
							
							//работа отослана (всё ОК):
							if ($arr['state']=="sent") {
								
								//проверить, выплачено ли автору?
								
								
								
								$state="sent";
						
								?>CCFFCC<? $title.="отправлена заказчику";
							
							//не отослана:
							}else{
								
								$state="not_sent";
						
								?>FFFF99<? $title.="не отправлена...";
						
							}
						}
					//подтверждено меньше стоимости работы:
					}else{
						
							$state="paid_partly";
							
							?>F7F7F7<? $title="Заказ оплачен не полностью...";
					
					}
				}?>"<? 
			}else{ 
				
				$state="unpaid";
				
				$title="Заказ не оплачен";
				
			}
			if ($title){?> title="<?=$title?>"<? unset($title); }?>>
			
			<td align="right"><? if ($test_order_id){?>order_id<? } ?><?=$arr['number']?></td>
			<td class="paddingLeft2"><?
			
			if ($test_table_source){?>Статус заказа<? }
			
			switch ($state)  { 

				case "sent":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" /><?
						break;
		
				case "not_sent":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" /><?
						break;
		
				case "paid_partly":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest_question.png" width="16" height="16" /><?
						break;
		
				case "unpaid":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/money_giving.gif" width="13" height="16" /><?
						break;
						
				case "no_price":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" /><?
						break;
				
			}?></td>

			<? if ($_SESSION['S_USER_TYPE']=="worker") {?>			

			<td><a href="../manager/?menu=messages&amp;action=compose&amp;order_id=<?=$arr['number']?>" title="Отправить сообщение по заказу..."><img src="<?=$_SESSION['SITE_ROOT']?>images/envelope_small.png" width="14" height="10" border="0" /></a></td>
			
			<td><a href="../manager/?menu=money&amp;order_id=<?=$arr['number']?>" title="Загрузить проводки по заказу <?=$arr['number']?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" border="0" align="absmiddle" /></a></td>

			<? }?>			
			<td align="right"><a href="../manager/?menu=orders&amp;work_id=<?=$arr['work_id']?>" title="Отфильтровать заказы по работе id <?=$arr['work_id']?>"><? 
			
			if ($test_work_id) {?>work_id<? }
			echo $arr['work_id'];?></a></td>
			
			<? if ($_SESSION['S_USER_TYPE']=="worker") {?>			

			<td class="paddingRight0"><?
			if ($arr['work_table']=="ri_worx") $Worx->setWorkLinkMailTo($arr['work_id']);
			else {?>&nbsp;<? }?></td>
			
			<td><?
			
			if ($test_table_source){?>Владелец<? }
			//
			if ($arr['work_table']=="ri_worx"){
				//получить данные автора-владельца:
				//извлечём массив данных:
				$qSelEmailAuthor="SELECT login,ri_user.number FROM ri_user, ri_worx 
	 WHERE ri_user.number = ri_worx.author_id
	   AND ri_worx.number = ".$arr['work_id'];
				$rSelEmailAuthor=mysql_query($qSelEmailAuthor); 
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelEmailAuthor",$qSelEmailAuthor); 
				if (mysql_num_rows($rSelEmailAuthor)) {
					$login=mysql_result($rSelEmailAuthor,0,'login');		
					$author_id=mysql_result($rSelEmailAuthor,0,'number');
				}?><a href="../manager/?menu=orders&amp;author_id=<?=$author_id?>" onMouseOver="this.title='Отфильтровать заказы по автору';"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /></a><a href="../manager/?menu=messages&amp;action=compose&amp;mailto=author&amp;user_id=<?=$author_id?>" title="Отправить сообщение автору"><?
				if (strlen($login)>8) {
					
					echo "<span title='$login'>".substr($login,0,7)."...</span>";
					
					
				}else{
				
					echo $login;
				
				}?></a><? 
			}else echo $arr['work_table'];?></td>
		
		<? }?>			
            
            <td nowrap><? if ($test_datatime){?>datatime<? }$Tools->dtime($arr['datatime']);?></td>
			
            <td><a href="#"><?=$Worx->getWorkName($arr['work_table'],$arr['work_id'])?></a></td>
			
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>			

            <td><a href="../manager/?menu=orders&amp;customer_id=<?=$arr['user_id']?>" title="Отфильтровать заказы по заказчику"><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle"></a><a href="../manager/?menu=messages&amp;action=compose&amp;mailto=customer&amp;user_id=<?=$arr['user_id']?>" title="Отправить сообщение заказчику"><?
				//извлечём массив данных:
				$qSelEmail="SELECT email FROM ri_customer WHERE number = ".$arr['user_id'];
				$rSelEmail=mysql_query($qSelEmail); 
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelEmail",$qSelEmail); 
				if (mysql_num_rows($rSelEmail)) echo mysql_result($rSelEmail,0,'email');?></a></td>
			
		<? }?>			
            
            <td align="right"><? 
				
			echo $work_price;
				
			if ($test_price){?>calculateWorkPrice<? }?></td>

		<?  if ($_SESSION['S_USER_TYPE']=="worker") {?>			

			<td align="right"><? //загрузить карточку заказа со статистикой проплат...?><a href="../manager/?menu=money&amp;order_id=<?=$arr['number']?>" title="Отфильтровать проводки по заказу"><?
			
			echo $all_summ;
			
			?></a></td>
			
			<td align="center"><?
			
					if ($all_summ2<$all_summ){?><span class="txtRed"><?=$all_summ2?></span><? }
					else echo $all_summ2;
			
			?></td>
			
            <td align="center"><a href="../manager/?menu=mone&amp;action=add&amp;order_id=<?=$arr['number']?>" title="Добавить проводку по заказу id <?=$arr['number']?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus_big.png" width="16" height="16" border="0" align="absmiddle" /></a></td>
            <? }?>
		  </tr>
		<? }?>
		</table>    
			  </div>
			</td>
		  </tr>
		</table><?
	} //КОНЕЦ МЕТОДА
	//проверим выплаты автору
	function checkOrderPaidUp($order_id) {
		
		global $catchErrors;
		global $Worx;
		//проверим выплаты автору:
		$qSel="SELECT summ FROM ri_payouts WHERE ri_basket_id = $order_id";
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
		if (mysql_num_rows($rSel)) {
			$payout_summ=0;
			while ($arr = mysql_fetch_assoc($rSel)) $payout_summ+=$arr['summ'];
			//если выплаченная автору сумма не меньше чистой (авторской стоимости работы) стоимости заказа:
			if ($payout_summ>=$Worx->calculatePureLocalPrice($Worx->getWorkID($order_id))) return true;
			else return false;
		}
	}	
	//подсчитать колич. проданных заказов, выплаченных полностью:
	function countSoldPaidUpOrders($arrTargetOrders) { //аргумент - все авторские заказы
	
		global $catchErrors;
		global $Worx;
		
		if (count($arrTargetOrders)) {
			//извлечём массив данных:
			$qSel="SELECT ri_basket_id,summ FROM ri_payouts WHERE ri_basket_id IN (".implode(",",$arrTargetOrders).")";
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, countSoldPaidUpOrders()","qSel",$qSel); 
			$arrPayoutsSumms=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrPayoutsSumms[$arr['ri_basket_id']]+=$arr['summ'];
			//проверить, полностью ли осуществлены выплаты:
			$arrOrdersPaidUp=array();
			foreach($arrPayoutsSumms as $order_id=>$payout_summ) 
				//если выплаченная автору сумма не меньше чистой (авторской стоимости работы) стоимости заказа:
				if ($payout_summ>=$Worx->calculatePureLocalPrice($Worx->getWorkID($order_id))) $arrOrdersPaidUp[]=$order_id;
			
		}
		
		return $arrOrdersPaidUp;
		
	} //КОНЕЦ МЕТОДА 
	//получить все заказы:
	function getAllOrders($inAuthorOrders=false) {	
	
		global $catchErrors;
		
		//извлечём массив данных всех заказов:
		$qSelBasketAll="SELECT number FROM ri_basket $inAuthorOrders ORDER BY number DESC";
		//$catchErrors->select($qSelBasketAll,true); 
		$rSelBasketAll=mysql_query($qSelBasketAll); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelBasketAll",$qSelBasketAll); 
		$all_orders_exists=mysql_num_rows($rSelBasketAll);
		if ($all_orders_exists) {
			$this->all_orders_exists=$all_orders_exists;
			while ($arr = mysql_fetch_assoc($rSelBasketAll)) $arrAllOrders[]=$arr['number'];
			$this->arrAllOrders=$arrAllOrders;
			return $arrAllOrders;		
		}else return false;
	}
	
	//получить массивы заказов по типам:
	function getOrdersArraysByTypes($inAuthorOrders=false) {
			
			global $catchErrors;
			global $Worx;
			
			//получить все выплаченные:
			$tArr=($_SESSION['S_USER_TYPE']=="author")? $this->arrAuthorOrders:$this->arrAllOrders;
			$arrSoldPaidUpOrders=$this->countSoldPaidUpOrders($tArr);
			
			//извлечём все проводки:
			$qSelPayment="SELECT ri_basket_id,summ,payment_status FROM ri_payments $inAuthorOrdersPayment";
			//$catchErrors->select($qSelPayment,true); 
			$rSelPayment=mysql_query($qSelPayment); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelPayment",$qSelPayment); 
			
			if (mysql_num_rows($rSelPayment)) {
				//получим массив заказов по которым был приход денег и сумму прихода по каждому:
				while ($arr = mysql_fetch_assoc($rSelPayment)) {
					//получим сумму проводок по каждому заказу:
					$arrRiBasketSumms[$arr['ri_basket_id']]+=$arr['summ'];
					//получим массив всех заказов, ПО КОТОРЫМ БЫЛИ ПРОВОДКИ
					$arrOrdersPaid[]=$arr['ri_basket_id'];
				}
				ksort($arrRiBasketSumms);//чиста для отладки...
				//унифицируем массив:
				if (count($arrOrdersPaid)) $arrOrdersPaid=array_unique($arrOrdersPaid);
			}
			###################################
			$arrAllOrders=$this->getAllOrders($inAuthorOrders);
			
				//$test_array_paid=true;
				if ($test_array_paid&&is_array($arrOrdersPaid)) {
					echo "<h5>\$arrOrdersPaid:</h5>";
					foreach ($arrOrdersPaid as $order_id=>$summ)
						echo "<div>$order_id=>$summ</div>";
				}
						
			//создать остальные массивы по типам:			
			for ($i=0;$i<count($arrAllOrders);$i++) { //echo( "rSelBasketAll ");
				
				$order_id=$arrAllOrders[$i];
				
				//сформируем массивы заказов по типам.
				//не оплаченные совсем:
				if (
					( is_array($arrOrdersPaid)&&!in_array($order_id,$arrOrdersPaid) )||
					  !count($arrOrdersPaid)
				   ) $arrOrdersUnpaid[]=$order_id;
				//оплаченные не полностью:
				elseif ($order_id) {

					$table=$Worx->getWorkTable($order_id);
					//рассчитать/извлечь стоимость работы:
					if ($_SESSION['S_USER_TYPE']=="author")	$price=$Worx->calculateLocalPrice($Worx->getWorkID($order_id));
					else {
						$wrk_id=$Worx->getWorkID($order_id);
						$price=$Worx->calculateWorkPrice ( $table,
													  	   $wrk_id,
													  	   false
														 );
					}
					$paid_ok=$Worx->calculateOrderPayment($order_id,true);
					//price		- цена работы
					//summ		- сумма всех входящих платежей
					//paid_ok	- сумма подтверждённых входящих платежей
					if ($price) {
						
						if ($paid_ok>=$price) {
							
							//оплачен полностью...
							$arrOrdersPaidFull[]=$order_id;
							
							//...и отослан
							if ($Worx->getWorkSent($order_id)) {
								
								$arrOrdersPaidSent[]=$order_id;
								//проверить состояние выплат автору:
								if ((!is_array($arrSoldPaidUpOrders)||!in_array($order_id,$arrSoldPaidUpOrders))&&$table=="ri_worx") $arrOrdersToPay[]=$order_id;
								
							}
							//...не отослан
							elseif ($table=="ri_worx") $arrOrdersPaidNotSent[]=$order_id;
						
						}else $arrOrdersPaidPartly[]=$order_id; //оплачен частично...
					
					}else{ //БЕЗ цены, НО С ПРОВОДКАМИ:
					
						$arrOrdersPaidNoPrice[]=$order_id;
						//echo "<div class='txtRed'>table= $table<br>wrk_id= $wrk_id<br>order_id= $order_id<br>price= $price</div><hr>";
					
					}
					//проверим выплаты автору:	
					if ($this->checkOrderPaidUp($order_id)) $arrOrdersPaidUp[]=$order_id; 
				}
			}
			
			$this->arrOrdersUnpaid=$arrOrdersUnpaid;
			$this->arrOrdersPaid=$arrOrdersPaid;
			$this->arrOrdersPaidNoPrice=$arrOrdersPaidNoPrice;
			$this->arrOrdersPaidPartly=$arrOrdersPaidPartly;
			$this->arrOrdersPaidFull=$arrOrdersPaidFull;
			$this->arrOrdersPaidNotSent=$arrOrdersPaidNotSent;
			$this->arrOrdersPaidSent=$arrOrdersPaidSent;
			$this->arrOrdersToPay=$arrOrdersToPay;
			$this->arrOrdersPaidUp=$arrOrdersPaidUp;
		
			//$test_arrays=true;
			if ($test_arrays) { $none="...не обнаружены...";
				
				?><h4>Неоплаченные</h4><?
				if ($arrOrdersUnpaid) foreach ($arrOrdersUnpaid as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>Оплаченные не полностью</h4><?
				if ($arrOrdersPaidPartly) foreach ($arrOrdersPaidPartly as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>Оплачены полностью, не отосланы</h4><?
				if ($arrOrdersPaidNotSent) foreach ($arrOrdersPaidNotSent as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>Оплачены и отосланы</h4><?
				if ($arrOrdersPaidSent) foreach ($arrOrdersPaidSent as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>Выплачены</h4><?
				if ($arrSoldPaidUpOrders) foreach ($arrSoldPaidUpOrders as $order_id) echo "$order_id, ";
				else echo $none;
			
			}		
	}
	
}?>