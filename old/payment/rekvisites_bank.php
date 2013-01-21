<?php
session_start();
require('../../connect_db.php');
require('../lib.php');
?>
<html>
<head>
<title>Ввод банковских реквизитов</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<body>
<hr size="1">
<p><a href="#">Перевод на произвольные банковские реквизиты</a>.<br>
    <a href="#">Перевод на счёт физического лица в российском банке</a>.<br>
    <a href="#">Перевод на счёт физического лица в Сбербанке РФ</a>. </p>
<table width="550" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#F5F5F5">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">&nbsp;</td>
    <td><input name="textarea" type="text" value="" style="width:100%"></td>
  </tr>
</table>
<p>&nbsp;</p>
<h3>Перевод на произвольные банковские реквизиты:</h3>
<table width="550" border="0" cellpadding="4" cellspacing="1" style="background:  #C6BF8B">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">Ваши
      реквизиты:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
				
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Выводимая из Яндекc.Денег сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Выводимая из Яндекc.Денег сумма" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Получаемая на счет сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Получаемая на счет сумма" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Банк взимает %</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Банк взимает %" name="agentpercent" size="3" value="0" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
				
			--></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Название
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="Название банка" maxlength="240" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Город
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="Город банка" maxlength="240" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">БИК
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="БИК банка" maxlength="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Корреспондентский
      счет банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="Корреспондентский счет банка" maxlength="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Получатель</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="CustName" maxlength="110" title="Получатель" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Расчетный
      счет</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="CustAccount" title="Расчетный счет" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">ИНН
      получателя</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" title="ИНН получателя" maxlength="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">КПП
      получателя</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="CustKPP" title="КПП получателя" maxlength="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<h3>Перевод на счет физического лица в российском банке: </h3>
<table width="550" border="0" cellpadding="4" cellspacing="1" style="background:  #C6BF8B">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">Ваши
      реквизиты:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
				
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Выводимая из Яндекc.Денег сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Выводимая из Яндекc.Денег сумма" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Получаемая на счет сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Получаемая на счет сумма" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Банк взимает %</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Банк взимает %" name="agentpercent" size="3" value="0" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
				
			--></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Название
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="Название банка" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Город
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="Город банка" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">БИК
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="БИК банка" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">ИНН
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankINN" title="ИНН банка" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">КПП
      банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="BankKPP" title="КПП банка" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Кор.
      счет банка</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_9" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="Кор. счет банка" MAXLENGTH="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="Банковский счет" onClick="document.forms.atm_form.DepositAccount.disabled=false;document.forms.atm_form.FaceAccount.disabled=true;document.forms.atm_form.RubAccount.disabled=true" type="radio" checked name="Account">
      Банковский счет</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">№ банковского
      счета<br>
        <input value="" id="iF_10" style="border: #C6BF8B 1px solid; width: 100%" name="DepositAccount" maxlength="50" title="№ банковского счета" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="Лицевой счет" onClick="document.forms.atm_form.DepositAccount.disabled=true;document.forms.atm_form.FaceAccount.disabled=false;document.forms.atm_form.RubAccount.disabled=false" type="radio" name="Account">
      Лицевой счет</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">№ консолидированного
      счета
        <input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="RubAccount" title="№ консолидированного счета" maxlength="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
      № рублевого лицевого счета
      <input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="FaceAccount" title="№ рублевого лицевого счета" maxlength="50" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Фамилия </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="tmpLastName" maxlength="50" title="Фамилия получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Имя </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_14" style="border: #C6BF8B 1px solid; width: 100%" name="tmpFirstName" maxlength="50" title="Имя получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Отчество </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_15" style="border: #C6BF8B 1px solid; width: 100%" name="tmpMiddleName" maxlength="50" title="Отчество получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">ИНН
      получателя (если есть)</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_16" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" maxlength="12" title="ИНН получателя (если есть)" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<p>Банковский Счет, точнее банковский счет физического лица &#8212; счет, открываемый
  банком для физических лиц, для участия в безналичном денежном обороте и/или
  аккумулировании на счете средств для целевого использования.</p>
<p>Реквизиты банковского счета для юридического и физического лица полностью
  аналогичны, и для зачисления денег на банковский счет физического лица банку-получателю
  достаточно знать только номер банковского счета физического лица. Однако, для
  обслуживания однотипных операций клиентов физических лиц банки могут открывать
  для клиентов лицевые счета.</p>
