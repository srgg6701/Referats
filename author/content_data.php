<? //echo $_REQUEST['menu'];

//if tried to change author's data:
if (isset($_REQUEST['author_data_change'])) $Author->updateAuthorData($_SESSION['S_USER_LOGIN']); ?>

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
    <td align="right">ID</td>
    <td class="bold"><?=$_SESSION['S_USER_ID']?></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Логин/Емэйл</td>
    <td><input type="text" name="login" id="login" value="<?=$arrAuthor['login']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">WMR</td>
    <td><input type="text" name="WMR" id="WMR" value="<?=$arrAuthor['WMR']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Имя</td>
    <td><input type="text" name="name" id="name" value="<?=$arrAuthor['name']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">WMZ</td>
    <td><input type="text" name="WMZ" id="WMZ" value="<?=$arrAuthor['WMZ']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Фамилия</td>
    <td><input type="text" name="family" id="family" value="<?=$arrAuthor['family']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">WME</td>
    <td><input type="text" name="WME" id="WME" value="<?=$arrAuthor['WME']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Отчество</td>
    <td><input type="text" name="otch" id="otch" value="<?=$arrAuthor['otch']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Яндекс.деньги</td>
    <td><input type="text" name="YmoneY" id="YmoneY" value="<?=$arrAuthor['YmoneY']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Гор. телефон</td>
    <td><input type="text" name="phone" id="phone" value="<?=$arrAuthor['phone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Банковский счёт</td>
    <td rowspan="4" valign="top"><textarea name="BankAcc" rows="6" id="BankAcc" style="height:100%;"><?=$arrAuthor['BankAcc']?></textarea></td>
    <td rowspan="4" valign="top">&nbsp;</td>
  </tr>  
  <tr>
    <td align="right">Моб. телефон</td>
    <td><input type="text" name="mobila" id="mobila" value="<?=$arrAuthor['mobila']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">Раб. телефон</td>
    <td><input type="text" name="workphone" id="workphone" value="<?=$arrAuthor['workphone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">Доп. телефон</td>
    <td><input type="text" name="dopphone" id="dopphone" value="<?=$arrAuthor['dopphone']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  <tr>
    <td align="right">ICQ</td>
    <td><input type="text" name="icq" id="icq" value="<?=$arrAuthor['icq']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Количество работ</td>
    <td><input type="text" name="howmach" id="howmach" value="<?=$arrAuthor['howmach']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Город проживания</td>
    <td><input type="text" name="city" id="city" value="<?=$arrAuthor['city']?>" /></td>
    <td>&nbsp;</td>
    <td align="right">Адрес web-сайта</td>
    <td><input type="text" name="myurl" id="myurl" value="<?=$arrAuthor['myurl']?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">    <hr noshade />
		</td>
  </tr>
  <tr>
    <td colspan="6" align="center" class="padding6">
    <input type="hidden" name="author_data_change" id="author_data_change" value="<?=$_SESSION['S_USER_ID']?>" />
    <input type="submit" name="button" id="button" value="Подтвердить" /></td>
  </tr>
</table>