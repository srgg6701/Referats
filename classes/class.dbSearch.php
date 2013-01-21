<? //<h1>ЗАГРУЗИЛИСЬ!!!</h1>
//поиск в БД
class dbSearch {

public $arrSearchPhrase;	//массив поисковых слов
public $arrStopWords;		//массив стоп-слов (как массив определяется внутри функции)
public $arrTableQueryResults=array();
public $go_test=false;
public $len_average;		//усреднённая длина слова поисковой фразы
public $string_to_search;	//поисковая фраза
public $words_count;		//количество слов в найденной фразе

	//подготавливаем полученную поисковую строку к обработке:
	function prepareString($string_to_prepare) { 

		$go_test=$this->go_test;
		//переводим в нижний регистр:
		$string_to_prepare=strtolower($string_to_prepare);
		//создаём шаблон допустимых символов:
		$invalid="/[^a-zа-яё]+/";
		//заменяем недопустимые на пробелы:
		$string_to_prepare=preg_replace($invalid," ",$string_to_prepare);
		//удаляем пробелы из начала и конца строки:
		$string_to_prepare=trim($string_to_prepare);
		//конвертируем в массив:
		$arrPhraseToWords=explode(" ",$string_to_prepare);

		for ($i=0;$i<count($arrPhraseToWords);$i++) 
		  { if ($go_test) echo "<div>[$i]: ".$arrPhraseToWords[$i]."</div>";
		    if (strstr($arrPhraseToWords[$i],"ё")) 
			  { if (strstr($arrPhraseToWords[$i],"ё")) $new_word=str_replace("ё","е",$arrPhraseToWords[$i]);
			    array_push($arrPhraseToWords,$new_word);
			  }
		  }
		return $arrPhraseToWords;
	}
	//предварительная обработка данных:
	function prepareToSearch() {
		//обработанные поисковые слова:
		$string_to_search=$this->string_to_search;	

		########################################
		$go_test=false;
		//$go_test=true;
		
		//сохраням массив, образованный из слов поискового запроса:
		//+сохраняем копию исходного массива, чтобы проверить точное совпадение его элементов без обрезки с поисковой фразой
		$arrSearchPhrase=$this->prepareString($string_to_search);
		$this->arrSearchPhrase=$arrSearchPhrase;	
		
		//стоп-слова:
		$this->arrStopWords=$arrStopWords=array("а","без","более","бы","был","была","были","было","быть","в","вам","вас","весь","во","вот","все","всего","всех","вы","где","да","даже","для","до","его","ее","если","есть","ещё","же","за","здесь","и","из","из-за","или","им","их","к","как","как-то","ко","когда","кто","ли","либо","мне","может","мы","на","надо","наш","не","него","неё","нет","ни","них","но","ну","о","об","однако","он","она","они","оно","от","очень","по","под","при","с","со","так","также","такой","там","те","тем","то","того","тоже","той","только","том","ты","у","уже","хотя","чего","чей","чем","что","чтобы","чьё","чья","эта","эти","это","я");
		
		//количество поисковых слов:
		//понадобится для расчёта веса каждого поискового слова
		$this->words_count=count($arrSearchPhrase); 
		$show_strings=false;
		if ($show_strings) 
		  { ?><div class='padding10 bgYellow'>Обработанная поисковая строка (<?=$string_to_search?>): <h2 style='display:inline;'><?=$string_to_search?></h2></div><hr>
          <div class='padding10 bgGreyRow'>Массив обработанных поисковых слов (<?=$arrSearchPhrase?>): <h2 style='display:inline;'><?=implode(", ",$arrSearchPhrase)?></h2></div><? 
		  }
	}
	//Получение записей из таблицы в соответствии с поисковым запросом. При этом если точного соответствия не обнаружено, каждое поисковое слово итеративно обрезается, начиная с конца, до тех пор, пока не будет найдена запись или длина слова не достигнет предела (3 символа).
	function makeSearchInTables( $field1,$field2,		//имена извлекаемых полей //второе поле - КРИТЕРИЙ поиска
								 $table,				//таблица извлечения данных
								 $and					//отбор по доп. критерию
							   ) { //echo "<div class='padding10'>makeSearchInTables.$table</div>";

		global $catchErrors;
		
		if (isset($_REQUEST['go_test'])) $go_test=true;
		
		$this->prepareToSearch();
		$this->prepareToSearch();
		
		//вернём стоп-слова:
		$arrStopWords=$this->arrStopWords;
		$arrSearchPhrase=$this->arrSearchPhrase;
			  	
		//если ничего не нашли, будем умешьшать поисковую фразу:
		$w=0;
		//темы предварительно найденных работ:
		$arrPreResultsWorkID=array();
		//цикл выполнения запросов к таблице во всех вариантах поисковых слов - от полной до минимальной (итеративно уменьшенной) длины
		//на выходе получаем количество найденных вариантов записей в таблице для анализа соответствия поисковому запросу
		
		##############################################################################################
		
		//$stop=true, когда выполнены все итерации уменьшения текущего поискового слова
		//$rws=найдено значение по условию от точного совпадения слов до совпадения итеративно уменьшенных
		while (!$stop) { //ВНИМАНИЕ!
		    
			//Следующий фрагмент кода фактически определяет глубину поиска, т.к. 
			//итеративно уменьшает длину поисковых слов
			#####################################################################		
			//если итерация не первая -
			if ($w) { //обрежем каждое слово, до тех пор, пока не найдём соответствующие записи в таблице:
				$s=0;
				foreach ($arrSearchPhrase as $key=>$qString) { //echo "<br>qString= $qString<br>";
					//[0]Пятый
					//[1]Элемент
					//устанавливаем лимит уменьшения:
					if (strlen($qString)>3) {
						//итеративно уменьшаем длину искомого слова:
						$arrSearchPhrase[$key]=substr($qString,0,strlen($qString)-1);
						//
					$s++;
					}
				}
			
				//счётчик уменьшения поисковых слов не инкременирован
				//НЕ break, т.к. необходими выполнить следующую часть кода
				if (!$s) $stop=true; 
			
				unset ($subquery_LIKE_name);
			}
			//трансформируем поисковый запрос:
			for ($i=0;$i<$this->words_count;$i++) { //искомое слово в запросе не является стоп-словом:
				
				if (!in_array($arrSearchPhrase[$i],$arrStopWords)) {	//
					
					if ($subquery_LIKE_name) $subquery_LIKE_name.=" 
         OR ";
					$subquery_LIKE_name.="$field2 LIKE '%".$arrSearchPhrase[$i]."%'";
					//сохраняем длину слова:
					$wlngth+=strlen($arrSearchPhrase[$i]);
	
				}
			} //echo "<pre>subquery_LIKE_name= $subquery_LIKE_name</pre>";
			
			//колич. слов в полученном запросе:
			$words=count($arrSearchPhrase);
			
			//усреднённая длина слова (нужна для дальнейшего расчёта коэффициента веса слова):
			$this->len_average=($words)? ($wlngth/$words):$wlngth;
			
			//создадим запрос к таблице данных:
			if ($subquery_LIKE_name) { 
				
				//
				$qSel="SELECT $field1,$field2 
  FROM $table WHERE ( 
            $subquery_LIKE_name 
       ) $and";
				$rSel=mysql_query($qSel);
				$rws=mysql_num_rows($rSel);
				$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); 
				//$catchErrors->select($qSel);
				
				if ($rws) {
					for ($c=0;$c<$rws;$c++) {
						
						$current_id=mysql_result($rSel,$c,'number'); //echo "<div class='iborder'>current_id= $current_id</div>";
						
						if (!in_array($current_id,$arrPreResultsWorkID)) { //echo "<h4>current_id= $current_id</h4>";
					
							$arrPreResultsWorkID[]=$current_id;
						
						}
					}
				}
				
			}else $stop=true; 
			
			//echo "stop= $stop, rws= $rws<hr>";
			//$go_test=true;
			//if ($go_test) $catchErrors->select($qSel); 

			$w++;
	  	  }	
		
