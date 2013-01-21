<?php
session_start();
require('../../connect_db.php');
require('../access.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if($fl=='change')
{
  //сверить login при изменении, произвести изменения в заказах
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$unum");
  $ulogin=mysql_result($us_r,0,'login');
  if($ulogin!=$uemail){mysql_query("UPDATE ri_zakaz SET email='$uemail' WHERE email='$ulogin'");}
  //обновить данные
  $sql_com="UPDATE ri_user SET login='$uemail', name='$name', family='$family', otch='$otch', email='$email', phone='$phone', mobila='$mobila', icq='$ICQ', city='$city', workphone='$workphone', dopphone='$dopphone', WMR='$WMR', WMZ='$WMZ', WME='$WME', YmoneY='$YmoneY', BankAcc='$BankAcc', howmach=$howmach";
  if(trim($pass)!='' && $pass==$pass2){$sql_com=$sql_com.", pass='$pass'";}
  $sql_com=$sql_com." WHERE number=$unum";
//echo("$sql_com<hr>");
  mysql_query($sql_com);
  if(mysql_error()!=''){echo(mysql_error()."<br>");}
  if(trim($ret)!=''){header("location: $ret");}
}
?>
<html>
<head>
<title>Анкета автора</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="personal_data.php" method="post">
  <div align="left" class="bottomPad6"><strong>Данные автора <?php
if(isset($mess))
{
  echo("<br><font size=+2 color='Red'>$mess</font><br>");
}
$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$unum");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'name');
if($unum!=1){$pass=mysql_result($us_r,0,'pass');}
$family=mysql_result($us_r,0,'family');
$otch=mysql_result($us_r,0,'otch');
$phone=mysql_result($us_r,0,'phone');
$workphone=mysql_result($us_r,0,'workphone');
$dopphone=mysql_result($us_r,0,'dopphone');
$mobila=mysql_result($us_r,0,'mobila');
$howmach=mysql_result($us_r,0,'howmach');
$city=mysql_result($us_r,0,'city');
$WMR=mysql_result($us_r,0,'WMR');
$WMZ=mysql_result($us_r,0,'WMZ');
$WME=mysql_result($us_r,0,'WME');
$YmoneY=mysql_result($us_r,0,'YmoneY');
$BankAcc=mysql_result($us_r,0,'BankAcc');
$icq=mysql_result($us_r,0,'icq');
echo ("<span style='background-color:yellow'>&nbsp;$name&nbsp;</span>");
?>
  </strong></div>
  <table cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap bgcolor="#F5F5F5">E-mail<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td width="100%"><input name="uemail" type="text" value="<?php echo($login); ?>" style="background-color:#F5F5F5">
      <input name="unum" type="hidden" id="unum" value="<?php echo($unum);?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Пароль<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><?php echo("<b>$pass</b>");?></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Имя<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="name" type="text" id="login4" value="<?php echo($name);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Фамилия<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="family" type="text" id="login5" value="<?php echo($family);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Отчество<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="otch" type="text" id="login6" value="<?php echo($otch);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>&#1043;ор&#1086;&#1076;&#1089;&#1082;&#1086;&#1081; &#1090;елефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="phone" type="text" id="login8" value="<?php echo($phone);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Мобильный телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="mobila" type="text" id="login9" value="<?php echo($mobila);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Рабочий &#1090;елефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="workphone" type="text" id="login8" value="<?php echo($workphone);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>Дополнительный телефон<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="dopphone" type="text" id="login9" value="<?php echo($dopphone);?>" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Город<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="city" type="text" id="login10"  value="<?php echo($city);?>" style="width:100%"></td>
  </tr>
  <!-- <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>Учебное заведение<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><select name="uchzav">
<option value="0" selected>Не выбран</option>
<?php
$uz_r=mysql_query("SELECT * FROM ri_uchzav ORDER BY number");
$uz_n=mysql_num_rows($uz_r);
for($i=0;$i<$uz_n;$i++)
{
  $uz_num=mysql_result($uz_r,$i,'number');
  $uz_name=mysql_result($uz_r,$i,'name');
  echo("<option value='$uz_num'");
  if($uchzav==$uz_num){echo(" selected");}
  echo(">$uz_name</option>\n");
}
?>
	</select></td>
  </tr> -->
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>ICQ<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td><input name="ICQ" type="text" id="login12" value="<?php echo($icq);?>" size="20"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>WMR</td>
    <td><input name="WMR" type="text" id="login12" value="<?php echo($WMR);?>" size="20"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap>WMZ</td>
    <td><input name="WMZ" type="text" id="login12" value="<?php echo($WMZ);?>" size="20"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" nowrap>WME</td>
    <td><input name="WME" type="text" id="login12" value="<?php echo($WME);?>" size="20"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right" nowrap bgcolor="#F5F5F5">Яндекс.Кошелёк</td>
    <td><input name="YmoneY" type="text" id="login12" value="<?php echo($YmoneY);?>" size="20"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" valign="top" nowrap>Банковские реквизиты </td>
    <td><textarea name="BankAcc" cols="20" id="login12" style="width:100%"><?php echo($BankAcc);?></textarea></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right" valign="top" nowrap bgcolor="#F5F5F5">Примерно работ всего </td>
    <td bgcolor="#F5F5F5"><input name="howmach" type="text" id="login12" value="<?php echo($howmach);?>" size="20"></td>
  </tr>
</table>
  <input name="fl" type="hidden" id="fl" value="change">
  <input type="submit" class="topPad6" value="Изменить данные...">
  <input type="button" name="Button" value="Послать сообщение" onClick='location.href="new_mess.php?resp=autor&about=0&dlya=<?php echo($unum);?>&email=<?php echo($login);?>&zakaz=0"'>
  <input type="button" name="Button" value="Войти в эккаунт автора" onClick='window.top.location.href="../autors.php?login=<?php echo($login);?>&pass=<?php echo ($pass); ?>"'>
  <input name="unum" type="hidden" id="unum" value="<?php echo($unum);?>">
  <input name="ret" type="hidden" id="ret" value="<?php echo($ret);?>">
</form>
</body>
</html>
<?php
}//end work
?>