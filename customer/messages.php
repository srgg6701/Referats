<table border="1" cellspacing="0" rules="rows" id="tbl_customer">
  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale cellPassive bold" id="first">
    <td align="center" bgcolor="#003399" title="id сообщения">#</td>
    <td align="center" bgcolor="#003399" style="cursor:default;" title="id заказа"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle_inverted.png" /></td>
    <td nowrap="nowrap" bgcolor="#003399">Дата/время</td>
    <td align="center"><img title="Направление сообщения" src="<?=$_SESSION['SITE_ROOT']?>images/mail_directions_inverted.png" width="22" height="16" /></td>
    <td nowrap="nowrap" bgcolor="#003399">Кому</td>
    <td width="100%" nowrap="nowrap" bgcolor="#003399">Тема сообщения</td>
    <td align="right" nowrap="nowrap" bgcolor="#003399"><a href="#message_start" onClick="addOrderNote('messages','');" title="Отправить сообщение администрации Referats.info"><img src="<?=$_SESSION['SITE_ROOT']?>images/plus.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Новое сообщение</a></td>
  </tr>
<? $Worx->trNote(6);

$count=1;
//
while ($arr = mysql_fetch_assoc($rSelMess)) { ?>

  <tr>
    <td align="right"><?=$arr['number']?></td>
    <td align="right"><?=$arr['ri_basket_id']?></td>
    <td nowrap="nowrap"><?
	
	$Tools->dtime($arr['datatime']);
	
	
	?></td>
    <td align="center"><?
    
	if ($arr['receiver_user_type']=="customer"){?><img src="<?=$_SESSION['SITE_ROOT']?>images//arrow_inbox.gif" width="9" height="9" /><? }else{?><img src="<?=$_SESSION['SITE_ROOT']?>images//arrow_outbox.gif" width="9" height="9" /><? }
	
	?></td>
    <td nowrap="nowrap"><?
		switch ($arr['receiver_user_type'])  { 

    	case "customer":
  	  		?><img src="<?=$_SESSION['SITE_ROOT']?>images//user_small.png" width="14" height="16" align="absmiddle" /> Мне<?
	    		break;

		case "author":
			?><img src="<?=$_SESSION['SITE_ROOT']?>images//author2.gif" width="16" height="16" align="absmiddle" /> Автор<?
				break;

		case "admin":
			?><img src="<?=$_SESSION['SITE_ROOT']?>images//cooworker.gif" width="16" height="16" align="absmiddle" /> Referats.info<?
				break;
	}?></td>
    <td colspan="2"><a href="#" onClick="switchDisplay('tr_<?=$count?>'); return false;" title="Отобразить/скрыть текст сообщения"><?
	$comm="Комментарий к разделу";
	echo(strstr($arr['subject'],$comm))? $comm:$arr['subject']; 
	?></a></td>
  </tr>
  <tr<? if($_REQUEST['make_answer']!=$arr['number']){?> style="display:<?="none"?>;"<? }?> id="tr_<?=$count?>"><td colspan="7" class="bgF4FF" style="padding:8px;"><?=nl2br($arr['text'])?></td></tr>
<? $count++;
}?>
  <TR bgcolor="#E1E1FF">
  <td colspan="7" align="center" bgcolor="#CCCCCC"><img src="<?=$_SESSION['SITE_ROOT']?>images/lamp2.png" width="20" height="20" hspace="4" align="absmiddle" class="bgWhite iborder borderColorOrangePale" />Щёлкните по теме сообщения, чтобы отобразить/скрыть его текст.</td></TR>
</table>

