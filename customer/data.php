<?
$qSel="SELECT * FROM ri_customer WHERE number = $_SESSION[S_USER_ID]"; 
$rSel=mysql_query($qSel);
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);

$user_name=mysql_result($rSel,0,'name');
$user_email=mysql_result($rSel,0,'email');
$user_email2=mysql_result($rSel,0,'email2');
$user_password=mysql_result($rSel,0,'password');
$user_mobila=mysql_result($rSel,0,'mobila');

//ЕСЛИ изменяли данные:
if (isset($_REQUEST['user_data_change'])){
	$arrToChange=array();
	if ($_REQUEST['user_name']!=$user_name) $arrToChange['name']=$_REQUEST['user_name'];
	if ($_REQUEST['user_email']!=$user_email) $arrToChange['email']=$_REQUEST['user_email'];
	if ($_REQUEST['user_email2']!=$user_email2) $arrToChange['email2']=$_REQUEST['user_email2'];
	if (isset($_REQUEST['user_password'])) $arrToChange['password']=$_REQUEST['user_password'];	
	if ($_REQUEST['user_mobila']!=$user_mobila) $arrToChange['mobila']=$_REQUEST['user_mobila'];	
}
if (count($arrToChange)) {
	$qUpd="UPDATE ri_customer SET ";
	$count=0;
	foreach ($arrToChange as $field=>$value) {
		if ($count) $qUpd.=", ";
		$qUpd.=" $field = '$value'";
		$count++;
	} $qUpd.=" WHERE number = $_SESSION[S_USER_ID]";
	//обновим данные:
	$catchErrors->update($qUpd); 
	$Messages->alertReload("Данные обновлены!","?section=customer&mode=data");
} ?>

<input name="user_data_change" type="hidden" value="<?=$_SESSION['S_USER_ID']?>">
<table cellspacing="0" cellpadding="8" class="iborder" rules="rows">
	<colgroup>
      <col align="right" class="bgF4FF">
    </colgroup>
  <tr>
    <td>id Заказчика</td><td><? echo mysql_result($rSel,0,'number');?></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Дата/время регистрации</td><td><? 
		$Tools->dtime(mysql_result($rSel,0,'datatime'));?></td>
  </tr>
  <tr>
    <td>Имя</td><td><input class="widthFull" name="user_name" type="text" value="<?=$user_name?>"></td>
  </tr>
  <tr>
    <td>Емэйл</td><td><input class="widthFull" name="user_email" type="text" value="<?=$user_email?>"></td>
  </tr>
  <tr>
    <td>Доп. емэйл</td><td><input class="widthFull" name="user_email2" type="text" value="<?=$user_email2?>"></td>
  </tr>
  <tr>
    <td>Пароль</td><td><input class="widthFull" name="user_password" type="text">
    <div class="txtGreen txt90">Оставьте поле пустым, если не хотите менять пароль</div></td>
  </tr>
  <tr>
    <td>Моб. телефон</td><td><input class="widthFull" name="user_mobila" type="text" value="<?=$user_mobila?>"></td>
  </tr>
</table>
<div class="padding6"><input name="save_data" type="submit" value="Сохранить!"></div>
