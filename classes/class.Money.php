<?

class Money {

public $payment_id;
public $ri_basket_id;
public $datatime;
public $summ;
public $payment_date;
public $payment_method;
public $payment_note;
public $recorder_type;
public $payment_status;
	
	//��� �������� ������� �� ������ (+(?)��������Ĩ����):
	function allPaymentsInbox($order_id,$ok=false){		
	
		global $catchErrors;
	
		//�������� ������ ������:
		$qSelSumm="SELECT summ FROM ri_payments	WHERE ri_basket_id = $order_id";
		if ($ok) $qSelSumm.=" AND payment_status = 'OK'";
		$rSelSumm=mysql_query($qSelSumm); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelSumm",$qSelSumm); 
		$all_summ=0;
		while ($arr = mysql_fetch_assoc($rSelSumm)) $all_summ+=$arr['summ'];
		//echo $all_summ;
		return $all_summ;
	}	//����� ������
	//��� ��������Ĩ���� �������� ������� �� ������:
	/*function allPaymentsInboxOK ($order_id){
		
		global $catchErrors;
		
		//�������� ������ ������:
		$qSelSumm="SELECT summ FROM ri_payments	WHERE ri_basket_id = $order_id AND payment_status = 'OK'";
		$rSelSumm=mysql_query($qSelSumm); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelSumm",$qSelSumm); 
		$all_summ2=0;
		while ($arr = mysql_fetch_assoc($rSelSumm)) $all_summ2+=$arr['summ'];
		return $all_summ2;		
	}	*/	//����� ������
	//��������� ������� ������:
	function buildPayoutsTable($author_id) { 

		global $Author;
		global $Blocks;
		global $catchErrors; 
		global $Manager; 
		global $Tools; 
		global $Worx; 
		
//�������� �������� ������� ������:
foreach($_GET as $filter=>$value) {

	switch ($filter)  { 

    	case "order_id":
  	  		$andFilter=" ri_basket_id = $value";
	    		break;

		case "author_id":
			$actor_type="author";
			$author_id=$actor_type_id=$value;//������ ������� ������ ����� ����������� ����� � ����������� � ���. $where
			$andFilter='';
				break;

		case "payout_author":
			$actor_type="worker";
			//�������� ������ ����������:
			$Manager->getManagerData(false,$value);
			$actor_type_id=$Manager->number;
		  	$andFilter=" payout_author = '$value'";
				break;
	}
	
}?>
        
<table width="100%" height="100%" cellpadding="0" cellspacing="0" id="tbl_payouts">
<? if (isset($andFilter)||$_REQUEST['payout_id']) { //���������� ���������� ������� � ������ ������:
	
		if (isset($_REQUEST['payout_id']))  $payouts="�������, �������� ";
		
?>  <tr style="height:auto;">
    <td colspan="2" class="padding4 paddingTop0"><? //echo "payouts= $payouts";
	$Blocks->showFilterResults (  "payouts", 	//��� ���������� ��������
								  $payouts,			//������, �� �������� �����������
								  $_REQUEST['payout_id'],		//...��� id...
								  $actor_type,		//���� ����������� �� ���������/����������/������
								  $actor_type_id	//...��� id...
								);?></td>
  </tr>
<? }?>  
  <tr style="height:auto;" bgcolor="#F5F5F5">
    <td nowrap="nowrap" class="tblHeaderCellLeft">
      <img src="<?=$_SESSION['SITE_ROOT']?>images/money_received.gif" width="21" height="15" hspace="4" align="middle" />id, 
      <img src="<?=$_SESSION['SITE_ROOT']?>images/calendar.gif" width="16" height="15" hspace="4" align="absmiddle" />���� �������, 
      <img src="<?=$_SESSION['SITE_ROOT']?>images/pay_in.png" width="16" height="16" hspace="4" align="absmiddle" />�����,
      <img src="<?=$_SESSION['SITE_ROOT']?>images/payout_choice.png" width="20" height="16" hspace="4" align="absmiddle" />������ ����������,
      <img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />id ������,
<? if ($_SESSION['S_USER_TYPE']!="author") {?>
      <img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />����������, 
<? }?>
      <!--<img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" />����,--> 
      <img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" align="absmiddle" />����� ������
      <img src="<?=$_SESSION['SITE_ROOT']?>images/comment2.gif" width="16" height="16" hspace="4" align="absmiddle" />�����������</td>
    <td align="center" nowrap="nowrap" class="tblHeaderCellRight" id="right_boundary"><a href="?menu=payouts&amp;action=add" title="�������� �������� � �������..."><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />...</a></td>
  </tr>
  <tr height="100%">
    <td colspan="2" valign="top"><div<? //style="height:100%; overflow:auto;"?>>
      <table cellpadding="4" cellspacing="0" rules="rows"><? 
//���������� ����� ����������� �������:
$limit_finish=10;
$Worx->setPagesLimit($limit_finish,$limit_start);
  
if ($author_id) {

	//�������� ������:
	//�������� ��� ������ ������:
	//���������� � ������� ������ ������:
	$arrAuthorBasket=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($author_id));
	if (count($arrAuthorBasket)) $where=" WHERE ri_basket_id IN (".implode(",",$arrAuthorBasket).")";

}
//���� ��������� ���������� �������:
if (isset($_REQUEST['payout_id']))  $where="WHERE number = ".$_REQUEST['payout_id'];
//������� ��� ������ � ��������:
if (!$where&&$andFilter) $andFilter="WHERE $andFilter";	
$qSel="SELECT * FROM ri_payouts $where $andFilter ORDER BY number DESC LIMIT $limit_start, $limit_finish ";
//$catchErrors->select($qSel);
$rSel=mysql_query($qSel); 
$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);	

