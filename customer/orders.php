<?
//если удаляем платёж/заказ или восстанавливаем заказ:
if ( $_REQUEST['del_payment'] ||
	 $_REQUEST['del_order'] ||
	 $_REQUEST['repair_order']
   ) {

	//удаляем платёж/заказ:
	if ($_REQUEST['del_payment'] || $_REQUEST['del_order']) {

		//id заказа:
		$del_payment=$_REQUEST['del_payment'];
		//id заказа:
		$del_order=$_REQUEST['del_order'];
		//инициируем сообщение админу:
		$mess_sbj="Удаление ";
		
		//
		$del_num=($del_payment)? $del_payment:$del_order;
		//
		//$Money->getPayments($del_num);
		$payment_number=$del_num;
		$summ=$Money->summ;
		
		//если удаляем платёж:
		if ($del_payment) {
	
			//для статистики:
			$qSel="SELECT number FROM ri_payments  WHERE `ri_basket_id` = $del_payment"; 
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
			if (mysql_num_rows($rSel)) $record_id=mysql_result($rSel,0,'number');
			
			//удаляем запись проводки:
			$qDel="DELETE FROM ri_payments WHERE `ri_basket_id` = $del_payment";
			$catchErrors->delete($qDel);


			//add statistics:
			$Actions->addStatRecord( "ri_payments",
									 $record_id,
									 "delete", 
									 "manually", 
									 "customer", //
									 $_SESSION['S_USER_ID'] //
								   );
	
			//обновляем статус оплаты в ri_basket:
			/*$qUpd="UPDATE ri_basket SET `paid` = '0' WHERE number = $del_payment";
			$catchErrors->update($qUpd);
			
			//add statistics:
			$Actions->addStatRecord( "ri_basket",
									 $del_payment,
									 "update", 
									 "manually", 
									 "customer", //
									 $_SESSION['S_USER_ID'] //
								   );*/
	
			$mess_sbj.="платежа # $payment_number ";
			$alert="Проводка удалена!";
		}
	
		//если удаляем заказ:
		if ($del_order) {
	
			//проверить, оплачено ли. 
			//Если да, удалим только платёж и отметим состояние заказа, как удалённого, зам заказ не удалим:
			if ($summ){
				
				//обновляем статус заказа в ri_basket:
				$qUpd="UPDATE ri_basket SET `status` = 'del' WHERE number = $del_order";
				$catchErrors->update($qUpd);
							
				//add statistics:
				$Actions->addStatRecord( "ri_basket",
										 $del_order,
										 "update", 
										 "manually", 
										 "customer", //
										 $_SESSION['S_USER_ID'] //
									   );

			}else{
	
				//удаляем запись из ri_basket:
				$qDel="DELETE FROM ri_basket WHERE number = $del_order";
				$catchErrors->delete($qDel);

				//add statistics:
				$Actions->addStatRecord( "ri_basket",
										 $del_order,
										 "delete", 
										 "manually", 
										 "customer", //
										 $_SESSION['S_USER_ID'] //
									   );
		
			}
	
			$mess_sbj.="заказа id $del_order";
			$alert="Заказ удалён!";
		}
	
		$order_id=$del_num; //для извлечения данных для сообщения админу
		
	}else{ //восстанавливаем

		$order_id=$_REQUEST['repair_order'];
		//обновляем статус заказа в ri_basket:
		$qUpd="UPDATE ri_basket SET `status` = 'reborn', datatime = '".date('Y-m-d H:i:s')."' WHERE number = $order_id";
		$catchErrors->update($qUpd);

		//add statistics:
		$Actions->addStatRecord( "ri_basket",
								 $order_id,
								 "update", 
								 "manually", 
								 "customer", //
								 $_SESSION['S_USER_ID'] //
							   );

		$alert="Заказ восстановлен!";	
		//инициируем тему сообщения админу:
		$mess_sbj="Восстановление заказа ";
			
	}

	//ПОЛУЧИТЬ название работы:
	$qSel="SELECT work_table, work_id FROM ri_basket WHERE number = $order_id"; 
	$rSel=mysql_query($qSel);
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
	//$catchErrors->select($qSel);
	//будем получать название работы/файла:
	if (mysql_num_rows($rSel)) {
		$table=mysql_result($rSel,0,'work_table');
		$qSel="SELECT ";
		//
		$wsbj=($table=="diplom_zakaz")? "subject":"work_name";
		$qSel.=" $wsbj FROM $table WHERE number = ".mysql_result($rSel,0,'work_id');
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		$work_name=mysql_result($rSel,0,$wsbj);
		//$catchErrors->select($qSel);
	}
		
	$mess_text="<p>id заказа (ri_basket.number): $order_id</p>
		  <p>Название/файл: $work_name</p>";
	if ($summ) $mess_text.="<p>Сумма: $summ</p>";

	//отправить извещение админу:
	$Messages->sendEmail($toAddress,
						 $_SESSION['S_USER_EMAIL'],
						 $_SESSION['S_USER_EMAIL'],
						 $mess_sbj." заказчиком $_SESSION[S_USER_EMAIL] (USER id: $_SESSION[S_USER_ID])",
						 $mess_text,
						 false //стандартный alert
						);

	$Messages->alertReload($alert,"?section=customer&mode=orders");
}?>

