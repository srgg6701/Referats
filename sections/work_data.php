<? 
//echo "<h5>work_table=$work_table, table= $table</h5>";
//лимит (%%) длины отображения текста:
$limit=20;
// 
if(isset($_REQUEST['mode'])) 
	$mode=$_REQUEST['mode'];
if(isset($_REQUEST['order_sent_id'])) 
	$order_sent_id=$_REQUEST['order_sent_id'];

$show_annotation=$_REQUEST["show_annotation"]; //true | false

$site_root=($_SESSION['T_ROOT_REFERATS'])? $_SESSION['T_ROOT_REFERATS']:$_SESSION['SITE_ROOT'];
//echo "<div>site_root= $site_root</div>";
/*//СКАЧАТЬ ФАЙЛ:
########################################
if (isset($_REQUEST['download_file_name'])) {?>
<script type="text/javascript">
//location.href='<?=$host_file.$_REQUEST['download_file_name']?>';
</script>
<?	//echo "<div>file= ".$host_file.$_REQUEST['download_file_name']."</div>";
	$order_sent_id=true;
}*/
	//метка заказа/покупки работы:?>
	<input name="order_work" id="order_work" type="hidden" />
	<input name="buy_work" id="buy_work" type="hidden" />
<div class="padding10"><?
//метка сохранения массива $_REQUEST в глобальной переменной:
if (!$_SESSION['S_USER_TYPE']) { //echo "<h3>action= save</h3>";?>

      <input name="action" type="hidden" value="save" /><!--<input name="order_<?=($work_table=="diplom_zakaz")? "diplom_zakaz_add":"ri_worx_add"?>" type="hidden" value="1" />--><?  
}
//
if ($work_table=="diplom_zakaz"){
	//метод оперирует данными $_REQUEST['work_id']
	$workFiles=$Worx->getWorkFilesData();
	/*
	'work_id'
	'source_type' //источник
	'file_name' //для файлов, полученных по емэйлу - имя аттачмента
	'ext' //расширение
	'size'
	'filetime'
	'full_path_to_file'	//для файла в дир. заказа. Для аттачментов содержит ":"		
	*/
	//отладочная информация:
	if (isset($_SESSION['TEST_MODE'])) {
		echo "<div>workFiles= </div>";
		var_dump('<pre>',$workFiles,'</pre>');
	}
} 
$req_file_index=$Tools->clearToIntegerAndStop($_REQUEST['file_index']);
//отладочная информация (тест массивов):
if (isset($_SESSION['TEST_MODE'])) {
	//$test_array_1=true;
	if ($test_array_1) {
		?><h4>ПРОВЕРКА МАССИВА $savedFiles:</h4><?
		foreach ($savedFiles as $index=>$array) {
			echo "<div class='paddingBottom4'>[$index]
					<div class='padding4 iborder bgPale'>";
			
				foreach($array as $key=>$data) echo "<div>[$key] => $data</div>";
			
			echo "</div>
				</div>";
		}
	}
	$test_array_2=true;
	if ($test_array_2&&$_REQUEST['work_table']!="ri_worx") {
		?><h4>ПРОВЕРКА МАССИВА $workFiles:</h4><? echo "{ $_REQUEST[file_index] }";
		//
		foreach ($workFiles as $index=>$array) {
			echo "<div class='paddingBottom4'>[$index]
					<div class='padding4 iborder bgGrayLightFBFBFB'>";
				if ($_REQUEST['show_annotation']&&$_REQUEST['file_index']==$index) {
					echo "<h2 class='bgYellow'>FILE IS HERE!</h2>";
					$stop_loop=true;
				}
				foreach($array as $key=>$data) echo "<div>[$key] => $data</div>";			
			echo "</div>
				</div>";
			if ($stop_loop) break;
		}
	}
}
#################################################################################################################################
//если файл недоступен для скачивания:
if (!$order_sent_id) {
	
	//если не в режиме просмотра кастрированного файла (для diplom_zakaz или ri_worx.volume <> 'full' - автор не загружал файл целиком):
	if(!$show_annotation){ ?>
<br />
<div class="bold txt120"><img src="<?=$site_root?>images/info-32.png" width="32" height="32" hspace="4" align="absmiddle" />ВНИМАНИЕ!</div>
<div class="paddingLeft4"><p>
<?		//сгенерировать аннотации РАЗДЕЛА: 
		if ($work_table=="ri_worx") {
		
			if (isset($_SESSION['T_ROOT_REFERATS'])){
				
				?>Для вас доступно бесплатное ознакомление с частью текста (примерно <?=$limit?>%). Чтобы сделать это, щёлкните по названию работы. Сразу же после её заказа и оплаты вы сможете получить доступ ко всем её файлам в полном объёме. При необходимости вы можете получить у автора любую дополнительную информацию.</p><?		
			
			}else{
				
				?>Вы можете ознакомится с частью работы (около <?=$limit?>%). Для этого щёлкните по её названию <a href="#subj">ниже</a>. Всю работу в полном объёме вы сможете получить после её оплаты. </p>
    <p>Также вы можете задать её автору любой интересующий вас вопрос.</p><?
			}
			
	   }elseif ($work_table=="diplom_zakaz") {
		   
		   if (isset($_SESSION['T_ROOT_REFERATS'])){
			   
			   ?>Для вас доступно бесплатное ознакомление с частью текста (примерно <?=$limit?>%) любого, относящегося к работе, файла. Чтобы сделать это, щёлкните по его названию. Сразу же после заказа и оплаты  работы вы сможете получить доступ ко всему её содержанию в полном объёме. При необходимости вы можете получить у автора любую дополнительную информацию.</p><?		
			
			}else{
			
				?>Вы можете ознакомится с частью (около 20%) любого относящегося к работе файла, представленного в формате .<strong>doc</strong>|.<strong>rtf</strong>. Для этого щёлкните по его названию в <a href="#files_table">таблице ниже</a>. Содержание файлов других форматов вы можете просмотреть, отправим нам соответствующий запрос. Для этого, пожалуйста, добавьте работу в корзину заказов, и напишите нам, какие файлы вас интересуют. </p>
    <p>После оплаты работы вы сможете получить доступ ко всем <strong>в полном объёме.</strong></p>
    <p>Также вы можете автору работы любой интересующий вас вопрос.</p>
    Для этого, пожалуйста, <a href="javascript:add_to_basket();">поместите работу в свою корзину заказов</a> (это не влечёт за собой обязательств по её покупке).<?	
			
			}
	   }?>
</div><br />
</p>
<hr noshade />

<?  } ?>

<h1 class="Cambria txt140 paddingTop10"><a href="<? 

	//данные могут извлекаться из 2-х разных таблиц:
	//diplom_zakaz 	- собственные работы
	//ri_worx		- работы авторов
	if ($work_table=="ri_worx"){
		//
		$qSel="SELECT * FROM ri_worx
		 WHERE number = $work_id"; 
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		if (mysql_num_rows($rSel)) {
			$author_id=mysql_result($rSel,0,'author_id');
			$work_name=mysql_result($rSel,0,'work_name');
			$work_area=mysql_result($rSel,0,'work_area');
			$work_type=mysql_result($rSel,0,'work_type');
			$work_volume=mysql_result($rSel,0,'volume');
			
			if ($work_volume=="full") $_SESSION["current_work_name"]=$work_name;
			
			if (isset($_SESSION['T_ROOT_REFERATS'])) echo $_SESSION['T_ROOT_REFERATS'];
			//S_ROOT_REFERATS => D:/AppServ/www/referats
			echo mysql_result($rSel,0,'author_id').'/'.rawurlencode($work_name);?>" name="subj"><img src="<?=$site_root?>images/word.png" width="48" height="48" hspace="4" border="0" align="absmiddle" alt="<?=$work_name?> <?=$work_area?>" /><?
		}

	}elseif($work_table=="diplom_zakaz"){
		
		$qSel="SELECT diplom_zakaz.number, 
       subject, 
       diplom_worx_topix.predmet, 
       typework 
  FROM diplom_zakaz, diplom_worx_topix 
 WHERE diplom_zakaz.predmet = diplom_worx_topix.number
   AND diplom_zakaz.number = $work_id";
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		if (mysql_num_rows($rSel)) {
			$work_name=mysql_result($rSel,0,'subject');
			$work_area=mysql_result($rSel,0,'diplom_worx_topix.predmet');
			$work_type=mysql_result($rSel,0,'typework');
		}	
		//дописываем ссылку:
		echo "?work_table=diplom_zakaz&amp;work_id=$work_id\">";?><img src="<?=$site_root?>images/Word2.png" width="64" height="64" border="0" align="absmiddle" alt="<?=$work_name?> <?=$work_area?>" /><?
	}
if($test_work_name){?>Название работы.<? } echo $work_name; ?></a></h1>
  <hr size="1">
    <div class="padding10">
    <h2 class="txt120"><span class="noBold">Предмет:</span> <? echo($work_area)? $work_area:"Не указан";?></h2>
    <h2 class="txt120"><span class="noBold">Тип работы:</span> <? echo($work_type)? $work_type:"Не указан";?></h2>
	<h4><span class="noBold"><? 
	
	if ($work_table=="diplom_zakaz") {?>Примерная <sup>[<a href="#" onClick="alert(this.title);return false;" title="Стоимость работы рассчитана автоматически, исходя из суммы, заплаченной заказчиком за написание уникальной работы; возможна её корректировка в любом направлении."><strong>?</strong></a>]</sup> с<? 
	}else echo "С";?>тоимость работы: </span><? echo $Worx->calculateWorkPrice($work_table,$work_id,false);?></h4>
    </div>
<?  //кнопки "Отложить в корзину" и "Купить".
	function generateButtons($reg_area=false) {
		global $work_id,$site_root,$go_reg_form;?>
  <div style="padding:8 0 8 0;">
  <? 	//инициируем тип кнопки:
  		$bType='type="';
		//style, not class, т.к. применяется не только на Referats.info
		if ($_SESSION['S_USER_TYPE']=="customer") $bType.="submit";
		else{
			
			$bType.="button";
			//
			$go_reg="document.getElementById('reg_area_1').style.display='block';";
			//кнопка вверху, перенести к нижней кнопке и отобразить поле для проверки данных
			if ($go_reg_form=="go") $go_reg="location.href='#register_form';".$go_reg; 
			//$go_reg.="document.getElementById('order_work').value='$work_id';";
			//нижняя кнопка - проверить заполнение поля аутентификации
			$go_reg="$go_reg return ";
			$go_reg.=($go_reg_form!="go")? "showAuthForm('$reg_area');":"false;";
		} 
		//дописать кавычки к кнопке:
		$bType.='"';?>
<script type="text/javascript">
//установить индикатор типа действия (корзина/покупка), чтобы передать его дальше
function setActionType(hiddenId) {

	var hiddenOrder=document.getElementById('order_work');
	var hiddenBuy=document.getElementById('buy_work');
	
	if (hiddenId=='order_work') {
		hiddenOrder.value="<?=$work_id?>";
		hiddenBuy.value="";
	}else if (hiddenId=='buy_work') {
		hiddenOrder.value="";
		hiddenBuy.value="<?=$work_id?>";
	}	
	<? if ($_SESSION["TEST_MODE"]){?>alert('work_order= '+hiddenOrder.value+"\nbuy_order= "+hiddenBuy.value);<? }?>
}
</script>
        
    <input name="order_action" type="hidden" value="add_to_basket">
    <input onclick="setActionType('order_work');<?=$go_reg?>" <?=$bType?> value="Отложить в корзину" style="padding:8px;"> 
    <input onclick="setActionType('buy_work');<?=$go_reg?>" <?=$bType?> value="Купить сейчас!" style="padding:8px;">
    <img title="Щёлкните кнопку «Купить сейчас», если вы уже оплатили данную работу" src="<?=$site_root?>images/info.png" width="17" height="17" /></div>
<?  	$go_reg_form="cancel";
	} //КОНЕЦ ФУНКЦИИ
	
	//echo "<div>work_volume= $work_volume</div>";
	//условия для обрезки теста файла:
	if ( $work_table=="diplom_zakaz"||
		 $work_volume=="full" //работа загружена автором полностью
	   ) { //+в режиме просмотра аннотации

		//передали указание загрузить в виде аннотации:
		//*********************************************
		//ПРЕОБРАЗОВАТЬ в .TXT
		if ($show_annotation) { 

			//предупреждение о необходимости аутентифицироваться:
			//$Blocks->authorizeToAddToBasket(); ЗДЕСЬ НЕ НАДО! Потому что получается дублирование блоков с одинаковыми именами полей!
			$go_reg_form="go"; //anchor
			generateButtons('reg_area');?>
    
    <hr noshade>
  <div class="paddingTop10 paddingBottom10 txt140"><img src="<?=$site_root?>images/info-32.png" width="32" height="32" hspace="4" align="left" />Файл: <span class="bold" id="annotation_file_name"><?
  	$file_index=($req_file_index)? $req_file_index:"0";
	echo ($show_annotation)? $_SESSION["current_work_name"]:$work_name; 
	
	if ($test_file_name){?>{ИМЯ ФАЙЛА}<? }?></span>.
  <br />
  Ознакомительный текст (около <?=$limit?>% от общего объёма).<br><br>
	<div class="padding10 txt70 iborder borderColorGray" style="background-image:url(images/bg_income.png); background-position:bottom; background-repeat:repeat-x;"><img src="<?=$site_root?>images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" /><strong>ВНИМАНИЕ!</strong>
  	  <div style="padding:8px;">Приведённый ниже текст обработан автоматически и представлен в виде простого текста (plain text). Поэтому он может содержать лишние (отсутствующие в оригинальном) элементы, а также отличаться по параметрам форматирования от исходного, который будет вам доступен после оплаты заказа и <strong>будет полностью соответствовать</strong> параметрам форматирования, указанным для данной оригинальной работы. Кроме того, автор сможет доработь её содержание по вашей заявке.</div>
  	</div>
  </div>
<?			//$test_text=true;
			if ($test_text) {?>Введение 
<p>Правовое положение  личности в обществе и государстве определяется не только правами и свободами,  но и обязанностями. Юридические обязанности получают правовое закрепление в  самых различных отраслях права (в гражданском, трудовом, семейном,  административном праве и так далее). Но ведущая роль в общей системе  юридических обязанностей в России принадлежит конституционным обязанностям  человека и гражданина РФ. </p>
<p> Институт  основных обязанностей человека и гражданина в конституционном праве России  прошел длительный путь и всегда проблемным был вопрос, связанный с его  реализацией. В обеспечении основных обязанностей человека и гражданина  задействован весь механизм государства, в том числе и органы внутренних дел. Основные конституционные обязанности  человека и гражданина имеют всеобщий характер, не зависят от конкретного  правового статуса лица и закрепляются на высшем конституционном уровне. При  этом одни конституционные обязанности возлагаются на каждого человека, другие -  только на граждан РФ. &nbsp;</p>
<p>
<?			}
####################################################################

			//получить имя файла - если он авторский, но загружен полностью или из diplom_zakaz
			//отладка:
			$test_annotation=true;
			if ($_SESSION['TEST_MODE']&&$test_annotation) {
				//var_dump($workFiles[$file_index]);
				?><div><strong>Проверка массива ниже</strong></div><?
			}
		
			//$block_build_table_test=true;
			//распарсим массив файлов, чтобы извлечь нужный по индексу:
			for ($i=0;$i<count($workFiles);$i++) {  
				//'work_id'
				//'source_type' //источник
				//'file_name' //для файлов, полученных по емэйлу - имя аттачмента
				//'ext' //расширение
				//'size'
				//'filetime'
				//'full_path_to_file'	//для файла в дир. заказа. Для аттачментов содержит ":"		
				
				//отладка:
				if (isset($_SESSION['TEST_MODE'])) {
			
					echo "<div class='padding10 bgPale'>ВОШЛИ В МАССИВ \$workFiles!<hr>";
					echo "<div>files_count= <b>$files_count</b>, file_index= <b>$file_index</b><hr></div>";
					foreach ($workFiles[$i] as $key=>$val) echo "<div>\$workFiles[$i]:: $key => $val</div>";
					echo "</div><br>";
				}
				//если файл был получен с аттачментом, будем сохранять его во временной директории:
				if (strstr($workFiles[$i]['source_type'],"mail")) {
					//путь к файлу аттачмента (до его имени) в 
					$filepath=substr($workFiles[$i]['full_path_to_file'],0,strripos($workFiles[$i]['full_path_to_file'],":"));
					$attach_name=substr($workFiles[$i]['full_path_to_file'],strlen($filepath)+1); //имя файла из массива, которое будем сравнивать с именами аттачментов сообщения
					$message=$Tools->getAttachesArray($filepath,"work_data.php");
					//отладка:
					if (isset($_SESSION['TEST_MODE'])) {
			
						echo "<div>Сохранить в дир. temp</div>";
						echo "<div>filepath= $filepath</div>";
						echo "<div>attach_name= $attach_name</div>";
					}
					
					if (count($message)) { //echo "<div>count(\$message)</div>";
	
						foreach($message as $file => $file_content) { 
						
							//$file - имя файла
							//$file_content - контент
							
							$size=round(strlen($file_content)/1024); 
						
							if ($size>0) {
								
								//если имя аттачмента и файла из ранее сохранённого массива файлов заказа совпали:
								if ($file==$attach_name) {
									//сохранить файл во временной директории (в том числе, если это - архив):
									$full_path_to_file=$Tools->putFileToTemp($file_content,"temp/$attach_name");
									//заменяем маршрут расположения файла для извлечения его реального контента:
									$workFiles[$i]['full_path_to_file']=$full_path_to_file;
									//$workFiles[$i]['full_path_to_file']=$Tools->putFileToTemp($file_content,"temp/$attach_name");
									//определить путь файла во временной директории
									//$temp_file_path=$_SESSION['DOC_ROOT_DIPLOM']."temp/$attach_name";
									//сохранить файл как временный:
									//file_put_contents($temp_file_path,$file_content); 
									//chmod($full_path_to_file,777);
									//прервать цикл, т.к. а настоящий момент письмо не может содержать более 1 аттачмента:
									break; //echo "<hr>$file => $file_content<hr>";
								}
							}
						}
					}
				}
				//*** целесообразность блока под вопросом, т.к. заархивированных файлов здеь, по идее, быть уже не должно...
				if (strstr($workFiles[$i]['ext'],"zip")) { //echo "<div class='txtRed'>unpackZip starts!</div>";
					
					//отладка:
					if (isset($_SESSION['TEST_MODE']))	var_dump('<pre>',$workFiles[$i],'</pre>');
					
					//распаковать zip и получить данные файла, индекс которого получен с пер. file_index:
					//ВНИМАНИЕ! 
					//если файл пришёл по емэйлу, он сохранён во временной директории
					$incomingFileArrayData=$Tools->unpackZip ($workFiles[$i],$files_count,false);
					
					//отладка:
					if (isset($_SESSION['TEST_MODE'])) {
						if (is_array($incomingFileArrayData)) foreach ($incomingFileArrayData as $key=>$val) echo "<div>[$key] => $val</div>";
						else echo "<div>\$incomingFileArrayData type = ".gettype($incomingFileArrayData)."</div>";
					}
					
					if (is_array($incomingFileArrayData)) break;
				
				}else{ //НЕ zip
					
					$test_file=true;
					
					//$filename=($attach_name)? $attach_name:
					
					if ($workFiles[$i]['ext']!="dir") {
						
						$files_count++;
						//echo "<div class='padding10 bgYellow'>(!dir) file_index= $file_index, files_count= $files_count</div>";
						
						if ($file_index==$files_count) {
								
							//генерировать строку с файлом:
							if (isset($_SESSION['TEST_MODE'])) foreach ($workFiles[$i] as $key=>$data) echo "<div class='txtGreen'>[$key] => $data</div>";
							
							//передадим массиву входящего файла значение из ранее сформированного массива:
							$incomingFileArrayData=$workFiles[$i];
							if ($attach_name) $incomingFileArrayData['full_path_to_file']=$temp_file_path;
							//прервать цикл:
							break;
						}											
					}
				}
			}?> 
<script type="text/javascript">
<? $file_name=$incomingFileArrayData['file_name'];
//уберём "/", если передавали имя файла внутри директории:
if ($file_name[0]=="/") $file_name=substr($file_name,1,strlen($file_name)); ?>
//указать имя файла в его контейнере:
document.getElementById('annotation_file_name').innerHTML='<?=$file_name?>';
</script>
			
		<?	$full_path_to_file=($work_table=="ri_worx")? $_SESSION['DOC_ROOT']."/".$author_id."/$work_name":$incomingFileArrayData['full_path_to_file'];
			
			//отладка:
			if (isset($_SESSION['TEST_MODE'])) echo "<hr><div class='txtRed'>full_path_to_file= $full_path_to_file</div>";
			
			//расширение (возвращается(&) второй аргумент):
			$Tools->detectExt($full_path_to_file,$ext);

			//путь к конвертеру:
			$pconvert="doc_converter/";
			if (isset($_SESSION['S_ROOT_REFERATS'])) 
				$pconvert=$_SESSION['S_ROOT_REFERATS']."/$pconvert";
			
			switch ($ext) { 
		
				case ".rtf": 
				require ($pconvert."rtf.php");		
				$text=rtf2text($full_path_to_file);
				break;	
				
				case ".doc": 
				require ($pconvert."doc.php");	
				$text=doc2text($full_path_to_file);		
				break;
				
				//case "docx":  $conv="docx"; break;

/*

http://www.webcheatsheet.com/PHP/reading_the_clean_text_from_docx_odt.php

In this article we will resolve the task of reading the "clean" text from the Office Open XML (more known as DOCX) and OpenDocument Format ODT using PHP. Note that we are not going to apply any third-party software.

You might ask, why do that? And rightly so. The clean text received from DOCX or ODT document reminds a mess. But this "mess" can then be used to create, for example, a search index for extensive document repository.

So let's start! Both of these file formats are ZIP archives renamed into .docx/.odt. If you open these archives in, for example, Total Commander using Ctrl+PageDown, you will see the archive structure (.docx on the left, .odt on the right).


 

Files we are looking for are content.xml in ODT and word/document.xml in DOCX.

To read the text data from these files, we use the following code:

function odt2text($filename) {
    return readZippedXML($filename, "content.xml");
}

function docx2text($filename) {
    return readZippedXML($filename, "word/document.xml");
}

function readZippedXML($archiveFile, $dataFile) {
    // Create new ZIP archive
    $zip = new ZipArchive;

    // Open received archive file
    if (true === $zip->open($archiveFile)) {
        // If done, search for the data file in the archive
        if (($index = $zip->locateName($dataFile)) !== false) {
            // If found, read it to the string
            $data = $zip->getFromIndex($index);
            // Close archive file
            $zip->close();
            // Load XML from a string
            // Skip errors and warnings
            $xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            // Return data without XML formatting tags
            return strip_tags($xml->saveXML());
        }
        $zip->close();
    }

    // In case of failure return empty string
    return "";
}
This code works in PHP 5.2+ and requires php_zip.dll for Windows or --enable-zip parameter for Linux. If you unable to use ZipArchive (old version of PHP or lack of libraries), you can use PclZip library.

Related information:

http://msdn.microsoft.com/en-us/library/aa338205.aspx*/


			}		
		
			$strlen=strlen($text);
			$text_limit=round($strlen/100*$limit);
			echo "<br />".nl2br(substr($text,0,$text_limit));
			#################################################################
		####################################################################
		}?>
<hr noshade />
	<br /><?    

	} unset($files_count); //чтоб не повлияло на индес файлов в их таблице 
		
}else $allow_download=true;
//
if ($work_table=="diplom_zakaz") { 
	//если архив:
	//unpackZip()->generateTableRow()
	//иначе:
	//generateTableRow()
	if (isset($_SESSION['TEST_MODE'])) echo "<h3 class='txtOrange'>showWorkFiles starts here!</h3>";

	//передать метку для генерации таблицы:
	//ВНИМАНИЕ! 
	//НЕ ПЕРЕНОСИТЬ МЕТКУ внутрь метода showWorkFiles, т.к. вложенные методы её не увидят!
	$build_table=true;	
	$Blocks->showWorkFiles( $site_root,
							$workFiles,
							$work_id,
							$savedFiles,
							$order_sent_id
						  );
	
}
//скачивание авторской(?) работы не разрешено:
if (!$allow_download) {?><a name="register_form"></a><?
	//предупреждение о необходимости аутентифицироваться:
	$Blocks->authorizeToAddToBasket('_1'); //дописываем идентификатор второго блока с предупреждением о необходимости аутентификации
	generateButtons('reg_area_1');
}?>
<br/>
<img src="images/i_triangle.png" alt="<?=$work_name?>" width="15" height="15" hspace="4" align="left" />Все указанные выше файлы относятся к работе
<p class="txtInl"><span class="bold"><?=$work_name?></span> (<?=$work_type?>, <?=$work_area?>).</p>
 <noindex>
 <br/><br/>
