<?
//��. ����� � Docs/������� ������.drt
##########################################

session_start();
if ($_GET['menu']=="exit") {
	session_unset();?>
    ������ ��������� | <a href="index.php">��������� �����</a> | <a href="../index.php">�� �������</a>
<? die();
}
require_once('../connect_db.php');
//
require_once('../classes/class.Author.php');
$Author=new Author;
//
require_once('../classes/class.Blocks.php');
$Blocks=new Blocks;
//
require_once('../classes/class.Errors.php');
$catchErrors=new catchErrors;
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

require_once("../mail/lib_mail_smtp.php");

if (isset($_REQUEST['submenu'])) $submenu=$_REQUEST['submenu'];

//���� ���������� ���������:
if (isset($_REQUEST['send_feedback'])) {
	
	$mSubj="��������� �� ������ id $_SESSION[S_USER_ID] ($_SESSION[S_USER_LOGIN])";
	$mText=$_REQUEST['send_feedback']."<hr>�����: ".$_SESSION['S_USER_LOGIN']." (".$_SESSION['S_USER_NAME'].").";
	if (isset($_REQUEST['payout_id'])) {
		$mSubj.=" �� ������ ������� id $_REQUEST[payout_id]";
		$mText2="<p>������� <a href='?menu=payouts&amp;payout_id=$_REQUEST[payout_id]'>id $_REQUEST[payout_id]</a>.</p>";
	}
	$Messages->sendEmail($toAddress,
						 $_SESSION['S_USER_LOGIN'],
						 $_SESSION['S_USER_LOGIN'],
						 $mSubj,
						 $mText,
						 "default"
						);
	$Messages->writeMessTbl( $_SESSION['S_USER_NAME'],
							 $_REQUEST['ri_basket_id'],
							 $_SESSION['S_ADMIN_EMAIL'],
						     false,
						     "admin",
							 "feedback",
							 $mSubj,
							 $mText.$mText2
							);
}
//���� ������ �� �������� �����������:
if ($_REQUEST['section']=="register"){
	
	//���� ����� �����:	
	if (isset($_REQUEST['new_author'])){
		$Messages->alertReload("����������� � �������� ������������ � ����� �������!","");
	}
}?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������� ������</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/txt.css" rel="stylesheet" type="text/css">
<link href="../css/padding.css" rel="stylesheet" type="text/css">
<link href="../css/border.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../email_check.js"></script>
<? if ($_REQUEST['menu']=="worx") {?>
<script type="text/javascript">

counter=1;
//counter1=0;

function generateFilesFields() {
	
//���������� ����� ��� �������
var files_count=document.getElementById('files_count').value;
//���������� ��� ������:
var typeSel=document.getElementById('work_type');
var selTypeValue=typeSel.options[typeSel.selectedIndex].value; //alert(selTypeValue);
//��������� ��� ��������� ����� ��������
var container=document.getElementById('file_uploading');
//
var upl;
//�������� �������:
//var wacount=0;
//var wtcount=0;
var tblStart="\n<table>\n  <tr>\n    <td>\n";
var tblNextCell="    </td>\n    <td>\n";
var tblNextCell99='    </td>\n    <td style="width:99%">\n';
var tblFinish="\n    </td>\n  </tr>\n</table>";
if (isNaN(files_count)) alert('��������� ���� �������� ��� ���������� ������ �� �������� ������!');
else {  
		i=0;
		while (i<files_count) {
			
			//������ �������� ������
			//������ ����� �����:
			//upl='<!--������������ ��������� ������:-->\n'+wlistHTML;
			upl=' \n<!--������ ���������:-->\n'+tblStart+'<select name="work_area'+counter+'" id="work_area'+counter+'">\n<option value=0 selected>��� ��������</option><option value="����������">����������</option><option value="���������� ����">���������� ����</option><option value="�����������">�����������</option><option value="��������������� �������������, �������, ������">��������������� �������������, �������, ������</option><option value="������: ������������ �����">������: ������������ �����</option><option value="������������, PR, ������������ ����">������������, PR, ������������ ����</option><option value="���������������� � �����">���������������� � �����</option><option value="���������, ��������">���������, ��������</option><option value="��������� ��������">��������� ��������</option><option value="����������, ���������� ����������">����������, ���������� ����������</option><option value="���������">���������</option><option value="����������">����������</option><option value="��������������">��������������</option><option value="��������">��������</option><option value="����������">����������</option><option value="������ ������������">������ ������������</option><option value="������ �������, ��������, ������������������">������ �������, ��������, ������������������</option><option value="����������">����������</option><option value="������� ��������">������� ��������</option><option value="�����������, �����������">�����������, �����������</option><option value="������������������� ������������">������������������� ������������</option><option value="��������� �����">��������� �����</option><option value="�������������� � ������������">�������������� � ������������</option><option value="����������, �������, �������">����������, �������, �������</option><option value="����������������">����������������</option><option value="�������">�������</option><option value="�����������">�����������</option><option value="�������� ���������">�������� ���������</option><option value="����������">����������</option><option value="�������������">�������������</option><option value="������������ ��������">������������ ��������</option><option value="������������� ��������">������������� ��������</option><option value="������">������</option><option value="����������� � �����, ��������">����������� � �����, ��������</option><option value="���������">���������</option><option value="�����">�����</option><option value="��������� � �������">��������� � �������</option><option value="������������� �����">������������� �����</option><option value="��������� � ������">��������� � ������</option><option value="��������������">��������������</option><option value="��������������">��������������</option>\n</select>'+tblNextCell;
			//alert('SEL= '+wlistHTML+'<select name="work_type'>');
			
			//alert(upl);
			//������ ���������:
			upl+=' \n<!--������ ����� �����:-->\n<select style="background-color:#F7f7f7;" name="work_type'+counter+'" id="work_type'+counter+'">\n<option value="0" selected>��� ���� ����� </option><option value="������ MBA">������ MBA</option><option value="��������� ������">��������� ������</option><option value="�����������">�����������</option><option value="������������">������������</option><option value="����������� ������">����������� ������</option><option value="��������">��������</option><option value="������������ ������">������������ ������</option><option value="�����������">�����������</option><option value="����">����</option><option value="���������">���������</option><option value="������������� ��������">������������� ��������</option><option value="���������������� ��������">���������������� ��������</option><option value="������">������</option><option value="�������">�������</option><option value="���������">���������</option><option value="������">������</option>\n</select>'+tblNextCell99;
			//���������� ������ ��� ���:
			upl+='\n<input name="file_'+counter+'" type="file" style="width:99%">'+tblNextCell;
			upl+=' \n<input name="wprice_'+counter+'" id="wprice_'+counter+'" type="text" size="3" title="���� ���� ������" onkeyUp="calculatePrices(this,\'wprice_customer_'+counter+'\');">'+tblNextCell;
			upl+=' \n<input name="wprice_customer_'+counter+'" id="wprice_customer_'+counter+'" type="text" size="3" title="���� ��� ���������" onkeyUp="calculatePrices(this,\'wprice_'+counter+'\');">'+tblNextCell;
			//������� ������������� ������ ��������:
			upl+=' \n<a href="#" \nonClick="parentNode.style.display=';
			upl+="'none';parentNode.parentNode.parentNode.parentNode.parentNode.innerHTML='';return false;";
			// ������� ����: td/tr/tbody/table/div
			upl+='" title="������"><img src="http://localhost/Referats/images/delete2.gif" align="absmiddle" hspace="4" border="0" /></a>'+tblFinish; 
			//alert(upl);
			//���������� ������� ����� ��������:
			//container.insertAdjacentHTML("beforeEnd",upl); //	insertAdjacentHTML	�������� ������ ��� IE!!!
			var newContainer=document.createElement("DIV");				
			var newDiv=container.appendChild(newContainer);
			newDiv.innerHTML=upl;
			var selTypes=document.getElementById('work_area'+counter);
			//alert(selTypeValue);
			for(j=0;j<selTypes.length;j++) {
				
				if (selTypes.options[j].value==selTypeValue) {
					//alert('BINGO!');
					selTypes.options[j].selected=true;
				}
			}
			//alert('\n����������� �����:\n'+newDiv.innerHTML);
			i++;
			counter++; //2
		} 
	  //alert('\n����������� �������:\n'+container.innerHTML);
	  document.getElementById('div_upl_button').style.display='block';
	  counter1+=i;
	}
}

//������ ���������� �������:
function checkLists() {
var bbr='';
var lst=document.getElementById('file_uploading').getElementsByTagName('SELECT');
	for (i=0;i<lst.length;i++) {
		bbr+="<br>="+i+", "+lst.item(i).name;
		//lst.insertAdjacentText("afterEnd",nm);
	}
document.write(bbr);
//return false;
}
//���������� ���� ��� ��������� � ������:
function calculatePrices(active,impacted) {
	
	//average: 25% ($price_ratio=125)
	
	//���� ������ �������� � ������ ��� ���� ������:
	if (active.id.indexOf("customer_")==-1) {
		//400/100*125=500
		document.getElementById(impacted).value=active.value/100*<?=$price_ratio?>;
	}else{ //���� ��� ���� ���������:
		//
		document.getElementById(impacted).value=active.value/<?=$price_ratio?>*100;
	}
}
</script>
<? }?>
<style>
body { 
<? 	if ($submenu!="upload"){?>
	/*overflow:hidden; */
<?	}?>	
	padding:0; 
	margin:0;
}
</style>
</head>
<body onLoad="<?
	
	if (isset($_REQUEST['answer_to'])) {
		//���� �������� �� ������ �� ������: ?>document.forms['form1'].action='index.php';document.forms['form1'].submit();<?
	}else{?>if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');<? 
	}?>">

