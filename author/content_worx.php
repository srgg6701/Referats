<? 	
if (isset($_REQUEST['work_subject'])) $work_subject=$_REQUEST['work_subject'];
require("../classes/class.dbSearch.php");
$dbSearch=new dbSearch;

//установим текст заглушки поисковой строки, чтобы она удалялась по щелчку мыши:
$Worx->setSearchPreString();

//если нужно удалить файл:
if (isset($_REQUEST['del_file_name'])) {
	//проверить, есть ли заказы по данной работе
	//получить id работы:
	$qSelOrders="SELECT ri_basket.number, state, status, ri_worx.number
  FROM ri_basket, ri_worx 
 WHERE ri_basket.work_id = ri_worx.number 
   AND ri_worx.work_name = '$_REQUEST[del_file_name]'";
	$rSelOrders=mysql_query($qSelOrders);
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelOrders",$qSelOrders); 
   	//$catchErrors->select($qSelOrders,1); echo "<div>recs: ".mysql_num_rows($rSelOrders)."</div>";
	$countPaid=0;
	if (mysql_num_rows($rSelOrders)) { //всего в корзине
		while ($arr = mysql_fetch_assoc($rSelOrders)) { 
			//выяснить состояние отправки/оплаты.
			//если есть проводки:
			if ($Worx->calculateOrderPayment($arr['number'],false)) $countPaid++;
		}
		//если по удаляемой работе остались неотосланные заказы с проводками
		if ($countPaid) {?>
<script type="text/javascript">
if (!confirm('По данной работе есть неотправленные заказчику оплаченные заказы (<?=$countPaid?>).\nВсё равно удалить?')) location.href='?menu=worx';
</script>
	<?		//известить админа об удалении работы, по которой были проводки (включая неподтверждённые):
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "Удаление автором работы, по заказам которой есть проводки",
								   "Автором id $_SESSION[S_USER_ID] ($_SESSION[S_LOGIN]) удалена работа id ".$arr['number'].". 
								   <p>Тема работы: $_REQUEST[del_file_name].</p>
								   <p>Ттип работы: ".mysql_result(mysql_query("SELECT work_type FROM ri_worx WHERE work_name = '$_REQUEST[del_file_name]'"),0,'work_type').".</p>
								   <p>Заказов работы: ".mysql_num_rows($rSelOrders).".</p>",
								   false
								 );
		}		
	}
	$Worx->deleteSingleFile("?menu=worx"); 
}
//метка блокировки изменения данных работ:
if ($submenu!="to_send"&&$submenu!="to_pay"&&$submenu!="sold") $allow_changes=true;

