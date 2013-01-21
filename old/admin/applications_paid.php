<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

//phpinfo();

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

if(!isset($period_from))
{
  //а надо сделать начиная с недели до текущей даты (за 7 дней?)
  $period_from=mktime(0,0,0,date("m"),date("d"),date("Y"))-24*3600*30*3;
  $period_from=date( "Y-m-d",$period_from);
}
if(isset($bDay)){$period_from="$bYear-$bMon-$bDay";}
if(!isset($period_to)){$period_to=date('Y-m-d');}
if(isset($eDay)){$period_to="$eYear-$eMon-$eDay";}
if($fl=='transmit'){zakaz_status_transmit($S_NUM_USER, $znum, 0);}

$loc_where=" ri_works.manager>0";
if(isset($where)){$loc_where=$loc_where.$where." AND ri_zakaz.data>='$period_from' AND ri_zakaz.data<='$period_to'";}

if(isset($order)){$order=" ORDER BY ".$order;}else
{$order=" ORDER BY ri_zakaz.number";}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Заказы</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function go2statusChanged (getChanged)	{
if (confirm ("Вы уверены, что хотите изменить статус этой работы?")) location.href=getChanged;
  }
  
function ChangeStatus(zid, where, title)
{
  //alert();
  if (confirm ('Вы уверены, что хотите изменить статус этой работы?'))
  {
    location.href='applications_paid.php?fl=transmit&znum='+zid+'&where='+where+'&title='+title;
  }
}
</script>

</head>
<body>
<div class="bottomPad6">
<b><?php echo($title." всего");
$sql="SELECT * FROM ri_zakaz, ri_works, ri_user WHERE  ri_user.number=ri_works.manager AND ri_zakaz.work=ri_works.number AND $loc_where $order";
echo("<hr>$sql<hr>");
$zk_r=mysql_query($sql);
$zk_n=mysql_num_rows($zk_r);
?>:</b></div>
<?php
if($where==' AND ri_zakaz.status=6'){
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0"><form name="form_period" action="applications_paid.php" method="post"><tr><td>За период с
  <select name="bDay" id="bDay">
  <?php
  $bDay=$period_from[8].$period_from[9];
  $bMon=$period_from[5].$period_from[6];
  $bYear=$period_from[0].$period_from[1].$period_from[2].$period_from[3];
  for($i=1;$i<=31;$i++)
  {
    echo("<option value=".f1t2($i));
	if($bDay==$i){echo(" selected");}
	echo(">".f1t2($i)."</option>\n");
  }
  ?>  </select>
  <select name="bMon" id="bMon">
  <?php
  for($i=1;$i<=12;$i++)
  {
    echo("<option value=".f1t2($i));
	if($bMon==$i){echo(" selected");}
	echo(">".rus_month($i)."</option>\n");
  }
  ?>
  </select>
  <select name="bYear" id="bYear">
  <?php
  for($i=2000;$i<=2010;$i++)
  {
    echo("<option value=$i");
	if($bYear==$i){echo(" selected");}
	echo(">$i</option>\n");
  }
  ?>
  </select> 
  <input name="period_from" type="hidden" value="<?php echo($period_from);?>" size="10"> 
по
<select name="eDay" id="eDay">
  <?php
  $eDay=$period_to[8].$period_to[9];
  $eMon=$period_to[5].$period_to[6];
  $eYear=$period_to[0].$period_to[1].$period_to[2].$period_to[3];
  for($i=1;$i<=31;$i++)
  {
    echo("<option value=".f1t2($i));
	if($eDay==$i){echo(" selected");}
	echo(">".f1t2($i)."</option>\n");
  }
  ?>
</select>
<select name="eMon" id="select2">
  <?php
  for($i=1;$i<=12;$i++)
  {
    echo("<option value=".f1t2($i));
	if($eMon==$i){echo(" selected");}
	echo(">".rus_month($i)."</option>\n");
  }
  ?>
</select>
<select name="eYear" id="select3">
  <?php
  for($i=2000;$i<=2010;$i++)
  {
    echo("<option value=$i");
	if($eYear==$i){echo(" selected");}
	echo(">$i</option>\n");
  }
  ?>
</select> 
<input name="period_to" type="hidden" value="<?php echo($period_to);?>" size="10"> 
<input type="submit" value="Выбрать">
<input name="title" type="hidden" id="title" value="<?php echo($title);?>">
<input name="where" type="hidden" id="where" value="<?php echo($where);?>"></td></tr></form></table>
<?php
}?>
<table width="100%" cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#CCFFCC">
    <td height="19" align="center"><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_zakaz.number");?>">ID</a></td>
    <td align="center" nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_zakaz.data");?>">Заявл.</a></td>
    <td nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_zakaz.data_to");?>">Срок</a></td>
    <td nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_zakaz.email");?>">Заказчик</a></td>
    <td nowrap colspan="2"><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_user.login");?>">Автор</a></td> 
    <td nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_works.tip");?>">Тип.</a></td>
    <td width="100%" nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_works.name");?>">Тема</a></td>
	<td nowrap><a href="applications_paid.php?where=<?php echo("$where&title=$title&order=ri_works.predmet");?>">Предмет</a></td>
	<td align="center" nowrap><a href="#">Стоим.</a></td>
    <td align="center" nowrap><a href="#">Цена</a></td>
    <td align="center" nowrap colspan="2"><a href="#">Прибыль</a></td>
  </tr>
