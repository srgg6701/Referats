<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

$filter=explode(';',$S_F_KASSA);

if($fl=='filter')
{
  $filter[0]="$bYear-$bMonth-$bDay";
  $filter[1]="$wYear-$wMonth-$wDay";
  $filter[2]=$zakazs;
  $filter[3]=$author;
  $S_F_KASSA=$filter[0].';'.$filter[1].';'.$filter[2].';'.$filter[3];
}

$where="WHERE ri_kassa.zakaz=ri_zakaz.number AND ri_zakaz.work=ri_works.number AND ri_kassa.data>='$filter[0]' AND ri_kassa.data<='$filter[1]'";
if($filter[2]>0){$where=$where." AND ri_kassa.zakaz=$filter[2]";}
if($filter[3]>0){$where=$where." AND ri_works.manager=$filter[3]";}

$ks_r=mysql_query("SELECT * FROM ri_kassa, ri_zakaz, ri_works $where");
$ks1_n=mysql_num_rows($ks_r);
if($command=='prev'){$S_PAGE4=$S_PAGE4-20;}
if($command=='next'){$S_PAGE4=$S_PAGE4+20;}
if($S_PAGE4>$ks1_n){$S_PAGE4=$ks1_n-20;}
if($S_PAGE4<0){$S_PAGE4=0;}
$ks_r=mysql_query("SELECT * FROM ri_kassa, ri_zakaz, ri_works $where LIMIT $S_PAGE4,20");
$ks_n=mysql_num_rows($ks_r);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Движение Д/С</title>
<link href="admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" cellpadding="0"  cellspacing="0">
<form name="form_filter" action="money.php" method="post">
  <tr>
    <td colspan="3" valign="top" bgcolor="#CCCCCC" style="padding:3px"><b>Движение
        Д/С за период с <?php echo(rustime($filter[0]));?> по <?php echo(rustime($filter[1]));?> </b></td>
  </tr>
  <tr>
    <td valign="top"><table cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
      <tr bgcolor="#CCFFCC">
        <td>Дата</td>
        <td align="center">Приход</td>
        <td align="center" nowrap>Расход</td>
        <td nowrap>Cчёт</td>
		<td>Заказ</td>
        <td nowrap>Примечание</td>
      </tr>