//если не загружаем файл:
if ($submenu!="upload"){
	
	//отсылка файлов заказчику:
	if ($submenu=="to_send"&&$_FILES) {

		//инициируем массив работ, заказы по которым могли быть отправлены заказчику:
		$arrWorxIDs=array();
		foreach ($_POST as $key=>$val) if (strstr($key,"set_number_")) $arrWorxIDs[]=$val;
		
		//$test_files=true;
		$flz=0;
		foreach ($_FILES as $file_data){
			
			//если файл не нулевой длины:
			if ($file_data['size']>0) {

				//get customers data to send file...				
				$qSelWork="SELECT ri_basket.number,
       ri_basket.work_id, 
       ri_basket.work_table, 
       ri_customer.name, 
       ri_customer.email,
       ri_customer.email2,
	   ri_worx.work_type
FROM ri_worx, ri_basket, ri_customer
WHERE ri_worx.number = '".$arrWorxIDs[$flz]."'
   AND ri_basket.work_id = ri_worx.number
   AND ri_basket.user_id = ri_customer.number";
				//$catchErrors->select($qSelWork);
				$rSelWork=mysql_query($qSelWork);
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelWork",$qSelWork);
				$count_work_order=mysql_num_rows($rSelWork);
				if ($count_work_order) {
					//
					$work_type=mysql_result($rSelWork,$count,'work_type');
					$work_id=mysql_result($rSelWork,$count,'work_id');
					$order_id=mysql_result($rSelWork,$count,'number');
					$work_table=mysql_result($rSelWork,$count,'work_table');
					
					$count=0; //echo "<h1>отсылаем файлы...</h1>";						
					smtpmail(  mysql_result($rSelWork,$count,'email'),				//адрес получателя
							   "От Referats.info: доставка заказа id $order_id (".$file_data["name"].")",			//тема сообщения
							   "Здравствуйте, ".mysql_result($rSelWork,$count,'name')."!
							   <p>Ваша работа в аттачменте. В случае возникновения затруднений, пожалуйста, обращайтесь к нам.".$Messages->setSiteSignature(true)."</p>",		//текст сообщения
							   $username,		//***логин отправителя
							   $reply_to_email,	//***адрес для ответа
							   "Admin",			//***имя получателя ответа
							   $sender_address,	//***адрес отправителя
							   "Referats.info",	//***имя отправителя
							   $file_data["tmp_name"],			//attach path 
							   $file_data["name"]				//attach name
							); 					
					$count++;			
				}	//echo "<hr>";			
			}
			$flz++;
		}
		if ($flz) {
			$alert="Файл";
			$alert.=($flz==1)? " отослан":"ы отосланы";
			$alert.=".";
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "Отсылка заказчику работы id $work_id",
								   "Заказ id $order_id; 
								   <p>Стоимость работы: ".$Worx->calculateWorkPrice	($work_table,$work_id,false).";</p>
								   <p>Подтверждено платежей на сумму: ".$Worx->calculateOrderPayment($ri_basket_id,true).";</p>
								   <p>Общая сумма проводок: ".$Worx->calculateOrderPayment($ri_basket_id,false).";</p>
								   <p>Тема работы: ".$file_data['name'].";</p>
								   <p>Тип работы: $work_type.</p>",
								   false
								 );
		}
	}
	
	//проверим, не изменяли ли параметры текущих работ:
	if (!$_REQUEST['submit_filter']&&$allow_changes)
		foreach($_POST as $key=>$work_id) {
			
			if (strstr($key,'set_number_')) {
				//получить текущее значение, сверить с полученным...
				$where=" 
  WHERE author_id = $_SESSION[S_USER_ID] 
   AND number = $work_id";
				$qSel="SELECT * FROM ri_worx $where"; 
				$rSel=mysql_query($qSel);
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
				//$catchErrors->select($qSel);
				while ($arr = mysql_fetch_assoc($rSel)) { 
					unset($qUpd);
					unset ($type);
					if ($arr['work_type']!=$_POST['work_type_'.$work_id]) {
						$qUpd.=" work_type = '".$_POST['work_type_'.$work_id]."'";
						$type=true;
					}
					//
					unset ($area);
					//получить предмет/тип:
					$Worx->getWorkAreaAndType("ri_worx",$work_id);
					if ($Worx->work_area!=$_POST['work_area_'.$work_id]) {
						if ($type) $qUpd.=", ";
						$qUpd.=" work_area = '".$_POST['work_area_'.$work_id]."'";
						$area=true;
					}
					//
					if ($arr['work_price']!=$_POST['work_price_'.$work_id]) {
						if ($area) $qUpd.=", ";
						$qUpd.=" work_price = '".$_POST['work_price_'.$work_id]."'";
					}
				}
				//
				if ($qUpd) {
					$sqlUpd="UPDATE ri_worx SET $qUpd $where";
					$catchErrors->update($sqlUpd);
					//
					$changes_saved="Изменения сохранены!";
					//
					if (!strstr($alert,$changes_saved)){
						if ($alert) $alert.="\\n"; //если отправляли файлы заказчику
						$alert.=$changes_saved;
					}
				}		
			}
		}
	//если были обновления, выведем алерт:
	if ($alert) $Messages->alertReload($alert,"?menu=worx&amp;submenu=$_REQUEST[submenu]");?>
    
<table cellspacing="0" cellpadding="4" height="100%" style="border-bottom: solid 1px #999;">
  <tr style="height:auto;">
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap"><?
	
	//список типов работ:
	$Worx->buildWorxTypesList("",$_REQUEST['work_type'],true); 
	if ($test_listing){?>Список типов работ...<? }?>&nbsp;<input style="width:120px;" type="submit" name="submit_filter" id="submit_filter" value="Отфильтровать" /></td>
