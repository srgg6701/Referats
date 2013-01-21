<?
class Orders {

public $all_orders_exists;//����� ���������� �������
//������� �������:
public $arrAllOrders; //���
public $arrAuthorOrders; //���������
public $arrOrdersUnpaid; //...�� ������� �� ���� �� ����� ��������
public $arrOrdersPaidNoPrice; //...��� ����, �� � ����������
public $arrOrdersPaidPartly; //...���������� ��������
public $arrOrdersPaidNotSent; //...��������� ����������, �� �� ����������
public $arrOrdersPaidSent; //...���������� ��������� ��� �������� ��� ����������
public $arrOrdersToPay; //...�� ������� ������ ���� ������� ������
public $arrOrdersPaidUp; //��������� ����������� �������
### ������:
public $arrOrdersPaidFull; //...���������� ���������
public $arrOrdersPaid; //***...�� ������� ���� �������� (�� ����������� �������������)

	
	function buildOrdersTable() {
		
		global $Blocks;
		global $catchErrors;
		global $Money;
		global $Tools;
		global $Worx;
		
		$order_status=($_REQUEST['order_status'])? $_REQUEST['order_status']:"paid_notsent";
		if (isset($_REQUEST['work_id'])) $work_id=$Tools->clearToIntegerAndStop($_REQUEST['work_id']);
		
		//���� ������������� �����, ����� ���������� ��� ������:
		if ($_SESSION['S_USER_TYPE']=="author") {
			
			global $Author;
			
			//if (isset($_SESSION['TEST_MODE'])) echo "<div>method buildOrdersTable</div>";
			$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']));
			$this->arrAuthorOrders=$arrAuthorOrders;
			
			if ($arrAuthorOrders) {
				//��� ������� ��������:
				$inAuthorOrdersPayment=" WHERE ri_basket_id IN (".implode(",",$arrAuthorOrders).")";
				//��� ������� �������:
				$inAuthorOrders=" WHERE number IN (".implode(",",$arrAuthorOrders).")";
			}
		}
		
		########################################
		//������� ������ �������:
		  //unpaid/			�� �������
		  //paid_partly/	������� �� ���������
		  //paid_notsent/	������� ���������, �� �������
		  //paid_sent/		������� � �������
		//$arrOrdersAll=array();//��� ������
		$arrRiBasketSumms=array();//����� ������� �� �������
		//��� ������, �� ������� ���� ��������:
		$arrOrdersPaid=array();
		//��� ������ ��� ���� �� ������� ���� ��������:
		$arrOrdersPaidNoPrice=array();
		//��� ������, ���������� ���������:
		$arrOrdersPaidFull=array();
		//������� ��������� ������ - �������� ��� ���������.
		//��������! ��������� ���������� ��������� ������ ��� �����, ��������Ĩ���� ����� �������� �� �������� �� ����� ��� ���������.
		$arrOrdersPaidPartly=array(); //��������
		$arrOrdersPaidNotSent=array(); //���������, �� �������
		$arrOrdersPaidSent=array(); //��������� ������� � �������
		$arrOrdersPaidUp=array(); //�������� ������

		$this->getOrdersArraysByTypes($inAuthorOrders);
		//getAllOrders($inAuthorOrders);
		//��� ������:
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
					
				case "unpaid": //������������
				  $inArray=$arrOrdersUnpaid;
					break;
			
				case "paid_partly": //���������� �� ���������*
				  $inArray=$arrOrdersPaidPartly;
					break;
			
				case "paid_notsent": //����������, �� ����������*
				  $inArray=$arrOrdersPaidNotSent;
					break;
			
				case "paid_sent": //���������� � ����������
				  $inArray=$arrOrdersPaidSent;
					break;
			
				case "paid_no_price": //���������� � ����������
				  $inArray=$arrOrdersPaidNoPrice;
					break;
			
				case "to_pay": //� �������
				  $inArray=$arrOrdersToPay;
					break;
					
				case "paid_up": //� �������
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

			//�������� ������ ������ ���� �������:
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
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelOrders",$qSelOrders); 
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
		
				if ($work_id) $for_work="������";
				else {
					if (isset($_REQUEST['author_id'])) {
						
						$user_id=$_REQUEST['author_id'];
						$user_type="author";
					
					}else{
						
						$user_id=$_REQUEST['customer_id'];
						$user_type="customer";
					
					} 
				}	
				$Blocks->showFilterResults( "orders", 	//��� ���������� ��������
											  $for_work,			//������, �� �������� �����������
											  $work_id,		//...��� id...
											  $user_type,		//���� ����������� �� ���������/����������/������
											  $user_id	//...��� id...
										);
				
				}else{
				
					?>���������: <img src="<?=$_SESSION['SITE_ROOT']?>images/filter_order.png" width="22" height="16" hspace="4" align="absmiddle" />
		<select name="order_status" id="order_status" onChange="go_orders_choice(this.options[this.selectedIndex].value);">
				
				<option value="all"<? if(!$_SESSION['FILTER_ORDER_STATUS']){?> selected<? }?>>��� ������: <?=($all_orders_exists)? $all_orders_exists:"0"?></option>
				
				<option value="unpaid"<? if($_SESSION['FILTER_ORDER_STATUS']=="unpaid"){?> selected<? }?>>�� �������: <? echo(count($arrOrdersUnpaid)&&is_array($arrOrdersUnpaid))? count($arrOrdersUnpaid):"0";?></option>
			<? if (count($arrOrdersPaidNoPrice)&&is_array($arrOrdersPaidNoPrice)){?>				
				<option value="paid_no_price"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_no_price"){?> selected<? }?> class="txtRed">�������, ��� ���������: <? echo count($arrOrdersPaidNoPrice);?></option>
			<? }?>				
				<option value="paid_partly"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_partly"){?> selected<? }?> style="background-color:#F7F7F7">������� �� ���������: <? echo(count($arrOrdersPaidPartly)&&is_array($arrOrdersPaidPartly))? count($arrOrdersPaidPartly):"0";?></option>
				
				<option value="paid_notsent"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_notsent"){?> selected<? }?> style="background-color:#FFFF99">������� ���������, �� �������: <? echo(count($arrOrdersPaidNotSent)&&is_array($arrOrdersPaidNotSent))? count($arrOrdersPaidNotSent):"0";?></option>
				
				<option value="paid_sent"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_sent"){?> selected<? }?> style="background-color:#CCFFCC">������� � �������<? if ($_SESSION['S_USER_TYPE']=="worker"){?>/������ ������<? }?>: <? echo(count($arrOrdersPaidSent)&&is_array($arrOrdersPaidSent))? count($arrOrdersPaidSent):"0";?></option>
			
				<option value="to_pay"<? if($_SESSION['FILTER_ORDER_STATUS']=="to_pay"){?> selected<? }?> style="background-color:#FFCC00">������, �� �� ��������: <? echo(count($arrOrdersToPay)&&is_array($arrOrdersToPay))? count($arrOrdersToPay):"0";?></option>

				<option value="paid_up"<? if($_SESSION['FILTER_ORDER_STATUS']=="paid_up"){?> selected<? }?> style="background-color:#EAF8F8">�������� ������: <? echo(count($arrOrdersPaidUp)&&is_array($arrOrdersPaidUp))? count($arrOrdersPaidUp):"0";?></option>

			</select>

		<?	}?></td>
		  </tr>    
		  <tr class="txt110 authorTblRowHeader"<? if ($_SESSION['S_USER_TYPE']=="worker"){?> style="height:auto;"<? }?>>
			<td nowrap="nowrap" class="paddingLeft0">
			<img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" title="id ������" />id,    
			<img src="<?=$_SESSION['SITE_ROOT']?>images/order_wait.png" width="20" height="16" hspace="4" align="absmiddle" title="������ ������" />������,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" border="0" align="absmiddle" title="�������� �� ������" />��������,
        <? }?>
            <img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" border="0" align="absmiddle" title="id ������" />id,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" align="absmiddle" title="����������� ������" />��������,
        <? }?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/calendar_clock.gif" width="19" height="15" hspace="4" align="absmiddle" title="���� � ����� �������� ������" />������,
			<img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" title="�������� ������" />��������,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="18" hspace="4" align="absmiddle" />��������,
        <? }?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" align="absmiddle" />����,
		<? if ($_SESSION['S_USER_TYPE']=="worker") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" align="absmiddle" />�����������,
			<img src="<?=$_SESSION['SITE_ROOT']?>images/money_applied.gif" width="17" height="15" hspace="4" border="0" align="absmiddle" />������������,
			<img onClick="alert('����� �������� �������� �� ������, �������� ��������������� ����� � ������� � �������� �� ������ \'+\' (����) � ��������� ������� ������ ������.');" title="�������� �������� �� ������..." src="../images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />...
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
			
				//����������/������� ��������� ������:
				$work_price=$Worx->calculateWorkPrice ($arr['work_table'],$arr['work_id'],false);
				//�������� ����� ���� �������� �������� �� ������
				$all_summ=$Money->allPaymentsInbox($arr['number']);	
				//������� ����� ���� ��������Ĩ���� �������� �������� �� ������
				$all_summ2=$Money->allPaymentsInbox($arr['number'],true);	?>
		  <tr<?
			
			unset($state);
			if ($all_summ||!$work_price){?> bgcolor="#<? //
				
				//�� ������� ��������� ������:
				if (!$work_price){
					
					$state="no_price";
					
					?>FFCCFF<? $title="�� ������� ��������� ������";
					
				}else{
					
				$title="������ ";
					
					//����� ������������� �������� �� ������ ��������� ������:
					if($all_summ2>=$work_price) {
						
						if (is_array($arrOrdersToPay)&&in_array($arr['number'],$arrOrdersToPay)) {
							?>FFFFFF<?
							
							$state="to_pay";
							$title.="�������, ";
							$title.=($arr['work_table']=="ri_worx")? "������ �� ��������� ������":"������ ������ �� ���������� ������";
						
						}else{
							
							//������ �������� (�� ��):
							if ($arr['state']=="sent") {
								
								//���������, ��������� �� ������?
								
								
								
								$state="sent";
						
								?>CCFFCC<? $title.="���������� ���������";
							
							//�� ��������:
							}else{
								
								$state="not_sent";
						
								?>FFFF99<? $title.="�� ����������...";
						
							}
						}
					//������������ ������ ��������� ������:
					}else{
						
							$state="paid_partly";
							
							?>F7F7F7<? $title="����� ������� �� ���������...";
					
					}
				}?>"<? 
			}else{ 
				
				$state="unpaid";
				
				$title="����� �� �������";
				
			}
			if ($title){?> title="<?=$title?>"<? unset($title); }?>>
			
			<td align="right"><? if ($test_order_id){?>order_id<? } ?><?=$arr['number']?></td>
			<td class="paddingLeft2"><?
			
			if ($test_table_source){?>������ ������<? }
			
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

			<td><a href="../manager/?menu=messages&amp;action=compose&amp;order_id=<?=$arr['number']?>" title="��������� ��������� �� ������..."><img src="<?=$_SESSION['SITE_ROOT']?>images/envelope_small.png" width="14" height="10" border="0" /></a></td>
			
			<td><a href="../manager/?menu=money&amp;order_id=<?=$arr['number']?>" title="��������� �������� �� ������ <?=$arr['number']?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" border="0" align="absmiddle" /></a></td>

			<? }?>			
			<td align="right"><a href="../manager/?menu=orders&amp;work_id=<?=$arr['work_id']?>" title="������������� ������ �� ������ id <?=$arr['work_id']?>"><? 
			
			if ($test_work_id) {?>work_id<? }
			echo $arr['work_id'];?></a></td>
			
			<? if ($_SESSION['S_USER_TYPE']=="worker") {?>			

			<td class="paddingRight0"><?
			if ($arr['work_table']=="ri_worx") $Worx->setWorkLinkMailTo($arr['work_id']);
			else {?>&nbsp;<? }?></td>
			
			<td><?
			
			if ($test_table_source){?>��������<? }
			//
			if ($arr['work_table']=="ri_worx"){
				//�������� ������ ������-���������:
				//�������� ������ ������:
				$qSelEmailAuthor="SELECT login,ri_user.number FROM ri_user, ri_worx 
	 WHERE ri_user.number = ri_worx.author_id
	   AND ri_worx.number = ".$arr['work_id'];
				$rSelEmailAuthor=mysql_query($qSelEmailAuthor); 
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSelEmailAuthor",$qSelEmailAuthor); 
				if (mysql_num_rows($rSelEmailAuthor)) {
					$login=mysql_result($rSelEmailAuthor,0,'login');		
					$author_id=mysql_result($rSelEmailAuthor,0,'number');
				}?><a href="../manager/?menu=orders&amp;author_id=<?=$author_id?>" onMouseOver="this.title='������������� ������ �� ������';"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /></a><a href="../manager/?menu=messages&amp;action=compose&amp;mailto=author&amp;user_id=<?=$author_id?>" title="��������� ��������� ������"><?
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

            <td><a href="../manager/?menu=orders&amp;customer_id=<?=$arr['user_id']?>" title="������������� ������ �� ���������"><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle"></a><a href="../manager/?menu=messages&amp;action=compose&amp;mailto=customer&amp;user_id=<?=$arr['user_id']?>" title="��������� ��������� ���������"><?
				//�������� ������ ������:
				$qSelEmail="SELECT email FROM ri_customer WHERE number = ".$arr['user_id'];
				$rSelEmail=mysql_query($qSelEmail); 
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSelEmail",$qSelEmail); 
				if (mysql_num_rows($rSelEmail)) echo mysql_result($rSelEmail,0,'email');?></a></td>
			
		<? }?>			
            
            <td align="right"><? 
				
			echo $work_price;
				
			if ($test_price){?>calculateWorkPrice<? }?></td>

		<?  if ($_SESSION['S_USER_TYPE']=="worker") {?>			

			<td align="right"><? //��������� �������� ������ �� ����������� �������...?><a href="../manager/?menu=money&amp;order_id=<?=$arr['number']?>" title="������������� �������� �� ������"><?
			
			echo $all_summ;
			
			?></a></td>
			
			<td align="center"><?
			
					if ($all_summ2<$all_summ){?><span class="txtRed"><?=$all_summ2?></span><? }
					else echo $all_summ2;
			
			?></td>
			
            <td align="center"><a href="../manager/?menu=mone&amp;action=add&amp;order_id=<?=$arr['number']?>" title="�������� �������� �� ������ id <?=$arr['number']?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus_big.png" width="16" height="16" border="0" align="absmiddle" /></a></td>
            <? }?>
		  </tr>
		<? }?>
		</table>    
			  </div>
			</td>
		  </tr>
		</table><?
	} //����� ������
	//�������� ������� ������
	function checkOrderPaidUp($order_id) {
		
		global $catchErrors;
		global $Worx;
		//�������� ������� ������:
		$qSel="SELECT summ FROM ri_payouts WHERE ri_basket_id = $order_id";
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); 
		if (mysql_num_rows($rSel)) {
			$payout_summ=0;
			while ($arr = mysql_fetch_assoc($rSel)) $payout_summ+=$arr['summ'];
			//���� ����������� ������ ����� �� ������ ������ (��������� ��������� ������) ��������� ������:
			if ($payout_summ>=$Worx->calculatePureLocalPrice($Worx->getWorkID($order_id))) return true;
			else return false;
		}
	}	
	//���������� �����. ��������� �������, ����������� ���������:
	function countSoldPaidUpOrders($arrTargetOrders) { //�������� - ��� ��������� ������
	
		global $catchErrors;
		global $Worx;
		
		if (count($arrTargetOrders)) {
			//�������� ������ ������:
			$qSel="SELECT ri_basket_id,summ FROM ri_payouts WHERE ri_basket_id IN (".implode(",",$arrTargetOrders).")";
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","������ ���������� ������, countSoldPaidUpOrders()","qSel",$qSel); 
			$arrPayoutsSumms=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrPayoutsSumms[$arr['ri_basket_id']]+=$arr['summ'];
			//���������, ��������� �� ������������ �������:
			$arrOrdersPaidUp=array();
			foreach($arrPayoutsSumms as $order_id=>$payout_summ) 
				//���� ����������� ������ ����� �� ������ ������ (��������� ��������� ������) ��������� ������:
				if ($payout_summ>=$Worx->calculatePureLocalPrice($Worx->getWorkID($order_id))) $arrOrdersPaidUp[]=$order_id;
			
		}
		
		return $arrOrdersPaidUp;
		
	} //����� ������ 
	//�������� ��� ������:
	function getAllOrders($inAuthorOrders=false) {	
	
		global $catchErrors;
		
		//�������� ������ ������ ���� �������:
		$qSelBasketAll="SELECT number FROM ri_basket $inAuthorOrders ORDER BY number DESC";
		//$catchErrors->select($qSelBasketAll,true); 
		$rSelBasketAll=mysql_query($qSelBasketAll); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelBasketAll",$qSelBasketAll); 
		$all_orders_exists=mysql_num_rows($rSelBasketAll);
		if ($all_orders_exists) {
			$this->all_orders_exists=$all_orders_exists;
			while ($arr = mysql_fetch_assoc($rSelBasketAll)) $arrAllOrders[]=$arr['number'];
			$this->arrAllOrders=$arrAllOrders;
			return $arrAllOrders;		
		}else return false;
	}
	
	//�������� ������� ������� �� �����:
	function getOrdersArraysByTypes($inAuthorOrders=false) {
			
			global $catchErrors;
			global $Worx;
			
			//�������� ��� �����������:
			$tArr=($_SESSION['S_USER_TYPE']=="author")? $this->arrAuthorOrders:$this->arrAllOrders;
			$arrSoldPaidUpOrders=$this->countSoldPaidUpOrders($tArr);
			
			//�������� ��� ��������:
			$qSelPayment="SELECT ri_basket_id,summ,payment_status FROM ri_payments $inAuthorOrdersPayment";
			//$catchErrors->select($qSelPayment,true); 
			$rSelPayment=mysql_query($qSelPayment); 
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelPayment",$qSelPayment); 
			
			if (mysql_num_rows($rSelPayment)) {
				//������� ������ ������� �� ������� ��� ������ ����� � ����� ������� �� �������:
				while ($arr = mysql_fetch_assoc($rSelPayment)) {
					//������� ����� �������� �� ������� ������:
					$arrRiBasketSumms[$arr['ri_basket_id']]+=$arr['summ'];
					//������� ������ ���� �������, �� ������� ���� ��������
					$arrOrdersPaid[]=$arr['ri_basket_id'];
				}
				ksort($arrRiBasketSumms);//����� ��� �������...
				//����������� ������:
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
						
			//������� ��������� ������� �� �����:			
			for ($i=0;$i<count($arrAllOrders);$i++) { //echo( "rSelBasketAll ");
				
				$order_id=$arrAllOrders[$i];
				
				//���������� ������� ������� �� �����.
				//�� ���������� ������:
				if (
					( is_array($arrOrdersPaid)&&!in_array($order_id,$arrOrdersPaid) )||
					  !count($arrOrdersPaid)
				   ) $arrOrdersUnpaid[]=$order_id;
				//���������� �� ���������:
				elseif ($order_id) {

					$table=$Worx->getWorkTable($order_id);
					//����������/������� ��������� ������:
					if ($_SESSION['S_USER_TYPE']=="author")	$price=$Worx->calculateLocalPrice($Worx->getWorkID($order_id));
					else {
						$wrk_id=$Worx->getWorkID($order_id);
						$price=$Worx->calculateWorkPrice ( $table,
													  	   $wrk_id,
													  	   false
														 );
					}
					$paid_ok=$Worx->calculateOrderPayment($order_id,true);
					//price		- ���� ������
					//summ		- ����� ���� �������� ��������
					//paid_ok	- ����� ������������� �������� ��������
					if ($price) {
						
						if ($paid_ok>=$price) {
							
							//������� ���������...
							$arrOrdersPaidFull[]=$order_id;
							
							//...� �������
							if ($Worx->getWorkSent($order_id)) {
								
								$arrOrdersPaidSent[]=$order_id;
								//��������� ��������� ������ ������:
								if ((!is_array($arrSoldPaidUpOrders)||!in_array($order_id,$arrSoldPaidUpOrders))&&$table=="ri_worx") $arrOrdersToPay[]=$order_id;
								
							}
							//...�� �������
							elseif ($table=="ri_worx") $arrOrdersPaidNotSent[]=$order_id;
						
						}else $arrOrdersPaidPartly[]=$order_id; //������� ��������...
					
					}else{ //��� ����, �� � ����������:
					
						$arrOrdersPaidNoPrice[]=$order_id;
						//echo "<div class='txtRed'>table= $table<br>wrk_id= $wrk_id<br>order_id= $order_id<br>price= $price</div><hr>";
					
					}
					//�������� ������� ������:	
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
			if ($test_arrays) { $none="...�� ����������...";
				
				?><h4>������������</h4><?
				if ($arrOrdersUnpaid) foreach ($arrOrdersUnpaid as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>���������� �� ���������</h4><?
				if ($arrOrdersPaidPartly) foreach ($arrOrdersPaidPartly as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>�������� ���������, �� ��������</h4><?
				if ($arrOrdersPaidNotSent) foreach ($arrOrdersPaidNotSent as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>�������� � ��������</h4><?
				if ($arrOrdersPaidSent) foreach ($arrOrdersPaidSent as $order_id) echo "$order_id, ";
				else echo $none;
				?><h4>���������</h4><?
				if ($arrSoldPaidUpOrders) foreach ($arrSoldPaidUpOrders as $order_id) echo "$order_id, ";
				else echo $none;
			
			}		
	}
	
}?>