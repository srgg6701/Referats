<? 	
if (isset($_REQUEST['work_subject'])) $work_subject=$_REQUEST['work_subject'];
require("../classes/class.dbSearch.php");
$dbSearch=new dbSearch;

//��������� ����� �������� ��������� ������, ����� ��� ��������� �� ������ ����:
$Worx->setSearchPreString();

//���� ����� ������� ����:
if (isset($_REQUEST['del_file_name'])) {
	//���������, ���� �� ������ �� ������ ������
	//�������� id ������:
	$qSelOrders="SELECT ri_basket.number, state, status, ri_worx.number
  FROM ri_basket, ri_worx 
 WHERE ri_basket.work_id = ri_worx.number 
   AND ri_worx.work_name = '$_REQUEST[del_file_name]'";
	$rSelOrders=mysql_query($qSelOrders);
	$catchErrors->errorMessage(1,"","������ ���������� ������","qSelOrders",$qSelOrders); 
   	//$catchErrors->select($qSelOrders,1); echo "<div>recs: ".mysql_num_rows($rSelOrders)."</div>";
	$countPaid=0;
	if (mysql_num_rows($rSelOrders)) { //����� � �������
		while ($arr = mysql_fetch_assoc($rSelOrders)) { 
			//�������� ��������� ��������/������.
			//���� ���� ��������:
			if ($Worx->calculateOrderPayment($arr['number'],false)) $countPaid++;
		}
		//���� �� ��������� ������ �������� ������������ ������ � ����������
		if ($countPaid) {?>
<script type="text/javascript">
if (!confirm('�� ������ ������ ���� �������������� ��������� ���������� ������ (<?=$countPaid?>).\n�� ����� �������?')) location.href='?menu=worx';
</script>
	<?		//��������� ������ �� �������� ������, �� ������� ���� �������� (������� ���������������):
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "�������� ������� ������, �� ������� ������� ���� ��������",
								   "������� id $_SESSION[S_USER_ID] ($_SESSION[S_LOGIN]) ������� ������ id ".$arr['number'].". 
								   <p>���� ������: $_REQUEST[del_file_name].</p>
								   <p>���� ������: ".mysql_result(mysql_query("SELECT work_type FROM ri_worx WHERE work_name = '$_REQUEST[del_file_name]'"),0,'work_type').".</p>
								   <p>������� ������: ".mysql_num_rows($rSelOrders).".</p>",
								   false
								 );
		}		
	}
	$Worx->deleteSingleFile("?menu=worx"); 
}
//����� ���������� ��������� ������ �����:
if ($submenu!="to_send"&&$submenu!="to_pay"&&$submenu!="sold") $allow_changes=true;

