<?php
session_start();
require('../connect_db.php');
require('lib.php');

$us_r=mysql_query("SELECT * FROM ri_user WHERE login='$login'");
$us_n=mysql_num_rows($us_r);
if($us_n>0)
{
  header("location: anketa.php?mess=Ошибка! Пользователь под именем'$login' уже зарегистрирован. Выберите себе дргое!");
}
//проверить, а не автор ли он???
$dus_r=mysql_query("SELECT * FROM diplom_maker WHERE email='$login'");
//echo("SELECT * FROM diplom_maker WHERE email='$login'<br>");
$dus_n=mysql_num_rows($dus_r);
if($dus_n>0)
{
  //Внести уже известные данные
  $dlogin=$login;
  $dfamily=mysql_result($dus_r,0,'login');
  $dpass=mysql_result($dus_r,0,'pass');
  $dphone=mysql_result($dus_r,0,'phone');
  $dmobila=mysql_result($dus_r,0,'mobila');
  $dicq=mysql_result($dus_r,0,'icq');
  $dcity=mysql_result($dus_r,0,'town');
  $dWMR=mysql_result($dus_r,0,'WMR');
  $dWMZ=mysql_result($dus_r,0,'WMZ');
  $dWME=mysql_result($dus_r,0,'WME');
  $dYmoneY=mysql_result($dus_r,0,'YmoneY');
  $dBankAcc=mysql_result($dus_r,0,'BankAcc');
  header("location: reg_user.php?login=$dlogin&pass=$dpass&family=$dfamily&phone=$dphone&mobila=$dmobila&city=$dcity&ICQ=$dicq&WMR=$dWMR&WMZ=$dWMZ&WME=$dWME&YmoneY=$dYmoneY&BankAcc=$dBankAcc");
}
?>
<html>
<head>
<TITLE>Регистрация автора и создание персонального эккаунта, шаг 2.</TITLE>
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
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
}

checkfree=0;
//Определяет, хотят ли авторы получить ПБО
check_free_sources=0;
//Определяет минимальную заполненность ячеек с данными о халяве для получения авторами ПБО
hPage=0;
//Проверяет, есть ли у автора home page

