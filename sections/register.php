<?
if ($current_level!="index") {

	if (!$Author) { //не в index.php
		require_once("../connect_db.php");
		require_once("../classes/class.Messages.php");
		require_once("../classes/class.Author.php");
		require_once("../classes/class.Errors.php");
		$Messages=new Messages;
		$Author=new Author;
		$catchErrors=new catchErrors;
	}
}
//если попросили напомнить пароль:
if (isset($_GET['email_to_send_password'])) {
	
	$Author->rememberPassword($_REQUEST['email_to_send_password'],$_REQUEST['actor_type']);

}else{ //не просили напоминать пароль
	
	//получить данные автора-исполнителя:
	$arrMkData=$Author->checkAuthorAsMaker($_REQUEST['email']);
	
	//проверим, действительно ли автор - реальный исполнитель:
	if ( isset($_REQUEST['pass_current']) && //получен пароль для проверки
		 $_REQUEST['pass_current']!=$arrMkData['pass'] //не совпадает с реальным паролем
	   ) {
		//отошлём пароль:
		$Author->rememberPassword($_REQUEST['email'],"author","diplom_maker");
		//выведем сообщение:
		$Messages->alertReload("Указанный вами пароль не совпадает с хранящимся в нашей БД. Правильный пароль отослан на ваш емэйл.","author/");	
	}
	//однозначно регистрируем нового автора:
	if ($_REQUEST['new_author']=="step2"){
		//если совершенно новый автор (не исполнитель):
		$passw=$_REQUEST['pass']; 
		//если исполнитель:
		if (!isset($_REQUEST['pass'])) $passw=$_REQUEST['pass_current'];
		$regUser->regAuthor();
		$Messages->alertReload("Регистрация подтверждена!\\nВаши данные отосланы на указанный вами емэйл.","author/?email=$_REQUEST[email]&amp;pass=$pass&amp;action=just_registered&amp;allow_account=allow");
	
	}?>

<div class="borderBottom4 borderColorGray bgWhite">
 <form class="padding0" onSubmit="return checkCells();">
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function diplom_hint ()	{
var job="<a href=http://www.diplom.com.ru/job.htm target=_blank>здесь</a>";
var collapse="";
if (document.getElementById('diplom_maker').innerHTML=='') 
	{
	document.getElementById('diplom_maker').innerHTML='<br>&nbsp;Регистрация в проекте Diplom.com.ru даст вам возможность выполнять на заказ уникальные творческие работы для его заказчиков. Подробности смотрите '+job+'.&nbsp;<br><br>';
	document.getElementById('clps').innerHTML="Свернуть подсказку</span><br>";
	}
	else {
	document.all['diplom_maker'].innerHTML='';
	}
}*/


//Определяет минимальную заполненность ячеек с данными о халявных сайтах для получения авторами ПБО
//check_free_sources=0;

function checkCells	()	{
	
	var myFm = document.forms[0]; 

if (myFm.email&&myFm.email.type=="text") {
	//alert(myFm.email);
	return emailCheckReferats(myFm.email);
}
if (myFm.family&&!myFm.family.value) {
	alert ('Вы не указали, как к вам обращаться!');
	myFm.family.style.backgroundColor='yellow';
	myFm.family.focus();
	return false;
}

if (myFm.city&&!myFm.city.value) {
	alert ('Вы не указали место проживания!');
	myFm.city.style.backgroundColor='yellow';
	myFm.city.focus();
	return false;
}

if (myFm.howmach) {
	
	if (!myFm.howmach.value||myFm.howmach.value==' ') {
		alert ('Вы не указали, сколько у вас готовых работ!');
		myFm.howmach.style.backgroundColor='yellow';
		myFm.howmach.focus();
		return false;
	}else if (myFm.howmach&&isNaN(myFm.howmach.value)) {
		alert ('Поле для количества готовых работ не должно содержать ничего, кроме цифр!');
		myFm.howmach.style.backgroundColor='yellow';
		myFm.howmach.focus();
		return false;
	}
}

if (myFm.site) {
	
	//Проверяет, есть ли у автора home page
	var radios=document.getElementById('homePage').getElementsByTagName('input');
	var hPage=false;
	
	for (i=0;i<radios.length;i++) {
		
		if(radios.item(i).type=="radio"&&radios.item(i).checked==true) { 
			
			hPage=true;
			break;
		}
	}
	
	if (!hPage) {
		
		alert ('Вы не сообщили, есть ли у вас собственная страница дипломов, курсовых работ и рефератов!');
		document.getElementById('homePage').style.backgroundColor='yellow';
		location.href='#ownpage';
		return false;
	
	}else{
		
		var tValue=myFm.site.value;
		if (document.getElementById('myURL').style.display=='block') {

			if (!tValue) 	{//Проверяем на на наличие запись URL
				alert ('Вы не сообщилили URL своей страницы дипломных, курсовых работ и префератов!'); 
				document.getElementById('site').style.backgroundColor='yellow'; 
				myFm.site.focus(); return false;
			}
			//Далее проверяем валидность записи URL. Не валиден, если:
			//1. Менее 4-х символов
			//2. Или  нет точки
			//3. Или после точки менее 2-х символов
			//4. Или после точки более 4-х символов
			
			else if ( tValue.length<4||
					  tValue.lastIndexOf(".")==-1||
					  tValue.substring(tValue.lastIndexOf("."),tValue.length).length<3||
					  tValue.substring(tValue.lastIndexOf("."),tValue.length).length>5
					) {
				alert ('URL вашей страницы указан некорректно!'); 
				document.getElementById('site').style.backgroundColor='yellow';  
				myFm.site.focus(); 
				return false;
			}
		  }
		if (document.getElementById('mySiteTime').style.display=='block'&&!myFm.time.value) {
			alert ('Вы не сообщили, когда планируете открыть собственную страницу дипломных, курсовых работ и префератов!'); 
			document.getElementById('time').style.backgroundColor='yellow'; 
			myFm.time.focus(); 
			return false
		}
	}
}
//мобила:
if (myFm.mobila&&!myFm.mobila.value) {
		alert ('Вы не указали № своего мобильного телефона!'); 
		myFm.mobila.style.backgroundColor='yellow'; 
		myFm.mobila.focus(); 
		return false	
}

if (myFm.ICQ) {

	if (myFm.ICQ.value&&isNaN(myFm.ICQ.value)) {
		alert ('Ячейка для номера ICQ не должна содержать ничего, кроме цифр!');
		myFm.ICQ.style.backgroundColor='yellow';
		myFm.ICQ.focus();
		return false;
	}
}

if (myFm.WMR) {

	if (myFm.WMR.value&&isNaN(myFm.WMR.value)) {
		alert ('Ячейка для рублёвого счёта WebMoney не должна содержать ничего, кроме цифр!');
		myFm.WMR.style.backgroundColor='yellow';
		myFm.WMR.focus();
		return false;
	}
}

if (myFm.WMZ) {

	if (myFm.WMZ.value&&isNaN(myFm.WMZ.value)) {
		alert ('Ячейка для счёта WebMoney в долларах не должна содержать ничего, кроме цифр!');
		myFm.WMZ.style.backgroundColor='yellow';
		myFm.WMZ.focus();
		return false;
	}
}

if (myFm.WME) {

	if (myFm.WME.value&&isNaN(myFm.WME.value)) {
		alert ('Ячейка для счёта WebMoney в Евро не должна содержать ничего, кроме цифр!');
		myFm.WME.style.backgroundColor='yellow';
		myFm.WME.focus();
		return false;
	}
}


if (myFm.WMU) {

	if (myFm.WMU.value&&isNaN(myFm.WMU.value)) {
		alert ('Ячейка для счёта WebMoney в гривнах не должна содержать ничего, кроме цифр!');
		myFm.WMU.style.backgroundColor='yellow';
		myFm.WMU.focus();
		return false;
	}
}


if (myFm.YmoneY) {

	if (myFm.YmoneY.value&&isNaN(myFm.YmoneY.value)) {
		alert ('Ячейка для счёта Яндекс.деньги не должна содержать ничего, кроме цифр!');
		myFm.YmoneY.style.backgroundColor='yellow';
		myFm.YmoneY.focus();
		return false;
	}
}

if (myFm.pass_current&&!myFm.pass_current.value) {

		alert ('Вы не указали свой пароль исполнителя!');
		myFm.pass_current.style.backgroundColor='yellow';
		myFm.pass_current.focus();
		return false;
}
if (myFm.pass&&myFm.pass2) {

	if (myFm.pass&&!myFm.pass.value) {
		alert ('Вы не ввели пароль!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass.focus();
		return false;
	}
	
	if (myFm.pass.value&&myFm.pass.value.length<4) {
		alert ('Длина пароля не должна быть менее 4-х символов!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass.focus();
		return false;
	}
	
	if (myFm.pass2&&!myFm.pass2.value) {
		alert ('Вы не подтвердили пароль!');
		myFm.pass2.style.backgroundColor='yellow';
		myFm.pass2.focus();
		return false;
	}

	if (
		 (myFm.pass.value&&myFm.pass2.value)&&
		 (myFm.pass.value!=myFm.pass2.value)
	   ) {
		alert ('Пароли не совпадают!');
		myFm.pass.style.backgroundColor='yellow';
		myFm.pass2.style.backgroundColor='lime';
		location.href='#mypasses';
		return false;
	}else{
		myFm.pass.style.backgroundColor='';
		myFm.pass2.style.backgroundColor='';
	}
}


//Проверяем, записал ли что-нибудь автор в ячейки для халявы и правильно ли это сделал:
var preObj=document.registration;
//форма отправки данных

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
		alert ('Вы ничего не ввели в ячейки для адресов сайтов!'); 
		document.getElementById('user_answer').style.backgroundColor='yellow'; 
		location.href="#free_period"; 
		return false;
	}else{
		var check_dot=0;
		//Проверяет валидность записи адресов сайтов

		for (j=0;j<16;j++)		
		  { 
			var cellObjAuthor=preObj.elements['authors_free'+eval(j+1)].value;
			//Значение ячейки для записи адресов сайтов для бесплатных авторских объявлений
			var cellObjCustomer=preObj.elements['customer_free'+eval(j+1)].value;
			//Значение ячейки для записи адресов сайтов для бесплатных объявлений заказчиков		
			var cellObjWorx=preObj.elements['worx_free'+eval(j+1)].value;
			//Значение ячейки для записи адресов сайтов для бесплатной скачки работ
			var ALength=cellObjAuthor.length;
			//Длина строки в ячейке авторов
			var CLength=cellObjCustomer.length;
			//Длина строки в ячейке заказчиков 
			var WLength=cellObjWorx.length;
			//Длина строки в ячейке бесплатных работ
			var Adot=cellObjAuthor.lastIndexOf('.');
			//Идентификатор наличия точки в записи адреса сайта для авторов
			var Cdot=cellObjCustomer.lastIndexOf('.');
			//Идентификатор наличия точки в записи адреса сайта для заказчиков
			var Wdot=cellObjWorx.lastIndexOf('.');
			//Идентификатор наличия точки в записи адреса сайта для бесплатных работ
			var aFullLength=cellObjAuthor.substring(Adot,ALength).length;
			//Длина имени сайта для авторов, начиная от точки и до конца
			var cFullLength=cellObjCustomer.substring(Cdot,CLength).length;
			//Длина имени сайта для заказчиков, начиная от точки и до конца
			var wFullLength=cellObjWorx.substring(Wdot,WLength).length;
			//Длина имени сайта для бесплатных работ, начиная от точки и до конца
						
		//	 Адрес нее валиден, если:
		//1. Менее 4-х символов
		//2. Или  нет точки
		//3. Или после точки менее 2-х символов
		//4. Или после точки более 4-х символов
		
		if ( (cellObjAuthor&&(ALength<4||Adot==-1||aFullLength<3||aFullLength>5)) || (cellObjCustomer&&(CLength<4||Cdot==-1||cFullLength<3||cFullLength>5)) || (cellObjWorx&&(WLength<4||Wdot==-1||wFullLength<3||wFullLength>5)) ) check_dot++;
	 	}
		if (check_dot>0){
			alert ('Проверьте правильность записи указанных вами адресов сайтов!'); 
			document.getElementById('user_answer').style.backgroundColor='yellow';
			location.href='#free_period';
			return false;
		}
  	}
  }

	//если чекбокс есть (когда не зарегистрирован, как автор), и он - не отмечен:
	if (myFm.agree&&myFm.agree.checked==false) {
		alert ('Вы не согласились с условиями нашего пользовательского соглашения!');
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
     <td><h3>Регистрация автора (собственника творческих работ).</h3>
 <p class="headerAuthorReg">Шаг <?
if (isset($_REQUEST['email'])){
	?>2<? 
	$stage=2; 
	$email=$_REQUEST['email']; 
}else{
	?>1<? 
	$stage=1; 
} ?> из 2.</p></td>
   </tr>
 </table>
 <table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td width="50%" valign="top"><?
//если на первом шаге регистрации - проверке емэйла:
if ($stage==1) { if ($test_stage1){?><h1>Шаг 1</h1>(тестовое отображение)<hr><? }?>
      <p>Регистрация в нашем проекте состоит из 2-х простых шагов
          и займёт у вас минимум времени. После
          этого вы получите доступ ко всем функциям нашей системы. </p>
      <p><strong>Пожалуйста, укажите свой <nobr>e-mail:</nobr></strong> </p>
      <div class="paddingBottom6 txtGreen txt90"><img src="images/lamp2.png" width="20" height="20" align="left" /> Если вы уже сотрудничаете с нашими проектом <script type="text/javascript">
dwrite('Educationservice');
</script>.ru (<noindex><a href="#" onClick="location.href='http://www.diplom.com.ru/esys4/';return false;"><script type="text/javascript">
dwrite('diplom.com.ru');
</script></a></noindex>), укажите свой контактный емэйл исполнителя уникальных творческих работ.</div>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%"><input name="email" type="text" id="email" class="widthFull"></td>
          <td><input type="submit" name="Submit" value="Продолжить &rsaquo;&rsaquo;" ></td>
        </tr>
      </table>
        <?
}
//если уже проверили емэйл:
elseif ($stage==2) {
	//проверим аутентификационные данные автора по его емэйлу:
	$us_n=count($Author->getAuthorDataAuth($email,""));
	//если нет среди авторов - проверить, а не исполнитель ли он???
	if (!$us_n){ ?><input name="new_author" type="hidden" value="<?=$email?>"><?
		
		$arrMkData=$Author->checkAuthorAsMaker($email);
		$dus_n=count($arrMkData);
		
		if($dus_n) { //Внести уже известные данные
			
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
      
	  }else{ //ri_user data://если зарегистрирован как автор
		$pageReload="author/?email=$email&amp;do=check_current_author_password";
		$alertMess="Вы уже зарегистрированы как автор-собственник готовых творческих работ.\\nВы будете перенаправлены на страницу авторизации.";
		$Messages->alertReload($alertMess,$pageReload);
	  }


	//если какие-либо данные уже заняты:
	//В НАСТОЯЩЕЕ ВРЕМЯ ИСКЛЮЧЕНО, Т.К. СОВПАСТЬ МОЖЕТ ТОЛЬКО ЕМЭЙЛ, КОТОРЫЙ ПРОВЕРЯЕТСЯ НА ПРЕДЫДУЩЕЙ СТАДИИ
	if (isset($mess)){?><div class="txtRed"><? if ($test_mess){?>СООБЩЕНИЕ О НЕВОЗМОЖНОСТИ ИСПОЛЬЗОВАТЬ ВВЕДЁННЫЕ ДАННЫЕ....<? }?><?=$mess?></div><? 
	}else{?>
<strong class="arialEncrised">Заполните анкету и ваш персональный аккаунт будет создан!</strong> <br>Поля, отмеченные символом <span class="txtRed txt100">*</span> являются обязательными к заполнению!<hr noshade /><?	
	}
	
	//если нашли среди исполнителей или авторов:
	if ($us_n||$dus_n) { 
		
		//сообщим о том, что он является исполнителем и подставим его данные:?>
        <p><strong><img src="<?=$_SESSION['SITE_ROOT']?>images/i_triangle.png" width="15" height="15" hspace="4" vspace="8" align="absmiddle">ВНИМАНИЕ!</strong>
          <br>
          <?
		  if ($dus_n){?>Указанный вами емэйл принадлежит одному из наших исполнителей уникальных творческих работ, сотрудничающему с нашими проектами <script type="text/javascript">
dwrite('EducationService.ru и Diplom.com.ru');
</script>. Если это &#8212; вы, п<? }
		  else {?>Вы уже зарегистрированы у нас в качестве автора. П<? }?>ожалуйста, проверьте свои данные (см. ниже) и либо подтвердите, либо отредактируйте их. Это потребует указания вашего пароля. Если вы забыли его, щёлкните <a href="javascript:sendPass('<?=$email?>','author');">здесь</a>, и мы вышлем его на указанный вами адрес.
<?  }
	//
	if ($test_stage1){?>
        <h1>Шаг 2</h1>(тестовое отображение)<hr><? }?>

<input name="email" type="hidden" id="email" value="<?php echo($email);?>">
<input name="new_author" type="hidden" id="new_author" value="step2">
<div class="paddingTop16 paddingBottom4">
Ваш емэйл: <b><?=$_REQUEST['email']?></b>
</div>
<div class="paddingTop16 paddingBottom4">
	<a name="myname"></a><span class="txtRed txt100">*</span>Ваш nickname, ФИО или другое обращение:
</div>
<input name="family" type="text" id="family" style="width:100%" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dlogin?>">
<?  //если и не автор, и не исполнитель:
	//(иначе попросим ввести текущий пароль)
    if (!$us_n&&!$dus_n)
	  {?>

<div class="paddingTop16 paddingBottom4">
	<a name="mypasses"></a><span class="txtRed txt100">*</span>Ваш пароль:
</div>
            <input name="pass" type="password" id="pass" onBlur="if (this.value) this.style.backgroundColor=''" class="widthFull">

<div class="paddingTop16 paddingBottom4">
	<a name="mypasses"></a><span class="txtRed txt100">*</span>Подтвердите пароль:
</div>
              <input name="pass2" type="password" id="pass2" onBlur="document.getElementById('pass').style.backgroundColor=''; if (this.value) this.style.backgroundColor=''" class="widthFull">

<?	  }?>
<div class="paddingTop16 paddingBottom4">
	<a name="mycity"></a><span class="txtRed txt100">*</span>Город проживания: 
</div>	
        <input name="city" type="text" id="city" onBlur="if (this.value) this.style.backgroundColor=''" class="widthFull" value="<?=$dcity?>">

      <div class="paddingTop16 paddingBottom4">
      <a name="myready_volume"></a>
      <span class="txtRed txt100">*</span>Какое примерное количество готовых работ вы имеете?
        <input name="howmach" type="text" id="howmach" onBlur="if (this.value) this.style.backgroundColor=''" size="3" value="<?=$howmach?>">
	  </div>
      
      <div class="paddingTop16 paddingBottom4">
      <a name="ownpage"></a>
      <span class="txtRed txt100">*</span>Имеете ли вы собственную страницу (web-сайт) заказа/продажи дипломов, курсовых работ и рефератов?</div>
      <div class="topPad6" style="background-color:#e4e4e4; height:24px; padding:4px" id="homePage">
        <input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor='';"> Да<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='none';document.getElementById('mySiteTime').style.display='none'; parentNode.nextSibling.style.backgroundColor=''; hPage=1; parentNode.style.backgroundColor='';"> Нет 
<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('mySiteTime').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor='';"> Пока нет, но планирую в ближайшее время</div>
<div id="HPcontent" class="paddingBottom4">
  <div class="padding4" id="myURL" style="display:<?="none"?>;">
    <span class=red>Укажите URL своей страницы:</span> 
    <input name="site" type="text" id="site" size=30 onBlur="if (this.value) this.style.backgroundColor='';" value="<?=$myurl?>"></div>
  <div  class="padding4" id="mySiteTime" style="display:<?="none"?>;">
    <span class=red>В течение какого срока вы планируете открыть собственную страницу:</span> 
    <input name="time" type="text" id="time" onBlur="if (this.value) this.style.backgroundColor='';"></div>
</div>
<div class="paddingTop16 paddingBottom4">
  Ваши контактные телефоны:</div>
      <table  cellspacing="0" cellpadding="0">
        <tr class="txt110">
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/phone.gif" width="16" height="13" hspace="2" align="absmiddle">Домашний:<br>
              <input name="phone" type="text" id="phone" size="18" value="<?=$dphone?>">
          </td>
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/phone2.gif" width="16" height="15" hspace="2" align="absmiddle">Рабочий:<br>
              <input name="workphone" type="text" id="workphone" size="18" value="<?=$workphone?>">
          </td>
          <td><span class="txtRed txt100">*</span><img src="<?=$_SESSION['SITE_ROOT']?>images/mobila.gif" width="16" height="16" hspace="2" align="absmiddle">Мобильный:<br>
              <input name="mobila" type="text" id="mobila" size="18" value="<?=$dmobila?>">
          </td>
          <td><img src="<?=$_SESSION['SITE_ROOT']?>images/mobila_add.png" width="18" height="18" hspace="2" align="absmiddle">Дополнительный:<br>
              <input name="dopphone" type="text" id="dopphone" size="20" value="<?=$dopphone?>">
          </td>
        </tr>
      </table>      
      <div class="paddingTop16">Ваш <img src="<?=$_SESSION['SITE_ROOT']?>images/icq.gif" width="16" height="15" hspace="2" align="absmiddle"># ICQ: 
        <input name="ICQ" type="text" id="ICQ" size="10" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dicq?>">
	  </div>
      <hr size="1" noshade>
      <h4>Укажите свои платежные реквизиты (желательно):
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
          <td nowrap><span style="font-size:22px;font-family:'Arial Narrow', Arial"><strong>.деньги</strong></span>&nbsp;</td>
          <td>
          <input name="YmoneY" type="text" id="YmoneY" size="13" onBlur="if (this.value) this.style.backgroundColor=''" value="<?=$dYmoneY?>">          </td>
        </tr>
    </table>
<?  //если уже автор или исполнитель:
    if ($us_n||$dus_n)
	  { ?>
<hr noshade />
<div class="paddingBottom4 paddingTop16">
	<a name="my_current_pass"></a>Укажите свой текущий пароль<? 
		if ($dus_n) {?> исполнителя. Он будет использован также для доступа в ваш аккаунт автора. В дальнейшем вы сможете изменить его<? }?>.
</div>
<input name="pass_current" type="password" id="pass_current" class="widthFull">        
<div class="paddingTop4 paddingBottom4">Если вы забыли пароль, мы вышлем его на указанный вами емэйл. Для этого щёлкните <a href="javascript:sendPass('<?=$email?>','author');">здесь</a>. <?
		
		//сгенерируем iFrame для скрытой отправки пароля на указанный емэйл:
		$regUser->remPassIframe(); ?></div>
        
  <?  }
	//если не автор:
    if (!$us_n)
	  { ?>  
      <a name="agree_point"></a>    
      <div><input name="agree" type="checkbox" class="padding0" id="agree" style="padding:4px 6px 4px -6px;margin:4px 6px 4px 0px" onClick="if (this.checked==true) document.getElementById('tblAgree').style.backgroundColor=''" value="checkbox">Я принимаю условия <a href="sections/author_agreement.php" target="_blank">пользовательского соглашения</a> торговой площадки Referats.info.
      </div><?
	  }?>
<div class="paddingTop10"><input name="Submit" type="submit" value="     OK     "></div>
<?
}?></td>
    <td width="50%" valign="top" class="paddingLeft20">
    <p class="headerAuthorReg">Ваш персональный аккаунт, это:</p>
      <ul type="square">
        <li>Самая полная и достоверная информация о количестве, типах,
        стоимости своих работ и истории их продаж </li>
        <li><span class="header10bottom"></span>Непосредственная
          обратная связь с заказчиком</li>
        <li>Отсутствие ограничений на количество продаваемых работ</li>
        <li>Мониторинг конкурирующих заказов, возможность регулировать
          стоимость своих работ</li>
        <li><span class="header10bottom"></span>Автоматизированная
          система оповещений</li>
        <li><span class="header10bottom"></span> Полный контроль
          прохождения платежей</li>
        <li><span class="header10bottom"></span>Надёжная и быстрая
          обратная связь с администрацией торговой площадки</li>
        <li><span class="header10bottom"></span>Подробная справочная
          система</li>
      </ul></td>
  </tr>
</table>
</form>
</div>
<img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="100%" height="53"><?
}?>