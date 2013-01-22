<?
class Worx {

public $arrOrdersPaidFull=array(); //все полностью оплаченные заказы
public $arrWorkOrdersIDs=array(); //общее количество заказов выбранной работы
//унифицированные массивы работ:
public $arrLettersAtt; //сообщения с аттачментами по конкретному заказу
public $arrDplomZakazIDsWithFiles=array();
//public $arrDplomZakazIDsWithFilesAttached; //содержащие файлы в письмах 
public $arrWorksFilesMail; //...с файлами, отправленными заказчикам по емэйлу; закачанных файлов нет
public $arrWorksFilesZip; //...с файлами, загруженными в систему; отправленных по емэйлу нет
public $arrWorksFilesAll; //консолидированный
public $arrWrongExt; //массив файлов с "неправильными" расширениями
public $getZipFileArray; //массив данных файла в сканируемой директории
public $savedFiles;
public $txt_default="";	
public $work_area;
public $work_type;
public $works_value; //колич. работ в текущем массиве заказов
	
	//построить таблицу работ на основе ранее выполненного запроса:
	function buildWorxTable( $arr,
							 $work_number,
							 $baskets_show=false,
							 $allow_changes=false
						   ){
		
		global $arrOrdersType;
		global $price_ratio; 
		global $search_handler; 
		
		if ($test_table){?><table><? }?>

		<tr>
          
          <td align="right" class="paddingBottom0 paddingTop0"><input name="set_number_<?=$work_number?>" type="hidden" value="<?=$work_number?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" align="absmiddle" /><?=$work_number?></td>
	<? if ($baskets_show) { ?>
          
          <td align="right" class="paddingBottom0 paddingTop0"><?
          
		  //if (isset($_SESSION['TEST_MODE'])) echo "<h6>getWorkOrdersValue (buildWorxTable)</h6>";
		  $orders_value=$this->getWorkOrdersValue ($arrOrdersType,$work_number);
          
		  if ($orders_value){?><a href="?menu=orders&amp;work_id=<?=$work_number?>" title="Загрузить заказы по работе"><? echo $orders_value;?></a><?
		  }else{?>&nbsp;<? }?></td>
    <? }?>
          
          <td width="100%"><a href="<?
		  
		  	$item_name=($search_handler)? "item_name":"work_name"; 
		  
 			$fname=$_SESSION['SITE_ROOT']."_download.php?author_id=$_SESSION[S_USER_ID]&amp;file_to_download=".rawurlencode($arr[$item_name]);
			//str_replace(" ","%20",$arr[$item_name]);  
			echo $fname;
		  	//echo str_replace(" ","%20",$arr[$item_name]);
		  
		  ?>" title="Загрузить файл"><?=$arr[$item_name]?></a></td>
          
          <td style="padding:1px;"><? //="Types"?><? 
		  //echo "<div>\$arr['item_table']= ".$arr['item_table'].", \$arr['item_id']= ".$arr['item_id']."</div>";
		  
		//получить предмет/тип:
		$this->getWorkAreaAndType("ri_worx",$work_number);
		$work_area=$this->work_area;
	  	$work_type=($search_handler)? $this->work_type:$arr['work_type'];		  
		if (isset($_SESSION['TEST_MODE'])) echo "<div>{buildWorxTable()}</div>";  
	    $this->buildWorxTypesList( false, 				//code
		  						   $work_type,	//тип работы
								   false
								 );
		 
		  ?></td>
          
          <td style="padding:1px;"><? //="Areas"?><? 
		  
		  $HTML=($search_handler)? " class='area_short'":" style='background-color:#F7f7f7; width:240px;'";
		  $this->buildWorxAreasList($HTML,$work_area); 
		  
		  ?></td>
          
          <td nowrap="nowrap"><input onkeyUp="calculatePrices(this,'work_price_customer_<?=$work_number?>');" name="work_price_<?=$work_number?>" type="text" id="work_price_<?=$work_number?>" size="3" value="<?
		  //извлечём стоимость работы:
		  $work_price=($search_handler)? mysql_result(mysql_query("SELECT work_price FROM ri_worx WHERE number = $work_number"),0,'work_price'):$arr['work_price'];
		  echo $work_price;
		  ?>"<? if (!$allow_changes){?> disabled<? }?>></td>
          
          <td nowrap="nowrap"><input onkeyUp="calculatePrices(this,'work_price_<?=$work_number?>');" name="work_price_customer_<?=$work_number?>" type="text" id="work_price_customer_<?=$work_number?>" size="3" value="<?=$work_price/100*$price_ratio?>"<? if (!$allow_changes){?> disabled<? }?>></td>
			<? if ($allow_changes){?>
          
          <td nowrap="nowrap"><a href="javascript:if(confirm('Подтверждаете удаление файла?')) location.href='?menu=<? echo $_REQUEST['menu']?>&amp;del_file_name=<?=$arr['work_name']?>'"><img src="<?=$_SESSION['SITE_ROOT']?>images/delete2.gif" width="16" height="14" border="0" /></a>&nbsp;</td>
			<? }?>          
        </tr>

<?  if ($test_table){?></table><? }
	} //КОНЕЦ МЕТОДА buildWorxTable
	//SELECT
	//список предметов:
	function buildWorxAreasList($code,$sel_area){
	
		global $catchErrors;
		global $cancel_sel_name; //echo "<div>cancel_sel_name= $cancel_sel_name</div>";
		global $work_number;
		if ($work_number) $work_numer="_$work_number";
		
		//ВНИМАНИЕ!!!
		//Физические переносы НЕ РАССТАВЛЯТЬ, т.к. код используется в том числе при динамическом добавлении в HTML!
		
		?><select<? 
		if (!$cancel_sel_name){
							//нижний дефис для имени списка дописан ранее...
			?> name="work_area<? echo $work_numer; ?>" id="work_area<?=$work_numer?>"<? 
		}echo $code;
		
		?>>
			<? $this->buildWorxAreasListOptions($sel_area);?>
        
        </select><?	
	} //КОНЕЦ МЕТОДА buildWorxAreasList
 	//OPTION
	//построить набор OPTIONS для списка предметов
	function buildWorxAreasListOptions($sel_area=false) {
		//если получили предмет работы на латинице, извлечём оригинальное значение из таблицы:
		if ($sel_area and preg_match("/[a-zA-Z]/",$sel_area)) {
			global $Tools;
			$sel_area=$Tools->convertField2CPU( "diplom_worx_topix",
							   "predmet", //имя поля c данными на кириллице
							   $sel_area //входящее значение поля для конвертации							   
							 ); echo "<option>sel_area= $sel_area</option>";
		}
		global $catchErrors,$nl; //nl - визуальный перенос строки в клиентском скрипте
		//исключить перенос строки, т.к. 
		//в том числе используется клиентским скриптом ?><option value=0<? if (!$sel_area){?> selected<? } ?>>Все предметы</option><? 

		$qSelTpx="SELECT predmet,number FROM diplom_worx_topix ORDER BY predmet";
		$t_wt=mysql_query($qSelTpx);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, buildWorxAreasList()","qSel",$qSelTpx); 					//
		$n_wt=mysql_num_rows($t_wt);
		for($p=0;$p<$n_wt;$p++){ 
			$wtype=mysql_result($t_wt,$p,'predmet');?><option value="<?=$wtype?>"<? 
			if ($sel_area&&$wtype&&strtolower($wtype)==strtolower($sel_area)){?> selected="selected"<? }?>><?=$wtype?></option><? echo $nl;   
		}
	} // КОНЕЦ МЕТОДА buildWorxAreasListOptions
	//SELECT 
	//список типов работ:
	function buildWorxTypesList( $code,
								 $sel_type, //тип работы
								 $show_worx_values, //показывать в списке колич. работ данного типа?
								 $reverse=false //команда обратного преобразования (кириллица->латиница) для списка
							   ) {
		
		if ($_SESSION['S_USER_TYPE']=="worker") {
			global $arrAll; //отсортированный массив работ по результатам применения фильтра выбора
			global $arrAllMax; //изначальный массив работ, до применения фильтра
			if ($arrAllMax) $arrAll=$arrAllMax;
		}

			//$test_arrs=true;
			if ($test_arrs) {
				if (count($arrAll)) {
					echo "<div class='txtOrange bold'>\$arrAll starts here!</div>";
					foreach ($arrAll as $val)
						if (is_array($val)) {
							echo "<div>val is array!</div>";
							foreach ($val as $key=>$work_id)
								echo "<div>$key=>$work_id</div>";
						}
						else echo "<div>\$val=>$val</div>";
				}
			}

		global $work_number;
		
		if ($work_number) $work_numer="_$work_number";
		
		if ($reverse) {

			//извлечь кириллические значения полей:

		}
		if (isset($_SESSION['TEST_MODE'])) echo '{$sel_type='," $sel_type}";?>
            
    <select name="work_type<?=$work_numer?>"<?=$code?> id="work_type<?=$work_numer?>">
	
	<?	$this->buildWorxTypesListOptions($sel_type);	?>
    
    </select>
 <? } //КОНЕЦ МЕТОДА buildWorxTypesList
 	//OPTION
	//построить набор OPTIONS для списка типов работ
 	function buildWorxTypesListOptions($sel_type=false) {
	
		//если получили предмет работы на латинице, извлечём оригинальное значение из таблицы:
		if ($sel_type and preg_match("/[a-zA-Z]/",$sel_type)) {
			global $Tools;
			$sel_type=$Tools->convertField2CPU( "diplom_worx_types",
							   "type", //имя поля c данными на кириллице
							   $sel_type //входящее значение поля для конвертации							   
							 ); //echo "<option>sel_type= $sel_type</option>";
		}
		global $catchErrors;$nl; //nl - визуальный перенос строки в клиентском скрипте
		
		$qSelTps="SELECT number, type FROM diplom_worx_types ORDER BY type ASC";
		$wtps=mysql_query($qSelTps);
		$wtns=mysql_num_rows($wtps);
		//$catchErrors->select($qSelTps);
		//если автор:		
		if ($_SESSION['S_USER_TYPE']=='author') {
			$qSel="SELECT number FROM ri_worx WHERE author_id = $_SESSION[S_USER_ID]"; 
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, buildWorxTypesList","qSel",$qSel);
			$sel_rows=(mysql_num_rows($rSel))? mysql_num_rows($rSel):"0";

		}else{
			
			$sel_rows=count($arrAll); //var_dump($arrAll);//echo "/ sel_rows= $sel_rows /";
			$arrWTp=array();
			for ($a=0;$a<$sel_rows;$a++) { 

				foreach ($arrAll[$a] as $key=>$val2) {
					
					if ( $key=="work_type" &&
						 !($arrAll[$a]['work_table']=="ri_worx" && $_SESSION['FILTER_WORX_AFFILIATION']=="own") &&	
						 !($arrAll[$a]['work_table']=="diplom_zakaz" && $_SESSION['FILTER_WORX_AFFILIATION']=="alien")
					   ) { //echo "<div>$key=>$val2</div>";
						//если есть работы текущего типа, инкременируем их количество:
						(array_key_exists($val2,$arrWTp))? $arrWTp[$val2]++:$arrWTp[$val2]=1;//if ($show_worx_values) echo " \$arrWTp[$val2]= ".$arrWTp[$val2]."<br>";
					}
				} $allWCount+=$arrWTp[$val2];
			}
			$allWCount=0;
			foreach ($arrWTp as $key=>$val) {
				$allWCount+=$val;
			}
		}
	?><option value="0" selected>Все типы работ <? 

	  	if ($show_worx_values) {?>(<? 
		
		if ($allWCount) echo $allWCount;
		else echo ($sel_rows)? $sel_rows:"0";?>)<?  
		
		}?></option><?  echo $nl;  	
	  
	  	if ($wtns){ 
		
			for ($i=0;$i<$wtns;$i++) { 
				
				$typework=mysql_result($wtps,$i,'type');
				
				//$test_conditions=true;
				if ($test_conditions) echo "<div>sel_type= $sel_type<br>typework= $typework</div>";
				
				?><option value="<?=$typework?>"<? 
	  		//выделить полученный тип работы в списке:
			if ( strtolower($sel_type)==strtolower($typework) ||
				 (!$sel_type&&$_REQUEST['work_type']==$typework)
			   ){?> selected<? }?>><?
			   
			   	echo $typework;
				
				if ($show_worx_values) {?> (<?
				   //получим количество работ данного типа:
					if ( $_SESSION['S_USER_TYPE']=='author'&&$sel_rows ) { 	
	
						$qSel2=$qSel."
   AND work_type = '$typework'";
						$rSel2=mysql_query($qSel2);
						$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, buildWorxTypesList()","qSel2",$qSel2);
						echo(mysql_num_rows($rSel2))? mysql_num_rows($rSel2):"0";
						//$catchErrors->select($qSel2);			   
				   
					}elseif($_SESSION['S_USER_TYPE']=='worker') {
						
						$tcount=0;
						foreach($arrWTp as $type=>$val) {
							//если тип-элемент массива = типу работы из таблицы diplom_worx_types
							if ($type==$typework) {
								//if ($show_worx_values) echo " type= $type, typework= $typework, tcount= $tcount, val= [$val]";
								$tcount=$val;
							}
						} 
						echo ($tcount)? $tcount:"0";
			   		
					}?>)<? 
				
				}?></option><? echo $nl; //физический перенос строки (только под клиентом)
			}
		}?><option value="Прочее">Прочее</option><?
	}	//КОНЕЦ МЕТОДА buildWorxTypesListOptions
 	//раcсчитать проводки по заказу (ВСЕ (+ подтверждённые)):
	function calculateOrderPayment($ri_basket_id,$ok) {
	
		global $catchErrors;
		//echo "<div>[calculateOrderPayment] ri_basket_id= $ri_basket_id</div>";		
		$qSel="SELECT summ FROM ri_payments WHERE ri_basket_id = $ri_basket_id"; 
		if ($ok) $qSel.=" AND payment_status = 'OK'";
		//$catchErrors->select($qSel,1);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, calculateOrderPayment()","qSel",$qSel);
		if (mysql_num_rows($rSel)) {
			while ($arr = mysql_fetch_assoc($rSel)) $summ+=$arr['summ'];
			return $summ;
		}
	} //КОНЕЦ МЕТОДА
 	//рассчитать/извлечь стоимость работы:
	function calculateWorkPrice	($work_table,$work_id,$close_tag=false) {
		
		global $catchErrors,$Messages,$Tools;
		global $price_ratio; //извлекаем из connect_db

		$work_id=$Tools->clearToIntegerAndStop($work_id);
		
		//если не получили таблицу или идентификатор работы:
		if (!$work_table||!$work_id) {
				
				if (!$work_table) $mText.="<p>имя таблицы-источника работы</p>";
				if (!$work_id) $mText.="<p>id работы</p>";
		
				$Messages->sendEmail ( "test@edicationservice.ru",
						 "sale@referats.info",
						 "sale@referats.info",
						 "ОШИБКА извлечения данных",
						 "Не получаны данные: $mText<hr>Метод: class.Worx->calculateWorkPrice()",
						 $alert_text
					   );

		
		}
		
		   //если не подключались через connect_db (напримет, при загрузке с другого домена), получим коэффициент:
		   if (!$_SESSION['diplom_zakaz_price_average']) $this->setPriceAverage(); 
		   if (!$price_ratio) $price_ratio=$this->setPriceRatio();

		//echo "<div>work_table= $work_table<div>";
		if ($work_table=="diplom_zakaz") {
		//расчитаем...
		$qSel="SELECT summ FROM matrix_ourcosts, diplom_zakaz
 WHERE diplom_zakaz.number = znum
   AND source_partner_id = partner_id
   AND znum = $work_id";
		   $field='summ';
		   $average=$_SESSION['diplom_zakaz_price_average']; 
		}elseif ($work_table=="ri_worx"){
			
			if ($close_tag) { echo ">";?>C<? }
			
			$qSel="SELECT work_price FROM ri_worx
 WHERE number = $work_id";
			$field='work_price';
			$average=100/$price_ratio; //0,8
		}
		$rSel=mysql_query($qSel);
		//$catchErrors->select($qSel);
		$funcMess="		
		class: $Worx 
		================================================================
		\$work_id= $work_id";
		
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, calculateWorkPrice()","qSel",$qSel,"calculateWorkPrice",$funcMess);
		//если не нашли цену в8 матрице, поищем в основной таблице:
		if (!mysql_num_rows($rSel)&&$field=='summ'){
			$qSel="SELECT ourcost FROM diplom_zakaz
 WHERE number = $work_id";
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, calculateWorkPrice()","qSel",$qSel,"calculateWorkPrice",$funcMess);
			$field='ourcost';
		}
		//извлекаем/расчитываем стоимость:
		$cost=(mysql_num_rows($rSel))? round(mysql_result($rSel,0,$field)/$average):"Не установлена";
		return $cost;
	} //КОНЕЦ МЕТОДА calculateWorkPrice
	//для выбранной работы в ri_worx:
	function calculateLocalPrice($work_id) {
		
		global $price_ratio,$Tools; //указан в connect_db.php		
		
		$work_id=$Tools->clearToIntegerAndStop($work_id);

		return $this->calculatePureLocalPrice($work_id)/100*$price_ratio;
		
	} //КОНЕЦ МЕТОДА calculateLocalPrice
	//цена автора для выбранной работы в ri_worx:
	function calculatePureLocalPrice($work_id) {
		global $catchErrors,$Tools;
		$work_id=$Tools->clearToIntegerAndStop($work_id);
		$qSel="SELECT work_price FROM ri_worx WHERE number = $work_id";
		//echo "<div>$qSel</div>";
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, calculatePureLocalPrice()","qSel",$qSel);
		return mysql_result($rSel,0,'work_price');
	} //КОНЕЦ МЕТОДА
	//проверить наличие директории для файлов автора:
	function checkAuthorFilesDir() {
		
		global $catchErrors;

		$user_dir=$_SESSION['DOC_ROOT']."/".$_SESSION['S_USER_ID'];
		//создать директорию:
		if (!file_exists($user_dir)) {
			$mkdir=mkdir($user_dir,0777);
			//если не удалось создать директорию:
			if (!$mkdir) $catchErrors->sendErrorMess ($errSubj,"Не создана директория для загрузки файлов"); 
		}
	} //КОНЕЦ МЕТОДА checkAuthorFilesDir
	//конвертируем id id заказов в id id работ:
	function convertArrOrdersIDsToWorxIDs($arrOrdersIDs) { //var_dump($arrOrdersIDs);
		$arrWorxIDs=array();
		if (count($arrOrdersIDs))
			foreach($arrOrdersIDs as $order_id) {
				//echo "<div>\$arrOrdersIDs[$i]=".$arrOrdersIDs[$i]."</div>";
				$arrWorxIDs[]=$this->getWorkID($order_id);
			}
		if (count($arrWorxIDs)) {
			$arr=array_unique($arrWorxIDs);
			$this->works_value=count($arr);
			return $arr;
		}else $this->works_value="0";
	} //КОНЕЦ МЕТОДА
	//delete single file
	function deleteSingleFile($loadPage) {
		
		global $catchErrors,$Messages;
		
		/*?><div class="paddingBottom10 txtRed">Удаляем файл...</div><?*/
		if ($handle = opendir($tDir=$_SESSION['DOC_ROOT']."/".$_SESSION['S_USER_ID'])) {
			//echo "handle=".$handle."<br>";
			//echo "readdir= ".readdir($handle)."<br>";
			//$i=-1;//ПОТОМУ что сначала идут "." и ".."
			while (false !== ($entry = readdir($handle))) { 
				//echo "<div>REQUEST['del_file_name']= $_REQUEST[del_file_name]<br>i= $i</div>entry= $entry";
				//				
				if ($entry==$_REQUEST['del_file_name']) {
				
					//echo "<h4>while is here.</h4>";
				
					//в данном случае в массив добавляется не ID, работы, а имя файла.
					if (isset($_SESSION['TEST_MODE'])) { //echo "i= $i";?><div class="padding4">Удаляем файл <?=$entry?> в тестовом режиме...</div><? }
					else { //удалим файл: 
						
						$del_file=unlink($tDir."/".$entry);
						if (isset($_SESSION['TEST_MODE'])) echo '<div class="padding4">Удаляем файл '.$del_file.'!</div>';
						if (!$del_file) $catchErrors->sendErrorMess ("Ошибка удаления файла...","Файл ".$tDir."/".$entry." не удалён..."); 
						//ЕСЛИ работа удаляется автором:
						elseif ($_SESSION['S_USER_TYPE']=='author') {
							//сообщим админу:
							$Messages->sendEmail($toAddress,
												 $_SESSION['S_USER_EMAIL'],
												 $_SESSION['S_USER_EMAIL'],
												 "Автором id $_SESSION[S_USER_ID] удалена работа &laquo;$entry&raquo;",
												 "Работа удалена ".date('Y-m-d H:i:s').".",
												 false //стандартный alert
												);
						}
						break;
					}
				} //$i++;
			}
		  closedir($handle);
		  if (!$entry||$entry==$_REQUEST['del_file_name']) {
			  //удаляем запись из таблицы работ:
			  $qDel="DELETE FROM ri_worx WHERE work_name = '$_REQUEST[del_file_name]' AND author_id = $_SESSION[S_USER_ID]";
			  $catchErrors->delete($qDel,"1");
			  //echo "<div>$qSel</div>";
		  }
		  $Messages->alertReload("Удалён файл:\\n$entry",$loadPage);

		}else{ //если не пробрались в директорию с файлом....

			$catchErrors->sendErrorMess ("Не получен доступ к директории для загрузки файла","Не выполнена функция opendir($tDir)."); 

		} 
		
	} //КОНЕЦ МЕТОДА deleteSingleFile
	//
	function dropFilterPayment() {
		
		global $order_id;
		global $user_id;?>
<div class="txt120 paddingBottom4"><img src="<?=$_SESSION['SITE_ROOT']?>images/filter_order.png" width="22" height="16" hspace="4" align="absmiddle" />Проводки <?
		if ($order_id){	?>по заказу id <strong><?=$order_id?></strong><?
		}else{
			if ($user_id) {?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle" />заказчика id <? echo $user_id; }
		}?>.&nbsp; &nbsp; [<a href="?<? 
		if ($_SESSION['S_USER_TYPE']=="customer"){?>section=customer&amp;mode=payments<? }
		else{?>menu=money<? }?>">сбросить фильтр</a>]</div><?
		
	}
	//проверить, чтоб текущий элемент был новым
	function entryIsNew($arrElem,$full_path_to_file) {
		
		//$test_func_output=true;
		if ($_SESSION['TEST_MODE']&&$test_func_output) {
			
			?><h4 style="margin-bottom:0;"><nobr>{entryIsNew(<span class='noBold'><? var_dump($arrElem);?>,<?=$full_path_to_file?>)</span>}</nobr></h4><?		
			
			echo "<div class='padding10' style='border-color:#33FF99; background-color:lightskyblue'>";
			
			if (!is_array($arrElem)) echo "<span class='txtGreen'>Не массив: [".is_array($arrElem)."]</span>"; 
			
			else {
				echo "<div class='txtGreen'>МАССИВ<br>";
				if (!in_array($full_path_to_file,$arrElem)) echo "<div style='padding:4px;' class='iborder'>$full_path_to_file не в массиве...</div>";
				foreach($arrElem as $key=>$val) echo "<div style='padding:4px;' class='iborder'>$key => $val</div>"; 
				echo "</div>";
			} echo "</div>";
		}
		
		if( !is_array($arrElem) ||
			!in_array($full_path_to_file,$arrElem)
		  ) return true;
	}
	//извлечь файлы из архива:
	function extractArchiveFiles( $source_type, //источник файла (mail_/znum_)
								  $znum, //id заказа-источника файла
								  $file, //имя файла
								  $full_path_to_file, //полный путь к файлу
								  $mail_filetime, //время последнего изменения файла
								  $filesize, //6. - размер файла
								  $fext //расширение
								) {							
		
		global $Tools;
		//for febugging:		
		$mess=" [extractArchiveFiles($full_path_to_file)]";
		//если zip:
		if ($fext==".zip") $this->saveAllFilesArray("zip",$source_type,$znum,$full_path_to_file,$mail_filetime,$filesize,$mess); //добавить файл в массив
		//rar:
		if ($fext==".rar") $this->saveAllFilesArray("rar",$source_type,$znum,$full_path_to_file,$mail_filetime,$filesize,$mess); //сохранить файл в массиве
		
	} //	конец МЕТОДА extractArchiveFiles	
	//найти и извлечь в массив приаттаченные файлы:	
	function extractFilesFromLetter($source=false) { //$test_func=true;

		//отладочная информация:
		if (isset($_SESSION['TEST_MODE'])) {
			if ($test_func){?><h4 style="margin-bottom:0;"><nobr>{extractFilesFromLetter()}</nobr></h4><? }
			if (isset($_REQUEST['show_attach'])) echo "<div>source= $source</div>";
		}
		
		global $catchErrors;
		global $Tools;
		
		$work_id=$Tools->clearToIntegerAndStop($_REQUEST['work_id']);
		//отладочная информация:
		if (isset($_SESSION['TEST_MODE'])) echo "<div>\$_REQUEST['work_id']= $_REQUEST[work_id], work_id= $work_id</div>";
		
		//получить письма с аттачментами:
		$squery=", inemail, toemail, type, zakaz, attach, directory, respondent_in, respondent_to, data";
		$qSel="SELECT number$squery FROM diplom_mailserver WHERE zakaz = $work_id";
		$qSel.="
   AND respondent_to LIKE '%customer%' "; //отправлено заказчику
		$qSel.="
   AND attach >0 "; //только с аттачментами
   		$qSel.="
ORDER BY number";
		//отладочная информация:
		//$test_sql=true;
		if (isset($_REQUEST['test'])) $catchErrors->select($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
		$rSel=mysql_query($qSel);
		
		//отладочная информация:
		//$test_letters=true;
		if ($_SESSION['TEST_MODE']&&$test_letters) {
			
			//$catchErrors->select($qSel);?>
		<table cellspacing="0" cellpadding="4" class="iborder" rules="rows">
  <tr>
    <td>number </td>
    <td>inemail </td>
    <td>toemail </td>
    <td>type </td>
    <td>zakaz </td>
    <td>attach </td>
    <td>directory </td>
    <td>respondent_in </td>
    <td>respondent_to </td>
    <td>data </td>
  </tr>
  			<? 	while ($arr = mysql_fetch_assoc($rSel)) {?>
  <tr>
    <td><?=$arr['number']?></td>
    <td><?=$arr['inemail']?></td>
    <td><?=$arr['toemail']?></td>
    <td><?=$arr['type']?></td>
    <td><?=$arr['zakaz']?></td>
    <td><?=$arr['attach']?></td>
    <td><?=$arr['directory']?></td>
    <td><?=$arr['respondent_in']?></td>
    <td><?=$arr['respondent_to']?></td>
    <td><?=$arr['data']?></td>
  </tr>
  			<? 	}?>
</table>

	<?	}
		
		$arrLetters=array();
		$rws=mysql_num_rows($rSel);
		
		if ($rws) { 
			//отладочная информация:
			//$test_start_analysis=true;
			if ($_SESSION['TEST_MODE']&&$test_start_analysis) echo "<hr size='3' color='#0000FF' noshade><H4 class='txtOrange'>Переходим к циклу анализа сообщений с аттачментами</H4>";
			
			//создать массив сообщений:
			for ($i=0;$i<$rws;$i++) {
				
				$zakaz=mysql_result($rSel,$i,'zakaz'); 
				$lnum=mysql_result($rSel,$i,'number'); 
				$dir=round($lnum/1000);
				$path=$_SESSION['DOC_ROOT_DIPLOM']."letters/$dir/";
				$filename=$path.$lnum; 
				//время последнего изменения файла. Нужно для последующей сортировки массива файлов в профайле работы.
				$mail_filetime=mysql_result($rSel,$i,'data') or die("<pre>$qSel</pre>"); 
				//получить массив аттачментов:
				$message=$Tools->getAttachesArray($filename,"extractFilesFromLetter");
				//если есть аттачменты:
				if (count($message)) { //echo "<div>count(\$message)</div>";
					//перебор аттачментов
					foreach($message as $file => $file_content) { 
					
						//$file - имя файла
						//$file_content - контент
						
						$size=round(strlen($file_content)/1024); 
					
						if ($size>0) {

							$full_path_to_file="$filename:".$file; //$path.$lnum:[имя_файла (аттачмента)]
							//
							$mess=" [extractFilesFromLetter()]";

							//выяснить тип файла:
							$extype=$Tools->detectExt($file,$fext);

							//если стандартного формата (распакован):
							if ($extype=="office") $type=$fext; //расширение файла
							//если запакован или неизвестный формат:
							else {
								
								switch ($fext)  { 
							
									case ".zip":
										$type="zip";
											break;
							
									case ".rar":
										$type="rar";
											break;
							
									default:
										$type="unknown";
										
								}
							}
							//отладочная информация:																
							if (isset($_REQUEST['test']))
								echo "<br><div class='iborder padding4'>[$i]zakaz= $zakaz<br>path/lnum= $path$lnum<br>full_path_to_file= $full_path_to_file</div>";
							$this->saveAllFilesArray( $type, //тип (расширение файла)
													  "mail_",
													  $_REQUEST['work_id'],
													  $full_path_to_file, //см. выше
													  $mail_filetime,
													  $size,
													  $mess
													); //добавить файл в массив
						}
					}
				}
			} //отладочная информация:
			if (isset($_SESSION['TEST_MODE'])) {
				if (!count($message)) echo "<hr size='3' color='#0000FF' noshade><H4 class='txtOrange'>!count(\$message)</H4>";
				if (!is_array($message)) echo "<hr size='3' color='#0000FF' noshade><H4 class='txtOrange'>!is_array(\$message)</H4>";
				if ($test_start_analysis) echo "<hr size='3' color='#0000FF' noshade><H4 class='txtOrange'>Закрыли цикл анализа сообщений с аттачментами</H4>";
			}
		}
	}	//	конец МЕТОДА extractFilesFromLetter
	//
	function extractWorksDataDiplom( $ExcludeBasket,
									 $and_diplom, //если не установлен фильтр чужих заказов
									 $andOrdersIDsWithFiles //если не установлен фильтр чужих заказов
								   ) {
	
		global $catchErrors;
		
		//достаём работы из diplom_zakaz:
		$qSel="SELECT number, 
   subject, 
   predmet, 
   typework 
  FROM diplom_zakaz
 WHERE number > 0";
		
		if ($ExcludeBasket) $qSel.="
   AND diplom_zakaz.number $ExcludeBasket "; 

		$qSel.="$and_diplom". //только закрытые, выполненные или восстановленные
"$andOrdersIDsWithFiles".//записи только тех заказов, файлы которых обнаружены в diplom_zip
"
ORDER BY diplom_zakaz.subject ASC";
		if (isset($_REQUEST['test_sel'])) 
			$catchErrors->select($qSel);
		//проверим общее количество записей:
		$r=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, findAllWorx()","qSel",$qSel);
		//$catchErrors->select($qSel,"extractWorksDataDiplom");
		if (mysql_num_rows($r)) { $cntr=0; //чиста для отладки
			//заполняем массив:
			while ($arr = mysql_fetch_assoc($r)) {
				if (preg_match("/[0-9]/",$arr['predmet'])) intval($arr['predmet']);
				//echo "[$arr[predmet]] (".gettype($arr['predmet'])."), ";
				if ($arr['predmet']) {
					$prdm=$arr['predmet']+1; $arr['predmet']=$prdm-1;
					if (gettype($arr['predmet'])==integer&&$arr['predmet']>0) { 
						//получим предмет из diplom_worx_topix:
						$qSelP="SELECT predmet FROM diplom_worx_topix WHERE number = ".$arr['predmet']; 
						$rSelP=mysql_query($qSelP);
						$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelP",$qSelP);
						if (mysql_num_rows($rSelP)) $predmet=mysql_result($rSelP,0,'predmet');
						//if ($_SESSION['TEST_MODE']&&$cntr<20) echo "<div>predmet OK! ($predmet)</div>";

					}else {
						
						//if ($_SESSION['TEST_MODE']&&$cntr<20) echo "<div>predmet(?) ".$arr['predmet']." gettype(\$arr['predmet'])= ".gettype($arr['predmet'])."</div>";
						$predmet=$arr['predmet'];
					}
					
				}else $predmet="";
				//
				$arrAll[]=array('work_table'=>'diplom_zakaz',
								'work_id'=>$arr['number'],
								'work_subject'=>$arr['subject'],
								'work_type'=>$arr['typework'],
								'work_area'=>$predmet										
							   ); $cntr++; //чиста для отладки
			}
			return $arrAll;
		}
	} //КОНЕЦ МЕТОДА
	//
	function extractWorksDataReferats( $ExcludeBasket,
									   $and_referats, //если не установлен фильтр чужих заказов
									   $author_id=false
									 ) {
	
		global $catchErrors;
		//достаём работы из Referats:
		$qSel="SELECT * FROM ri_worx WHERE number >0 
$and_referats ";

		if ($ExcludeBasket) $qSel.="
   AND number $ExcludeBasket"; 

		//если фильтруем по автору работы:
		if ($author_id) $qSel.="
   AND author_id = $author_id";

				$qSel.="
ORDER BY work_name ASC";
		if (isset($_REQUEST['test_sel'])) 
			$catchErrors->select($qSel);
		//проверим общее количество записей:
		$r=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, findAllWorx()","qSel",$qSel);
		//$catchErrors->select($qSel,"extractWorksDataReferats");
		if (mysql_num_rows($r)) {
			//дополняем массив:
			while ($arr = mysql_fetch_assoc($r))
				$arrAll[]=array('work_table'=>'ri_worx',
								'work_id'=>$arr['number'],
								'work_subject'=>$arr['work_name'],
								'work_type'=>$arr['work_type'],
								'work_area'=>$arr['work_area']										
							   );
			//возвращаем массив данных:
			return $arrAll;
		}
	} //КОНЕЦ МЕТОДА
	//бывш. метод accessToFiles
	//отфильтровать проводки по выбранному заказу:
	function filterByOrder($order_id){
		
		$table=$this->getWorkTable($order_id);

		global $Blocks;
		//отображаем результаты фильтра и ссылку сброса:
		$Blocks->showFilterResults( "payments", 	//тип полученных объектов
								  "заказу",			//объект, по которому фильтровали
								  $order_id,		//...его id...
								  $actor_type,		//если фильтровали по Заказчику/Сотруднику/Автору
								  $actor_type_id	//...его id...
								);
		if ($test_filter){?><div><b>Результаты фильтра...</b></div><? }?>
    
<div class="paddingBottom4 paddingTop4">
  <div class="padding8 iborder borderColorGray" style="background-color:#eaffea;">      
  <div class="paddingBottom6">    
	Цена работы:  <strong><?	
	
	//рассчитать/извлечь стоимость работы:
	$price=$this->calculateWorkPrice ($table,$this->getWorkID($order_id),$close_tag);
	echo($price)? $price:"0";
	
	?></strong>, 
    
    Оплачено: <strong><?
	
	//получить:
	$paid=$this->calculateOrderPayment($order_id,false);
    echo($paid)? $paid:"0";
	
	?></strong>, 
    
  Подтверждено: <? 	
	//получить:
	$paidOK=$this->calculateOrderPayment($order_id,true);
	
	?><strong class="txt<? if ($paidOK<$paid){?>Red<? }else echo "Green"?>"><?
	
    echo($paidOK)? $paidOK:"0";
	
	?></strong><?  
	if ($paidOK>=$price){
		?><img src="<?=$_SESSION['SITE_ROOT']?>images/submit_green.gif" width="16" height="16" hspace="4" align="absmiddle" title="Оплачено полностью!" /><? 
		if (!$this->getWorkSent($order_id)) {?><img src="<?=$_SESSION['SITE_ROOT']?>images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" /><span class="txtRed"><?			
        	if ($_SESSION["S_USER_TYPE"]!="customer"){?>
  Заказчику не отослана<? }
			else {?>Не доставлена<? }?>!</span><?
		}

	}else {?>, Остаток к оплате: <strong class="txtOrange"><?=($price-$paidOK)?></strong>
 <? }?></div>
  <div>Тема работы: <strong><? 

	//получить имя работы:
	echo $this->getWorkName($table,$this->getWorkID($order_id));?></strong>.</div>
	<? 	if ($_SESSION['S_USER_TYPE']!="customer") {?>    
    <hr size="1">
  <div><a href="?menu=messages&amp;order_id=<?=$order_id?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/mails.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" />Загрузить сообщения по заказу...</a> &nbsp; <a href="?menu=messages&amp;action=compose&amp;order_id=<?=$order_id?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/mess_new.gif" width="17" height="16" hspace="4" border="0" align="absmiddle" />Создать сообщение по заказу...</a></div>
	<? 	}?>  
</div> 
</div>
<?  } //КОНЕЦ МЕТОДА  	
	//найти всё работы, как в diplom_zakaz, так и в ri_workx:
	function findAllWorx( $work_subject,
						  $work_type,
						  $work_area,
						  $arrDplomZakazIDsWithFiles,
						  &$arr //массив с результатами поиска
						){ 	//echo "<div>findAllWorx() open!</div>";
							//echo "<h4>work_type= $work_type</h4>";
	
		global $author_id;
		global $catchErrors;
		global $dbSearch;
		global $limit_start;
		global $limit_finish;
		global $show_all; //показать все работы - и свои, и чужие
		global $skip_diplom_zakaz;
		global $Tools;
	

		//если получили тип работы на латинице, извлечём оригинальное значение из таблицы:
		if ($work_type and !preg_match("/[а-яА-Я]/",$work_type)) { //echo "<h4>work_type= $work_type</h4>";
			$work_type=$Tools->convertField2CPU( "diplom_worx_types",
							   "type", //имя поля c данными на кириллице
							   $work_type //входящее значение поля для конвертации							   
							 ); //echo "<h4>work_type= $work_type</h4>";
		}
		//если получили предмет работы на латинице, извлечём оригинальное значение из таблицы:
		if ($work_area and !preg_match("/[а-яА-Я]/",$work_area)) {
			$work_area=$Tools->convertField2CPU( "diplom_worx_topix",
							   "predmet", //имя поля c данными на кириллице
							   $work_area //входящее значение поля для конвертации							   
							 ); //echo "work_area= $work_area";
		}

		$_SESSION['S_SORT']=($_REQUEST['sort'])? $_REQUEST['sort']:"subject";
		
		$order_and_limit="
ORDER BY $_SESSION[S_SORT] ";
		if ($limit_finish) $order_and_limit.="LIMIT $limit_start, $limit_finish";
		
		//инициализируем консолидированный массив работ:
		$arrAll=array();

		if ($_SESSION['FILTER_WORX_AFFILIATION']!="alien"||$show_all) {

			//только содержащие файлы:
			$andOrdersIDsWithFiles="
   AND diplom_zakaz.number IN (".implode(",",$arrDplomZakazIDsWithFiles).") ";
		}
		//ВНИМАНИЕ! Тема работы может остутствовать. Это значит - показать работы на любую тему по указанному предмету.
		//echo "<h4>work_type= $work_type</h4>";
		//тип работы:
		if ($work_type) {
			
			//извлечём массив данных:
			$qSel="SELECT DISTINCT `type` FROM diplom_worx_types";
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
			if (mysql_num_rows($rSel)) {
				$arrTypes=array();
				//$arrTypes[]="Диплом"; //добавляем вручную,т.к. в таблице вместо этого типа указан "Дипломная работа"
				while ($arr = mysql_fetch_assoc($rSel)) $arrTypes[]=$arr['type'];
				$inOddsType=" OR diplom_zakaz.typework NOT IN ('".implode("','",$arrTypes)."')";
			}
			//если не авторские: 
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="alien"||$show_all) $and_diplom.=" 
   AND ( diplom_zakaz.typework = '$work_type' 
   		 $inOddsType
       )";  
	   		//echo "<div>and_diplom= $and_diplom</div>";
			//если не собственные:
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="own"||$show_all) $and_referats.="
   AND ( work_type = '$work_type' OR work_type = '' OR work_type = '0' )";
   			//echo "<div>and_referats= $and_referats</div>";
		}
		//предмет:
		if ($work_area){
			//извлечём массив данных:
			$qSel="SELECT number FROM diplom_worx_topix ORDER BY number DESC LIMIT 0,1";
			//$catchErrors->select($qSel);
			$rSel=mysql_query($qSel); 
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
			if (mysql_num_rows($rSel)) $orOddsArea="OR diplom_zakaz.predmet < 1 OR diplom_zakaz.predmet > ".mysql_result($rSel,0,'number');

			//если не авторские: 
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="alien"||$show_all) {
				
				//получить id предмета:
				$q="SELECT number FROM diplom_worx_topix 
 WHERE predmet = '$work_area'";
 				//$catchErrors->select($q,"<h3>получить id предмета</h3>");
				$r=mysql_query($q);
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","q",$q);
				$nrows=mysql_num_rows($r);
				if ($nrows) $and_diplom.=" 
   AND ( diplom_zakaz.predmet = '".mysql_result($r,0,'number')."' $orOddsArea )"; //echo "<div>nrows= $nrows<hr>and_diplom= <pre>$and_diplom</pre></div>";
			}
			//если не собственные:
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="own"||$show_all) $and_referats.=" 
   AND ( work_area = '$work_area' OR work_area = '' OR work_area = '0' )";
		}

		//если использовали поиск по сайту.
		if ($work_subject) { //echo "<h1 style='padding:4px;' class='iborder'>work_subject= $work_subject</h1>";
			
			//передаём поисковому классу искомое название: 
			$dbSearch->string_to_search=$work_subject;
			//возвращаем массив найденных заказов:
			if ( (!$skip_diplom_zakaz && //ищет не автор среди своих работ
				  $_SESSION['FILTER_WORX_AFFILIATION']!="alien"  //ищем не среди чужих заказов
				 )||$show_all
			   )
			$dbSearch->makeSearchInTables("number","subject","diplom_zakaz","$and_diplom $andOrdersIDsWithFiles");
			//echo "<div>makeSearchInTables.diplom_zakaz</div>";
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="own"||$show_all)
			$dbSearch->makeSearchInTables("number","work_name","ri_worx",$and_referats);
			//echo "<div>makeSearchInTables.ri_worx</div>";
			//извлекаем массив найденных значений:
			$arr=$dbSearch->sortFoundedResults();
			//var_dump($arr);
			
		}else{	//ВНИМАНИЕ!
				//Условие выполняется также при псевдопоиске, когда выбран тип работы, но не указана её тема.

			//выясним, сколько заказов:
			if ($_SESSION['S_USER_TYPE']=="customer"){
				//заказы:
				$qInBsk="SELECT work_id FROM ri_basket WHERE user_id = $_SESSION[S_USER_ID]";
				$rInBsk=mysql_query($qInBsk);
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, findAllWorx()","qInBsk",$qInBsk);
				if (mysql_num_rows($rInBsk)) {
					$arrInBasket=array();
					while ($arr = mysql_fetch_assoc($rInBsk)) $arrInBasket[]=$arr['work_id'];
					$ExcludeBasket="
	NOT IN (".implode(",",$arrInBasket).")";
				}
			}
			//если не авторские:
			if (($_SESSION['FILTER_WORX_AFFILIATION']!="alien"||$show_all)&&!$author_id) { 	
				//echo "<h5>extractWorksDataDiplom</h5>";
				//echo "<div>and_in_zip= <pre>$andOrdersIDsWithFiles</pre></div>";
				//достаём работы из diplom_zakaz:
				$arrAllDiplom=$this->extractWorksDataDiplom ( $ExcludeBasket, //только если заавторизован заказчик
														 	  //$and_completed, //если не установлен фильтр чужих заказов
														 	  $and_diplom, //если не установлен фильтр чужих заказов
														 	  $andOrdersIDsWithFiles //все заказы diplom_zakaz с файлами
													   		); 
				
			}	
			//если не собственные
			if ($_SESSION['FILTER_WORX_AFFILIATION']!="own"||$show_all) {
				//echo "<h5>extractWorksDataReferats</h5>";
				//достаём работы из Referats:
				$arrAllReferats=$this->extractWorksDataReferats ( $ExcludeBasket, //только если заавторизован заказчик
																  $and_referats, //если не установлен фильтр чужих заказов
																  $author_id
																);
				############################################################
				
			}
			//объединяем массивы, с предварительной проверкой их существования
			//ВНИМАНИЕ! Первый аргумент - массив объединяемых массивов
			$arrAll=$Tools->arraysMergeAndUnify(array($arrAllDiplom,$arrAllReferats));
			
			if (isset($_GET['arrAll'])){
				var_dump('<h1>arrAll</h1><pre>',$arrAll,'</pre>'); 
				die();	
			}
			
			//$test_arrays1=true;
			if ($test_arrays1) {
				foreach($arrAllDiplom as $key=>$order_id) 
					echo "<div>$key=>$order_id</div>";
				echo "<hr>";
				foreach($arrAllReferats as $key=>$order_id)	
					echo "<div>$key=>$order_id</div>";
			}
			//$test_arrays2=true;
			if ($test_arrays2) 
				foreach($arrAll as $key=>$order_id) echo "<div>$key=>$order_id</div>";
		} 

