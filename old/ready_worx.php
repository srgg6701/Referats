<? session_start();

require_once('../connect_db.php');

require_once('../classes/class.Errors.php');
$catchErrors=new catchErrors;

require_once('../classes/class.Messages.php');
$Messages=new Messages; 

require_once ("../classes/class.Tools.php");
$Tools=new Tools;

require_once ("../classes/class.Worx.php");
$Worx=new Worx;
		   		
######################################################################################################################

//�������� ��� ��������� � ������� ������ � ������� (������ � ���������� ������, �������������, � ����� - ������ ������): 
	//if (!$_REQUEST['work_id']&&!$_REQUEST['section']&&!$_REQUEST['article']) $arrDplomZakazIDsWithFiles=$Worx->getDplomZakazIDsWithFiles();

	$limit_finish=(strstr($_SERVER['HTTP_HOST'],"localhost"))? 25:25;
	$Worx->setPagesLimit($limit_finish,$limit_start);
	  
	$work_subject=$_REQUEST['work_subject'];	
	
	if ($work_subject) $dbSearch=new dbSearch;
	
	//���������� �������� ��� ���� ������ - ������� �� ���� ��� ����� ��� ����:
	$work_type=($_REQUEST['work_type'])? $_REQUEST['work_type']:$_SESSION['S_WORK_TYPE_ALL'];
	$work_area=($_REQUEST['work_area'])? $_REQUEST['work_area']:$_SESSION['S_WORK_AREA_ALL'];
	
	//echo "<div>isset(\$request_work_type_all)=".isset($request_work_type_all).", work_type= $work_type</div>";
	//echo "<div>isset(\$request_work_area_all)=".isset($request_work_area_all).", work_area= $work_area</div>";
	//echo "<hr>";
	//echo "<div>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]</div>";
	//echo "<div>S_WORK_AREA_ALL= $_SESSION[S_WORK_AREA_ALL]</div>";

	//�������� ��� ������ ��������� ����� ��� ����������� � �������:
	$arrAll=$Worx->findAllWorx( $work_subject,
								$work_type,
								$work_area,
								$arrDplomZakazIDsWithFiles, //��� ��������� � ������� ������ diplom_zakaz � �������, ��� � �����������, ��� � �������������
								$arr //������ ��������������� ��������� ��������
							  );
	$all_worx=count($arrAll);
	
	//$test_array=true;
	if ($test_array)
	for ($i=0;$i<count($arrAll);$i++) {
		foreach ($arrAll[$i] as $key=>$val)		
			if (isset($_SESSION['TEST_MODE'])) echo "<div>[$key] => $val</div>";
	}
	?>
<html>
<head>
<title></title>
<meta name="description" content="���� ���������, ��������, ��������� �����. ������� ������, ������� �� �����.">
<meta name="keywords" content="���� ���������, ��������, ������, �������, ��������, ������ �� �����, �������� ������ �� ����, ������ ������, �������� ��, ������� �� ����, ����������, �����, ��������, ���������, �����������, �������, ����������, �������� � ��������, ����������, ��������� ���������, ����������, ���������, ��������� ���������, �����������, ���, ���������, ����������� �����, ����������, ����������, ������, �����, ���������">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="../css/border.css" rel="stylesheet" type="text/css">
<link href="../css/padding.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/txt.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../js.js"></script>
</head>
<body>
    <div class="paddingBottom6 paddingTop6">