//���� �� ��������� ����:
if ($submenu!="upload"){
	
	//������� ������ ���������:
	if ($submenu=="to_send"&&$_FILES) {

		//���������� ������ �����, ������ �� ������� ����� ���� ���������� ���������:
		$arrWorxIDs=array();
		foreach ($_POST as $key=>$val) if (strstr($key,"set_number_")) $arrWorxIDs[]=$val;
		
		//$test_files=true;
		$flz=0;
		foreach ($_FILES as $file_data){
			
			//���� ���� �� ������� �����:
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
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSelWork",$qSelWork);
				$count_work_order=mysql_num_rows($rSelWork);
				if ($count_work_order) {
					//
					$work_type=mysql_result($rSelWork,$count,'work_type');
					$work_id=mysql_result($rSelWork,$count,'work_id');
					$order_id=mysql_result($rSelWork,$count,'number');
					$work_table=mysql_result($rSelWork,$count,'work_table');
					
					$count=0; //echo "<h1>�������� �����...</h1>";						
					smtpmail(  mysql_result($rSelWork,$count,'email'),				//����� ����������
							   "�� Referats.info: �������� ������ id $order_id (".$file_data["name"].")",			//���� ���������
							   "������������, ".mysql_result($rSelWork,$count,'name')."!
							   <p>���� ������ � ����������. � ������ ������������� �����������, ����������, ����������� � ���.".$Messages->setSiteSignature(true)."</p>",		//����� ���������
							   $username,		//***����� �����������
							   $reply_to_email,	//***����� ��� ������
							   "Admin",			//***��� ���������� ������
							   $sender_address,	//***����� �����������
							   "Referats.info",	//***��� �����������
							   $file_data["tmp_name"],			//attach path 
							   $file_data["name"]				//attach name
							); 					
					$count++;			
				}	//echo "<hr>";			
			}
			$flz++;
		}
		if ($flz) {
			$alert="����";
			$alert.=($flz==1)? " �������":"� ��������";
			$alert.=".";
			$Messages->sendEmail ( $toAddress,
								   $fromAddress,
								   $replyTo,
								   "������� ��������� ������ id $work_id",
								   "����� id $order_id; 
								   <p>��������� ������: ".$Worx->calculateWorkPrice	($work_table,$work_id,false).";</p>
								   <p>������������ �������� �� �����: ".$Worx->calculateOrderPayment($ri_basket_id,true).";</p>
								   <p>����� ����� ��������: ".$Worx->calculateOrderPayment($ri_basket_id,false).";</p>
								   <p>���� ������: ".$file_data['name'].";</p>
								   <p>��� ������: $work_type.</p>",
								   false
								 );
		}
	}
	
	//��������, �� �������� �� ��������� ������� �����:
	if (!$_REQUEST['submit_filter']&&$allow_changes)
		foreach($_POST as $key=>$work_id) {
			
			if (strstr($key,'set_number_')) {
				//�������� ������� ��������, ������� � ����������...
				$where=" 
  WHERE author_id = $_SESSION[S_USER_ID] 
   AND number = $work_id";
				$qSel="SELECT * FROM ri_worx $where"; 
				$rSel=mysql_query($qSel);
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
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
					//�������� �������/���:
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
					$changes_saved="��������� ���������!";
					//
					if (!strstr($alert,$changes_saved)){
						if ($alert) $alert.="\\n"; //���� ���������� ����� ���������
						$alert.=$changes_saved;
					}
				}		
			}
		}
	//���� ���� ����������, ������� �����:
	if ($alert) $Messages->alertReload($alert,"?menu=worx&amp;submenu=$_REQUEST[submenu]");?>
    
<table cellspacing="0" cellpadding="4" height="100%" style="border-bottom: solid 1px #999;">
  <tr style="height:auto;">
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap"><?
	
	//������ ����� �����:
	$Worx->buildWorxTypesList("",$_REQUEST['work_type'],true); 
	if ($test_listing){?>������ ����� �����...<? }?>&nbsp;<input style="width:120px;" type="submit" name="submit_filter" id="submit_filter" value="�������������" /></td>
<?   if ($test_table){?><td nowrap="nowrap">{������ � ������ ������ ������}</td><? }
	
	//������ � ������ ������ ������:
	$Worx->searchWithinAccount($txt_default);?>
      </tr>
    </table><!--<strong><a href="?menu=worx&amp;submenu=upload"><img src="<?=$_SESSION['SITE_ROOT']?>images/down.gif" width="16" height="16" hspace="4" vspace="4" border="0" align="absmiddle" />��������� �����...</a></strong>--></td>
  </tr>
  <tr class="txt110 authorTblRowHeader" style="height:auto;">
    <td class="iborder borderColorGray">������, ������</td>
    <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="padding-left:5px; border-left:none"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle" />&nbsp;id, <?

    if ($submenu!="upload") {

		//$addColumnSource=$submenu;
		$baskets_show=true;
		
		?><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />������,<? 

	}?><img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" />���� ������, <img src="<?=$_SESSION['SITE_ROOT']?>images/work_type.png" width="16" height="16" hspace="4" align="absmiddle" />��� ������, <img src="<?=$_SESSION['SITE_ROOT']?>images/predmet.gif" width="16" height="16" hspace="4" align="absmiddle" />�������, <img src="<?=$_SESSION['SITE_ROOT']?>images/money_giving.gif" width="13" height="16" hspace="4" align="absmiddle" />���� ����, <img src="<?=$_SESSION['SITE_ROOT']?>images/honorar.gif" width="18" height="17" hspace="4" align="absmiddle" />���� ��� ���������<? 
	if ($allow_changes){?>, <img src="<?=$_SESSION['SITE_ROOT']?>images/delete2.gif" width="16" height="14" hspace="4" align="absmiddle" /><span class="txtRed">�������</span><? }?> <span style="padding-left:40px"><?
	
	  function makeUploadButton($value,$code) {?>
        <input type="button"<?=$code?> name="button" id="button" value="<?=$value?>" onClick="location.href='?menu=worx&amp;submenu=upload'" style="color:#00F;" title="��������� ��������� ����� � ��������� �� �� �������!" /><?
	  }	makeUploadButton('����������...',false);
	  
	  	?></span></td>
  </tr>
