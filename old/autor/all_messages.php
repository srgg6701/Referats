<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Основной фрейм просмотра почты</title>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js"></script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('applications');
</script>
</head>
<frameset rows="*,*"" frameborder="NO" border="1" framespacing="1">
  <frame src="my_messages.php?mark=out&zakaz=<?php echo("$zakaz&work=$work");?>" name="topFrame" style="border-bottom:solid 2px #cccccc">
  <frame src="my_messages.php?mark=in&zakaz=<?php echo("$zakaz&work=$work");?>" name="bottomFrame">
</frameset>
<noframes><body><? require ("../../temp_transparency_author.php");?>
</body></noframes>
</html>