function checkCells	()	{
var myFm = document.registration;

if (!myFm.family.value) {
alert ('Вы не указали, как к вам обращаться!');
myFm.family.style.backgroundColor='yellow';
myFm.family.focus();
return false;
}

if (!myFm.pass.value) {
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

if (!myFm.pass2.value) {
alert ('Вы не подтвердили пароль!');
myFm.pass2.style.backgroundColor='yellow';
myFm.pass2.focus();
return false;
}

if ((myFm.pass.value&&myFm.pass2.value)&&(myFm.pass.value!=myFm.pass2.value)) {
alert ('Пароли не совпадают!');
myFm.pass.style.backgroundColor='yellow';
myFm.pass2.style.backgroundColor='lime';
location.href='#mypasses';
return false;
}

else 
{
myFm.pass.style.backgroundColor='';
myFm.pass2.style.backgroundColor='';
}

if (!myFm.city.value) {
alert ('Вы не указали место проживания!');
myFm.city.style.backgroundColor='yellow';
myFm.city.focus();
return false;
}

if (!myFm.howmach.value||myFm.howmach.value==' ') {
alert ('Вы не указали, сколько у вас готовых работ!');
myFm.howmach.style.backgroundColor='yellow';
myFm.howmach.focus();
return false;
}

else if (isNaN(myFm.howmach.value)) {
alert ('Поле для количества готовых работ не должно содержать ничего, кроме цифр!');
myFm.howmach.style.backgroundColor='yellow';
myFm.howmach.focus();
return false;
}

if (hPage==0) {
alert ('Вы не сообщили, есть ли у вас собственная страница дипломов, курсовых работ и рефератов!');
document.getElementById('homePage').style.backgroundColor='yellow';
location.href='#ownpage';
return false;
}

else {
var tValue=myFm.site.value;
	if (document.getElementById('myURL').style.display=='block')	
	{
		if (!tValue) 	{//Проверяем на на наличие запись URL
		alert ('Вы не сообщилили URL своей страницы дипломных, курсовых работ и префератов!'); document.getElementById('site').style.backgroundColor='yellow'; myFm.site.focus(); return false;
		}
		//Далее проверяем валидность записи URL. Не валиден, если:
		//1. Менее 4-х символов
		//2. Или  нет точки
		//3. Или после точки менее 2-х символов
		//4. Или после точки более 4-х символов
		
		else if (tValue.length<4||tValue.lastIndexOf(".")==-1||tValue.substring(tValue.lastIndexOf("."),tValue.length).length<3||tValue.substring(tValue.lastIndexOf("."),tValue.length).length>5)	{
		alert ('URL вашей страницы указан некорректно!'); document.getElementById('site').style.backgroundColor='yellow';  myFm.site.focus(); return false;
		}
	}
	if (document.getElementById('mySiteTime').style.display=='block'&&!myFm.time.value) {alert ('Вы не сообщили, когда планируете открыть собственную страницу дипломных, курсовых работ и префератов!'); document.getElementById('time').style.backgroundColor='yellow'; myFm.time.focus(); return false}
	}

if (myFm.ICQ.value&&isNaN(myFm.ICQ.value)) {
alert ('Ячейка для номера ICQ не должна содержать ничего, кроме цифр!');
myFm.ICQ.style.backgroundColor='yellow';
myFm.ICQ.focus();
return false;
}

if (myFm.WMR.value&&isNaN(myFm.WMR.value)) {
alert ('Ячейка для рублёвого счёта WebMoney не должна содержать ничего, кроме цифр!');
myFm.WMR.style.backgroundColor='yellow';
myFm.WMR.focus();
return false;
}

if (myFm.WMZ.value&&isNaN(myFm.WMZ.value)) {
alert ('Ячейка для счёта WebMoney в долларах не должна содержать ничего, кроме цифр!');
myFm.WMZ.style.backgroundColor='yellow';
myFm.WMZ.focus();
return false;
}

if (myFm.WME.value&&isNaN(myFm.WME.value)) {
alert ('Ячейка для счёта WebMoney в Евро не должна содержать ничего, кроме цифр!');
myFm.WME.style.backgroundColor='yellow';
myFm.WME.focus();
return false;
}

if (myFm.WMU.value&&isNaN(myFm.WMU.value)) {
alert ('Ячейка для счёта WebMoney в гривнах не должна содержать ничего, кроме цифр!');
myFm.WMU.style.backgroundColor='yellow';
myFm.WMU.focus();
return false;
}

if (myFm.YmoneY.value&&isNaN(myFm.YmoneY.value)) {
alert ('Ячейка для счёта Яндекс.деньги не должна содержать ничего, кроме цифр!');
myFm.YmoneY.style.backgroundColor='yellow';
myFm.YmoneY.focus();
return false;
}

if (checkfree==0) {
alert ('Вы не указали, хотите ли вы получить право на период бесплатного обслуживания!');
location.href='#free_p';
document.getElementById('periods').style.backgroundColor='yellow';
return false;
}

//Проверяем, записал ли что-нибудь автор в ячейки для халявы и правильно ли это сделал:
var preObj=document.registration;
//форма отправки данных

if (document.getElementById('user_answer').style.display!='none') 
  {
	for (i=0;i<16;i++)
	{
	if (preObj.elements['authors_free'+eval(i+1)].value!=''||preObj.elements['customer_free'+eval(i+1)].value!=''||preObj.elements['worx_free'+eval(i+1)].value!='') check_free_sources++;
	}
	if (check_free_sources==0) {alert ('Вы ничего не ввели в ячейки для адресов сайтов!'); document.getElementById('user_answer').style.backgroundColor='yellow'; location.href="#free_period"; return false;}
	else 
	{
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
		if (check_dot>0)	{
				alert ('Проверьте правильность записи указанных вами адресов сайтов!'); 
				document.getElementById('user_answer').style.backgroundColor='yellow';
				location.href='#free_period';
				return false;
				}
  		}
  }

if (myFm.agree.checked==false) {
alert ('Вы не согласились с условиями нашего пользовательского соглашения!');
location.href='#agree';
document.getElementById('tblAgree').style.backgroundColor='yellow';
return false;
}

return true;
}
//-->
</script>
</head>
<body onLoad="checkfree=0"><? require ("../temp_transparency_author.php");?><form action="reg_user.php" method="post" name="registration" onSubmit="return checkCells();">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" background="../images/bg2.jpg">
    <tr>
      <td><a href="../index.php"><img src="../images/logo2.gif"  alt="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты." width="257" height="56" hspace="10" border="0"></a></td>
      <td width="100%">&nbsp;</td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="50%" valign="top">
	<h1>Создание персонального аккаунта автора.</h1>
      <p style="color:#FF6600;font-size:125%;font-weight:600" class="arial">Шаг
        2 из 2.</p>
      <p><strong class="arialEncrised">Заполните анкету и ваш персональный аккаунт будет создан!</strong> <br>Поля, отмеченные символом <span class="red" style="font-size:16px">*</span> являются обязательными к заполнению!
                          <?php
if(isset($mess))
{
  echo("<br><font size=+2 color='Red'>$mess</font><br>");
}
?>
                          <input name="login" type="hidden" id="login" value="<?php echo($login);?>">
          <br>
      </p>
      <a name="myname"></a>
      <table  cellspacing="0" cellpadding="0">
        <tr>
          <td><span class="arial"><span class="red" style="font-size:16px">*</span>Ваш nickname, ФИО или другое обращение:&nbsp;<br>
            <input name="family" type="text" id="family" style="width:100%" onBlur="if (this.value) this.style.backgroundColor=''">
          </span></td>
        </tr>
      </table>      <p><span class="arial">      </span><span class="arial">
        </span></p>
      <a name="mypasses"></a>
      <table  cellspacing="0" cellpadding="0">
        <tr>
          <td><span class="arial"><span class="red" style="font-size:16px">*</span>Ваш пароль:<br>
              <input name="pass" type="password" id="pass" onBlur="if (this.value) this.style.backgroundColor=''" size="40">
&nbsp;          </span></td>
          <td><span class="arial"><span class="red" style="font-size:16px">*</span>Подтвердите пароль:<br>
              <input name="pass2" type="password" id="pass2" onBlur="document.getElementById('pass').style.backgroundColor=''; if (this.value) this.style.backgroundColor=''" size="40">
&nbsp;          </span></td>
        </tr>
      </table><a name="mycity"></a>
      <p><span class="red" style="font-size:16px">*</span>Город проживания: 
        <input name="city" type="text" id="login10" onBlur="if (this.value) this.style.backgroundColor=''" size="40">
</p>



      <hr size="1" noshade>
      <a name="myready_volume"></a><p><span class="red" style="font-size:16px">*</span>Какое примерное количество готовых работ вы имеете?
        <input name="howmach" type="text" id="howmach" onBlur="if (this.value) this.style.backgroundColor=''" size="3">
</p>
      <p><a name="ownpage"></a><span class="red" style="font-size:16px">*</span>Имеете ли вы собственную страницу (web-сайт) заказа/продажи дипломов, курсовых работ и рефератов?
      <div class="topPad6" style="background-color:#e4e4e4; height:24px; padding:4px" id="homePage">
        <input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor=''; hPage=1"> Да<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('myURL').style.display='none';document.getElementById('mySiteTime').style.display='none'; parentNode.nextSibling.style.backgroundColor=''; hPage=1; parentNode.style.backgroundColor=''; hPage=1"> Нет 
<input name="owner" type="radio" value="radiobutton" onClick="document.getElementById('mySiteTime').style.display='block'; parentNode.nextSibling.style.backgroundColor='#f5f5f5'; parentNode.style.backgroundColor=''; hPage=1"> Пока нет, но планирую в ближайшее время</div><div id="HPcontent"><span id="myURL" style="display:none"><span class=red>Укажите URL своей страницы:</span> 
    <input name="site" type="text" id="site" size=30 onBlur="if (this.value) this.style.backgroundColor='';"></span><span id="mySiteTime" style="display:none"><span class=red>В течение какого срока вы планируете открыть собственную страницу:</span> <input name="time" type="text" id="time" onBlur="if (this.value) this.style.backgroundColor='';"></span></div>
	  </p> 
	  
	  <hr size="1" noshade>
	  <h1>Ваши контактные телефоны:</h1>
      <table  cellspacing="0" cellpadding="0">
        <tr>
          <td><span class="arial"><img src="../images/pyctos/phone.gif" width="16" height="13" hspace="2" align="absmiddle">Домашний:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              <input name="phone" type="text" id="phone" style="width:98%">
          </span></td>
          <td><span class="arial"><img src="../images/pyctos/phone2.gif" width="16" height="15" hspace="2" align="absmiddle">Рабочий:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              <input name="workphone" type="text" id="workphone" style="width:98%">
          </span></td>
          <td><span class="arial"><img src="../images/pyctos/cellular.gif" width="7" height="16" hspace="4" align="absmiddle">Мобильный:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              <input name="mobila" type="text" id="mobila" style="width:98%">
          </span></td>
          <td><span class="arial">&nbsp;<!-- #BeginLibraryItem "/Library/pic_cellular%2B.lbi" --><img src="../images/pyctos/cellular.gif" width="7" height="16" hspace="1" align="absmiddle" title="Дополнительный телефон"><span class="red">+</span><!-- #EndLibraryItem -->&nbsp;Дополнительный:&nbsp;&nbsp;<br>
              <input name="dopphone" type="text" id="dopphone" style="width:98%">
          </span></td>
        </tr>
      </table>      
      <p>Ваш <img src="../images/pyctos/icq.gif" width="18" height="18" hspace="2" align="absmiddle"># ICQ: 
        <input name="ICQ" type="text" id="login12" size="10" onBlur="if (this.value) this.style.backgroundColor=''">
</p>
      <hr size="1" noshade>      <h4>Укажите свои платежные реквизиты (желательно):
      </h4>
	  <h4><img src="../images/logo_wm.gif" width="113" height="36" vspace="10">	  <br>
      </h4>
	  <table  cellspacing="0" cellpadding="0">
        <tr valign="bottom">
          <td width="120" style="padding-right:12px"><p class="arial">&nbsp;&nbsp;&nbsp;WMR<br>
                <strong style="color:#CC0000">R</strong>
                <input name="WMR" type="text" id="WMR" value="" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
            </p>
            </td>
          <td width="120" style="padding-right:12px"><span class="arial">&nbsp;&nbsp;&nbsp;WMZ<br>
                <strong style="color:#009900">Z</strong>
                <input name="WMZ" type="text" id="WMZ" value="" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </span></td>
          <td width="120" style="padding-right:12px"><span class="arial">&nbsp;&nbsp;&nbsp;WME<br>
              <strong style="color:#000099">E</strong>
                <input name="WME" type="text" id="WME" value="" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </span></td>
          <td width="120" style="padding-right:12px"><span class="arial">&nbsp;&nbsp;&nbsp;WMU<br>
              <strong style="color:#FF9900 ">U</strong>
              <input name="WMU" type="text" id="WMU" value="" size="13" onBlur="if (this.value) this.style.backgroundColor=''">
          </span></td>
        </tr>
      </table>
      <br>
      <br>
      <table cellspacing="0" cellpadding="0">
        <tr valign="bottom">
          <td valign="bottom" nowrap><img src="../images/ya.gif" width="44" height="27" vspace="2"><img src="../images/logo-yandex.gif" width="64" height="28" hspace="0"></td>
          <td nowrap><span style="font-size:22px;font-family:'Arial Narrow', Arial"><strong>.деньги</strong></span>&nbsp;</td>
          <td valign="bottom">                <input name="YmoneY" type="text" id="YmoneY" size="13" onBlur="if (this.value) this.style.backgroundColor=''">          </td>
        </tr>
      </table>      
      <br>
      <h1 class="header6bottom red"><hr size="1">
        <a name="free_p"></a><br>
        <b>Внимание! </b></h1>
        Вы можете получить право на период <strong>бесплатного</strong> обслуживания на нашей площадке от 2-х недель до 3-х месяцев! Для этого вам нужно будет ответить всего на 3 (три :) простых вопроса. Отметьте нужный пункт:
		<p id="periods"><span id="author_free"><input name="radiobutton" type="radio" value="radiobutton" onClick="document.getElementById('user_answer').style.display='block'; location.href='#free_period'; this.parentNode.style.border='solid 2px orange'; document.getElementById('periods').style.backgroundColor=''; checkfree=1"> 
        Получить право на бесплатное обслуживание на торговой площадке Referats.info.</span><br>
        <input name="radiobutton" type="radio" value="radiobutton" onClick="document.getElementById('user_answer').style.display='none';document.getElementById('author_free').style.border='none'; document.getElementById('periods').style.backgroundColor=''; checkfree=1"> 
        Отказаться от бесплатного обслуживания и закончить регистрацию сейчас.</p> 
        <hr size="1">
		<a name="free_period"></a>
		<div id="user_answer" style="display:none">
		  <p><strong>1. Пожалуйста, сообщите известные вам сайты, на которых авторы и исполнители творческих работ могут давать бесплатные объявления о своих услугах. Вам не нужно указывать префикс <em class="red">http://www</em>, ограничьтесь именем и доменной зонной, по шаблону <span class="red">site.ru</span>.</strong></p>
		  <table  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top">Для быстрого перехода из текущей ячейки в следующюю можете нажимать клавишу &laquo;Tab&raquo;<br>
              (она находится в крайнем левом ряду на клавиатуре, третий ряд сверху): </td>
              <td><img src="../images/tab.gif" width="77" height="47"></td>
            </tr>
          </table>
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="authors_free[1]" type="text" id="authors_free1" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[2]" type="text" id="authors_free2" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[3]" type="text" id="authors_free3" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[4]" type="text" id="authors_free4" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[5]" type="text" id="authors_free5" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[6]" type="text" id="authors_free6" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[7]" type="text" id="authors_free7" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[8]" type="text" id="authors_free8" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
            <tr>
              <td><input name="authors_free[9]" type="text" id="authors_free9" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[10]" type="text" id="authors_free10" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[11]" type="text" id="authors_free11" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[12]" type="text" id="authors_free12" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[13]" type="text" id="authors_free13" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[14]" type="text" id="authors_free14" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[15]" type="text" id="authors_free15" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="authors_free[16]" type="text" id="authors_free16" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
          </table>
		  <p><strong>2. Пожалуйста, сообщите известные вам сайты, на которых заказчики могут давать бесплатные объявления о написании для них дипломных работ, курсовых, рефератов и т.д.</strong></p>
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="customer_free[1]" type="text" id="customer_free1" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[2]" type="text" id="customer_free2" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[3]" type="text" id="customer_free3" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[4]" type="text" id="customer_free4" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[5]" type="text" id="customer_free5" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[6]" type="text" id="customer_free6" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[7]" type="text" id="customer_free7" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[8]" type="text" id="customer_free8" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
            <tr>
              <td><input name="customer_free[9]" type="text" id="customer_free9" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[10]" type="text" id="customer_free10" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[11]" type="text" id="customer_free11" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[12]" type="text" id="customer_free12" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[13]" type="text" id="customer_free13" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[14]" type="text" id="customer_free14" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[15]" type="text" id="customer_free15" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="customer_free[16]" type="text" id="customer_free16" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
          </table>
		  <p><strong>3. Пожалуйста, сообщите известные вам сайты, c которых можно бесплатно скачивать дипломные, курсовые работы, рефераты и т.д.</strong></p>
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="worx_free[1]" type="text" id="worx_free1" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[2]" type="text" id="worx_free2" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[3]" type="text" id="worx_free3" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[4]" type="text" id="worx_free4" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[5]" type="text" id="worx_free5" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[6]" type="text" id="worx_free6" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[7]" type="text" id="worx_free7" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[8]" type="text" id="worx_free8" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
            <tr>
              <td><input name="worx_free[9]" type="text" id="worx_free9" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[10]" type="text" id="worx_free10" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[11]" type="text" id="worx_free11" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[12]" type="text" id="worx_free12" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[13]" type="text" id="worx_free13" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[14]" type="text" id="worx_free14" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[15]" type="text" id="worx_free15" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
              <td><input name="worx_free[16]" type="text" id="worx_free16" style="width:100%" onBlur="if (this.value) document.getElementById('user_answer').style.backgroundColor=''"></td>
            </tr>
          </table>
	    </div>
		<p style="display:none">
          <input name="radiobutton" type="radio" value="radiobutton">
  Зарегистрироваться только на Referats.info в качестве автора <br>
  <input name="radiobutton" type="radio" value="radiobutton">
  Продолжить регистрацию в качестве исполнителя на Diplom.com.ru <a href="javascript:diplom_hint();">[?]</a> <br>
  <span id="diplom_maker" style="background-color:#e4e4e4;padding:6px"></span><span id="clps" onClick="javascript:document.getElementById('diplom_maker').innerHTML='';this.innerHTML=''" style='color:blue;cursor:hand;text-decoration:underline'; ></span></p>
		<table height="40" cellpadding="0"  cellspacing="0" id="tblAgree">
          <tr>
            <td><input name="agree" type="checkbox" class="checkbox" id="agree" style="padding:4px 6px 4px -6px;margin:4px 6px 4px 0px" onClick="if (this.checked==true) document.getElementById('tblAgree').style.backgroundColor=''" value="checkbox"></td>
            <td width="100%" nowrap>Я принимаю условия <a href="agreement.htm" target="_blank">пользовательского соглашения</a> торговой площадки Referats.info.</td>
          </tr>
        </table><p class="topPad6">
		<input name="Submit" type="submit" value="     OK     ">
      </p>
      
      
      
      </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
  <tr valign="bottom">
    <td height="22" align="center" nowrap class="topDotted"><b>Внимание!</b> Чем
      больше работ вы выставите на продажу, тем длиннее будет период вашего <span class="red"><b>бесплатного</b></span>      обслуживания!. </td>
  </tr>
  <tr valign="bottom">
    <td height="20" align="center" nowrap background="../images/bankreferatov_bg.gif"><b style="font-weight:100">Банк
        рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ,
        рефераты</b></td>
  </tr>
</table>
</form>
</body>
</html>
