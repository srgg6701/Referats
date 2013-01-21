<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');
if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'family');

$znum=$znum+1-1;
if($znum>0)
{
  $zk_r=mysql_query("SELECT * FROM ri_zakaz, ri_works WHERE ri_zakaz.work=ri_works.number AND ri_zakaz.number=$znum");
  $zk_n=mysql_num_rows($zk_r);
  if($zk_n>0)
  {
    $ztema=mysql_result($zk_r,0,'ri_works.name');
  }
}

$wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$wnum");
$wdata=mysql_result($wk_r,0,'data');
$wtip=mysql_result($wk_r,0,'tip');
$wpredmet=mysql_result($wk_r,0,'predmet');
$wname=mysql_result($wk_r,0,'name');
$wkeywords=mysql_result($wk_r,0,'keywords');
$wtax=mysql_result($wk_r,0,'tax');
$wenable=mysql_result($wk_r,0,'enable');
$tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
$wtip_s=mysql_result($tw_r,0,'tip');
$pr_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$wpredmet");
$wpredmet_s=mysql_result($pr_r,0,'predmet');

if($fl=='send')
{
  $subj=str_replace("\\",'',$subj);
  $subj=str_replace("'","\'",$subj);
  send_intro_mess($S_NUM_USER, 1, 'admin@referats.info', $subj, $letter, $znum+1-1);
  //echo("$S_NUM_USER, 1, 'admin@referats.info', $subj, $letter, $mzakaz<hr>");
  //mail($admin_mail,"WA: $subj","От $name<hr>$letter","From: $login".chr(13).chr(10).'Reply-To: '.$login.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  echo("<script>alert('Вы отправили сообщение на тему $subj');\nlocation.href='worx.php';</script>");
}
?>
<html>
<head>
<TITLE>Сообщение по работе "<?php echo ($wname); ?>".</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<link href="autor.css" rel="stylesheet" type="text/css">
<style type="text/css">
.LR_pad {padding-left:10px; padding-right:10px}
LI {padding-right:10px;}
</style>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="send_mess" action="mess_form.php" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#FFFFFF" style="border: solid 1px #e4e4e4; padding-right:2px"><img src="../../images/outbox.gif" width="51" height="42" hspace="0" vspace="0" align="absmiddle"></td>
    <td width="100%" height="34" bgcolor="#E4E4E4" class="arial" style="font-size:80%; padding-left:4px"><strong>Сообщение по
        <?php if($znum>0)
{echo("заказу id $znum <br><span class=red style='font-size:110%'>$ztema</span>");}
else{echo("заявленной вами на утверждение работе id $wnum <br><span class=red style='font-size:110%'>$wname</span>");}?>        
        <input name="subj"  id="subj" type="hidden" value="<?php echo("Сообщение автора $name по");
			  if($znum>0){echo(" заказу '$wname'");}else{echo(" работе(id_$wnum) '$wname'");}?>">
      </strong></td>
  </tr>
</table>
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" valign="bottom"><p class="bottomPad6 green"><strong>Текст сообщения:</strong></p></td>
    <td align="center" nowrap><strong><a href="#" target="_blank">Все сообщения по этой работе</a></strong></td>
    <td width="30%" rowspan="2" align="center" valign="top" style="padding-left:6px; padding-top:6px"><table width="100%"  cellspacing="0" cellpadding="10">
        <tr>
          <td bgcolor="#FFFFCC"><span class="red"><font size="+1">Внимание!</font></span></td>
        </tr>
        <tr>
          <td bgcolor="#FFFF00"><strong>Если вы хотите задать нам вопрос, не имеющий
              отношения к какой-либо конкретной работе (например &#8212; вопрос
            технического или организационного характера ), делайте это из раздела <a href="../../autor/faq.htm#add_question">FAQ</a>.</strong></td>
        </tr>
        <tr>
          <td><strong class="green">Мы постараемся ответить вам в течение 24 часов!</strong></td>
        </tr>
        </table></td>
  </tr>
  <tr>
    <td width="70%" colspan="2"><textarea name="letter" rows="16" id="letter" style="width:100%">
	<?php
//if($znum>0)
//{echo("Заказ Id $znum, по теме &quot;$ztema&quot;.");}
//else
//{echo("Id $wnum, по предмету $wpredmet_s,\nна тему: $wname\n");}
?>
          </textarea></td>
    </tr>
</table><?php if($znum>0)
{echo('<input type="radio" name="mess_direction" value="radiobutton"> 
Администрации торговой площадки
<input type="radio" name="mess_direction" value="radiobutton">Заказчику');}
?>
<table width="100%"  cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><input name="Submit" type="submit" class="topPad6" value="Отправить сообщение!">
        <input name="fl" type="hidden" id="fl" value="send">
        <input name="wnum" type="hidden" id="wnum" value="<?php echo($wnum);?>">
        <input name="znum" type="hidden" id="znum" value="<?php echo($znum);?>"></td>
    <td width="100%" align="center">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//end work
?>