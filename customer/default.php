<?
$mode=(!$_REQUEST['mode'])? "orders":$_REQUEST['mode'];
//var_dump($_SESSION);

if ($_SESSION['S_USER_TYPE']=="customer") {

	require_once("classes/class.Money.php");
	$Money=new Money;

	if (isset($_REQUEST['answer_to'])) {?>
<script type="text/javascript">
var go_page="?section=customer&mode=messages&make_answer=<?=$_REQUEST['answer_to']?>#menu_start";
//alert(go_page);
location.href=go_page;
</script>
<?	}
	//извлечём №№ заказов текущего клиента:
	$qSel="SELECT number, 
       work_table, 
       work_id, 
       state, 
       status 
   FROM ri_basket
  WHERE user_id = $_SESSION[S_USER_ID]
ORDER BY number DESC";
	$rSel=mysql_query($qSel); 
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
	//$catchErrors->select($qSel);

	if ($mode=="payments"&&$_REQUEST['order_id']) {
		$order_id=$_REQUEST['order_id'];
		$and_order_id="
   AND ri_basket_id = $order_id";
	}
	//платежи:
	$qSelPaid="SELECT ri_payments.number,
       ri_basket_id, 
       ri_payments.datatime, 
       payment_date, 
       summ, 
       payment_method, 
       payment_note
  FROM ri_payments, ri_basket 
 WHERE ri_basket.number = ri_basket_id
  AND ri_basket.user_id = $_SESSION[S_USER_ID] $and_order_id
ORDER BY payment_date"; 
	$rSelPaid=mysql_query($qSelPaid);
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelPaid",$qSelPaid);
	$paid_rows=mysql_num_rows($rSelPaid);
	
	//сообщения:
	$qSelMess="SELECT * FROM ri_messages
 WHERE ( sender_user_id = $_SESSION[S_USER_ID] 
         AND sender_user_type = 'customer'
       )
       OR 
	   ( receiver_user_id REGEXP '(^|,)".$_SESSION['S_USER_ID']."(,|$)' 
	     AND  receiver_user_type = 'customer'
       )
 ORDER BY number DESC";
	$rSelMess=mysql_query($qSelMess); 
	$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelMess",$qSelMess); 	
	//$catchErrors->select($qSelMess);
	$messages_rows=mysql_num_rows($rSelMess);?>
<a name="menu_start"></a>
<table width="100%" cellpadding="10" cellspacing="0" id="customer_menu">
  <tr class="arial" align="center">
    <td<? if ($mode=="orders"){?> class="userMenu"<? }?> nowrap="nowrap"><a href="?section=customer&mode=orders"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle">Заказы</a> (<? echo(mysql_num_rows($rSel))? mysql_num_rows($rSel):"0";?>)</td>
    <td<? if ($mode=="payments"||$mode=="pay"){?> class="userMenu"<? }?> nowrap="nowrap"><a href="?section=customer&mode=payments"><img src="<?=$_SESSION['SITE_ROOT']?>images/money_traffic.png" width="16" height="16" hspace="4" border="0" align="absmiddle">Платежи</a> (<? echo($paid_rows)? $paid_rows:"0";?>)</td>
    <td<? if ($mode=="messages"){?> class="userMenu"<? }?> nowrap="nowrap"><a href="?section=customer&mode=messages"><img src="<?=$_SESSION['SITE_ROOT']?>images/all.png" width="20" height="16" hspace="4" border="0" align="absmiddle">Сообщения</a> (<? echo($messages_rows)? $messages_rows:"0";?>)</td>
    <td<? if ($mode=="data"){?> class="userMenu"<? }?> nowrap="nowrap"><a href="?section=customer&mode=data"><img src="<?=$_SESSION['SITE_ROOT']?>images/based_pattern_edit.gif" width="16" height="16" hspace="4" border="0" align="absmiddle"></a><a href="?section=customer&mode=data">Мои данные</a></td>
    <td nowrap="nowrap"><a href="index.php"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle_plus.png" width="24" height="20" hspace="4" border="0" align="absmiddle">Все  работы</a></td>
    <td align="right" nowrap="nowrap" bgcolor="#F4F4FF"><a href="?section=customer&mode=exit"><img src="<?=$_SESSION['SITE_ROOT']?>images/exit.gif" width="16" height="16" hspace="4" vspace="4" border="0" align="absmiddle">Выход</a></td>
  </tr>
</table>
<div class="padding10"><?
	if ($test_customer_mode){?><p>Активный раздел заказчика....</p><? }
		
	//echo "<hr>mode = ".$mode.".php<hr>";
	include("customer/".$mode.".php");
	
	?></div><?

}else{?>

<div class="txtRed padding10 borderTop1 borderColorOrangePale" style="border-top-width:2px;">
<img src="<?=$_SESSION['SITE_ROOT']?>images/Unlock-32.png" width="32" height="32" hspace="4" vspace="10" align="absmiddle" />Требуется аутентификация или регистрация. </div>
<?	if (isset($_REQUEST['answer_to'])) {
		//если заходили по ссылке из письма:?>
<input name="answer_to" type="hidden" value="<?=$_REQUEST['answer_to']?>">
<? //die();  
	}
	//форма напомнания пароля:	
	$Customer->customerAuth(" style='padding-top:20px; padding-bottom:10px;'");?>
<br />
<br /><?
}?>
