<? 

require("../classes/class.dbSearch.php");
$dbSearch=new dbSearch;

//���� ����� ������� ����:
//$Worx->deleteSingleFile("?menu=worx"); 
//
$arrDplomZakazIDsWithFiles=$Worx->getDplomZakazIDsWithFiles(); 
//echo "<hr>count= ".count($arrDplomZakazIDsWithFiles)."<hr>";
$show_all=true;

$arrAll=$arrAllMax=$Worx->findAllWorx ( false, //���������� �������� ���� ������
										false, //���������� �������� ��� ������, ����� ����� ��������� ���������� �������� ������ ����� ���������. ������������ �������� ���������, �� ��� � ��� ������ 
										false,
										$arrDplomZakazIDsWithFiles, //������ � diplom_zakaz
										$arr
									  );

unset($show_all);

$all_worx_start=$all_worx=count($arrAll); 

############################################################
//�����!
//��� ������:
$arrAllAuthorsWorks=$Author->getAllAuthorsWorxNumbers(false);
//��� ������:
$arrAllAuthorsOrdersNumbers=$Author->getAllAuthorsOrdersNumbers($arrAllAuthorsWorks); 	
//echo "count(\$arrAllAuthorsOrdersNumbers)=".count($arrAllAuthorsOrdersNumbers)."<hr>";
//�������: 
//��� ��������� ���������� ������ ������:
$arrAllAuthorsOrdersPaidOK=array();

############################################################
//������� ��� ������ �� ��������:
$Orders->getOrdersArraysByTypes();
$all_orders_exists=$Orders->all_orders_exists;


//��� ������������ ����������� ������:
$arrOrdersUnpaid=$Orders->arrOrdersUnpaid;
//echo "<hr>"; var_dump($arrOrdersUnpaid);
//��������������, ��� ����
$arrOrdersPaidNoPrice=$Orders->arrOrdersPaidNoPrice;

//��� ������������:
$arrOrdersPaidNotSent=$Orders->arrOrdersPaidNotSent;
//$arrOrdersPaidNotSent=array();
//��� ��������� (�.�., - ���������� � ��, � ������� ��� ������ ������):
$arrOrdersPaidSent=$Orders->arrOrdersPaidSent;
//���, ������������� �������:
$arrOrdersToPay=$Orders->arrOrdersToPay;
//$arrOrdersToPay=array();
//����������� �������:
$arrOrdersPaidUp=$Orders->arrOrdersPaidUp;

//���� ���� ��������� ������:
if (count($arrAllAuthorsOrdersNumbers)) {

	if (count($arrOrdersPaidNotSent)) {
		
		$arrWorxToSend=$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersPaidNotSent);
		$all_to_send=count($arrWorxToSend);
	}
}
			
//��������: #####################################################
  //*����� ���������� ������� ������� ���� (count($arrOrdersType))
  //*��������� ������� ��� ���������� ����� �� ������� ��������

$worxFilterIN="(0)";
 
switch ($submenu) { //� ��������:

	//������������ �����������:
	case "unpaid":
		$arrAllListing=$Worx->parseWorxForTables($arrOrdersUnpaid);
		break;
	
	//������������ �����������:
	case "paid_no_price":
		$arrAllListing=$Worx->parseWorxForTables($arrOrdersPaidNoPrice);
		break;
	
	//��������� ����������:
	case "to_pay":
		$arrAllListing=$Worx->parseWorxForTables($arrOrdersToPay);
		break;
	
	case "to_send":
	  
	  $arrOrdersType=$arrOrdersPaidNotSent;
	  if ($all_to_send) $worxFilterIN="(".implode(",",$arrOrdersPaidNotSent).")";	
		break;
	
	//��������� ����������� �������:
	case "sold":
	  $arrOrdersType=$arrOrdersPaidUp;
	  $worxFilterIN="(".implode(",",$arrOrdersPaidUp).")";
		break;
	
	//��� ���������:	
	case "sold_orders":
	  $arrAllListing=$Worx->parseWorxForTables($arrOrdersPaidSent);
	  //$arrOrdersPaidSent;
		break;
} 

