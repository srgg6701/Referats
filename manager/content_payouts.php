<? $payout=true; $show_default=true;

if ($action=="add"||$action=="edit") {
	
	if (isset($_REQUEST['payout_id'])) $payout_id=$_REQUEST['payout_id'];
	
	if (!$_REQUEST['payment_for_order_complete']) {
	
		if ($action=="edit") $Money->getPayOutData($payout_id);
	
	}else{ 
	
		$Money->handlePayment($payout_id);
	
	}
	//��������� ������� � ������� ��������:	
	$Money->paymentAllDataTable($payout_id,false);

}else{

	//��������� ������� ������:
	$Money->buildPayoutsTable(false);

}?>