		//$test_array=true;
		if ($test_array) {
			$t=1;
			//if ($author_id) 
				foreach($arrAll as $preval) {
					echo "<br><br>t= $t<hr>";
					foreach($preval as $key=>$val) echo "<div>$key=>$val</div>";
					$t++;
				
			}
		}
		
		return $arrAll;
	} //КОНЕЦ МЕТОДА
	//получить массив данных работы:
	function getWorkFilesData() {
	
		//сформировать массивы файлов из директории заказа:
		$this->scanEntries($_REQUEST['work_id']);
		$_SESSION['test_work_id']=$_REQUEST['work_id'];
		//сформировать массив файлов, извлечённых из аттачментов:
		//получить $this->saveAllFilesArray() -> saveAllFilesArray() -> $this->savedFiles
		$this->extractFilesFromLetter(); 
		//if (isset($_SESSION['TEST_MODE'])) die("Остановили загрузку...");	
		//отсортировать по ключам (время последнего изменения файла) в обратном порядке:
		krsort($this->savedFiles);
		// 
		$savedFiles=$this->savedFiles;
		//тип (расширение) файла
		//источник (mail/zip)
		//id заказа
		//полный путь к аттачемну: путь к файлу сообщения: имя файла в аттачменте
		//время создания аттачмента
		//размер файла
		//
		//отладочная информация:
		//$test_arr=true;
		if ($test_arr)
		foreach ($savedFiles as $key=>$arr) {		
			if (is_array($arr))	foreach ($arr as $key=>$val) echo "<div>[$key] => $val</div>"; 
		}
		
		//трансформировать массив:
		$workFiles=array();
	
		//ВНИМАНИЕ! В массиве присутствуют файлы только текущего заказа ($work_id):	
		foreach ($savedFiles as $filetime=>$arr_data) {

			$separator=(strstr($arr_data['source_type'],"mail"))? ":":"/"; //разделитель
			//извлечь имя файла:
			$file_name=substr(strrchr($arr_data['full_path_to_file'],$separator),1); //имя файла
			//получить массив данных файлов:
			$workFiles[]=array( 'work_id'=> $arr_data['work_id'],
								'source_type'=> $arr_data['source_type'],
								'file_name' => $file_name,
								'ext' => $arr_data['ext'],
								'size' => $arr_data['size'],
								'filetime'=>$filetime,
								'full_path_to_file'=> $arr_data['full_path_to_file'] 
								//для файла в дир. заказа. Для аттачментов содержит ":"
							  );
		}
		return $workFiles;
	} // КОНЕЦ МЕТОДА getWorkFilesData	
	//4. все OK проводки по АВТОРСКИМ заказам:
	function getAllOrdersPaid() {
		
		global $catchErrors;

		//инициируем массив id id работ, заказы на которые есть в таблице заказов.
		//нужно для определения стоимости работы:
		$arrAuthorsWorkIDsInBasket=array();
		//извлечём id id всех работ, по которым есть заказы:
		$qSel="SELECT DISTINCT work_id FROM ri_basket WHERE work_table <> 'diplom_zakaz' ORDER BY work_id ASC";
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getAllOrdersPaid()","qSel",$qSel); 
		$a=0;
		while ($arr = mysql_fetch_assoc($rSel)) {
			$arrAuthorsWorkIDsInBasket[$a]=$arr['work_id'];
			$a++;
		}

		//если есть заказы:
		if (count($arrAuthorsWorkIDsInBasket)) {

			//инициируем массив заказов, подлежащих отсылке
			$arrOrdersToSend=array();
			
			###################
			//$test_payments=true;
			//if ($test_payments) echo "<h4>Всего работ, по которым есть заказы (".count($arrAuthorsWorkIDsInBasket)."): <span class='noBold'>".implode(", ",$arrAuthorsWorkIDsInBasket)."</span></h4>";
			
			//
			foreach($arrAuthorsWorkIDsInBasket as $work_id) {

				//получить стоимость работы и сравнить с суммой подтверждённых проводок:				
				$customer_price=$this->calculateLocalPrice($work_id); //echo "<h5>work_id= $work_id</h5>";

				//получить заказчиков по данной работе:
				$qSelOrder="SELECT user_id,number FROM ri_basket WHERE work_id = $work_id";
 				//$catchErrors->select($qSelOrder);
 				$rSelOrder=mysql_query($qSelOrder);			
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getAllOrdersPaid()","qSelOrder",$qSelOrder);
				$orders_for_work=mysql_num_rows($rSelOrder);
				#################################
				//ЕСЛИ ЕСТЬ заказы данной работы:
				if ($orders_for_work) {
					
					//echo "<br><div>work_id: $work_id, заказов: $orders_for_work</div>";
					//разнесём проводки по заказчикам:
					for	($j=0;$j<$orders_for_work;$j++) {
						//извлечь id заказа:
						$order_id=mysql_result($rSelOrder,$j,'number'); //echo "<div>order_id= $order_id</div>";
						//получить подтверждённые суммы проводок:
						$qSel="SELECT summ,payment_status FROM ri_payments, ri_basket
WHERE  ri_basket_id = ".mysql_result($rSelOrder,$j,'number')."
   AND ri_basket_id =  ri_basket.number 
   AND payment_status = 'OK'
   AND work_id = $work_id";   							
						//
						$rSel=mysql_query($qSel);
						//
						if ($test_payments) {						
							if (mysql_num_rows($rSel)) {
								echo "<div>ПРОВОДКА подтверждена</div>";
								//$catchErrors->select($qSel);
							}else echo "<div class='txtRed'>Проводка не подтверждена...</div>";
						}
						
						$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getAllOrdersPaid()","qSel",$qSel);
						$arrOrdersPaidOK=array();
						$t=0;
						//все подтверждённые проводки данного заказчика по данному заказу:
						while ($arr = mysql_fetch_assoc($rSel)) {
							//получаем подтверждённые суммы проводок:
							if ($arr['payment_status']=="OK") {
								
								$arrOrdersPaidOK[$order_id]+=$arr['summ'];
								//echo "<div>order_id= $order_id, summ= ".$arr['summ']."</div>";
								$t++;
							}
						} //if ($t) echo "<div>\$arrOrdersPaidOK[$order_id]= ".$arrOrdersPaidOK[$order_id].", wprice= $customer_price</div>";
						
						if ($arrOrdersPaidOK[$order_id]>=$customer_price) { 

							//если массив заказчиков по данной работе уже создан, добавляем в него очередного заказчика, иначе - присваиваем ему первое значение:	
							if (count($arrOrdersToSend[$work_id])) array_push($arrOrdersToSend[$work_id],$order_id);
							else $arrOrdersToSend[$work_id]=array($order_id); 

						}
					}
					//echo ($arrOrdersToSend[$work_id])? "<div class='bold txtGreen'>Полностью оплаченные заказы: ".implode(", ",$arrOrdersToSend[$work_id])."</div>":"<div class='txtRed'>Массив полностью оплаченных заказов по работе id $work_id не создан...</div>";
				}
			}
	    }
		
		//возвратим: work_id => order1, order2....
		//$test_array_return=true;
		if ($test_array_return) {
			foreach($arrOrdersToSend as $work_id=>$array)  echo "<br>work_id= $work_id, заказы: ".implode(", ",$array);
		} 
		//конвертируем в сплошной массив полностью оплаченных заказов
		foreach($arrOrdersToSend as $work_id=>$array_orders) {
			for ($i=0;$i<count($array_orders);$i++) {
				$this->arrOrdersPaidFull[]=$array_orders[$i];
				//echo "$array_orders[$i], ";
			}
		}
		return $arrOrdersToSend;
	} //КОНЕЦ МЕТОДА
	//id заказчика:
	function getCustomerID($ri_basket_id) {
	
		global $catchErrors;
				
		$qSel="SELECT user_id FROM ri_basket WHERE number = $ri_basket_id"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getCustomerID()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'user_id');
		
	} //КОНЕЦ МЕТОДА
	//
	function getOrdersToSaleIDs() {
	
		global $catchErrors;
		//
		//извлечём массив данных:
		$qSel="SELECT number FROM diplom_zakaz WHERE ";
		//$qSel.=($znum)? "number = $znum":
		$qSel.="	
status_cycle = 'closed' OR 
       status_cycle = 'made' OR
       status_cycle = 'remade' OR
       status_cycle = 'processed'
ORDER BY number";
		$rSel=mysql_query($qSel); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
		//$arrOrdersToSale=array();
		//инициализируем массив id id заказов с файлами:
		while ($arr = mysql_fetch_assoc($rSel)) $arrOrdersToSale[]=$arr['number'];
		return $arrOrdersToSale;
	}
	//извлечь id id заказов с файлами - как из /zip/, так и приаттаченных:
	function getDplomZakazIDsWithFiles() { //echo "<h1>getDplomZakazIDsWithFiles</h1>";
		
		global $catchErrors;
		global $Tools;		
		
		$tDir=$_SESSION['DOC_ROOT_DIPLOM']."zip";
		//if ($znum) $tDir.="/$znum"; //чтобы пропустить все директории, кроме заказа
		if (isset($_REQUEST['work_id'])) 
			$tDir.="/".$_REQUEST['work_id'];  
		
		if (is_dir($tDir)) { 
		
			$d = dir($tDir);

			//$count=0;		
			//проверим наличие файлов в директории заказа:
			while (false !== ($entry = $d->read())) { 
				
				if ( $entry &&
					 $entry!==0 && 
					 is_numeric($entry) &&
					 in_array($entry,$this->getOrdersToSaleIDs()) &&
					 $entry!="." && 
					 $entry!=".."  
				   )//просканировать директорию:
					$this->scanEntries($entry,false);//,$znum 						
				elseif (in_array($entry,$this->getOrdersToSaleIDs())) echo "[$entry]"; 
			} 
			$d->close();
		}
		
		#########################################################
		//теперь будем проверять наличие приаттаченных файлов:
		$s="SELECT diplom_zakaz_number FROM ri_znums_attaches";
		$r=mysql_query($s);
		//$catchErrors->select($s,"Получить все заказы, содержащие приаттаченные файлы, доступные к продаже");
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","s",$s);
		//получить все заказы, содержащие приаттаченные файлы, доступные к продаже:
		if (mysql_num_rows($r)) 
			while ($arr = mysql_fetch_assoc($r)) 
				$arrDplomZakazIDsWithFilesAttached[]=$arr['diplom_zakaz_number'];
		
		//получить уникальные значения для массивов Zip&Mail:
		//ВНИМАНИЕ! выполняем унификацию массивов по отдельности, т.к. их данные могут понадобиться также раздельно:
		$arrIDsMail=$Tools->arraysDiff(array($arrDplomZakazIDsWithFilesAttached,$this->arrDplomZakazIDsWithFiles),"getDplomZakazIDsWithFiles");
		$this->arrDplomZakazIDsWithFiles=$Tools->arraysDiff(array($this->arrDplomZakazIDsWithFiles,$arrIDsMail),"getDplomZakazIDsWithFiles"); 
		$arrWhole=$Tools->arraysMergeAndUnify(array($arrDplomZakazIDsWithFilesAttached,$this->arrDplomZakazIDsWithFiles),true);

		if (count($arrWhole)) {
			$this->arrWorksFilesMail=$arrIDsMail; //унифицирован
			$this->arrWorksFilesZip=$this->arrDplomZakazIDsWithFiles; //унифицирован
			$this->arrWorksFilesAll=$arrWhole; //объединённый унифицированный массив
		} //echo "<h2>".count($arrWhole)."</h2>";
	
		return $arrWhole; 

	} //КОНЕЦ МЕТОДА getDplomZakazIDsWithFiles
	//извлечь количество заказов данной работы:
	function getWorkOrdersValue ($arrOrdersType,$work_id,$basket=true) { 
	
		global $catchErrors;
		//колич. заказов данной работы
		//извлечём массив данных:
		$qSelBasket="SELECT number FROM ri_basket
WHERE work_id = $work_id";
		if (count($arrOrdersType)&&$arrOrdersType!==false) $qSelBasket.="
   AND number IN (".implode(",",$arrOrdersType).")";
		//$catchErrors->select($qSelBasket);
		$rSelBasket=mysql_query($qSelBasket); 
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelBasket",$qSelBasket); 
		$arrOrdersIDs=array();
		while ($arr = mysql_fetch_assoc($rSelBasket)) $arrOrdersIDs[]=$arr['number'];
		$this->arrWorkOrdersIDs=$arrOrdersIDs;
		$orders_value=mysql_num_rows($rSelBasket);
		if ($orders_value&&$basket) {?><img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" align="absmiddle" border="0" /><? 
		}
		return $orders_value;		
	} //КОНЕЦ МЕТОДА
	//
	function getWorkAreaAndTypeConverted($work_id,$ri_worx=false) {
	
		global $catchErrors;
		$arrWorkAreaAndType=array();
		if($ri_worx){
		
			$qSel="SELECT work_area, work_type FROM ri_worx WHERE number = $work_id"; 
			$rSel=mysql_query($qSel);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkAreaAndType()","qSel",$qSel);
			
			if (mysql_num_rows($rSel)) {	
				$wtype_name=mysql_result($rSel,0,"work_type"); //Дипломная работа
				$warea_name=mysql_result($rSel,0,"work_area"); //Квантовая механика
			}
			//
			$arrQrs=array( 'type'=>array($wtype_name=>"SELECT number FROM diplom_worx_types WHERE `type` = '$wtype_name'"),
						   'predmet'=>array($warea_name=>"SELECT number FROM diplom_worx_topix WHERE `predmet` = '$warea_name'")
						 ); 
	
			foreach($arrQrs as $table_field=>$array){
				//'type'=>array
				//'predmet'=>array
				foreach ($array as $field_name=>$query) { 
					//'type'=> Дипломная работа, query
					//'predmet'=> Квантовая механика, query
					//echo "<div><pre>$query</pre></div>";
					$rSel=mysql_query($query); 
					//
					$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, query()","query",$query);
					//если тип работы
					$tfield=($table_field=="type")? $wtype_name:$warea_name;
					//
					if (mysql_num_rows($rSel)) 
						$arrWorkAreaAndType[$table_field]=array(mysql_result($rSel,0,'number')=>$tfield);
						//$arrWorkAreaAndType['type']=array(4=>'Дипломная работа');
						//$arrWorkAreaAndType['predmet']=array(66=>'Квантовая механика');					
				}
			}
			
		}else{ //diplom_zakaz
			
			$where="WHERE diplom_zakaz.number = $work_id";
			//тип работы (в 2 этапа): Дипломная работа
			$qSelTypeworkName="SELECT typework FROM diplom_zakaz $where";
			$rSelTypeworkName=mysql_query($qSelTypeworkName);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, qSelTypeworkName()","qSelTypeworkName",$qSelTypeworkName);
			if (mysql_num_rows($rSelTypeworkName)) $wtype_name=mysql_result($rSelTypeworkName,0,'typework');
			//
			$qSelTypeworkNumber="SELECT number FROM diplom_worx_types WHERE `type` = '$wtype_name'";
			$rSelTypeworkNumber=mysql_query($qSelTypeworkNumber);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, qSelTypeworkNumber()","qSelTypeworkNumber",$qSelTypeworkNumber);
			if (mysql_num_rows($rSelTypeworkNumber)) $wtype_number=mysql_result($rSelTypeworkNumber,0,'number');
			//
			$arrWorkAreaAndType['type']=array($wtype_number=>$wtype_name);
			//в diplom_zakaz должен быть predmet	//Квантовая механика
			$qSelTopix="SELECT diplom_worx_topix.predmet, diplom_worx_topix.number
  FROM diplom_worx_topix, diplom_zakaz $where
   AND diplom_zakaz.predmet = diplom_worx_topix.number";
			$rSelTopix=mysql_query($qSelTopix);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, qSelTopix()","qSelTopix",$qSelTopix);
			if (mysql_num_rows($rSelTopix)) 
				$arrWorkAreaAndType['predmet']=array(mysql_result($rSelTopix,0,'diplom_worx_topix.number')=>mysql_result($rSelTopix,0,'diplom_worx_topix.predmet')); 
			
		}
		return $arrWorkAreaAndType;
	}
	//получить тип работы и предмет:
	function getWorkAreaAndType($table,$work_id) {
		
		global $catchErrors;
		
		//predmet//typework:
        if ($table=="diplom_zakaz") {
        	$qSel="SELECT diplom_worx_topix.predmet, typework 
  FROM diplom_worx_topix, diplom_zakaz
 WHERE diplom_zakaz.number = $work_id 
   AND diplom_zakaz.predmet = diplom_worx_topix.number";
			$wtype="typework"; 
   			$warea="predmet";
		
		}elseif($table=="ri_worx"){
		
			$qSel="SELECT work_area, work_type FROM ri_worx WHERE number = $work_id"; 
			$wtype="work_type";
			$warea="work_area";
		}
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkAreaAndType()","qSel",$qSel);
		//$catchErrors->select($qSel);
		if (mysql_num_rows($rSel)) { 
			$this->work_type=mysql_result($rSel,0,$wtype); //echo "<br>this: [$this->work_type]";
			$this->work_area=mysql_result($rSel,0,$warea); //echo "<br>this: [$this->work_area]<hr>";
		}
	} //КОНЕЦ МЕТОДА
	//получить идентификатор работы в её родной таблице:
	function getWorkID($ri_basket_id){
		
		global $catchErrors;
				
		$qSel="SELECT work_id FROM ri_basket WHERE number = $ri_basket_id"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkID()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'work_id');
		
	} //КОНЕЦ МЕТОДА
	//получить статус доставки работы:
	function getWorkSent($ri_basket_id){
		
		global $catchErrors;
				
		$qSel="SELECT state FROM ri_basket WHERE number = $ri_basket_id AND state = 'sent'"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkSent()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'state');
		
	} //КОНЕЦ МЕТОДА
	//получить все доставленные работы:
	function getWorxSent($table=false){
		
		global $catchErrors;
				
		$qSel="SELECT number FROM ri_basket WHERE state = 'sent'";
		if ($table) $qSel.="
   AND work_table = '$table'"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkSent()","qSel",$qSel);
		if (mysql_num_rows($rSel)) {
			
			$arrWorxSent=array();
			while ($arr = mysql_fetch_assoc($rSel)) $arrWorxSent[]=$arr['number'];
			return $arrWorxSent;
		}else return false;
	}
	//получить имя работы:
	function getWorkName($table,$work_id){ //echo "<h1>getWorkName</h1>";
		
		global $catchErrors;
				
		$name=($table=="diplom_zakaz")? "subject":"work_name";
		
		$qSel="SELECT $name FROM $table WHERE number = $work_id"; 
		//$catchErrors->select($qSel);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkName()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,$name);
		//echo mysql_result($rSel,0,$name);
	} //КОНЕЦ МЕТОДА
	//получить имя таблицы работы по id заказа:
	function getWorkTable($ri_basket_id){
		
		global $catchErrors;
				
		$qSel="SELECT work_table FROM ri_basket WHERE number = $ri_basket_id"; 
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkTable()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'work_table');
	} //КОНЕЦ МЕТОДА
	//получить имя таблицы работы по id работы:
	function getWorkTableById($work_id){
		
		global $catchErrors;
				
		$qSel="SELECT work_table FROM ri_basket WHERE work_id = $work_id"; 
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ, getWorkTable()","qSel",$qSel);
		if (mysql_num_rows($rSel)) return mysql_result($rSel,0,'work_table');
	} //КОНЕЦ МЕТОДА
	//распарсить работы из общего массива заказов, сформированного по определённому типу, по 2 таблицам заказов:
	function parseWorxForTables($arrOrders) { //echo "<div>parseWorxForTables() open!</div>";
	
		global $Tools;
		  if (count($arrOrders)) {
			
			$arrOrdersDiplom=array();
			$arrOrdersReferats=array();
			
			for($i=0;$i<count($arrOrders);$i++){
				
				if ($this->getWorkTable($arrOrders[$i])=="diplom_zakaz")  
					$arrOrdersDiplom[]=$this->getWorkID($arrOrders[$i]);
				elseif ($this->getWorkTable($arrOrders[$i])=="ri_worx") 
					$arrOrdersReferats[]=$this->getWorkID($arrOrders[$i]);	
				
			}
			if (count($arrOrdersDiplom)) {
				
				$arrAllListingDiplom=$this->extractWorksDataDiplom( false,
										 false, //если не установлен фильтр чужих заказов
										 "
   AND diplom_zakaz.number IN (".implode(",",$arrOrdersDiplom).")", //если не установлен фильтр чужих заказов
										 false //если не установлен фильтр чужих заказов
									   ); 
			}
			if (count($arrOrdersReferats))
				$arrAllListingReferats=$this->extractWorksDataReferats( $ExcludeBasket,
										   "
   AND ri_worx.number IN (".implode(",",$arrOrdersReferats).")" //если не установлен фильтр чужих заказов
										 );
			//объединяем массивы, с предварительной проверкой их существования
			//ВНИМАНИЕ! Первый аргумент - массив объединяемых массивов
			return $Tools->arraysMergeAndUnify(array($arrAllListingDiplom,$arrAllListingReferats));
		  } else return false;
	}
	//
	function saveAllFilesArray( $type, //тип файла (по расширению)
								$source_type, //источник (sys/mail)
								$znum, //id заказа
								$full_path_to_file, //полный путь
								$mail_filetime, //время последнего изменения файла
								$filesize, //6. размер файла
								$mess=false
							  ) {
			
		//извлечь время последнего изменения файла:
		global $dir_count;
		global $Tools;
		//отладка:
		if (isset($_REQUEST['test'])) 
			echo "<h5>znum= $znum</h5>";
		
		//если не аттачмент, извлечём дату последнего изменения файла:
		if (!strstr($source_type,"mail")) {
			//echo "<h5>[1]full_path_to_file= $full_path_to_file<div class='txtGreen'>mess=$mess</div></h5>";	
			if ($type!="dir") $mail_filetime=$Tools->getFiletime($full_path_to_file,$mess,$filetipe);
			else {
				if (!$dir_count) $dir_count='0';
				$mail_filetime=$dir_count;
				$dir_count++;
			} 
		}
		//тестовая информация:
		//$test_func_output=true;
		if ($_SESSION['TEST_MODE']&&$test_func_output) {
			
			?><h4 style="margin-bottom:0;"><nobr>{saveAllFilesArray(<span class='noBold'><b class="txtOrange"><?=$type?></b>,<b class="txtGreen"><?=$source_type?></b>,<?=$znum?>,<?=$full_path_to_file?>.<?=$mess?>)</span>}</nobr></h4><? 
			echo "<div class='iborder padding10' style='border-color:#0000FF; background-color:#EEEEEE'>";
		}
		//если не сохраняли во временной директории:
		if ($full_path_to_file!=$_SESSION['DOC_ROOT_DIPLOM']."temp/".session_id().".zip") {

			//показать нечитаемый (по расширению) файл:
			$this->showWrongExtFiles ($type,$full_path_to_file);

			//			
			if ($this->entryIsNew($this->savedFiles[$mail_filetime],$full_path_to_file)) { //вхождение новое:
				//тестовая информация:
				if (isset($_SESSION['TEST_MODE'])) {
					//echo "<div>key= $key</div>";
					//$test_new=true;
					if ($test_new) echo "<div style='padding:4px;'>ВХОЖДЕНИЕ <b>НОВОЕ:</b> $full_path_to_file</div>";
					//$test_sArr=true;
					if ($test_sArr) {
						
						if (is_array($this->savedFiles[$mail_filetime])) 
							foreach ($this->savedFiles[$mail_filetime] as $key=>$val) echo "<div>[$key] => $val</div>";
					}
					if (strstr($full_path_to_file,"/temp/".session_id().".zip")) echo "<blockquote>full_path_to_file = $full_path_to_file</blockquote>";
				} 
				
				//создать массив, если ещё не создан:
				if (!is_array($this->savedFiles)) $this->savedFiles=array();
				$this->savedFiles[$mail_filetime]=array();
				//добавить имя файл в массив:
				//сохраним файл в общем массиве:
				$this->savedFiles[$mail_filetime]=array ( 'ext' => $type, //тип (расширение)
														  'source_type' => $source_type, //источник - директория заказа/сообщение (аттачмент)
														  'work_id' => $znum, //для идентификации заказов, содержащих файлы нестандартного формата
														  'full_path_to_file'=> $full_path_to_file,
														  'size' => $filesize
														);
				//ВНИМАНИЕ!!! После формирования массива и перед построением таблицы файлов необходимо выполнить:
					//пересортировку по ключам
					//трансформацию массива: переместить ключи в качестве первого элемента, проставить индексы 
				//
				if (isset($_SESSION['TEST_MODE'])) {
					if ($test_saving) {
						echo "<div style='padding:4px;'>Сохраняемый элемент массива: savedFiles[$mail_filetime]</div>";					
						switch ($type)  { 
							case "dir":	$color="#660033"; break;
							case "znum": $color="green";	break;	
							case "arch": $color="#cccccc";	break;
							case "rar": $color="#FF33CC";	break;
							case "zip": $color="brown";	break;
							default: $color="FF33CC";
						}
						if(!$full_path_to_file) $mess2="<span class='txtRed'>Файл $full_path_to_file пуст!</span>";
						else echo "<div style='background-color:yellow' class='iborder padding8'><nobr>Добавляем в массив файл $full_path_to_file ($mail_filetime)</nobr></div>";
					}
					//$test_added=true;
					if ($test_added) {
						echo "<div style='color:#999999'><nobr>(TEST) saveAllFilesArray -> $mess</nobr></div>"; //выводит цепочку методов и сохраняемый файл
						echo "<div><nobr><span style='color:$color'>$mess2</span></nobr></div>";
					}
				}
			}elseif (isset($_SESSION['TEST_MODE'])) echo "<div class='txtOrange'><b>$full_path_to_file</b> не является новым вхождением</div>";
			
		} 
		//отладка:
		if ($_SESSION['TEST_MODE']&&$test_func_output) echo "</div>";
		//возвращаем массив:
		return $this->savedFiles;
	} //	КОНЕЦ МЕТОДА saveAllFilesArray
	//
	function scanEntries ($znum,$entry=false) { if ($this->getZipFileArray) echo "<h2 class='txtRed'>entry= $entry</h2>";
		
		global $Blocks;
		global $Tools;
		
		//$test_func_output=true;
		if ($_SESSION['TEST_MODE']&&$test_func_output) {
			?><h4 style="margin-bottom:0; color:#666;"><nobr>{scanEntries(<span class='noBold'><?=$znum?>,<?=$entry?></span>)}</nobr></h4><? 
			echo "<div class='padding10 iborder2' style='border-color:#999999;'>";
		}

		global $Tools;
		
		$entry_path=$_SESSION['DOC_ROOT_DIPLOM']."zip/$znum";
		//directory:
		if ($entry) { 

			if ($entry[0]!="/") $entry_path.="/";
			$entry_path.="$entry"; //echo "<hr><div>entry= $entry<br>entry_path= $entry_path</div><hr>"; 
			//
			$mess=" [scanEntries(entry_path= $entry_path)]";
			//сохранить в массиве
			$this->saveAllFilesArray("dir","sys_",$znum,$entry_path,false,false,$mess); 

		} if ($this->getZipFileArray) echo "<h2 class='txtRed'>entry_path= $entry_path</h2>";
		//
		if ($handle = @opendir($entry_path)) { 
	
			while (false !== ($file = readdir($handle))) { 
	
				if ($file != "." && $file != "..") { 
					
					//полный путь:
					$full_path_to_file=$entry_path."/".$file;
					//размер файла:
					$filesize=filesize($full_path_to_file);

					$mess=" [scanEntries($full_path_to_file)]";
					
					//получить тип расширения и его само (последний аргумент):
					$extype=$Tools->detectExt($file,$fext);
					//					
					if ( $extype || //нужное расширение
						 is_dir($full_path_to_file) //директория
					   ) {
						
						//если директория:
						if (is_dir($full_path_to_file)) { 
							
							$new_entry=$entry_path."$entry/$file";				
							
							self::scanEntries ($znum,"$entry/$file");  
						
						}else{
						
							if($file) { 
														
								//вывести неизвлекаемый файл:
								$this->showWrongExtFiles ($fext,$full_path_to_file);

								if ($extype=="archive") {  //если архив
									//   
									$this->extractArchiveFiles( 'sys_',
																$znum,
																$file,
																$full_path_to_file,
																$Tools->getFiletime($full_path_to_file),
																$filesize,
																$fext
															  );	
								
								}else{								
									
									if (isset($_REQUEST['work_id'])) {
										
										if ($extype=="office") {
	
											//echo "<h5>[3]full_path_to_file= $full_path_to_file</h5>";											
											$this->saveAllFilesArray( "znum",
																	  "sys_",
																	  $znum,
																	  $full_path_to_file,
																	  $Tools->getFiletime($full_path_to_file),
																	  $filesize,
																	  $mess
																	);
											if ($this->getZipFileArray) {
												//echo "<hr>generateTableRow HERE<hr>";	
												$Blocks->generateTableRow($this->getZipFileArray,$files_count,"class.Worx->scanEntries()");
											}
										}
										
									}else{
										
										$this->arrDplomZakazIDsWithFiles[]=$znum;
										if (!$znum&&$_SESSION['TEST_MODE']) echo "<div class='txtRed'>Не получен \$znum</div>"; 
										//прерываем цикл при обнаружении первого файла
										break;
									} 
								}
							}
						}
					} else "<h5>Не выполнено: $znum</h5>";	
				}
			}
		} if ($handle) closedir($handle);
		if ($_SESSION['TEST_MODE']&&$test_func_output) echo "</div>";
	}
	//	КОНЕЦ МЕТОДА scanEntries
	function searchWithinAccount($txt_default) {
			
		global $work_subject;
	  
	  if ($test_table){?><table><tr><? }?>
            
    	<td nowrap="nowrap" style="padding-left:40px; padding-right:8px;"><!--<img src="<?=$_SESSION['SITE_ROOT']?>images/1295963445_search.png" width="16" height="16" hspace="4">-->Искать в собственных:</td>
<td width="100%" nowrap="nowrap"><input name="work_subject" type="text" class="widthFull iborder borderColorOrangePale" style="height:22; background-color:#FFC; color:#666;" id="work_subject" value="<?
		if ($work_subject) echo $work_subject;
		else {
			if (!$txt_default) $txt_default=$this->setSearchPreString();
			echo $txt_default;
			?>" onClick="if (this.value=='<?=$txt_default?>') this.value='';<? 
		}?>" title="Оставьте поле пустым, если хотите найти работу по указанному в списке типу предмета на любую тему."></td>
        <td nowrap="nowrap" class="paddingLeft4"><input name="" type="submit" value="Найти"></td> 
   <? if ($test_table){?></tr></table><? }
      }	 //КОНЕЦ МЕТОДА
	//отобразим таблицу с выбором типа и предмета работ:
	function setFilterToWorxCriteria($block=false,$return_area=false) {
?>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td></td>
<?  if ($block!="work_type") {?>
    <td><? 
		if (isset($_SESSION['S_WORK_TYPE_ALL'])){?><span class="txtOrange">{фильтр}</span> <? } ?></td>
<?  }
	if ($block!="work_area") {?>
    <td><? 
		if (isset($_SESSION['S_WORK_AREA_ALL'])){?><span class="txtOrange">{фильтр}</span> <? } ?></td>
<?	}?>    
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td nowrap><strong>Выберите: </strong></td>
<?  if ($block!="work_type") {?>
    <td><? 
   		if ($_test_listing){?>построим список типов работ<? } 
		$work_number="all"; //чтобы дописать name+id списков
		if (isset($_SESSION['TEST_MODE'])) echo "<div>{setFilterToWorxCriteria()}</div>";  
		$this->buildWorxTypesList(' style="background-color:#FFFFCC;" class=""',$_SESSION['S_WORK_TYPE_ALL'],false,'reverse'); ?></td>
<?	}
	if ($block!="work_area") {?>    
    <td width="100%"><?
    	if ($_test_listing){?>построим список предметов<? } 
		$this->buildWorxAreasList(" class='widthFull' style='background-color: #eaffea'",$_SESSION['S_WORK_AREA_ALL']);
		unset($work_number);?></td>
<?  }?>
    <td><input name="go_worx_filter" type="submit" id="go_worx_filter" value="Отфильтровать!"></td>
<? 		if ($_SESSION['S_WORK_TYPE_ALL']||$_SESSION['S_WORK_AREA_ALL']) {?>
    <td class="paddingLeft0"><a href="index.php?mode=skachat-rabotu&amp;<?
    		
			if ($return_area) echo $return_area; else{?>work_area_all=&amp;work_type_all=<? }?>" title="Сбросить результаты фильтра"><img src="images/close_orange.png" width="18" height="18" border="0" align="absmiddle"></a></td>
<? 		}?>
  </tr>
</table>
<?  }	  
	//
	function setPagesLimit(&$limit_finish,&$limit_start) {
				
		$limit_start=(isset($_REQUEST['work_subject']))? '0':$_REQUEST['page']*$limit_finish;
		
	} //КОНЕЦ МЕТОДА
	//установка заглушки для поисковой строки:
	function setSearchPreString() {
		return "...введите подстроку для поиска работы по названию...";
	}
	//
	function setWorkLinkMailTo($work_id) {
	
		?><a href="?menu=messages&amp;mailto=autho&amp;action=compose&amp;work_id=<?=$work_id?>" title="Отправить сообщение автору работы"><img src="<?=$_SESSION['SITE_ROOT']?>images/envelope_small.png" width="14" height="10" border="0" /></a><?
	
	}
	//
	function showOrdersValue($arrOrdersType,$work_number) {
	
	  	//if (isset($_SESSION['TEST_MODE'])) echo "<h6>getWorkOrdersValue (showOrdersValue)</h6>";

		$orders_value=$this->getWorkOrdersValue ($arrOrdersType,$work_number); 

		  if ($orders_value) {
			  
			  ?><a href="?menu=orders&amp;work_id=<?=$work_number?>" title="Загрузить сводку заказов данной работы"><?=$orders_value?></a><?

		  } else echo "&nbsp;";
	
	}
	//
	function setPriceAverage () {
	
		$_SESSION['diplom_zakaz_price_average']=4;
	
	}
	//
	function setPriceRatio () {
	
		return 125;
	
	}
	//заголовок с результатами поиска:
	function showSearchResultHeader() {?>
    <div class="paddingBottom4">
      <table width="100%" class="bgYellowFadeTop" cellspacing="0" cellpadding="8" style="border-bottom:solid 2px #FC0;">
  		<tr>
    	  <td width="100%"><h4 class="padding0 Cambria">Результаты поиска:</h4></td>
    	  <td><input name="drop_search" type="button" value="Сбросить" onClick="location.href='?menu=worx'"></td>
  		</tr>
	  </table>
    </div>
<?	}	 //КОНЕЦ МЕТОДА  
	//показать нечитаемый (по расширению) файл:
	function showWrongExtFiles ($type,$full_path_to_file,$show_wrong_ext=false) {
		
		//global $wrong_ext_count;
		if (!$show_wrong_ext) $show_wrong_ext=$_REQUEST['show_wrong_ext'];
		if ( !strstr($type,"doc")&&
			 !strstr($type,"txt")&&
			 !strstr($type,"zip")&&
			 $show_wrong_ext
		   ) {
			
			//if (!$wrong_ext_count) $wrong_ext_count='0';
			$file_path="/home/rossorig/domains/diplom.com.ru/public_html/";
			if (strstr($full_path_to_file,":")) {
				$file_path.="letters/";
				$color='Red';
			}
			else {
				$file_path.="zip/";
				$color='Orange';
			}
			$file_path=substr($full_path_to_file,strlen($file_path),strlen($full_path_to_file));
			if (!is_array($this->arrWrongExt)) $this->arrWrongExt=array();
			if (!in_array($file_path,$this->arrWrongExt)) {
				$this->arrWrongExt[]=array($color=>$file_path);
				//echo "<div class='txt$color'>[$color] => $file_path</div>";  
				//$wrong_ext_count++;
			}
		}
	}
	//
	function trNote($cols) { if ($test_table){?><table><? }?>  
  <tr>
    <td colspan="<?=$cols?>" align="center" bgcolor="#FFFFCC"><img src="<?=$_SESSION['SITE_ROOT']?>images/i_triangle.png" width="15" height="15" hspace="4" vspace="2" align="absmiddle" />Чтобы <? 
		switch ($_REQUEST['mode']){
			case "payments": ?>добавить запись о новом платеже<? 
			break;
			case "messages": ?>создать новое сообщение по заказу<? 
			break;
		}?>, <a href="?section=customer&amp;mode=orders">выберите соответствующий заказ</a>.</td>
  </tr>
<?		if ($test_table){?></table><? }
   }
	//получить длину массива:
	function zCount($array) {
	 	return (is_array($array))? count($array)+1:'0';
	}   
}?>