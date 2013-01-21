<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
require('../access.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);

if ($change_status&&$znumber)
  { mysql_query("UPDATE ri_zakaz SET status = $change_status WHERE number = $znumber");//изменяем статус записи в таблице заказов
  }

if($fl=='new_search')
{
  //echo("make_find($referat_subj, \"WHERE ri_works.enable='Y'\");");
  if($find_type=='subj' || !isset($find_type)) make_find($referat_subj, "WHERE ri_works.enable='Y'");
  else make_find_by_id($referat_subj);
}
$sid=session_id();
$where=' AND ( ri_works.tip=0';
if($diplom=='on'){$where=$where." OR ri_works.tip=3";}
if($curs=='on'){$where=$where." OR ri_works.tip=2";}
if($referat=='on'){$where=$where." OR ri_works.tip=1";}
if($other=='on'){$where=$where." OR ri_works.tip>3";}
$where=$where." )";

$sc_r=mysql_query("SELECT * FROM ri_rating, ri_works, ri_zakaz, ri_zakaz_status 
					WHERE ri_rating.work=ri_works.number 
					AND ri_rating.sessionid='$sid' 
					AND ri_zakaz_status.number = ri_zakaz.status 
					AND ri_works.number = ri_zakaz.work 
					$where 
					ORDER BY ri_rating.wordindex DESC, ri_works.name");
$sc_n=mysql_num_rows($sc_r);
?>
<html>
<head>
<TITLE>Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ рефераты</TITLE>
<meta name="description" content="Банк рефератов, курсовых, дипломных работ. Готовые работы, дипломы на заказ.">
<meta name="keywords" content="банк рефератов, курсовая, диплом, реферат, курсовые, диплом на заказ, курсовая работа на тему, купить диплом, курсовая по, реферат на тему, менеджмент, право, экологии, экономике, политологии, финансы, педагогика, рефераты и курсовые, психология, коллекция рефератов, социология, дипломная, коллекция рефератов, диссертация, ОБЖ, география, иностранные языки, литература, социология, физика, химия, философия">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="../referats.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<script language="JavaScript" type="text/javascript">
function changeStatus(wnum,znumber) {
var zkz=document.getElementById('status_'+znumber);
if (confirm('Подтвердить изменение статуса?'))
  {  location.href='search_list.php?znumber='+znumber+'&change_status='+zkz.options[zkz.selectedIndex].value;
  }
}
</script>

</head>
<body onLoad="MM_preloadImages('../../images/pyctos/account2_over.gif','../../images/pyctos/cooperation_over.gif','../../images/pyctos/faq_over.gif','../../images/pyctos/agreement_over.gif','../../images/pyctos/useful_over.gif','../../images/pyctos/feedback_over.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--; border-top:solid 3px #ff0000-->
    <td style="border-bottom:dotted 1px #ff0000"><img src="../../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
<td style="padding: 10px"><h1 class="header6bottom"><b>Результат поиска работы:</b></h1>
      <table width="100%" cellpadding="4"  cellspacing="1" bgcolor="#CC0000">
      <tr class="arial">
        <td height="26" background="../../images/pyctos-bg-1.gif"><b>Тип</b></td>
        <td background="../../images/pyctos-bg-1.gif"><b>Предмет</b></td>
        <td width="100%" background="../../images/pyctos-bg-1.gif"><b>Тема</b></td>
        <td nowrap background="../../images/pyctos-bg-1.gif"><strong>Текущий статус заказа </strong></td>
      </tr>
      <?php
for($i=0;$i<$sc_n;$i++)
{
  $wnum=mysql_result($sc_r,$i,'ri_works.number');
  $wname=mysql_result($sc_r,$i,'ri_works.name');
  $wpredmet=mysql_result($sc_r,$i,'ri_works.predmet');
  $wtip=mysql_result($sc_r,$i,'ri_works.tip');
  $znumber=mysql_result($sc_r,$i,'ri_zakaz.number');
  $pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredmet");
  $str_predmet=mysql_result($pr_r,0,'predmet');
  $tp_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $str_tip=mysql_result($tp_r,0,'tip');
  ?><tr bgcolor=#FFFFFF>
      <td nowrap><? echo($str_tip);?></td>
      <td nowrap><? echo($str_predmet);?></td>
      <td><a href='adm_works_ed.php?wnum=<? echo($wnum);?>&ret=worx.php'><? echo($wname);?></a></td>
	  <td nowrap><select name="status_<?php echo ($znumber); ?>" id="status_<?php echo ($znumber); ?>">
<?php $tStts=mysql_query("SELECT number, name FROM ri_zakaz_status"); 
		$tStn=mysql_num_rows($tStts);
		if ($tStn)
		  {  for ($stn=0;$stn<$tStn;$stn++)
				{   $st_number=mysql_result($tStts,$stn,'number');
  					$st_name=mysql_result($tStts,$stn,'name');?>
					<option value="<?php echo ($st_number); ?>"><?php echo ($st_name); ?></option>
					<?
				}
		  }
 ?>	</select>
	    <img src="../../images/submit_green.gif" width="16" height="16" onClick="changeStatus(<?php echo ($wnum.",".$znumber); ?>);"></td>
      </tr><?
}
?>
    </table>
      <form action="../search_list.php" method="post" name="search_form" style="padding-top:0; margin-top:10px">
        <b>Новый поиск:</b>        
        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td nowrap><strong>
              <input name="diplom" type="checkbox" id="diplom" value="on" checked>
        Диплом</strong></td>
            <td nowrap><strong>
              <input name="curs" type="checkbox" id="curs" value="on" checked>
        Курсовая</strong></td>
            <td nowrap><strong>
              <input name="referat" type="checkbox" id="referat" value="on" checked>
        Реферат</strong></td>
            <td nowrap><input name="other" type="checkbox" id="other" value="on" checked>
        Другое
          <input name="fl" type="hidden" id="fl" value="new_search"></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%"><input name="referat_subj" type="text" class="cells" id="referat_subj2" style="width:100%"></td>
            <td align="center"><input type="submit" name="Submit" value="Найти!">
                <!-- onClick="sendOrder('реферат','referat_subj');"> -->
            </td>
          </tr>
        </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>