<script type="text/javascript">
function showPayments(order_id,to_do,table,work_native_id) { 
	var dspl,inn;
	if (to_do=="close") {
		//dspl="none";
		inn="";
	}else{
		//dspl="block";
		inn='<iframe src="<?=$_SESSION['SITE_ROOT']?>customer/pay.php?order_id='+order_id+'&table='+table+'&work_native_id='+work_native_id+'&mode='+to_do+'" style="width:100%; height:220px; border:none; overflow:hidden;" frameborder="0" marginheight="0" marginwidth="0"></iframe>';
	}
	document.getElementById('t_'+order_id).style.height='';
	document.getElementById('w_'+order_id).innerHTML=inn;
}
</script>

<!--<style>
table#tbl_customer img { border-color:#FFF; }#FC0;
</style>-->
<table border="0" cellspacing="0" class="iborder" id="tbl_customer">
  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale cellPassive bold" id="first">
    <td align="center" style="cursor:default;" title="id заказа"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle_inverted.png" /></td>
    <td title="Текущее состояние заказа">Сост.</td>
    <td>Тема/Файл</td>
    <td nowrap="nowrap">Тип работы</td>
    <td>Предмет</td>
    <td align="center">Цена</td>
    <td align="center">Оплата</td>
    <td align="center"><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" hspace="2" align="absmiddle" title="Подтверждённая сумма" /></td>
    <td align="center">Действия</td>
  </tr>

