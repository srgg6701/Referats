<? 
//echo "<h5>work_table=$work_table, table= $table</h5>";
//����� (%%) ����� ����������� ������:
$limit=20;
// 
if(isset($_REQUEST['mode'])) 
	$mode=$_REQUEST['mode'];
if(isset($_REQUEST['order_sent_id'])) 
	$order_sent_id=$_REQUEST['order_sent_id'];

$show_annotation=$_REQUEST["show_annotation"]; //true | false

$site_root=($_SESSION['T_ROOT_REFERATS'])? $_SESSION['T_ROOT_REFERATS']:$_SESSION['SITE_ROOT'];
//echo "<div>site_root= $site_root</div>";
/*//������� ����:
########################################
if (isset($_REQUEST['download_file_name'])) {?>
<script type="text/javascript">
//location.href='<?=$host_file.$_REQUEST['download_file_name']?>';
</script>
<?	//echo "<div>file= ".$host_file.$_REQUEST['download_file_name']."</div>";
	$order_sent_id=true;
}*/
	//����� ������/������� ������:?>
	<input name="order_work" id="order_work" type="hidden" />
	<input name="buy_work" id="buy_work" type="hidden" />
<div class="padding10"><?
//����� ���������� ������� $_REQUEST � ���������� ����������:
if (!$_SESSION['S_USER_TYPE']) { //echo "<h3>action= save</h3>";?>

      <input name="action" type="hidden" value="save" /><!--<input name="order_<?=($work_table=="diplom_zakaz")? "diplom_zakaz_add":"ri_worx_add"?>" type="hidden" value="1" />--><?  
}
//
if ($work_table=="diplom_zakaz"){
	//����� ��������� ������� $_REQUEST['work_id']
	$workFiles=$Worx->getWorkFilesData();
	/*
	'work_id'
	'source_type' //��������
	'file_name' //��� ������, ���������� �� ������ - ��� ����������
	'ext' //����������
	'size'
	'filetime'
	'full_path_to_file'	//��� ����� � ���. ������. ��� ����������� �������� ":"		
	*/
	//���������� ����������:
	if (isset($_SESSION['TEST_MODE'])) {
		echo "<div>workFiles= </div>";
		var_dump('<pre>',$workFiles,'</pre>');
	}
} 
$req_file_index=$Tools->clearToIntegerAndStop($_REQUEST['file_index']);
//���������� ���������� (���� ��������):
if (isset($_SESSION['TEST_MODE'])) {
	//$test_array_1=true;
	if ($test_array_1) {
		?><h4>�������� ������� $savedFiles:</h4><?
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
		?><h4>�������� ������� $workFiles:</h4><? echo "{ $_REQUEST[file_index] }";
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
//���� ���� ���������� ��� ����������:
if (!$order_sent_id) {
	
	//���� �� � ������ ��������� ��������������� ����� (��� diplom_zakaz ��� ri_worx.volume <> 'full' - ����� �� �������� ���� �������):
	if(!$show_annotation){ ?>
<br />
<div class="bold txt120"><img src="<?=$site_root?>images/info-32.png" width="32" height="32" hspace="4" align="absmiddle" />��������!</div>
<div class="paddingLeft4"><p>
<?		//������������� ��������� �������: 
		if ($work_table=="ri_worx") {
		
			if (isset($_SESSION['T_ROOT_REFERATS'])){
				
				?>��� ��� �������� ���������� ������������ � ������ ������ (�������� <?=$limit?>%). ����� ������� ���, �������� �� �������� ������. ����� �� ����� � ������ � ������ �� ������� �������� ������ �� ���� � ������ � ������ ������. ��� ������������� �� ������ �������� � ������ ����� �������������� ����������.</p><?		
			
			}else{
				
				?>�� ������ ����������� � ������ ������ (����� <?=$limit?>%). ��� ����� �������� �� � �������� <a href="#subj">����</a>. ��� ������ � ������ ������ �� ������� �������� ����� � ������. </p>
    <p>����� �� ������ ������ � ������ ����� ������������ ��� ������.</p><?
			}
			
	   }elseif ($work_table=="diplom_zakaz") {
		   
		   if (isset($_SESSION['T_ROOT_REFERATS'])){
			   
			   ?>��� ��� �������� ���������� ������������ � ������ ������ (�������� <?=$limit?>%) ������, ������������ � ������, �����. ����� ������� ���, �������� �� ��� ��������. ����� �� ����� ������ � ������  ������ �� ������� �������� ������ �� ����� � ���������� � ������ ������. ��� ������������� �� ������ �������� � ������ ����� �������������� ����������.</p><?		
			
			}else{
			
				?>�� ������ ����������� � ������ (����� 20%) ������ ������������ � ������ �����, ��������������� � ������� .<strong>doc</strong>|.<strong>rtf</strong>. ��� ����� �������� �� ��� �������� � <a href="#files_table">������� ����</a>. ���������� ������ ������ �������� �� ������ �����������, �������� ��� ��������������� ������. ��� �����, ����������, �������� ������ � ������� �������, � �������� ���, ����� ����� ��� ����������. </p>
    <p>����� ������ ������ �� ������� �������� ������ �� ���� <strong>� ������ ������.</strong></p>
    <p>����� �� ������ ������ ������ ����� ������������ ��� ������.</p>
    ��� �����, ����������, <a href="javascript:add_to_basket();">��������� ������ � ���� ������� �������</a> (��� �� ������ �� ����� ������������ �� � �������).<?	
			
			}
	   }?>
</div><br />
</p>
<hr noshade />

<?  } ?>

<h1 class="Cambria txt140 paddingTop10"><a href="<? 

	//������ ����� ����������� �� 2-� ������ ������:
	//diplom_zakaz 	- ����������� ������
	//ri_worx		- ������ �������
	if ($work_table=="ri_worx"){
		//
		$qSel="SELECT * FROM ri_worx
		 WHERE number = $work_id"; 
		$rSel=mysql_query($qSel);
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
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
		$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
		if (mysql_num_rows($rSel)) {
			$work_name=mysql_result($rSel,0,'subject');
			$work_area=mysql_result($rSel,0,'diplom_worx_topix.predmet');
			$work_type=mysql_result($rSel,0,'typework');
		}	
		//���������� ������:
		echo "?work_table=diplom_zakaz&amp;work_id=$work_id\">";?><img src="<?=$site_root?>images/Word2.png" width="64" height="64" border="0" align="absmiddle" alt="<?=$work_name?> <?=$work_area?>" /><?
	}
if($test_work_name){?>�������� ������.<? } echo $work_name; ?></a></h1>
  <hr size="1">
    <div class="padding10">
    <h2 class="txt120"><span class="noBold">�������:</span> <? echo($work_area)? $work_area:"�� ������";?></h2>
    <h2 class="txt120"><span class="noBold">��� ������:</span> <? echo($work_type)? $work_type:"�� ������";?></h2>
	<h4><span class="noBold"><? 
	
	if ($work_table=="diplom_zakaz") {?>��������� <sup>[<a href="#" onClick="alert(this.title);return false;" title="��������� ������ ���������� �������������, ������ �� �����, ����������� ���������� �� ��������� ���������� ������; �������� � ������������� � ����� �����������."><strong>?</strong></a>]</sup> �<? 
	}else echo "�";?>�������� ������: </span><? echo $Worx->calculateWorkPrice($work_table,$work_id,false);?></h4>
    </div>
<?  //������ "�������� � �������" � "������".
	function generateButtons($reg_area=false) {
		global $work_id,$site_root,$go_reg_form;?>
  <div style="padding:8 0 8 0;">
  <? 	//���������� ��� ������:
  		$bType='type="';
		//style, not class, �.�. ����������� �� ������ �� Referats.info
		if ($_SESSION['S_USER_TYPE']=="customer") $bType.="submit";
		else{
			
			$bType.="button";
			//
			$go_reg="document.getElementById('reg_area_1').style.display='block';";
			//������ ������, ��������� � ������ ������ � ���������� ���� ��� �������� ������
			if ($go_reg_form=="go") $go_reg="location.href='#register_form';".$go_reg; 
			//$go_reg.="document.getElementById('order_work').value='$work_id';";
			//������ ������ - ��������� ���������� ���� ��������������
			$go_reg="$go_reg return ";
			$go_reg.=($go_reg_form!="go")? "showAuthForm('$reg_area');":"false;";
		} 
		//�������� ������� � ������:
		$bType.='"';?>
<script type="text/javascript">
//���������� ��������� ���� �������� (�������/�������), ����� �������� ��� ������
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
    <input onclick="setActionType('order_work');<?=$go_reg?>" <?=$bType?> value="�������� � �������" style="padding:8px;"> 
    <input onclick="setActionType('buy_work');<?=$go_reg?>" <?=$bType?> value="������ ������!" style="padding:8px;">
    <img title="ٸ������ ������ ������� ������, ���� �� ��� �������� ������ ������" src="<?=$site_root?>images/info.png" width="17" height="17" /></div>
<?  	$go_reg_form="cancel";
	} //����� �������
	
	//echo "<div>work_volume= $work_volume</div>";
	//������� ��� ������� ����� �����:
	if ( $work_table=="diplom_zakaz"||
		 $work_volume=="full" //������ ��������� ������� ���������
	   ) { //+� ������ ��������� ���������

		//�������� �������� ��������� � ���� ���������:
		//*********************************************
		//������������� � .TXT
		if ($show_annotation) { 

			//�������������� � ������������� �������������������:
			//$Blocks->authorizeToAddToBasket(); ����� �� ����! ������ ��� ���������� ������������ ������ � ����������� ������� �����!
			$go_reg_form="go"; //anchor
			generateButtons('reg_area');?>
    
    <hr noshade>
  <div class="paddingTop10 paddingBottom10 txt140"><img src="<?=$site_root?>images/info-32.png" width="32" height="32" hspace="4" align="left" />����: <span class="bold" id="annotation_file_name"><?
  	$file_index=($req_file_index)? $req_file_index:"0";
	echo ($show_annotation)? $_SESSION["current_work_name"]:$work_name; 
	
	if ($test_file_name){?>{��� �����}<? }?></span>.
  <br />
  ��������������� ����� (����� <?=$limit?>% �� ������ ������).<br><br>
	<div class="padding10 txt70 iborder borderColorGray" style="background-image:url(images/bg_income.png); background-position:bottom; background-repeat:repeat-x;"><img src="<?=$site_root?>images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" /><strong>��������!</strong>
  	  <div style="padding:8px;">���������� ���� ����� ��������� ������������� � ����������� � ���� �������� ������ (plain text). ������� �� ����� ��������� ������ (������������� � ������������) ��������, � ����� ���������� �� ���������� �������������� �� ���������, ������� ����� ��� �������� ����� ������ ������ � <strong>����� ��������� ���������������</strong> ���������� ��������������, ��������� ��� ������ ������������ ������. ����� ����, ����� ������ �������� � ���������� �� ����� ������.</div>
  	</div>
  </div>
<?			//$test_text=true;
			if ($test_text) {?>�������� 
<p>�������� ���������  �������� � �������� � ����������� ������������ �� ������ ������� � ���������,  �� � �������������. ����������� ����������� �������� �������� ����������� �  ����� ��������� �������� ����� (� �����������, ��������, ��������,  ���������������� ����� � ��� �����). �� ������� ���� � ����� �������  ����������� ������������ � ������ ����������� ��������������� ������������  �������� � ���������� ��. </p>
<p> ��������  �������� ������������ �������� � ���������� � ��������������� ����� ������  ������ ���������� ���� � ������ ���������� ��� ������, ��������� � ���  �����������. � ����������� �������� ������������ �������� � ����������  ������������ ���� �������� �����������, � ��� ����� � ������ ���������� ���. �������� ��������������� �����������  �������� � ���������� ����� �������� ��������, �� ������� �� �����������  ��������� ������� ���� � ������������ �� ������ ��������������� ������. ���  ���� ���� ��������������� ����������� ����������� �� ������� ��������, ������ -  ������ �� ������� ��. &nbsp;</p>
<p>
<?			}
####################################################################

			//�������� ��� ����� - ���� �� ���������, �� �������� ��������� ��� �� diplom_zakaz
			//�������:
			$test_annotation=true;
			if ($_SESSION['TEST_MODE']&&$test_annotation) {
				//var_dump($workFiles[$file_index]);
				?><div><strong>�������� ������� ����</strong></div><?
			}
		
			//$block_build_table_test=true;
			//��������� ������ ������, ����� ������� ������ �� �������:
			for ($i=0;$i<count($workFiles);$i++) {  
				//'work_id'
				//'source_type' //��������
				//'file_name' //��� ������, ���������� �� ������ - ��� ����������
				//'ext' //����������
				//'size'
				//'filetime'
				//'full_path_to_file'	//��� ����� � ���. ������. ��� ����������� �������� ":"		
				
				//�������:
				if (isset($_SESSION['TEST_MODE'])) {
			
					echo "<div class='padding10 bgPale'>����� � ������ \$workFiles!<hr>";
					echo "<div>files_count= <b>$files_count</b>, file_index= <b>$file_index</b><hr></div>";
					foreach ($workFiles[$i] as $key=>$val) echo "<div>\$workFiles[$i]:: $key => $val</div>";
					echo "</div><br>";
				}
				//���� ���� ��� ������� � �����������, ����� ��������� ��� �� ��������� ����������:
				if (strstr($workFiles[$i]['source_type'],"mail")) {
					//���� � ����� ���������� (�� ��� �����) � 
					$filepath=substr($workFiles[$i]['full_path_to_file'],0,strripos($workFiles[$i]['full_path_to_file'],":"));
					$attach_name=substr($workFiles[$i]['full_path_to_file'],strlen($filepath)+1); //��� ����� �� �������, ������� ����� ���������� � ������� ����������� ���������
					$message=$Tools->getAttachesArray($filepath,"work_data.php");
					//�������:
					if (isset($_SESSION['TEST_MODE'])) {
			
						echo "<div>��������� � ���. temp</div>";
						echo "<div>filepath= $filepath</div>";
						echo "<div>attach_name= $attach_name</div>";
					}
					
					if (count($message)) { //echo "<div>count(\$message)</div>";
	
						foreach($message as $file => $file_content) { 
						
							//$file - ��� �����
							//$file_content - �������
							
							$size=round(strlen($file_content)/1024); 
						
							if ($size>0) {
								
								//���� ��� ���������� � ����� �� ����� ����������� ������� ������ ������ �������:
								if ($file==$attach_name) {
									//��������� ���� �� ��������� ���������� (� ��� �����, ���� ��� - �����):
									$full_path_to_file=$Tools->putFileToTemp($file_content,"temp/$attach_name");
									//�������� ������� ������������ ����� ��� ���������� ��� ��������� ��������:
									$workFiles[$i]['full_path_to_file']=$full_path_to_file;
									//$workFiles[$i]['full_path_to_file']=$Tools->putFileToTemp($file_content,"temp/$attach_name");
									//���������� ���� ����� �� ��������� ����������
									//$temp_file_path=$_SESSION['DOC_ROOT_DIPLOM']."temp/$attach_name";
									//��������� ���� ��� ���������:
									//file_put_contents($temp_file_path,$file_content); 
									//chmod($full_path_to_file,777);
									//�������� ����, �.�. � ��������� ������ ������ �� ����� ��������� ����� 1 ����������:
									break; //echo "<hr>$file => $file_content<hr>";
								}
							}
						}
					}
				}
				//*** ���������������� ����� ��� ��������, �.�. ���������������� ������ ����, �� ����, ���� ��� �� ������...
				if (strstr($workFiles[$i]['ext'],"zip")) { //echo "<div class='txtRed'>unpackZip starts!</div>";
					
					//�������:
					if (isset($_SESSION['TEST_MODE']))	var_dump('<pre>',$workFiles[$i],'</pre>');
					
					//����������� zip � �������� ������ �����, ������ �������� ������� � ���. file_index:
					//��������! 
					//���� ���� ������ �� ������, �� ������� �� ��������� ����������
					$incomingFileArrayData=$Tools->unpackZip ($workFiles[$i],$files_count,false);
					
					//�������:
					if (isset($_SESSION['TEST_MODE'])) {
						if (is_array($incomingFileArrayData)) foreach ($incomingFileArrayData as $key=>$val) echo "<div>[$key] => $val</div>";
						else echo "<div>\$incomingFileArrayData type = ".gettype($incomingFileArrayData)."</div>";
					}
					
					if (is_array($incomingFileArrayData)) break;
				
				}else{ //�� zip
					
					$test_file=true;
					
					//$filename=($attach_name)? $attach_name:
					
					if ($workFiles[$i]['ext']!="dir") {
						
						$files_count++;
						//echo "<div class='padding10 bgYellow'>(!dir) file_index= $file_index, files_count= $files_count</div>";
						
						if ($file_index==$files_count) {
								
							//������������ ������ � ������:
							if (isset($_SESSION['TEST_MODE'])) foreach ($workFiles[$i] as $key=>$data) echo "<div class='txtGreen'>[$key] => $data</div>";
							
							//��������� ������� ��������� ����� �������� �� ����� ��������������� �������:
							$incomingFileArrayData=$workFiles[$i];
							if ($attach_name) $incomingFileArrayData['full_path_to_file']=$temp_file_path;
							//�������� ����:
							break;
						}											
					}
				}
			}?> 
<script type="text/javascript">
<? $file_name=$incomingFileArrayData['file_name'];
//����� "/", ���� ���������� ��� ����� ������ ����������:
if ($file_name[0]=="/") $file_name=substr($file_name,1,strlen($file_name)); ?>
//������� ��� ����� � ��� ����������:
document.getElementById('annotation_file_name').innerHTML='<?=$file_name?>';
</script>
			
		<?	$full_path_to_file=($work_table=="ri_worx")? $_SESSION['DOC_ROOT']."/".$author_id."/$work_name":$incomingFileArrayData['full_path_to_file'];
			
			//�������:
			if (isset($_SESSION['TEST_MODE'])) echo "<hr><div class='txtRed'>full_path_to_file= $full_path_to_file</div>";
			
			//���������� (������������(&) ������ ��������):
			$Tools->detectExt($full_path_to_file,$ext);

			//���� � ����������:
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

	} unset($files_count); //���� �� �������� �� ����� ������ � �� ������� 
		
}else $allow_download=true;
//
if ($work_table=="diplom_zakaz") { 
	//���� �����:
	//unpackZip()->generateTableRow()
	//�����:
	//generateTableRow()
	if (isset($_SESSION['TEST_MODE'])) echo "<h3 class='txtOrange'>showWorkFiles starts here!</h3>";

	//�������� ����� ��� ��������� �������:
	//��������! 
	//�� ���������� ����� ������ ������ showWorkFiles, �.�. ��������� ������ � �� ������!
	$build_table=true;	
	$Blocks->showWorkFiles( $site_root,
							$workFiles,
							$work_id,
							$savedFiles,
							$order_sent_id
						  );
	
}
//���������� ���������(?) ������ �� ���������:
if (!$allow_download) {?><a name="register_form"></a><?
	//�������������� � ������������� �������������������:
	$Blocks->authorizeToAddToBasket('_1'); //���������� ������������� ������� ����� � ��������������� � ������������� ��������������
	generateButtons('reg_area_1');
}?>
<br/>
<img src="images/i_triangle.png" alt="<?=$work_name?>" width="15" height="15" hspace="4" align="left" />��� ��������� ���� ����� ��������� � ������
<p class="txtInl"><span class="bold"><?=$work_name?></span> (<?=$work_type?>, <?=$work_area?>).</p>
 <noindex>
 <br/><br/>
<div class="paddingTop10"><table width="100%" cellpadding="0" cellspacing="0">
  <tr class="borderBottom2 borderColorGray">
    <td valign="top"><img src="../order/images/42-15344192.jpg" width="64" height="96" hspace="10" vspace="10" /></td>
    <td width="100%" class="paddingLeft10 paddingTop10 paddingBottom10"><h4><strong>����� ������?</strong></h4>
    <strong>������������� ���������: </strong>
	<ul>
	  
    	<li>��� ���������� �� ������ ���������� ������</li>
    	<li>��� �������� ������� � ��������</li>
    	<li>��� �� ��������� �� ����������</li>
    	<li>��� ��������� ���������� ��� ��� ������ �������������� � �������� ������ ��� �����</li>
    	<li>...������, ������ ������!</li>
    </ul>
    <p>������ ������ <a href="http://www.diplom.com.ru">����� ��� ���������</a> � ���������� �������� ������!</p></td>
  </tr>
</table>
</div> 
</noindex>
<?
//
$Tools->wrongExtIssue();?></div><?

//������� ��������� �����:
//������ ������� ��������� ����, ���� �� ������������� � dir temp:
$dir=$_SESSION['DOC_ROOT_DIPLOM']."temp";
// ������� �������� ������������ ������� � ������ ��������� ��� ����������
if (is_dir($dir)) {
	//�������:
	if (isset($_SESSION['TEST_MODE'])) echo "<h5>is_dir($dir)</h5>";
	
	if ($dh = opendir($dir)) {
		
		while (false!==($file = readdir($dh))) {
			
			//�������:
			if (isset($_SESSION['TEST_MODE'])) echo "<h5><span class='txtRed'>file= $file</span><br>LINE = ".__LINE__."</h5>";
	
			//echo "<br>count file<br>";
			if ($file!="."&&$file!="..") {

				//� ������ ������ � ������ ����������� �� ID, ������, � ��� �����.
				if (isset($_SESSION['TEST_MODE'])) { //echo "i= $i";?><div class="padding4">������� ���� <?=$file?> � �������� ������...</div><? }
				if (isset($_SESSION['TEST_MODE'])) echo '<div class="padding4">������� ���� '.$file.'!</div>';
				$del_file=unlink("$dir/$file");			

				if (!$del_file) $catchErrors->sendErrorMess ("������ �������� �����...","���� $dir/$file �� �����..."); 
			}
		} //echo "</blockquote>";
		closedir($dh);
	}
}?>