$i=0;
while ($arr = mysql_fetch_assoc($rSel)){?>
        <tr style="height:auto;">
          <td align="right"><? if ($test_number){?>number<? }?><?=$arr['number']?></td>

          <td nowrap="nowrap"><? if ($test_datatime) {?>payout_date<? }$Tools->dtime($arr['payout_date']);?></td>

          <td align="right"><? if ($test_summ) {?>summ<? }?><?=$arr['summ']?></td>

          <td nowrap="nowrap"><? if ($test_payout_mode) {?>payout_mode<? }?><?=$arr['payout_mode']?></td>
          <td class="paddingRight2"><a href="?menu=payouts&amp;order_id=<?=$arr['ri_basket_id']?>" title="������������� ������� �� ������"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" border="0" /></a></td>

          <td align="right"><? if ($test_ri_basket_id ) {?>ri_basket_id<? } echo $arr['ri_basket_id']; 
		  
		  if ($_SESSION['S_USER_TYPE']!="author") {
			  
			  ?><a href="?menu=messages&amp;action=compose&amp;order_id=<?=$arr['ri_basket_id']?>" title="��������� ��������� �� ������"><img src="<?=$_SESSION['SITE_ROOT']?>images/envelope_small.png" width="14" height="10" hspace="4" border="0" /></a><?
			  
		  }?></td>
<? if ($_SESSION['S_USER_TYPE']!="author") {?>
          <td><?
	//�������� id ������:
	$this_author_id=$Author->getAuthorIdByOrderId($arr['ri_basket_id']);
		  
		  ?><a href="?menu=payouts&amp;author_id=<?=$this_author_id?>" title="������������� ������� �� ����������"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" border="0" /></a></td>
<? }?>          
          <td><? 
	//email (login) ������ �� ��� ID:
	$this_author_login=$Author->getAuthorLoginById($this_author_id);?><a href="?menu=messages&amp;action=compose&amp;mailto=author&amp;user_id=<?=$this_author_id?>" title="��������� ��������� ���������� �������"><? if($test_author_login){?>	author_login<? }
		echo $this_author_login;?></a></td>

          <td nowrap="nowrap"><a<? if ($_SESSION['S_USER_TYPE']!="author") {?> href="?menu=payouts&amp;payout_author=<?=$arr['payout_author']?>" title="������������� ������� �� ����������-������ ��������"<? }?>><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /></a><? 
		  
		  //�������� id ����������:
		  $Manager->getManagerData(false,$arr['payout_author']);
		  $worker_id=$Manager->number;?><a href="?menu=messages&amp;action=compose&amp;mailto=workers&amp;<? if ($_SESSION['S_USER_TYPE']=="author") {?>payout_id=<? echo $arr['number']; } else{?>user_id=<? echo $worker_id; }?>" title="��������� ��������� ����������-������ ��������"><?
		  
		  if ($test_payout_author) {?>payout_author<? }?><?=$arr['payout_author']?></a></td>

          <td width="100%"><? if ($test_payout_note){?>payout_note<? }
		  
		  echo (strlen($arr['payout_note'])>45)? "<span title='".$arr['payout_note']."'>".substr($arr['payout_note'],0,42)."..."."</span>":$arr['payout_note'];
		  
		  ?></td>

        </tr><? echo "\n";
  $i++;
}
if (!$i){?><tr><td colspan="10" class="padding10" style=" border:none;">�������� �� ����.</td></tr><? }?>
      </table>
    </div></td>
  </tr>
  <tr style="height:auto;">
    <td colspan="2" valign="top"><?
	
	$pageNextStyle=" style='';";
	$Blocks->makePagesNext($all_messages,$limit_finish);
	    
	?></td>
  </tr>