if (!is_array($arrAllListing)) { //���� ��������� submenu, �� �� ������ ���� ��������� � ����������
  
	//echo "<div class='txtRed'>!arrAllListing</div>";
	if ($submenu&&$submenu!="all") {
		
		$worxFilter="  
   AND ri_basket.number IN $worxFilterIN";
			
	if (isset($_SESSION['FILTER_WORX_TYPE'])) $andWorxType="
   AND ri_worx.work_type = '$_SESSION[FILTER_WORX_TYPE]'";
	
	$qSelSubmenu="SELECT ri_worx.* FROM ri_worx,ri_basket 
WHERE ri_basket.work_id = ri_worx.number 
   $worxFilter $andWorxType ORDER BY work_name ASC";
	
	//echo "������ ��� ������������ ������� ���������� ������ ����� (\$arrAllListing):<br>"; 	
	//$catchErrors->select($qSelSubmenu);

	$rSelSubmenu=mysql_query($qSelSubmenu); 
	$catchErrors->errorMessage(1,"","������ ���������� ������","qSelSubmenu",$qSelSubmenu); 

	if (mysql_num_rows($rSelSubmenu)) {
		//work_table=>diplom_zakaz
		//work_id=>9433
		//work_subject=>������-�����
		//work_type=>������
		//work_area=>����������, ���������� ����������
		//���������� ������ ������ �����:
		$arrAllListing=array();
		$arrAllWorxUnique=array();
		$ww=0;
		while ($arr = mysql_fetch_assoc($rSelSubmenu)) {
	
			//���� ��������� id ������ �������:
			if (!in_array($arr['number'],$arrAllWorxUnique)) { 
				
				$arrAllWorxUnique[$arr['number']]=$arr['number'];
			
				$arrAllListing[$ww]=array();
				$arrAllListing[$ww]['work_table']="ri_worx";			
				$arrAllListing[$ww]['work_id']=$arr['number'];			
				$arrAllListing[$ww]['work_subject']=$arr['work_name'];			
				$arrAllListing[$ww]['work_type']=$arr['work_type'];			
				$arrAllListing[$ww]['work_area']=$arr['work_area'];		
				
				$ww++;
			}
		} //foreach($arrAllListing as $key=>$array) { echo "<div>$key=>"; foreach($array as $key=>$val) echo "<div>$key=>$val</div>"; echo "<div>"; }
	} 
  }
}

//���� ����������� �� ���� ������, �� �������������� ��� �� ������:
if ( $_REQUEST['affiliation'] || $_REQUEST['work_type'] || $_REQUEST['author_id'] || $_REQUEST['work_subject'] ) {
	
	$submenu="cancel";
	$author_id=$_REQUEST['author_id']; //��� �������� � ������� � ���� global
	//echo "<h2>�������������!</h2>";
	$arrAllListing=$arrAll=$Worx->findAllWorx ( $_REQUEST['work_subject'],
												$_SESSION['FILTER_WORX_TYPE'], 
												false,
												$arrDplomZakazIDsWithFiles,
												$arr
											  );
}
##################################################################################

//���� �� �������� ������ ������/������, ����������� � �������� ������-������� ��������������:
if ((!$submenu||$submenu=="all")&&!$author_id) $arrAllListing=$arrAll;
$all_worx=count($arrAllListing);

##################################################################################?>

