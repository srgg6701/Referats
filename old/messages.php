<?php
session_start();
require('file:///D|/AppServ/www/connect_db.php');
require('file:///D|/AppServ/www/access.php');
require('file:///D|/AppServ/www/lib.php');

if(access($S_NUM_USER, 'rigths_adm')){//начало разрешения работы со страницей

if($fl=='archive')
{
  for($i=0;$i<21;$i++)
  {
    if($mess_sel[$i]>0)
	{
	  mysql_query("UPDATE ri_mess SET status=-1 WHERE number=$mess_sel[$i]");
	}
  }
}

if($fl=='delete')
{
  for($i=0;$i<21;$i++)
  {
    if($mess_sel[$i]>0)
	{
	  mysql_query("DELETE FROM ri_mess WHERE number=$mess_sel[$i]");
	}
  }
}

if($fl=='filter')
{
  $S_F_MESS='';
  if($input=='on'){$S_F_MESS=$S_F_MESS.'1;';}else{$S_F_MESS=$S_F_MESS.'0;';}
  if($output=='on'){$S_F_MESS=$S_F_MESS.'1;';}else{$S_F_MESS=$S_F_MESS.'0;';}
  if($autors=='on'){$S_F_MESS=$S_F_MESS.'1;';}else{$S_F_MESS=$S_F_MESS.'0;';}
  if($zakazs=='on'){$S_F_MESS=$S_F_MESS.'1;';}else{$S_F_MESS=$S_F_MESS.'0';}
}
//настройка фильтра
if($status==-1)
{$where='WHERE status=-1 ';}
else
{$where='WHERE status>=0 ';}
$wstr=explode(';',$S_F_MESS);
if($wstr[0]=='1' && $wstr[1]!='1'){$where=$where.' AND ri_mess.to_user=1';}
if($wstr[1]=='1' && $wstr[0]!='1'){$where=$where.' AND ri_mess.to_user<>1';}

if($wstr[2]=='1' && $wstr[3]!='1'){$where=$where.' AND (ri_mess.to_user<>0 AND ri_mess.from_user<>0)';}
if($wstr[3]=='1' && $wstr[2]!='1'){$where=$where.' AND (ri_mess.to_user=0 OR ri_mess.from_user=0)';}

//echo("status='$status'<br>");
if(isset($linking)){$where=$where." AND ri_mess.zakaz=$linking";}
if(isset($status) && $status=='0'){$where=$where." AND ri_mess.status=$status";}
if(isset($status) && $status=='1'){$where=$where." AND ri_mess.status<=$status";}
if(isset($status) && $status=='2'){$where=$where." AND ri_mess.status=$status";}
$where=$where." AND ((ri_mess.direct='0' AND ri_mess.to_user=1) OR (ri_mess.direct='1' AND ri_mess.from_user=1))";
//if(isset($status) && $status!='' && $status!=-1){$where=$where." AND ri_mess.status=$status";}

$plen=20;
$ms_r=mysql_query("SELECT * FROM ri_mess $where");
//echo("SELECT * FROM ri_mess $where<br>");
$ms1_n=mysql_num_rows($ms_r);
if(isset($command))
{
  if($command=='prev')
  {
    $S_PAGE1=$S_PAGE1-$plen;
	if($S_PAGE1<0){$S_PAGE1=0;}
  }
  if($command=='next')
  {
    $S_PAGE1=$S_PAGE1+$plen;
	if($S_PAGE1>$ms1_n){$S_PAGE1=$ms1_n-$plen+1;}
	if($S_PAGE1<0){$S_PAGE1=0;}
  }
}
//if($command=='prev'){$S_PAGE1=$S_PAGE1-$plen;}
//if($command=='next'){$S_PAGE1=$S_PAGE1+$plen;}
//while($S_PAGE1>$ms1_n){$S_PAGE1=$S_PAGE1-$plen;}
//if($S_PAGE1<0){$S_PAGE1=0;}
$ms_r=mysql_query("SELECT * FROM ri_mess $where ORDER BY number DESC LIMIT $S_PAGE1,$plen");
$ms_n=mysql_num_rows($ms_r);
?>
<html>
<head>
<title>Сообщения</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="../admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="file:///D|/AppServ/www/colorize_row.js">
</script>
<script language="JavaScript" type="text/JavaScript">
if (location.href.indexOf('autor2')!=-1)alert ('У вас нет новых сообщений');

function setfilter()
{
  form_ml.fl.value='filter';
  form_ml.submit();
}
</script>
<script language="JavaScript" type="text/JavaScript" src="file:///D|/AppServ/www/check_all_boxes.js"></script>
</head>
<body topmargin="0" marginheight="0"><? require ("../temp_transparency.php");?><form name="form_ml" action="messages.php" method="post">
<?php 
if ($status==-1) {$button_place1='passive';$button_place2='active';$button_bg2='#eeeeee';$button_bg1='#cccccc';} 
else {$button_place1='active';$button_place2='passive';$button_bg1='#eeeeee';$button_bg2='#cccccc';}
?>
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2"><b>Сообщения:</b>&nbsp;&nbsp;</td>
    <td rowspan="2"><img src="../images/interface/button_<?php echo ($button_place1); ?>_left.gif" width="11" height="24"></td>
    <td rowspan="2" align="center" nowrap bgcolor="<?php echo ($button_bg1); ?>" style="padding:0px 8px 0px 8px"><a href="messages.php?status=<?php echo("$last_status&input=$input&output=$output&fl=$fl&autors=$authors");?>" style="text-decoration:none"><strong>текущие</strong></a></td>
    <td rowspan="2"><img src="../images/interface/button_<?php echo ($button_place1); ?>_right.gif" width="11" height="24"></td>
    <td><img src="file:///D|/AppServ/www/images/spacer.gif" width="2" height="10"></td>
    <td rowspan="2"><img src="../images/interface/button_<?php echo ($button_place2); ?>_left.gif" width="11" height="24"></td>
    <td rowspan="2" align="center" nowrap bgcolor="<?php echo ($button_bg2); ?>" style="padding:0px 8px 0px 8px"><a href="messages.php?status=-1<?php echo("&input=$input&output=$output&fl=$fl&autors=$authors&last_status=$status");?>" style="text-decoration:none"><strong>архив</strong></a></td>
    <td rowspan="2"><img src="../images/interface/button_<?php echo ($button_place2); ?>_right.gif" width="11" height="24"></td>
    <td width="100%"><img src="file:///D|/AppServ/www/images/spacer.gif" width="11" height="10"></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><img src="file:///D|/AppServ/www/images/spacer.gif" width="10" height="14"></td>
    <td bgcolor="#CCCCCC"><img src="file:///D|/AppServ/www/images/spacer.gif" width="10" height="14"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#EEEEEE">
    <td colspan="9"><table width="85%" cellpadding="0"  cellspacing="0">
      <tr>
        <td align="center" nowrap>Статус: </td>
        <td nowrap><select name="select" onChange="if (this.options[2].selected||this.options[1].selected) {document.form_ml.output.checked=false; document.form_ml.input.checked=true; document.form_ml.output.disabled=true}; else document.form_ml.output.disabled=false; document.form_ml.status.value=this.options[selectedIndex].value;">
            <option value="-1" <?php if($status==-1){echo("selected");}?>>Все</option>
            <option value="1" <?php if($status==1){echo("selected");}?>>Неотвеченые</option>          
		    <option value="0" <?php if($status==0){echo("selected");}?>>Новые</option>
        </select></td>
        <td align="center" nowrap><img src="file:///D|/AppServ/www/images/arrows/arrow_sm_down_green.gif" width="14" height="12" hspace="0" vspace="0" border="1" align="absmiddle">
          <input name="input" type="checkbox" class="checkboxFilter" id="input" value="on" <?php if($wstr[0]=='1'){echo('checked');}?>>
Входящие&nbsp;&nbsp;&nbsp;  <img src="file:///D|/AppServ/www/images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="0" vspace="0" border="1" align="absmiddle">
  <input name="output" type="checkbox" class="checkboxFilter" id="output" value="on" <?php if($wstr[1]=='1'){echo('checked');}?>>
Исходящие</td>
        <td align="center" nowrap><table width="100%"  cellspacing="0" cellpadding="2" style="border:solid 1px #cccccc">
          <tr>
            <td align="center" nowrap bgcolor="#B2E6E6"><input name="autors" type="checkbox" class="checkboxFilter" id="autors" value="on" <?php if($wstr[2]=='1'){echo('checked');}?>>
    Авторы </td>
            <td align="center" nowrap bgcolor="#FCFCE7"><input name="zakazs" type="checkbox" class="checkboxFilter" id="zakazs" value="on" <?php if($wstr[3]=='1'){echo('checked');}?>>
    Заказчики</td>
            <td align="center" nowrap bgcolor="#FFFF00"><input name="clients" type="checkbox" class="checkboxFilter" id="clients" value="on">
    Клиенты</td>
          </tr>
        </table></td>
        <td align="center" nowrap><input type="button" name="Submit2" value="Отфильтровать" onClick="javascript: setfilter();"></td>
      </tr>
    </table>
            <input name="status" type="hidden" id="status" value="<?php echo($status);?>">            </td>
    </tr>
  <tr>
    <td bgcolor="#CCFFCC"><a href="#"><b>Дата</b></a></td>
    <td align="center" bgcolor="#CCFFCC" style="padding:0px">Время</td>
<!--    <td align="center" nowrap bgcolor="#CCFFCC"><a href="#"><b>ID</b></a></td>-->
    <td align="center" nowrap bgcolor="#CCFFCC"><table cellpadding="2"  cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td nowrap bgcolor="#FFFFFF"><img src="file:///D|/AppServ/www/images/arrows/arrow_sm_down_green.gif" width="14" height="12"><img src="file:///D|/AppServ/www/images/arrows/arrow_sm_up_blue.gif" width="14" height="12"></td>
      </tr>
    </table>
      </td>
    <!--<td nowrap bgcolor="#CCFFCC"><a href="#"><b>Респондент</b></a></td>-->
    <td align="center" nowrap bgcolor="#CCFFCC"><a href="#"><b>Респ-т.</b></a></td>
    <td width="70%" bgcolor="#CCFFCC"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td nowrap><a href="#"><b>Тема сообщения/работы</b></a></td>
        <td width="100%" align="center"><table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="50%" align="right" nowrap><?php if($S_PAGE1>=$plen){echo("<a href=messages.php?command=prev&fl=$fl&input=$input&output=$output&autors=$autors&zakazs=$zakazs&status=$status><img src='../images/arrows/to_left.gif' align='absmiddle' border='1'>  предыдущие</a>");}?></td>
            <td align="center" nowrap><?php if($ms1_n>$plen){ echo("&nbsp;&nbsp;".($S_PAGE1+1)."&nbsp;&nbsp;");}?></td>
            <td width="50%" nowrap><?php if($S_PAGE1+$plen<$ms1_n){echo("<a href=messages.php?command=next&fl=$fl&input=$input&output=$output&autors=$autors&zakazs=$zakazs&status=$status>следующие <img src='../images/arrows/to_right.gif' align='absmiddle' border='1'></a>");}?></td>
          </tr>
        </table></td>
      </tr>
    </table>      </td>
	<td align="center" bgcolor="#CCFFCC">Статус</td>
    <td align="center"><!-- #BeginLibraryItem "/Library/check_all_boxes.lbi" -->
      <input type="checkbox" name="checkbox" value="checkbox" onClick="checkAllBoxes()">
    <!-- #EndLibraryItem -->
      <!-- <img src="../images/prioritet10.gif" width="8" height="8" border="1"> --></td>
    </tr>
<?php
for($i=0;$i<$ms_n;$i++)
{
  $mnum=mysql_result($ms_r,$i,'number');
  $mdata=rustime(mysql_result($ms_r,$i,'data'));
  $mzakaz=mysql_result($ms_r,$i,'zakaz');
  $mtimer=mysql_result($ms_r,$i,'timer');
  $mfrom=mysql_result($ms_r,$i,'from_user');
  $mto=mysql_result($ms_r,$i,'to_user');
  $mdirect=mysql_result($ms_r,$i,'direct');
  $memail=mysql_result($ms_r,$i,'email');
  $msubj=mysql_result($ms_r,$i,'subj');
  $mmess=rawurldecode(mysql_result($ms_r,$i,'mess'));
  $mstatus=mysql_result($ms_r,$i,'status');
  $str_status='';
  if($mzakaz+1-1>0)
  {
    $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$mzakaz");
    $zk_n=mysql_num_rows($zk_r);
	if($zk_n>0)
	{
	  $zstatus=mysql_result($zk_r,0,'status');
      $zst_r=mysql_query("SELECT * FROM ri_zakaz_status WHERE number=$zstatus");
      $zst_n=mysql_num_rows($zst_r);
      if($zst_n>0){$str_status=mysql_result($zst_r,0,'name');}
	}
  }
  //определяем респондента
  if($mfrom>1){$resp=$mfrom;}
  if($mto>1){$resp=$mto;}
  if($mfrom<2 && $mto<2)
  {
    //респондент - заказнический
	$resp=$memail;
	$stat='Заказчик';
  }
  else
  {
    //респондент - авторский
	$stat='Автор';
	$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$resp");
	$us_n=mysql_num_rows($us_r);
	$resp='';
	if($us_n>0){$resp=mysql_result($us_r,0,'family');}
  }
  $bgc='#FFFFFF';
  $picdirect='../images/arrows/arrow_sm_down_green.gif';
  if($msubj==''){$ts="&lt;без темы&gt;";}else{$ts=$msubj;}
  if($mstatus==1 || $mstatus==0){$picdirect='../images/arrows/unanswered.gif';}
  if($mfrom==1){$bgc='#CCFFFF'; $picdirect='../images/arrows/arrow_sm_up_blue.gif'; }
	echo("<tr bgcolor=$bgc>
    <td>$mdata</td>
	<td align='center'>$mtimer</td>
    <!--<td align=center>$mnum</td>
    <td nowrap>$resp</td>-->
    <td align='center'><img src=$picdirect align='absmiddle' border=1 hSpace=4></td><td align='center'>$stat</td>
    <td><a href='view_mess.php?mnum=$mnum&status=$mstatus'>");
  if($mstatus==0 && $mto==1){echo("<span style='color:red'><b>$ts</b></span>");}
  if($mstatus==1 && $mto==1){echo("<span style='color:red'>$ts</span>");}  
  if($mstatus==2 || $mfrom==1){echo($ts);}
  echo("</a></td><td>$str_status</td>
  <td align=center><input type=checkbox class='checkbox' name=mess_sel[$i] value=$mnum><script language='JavaScript'>arCheckboxes[$i]='mess_sel[$i]'</script>
</td>
</tr>");
}
?>
</table>
<div align="right" class="topPad6"><table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="center"><table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="50%" align="right" nowrap><?php if($S_PAGE1>=$plen){echo("<a href=messages.php?command=prev&fl=$fl&input=$input&output=$output&autors=$autors&zakazs=$zakazs&status=$status><img src='../images/arrows/to_left.gif' align='absmiddle' border='1'>  предыдущие</a>");}?></td>
        <td align="center" nowrap><?php if($ms1_n>$plen){ echo("&nbsp;&nbsp;".($S_PAGE1+1)."&nbsp;&nbsp;");}?></td>
        <td width="50%" nowrap><?php if($S_PAGE1+$plen<$ms1_n){echo("<a href=messages.php?command=next&fl=$fl&input=$input&output=$output&autors=$autors&zakazs=$zakazs&status=$status>следующие <img src='../images/arrows/to_right.gif' align='absmiddle' border='1'></a>");}?></td>
      </tr>
    </table></td>
    <td nowrap><input name="fl" type="hidden" id="fl">Отмеченные сообщения:
<input type="button" name="Submit" value="Удалить из БД" style="color:#FF0000;font-weight:700" onClick="delSelect(document.form_ml,'fl','delete');">
<input type="button" name="Submit" value="Переместить в архив" onClick="delSelect(document.form_ml,'fl','archive');">
</td>
  </tr>
</table>

</div>
</form>
</body>
</html>
<?php
}//end work
?>