<? if (!$work_subject) {?>
	
	<? 	if ($test_worx_filter){?>{���������� ������� ������ ���� � �������� ����� (������)}<? }
		//
		$Worx->setFilterToWorxCriteria();?>
    
<? }?>
</div>
<?
if ($_REQUEST['show_wrong_ext']&&is_array($Worx->arrWrongExt)) {
	
	$arrWrongExt=$Worx->arrWrongExt;
?>
<div style='color:blue; cursor:pointer' onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class="txt130 bold arial padding4 bgPale iborder">����� ������������ ������: <?=count($arrWrongExt)?></div>
	<div style="display:<?="none"?>;" id="container"><?
	
	for ($i=0;$i<count($arrWrongExt);$i++)
		foreach($arrWrongExt[$i] as $color=>$path) {?><div class="txt<?=$color?>"><?=$path?></div><? }
	
	?><div class="padding4"><a href="#" onClick="document.getElementById('container').style.display='none';return true;">��������</a></div>
    </div><?
}?>
<!--<img src="images/spacer.gif" width="100%" height="14">--><table width="100%" border="1" cellpadding="4" cellspacing="0" rules="rows" id="tbl_customer">
  	  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale">
  	    <td height="36" class="cellPassive<? //echo($_SESSION['S_SORT']=="subject")? "Active":"Passive";?>"><input type="checkbox" name="checAll" id="checkAll" onClick="manageCheckBoxes(this,'tbl_customer');"></td>
    	<td bgcolor="#003399" class="padding6 cellPassive<? 
		
		//echo($_SESSION['S_SORT']=="subject"||$work_subject)? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=subject"<? }*/
		
		?>>����</a></strong></td>
    	
        <td class="padding6 cellPassive<? 
		
		//echo(($_SESSION['S_SORT']=="typework"&&!$work_subject)||$_REQUEST['work_type'])? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=typework"<? }*/
		
		?>>���</a></strong></td>
    	
        <td class="padding6 cellPassive<? 
		
		//echo(strstr($_SESSION['S_SORT'],"predmet")&&!$work_subject)? "Active":"Passive";
		
		?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=diplom_worx_topix.predmet"<? }*/
		
		?>>�������</a></strong></td>

  	  </tr>
	<?	//�������� ������� ��� ��������� SEO-������:
		$arrWrkTypes=array();
		$arrWrkAreas=array();
		//�������, ���� �� ����� � �������; - ������� title, ����������� �������
		function findOrder($work_id,&$title_busy) {
			//��������, ��� �� ��� � ��������� ������ ������ � �������:
			$qFindOrder="SELECT number FROM ri_basket WHERE user_id = $_SESSION[S_USER_ID] AND work_id = $work_id";
			if ($_SESSION['S_USER_TYPE']=='customer'&&mysql_num_rows(mysql_query($qFindOrder))) $checked_disabled=" checked disabled";

			//������� title �� ���������� � ������� ������:
			if ($checked_disabled) $title_busy=' title="����� ������� � ���� �������"'; 
			return $checked_disabled;
		}
		
		$bg_count=0; //background
        //errorMessage(1,"","������ ���������� ������","qSel",$qSel);
        //���� ��������� ���������� ������:
        if ($work_subject) {
			 
            for ($r=0;$r<count($arr);$r++) {
				//���������� ����� ������, ����������� � �������:
				unset($checked_disabled); 
                $work_id=$arr[$r]['item_id'];
				//�������, �� ��������� �� ����� ��� � �������:
				$checked_disabled=findOrder($work_id,$title_busy);
				//���� �� ������ ������� �������� ������ �� ��������:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {
				
                	$work_subject=$arr[$r]['item_name'];
                	
					//predmet//typework:
					$work_table=$arr[$r]['item_table'];
					$Worx->getWorkAreaAndType($work_table,$work_id);
					$work_area=$Worx->work_area;
					$work_type=$Worx->work_type;?>
                    
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>

    <td><input type="checkbox" 
    		   name="order_<?=$work_table?>_<?=$work_id?>" 
    		   id="order_<?=$work_table?>_<?=$work_id?>" 
               value="<?=$work_id?>"<?=$checked_disabled?>></td>
    <td><a href="../bank-referatov.php?work_table=<?=$work_table?>&work_id=<?=$work_id?>"><?
					
				if ($work_subject||$work_id) echo ($work_subject)? $work_subject:"id :".$work_id;
				elseif (isset($_SESSION['TEST_MODE'])) echo "<div>work_table= $work_table, work_id= $work_id, work_subject= $work_subject, work_type= $work_type, work_area= $work_area</div>";
				
				?></a></td>
    <td><?=$work_type?></td>
    <td><?=$work_area?></td>
  </tr>
	  <?			$bg_count++; //������������� ������� �����������
	  			}
            }

        }elseif($all_worx){ //���� ��������� ������ �� ���������:

			//��������� ������� ����� ����������� ������� �� ���.:
			$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
			for ($i=$limit_start;$i<$current_limit;$i++) {
				//���������� ����� ������, ����������� � �������:
				unset($checked_disabled); 
				//�������, �� ��������� �� ����� ��� � �������:
				$checked_disabled=findOrder($arrAll[$i]['work_id'],$title_busy);
				//���� �� ������ ������� �������� ������ �� ��������:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {?>
		
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>
        
    <td><input type="checkbox" 
    		   name="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               id="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               value="<?=$arrAll[$i]['work_id']?>"<?=$checked_disabled?>>
   </td>
    <td><a href="../bank-referatov.php?work_table=<?=$arrAll[$i]['work_table']?>&work_id=<?=$arrAll[$i]['work_id']?>"><?
	
		
		if ($arrAll[$i]['work_subject']||$arrAll[$i]['work_id']) echo ($arrAll[$i]['work_subject'])? $arrAll[$i]['work_subject']:"id :".$arrAll[$i]['work_id'];
		elseif (isset($_SESSION['TEST_MODE'])) echo "<div>work_table= ".$arrAll[$i]['work_table'].", work_id= ".$arrAll[$i]['work_id'].", work_subject= ".$arrAll[$i]['work_subject'].", work_type= ".$arrAll[$i]['work_type'].", work_area= ".$arrAll[$i]['work_area']."</div>";

			
			?></a></td>
    <td><? 
					if (!in_array($arrAll[$i]['work_type'],$arrWrkTypes)) {
						
						?><a title="������������� ������ �� ����" href="../bank-referatov.php?work_type=<?=$arrAll[$i]['work_type']?>&work_area=<?=$_SESSION['S_WORK_AREA_ALL']?>"><?
						$arrWrkTypes[]=$arrAll[$i]['work_type'];
						
					} echo $arrAll[$i]['work_type'];
					
					if (!in_array($arrAll[$i]['work_type'],$arrWrkTypes)) {?></a><? }?></td>
    <td><? 
					if (!in_array($arrAll[$i]['work_area'],$arrWrkAreas)) {
						
						?><a title="������������� ������ �� ��������" href="../bank-referatov.php?work_type=<?=$_SESSION['S_WORK_AREA_TYPE']?>&work_area=<?=$arrAll[$i]['work_area']?>"><?
						
						$arrWrkAreas[]=$arrAll[$i]['work_area'];
					
					} echo $arrAll[$i]['work_area'];
					
					if (!in_array($arrAll[$i]['work_area'],$arrWrkAreas)) {?></a><? }?></td>
  </tr>
<?					$bg_count++;
				}
    		} 
		}?>
    </table><? 
	//
	$Blocks->authorizeToAddToBasket();
	//�������� ��������� � ����������������� ������:
	$Tools->wrongExtIssue()?>
    <table cellspacing="0" cellpadding="0">
  <tr>
    <td class="paddingBottom8 paddingTop8"><input type="submit" value="�������� � ������� �������!" style="padding:8px; width:240px;" onClick="return checkAllBoxes('reg_area');"></td>
<?  if ($work_subject) {?>
	<td class="paddingLeft10">[<a href="../index.php">�������� ��������� ������</a>]</td>
<? }?>
  </tr>
</table><?	  
	  //$test_pages=true;
	  if ($test_pages){?>{ ������� �� ���������... }<? }
	  $Blocks->makePagesNext($all_worx,$limit_finish);

	

?></body></html>