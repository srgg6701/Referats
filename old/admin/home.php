<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
session_register('S_LIST_PAGE');
session_register('S_F_ALL');
session_register('S_F_REF');
session_register('S_F_KUR');
session_register('S_F_DIP');
$S_F_ALL='on';
$S_F_REF='on';
$S_F_KUR='on';
$S_F_DIP='on';
session_register('S_PREDMET_NUM');
if(!isset($S_PASSLOH))
{
  session_register('S_PASSLOH');
  $S_PASSLOH='';
  session_register('S_PAY_TIP');
  $S_PAY_TIP='';
}
session_register('S_ZAKAZ_NUM');
$S_ZAKAZ_NUM=0;
session_register('S_WORK_NUM');
$S_WORK_NUM=0;
session_register('S_ZK_SUMM');
$S_ZK_SUMM=0;
session_register('S_RAD_ORDER');
$S_RAD_ORDER='name';
if($flag_res=='Y')
{
  $S_PASSLOH=''; write_conf('adm_config.php');
  session_register('S_PASSLOH');
  $S_PASSLOH='';
  session_register('S_PAY_TIP');
  $S_PAY_TIP='';
}

$us_r=mysql_query("SELECT * FROM ri_user");
$us_n=mysql_num_rows($us_r);
for($j=0;$j<$us_n;$j++)
{
  $kolvo_primerno=$kolvo_primerno+mysql_result($us_r,$j,'howmach');
}

$wk_r=mysql_query("SELECT * FROM ri_works");
$wk_all=mysql_num_rows($wk_r);
$wk_r=mysql_query("SELECT * FROM ri_works WHERE enable='N'");
$wk_new=mysql_num_rows($wk_r);

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE ri_mess.to_user=1 AND ri_mess.status=0 AND ((ri_mess.direct='0' AND ri_mess.to_user=1) OR (ri_mess.direct='1' AND ri_mess.from_user=1))");
$ms_new=mysql_num_rows($ms_r);
$ms_r=mysql_query("SELECT * FROM ri_mess WHERE ri_mess.to_user=1 AND ri_mess.status=1 AND ((ri_mess.direct='0' AND ri_mess.to_user=1) OR (ri_mess.direct='1' AND ri_mess.from_user=1))");
$ms_not=mysql_num_rows($ms_r);

$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE status=1 AND ri_zakaz.work=ri_works.number");
$zk_new=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE status=2 AND ri_zakaz.work=ri_works.number");
$zk_opl=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE status=4 AND ri_zakaz.work=ri_works.number");
$zk_post=mysql_num_rows($zk_r);
?>
<html>
<head>
<title><MMString:LoadString id="insertbar/linebreak" /></title>
<link href="admin.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../../rollovers.js"></script>
<style type="text/css">
<!--
.stat {	padding: 4px;
}
-->
</style>
</head>
<body>
<!-- MENU-LOCATION=NONE -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
	  <table cellpadding="2" cellspacing="1" bgcolor="#cccccc">
  		<tr bgcolor="#e4e4e4">
			<td nowrap>Всего работ: [<?php echo($wk_all);?>] Неделю назад: [] ( + ...) </td>
			<td>Колич.</td>
		</tr>
        <?php
