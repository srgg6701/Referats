<?
//
if ($and_order_id) $Worx->filterByOrder($order_id);?>
<table width="98%" border="1" cellspacing="0" rules="rows" id="tbl_customer">
  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale cellPassive bold" id="first">
    <td align="center" bgcolor="#003399" title="id ��������">#</td>
    <td align="center" style="cursor:default;" title="id ������"><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle_inverted.png" /></td>
    <td nowrap="nowrap" bgcolor="#003399">����/����� ��������</td>
    <td nowrap="nowrap" bgcolor="#003399">���� �������</td>
    <td bgcolor="#003399">�����</td>
    <td nowrap="nowrap" bgcolor="#003399">������ ������</td>
    <td align="center" bgcolor="#003399" title="������ ��������"><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" hspace="4" /></td>
    <td bgcolor="#003399">�����������</td>
  </tr>
<?	$Worx->trNote(8);
//
while ($arr = mysql_fetch_assoc($rSelPaid)) { ?>

  <tr>
    <td align="right"><?=$arr['number']?></td>
    <td align="right" title="������������� �������� �� ������"><a href="?section=customer&mode=payments&order_id=<?=$arr['ri_basket_id']?>"><?=$arr['ri_basket_id']?></a></td>
    <td><? echo $Tools->ddmmyyyy($arr['datatime']);?> <span class="txtGrayCCC"><? echo $Tools->hms($arr['datatime']);?></span></td>
    <td><? $Tools->dtime($arr['payment_date'])?></td>
    <td align="right"><?=$arr['summ']?></td>
    <td><?=$arr['payment_method']?></td>
    <td align="center"><?
    
	//������� ������ ��������
	if (mysql_num_rows(mysql_query("SELECT payment_status FROM ri_payments WHERE payment_status = 'OK' AND number = ".$arr['number']))) {?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" /><? }
	
	?></td>
    <td><?=$arr['payment_note']?></td>
  </tr>

<?
}?>
</table>