<? //����� ���������� � �������� ������:
$catchErrors->showGetPostDataForeach($mType);
//���� ����������������:
if (
	( $_REQUEST['email']||$_REQUEST['login']||$_SESSION['S_USER_LOGIN'] ) &&
	( $_REQUEST['do']!="check_current_author_password" || //�� �������������� ��� ������������������� ������ �� �������� ����������� (register.php)
	  $_REQUEST['go_current_author'] //������������ �������� ������ ����� ����� ���������������
	)
   ) {
	//echo "REQUEST['email']= $_REQUEST[email].<hr>";
	//���� ��� ����������������:	
	if ($_SESSION['S_USER_ID']&&$_SESSION['S_USER_TYPE']=="author") {

		$email=$_SESSION['S_USER_LOGIN'];
		$pass=$_SESSION['S_USER_PASS'];	
		//die ("FIRST");

	}else{ //���� ��� ���...

		$email=($_REQUEST['email'])? $_REQUEST['email']:$_REQUEST['login'];
		$pass=$_REQUEST['pass_current'];
		//die ("SECOND");

	} //echo "<div>email=$email, pass=$pass</div>";
	
	//������� ������ ������ ������:	
	$arrAuthor=$Author->getAuthorDataAuth($email,$pass); 
	//���� ������ ������ �� ����������:
	if (!count($arrAuthor)) {
		
		if ( $_SESSION['TEST_MODE'] && 
			 $_REQUEST['pass'] &&
			 $_REQUEST['action']=="just_registered"
		    ) $psswsrws=$_REQUEST['pass'];
		
		else { //���� ����������� �� �������, ��������, ���� �� ����� ����� ������:
			
			$qSelData="SELECT login,name,pass FROM ri_user WHERE login = '$email'";
			//$catchErrors->select($qSelData);
			$rSelData=mysql_query($qSelData);
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
			//�� ����� ������:
			if (!mysql_num_rows($rSelData)) {
			
				$mess="�����, ������������� � ����� ��"; 
				//�����, �� ������ �� ���:			  
			}elseif($_REQUEST['pass_current']!=mysql_result($rSelData,0,'pass')) {
			
				$mess="������������ ������";
			}
			//���� ����:
			/*if (!$psswsrws) {
	
				$mess="������������ ������";
				//$aname=mysql_result($rSelData,0,'name');
				//$apass=mysql_result($rSelData,0,'pass');
	
			}elseif ($_GET['action']!="just_registered"){ //���� ��� � ��� ���� �� ���� ��������, ����� ����� ������ ��������������:
	
				
			}//*/
			
			if ($mess) $Messages->alertReload("�� ������� $mess.",""); 
		}
	} //elseif($_REQUEST['point']!="start") $Messages->alertReload("?menu=default&amp;point=start",false);
} 

