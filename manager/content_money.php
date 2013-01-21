<? //проверим подтверждение/отмену проводки в одиночном режиме:
//...и НЕ редактируем существующую проводку:
if ($_GET['payment_id']&&$action!="edit") {

	require_once("../classes/class.Customer.php");
	$Customer=new Customer;	

	$payment_id=$_GET['payment_id'];
	
	$qUpdPaymentStat="UPDATE ri_payments SET `payment_status` = ";
	//get id from ri_basket:
	$ri_basket_id=mysql_result(mysql_query("SELECT ri_basket_id FROM ri_payments WHERE number = $payment_id"),0,'ri_basket_id');
	//
	$where="WHERE `number` = $payment_id";
	//
	$qUpdPaymentStatCancel="$qUpdPaymentStat '0' $where";

	//удаляли собственный платёж:
	if ($action=="delete") {

		//удалить проводку:
		$catchErrors->delete("DELETE FROM ri_payments $where");
		//сбросить статус заказа:
		$catchErrors->update($qUpdPaymentStatCancel);
		//add statistics:
		$Actions->addStatRecord( "ri_payments",
								 $payment_id,
                            	 "delete", 
                            	 "manually", 
                            	 $initiator, //
                            	 $initiator_id //
						       );
	
	}else{ //подтверждали/отменяли проводку заказчика:
	
		if ($action=="apply") {
			
			$paid_stat='OK';
			$stat="подтверждена";
			//проверим и изменим сумму проводки:
			$where_payment_id=" WHERE number = $payment_id";
			//
			$qSelSmm="SELECT summ FROM ri_payments $where_payment_id";
			$rSelSmm=mysql_query($qSelSmm);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelSmm",$qSelSmm);
			
			//если передавали сумму, отличающуюся от текущей, изменим её значение в таблице:
			if ($_GET['summ']!=mysql_result($rSelSmm,0,'summ')) {
				
				$catchErrors->update("UPDATE ri_payments SET summ=$_GET[summ] $where_payment_id");
				//
				$Actions->addStatRecord( "ri_payments",
										 $payment_id,
										 "update", 
										 "manually", 
										 $initiator, //
										 $initiator_id //
									   );
				
			} 

			$payd_summ="<p>Сумма проводки: $_GET[summ] р.</p>";

		}else{ //отменяли проводку 
			
			$paid_stat='';
			$stat="отменена";
		
		}
		//обновить...:
		$catchErrors->update("$qUpdPaymentStat '$paid_stat' $where");
		
		//получить данные заказчика:
		$user_id=mysql_result(mysql_query("SELECT user_id FROM ri_basket WHERE number = $ri_basket_id"),0,'user_id');
		$Customer->getCustomerData($user_id,false);
		$customer_email=$Customer->customer_email;
		$customer_password=$Customer->customer_password;
		
		//
		$Messages->writeMessTbl (  $Customer->customer_name,
								   $ri_basket_id,
								   $customer_email,
								   $user_id,
								   "customer",
								   $comment_type,
								   "Изменение статуса проводки",
								   "Проводка денежных средств по заказу id $ri_basket_id $stat.
								   $payd_summ"
								);
		$mysql_insert_id=($_SESSION['TEST_MODE'])? 	mysql_result(mysql_query("SELECT number FROM ri_messages ORDER BY number DESC"),'0','number')+1:mysql_insert_id();
		//
		$Messages->sendEmail (  $customer_email,
						 		$fromAddress,
								$replyTo,
						 "Сообщение на Referats.info: Изменение статуса проводки.",
						 "Проводка денежных средств по вашему заказу id $ri_basket_id $stat.
						 $payd_summ
						 <p>Чтобы ответить на данное сообщение, пожалуйста, перейдите по <a href='".$_SESSION['SITE_ROOT'].$Messages->makeGatewayLink($customer_email,"customer",$customer_password)."&amp;answer_to=$mysql_insert_id'>ссылке</a>.</p>",
						 "Проводка $stat!"
					   		 );

	}
	//
	$Actions->addStatRecord( "ri_basket",
							 $ri_basket_id,
							 "update", 
							 "manually", 
							 $initiator, //
							 $initiator_id //
						   );
	//ВЫЯСНИТЬ соотношение цены работы и подтверждённых проводок.
	//если подтверждено не меньше - 
	  //если работа авторская - отправить ему извещение
	  //если компании - присвоить статус ri_basket.state = sent, что предоставляем заказчику доступ к файлам
	$Money->compareSumms($Worx->getWorkTable($ri_basket_id),$ri_basket_id);
	
} 
//если редактировали или добавляли проводку:

//																	handlePayment()
//							action									INSERT	UPDATE
//							add	edit	ri_basket_id	payment_id		
//Новый платёж по заказу	+			+							+	
//Новый платёж				+										+	
//Редактировать текущий			+		+				+					+

