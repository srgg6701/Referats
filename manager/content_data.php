<? //echo $_REQUEST['menu'];

//if tried to change author's data:
if (isset($_REQUEST['worker_data_change'])) 
	$Manager->updateWorkerData(); 
if (!count($arrManager)) $arrManager=$Manager->getManagerData($_SESSION['S_USER_ID']);?>

<table cellspacing="0" cellpadding="4" class="iborder" bordercolor="#CCCCCC">
  <tr class="authorTblRowHeader">
    <td height="28" align="right"><strong>Данные</strong></td>
    <td><strong>Значение</strong></td>
    <td bgcolor="#FFFFFF">&nbsp;&nbsp;</td>
    <td align="right"><strong>Данные</strong></td>
    <td><strong>Значение</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Должность:</td>
    <td colspan="4"><strong>
      <?=$_SESSION['S_USER_STATUS']?>
    </strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Логин</td>
    <td><?=$arrManager['login']?></td>
    <td>&nbsp;</td>
    <td align="right">WMR</td>
    <td><input name="WMR" type="text" disabled="disabled" id="WMR" value="<? //$arrManager['WMR']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Email</td>
    <td><input type="text" name="email" id="email" value="<?=$arrManager['email']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">WMZ</td>
    <td><input name="WMZ" type="text" disabled="disabled" id="WMZ" value="<? //$arrManager['WMZ']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Email-2</td>
    <td><input type="text" name="email2" id="email2" value="<?=$arrManager['email2']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">WME</td>
    <td><input name="WME" type="text" disabled="disabled" id="WME" value="<? //$arrManager['WME']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Имя</td>
    <td><input type="text" name="name" id="name" value="<?=$arrManager['name']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Яндекс.деньги</td>
    <td><input name="YmoneY" type="text" disabled="disabled" id="YmoneY" value="<? //$arrManager['YmoneY']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Фамилия</td>
    <td><input type="text" name="family" id="family" value="<?=$arrManager['family']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Отчество</td>
    <td><input type="text" name="futhers" id="futhers" value="<?=$arrManager['futhers']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Гор. телефон</td>
    <td><input name="phone" type="text" disabled="disabled" id="phone" value="<? //$arrManager['phone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Банковский счёт</td>
    <td rowspan="4" valign="top"><textarea name="BankAcc" rows="6" disabled="disabled" id="BankAcc" style="height:100%;"><? //$arrManager['BankAcc']?></textarea></td>
    <td rowspan="4" valign="top">&nbsp;</td>
  </tr>  
  <tr>
    <td align="right">Моб. телефон</td>
    <td><input name="mobila" type="text" id="mobila" value="<?=$arrManager['mobila']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">Раб. телефон</td>
    <td><input name="workphone" type="text" disabled="disabled" id="workphone" value="<? //$arrManager['workphone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">Доп. телефон</td>
    <td><input name="dopphone" type="text" disabled="disabled" id="dopphone" value="<? //$arrManager['dopphone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">ICQ</td>
    <td><input type="text" name="icq" id="icq" value="<?=$arrManager['icq']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Skype</td>
    <td><input type="text" name="skype" id="skype" value="<?=$arrManager['skype']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Город проживания</td>
    <td><input type="text" name="city" id="city" value="<?=$arrManager['city']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">    <hr noshade />
		</td>
  </tr>
  <tr>
    <td colspan="6" align="center" class="padding6">
    <input type="hidden" name="worker_data_change" id="worker_data_change" value="<?=$_SESSION['S_USER_ID']?>" />
    <input type="submit" name="button" id="button" value="Подтвердить" /></td>
  </tr>
</table>