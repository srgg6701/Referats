<?
class Tools {

	//public $arr_files_zip=array();
	public $arrFilesRest;
	public $arr_files_name_zip=array(); //�������� ��� ������
	public $arr_files_size_zip=array();
	public $arr_files_time_zip=array(); //����� �������� �
	public $arr_files_path_zip=array(); //���������� ������ �� ���� (HTTP)
	public $arr_files_place_zip=array(); //���������� ����� ��� ���������

	//�������� ������ � ����. ���������� ��������:
	function addObjStatRec($table,$menu,$object_name,$author_id=false) {
	
		global $Author;		
		global $catchErrors;		
		
		if ($_SESSION['S_USER_TYPE']=="author") {

			//if (isset($_SESSION['TEST_MODE'])) echo "<div>method addObjStatRec</div>";
			//��� ������/������ ������� ������:
			$allAutorOrders=$Author->getAllAuthorsOrdersNumbers($Author->getAllAuthorsWorxNumbers($author_id));
			$inOrders=(is_array($allAutorOrders)&&count($allAutorOrders))? implode(",",$allAutorOrders):"0";

			switch ($table)  { 
		
				case "ri_worx": //����� ����� ����������� ����. ri_basket, ������ ��� ���������� ������, � �� ������
					$byActor="
   AND number IN ($inOrders)";
   					$table="ri_basket"; //����������...
						break;
		
				case "ri_messages":
					$byActor="
   AND receiver_user_type = 'author'
   AND receiver_user_id REGEXP '(^|,)".$_SESSION['S_USER_ID']."(,|$)' ";
						break;
		
				case "ri_payouts":
					$byActor="
   AND ri_basket_id IN ($inOrders)";
						break;
			}
		}

		//�������� ��������� ������:
		$qSelGetLast="SELECT last_id FROM ri_objects_stat
 WHERE actor_type = '$_SESSION[S_USER_TYPE]' 
   AND actor_id = $_SESSION[S_USER_ID]
   AND `table` = '$table'
ORDER BY number DESC LIMIT 0,1"; 
		//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSelGetLast,"�������� ��������� ������");
		$rSelGetLast=mysql_query($qSelGetLast);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSelGetLast",$qSelGetLast);
		//id ���������� �������:
		$previous_id=(!mysql_num_rows($rSelGetLast))? '0':mysql_result($rSelGetLast,0,'last_id');
		//echo "<div>previous_id= $previous_id</div>";		
		//
		$qSel="SELECT number FROM $table WHERE number > $previous_id $byActor ORDER BY number DESC"; 
		//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel,false,false);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		$news_count=0;
		while ($arr = mysql_fetch_assoc($rSel)) $news_count++;
		//echo "<div>news_count= $news_count, menu= $menu, object_name= $object_name</div>";
		if ( $news_count&&$menu==$object_name&&
		     ( $menu!="messages" || $_REQUEST['action']!="compose" )
		   ) {
			
			$qIns="INSERT INTO ri_objects_stat ( `table`, 
						  last_id, 
						  last_datetime, 
						  actor_type, 
						  actor_id 
						) VALUES 
						( '$table', 
						  '".mysql_result(mysql_query($qSel." LIMIT 0,1"),0,'number')."', 
						  '".date("Y-m-d H:i:s")."', 
						  '$_SESSION[S_USER_TYPE]', 
						  '$_SESSION[S_USER_ID]' 
						)";
			$catchErrors->insert($qIns);
		}
		//�����. ����� ��������:
		return $news_count;
	} //	����� ������
	//������ �������:
	function arraysDiff($arrContainer,$func=false) {
		//��������, ��� ������ �����:
		$func=(!$func)? "$_SERVER[REQUEST_URI] ... ":"$_SERVER[REQUEST_URI] ... $func()";
		
		//$test_array=true;
		if ($test_array) {
			$i=0;
			foreach ($arrContainer as $array) {
				foreach ($array as $key=>$val)
					echo "<div>$key=>$val</div>";
				echo "<br>\$i=[$i]<hr>";
				$i++;
			}
		}
		if (is_array($arrContainer[0])&&count($arrContainer[0])) {	//�� ��������� ����������� ��� ���������� ������� �������� ��������:
			$arrOutput=$arrContainer[0];//������ ������
			for ($i=1;$i<count($arrContainer);$i++) { 
				if (count($arrContainer[$i])) {
					@$arrOutput=array_diff($arrOutput,$arrContainer[$i]);  
					//���� ����...
					if (!$arrOutput&&$_SESSION['TEST_MODE']) {
						echo "<div>������ ���������� $func -> arraysDiff($arrContainer)<hr>arrOutput= ";
						var_dump($arrOutput);
						echo "<br>arrContainer[$i]= ";
						var_dump($arrContainer[$i]);
						echo "</div>";
						//�������� �� ������ ��������� �� ������ (���� �� �������� �������, ����� - ������� ����� �� ��������):
    					if (!$i) $catchErrors->sendErrorMess ($errSubj,$mssText);
					}
				}
			}
			$sort=sort($arrOutput);
			if (!$sort) echo "<div class='txtRed'>func= $func</div>";
			return $arrOutput;
		} else return false;
	}//	����� ������ arraysDiff()
	//���������� �������, � ��������������� ��������� �� �������������
	//��������! ������ �������� - ������ ������������ ��������
	function arraysMergeAndUnify($arrContainerForAll,$unique=false) {
		$arrOutput=array();
		
		for($a=0;$a<count($arrContainerForAll);$a++) 
			
			if (is_array($arrContainerForAll)&&count($arrContainerForAll[$a])) {
				if (is_array($arrContainerForAll[$a]))
					foreach ($arrContainerForAll[$a] as $data) $arrOutput[]=$data;
			}
		if ($unique) $arrOutput=array_unique($arrOutput);
		//echo "<hr>count: ".count($arrOutput)."<hr>";//var_dump($arrOutput); 
		return (count($arrOutput))? $arrOutput:false;

	}	//	����� ������ arraysMergeAndUnify()
	//������� ����� �� ����������, ��� ������ ���� ������ �������� ��������:
	function clearToInteger($data) {
		return preg_replace("[^0-9]","",$data);
		//die("<hr>work_id: $_REQUEST[work_id] -> $work_id");
	}	
	//������� ����� �� ����������, ��� ������ ���� ������ �������� �������� � ���������� ������� ��� ������ ���������� ��������:
	function clearToIntegerAndStop($inbox_variable) {
		return preg_replace("/[^0-9]/",'',$inbox_variable);
	}
	//
	function convertField2CPU( $table,
							   $field, //��� ���� c ������� �� ���������
							   $value, //�������� �������� ���� ��� �����������
							   $cpu=false //��������� ������������ ��� (���� �������� �� ���������)
							 ) { //echo "<h5>".gettype($type).": $type</h5>";
		
		global $catchErrors;
		//diplom_worx_types.type
		//diplom_worx_topix.predmet
		
		if ($cpu) {
		
			$sel_field="human_friendly_url";
			$get_field=$field;
		
		}else{
			$sel_field=$field;
			$get_field="human_friendly_url";
		}
		//		
		$qSel="SELECT `$sel_field` FROM $table WHERE `$get_field` = '$value'"; 
			 //$cpu
			 //SELECT human_friendly_url FROM `diplom_worx_topix` WHERE predmet = 				'������� ��������'
			 //		  `$sel_field`			  $table			  		$get_field=field	  	$value
			 //$!cpu
			 //SELECT predmet FROM `diplom_worx_topix` WHERE human_friendly_url = 				'pishchevye-produkty'
			 //		  `$sel_field`=field			  $table			 $get_field				$value
			 
		//if (isset($_SESSION['TEST_MODE']))
			//$catchErrors->select($qSel,1);
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		$sel_rows=mysql_num_rows($rSel);
		if ($sel_rows) return mysql_result($rSel,0,$sel_field);
	}	
	//�������������� ��������� � ��������:
	function convertToLatin($string) {
		$string=trim($string);
		
		### ��������! ����� � �������� ������ ������� ����� � ��������� �����, �.�. �� ����������� ������� ������� strtolower �� ��������.
		### ��������� �������: 
		//���� �������� �� ���������� ��������, �� �� �������� �� �������, �� ��, ��� ��������� ����������� �� ��������� �������������� ���������� ������ ������� �������������� (http://otvety.google.ru/otvety/thread?tid=10781cd072dc0757)  
		### ��������� �������: 
		// setlocale(LC_CTYPE,[])
		$arrLetters=array( ','=>';',
						   ' '=>'-',
						   '�'=>'a',
						   '�'=>'b',
						   '�'=>'v',
						   '�'=>'g',
						   '�'=>'d',
						   '�'=>'e',
						   '�'=>'yo',
						   '�'=>'zh',
						   '�'=>'z',
						   '�'=>'i',
						   '�'=>'i',
						   '�'=>'k',
						   '�'=>'l',
						   '�'=>'m',
						   '�'=>'n',
						   '�'=>'o',
						   '�'=>'p',
						   '�'=>'r',
						   '�'=>'s',
						   '�'=>'t',
						   '�'=>'u',
						   '�'=>'f',
						   '�'=>'h',
						   '�'=>'ts',
						   '�'=>'ch',
						   '�'=>'sh',
						   '�'=>'shch',
						   '�'=>'',
						   '�'=>'y',
						   '�'=>"",
						   '�'=>'e',
						   '�'=>'ju',
						   '�'=>'ya',
						   '�'=>'a',
						   '�'=>'b',
						   '�'=>'v',
						   '�'=>'g',
						   '�'=>'d',
						   '�'=>'e',
						   '�'=>'yo',
						   '�'=>'zh',
						   '�'=>'z',
						   '�'=>'i',
						   '�'=>'i',
						   '�'=>'k',
						   '�'=>'l',
						   '�'=>'m',
						   '�'=>'n',
						   '�'=>'o',
						   '�'=>'p',
						   '�'=>'r',
						   '�'=>'s',
						   '�'=>'t',
						   '�'=>'u',
						   '�'=>'f',
						   '�'=>'h',
						   '�'=>'ts',
						   '�'=>'ch',
						   '�'=>'sh',
						   '�'=>'shch',
						   '�'=>'',
						   '�'=>'y',
						   '�'=>"",
						   '�'=>'e',
						   '�'=>'ju',
						 );
		//
		$string=strtolower($string);
		//echo " string= $string<hr>";
		for($i=0,$s=strlen($string);$i<$s;$i++) { //������
			$letter_key=strtolower($string[$i]); //� � � � � �
			//echo "letter_key= $letter_key, ";
			if (array_key_exists($letter_key,$arrLetters)) {
				//������
				foreach ($arrLetters as $letter_source=>$letter_converted) 
					if ($letter_key==$letter_source) $word.=$letter_converted; 
			}else $word.=$letter_key;
		}
		return $word;
	} //����� ������		
	
	//�������� ���������� �����:
	function detectExt($file,&$fext) {
		$fext=strtolower(substr($file,strlen($file)-4,4));
		$fextx=strtolower(substr($file,strlen($file)-5,5)); 
		if ( $fext==".xls" ||
			 $fext==".doc" ||
			 $fextx==".docx" ||
			 $fextx==".xlsx" ||
			 $fext==".rtf"
		   ) $extype="office";
		else $extype=($fext==".zip" || $fext==".rar")? "archive":"unknown";
		return $extype;
	}	
	//��������, �� �������� �� ��������� ���� �����������:	
	function detectFolderInZip($unzipped_file_name,&$files_count) { 
		
		//global $files_count;
		// ��������� ������ ����� ����a:
		$last=substr($unzipped_file_name, strlen($unzipped_file_name)-1);
		//
		return ($last=="/"||$last == "\\")? true:false;	
	}
	//
	function ddmmyyyy($datatime) {
			return $datatime[8].$datatime[9].
			".".$datatime[5].$datatime[6].
			".".$datatime[0].$datatime[1].$datatime[2].$datatime[3];
	}
	//
	function hms($datatime) {
			return substr($datatime,11,8);
	}
	//
	function dtime($datatime) {
			echo $this->ddmmyyyy($datatime)." ".$this->hms($datatime);
	} 	
	//function to login and change by FTP
	function chmod_custom($path, $mod, $ftp_details) {
		
		// extract ftp details (array keys as variable names)
		extract ($ftp_details);
		 
		// set up basic connection
		$conn_id = ftp_connect($ftp_server);
		 
		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		 
		// try to chmod $path directory
		$success=(ftp_site($conn_id, 'CHMOD '.$mod.' '.$ftp_root.$path) !== false)? TRUE:FALSE;
		 
		// close the connection
		ftp_close($conn_id);
		return $success;
	}
	//�������� ������ �����������:
	function getAttachesArray($filename,$func=false) {
				
		if (isset($_REQUEST['show_attach'])) die("<div class='iborder'>mail_filetime (attach)= $mail_filetime</div>func= $func");
		
		if (file_exists($filename)) { 
			//
			$letter=file_get_contents($filename);
			//
			if (!$letter) {
				chmod($filename,0777);
				$letter=file_get_contents($filename);
			}
			
			if ($letter[0]=='s' && $letter[1]==':') $letter=unserialize($letter); //die("<h3>S:</h3>");			
			if ($letter[1]=='%' && $letter[2]=='3' && $letter[3]=='A') $letter=rawurldecode($letter); //die("<h3>%3</h3>");
			
			$arrMessage=unserialize($letter);
			//������� ������ �����������:
			if (is_array($arrMessage["attach"])) $message=$arrMessage["attach"];
			return $message;
		
		}//elseif (isset($_SESSION['TEST_MODE'])) echo "<div style='padding:4px;' class='iborder'>�� ���������� \$filename!<div class='txtRed'>filename= $filename</div></div>"; 	
	}	//����� ������ getAttachesArray
	//��������� �� ��������� ����������:								
	//�������� ����� ���������� ��������� �����:
	function getFiletime($full_path_to_file,$mess=false,$filetype=false) {

		if ($_SESSION['TEST_MODE']&&$mess) {
			if (!$filetype) $filetype=filetype($full_path_to_file);
		}
		return date("Y-m-d H:i:s",filemtime($full_path_to_file));
	
	}	//	����� ������ getFiletime()
	//�������� ����� ���������� ��������� ����� �� FTP:
	function getFileTimeByFTP($znum,$file_path) {
		
		if (!strstr($_SERVER['HTTP_HOST'],"localhost")) {

			// ��������� ����������
			$conn_id = ftp_connect("educationservice.ru");
			
			// ���� � ������ ������������ � �������
			$login_result = ftp_login($conn_id, "rossorig", "[edfyncnekbdajhtdth");
			
			//$file_path="/domains/diplom.com.ru/public_html/zip/$znum/".$file_path;
			$pstart="/home/rossorig";
			if (strstr($file_path,$pstart)) $path=substr($file_path,strlen($pstart)+1);
			//  ��������� ������� ����������� �����
			$buff = ftp_mdtm($conn_id, $path);
			
			if ($buff!=-1) {
				
				// ���� ��������� ����������� somefile.txt : March 26 2003 14:16:41.
				//if (isset($_SESSION['TEST_MODE'])) echo "���� ��������� ����������� $path: ";
				$filetime=date("d-m-Y H:i:s.", $buff);
				
			}elseif (isset($_SESSION['TEST_MODE'])){
				
				echo "<div class='txtRed'>�� ������� ��������� mdtime</div>path= $path";
			}
			
			// �������� ����������
			ftp_close($conn_id); //echo "buff= $buff";			
			return $filetime;
		}
	}	//	����� ������ getFileTimeByFTP()
	//�������� ���� �������� ����� � �������:
	function getDateFromEventsFiles($znum,$file_name,$class_name=false) {
		
		global $catchErrors,$Tools; 
		if (!$znum) $znum=$_REQUEST['work_id'];
		$znum=$Tools->clearToIntegerAndStop($znum);

		$qSel="SELECT `date`
  FROM diplom_events_files 
 WHERE znum = ".$znum."
   AND ( `file_name` ='".$file_name."' )";
		//if (isset($_SESSION['TEST_MODE'])) $catchErrors->select($qSel);
		$rSelEventsFilesDate=@mysql_query($qSel);
		//��������� ������ �� ������:
		$funcMess="		
		class: $class_name 
		================================================================
		\$_GET[work_id]=$_GET[work_id]";
		//�������/����� ������:
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel,"getDateFromEventsFiles",$funcMess);				
		if (mysql_num_rows($rSelEventsFilesDate)) return mysql_result($rSelEventsFilesDate,0,'date'); 
	}	//	����� ������ getDateFromEventsFiles()
	//
	function setCHMODE ($filename) {
		
		if (!strstr($_SERVER['HTTP_HOST'],"localhost")) {
			//������������ $filename, ���� ������ - 
			//	/domains/diplom.com.ru/public_html/zip/���_����������/���_�����
			//������
			//	/home/rossorig/domains/diplom.com.ru/public_html/zip/���_����������/���_�����
			$filename=substr($filename,14); //echo "<div>filename= $filename</div>";

			//settings	//$folders = array("/feeds/","/sitemap/");
			
			$folders = array($filename);
			$ftp_details['ftp_user_name'] = "rossorig";
			$ftp_details['ftp_user_pass'] = "[edfyncnekbdajhtdth";
			$ftp_details['ftp_root'] = '';
			$ftp_details['ftp_server'] = 'ftp.educationservice.ru';
			
			//the actual transaction
			foreach($folders as $folder) {
				//	=>/feeds/
				//	=>/sitemap/
				if (!$this->chmod_custom($folder, "0644", $ftp_details)) die ("<div class='padding10 txtRed'>������ ��������� ���� ������� � ����� $filename</div>");		 		
			}
		}
	}
	//������������ ����� ������ ��� ���� ������ � ������� cpu: 
	function setWorkParamCpuLink($work,$param=false){ //�� ��������� - ��� ������

		if($param=='area'){
		
			$table="diplom_worx_topix";
			$field="predmet";
			
		}else{

			$table="diplom_worx_types";
			$field="type";

		}
		
		return $this->convertField2CPU( $table,
							   	  $field, //��� ����, �������� �������� ���� ��������
							   	  $work, //�������� �������� ��������
							   	  true //��������� ������������ ���
							 	);
	}      
	//��������� ���� � �������� ���������� � ��������� ����� �������:
	function putFileToTemp($file_content,$dir=false,$rights=0777) {  
		global $catchErrors; 
		if (!$dir) $dir="temp/".session_id().".zip";
		//������� ���� ����������:
		$full_path_to_file=$_SESSION['DOC_ROOT_DIPLOM'].$dir;
		//��������� �� ��������� ���������� ��� ���������� �������� � �������:
		@file_put_contents($full_path_to_file,$file_content); //$file_content - �������� ���������� ����� foreach
		$chmod=@chmod($full_path_to_file,$rights);
		if (!$chmod) {
			if (strstr($_SERVER['REQUEST_URI'],"index_temp.php")) echo "<h2 class='txtRed'>������ ��������� ���� ������� � ����� $full_path_to_file!</h2>";
			//�������� �� ������ ��������� �� ������ (���� �� �������� �������, ����� - ������� ����� �� ��������):
			else $catchErrors->sendErrorMess ($errSubj,$mssText);
		} 		
		//���������� ����������:
		//$show_perms=true;
		if ($show_perms)
			if (isset($_SESSION['TEST_MODE'])) {
				if (!file_exists($full_path_to_file)) $none="��";
				echo "<div>������������� ����� ������� � ����� $full_path_to_file � ���. temp:<hr>���� $full_path_to_file $none ����������</div>";
			}
		return $full_path_to_file;
	} //����� ������
	//���������� ����� .zip
	//��. �������� � Docs/����� ������� � �������.xls
	function unpackZip ( $fileArrayData, //��������������� ����� (������������) (/home/rossorig/domains/diplom.com.ru/public_html/zip/[id]/[file_name].zip)
						 &$files_count,
						 $log=false
					   ) { 
		if (!$files_count) $files_count=0;
		global $build_table; //����� ������ ��������� ������� ������ ������
		global $catchErrors,$Worx,$Blocks; 
		//global $block_build_table_test; //����������� ����� �������� ���������� � ������� ���������� ������
		//global $files_count; //����� ������� ������ ������
		
		//���������� ����������:
		if (isset($_REQUEST['log'])) $log=$_REQUEST['log'];
		//
		if (isset($_SESSION['TEST_MODE'])) 
			echo "<TR>
					<TD colspan='4' bgcolor='#eeeeee'>METHOD = ".__METHOD__."<BR>LINE = ".__LINE__."
					<h4>build_table = $build_table</h4>
					</td>
				  </tr>";

		$order_id=$fileArrayData['work_id']; 
		$source_type=$fileArrayData['source_type']; 
		$filename=$fileArrayData['file_name'];
		$filetime=$fileArrayData['filetime'];
		$full_path_to_file=$fileArrayData['full_path_to_file'];			
		//���������� ����������:
		if (isset($_SESSION['TEST_MODE'])){
			echo "<tr><td colspan=4 class='bgPale'>".__FUNCTION__."<BR>".__METHOD__."<br>";
			if (isset($_REQUEST['show_annotation'])) 
				echo"<h5>build_table(global)= $build_table</h5>filename= $filename";
			var_dump('<pre>',$fileArrayData,'</pre>');
			echo "</td></tr>";
		}
		if ($order_id) $mess=" [unpackZip($full_path_to_file)]";

		//���������� ����������:
		if (isset($_REQUEST['test_unpack'])) 
		if (isset($_SESSION['TEST_MODE'])) echo (!$build_table)? "<h4 class='padding0'>�������� ���������� ������ $full_path_to_file...</h4>":"<tr><td colspan=4 class='bgPale'><h4 class='padding0'>�������� ���������� ������ $full_path_to_file...<br></h4></td></tr>";	
		
		//die ("\$this->arrFilesRest=".$this->arrFilesRest);

		if (!strstr($_SERVER['HTTP_HOST'],"localhost")) 
			//��������!
			//���� � ���������� ����� ��� ������� ���� ����������, ��������� ����� �� ���. temp/session_id().zip, ���� �� ��� �������:
			$zip=zip_open($full_path_to_file);
		
		//���� �������:
		if ($zip) { 
		
			if ($log&&$_SESSION['TEST_MODE']) echo (!$build_table)? "<div bgColor='lightskyblue' class='paddingLeft10'><b>������� zip</b></div>":"<tr><td colspan=4 bgColor='lightskyblue' class='paddingLeft20'><b>������� zip</b></td></tr>";
				
			$zip_read=0;
			//���� ���� ����������:
			if (gettype($zip)=="resource") { 

				//�������� ������������� ����:
				while ($zip_entry = zip_read($zip)) { 
				
					//����������� � �������������� DOS->Windows ��������� ��� �����:
					$zip_entry_name=iconv("cp866","windows-1251",zip_entry_name($zip_entry));
					
					if ($log&&$_SESSION['TEST_MODE']) echo (!$build_table)? "<blockquote class='paddingLeft10'><b>������ zip</b></blockquote>":"<tr><td colspan=4><blockquote style='padding-bottom:0; margin-bottom:0;'><b>������ zip</b><div>zip_entry_name= $zip_entry_name</div></blockquote></td></tr>";
					//� ����� ����� ���� ������ ��� �������� ����:
					if (strstr($zip_entry_name,"/")||strstr($zip_entry_name ,"\\")) {
						//��������� ��������� ����� ����� �����:
						if (strstr($zip_entry_name,"/")) $zip_entry_name=strrchr($zip_entry_name,"/");
						else $zip_entry_name=strrchr($zip_entry_name,"\\"); 
						$zip_entry_name=substr($zip_entry_name,$zip_entry_name[1],strlen($zip_entry_name)); 
					}
					


					$local_file_name_unzipped_decoded=$zip_entry_name; 
					
					$mess=" [unpackZip($full_path_to_file)]";
					//�������:
					//if ($log)
						if (isset($_SESSION['TEST_MODE'])) 
							echo "<tr>
									<td colspan=4>METHOD = <b>".__METHOD__."</b><BR>
							LINE = <b>".__LINE__."</b>
							<hr>
							zip_entry_name = $zip_entry_name
							<blockquote style='margin-bottom:0;'><b>! DIR</b></blockquote>
							</td>
						</tr>";
					
					$files_count++;
					//						
					if (zip_entry_open($zip,$zip_entry,"r")) { // ����������� zip-����
				 
						//�������� ������ (����������) �����:
						$fext=$this->detectExt($local_file_name_unzipped_decoded,$fext);
						//���������� ����������:
						if (isset($_SESSION['TEST_MODE'])) {
							
							echo "<tr><td colspan=4 class='bgPale' style='padding-left:60px;'>zip ������...<br>fext= $fext</td></tr>";
						}
						//���� �� �������� �������:
						if (strstr($fext,"doxs")||strstr($fext,"rar")||strstr($fext,"doxs")) {	
							//�� ������ ������ ������ ����������� �������, ��������:
							if (!$is_array($this->arrFilesRest)) $this->arrFilesRest=array();
							//�������� ������ ����������� ����� � ������:
							$this->arrFilesRest[]=array('ext'=>$fext,'file_name'=>$local_file_name_unzipped_decoded);
						
						}else{ //���� office:

							//�� ���� - 
							if (strlen($filetime)<19) {
								//�������� ����� �������� ������
								$arch_time=$this->getDateFromEventsFiles($order_id,$file_name,"Tools->unpackZip");
							
							}
							//								
							$incomingFileArrayData=array (  'work_id'=> $order_id,
															'source_type'=> $source_type,
															'file_name' => $local_file_name_unzipped_decoded,
															'ext' => $fext,
															'size' => zip_entry_filesize($zip_entry),
															'filetime'=>$filetime,
															'full_path_to_file'=> $full_path_to_file //��� ����� � ���. ������
														  );
							//�������:
							if (isset($_SESSION['TEST_MODE'])) 
								echo "<tr>
										<td colspan=4 class='bgYellow'><b>build_table= $build_table</b><hr>
										METHOD = <b>".__METHOD__."</b><BR>
										LINE = <b>".__LINE__."</b>
										<hr></td>
									  </tr>";
							//���� ����� ��������� �������:
							if ($build_table) { //global
								//���������� ����������:
								$test_row=true;
								if ($_SESSION['TEST_MODE']&&$test_row) {  ?><TR><TD colspan="4" bgcolor="#ff3399" style="padding-left:60px;">���������� ������ ������� ������...</TD></TR><? }
								//������������� ������ � ������� ������ ������:
								$Blocks->generateTableRow ($incomingFileArrayData,$files_count,"class.Tools->unpakZip()",$arch_time);
							} //� ����� ������ ���� ���������� ������ $incomingFileArrayData
						}
											
						zip_entry_close($zip_entry);
						
					}elseif ($this->detectExt($local_file_name_unzipped_decoded,$fext)!="unknown"){
						//�������:
						if (isset($_SESSION['TEST_MODE'])) echo "<div class='txtRed'>��������� �� ���������!</div>";
						return false;
					}					
					$zip_read++;
				}
				zip_close($zip);
				
				if ($log&&$_SESSION['TEST_MODE']) echo (!$build_table)? "<div><b>������� zip</b></div>":"<tr><td colspan=4 bgColor='#CCCCCC' class='paddingLeft20'><b>������� zip</b></td></tr>";
			} //�������:				
			if (isset($_SESSION['TEST_MODE'])){
				
				if ($log&&$_REQUEST['test_unpack']) {
										
					echo (!$build_table)? "<h4 class='txtWhite'>��������� ���������� ������...</h4>":"<tr><td colspan=4 bgColor='#666666'><h4 class='txtWhite'>��������� ���������� ������...</h4></td></tr>";
				}
				if (!$zip_read) {
					echo "<div class='txtRed'>Zip ($full_path_to_file) �� ������!</div>";
					return false;
				}else echo "<div class='txtGreen bold'>Zip ($full_path_to_file) ������!</div>";
			}
			
			return $incomingFileArrayData;
			
		}else{
			
			if ($log&&$_SESSION['TEST_MODE']) echo "<div class='txtRed'>����� �� ��� ������!</div>";
			//�������� ������ - �� ���������� �� �������, (��� ) ������������� ����� �������:
			//chmod($full_path_to_file,0777);//$zip=zip_open($full_path_to_file);
			//�������� �� ������ ��������� �� ������ (���� �� �������� �������, ����� - ������� ����� �� ��������):
			$message="
			id ������: 				$order_id
			�������� �����: 		$source_type 
			��� �����:				$filename
			���� �������� �����:	$filetime
			���� � �����:			$full_path_to_file
			<HR>
			".__FILE__."
			".__FUNCTION__."
			".__METHOD__;
    		$catchErrors->sendErrorMess ("�� ���������� �����",nl2br($message));
			return false;
		}
	}	//	����� ������ unpackZip
	function wrongExtIssue() {
		
		global $Messages;
		
		if (count($this->arrFilesRest)) {
			$mText="�����: ";
			for ($i=0;$i<count($this->arrFilesRest);$i++)
				foreach ($this->arrFilesRest[$i] as $key=>$data)
					echo "<div>".$data['file_name']."</div>"; //arrFilesRest[]=array('ext'=>$fext,'file_name'=>$local_file_name_unzipped_decoded);		
		
			$Messages->sendEmail ( "test@educationservice.ru",
								   "sale@referats.info",
								   "sale@referats.info",
								   "���� ���������� ������� � �������� ������� �����, ����� id $_REQUEST[work_id]",
								   $mText,
								   false
								 );
		}
	}	
}?>
