<?
//��. ����� � Docs/������� ������.drt
##########################################
session_start();

//������������� �������� ��������:
###############################################################################################
//�������������� ������:
if (isset($_REQUEST['affiliation'])) {
	$_SESSION['FILTER_WORX_AFFILIATION']=$_GET['affiliation'];
	if (isset($_POST['affiliation'])) $_SESSION['FILTER_WORX_AFFILIATION']=$_POST['affiliation'];
	//echo "<div>FILTER_WORX_AFFILIATION= $_SESSION[FILTER_WORX_AFFILIATION]</div>";
}else $_SESSION['FILTER_WORX_AFFILIATION']="all";
//��� ������:
if (isset($_REQUEST['work_type'])) {
	$_SESSION['FILTER_WORX_TYPE']=$_GET['work_type'];
	if (isset($_POST['work_type'])) $_SESSION['FILTER_WORX_TYPE']=$_POST['work_type'];
	//echo "<div>FILTER_WORX_AFFILIATION= $_SESSION[FILTER_WORX_AFFILIATION]</div>";
}else unset($_SESSION['FILTER_WORX_TYPE']);
###############################################################################################

if (isset($_REQUEST['work_subject'])) $work_subject=$_REQUEST['work_subject'];
$action=$_GET['action'];
$order_id=$_REQUEST['order_id'];	


if ($_GET['menu']=="exit") {
	session_unset();?>
    ������ ��������� | <a href="index.php">��������� �����</a> | <a href="../index.php">�� �������</a>
<? die();
}
require_once('../connect_db.php');
//
require_once('../classes/class.Actions.php');
$Actions=new Actions;
//
require_once('../classes/class.Actors.php');
$Actors=new Actors;
//
require_once('../classes/class.Author.php');
$Author=new Author;
//
require_once('../classes/class.Blocks.php');
$Blocks=new Blocks;
//
require_once('../classes/class.Customer.php');
$Customer=new Customer;
//
require_once('../classes/class.Errors.php');
$catchErrors=new catchErrors;
//
require_once('../classes/class.Manager.php');
$Manager=new Manager;
//
require_once('../classes/class.Messages.php');
$Messages=new Messages;
//
require_once('../classes/class.Money.php');
$Money=new Money;
//
require_once("../classes/class.Orders.php");
$Orders=new Orders;
//
require_once('../classes/class.regUser.php');
$regUser=new regUser;
//
require_once('../classes/class.Tools.php');
$Tools=new Tools;
//
require_once("../classes/class.Worx.php"); 
$Worx=new Worx;

if (isset($_REQUEST['submenu'])) $submenu=$_REQUEST['submenu'];?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������� ����������</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/txt.css" rel="stylesheet" type="text/css">
<link href="../css/padding.css" rel="stylesheet" type="text/css">
<link href="../css/border.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../email_check.js"></script>
<script type="text/javascript">
function findOrderById(order_id_cell) {
var inputOrder=document.getElementById(order_id_cell);
	if (inputOrder.value=='') alert('�� �� ������� id ������!');
	else location.href='?menu=money&amp;order_id='+inputOrder.value;
}
function findWorkByName(work_name_cell) {
var inputWork=document.getElementById(work_name_cell);
	if (inputWork.value=='') alert('�� �� ������� ���� ������!');
	else location.href='?menu=worx&amp;work_subject='+inputWork.value;
}
function manageSearchCells(cellNameShow,cellNameHide){
document.getElementById('find_order_row').style.display='block';
document.getElementById(cellNameShow).style.display='block';
document.getElementById(cellNameHide).style.display='none';
}
</script>

<style>
body { 
	overflow:hidden; 
	padding:0; 
	margin:0;
}
</style>
</head>
<body onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');">

<? //����� ���������� � �������� ������:
$catchErrors->showGetPostDataForeach($mType);
//���� ����������������:
if ($_REQUEST['login']||$_SESSION['S_USER_LOGIN']) {
	
	//���� �������� ������ ����� ��������������:
	if (isset($_REQUEST['login'])){ 

		$login=$_REQUEST['login'];
		$password=$_REQUEST['pass_current'];
	
	}elseif (isset($_SESSION['S_USER_ID'])) { //���� ��� ����������������:	

		$login=$_SESSION['S_USER_LOGIN'];
		$password=$_SESSION['S_USER_PASS'];	

	}
	//������� ������ ������ ����������:	
	$arrManager=$Manager->getManagerData(false,$login,$password);
	//���� ������ ������ ����������:
	if (!count($arrManager)) {
		
		//���� ����������� �� �������, ��������, ���� �� ����� ����� ������:
		$qSelData="SELECT login,name,password FROM ri_workers WHERE login = '$login'";
		$rSelData=mysql_query($qSelData);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		//���� ����:
		if (mysql_num_rows($rSelData)) {

			$mess="������������ ������";
			$aname=mysql_result($rSelData,0,'name');
			$apass=mysql_result($rSelData,0,'password');

		}elseif ($_GET['action']!="just_registered"){ //���� ��� � ��� ���� �� ���� ��������, ����� ����� ������ ��������������:

			$mess="�����, ������������� � ����� ��"; 
		}//

		if ($mess) $Messages->alertReload("�� ������� $mess.",""); 
	}
} ?>
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" class="padding0" enctype="multipart/form-data"<? 
	if ($_SESSION['S_USER_TYPE']=="worker"&&$_REQUEST['action']=="compose"){?> onSubmit="return actors.checkSubjectsChecked();"<? }?>>