<p>Лицевой счет, точнее субсчет в рамках консолидированного банковского счета,
  - Счет банка, предназначенный для учета средств физических лиц. Множество однотипных
  счетов (накопительные счета, карточные счета, депозитные счета и т.д.) в банке,
  могут учитываться на одном банковском счете так называемом, консолидированном
  счете лицевых (иных) счетов, а для каждого клиента открывается отдельный лицевой
  счет (субсчет), в рамках консолидированного, по которому ведется персональный
  учет средств каждого клиента.</p>
<h3>Перевод на счет физического лица в СБ РФ:</h3>
<table border="0" cellspacing="1" cellpadding="4" style="background:  #C6BF8B" width="550">
  <tr valign="top">
    <td style="background: #EEEBDC;font: bold 80% Arail;text-align: center;border-bottom: 2px solid #C6BF8B" colspan="2">Ваши
      реквизиты:</td>
  </tr>
  <script type="text/javascript" language="Javascript"><!--
        
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Выводимая из Яндекc.Денег сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_1" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Выводимая из Яндекc.Денег сумма" name="sum" size="10" onKeyUp="checkKeyPress();calcnetsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
					//document.writeln('<tr><td style= "background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Получаемая на счет сумма</td>');
					//document.writeln('<td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input id="iF_2" style="border: #C6BF8B 1px solid; width: 100%" type="text" title="Получаемая на счет сумма" name="net_sum" size="10" onKeyUp="checkKeyPress();calcsum()" onBlur="itemBlur()" onFocus="itemFocus()"/></td></tr>');
        
    --></script>
  <noscript>
  </noscript>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Фамилия </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_3" style="border: #C6BF8B 1px solid; width: 100%" name="tmpLastName" maxlength="50" title="Фамилия получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Имя </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_4" style="border: #C6BF8B 1px solid; width: 100%" name="tmpFirstName" maxlength="50" title="Имя получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Отчество </td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_5" style="border: #C6BF8B 1px solid; width: 100%" name="tmpMiddleName" maxlength="50" title="Отчество получателя" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">ИНН
      получателя (если есть)</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_6" style="border: #C6BF8B 1px solid; width: 100%" name="CustINN" title="ИНН получателя" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Город
      отделения СБ РФ</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_7" style="border: #C6BF8B 1px solid; width: 100%" name="BankCity" title="Город отделения СБ РФ" MAXLENGTH="30" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">Название
      отделения СБ РФ</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_8" style="border: #C6BF8B 1px solid; width: 100%" name="BankName" title="Название отделения СБ РФ" MAXLENGTH="100" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">БИК
      отделения СБ РФ</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_9" style="border: #C6BF8B 1px solid; width: 100%" name="BankBIK" title="БИК отделения СБ РФ" MAXLENGTH="9" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">К/С
      отделения СБ РФ</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_10" style="border: #C6BF8B 1px solid; width: 100%" name="BankCorAccount" title="К/С отделения СБ РФ" MAXLENGTH="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="Банковский счет" onClick="document.forms.atm_form.DepositAccount.disabled=false;document.forms.atm_form.FaceAccount.disabled=true;document.forms.atm_form.RubAccount.disabled=true" type="radio" checked name="Account">
      Банковский счет</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">№ банковского
      счета<br>
        <input value="" id="iF_11" style="border: #C6BF8B 1px solid; width: 100%" name="DepositAccount" title="№ банковского счета" maxlength="35" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right; vertical-align: top"><input value="Лицевой счет" onClick="document.forms.atm_form.DepositAccount.disabled=true;document.forms.atm_form.FaceAccount.disabled=false;document.forms.atm_form.RubAccount.disabled=false" type="radio" name="Account">
      Лицевой счет</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%">№ консолидированного
      счета
        <input value="" id="iF_12" style="border: #C6BF8B 1px solid; width: 100%" name="RubAccount" title="№ консолидированного счета" maxlength="20" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
      № рублевого лицевого счета
      <input value="" id="iF_13" style="border: #C6BF8B 1px solid; width: 100%" name="FaceAccount" title="№ рублевого лицевого счета" maxlength="35" type="text" onBlur="itemBlur()" onFocus="itemFocus()">
    </td>
  </tr>
  <tr valign="top">
    <td nowrap style="background: #EEEBDC; font: 80% Tahoma, Arail; white-space: nowrap; text-align: right">ИНН
      отделения СБ РФ</td>
    <td style="background: #FFF; font: 80% Tahoma, Arail; width: 100%"><input value="" id="iF_14" style="border: #C6BF8B 1px solid; width: 100%" name="BankINN" title="ИНН отделения СБ РФ" MAXLENGTH="12" type="text" onBlur="itemBlur()" onFocus="itemFocus()"></td>
  </tr>
</table>
<br>

</body>
</html>