<?   if ($test_table){?><td nowrap="nowrap">{ячейка и кнопка поиска работы}</td><? }
	
	//ячейка и кнопка поиска работы:
	$Worx->searchWithinAccount($txt_default);?>
      </tr>
    </table><!--<strong><a href="?menu=worx&amp;submenu=upload"><img src="<?=$_SESSION['SITE_ROOT']?>images/down.gif" width="16" height="16" hspace="4" vspace="4" border="0" align="absmiddle" />Загрузить файлы...</a></strong>--></td>
  </tr>
  <tr class="txt110 authorTblRowHeader" style="height:auto;">
    <td class="iborder borderColorGray">Объект, Статус</td>
    <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="padding-left:5px; border-left:none"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle" />&nbsp;id, <?

    if ($submenu!="upload") {

		//$addColumnSource=$submenu;
		$baskets_show=true;
		
		?><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />Заказы,<? 

	}?><img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" />Тема работы, <img src="<?=$_SESSION['SITE_ROOT']?>images/work_type.png" width="16" height="16" hspace="4" align="absmiddle" />Тип работы, <img src="<?=$_SESSION['SITE_ROOT']?>images/predmet.gif" width="16" height="16" hspace="4" align="absmiddle" />Предмет, <img src="<?=$_SESSION['SITE_ROOT']?>images/money_giving.gif" width="13" height="16" hspace="4" align="absmiddle" />Ваша Цена, <img src="<?=$_SESSION['SITE_ROOT']?>images/honorar.gif" width="18" height="17" hspace="4" align="absmiddle" />Цена для заказчика<? 
	if ($allow_changes){?>, <img src="<?=$_SESSION['SITE_ROOT']?>images/delete2.gif" width="16" height="14" hspace="4" align="absmiddle" /><span class="txtRed">Удалить</span><? }?> <span style="padding-left:40px"><?
	
	  function makeUploadButton($value,$code) {?>
        <input type="button"<?=$code?> name="button" id="button" value="<?=$value?>" onClick="location.href='?menu=worx&amp;submenu=upload'" style="color:#00F;" title="Загрузить аннотации работ и выставить их на продажу!" /><?
	  }	makeUploadButton('Разместить...',false);
	  
	  	?></span></td>
  </tr>
<?	//найти!
	//все РАБОТЫ автора:
	//$author_id=$_SESSION['S_USER_ID']; echo "<div>author_id= $author_id, S_USER_ID= $_SESSION[S_USER_ID]</div>";
	$arrAuthorWorks=$Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']);
	//все его ЗАКАЗЫ:
	$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($arrAuthorWorks);
	//все НЕотосланные:
	$arrAllAuthorsOrdersIDsToSend=array();
	//получим: 
	//все НЕоплаченные ЗАКАЗЧИКАМИ заказы автора:
	$arrAuthorOrdersUnPaid=array();
	//все полностью оплаченные заказы автора:
	$arrAuthorOrdersPaidOK=array();
	//все НЕполностью оплаченные заказы автора:
	$arrAuthorOrdersPaidPartly=array();
	//все к выплате автору:
	$arrAuthorOrdersToPay=array();
	//все выплаченные извлекаются далее, функцией:
	//
	if (count($arrAuthorOrders)) {
		//
		foreach ($arrAuthorOrders as $order_id) {
			
			//для выбранной работы в ri_worx:
			//сумма к оплате:
			$to_pay=$Worx->calculateLocalPrice($Worx->getWorkID($order_id)); 
			//оплачено и подтверждено:
			$paidOK=$Money->allPaymentsInbox($order_id,true); //echo " paidOK= $paidOK";
			$paidPartly=$Money->allPaymentsInbox($order_id);
			
			//получим СУММЫ: 
			if ($to_pay&&$paidOK>=$to_pay) { 
				//всех ПОДТВЕРЖДЁННЫХ входящих платежей по заказу:
				$arrAuthorOrdersPaidOK[]=$order_id;
				//если не отправлена:
				if (!$Worx->getWorkSent($order_id)) {
					
					$arrAllAuthorsOrdersIDsToSend[]=$order_id;
				
				}elseif (!$Orders->checkOrderPaidUp($order_id)) $arrAuthorOrdersToPay[]=$order_id;
				
			}else{ //echo "<div>order_id= $order_id, to_pay= $to_pay, paidPartly= $paidPartly</div>";
				//совсем не оплаченные:
				if (!$paidPartly) {
					$arrAuthorOrdersUnPaid[]=$order_id;
					//echo "<span class='txtRed'>неоплаченные: order_id= $order_id</span>";
				}
				//оплаченные частично
				else {
					$arrAuthorOrdersPaidPartly[]=$order_id;
					//echo "частично: order_id= $order_id";
				}
			}
			 //echo "</div><br>"; 
		} 
	} 
	//
	if (count($arrAllAuthorsOrdersIDsToSend)) {
		
		$arrWorxToSend=$Worx->convertArrOrdersIDsToWorxIDs($arrAllAuthorsOrdersIDsToSend);
		$all_to_send=count($arrWorxToSend);
	}
 	//колич. проданных и выплаченных заказов:
	$arrAuthorOrdersPaidUp=$Orders->countSoldPaidUpOrders($arrAuthorOrders);
	
	//ПОЛУЧИТЬ: #####################################################
	  //*общее количество заказов данного типа (count($arrOrdersType))
	  //*подстроку запроса для извлечения работ на текущей странице	 
	switch ($submenu) { //к отправке:

	  	case "to_send":
		  
		  $arrOrdersType=$arrAllAuthorsOrdersIDsToSend;
		  if ($all_to_send) $worxFilter.="(".implode(",",$arrAllAuthorsOrdersIDsToSend).")";	
			break;
		
		//НЕоплаченные ЗАКАЗЧИКАМИ все заказы минус оплаченные:
		case "unpaid":
		  
		  $arrOrdersUnPaid=array_diff($arrAuthorOrders,$arrAuthorOrdersPaidOK);
		  
		  if (count($arrOrdersUnPaid)) {
			  
			  $arrOrdersType=$arrOrdersUnPaid;
			  $worxFilter.="(".implode(",",$arrOrdersType).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersUnPaid)
		  }
			break;
		
		//полностью оплаченные:
		case "to_pay":
			
		  if (count($arrAuthorOrdersUnPaid)) {
			  
			  $arrOrdersType=$arrAuthorOrdersUnPaid;
			  $worxFilter.="(".implode(",",$arrAuthorOrdersUnPaid).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrAuthorOrdersUnPaid)
			  
		  }
			break;
		
		//полностью оплаченные:
		case "sold":
		  
		  $arrOrdersType=$arrAuthorOrdersPaidUp;
		  $worxFilter.="(".implode(",",$arrAuthorOrdersPaidUp).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrAuthorOrdersPaidUp)
			break;
			
		default: $arrOrdersType=$arrAuthorOrders;
	  }

	if ($worxFilter) $worxFilter="AND ri_basket.number IN $worxFilter"; 

