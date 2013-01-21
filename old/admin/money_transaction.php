<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE  ri_zakaz.work=ri_works.number AND ri_zakaz.number=$znum");
$zdata=mysql_result($zk_r,0,'ri_zakaz.data');
$zdata_to=mysql_result($zk_r,0,'ri_zakaz.data_to');
$zuser=mysql_result($zk_r,0,'ri_zakaz.user');
$zemail=mysql_result($zk_r,0,'ri_zakaz.email');
$zsumm_our=mysql_result($zk_r,0,'ri_zakaz.summ_our');
$wtax=mysql_result($zk_r,0,'ri_works.tax');
$zstatus=mysql_result($zk_r,0,'ri_zakaz.status');
$ztip=mysql_result($zk_r,0,'ri_works.tip');
$tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
$ztip_s=mysql_result($tip_r,0,'tip');
$zpredm=mysql_result($zk_r,0,'ri_works.predmet');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
$zpredm_s=mysql_result($pr_r,0,'predmet');
$ztema=mysql_result($zk_r,0,'ri_works.name');
$zmanager=mysql_result($zk_r,0,'ri_works.manager');

//удаление
if(isset($del))
{
  mysql_query("DELETE FROM ri_kassa WHERE number=$del");
}

//обновляем записи
$ks_r=mysql_query("SELECT * FROM ri_kassa WHERE zakaz=$znum");
$ks_n=mysql_num_rows($ks_r);
for($i=0;$i<$ks_n;$i++)
{
  $knum=mysql_result($ks_r,$i,'number');
  if(isset($money_data[$knum]))
  {
    //$kdata; $ksumm; $ktip; $krem
	mysql_query("UPDATE ri_kassa SET data='".engtime($money_data[$knum])."', summ='$money_summ[$knum]', tip=$money_tr[$knum], remark='$money_rem[$knum]' WHERE number=$knum");
  }
}

if(isset($fl) && $new_summ+1-1!=0)
{
  if($fl=='prih')
  {
    $person=1;
  }
  else
  {
    $person=$zmanager;//там автор
  }
  mysql_query("INSERT INTO ri_kassa ( person, zakaz, summ, timer, data, tip, remark ) VALUES ( $person, $znum, '$new_summ', '".date('H:i:s')."', '".date('Y-m-d')."', $new_trans, '$new_rem' )");
  if($zstatus!=5){echo("<script>location.href='money_transaction.php?znum=$znum';</script>");}
}

$ks_r=mysql_query("SELECT * FROM ri_kassa WHERE  ri_kassa.zakaz=$znum");
$ks_n=mysql_num_rows($ks_r);
$kt_r=mysql_query("SELECT * FROM ri_kassa_tip");
$kt_n=mysql_num_rows($kt_r);

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$zmanager");
$uname=mysql_result($us_r,0,'family');
$uemail=mysql_result($us_r,0,'login');
$uphone=mysql_result($us_r,0,'phone');
$umobila=mysql_result($us_r,0,'mobila');

$hl=HalyvaPercent($zmanager);
$komission=$hl[1]*$hl[0];
//echo("$komission<br>");
?>
<html>
<head>
<title>Кассовая книга</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="admin.css" rel="stylesheet" type="text/css">
<META name="ROBOTS" content="NONE">
</head>
<body topmargin="0" marginheight="0" onLoad="set_who_title(0);">
<script>
<?php
if($uname==''){$uname=$uemail;}
if($zname==''){$zname=$zemail;}
echo("uname='$uname';\nuemail='$uemail';\nuphone='$uphone';\numobila='$umobila';\nzname='$zuser';\nzemail='$zemail';\nzphone='$zphone';\nzmobila='$zmobila';\n");
?>

function set_who_title(who)
{
if(who==0)
{
  document.getElementById('who_name').innerHTML='<a href="mailto: '+zemail+'">'+zname+'</a>';
  document.getElementById('who_title').innerHTML='Заказчик';
  document.getElementById('who_phone').innerHTML=zphone;
  document.getElementById('who_mobila').innerHTML=zmobila;
}
else
{
  document.getElementById('who_name').innerHTML='<a href="mailto: '+uemail+'">'+uname+'</a>';
  document.getElementById('who_title').innerHTML='Исполнитель';
  document.getElementById('who_phone').innerHTML=uphone;
  document.getElementById('who_mobila').innerHTML=umobila;
}
}

