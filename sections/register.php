<?
if ($current_level!="index") {

	if (!$Author) { //�� � index.php
		require_once("../connect_db.php");
		require_once("../classes/class.Messages.php");
		require_once("../classes/class.Author.php");
		require_once("../classes/class.Errors.php");
		$Messages=new Messages;
		$Author=new Author;
		$catchErrors=new catchErrors;
	}
}
//���� ��������� ��������� ������:
if (isset($_GET['email_to_send_password'])) {
	
	$Author->rememberPassword($_REQUEST['email_to_send_password'],$_REQUEST['actor_type']);

}else{ //�� ������� ���������� ������
	
	//�������� ������ ������-�����������:
	$arrMkData=$Author->checkAuthorAsMaker($_REQUEST['email']);
	
	//��������, ������������� �� ����� - �������� �����������:
	if ( isset($_REQUEST['pass_current']) && //������� ������ ��� ��������
		 $_REQUEST['pass_current']!=$arrMkData['pass'] //�� ��������� � �������� �������
	   ) {
		//������ ������:
		$Author->rememberPassword($_REQUEST['email'],"author","diplom_maker");
		//������� ���������:
		$Messages->alertReload("��������� ���� ������ �� ��������� � ���������� � ����� ��. ���������� ������ ������� �� ��� �����.","author/");	
	}
	//���������� ������������ ������ ������:
	if ($_REQUEST['new_author']=="step2"){
		//���� ���������� ����� ����� (�� �����������):
		$passw=$_REQUEST['pass']; 
		//���� �����������:
		if (!isset($_REQUEST['pass'])) $passw=$_REQUEST['pass_current'];
		$regUser->regAuthor();
		$Messages->alertReload("����������� ������������!\\n���� ������ �������� �� ��������� ���� �����.","author/?email=$_REQUEST[email]&amp;pass=$pass&amp;action=just_registered&amp;allow_account=allow");
	
	}?>

<div class="borderBottom4 borderColorGray bgWhite">
 <form class="padding0" onSubmit="return checkCells();">
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function diplom_hint ()	{
var job="<a href=http://www.diplom.com.ru/job.htm target=_blank>�����</a>";
var collapse="";
if (document.getElementById('diplom_maker').innerHTML=='') 
	{
	document.getElementById('diplom_maker').innerHTML='<br>&nbsp;����������� � ������� Diplom.com.ru ���� ��� ����������� ��������� �� ����� ���������� ���������� ������ ��� ��� ����������. ����������� �������� '+job+'.&nbsp;<br><br>';
	document.getElementById('clps').innerHTML="�������� ���������</span><br>";
	}
	else {
	document.all['diplom_maker'].innerHTML='';
	}
}*/


//���������� ����������� ������������� ����� � ������� � �������� ������ ��� ��������� �������� ���
//check_free_sources=0;

function checkCells	()	{
	
	var myFm = document.forms[0]; 

if (myFm.email&&myFm.email.type=="text") {
	//alert(myFm.email);
	return emailCheckReferats(myFm.email);
}
if (myFm.family&&!myFm.family.value) {
	alert ('�� �� �������, ��� � ��� ����������!');
	myFm.family.style.backgroundColor='yellow';
	myFm.family.focus();
	return false;
}

if (myFm.city&&!myFm.city.value) {
	alert ('�� �� ������� ����� ����������!');
	myFm.city.style.backgroundColor='yellow';
	myFm.city.focus();
	return false;
}

if (myFm.howmach) {
	
	if (!myFm.howmach.value||myFm.howmach.value==' ') {
		alert ('�� �� �������, ������� � ��� ������� �����!');
		myFm.howmach.style.backgroundColor='yellow';
		myFm.howmach.focus();
		return false;
	}else if (myFm.howmach&&isNaN(myFm.howmach.value)) {
		alert ('���� ��� ���������� ������� ����� �� ������ ��������� ������, ����� ����!');
		myFm.howmach.style.backgroundColor='yellow';
		myFm.howmach.focus();
		return false;
	}
}

if (myFm.site) {
	
	//���������, ���� �� � ������ home page
	var radios=document.getElementById('homePage').getElementsByTagName('input');
	var hPage=false;
	
	for (i=0;i<radios.length;i++) {
		
		if(radios.item(i).type=="radio"&&radios.item(i).checked==true) { 
			
			hPage=true;
			break;
		}
	}
	
	if (!hPage) {
		
		alert ('�� �� ��������, ���� �� � ��� ����������� �������� ��������, �������� ����� � ���������!');
		document.getElementById('homePage').style.backgroundColor='yellow';
		location.href='#ownpage';
		return false;
	
	}else{
		
		var tValue=myFm.site.value;
		if (document.getElementById('myURL').style.display=='block') {

			if (!tValue) 	{//��������� �� �� ������� ������ URL
				alert ('�� �� ���������� URL ����� �������� ���������, �������� ����� � ����������!'); 
				document.getElementById('site').style.backgroundColor='yellow'; 
				myFm.site.focus(); return false;
			}
			//����� ��������� ���������� ������ URL. �� �������, ����:
			//1. ����� 4-� ��������
			//2. ���  ��� �����
			//3. ��� ����� ����� ����� 2-� ��������
			//4. ��� ����� ����� ����� 4-� ��������
			
			else if ( tValue.length<4||
					  tValue.lastIndexOf(".")==-1||
					  tValue.substring(tValue.lastIndexOf("."),tValue.length).length<3||
					  tValue.substring(tValue.lastIndexOf("."),tValue.length).length>5
					) {
				alert ('URL ����� �������� ������ �����������!'); 
				document.getElementById('site').style.backgroundColor='yellow';  
				myFm.site.focus(); 
				return false;
			}
		  }
		if (document.getElementById('mySiteTime').style.display=='block'&&!myFm.time.value) {
			alert ('�� �� ��������, ����� ���������� ������� ����������� �������� ���������, �������� ����� � ����������!'); 
			document.getElementById('time').style.backgroundColor='yellow'; 
			myFm.time.focus(); 
			return false
		}
	}
}
//������:
if (myFm.mobila&&!myFm.mobila.value) {
		alert ('�� �� ������� � ������ ���������� ��������!'); 
		myFm.mobila.style.backgroundColor='yellow'; 
		myFm.mobila.focus(); 
		return false	
}

if (myFm.ICQ) {

	if (myFm.ICQ.value&&isNaN(myFm.ICQ.value)) {
		alert ('������ ��� ������ ICQ �� ������ ��������� ������, ����� ����!');
		myFm.ICQ.style.backgroundColor='yellow';
		myFm.ICQ.focus();
		return false;
	}
}

if (myFm.WMR) {

	if (myFm.WMR.value&&isNaN(myFm.WMR.value)) {
		alert ('������ ��� �������� ����� WebMoney �� ������ ��������� ������, ����� ����!');
		myFm.WMR.style.backgroundColor='yellow';
		myFm.WMR.focus();
		return false;
	}
}

if (myFm.WMZ) {

	if (myFm.WMZ.value&&isNaN(myFm.WMZ.value)) {
		alert ('������ ��� ����� WebMoney � �������� �� ������ ��������� ������, ����� ����!');
		myFm.WMZ.style.backgroundColor='yellow';
		myFm.WMZ.focus();
		return false;
	}
}

if (myFm.WME) {

	if (myFm.WME.value&&isNaN(myFm.WME.value)) {
		alert ('������ ��� ����� WebMoney � ���� �� ������ ��������� ������, ����� ����!');
		myFm.WME.style.backgroundColor='yellow';
		myFm.WME.focus();
		return false;
	}
}


if (myFm.WMU) {

	if (myFm.WMU.value&&isNaN(myFm.WMU.value)) {
		alert ('������ ��� ����� WebMoney � ������� �� ������ ��������� ������, ����� ����!');
		myFm.WMU.style.backgroundColor='yellow';
		myFm.WMU.focus();
		return false;
	}
}


if (myFm.YmoneY) {

	if (myFm.YmoneY.value&&isNaN(myFm.YmoneY.value)) {
		alert ('������ ��� ����� ������.������ �� ������ ��������� ������, ����� ����!');
		myFm.YmoneY.style.backgroundColor='yellow';
		myFm.YmoneY.focus();
		return false;
	}
}

if (myFm.pass_current&&!myFm.pass_current.value) {

		alert ('�� �� ������� ���� ������ �����������!');
		myFm.pass_current.style.backgroundColor='yellow';
		myFm.pass_current.focus();
		return false;
}
if (myFm.pass&&myFm.pass2) {

	if (myFm.pass&&!myFm.pass.value) {
		alert ('�� �� ����� ������!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass.focus();
		return false;
	}
	
	if (myFm.pass.value&&myFm.pass.value.length<4) {
		alert ('����� ������ �� ������ ���� ����� 4-� ��������!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass.focus();
		return false;
	}
	
	if (myFm.pass2&&!myFm.pass2.value) {
		alert ('�� �� ����������� ������!');
		myFm.pass2.style.backgroundColor='yellow';
		myFm.pass2.focus();
		return false;
	}

	if (
		 (myFm.pass.value&&myFm.pass2.value)&&
		 (myFm.pass.value!=myFm.pass2.value)
	   ) {
		alert ('������ �� ���������!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass2.style.backgroundColor='lime';
		location.href='#mypasses';
		return false;
	}else{
		myFm.pass.style.backgroundColor='';
		myFm.pass2.style.backgroundColor='';
	}
}


//���������, ������� �� ���-������ ����� � ������ ��� ������ � ��������� �� ��� ������:
var preObj=document.registration;
//����� �������� ������

if ( document.getElementById('user_answer') &&
	 document.getElementById('user_answer').style.display!='none'
   ) {
	for (i=0;i<16;i++) {

		if ( preObj.elements['authors_free'+eval(i+1)].value!=''||
			 preObj.elements['customer_free'+eval(i+1)].value!=''||
			 preObj.elements['worx_free'+eval(i+1)].value!=''
		    ) check_free_sources++;
	}
	if (check_free_sources==0) {
		alert ('�� ������ �� ����� � ������ ��� ������� ������!'); 
		document.getElementById('user_answer').style.backgroundColor='yellow'; 
		location.href="#free_period"; 
		return false;
	}else{
		var check_dot=0;
		//��������� ���������� ������ ������� ������

		for (j=0;j<16;j++)		
		  { 
			var cellObjAuthor=preObj.elements['authors_free'+eval(j+1)].value;
			//�������� ������ ��� ������ ������� ������ ��� ���������� ��������� ����������
			var cellObjCustomer=preObj.elements['customer_free'+eval(j+1)].value;
			//�������� ������ ��� ������ ������� ������ ��� ���������� ���������� ����������		
			var cellObjWorx=preObj.elements['worx_free'+eval(j+1)].value;
			//�������� ������ ��� ������ ������� ������ ��� ���������� ������ �����
			var ALength=cellObjAuthor.length;
			//����� ������ � ������ �������
			var CLength=cellObjCustomer.length;
			//����� ������ � ������ ���������� 
			var WLength=cellObjWorx.length;
			//����� ������ � ������ ���������� �����
			var Adot=cellObjAuthor.lastIndexOf('.');
			//������������� ������� ����� � ������ ������ ����� ��� �������
			var Cdot=cellObjCustomer.lastIndexOf('.');
			//������������� ������� ����� � ������ ������ ����� ��� ����������
			var Wdot=cellObjWorx.lastIndexOf('.');
			//������������� ������� ����� � ������ ������ ����� ��� ���������� �����
			var aFullLength=cellObjAuthor.substring(Adot,ALength).length;
			//����� ����� ����� ��� �������, ������� �� ����� � �� �����
			var cFullLength=cellObjCustomer.substring(Cdot,CLength).length;
			//����� ����� ����� ��� ����������, ������� �� ����� � �� �����
			var wFullLength=cellObjWorx.substring(Wdot,WLength).length;
			//����� ����� ����� ��� ���������� �����, ������� �� ����� � �� �����
						
		//	 ����� ��� �������, ����:
		//1. ����� 4-� ��������
		//2. ���  ��� �����
		//3. ��� ����� ����� ����� 2-� ��������
		//4. ��� ����� ����� ����� 4-� ��������
		
		if ( (cellObjAuthor&&(ALength<4||Adot==-1||aFullLength<3||aFullLength>5)) || (cellObjCustomer&&(CLength<4||Cdot==-1||cFullLength<3||cFullLength>5)) || (cellObjWorx&&(WLength<4||Wdot==-1||wFullLength<3||wFullLength>5)) ) check_dot++;
	 	}
		if (check_dot>0){
			alert ('��������� ������������ ������ ��������� ���� ������� ������!'); 
			document.getElementById('user_answer').style.backgroundColor='yellow';
			location.href='#free_period';
			return false;
		}
  	}
  }

	//���� ������� ���� (����� �� ���������������, ��� �����), � �� - �� �������:
	if (myFm.agree&&myFm.agree.checked==false) {
		alert ('�� �� ����������� � ��������� ������ ����������������� ����������!');
		location.href='#agree_point';
		document.getElementById('agree').style.backgroundColor='yellow';
		return false;
	}
return true;
}
//-->
</script>
   <input name="section" type="hidden" value="register">
 <table cellspacing="0" cellpadding="0">
   <tr>
     <td class="paddingLeft10"><img src="<?=$_SESSION['SITE_ROOT']?>images/key_money.jpg" width="163" height="108" hspace="10" vspace="20"></td>
     <td><h3>����������� ������ (������������ ���������� �����).</h3>
 <p class="headerAuthorReg">��� <?
if (isset($_REQUEST['email'])){
	?>2<? 
	$stage=2; 
	$email=$_REQUEST['email']; 
}else{
	?>1<? 
	$stage=1; 
} ?> �� 2.</p></td>
   </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td width="50%" valign="top"><?
//���� �� ������ ���� ����������� - �������� ������:
if ($stage==1) { if ($test_stage1){?><h1>��� 1</h1>(�������� �����������)<hr><? }?>
      <p>����������� � ����� ������� ������� �� 2-� ������� �����
          � ����� � ��� ������� �������. �����
          ����� �� �������� ������ �� ���� �������� ����� �������. </p>
      <p><strong>����������, ������� ���� <nobr>e-mail:</nobr></strong> </p>
      <div class="paddingBottom6 txtGreen txt90"><img src="images/lamp2.png" width="20" height="20" align="left" /> ���� �� ��� ������������� � ������ �������� <script type="text/javascript">
dwrite('Educationservice');
</script>.ru (<noindex><a href="#" onClick="location.href='http://www.diplom.com.ru/esys4/';return false;"><script type="text/javascript">
dwrite('diplom.com.ru');
</script></a></noindex>), ������� ���� ���������� ����� ����������� ���������� ���������� �����.</div>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%"><input name="email" type="text" id="email" class="widthFull"></td>
          <td><input type="submit" name="Submit" value="���������� &rsaquo;&rsaquo;" ></td>
        </tr>
      </table>
        <?
}
//���� ��� ��������� �����:
elseif ($stage==2) {
	//�������� ������������������ ������ ������ �� ��� ������:
	$us_n=count($Author->getAuthorDataAuth($email,""));
	//���� ��� ����� ������� - ���������, � �� ����������� �� ��???
	if (!$us_n){ ?><input name="new_author" type="hidden" value="<?=$email?>"><?
		
		$arrMkData=$Author->checkAuthorAsMaker($email);
		$dus_n=count($arrMkData);
		
		if($dus_n) { //������ ��� ��������� ������
			
		    $dlogin=$email;
			$dlogin=$arrMkData['login'];
			$dname=$arrMkData['name'];
			$dpass=$arrMkData['pass'];
			$dphone=$arrMkData['phone'];
			$dmobila=$arrMkData['mobila'];
			$dicq=$arrMkData['icq'];
			$dcity=$arrMkData['city'];
			$dWMR=$arrMkData['WMR'];
			$dWMZ=$arrMkData['WMZ'];
			$dWME=$arrMkData['WME'];
			$dYmoneY=$arrMkData['YmoneY'];
			$dBankAcc=$arrMkData['BankAcc'];
	  	  }
      
	  }else{ //ri_user data://���� ��������������� ��� �����
		$pageReload="author/?email=$email&amp;do=check_current_author_password";
		$alertMess="�� ��� ���������������� ��� �����-����������� ������� ���������� �����.\\n�� ������ �������������� �� �������� �����������.";
		$Messages->alertReload($alertMess,$pageReload);
	  }


	//���� �����-���� ������ ��� ������:
	//� ��������� ����� ���������, �.�. �������� ����� ������ �����, ������� ����������� �� ���������� ������
	if (isset($mess)){?><div class="txtRed"><? if ($test_mess){?>��������� � ������������� ������������ ���Ĩ���� ������....<? }?><?=$mess?></div><? 
	}else{?>
<strong class="arialEncrised">��������� ������ � ��� ������������ ������� ����� ������!</strong> <br>����, ���������� �������� <span class="txtRed txt100">*</span> �������� ������������� � ����������!<hr noshade /><?	
	}
	
	//���� ����� ����� ������������ ��� �������:
	if ($us_n||$dus_n) { 
		
		//������� � ���, ��� �� �������� ������������ � ��������� ��� ������:?>
        <p><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/i_triangle.png" width="15" height="15" hspace="4" vspace="8" align="absmiddle">��������!</strong>
          <br>
          <?
		  if ($dus_n){?>��������� ���� ����� ����������� ������ �� ����� ������������ ���������� ���������� �����, ��������������� � ������ ��������� <script type="text/javascript">
dwrite('EducationService.ru � Diplom.com.ru');
</script>. ���� ��� &#8212; ��, �<? }
		  else {?>�� ��� ���������������� � ��� � �������� ������. �<? }?>���������, ��������� ���� ������ (��. ����) � ���� �����������, ���� �������������� ��. ��� ��������� �������� ������ ������. ���� �� ������ ���, �������� <a href="javascript:sendPass('<?=$email?>','author');">�����</a>, � �� ������ ��� �� ��������� ���� �����.
<?  }
	//
	if ($test_stage1){?>
        <h1>��� 2</h1>(�������� �����������)<hr><? }?>

<input name="email" type="hidden" id="email" value="<?php echo($email);?>">
<input name="new_author" type="hidden" id="new_author" value="step2">
<div class="paddingTop16 paddingBottom4">
��� �����: <b><?=$_REQUEST['email']?></b>
</div>
<div class="paddingTop16 paddingBottom4">
	<a name="myname"></a><span class="txtRed txt100">*</span>��� nickname, ��� ��� ������ ���������:
</div>
<input name="family" type="text" id="family" style="width:100%" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dlogin?>">
<?  //���� � �� �����, � �� �����������:
	//(����� �������� ������ ������� ������)
    if (!$us_n&&!$dus_n)
	  {?>

<div class="paddingTop16 paddingBottom4">
	<a name="mypasses"></a><span class="txtRed txt100">*</span>��� ������:
</div>
            <input name="pass" type="password" id="pass" onBlur="if (this.value) this.style.backgroundColor=''" class="widthFull">

<div class="paddingTop16 paddingBottom4">
	<a name="mypasses"></a><span class="txtRed txt100">*</span>����������� ������:
</div>
              <input name="pass2" type="password" id="pass2" onBlur="document.getElementById('pass').style.backgroundColor=''; if (this.value) this.style.backgroundColor=''" class="widthFull">

<?	  }?>
<div class="paddingTop16 paddingBottom4">
	<a name="mycity"></a><span class="txtRed txt100">*</span>����� ����������: 
</div>	
        <input name="city" type="text" id="city" onBlur="if (this.value) this.style.backgroundColor=''" class="widthFull" value="<?=$dcity?>">

      <div class="paddingTop16 paddingBottom4">
      <a name="myready_volume"></a>
      <span class="txtRed txt100">*</span>����� ��������� ���������� ������� ����� �� ������?
        <input name="howmach" type="text" id="howmach" onBlur="if (this.value) this.style.backgroundColor=''" size="3" value="<?=$howmach?>">
	  </div>
      
      <div class="paddingTop16 paddingBottom4">
      <a name="ownpage"></a>
      <span class="txtRed txt100">*</span>������ �� �� ����������� �������� (web-����) ������/������� ��������, �������� ����� � ���������?</div>
      <div class="topPad6" style="background-color:#e4e4e4; height:24px; padding:4px" id="homePage">
        <input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor='';"> ��<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='none';document.getElementById('mySiteTime').style.display='none'; parentNode.nextSibling.style.backgroundColor=''; hPage=1; parentNode.style.backgroundColor='';"> ��� 
<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('mySiteTime').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor='';"> ���� ���, �� �������� � ��������� �����</div>
<div id="HPcontent" class="paddingBottom4">
  <div class="padding4" id="myURL" style="display:<?="none"?>;">
    <span class=red>������� URL ����� ��������:</span> 
    <input name="site" type="text" id="site" size=30 onBlur="if (this.value) this.style.backgroundColor='';" value="<?=$myurl?>"></div>
  <div  class="padding4" id="mySiteTime" style="display:<?="none"?>;">
    <span class=red>� ������� ������ ����� �� ���������� ������� ����������� ��������:</span> 
    <input name="time" type="text" id="time" onBlur="if (this.value) this.style.backgroundColor='';"></div>
</div>
<div class="paddingTop16 paddingBottom4">
  ���� ���������� ��������:</div>
      <table  cellspacing="0" cellpadding="0">
        <tr class="txt110">
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/phone.gif" width="16" height="13" hspace="2" align="absmiddle">��������:<br>
              <input name="phone" type="text" id="phone" size="18" value="<?=$dphone?>">
          </td>
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/phone2.gif" width="16" height="15" hspace="2" align="absmiddle">�������:<br>
              <input name="workphone" type="text" id="workphone" size="18" value="<?=$workphone?>">
          </td>
          <td><span class="txtRed txt100">*</span><img src="<?=$_SESSION['SITE_ROOT']?>images/mobila.gif" width="16" height="16" hspace="2" align="absmiddle">���������:<br>
              <input name="mobila" type="text" id="mobila" size="18" value="<?=$dmobila?>">
          </td>
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/mobila_add.png" width="18" height="18" hspace="2" align="absmiddle">��������������:<br>
              <input name="dopphone" type="text" id="dopphone" size="20" value="<?=$dopphone?>">
          </td>
        </tr>
      </table>      
      <div class="paddingTop16">��� <img src="<?=$_SESSION['SITE_ROOT']?>images/icq.gif" width="16" height="15" hspace="2" align="absmiddle"># ICQ: 
        <input name="ICQ" type="text" id="ICQ" size="10" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dicq?>">
	  </div>
      <hr size="1" noshade>
      <h4>������� ���� ��������� ��������� (����������):
      </h4>
<img src="<?=$_SESSION['SITE_ROOT']?>images/logo_wm.gif" width="113" height="36" vspace="10">
	  <table cellspacing="0" cellpadding="0">
        <tr valign="bottom" class="txt120">
          <td width="120" >
                WM<strong style="color:#CC0000">R</strong><br />
                <input name="WMR" type="text" id="WMR" value="<?=$dWMR?>" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
            </td>
          <td width="120">
                WM<strong style="color:#009900">Z</strong><br />
                <input name="WMZ" type="text" id="WMZ" value="<?=$dWMZ?>" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </td>
          <td width="120">
              WM<strong style="color:#000099">E</strong><br />
                <input name="WME" type="text" id="WME" value="<?=$dWME?>" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </td>
          <td width="120">
              WM<strong style="color:#FF9900 ">U</strong><br />
              <input name="WMU" type="text" id="WMU" value="<?=$dWMU?>" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </td>
        </tr>
      </table>
	  <br>
	  <table cellspacing="0" cellpadding="0">
	    <tr>
          <td nowrap><img src="<?=$_SESSION['SITE_ROOT']?>images/ya.gif" width="44" height="27" vspace="10" align="absmiddle"><img src="<?=$_SESSION['SITE_ROOT']?>images/logo-yandex.gif" width="64" height="28" hspace="0" vspace="10" align="absmiddle"></td>
          <td nowrap><span style="font-size:22px;font-family:'Arial Narrow', Arial"><strong>.������</strong></span>&nbsp;</td>
          <td>
          <input name="YmoneY" type="text" id="YmoneY" size="13" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dYmoneY?>">          </td>
        </tr>
    </table>
<?  //���� ��� ����� ��� �����������:
    if ($us_n||$dus_n)
	  { ?>
<hr noshade />
<div class="paddingBottom4 paddingTop16">
	<a name="my_current_pass"></a>������� ���� ������� ������<? 
		if ($dus_n) {?> �����������. �� ����� ����������� ����� ��� ������� � ��� ������� ������. � ���������� �� ������� �������� ���<? }?>.
</div>
<input name="pass_current" type="password" id="pass_current" class="widthFull">        
<div class="paddingTop4 paddingBottom4">���� �� ������ ������, �� ������ ��� �� ��������� ���� �����. ��� ����� �������� <a href="javascript:sendPass('<?=$email?>','author');">�����</a>. <?
		
		//����������� iFrame ��� ������� �������� ������ �� ��������� �����:
		$regUser->remPassIframe(); ?></div>
        
  <?  }
	//���� �� �����:
    if (!$us_n)
	  { ?>  
      <a name="agree_point"></a>    
      <div><input name="agree" type="checkbox" class="padding0" id="agree" style="padding:4px 6px 4px -6px;margin:4px 6px 4px 0px" onClick="if (this.checked==true) document.getElementById('tblAgree').style.backgroundColor=''" value="checkbox">� �������� ������� <a href="sections/author_agreement.php" target="_blank">����������������� ����������</a> �������� �������� Referats.info.
      </div><?
	  }?>
<div class="paddingTop10"><input name="Submit" type="submit" value="     OK     "></div>
<?
}?></td>
    <td width="50%" valign="top" class="paddingLeft20">
    <p class="headerAuthorReg">��� ������������ �������, ���:</p>
      <ul type="square">
        <li>����� ������ � ����������� ���������� � ����������, �����,
        ��������� ����� ����� � ������� �� ������ </li>
        <li><span class="header10bottom"></span>����������������
          �������� ����� � ����������</li>
        <li>���������� ����������� �� ���������� ����������� �����</li>
        <li>���������� ������������� �������, ����������� ������������
          ��������� ����� �����</li>
        <li><span class="header10bottom"></span>������������������
          ������� ����������</li>
        <li><span class="header10bottom"></span> ������ ��������
          ����������� ��������</li>
        <li><span class="header10bottom"></span>������� � �������
          �������� ����� � �������������� �������� ��������</li>
        <li><span class="header10bottom"></span>��������� ����������
          �������</li>
      </ul></td>
  </tr>
</table>
</form>
</div>
<img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="100%" height="53"><?
}?>