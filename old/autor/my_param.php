<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if($fl=='change')
{
  //сверить login при изменении, произвести изменения в заказах
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
  $ulogin=mysql_result($us_r,0,'login');
  if($ulogin!=$uemail){mysql_query("UPDATE ri_zakaz SET email='$uemail' WHERE email='$ulogin'");}
  mysql_query("UPDATE ri_user SET login='$email', family='$uname', phone='$uphone', mobila='$umobila', workphone='$uworkphone', dopphone='$udopphone', city='$ucity', wmr='$uwmr', wmz='$uwmz', wme='$uwme', ymoney='$uymoney', bankacc='$ubankacc', icq='$uicq', howmach=$uhowmach WHERE number=$S_NUM_USER");
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER AND pass='$upass_old'");
  $us_n=mysql_num_rows($us_r);
  if($us_n>0)
  {
    mysql_query("UPDATE ri_user SET pass='$upass' WHERE number=$S_NUM_USER");
  }
}

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$ulogin=mysql_result($us_r,0,'login');
$upass=mysql_result($us_r,0,'pass');
$uname=mysql_result($us_r,0,'family');
$uphone=mysql_result($us_r,0,'phone');
$umobila=mysql_result($us_r,0,'mobila');
$uworkphone=mysql_result($us_r,0,'workphone');
$udopphone=mysql_result($us_r,0,'dopphone');
$ucity=mysql_result($us_r,0,'city');
$uicq=mysql_result($us_r,0,'icq');
$uhowmach=mysql_result($us_r,0,'howmach');
$uwmr=mysql_result($us_r,0,'WMR');
$uwmz=mysql_result($us_r,0,'WMZ');
$uwme=mysql_result($us_r,0,'WME');
$uymoney=mysql_result($us_r,0,'YmoneY');
$ubankacc=mysql_result($us_r,0,'BankAcc');

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Регистрационные данные автора</title>
<link href="autor.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #D4D0C8}
h4 { font-size:120% }
-->
</style>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<script language="JavaScript" type="text/JavaScript" src="../../valid_email.js">
</script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('my_param');

function checkCells	()	{
var myFm = document.my_param;

if (!myFm.upass_old.value&&(myFm.upass.value||myFm.upass2.value)) {
alert ('Вы не ввели старый пароль!');
myFm.upass_old.style.backgroundColor='yellow';
myFm.upass_old.focus();
location.href='#mypasses';
return false;
}

if (myFm.upass_old.value&&myFm.upass.value&&!myFm.upass2.value) {
alert ('Вы не подтвердили новый пароль!');
myFm.upass2.style.backgroundColor='yellow';
myFm.upass2.focus();
location.href='#mypasses';
return false;
}

if ((myFm.upass.value&&myFm.upass2.value)&&(myFm.upass.value!=myFm.upass2.value)) {
alert ('Пароли не совпадают!');
myFm.upass.style.backgroundColor='yellow';
myFm.upass2.style.backgroundColor='lime';
location.href='#mypasses';
return false;
}

if (myFm.upass_old.value&&myFm.upass2.value&&!myFm.upass.value) {
alert ('Вы не указали новый пароль!');
myFm.upass.style.backgroundColor='yellow';
myFm.upass.focus();
location.href='#mypasses';
return false;
}

if (!myFm.ucity.value) {
alert ('Вы не указали место проживания!');
myFm.ucity.style.backgroundColor='yellow';
myFm.ucity.focus();
location.href='#mycity';
return false;
}
if (!myFm.email.value) {
alert ('Вы не указали свой email!');
myFm.email.style.backgroundColor='yellow';
location.href='#myemail';
myFm.email.focus();
return false;
}

return emailCheckReferats(document.my_param.email);
}
</script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="my_param" action="my_param.php" method="post" onSubmit="return checkCells();">
   <h3 class="dLime">Ваши регистрационные данные
   </h3>
   <table width="100%" cellpadding="2"  cellspacing="2">
    <tr>
      <td height="30" colspan="2" bgcolor="#CCCCCC"><h4>1. Общие данные: </h4></td>
     </tr>
    <tr>
    <td align="right"><a name="myemail"></a>E-mail</td>
    <td valign="top"><input name="email" type="text" id="email" style="width:100%" value="<?php echo($ulogin);?>">
     </td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">Изменение пароля</td>
    <td valign="top"><a name="mypasses"></a>Введите старый пароль 
      <input name="upass_old" type="password" id="upass_old">
      <br>
      Введите новый пароль 
      <input name="upass" type="password" id="upass">
      <br>
      Подтвердите новый пароль
      <input name="upass2" type="password" id="upass2"></td>
  </tr>
  <tr>
    <td align="right">Как к вам обращаться </td>
    <td valign="top"><input name="uname" type="text" id="uname" value="<?php echo($uname);?>" disabled>
      (для изменения этого поля вам нужно <a href="faq.php#add_question" target="_blank">обратиться к администратору</a>)</td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right"><a name="mycity"></a>Город</td>
    <td valign="top"><input name="ucity" type="text" id="ucity" value="<?php echo($ucity);?>"></td>
  </tr>
  <tr>
    <td align="right">Домашний телефон </td>
    <td valign="top"><input name="uphone" type="text" id="uphone" value="<?php echo($uphone);?>"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">Рабочий телефон</td>
    <td valign="top"><span class="style1">
      <input name="uworkphone" type="text" id="uworkphone" value="<?php echo($uworkphone);?>">
    </span></td>
  </tr>
  <tr>
    <td align="right">Мобильный телефон </td>
    <td valign="top"><input name="umobila" type="text" id="umobila" value="<?php echo($umobila);?>"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">Дополнительный телефон </td>
    <td valign="top"><input name="udopphone" type="text" id="udopphone" value="<?php echo($udopphone);?>"></td>
  </tr>
  <tr>
    <td align="right">ICQ</td>
    <td valign="top"><input name="uicq" type="text" id="uicq" value="<?php echo($uicq);?>"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">Примерное количество работ </td>
    <td valign="top"><input name="uhowmach" type="text" id="uhowmach" value="<?php echo($uhowmach);?>"></td>
  </tr>
  <tr>
    <td height="30" colspan="2" bgcolor="#CCCCCC"><h4>2. Платежные реквизиты:</h4></td>
  </tr>
  <tr>
    <td align="right">WMR</td>
    <td valign="top"><input name="uwmr" type="text" id="uwmr" value="<?php echo($uwmr);?>"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">WMZ</td>
    <td valign="top"><input name="uwmz" type="text" id="uwmz" value="<?php echo($uwmz);?>"></td>
  </tr>
  <tr>
    <td align="right">WME</td>
    <td valign="top"><input name="uwme" type="text" id="uwme" value="<?php echo($uwme);?>"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right"> Яндекс.деньги</td>
    <td valign="top"><input name="uymoney" type="text" id="uymoney" value="<?php echo($uymoney);?>"></td>
  </tr>
  <tr>
    <td align="right">Банковские реквизиты </td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="ubankacc" id="ubankacc" style="width:100%" rows="10"><?php echo($ubankacc);?></textarea></td>
  </tr>
  <tr>
    <td colspan="2"><input name="fl" type="hidden" id="fl" value="change">
      <input type="submit" name="Submit" value="Потвердить изменения!"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//end work
?>