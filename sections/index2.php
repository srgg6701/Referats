<? session_start();?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Directories</title>
</head>
<body><?

 ?><h2><img src="<?=$_SESSION['SITE_ROOT']?>images/Word2.png" width="64" height="64" hspace="4" align="absmiddle">Директории с файлами (всего, директорий: <span id="fsumm"></span>) &#8212;</h2>
 <? //
	$d = dir($_SESSION['SITE_ROOT']."../Diplom/zip");
	$i=0;
	while (false !== ($entry = $d->read())) {
		if (is_numeric($entry)&&$entry>0) 
		  { 
			if ($handle = opendir($entry)) {
				$fcount=0;
				/* Именно этот способ чтения элементов каталога является правильным. */
				while (false !== ($file = readdir($handle))) { 
					if ($file&&$file!="."&&$file!="..") { 
						$arrFiles[]=$file;
						$fcount++;
					}
				}
				if ($fcount) 
				  { //
					if (!is_float($i/10)) echo "<hr />";
					elseif ($i) {?>, <? } 		    
					?> <a href="<?=$entry?>"><?=$entry?></a> [<?=$fcount?>]<? 
					
					$i++;

				  }
				closedir($handle); 
			}
		  } 
	}
	$d->close(); ?>
</body>
</html>