if ($action=="add"||$action=="edit") {
	
	if (isset($_REQUEST['payment_id'])) 
		$payment_id=$_REQUEST['payment_id'];
	
	if (isset($_REQUEST['payment_for_order_complete'])) 
		$Money->handlePayment($payment_id);
	elseif ($action=="edit") $Money->getPaymentData($payment_id);
	
	//построить таблицу с данными проводки:	
	//echo "<div>paymentAllDataTable STARTS</div>";
	$Money->paymentAllDataTable($payment_id,false);

}else{ ?>

<table width="100%"<? if(!$order_id){?> height="100%"<? }?> cellpadding="0" cellspacing="0" id="tbl_payments">
<?
	if ($order_id||$_REQUEST['customer_id']) {?>    
  <tr style="height:auto;">
      <td colspan="2" nowrap="nowrap" class="padding4 paddingTop0"><?

	if ($order_id) $Worx->filterByOrder($order_id);
	elseif (isset($_REQUEST['customer_id'])) {
		//
		$user_id=$_REQUEST['customer_id'];
		//$Worx->dropFilterPayment();
		//отображаем результаты фильтра и ссылку сброса:
		$Blocks->showFilterResults( "payments", 	//тип полученных объектов
								  false,			//объект, по которому фильтровали
								  false,		//...его id...
								  "customer",		//если фильтровали по Заказчику/Сотруднику/Автору
								  $_REQUEST['customer_id']	//...его id...
								);

		//внимание! $user_id далее не должен быть использован!
	} ?></td>
  </tr>
<? }?>  
  <tr<? if(!$order_id){?> style="height:auto;"<? }?> bgcolor="#F5F5F5">
	<td nowrap="nowrap" class="tblHeaderCellLeft"><input name="allBoxes" type="checkbox" disabled title="Отметить/разотметить всех" style="margin:0; padding:0;">
        <a href="?menu=money&amp;sort_money=<?

		$_SESSION['S_SORT_MONEY']=(!$_REQUEST['sort_money'])? "DESC":$_REQUEST['sort_money'];
		echo ($_SESSION['S_SORT_MONEY']=="DESC")? "ASC":"DESC";
		
		?>" title="Пересортировать по номеру проводки"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" border="0" align="middle" /></a>id,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />id, 
        <img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />id,
         <img src="<?=$_SESSION['SITE_ROOT']?>images/calendar_clock.gif" width="19" height="15" hspace="4" border="0" align="absmiddle" />Дата/Время,  <img src="<?=$_SESSION['SITE_ROOT']?>images/calendar.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" />Дата,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest_question.png" width="16" height="16" hspace="4" border="0" align="absmiddle" /><span class="noBold"><img src="<?=$_SESSION['SITE_ROOT']?>images/change.png" width="16" height="16" align="absmiddle" title="Статус платежа может быть изменён" /></span> Статус,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/payout_choice.png" width="20" height="16" hspace="4" border="0" align="absmiddle" />Способ,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/pay_in.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Сумма,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="18" hspace="4" border="0" align="absmiddle" />Заказчик,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Автор проводки,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/comment2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Комментарий
        </td>
	<td align="right" nowrap="nowrap" class="tblHeaderCellRight" id="right_boundary"><a href="?menu=mone&amp;action=add" title="Добавить проводку..."><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />...</a></td>
  </tr>
  <tr<? if(!$order_id){?> height="100%"<? }?>>
    <td colspan="3" valign="top">
      <div style="height:100%; overflow:auto;"><?
//if filter by order:
if ($order_id) $and_ri_basket_id="
   AND ri_basket_id = $order_id";

if (isset($_REQUEST['customer_id'])) $filter_by_customer="
   AND user_id = $_REQUEST[customer_id]";

//извлечём массив данных:
$qSel="SELECT * FROM ri_payments, ri_basket
  WHERE ri_basket_id = ri_basket.number $and_ri_basket_id $filter_by_customer
ORDER BY ri_payments.number ".$_SESSION['S_SORT_MONEY'];
//$catchErrors->select($qSel); 
$rSel=mysql_query($qSel); 
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);?>
      <table width="100%" cellpadding="4" cellspacing="0" rules="rows">