		if (count($arrPreResultsWorkID)) {
			
			$qSelNmbrs="SELECT $field1,$field2 
  FROM $table WHERE $field1 IN (".implode(", ",$arrPreResultsWorkID).")";
			$rSelNmbrs=mysql_query($qSelNmbrs);
			$rwsnm=mysql_num_rows($rSelNmbrs);
			$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSelNmbrs",$qSelNmbrs); 
		
			while ($arr=mysql_fetch_assoc($rSelNmbrs)) 
				$this->arrTableQueryResults[]=array( 'table'=>$table,
													 'item_id'=>$arr[$field1],
													 'item_name'=>$arr[$field2]
												   );
		}
		$this->arrSearchPhrase=$arrSearchPhrase; //foreach($arrSearchPhrase as $key=>$phrase) echo "<div>$key=>$phrase</div>";
	}
	//Если записи найдены - пересортировка значений внутри массивов с однорейтинговыми элементами. Критерий - длина фразы	
	function sortFoundedResults() {  
		
		//извлечём массив результатов поиска в таблицах:
		$arrTableQueryResults=$this->arrTableQueryResults;
		$rws=count($arrTableQueryResults);
		//извлечём массив поисковых слов фразы:
		$arrSearchPhrase=$this->arrSearchPhrase;
		//вернём стоп-слова:
		$arrStopWords=$this->arrStopWords;
		
		//если нашли запись в таблице:
		//инициализируем контейнер для блоков одноранговых элементов:
		$arrResultsClusters=array();
		//окончательный массив:
		$arrResultsRankFinal=array();
		//
		if ($rws)
		  {	//инициализируем контейнер результатов
			$arrResults=array(); 
			##################################################################
			//Расчитываем рейтинг элементов:
			##################################################################
			for ($i=0;$i<$rws;$i++) 
			  { //
			  	$item_table=$arrTableQueryResults[$i]['table'];
				$item_id=$arrTableQueryResults[$i]['item_id'];
				//название
				$item_name=$arrTableQueryResults[$i]['item_name'];
				$item_name_len=strlen($item_name);//для ранжирования элементов внутри кластера
				
				//echo "<br><hr><div class='padding10'>[item_table] $item_table<br>[item_id] $item_id<br><div class='iborder'>[item_name] $item_name</div>[item_name_len] $item_name_len</div>";
				
				//сохраним название в массиве:
				//сохраняем в массиве обработанные слова поискового запроса:
				$arrWordsFound=$this->prepareString($item_name); 
				//удаляем
				unset($rank);  
				//колич. найденных слов:		
				$words_count=count($arrWordsFound);
				
				##############################################################
				$show_test_row=false;
				if ($go_test) 
				  { ?>
				  <tr style="display:<? if(!$show_test_row){?>none;<? }?>">
					<td colspan=3><!--item_id= <?=$item_id?>, rws= <?=$rws?>, i= <?=$i?>-->
				  
				<div class='padding10 iborder' style="background-color:#f5f5f5; display:<?="none"?>;">Текущее название [<?=$i+1?>]:
					<div onclick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" style="font-size:2em; font-weight:bold; cursor: pointer;"><? if ($test_header) {?>Название элемента<? } else echo $item_name?></div>
					<div style="display:<? echo "none";?>; padding:6px; background-color:#E8FFE8">
					Массив: arrSearchPhrase=<? var_dump($arrSearchPhrase);?><hr><? 
				  } 
				//=количеству слов поискового запроса:
				for ($s=0;$s<$this->words_count;$s++)
				  {	//echo("<hr>count= ".count($arrSearchPhrase)); 
				  	//echo "<hr>words_count= $words_count"; 
					//массив для сохранения слов, совпавших с поисковыми полностью. Нужен, чтобы исключить повторное начисление баллов:
					$arrStopWordChecking=array();
					//текущее слово из поискового запроса:
					$wordFromSearch=$arrSearchPhrase[$s]; 
					
					//проверить каждое слово из найденной фразы:		
					#####################################################
					for($j=0;$j<$words_count;$j++) //длина найденной фразы
					  { //$show_loop_enter=true;
						if ($show_loop_enter) echo "<br>вошли в цикл[$i] проверки каждого слова из найденной фразы";
						//echo "<div class='bgPale'>$j/[$words_count] Найденное слово: $arrWordsFound[$j]</div>";						
						unset ($blike);		
						unset($bonus);									
						//текущее найденное слово:
						$wordFromFound=$arrWordsFound[$j];	  
						
						if ($go_test) 
						  { $words_to_compare="<div class='padding10 iborder' style='background-color:#ffe8dd'>СРАВНИВАЕМЫЕ СЛОВА <span class='txtDarkBlue'>[$j]</span> из $words_count: 
							ПОИСКОВОЕ: <b class='txtRed bgSystemLight'>$wordFromSearch</b>, НАЙДЕННОЕ: <b class='txtGreen bgPale'>$wordFromFound</b></div>";
						  }
						  
						//если оба слова не состоят в СТОП-листе:
						if ( !in_array($wordFromSearch,$arrStopWords) &&
							 !in_array($wordFromFound,$arrStopWords)
						   )
						  { $go_test=true;				
							if ($go_test) $stop_checked="прошли[$j] проверку на СТОП-слова /<strong>$wordFromSearch</strong>/ ";
							$go_test=false;
							
							//длина поискового слова:
							$word_from_search_phrase_len=strlen($wordFromSearch); 
							//длина найденного слова:
							$word_from_subject_len=strlen($wordFromFound);							
							//выясним длину цикла сравнения (по наименее длинному из слов):
							$compare_count=($word_from_search_phrase_len>$word_from_subject_len)? $word_from_subject_len:$word_from_search_phrase_len;
								
							if ($go_test) 
							  { $check_words_identity="<DIV class='padding10'><strong>Проверка совпадения слов:</strong></div>";
								$check_words_identity.="<div>wordFromSearch= <b>$wordFromSearch</b><br>wordFromFound= $wordFromFound</div>";
							  }

							##############################################################
							//если слова совпали полностью:
							if ( $wordFromSearch==$wordFromFound &&
								 //слово не находится в массиве ранее найденных полных совпадений:
								 !in_array($wordFromSearch,$arrStopWordChecking) 
							   ) 
							  { //заблокируем дальнейшую проверку совпавшего слова:
								$arrStopWordChecking[]=$wordFromSearch;
								//бонус по умолчанию - 
								//максимальный балл/количество поисковых слов:
								//$bns=round(10/$words_count); 
								$bns=10/$words_count; 
								//echo "<div class='txtRed'>bns= $bns, pre_bns= ".(10/$words_count)."</div>";
								//
								$blike+=$bns;
								
								if ($go_test) echo "<div>blike[1]= $blike</div>";
								
								//если поисковое слово больше усреднённой длины:
								if ($word_from_search_phrase_len>$this->len_average) 
								  { //вычислим бонус:
									$bonus=($word_from_search_phrase_len/$this->len_average);//длина искомого слова / средняя длина искомых слов
									$bonus*=$bonus;
									$blike+=$bonus; 
									
									if ($go_test) echo "<div>blike[2]= $blike</div>";
									
								  }
								//бонус за порядок слов:
								if ($blike) 
								  { $bonus_for_word_order=$words-$k;
									if ($bonus_for_word_order>0) $blike+=$bonus_for_word_order; //if ($item_id==$ztest) 									
									if ($go_test) echo "<div>blike[3]= $blike</div>";						
								  } 
								  
								if ($go_test) $identity_true="<div class='padding10'>СЛОВА СОВПАЛИ ПОЛНОСТЬЮ!</div>";

							  }	
							//если нет полного совпадения, будем сверяться побуквенно -
							//и слово ранее не совпадало полностью с найденным:
							elseif (!in_array($wordFromSearch,$arrStopWordChecking))						
							  { 						
								if ($go_test) $no_identity.="<DIV>НЕ ОБНАРУЖЕНО. Побуквенное сравнение:</DIV>";	
								
								//будем сравнивать поисковую фразу и полученную:
								if ($go_test) $compare_phrases.="<DIV class='padding10 bgSystemLight'>";	
								
								//														
								for ($k=0;$k<$compare_count;$k++) //колич. букв в ТЕКУЩЕМ найденном СЛОВЕ
								  { //сравниваем поисковую фразу и полученную побуквенно:
									if ($wordFromSearch[$k]==$wordFromFound[$k]) 
									  { $blike+=1; 
										
										if ($go_test) $compare_phrases_by_letters.=" <span>[#$k]<strong>".$wordFromFound[$k]."</strong></span>";
									  }
									else break;
								  } 

								 //
								 if ($go_test) 
								   { if ($blike) $weight="<div class='bgWhite padding4'>Начислено баллов ВСЕГО (blike): <span style='background-color:yellow;' class='padding4 iborder'>$blike</span></div>";
									 $report_string.="$weight
									 </div>";
								   }
							  }

							//инкременируем рейтинг слова:
							$rank+=$blike;

							if ($go_test&&$blike) { 
								
								echo "Слова, заблокированные от повторной проверки: ".implode(",",$arrStopWordChecking)."<hr>";
								
								echo
								$words_to_compare.
								$stop_checked.
								$check_words_identity.
								$blike_plus.
								$identity_true.
								$no_identity.
								$compare_phrases.
								$compare_phrases_by_letters.
								$report_string;
							 }
						  }

						if ($go_test)
						  {	//удаляем ранее созданные переменные:
							unset($words_to_compare);
							unset($stop_checked);
							unset($check_words_identity);
							unset($blike_plus);
							unset($identity_true);
							unset($no_identity);
							unset($compare_phrases);
							unset($compare_phrases_by_letters);
							unset($weight);
							unset($report_string);
						  }
					  } 
				  }
				//$go_test=true;  												
				if ($go_test) { ?>
					</div>
				  <div class='separatorBottom'>ИТОГО, <span class='padding4' style='background-color:yellow;'>РЕЙТИНГ ФРАЗЫ (dlike[<?=$i?>])= <strong class='txtDarkBlue txt110'><?=$rank?></strong></span>
				  </div>
			 </div></td></tr><? 
				} $go_test=false;
				//
				if ($rank) { 
					//
					$rank=$rank/3*2; 
					//settype($rank,"integer");
					$arrResults[]=$rank;
					$arrData[]=array('item_table'=>$item_table,'item_id'=>$item_id,"item_name"=>$item_name,"item_name_len"=>$item_name_len,"rank"=>$rank);
				} //if ($go_test&&$i>25) break; //только в режиме отладки
			  }
			//отсортировали по рейтингу: 
			
			$arrResultsRank=array();
			$arrResultsItemData=array();
			
			arsort ($arrResults); //var_dump($arrResults); 
		    reset($arrResults);

			//приводим к последовательному порядку ключи и значения:
			while (list($key,$rank) = each($arrResults)) {
				$arrResultsRank[]=$arrResults[$key];
				$arrResultsItemData[]=$arrData[$key]; 
				
				//echo "<br>"; foreach ($arrData[$key] as $key=>$val) echo "<div>$key=>$val</div>";
					
			}
			
			$w=0;
			
			for ($key=0;$key<=count($arrResultsRank);$key++) {
				$test_key=true;
				$rank_previous=$arrResultsRank[$key-1];
				$rank_current=$arrResultsRank[$key];
				$rank_next=$arrResultsRank[$key+1];
				
				//if ($test_key) echo "<h2>key= $key<br>rank_current= $rank_current, rank_next= $rank_next</h2>";
				//итерация первая ИЛИ 
				//текущий меньше предыдущего (образуем новый кластер)
								//6			//7
				if ($rank_current<$rank_previous||!$key)	
				  { //
				    if ($key<count($arrResultsRank))
					  {	//$go_test=true;
					  	if ($go_test) echo "<div class='iborder padding4 bgYellow'>Начало нового кластера. Rank: $rank_current</div>";
						$go_test=false;
						
						//не подошли к порогу перехода на другой кластер:
						if ($rank_current>$rank_next) { 
						
							//$show_cluster_issue=true;
							if ($show_cluster_issue) echo "Кластер <span class='txtRed'>НЕ БУДЕТ</span> сформирован<hr>";

							$arrResultsRankFinal[]=
							array('item_table'=>$arrResultsItemData[$key]['item_table'],
								  'item_id'=>$arrResultsItemData[$key]['item_id'],
								  'item_name'=>$arrResultsItemData[$key]['item_name'],
								  'rank'=>$rank_current
								 );
							
							//echo "<div>arrResultsItemData[$key]['item_table']= ".$arrResultsItemData[$key]['item_table']."</div>";
							if ($go_test) echo "<div>[".$arrResultsItemData[$key]['item_table']."], ".$arrResultsItemData[$key]['item_id']."], ".$arrResultsItemData[$key]['item_name']." (".$arrResultsItemData[$key]['item_name_len'].")</div>";						   
						}else{ //создать метку формирования кластеров:
							//запускаем создание кластера:
							$make_cluster=true;	
						}
					  }
				  } //echo "<div>key= $key | count(\$arrResultsRank)= ".count($arrResultsRank).", make_cluster= $make_cluster</div>";
				//СТРОИМ КЛАСТЕР ДЛЯ ПОСЛЕДУЮЩЕЙ ПЕРЕСОРТИРОВКИ
				//не первая итерация И
				//текущий равен предыдущему
				######################################
				//если запустили создание кластера:				
				if ($key<count($arrResultsRank)&&$make_cluster)
				  { //item_id //item_name// item_name_len// rank

					$arrResultsItemDataTable[$w]=$arrResultsItemData[$key]['item_table'];
					$arrResultsItemDataID[$w]=$item_id=$arrResultsItemData[$key]['item_id'];
					$arrResultsItemDataName[$w]=$arrResultsItemData[$key]['item_name'];
					$arrResultsItemDataLen[$w]=$arrResultsItemData[$key]['item_name_len'];

					//echo "<div class='txtRed'>arrResultsItemDataID[$w]= ".$arrResultsItemData[$key]['item_table']."</div>";
					//$go_test=true;
					if ($go_test) echo "<div>[".$arrResultsItemData[$key]['item_table']."], ".$arrResultsItemData[$key]['item_id']."], ".$arrResultsItemData[$key]['item_name']." (".$arrResultsItemData[$key]['item_name_len'].")</div>rank_current= $rank_current, rank_next= $rank_next, key= $key";
					$go_test=false;

					$w++;

					//подошли к порогу:
									//6			//5
					if ($rank_current>$rank_next&&$key)
					  {
						$show_rift=false;
						if ($show_rift) echo "<div>Подошли к порогу (текущий/следующий: $rank_current : ".$rank_next.")</div>";
							
						######################################
						//если массив для кластера сформирован
						if (count($arrResultsItemDataID)) { 
							//отсортировать по длине фразы:
							asort($arrResultsItemDataLen);
							foreach ($arrResultsItemDataLen as $lkey=>$ldata)
							  {	//id,name,rank
								$arrResultsRankFinal[]=
								array( 'item_table'=>$arrResultsItemDataTable[$lkey], 
									   'item_id'=>$arrResultsItemDataID[$lkey],
									   'item_name'=>$arrResultsItemDataName[$lkey],
									   'rank'=>$rank_current
									 );
							  }
						}	

						##############################
						//сбросить всё:
						$w=0;
						$arrResultsItemDataTable=array();
						$arrResultsItemDataID=array();
						$arrResultsItemDataName=array();
						$arrResultsItemDataLen=array();					
						$make_cluster=false;
					  }
				  }
			}
	      }
		
		//$go_test=true;
		if ($go_test) {?><hr><?  
			for ($a=0;$a<count($arrResultsRankFinal);$a++)
			//id,name,rank
			echo "<div>".($a+1)." ) [".$arrResultsRankFinal[$a]['item_table']."] [".$arrResultsRankFinal[$a]['item_id']."] ".$arrResultsRankFinal[$a]['item_name']." (".$arrResultsRankFinal[$a]['rank'].")</div>";
			die();
		}
		return $arrResultsRankFinal;
	}
} ?>