<?php
$prih_summ=0;
$rash_summ=0;
for($i=0;$i<$ks_n;$i++)
{
  $knum=mysql_result($ks_r,$i,'number');
  $kdata=rustime(mysql_result($ks_r,$i,'data'));
  $ksumm=mysql_result($ks_r,$i,'summ');
  $ktip=mysql_result($ks_r,$i,'tip');
  $kt_r=mysql_query("SELECT * FROM ri_kassa_tip WHERE number=$ktip");
  $ktip_s=mysql_result($kt_r,0,'tip');
  $kperson=mysql_result($ks_r,$i,'person');
  $kzakaz=mysql_result($ks_r,$i,'zakaz');
  $krem=mysql_result($ks_r,$i,'remark');
  if($kperson==1)
  {$prih=$ksumm;$rash='';}
  else
  {$prih='';$rash=$ksumm;}
  $prih_summ=$prih_summ+$prih;
  $rash_summ=$rash_summ+$rash;

  echo("<tr bgcolor=#FFFFFF>
<td>$kdata</td>
<td align=right>$prih</td>
<td align=right>$rash</td>
<td nowrap>$ktip_s</td>
<td nowrap><a href='zakaz_datas.php?znum=$kzakaz'>$kzakaz</a></td>
<td nowrap>$krem</td>
</tr>");
}
?>
      <tr bgcolor="#E4E4E4">
        <td><b>Всего:</b></td>
        <td align="right"><b>          <?php echo($prih_summ);?></b></td>
        <td align="right"><b><?php echo($rash_summ);?></b></td>
        <td colspan="2" align="right" nowrap><b>Прибыль за период: <?php echo($prih_summ-$rash_summ);?></b></td>
    
      </tr>
      <tr>
        <td height="30" colspan="6" align="center">
<?php
if($S_PAGE4>0){echo("<a href='money.php?command=prev'>&lt;&lt;&lt;</a> |");}
if($ks1_n>20){echo("с $S_PAGE_4 по ".($S_PAGE4+20));}
if($ks1_n>($S_PAGE4+20)){echo("| <a href='money.php?command=next'>&gt;&gt;&gt;</a>");}
?></td>
      </tr>
    </table></td>
    <td valign="top"><img src="../../images/spacer.gif" width="10" height="10"></td>
    <td width="100%" valign="top" nowrap style="padding:3px"><p>        Показать
        отчёт:<?php
$ts=$filter[0];
$bYear=$ts[0].$ts[1].$ts[2].$ts[3];
$bMonth=$ts[5].$ts[6];
$bDay=$ts[8].$ts[9];
$ts=$filter[1];
$wYear=$ts[0].$ts[1].$ts[2].$ts[3];
$wMonth=$ts[5].$ts[6];
$wDay=$ts[8].$ts[9];
?> 
          <table cellspacing="0" cellpadding="0" width="100%">
        <tr>
          <td align="right" valign="top">За период с </td>
          <td><select name="bDay" id="bDay">
            <?php
for($i=1;$i<32;$i++)
{
  echo("<option value=");
  if($i<10){echo('0');}
  echo("$i");
  if($i==$bDay){echo(" selected");}
  echo(">$i</option>");
}
?>
          </select>
            <select name="bMonth" id="bMonth">
              <?php
for($i=1;$i<=12;$i++)
{
  echo("<option value=");
  if($i<10){echo('0');}
  echo("$i");
  if($i==$bMonth){echo(" selected");}
  echo(">".rus_month($i)."</option>");
}
?>
            </select>
            <b>
            <select name="bYear">
              <?php
for($i=2004;$i<2010;$i++)
{
  echo("<option value=$i");
  if($i==$bYear){echo(" selected");}
  echo(">$i</option>");
}
?>
            </select>
            </b> </td>
        </tr>
        <tr>
          <td align="right" valign="top">по</td>
          <td><select name="wDay" id="select3">
            <?php
for($i=1;$i<32;$i++)
{
  echo("<option value=");
  if($i<10){echo('0');}
  echo("$i");
  if($i==$wDay){echo(" selected");}
  echo(">$i</option>");
}
?>
          </select>
            <select name="wMonth" id="select4">
              <?php
for($i=1;$i<=12;$i++)
{
  echo("<option value=");
  if($i<10){echo('0');}
  echo("$i");
  if($i==$wMonth){echo(" selected");}
  echo(">".rus_month($i)."</option>");
}
?>
            </select>
            <select name="wYear" id="wYear">
              <?php
for($i=2004;$i<2010;$i++)
{
  echo("<option value=$i");
  if($i==$wYear){echo(" selected");}
  echo(">$i</option>");
}
?>
            </select></td>
        </tr>
        <tr>
          <td align="right" valign="top">только для заказа номер </td>
          <td>
            <select name="zakazs" id="zakazs">
              <option value="0" selected>- Всех -</option>
            <?php
$zk_r=mysql_query("SELECT * FROM ri_zakaz ORDER BY number");
$zk_n=mysql_num_rows($zk_r);
for($i=0;$i<$zk_n;$i++)
{
  $znum=mysql_result($zk_r,$i,'number');
  echo("<option value='$znum'");
  if($znum==$filter[2]){echo(" selected");}
  echo(">$znum</option>\n");
}
		  ?>
            </select></td>
        </tr>
        <tr>
          <td align="right" valign="top">только для исполнителя номер </td>
          <td><select name="author">
            <option value="0" selected>- Всех -</option>
            <?php
$us_r=mysql_query("SELECT * FROM ri_user ORDER BY family");
$us_n=mysql_num_rows($us_r);
for($i=0;$i<$us_n;$i++)
{
  $unum=mysql_result($us_r,$i,'number');
  $ufamily=mysql_result($us_r,$i,'family');
  $ulogin=mysql_result($us_r,$i,'login');
  echo("<option value='$unum'");
  if($unum==$filter[3]){echo(" selected");}
  echo(">$unum. $ufamily ($ulogin)</option>\n");
}
		  ?>          
          </select></td>
        </tr>
      </table>
     <input type="submit" name="Submit" value="Сформировать!">
          <input name="fl" type="hidden" id="fl" value="filter">
      </p></td>
  </tr>
  </form>
</table>
<div align="right" class="topPad6"></div>
</body>
</html>
<?php
}//end work
?>