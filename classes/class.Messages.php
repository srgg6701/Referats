<?
class Messages {
	//
	function alertReload($alert,$loadPage) { //����������� �������� ���������� �������� ����� ��������� ������
		$script_close="</script>"; //�����, ������ ��� ����� DW ���������� ��������� ������� � ���������� ������.
		echo "\n";?><script language="JavaScript" type="text/javascript"><? echo "\n";
		if ($alert)
		  {?>
		alert('<? echo ($alert);?>');<?
		  }
		if ($loadPage) 
		  { if (strstr($loadPage,"back.")) 
			  { $step=substr($loadPage,5); 
				$go_location="history.back($step)";
			  }
			else $go_location="location.href='$loadPage'";
			if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_VARS'])
			  { echo "\n";?>
		if (confirm('��������� �������� ��������?\n(<?php echo $loadPage; ?>)')) <?php echo $go_location; ?>;
		
		document.write('<div style="padding:8px; border:solid 1px orange; background-color:#FFFFCC;" onmouseover="this.title=\'<?=$loadPage?>\';window.status=\'<?=$loadPage?>\';">alertReload(): �������� ��������: <a href="#" onclick="location.href=\'<?=$loadPage?>\'"><?=$loadPage?></a></div>');
		<?		die($script_close);
			  }
			else echo $go_location;
		  }?>
				</script><?
	} //	����� ������ alertReload() 
	//�������� ������ ���������:
	function buildMessListing($rSel,$user_type,$limit_mess_finish) {
		
		global $Blocks;
		global $catchErrors;
		global $Tools;
		global $Worx;

		//���������� ���������� ������:
		$qSel="SELECT * FROM ri_messages 
 WHERE ";
		//���������� ���������� ��������� �� ���.:
 		$limit_mess_start=($_REQUEST['page'])? $_REQUEST['page']*$limit_mess_finish:'0';

		//���� ��������� �������������� ������:
		if (
			( $_REQUEST['sender_user_type']&&$_REQUEST['sender_user_id'] )
			  ||
			( $_REQUEST['receiver_user_type']&&$_REQUEST['receiver_user_id'] )
			  ||
			  $_REQUEST['order_id'] 
		   ) {
			   
			if (isset($_REQUEST['order_id'])) 
				$qSel.="ri_basket_id = ".$_REQUEST['order_id'];
   
   			else {
			
				if (isset($_REQUEST['sender_user_type'])) {
				
					$user_type_direct="sender_user_type";
					$user_id_direct="sender_user_id";
				
				}else{
					
					$user_type_direct="receiver_user_type";
					$user_id_direct="receiver_user_id";
				
				}
				
				$qSel.="$user_type_direct = '$_REQUEST[$user_type_direct]'
   AND $user_id_direct = $_REQUEST[$user_id_direct]";
			}
		
		}else{

			//���������� ������ �� �����������:
			if (isset($_REQUEST['mail_direct'])) $_SESSION['S_MAIL_DIRECT']=$_REQUEST['mail_direct'];
			elseif (! $_SESSION['S_MAIL_DIRECT']) $_SESSION['S_MAIL_DIRECT']="inbox";
		
			//���������� ������ �� ������� ���������:
			if (isset($_REQUEST['messages_stat'])) $_SESSION['S_MESSAGES_STAT']=$_REQUEST['messages_stat'];
			elseif (!$_SESSION['S_MESSAGES_STAT']) $_SESSION['S_MESSAGES_STAT']="all";
				
			if ($user_type=="worker") {
				//��������:				
				$imcomingMail="
   (
     ( sender_user_type <> 'admin' 
       AND sender_user_type <> 'worker'
     )
     OR sender_user_id <> $_SESSION[S_USER_ID]
   )";
   				//���������:
				$outcomingMail="
   ( sender_user_type = 'worker'
     AND sender_user_id = $_SESSION[S_USER_ID]
   )";
			}

			if ($user_type=="author") {
			
				$imcomingMail="
   ( receiver_user_type = 'author' 
     AND receiver_user_id REGEXP '(^|,)".$_SESSION['S_USER_ID']."(,|$)' 
   )";
				$outcomingMail=" 
   ( sender_user_type = 'author' 
     AND sender_user_id = $_SESSION[S_USER_ID]
   )";
			}
			
			$all_directions="   ( $imcomingMail 
	   OR $outcomingMail
	   )";
	
			$qSelByDirect=$qSel;
			//�������� �����. ���� ��������� ��������:
			$qSelAllMess=$qSel.$all_directions;
			$rSellAllMess=mysql_query($qSelAllMess);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelAllMess",$qSelAllMess); 
			$allMess=mysql_num_rows($rSellAllMess);
			
			//������ �� �����������:
			switch ($_SESSION['S_MAIL_DIRECT'])
			  { case "inbox":
				  $qSel.=$imcomingMail;
					break;
				case "outbox":
				  $qSel.=$outcomingMail;
					break;
				case "all":
				$qSel.=$all_directions;
	   				break;
			  }
			//�������� ������� ��������� � ����������
			//���������� ������:
			$qSelMessStat="SELECT ri_messages_id FROM ri_messages_status 
WHERE user_type = '$_SESSION[S_USER_TYPE]'   
AND mess_status = '";			
			//��������� ������ �������:
			if (strstr($_SESSION['S_MESSAGES_STAT'],"unread")) {
				
				$qSelMessStat.="read' 
	AND user_id ";
				//����������� ������� �����������/������� ������������:
				$qSelMessStat.=($_SESSION['S_MESSAGES_STAT']=="unread")? "=":"<>";
				
				$qSelMessStat.=" $_SESSION[S_USER_ID] ";
				
			}else $qSelMessStat.="answer'";
						
			//$catchErrors->select($qSelMessStat);
			//
			$rSelMessStat=mysql_query($qSelMessStat);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelMessStat",$qSelMessStat);
			$arrMessFilteredByStatus=array();

			//
			while ($arr = mysql_fetch_assoc($rSelMessStat)) $arrMessFilteredByStatus[]=$arr['ri_messages_id'];

			//�������� �����������
			//������� �� ��������� �������� ��������� + ������������� ���������� ��� �����������:
			$arrAllMess=array();
			$rSelAll=mysql_query($qSel);

			//$catchErrors->select($qSel);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			while ($arr = mysql_fetch_assoc($rSelAll)) $arrAllMess[]=$arr['number'];

			//������ �������:
			$arrFilteredMessages=$Tools->arraysDiff(array($arrAllMess,$arrMessFilteredByStatus),"buildMessListing");

			//���� ����������� �� ������� ��������� (���������������� � �� ��������, � �� ���������):
			if ( $_SESSION['S_MESSAGES_STAT']!="all" &&
				 count($arrFilteredMessages) 
			   ) $qSel="SELECT * FROM ri_messages WHERE number IN (".implode(",",$arrFilteredMessages).")";
			
		}
		   
