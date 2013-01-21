<? //echo $_REQUEST['menu'];?>
<table width="100%"<? //height="100%"?> cellspacing="0" cellpadding="0">
  <tr<? //height="100%"?>>
    <td width="40%">
      
      <div<? //style="height:100%; overflow:auto;"?>>
      
   		<table border="0" cellpadding="4" cellspacing="0">
          <tr bgcolor="#FFFF33">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><a href="?menu=worx&amp;submenu=to_send"><img src="../images/flag.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />Заказы к отправке:</a></h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? 
			
	//все РАБОТЫ автора:
	//все его ЗАКАЗЫ:
	//$author_id=$_SESSION['S_USER_ID']; echo "<div>author_id= $author_id, S_USER_ID= $_SESSION[S_USER_ID]</div>";
	$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']));
	//
	if (count($arrAuthorOrders)) {
		$arrAllAuthorsOrdersIDsToSend=array();
		//
		foreach ($arrAuthorOrders as $order_id) {
			
			//для выбранной работы в ri_worx:
			//сумма к оплате:
			$to_pay=$Worx->calculateLocalPrice($Worx->getWorkID($order_id)); 
			//оплачено и подтверждено:
			$paidOK=$Money->allPaymentsInbox($order_id,true); //echo " paidOK= $paidOK";
			$paidPartly=$Money->allPaymentsInbox($order_id);
			
			//получим СУММЫ: 
			if ($to_pay&&$paidOK>=$to_pay&&!$Worx->getWorkSent($order_id)) $arrAllAuthorsOrdersIDsToSend[]=$order_id;
			 //echo "</div><br>"; 
		} 
		//
		if (count($arrAllAuthorsOrdersIDsToSend)) {
			
			$arrWorxToSend=$Worx->convertArrOrdersIDsToWorxIDs($arrAllAuthorsOrdersIDsToSend);
			$all_to_send=count($arrWorxToSend);
		}
	} echo ($all_to_send)? $all_to_send:"0";
	
			?></td>
            <td bgcolor="#FFFFFF">Полностью оплаченные заказчиками работы. Вы должны отправить их как можно скорее!</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFE3FF">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />Новые заказы:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_orders)? $new_orders:"0";?></td>
            <td bgcolor="#FFFFFF">Заказы на ваши работы, появившиеся с момента последней загрузки менеджера.</td>
          </tr>
          <!--<tr>
		<td>Новые</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Все отложенные</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Неоплаченные</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#EAF8F8">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/mails.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" />Новые <a<? // href="?menu=messages"?>>сообщения</a>:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_messages)? $new_messages:"0";?></td>
            <td bgcolor="#FFFFFF">Новые входящие сообщения, появившиеся с момента последней загрузки менеджера.</td>
          </tr>
          <!--<tr>
            <td>Новые</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Непрочтённые</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#E3FFE3">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/pay_in.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Новые <a<? // href="?menu=money"?>>выплаты</a>:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_payouts)? $new_payouts:"0";?></td>
            <td bgcolor="#FFFFFF">Новые выплаты за проданные работы, являющиеся вашей интеллектуально собственностью.</td>
          </tr>
          <!--<tr>
            <td>Количество</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Сумма</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
	    </table>

      </div>
    
    </td>
    
    <td width="60%" rowspan="2" valign="top" class="paddingLeft8 paddingRight10">
      <table cellspacing="0" cellpadding="0"<? //height="100%"?>>
        <tr style="height:auto;">
          <td><h4 class="padding0"><img src="../images/info-32.png" width="32" height="32" hspace="10" align="absmiddle" />ВНИМАНИЕ!</h4>
          <div class="txt110 padding10 paddingLeft10 paddingBottom20"><?=$use_docs_reducer?></div></td>
        </tr>
        <tr style="height:auto;">
          <td><h4 class="padding0 paddingBottom6"><img src="<?=$_SESSION['SITE_ROOT']?>images/lamp2.png" width="20" height="20" align="absmiddle" />Справка по разделам аккаунта.</h4></td>
        </tr>
        <tr<? //height="100%"?>>
          <td><div<? //style="height:100%; overflow:auto"?>>
        <table height="100%" cellspacing="0" cellpadding="4" class="iborder" rules="rows" style="border-color:#CCC;">
<? 
$arrMenusColors=array('FFE3FF','E3FFE3','EAF8F8','FFFF99','CCCCFF','EFEFEF','CCFFFF');
$clr=-1; //т.к. далее первая итерация будет пропущена.
//class.Blocks
foreach($arrMenus as $point=>$menu) {
	if ($point!="default"){?>
      <tr valign="top" style="height:auto;">
        <td bgcolor="<? echo "#".$arrMenusColors[$clr];?>"><a href="?menu=<?=$point?>" class="bold"><?=$menu?></a></td>
        <td width="100%"><?
    
		switch($point) { 
			
			case "worx":?><div>
				<p>Раздел, содержащий всю статистику ваших работ &#8212; названия, отчёты о продажах и текущем состоянии каждой работы. Списки можно формировать по нескольким критериям. </p>
				<ol class="content">
				  <li>По типам работ &#8212; дипломные, курсовые, рефераты и проч.</li>
				  <li>По состоянию заказов:</li>
				  <div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=unpaid">Неоплаченные</a> &#8212; отложенные заказчиками в корзину заказов, но без внесения предоплаты.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_partly">Предоплаченные</a> &#8212; не полностью оплаченные заказчиками.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=to_pay">К выплате</a> &#8212; проданные заказчикам, но по которым торговая площадка Referats.info с вами ещё не расчиталась.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/salary_ok.png" width="16" height="16" hspace="4" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_up">Выплачено</a> &#8212; те, по которым вы получили выплаты в полном объёме.</div>
				</ol>
				<p>Также раздел позволяет вам <strong><a href="?menu=worx&amp;submenu=upload"><img src="../images/arrow_up_send.png" width="16" height="16" hspace="4" border="0" />загрузить новые работы</a></strong> и выставить их на продажу. </p></div><? break;
			case "money":?><div>Статистика расчётов за проданные работы с торговой площадкой Referats.info.</div><? break;
			case "messages":?><div>История сообщений между вами и администрацией торговой площадки. </div><? break;
			case "data":?><div>Ваши регистрационные данные &#8212; просмотр и редактирование. </div><? break;	
			case "tools":?>
				<div>Программа автоматической подготовки файлов работ к размещению на нашей торговой площадке (<a href="?menu=tools&amp;point=howitworks">DocsReducer&#8482;</a>). </div><? break;
			case "faq":?><div>Список наиболее актуальных вопросов и ответов на них. </div><? break;
			case "author_agreement":?><div>Пользовательское соглашение между нашей торговой площадкой и вами, как собственником творческих работ.</div><? break;	
			case "feedback":?><div>Обратная связь с администрацией проекта. </div><? break;	
		}
	?></td>
      </tr>
<? } $clr++;
}?>
         <tr height="100%" style="visibility:hidden;">
           <td colspan="2" style="visibility:hidden;">&nbsp;</td>
         </tr>
    	</table>
      
      </div></td>
        </tr>
      </table>

      
    </td>

  </tr>
  <tr style="height:auto;">
    <td bgcolor="#EAF8F8"><? Messages::composeNewMail();?>
	</td>
  </tr>
</table>