if (!count($arrAuthor)&&!$_REQUEST['allow_account']) $show_enter=true;
elseif ($_SESSION['TEST_MODE']&&$_REQUEST['allow_account']) {
	?>{���� � ������� ������������, �.�. ������� �������� ����� � ������ ������ ������ ��������� �� ����...}<? 
	die();
}?>


<form name="form1" method="post" class="padding0" enctype="multipart/form-data"><? echo "\n";
	
if ($_REQUEST['do']=="check_current_author_password") {	
	?><input name="go_current_author" type="hidden" value="1"><? 
} ?>
<table <? if (!$show_enter) {?>width="100%"<? } //height="100%" ?> align="center" cellpadding="0" cellspacing="0">
<?
//���� ������ ������ ������ �� ����������� (������������ ������ ��� �� �������� �����)
//��� ������ ��� ������������������:
if ($show_enter==true) { ?>
  <tr height="25%">
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr style="height:auto">
    <td style="padding-top:40%;"><div id="warning"></div>
<script type="text/javascript">
if (navigator.appName!="Microsoft Internet Explorer") document.getElementById('warning').innerHTML="�� ����������� �������, �� ���������� Internet Explorer.<div class='txtRed paddingBottom10'>��� ����� ������� �������� ��� ������ � ����� ���������.</div>";
</script> 
<? 	### ����� ��������������
	
	if ( $_SESSION['TEST_MODE'] && 
		$_REQUEST['pass'] &&	
		$_REQUEST['action']=="just_registered"
	  ){?><div class="txtRed padding10" align="center">����������� ����������, <br>�.�. ������� ����� ������������</div><? }?>   
<div class="iborder borderColorGray padding8" style="border-width:2px;">

      <table cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="2" align="center" bgcolor="#FFCCFF" class="padding10 borderBottom1 borderColorGray txt90"><img src="<?=$_SESSION['SITE_ROOT']?>images/Unlock-32.png" width="32" height="32" hspace="4" align="absmiddle">���� ��� �������</td>
          </tr>
        <tr>
          <td colspan="2"><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="10" height="10"></td>
          </tr>
        <tr>
    	  <td>E-mail</td>
          <td>
          <input type="text" class="widthFull" name="email" id="email" value="<?=($email)? $email:$_REQUEST['email']?>"><script type="text/javascript">
user_login=0;
</script></td>
        </tr>
        <tr>
          <td>������</td>
          <td>
            <input class="widthFull" type="password" name="pass_current" id="pass_current" value="<?
		  //������ � ������ �������� ����� �������� ������, �.�., ����� ����� ������� �� ������ �� ������:
		  echo $_GET['pass'];?>">
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
	}?></td>
          <td><input type="button" name="button2" id="button2" value="��������� ������" onClick="user_login=document.getElementById('email').value;sendMailAgain('author');"></td>
        </tr>
      </table>
      <div class="padding8"><a href="../?section=register">��� �� ����������������?</a></div>
