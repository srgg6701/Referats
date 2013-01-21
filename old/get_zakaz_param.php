<?php
session_start();
require('../connect_db.php');
require('lib.php');

$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$znum");
$zdata=rustime(mysql_result($zk_r,0,'ri_zakaz.data'));
$zwork=mysql_result($zk_r,0,'ri_zakaz.work');
$zdata_to=rustime(mysql_result($zk_r,0,'ri_zakaz.data_to'));
$zuser=mysql_result($zk_r,0,'ri_zakaz.user');
$zstatus=mysql_result($zk_r,0,'ri_zakaz.status');
$ztip=mysql_result($zk_r,0,'ri_works.tip');
$zname=mysql_result($zk_r,0,'ri_works.name');
$tip_r=mysql_query("SELECT * FROM ri_typework WHERE number=$ztip");
$ztip_s=mysql_result($tip_r,0,'tip');
$zpredm=mysql_result($zk_r,$i,'ri_works.predmet');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$zpredm");
$zpredm_s=mysql_result($pr_r,0,'predmet');
$ztema=mysql_result($zk_r,0,'ri_works.name');
$zs_r=mysql_query("SELECT * FROM ri_zakaz_status WHERE number=$zstatus");
$zstatus_str=mysql_result($zs_r,0,'name');

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body><? require ("../temp_transparency.php");?>
<script>
parent.visual_param(<?php echo("'$zdata', '$zdata_to', '$zuser', $zstatus, '$ztip_s', '$zpredm_s', '$zs_r', '$zname', $znum");?>);
</script>
</body>
</html>
