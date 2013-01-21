<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

if(!isset($bDay)){$bDay=date('d')-1;}
if($bDay==0){$bDay=31;}
if(!isset($bMonth)){$bMonth=date('m');}
if(!isset($bYear)){$bYear=date('Y');}

if(!isset($wDay)){$wDay=date('d');}
if($wDay==0){$wDay=31;}
if(!isset($wMonth)){$wMonth=date('m');}
if(!isset($wYear)){$wYear=date('Y');}

$hs_r=mysql_query("SELECT DISTINCT ip FROM ri_hostin WHERE data='".date('Y-m-d')."'");
$hs_n_today=mysql_num_rows($hs_r);
?>
<html>
<head>
<title>Заходы на сайт</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META name="ROBOTS" content="NONE">
<script language="JavaScript" type="text/JavaScript">
if (document.referrer=='http://www.diplom.com.ru/host_statistic.php') location.reload();
function goToPos (myForm,searchWords) {
//location.href=myForm.action+'?words='+searchWords.value+'&start=www.diplom.com.ru';
}
function goToIndexed (siteTarget)	{
location.href='http://www.yandex.ru/yandsearch?text=&serverurl='+siteTarget+'/&refine=&how=tm'
}
function showQueryField (targSpan)	{
if (document.all[targSpan].innerHTML=='') document.all[targSpan].innerHTML='<br><INPUT name=target_query class="cells" style="WIDTH: 100%">';
else document.all[targSpan].innerHTML='';
}</script>
<link href="admin.css" rel="stylesheet" type="text/css">
</head>
<body style="margin-right: 0px;"><!--onSubmit='goToPos(this,this.elements["words"]);' target="_blank"-->
<table width="100%"  border="0" cellpadding="4" cellspacing="0" bgcolor="#CCCCCC">
  <tr><form name=filter action="searchers.php?fl=filter" method="post">
    <td width="100%" nowrap>Посещаемость: <a href="#" title="Показать только сегодняшние заходы">сегодня: <?php echo($hs_n_today);?>
        </a> &nbsp;<a href="#" title="Показать только вчерашние заходы">вчера: </a> &nbsp;<a href="#" title="Показать все заходы">средняя:
        </a></td>
    <td align="right" nowrap>
   Сформировать отчёт за период с&nbsp;</td>
    <td align="right" nowrap>
      <select name="bDay" style="font-size:10px">
<?php
for($i=0;$i<32;$i++)
{
  echo("<option value='$i' ");
  if($bDay==$i){echo('selected');}
  echo(">$i</option>");
}
?>
      </select>
      <select name="bMonth" style="font-size:10px">
        <option value="01" <?php if($bMonth==1){echo('selected');}?>>Январь</option>
        <option value="02" <?php if($bMonth==2){echo('selected');}?>>Февраль</option>
        <option value="03" <?php if($bMonth==3){echo('selected');}?>>Март</option>
        <option value="04" <?php if($bMonth==4){echo('selected');}?>>Апрель</option>
        <option value="05" <?php if($bMonth==5){echo('selected');}?>>Май</option>
        <option value="06" <?php if($bMonth==6){echo('selected');}?>>Июнь</option>
        <option value="07" <?php if($bMonth==7){echo('selected');}?>>Июль</option>
        <option value="08" <?php if($bMonth==8){echo('selected');}?>>Август</option>
        <option value="09" <?php if($bMonth==9){echo('selected');}?>>Сентябрь</option>
        <option value="10" <?php if($bMonth==10){echo('selected');}?>>Октябрь</option>
        <option value="11" <?php if($bMonth==11){echo('selected');}?>>Ноябрь</option>
        <option value="12" <?php if($bMonth==12){echo('selected');}?>>Декабрь</option>
      </select>
      <select name="bYear"  style="font-size:10px">
<?php
for($i=2004;$i<2008;$i++)
{
  echo("<option value='$i' ");
  if($i==$bYear){echo("selected");}
  echo(">$i</option>");
}
?>
      </select>
    </td><td nowrap>по</td>
    <td nowrap>
<select name="wDay" style="font-size:10px">
<?php
for($i=0;$i<32;$i++)
{
  echo("<option value='$i' ");
  if($wDay==$i){echo('selected');}
  echo(">$i</option>");
}
?>
</select>
<select name="wMonth" style="font-size:10px">
        <option value="01" <?php if($wMonth==1){echo('selected');}?>>Январь</option>
        <option value="02" <?php if($wMonth==2){echo('selected');}?>>Февраль</option>
        <option value="03" <?php if($wMonth==3){echo('selected');}?>>Март</option>
        <option value="04" <?php if($wMonth==4){echo('selected');}?>>Апрель</option>
        <option value="05" <?php if($wMonth==5){echo('selected');}?>>Май</option>
        <option value="06" <?php if($wMonth==6){echo('selected');}?>>Июнь</option>
        <option value="07" <?php if($wMonth==7){echo('selected');}?>>Июль</option>
        <option value="08" <?php if($wMonth==8){echo('selected');}?>>Август</option>
        <option value="09" <?php if($wMonth==9){echo('selected');}?>>Сентябрь</option>
        <option value="10" <?php if($wMonth==10){echo('selected');}?>>Октябрь</option>
        <option value="11" <?php if($wMonth==11){echo('selected');}?>>Ноябрь</option>
        <option value="12" <?php if($wMonth==12){echo('selected');}?>>Декабрь</option>