function set_blank(t)
{
  blank='<table width=100% border=0 cellpadding=0 cellspacing=0><tr valign=top><td valign=top height=40>Сумма:<br><INPUT name=new_summ  size=4></td><td>Способ оплаты:<br><select name=new_trans><?php
for($i=0;$i<$kt_n;$i++)
{
  $ktnum=mysql_result($kt_r,$i,'number');
  $kttip=mysql_result($kt_r,$i,'tip');
  echo("<option value=$ktnum>$kttip</option>");
}
?></option></select></td></tr><tr><td colspan=2>Комментарий к оплате:<br><textarea name=new_rem style=width:100% rows=4 ></textarea><input type=hidden name=fl value='+t+'></td></tr></table>';

  if(t=='prih')
  {
    document.getElementById('blank_prih').innerHTML=blank;
    document.getElementById('blank_rash').innerHTML='';
	set_who_title(1);
  }
  else
  {
    document.getElementById('blank_prih').innerHTML='';
    document.getElementById('blank_rash').innerHTML=blank;
	set_who_title(0);
  }
}

function Submit_It()
{
<?php if($zstatus=='1'){?>
  if(confirm('Заказ оплачен полностью?'))
  {
    document.form_trans.fl_status.value='Y';
  }
  else
  {
    document.form_trans.fl_status.value='N';
  }
<?php }?>
  document.form_trans.submit();
}
</script>
<form name="form_trans" action="money_transaction.php" method="post"><img src="../../images/spacer.gif"
width="1" height="1"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6"><b>Кассовая книга (проводки) </b></td>
    </tr>
  <tr bgcolor="#f5f5f5">
    <td>ID</td>
    <td width="100%">Тема</td>
    <td><span id="who_title"></span></td>
    <td align="center" nowrap>Телефон</td>
    <td align="center" nowrap>Моб. телефон</td>
    <td align="center" nowrap>Цена<br>наша/автора</td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td><?php echo($znum)?></td>
    <td><font size="2"><a href="zakaz_datas.php?znum=<?php echo($znum);?>"><?php echo($ztema);?></a> </font></td>
    <td nowrap>
      <span id="who_name"></span></td>
    <td align="center" nowrap><span id="who_phone"></span></td>
    <td align="center" nowrap><span id="who_mobila"></span></td>
	<td align="center" nowrap><?php echo("$zsumm_our/".($zsumm_our*(100-$komission)/100));?></td>
    </tr>
</table>
<img src="../../images/spacer.gif"
 width="1" height="1"><table width=100% border=0 cellpadding=2 cellspacing=1 bgcolor='#CCCCCC'>
  					<tr>
						<td bgcolor='#FFFFFF'><a href="javascript: set_blank('prih');">Приход, всего:</a> <span id="prihod"></span></td>
  			   <td bgcolor="#E4E4E4"><a href="javascript: set_blank('rash');">Расход, всего:</a> <span id="rashod"></span></td>
  					</tr>
					<tr>
				<td bgcolor='#FFFFFF' valign='top'>
  					<table width='100%' border='0' cellpadding='2' cellspacing='1' bgColor='#cccccc'>
  					<tr>
  				<td nowrap bgColor='#F5F5F5'>Дата</td>
  				<td bgColor='#F5F5F5'>Сумма</td>
  				<td width='100%' bgColor='#F5F5F5'>Способ оплаты</td>
				<td align="center"  bgColor='#F5F5F5' class="red">Del.</td>
					</tr>
