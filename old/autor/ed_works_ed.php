<?php
session_start();
require('../../connect_db.php');
require('../access.php');

if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

if($fl=='change')
{
  //echo("Изменения начаты...<br>");
  //опеределим что за действо - изменение или добавление
  if($wnum==0)
  {
    //добавить
    //проверить, вдруг уже есть такая точно работа, в этом случае факт добавления игнорировать
	$wk_r=mysql_query("SELECT * FROM ri_works WHERE tip='$tip' AND predmet='$predmet' AND name='$name' AND manager=$man");
	$wk_n=mysql_num_rows($wk_r);
	if($wk_n==0)
	{
	  mysql_query("INSERT INTO ri_works ( tip, predmet, name, annot, tax, manager, data, pages ) VALUES ( $tip, $predmet, '$name', '".rawurlencode($annot)."', '$tax', $man, '".date('Y-m-d')."', $pages )");
	  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
	  $wnum=mysql_insert_id();
	  mysql_query("INSERT INTO ri_shedule ( data, kratnost, period, script, remark, enable ) VALUES ( '".date('Y-m-d')."', 0, 72, 'autoutv_work($wnum)', 'Автоутверждение работы для выставления на продажу', 'O' )");
	}
  }
  else
  {
    //изменить
    //echo(" процесс изменения<br>");
	mysql_query("UPDATE ri_works SET tip=$tip, predmet=$predmet, tax='$tax', name='$name', annot='".rawurlencode($annot)."',  data='".date('Y-m-d')."', pages=$pages WHERE number=$wnum");
  }
  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
  //закачать файл, опеределять есть он или нет будем в каждом частном случае
  if(isset($work_file) && ($work_file!='none'))
  {
    copy($work_file,"download/$wnum.zip");
  }
  header("location: $ret");
}

if($wnum==0)
{
  $tip=0;
  $predmet=0;
  $name='';
  $annot='';
  $rem='';
  $man=0;
  $pages=0;
}
else
{
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$wnum");
  $tip=mysql_result($wk_r,0,'tip');
  $predmet=mysql_result($wk_r,0,'predmet');
  $name=mysql_result($wk_r,0,'name');
  $annot=rawurldecode(mysql_result($wk_r,0,'annot'));
  $keywords=mysql_result($wk_r,0,'keywords');  
  $tax=mysql_result($wk_r,0,'tax');  
  $pages=mysql_result($wk_r,0,'pages');  
  $man=mysql_result($wk_r,0,'manager');  
}
?>
<html>
<head>
<title>Редактор содержания работы</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="autor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="lime_div.js"></script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('ed_works_ed');
function checkAllCells()	{
//Проверка наличия и валидности всех полей формы
dForm=document.forms[0];
if (dForm.tip.options[0].selected==true) {alert ('Вы не указали тип размещаемой работы!'); dForm.tip.focus(); return false;}
if (dForm.predmet.options[0].selected==true) {alert ('Вы не указали предмет размещаемой работы!'); dForm.predmet.focus(); return false;}
if (dForm.name.value==''||!dForm.name.value) {alert ('Вы не указали тему размещаемой работы!'); dForm.name.focus(); return false;}
if (dForm.annot.value==''||!dForm.annot.value) {alert ('Вы не разместили содержание работы!'); dForm.annot.focus(); return false;}
if (isNaN(dForm.pages.value)) {alert ('Поле для количества страниц не должно содержать ничего, кроме цифр!'); dForm.pages.focus(); return false;}
if (dForm.tax.value==0||dForm.tax.value=='') {alert ('Вы не указали стоимость размещаемой работы!'); dForm.tax.focus(); return false;}
if (isNaN(dForm.tax.value)) {alert ('Поле для стоимости работы не должно содержать ничего, кроме цифр!'); dForm.tax.focus(); return false;}
if (dForm.pages.value==0||dForm.pages.value=='') {
if (confirm('Вы не указали объём (колич. страниц) размещаемой работы.\nВы желаете оставить это поле незаполненным и внести данные позже?')) return true;
else  {dForm.pages.focus();return false;}
}
return true;
}
</script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form action="ed_works_ed.php" method="post" enctype="multipart/form-data" onSubmit="return checkAllCells();">
  <h3 class="dLime">Разместить в каталоге Referats.info содержание работы.</h3>
    <!--*Значение поля "Владелец" устанавливается автоматически при создании аннотации. <font size="-1">  