<? $i=0;
while ($arr = mysql_fetch_assoc($rSel)) {
		$payment_id=mysql_result($rSel,$i,'ri_payments.number');?> 
  		
        <tr>
    	  <td class="cell_pay_box"><input type="checkbox" name="payment_<?=$payment_id?>" id="payment_<?=$payment_id?>" value="<?=$payment_id?>"<?
    
	if ($arr[$email]) {?> title="<?=$arr[$email]?>"<? }?>></td>
      	 
          <td align="right"><? echo $payment_id;?><a href="?menu=mone&amp;action=edit&amp;payment_id=<?=$payment_id?>" title="Редактировать данные проводки"><? if ($test_) {?>number<? } ?><img src="<?=$_SESSION['SITE_ROOT']?>images/edit.gif" width="16" height="14" hspace="4" border="0" align="absmiddle" /></a></td>
          <td align="right" nowrap="nowrap" class="paddingBottom0 paddingTop0"><a href="?menu=money&amp;order_id=<?=$arr['number']?>" title="Отфильтровать проводки по заказу"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" /><? if ($test_order_id){?>order_id<? }?><?=$arr['number']?></a></td>
          <td class="paddingLeft0"><a href="?menu=messages&amp;action=compose&amp;order_id=<?=$arr['number']?>" title="Отправить сообщение по заказу..."><img src="<?=$_SESSION['SITE_ROOT']?>images/envelope_small.png" width="14" height="10" border="0" /></a></td>
          <td align="right" nowrap="nowrap" class="bgGrayLightFBFBFB"><a href="?menu=money&amp;work_id=<?=$arr['work_id']?>" title="Отфильтровать проводки по заказу"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" border="0" align="absmiddle" /><? if ($test_) {?>work_id<? }  
		
		echo $arr['work_id'];
		
		 ?></a></td>
          <td nowrap="nowrap"><a href="?menu=money&amp;filter_date=<?=$payment_id?>" title="Отфильтровать по дате проводки"><? if ($test_) {?>Дата/Время проводки<? }  

		echo $Tools->ddmmyyyy($arr['datatime']);
		
		 ?></a> <?=$Tools->hms($arr['datatime'])?></td>
         
          <td nowrap="nowrap"><? if ($test_) {?>Дата платежа<? }  
		
		$Tools->dtime($arr['payment_date']);
		
		 ?></td>
         
          <td align="center"><a href="<?
         if ($arr['payment_status']!=="OK"){?>#" onClick="applyPayment(<?=$payment_id?><? if ($order_id) echo ",$order_id";?>);" title="Не подтверждён.<?="\n"?>Подтвердить платёж."><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" border="0" />
            <?
		 }else{ 
		 
		 	$action=($arr['recorder_type']=="customer")? "cancel":"delete";
			
			echo "?menu=mone&amp;action=$action&amp;payment_id=$payment_id\" title=\"";
		 	
			if ($arr['recorder_type']=="customer") {
				echo "Подтверждён.\nВернуть статус неподтверждённого.\">";?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" border="0" /><?
			}else{
				echo "Проведён сотрудником.\nУДАЛИТЬ проводку.\">";?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_blue.png" width="16" height="16" border="0" /><?
			}?>
            
            <? }?>
          </a></td>
          <td nowrap="nowrap" class="bgGrayLightFBFBFB"><a href="?menu=money&amp;filter_payment_method=<?=$arr['payment_method']?>" title="Отфильтровать проводки по способу оплаты"><? if ($test_) {?>payment_method<? }  
		
		echo $arr['payment_method'];
		
		 ?></a></td>
         
          <td class="cell_pay"><input name="summ_<?=$payment_id?>" type="text" id="summ_<?=$payment_id?>" size="3" value="<?=$arr['summ']?>"><? if ($test_) {?>Сумма<? }  
		
		 ?></td>
         
          <td class="bgGrayLightFBFBFB"><a href="?menu=money&amp;customer_id=<?=$arr['user_id']?>" title="Отфильтровать проводки по заказчику"><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle" /><? if ($test_) {?>Заказчик<? } ?></a><a href="?menu=messages&amp;action=compose&amp;mailto=customer&amp;user_id=<?=$arr['user_id']?>" title="Отправить сообщение заказчику"><? 
		  
		  echo mysql_result(mysql_query("SELECT email FROM ri_customer WHERE number = ".$arr['user_id']),0,'email');
		  
		  ?></a></td>
         
          <td><? if ($test_) {?>recorder_type<? }  $Money->showRecorderType($arr['recorder_type'],false);?></td>
         
          <td width="100%"><? if ($test_) {?>payment_note<? }  
		
		echo $arr['payment_note'];
		
		 ?></td>
         <?  /*?>
          <td width="100%"><a href="?menu=money&amp;payment_id=<?=$payment_id?>" title="Редактировать..."><?
         
		 echo $arr['paid'];
		 
		 ?></a></td>
         <? */ ?>
          </tr>

<?		$i++;
    }?>
	  </table></div>
    </td>
  </tr>
  <tr<? if(!$order_id){?> style="height:auto;"<? }?>>
    <td height="30" colspan="3" class="paddingTop6"><input type="submit" value="Подтвердить!"> 
      &nbsp; <img src="<?=$_SESSION['SITE_ROOT']?>images/lamp2.png" width="20" height="20" hspace="4" align="absmiddle" />Подтвердит проводки со статусом &laquo;Неподтверждённые&raquo;  и изменит сумму (если вы её отредактировали).</td>
  </tr>  
</table>
<?
}?>