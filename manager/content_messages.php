<? 

if (isset($_REQUEST['mailto'])) 
	$mailto=$_REQUEST['mailto'];
if (isset($_REQUEST['user_id'])) 
	$user_id=$_REQUEST['user_id'];
if (isset($_REQUEST['work_id'])) 
	$work_id=$_REQUEST['work_id'];

//
if (isset($_REQUEST['actor'])) { //echo "<h3>START </h3>";

	require_once('../connect_db.php');
	require_once('../classes/class.Errors.php');
	require_once('../classes/class.Tools.php');
	require_once("../classes/class.Actors.php");
	$catchErrors=new catchErrors;
	$Tools=new Tools;
	$Actors=new Actors;
	$Actors->buildActorsPage($_REQUEST['actor']);
}
if (!$_REQUEST['menu']&&!$_REQUEST['actor']&&!$mailto) {

	session_start();

	?><div class="txt110" align="center"><img src="<?=$_SESSION['SITE_ROOT']?>images/frame_up_green.png" width="25" height="25" hspace="4" align="absmiddle" />�������� ��� �����������</div><? 

}
//����� ���������:
if ($_REQUEST['action']=="compose") {
	
	//�������� ������ ���������:
	if (!isset($actor)) {?>

<table width="100%" height="<? if (!isset($_SESSION['TEST_MODE'])){?>100%<? } else echo "400";?>" cellpadding="4" cellspacing="0">
  <tr>
	<td width="45%" rowspan="2" valign="top">
	  <div style="height:100%; overflow:auto">
		<? $Messages->composeNewMail(); 
		if ($test_compose){?>����� ������ ���������...<? }?></div>
        <input name="addresses" id="addresses" type="hidden">
        <input name="receiver_user_type" id="receiver_user_type" type="hidden"></td>
	<td width="55%" valign="top" nowrap="nowrap" class="padding10 txt100" style="height:auto;"><?
    
		if ($work_id||$mailto) {
		
			?><strong class="arial paddingLeft10">��������� ��� <?
            
			switch ($mailto) { 
				
				case "workers":
				  
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />���������� id <? echo $user_id;
					
					break;
				
				case "author":
				  
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />������ <? 
					if ($work_id){
						
						?>������ id <? echo $work_id; 
					
					}elseif ($user_id){?>id <?=$user_id?> <span class="txtGrayCCC"><?
						
						//������ ������ �� ��� id:
						$Author->getAuthorDataById($user_id);
						echo $Author->login; ?></span><?	
					
					}
					
					break;
				
				case "customer":
				
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="13" height="16" hspace="4" border="0" align="absmiddle" />��������� id <? echo $user_id;
				
					break;
			  }

			
			/*if ($mailto!="customer"){?><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />������ <? 
				if ($work_id){
					
					?>������ id <? echo $work_id; 
				
				}elseif ($user_id){?>id <?=$user_id?> <span class="txtGrayCCC"><?
					
					//������ ������ �� ��� id:
					$Author->getAuthorDataById($user_id);
					echo $Author->login; ?></span><?	
				
				}
				
			}else{
				
				?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="13" height="16" hspace="4" border="0" align="absmiddle" />��������� id <? echo $user_id;	
				
			}*/?>.</strong><?
		
		}
		if (!$mailto) { 

			//�������� ������������� ������ � � ������ �������:
			if (isset($_REQUEST['order_id'])) 
				$work_id=$Worx->getWorkID($_REQUEST['order_id']);
			if ($work_id) $author_id=$Author->getAuthorIdByWorkId($work_id);
			if (!$author_id&&$work_id) {?>
	  <div class="paddingBottom10">
			<div class="txt100 padding10 iborder borderColorGray bgGrayLightFBFBFB"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_triangle.png" width="15" height="15" vspace="2" align="left" /> ������ id <?=$work_id?> �������� �������������� Referats.info.</div>	
		</div>
		<?	} ?><div align="center">��� �����������:&nbsp; 
        &nbsp; 
        <a href="content_messages.php?actor=author<? 
		
		if (isset($_REQUEST['order_id'])) {?>&amp;user_id=<? echo $author_id; }?>" target="actors"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /><strong>�����</strong></a> 
        &nbsp;
        <a href="content_messages.php?actor=customer<? 
		
		if (isset($_REQUEST['order_id'])) {?>&amp;user_id=<?
		//�������� ���������:
		echo $Customer->getCustomerIdByOrderID($_REQUEST['order_id']); }?>" target="actors"><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="13" height="16" hspace="4" border="0" align="absmiddle" /><strong>��������</strong></a>
        &nbsp;
        <a href="content_messages.php?actor=workers" target="actors"><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /><strong>���������</strong></a>        
    </div><?
		}?></td>
  </tr>
  <tr>
	<td height="100%" valign="top"><?
    
		//if (!$_REQUEST['work_id']) {	
		
			?><div class="padding10 paddingTop0">
        <iframe src="content_messages.php?<? 
			
			if ($work_id){
				?>work_id=<? echo $work_id;?>&amp;<? 
				
				if ($mailto) {
					//������� id ������:
					if ($mailto=="author") $user_id=$author_id=$Author->getAuthorIdByWorkId($work_id);
				}			
			} 
			if ($user_id) {?>user_id=<? echo $user_id;?>&amp;<? }
			if ($mailto) {?>mailto=<? echo $mailto;}?>" frameborder="0" name="actors" class="iborder2 borderColorGray" style="height:<? if($_REQUEST['order_id']||$work_id||$user_id) echo "160px"; else{?>100%<? }?>; width:90%;"></iframe>
            
            </div><?		  		
			
		if ($work_id||$_REQUEST['order_id']) {
		
			?><div class="padding10 paddingTop0"><h4 class="padding0 paddingLeft4 paddingBottom6 txtGreen"><img src="<?=$_SESSION['SITE_ROOT']?>images/database_table.png" width="32" height="32" align="absmiddle"> ������:</h4>
 		<?  //������� ������ ������:
			if ($author_id) $arrAuthorData=$Author->getAuthorDataById($author_id); ?>    
           
          <table cellspacing="0" cellpadding="0" class="iborder" bordercolor="#CCCCCC" rules="rows">
  <tr class="bgGrayLightEFEFEF">
    <th nowrap class="padding4"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />�����</th>
    <th nowrap class="padding4"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle">������</th>
  </tr>
  <tr>
    <td valign="top"<? if(!$author_id){?> bgcolor="#E3FEFF" class="padding10"<? }?>>
 <? if ($author_id){?>	       
    <table width="100%" cellpadding="4" cellspacing="0">
      <tr>
        <td align="right"><strong>���</strong></td>
        <td><?=$arrAuthorData['name']?>&nbsp;</td>
      </tr>
      <tr class="bgGrayLightFBFBFB">
        <td align="right"><strong>����� ����������</strong></td>
        <td><?=$arrAuthorData['city']?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>���.���.</strong></td>
        <td><?=str_replace(",","<br>",$arrAuthorData['mobila'])?>&nbsp;</td>
      </tr>
      <tr class="bgGrayLightFBFBFB">
        <td align="right"><strong>���. ���.</strong></td>
        <td><?=str_replace(",","<br>",$arrAuthorData['phone'])?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>���. 2</strong></td>
        <td><?=$arrAuthorData['dopphone']?>&nbsp;</td>
      </tr>
      <tr class="bgGrayLightFBFBFB">
        <td align="right"><strong>���. ���.</strong></td>
        <td><?=$arrAuthorData['workphone']?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>Skype</strong></td>
        <td><?=$arrAuthorData['skype']?>&nbsp;</td>
      </tr>
      <tr class="bgGrayLightFBFBFB">
        <td align="right"><strong>icq</strong></td>
        <td><?=$arrAuthorData['icq']?>&nbsp;</td>
      </tr>
    </table><?
 	}else{?>
    <h3><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/document_edit.png" width="32" height="32" align="absmiddle" /><img src="<?=$_SESSION['SITE_ROOT']?>images/document_search.png" width="32" height="32" hspace="2" align="absmiddle" /> Referats.info</nobr></h3><? }?></td>
    <td valign="top" style="border-left:1px solid #CCC;">
    <table width="100%" cellpadding="4" cellspacing="0">
      <tr>
        <td align="right"><strong>����</strong></td>
        <td><?
	//�������� ��� ������:
	$table=($author_id)? "ri_worx":"diplom_zakaz";
	echo $Worx->getWorkName($table,$work_id);?>&nbsp;</td>
      </tr>
      <tr><? 
	//�������� ��� ������ � �������:
	$Worx->getWorkAreaAndType($table,$work_id);
	  
	  //�������� ����� ���������� �������:
	  	//������� ���������� ������� ������ ������:
	  	if (isset($_SESSION['TEST_MODE'])) echo "<h6>getWorkOrdersValue (content_messages.php)</h6>";
		$Worx->getWorkOrdersValue (false,$work_id,false);
		$arrWorkOrdersIDs=$Worx->arrWorkOrdersIDs; //var_dump($arrWorkOrdersIDs);
		//���� ������:
		if($author_id)	{
			$price=$Worx->calculateLocalPrice($work_id);
			$summ_to_pay=$Worx->calculatePureLocalPrice($work_id);
		}else $price=$summ_to_pay=$Worx->calculateWorkPrice($table,$work_id);?>
        
        <td align="right"><strong>���</strong></td>
        <td><?=$Worx->work_type?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>�������</strong></td>
        <td><?=$Worx->work_area?>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>����</strong></td>
        <td><?=$summ_to_pay?>&nbsp;</td>
      </tr>
      <tr><?
		//� ��������: 
			//��������� �������� 
			//�����/ ����������
		//�� ��������: 
			//��� 
			//�����/ ��������� ����������
		//� �������:
			//������������
			//�����/ �����������
		//�����������:
			//������: ������ ��������� / ��������� 
		//�������:
			//��� ��������� ���������� � ����������
		$arrPaidFull=array(); //��������� ��������
		$arrSent=array(); //����������
		$arrPaidUp=array(); //�����������
		$arrSold=array(); //�����������
		
		for($i=0;$i<count($arrWorkOrdersIDs);$i++) {
			
			$paidOK=false;
			$paidSumm=$Money->allPaymentsInbox($arrWorkOrdersIDs[$i],true);
			//echo "<div>paidSumm= $paidSumm, price= $price</div>";
			if ($paidSumm>=$price) { 
				$arrPaidFull[]=$arrWorkOrdersIDs[$i];
				$paidOK=true;
			}
			if ($Worx->getWorkSent($arrWorkOrdersIDs[$i])) {
				$arrSent[]=$arrWorkOrdersIDs[$i];
				if ($paidOK) $arrSold[]=$arrWorkOrdersIDs[$i];
			}
			//���������� ��� ��������� ���������� �������:
			if ($Author->calculateAuthorPayOuts(false,$arrWorkOrdersIDs[$i])>=$price) $arrPaidUp[]=$arrWorkOrdersIDs[$i];
			
		}
		//to send:
		$arrToSend=$Tools->arraysDiff(array($arrPaidFull,$arrSent));
		//�� �������� (�����������):
		$arrUnPaid=$Tools->arraysDiff(array($arrWorkOrdersIDs,$arrPaidFull));
		//� ������� ������:
		if ($autor_id) $arrToPay=$Tools->arraysDiff(array($arrToSend,$arrPaidUp));?>
        <th colspan="2" align="center" bgcolor="#EAFFEA"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle"><a href="?menu=orders&amp;work_id=<?=$work_id?>" title="��������� ��� ������ �� ������">������</a> <span class="noBold">(�����: <?=count($arrWorkOrdersIDs)?>)</span></th>
        </tr>
      <tr>
        <td nowrap><strong><?
        if ($author_id){?><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />� ��������<?
		}else{?><img src="<?=$_SESSION['SITE_ROOT']?>images/access_rights.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />��������� ��������<? }?></strong></td>
        <td align="right"><? echo (count($arrToSend)&&is_array($arrToSend))? count($arrToSend):"0";?></td>
      </tr>
      <tr>
        <td nowrap><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" align="absmiddle">�� ��������</strong></td>
        <td align="right"><? echo (count($arrUnPaid)&&is_array($arrUnPaid))? count($arrUnPaid):"0";?></td>
      </tr>
      <tr>
        <td nowrap><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" hspace="4" border="0" align="absmiddle">� �������</strong></td>
        <td align="right"><? echo (count($arrToPay)&&is_array($arrToPay))? count($arrToPay):"0";?></td>
      </tr>
      <tr>
        <td nowrap><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_out.png" width="16" height="16" hspace="4" border="0" align="absmiddle">���������</strong></td>
        <td align="right"><? echo (count($arrPaidUp)&&is_array($arrPaidUp))? count($arrPaidUp):"0";?></td>
      </tr>
      <tr>
        <td nowrap><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/salary_ok.png" width="16" height="16" hspace="4" border="0" align="absmiddle">�������</strong></td>
        <td align="right"><? echo (count($arrSold)&&is_array($arrSold))? count($arrSold):"0";?></td>
      </tr>
    </table></td>
    </tr>
</table></div><?	

		}?></td>
  </tr>
</table>

<? }		
	
}else{
	
	if ($menu=="messages") { //������� ������ ���������: 	

		$Messages->buildMessListing($rSel,"worker",20);

	}elseif(isset($_REQUEST['mailto'])) {
		
		//echo "<h1>NO menu!</h1>";
		
		require_once('../connect_db.php');
		require_once("../classes/class.Actors.php");
		require_once('../classes/class.Errors.php');
		$catchErrors=new catchErrors;
		$Actors=new Actors;
		$Actors->buildActorsPage($_REQUEST['mailto']);
	
	}
} 

//
foreach($_POST as $key=>$val) 
	if (strstr($key,"send_answer")) 
		$source_message_id=substr($key,12);
//echo "<div>source_message_id= $source_message_id</div>";

if ($_POST['send_feedback']||$source_message_id) { 	//echo "<h2>��������!</h2>";
	
	if (isset($_POST['send_feedback'])) require_once("../mail/lib_mail_smtp.php");
	//���������� ��������� ���������:
	$Messages->handleOutcomingMessage($source_message_id);
	
}?>