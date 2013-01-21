<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body>
<?php
echo("PHPSESSID=$PHPSESSID<br>");
//Echo(phpinfo()."<br>");
echo("$HTTP_REFERER<br>");
$c=count($_SERVER);
for($i=0;$i<$c;$i++)
{
  echo("[$i]=".$_SERVER[$i]."<br>");
}
?>
</body>
</html>