</table>
<?  }	
	//������� ��, ��� �������� � ��, ��� ������. ���� �� ��, �������� ����� ��������� ������:
	function compareSumms($table,$ri_basket_id) {
		
		global $Author;
		global $catchErrors;
		global $Messages;
		global $Worx;
		global $work_id;
		global $work_name;
		$work_id=$Tools->clearToIntegerAndStop($work_id);

		//��������, �� �� ��������. ���� ��, ���������� ���� (������ � ���������):
		//����������/������� ��������� ������:
		$work_price=$Worx->calculateWorkPrice ( $table,
												$Worx->getWorkID($ri_basket_id),
												false
											  );
		//������� ����� ���� ��������Ĩ���� �������� �������� �� ������
		$all_summ2=$this->allPaymentsInbox($ri_basket_id,true);
		
		//���� � �������� ������, �������� � �������� ����� ��������.
		//��������! ����������� � ����� ������, �.�.: 
		  //*������� ���������� ������, ���� ������������� ���������
		  //*����������� ������� ���������� ��� �������������� ��������, ������� ��� �� ��������������
		if (isset($_SESSION['TEST_MODE'])) {
			echo "<div>all_summ2 BEFORE= $all_summ2, ";
			$all_summ2+=$_REQUEST['summ'];
			echo "all_summ2 AFTER= $all_summ2</div>";
		}
		//�������� ��������� ������:
		if ($all_summ2>=$work_price) {
			//���� ������ ������:
			if ($table=="ri_worx") {
				
				//email (login) ������ �� ��� ID:
				$email=$Author->getAuthorLoginById($Author->getAuthorIdByOrderId($ri_basket_id));
				$arrAuthorData=$Author->getAuthorDataAuth($email,$pass);
				$alert="������ ���������� ��������� � ������ ������ ������ � ������������� �������� ���� ���������.\\n[������� ������!]";
				$link_to_enter=$_SESSION['SITE_ROOT'].$Messages->makeGatewayLink($email,"author",$Author->pass)."&amp;menu=worx&amp;submenu=to_send&amp;work_id=$work_id";
				//
				$Messages->sendEmail   ( $email,
										 $fromAddress,
										 $replyTo,
										 "���� ������ �������� ���������!",
										 "������������, ".$arrAuthorData['name']."!
										 <p>���� �������� ���, ��� ���� ������ id $work_id (���� ������: $work_name), ����� id $ri_basket_id ��������� �������� ����������. ��� ���������� ��������� ��� ������ ������� �� ������ ��������: <a href='$link_to_enter'>$link_to_ente</a>
										 </p>",
										 $alert
									   );
			}else{ //���� ������ ��, ������ �������� (�����) �� �����, � ������ ��������� ����� ������, ��� ����������, ��� �������� �������� ��� ��������� ������� � ������:
				
				//��������...:
				$qUpd="UPDATE ri_basket SET `state` = 'sent' WHERE `number` = '$ri_basket_id'";
				$catchErrors->update($qUpd);
				
			} 
		}
		//������� � ������ ��������:
		$Messages->alertReload(false,"?menu=money");
		
/*<script type="text/javascript">
alert('�������� ��������� ������!');
</script>	*/						
	}	//����� ������
	
	//�������� ��� �������:
	/*function getPayments($ri_basket_id) {
		
		global $catchErrors;
		$this->ri_basket_id=$ri_basket_id;
		
		//������� id �������, ����� �������� ������:
		$qSelPaid="SELECT * FROM ri_payments WHERE ri_basket_id = $ri_basket_id"; 
		$rSelPaid=mysql_query($qSelPaid);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelPaid",$qSelPaid);
		$paid_rows=mysql_num_rows($rSelPaid);
		//$catchErrors->select($qSelPaid);
		//
		if ($paid_rows) {
			$this->payment_id=mysql_result($rSelPaid,0,'number');
			$this->datatime=mysql_result($rSelPaid,0,'datatime');
			$this->summ=mysql_result($rSelPaid,0,'summ');
			$this->payment_date=mysql_result($rSelPaid,0,'payment_date');
			$this->payment_method=mysql_result($rSelPaid,0,'payment_method');
			$this->payment_note=mysql_result($rSelPaid,0,'payment_note');
			$this->recorder_type=mysql_result($rSelPaid,0,'recorder_type');
			$this->payment_status=mysql_result($rSelPaid,0,'payment_status');			
		} return $paid_rows;
	}*/	//����� ������
	//�������� ��� ������ �������:
	function getPaymentData($payment_id) {
		
		global $catchErrors;
		
		//������� id �������, ����� �������� ������:
		$qSelPaid="SELECT * FROM ri_payments WHERE number = $payment_id"; 
		$rSelPaid=mysql_query($qSelPaid);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelPaid",$qSelPaid);
		$paid_rows=mysql_num_rows($rSelPaid);
		//$catchErrors->select($qSelPaid);
		//
		if ($paid_rows) {
			$this->payment_id=$payment_id;
			$this->ri_basket_id=mysql_result($rSelPaid,0,'ri_basket_id');
			$this->datatime=mysql_result($rSelPaid,0,'datatime');
			$this->summ=mysql_result($rSelPaid,0,'summ');
			$this->payment_date=mysql_result($rSelPaid,0,'payment_date');
			$this->payment_method=mysql_result($rSelPaid,0,'payment_method');
			$this->payment_note=mysql_result($rSelPaid,0,'payment_note');
			$this->recorder_type=mysql_result($rSelPaid,0,'recorder_type');
			$this->payment_status=mysql_result($rSelPaid,0,'payment_status');			
		} return $paid_rows;
	}	//����� ������
	//���������� �������� ��������:
	function handlePayment($payment_id) { 	//������� ��������� � ����������� �������, ���������� ��������� ��:
		//echo "<div>handlePayment STARTS!</div>";
			
		global $Actions;
		global $Author;
		global $catchErrors;
		global $Messages;		
		global $payout;
		global $Worx;
	
		$show_default=true; //���������� � ���������� ���� ����� �������� � ������ ������������ (��� Chrome, Firefox...)
		
		$day=$_REQUEST['day'];
		if (strlen($day)==1) $day="0".$day;
		
		if ($payment_id) {
			
			$this->getPaymentData($payment_id);
			$ri_basket_id=($_REQUEST['order_id'])? $_REQUEST['order_id']:$this->ri_basket_id;
			
			$table=$_REQUEST['table'];
			$work_native_id=$_GET['work_native_id'];
			
			//���� �� �������� �������-�������� ��� ������ ������������� ������, ����� ��������...
			if (!$table||!$work_native_id) {

				$table=$Worx->getWorkTable($ri_basket_id);
				$work_native_id=$Worx->getWorkID($ri_basket_id);
				
			}
			
			//�������� ������ �������:
			$qUpd="UPDATE ri_payments SET datatime = '".date('Y-m-d H:i:s')."', 
                           summ = $_REQUEST[summ], 
                   payment_date = '$_REQUEST[year]-$_REQUEST[month]-$day', 
                 payment_method = '$_REQUEST[pay_method]', 
                   payment_note = '$_REQUEST[payment_note]', 
                  recorder_type = '$_SESSION[S_USER_TYPE]' ";  
			if ($_SESSION['S_USER_TYPE']=="worker")
			$qUpd.=",
                  payment_status = 'OK' ";  
			$qUpd.="
	  WHERE `number` = ".$this->payment_id;
			$catchErrors->update($qUpd);
	
			//add statistics:
			$Actions->addStatRecord( "ri_payments",
									 $this->payment_id,
									 "update", 
									 "manually", 
									 $initiator, //
									 $initiator_id //
								   );

			//��������� ���� ��������� ������:
			$payment_action="��������� ������ ";
			
			$paid_stat=($_REQUEST['action']=="edit")? 2:1; 
			$alert="�������� ��������!";
			
		}else{ //���� ����� �����, - ��������:
			
			if ($_SESSION['S_USER_TYPE']=="worker") $payment_status="OK";
			$ri_basket_id=$_REQUEST['order_id'];
			//
			if ($payout) { 
			
				$qIns="INSERT INTO ri_payouts ( datatime, 
                          summ, 
                          payout_date, 
                          payout_mode, 
                          payout_author,
                          payout_note, 
                          ri_basket_id
                        ) VALUES 
                        ( '".date('Y-m-d H:i:s')."', 
                          $_REQUEST[summ], 
                          '".$_REQUEST['year']."-".$_REQUEST['month']."-$day', 
                          '$_REQUEST[pay_method]', 
                          '$_SESSION[S_USER_LOGIN]', 
                          '$_REQUEST[payment_note]', 
                          $ri_basket_id   
                        )";
				$tableIns="ri_payouts";
				
			}else{
				
				$qIns="INSERT INTO ri_payments ( ri_basket_id, 
                          datatime, 
                          summ, 
                          payment_date, 
                          payment_method, 
                          payment_note, 
                          recorder_type,
                          payment_status
                        ) VALUES 
                        ( $ri_basket_id, 
                          '".date('Y-m-d H:i:s')."', 
                          $_REQUEST[summ], 
                          '".$_REQUEST['year']."-".$_REQUEST['month']."-$day', 
                          '$_REQUEST[pay_method]', 
                          '$_REQUEST[payment_note]', 
                          '$_SESSION[S_USER_TYPE]', 
                          '$payment_status'
                        )";
				$tableIns="ri_payments";
				
			}
			$catchErrors->insert($qIns);
			//add statistics:
			$Actions->addStatRecord( $tableIns,
									 mysql_insert_id(),
									 "insert", 
									 "manually", 
									 $initiator, //
									 $initiator_id //
								   );

			$payment_action="��������";
			
			$getRec=mysql_query("SELECT number FROM $tableIns ORDER BY number DESC");
			$last_rec=(mysql_num_rows($getRec))? mysql_result($getRec,'0','number'):'0';
			$payment_id=($_SESSION['TEST_MODE'])? $last_rec+1:mysql_insert_id(); 
			//echo "<h3>payment_id= $payment_id</h3>";

			$this->getPaymentData($payment_id);
			$table=$Worx->getWorkTable($ri_basket_id);
			$work_native_id=$Worx->getWorkID($ri_basket_id);
			$alert="�������� ���������!";

		}
		//�������� �������� ������:
		$work_name=$Worx->getWorkName($table,$work_native_id);
		//���� ������������� ��������:
		if ($_SESSION['S_USER_TYPE']=="customer") {
			$status=1;
			$Messages->sendEmail( $toAddress,
								  $_SESSION['S_USER_EMAIL'],
								  $_SESSION['S_USER_EMAIL'],
							  "$payment_action ������� ����������",
							  "������ �������:
							  <p>id ������ (ri_basket.number): $ri_basket_id</p>
							  <p>��������/����: $work_name</p>
							  <p>������ ������: $_REQUEST[pay_method]</p>
							  <p>�����: $_REQUEST[summ]</p>
							  <p>������ �������: �� ��������</p>
							  <p>����������� ���������: $_REQUEST[payment_note]</p>",
							  "������ ���������!" //����������� alert
								);
			if (!isset($_SESSION['TEST_MODE'])){?>
	
<script type="text/javascript">
	//����������� ������������ ��������:
	if (parent) parent.location.reload();
	</script>
	
	<?		}
		}elseif ($_SESSION['S_USER_TYPE']=="worker"){
			
			if (!$payout) $this->compareSumms($table,$ri_basket_id); 
			else {
				
				//���� ����������� ������ ������, �������� ���:
				//get author data:
				$author_id=$Author->getAuthorIdByOrderId($ri_basket_id);
				$arrAuthorData=$Author->getAuthorDataAuth($email,$pass);
				//
				$Messages->sendEmail   ( $arrAuthorData['login'],
										 $fromAddress,
										 $replyTo,
								 "������� ����� �� ����� id $ri_basket_id",
								 "������������, ".$arrAuthorData['name']."!
								 <p>���� ��������, ��� ��� ��������� ������ �� ����� id $ri_basket_id (���� ������: $work_name).</p>
								 <p>����� �������: $_REQUEST[summ] �.</p> 
								 <p>������ �������: $_REQUEST[pay_method].</p> 
								 <p>������� �� ��������������!</p>",
										 false
									   );
				
				if ($alert) $Messages->alertReload($alert,"?menu=$_REQUEST[menu]");
			}
			//echo "<h2>work_price= $work_price<br>all_summ2= $all_summ2</h2>";
		}
	}	//����� ������
	//�������� ������� ������ ��������:
	function paymentAllDataTable($payment_id,$allow_close) {
		
		//echo "<div>payment_id= $payment_id</div>";
		
		global $Author; 
		global $catchErrors; 
		global $payout; //��������� ������ � �������
		global $Orders;
		global $Tools;
		global $Worx;
		//
		if (isset($_REQUEST['order_id'])) $order_id=$_REQUEST['order_id'];
		
		//���� ���������� ����� ��� �����:
		if ($payment_id||$order_id) {
			
			//$payment_id=($_REQUEST['payment_id'])? $_REQUEST['payment_id']:$this->payment_id;
			//���� ����������� ������������ ��������:
			if ($_REQUEST['action']=="edit") $set_style=' style="background-color:#eaffea;"';

			$iborder=' class="iborder borderColorGray"';

			if ($_REQUEST['action']=="edit"||$_REQUEST['action']=="add"){?>
            
        <h3 style="display:inline" class="paddingLeft4"><? 

	    $ri_basket_id=($order_id)? $order_id:$this->ri_basket_id;
		$pay_type=($payout)? "�������":"��������";
		$PayType=($payout)? "�������":"��������";

				if ($order_id){?><img src="<?=$_SESSION['SITE_ROOT']?>images/money_applied.gif" width="17" height="15" align="absmiddle" /> ����� <?=$pay_type?><? }else{ echo $PayType;?> # <? } echo $payment_id?>.</h3>
        &nbsp;&nbsp;
          <span class="txt120">����� id <strong><?=$ri_basket_id?></strong>.<?
		  
		  		if (!$payout){?> �����������: <strong><? 
		  $table=$Worx->getWorkTable($ri_basket_id);
		  echo ($table=="diplom_zakaz")? "Referats.info":"�����";?></strong>.<? }
		  	?></span><?
		  
  		$work_id=$Tools->clearToIntegerAndStop($Worx->getWorkID($ri_basket_id));?>
  <hr noshade size="1" />  
          <div class="padding4">[work_id: <strong><?=$work_id?></strong>] ���� ������: <strong><? echo $Worx->getWorkName($table,$work_id);?></strong>.</div>
        <hr noshade size="2" color="#CCCCCC" />
        <br />  
         <?	}
		    
			echo "\n";    

		}elseif ($_SESSION['S_USER_TYPE']=="worker"){ //echo "No payments";

			//id id ���� ��������� �������:
			$arrAllOrders=$Author->getAllAuthorsWorxNumbers(); 
			//��������� ���������� (������� � �������) ������:
			//([work_id]=>array(order1,order2...))
			$Worx->getAllOrdersPaid();
			//�������� �������� ������:
			$arrPaid=$Worx->arrOrdersPaidFull;				
			//echo "<hr>"; var_dump($arrPaid);
			//���� �������:
			if ($payout) {
				
				//���������� �����. ��������� �������, ����������� ������� ���������:
				$arrPaidUp=$Orders->countSoldPaidUpOrders(
							//id id ���� ��������� �����:
							$Author->getAllAuthorsOrdersNumbers($arrAllOrders));
				
				//�������� ������������� ������-
				//��� "����������" ����� ����������� �������:
				$arrInOrders=$Tools->arraysDiff(array($Worx->getWorxSent(),$arrPaidUp),"paymentAllDataTable");
				
			}else{ //���� �������� �������:

				//�������� ������������ ������ - ��� ����� ��������� ����������:
				$arrInOrders=$Tools->arraysDiff(array($arrAllOrders,$arrPaid),"paymentAllDataTable");

			}
			//
			if ($arrInOrders) {
				$where="
   WHERE number IN (".implode(",",$arrInOrders).")";
				$qSel="SELECT number,work_id,work_table FROM ri_basket $where"; 
				//$catchErrors->select($qSel);
				$rSel=mysql_query($qSel);
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
				$sel_rows=mysql_num_rows($rSel);
			}?>

        <div class="padding10 bgGrayLightFBFBFB borderBottom2 borderColorGray">

    <div class="txt120 paddingBottom4 bold">��<? if ($_REQUEST['menu']=="payouts"){?>��<? }else{?>�<? }?>��������� ������ <span class="noBold">(id ������, <? 
			if ($payout){?>�����, ����� �������,<? }else{?>�����������, ����, <? }?> ����)</span>:</div>
 		<?  if ($sel_rows) {
				
				if (!$order_id) {?>          
    <select name="order_id" id="order_id">
      <option value="0">-�������� �����-</option>

	    <? 	######################################
			while ($arr = mysql_fetch_assoc($rSel)) {?>

		<option value="<?=$arr['number']?>"><? echo $arr['number'];
			
				$work_table=$arr['work_table'];

				//���� ������� �������:
				if ($payout) {
				
				$qSelAuthor="SELECT login FROM ri_user, ri_worx, ri_basket
 WHERE ri_user.number = ri_worx.author_id 
   AND ri_worx.number = ri_basket.work_id 
   AND ri_basket.number = ".$arr['number']; 
				$rSelAuthor=mysql_query($qSelAuthor);
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSelAuthor",$qSelAuthor);
				if (mysql_num_rows($rSelAuthor)) $order_src=mysql_result($rSelAuthor,0,'login');
				$wprice=$Worx->calculatePureLocalPrice($arr['work_id']);

				}else{ 
			
					$order_src=$work_table;
					$wprice=$Worx->calculateWorkPrice ($work_table,$arr['work_id'],false);
				
				}

				echo " [$order_src], $wprice �. ";
			
				echo $Worx->getWorkName($work_table,$arr['work_id']);
			
		?></option>

			<?  } ?>
    </select>
    	<?		}
		
		    }else{?>
        <br><span class="padding10 bgPale">������ ���������� ���� �����������...</span>
        
		<?  }?>
    </div>
    <br />
	<?  }
		
		if ($sel_rows||$order_id||$payment_id) {
		
		//echo "<div>sel_rows= $sel_rows, order_id= $order_id</div>";
		
		//������� ��������-action ����� ���. payment_for_order_complete, ��� �������� ����� ����, ��� ��������� �����?>

<input name="payment_for_order_complete" type="hidden" value="<?
	echo ($order_id)? $order_id:"new";?>">
<table cellpadding="3" cellspacing="0">
  <tr>
    <td nowrap="nowrap">���� <?
    $pty=($payout)? "�������":"������"; echo $pty;?>: </td>
    <td nowrap="nowrap">������ <?=$pty?>: </td>
    <td nowrap="nowrap" class="paddingRight10">�����: </td>
    
    <td width="100%" rowspan="4" valign="top" nowrap="nowrap" class="paddingLeft20">
    <? if ($payment_id) {?>
    <table cellspacing="0" cellpadding="4" class="iborder" bordercolor="#003366">
      <tr>
        <td valign="top" nowrap="nowrap" bgcolor="#999999" class="paddingLeft20 txtWhite">���� ��������</td>
    <? if ($_SESSION['S_USER_TYPE']=="worker") {?>
        <td bgcolor="#003366" class="paddingLeft20 txtWhite">����� ��������</td>
    <? }?>        
      </tr>
      <tr>
        <td nowrap="nowrap"<?
    	if ($payment_id) {?> bgcolor="#F5F5F5" class="paddingLeft20"><img src="<?=$_SESSION['SITE_ROOT']?>images/calendar.gif" width="16" height="15"> &nbsp;
          <? 
	
		echo $this->datatime[8];
		echo $this->datatime[9];
		echo ".";
		echo $this->datatime[5];
		echo $this->datatime[6];
		echo ".";
		echo $this->datatime[0];
		echo $this->datatime[1];
		echo $this->datatime[2];
		echo $this->datatime[3];
		}else echo ">&nbsp;";?></td>
    <? if ($_SESSION['S_USER_TYPE']=="worker") {?>
        <td class="paddingLeft20"><? 
		$recorder_type=$this->recorder_type;
		$user_type=($recorder_type=="customer")? "��������":"���������";
		$this->showRecorderType($recorder_type,$user_type);
        
		?></td>
	<? }?>
      </tr>
    </table><?
	}?></td>
  </tr>
  <tr>
    <td nowrap="nowrap"><? 
	
		$day=substr($this->payment_date,8,2);
		if ($day[0]=="0") $day=$day[1]; 
		
		$month=substr($this->payment_date,5,2);
		if ($month[0]=="0") $month=$month[1]; 
		
		$year=substr($this->payment_date,0,4); ?>
    
	<select name="day"<?=$set_style?>>
      <?php   //
		for($i=1;$i<32;$i++) { ?>
      <option value="<? echo $i;?>"<? 
	  			
			if (
				 ( $payment_id&&$day==$i ) || 
				 ( !$payment_id&&date('d')==$i )
			   ) echo " selected"; ?>><? echo $i;?></option>
      <? echo "\n";
		}?>
    </select>
	<select name="month"<?=$set_style?>>
        <? $arrMnth=array("������","�������","����","������","���","����","����","������","��������","�������","������","�������"); 
		$i=1;
		foreach ($arrMnth as $mnt) { ?>

        <option value="<? echo($i<10)? "0$i":$i; ?>"<?php 
				
			if ( 
				 ( $payment_id&&$month==$i ) ||
				 ( !$payment_id&&date('m')==$i )
			   ) echo " selected"; ?>><? echo $mnt;?></option>
        <?   echo "\n"; $i++;
        } ?>
      </select>
	<select name="year"<?=$set_style?>>
        <option value="<?php echo (date('Y')-1);?>"<? 
				if (!$payment_id||$year==date('Y')-1){?> selected<? }?>><?php echo (date('Y')-1); ?></option>
        <option value="<?php echo (date('Y')); ?>"<?
				if (!$payment_id||$year==date('Y')){?> selected<? }?>><?php echo (date('Y')); ?></option>
      </select>
      </td>
    <td nowrap="nowrap"><?

		//������� ������:
		$this->payMethod($set_style,$onchange,$this->payment_method);
	
	?></td>
    <td nowrap="nowrap"><input<?=$set_style?> value="<?=$this->summ?>" name="summ" type="text" id="summ" size="3"<?=$iborder?> /></td>
    <?  if ($payment_id) {?>	
    <?  }?>
    </tr>
  <tr>
    <td colspan="3">���������� � �������:</td>
    </tr>
  <tr>
    <td colspan="3">
      
	  <textarea<?=$set_style?> name="payment_note" id="payment_note" class="widthFull<? if ($set_style){?> iborder borderColorGray<? }?>" rows="5"
	<?  if ($_SESSION['S_USER_TYPE']=="worker"){?>
      	title="������� ������ �������� ������ ����;
						��������� ������ + Ctrl - ��������;
						������� + Ctrl - ����� ������ � ���������� ��������."
						onDblClick="if (event.ctrlKey) this.rows=4; else this.rows+=4"
						onClick="if (event.ctrlKey&&this.rows>1) this.rows-=3;"<?
		}?>><?=$this->payment_note?></textarea></td>
    </tr>
</table>
<div class="paddingTop6"><input name="submit_payment" type="submit" value="<? 
			if ($set_style){?>��������� ���������<? }else{?>�������� �����<? }?>!"<?
    		if (!$allow_close){?> onClick=" return checkFields();"<? }?>>
<?  		if ($allow_close) {?>     
  <input type="button" name="button" id="button" value="������� �������" onClick="parent.showPayments(<?=$_GET['order_id']?>,'close');" /><?
			}
		}?>
</div>
<?  }	//����� ������	
	//������ �������� ��������:
    function payMethod($style,$onchange,$selected){
		
		global $catchErrors;?>
    
    <select name="pay_method" id="pay_method"<?=$style?>>
      <option value="0"<? if ($selected=="default"){?> selected="selected"<? } 
	  echo $onchange;?>>-�������� �� ������-</option>
   <? //
	  $qSelExcl="SELECT payment_id FROM matrix_payment_type_exclude WHERE partner_id = 13";
	  $rSelExcl=mysql_query($qSelExcl);
	  $catchErrors->errorMessage(1,"","������ ���������� ������","qSelExcl",$qSelExcl);
	  $r_n=mysql_num_rows($rSelExcl);
	  if ($r_n)
		{ for ($i=0;$i<$r_n;$i++)
		    { if ($i) $exclud.=",";
			  //�������� id id �������� �������, ����������� ������ ��������:
			  $exclud=mysql_result($rSelExcl,$i,'payment_id');	  
			} $excldIN="WHERE number NOT IN ($exclud)";
		}

	  $qPData="SELECT * FROM diplom_payment_type $excldIN ORDER BY number"; 
	  $dpt=mysql_query($qPData);
	  $catchErrors->errorMessage(1,"","������ ���������� ������","qPData",$qPData);

	  	for ($i=0;$i<mysql_num_rows($dpt);$i++) { 
	  		$number=mysql_result($dpt,$i,'number');
		  	$nickname=mysql_result($dpt,$i,'nickname');
		  	$payment_type=mysql_result($dpt,$i,'payment_type'); ?>
      <option value="<?=$payment_type?>"<? 

	  		if ($selected==$payment_type) echo ' selected="selected"';?>><? 
			echo $payment_type; ?></option>
 	<?	}?>
    </select><?
	}	//����� ������
	//
	function showRecorderType($type,$user){	
		if ($type=="customer") {
			
			?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="13" height="16" hspace="4" align="absmiddle" title="��������" /><? 
			
		}else{
			
			?><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" align="absmiddle" title="���������" /><? 
			
		}
		
		if ($user) echo $user;
		
	}
}?>