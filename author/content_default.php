<? //echo $_REQUEST['menu'];?>
<table width="100%"<? //height="100%"?> cellspacing="0" cellpadding="0">
  <tr<? //height="100%"?>>
    <td width="40%">
      
      <div<? //style="height:100%; overflow:auto;"?>>
      
   		<table border="0" cellpadding="4" cellspacing="0">
          <tr bgcolor="#FFFF33">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><a href="?menu=worx&amp;submenu=to_send"><img src="../images/flag.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />������ � ��������:</a></h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? 
			
	//��� ������ ������:
	//��� ��� ������:
	//$author_id=$_SESSION['S_USER_ID']; echo "<div>author_id= $author_id, S_USER_ID= $_SESSION[S_USER_ID]</div>";
	$arrAuthorOrders=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($_SESSION['S_USER_ID']));
	//
	if (count($arrAuthorOrders)) {
		$arrAllAuthorsOrdersIDsToSend=array();
		//
		foreach ($arrAuthorOrders as $order_id) {
			
			//��� ��������� ������ � ri_worx:
			//����� � ������:
			$to_pay=$Worx->calculateLocalPrice($Worx->getWorkID($order_id)); 
			//�������� � ������������:
			$paidOK=$Money->allPaymentsInbox($order_id,true); //echo " paidOK= $paidOK";
			$paidPartly=$Money->allPaymentsInbox($order_id);
			
			//������� �����: 
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
            <td bgcolor="#FFFFFF">��������� ���������� ����������� ������. �� ������ ��������� �� ��� ����� ������!</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFE3FF">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />����� ������:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_orders)? $new_orders:"0";?></td>
            <td bgcolor="#FFFFFF">������ �� ���� ������, ����������� � ������� ��������� �������� ���������.</td>
          </tr>
          <!--<tr>
		<td>�����</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>��� ����������</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>������������</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#EAF8F8">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/mails.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" />����� <a<? // href="?menu=messages"?>>���������</a>:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_messages)? $new_messages:"0";?></td>
            <td bgcolor="#FFFFFF">����� �������� ���������, ����������� � ������� ��������� �������� ���������.</td>
          </tr>
          <!--<tr>
            <td>�����</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>�����������</td>
            <td>&nbsp;</td>
          </tr>-->
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr bgcolor="#E3FFE3">
            <td valign="top" nowrap="nowrap" class="iborder borderColorGray" style="border-right:none;"><h4 class="padding0"><img src="../images/flag_green1.gif" width="16" height="16" border="0" align="absmiddle" /><img src="../images/pay_in.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />����� <a<? // href="?menu=money"?>>�������</a>:</h4></td>
            <td align="right" valign="top" class="iborder borderColorGray" style="border-left:none;"><? echo ($new_payouts)? $new_payouts:"0";?></td>
            <td bgcolor="#FFFFFF">����� ������� �� ��������� ������, ���������� ����� ��������������� ��������������.</td>
          </tr>
          <!--<tr>
            <td>����������</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>�����</td>
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
          <td><h4 class="padding0"><img src="../images/info-32.png" width="32" height="32" hspace="10" align="absmiddle" />��������!</h4>
          <div class="txt110 padding10 paddingLeft10 paddingBottom20"><?=$use_docs_reducer?></div></td>
        </tr>
        <tr style="height:auto;">
          <td><h4 class="padding0 paddingBottom6"><img src="<?=$_SESSION['SITE_ROOT']?>images/lamp2.png" width="20" height="20" align="absmiddle" />������� �� �������� ��������.</h4></td>
        </tr>
        <tr<? //height="100%"?>>
          <td><div<? //style="height:100%; overflow:auto"?>>
        <table height="100%" cellspacing="0" cellpadding="4" class="iborder" rules="rows" style="border-color:#CCC;">
<? 
$arrMenusColors=array('FFE3FF','E3FFE3','EAF8F8','FFFF99','CCCCFF','EFEFEF','CCFFFF');
$clr=-1; //�.�. ����� ������ �������� ����� ���������.
//class.Blocks
foreach($arrMenus as $point=>$menu) {
	if ($point!="default"){?>
      <tr valign="top" style="height:auto;">
        <td bgcolor="<? echo "#".$arrMenusColors[$clr];?>"><a href="?menu=<?=$point?>" class="bold"><?=$menu?></a></td>
        <td width="100%"><?
    
		switch($point) { 
			
			case "worx":?><div>
				<p>������, ���������� ��� ���������� ����� ����� &#8212; ��������, ������ � �������� � ������� ��������� ������ ������. ������ ����� ����������� �� ���������� ���������. </p>
				<ol class="content">
				  <li>�� ����� ����� &#8212; ���������, ��������, �������� � ����.</li>
				  <li>�� ��������� �������:</li>
				  <div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=unpaid">������������</a> &#8212; ���������� ����������� � ������� �������, �� ��� �������� ����������.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_partly">��������������</a> &#8212; �� ��������� ���������� �����������.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" hspace="4" border="0" align="absmiddle" /><a href="?menu=orders&amp;order_status=to_pay">� �������</a> &#8212; ��������� ����������, �� �� ������� �������� �������� Referats.info � ���� ��� �� �����������.</div>
					<div class="paddingTop6"><img src="<?=$_SESSION['SITE_ROOT']?>images/salary_ok.png" width="16" height="16" hspace="4" align="absmiddle" /><a href="?menu=orders&amp;order_status=paid_up">���������</a> &#8212; ��, �� ������� �� �������� ������� � ������ ������.</div>
				</ol>
				<p>����� ������ ��������� ��� <strong><a href="?menu=worx&amp;submenu=upload"><img src="../images/arrow_up_send.png" width="16" height="16" hspace="4" border="0" />��������� ����� ������</a></strong> � ��������� �� �� �������. </p></div><? break;
			case "money":?><div>���������� �������� �� ��������� ������ � �������� ��������� Referats.info.</div><? break;
			case "messages":?><div>������� ��������� ����� ���� � �������������� �������� ��������. </div><? break;
			case "data":?><div>���� ��������������� ������ &#8212; �������� � ��������������. </div><? break;	
			case "tools":?>
				<div>��������� �������������� ���������� ������ ����� � ���������� �� ����� �������� �������� (<a href="?menu=tools&amp;point=howitworks">DocsReducer&#8482;</a>). </div><? break;
			case "faq":?><div>������ �������� ���������� �������� � ������� �� ���. </div><? break;
			case "author_agreement":?><div>���������������� ���������� ����� ����� �������� ��������� � ����, ��� ������������� ���������� �����.</div><? break;	
			case "feedback":?><div>�������� ����� � �������������� �������. </div><? break;	
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