<?
//
while ($arrWx = mysql_fetch_assoc($rSel)) { //echo "<div>REC</div>"; 
	
	if ($arrWx['work_table']=="diplom_zakaz") {
		//достаём работы из diplom_zakaz:
//		$qSel2="SELECT subject, 
//       diplom_worx_topix.predmet, 
//       typework 
//  FROM diplom_zakaz, diplom_worx_topix 
// WHERE diplom_zakaz.predmet = diplom_worx_topix.number 
//   AND diplom_zakaz.number = ".$arrWx['work_id'];
		$qSel2="SELECT subject, 
       diplom_zakaz.predmet, 
       typework 
  FROM diplom_zakaz 
 WHERE diplom_zakaz.number = ".$arrWx['work_id'];
		//$catchErrors->select($qSel2,1);
   
   		$wname="subject";
   		$wtype="typework";
   		//предмет нужно получать отдельно:
		$qSel3="SELECT predmet
  FROM diplom_worx_topix 
 WHERE number = ".mysql_result(mysql_query($qSel2),0,'predmet');
		$rPredmet=mysql_query($qSel3);
		//$catchErrors->select($qSel3,1);
		if (mysql_num_rows($rPredmet)) $warea=mysql_result($rPredmet,0,'predmet');
		//echo "<div>= $arrWx[work_id]</div>";
	
	}else{ //иначе - из ri_worx:
		
		//извлечём массив данных:
		$qSel2="SELECT work_name,
	   work_type,
	   work_area
FROM ri_worx
  WHERE number = ".$arrWx['work_id'];
   		$wname="work_name";
   		$wtype="work_type";
		//$catchErrors->select($qSel2,1);
		$rPredmet=mysql_query($qSel2);
   		if (mysql_num_rows($rPredmet)) $warea=mysql_result($rPredmet,0,'work_area');
		//"work_area";
		//echo "<div>= $arrWx[work_id]</div>";
	}
	$rSel2=mysql_query($qSel2); 
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel2",$qSel2);
	$all_orders=mysql_num_rows($rSel2); 
	if ($all_orders) {?> 
  <tr class="borderTop1">
    <td align="right"><?=$arrWx['number']?></td>
    <td align="center"<?

				unset($go_download);
	 
	if ($arrWx['status']=="del") {?>><img title="Заказ удалён" src="<?=$_SESSION['SITE_ROOT']?>images/order_deleted.png" hspace="4" border="0" align="absmiddle" /><? 
	
	}else{ 		

		$work_price=$Worx->calculateWorkPrice($arrWx['work_table'],$arrWx['work_id'],false);
		$all_summ=$Money->allPaymentsInbox($arrWx['number']);
		//получим сумму всех ПОДТВЕРЖДЁННЫХ входящих платежей по заказу
		$all_summ2=$Money->allPaymentsInbox($arrWx['number'],true);
		//выяснить статус отсылки работы:
		if ($work_price&&$all_summ2>=$work_price){
			
			if ($arrWx['state']!="sent"){ 
			
			echo ">";?><img title="Ожидается доставка" src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" /><?	
			
			}else{
			 	
				if ($arrWx['work_table']=="ri_worx") {
					$ttl="Работа доставлена";
					$img="arrow_up_send.png";
				}else {
					$ttl="Открыт доступ к скачиванию файлов";
					$img="open.png";
					$go_download=true;
				}
				echo ">";?><img title="<?=$ttl?>" src="<?=$_SESSION['SITE_ROOT']?>images/<?=$img?>" width="16" height="16" /><?		
			}
    	}else { echo ">";?><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest.png" width="20" height="15" title="Ожидается полная оплата заказа..." /><? }
		
	}?></td>
    <td<? if ($arrWx['status']=="del"){?> class="txtRed"<? }?>><? if ($go_download){?><a href="?work_table=diplom_zakaz&work_id=<?
	echo $arrWx['work_id']; if($go_download){?>&order_sent_id=<? echo $arrWx['number']; }?>" title="Скачать файлы"><? }echo mysql_result($rSel2,0,$wname); if ($go_download){?></a><? }?></td>
    <td><?=mysql_result($rSel2,0,$wtype)?></td>
    <td><?=($warea)? $warea:"?"?></td>
    <td align="right"><?
	
	echo $work_price;
	
	?></td>
    <td align="right" nowrap="nowrap"><a href="?section=customer&mode=payments&order_id=<?=$arrWx['number']?>" title="Загрузить статистику проводок по заказу"><?
    
	//пропишем сумму всех входящих платежей по заказу
	echo $all_summ;
	
	?></a></td>
    <td align="right" nowrap="nowrap"><?
    
	if ($all_summ2!=$all_summ){?><span class="txtRed"><?=$all_summ2?></span><? }
	else echo $all_summ2;	
	
	?></td>
    <td align="center" nowrap="nowrap"><? 
		/*		
		if ($arrWx['paid']==2){
	
			?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" hspace="2" align="absmiddle" title="Полностью оплачено" /><? 
	
		}else{
			
			if ($arrWx['paid']) {
	
				?><a href="#" onClick="showPayments(<?=$arrWx['number']?>,'show','<?=$arrWx['work_table']?>','<?=$arrWx['work_id']?>');return false;" title="Загрузить раздел проводок по закаузу"><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_gray.gif" width="16" height="16" hspace="2" border="0" align="absmiddle" title="Оплачено, не подтверждено;<?="\nЩёлкните, чтобы отредактировать проводку."?>" /></a><? 
			
			}else{
			
				?><a href="#" onClick="showPayments(<?=$arrWx['number']?>,'make','<?=$arrWx['work_table']?>','<?=$arrWx['work_id']?>');return false;"><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_disabled.png" width="16" height="16" hspace="2" border="0" align="absmiddle" title="Не оплачено;<?="\n"?>Щёлкните, чтобы провести оплату..." /></a><? 
			
			}
		}<!--<a href="#" onClick="showPayments(<?=$arrWx['number']?>,'add','<?=$arrWx['work_table']?>','<?=$arrWx['work_id']?>');return false;" title="Добавить проводку по заказу">-->
		*/
		?><a href="#" onClick="showPayments(<?=$arrWx['number']?>,'make','<?=$arrWx['work_table']?>','<?=$arrWx['work_id']?>');return false;" title="Добавить проводку по заказу"><img src="<?=$_SESSION['SITE_ROOT']?>images/payment_plus.png" width="22" height="15" border="0" align="absmiddle" /></a><? 
		
		/*if ($arrWx['paid']==1){?><a href="?section=customer&mode=orders&del_payment=<?=$arrWx['number']?>" title="Удалить проводку"><img src="<?=$_SESSION['SITE_ROOT']?>images/payment_cancel.png" border="0" align="absmiddle" /></a><? 
		
   		}else{?><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="16" height="16" align="absmiddle" /><? }*/?>
   <a href="#message_start" onClick="addOrderNote('order',<?=$arrWx['number']?>);" title="Отправить сообщение по заказу"><img src="<?=$_SESSION['SITE_ROOT']?>images/mess_new.gif" width="17" height="16" hspace="2" border="0" align="absmiddle" /></a>
<? //
   if ($arrWx['status']=="del"){?>
    <a href="?section=customer&mode=orders&repair_order=<?=$arrWx['number']?>" title="Восстановить заказ"><img src="<?=$_SESSION['SITE_ROOT']?>images/redo.gif" width="16" height="16" border="0" align="absmiddle" /></a>
<? }else{?>    
    <a href="?section=customer&mode=orders&del_order=<?=$arrWx['number']?>" title="Удалить заказ"><img src="<?=$_SESSION['SITE_ROOT']?>images/order_deleted.png" border="0" align="absmiddle" /></a><?
   }?></td>
  </tr>
  <tr id="t_<?=$arrWx['number']?>" style="height:0px;">
  	 <td width="100%" colspan="9" id="w_<?=$arrWx['number']?>" class="padding0"><?
	if ($_REQUEST['add_payment']&&$_REQUEST['add_payment']==$arrWx['work_id']) {?><script type="text/javascript">

	showPayments(<?=$arrWx['number']?>,'make','<?=$arrWx['work_table']?>','<?=$arrWx['work_id']?>');

</script><?
	}//echo "<div>\$_REQUEST[add_payment]= $_REQUEST[add_payment], \$arrWx[work_id]= $arrWx[work_id]</div>";?></td>
  </tr>
<? 		    
  	}
	//$test_q=true;
	if ($test_q){?><tr><td colspan="8">(<?=$all_orders?>) <hr><pre><?=$qSel2?></pre></td></tr><? }
}
if (!$all_orders){?><tr><td colspan="8" style="padding:14px !important;">У вас нет заказов. Щёлкните кнопку &laquo;Новый заказ...&raquo;, чтобы выбрать работу.</td></tr><? }
?>
</table>
<div class="paddingTop6"><input name="add_worx" type="button" value="Новый заказ..." onClick="location.href='index.php?mode=skachat-rabotu&filter=free_only'"></div>