$kolvo_primerno=0;
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY sort, predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  $psort=mysql_result($pr_r,$i,'sort');
  	  ?><tr bgColor='#ffffff'>
  	      <td nowrap><a href='../worx.php?pnum=<? echo($pnum);?>'<? 
  if($psort==9)
  {
    $p0=strpos($ppredmet,'>');
    $ppredmet=substr($ppredmet,$p0+1,9999);
    $p0=strpos($ppredmet,'<');
    $ppredmet=substr($ppredmet,0,$p0);
  }
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE predmet=$pnum AND enable='Y'");
  $wk_n=mysql_num_rows($wk_r);
  ?>><? echo($i+1); echo($ppredmet);?></a></td>
  	      <td align='right'>$wk_n</td>
	    </tr><? } ?>
      </table>
    </td>
    <td valign="top" width="100%" style="padding:10px 10px 0px 10px">
	  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="bottom" nowrap style="padding-top:10px"><img src="../../images/angel_red.gif" width="113" height="140" hspace="10" vspace="0"></td>
          <td valign="top"><h2 style="color:#CC0000; padding:6px 0px 0px 0px;"><span class="red">Admin</span>.Home</h2>
            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>Здесь будет девиз Админа! :)</td>
              </tr>
              <tr align="right">
                <td valign="bottom"><span class="red">...с течением времени</span>, &#8212; как говорил товарищь О. Бендер :) </td>
              </tr>
              <tr>
                <td valign="bottom"><hr size="1" noshade color="#FF9900"></td>
              </tr>
              <tr>
			<form action="search_list.php" method="post">
                <td height="80" style="padding-left:20px"><h5>Искать по <input type="radio" name="find_type" value="subj" checked>теме <input type="radio" name="find_type" value="id"> Id</h5><h5>Поиск работы в БД <img src="../../images/arrows/arrow_sm_down_blue.gif" width="16" height="15" hspace="2" border="1" align="absmiddle">&nbsp;&nbsp;</h5>
                <INPUT class=cells id="referat_subj" style="WIDTH: 100%" name="referat_subj">
                  <table width="100%" height="25" border="0" cellpadding="2" cellspacing="0">
                    <tr valign="bottom">
                      <td valign="bottom" nowrap><input name="diplom" type="checkbox" class="checkbox" id="diplom" value="on" checked>
      Диплом</td>
                      <td valign="bottom" nowrap><input name="curs" type="checkbox" class="checkbox" id="curs" value="on" checked>
      Курсовая</td>
                      <td valign="bottom" nowrap><input name="referat" type="checkbox" class="checkbox" id="referat" value="on" checked>
      Реферат</td>
                      <td valign="bottom" nowrap><input name="other" type="checkbox" class="checkbox" id="other" value="on" checked>
      Другое</td>
                      <td width="100%" nowrap><input type="submit" name="Submit" value="Найти!">
                        <!-- onClick="sendOrder('реферат','referat_subj');"> -->
                        <input name="fl" type="hidden" id="fl" value="new_search"></td>
                    </tr>
                  </table>
			    </td>
			</form>
              </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding-top:10px">
	    	<table align="left" cellpadding="0" cellspacing="0">
			  <tr>
			    <td valign="top" bgcolor="#00FF00"><img src="../../images/corners/green_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			    <td rowspan="2" bgcolor="#00FF00"><nobr>
				<h3 class="stat"><span style="font-weight:200; color:#990000">&sect;</span> Работы </h3>
				</nobr>
				  <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#CEFFC4">
					<tr>
					  <td nowrap title="Общее количество готовых работ, которое вы указали при регистрации." style="cursor:default">&nbsp;Потенциальных</td>
					  <td align="right"><?php echo($kolvo_primerno);?></td>
					</tr>
					<tr>
					  <td><a href="worx.php?only_new=on">Новые</a></td>
					  <td align="right"><?php echo($wk_new);?></td>
					</tr>
					<tr>
					  <td><a href="worx.php?only_new=on">Неутверждённые</a></td>
					  <td align="right">&nbsp;</td>
					</tr>
					<tr>
					  <td><a href="worx.php?only_reconfirm=on">Отложенные</a></td>
					  <td align="right">&nbsp;</td>
					</tr>
				</table>
			  </td>
			  <td valign="top" bgcolor="#00FF00"><img src="../../images/corners/green_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			  <td rowspan="7"><img src="../../images/spacer.gif" width="2" height="9"></td>
			  <td valign="top" bgcolor="#99FFCC"><img src="../../images/corners/lblue_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			  <td rowspan="2" bgcolor="#99FFCC"><nobr>
				<h3 class="stat"><span style="color:#FF0000">&radic;</span> Заказы</h3>
				</nobr>
				  <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#D5FFEA">
					<tr>
					  <td><a href="applications_paid.php?title=Заявки&where= AND ri_zakaz.status=1">Заявки</a></td>
					  <td align="right"><?php echo($zk_new);?></td>
					</tr>
					<tr>
					  <td nowrap><a href="applications_paid.php?title=Заказы&where= AND ri_zakaz.status=2">Не
						  отправленные</a></td>
					  <td align="right"><?php echo($zk_opl);?></td>
					</tr>
					<tr>
					  <td nowrap><a href="applications_paid.php?title=Отосланные&where= AND ri_zakaz.status=4">Не
						  полученные </a></td>
					  <td align="right"><?php echo($zk_post);?></td>
					</tr>
					<tr>
					  <td>Проблемные</td>
					  <td align="right"><?php echo($zk_problem);?></td>
					</tr>
				  </table>
			  </td>
			  <td valign="top" bgcolor="#99FFCC"><img src="../../images/corners/lblue_right_top.gif" width="9" height="9" style="background-color:#FFFFFF "></td>
			</tr>
			<tr>
			  <td bgcolor="#00FF00">&nbsp;</td>
			  <td bgcolor="#00FF00">&nbsp;</td>
			  <td bgcolor="#99FFCC">&nbsp;</td>
			  <td bgcolor="#99FFCC">&nbsp;</td>
			</tr>
			<tr>
			  <td><img src="../../images/corners/green_left_bottom.gif" width="9" height="9"></td>
			  <td bgcolor="#00FF00"><img src="../../images/spacer.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/green_right_bottom.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/lblue_left_bottom.gif" width="9" height="9"></td>
			  <td bgcolor="#99FFCC"><img src="../../images/spacer.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/lblue_right_bottom.gif" width="9" height="9"></td>
			</tr>
			<tr>
			  <td colspan="3"><img src="../../images/spacer.gif" width="9" height="2"></td>
			  <td colspan="3"><img src="../../images/spacer.gif" width="9" height="2"></td>
			</tr>
			<tr>
			  <td valign="top" bgcolor="#33CCFF"><img src="../../images/corners/blue_left_top.gif" width="9" height="9" style="background-color:#FFFFFF "></td>
			  <td rowspan="2" bgcolor="#33CCFF"><nobr>
				<h3 class="stat"><font color="#0000FF">@</font> Сообщения</h3>
				</nobr>
				  <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#C6E7FF">
					<tr>
					  <td><a href="messages.php?status=0&fl=filter">Новые</a></td>
					  <td align="right"><?php echo($ms_new);?></td>
					</tr>
					<tr>
					  <td><a href="messages.php?status=1&input=on&output=off&fl=filter">Неотвеченные</a></td>
					  <td align="right"><?php echo($ms_not);?></td>
					</tr>
					<tr>
					  <td nowrap>&nbsp;</td>
					  <td align="right">&nbsp;</td>
					</tr>
				</table>
			  </td>
			  <td valign="top" bgcolor="#33CCFF"><img src="../../images/corners/blue_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			  <td valign="top" bgcolor="#FFCC00"><img src="../../images/corners/orange_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			  <td rowspan="2" bgcolor="#FFCC00"><nobr>
				<h3 class="stat"><font color="#00CC00">&#8240;</font> Статистика</h3>
				</nobr>
				  <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFAB7">
					<tr>
					  <td><a href="searchers.php">Посещаемость</a></td>
					  <td align="right">&nbsp;</td>
					</tr>
					<tr>
					  <td><a href="worx.php">Всего работ</a> </td>
					  <td align="right"><?php echo($wk_all);?></td>
					</tr>
					<tr>
					  <td><a href="autors.php">Всего авторов</a> </td>
					  <td align="right"><?php echo($us_n);?></td>
					</tr>
				</table>
			  </td>
			  <td valign="top" bgcolor="#FFCC00"><img src="../../images/corners/orange_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
			</tr>
			<tr>
			  <td bgcolor="#33CCFF">&nbsp;</td>
			  <td bgcolor="#33CCFF">&nbsp;</td>
			  <td bgcolor="#FFCC00">&nbsp;</td>
			  <td bgcolor="#FFCC00">&nbsp;</td>
			</tr>
			<tr>
			  <td><img src="../../images/corners/blue_left_bottom.gif" width="9" height="9"></td>
			  <td bgcolor="#33CCFF"><img src="../../images/spacer.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/blue_right_bottom.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/orange_left_bottom.gif" width="9" height="9"></td>
			  <td bgcolor="#FFCC00"><img src="../../images/spacer.gif" width="9" height="9"></td>
			  <td><img src="../../images/corners/orange_right_bottom.gif" width="9" height="9"></td>
			</tr>
		  </table>
			<table cellspacing="0" cellpadding="10">
			  <tr>
				<td>Домашняя страница: <br>
				  <select name="select" style="font-size:100%"><!-- Учитывать факт наличия/отсутствия атрибута value. Он отсутствует у заголовков разделов-->
					<option selected value="" style="color: #cc0000">Admin.Home</option>
					<option style="background-color: #DFDDFF">--Работы--</option>
					<option value="" style="color: #9900CC">Новые</option>
					<option value="" style="color: #9900CC">Отложенные</option>
					<option style="background-color:#DEFFCE">--ЗАКАЗЫ--</option>
					<option value="" style="color:#00cc00">Заявки</option>
					<option value="" style="color:#00cc00">Не отправленные</option>
					<option value="" style="color:#00cc00">Не полученные</option>
					<option value="" style="color:#00cc00">Проблемные</option>
					<option style="background-color:#66FFFF">--Сообщения--</option>
					<option value="" style="color:#0000FF">Новые</option>
					<option value="" style="color:#0000FF">Неотвеченые</option>
					<option style="background-color:#F2DBF2">--Статистика--</option>
					<option value="" style=" color: #CC00CC">Посещаемость</option>
				  </select>
				<input type="submit" name="Submit" value="     OK     "> </td>
			  </tr>
			</table>
          </td>
        </tr>
      </table>
	</td>
  </tr>
</table>
</body>
</html>