<table width="100%" height="100%" cellpadding="4" cellspacing="0" style="border-bottom: solid 1px #999;">
  <tr style="height:auto;">
    <td colspan="2"><table cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap">��������������: 
		<select name="affiliation">
		  <option value="all">���</option>
		  <option style="background-color:#CFC;" value="own"<? if ($_SESSION['FILTER_WORX_AFFILIATION']=="own"){?> selected<? }?>>�����������</option>
		  <option style="background-color:#FCF;" value="alien"<? if ($_SESSION['FILTER_WORX_AFFILIATION']=="alien"){?> selected<? }?>>�����</option>
        </select><?
	
	//������ ����� �����:
	$Worx->buildWorxTypesList("",$_SESSION['FILTER_WORX_TYPE'],true); 
	
	if ($test_listing){?>������ ����� �����...<? }?>&nbsp;<input style="width:120px;" type="submit" value="�������������" /> &nbsp; <? 
	if ( $_SESSION['FILTER_WORX_AFFILIATION']!="all" ||
		 $_SESSION['FILTER_WORX_TYPE'] ||
		 $_REQUEST['author_id']
	   ) {?><img src="<?=$_SESSION['SITE_ROOT']?>images/filter_order.png" width="22" height="16" hspace="4" align="absmiddle" /><?
		   
		   if (isset($_REQUEST['author_id'])) {?>
			 ������ <img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />������ id <? echo $_REQUEST['author_id']; 
		   }else{

			   if (isset($_SESSION['FILTER_WORX_AFFILIATION'])) {?>
				 <!--�������������� �����: --><? 
				 $comma=", ";
				 switch($_SESSION['FILTER_WORX_AFFILIATION']) {
					 case "own":
						?>�����������<?
					 break;
					 case "alien":
						?>�����<?
					 break;				 
					 default: ?>���<?
				 }  
			   }
			   
			   if (isset($_SESSION['FILTER_WORX_TYPE'])) {
				   
				   echo $comma;
				   
				   ?><!--��� �����: --><? 
				   echo $_SESSION['FILTER_WORX_TYPE'];
				}
		   
		   }?> [ <a href="?menu=worx" class="bold">�������� ������</a> ]<? 
	
	}?>        <!-- name="submit_filter" id="submit_filter"--></td>

      </tr>
    </table> 	</td>
  </tr>
  <tr class="txt110 authorTblRowHeader" style="height:auto;">
    <td class="iborder borderColorGray">������, ������</td>
    <td width="100%" nowrap="nowrap" class="iborder borderColorGray" style="padding-left:5px; border-left:none">
    <img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle" />id ������, 
	<img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" />������ ������,
    <img src="<?=$_SESSION['SITE_ROOT']?>images/file_name.gif" width="18" height="18" hspace="4" align="absmiddle" />���� ������, 
    <img src="<?=$_SESSION['SITE_ROOT']?>images/work_type.png" width="16" height="16" hspace="4" align="absmiddle" />��� ������, 
    <img src="<?=$_SESSION['SITE_ROOT']?>images/predmet.gif" width="16" height="16" hspace="4" align="absmiddle" />�������, 
    <img src="<?=$_SESSION['SITE_ROOT']?>images/honorar.gif" width="18" height="17" hspace="4" align="absmiddle" />���� ��� ���������<!--, <span class="txtRed">�������</span>--></td>
  </tr>
  <tr height="100%">
    <td valign="top" bgcolor="#FBFBFB" id="worxSubmenu" class="padding0">
    <table style="border-left:none; border-right:none; border-top:none;" cellpadding="0" cellspacing="0" rules="rows" class="txt120">
    	<colgroup>
        	<col>
        	<col>
        	<col align="right">
        	<col>
        	<col align="right">
        </colgroup>
      <tr class="bgYellowFadeTop">
    	<td colspan="7" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="padding6"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> <strong>������</strong> &gt; <img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" vspace="2" border="0" align="absmiddle" /> <strong>������</strong></nobr></td>
    </tr>
  	<tr<? if ($submenu=="all"||!$submenu){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="16" height="16" hspace="5" vspace="4" /></td>      
      <td>�����:</td>      
      <td>&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=all">
      <?=$all_worx_start?>
    </a></td>
      <td align="center" class="padding4">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=all"><? echo($all_orders_exists)? $all_orders_exists:"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="txtRed<? if ($submenu=="to_send"){?> workMenuActive<? }?>">
      <td nowrap="nowrap"><img src="<?=$_SESSION['SITE_ROOT']?>images/arrow_up_if_send.png" width="16" height="16" hspace="5" vspace="4" border="0" align="absmiddle" /></td>
      <td nowrap="nowrap"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="��������� ���������, �� ��� �� ���������� ������." onClick="alert(this.title);" /> � ��������:</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=to_send"><? echo($all_to_send)? $all_to_send:"0";?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=paid_notsent"><? echo(is_array($arrOrdersPaidNotSent)&&count($arrOrdersPaidNotSent))? count($arrOrdersPaidNotSent):"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
<? if (count($arrOrdersPaidNotSent)){?>
    <tr<? if ($submenu=="paid_no_price"){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_rest.png" width="20" height="15" hspace="3" vspace="4" border="0" align="absmiddle" /></td>
    
      <td nowrap="nowrap"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="��������� ������, ���� �� ������� �� �������." onClick="alert(this.title);" /> ��������������, ��� ����:</td>
      <td nowrap="nowrap">&nbsp;</td>
    
      <td align="right"><a href="?menu=worx&amp;submenu=paid_no_price"><? 
	$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersPaidNoPrice);
	echo $Worx->works_value;	?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=paid_no_price"><? echo (count($arrOrdersPaidNoPrice)&&is_array($arrOrdersPaidNoPrice))? count($arrOrdersPaidNoPrice):"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
<? }?>
    <tr<? if ($submenu=="sold_orders"){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/money_applied.gif" width="17" height="15" hspace="5" vspace="4" border="0" align="absmiddle" /></td>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="��� ��������� ������. �������� �����������, � ������� ��� ������ ������ � ������������ ���������� ���������" onClick="alert(this.title);" /> ���������:</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=sold_orders"><?  // 
	$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersPaidSent);
	echo $Worx->works_value;	?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=paid_sent"><? echo(count($arrOrdersPaidSent))? count($arrOrdersPaidSent):"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr<? if ($submenu=="unpaid"){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/money_waiting.gif" width="16" height="15" hspace="5" vspace="4" border="0" align="absmiddle" /></td>
      <td nowrap="nowrap"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="���������� � ������� ������, �� ���������� ����������, ��� ���������� �� �� ���������." onClick="alert(this.title);" /> ������������:</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=unpaid"><? 
	$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersUnpaid);
	echo $Worx->works_value;	?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=unpaid"><? echo(count($arrOrdersUnpaid))? count($arrOrdersUnpaid):"0"; ?></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#EAFFEA">
      <td colspan="7" align="center"><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/maker_calculator.png" width="20" height="16" hspace="4" vspace="6" border="0" align="absmiddle" />�� �������� � ��������:</strong></td>
    </tr>
    <tr<? if ($submenu=="to_pay"){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/ourcost.png" width="16" height="16" hspace="5" vspace="4" border="0" align="absmiddle" /></td>
      <td nowrap="nowrap"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="��������� ������, �� ������� ������� ��� �� ���� ��������� ������." onClick="alert(this.title);" /> � �������:</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=to_pay"><? 
	$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersToPay);
	echo $Worx->works_value;	?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=to_pay"><? echo(count($arrOrdersToPay))? count($arrOrdersToPay):"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr<? if ($submenu=="sold"){?> class="workMenuActive"<? }?>>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pay_out.png" width="16" height="16" hspace="5" vspace="4" /></td>
      <td><img src="<?=$_SESSION['SITE_ROOT']?>images/i_round.gif" width="12" height="12" border="0" align="absmiddle" title="��������� ���������� ������, �� ������� ������� ��������� ������." onClick="alert(this.title);" /> �����������:</td>
      <td nowrap="nowrap">&nbsp;</td>
      <td align="right"><a href="?menu=worx&amp;submenu=sold"><? 
	$Worx->convertArrOrdersIDsToWorxIDs($arrOrdersPaidUp);
	echo $Worx->works_value;	?></a></td>
      <td align="center">&gt;</td>
      <td align="right"><a href="?menu=orders&amp;order_status=paid_up"><? echo(count($arrOrdersPaidUp))? count($arrOrdersPaidUp):"0";?></a></td>
      <td>&nbsp;</td>
    </tr>
  </table> </td>
        
    <td width="100%" valign="top" class="padding0" style="border-right:solid 1px #999;">
  <? 	//���� ������� ����� ������:
  		if ($submenu=="work_data") {

			$site_root=$_SESSION['SITE_ROOT'];
			//�������:
			if (isset($_REQUEST['test'])) {
				echo "<div>showWorkFiles()</div>\$Worx->getWorkFilesData:<br>";
				var_dump($Worx->getWorkFilesData());
			}
			$Blocks->showWorkFiles( $site_root,
									$Worx->getWorkFilesData(), //$workFiles
									$_REQUEST['work_id']
								  );
		
		}else{?>
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
  	  <tr height="100%">
        <td width="100%"><div style="height:100%; overflow:auto"><? 
	//
	if ($work_subject) $Worx->showSearchResultHeader(); 
	if ($test_results){?><h4 class="padding0 Cambria">���������� ������:</h4><? }?>
	  	  <table width="100%" cellpadding="1" cellspacing="0" class="listingInTbl" id="tbl_current_works">
<?  function generateRow($array,$search=false){ 
		
		global $Author;
		global $Worx;
	//	$arr[$rr]['item_table']
	//	$arrAllListing[$i]['work_table']
		$pre_key=($search)? "item_":"work_";
		$work_number=$array[$pre_key.'id'];?>

        	<tr>
				<? //1?>
              <td align="right"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle" /><input name="set_number_<?=$work_number?>" type="hidden" value="<?=$work_number?>"></td>
				<? //2?>
              <td align="right"><?=$work_number?></td>
				<? //3?>
              <td align="right"><?
		if ($array[$pre_key.'table']=="ri_worx") $Worx->setWorkLinkMailTo($work_number);
		else {?>&nbsp;<? }?></td>
				<? //4?>
              <td align="right"><? if ($test_basket){?><img src="../images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" /><? }?><a href="?menu=orders&amp;work_id=<?=$work_number?>" title="��������� ������ ������� ������ ������"><? $Worx->showOrdersValue($arrOrdersType,$work_number);?></a></td>
	          	<? //5?>
              <td width="100%" class="paddingLeft4"><? 
	  if ($array[$pre_key.'table']=="ri_worx"){?><a href="?menu=worx&amp;author_id=<?
	  
	  	//�������� id ������ �� id ������:
	  	echo $Author->getAuthorIdByWorkId($work_number);	
	  
	  ?>" title="������������� ������ �� ������"><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" border="0" align="absmiddle" /></a><? 
	  } 
	  $name=($search)? "name":"subject";?>&nbsp;<a href="<?=$_SESSION['SITE_ROOT']?>manager/?mode=skachat-rabotu&amp;menu=worx&amp;submenu=work_data&amp;work_id=<?=$work_number?>"><? echo $array[$pre_key.$name];?></a></td>
	          	<? //6?>
          	  <td nowrap="nowrap"><? 
		  
		if ($search) {
		  //�������� �������/���:
		  $Worx->getWorkAreaAndType($array[$pre_key.'table'],$array[$pre_key.'id']);
		  $work_type=$Worx->work_type;		  
		  $work_area=$Worx->work_area;
		
		}else{ 
		
			$work_type=$array[$pre_key.'type'];
			$work_area=$array[$pre_key.'area'];
			
		}
		
		$Worx->buildWorxTypesList( " disabled", 				//code
		  							 $work_type,	//��� ������
									 false
								   );?></td>
	          	<? //7?>
          	  <td nowrap="nowrap"><? $Worx->buildWorxAreasList(" disabled class='area_short'",$work_area);?></td>
	          	<? //8?>
          	  <td align="right" class="padding4"><? 
		echo ($array[$pre_key.'table']=="diplom_zakaz")? 
			$Worx->calculateWorkPrice("diplom_zakaz",$work_number,false):
			$Worx->calculateLocalPrice($work_number);?></td>
        	
            </tr>
<?	}
	$i=0;
	//���������� ������:
	if ($work_subject) {

		for ($rr=0;$rr<count($arr);$rr++) {

			//$test_arr=true;
			if ($_SESSION['TEST_MODE']&&$test_arr) {
				echo "<div>count(\$arr)= ".count($arr)."</div>";	
				var_dump($arr);
			}
			generateRow($arr[$rr],true);
			$i++;

		}
	
	}elseif($all_worx){
	
		//��������� ������� ����� ����������� ������� �� ���.:
		$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
		
		//$test_arrListing=true;
		if ($_SESSION['TEST_MODE']&&$test_arrListing) {
			echo "<div>count(\$arrAllListing)= ".count($arrAllListing).", type= ".gettype($arrAllListing)."</div>";	
			var_dump($arrAllListing);
		}
		
		for ($i=$limit_start;$i<$current_limit;$i++)  if (is_array($arrAllListing)&&count($arrAllListing)) generateRow($arrAllListing[$i]);	

	}?>
	  		</table>
      </div></td>
  		</tr>
  		<tr style="height:auto" class="bgGrayLightEFEFEF">
    	  <td class="padding4"><?  $pageNextStyle=' class="padding8 paddingTop10"';
		$Blocks->makePagesNext($all_worx,$limit_finish);?></td>
  		</tr>
	  </table>
  <?	}?>
    </td>
  </tr>
</table>