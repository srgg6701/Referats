<? 

 //error_reporting(E_ALL); 
 error_reporting(E_ERROR); 
 error_reporting(E_PARSE); 
 error_reporting(E_CORE_ERROR); 
 error_reporting(E_STRICT); 
 error_reporting(E_DEPRECATED); 
 ini_set('display_errors', '1'); 
 ini_set('display_startup_errors', '1'); 
 
 session_start();
 
	if (isset($_GET['social_bookmarks'])) {
echo '<html>
	<head>
    	<title>�������� ���� � ���������� ��������</title>
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
    </head>
<body class="padding0 paddingTop6 bgF4FF">' ?>
<div align="center"><?
		
		$sociolink='<a href="index.php?article=set_distributor_link" onMouseOver="this.style.textDecoration=\'none\';" target="_parent">';
		
		if (!$_SESSION['S_USER_TYPE']||!$_SESSION['S_USER_ID']){ 
			
			echo $sociolink;?><img border="0" src="images/odnaknopka.png" width="256" height="16"><?
		
		}else{?><script src="http://odnaknopka.ru/ok3.js" type="text/javascript"></script><?
		}?>&nbsp;&nbsp;<?=$sociolink?>���������...</a></div><?
		
echo '</body>
</html>';
		die();
	}
	
require_once('connect_db.php');
//
require_once('classes/class.Actions.php');
$Actions=new Actions;
require_once('classes/class.Blocks.php');
$Blocks=new Blocks;
require_once('classes/class.dbSearch.php');
//����������� �����, �� �������: if ($work_subject)
require_once('classes/class.Errors.php');
$catchErrors=new catchErrors;
require_once('classes/class.Customer.php');
$Customer=new Customer;
require_once('classes/class.Messages.php');
$Messages=new Messages; 
require_once('classes/class.Money.php');
$Money=new Money;
require_once ("classes/class.regUser.php");
$regUser=new regUser;
require_once ("classes/class.Tools.php");
$Tools=new Tools;
require_once ("classes/class.Worx.php");
$Worx=new Worx;

if ($_REQUEST['mode']=="exit") { echo "<h1>exit</h1>";
	session_unset();
	$Messages->alertReload("","index.php");
}
	
//���� ��������� ����������� � �������:
if (isset($_REQUEST['comment'])) { 

	$msbj="����������� � ������� $_REQUEST[add_comment_type].";
	$mtxt=$_REQUEST['comment']."<hr>�����������: $_REQUEST[name].";

	//��������� ��������� �� ������
	$Messages->sendEmail( $toAddress,
						  $_REQUEST['email'],
						  $_REQUEST['email'],
						  $msbj,
						  $mtxt,
						  false
						);					
	//�������� ������ � ������� ri_messages
	$Messages->writeMessTbl( $_REQUEST['name'],
						     $ri_basket_id,
						     $toAddress,
						     $receiver_user_id,
						     "admin",
						     $_SERVER['REQUEST_URI'],
						     $msbj,
						     $mtxt
						   );
}
//���� �������������: 
	//��������� ����� � �������
//...�� �������������: 
	//��������� ������ REQUEST � ���������� ����������, ����� ������� ������ ��� ���������� ������ ����� �����������/����������� �����
function addWorksToBasket($action) { 
	
		//$test_function=true;
		if ($test_function)	{
			//echo "<h5 class='txtGreen'>addWorksToBasket(\$action=$action) just STARTED</h5>";
			echo "<h5 class='txtGreen'>\$action=$action -> just STARTED!</h5>";
			echo "<div class='txtOrange'>(������) \$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
		}
	
	global $catchErrors;
	global $Messages;
	
	//��������� ������ ����� � ���������� ���.:
	if($action=="save") {
					
		$_SESSION['saved_orders']=$_REQUEST;
		//�������:
		//$test_loop=true; 
		if ($test_loop) {
			echo "<div><div style='color:red'>��������� ������ \$_REQUEST � ���������� ����������:</div>";
			foreach ($_SESSION['saved_orders'] as $key=>$val)
				echo "<div style='color:green'>[$key]=>$val</div>";
			//var_dump($_SESSION['saved_orders']);
			echo "</div>";
		}

	}else{	//��������� �����:

		//�������, ���������� �� ������� ���������� �������
		//��� ��������� ������:
		if (!$_REQUEST['buy_work']&&!$_REQUEST['order_work']) {
			foreach ($_REQUEST as $key=>$val)
				if (strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_")) {
					$keys_exist=true; 
					break;
				}
		} //echo "<div>keys_exist= $keys_exist</div>";
		//���� ��������/���������/��������� ������������ ������ ��� - � �������� ������:
		if ($_REQUEST['buy_work']||$_REQUEST['order_work']||$keys_exist) {

			$bsk=0;//��� �������� ������������� � ������� ������� �, �������������� - ����������� ��� �������� ���������� �����.
			//���������, �� �������� �� � �������?
			$add_basket=0; //������� ���������� ������� � �������
			$cancel_basket=0; //������� ������ ���������� ������� � �������
			//������� ������� ������ ��� ���������� �� ������� REQUEST (�������� ��� ����� �����������).
			//$_SESSION['saved_orders'] - ����� ���������� ������ REQUEST (�� �������������� ���������)
			$arrToUse=(!$_SESSION['saved_orders'])? $_REQUEST:$_SESSION['saved_orders'];
			
				//$test_arrToUse=true;
				if ($test_arrToUse) {
					echo "<div class='txtOrange'>addWorksToBasket(\$action=$action) works!<br>\$arrToUse= "; 
					echo(!$_SESSION['saved_orders'])? "\$_REQUEST":"\$_SESSION['saved_orders']"; 
					echo "</div>";
				}

				//$test_loop=true;
				if ($test_loop) {
	
					echo "<hr>\$arrToUse is ";
					if (is_array($arrToUse)) {
						echo "Array: ";
						foreach ($arrToUse as $key=>$val)
							echo "<div>[$key]=> $val</div>";
					}else{ 
						echo "\$arrToUse type is ".gettype($arrToUse);
						//var_dump($arrToUse);
					}
					echo "<hr>";
				}

			//���� ������ ������ � �� �� ����:
			if (is_array($arrToUse)&&count($arrToUse)) { //echo "<h5>Inside of \$arrToUse...</h5>";

				$arrOrderData=array();
				$count_work_table=0;
				$count_work_id=0;
				foreach ($arrToUse as $key=>$val){ //echo "<h5>Inside of foreach(\$arrToUse)...</h5>$key=>$val";
					
					//�������, id ������:
					if ( strstr($key,"order_diplom_zakaz_")||strstr($key,"order_ri_worx_") //�������� ��������
						 //��������� �����
						 || $key=="work_table" /*|| $key=="work_id" */|| $key=="buy_work" || $key=="order_work"
					   ) {
						
						if ((strstr($key,"order_diplom_zakaz_") || strstr($key,"order_ri_worx_")))
							{ //echo "<div><b>[$key]</b>=> $val</div>";
						
							$arrOrderData[$count_work_table]['table']=(strstr($key,"order_diplom_zakaz_"))? "diplom_zakaz":"ri_worx";
							$count_work_table++;
							$arrOrderData[$count_work_id]['work_id']=$val;
							$count_work_id++;
						
						}else{ //echo "<div><b><em>[$key]</em></b>=> $val</div>";
							
							//��������! ���������� ��������� �������� ����������� ��������� �������, ����������� ��-�� ���������� �������:
							if ($key=="work_table"/*&&!$arrOrderData[$count_work_table-1]['table']*/) {
								$arrOrderData[$count_work_table]['table']=$val;
								$count_work_table++;
							}
							if (($key=="buy_work"||$key=="order_work")&&$val) {
								$arrOrderData[$count_work_id]['work_id']=$val;
								$count_work_id++;
							}
						}
					} 			 
				} //for ($i=0;$i<count($arrOrderData);$i++) foreach($arrOrderData[$i] as $key=>$val) echo "<div>[$i][$key]=> $val</div>";
				
				//���� ������� ������ ������:
				if (count($arrOrderData)) {
					
					$bsk=0;
					foreach ($arrOrderData as $key=>$val) { 
					//echo "<div>[$key]=>$val</div>"; 
					//if (is_array($val)) foreach ($val as $key2=>$val2) echo "<div>[$key2]=>$val2</div>";
					
						//��������� - ���� �� ����� ����� � �������. ���� ��� - ��������:
						$qSel="SELECT number FROM ri_basket
 WHERE user_id = $_SESSION[S_USER_ID] 
   AND work_table = '".$arrOrderData[$bsk]['table']."' 
   AND work_id = ".$arrOrderData[$bsk]['work_id']; 
						//$catchErrors->select($qSel);
						$rSel=mysql_query($qSel);
						$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
						if(!mysql_num_rows($rSel)) {
					
							########################################################
							//��������� ������:
							//�������� id ������ �� ri_worx
							$qIns="INSERT INTO ri_basket ( user_id, 
                        work_table, 
                        work_id, 
                        datatime 
                      ) VALUES 
                      ( $_SESSION[S_USER_ID], 
                        '".$arrOrderData[$bsk]['table']."', 
                        ".$arrOrderData[$bsk]['work_id'].",
                        '".date('Y-m-d H:i:s')."' 
                      )";
							$catchErrors->insert($qIns);
							$add_basket++;
			
						}else $cancel_basket++;
						$bsk++; //������������� ������� ����� ����������
					}
				}
			}
		
			//������� ���������� � id id �����:
			unset($_SESSION['saved_orders']);
	
				if ($test_loop) {
					echo "<div class='txtRed'>������� ���������� ���������� \$_SESSION['saved_orders']";
					//:<br>\$_SESSION['saved_orders']=";var_dump($_SESSION['saved_orders']);
					echo "</div>";
				}
			
			//���� �������� ��������� ������ � �������:
			if ($bsk&&($add_basket||$cancel_basket)) {
				
				$add_value=$add_basket-$cancel_basket;
				if ($add_basket) $added="��������� �������: $add_value"; 
				if ($cancel_basket) $cancel="\\n�������� ���������� (��� ���� � ����� �������): $cancel_basket"; 
				$pageReload="?section=customer";
				//���� �������� ������, ��������� ������������� �������� ������� ������:
				if (isset($_REQUEST['buy_work'])) $pageReload.="&add_payment=".$_REQUEST['buy_work'];
				$Messages->alertReload($added.$cancel,$pageReload); 
			}
		}
	}
}	//����� ������ addWorksToBasket()

		//����� ���������� � �������� ������:
		$catchErrors->showGetPostDataForeach($mType);
		if (isset($_SESSION['TEST_MODE'])) {?><script language="JavaScript" type="text/JavaScript" src="js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="email_check.js"></script><? }

//�������������� ��� ����������������� ��������:
if (isset($_REQUEST['user_login'])) {

	//���������� �������� ���� ������ �����, �� �� �������� (��� ��� ������) ������������� ����������� ��������������
	if (!isset($_REQUEST['apply_register'])) {
		
		 //��������� ��������� ����� (�� �� - �����):
	
		//�������� ��������� �������:
		//���������, �� ��������������� �� ���:
		$qSel="SELECT number,name,email FROM ri_customer
  WHERE ( email = '$_REQUEST[user_login]' 
	 OR email2 = '$_REQUEST[user_login]'
   )"; 	
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//���� �� ���������������:
		if (!mysql_num_rows($rSel)) {//���� �� ���������
			
			//���� ��� ������ �����, �� (��������) �� ������� �������� � ������� ������:
			addWorksToBasket("save");//��������� ������ REQUEST  � ���������� ���������� �� ����������� �����...
			
			//die("<a href='?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes'>?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes</a>");
			
			//1. ����������� ��������
			//2. ������� ����� ����� � �������� ������ (����� �������� ������ ������� ����
			//3. �������� ����� ������������� ��������� ��������������, ��� ���������� ��������� (������������) ���� 
			$alert_mess="����� $_REQUEST[user_login] � ����� �� �� ���������!\\n������� ������������������ � ���� �������?";
			$go_page="?section=customer&user_login=$_REQUEST[user_login]&apply_register=yes";
			if (isset($_REQUEST['buy_work'])) $go_page.="&buy_work=$_REQUEST[buy_work]";
			if (isset($_REQUEST['order_work'])) $go_page.="&order_work=$_REQUEST[order_work]";
			if (isset($_SESSION['TEST_MODE'])){
        
				echo "<div><hr><b>alert:</b> $alert_mess<hr>location.href= <a href='$go_page'>$go_page</a></div>";
		    
			}else{?>
<script type="text/javascript">
if (confirm('<?=$alert_mess?>')) {
	var goPage="<?=$go_page?>";
	//window.open(goPage,'appl');
	location.href=goPage;
}
</script>
	<?		}
			die();	
		
		}else{ //���� ���������:
			
			//��������, ��� �� ������:
			$qSel.="
   AND password = '$_REQUEST[password]'";
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			//������ �� ���:
			if (!mysql_num_rows($rSel)) {
				
				$Messages->alertReload("������ ������ �������!","?section=customer");
				die();
	
			}else{ //������ ����������
	
				$_SESSION['S_USER_TYPE']="customer";
				$_SESSION['S_USER_ID']=mysql_result($rSel,0,'number');
				//�������� ���������� ����������:
				$Customer->getCustomerData($_SESSION['S_USER_ID'],true);
	
			}
		}
	
	//���������� ����� ����������� ������ ����� (��� ����� ������������� ����������� � ����������� �������):
	}else{		//echo "<div>\$_SESSION['saved_orders']= $_SESSION[saved_orders]</div>";
		
		//���� ��� ������ �����, �� (��������) �� ������� �������� � ������� ������:
		$regUser->regCustomer($_REQUEST['user_login']);
		
	}	
}
//�������� ������ � ������� (���� id id ����� ���������� � ������� $_REQUEST):
if ($_SESSION['S_USER_TYPE']=="customer") addWorksToBasket("insert");?>
  
<html>
<head>
<title>���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������</title>
<meta name="description" content="���� ���������, ��������, ��������� �����. ������� ������, ������� �� �����.">
<meta name="keywords" content="���� ���������, ��������, ������, �������, ��������, ������ �� �����, �������� ������ �� ����, ������ ������, �������� ��, ������� �� ����, ����������, �����, ��������, ���������, �����������, �������, ����������, �������� � ��������, ����������, ��������� ���������, ����������, ���������, ��������� ���������, �����������, ���, ���������, ����������� �����, ����������, ����������, ������, �����, ���������">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="email_check.js"></script>
<script type="text/javascript">
function searchWork(work_type) {
	document.getElementById('work_type').value=work_type;
	document.forms['form1'].action="index.php";
	document.forms['form1'].submit();
}
//�������� �������� ���������� ���������
function checkAllBoxes(reg_area) {
var un=0;
var allBoxes=document.getElementById('tbl_customer').getElementsByTagName('INPUT');
for (i=1;i<allBoxes.length;i++) if (allBoxes.item(i).checked==true) un++;
	if (un==0) {
		alert('�� �� �������� �� ����� ������!');
		return false;
	}
<?  //���� �� ����������������, ��� ��������:
	if ($_SESSION['S_USER_TYPE']!="customer"){?>
	else return showAuthForm(reg_area);
<? } echo "\n";?>
}

dg="@";
realm=".";
realm+="info";
var mContent="sale"+dg+"referats"+realm;
function showFeedBack(fcontent) {
	var tBlock=document.getElementById('feedbak_container');
	if (fcontent=="email") fcontent=mContent;
tBlock.innerHTML=fcontent;
}
function sendEmail() {
	location.href="mailto: "+mContent;
}
function callViaSkipe(dSkipe) {
	location.href="skype:"+dSkipe;
}
//�������� ������ � ����:
function addOrderNote(mtype,order_id) {
var set_subject;
	switch(mtype) {
		case "order":
		set_subject="��������� �� ������ id "+order_id;
		document.getElementById('ri_basket_id').value=order_id;
		break;
		
		default: set_subject="����� ��������� ������������� Referats.info.";
	}
document.getElementById('comment').value=set_subject+':\n----------------------------------------\n';
document.getElementById('set_subject').value=set_subject;
}
</script>
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24990263-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body<? if($_REQUEST['section']=="register") echo ' bgcolor="#E1E1FF"';?> onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');"><?

//echo "\$_SESSION['S_USER_TYPE']=".$_SESSION['S_USER_TYPE'];?>
<table width="100%" cellspacing="0" cellpadding="0" style="display:none;">
  <tr class="borderBottom4 borderColorGray">
    <td width="25%" height="82" align="center" nowrap bgcolor="#003399" class="padding10"><a href="index.php" class="txtWhite header"><img src="images/logo_docs.png" alt="��������, ��������, ��������� ������ �������. ������� ������, ������� �� ����� ��������" width="61" height="32" hspace="4" border="0" align="absmiddle">Referats.<span style="color:#ffcc00;">info</span></a></td>
    <td width="52%" align="center" bgcolor="#FFCC00" class="padding10">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border:none;" class="txt100"><strong>���������� ������� ���������� ������:</strong></td>
      </tr>
      <tr>
        <td style="border:none;">
        <h1 class="padding0 noBold txt110 Cambria"><a href="#" onClick="searchWork('��������� ������');return false;">��������� ������</a>, <a href="#" onClick="searchWork('������ MBA');return false;">������� MBA</a>, <a href="#" onClick="searchWork('��������');return false;">�������� ������</a>, <a href="#" onClick="searchWork('�������');return false;">��������</a> � <a href="#" onClick="searchWork('�����������');return false;">�����������</a>!</h1></td>
      </tr>
    </table>      </td>
    <td width="23%" align="center" bgcolor="#E1E1FF" id="tdConnect">
    <a href="javascript:callViaSkipe('+79044428447');" title="������ �� ��������� ������� �� ������"><img src="images/phone_sound.png" width="32" height="32" border="0" onMouseOver="showFeedBack('+7 904 442 84 47');"></a>
    <a href="javascript:sendEmail();"><img src="images/message.png" width="28" height="28" border="0" onMouseOver="showFeedBack('email');"></a>
    <a href="javascript:callViaSkipe('eduservice');" title="����� �� ������"><img src="images/Skype-32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('eduservice');"></a>
    <a href="javascript:callViaSkipe('29894257');" title="����� �� icq"><img src="images/licq_32x32.png" width="32" height="32" border="0" onMouseOver="showFeedBack('29894257');"></a>
    <div class="paddingTop2" id="feedbak_container"><strong class="txtRed">������ �� ����� � ����!</strong></div>
    </td>
  </tr>
</table>
<? if($_REQUEST['section']!="register")
     {?>
<table width="100%" cellspacing="0" cellpadding="10">
  <tr align="center" class="txt120 borderBottom2 borderColorGray bgPanel">
    <td height="55"><a href="bank-referatov.php">������� ������</a></td>
    <td><a href="index_temp.php?section=payment">������� ������</a></td>
    <td><a href="index_temp.php?section=faq">FAQ</a></td>
    <td><a href="index_temp.php?article=all">��������</a></td>
    <td><a href="index_temp.php?section=agreement">���������� �� �������</a></td>
    <td><a href="index_temp.php?section=authors" title="��������������<?="\n"?>����������<?="\n"?>FAQ<?="\n"?>�����������">�������<img src="images/i_triangle.png" width="15" height="15" hspace="4" vspace="4" border="0" align="absmiddle"></a> <a href="author/" title="���� � �������"><img src="images/home.gif" width="14" height="14" hspace="3" vspace="4" border="0" align="absmiddle"></a></td>
  </tr>
</table>
<!--

�������� ����������:

typework
	diploma
    diplomaMBA
    course
    referat
    dissertation
section
	payment
    faq
    useful
    agreement
    sale
    set_distributor_link
    payment
    partnership
sort
	subject
    typework
    predmet
work_id
article
	plagiat
    affair
    bad_teacher
    recruits
    set_distributor_link
find_work
    work_subject
    work_type    
-->
<table width="100%" cellspacing="0" cellpadding="10">
<form method="post" name="form1" class="padding0">
  <tr bgcolor="#E1E1FF">
    <td height="52" bgcolor="#E1E1FF" class="paddingRight0"><? 
	//�������� ������ ����� �����:
	$Worx->buildWorxTypesList(' style="background-color:#FFFFCC;" class="widthFull"',false,false); ?></td>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap class="txt100 paddingLeft4">������� ���� ������:</td>
          <td><img src="images/1295963445_search.png" width="16" height="16" hspace="4"></td>
          <td width="100%"><input style="height:24px;" name="work_subject" type="text" class="widthFull" id="work_subject" value="<?=$_REQUEST['work_subject']?>" title="�������� ���� ������, ���� ������ ����� ������ �� ���������� � ������ ���� �������� �� ����� ����."></td>
          <td><input style="height:26px;" type="submit" name="find_work" id="find" value="  �����!  "></td>
        </tr>
      </table> </td>
    <td align="center" class="bgF4FF"><a href="index_temp.php?section=register"><strong><img src="images/pay_rest.gif" width="16" height="16" hspace="4" border="0" align="absmiddle">������� ������� ������...</strong></a></td>
  </tr>
</form>  
  <tr>
    <td width="15%" valign="top" class="contentColumn borderTop1 borderColorGray"><?
	
	if (!$_REQUEST['work_id']) {
		//
		$arrDplomZakazIDsWithFiles=$Worx->getDplomZakazIDsWithFiles();
		echo "<div>=".count($arrDplomZakazIDsWithFiles)."=</div>";
			
			?>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">����� ��� ������ � �������:</div>
			<div style="display:<?="none"?>;"><? 
		if ( $_REQUEST['section']=="authors" ||
				 $_REQUEST['section']=="author_agreement" ||
				 $_REQUEST['section']=="faq_authors"
		   ) $author_sections=true;	?></div>
		   <hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">����� �����: <?
			
			$right_stat="SELECT number FROM diplom_zakaz
		   WHERE ( status_cycle = 'closed' OR 
				 status_cycle = 'made' OR
				 status_cycle = 'remade' OR
				 status_cycle = 'processed' )
		   AND number IN (";
			
			$wAll=$Worx->arrWorksFilesAll;
			echo count($wAll);?>
	  <?  $wAll2=array_unique($wAll);
			echo " : ".count($wAll2);?></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wAll2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">�������� � �������: <?
			
			$qSel=$right_stat.implode(",",$wAll2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) { 
				echo $arr['number'].", ";
				$arrToSale[]=$arr['number'];
			 }
			?></div>
			
			<hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">� ������� � ���. zip: <?
			$wZip=$Worx->arrWorksFilesZip;
			if (is_array($wZip)) {
				echo count($wZip);
				$wZip2=array_unique($wZip);
				echo " : ".count($wZip2);
			}else echo " 0";?></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wZip2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">�������� � �������: <?
			
			$qSel=$right_stat.implode(",",$wZip2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div>
			
			<hr>
	  <div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';"><nobr>� �������������� �������: <?
			$wMail=$Worx->arrWorksFilesMail;
			echo count($wMail);
			$wMail2=array_unique($wMail);
			echo " : ".count($wMail2);
			?></nobr></div>
			<div style="display:<?="none"?>;"><?
			 foreach ($wMail2 as $val) echo "$val, ";
			?></div>
			
			<hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">�������� � �������: <?
			
			$qSel=$right_stat.implode(",",$wMail2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
			<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div>
			
	  <hr size="1"><div class="link" onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';">C ��������: <?
			
			$qSel=$right_stat.implode(",",$wMail2).") ";
			$rSel=mysql_query($qSel); echo mysql_num_rows($rSel);?></div>
	<div style="display:<?="none"?>;"><?
			 while ($arr = mysql_fetch_assoc($rSel)) echo $arr['number'].", ";
			?></div><?
	}else {?><h4><a href="index_temp.php">�� ������� ��������</a></h4><? }?></td>

    <td valign="top" class="padding0 paddingBottom10 paddingLeft10 borderTop1 borderColorGray"><?
if ($_REQUEST['section']!="customer"){?>
    <div align="center" class="iborder borderColorGray" style="border-top:none;">
      <table align="center" cellpadding="0" cellspacing="0" class="bgYellowFadeTop"<? if ($author_sections){?> width="100%"<? }?>>
  <tr>
<? if (!$author_sections) {?>
    <td align="center" class="padding10">
        <table cellspacing="0" cellpadding="0" class="iborder2 bgWhite" style="border-color:#003399;">
          <tr>
            <td colspan="4" align="left" class="paddingTop10 paddingBottom6 paddingRight10"><table cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="images/kopeteavailable.png" width="32" height="32" hspace="4"></td>
                <td><a href="index_temp.php?section=customer" class="arial">������ �������</a></td>
              </tr>
            </table>              </td>
            </tr>
          <tr align="center">
            <td><img src="images/home_24x24.png" width="24" height="24" vspace="4"></td>
            <td><img src="images/basket_middle.png" width="21" height="20"></td>
            <td><img src="images/calculator.gif" width="16" height="16" hspace="4"></td>
            <td><img src="images/all.png" width="20" height="16" hspace="4"></td>
          </tr>
	<? if ($_SESSION['S_USER_TYPE']=="customer") {?>          
          <tr align="center">
            <td colspan="4" align="right" bgcolor="#003399" class="padding6"><a href="index_temp.php?section=customer&mode=exit" class="txtWhite"><strong>�����...</strong></a></td>
            </tr>
    <? }?>        
        </table>
      </td>
<? }?>  
    <td width="100%" align="center" valign="top">
      <div class="padding10 txt120 bold" style="height:60px; padding-top:14px;"> <img src="images/piggy_cash_time.png" width="32" height="32" hspace="8" align="absmiddle">������ ��������
<? if ($author_sections){?>
        <span class="txtRed">��������������</span>
        <? } else{?>����������<? }?> ����� �� ������� ����� �����?</div>
        <div class="padding10"><span class="txtRed">��� ����� �� ����� ������ ������! </span><br>
������ �������� ������ �� ��� ���� � ���� ���������� ����: </div>
	</td>
  </tr>
  <tr class="borderTop1 borderColorGray bgF4FF">
<?   if (!$author_sections){?>
    <td align="center" class="padding10">&nbsp;</td>
<?   }?>    
    <td align="center" valign="top" class="padding10">
<?	 if (!isset($_SESSION['TEST_MODE'])){ 
		
		?><iframe src="index.php?social_bookmarks=yes<?
        
		if ($_SESSION['S_USER_TYPE']&&$_SESSION['S_USER_ID']) {?>&user_type=<?=$_SESSION['S_USER_TYPE'];?>&user_id=<? echo $_SESSION['S_USER_ID']; }
		
		?>" class="widthFull" style="height:26px;" frameborder="0"></iframe><?	   
		
	 }else{?>������ ���������� � ���������� �������� odnaknopka.ru<? }?></td>
  </tr>
      </table>
    </div><?
}?><form name="works" method="post" class="padding0"><!--
    
  	�������� �������
    
  --><? 
//�������� ���������� ������� (������, ���� ���������� ��� ����������, �� �� ��������)
//��� ������:
$request_work_type_all=($_POST['work_type'])? $_POST['work_type']:$_GET['work_type'];
//�������:
$request_work_area_all=($_POST['work_area'])? $_POST['work_area']:$_GET['work_area'];

	//echo "<div class='txtGreen'>
		//	�������� ������ ����������� �������:
		  //<div>request_work_type_all=".$request_work_type_all."</div>";
	//echo "<div>request_work_area_all=".$request_work_area_all."</div>";

//S_WORK_TYPE_ALL - ����������� �������� ��������� ���� ������
//S_WORK_AREA_ALL - ����������� �������� ��������� ��������

//���� �������� ������
//���� � �������� ���������� ���� ��������, ����������� ��� ���������� ���.:
if ($request_work_type_all) $_SESSION['S_WORK_TYPE_ALL']=$request_work_type_all;
//���� �������� ���, �� ���� ���, ���������� �������� ����. ����������:
elseif (isset($_POST['work_type_all'])||isset($_GET['work_type_all'])) unset($_SESSION['S_WORK_TYPE_ALL']);

//���� �������� ������ (���������� �����������)
if ($request_work_area_all) $_SESSION['S_WORK_AREA_ALL']=$request_work_area_all;
elseif (isset($_POST['work_area_all'])||isset($_GET['work_area_all'])) unset($_SESSION['S_WORK_AREA_ALL']);

	//echo "<hr>";
	//echo "<div>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]</div>";
	//echo "<div>S_WORK_AREA_ALL= $_SESSION[S_WORK_AREA_ALL]</div></div>";


if($_REQUEST['work_table']&&!$_REQUEST['work_type']) { 
	
	$work_id=$_REQUEST['work_id'];
	$work_table=$_REQUEST['work_table']; //echo "<div>work_table= $work_table</div>";
	include("sections/work_data.php");
	
}elseif (!$_REQUEST['section']&&!$_REQUEST['article']){ //echo "<h1>IF!</h1>"; 
		   		
	$limit_finish=(strstr($_SERVER['HTTP_HOST'],"localhost"))? 50:500;
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

	$arrAll=$Worx->findAllWorx( $work_subject,
								$work_type,
								$work_area,
								$arrDplomZakazIDsWithFiles,
								$arr //������ ��������������� ��������� �� ������� ���� ��������
							  );
	$all_worx=count($arrAll);?><img src="images/spacer.gif" width="100%" height="12"><table width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td width="100%" class="bgPanel borderBottom1 borderColorGray paddingLeft10"><h1 class="txt130" style="margin-bottom:14px;"><img src="images/shopping_plus-32.png" width="32" height="32" hspace="4" align="absbottom"><?
	    if ($work_subject) {?>���������<? $wcnt=count($arr);}
        else {?>�������<? $wcnt=$all_worx; }?> ������ (<? echo $wcnt;?>):</h1></td>
      <td nowrap class="iborder borderColorGray padding10 bgPale"><a href="#worx_rest">���������� ������</a></td>
    </tr>
</table>
<div class="paddingBottom6 paddingTop6">
<? if (!$work_subject) {?>
<? if ($test_worx_filter){?>{���������� ������� ������ ���� � �������� ����� (������)}<? }
$Worx->setFilterToWorxCriteria();?>
<? }?>
</div>
<!--<img src="images/spacer.gif" width="100%" height="14">--><table width="100%" border="1" cellpadding="4" cellspacing="0" rules="rows" id="tbl_customer">
  	  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale">
  	    <td height="36" class="cellPassive<? //echo($_SESSION['S_SORT']=="subject")? "Active":"Passive";?>"><input type="checkbox" name="checAll" id="checkAll" onClick="manageCheckBoxes(this,'tbl_customer');"></td>
  	    <td bgcolor="#003399" class="padding6 cellPassive<? 
		
		//echo($_SESSION['S_SORT']=="subject"||$work_subject)? "Active":"Passive";
		
		?>"><strong><a>id</a></strong></td>
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
	<?	//�������, ���� �� ����� � �������; - ������� title, ����������� �������
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
    <td>&nbsp;</td>
    <td><a href="index_temp.php?work_table=<?=$work_table?>&work_id=<?=$work_id?>"><?=$work_subject?></a></td>
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
    <td><?=$arrAll[$i]['work_id']?></td>
    <td><a href="index_temp.php?work_table=<?=$arrAll[$i]['work_table']?>&work_id=<?=$arrAll[$i]['work_id']?>"><?=$arrAll[$i]['work_subject']?></a></td>
    <td><?=$arrAll[$i]['work_type']?></td>
    <td><?=$arrAll[$i]['work_area']?></td>
  </tr>
		
<?					$bg_count++;
					if ($arrAll[$i]['work_table']=="diplom_zakaz") $arrDiplomZakaz[]=$arrAll[$i]['work_id'];
				}
    		} 
		}?>
    </table>
	<? 
	
	//� ������ ������� ��� ��������/�������� ������, ������ ����� ���������� � �������, �� ����� � ��� ��� ������...
	echo "<div>[".count($arrDiplomZakaz)."]</div>";
	//var_dump($arrDiplomZakaz);
	//�������� ������ ������:
$qSel="SELECT number, status_cycle, subject FROM diplom_zakaz
   WHERE ( status_cycle = 'closed' OR 
         status_cycle = 'made' OR
		 status_cycle = 'remade' OR
		 status_cycle = 'processed' ) 
ORDER BY number DESC";
$rSel=mysql_query($qSel); 
$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); ?>
<div onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';"><h4><span class="link">����� � �������: <?
$allToSale=mysql_num_rows($rSel); echo $allToSale;?>, ��������, � �������: <? echo count($arrToSale);?>; <? 
?><a name="worx_rest">��������� ������</a></span> (<?=$allToSale-count($arrToSale)?>):</h4></div>
<div style="display:<?="none"?>;">
<?  
while ($arr = mysql_fetch_assoc($rSel)) { 

	if (!in_array($arr['number'],$wAll2)) {
		
		echo "<div>[".$arr['number']."][".$arr['status_cycle']."][files: ";
		//
		$arrFiles=$Worx->getDplomZakazIDsWithFiles();
		if (count($arrFiles)&&is_array($arrFiles)) foreach ($arrFiles as $file) echo "<div>/$file/</div>";
		
		echo "] $arr[subject]</div>";
		//$empty++;

	} 
}?></div><? //echo "<h5>[=$empty=]</h5>";

	$Blocks->authorizeToAddToBasket();?>
    <table cellspacing="0" cellpadding="0">
  <tr>
    <td class="paddingBottom8 paddingTop8"><input type="submit" value="�������� � ������� �������!" style="padding:8px; width:240px;" onClick="return checkAllBoxes('reg_area');"></td>
<?  if ($work_subject) {?>
	<td class="paddingLeft10">[<a href="index.php">�������� ��������� ������</a>]</td>
<? }?>
  </tr>
</table><?	  
	  //$test_pages=true;
	  if ($test_pages){?>{ ������� �� ���������... }<? }
	  $Blocks->makePagesNext($all_worx,$limit_finish);

	}
		//���� ������:
		if (isset($_REQUEST['article'])) include("articles/index.php");
		if (isset($_REQUEST['section'])) include("sections/index_sections.php");
	
?></form></td>
    <td width="23%" valign="top" class="contentColumn borderTop1 borderColorGray paddingLeft20">&nbsp;</td>
  </tr>
  <tr bgcolor="#E1E1FF">
    <td height="50" colspan="2" valign="top" bgcolor="#E1E1FF" class="txt100" id="flat"><a href="index.php">&#8226; �������</a> &nbsp;<a href="index_temp.php?section=payment">&#8226; ������� ������</a> &nbsp;<a href="index_temp.php?section=faq">&#8226; FAQ</a> &nbsp;<a href="index_temp.php?section=useful">&#8226; ��������</a> &nbsp;<a href="index_temp.php?section=agreement">&#8226; ���������������� ����������</a> &nbsp;<a href="index_temp.php?section=partnership">&#8226; ��������������</a></td>
    <td valign="top" class="paddingTop14">&copy;<a href="http://www.eduservice.biz">EducationService</a> 2003-<? echo date("Y");?></td>
  </tr>
</table>
<? 
  }
else include("sections/register.php");?></body>
</html>