<div class="paddingTop10"><table width="100%" cellpadding="0" cellspacing="0">
  <tr class="borderBottom2 borderColorGray">
    <td valign="top"><img src="../order/images/42-15344192.jpg" width="64" height="96" hspace="10" vspace="10" /></td>
    <td width="100%" class="paddingLeft10 paddingTop10 paddingBottom10"><h4><strong>Нужна помощь?</strong></h4>
    <strong>Консультируем бесплатно: </strong>
	<ul>
	  
    	<li>Как сэкономить на заказе творческой работы</li>
    	<li>Как избежать проблем с преподом</li>
    	<li>Как не нарваться на мошенников</li>
    	<li>Как продавать написанную для вас работу самостоятельно и получать деньги всю жизнь</li>
    	<li>...многое, многое другое!</li>
    </ul>
    <p>Всегда готовы <a href="http://www.diplom.com.ru">пойти вам навстречу</a> и поделиться огромным опытом!</p></td>
  </tr>
</table>
</div> 
</noindex>
<?
//
$Tools->wrongExtIssue();?></div><?

//удалить временные файлы:
//теперь удалить временный файл, чтоб не накапливались в dir temp:
$dir=$_SESSION['DOC_ROOT_DIPLOM']."temp";
// Открыть заведомо существующий каталог и начать считывать его содержимое
if (is_dir($dir)) {
	//отладка:
	if (isset($_SESSION['TEST_MODE'])) echo "<h5>is_dir($dir)</h5>";
	
	if ($dh = opendir($dir)) {
		
		while (false!==($file = readdir($dh))) {
			
			//отладка:
			if (isset($_SESSION['TEST_MODE'])) echo "<h5><span class='txtRed'>file= $file</span><br>LINE = ".__LINE__."</h5>";
	
			//echo "<br>count file<br>";
			if ($file!="."&&$file!="..") {

				//в данном случае в массив добавляется не ID, работы, а имя файла.
				if (isset($_SESSION['TEST_MODE'])) { //echo "i= $i";?><div class="padding4">Удаляем файл <?=$file?> в тестовом режиме...</div><? }
				if (isset($_SESSION['TEST_MODE'])) echo '<div class="padding4">Удаляем файл '.$file.'!</div>';
				$del_file=unlink("$dir/$file");			

				if (!$del_file) $catchErrors->sendErrorMess ("Ошибка удаления файла...","Файл $dir/$file не удалён..."); 
			}
		} //echo "</blockquote>";
		closedir($dh);
	}
}?>