Для данной аннотации <strong>Владелец
  -&nbsp;<?php
if($man==0){$man=$S_NUM_USER;}
$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$man");
$man_s=mysql_result($us_r,0,'login').'('.mysql_result($us_r,0,'family').' '.mysql_result($us_r,0,'name').' '.mysql_result($us_r,0,'otch').')';
echo($man_s);
?></strong></font>
-->
    
  
  <table width="100%" height="90%" border="0" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
  <!--<tr>
    <td><div align="center"><strong>Поле</strong></div></td>
    <td><div align="center"><strong>Значение</strong></div></td>
  </tr>-->
  <tr bgcolor="#E4E4E4">
    <td height="1%" align="right" nowrap><font color="#000000">Тип работы<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></font></td>
    <td height="1%"><font color="#000000">
      <select name="tip">
        <option value="0">-Все-</option>
        <?php
$tw_r=mysql_query("SELECT * FROM ri_typework ORDER BY number");
$tw_n=mysql_num_rows($tw_r);
for($i=0;$i<$tw_n;$i++)
{
  $lwnum=mysql_result($tw_r,$i,'number');
  $lwtip=mysql_result($tw_r,$i,'tip');
  echo("<option value='$lwnum'");
  if($tip==$lwnum){echo(" selected");}
  echo(">$lwtip</option>\n");
}
?>
      </select>
    </font></td>
  </tr>
  <tr>
    <td height="1%" align="right" nowrap bgcolor="#FFFFFF"><font color="#000000">Предмет<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></font></td>
    <td height="1%" bgcolor="#FFFFFF"><font color="#000000">
      <select name="predmet">
        <option value="0">-Все-</option>
        <?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<option value='$pnum'");
  if($predmet==$pnum){echo(" selected");}
  echo(">$ppredmet</option>\n");
}
?>
      </select>
    </font></td>
  </tr>
  <tr bgcolor="#E4E4E4">
    <td height="1%" align="right" nowrap>Наименование (тема)<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%"><input name="name" type="text" id="name" style="width:100%" value="<?php echo($name);?>"></td>
  </tr>
  <tr>
    <td height="96%" align="right" nowrap bgcolor="#FFFFFF">Содержание (план) работы<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="96%" valign="top" bgcolor="#FFFFFF"><textarea name="annot"  style="width:100%; height:100%" id="annot"><?php echo($annot);?></textarea></td>
  </tr>
  <tr bgcolor="#E4E4E4">
    <td height="1%" align="right" nowrap>Число страниц<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%"><input name="pages" type="text" id="pages" size="5" value="<?php echo($pages);?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="1%" align="right" nowrap>Ваша цена, руб.<img src="../../images/arrows/simple_black.gif" width="14" height="12" hspace="4" border="1" align="absmiddle"></td>
    <td height="1%"><input name="tax" type="text" id="tax" size="5" value="<?php echo($tax);?>"></td>
  </tr>
  <!--<tr>
    <td valign="top" bgcolor="#FFFFFF">Ключевые слова</td>
    <td bgcolor="#FFFFFF"><input name="rem" type="text" id="rem" size="70" value="<?php echo($keywords);?>"></td>
  </tr> -->
</table>
  <div class="topPad6">
  <input name="fl" type="hidden" id="fl" value="change"><input type="submit" value="Подтвердить изменения..."><input name="wnum" type="hidden" id="wnum" value="<?php echo($wnum+1-1);?>"><input name="man" type="hidden" id="man" value="<?php echo($man);?>"><input name="ret" type="hidden" id="ret" value="<?php echo($ret);?>">
  <input type="button" name="Button" <?php 
echo("onClick=location.href='$ret'");
?> value="Вернуться к списку работ -->">
  </div>
</form>
</body>
</html>
<?php
}//end works
?>