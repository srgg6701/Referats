<?php
session_start();
require('../../connect_db.php');
require('../access.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

$where=str_replace('\\','',$where);
$hs_r=mysql_query("SELECT * FROM ri_hostin $where ORDER BY Number DESC");
$err=mysql_error();
if($err!=''){
echo("SELECT * FROM ri_hostin $where ORDER BY Number DESC<br>err=$err<br>");
}
$hs_n=mysql_num_rows($hs_r);
?>
<html>
<head>
<title>Заходы на сайт</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="admin.css" rel="stylesheet" type="text/css"><META name="ROBOTS" content="NONE">
<link href="admin.css" rel="stylesheet" type="text/css">
<style>
.cells {  border: 1px #CCCCCC solid; background-color: #E6E6F2}
.cellCost {  background-color: #D3F5DD; border: #999999; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}

</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- onLoad="location.href='#bottom'"-->
<?php
for($i=0;$i<$hs_n;$i++)
{
  $hdata=mysql_result($hs_r,$i,'data');
  $htime=mysql_result($hs_r,$i,'time');
  $hpage=mysql_result($hs_r,$i,'page');
  $hhost=mysql_result($hs_r,$i,'fromhost');
  $hIP=mysql_result($hs_r,$i,'IP');
  $huser=mysql_result($hs_r,$i,'user');
  echo("<span class='cellCost'>$hdata</span>&nbsp$htime&nbsp;<a href='#' title='Сформировать отчёт по данной странице!' class='cells'>$hpage</a>&nbsp;<a href='$hhost'; target='_blank'>$hhost</a><br>\n");
}
?>
</body>
</html>
<?php
}//end work
?>