<?
//���� ������ ������ ������ �� ����������� (������������ ������ ��� �� �������� �����)
//��� ������ ��� ������������������:
if ( !count($arrManager) || 
     ( $_GET['action']=="just_registered" && !$_REQUEST['allow_account'] )
   ) {?>
  <tr height="25%">
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr style="height:auto">
    <td><div id="warning"></div>
<script type="text/javascript">
if (navigator.appName!="Microsoft Internet Explorer") document.getElementById('warning').innerHTML="�� ����������� �������, �� ���������� Internet Explorer.<div class='txtRed paddingBottom10'>��� ����� ������� �������� ��� ������ � ����� ���������.</div>";
</script>    
<center><div class="iborder borderColorGray padding8" style="border-width:2px; width:200;">
      <table cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFCC" class="padding10 borderBottom1 borderColorGray txt90"><img src="<?=$_SESSION['SITE_ROOT']?>images/Unlock-32.png" width="32" height="32" hspace="4" align="absmiddle">���� ��� �����������</td>
        </tr>
        <tr>
          <td colspan="2"><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="10" height="10"></td>
          </tr>
        <tr>
          <td>�����</td>
          <td>
            <input type="text" name="login" id="login" value="<?=$login?>" class="widthFull"><script type="text/javascript">
user_login=0;
</script></td>
        </tr>
        <tr>
          <td>������</td>
          <td>
          <input type="password" name="pass_current" id="pass_current" value="<?
		  //������ � ������ �������� ����� �������� ������, �.�., ����� ����� ������� �� ������ �� ������:
		  echo $_GET['password'];?>" class="widthFull">
        </td>
        </tr>
        <tr>
          <td colspan="2" class="padding0"><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" alt="" width="10" height="6"></td>
        </tr>
        <tr>
          <td><input name="button" type="submit" id="button" value="�����!">
<?  //���� �� ����������� ���� � �������:
	if ($_GET['action']=="just_registered") {?>          
            <input type="hidden" name="allow_account" id="allow_account" value="yes"><? 
	}
	if (isset($_REQUEST['answer_to'])) {
		//���� �������� �� ������ �� ������:?>
			<input name="answer_to" type="hidden" value="<?=$_REQUEST['answer_to']?>">
<?  }?></td>
          <td><input type="button" name="button2" id="button2" value="��������� ������" onClick="user_login=document.getElementById('login').value;sendMailAgain('worker');" style="visibility:hidden;"></td>
        </tr>
      </table><?
//����������� iFrame ��� ������� �������� ������ �� ��������� �����:
$regUser->remPassIframe(); 
	  ?></div></center>
	</td>
  </tr>  
  <tr height="75%">
    <td colspan="2" valign="top">&nbsp;</td>
  </tr><? echo "\n";

}else{ 

	//1.������� ����� ������ ������
	if (!$_SESSION['S_USER_ID']) {
		$qIns="INSERT INTO ri_sessions ( user_id, 
                          user_type, 
                          session_started 
                        ) VALUES 
                        ( ".$arrManager['number'].", 
                          'worker', 
                          '".date('Y-m-d H:i:s')."' 
                        )";
		$catchErrors->insert($qIns);
	}
	$_SESSION['S_USER_LOGIN']=$arrManager['login'];
	$_SESSION['S_USER_NAME']=$arrManager['name'];
	$_SESSION['S_USER_ID']=$arrManager['number'];
	$_SESSION['S_USER_PASS']=$arrManager['password'];
	$_SESSION['S_USER_STATUS']=$arrManager['status'];
	$_SESSION['S_USER_TYPE']="worker";

    //���������� ����� ����������� �������:
	$limit_finish=50;
	$Worx->setPagesLimit($limit_finish,$limit_start);

	//��������� ������, �����: 
  	//1.���������� ����� � ������
  	//2.��������� � ������� (���� �� ����������) ���������� ��� ������
  	//3.������� ���������� ������ �������, �������� � ��������� ?>
    
  <tr class="borderBottom1 authorTblRowHeader" style="height:auto;">
    <td colspan="2" align="left" nowrap class="padding6 paddingTop10" id="authorMenu" style="border-bottom-color:#E5E5E5;"><?
	$menu=($_REQUEST['menu'])? $_REQUEST['menu']:"default";
	
	function setAtt($menu) {
		if($_REQUEST['menu']==$menu) echo ' class="iborder autorMenuActive"';
	}?>
        <span<? setAtt(false);?>><a href="index.php">�������</a></span>
    	<span<? setAtt("worx");?> style="padding-right:4px;"><a href="?menu=worx">������</a><?

		//�������� �����. ����� �����:
		$new_authors_worx=$Tools->addObjStatRec("ri_worx",$menu,"worx");
		if ($new_authors_worx) {
			
			?> &nbsp;<a href="#" class="txtRed"><img src="../images/flag_green1.gif" width="16" height="16" border="0">:<?=$new_authors_worx?></a><?
			
		}?></span><a title="����� ������..." href="#" 