<?php
$prihod=0;
for($i=0;$i<$ks_n;$i++)
{
  $kperson=mysql_result($ks_r,$i,'ri_kassa.person');
  if($kperson==1)
  {
    $kdata=rustime(mysql_result($ks_r,$i,'ri_kassa.data'));
    $knum=mysql_result($ks_r,$i,'ri_kassa.number');
    $ksumm=mysql_result($ks_r,$i,'ri_kassa.summ');
	$prihod=$prihod+$ksumm;
    $ktip=mysql_result($ks_r,$i,'ri_kassa.tip');
    $krem=mysql_result($ks_r,$i,'ri_kassa.remark');
	echo("<tr>
		<td bgColor='#FFFFFF'><input name='money_data[$knum]' value='$kdata' size=8></td>
		<td bgColor='#FFFFFF'><input name='money_summ[$knum]' value=$ksumm size=5></td>
		<td width='100%' bgColor='#FFFFFF'><select name='money_tr[$knum]'>");
		for($j=0;$j<$kt_n;$j++)
		{
		  $ktnum=mysql_result($kt_r,$j,'number');
		  $kttip=mysql_result($kt_r,$j,'tip');
		  echo("<option value=$ktnum");
		  if($ktip==$ktnum){echo(" selected");}
		  echo(">$kttip</option>");
		}
		echo("</select>
		</td>
		<td bgColor='#FFFFFF' align='center'><a href='money_transaction.php?del=$knum&znum=$znum' style='color:red'>Del.</a></td>
		</tr>
		<tr>
		<td colSpan='4' bgColor='#F5F5F5'>Комментарий:<br>
<textarea name='money_rem[$knum]' style='width:100%' rows='3'>$krem</textarea>
		</td>
		</tr>");
  }
}
?>
</table>
		</td>
		<td valign='top' bgcolor="#E4E4E4">
 			<table width='100%' border='0' cellpadding='2' cellspacing='1' bgColor='#CCCCCC'>
				<tr>
					<td bgColor='#F5F5F5'>Дата</td>
					<td bgColor='#F5F5F5'>Сумма</td>
					<td bgColor='#F5F5F5' nowrap>Способ оплаты</td>
					<td align="center"  bgColor='#F5F5F5' class="red">Del.</td>
				</tr>
<?php
$rashod=0;
for($i=0;$i<$ks_n;$i++)
{
  $kperson=mysql_result($ks_r,$i,'ri_kassa.person');
  if($kperson!=1)
  {
    $kdata=rustime(mysql_result($ks_r,$i,'ri_kassa.data'));
    $knum=mysql_result($ks_r,$i,'ri_kassa.number');
    $ksumm=mysql_result($ks_r,$i,'ri_kassa.summ');
	$rashod=$rashod+$ksumm;
    $ktip=mysql_result($ks_r,$i,'ri_kassa.tip');
    $krem=mysql_result($ks_r,$i,'ri_kassa.remark');
	echo("<tr>
		<td bgColor='#FFFFFF'><input name='money_data[$knum]' value='$kdata' size=8></td>
		<td bgColor='#FFFFFF'><input name='money_summ[$knum]' value=$ksumm size=5></td>
		<td bgColor='#F5F5F5'><select name='money_tr[$knum]'>");
		for($j=0;$j<$kt_n;$j++)
		{
		  $ktnum=mysql_result($kt_r,$j,'number');
		  $kttip=mysql_result($kt_r,$j,'tip');
		  echo("<option value=$ktnum");
		  if($ktip==$ktnum){echo(" selected");}
		  echo(">$kttip</option>");
		}
		echo("</select>
		</td>
		<td bgColor='#FFFFFF' align='center'><a href='money_transaction.php?del=$knum&znum=$znum' style='color:red'>Del.</a></td>
		</tr>
		<tr>
		<td width='100%' bgColor='#FFFFFF' colSpan='4'>Комментарий:<br>
		<textarea name='money_rem[$knum]' style='width:100%' rows='3'>$krem</textarea></td>
		</tr>");
  }
}
?>
</table>
	</td>
		</tr>
		<tr>
	<td width='50%'  bgcolor='#FFFFFF'><span id="blank_prih"></span></td>
	<td width='50%' bgcolor="#E4E4E4"><span id="blank_rash"></span></td>
		</tr>
		<tr>
  	<td colspan="2"  bgcolor='#FFFFFF'><font size="2">Итого, маргинальная прибыль по заказу: <?php echo($prihod-$rashod);?> руб.</font></td>
    	</tr>
</table>
<?php
//проверить статус, если $fl_status=='Y', то изменить статус
if($fl_status=='Y' && $zstatus<2)
{
  zakaz_status_transmit(0, $znum, 2);
} 
//проверить статус, если выплачена цена, то считать работу оплаченной
//получить размер комиссии и воздействовать им на выплачиваемую сумму
if($rashod>=round($zsumm_our*(100-$komission)/100) && $zstatus<6)
{
  zakaz_status_transmit(0, $znum, 6);
  echo("<script>alert('Гонорар автору выплачен!'); location.href='money_transaction.php?znum=$znum';</script>");
}
?>
<script>
document.getElementById('prihod').innerHTML='<?php echo($prihod);?>';
document.getElementById('rashod').innerHTML='<?php echo($rashod);?>';
</script>
<input name="znum" type="hidden" id="znum" value="<?php echo($znum);?>">
<input name="fl_status" type="hidden" id="fl_status" value="qqq">
  <input name="Submit" type="button" class="topPad6" onClick="javascript: Submit_It();" value="Принять/Выдать">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><p><font size="2"><a href="javascript:history.back(1);">&lt; Назад</a></font> </p></td>
    <td width="100%" align="center"><font size="2">
        <!--<input type="button" name="Submit2" value="Закрыть окно!" onClick="window.opener.location.reload();self.close();">-->
    </font></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
if($inflag=='prih' || $inflag=='rash')
{
  echo("<script>set_blank('$inflag');</script>");
}
}//end works
?>