		$qSel.="
		ORDER BY number DESC";

		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); 
		//�� ������������:		
		$all_messages_direct=mysql_num_rows($rSel);
		if ($allMess&&!$all_messages_direct&&$_SESSION['S_MAIL_DIRECT']!="all") {
		
			//���� ��� ��������� �� ���������� �����������, �� ������ ��������� ���� - �������� �� ���:?>
<script type="text/javascript">
location.href="?menu=messages&amp;mail_direct=all";
</script>
<?			die();
		}
		//		
		if ($allMess){?>
<script type="text/javascript">
function applyMessFilter(sel) {
	var goPage="?menu=messages&"+sel.name+"="+sel.options[sel.selectedIndex].value;
	location.href=goPage;
}
</script>

<table cellspacing="0" cellpadding="0" height="100%" id="tbl_messages">
  <tr style="height:auto;">
    <td colspan="2" class="paddingBottom4 paddingLeft4"><?
	
	if (!$user_id_direct&&!$_REQUEST['order_id']) {?>
    �����������: 
      <select name="mail_direct" onChange="applyMessFilter(this);">
	    <option value="inbox"<? if($_SESSION['S_MAIL_DIRECT']=="inbox"){?> selected<? }?>>��������: <?
        $in=mysql_num_rows(mysql_query($qSelByDirect.$imcomingMail));
		echo($in)? $in:"0";
		?></option>
	    <option value="outbox"<? if($_SESSION['S_MAIL_DIRECT']=="outbox"){?> selected<? }?>>������������: <?
        $out=mysql_num_rows(mysql_query($qSelByDirect.$outcomingMail));
		echo($out)? $out:"0";        
		?></option>
	    <option value="all"<? if($_SESSION['S_MAIL_DIRECT']=="all"){?> selected<? }?>>���: <? 
		echo($allMess)? $allMess:"0";
		?></option>
      </select> 
      &nbsp;
    ������:
      <select name="messages_stat" onChange="applyMessFilter(this);">
        
        <option value="unread"<? if ($_SESSION['S_MESSAGES_STAT']=="unread"){?> selected<? }?>>�����������<? if ($_SESSION['S_USER_STATUS']=="super_admin"){?> ����</option>
        
		<option value="unread_by_workers"<? if ($_SESSION['S_MESSAGES_STAT']=="unread_by_workers"){?> selected<? }?>>����������� ������������<? }?></option>
        
        <option value="unanswered"<? if ($_SESSION['S_MESSAGES_STAT']=="unanswered"){?> selected<? }?>>������������</option>
        
        <option value="all"<? if ($_SESSION['S_MESSAGES_STAT']=="all"){?> selected<? }?>>���</option>
      
      </select>
      &nbsp;
    <img src="<?=$_SESSION['SITE_ROOT']?>images/filter_mail.png" width="20" height="16" hspace="4" align="absmiddle" /><?   
	
	}else{//���� ��������� ������:
				
			if (isset($_REQUEST['order_id'])) 
				$Blocks->showFilterResults( 
									"messages", 	//��� ���������� ��������
								  	"������",			//������, �� �������� �����������
								  	$_REQUEST['order_id'],		//...��� id...
								  	false,		//���� ����������� �� ���������/����������/������
								  	false	//...��� id...
									); 
			else $Blocks->showFilterResults( 
									"messages", 	//��� ���������� ��������
								  	false,			//������, �� �������� �����������
								  	false,		//...��� id...
								  	$_REQUEST[$user_type_direct],		//���� ����������� �� ���������/����������/������
								  	$_REQUEST[$user_id_direct]	//...��� id...
									); 
	}
	if ($test_filter){?>���������� �������...<? }?> &nbsp; �������� ���������: <span<? if (!$_REQUEST['sender_user_id']){?> id="all_messages"<? }?>><? echo($all_messages_direct)? $all_messages_direct:"0"; ?> �� <? echo($allMess)? $allMess:"0";?></span></td>
  </tr>

  <tr style="height:auto;" bgcolor="#F5F5F5">
    <td class="tblHeaderCellLeft">
    <img src="<?=$_SESSION['SITE_ROOT']?>images/read2.png" width="20" height="16" hspace="4" align="middle" />id, 
    <img src="<?=$_SESSION['SITE_ROOT']?>images/calendar_clock.gif" width="19" height="15" hspace="4" align="absmiddle" />����, ����� ���������,      
    <img src="<?=$_SESSION['SITE_ROOT']?>images/mail_directions.png" width="20" height="16" hspace="4" align="absmiddle" />����������� ���������,<?
			if ($user_type=="worker"){?>
    <img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" align="absmiddle" />����������,
		<?  }?>
	<img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />id ������,
    <img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" />������, ����, 
    <img src="<?=$_SESSION['SITE_ROOT']?>images/comment2.gif" width="16" height="16" hspace="4" align="absmiddle" />�����</td>
    <td align="right" class="tblHeaderCellRight" id="right_boundary"><?
    
	$this->makeNewMessageLink($_REQUEST['order_id']); 
	
	?></td>
  </tr>
  <tr height="100%">
    <td colspan="2" valign="top">
      <div<? //style="height:100%; overflow:auto;"?>>
      <table cellspacing="0" cellpadding="4" rules="rows">
<? 		//�������� ������:
		$qSel.=" LIMIT $limit_mess_start, $limit_mess_finish ";
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);	
		//echo(mysql_num_rows($rSel))? mysql_num_rows($rSel):"0";
		//
		//$i=0;
		while ($arr = mysql_fetch_assoc($rSel)){
		
			$colspan=0;?>

  		<tr style="height:auto;" valign="top" id="tr_mess_<?=$arr['number']?>">
          
          <td align="right"><? if ($test_number){?>number<? }
		  
			echo $arr['number'];  
			$colspan++;?></td>
          
          <td nowrap="nowrap"><? if ($test_datatime) {?>datatime<? }
        
	$Tools->dtime($arr['datatime']);     
	$colspan++;   
		
		?></td>
          
          <td><?
	$arrReceiverUserId=explode(",",$arr['receiver_user_id']);
//���� ����������� ������� ������� - ���������, ����� - ��������
if ( $arr['sender_user_type']==$_SESSION['S_USER_TYPE'] &&
	 $arr['sender_user_id']==$_SESSION['S_USER_ID']
   ) { //���������
		
		$respondent=$arr['receiver_user_type'];
		$direct="to_email";
		$resp_direct="receiver_user";
		
		?><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_outbox.gif" width="9" height="9" /><? 
	
}else{ //��������
		
		$respondent=$arr['sender_user_type'];
		$direct="from_email";
		$resp_direct="sender_user";
		
		?><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_inbox.gif" width="9" height="9" /><? 
	
} //echo "sender_user_type=".$arr['sender_user_type']."<br>sender_user_id=".$arr['sender_user_id']."<hr>receiver_user_type= ".$arr['receiver_user_type']."<br>sreceiver_user_id=".$arr['receiver_user_id'];
	$colspan++;?></td>
<?			if ($user_type=="worker") {?>

          <td align="center"><? 
		//���������� ����������:
        if (strstr($arr['receiver_user_id'],",")){
			
			?><img src="<?=$_SESSION['SITE_ROOT']?>images/unknown_multi.png" width="16" height="16" /><?
		
		}else{ //...��������...
			
			?><a href="?menu=messages&amp;<?=$resp_direct."_type"?>=<?=$respondent?>&amp;<?=$resp_direct."_id"?>=<?=$arr[$resp_direct."_id"]?>" title="������������� ��������� �� �����������"><?  

			switch ($respondent)  { 
				case "author":
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" border="0" /><?
					break;
			
				case "admin":case "worker":case "workers":
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" border="0" /><?
					break;
			
				case "customer":
					?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="13" height="16" border="0" /><?
					break;
				
				default: ?><img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" border="0" /><?
				
			} ?></a><?
		}
		if ($test_respondent){?>����������<? }
		
		$colspan++;
			
		?></td>

          <td><?
			//
			if (strstr($arr['receiver_user_id'],",")){
				  
				switch ($respondent)  { 

					case "author":
					  ?>������<?
						break;
				
					case "admin":case "worker":case "workers":
					  ?>����������<?
						break;
				
					default: ?>���������<?

				} 
	
			}else{
				
				?><a href="?menu=messages&amp;action=compose&amp;mailto=<?=$respondent?>&amp;user_id=<?=$arr[$resp_direct."_id"]?>" title="��������� ��������� �����������"><?=$arr[$direct]?></a><?  
			
			}	
			$colspan++;	  ?></td>
<?			}?>          
          <td align="right"><? if ($test_ri_basket_id){?>ri_basket_id<? }
		  
		if ($arr['ri_basket_id']){?><a href="?menu=messages&amp;order_id=<?=$arr['ri_basket_id']?>" title="������������� ��������� �� ������"><?=$arr['ri_basket_id']?></a><? }
		
		else echo "?";
		
		$colspan++;
		  
		  ?></td>
          
          <td width="50%" nowrap="nowrap"><? 
		  	
			$mss_read=false;
			
			if ($this->checkMessageStatus($arr['number'])=="read") {
				
				$mss_read=true;
				
				?><a href="#" onClick="manageGatewayIFrameUnread('gateway_<?=$arr['number']?>',<?=$arr['number']?>);" title="��������; �������� ��� �����������..."><? 
			
			}
			
          ?><img border="0" name="mess_stat_<?=$arr['number']?>" src="../images/<?  
		  
			//������� ������ ���������/������
			if ($this->checkMessageStatus($arr['number'])=="answer") {?>answer<? }
			else {
				if ($mss_read)	{?>read<?  }
				else {?>unread<? }
			}?>.gif" width="16" height="15" align="absmiddle" /><?
			
			if ($mss_read) {?></a><? }
		
			//��������� ������� ����� ����������:
			if ($_SESSION['S_USER_STATUS']=="super_admin") {?>
			<img src="<?=$_SESSION['SITE_ROOT']?>images/<?  
		  		
				$qSelCheckStat="SELECT ri_messages_id FROM ri_messages_status 
 WHERE user_type = 'worker' 
   AND user_id <> $_SESSION[S_USER_ID]
   AND ri_messages_id = ".$arr['number']."
   AND mess_status = ";
				//������� ������ ���������/������
				if (mysql_num_rows(mysql_query("$qSelCheckStat 'answer' LIMIT 0,1")))	{?>answer<? }
				else {
					if (mysql_num_rows(mysql_query("$qSelCheckStat 'read' LIMIT 0,1")))	{?>read<? }
					else {?>unread<? }
				}?>.gif" width="16" height="15" align="absmiddle" />
		<?	}
			
			if ($test_subject){?><a href="#">���� ���������...</a><? }
			echo "&nbsp;";
			echo (strlen($arr['subject'])>45)? "<span title='".$arr['subject']."'>".substr($arr['subject'],0,42)."..."."</span>":$arr['subject'];
			$colspan++;
		
		?></td>

          <td width="50%" nowrap class='link' id="<?=$arr['number']?>" onClick="switchDisplay ('mCell_<?=$arr['number']?>');" onMouseOver="showMessAsTitle(this);"><? if ($test_subject){?>����� ���������...<? }
		
		echo strip_tags(substr($arr['text'],0,52))."...";
		$colspan++;
		
		?><iframe id="gateway_<?=$arr['number']?>" style="display:<? 
		
		//$test_iframe=true;
		echo($test_iframe)? "block":"none";
		
		?>; width:100%" src="../manager/queries_background_gateway.php"></iframe></td>
          <td>
          	<a href="#" onclick="return deleteMessage('gateway_<?=$arr['number']?>',<?=$arr['number']?>);"><img src="../images/delete2.gif" width="16" height="14" border="0" /></a><? $colspan++; ?></td>

  		</tr>
		
        <tr>
          <td id="mCell_<?=$arr['number']?>" style='display:<?="none";?>' colspan="<?=$colspan?>">

          <div class="paddingTop6" id="answer_area_<?=$arr['number']?>"></div>
          
          <div id="mess_source_<?=$arr['number']?>"><? echo nl2br(strip_tags($arr['text']));?></div>
          
          </td>
        </tr><? echo "\n";
  			
			//$i++;
}?>
  		<tr height="100%">
  		  <td colspan="9" align="right" bgcolor="#F5F5F5"><img src="<?=$_SESSION['SITE_ROOT']?>images/lamp2.png" width="20" height="20" hspace="4" align="absmiddle" class="bgWhite iborder borderColorGray" />ٸ������ �� ������ � ��������� �������, ����� ����������/������ ������ ����� ���������.</td>
        </tr>
	  </table>
      </div>
    </td>
  </tr>
  <tr style="height:auto;">
    <td colspan="2" valign="top"><?
	
	$pageNextStyle=" style='';";
	$Blocks->makePagesNext($all_messages_direct,$limit_mess_finish);
	    
	?></td>
  </tr>