<?	//�����!
	//��� ������ ������:
	//$author_id=$_SESSION['S_USER_ID']; echo "<div>author_id= $author_id, S_USER_ID= $_SESSION[S_USER_ID]</div>";
	$arrAuthorWorks=$Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']);
	//��� ��� ������:
	$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($arrAuthorWorks);
	//��� ������������:
	$arrAllAuthorsOrdersIDsToSend=array();
	//�������: 
	//��� ������������ ����������� ������ ������:
	$arrAuthorOrdersUnPaid=array();
	//��� ��������� ���������� ������ ������:
	$arrAuthorOrdersPaidOK=array();
	//��� ����������� ���������� ������ ������:
	$arrAuthorOrdersPaidPartly=array();
	//��� � ������� ������:
	$arrAuthorOrdersToPay=array();
	//��� ����������� ����������� �����, ��������:
	//
	if (count($arrAuthorOrders)) {
		//
		foreach ($arrAuthorOrders as $order_id) {
			
			//��� ��������� ������ � ri_worx:
			//����� � ������:
			$to_pay=$Worx->calculateLocalPrice($Worx->getWorkID($order_id)); 
			//�������� � ������������:
			$paidOK=$Money->allPaymentsInbox($order_id,true); //echo " paidOK= $paidOK";
			$paidPartly=$Money->allPaymentsInbox($order_id);
			
			//������� �����: 
			if ($to_pay&&$paidOK>=$to_pay) { 
				//���� ��������Ĩ���� �������� �������� �� ������:
				$arrAuthorOrdersPaidOK[]=$order_id;
				//���� �� ����������:
				if (!$Worx->getWorkSent($order_id)) {
					
					$arrAllAuthorsOrdersIDsToSend[]=$order_id;
				
				}elseif (!$Orders->checkOrderPaidUp($order_id)) $arrAuthorOrdersToPay[]=$order_id;
				
			}else{ //echo "<div>order_id= $order_id, to_pay= $to_pay, paidPartly= $paidPartly</div>";
				//������ �� ����������:
				if (!$paidPartly) {
					$arrAuthorOrdersUnPaid[]=$order_id;
					//echo "<span class='txtRed'>������������: order_id= $order_id</span>";
				}
				//���������� ��������
				else {
					$arrAuthorOrdersPaidPartly[]=$order_id;
					//echo "��������: order_id= $order_id";
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
 	//�����. ��������� � ����������� �������:
	$arrAuthorOrdersPaidUp=$Orders->countSoldPaidUpOrders($arrAuthorOrders);
	
	//��������: #####################################################
	  //*����� ���������� ������� ������� ���� (count($arrOrdersType))
	  //*��������� ������� ��� ���������� ����� �� ������� ��������	 
	switch ($submenu) { //� ��������:

	  	case "to_send":
		  
		  $arrOrdersType=$arrAllAuthorsOrdersIDsToSend;
		  if ($all_to_send) $worxFilter.="(".implode(",",$arrAllAuthorsOrdersIDsToSend).")";	
			break;
		
		//������������ ����������� ��� ������ ����� ����������:
		case "unpaid":
		  
		  $arrOrdersUnPaid=array_diff($arrAuthorOrders,$arrAuthorOrdersPaidOK);
		  
		  if (count($arrOrdersUnPaid)) {
			  
			  $arrOrdersType=$arrOrdersUnPaid;
			  $worxFilter.="(".implode(",",$arrOrdersType).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersUnPaid)
		  }
			break;
		
		//��������� ����������:
		case "to_pay":
			
		  if (count($arrAuthorOrdersUnPaid)) {
			  
			  $arrOrdersType=$arrAuthorOrdersUnPaid;
			  $worxFilter.="(".implode(",",$arrAuthorOrdersUnPaid).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrAuthorOrdersUnPaid)
			  
		  }
			break;
		
		//��������� ����������:
		case "sold":
		  
		  $arrOrdersType=$arrAuthorOrdersPaidUp;
		  $worxFilter.="(".implode(",",$arrAuthorOrdersPaidUp).")";//$Worx->convertArrOrdersIDsToWorxIDs($arrAuthorOrdersPaidUp)
			break;
			
		default: $arrOrdersType=$arrAuthorOrders;
	  }

	if ($worxFilter) $worxFilter="AND ri_basket.number IN $worxFilter"; 

//�������� ������ ������:
	if (isset($_REQUEST['work_type'])) 
		$sel_work_type="
   AND ri_worx.work_type = '$_REQUEST[work_type]'";
	
	$ri_where="ri_worx
  WHERE author_id = $_SESSION[S_USER_ID] $sel_work_type";
	
	$qSelAll1="SELECT * FROM $ri_where";
	
	$qSelAll="$qSelAll1
ORDER BY work_name ASC";

	//echo "��� ������ ������ (worx_id): "; $catchErrors->select($qSelAll);

	//
	$rSelAll=mysql_query($qSelAll); 
	$catchErrors->errorMessage(1,"","������ ���������� ������","qSelAll",$qSelAll); 
	$all_worx=mysql_num_rows($rSelAll);?>
      
  <tr height="100%">
    <td valign="top" nowrap="nowrap" bgcolor="#FBFBFB" id="worxSubmenu">
      <div class="txt100 paddingTop6 bold"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> ������:</div>
	  <div<? if ($submenu=="all"||!$submenu){?> class="workMenuActive"<? }?>><nobr><a href="?menu=worx">�����:</a> <?=$all_worx?>
      <a class="bold" title="�������� ������(�)" href="?menu=worx&amp;submenu=upload"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />��������...</a></nobr></div>
      <div<? if ($submenu=="to_send"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="������, ������ �� ������� ��������� ��������. �� ������ ��������� �� ���������� ��� ����� ������." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" vspace="2" border="0" align="absmiddle" /> <a href="?menu=worx&amp;submenu=to_send"<? if ($all_to_send){?> class="txtRed"<? }?>>� ��������:</a> <? echo($all_to_send)? $all_to_send:"0";?></nobr></div>
	<hr noshade>
   	  <div class="txt100 paddingTop6 bold"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=all">������</a> (<? echo (count($arrAuthorOrders)&&is_array($arrAuthorOrders))? count($arrAuthorOrders):"0";?>):</div>
  		
	<!--<hr size="1">-->
        <div<? if ($submenu=="unpaid"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="���������� � ������� ������, �� ���������� ����������." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=unpaid"> ������������</a> (<? echo(count($arrAuthorOrdersUnPaid)&&is_array($arrAuthorOrdersUnPaid))? count($arrAuthorOrdersUnPaid):"0";?>)</nobr></div>
  		
        <div<? if ($submenu=="paid_partly"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="���������� � ������� ������, ���������� ���������� �� ���������." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_partly"> ��������������</a> (<? echo(count($arrAuthorOrdersPaidPartly))? count($arrAuthorOrdersPaidPartly):"0";?>)</nobr></div>
	
    <!--<hr size="1">-->
      <div<? if ($submenu=="to_pay"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="��������� ������, �� ������� ��� ��� �� ���� ��������� ������." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=to_pay">� �������</a> (<?
        
		//�����. ���������, �� �� ����������� ������ �������:
		echo(count($arrAuthorOrdersToPay)&&is_array($arrAuthorOrdersToPay))? count($arrAuthorOrdersToPay):"0";
		
		?>)</nobr></div>

   	  <div<? if ($submenu=="sold"){?> class="workMenuActive"<? }?>><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" vspace="2" border="0" align="absmiddle" title="��������� ���������� ������, �� ������� �� �������� ������." onClick="alert(this.title);" /> <img src="<?=$_SESSION['SITE_ROOT']?>images/salary_ok.png" width="16" height="16" border="0" align="absmiddle" /> <a href="?menu=orders&amp;order_status=paid_up">���������</a> (<?	
		
		//�����. ��������� �������:
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
	
	//echo "��������� ������, � ������ ������ �������: "; $catchErrors->select($qSelCurrent);
	$rSelCurrent=mysql_query($qSelCurrent); 
	$catchErrors->errorMessage(1,"","������ ���������� ������","qSelCurrent",$qSelCurrent);
	$row_currents=mysql_num_rows($rSelCurrent);?>    
    
    <td width="100%" valign="top" class="padding0" style="border-right:solid 1px #999;">
      <table cellspacing="0" cellpadding="0" height="100%" width="100%">
        <tr height="100%">
          <td><div<? //style="height:100%; overflow:auto"?>>
<?  //
	if ( $work_subject &&
		 $work_subject!=$Worx->setSearchPreString() //���� ��������� ������ �� �������� ������� ��������
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
                <td nowrap="nowrap" style="padding-left:56px;"><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_send.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />����:&nbsp;</td>
                <td class="widthFull"><input name="work_<?=$work_number?>" type="file" class="widthFull" id="work_<?=$work_number?>" /></td>
              </tr>
            </table>
</td>
        </tr>

<?  if ($test_table){?></table><? }
}?>      
    	
        <? if ($test_table_start){?>{ ������� � ��������... }<? }?>
        
	  <table width="100%" cellpadding="3" cellspacing="0" class="listingInTbl" id="tbl_current_works">
<?	//
	$i=0;
	if ($search_handler) {
		
		//���� �������� ������ �� ����, ���������� ��������������� ������:
		$skip_diplom_zakaz=true; //��������� ����� � diplom_zakaz
		$arrAll=$Worx->findAllWorx( $work_subject,
								    $_REQUEST['work_type'], 
									false,
								    $arrDplomZakazIDsWithFiles,
								    $arr
								  );
		$all_worx=count($arr);
		
		if ($test_results){?><h4 class="padding0 Cambria">���������� ������:</h4><? }
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

		//��������� ������� ����� ����������� ������� �� ���.:
		$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
		
		//echo "<tr><td colspan=7>limit_start= $limit_start<br>limit_finish= $limit_finish<br>all_worx= $all_worx<br>current_limit= $current_limit<hr>row_currents= $row_currents</td></tr>";
			
		if ($i<$current_limit&&$row_currents)
		while ($arr = mysql_fetch_assoc($rSelCurrent)) {
			$work_number=$arr['number']; 
			//�������� ������ � ��������:
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
              <input name="save" type="submit" value="���������<? if ($submenu=="to_send"){?>/���������<? }?>" onClick="return checkPriceInt('tbl_current_works','work_price_');"></div>
            <div class="paddingTop4"><? $Blocks->makePagesNext($all_worx,$limit_finish);?></div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
	
}else{ //���� ��������� �����?>
    
<!--<h5>�������� ������ &nbsp;|&nbsp; <a href="?menu=worx">����� �����</a></h5>-->

<table width="94%" cellpadding="10" cellspacing="0" class="iborder2 borderColorOrange">
  <tr class="userMenu">
    <td colspan="3"><h2 style="display:inline;"><img src="../images/exclame_warning.png" width="32" height="32" align="absmiddle" />��������!</h2> &nbsp; [<a href="#" onClick="switchDisplay ('tbl_info');">��������/���������� �������</a>]</td>
  </tr>
  <tr valign="top" id="tbl_info">
    <td><h4>1. ������� ���������� ���������</h4>      <?=$use_docs_reducer?></td>
    <td> <h4>2. ������� ����������� ������
    </h4>
      <ul class="paddingBottom0">
      <li>�� ������ ��������� ����� ������ �������� <strong>.doc</strong>, <strong>.docx</strong> � <strong>.rtf</strong>.  ����� ���� ������ �������� �� ������� ��������� ����������������� ��������� �������, ����� �������� �� ������ �� �����.</li>
      <li>���������� �� ��������� ����� ������� ��������� ����� ������, �.�. � ������ ��������� ��� ����������� ����� �������� ����� ����������</li>
    </ul>    </td>
    <td><h4>3. �������� ��� �������� ������
    </h4>
      <div class="paddingBottom10"><span class="txtRed">���� � ��� ��������� ��������</span> � ��������� ������ ���������, �� ������ �������� �� ��� �� <nobr><a href="mailto:sale@referats.info">sale@referats.info</a>,</nobr> � �� ������� ��� �� ���!</div>
      � ���� ������ ����������� �������� ��� �����, ��������� ���� ��� �����������. 
    ��������� ��� �������������� ���������� ��������� �� ������ ������� � ������� <a href="?menu=tools&amp;point=download">�����������.</a></td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFFF99" class="txt100"></td>
  </tr>
  </table><br>
<?
//���� ��������� �����...

	if (isset($_REQUEST['files_count'])) {
		$arrWType=array();
		$arrWPrice=array();
		$arrWArea=array();
		//
		$wdata=0;
		foreach ($_POST as $key=>$val) {
			//
			if ( strstr($key,"work_type") && //�������� ��� ������
			     $key!="work_type"	//�� �� ������ � ����� ������ �� ���������
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
    <td>$arrWPrice[$i] ���.</td>
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
			
			//���� ������ ��� �������� ������:	
			if (!count($_FILES)) {

				foreach($_REQUEST as $key=>$val) $rqst.="$key=>$val\n";
			
				$subject="������ ��� �������� ������ �������  id $_SESSION[S_USER_ID] ($_SESSION[S_USER_NAME])";
				$message="��������!\n
				\n
				����� �� ���� ���������.
				\n
				Email ������: $_SESSION[S_USER_LOGIN]
				\n
				��� ������: $_SESSION[S_USER_NAME]
				\n������ ��������:
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
			
			}else{ //�� ��
			
				$subject="�������� ������ ������� id $_SESSION[S_USER_ID] ($_SESSION[S_USER_NAME])";
				$message="����������� ������: <hr> $fmess";
			
			}
			//�������� ������ ��������� � �������� ������:
			$Messages->sendEmail($toAddress,
								 $_SESSION['S_USER_LOGIN'],
								 $_SESSION['S_USER_LOGIN'],
								 $subject,
								 $message,
								 false //����������� alert
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
 <div class='paddingLeft4 paddingBottom8'><strong>��������� ����� (<?=count($_FILES)?>)</strong> &nbsp;[<a href="javascript:switchDisplay ('fuploaded');switchSwitcherText ('conceal','������','����������')"><span id="conceal">������</span></a> �������]:</div>   

<table id="fuploaded" cellspacing="0" cellpadding="4" class="iborder2 borderColorOrange" rules="rows">
  <tr class="bgF4FF bold">
    <td nowrap="nowrap">��� ������</td>
    <td>�������</td>
    <td>��� �����</td>
    <td>����</td>
  </tr>
	<?  //	
		$root=$_SESSION['DOC_ROOT']."/".$_SESSION['S_USER_ID'];
		$j=0;
		//��������� ����� � ���������� ������:
		foreach ($_FILES as $kname=>$files_fields) { //���� ���� �������� ��� ������ HTTP POST:?>

  <tr valign="top">
    <td><?=$arrWType[$j]?></td>
    <td><?=$arrWArea[$j]?></td>
    <td><?	//echo "<br>[$kname]=> ".$files_fields; 
			//���� ���������� ���� � ������ �����������:
			if (is_uploaded_file($files_fields['tmp_name'])) {
				
				//����� ��������� - � ��� �� ��� � ��������� ���������� ������ �����?
				$place_to_file_uploaded="$root/".$files_fields['name'];
				//$test_place=true;
				if ($test_place) {?>
                		
                        <div style='padding:4px;' class='iborder'>����� ���������� ������������ �����: <?=$place_to_file_uploaded?></div>
						
			<?  }
				//���� ����� ���� ��� ���� - �������� ��� ��������.
				if (file_exists($place_to_file_uploaded)) {?>
                			
                        <DIV style='padding:4px'><h4>������!</h4>
						  <div style='color:red'>���� � ������ &laquo;<?=$files_fields['name']?>&raquo; �� ��� ��������, �.�. ��� ���������� � ������ ����������.
                          </div>
						</div>
				
			<?		$upload_error="double";
					
			    }else{ 	//���� �� ���������� - 
					//���������� ���������� ���� �� ��������� ���������� � ���������� 
					//$block_upload=TRUE; //��� ������������
					if (!$block_upload) {
						//���������� ���� �� ��������� ���������� � �������:
						$upld=move_uploaded_file($files_fields['tmp_name'],$place_to_file_uploaded);
						//���� ��������:
						if (!$upld) {?>
					
					<div class="padding4"><strong>������!</strong> 
                    	���� <?=$files_fields['name']?> �� �������� � ���������� <?=$place_to_file_uploaded?>.
                    </div>
					
			 <?				$upload_error="unplaced";
			 				$Messages->sendEmail($toAddress,
												 $_SESSION['S_USER_EMAIL'],
												 $_SESSION['S_USER_EMAIL'],
												 "SUBJECT",
												 "�����",
												 false //alert
												);
			      		}
					} 
					echo $arrWType[$i]; //��� ������������ �����
				}
		    }else{ //���� ���� �� ��������:
				
					$upload_error="unuploaded";	?>
				
            	<div class="padding10 iborder"><B class="txtRed">������!</B> ���� �� ��������.
                <div>
                  <p>��������� ����� ���� ������� ������� ����� ����������� ������ �/��� ������������ �����. </p>
<p>���� ��� ������ ����������� ���������, �� ������ ������� ��� ��������� ����� ����� �� ������ sale@referats.info � 
<b>�� ��������� �� � ����� �������� ����</b>.</p>
      </div></div>
            	
		<?	}
		  	//���� �� ���� ������ �������� �����:
 		  	if (!$upload_error) {
				//var_dump($arrWType);echo "<hr>";var_dump($arrWArea);echo "<hr>";//var_dump($arrWPrice);
				//���� �� ��, ��������� ������ � ������� ����������� �����:
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
			
		  ?><a href="<?=$fname?>"><? if($test_file_name){?>��� �����...<? }?><?=$files_fields['name']
		  																								?></a></td>
    <td><?=$arrWPrice[$j]?></td>
  </tr>							
	<?		$j++;
	    }?>
</table><br />
<hr noshade size="1" />
		
<?	}?>
  <h3 class="paddingBottom10 paddingTop10"><img src="../images/flag.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />������� ����������, ��� �� ������ ��������� &#8212;</h3>
<p class="txt130">
  <input type="radio" name="volume" id="volume" value="full" onclick="document.getElementById('upload_content').style.display='block';" /> ����� ����� � ������ ������ 
  <input type="radio" name="volume" id="volume" value="annotation" onclick="document.getElementById('upload_content').style.display='block';" />
��������� ����� (��������������� ������� ������ ��� ���������)<img src="../images/info.png" width="17" height="17" hspace="4" align="absmiddle" title="����� ������ ����������� ��������� ����� �����, ����������� ���� ��������� DocsReducer&#8482;.<?="\n"?>����� ������� ���������, ��������� � ������ �����������->�������" onclick="alert(this.title);" /></p>
<p>�������� ��������, ��� � ����� ������� �������� ������ �������� ������ ������� ����� ������ ������ ����� � ������ ������, � ��� �� ������ ��������������� ����������������.</p>
<hr noshade />
<div id="upload_content" style="display:<?="none"?>;">
  
  <div class="paddingBottom6 paddingTop6">
<img src="../images/info-32.png" width="32" height="32" hspace="4" align="absmiddle" />�� ������ ��������� ������������ ����� ���������� ������, <b>����� ��������� ����� ������� �� ��������� <?
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $type="�";
			break;
        case 'm':
            $type="M";
			break;
        case 'k':
            $type="�";
			break;
    }
	echo substr($val,0,strlen($val)-1)." {$type}�";
}
echo $val." ".return_bytes(ini_get('post_max_size')); ?>.</b></div>
<ol class="content">
  <li>��� ����������� �����: <span id="file_upload"><?
	//�������� ������ ����� �����:
	$Worx->buildWorxTypesList(' style="background-color:#FFFFCC;"',false,false); ?></span></li>
  <li class="paddingTop8">���������� ����������� ������: 
    <input name="files_count" type="text" id="files_count" size="1" />
    <!-- generateFilesFields() - � index.php-->
<input onClick="generateFilesFields();" type="button" name="files_array" id="files_array" value="    OK     " /></li>
</ol>
<hr color="#FFFFFF" />

<div id="file_uploading" class="iborder2 borderColorGray">
<div class="paddingBottom6">
	<table cellspacing="0" cellpadding="8" class="userMenu">
	  <tr>
	    <td valign="top"><strong><img src="../images/exclame_warning.png" width="32" height="32" /></strong></td>
	    <td class="txt100 paddingLeft0"><strong>�����:</strong>
          <div class="txtRed t">����������, ��������������, ��� ���� ����� ����� �����, ��������������� ���� ������, �.�. � ��������� ������ �������� �� ������ �������� ������������ ������������� � � ����������!</div></td>
	    </tr>
	  </table>
	</div>
	<div class="padding8">����������� �����: &nbsp;
    					<strong>
						��� ������, &nbsp;
                        �������, &nbsp;
                        ������������, &nbsp;
                        ���� ���� ������, &nbsp;
                        ���� ��� ���������</strong>.
	</div>
</div>
<div id="div_upl_button" class="paddingTop6 paddingLeft8" style="display:<? //"none";?>"><input name="upload_all_files" type="submit" value="���������!" onClick="return checkPriceInt('file_uploading','wprice_');"></div>    
	
  </div>
    
</div><? echo "\n";
 }