onClick="manageSearchCells('fWorkSubj','fOrder');return false;"><img src="<?=$_SESSION['SITE_ROOT']?>images/find.png" width="16" height="16" border="0" align="absmiddle"></a>
    	<span<? setAtt("orders");?> style="padding-right:4px;"><a href="?menu=orders">������</a><?

		//�������� �����. ����� �������:
		$new_orders=$Tools->addObjStatRec("ri_basket",$menu,"orders");
		if ($new_orders) {
			
			?> &nbsp;<a href="#" class="txtRed"><img src="../images/flag_green1.gif" width="16" height="16" border="0">:<?=$new_orders?></a><?
			
		}?></span><a title="����� �����..." href="#" 
onClick="manageSearchCells('fOrder','fWorkSubj');return false;"><img src="<?=$_SESSION['SITE_ROOT']?>images/find.png" width="16" height="16" border="0" align="absmiddle"></a>
        <span<? setAtt("money");?> style="padding-right:4px;"><a href="?menu=money">������ �/�</a><?

		//�������� �����. ����� ��������:
		$payment_menu=($menu=="money")? "payments":$menu;
		$new_payments=$Tools->addObjStatRec("ri_payments",$payment_menu,"payments");
		if ($new_payments) {
			
			?> &nbsp;<a href="#" class="txtRed"><img src="../images/flag_green1.gif" width="16" height="16" border="0">:<?=$new_payments?></a><?
			
		}?></span><a title="����� �������� �/�..." href="?menu=mone&amp;action=add"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" border="0" align="absmiddle"></a>
        <span<? setAtt("payouts");?> style="padding-right:4px;"><a href="?menu=payouts">�������</a></span><a title="����� �������� � �������..." href="?menu=payout&amp;action=add"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" border="0" align="absmiddle"></a>
        <span<? setAtt("messages");?> style="padding-right:4px;"><a href="?menu=messages">���������</a><?

		//�������� �����. ����� ���������:
		$new_messages=$Tools->addObjStatRec("ri_messages",$menu,"messages");
		if ($new_messages) {
			
			?> &nbsp;<a href="#" class="txtRed"><img src="../images/flag_green1.gif" width="16" height="16" border="0">:<?=$new_messages?></a><?
			
		}?></span><a title="����� ���������..." href="?menu=messages&amp;action=compose"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" border="0" align="absmiddle"></a>
        <!--<span<? setAtt("actors");?>><a href="?menu=actors">��������</a></span>-->
        <span<? setAtt("data");?>><a href="?menu=data">������</a></span>
        <span<? setAtt("agreements");?>><a href="?menu=agreements">����������</a></span>
		<span><a href="?menu=exit">�����</a></span></td>
    </tr>
  <tr style="height:auto; display:<?="none"?>;" id="find_order_row">
  	<td colspan="2" class="padding4 bgPale">
    <span id="fOrder" style="display:<?="none"?>;padding-left:180px;"><?
    $hide_search='<img src="'.$_SESSION['SITE_ROOT'].'images/delete_gray.png" width="16" height="16" hspace="4" border="0" align="absmiddle" title="������ ���� ������" onClick="switchDisplay(\'find_order_row\');">'; echo $hide_search;?>����� ����� id 
  	  <input id="find_order" name="find_order" type="text" size="2">
  	  <input type="button" onClick="findOrderById('find_order');" value="�����!"></span>
    <span id="fWorkSubj" style="display:<?="none"?>;padding-left:96px;"><?=$hide_search?>����� ������ �� ���� 
  	  <input id="work_subject" name="work_subject" type="text" size="80">
  	  <input type="button" onClick="findWorkByName('work_subject');" value="�����!"></span>      </td>
  </tr>
  <tr height="100%">
    <td colspan="2" valign="top" style="border-top:solid 1px #CCC;"><div style="overflow:auto; height:100%;" class="padding8 paddingTop14"><?

    	$content=($_REQUEST['menu'])? $_REQUEST['menu']:"default";
		include("content_".$content.".php");
	
	?></div></td>
  </tr>
<?
}?>
</form>
</table>
</body>
</html>