<?php
$st_r=mysql_query("SELECT * FROM ri_zakaz_status");
$st_n=mysql_num_rows($st_r);
$old_num=0;
for($i=0;$i<$st_n;$i++)
{
  $stnum=mysql_result($st_r,$i,'number');
  $stname=mysql_result($st_r,$i,'name');
  $starray[$old_num]=$stnum;
  $starray_name[$old_num]=$stname;
  $old_num=$stnum;
}
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE  ri_zakaz.work=ri_works.number AND $loc_where $order");
//$wk_r=mysql_query("SELECT * FROM ri_works, ri_user WHERE ri_works.manager=ri_user.number AND ri_works.number=$about");
//
$zk_n=mysql_num_rows($zk_r);
for($i=0;$i<$zk_n;$i++)
{
  $zid=mysql_result($zk_r,$i,'ri_zakaz.number');
  $zdata=mysql_result($zk_r,$i,'ri_zakaz.data');
  $zdata_to=mysql_result($zk_r,$i,'ri_zakaz.data_to');
  $zuser=mysql_result($zk_r,$i,'ri_zakaz.user');
  $zemail=mysql_result($zk_r,$i,'ri_zakaz.email');
  $zsumuser=mysql_result($zk_r,$i,'ri_zakaz.summ_user');
  $zsumour=mysql_result($zk_r,$i,'ri_zakaz.summ_our');
  $zautor=mysql_result($zk_r,$i,'ri_works.manager');
  $zwork=mysql_result($zk_r,$i,'ri_works.number');
  $ztax=mysql_result($zk_r,$i,'ri_works.tax');
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$zautor");
  $us_n=mysql_num_rows($us_r);
  $uuser='';$unum='';
  if($us_n>0){
  	$uuser=mysql_result($us_r,0,'login');
	$unum=mysql_result($us_r,0,'number');
	if($uuser==''){$uuser="id $unum";}
  }
  
  $zstatus=mysql_result($zk_r,$i,'ri_zakaz.status');
  $ztip=mysql_result($zk_r,$i,'ri_works.tip');
  $tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
  $ztip_s=mysql_result($tip_r,0,'tip');
  $zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
  $zpredm_s=mysql_result($pr_r,0,'predmet');
  $ztema=mysql_result($zk_r,$i,'ri_works.name');
  $zstatus_s='';
  $zstatus_s=$starray_name[$zstatus];
  // переход к кассовой книге go2statusChanged ($zid,$where,$title)'
  echo("<tr bgcolor='#FFFFFF'>
  <td align='center'>
  <a href=\"javascript: ChangeStatus($zid, '$where', '$title');\" title='Изменить текущий статус работы на `$zstatus_s`'>$zid</a>
  </td>
  <td align='center' nowrap>".rustime($zdata)."</td>
  <td nowrap>".rustime($zdata_to)."</td>
  <td nowrap align='right'>
  ");
  if(trim($zuser)==''){echo("?");}else{echo("<b>$zuser</b> [$zemail]");}
  echo("<span class='red'><b>+</b></span><a href='new_mess.php?resp=zakaz&about=$zid' title='Послать сообщение'><img src='../images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle' style='background-color:yellow'></a>
  </td>
  <td nowrap align='center'>");
  //if(trim($zautor)==''){echo("?");}else{echo("$zautor");}
  echo("<a href='personal_data.php?unum=$unum'>$uuser</a>
  </td>
  <td align='center' bgColor=''><a href='new_mess.php?resp=autor&about=$zwork' title='Отправить сообщение автору по этой работе'><span class='red'><b>+</b></span><img src='../images/pyctos/develope.gif' width='18' height='10' hspace='2' border='0' align='absmiddle' style='background-color:ccffff'></a></td>
  <td nowrap>$ztip_s</td>
  <td width='100%'>
  <a href='zakaz_datas.php?znum=$zid&ret=applications_paid.php?title=$title{and}where=%20AND%20ri_zakaz.status=$zstatus' class='green'>$ztema</a>
  </td>
  <td nowrap>$zpredm_s</td>
  <td align=right>");
  if($where==' AND ri_zakaz.status=5')
  {
    $ks_r=mysql_query("SELECT SUM(summ) AS AllMoney FROM ri_kassa WHERE person<>1 AND zakaz=$zid");
    $AllMoney=mysql_result($ks_r,0,'AllMoney');
	//так же надо учитывать скидки
	$hl=HalyvaPercent($zautor);
	if($hl[0]==1)
	{
	  $AllMoney=Round($ztax*(1-$hl[1]/100))-$AllMoney;
	}
	else
	{
	  $AllMoney=$ztax-$AllMoney;
	}
    $title="Нужно выплатить автору $AllMoney рублей";
  }
  echo("<a href='money_transaction.php?znum=$zid&inflag=prih'>$zsumuser</a>
  </td>
  <td align=right>
  <a href='money_transaction.php?znum=$zid&inflag=rash' title='$title'>$zsumour</a>
  </td>
  <td nowrap align='right'>");
  $ourprofit=($zsumuser-$zsumour);
  $pp=100;
  if($zsumour!=0){$pp=round($ourprofit*100/$zsumour);}
  echo("<span style='color:red;font-weight:600'>$ourprofit</span></td><td nowrap align='right'>$pp%</td>
  </tr>");
}
?>
</table>
</body>
</html>
<?php
}//end work
?>