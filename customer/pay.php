<? session_start();

require_once('../connect_db.php');
require_once('../classes/class.Actions.php');
require_once('../classes/class.Errors.php');
//require_once('../classes/class.Customer.php');
require_once('../classes/class.Messages.php');
require_once('../classes/class.Money.php');
require_once("../classes/class.Worx.php");

$Actions=new Actions;
$catchErrors=new catchErrors;
$Messages=new Messages; 
$Money=new Money; 
$Worx=new Worx;

if (isset($_REQUEST['payment_id'])) 
	$payment_id=$_REQUEST['payment_id'];
if (isset($_POST['pay_method'])) 
	$Money->handlePayment($payment_id);?>
<html>
<head>
<title>���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������</title>
<meta name="description" content="���� ���������, ��������, ��������� �����. ������� ������, ������� �� �����.">
<meta name="keywords" content="���� ���������, ��������, ������, �������, ��������, ������ �� �����, �������� ������ �� ����, ������ ������, �������� ��, ������� �� ����, ����������, �����, ��������, ���������, �����������, �������, ����������, �������� � ��������, ����������, ��������� ���������, ����������, ���������, ��������� ���������, �����������, ���, ���������, ����������� �����, ����������, ����������, ������, �����, ���������">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../email_check.js"></script>
<link href="../css/txt.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/padding.css" rel="stylesheet" type="text/css">
<link href="../css/border.css" rel="stylesheet" type="text/css">
</head>
<body class="paddingLeft10 paddingRight0" style="overflow:hidden;" onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');"><?

//����� ���������� � �������� ������:
$catchErrors->showGetPostDataForeach($mType);?>
<form class="padding0" method="post" onSubmit="return checkFields();">
<? $Money->paymentAllDataTable($payment_id,true);?>
</form>
</body>