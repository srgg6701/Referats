<? //<h1>�����������!!!</h1>
//����� � ��
class dbSearch {

public $arrSearchPhrase;	//������ ��������� ����
public $arrStopWords;		//������ ����-���� (��� ������ ������������ ������ �������)
public $arrTableQueryResults=array();
public $go_test=false;
public $len_average;		//���������� ����� ����� ��������� �����
public $string_to_search;	//��������� �����
public $words_count;		//���������� ���� � ��������� �����

	//�������������� ���������� ��������� ������ � ���������:
	function prepareString($string_to_prepare) { 

		$go_test=$this->go_test;
		//��������� � ������ �������:
		$string_to_prepare=strtolower($string_to_prepare);
		//������ ������ ���������� ��������:
		$invalid="/[^a-z�-��]+/";
		//�������� ������������ �� �������:
		$string_to_prepare=preg_replace($invalid," ",$string_to_prepare);
		//������� ������� �� ������ � ����� ������:
		$string_to_prepare=trim($string_to_prepare);
		//������������ � ������:
		$arrPhraseToWords=explode(" ",$string_to_prepare);

		for ($i=0;$i<count($arrPhraseToWords);$i++) 
		  { if ($go_test) echo "<div>[$i]: ".$arrPhraseToWords[$i]."</div>";
		    if (strstr($arrPhraseToWords[$i],"�")) 
			  { if (strstr($arrPhraseToWords[$i],"�")) $new_word=str_replace("�","�",$arrPhraseToWords[$i]);
			    array_push($arrPhraseToWords,$new_word);
			  }
		  }
		return $arrPhraseToWords;
	}
	//��������������� ��������� ������:
	function prepareToSearch() {
		//������������ ��������� �����:
		$string_to_search=$this->string_to_search;	

		########################################
		$go_test=false;
		//$go_test=true;
		
		//�������� ������, ������������ �� ���� ���������� �������:
		//+��������� ����� ��������� �������, ����� ��������� ������ ���������� ��� ��������� ��� ������� � ��������� ������
		$arrSearchPhrase=$this->prepareString($string_to_search);
		$this->arrSearchPhrase=$arrSearchPhrase;	
		
		//����-�����:
		$this->arrStopWords=$arrStopWords=array("�","���","�����","��","���","����","����","����","����","�","���","���","����","��","���","���","�����","����","��","���","��","����","���","��","���","��","����","����","���","��","��","�����","�","��","��-��","���","��","��","�","���","���-��","��","�����","���","��","����","���","�����","��","��","����","���","��","����","��","���","��","���","��","��","�","��","������","��","���","���","���","��","�����","��","���","���","�","��","���","�����","�����","���","��","���","��","����","����","���","������","���","��","�","���","����","����","���","���","���","�����","���","���","���","���","���","�");
		
		//���������� ��������� ����:
		//����������� ��� ������� ���� ������� ���������� �����
		$this->words_count=count($arrSearchPhrase); 
		$show_strings=false;
		if ($show_strings) 
		  { ?><div class='padding10 bgYellow'>������������ ��������� ������ (<?=$string_to_search?>): <h2 style='display:inline;'><?=$string_to_search?></h2></div><hr>
          <div class='padding10 bgGreyRow'>������ ������������ ��������� ���� (<?=$arrSearchPhrase?>): <h2 style='display:inline;'><?=implode(", ",$arrSearchPhrase)?></h2></div><? 
		  }
	}
	//��������� ������� �� ������� � ������������ � ��������� ��������. ��� ���� ���� ������� ������������ �� ����������, ������ ��������� ����� ���������� ����������, ������� � �����, �� ��� ���, ���� �� ����� ������� ������ ��� ����� ����� �� ��������� ������� (3 �������).
	function makeSearchInTables( $field1,$field2,		//����� ����������� ����� //������ ���� - �������� ������
								 $table,				//������� ���������� ������
								 $and					//����� �� ���. ��������
							   ) { //echo "<div class='padding10'>makeSearchInTables.$table</div>";

		global $catchErrors;
		
		if (isset($_REQUEST['go_test'])) $go_test=true;
		
		$this->prepareToSearch();
		$this->prepareToSearch();
		
		//����� ����-�����:
		$arrStopWords=$this->arrStopWords;
		$arrSearchPhrase=$this->arrSearchPhrase;
			  	
		//���� ������ �� �����, ����� ��������� ��������� �����:
		$w=0;
		//���� �������������� ��������� �����:
		$arrPreResultsWorkID=array();
		//���� ���������� �������� � ������� �� ���� ��������� ��������� ���� - �� ������ �� ����������� (���������� �����������) �����
		//�� ������ �������� ���������� ��������� ��������� ������� � ������� ��� ������� ������������ ���������� �������
		
		##############################################################################################
		
		//$stop=true, ����� ��������� ��� �������� ���������� �������� ���������� �����
		//$rws=������� �������� �� ������� �� ������� ���������� ���� �� ���������� ���������� �����������
		while (!$stop) { //��������!
		    
			//��������� �������� ���� ���������� ���������� ������� ������, �.�. 
			//���������� ��������� ����� ��������� ����
			#####################################################################		
			//���� �������� �� ������ -
			if ($w) { //������� ������ �����, �� ��� ���, ���� �� ����� ��������������� ������ � �������:
				$s=0;
				foreach ($arrSearchPhrase as $key=>$qString) { //echo "<br>qString= $qString<br>";
					//[0]�����
					//[1]�������
					//������������� ����� ����������:
					if (strlen($qString)>3) {
						//���������� ��������� ����� �������� �����:
						$arrSearchPhrase[$key]=substr($qString,0,strlen($qString)-1);
						//
					$s++;
					}
				}
			
				//������� ���������� ��������� ���� �� ��������������
				//�� break, �.�. ���������� ��������� ��������� ����� ����
				if (!$s) $stop=true; 
			
				unset ($subquery_LIKE_name);
			}
			//�������������� ��������� ������:
			for ($i=0;$i<$this->words_count;$i++) { //������� ����� � ������� �� �������� ����-������:
				
				if (!in_array($arrSearchPhrase[$i],$arrStopWords)) {	//
					
					if ($subquery_LIKE_name) $subquery_LIKE_name.=" 
         OR ";
					$subquery_LIKE_name.="$field2 LIKE '%".$arrSearchPhrase[$i]."%'";
					//��������� ����� �����:
					$wlngth+=strlen($arrSearchPhrase[$i]);
	
				}
			} //echo "<pre>subquery_LIKE_name= $subquery_LIKE_name</pre>";
			
			//�����. ���� � ���������� �������:
			$words=count($arrSearchPhrase);
			
			//���������� ����� ����� (����� ��� ����������� ������� ������������ ���� �����):
			$this->len_average=($words)? ($wlngth/$words):$wlngth;
			
			//�������� ������ � ������� ������:
			if ($subquery_LIKE_name) { 
				
				//
				$qSel="SELECT $field1,$field2 
  FROM $table WHERE ( 
            $subquery_LIKE_name 
       ) $and";
				$rSel=mysql_query($qSel);
				$rws=mysql_num_rows($rSel);
				$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel); 
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
			$catchErrors->errorMessage(1,"","������ ���������� ������","qSelNmbrs",$qSelNmbrs); 
		
			while ($arr=mysql_fetch_assoc($rSelNmbrs)) 
				$this->arrTableQueryResults[]=array( 'table'=>$table,
													 'item_id'=>$arr[$field1],
													 'item_name'=>$arr[$field2]
												   );
		}
		$this->arrSearchPhrase=$arrSearchPhrase; //foreach($arrSearchPhrase as $key=>$phrase) echo "<div>$key=>$phrase</div>";
	}
	//���� ������ ������� - �������������� �������� ������ �������� � ���������������� ����������. �������� - ����� �����	
	function sortFoundedResults() {  
		
		//�������� ������ ����������� ������ � ��������:
		$arrTableQueryResults=$this->arrTableQueryResults;
		$rws=count($arrTableQueryResults);
		//�������� ������ ��������� ���� �����:
		$arrSearchPhrase=$this->arrSearchPhrase;
		//����� ����-�����:
		$arrStopWords=$this->arrStopWords;
		
		//���� ����� ������ � �������:
		//�������������� ��������� ��� ������ ������������ ���������:
		$arrResultsClusters=array();
		//������������� ������:
		$arrResultsRankFinal=array();
		//
		if ($rws)
		  {	//�������������� ��������� �����������
			$arrResults=array(); 
			##################################################################
			//����������� ������� ���������:
			##################################################################
			for ($i=0;$i<$rws;$i++) 
			  { //
			  	$item_table=$arrTableQueryResults[$i]['table'];
				$item_id=$arrTableQueryResults[$i]['item_id'];
				//��������
				$item_name=$arrTableQueryResults[$i]['item_name'];
				$item_name_len=strlen($item_name);//��� ������������ ��������� ������ ��������
				
				//echo "<br><hr><div class='padding10'>[item_table] $item_table<br>[item_id] $item_id<br><div class='iborder'>[item_name] $item_name</div>[item_name_len] $item_name_len</div>";
				
				//�������� �������� � �������:
				//��������� � ������� ������������ ����� ���������� �������:
				$arrWordsFound=$this->prepareString($item_name); 
				//�������
				unset($rank);  
				//�����. ��������� ����:		
				$words_count=count($arrWordsFound);
				
				##############################################################
				$show_test_row=false;
				if ($go_test) 
				  { ?>
				  <tr style="display:<? if(!$show_test_row){?>none;<? }?>">
					<td colspan=3><!--item_id= <?=$item_id?>, rws= <?=$rws?>, i= <?=$i?>-->
				  
				<div class='padding10 iborder' style="background-color:#f5f5f5; display:<?="none"?>;">������� �������� [<?=$i+1?>]:
					<div onclick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" style="font-size:2em; font-weight:bold; cursor: pointer;"><? if ($test_header) {?>�������� ��������<? } else echo $item_name?></div>
					<div style="display:<? echo "none";?>; padding:6px; background-color:#E8FFE8">
					������: arrSearchPhrase=<? var_dump($arrSearchPhrase);?><hr><? 
				  } 
				//=���������� ���� ���������� �������:
				for ($s=0;$s<$this->words_count;$s++)
				  {	//echo("<hr>count= ".count($arrSearchPhrase)); 
				  	//echo "<hr>words_count= $words_count"; 
					//������ ��� ���������� ����, ��������� � ���������� ���������. �����, ����� ��������� ��������� ���������� ������:
					$arrStopWordChecking=array();
					//������� ����� �� ���������� �������:
					$wordFromSearch=$arrSearchPhrase[$s]; 
					
					//��������� ������ ����� �� ��������� �����:		
					#####################################################
					for($j=0;$j<$words_count;$j++) //����� ��������� �����
					  { //$show_loop_enter=true;
						if ($show_loop_enter) echo "<br>����� � ����[$i] �������� ������� ����� �� ��������� �����";
						//echo "<div class='bgPale'>$j/[$words_count] ��������� �����: $arrWordsFound[$j]</div>";						
						unset ($blike);		
						unset($bonus);									
						//������� ��������� �����:
						$wordFromFound=$arrWordsFound[$j];	  
						
						if ($go_test) 
						  { $words_to_compare="<div class='padding10 iborder' style='background-color:#ffe8dd'>������������ ����� <span class='txtDarkBlue'>[$j]</span> �� $words_count: 
							���������: <b class='txtRed bgSystemLight'>$wordFromSearch</b>, ���������: <b class='txtGreen bgPale'>$wordFromFound</b></div>";
						  }
						  
						//���� ��� ����� �� ������� � ����-�����:
						if ( !in_array($wordFromSearch,$arrStopWords) &&
							 !in_array($wordFromFound,$arrStopWords)
						   )
						  { $go_test=true;				
							if ($go_test) $stop_checked="������[$j] �������� �� ����-����� /<strong>$wordFromSearch</strong>/ ";
							$go_test=false;
							
							//����� ���������� �����:
							$word_from_search_phrase_len=strlen($wordFromSearch); 
							//����� ���������� �����:
							$word_from_subject_len=strlen($wordFromFound);							
							//������� ����� ����� ��������� (�� �������� �������� �� ����):
							$compare_count=($word_from_search_phrase_len>$word_from_subject_len)? $word_from_subject_len:$word_from_search_phrase_len;
								
							if ($go_test) 
							  { $check_words_identity="<DIV class='padding10'><strong>�������� ���������� ����:</strong></div>";
								$check_words_identity.="<div>wordFromSearch= <b>$wordFromSearch</b><br>wordFromFound= $wordFromFound</div>";
							  }

							##############################################################
							//���� ����� ������� ���������:
							if ( $wordFromSearch==$wordFromFound &&
								 //����� �� ��������� � ������� ����� ��������� ������ ����������:
								 !in_array($wordFromSearch,$arrStopWordChecking) 
							   ) 
							  { //����������� ���������� �������� ���������� �����:
								$arrStopWordChecking[]=$wordFromSearch;
								//����� �� ��������� - 
								//������������ ����/���������� ��������� ����:
								//$bns=round(10/$words_count); 
								$bns=10/$words_count; 
								//echo "<div class='txtRed'>bns= $bns, pre_bns= ".(10/$words_count)."</div>";
								//
								$blike+=$bns;
								
								if ($go_test) echo "<div>blike[1]= $blike</div>";
								
								//���� ��������� ����� ������ ���������� �����:
								if ($word_from_search_phrase_len>$this->len_average) 
								  { //�������� �����:
									$bonus=($word_from_search_phrase_len/$this->len_average);//����� �������� ����� / ������� ����� ������� ����
									$bonus*=$bonus;
									$blike+=$bonus; 
									
									if ($go_test) echo "<div>blike[2]= $blike</div>";
									
								  }
								//����� �� ������� ����:
								if ($blike) 
								  { $bonus_for_word_order=$words-$k;
									if ($bonus_for_word_order>0) $blike+=$bonus_for_word_order; //if ($item_id==$ztest) 									
									if ($go_test) echo "<div>blike[3]= $blike</div>";						
								  } 
								  
								if ($go_test) $identity_true="<div class='padding10'>����� ������� ���������!</div>";

							  }	
							//���� ��� ������� ����������, ����� ��������� ���������� -
							//� ����� ����� �� ��������� ��������� � ���������:
							elseif (!in_array($wordFromSearch,$arrStopWordChecking))						
							  { 						
								if ($go_test) $no_identity.="<DIV>�� ����������. ����������� ���������:</DIV>";	
								
								//����� ���������� ��������� ����� � ����������:
								if ($go_test) $compare_phrases.="<DIV class='padding10 bgSystemLight'>";	
								
								//														
								for ($k=0;$k<$compare_count;$k++) //�����. ���� � ������� ��������� �����
								  { //���������� ��������� ����� � ���������� ����������:
									if ($wordFromSearch[$k]==$wordFromFound[$k]) 
									  { $blike+=1; 
										
										if ($go_test) $compare_phrases_by_letters.=" <span>[#$k]<strong>".$wordFromFound[$k]."</strong></span>";
									  }
									else break;
								  } 

								 //
								 if ($go_test) 
								   { if ($blike) $weight="<div class='bgWhite padding4'>��������� ������ ����� (blike): <span style='background-color:yellow;' class='padding4 iborder'>$blike</span></div>";
									 $report_string.="$weight
									 </div>";
								   }
							  }

							//������������� ������� �����:
							$rank+=$blike;

							if ($go_test&&$blike) { 
								
								echo "�����, ��������������� �� ��������� ��������: ".implode(",",$arrStopWordChecking)."<hr>";
								
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
						  {	//������� ����� ��������� ����������:
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
				  <div class='separatorBottom'>�����, <span class='padding4' style='background-color:yellow;'>������� ����� (dlike[<?=$i?>])= <strong class='txtDarkBlue txt110'><?=$rank?></strong></span>
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
				} //if ($go_test&&$i>25) break; //������ � ������ �������
			  }
			//������������� �� ��������: 
			
			$arrResultsRank=array();
			$arrResultsItemData=array();
			
			arsort ($arrResults); //var_dump($arrResults); 
		    reset($arrResults);

			//�������� � ����������������� ������� ����� � ��������:
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
				//�������� ������ ��� 
				//������� ������ ����������� (�������� ����� �������)
								//6			//7
				if ($rank_current<$rank_previous||!$key)	
				  { //
				    if ($key<count($arrResultsRank))
					  {	//$go_test=true;
					  	if ($go_test) echo "<div class='iborder padding4 bgYellow'>������ ������ ��������. Rank: $rank_current</div>";
						$go_test=false;
						
						//�� ������� � ������ �������� �� ������ �������:
						if ($rank_current>$rank_next) { 
						
							//$show_cluster_issue=true;
							if ($show_cluster_issue) echo "������� <span class='txtRed'>�� �����</span> �����������<hr>";

							$arrResultsRankFinal[]=
							array('item_table'=>$arrResultsItemData[$key]['item_table'],
								  'item_id'=>$arrResultsItemData[$key]['item_id'],
								  'item_name'=>$arrResultsItemData[$key]['item_name'],
								  'rank'=>$rank_current
								 );
							
							//echo "<div>arrResultsItemData[$key]['item_table']= ".$arrResultsItemData[$key]['item_table']."</div>";
							if ($go_test) echo "<div>[".$arrResultsItemData[$key]['item_table']."], ".$arrResultsItemData[$key]['item_id']."], ".$arrResultsItemData[$key]['item_name']." (".$arrResultsItemData[$key]['item_name_len'].")</div>";						   
						}else{ //������� ����� ������������ ���������:
							//��������� �������� ��������:
							$make_cluster=true;	
						}
					  }
				  } //echo "<div>key= $key | count(\$arrResultsRank)= ".count($arrResultsRank).", make_cluster= $make_cluster</div>";
				//������ ������� ��� ����������� ��������������
				//�� ������ �������� �
				//������� ����� �����������
				######################################
				//���� ��������� �������� ��������:				
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

					//������� � ������:
									//6			//5
					if ($rank_current>$rank_next&&$key)
					  {
						$show_rift=false;
						if ($show_rift) echo "<div>������� � ������ (�������/���������: $rank_current : ".$rank_next.")</div>";
							
						######################################
						//���� ������ ��� �������� �����������
						if (count($arrResultsItemDataID)) { 
							//������������� �� ����� �����:
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
						//�������� ��:
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