 <?
class Blocks {
	
	//
	function authorizeToAddToBasket($reg_area_num=false) {
		global $Customer;
		if ($_SESSION['S_USER_TYPE']!="customer"){?>
        
      <div class="paddingTop8" id="reg_area<?=$reg_area_num?>" style="display:<?="none"?>;">
        <div class="padding8 bgYellowFadeBottom iborder2 borderColorOrangePale">
            ����� �������� ����� � �������, ��� ����� ������� ���� ������:
	<? $Customer->customerAuth(false);?>        
        </div>
      </div>
<?  	}
	}	//����� ������ 	
	//������������� ������ � ������� ������ ������:
	function generateTableRow( $arrFile, //������ ������ �����
							   &$files_count,
							   $function_sources=false,
							   $arch_time=false
							 ) {
		
		global $catchErrors,$Messages,$Tools;
		
		//global $function_sources; //��������, ���������� �������															
		global $errMess; //��������� �������� ��������� �� ������
		
		if (!$arrFile['work_id']) $arrFile['work_id']=$_REQUEST['work_id']; 
		//�������:
		if (isset($_SESSION['TEST_MODE'])) { echo "<div>FUNCTION: ".__FUNCTION__."<BR>METHOD: ".__METHOD__."</div>";

echo <<<TABLE
<tr><td colspan='4'>var_dump('<pre>',$arrFile,'</pre>')</td></tr>
TABLE;
		
			if ($test_table){?>
		<table>        
		  <tr class="authorTblRowHeader bold">
			<td>&nbsp;</td>
			<td>��������<? 
			if (isset($_REQUEST['order_sent_id'])){
					/*?> | <a href="#" onClick="window.open(http://www.diplom.com.ru/zip/<?=$_REQUEST['work_id']?>,'dir');return false;">��� ����� � �����</a><? */
			}?></td>
			<td align="center" nowrap="nowrap">�����, ��.</td>
			<td align="center" nowrap="nowrap">���� ���������</td>
		  </tr>
		<?  }
		}
		if ($arrFile['work_id']){?>

      <tr valign="top">
        <td title="<?=$arrFile['file_name']?>"><? 
			
			if (isset($_SESSION['TEST_MODE'])) echo(strstr($arrFile['source_type'],"mail"))? "[mail]":"[sys] &nbsp;";
			
			$extype=$Tools->detectExt($arrFile['file_name'],$ext);
			
			$images_root=($_SESSION['T_ROOT_REFERATS'])? $_SESSION['T_ROOT_REFERATS']:$_SESSION['SITE_ROOT'];
			//�������� ������ ���������� �����:
			switch ($ext) { 
			
				case ".pdf":
			  ?><img src="<?=$images_root?>images/files_extensions/pdf.png" width="16" height="16" /><?
				break;
			
				case ".zip":case ".rar":
			  ?><img src="<?=$images_root?>images/files_extensions/archive.png" width="16" height="16" /><?
				break;
			
				case ".doc": case ".rtf":
			  ?><img src="<?=$images_root?>images/files_extensions/word.png" width="16" height="16" /><?
				break;
			
				case "docx": 
			  ?><img src="<?=$images_root?>images/files_extensions/docx.png" width="16" height="16" /><?
				break;
				
				case ".xls": case "xlsx":
			  ?><img src="<?=$images_root?>images/files_extensions/excel.png" width="16" height="16" /><?
				break;
			
				case ".txt":
			  ?><img src="<?=$images_root?>images/files_extensions/txt.png" width="16" height="16" /><?
				break;
			
				default:
			  ?><img class="iborder borderColorGray" src="<?=$images_root?>images/spacer.gif" width="12" height="14" /><?
			
			} echo $source_type;
		
		?></td>
		<? //�������� �����?>
        <td><? //������ � ����������:
			
		  	$just_file_name=basename($arrFile['file_name']); 
			
			//������������:
			if (isset($_REQUEST['order_sent_id'])) {
				
				
				$link=$_SESSION['SITE_ROOT']."_download.php?file_to_download=$arrFile[work_id]/".rawurlencode($just_file_name);
				//str_replace(" ","%20",$just_file_name);  

				?><span class="link" title="������� ����: <?=$just_file_name?>" onClick="location.href='<?
				if ($ext==".zip") echo "zip"; //???
				else echo $link;
				?>'"><img src="<?=$images_root?>images/down.gif" width="16" height="16" hspace="4" /><?
				  
				echo $just_file_name;
				  
				?></span><? //echo "<div>link= $link</div>";
			  
			}else{ //�� ������������...
				
			  	global $source_method;
			  	global $test_page;
			  
			  	if (!$arrFile['work_id']&&!$errMess) { 	
				  
				  	if (strstr($_SERVER['HTTP_HOST'],"localhost")) echo "<h4>������!</h4>�� �������� \$arrFile['work_id'] � \$errMess";
				  	//
				  	$Messages->sendEmail ( "test@educationservice.ru",
										 "sale@referats.info",
										 "sale@referats.info",
										 "�� ������� \$arrFile['work_id']; \$_SESSION['test_work_id']= \$_SESSION['test_work_id'] (work_data.php)",
										 nl2br("HTTP_REFERER: $_SERVER[HTTP_REFERER]
										 �������� ������: $function_sources"),
										 $alert_text
									   );
					$errMess=true;
			  }
			  
			  ?><a<? 
		  		
				if (strstr($ext,"rtf")||$ext==".doc"||$order_sent_id) {
						
					?> href="?work_table=diplom_zakaz&amp;work_id=<? 
					
					echo ($arrFile['work_id'])? $arrFile['work_id']:$_REQUEST['work_id'];
					
					?>&amp;show_annotation=1&amp;file_index=<? echo $files_count;
					
					if ($ext==".zip") {?>&amp;pack=<? echo $arrFile['file_namev'];} ?>"<? 
				
				} ?>><?=$just_file_name?></a><?
			
	  		}?></td>

        <td align="right"><?=(strstr($arrFile['source_type'],"mail")&&!strstr($arrFile['full_path_to_file'],"/public_html/temp/"))? $arrFile['size']:round($arrFile['size']/1024)?><?
        
		//foreach ($arrFile as $key=>$val) echo "<div>[$key] => $val</div>"
		//echo "<hr>full_path_to_file= ".$arrFile['full_path_to_file'];?></td> 
        
        <td nowrap="nowrap" style="color:#999;"><?  
		
			if (strstr($arrFile['source_type'],"sys")) {
				
				$dt=$Tools->getDateFromEventsFiles($arrFile['work_id'],$just_file_name,"Blocks->generateTableRow");
			
			}else $dt=$arrFile['filetime'];
			
			if ($dt) $Tools->dtime($dt);//dd.mm.YYYY H:i:s
			//������� ���� ���������:
			else {
				
				if (!$arch_time) { //���� �� �����,  �� ftp
					$ftp_file_time=$Tools->getFileTimeByFTP($arrFile['work_id'],$arrFile['full_path_to_file']);//$file_path
					//echo "<div class='txtGreen'><b>filetime= ".$arrFile['filetime']."</b>, full_path_to_file= ".$arrFile['full_path_to_file']."</div>";
					echo $ftp_file_time;
				
				}else echo $arch_time; //����� �������� ������
				
			}?><script type="text/javascript">
document.getElementById('all_files_value').innerHTML="<?=$files_count?>";
</script><? //����� ��������� ������ ��������� ����� - ������� ��� �� ��������� ����������:
			$temp_file=$_SESSION['DOC_ROOT_DIPLOM']."temp/".$arrFile['file_name'];
			if (file_exists($temp_file)) @unlink($temp_file);
			if (isset($_SESSION['TEST_MODE'])) echo '<div class="padding4">������� ���� '.$temp_file.'!</div>';?></td>
      </tr>

<?		}else{ $Messages->sendEmail(	"test@educationservice.ru",
								 	"error@referats.info",
								 	"sale@referats.info",
								 	"�� ������� \$arrFile['work_id'] ������",
								 	nl2br("class.Blocks.php->generateTableRow();
									================================================================
									REQUEST_URI = $_SERVER[REQUEST_URI]
									================================================================
									HTTP_REFERER = $_SERVER[HTTP_REFERER]
									================================================================
									HTTP_HOST: $_SERVER[HTTP_HOST]
									================================================================
									HTTP_USER_AGENT: $_SERVER[HTTP_USER_AGENT]
									================================================================
									SERVER_PROTOCOL: $_SERVER[SERVER_PROTOCOL]
									================================================================
									LINE: ".__LINE__."
									================================================================
									FILE: ".__FILE__."
									================================================================
									FUNCTION: ".__FUNCTION__."
									================================================================
									CLASS: ".__CLASS__."
									================================================================
									METHOD ".__METHOD__."
									================================================================
									mysql_error(): ".mysql_error()),
								 	false
								  );
			return false;
		}
		if ($test_table){?>
	</table>        
	<?  } 
		return true;
	}	// ����� ������ generateTableRow	
	//������� �� ���������:
	function makePagesNext($all_pages,$limit_finish) {

		global $pageNextStyle;

		$pages=round($all_pages/$limit_finish);
		//
		$max_pages=$pages*$limit_finish;

		if (!$pageNextStyle) $pageNextStyle=' class="padding8 paddingTop10 borderTop1 borderColorGray"';
		//echo "<div>if ($all_pages>(".($pages*$limit_finish).")&&$pages)...</div><div>all_pages= $all_pages, pages= $pages, limit_finish= $limit_finish</div><br>\$pages*\$limit_finish= ".($pages*$limit_finish)."<br><br>max_pages= $max_pages";

		//��� ���������� - �������� ���������� ���������� �������:
		if ($all_pages/$limit_finish>1) {
			
			?><div<?=$pageNextStyle?>><strong>��������:</strong> &nbsp;<?
			

				if (is_double($pages)) {
					$rpages=round($pages,0);
					if ($rpages<$pages) 
						$pages=$rpages+=1;
				} //echo "<div>count.arrIDs= ".count($arrDplomZakazIDsWithFiles)."<hr>rwSelAll= $rwSelAll<br>rwSeLimit= $rwSeLimit<br>round.pages= $rpages</div>";
				//echo "<br>all_pages= $all_pages, limit_finish= $limit_finish, pages= $pages<br>";
				
				if ($all_pages>$max_pages) $pages+=1;
				
				for($i=0;$i<$pages;$i++) {
					
					?> &gt;<a href="?mode=skachat-rabotu&amp;<? 
					
					if (isset($_REQUEST['filter'])) {?>filter=<? echo $_REQUEST['filter']."&"; }
					
					if (isset($_REQUEST['menu'])) {?>menu=<? echo $_REQUEST['menu']."&"; }
					
					if (isset($_SESSION['FILTER_WORX_AFFILIATION'])) {?>affiliation=<? echo $_SESSION['FILTER_WORX_AFFILIATION']."&"; }
					
					?>page=<?=$i?>"<? if ($_REQUEST['page']==$i) {?> class="cellActive padding2"<? }?>><?=$i+1?></a><?
				}
		  ?></div><? 
		}else {?>&nbsp;<? }
	  } //����� ������ 
	//��� �������:
	function setMenu() {
		
		$arrMenus=array ( 'default'=>"��������",
					  'worx'=>"������/������",
					  'money'=>"�������",
					  'messages'=>"���������",
					  'data'=>"������",
					  'tools'=>"�����������",
					  'faq'=>"FAQ",
					  'author_agreement'=>"����������"//,
					  //'feedback'=>"�������� �����"
					); return $arrMenus;
	} //����� ������ 
	//���������� ���������� ������� � ������ ������:
	function showFilterResults( $object_type, 	//��� ���������� ��������
								$subject,			//������, �� �������� �����������
								$subject_id,		//...��� id...
								$actor_type,		//���� ����������� �� ���������/����������/������
								$actor_type_id	//...��� id...
							  ) { //echo "actor_type= $actor_type, actor_type_id= $actor_type_id";?>
	
<div style="padding:4px 0px 2px 4px;<? if ($object_type=="messages"){?> float:left;<? }?>"><img src="<?=$_SESSION['SITE_ROOT']?>images/filter_order.png" width="22" height="16" hspace="4" align="absmiddle" /><?

		//������/������/���������
		switch ($object_type) { 
			
			case "orders":
			  ?>������<? 
			  
			  $drop_link="orders&amp;order_status=".$_SESSION['FILTER_ORDER_STATUS'];
			  
				break;
				
			case "payments":
			  ?>��������<? 
			  
			  $drop_link="money";
			  
				break;
				
			case "payouts":
			  ?>�������<? 
			  
			  $drop_link="payouts";
			  
				break;
				
			case "messages":
			  ?>���������<? 
			  
			  $drop_link="messages";
			  
				break;
				
			case "worx":
			  ?>������<? 
			  
			  $drop_link="worx";
			  
				break;
		}
		
		if ($subject&&$subject_id) {
			
			?> �� <? echo $subject;
			
			?> id <? echo $subject_id; 
		
		}elseif($actor_type&&$actor_type_id){

			switch ($actor_type) { 
				
				case "worker":
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/cooworker.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />����������<? 
					break;
	
				case "customer":
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle" />���������<? 			  	
					break;
					
				case "author":
				  ?><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /><?
                  if ($object_type=="payouts"){?>������<? }else{?>������<? }
					break;
			} 
			
			echo " id $actor_type_id";
		
		}?> &nbsp; [ <a href="?menu=<?=$drop_link?>" class="bold">�������� ������</a> ]</div><? 
		if ($object_type=="messages"){?><div><img src="<?=$_SESSION['SITE_ROOT']?>images/spacer.gif" width="1" height="5" /></div><? }?>    
    
<?	} //����� ������ 
	//
	function showWorkFiles( $site_root,
							$workFiles,
							$work_id,
							$savedFiles=false,
							$order_sent_id=false
						  ) {
		//���������� ����������:
		if (isset($_SESSION['TEST_MODE'])) {
			echo "<blockquote><h3>showWorkFiles inside</h3></blockquote>";
			//var_dump('<pre>',$workFiles,'</pre>');
		}
		global $Tools,$Worx; 
		//�������� �� ������ �������� id ������:
		$work_id=$Tools->clearToIntegerAndStop($work_id);?>    
        
<div<? if ($_REQUEST['submenu']=="work_data"){?> style="padding:20px;"<? }?>>        
<div class="paddingBottom10 bold txt130">��� �����<? 

	if ( $order_sent_id || //���� ��������� ������ � ����������
		 $_REQUEST['submenu']=="work_data" //������� ������� ������ � �������� ���������
	   ){ //�������� ��� ����������
	
	?> �� ������ id <img src="<?=$site_root?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" /><? 
	
	echo ($order_sent_id)? $order_sent_id:$_REQUEST['work_id'];
	
	?>.
	<div class="paddingTop10"><span style="color: #009">���� ������:</span> <div class="noBold"><? 
	
		//�������� ��� ������:
		echo $Worx->getWorkName("diplom_zakaz",$work_id);?></div>
    
    </div>
  </div><?  
	
	}
	if ($_REQUEST['submenu']!="work_data"){
		
		?><hr noshade color="#eeeeee"><div class="paddingBottom10 bold">����� ������: <span id="all_files_value"></span><a name="files_table"></a></div><?	
		
	}
		//�������:
		### test:	
		if (isset($_SESSION['TEST_MODE'])) {
			$test_arr2=true;
			if ($test_arr2) {
				foreach ($savedFiles as $key=>$arr) {		
					if (is_array($arr))	foreach ($arr as $key=>$val) echo "<div>[$key] => $val</div>"; 
				} echo "<hr>";
				for ($i=0;$i<count($workFiles);$i++) {
					foreach ($workFiles[$i] as $k=>$arr)
						if (is_array($arr)) foreach ($arr as $key=>$val) echo "<div>[$key] => $val</div>";
				}
			}	echo "<h4 class=txtGreen>TABLE starts here</h4>";
		}?>
	<table width="70%" cellpadding="4" cellspacing="0" rules="rows" class="iborder borderColorGray">
      <tr class="paddingBottom10 txt90">
        <td colspan="4" class="padding8"><img src="<?=$site_root?>images/i_triangle.png" width="15" height="15" hspace="4" align="left" />���� � ��� ��������� �������� � ��������� ������-���� �����, ����������, �������� �� ���� ���, � �� ����������� ����������� ��� ����������� ������������ � ��� �����������.</td>
      </tr>
      <tr class="authorTblRowHeader bold">
        <td>&nbsp;</td>
        <td>��������</td>
        <td align="center" nowrap="nowrap">�����, ��.</td>
        <td align="center" nowrap="nowrap">���� ���������</td>
      </tr>
<?  //
		if (count($workFiles)) { //
			
			//�������:
			if (strstr($_SERVER['REQUEST_URI'],"index_temp.php")) {
				if (isset($_SESSION['TEST_MODE']))
					echo "<div>������ workFiles: <BR>METHOD = ".__METHOD__."<BR>LINE = ".__LINE__."</div>";
				//var_dump('<pre>',$workFiles,'</pre>'); 
			}
			for ($i=0;$i<count($workFiles);$i++) { 
				//�������:
				$test_row=true;
				//
				if (strstr($workFiles[$i]['ext'],"zip")) { //echo "<div>source_type= $source_type<br>source= ".$attaches."</div>";
					
					//������ �������� generateTableRow()
					$full_path_to_file=$workFiles[$i]['full_path_to_file'];
					
					//�������:
					if (isset($_SESSION['TEST_MODE'])) {  
						if ($test_row){?>
						<TR>
						  <TD colspan="4" bgcolor="#eeeeee"><h2 class="txtDarkBlue">build_table= <?=$build_table?><span class="txtGrayCCC">(<?=$files_count?>)</span> [zip]<?=$workFiles[$i]['file_name']?><br><?=$workFiles[$i]['full_path_to_file']?></h2><? echo "<div>ext= ".$workFiles[$i]['ext'].", filetime= ".$workFiles[$i]['filetime']."</div>";?></TD>
						</TR><? 
						}
					}
	
					//
					if (strstr($workFiles[$i]['source_type'],"mail")) {
						//# letter
						$lnum_path=substr($full_path_to_file,0,strripos($full_path_to_file,":")); 
						//�������� ���� �������� ���������
						$filetime=$Tools->getFiletime($lnum_path,$mess);	
						//��������� ���� �� ��������� ����������
						//�������� � ���������:
						$lnum=substr($lnum_path,strripos($full_path_to_file,"/")+1);
						//�������� ���������� ���������:
						//�������� ������ ���� ����������� ���������, ���� ������� ������� �������� �����:
						$message=$Tools->getAttachesArray($lnum_path,"unpackZip");
			
						//���� ���� ����������:
						if (count($message)) {
							//�������:
							if (isset($_SESSION['TEST_MODE'])) echo "<div class='txtGreen'><b>count(\$message)</b></div>";
							
							foreach($message as $file => $file_content) { 
								//��������� ���� �� ��������� ���������� � ������� ��� ����:
								$workFiles[$i]['full_path_to_file']=$Tools->putFileToTemp($file_content);
								//�������:
								if (isset($_SESSION['TEST_MODE'])) {
									echo "<TR>
											<TD colspan='4' bgcolor='#eeeeee'>METHOD = ".__METHOD__."<BR>LINE = ".__LINE__."<h4 class='txtGreen'>\$workFiles[$i]['full_path_to_file']= {$workFiles[$i]['full_path_to_file']}</h4>
											</td>
										</tr>";	
								}
							}
						} //���������� ����������:
						elseif (isset($_SESSION['TEST_MODE'])) echo("<div class='txtRed'>!count(\$message)</div>");
					}

					$Tools->unpackZip ($workFiles[$i],$files_count,false);
				
				}else{
					
					if ($workFiles[$i]['ext']!="dir") {
						//�������:
						if ($_SESSION['TEST_MODE']&&$test_row) {  ?><TR><TD colspan="4" bgcolor="#cccccc"><h2><span class="txtGrayCCC">(<?=$files_count?>)</span> [!zip]<?=$workFiles[$i]['file_name']?><br><?=$workFiles[$i]['full_path_to_file']?></h2><? echo "<div>ext= ".$workFiles[$i]['ext'].", filetime= ".$workFiles[$i]['filetime']."</div>";?></TD></TR><? }
						$files_count++; //�������� ����� ������� generateTableRow()
						//������������ ������ � ������:
						$this->generateTableRow( $workFiles[$i],$files_count,"work_data.php" ); //������������� ������ ��������������� �����
					}
				} 
			} 
	
		}else{?>
	
	  <tr>
	    <td colspan="4"><img src="images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" align="absmiddle" />����� � �������� <strong>MS Office</strong>, .<strong>txt</strong>, .<strong>zip</strong>, .<strong>rar</strong> � .<strong>pdf</strong> �� ����������. ���������� � ������������� ������� ��� ��������� �������.</td>
      </tr>
	<?  }?>
	</table></div><? 	echo "\n";
	} //����� ������ showWorkFiles
}?>