<?  //
	if (isset($_REQUEST['answer_to'])) {
		//���� �������� �� ������ �� ������:?>
<input name="answer_to" type="hidden" value="<?=$_REQUEST['answer_to']?>">
<?  }	  
//����������� iFrame ��� ������� �������� ������ �� ��������� �����:
$regUser->remPassIframe(); 
	  ?></div>
	</td>
  </tr>  
  <tr height="75%">
    <td colspan="2" valign="top">&nbsp;</td>
  </tr><? echo "\n";  
}else{  //die('!show_enter');

	//1.������� ����� ������ ������
	if (!$_SESSION['S_USER_ID']) {
		$qIns="INSERT INTO ri_sessions ( user_id, 
                          user_type, 
                          session_started 
                        ) VALUES 
                        ( ".$arrAuthor['number'].", 
                          'author', 
                          '".date('Y-m-d H:i:s')."' 
                        )";
		$catchErrors->insert($qIns);
	}
	$_SESSION['S_USER_TYPE']="author";
	$_SESSION['S_USER_ID']=$arrAuthor['number'];
	$_SESSION['S_USER_LOGIN']=$arrAuthor['login'];
	$_SESSION['S_USER_PASS']=$arrAuthor['pass'];
	$_SESSION['S_USER_NAME']=$arrAuthor['name'];

	//��������� ������, �����: 
  	//1.���������� ����� � ������
  	//2.��������� � ������� (���� �� ����������) ���������� ��� ������
  	//3.������� ���������� ������ �������, �������� � ���������
		
	//2.�������� (���� ��� - ��������) ���������� ��� ������ ������:
	$Worx->checkAuthorFilesDir();
    //���������� ����� ����������� �������:
	$limit_finish=100;
	$Worx->setPagesLimit($limit_finish,$limit_start); ?>
    
  <tr class="borderBottom1 authorTblRowHeader" style="height:auto;">
    <td width="100%" align="left" nowrap class="padding6 paddingTop10" id="authorMenu" style="border-bottom-color:#E5E5E5;"><?
	$amenu=($_REQUEST['menu'])? $_REQUEST['menu']:"default";
	//<img src=\"../images/home_domain.png\" border=\"1\">

	require_once("../classes/class.Blocks.php");

	$arrMenus=Blocks::setMenu();

	foreach($arrMenus as $vkey=>$menu) { 

	echo "\n";?><span<? 
		if ($amenu==$vkey||($amenu=="orders"&&$vkey=="worx")){
			?> class="iborder autorMenuActive"<? 
		} 
		if ($vkey=="messages"||$vkey=="worx"){
			?> style="padding-right: 6px !important;"<? 
		}?>><a href="?menu=<?=$vkey?>"><? echo $menu;?></a><?
		if ($vkey=="messages"||$vkey=="worx"||$vkey=="money") {
			//���������� ��� ��������� ��� �������� ������� � ��������� ����� �������:
			//�������/������:
			$table=($vkey=="money")? "payouts":$vkey;
			//������/������:
			$object_name=($vkey=="worx")? "orders":$vkey;
			//�������� �����. ����� ��������:
			//if (isset($_SESSION['TEST_MODE'])) echo "<div>user_id= $user_id, </div>";
			$new_items=$Tools->addObjStatRec("ri_".$table,$amenu,$object_name,$_SESSION['S_USER_ID']);
			if ($new_items) {
				
					if ($vkey=="default")
					switch ($vkey)  { 

						case "worx":
							$new_worx=$new_items;
								break;
				
						case "messages":
							$new_messages=$new_items;
								break;
				
						case "money":
							$new_payouts=$new_items;
								break;
					}

				?> &nbsp;<a class="txtRed"><img src="../images/flag_green1.gif" width="16" height="16" border="0">:<?=$new_items?></a><?
			}		
		}
		if ($vkey=="messages"||$vkey=="worx") {
			
			?></span><a href="?menu=<? 
		
			if ($vkey=="messages") {
				?>messages&amp;action=compose<? 
				$title="����� ���������";
			}
			else {
				?>worx&amp;submenu=upload<? 
				$title="���������� ��������� ������";
			} ?>" title="<?=$title?>..."><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" border="0" align="absmiddle"></a><? 
		}else echo "</span>";
	}	
	if ($test_menu){?>
    	<span class="iborder autorMenuActive"><a href="#">������</a></span>
        <span><a href="#">�������</a></span>
        <span style="padding-right:0;"><a href="?menu=messages">���������</a></span><a title="����� ���������..." href="?menu=messages&amp;action=compose"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" border="0" align="absmiddle"></a>
        <span><a href="#">������</a></span>
        <span><a href="#">�����������</a></span>
        <span><a href="#">FAQ</a></span>
        <span><a href="#">����������</a></span>
        <span><a href="#">�������� �����</a></span><?
	}?><span><a href="?menu=exit">�����</a></span></td>
    <td style="border-bottom-color:#E5E5E5;">&nbsp;</td>
  </tr>
  <tr height="100%">
    <td colspan="2" valign="top" style="border-top:solid 1px #CCC;"><?
	
	$use_docs_reducer="��� <a href=\"?menu=tools&amp;point=howitworks\">������� ���������� ���������</a>, ����������, ����������� ���� ��������� <strong>DocsReducer</strong>&#8482;, ��������� ��� ���������� � ������� <strong><a href=\"?menu=tools\">�����������</a></strong>.";
    
	?><div<?  //style="overflow:auto; height:100%;"
	if ($_REQUEST['menu']!="tools"){?> class="padding8 paddingTop14"<? }?>><?

    	$content=($_REQUEST['menu'])? $_REQUEST['menu']:"default";
		include("content_".$content.".php");
	
	?></div></td>
  </tr>
<?
}?>
</table>
</form>
</body>
</html>