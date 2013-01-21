<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Основной фрейм</title>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js"></script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('applications');
</script>
</head>
<frameset rows="*,*"" frameborder="NO" border="1" framespacing="1">
  <frame src="applications_paid.php?where= AND ri_zakaz.status=2&title=Оплаченные заказы (нужно отправить)" name="topFrame" style="border-bottom:solid 2px #cccccc">
  <frame src="applications_paid.php?where= AND ri_zakaz.status=1&title=Неоплаченные заказы" name="mainFrame">
</frameset>
<noframes><body><? require ("../../temp_transparency_author.php");?>
</body></noframes>
</html>