</select>
<select name="wYear" style="font-size:10px">
<?php
for($i=2004;$i<2008;$i++)
{
  echo("<option value='$i' ");
  if($i==$wYear){echo("selected");}
  echo(">$i</option>");
}
?>
</select>
&nbsp;
<input type="submit" name="Submit" value="Do it! :)" style="font-size:10px"></td></form>
  </tr>
</table>
<table width="100%" height="88%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign='top'><hr size="1" noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td height="386" colspan="2" valign='top'><iframe src="visites.php<?php echo("?where=WHERE data>='$bYear-$bMonth-$bDay' AND data<='$wYear-$wMonth-$wDay' ");?>" name="tables" width="100%" height="100%" frameborder="0"></iframe> </td>
  </tr>
  <tr>
    <td colspan="2" valign='top'><hr size="1" noshade color="#CCCCCC"></td>
  </tr>
  <tr>
    <td height="30%" valign='top'><FORM name=Search action=http://search.rambler.ru/cgi-bin/rambler_search method=get style="padding-bottom:0px;margin-bottom:0px">
      <input name="start" type="hidden" value="diplom.com.ru">
<?php
$hs_r=mysql_query("SELECT * FROM ri_hostin WHERE data>='$bYear-$bMonth-$bDay' AND data<='$wYear-$wMonth-$wDay'");
$hs_n=mysql_num_rows($hs_r);
$yand=0;
$ramb=0;
$goog=0;
$yaho=0;
$apor=0;
$mail=0;
for($i=0;$i<$hs_n;$i++)
{
  $ts=mysql_result($hs_r,$i,'fromhost');
  $ts=uppercase($ts);
  if(strstr($ts,'YANDEX.RU')){$yand++;}
  if(strstr($ts,'RAMBLER.RU')){$ramb++;}
  if(strstr($ts,'GOOGLE.RU') || strstr($ts,'GOOGLE.COM')){$goog++;}
  if(strstr($ts,'YAHOO.RU') || strstr($ts,'YAHOO.COM')){$yaho++;}
  if(strstr($ts,'APORT.RU')){$apor++;}
  if(strstr($ts,'MAIL.RU')){$mail++;}
}
?>
      <table cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#F5F5F5">
          <td nowrap><b>Показатель:</b></td>
          <td align="center"><b>Яndex</b></td>
          <td align="center"><b>Rambler</b></td>
          <td align="center"><b>Google</b></td>
          <td align="center"><b>Yahoo</b></td>
          <td align="center"><b>Aport</b></td>
          <td align="center"><b>Mail.ru</b></td>
          <td align="center"><strong>Km.ru</strong></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td nowrap><a href="#">Проиндексированные страницы: </a></td>
          <td align="center"><a href="http://www.yandex.ru/yandsearch?text=&serverurl=www.referats.info/&refine=" target="_blank"><?php echo($yand);?></a></td>
          <td align="center"><a href="http://search.rambler.ru/cgi-bin/rambler_search?filter=www.referats.info&limit=50&sort=1" target="_blank"><?php echo($ramb);?></a></td>
          <td align="center"><a href="http://www.google.ru/search?q=site%3Awww.referats.info&btnG=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA+%D0%B2+Google&hl=ru" target="_blank"><?php echo($goog);?></a></td>
          <td align="center"><a href="http://search.yahoo.com/search?ei=UTF-8&p=site%3Awww.referats.info&fr=sfp&dups=1" target="_blank"><?php echo($yaho);?></a></td>
          <td align="center"><a href="http://sm.aport.ru/scripts/template.dll?r=URL%3Dreferats.info&That=std" target="_blank"><?php echo($apor);?></a></td>
          <td align="center"><a href="#"><?php echo($mail);?></a></td>
          <td align="center"><?php echo($km);?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td nowrap><a href="#">Индекс цитирования:</a></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td nowrap><a href="#">Статистика заходов с поисковых систем за период:</a></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td nowrap bgcolor="#FFFFFF"><a href="#">Проверка позиции сайта по</a> <a href="javascript:showQueryField('qField');" class="red">запросу:</a><span id="qField"></span></td>
          <td align="center" valign="top"><a href="#">Яndex</a></td>
          <td align="center" valign="top"><a href="#">Rambler</a></td>
          <td align="center" valign="top"><a href="#">Google</a></td>
          <td align="center" valign="top"><a href="#">Yahoo</a></td>
          <td align="center" valign="top"><a href="#">Aport</a></td>
          <td align="center" valign="top"><a href="#">Mail.ru</a></td>
          <td align="center" valign="top"><a href="#">Km.ru</a></td>
        </tr>
      </table>
    </form></td>
    <td width="100%" height="30%" valign='top' bgcolor="#CCCCCC">&nbsp;    </td>
    </tr>
</table>
</body>
</html>
<?php
}//end work
?>