</table>
	<?	}else{?>��������� ���. <? $this->makeNewMessageLink($_REQUEST['order_id']); }
	}		//	����� ������
	//�������� ������ ���������:
	function checkMessageStatus($source_message_id) {
	
		global $catchErrors;
		if (isset($_SESSION['S_USER_TYPE'])) {
			$qSelNum="SELECT mess_status FROM ri_messages_status 
  WHERE user_type = '$_SESSION[S_USER_TYPE]'
   AND user_id = $_SESSION[S_USER_ID] 
   AND ri_messages_id = $source_message_id";
			//$catchErrors->select($qSelNum);
			$rSelNum=mysql_query($qSelNum);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelNum",$qSelNum);
			if (mysql_num_rows($rSelNum)) return mysql_result($rSelNum,0,'mess_status');
		}
	}	//	����� ������
	//��������� ��������� �������������:
	function composeNewMail(){?>      	
    <table cellspacing="0" cellpadding="4" width="<? if ($_SESSION['S_USER_TYPE']!="author"){?>100%<? }?>">
  <tr>
    <td><h4 class="padding0"><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/message.png" width="28" height="28" hspace="4" align="absmiddle" />����� ���������<? 
	
	if(isset($_REQUEST['order_id'])){?> 
    
    <a href="?menu=money&amp;order_id=<?=$_REQUEST['order_id']?>">�� ������ id <? echo $_REQUEST['order_id'];?></a><? 
	
	}

	if(isset($_REQUEST['payout_id'])){?> 
    
    �� ������� id <? echo $_REQUEST['payout_id'];?> �� ����� id <? echo (mysql_result(mysql_query("SELECT ri_basket_id FROM ri_payouts WHERE number = $_REQUEST[payout_id]"),0,'ri_basket_id')); 
	
	}
	
	?>.</nobr></h4></td>
    <td align="right" nowrap="nowrap" class="txt90 arial"><a href="?menu=messages"><img src="<?=$_SESSION['SITE_ROOT']?>images/mails.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" />������ ���������...</a></td>
  </tr>
  <tr>
    <td colspan="2"><textarea class="widthFull iborder2 padding4" style="border-color:#99C;" name="send_feedback" rows="10" title="������� ������ �������� ������ ����;
						��������� ������ + Ctrl - ��������;
						������� + Ctrl - ����� ������ � ���������� ��������."
						onClick="if (event.ctrlKey&&this.rows>1) this.rows-=3;"
						onDblClick="if (event.ctrlKey) this.rows=4; else this.rows+=4"></textarea>
      	<div class="padding4"><input type="submit" value="���������!"></div></td>
    </tr>
    </table>
	<? //<div></div>
	} //	����� ������	
	//delete
	function deleteMessage($message_id) {
	
		global $catchErrors;
		//������� ������:
		$qDel="DELETE FROM ri_messages WHERE `number` = $message_id";
		$catchErrors->delete($qDel);

	}
	//������������ ��������� ���������:
	function handleOutcomingMessage($source_message_id=false) { //echo "<h2>STARTED</h2>";
		
		global $catchErrors;
		
		foreach ($_POST as $key=>$text){
			
			//�������������� ������ ��� �����������:
			$arrName=array();
			//�������������� ������ ������ ��������������:
			$arrGateway=array(); //
			
			//���� ���������� ����� �� ���������:
			if (strstr($key,"txtarea_")) { //echo "<div>key= $key</div>";
				//����� ��������� ���������
				//�������� id ��������� ���������:
				$mess_id=substr($key,8);
				//�������� id ������:
				$qSelMessSource="SELECT ri_basket_id, sender_user_type, from_email, sender_user_id FROM ri_messages WHERE number = $mess_id"; 
				//$catchErrors->select($qSelMessSource);
				$rSelMessSource=mysql_query($qSelMessSource);
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSelMessSource",$qSelMessSource);
				if (mysql_num_rows($rSelMessSource)) $ri_basket_id=mysql_result($rSelMessSource,0,'ri_basket_id');
				
				//������� ����������, �.�. ���� �������� ��������� ����� �������� �� ������ ��� ���������, ��� ������ ���������� ���� ����������� � �����:
				$arrToAddress=array();
				$arrEmailSender=array();				
				
				//���� �������� ��������� ������������ �����������:
				if ($_SESSION['S_USER_TYPE']=="worker") {
					
					$arrToAddress[]=$from_email=mysql_result($rSelMessSource,0,'from_email');
					$sender_user_type=mysql_result($rSelMessSource,0,'sender_user_type');
					//���������� ��������� - ���, ��� ��� ������� ���������:
					$receiver_user_id=mysql_result($rSelMessSource,0,'sender_user_id');
					//echo "<div>sender_user_type= $sender_user_type, receiver_user_id= $receiver_user_id</div>";
					//�������� ������ ��������-����������� ��������� ���������, ����� ������������ ������ ��� �����������:
					switch ($sender_user_type) { 
						case "customer":
							global $Customer;
							if (!$Customer) {
								require_once ("class.Customer.php");
								$Customer=new Customer;
							}
							$Customer->getCustomerData(mysql_result($rSelMessSource,0,'sender_user_id'),false);
							$arrName[]=$Customer->name;
							$current_password=$Customer->customer_password;
							//
							$receiver_user_type="customer";
							break;

						case "author": 
							global $Author;
							if (!$Author) {
								require_once ("class.Author.php");
								$Author=new Author;
							}
							$Author->getAuthorDataAuth($from_email,false);
							$arrName[]=$Author->name;
							$current_password=$Author->pass;
							//
							$receiver_user_type="author";
							break;
					  }
					//��������� ��������� �����:
					$arrEmailSender[]=$_SESSION['S_ADMIN_EMAIL'];
					$username=$arrName[$i];
					$toemail=$arrToAddress[0];
					//�������� ������ ��������������:
					$arrGateway[]=$this->makeGatewayLink($toemail,$sender_user_type,$current_password);
					
				##################################################
				}else{ //���� ������������ ������� ��� ����������:
					
					global $Manager;
					if (!$Manager) {
						//��������! ���������� ���� �����������, ��� ����������� �� ����, ��� ������ �� ��� ��������� ���������. 
						require_once ("class.Manager.php");
						$Manager=new Manager;
					}
					$qSelMessSourceWrkrs="SELECT number FROM ri_workers"; 
					$rSelMessSourceWrkrs=mysql_query($qSelMessSourceWrkrs);
					$catchErrors->errorMessage(1,"","������ ���������� ������","qSelMessSourceWrkrs",$qSelMessSourceWrkrs);
					$sel_rows=mysql_num_rows($rSelMessSourceWrkrs);
					if ($sel_rows){
						for($i=0;$i<$sel_rows;$i++) {

							$Manager->getManagerData(mysql_result($rSelMessSourceWrkrs,$i,'number'));
							$arrToAddress[]=$Manager->email;
						  	$arrName[]=$Manager->name;
							$mlogin=$Manager->login;
							//
							$arrGateway[]=$this->makeGatewayLink($Manager->email,"worker",$Manager->password);

						}
					}
					$username="admin";				
					$toemail=$_SESSION['S_ADMIN_EMAIL'];
					$receiver_user_type="admin";
				}
				$message="������������";
				$message.=($sender_user_type)? ", ".$arrName[$i]."!
						<p>�� �������� ��������� �� <a href='http://www.referats.info'>Referats.info</a>.
						����� �������� ���, ��������� �� <a href='".$_SESSION['SITE_ROOT'].$arrGateway[$i]."&amp;answer_to=$mess_id'>������</a>.</p>":
						"!<br><br>".nl2br($text)."<hr>�������� �������� <a href='http://www.referats.info'>Referats.info</a>: ������� �������, ��������, ��������, �����������.<p>Skype: <a href='skype:eduservice'>eduservice</a></p>";
				//������ ������ ��� ��������� � �����:
				for ($i=0;$i<count($arrGateway);$i++)				
					$this->sendEmail ( $arrToAddress[$i],
									   $arrEmailSender[$i],
									   $arrEmailSender[$i],
									   "����� �� ���� ��������� �� Referats.info",
										$message,
									   "��������� ����������!"
									 );	
						
						$mss_sbj_table="����� �� ��������� # $mess_id";
						$mess_type="answer"; //echo "<div>$message</div>";
						
			###############################################################################################
				
			}elseif($key=="send_feedback") { //���� ��������� ����� ���������:
				
				//�������������� ������ ������� �����������:
				$arrToAddress=explode(",",$_REQUEST['addresses']);
				//(������ ��� ����������� ��� ��������������� �� ����� � ������� ����)

				//�������������� ���� ���������:
				$mss_sbj_table="����� ��������� �� ";
				
				//������� �������:
				switch ($_SESSION['S_USER_TYPE']) { 
					
					case "worker": //���������
					 	
						$mss_sbj_table.="Referats.info";
						//
						$fromAddress=$_SESSION['S_ADMIN_EMAIL'];
						//
						$receiver_user_type=$table=$_REQUEST['receiver_user_type'];
						
						//echo "<div>receiver_user_type= $receiver_user_type</div>";
						switch ($receiver_user_type){ 
							
							case "author":
								$table="user";
								$aemail="login";
								$apass="pass";
								break;
							case "customer":case "workers":
								$aemail="email";
								$apass="password";
								break;
								break;
						  }

						//�� ������ �������� ������� id id ���� ����������� � ���� ���� � ��������� ����� � ���� ������:
						$arrReceiversUdersIDs=array();
						//
						for($i=0;$i<count($arrToAddress);$i++) {
							//echo "<div>arrToAddress[$i]= ".$arrToAddress[$i]."</div>";
							if ($arrToAddress[$i]) {

								$qSel2Data="SELECT number, name, $apass FROM ri_$table WHERE $aemail = '".$arrToAddress[$i]."'";
								$rSel2Data=mysql_query($qSel2Data);
								$catchErrors->errorMessage(1,"","������ ���������� ������","qSel2Data",$qSel2Data);
								//$catchErrors->select($qSel2Data);
								//������� ������ ��� ����������� �: 
								$uname=mysql_result($rSel2Data,0,'name');
								$userid=mysql_result($rSel2Data,0,'number');
								//������� ������ �������������� (�� ������): 
								$arrGateway[$i]=$this->makeGatewayLink($arrToAddress[$i],$receiver_user_type,mysql_result($rSel2Data,0,$apass));
								
								//����� ���������, ������������� �� ������:
								$arrName[]=$uname;
								//���� ��� id ���������� � ������� ���������:
								$arrReceiversUdersIDs[]=$userid;
								//echo "<div>name= $uname, userid= $userid</div>";
							}
						}
						
						$toemail=($i>1)? "mass@mail":$arrToAddress[0];
						$receiver_user_id=implode(",",$arrReceiversUdersIDs);
						
						if (isset($_REQUEST['send_copy_to_me'])) {
							
							$addresses=implode(", ",$arrToAddress);
							//�������� � advanced-������ (worker):
							smtpmail (  $_REQUEST['send_copy_to_me'],		//����� ����������
										"����� ���������",			//���� ���������
										nl2br("��� - ����� ���������, ������������ �� �������:
										$addresses."),			//����� ���������
										"test@educationservice.ru",			//***����� �����������
										"test@educationservice.ru",				//***����� ��� ������
										"Admin",				//***��� ���������� ������
										"sale@referats.info",			//***����� �����������
										"Referats.info",		//***��� �����������
										$attach=false			//���� ��� ����������
									 );
						}
					break;
					
					default: //����� ������
						
						$fromAddress=$_SESSION['S_USER_EMAIL'];
						$receiver_user_type="admin";
						
						switch ($_SESSION['S_USER_TYPE']) {
							
							case "author": 
							$mss_sbj_table.="������";
							break;
						  
							case "customer": 
							$mss_sbj_table.="���������";
							break;
						
						}
					
					break;

				}
				
				for ($i=0;$i<count($arrReceiversUdersIDs);$i++) {
					
					//�������� ��������� �� ������:
					
					$message_text="������������, ".$arrName[$i]."!
					<p>�� �������� ��������� �� <a href='http://www.referats.info'>Referats.info</a>.
					����� �������� ���, ��������� �� <a href='".$_SESSION['SITE_ROOT'].$arrGateway[$i]."'>������</a>.</p>";
					
					if ($_SESSION['S_USER_TYPE']=="worker") {
					
						//�������� � advanced-������ (worker):
						smtpmail (  $arrToAddress[$i],		//����� ����������
									$mss_sbj_table,			//���� ���������
									$message_text,			//����� ���������
									$fromAddress,			//***����� �����������
									$replyTo,				//***����� ��� ������
									"Admin",				//***��� ���������� ������
									$fromAddress,			//***����� �����������
									"Referats.info",		//***��� �����������
									$attach=false			//���� ��� ����������
								 );
					
					}else
					
					$this->sendEmail ( $arrToAddress[$i],
									   $fromAddress,
									   $replyTo,
									   $mss_sbj_table,
									   $message_text,
									   false
									 );	
				}
				
				if ($i>1) {
					
					$alertMess="��������� ��������";
					$username="������ ���";
				
				}else{ 
					
					$alertMess="��������� ��������";
					$username=$arrName[0];
						
				}
				
				$this->alertReload($alertMess."!",false);
				$mess_type="new";
				
			}
			//
			if (strstr($key,"txtarea_")||$key=="send_feedback")

				//�������� ��������� � ��
				$this->writeMessTbl( $username,
									 $ri_basket_id,
									 $toemail,
									 $receiver_user_id, //� �������� id ���������� ��������� ����������� ��������� ���������. ���� ������������ ����������, �������� �����������, �.�. ��� �������� ��������� � �� ��� ������������� ���������� (���� admin)
									 $receiver_user_type, //���� ����������, �� - admin
									 $mess_type,
									 $mss_sbj_table,
									 $text,
									 $source_message_id
								   );
		}
	}	//	����� ������
	//�������� ������ ��������������:
	function makeGatewayLink($email,$user_type,$current_password) {
		
		switch ($user_type)
		  { case "customer":
			  $link="index.php?section=customer&amp;user_login=$email&amp;password=$current_password";
				break;
			case "author":
			  $link="author/?email=$email&amp;pass_current=$current_password";
				break;
			case "worker":
				global $mlogin;
			  //������� 
			  $link="manager/?login=$mlogin&amp;password=$current_password";
				break;
		  }	//echo "<div>link= $link</div>";
		//
		return $link;
	}	//	����� ������
	//
	function makeNewMessageLink($order_id=false){
		
		?><a href="?menu=messages&amp;action=compose<? if ($order_id){?>&amp;order_id=<? echo $order_id; }?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/mess_new.gif" width="17" height="16" hspace="4" vspace="6" border="0" align="absmiddle" />������� ���������<? if ($order_id){?> �� ������<? }?>...</a><? 
	
	}	//	����� ������
	//
	function queryMessBackgroundGateway() {
		
		global $catchErrors;
		
		if ($_REQUEST['message_read']||$_REQUEST['message_unread']) {
			//������ ����� ���������:
			if (isset($_REQUEST['message_read'])) 
				$this->setMessageStatus($_REQUEST['message_read'],"read");
			//������ ����� �����������:
			elseif(isset($_REQUEST['message_unread'])) $this->setMessageStatus($_REQUEST['message_unread'],"unread"); 
		}else{
		
			if (isset($_REQUEST['message_delete'])) {
				
				$mess_to_del=$_REQUEST['message_delete'];
				$this->deleteMessage($mess_to_del);?>

<script type="text/javascript">
messString=parent.document.getElementById('tr_mess_<?=$mess_to_del?>');
messString.nextSibling.style.display="none";
messString.style.display="none";
</script>
		<?	}
		}
	}	//	����� ������	
	//����� ��������� ��� �����������
	function setMessageStatus($source_message_id,$status) {
		
		global $catchErrors;
		
		if (isset($_SESSION['S_USER_TYPE'])) {

			$current_status=$this->checkMessageStatus($source_message_id);
			//���� �� ����� ��������� � ��������� ��������:		
			if (!$current_status) {
					  
				$sqlAnswer="INSERT INTO ri_messages_status ( user_type, 
                                user_id, 
                                mess_status, 
                                ri_messages_id 
                              ) VALUES 
                              ( '$_SESSION[S_USER_TYPE]', 
                                $_SESSION[S_USER_ID], 
                                '$status',
                                $source_message_id
                              )"; //����� ����� ������������ ��� � �����, ��� � ����������� �� ���������, �������������� ��������
				//��������� ������ � ��.				
				$catchErrors->insert($sqlAnswer);

			}else{ //���� ����� - �������:
			
				if ($current_status!=$status) {
					
					//��������...:
					$qUpd="UPDATE ri_messages_status SET `mess_status` = '$status' 
  WHERE user_type = '$_SESSION[S_USER_TYPE]'
   AND user_id = $_SESSION[S_USER_ID] 
   AND ri_messages_id = $source_message_id";
				$catchErrors->update($qUpd);
			
				}		
			}?>
<script type="text/javascript">
parent.document.images['mess_stat_<?=$source_message_id?>'].src="<? echo $_SESSION['SITE_ROOT']."images/".$status.".gif"; ?>";

	<?  //���� ��������������� ��������� �� �������� ��������� (�� �� ����������� �� �����������), ����� ����������� �������� ��������� �������� ���������:
		if ( strstr($_SESSION['S_MESSAGES_STAT'],"read")){?>
var countBlock=parent.document.getElementById('all_messages');
if (countBlock) {
	var wCount=parseInt(countBlock.innerHTML)
	wCount<? 
			if ($_SESSION['S_MESSAGES_STAT']==$status) {
		
		 		?>++<? 
		
			}else{
		
				?>--<? 
		
			}?>;
	countBlock.innerHTML=wCount;
}
	<? }?>
</script>
<?		}	
	}
	
	//���������� ��������� �� ������
	function sendEmail ( $toAddress,
						 $fromAddress,
						 $replyTo,
						 $mSubj,
						 $mText,
						 $alert_text=false
					   ) {
		if (!$_SESSION['S_ADMIN_EMAIL']) $_SESSION['S_ADMIN_EMAIL']="sale@referats.info";
		if (!$toAddress) $toAddress=$_SESSION['S_ADMIN_EMAIL'];
		if (!$fromAddress) $fromAddress=$_SESSION['S_ADMIN_EMAIL'];
		if (!$replyTo) $replyTo=$fromAddress;
		global $set_subject;
		if (!$set_subject) {if (!$mSubj) $mSubj="�� ������������� Referats.info";}
		else $mSubj=$set_subject;
		//���� � �������� ������:
		if (isset($_SESSION['TEST_MODE'])) { //echo "<hr>Test mode on";?>
              <div>
              ���������� ��������� �� ������:
              <div>
              ����: <?=$toAddress?><br>
              ����: <?=$mSubj?><br>
              �� ����: <?=$fromAddress?><br>
              ����� ��� ������: <?=$replyTo?>
              <hr />
              ����� ���������: <br><?=$mText?>
              </div>
              </div>

	<? }else{ //echo "<hr>Test mode off"; 

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; Windows-1251' . "\r\n";
			
			// Additional headers
			//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
			if (!$fromAddress) $fromAddress="Referats.info <sale@referats.info>";
			$headers .= 'From: '.$fromAddress."\r\n";
			//$headers .= 'Cc: srgg140201@yandex.ru' . "\r\n";
			//$headers .= 'Bcc: srgg67@gmail.com' . "\r\n";
			$bodyStart="<html>
			<head>
			  <title>��������� �� Referats.info</title>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
			</head>
			<body>";
			$bodyFinish="</body></html>";
			
		    $smail=(strstr($_SERVER['HTTP_HOST'],"localhost"))? true:mail($toAddress,$mSubj,$bodyStart.$mText.$bodyFinish,$headers);
			//���� �������� �� �������....
			if (!$smail) 
			  { //echo "<hr>!smail";?>
<div class="padding10 txtRed">��������� �� ����������...</div><? 
			  }elseif ($alert_text){ //echo "<hr>smail"; 
					if ($alert_text=="default") $alert_text="��������� ����������!\\n�� ����������� �������� ��� � ��������� �����.";
					//else echo "<hr>alert_text= $alert_text";?>
<script type="text/javascript">
alert('<?=$alert_text?>');
</script>			  
		   <? }
		  } 
	} //	����� ������
	//��������� ������� � ���������:
	function setSiteSignature($social_net) {
		$social_offer="<li>������ �������� ���������� ����� �� ������� ����� �����?! ��� ����� ��� �� ����� ��������� ������� ������!<br>������ �������� ������ �� ��� ���� � ���� ���������� ����. <p>����������� �����: <a href='$_SESSION[SITE_ROOT]?article=set_distributor_link'>$_SESSION[SITE_ROOT]?article=set_distributor_link</A></p></li>";
		$signature="
		<li>����� ���������� ��������� ������, �����������, �������� ��� �������? <a href='http://www.educationservice.ru'>EducationService.ru</a> &#8212; ��������� ������� ���� ����� �������!</li>
		<hr>� ���������� �����������,
		<br>������������� �������� �������� Referats.info.
		<hr>
		Skype: <a href='skype:eduservice'>eduservice</a>, ���. +7 904 442 84 47.</p>";
		if ($social_net) $signature=$social_offer.$signature;
		return "<hr noshade>".$signature;	
	}
	//������ ��������� � ��:
  	function writeMessTbl( $username,
						   $ri_basket_id,
						   $toemail,
						   $receiver_user_id,
						   $receiver_user_type,
						   $comment_type,
						   $subject,
						   $text,
						   $source_message_id=false
						 ) {
		global $catchErrors;		
		
		if (!$comment_type) $comment_type=$_SERVER['REQUEST_URI'];
		//����� �����������:
		if (isset($_REQUEST['email'])) 
			$from_email=$_REQUEST['email'];
		else {
			
				switch ($_SESSION['S_USER_TYPE'])  { 

					case "worker":
						$ator_email="S_ADMIN_EMAIL";
							break;
			
					case "customer":
						$ator_email="S_USER_EMAIL";
							break;
			
					case "author":
						$ator_email="S_USER_LOGIN";
							break;
				}

			$from_email=$_SESSION[$ator_email];
		}
		
		if (!$ri_basket_id) $ri_basket_id=($_REQUEST['order_id'])? $_REQUEST['order_id']:$_REQUEST['ri_basket_id'];
				
		$sql="INSERT INTO ri_messages ( name, 
                          ri_basket_id, 
                          from_email, 
                          sender_user_id, 
                          sender_user_type, 
                          to_email, 
                          receiver_user_id, 
                          receiver_user_type, 
                          datatime, 
                          type, 
                          subject, 
                          text 
                        ) VALUES 
                        ( '$username', 
                          '$ri_basket_id', 
                          '$from_email', 
                          '$_SESSION[S_USER_ID]', 
                          '$_SESSION[S_USER_TYPE]', 
                          '$toemail', 
                          '$receiver_user_id', 
                          '$receiver_user_type', 
                          '".date("Y-m-d H:i:s")."', 
                          '$comment_type', \n".//$_REQUEST[add_comment_type] - �������� ��������� (������ �����)
                          "'$subject', \n". //���� ��������� (���� ����)
                          "'$text'\n".//$_REQUEST[$text_field]
                        ")"; //����� ����� ������������ ��� � �����, ��� � ����������� �� ���������, �������������� ��������
		//��������� ������ � ��.				
		$catchErrors->insert($sql);
		//������� ����� ��������� ��� �������� ��������:
		$mysql_insert_id=($_SESSION['TEST_MODE'])? 	mysql_result(mysql_query("SELECT number FROM ri_messages ORDER BY number DESC"),'0','number')+1:mysql_insert_id();
		//���������...
		$this->setMessageStatus($mysql_insert_id,"read");
		//echo "<div>source_message_id= $source_message_id</div>";
		//���� �������� �� ���������, �������� ��������������� �����:
		if ($source_message_id) $this->setMessageStatus($source_message_id,"answer");
		
	} //	����� ������
}?>