//извлечём массив данных:
	if (isset($_REQUEST['work_type'])) 
		$sel_work_type="
   AND ri_worx.work_type = '$_REQUEST[work_type]'";
	
	$ri_where="ri_worx
  WHERE author_id = $_SESSION[S_USER_ID] $sel_work_type";
	
	$qSelAll1="SELECT * FROM $ri_where";
	
	$qSelAll="$qSelAll1
ORDER BY work_name ASC";

	//echo "Все РАБОТЫ автора (worx_id): "; $catchErrors->select($qSelAll);

	//
	$rSelAll=mysql_query($qSelAll); 
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelAll",$qSelAll); 
	$all_worx=mysql_num_rows($rSelAll);?>
      
  <tr height="100%">
    <td valign="top" nowrap="nowrap" bgcolor="#FBFBFB" id="worxSubmenu">
      <div class="txt100 paddingTop6 bold"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> Работы:</div>
	  <div<? if ($submenu=="all"||!$submenu){?> class="workMenuActive"<? }?>><nobr><a href="?menu=worx">Всего:</a> <?=$all_worx?>
      <a class="bold" title="Добавить работу(ы)" href="?menu=worx&amp;submenu=upload"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Добавить...</a></nobr></div>
      <div<? if ($submenu=="to_send"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="Работы, заказы по которым полностью оплачены. Вы должны отправить их заказчикам как можно скорее." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" vspace="2" border="0" align="absmiddle" /> <a href="?menu=worx&amp;submenu=to_send"<? if ($all_to_send){?> class="txtRed"<? }?>>К отправке:</a> <? echo($all_to_send)? $all_to_send:"0";?></nobr></div>
	<hr noshade>
   	  <div class="txt100 paddingTop6 bold"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=all">Заказы</a> (<? echo (count($arrAuthorOrders)&&is_array($arrAuthorOrders))? count($arrAuthorOrders):"0";?>):</div>
  		
	<!--<hr size="1">-->
        <div<? if ($submenu=="unpaid"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="Отложенные в корзину заказы, не оплаченные ЗАКАЗЧИКОМ." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=unpaid"> Неоплаченные</a> (<? echo(count($arrAuthorOrdersUnPaid)&&is_array($arrAuthorOrdersUnPaid))? count($arrAuthorOrdersUnPaid):"0";?>)</nobr></div>
  		
        <div<? if ($submenu=="paid_partly"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="Отложенные в корзину заказы, оплаченные ЗАКАЗЧИКОМ не полностью." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_partly"> Предоплаченные</a> (<? echo(count($arrAuthorOrdersPaidPartly))? count($arrAuthorOrdersPaidPartly):"0";?>)</nobr></div>
	
    <!--<hr size="1">-->
      <div<? if ($submenu=="to_pay"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="Купленные работы, по которым вам ещё не были выплачены деньги." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=to_pay">К выплате</a> (<?
        
		//колич. проданных, но не выплаченных автору заказов:
		echo(count($arrAuthorOrdersToPay)&&is_array($arrAuthorOrdersToPay))? count($arrAuthorOrdersToPay):"0";
		
		?>)</nobr></div>

   	  <div<? if ($submenu=="sold"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="Полностью оплаченные заказы, по которым вы получили деньги." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/salary_ok.png" width="16" height="16" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=paid_up">Выплачено</a> (<?	
		
		//колич. проданных заказов:
		echo(count($arrAuthorOrdersPaidUp)&&is_array($arrAuthorOrdersPaidUp))? count($arrAuthorOrdersPaidUp):"0";
		
        ?>)</nobr></div>
    </td>
<?
	if ($submenu) {
		
		$qSelCurrent="SELECT DISTINCT ri_worx.number, ri_worx.* FROM ri_basket, $ri_where
   AND ri_basket.work_id = ri_worx.number $worxFilter";
   		$all_worx=mysql_num_rows(mysql_query($qSelCurrent));
	}
	//ri_worx WHERE author_id = $_SESSION[S_USER_ID] $sel_work_type
	
	else $qSelCurrent="$qSelAll1"; 
	
	$qSelCurrent.="
LIMIT $limit_start, $limit_finish ";
	
	//echo "Последний запрос, с учётом лимита страниц: "; $catchErrors->select($qSelCurrent);
	$rSelCurrent=mysql_query($qSelCurrent); 
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelCurrent",$qSelCurrent);
	$row_currents=mysql_num_rows($rSelCurrent);?>    
    
    <td width="100%" valign="top" class="padding0" style="border-right:solid 1px #999;">
      <table cellspacing="0" cellpadding="0" height="100%" width="100%">
        <tr height="100%">
          <td><div<? //style="height:100%; overflow:auto"?>>
<?  //
	if ( $work_subject &&
		 $work_subject!=$Worx->setSearchPreString() //если поисковый запрос не является текстом заглушки
	   ) {
		$search_handler=true;
		$Worx->showSearchResultHeader(); 
	}      

function fieldToSendFile() {
		
		global $work_number;
		if ($test_table){?><table><? }?>

		<tr bgcolor="#CCCCCC">
          <td colspan="8">
            <table cellspacing="0" cellpadding="0">
              <tr>
                <td nowrap="nowrap" style="padding-left:56px;"><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_send.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Файл:&nbsp;</td>
                <td class="widthFull"><input name="work_<?=$work_number?>" type="file" class="widthFull" id="work_<?=$work_number?>" /></td>
              </tr>
            </table>
</td>
        </tr>

<?  if ($test_table){?></table><? }
}?>      
    	
        <? if ($test_table_start){?>{ ТАБЛИЦЫ С РАБОТАМИ... }<? }?>
        
	  <table width="100%" cellpadding="3" cellspacing="0" class="listingInTbl" id="tbl_current_works">
<?	//
	$i=0;
	if ($search_handler) {
		
		//если отбирали работы по типу, сформируем соответствующий массив:
		$skip_diplom_zakaz=true; //пропустим поиск в diplom_zakaz
		$arrAll=$Worx->findAllWorx( $work_subject,
								    $_REQUEST['work_type'], 
									false,
								    $arrDplomZakazIDsWithFiles,
								    $arr
								  );
		$all_worx=count($arr);
		
		if ($test_results){?><h4 class="padding0 Cambria">Результаты поиска:</h4><? }
		for ($rr=0;$rr<count($arr);$rr++) {
				
			$work_number=$arr[$rr]['item_id']; 
			
			$Worx->buildWorxTable(  $arr[$rr], 
									$work_number,
							 		$baskets_show,
							 		true
						   		  );?>

<?			if ($submenu=="to_send") fieldToSendFile();
			
			$i++;
		}
	}	//
	
	if ($all_worx>0) {

		//установим текущий лимит отображения записей на стр.:
		$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
		
		//echo "<tr><td colspan=7>limit_start= $limit_start<br>limit_finish= $limit_finish<br>all_worx= $all_worx<br>current_limit= $current_limit<hr>row_currents= $row_currents</td></tr>";
			
		if ($i<$current_limit&&$row_currents)
		while ($arr = mysql_fetch_assoc($rSelCurrent)) {
			$work_number=$arr['number']; 
			//получить строки с работами:
			$Worx->buildWorxTable(  $arr, 
									$work_number,
									$baskets_show,
									true
								  );
				
				if ($submenu=="to_send") fieldToSendFile();
				
			$i++;
		}
	}?>
	  </table>
      </div></td>
        </tr>
        <tr bgcolor="#EFEFEF" style="height:auto;">
          <td valign="top" class="paddingTop8">
            <div class="padding4">
              <input name="save" type="submit" value="Сохранить<? if ($submenu=="to_send"){?>/Отправить<? }?>" onClick="return checkPriceInt('tbl_current_works','work_price_');"></div>
            <div class="paddingTop4"><? $Blocks->makePagesNext($all_worx,$limit_finish);?></div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
	
}else{ //если загружали файлы?>
    
<!--<h5>Загрузка файлов &nbsp;|&nbsp; <a href="?menu=worx">Обзор работ</a></h5>-->

<table width="94%" cellpadding="10" cellspacing="0" class="iborder2 borderColorOrange">
  <tr class="userMenu">
    <td colspan="3"><h2 style="display:inline;"><img src="../images/exclame_warning.png" width="32" height="32" align="absmiddle" />ВНИМАНИЕ!</h2> &nbsp; [<a href="#" onClick="switchDisplay ('tbl_info');">свернуть/развернуть таблицу</a>]</td>
  </tr>
  <tr valign="top" id="tbl_info">
    <td><h4>1. Быстрая подготовка аннотаций</h4>      <?=$use_docs_reducer?></td>
    <td> <h4>2. Форматы загружаемых файлов
    </h4>
      <ul class="paddingBottom0">
      <li>Вы можете загружать файлы только форматов <strong>.doc</strong>, <strong>.docx</strong> и <strong>.rtf</strong>.  Файлы всех других форматов вы сможете отправить непосредственному заказчику позднее, после внесения им оплаты за заказ.</li>
      <li>Старайтесь не загружать сразу большой суммарный объём файлов, т.к. в случае медленной или прерывистой связи загрузка может прерваться</li>
    </ul>    </td>
    <td><h4>3. Проблемы при загрузке файлов
    </h4>
      <div class="paddingBottom10"><span class="txtRed">Если у вас возникают проблемы</span> с загрузкой файлов аннотаций, вы можете прислать их нам на <nobr><a href="mailto:sale@referats.info">sale@referats.info</a>,</nobr> и мы сделаем это за вас!</div>
      В этом случае обязательно сообщите нам емэйл, указанный вами при регистрации. 
    Программу для автоматической подготовки аннотаций вы можете скачать в разделе <a href="?menu=tools&amp;point=download">Инструменты.</a></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFF99" class="txt100"></td>
  </tr>
  </table><br>
<?
//если загружаем файлы...

	if (isset($_REQUEST['files_count'])) {
		$arrWType=array();
		$arrWPrice=array();
		$arrWArea=array();
		//
		$wdata=0;
		foreach ($_POST as $key=>$val) {
			//
			if ( strstr($key,"work_type") && //содержит тип работы
			     $key!="work_type"	//но не ячейку с типом работы по умолчанию
			   ) $arrWType[]=$val;
			if (strstr($key,"work_area")) $arrWArea[]=$val;
			if (strstr($key,"wprice_")&&!strstr($key,"customer")) $arrWPrice[]=$val;
			$wdata++;
			if (isset($_SESSION['TEST_MODE'])) echo "<div>\$wdata= $wdata, val[$key]= $val</div>";
		}
		if ($wdata) {
			
			$fmess="<table cellpadding='4' cellspacing='0' rules='rows'>";
			$i=0;
			foreach ($arrWType as $key=>$val) {
				
				if (isset($_SESSION['TEST_MODE'])) echo "<div>[arrWType(2)] val= $val</div>";
			
			$fmess.="\n  <tr>
    <td>$val</td>
    <td>$arrWArea[$i]</td>
    <td>$arrWPrice[$i] руб.</td>
  </tr>";
				$i++;
			}//echo "<br>fmess= $fmess";
			$fmess.="\n</table>";
			//$test_arrays=true;
			if ($test_arrays) {
				var_dump($arrWType); echo "<hr>";
				var_dump($arrWPrice); echo "<hr>";
				var_dump($arrWArea); echo "<hr>";
			} 
			
			//если ошибка при загрузке файлов:	
			if (!count($_FILES)) {

				foreach($_REQUEST as $key=>$val) $rqst.="$key=>$val\n";
			
				$subject="Ошибка при загрузке файлов автором  id $_SESSION[S_USER_ID] ($_SESSION[S_USER_NAME])";
				$message="ВНИМАНИЕ!\n
				\n
				Файлы не были размещены.
				\n
				Email Автора: $_SESSION[S_USER_LOGIN]
				\n
				Имя автора: $_SESSION[S_USER_NAME]
				\nДанные загрузки:
				\n
				\$_REQUEST: 
				\n
				$rqst
				\n
				\$_REQUEST: var_dump($_REQUEST)
				\n
				==================================================================================
				\n
				HTTP_REFERER :$_SERVER[HTTP_REFERER]
				\n
				================================================================
				\n
				HTTP_USER_AGENT: $_SERVER[HTTP_USER_AGENT]
				\n
				================================================================
				\n
				REQUEST_URI: $_SERVER[REQUEST_URI]
				\n
				================================================================
				\n
				SERVER_PROTOCOL: $_SERVER[SERVER_PROTOCOL]
				\n";
			
			}else{ //всё ОК
			
				$subject="Загрузка файлов автором id $_SESSION[S_USER_ID] ($_SESSION[S_USER_NAME])";
				$message="Размещаемые работы: <hr> $fmess";
			
			}
			//отправим админу сообщение о загрузке файлов:
			$Messages->sendEmail($toAddress,
								 $_SESSION['S_USER_LOGIN'],
								 $_SESSION['S_USER_LOGIN'],
								 $subject,
								 $message,
								 false //стандартный alert
								);
		}
		//$test_files=true;
		if ($test_files) 
			foreach ($_FILES as $key=>$arr){
				echo $key;
					foreach ($arr as $key=>$data)
						echo "<br>$key=> $data";
				echo "<hr>";
			}?>
 <div class='paddingLeft4 paddingBottom8'><strong>Загружены файлы (<?=count($_FILES)?>)</strong> &nbsp;[<a href="javascript:switchDisplay ('fuploaded');switchSwitcherText ('conceal','скрыть','отобразить')"><span id="conceal">скрыть</span></a> таблицу]:</div>   

<table id="fuploaded" cellspacing="0" cellpadding="4" class="iborder2 borderColorOrange" rules="rows">
  <tr class="bgF4FF bold">
    <td nowrap="nowrap">Тип работы</td>
    <td>Предмет</td>
    <td>Имя файла</td>
    <td>Цена</td>
  </tr>
	<?  //	
		$root=$_SESSION['DOC_ROOT']."/".$_SESSION['S_USER_ID'];
		$j=0;
		//размещаем файлы в директории автора:
		foreach ($_FILES as $kname=>$files_fields) { //если файл загружен при помощи HTTP POST:?>

  <tr valign="top">
    <td><?=$arrWType[$j]?></td>
    <td><?=$arrWArea[$j]?></td>
    <td><?	//echo "<br>[$kname]=> ".$files_fields; 
			//если обнаружили файл в списке загружаемых:
			if (is_uploaded_file($files_fields['tmp_name'])) {
				
				//будем проверять - а нет ли уже в указанной дмректории такого файла?
				$place_to_file_uploaded="$root/".$files_fields['name'];
				//$test_place=true;
				if ($test_place) {?>
                		
                        <div style='padding:4px;' class='iborder'>Место назначения загружаемого файла: <?=$place_to_file_uploaded?></div>
						
			<?  }
				//если такой файл уже есть - отменяем его загрузку.
				if (file_exists($place_to_file_uploaded)) {?>
                			
                        <DIV style='padding:4px'><h4>ОШИБКА!</h4>
						  <div style='color:red'>Файл с именем &laquo;<?=$files_fields['name']?>&raquo; не был загружен, т.к. уже существует в данной директории.
                          </div>
						</div>
				
			<?		$upload_error="double";
					
			    }else{ 	//Если не существует - 
					//закачиваем отсылаемый файл из временной директории в постоянную 
					//$block_upload=TRUE; //для тестирования
					if (!$block_upload) {
						//перемещаем файл из временной директории в целевую:
						$upld=move_uploaded_file($files_fields['tmp_name'],$place_to_file_uploaded);
						//если неудачно:
						if (!$upld) {?>
					
					<div class="padding4"><strong>ОШИБКА!</strong> 
                    	Файл <?=$files_fields['name']?> не размещён в директории <?=$place_to_file_uploaded?>.
                    </div>
					
			 <?				$upload_error="unplaced";
			 				$Messages->sendEmail($toAddress,
												 $_SESSION['S_USER_EMAIL'],
												 $_SESSION['S_USER_EMAIL'],
												 "SUBJECT",
												 "ТЕКСТ",
												 false //alert
												);
			      		}
					} 
					echo $arrWType[$i]; //ТИП загружаемого файла
				}
		    }else{ //если файл не загружен:
				
					$upload_error="unuploaded";	?>
				
            	<div class="padding10 iborder"><B class="txtRed">ОШИБКА!</B> Файл не загружен.
                <div>
                  <p>Причинами могут быть слишком большой объём загружаемых файлов и/или нестабильная связь. </p>
<p>Если эта ошибка повторяется регулярно, вы можете выслать нам аннотации своих работ по емэйлу sale@referats.info и 
<b>мы разместим их в вашем аккаунте сами</b>.</p>
      </div></div>
            	
		<?	}
		  	//если не было ошибок загрузки файла:
 		  	if (!$upload_error) {
				//var_dump($arrWType);echo "<hr>";var_dump($arrWArea);echo "<hr>";//var_dump($arrWPrice);
				//если всё ОК, добавляем запись в таблицу размещённых работ:
				$qIns="INSERT INTO ri_worx 
            ( author_id, 
              work_type, 
              work_name, 
              work_area, 
              work_price, 
              volume, 
              datatime 
            ) VALUES 
            ( $_SESSION[S_USER_ID], 
              '".$arrWType[$j]."', 
              '$files_fields[name]', 
              '".$arrWArea[$j]."', 
              '".$arrWPrice[$j]."', 
              '$_REQUEST[volume]', 
              '".date('Y-m-d H:i:s')."'
            )";
				$catchErrors->insert($qIns,1); 
		  	
			}else unset($upload_error); 
			
			$fname=$_SESSION['SITE_ROOT']."_download.php?author_id=$_SESSION[S_USER_ID]&amp;file_to_download=".rawurlencode($files_fields['name']);			
			//str_replace(" ","%20",$files_fields['name']);
			
		  ?><a href="<?=$fname?>"><? if($test_file_name){?>Имя файла...<? }?><?=$files_fields['name']
		  																								?></a></td>
    <td><?=$arrWPrice[$j]?></td>
  </tr>							
	<?		$j++;
	    }?>
</table><br />
<hr noshade size="1" />
		
<?	}?>
  <h3 class="paddingBottom10 paddingTop10"><img src="../images/flag.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Укажите пожалуйста, что вы будете загружать &#8212;</h3>
<p class="txt130">
  <input type="radio" name="volume" id="volume" value="full" onclick="document.getElementById('upload_content').style.display='block';" /> Файлы работ в полном объёме 
  <input type="radio" name="volume" id="volume" value="annotation" onclick="document.getElementById('upload_content').style.display='block';" />
Аннотации работ (ознакомительный вариант текста для заказчика)<img src="../images/info.png" width="17" height="17" hspace="4" align="absmiddle" title="Чтобы быстро подготовить аннотации ваших работ, используйте нашу программу DocsReducer&#8482;.<?="\n"?>Чтобы скачать программу, перейдите в раздел Инструменты->Скачать" onclick="alert(this.title);" /></p>
<p>Обратите внимание, что в обоих случаях заказчик сможет получить полный вариант вашей работы только после её полной оплаты, о чём вы будете незамедлительно проинформированы.</p>
<hr noshade />
<div id="upload_content" style="display:<?="none"?>;">
  
  <div class="paddingBottom6 paddingTop6">
<img src="../images/info-32.png" width="32" height="32" hspace="4" align="absmiddle" />Вы можете загрузить одновременно такое количество файлов, <b>общий суммарный объём которых не превышает <?
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $type="Г";
			break;
        case 'm':
            $type="M";
			break;
        case 'k':
            $type="К";
			break;
    }
	echo substr($val,0,strlen($val)-1)." {$type}б";
}
echo $val." ".return_bytes(ini_get('post_max_size')); ?>.</b></div>
<ol class="content">
  <li>Тип загружаемых работ: <span id="file_upload"><?
	//построим список типов работ:
	$Worx->buildWorxTypesList(' style="background-color:#FFFFCC;"',false,false); ?></span></li>
  <li class="paddingTop8">Количество загружаемых файлов: 
    <input name="files_count" type="text" id="files_count" size="1" />
    <!-- generateFilesFields() - в index.php-->
<input onClick="generateFilesFields();" type="button" name="files_array" id="files_array" value="    OK     " /></li>
</ol>
<hr color="#FFFFFF" />

<div id="file_uploading" class="iborder2 borderColorGray">
<div class="paddingBottom6">
	<table cellspacing="0" cellpadding="8" class="userMenu">
	  <tr>
	    <td valign="top"><strong><img src="../images/exclame_warning.png" width="32" height="32" /></strong></td>
	    <td class="txt100 paddingLeft0"><strong>ВАЖНО:</strong>
          <div class="txtRed t">Пожалуйста, удостоверьтесь, что ваши файлы имеют имена, соответствующие теме работы, т.к. в противном случае заказчик не сможет получить достоверного представления о её содержании!</div></td>
	    </tr>
	  </table>
	</div>
	<div class="padding8">Загружаемые файлы: &nbsp;
    					<strong>
						Тип работы, &nbsp;
                        Предмет, &nbsp;
                        Расположение, &nbsp;
                        Ваша цена работы, &nbsp;
                        Цена для заказчика</strong>.
	</div>
</div>
<div id="div_upl_button" class="paddingTop6 paddingLeft8" style="display:<? //"none";?>"><input name="upload_all_files" type="submit" value="Загрузить!" onClick="return checkPriceInt('file_uploading','wprice_');"></div>    
	
  </div>
    
</div><? echo "\n";
 }
