<?
class catchErrors {
	
	//$mType - ������� GET ��� POST
	function reachIt($mType) {
		$arr=array();
		$cnt=0;
		foreach ($mType as $key => $val) 
		  { 
			$arr[$cnt]=$val;
			
			if (strstr($key,"_old")){ if ($cnt>0) $color=($arr[$cnt-1]!=$val)? "red":"green";}
			else $color="#000000";
			
			$colorstyle=" style='color:$color'";
			
			echo "<tr><td>$key</td><td$colorstyle>";
			
			if (is_array($val)) foreach ($val as $key => $value) echo "<div>reachIt: [$key] => $value</div>";
			else echo $val;
			
			echo "</td></tr>";
			
			$cnt++;
		  }
	}	//����� ������
	//����� ���������� ������ � ����� ������:
	function showGetPostDataForeach($mType) {
		//
		//if ($_GET['debug']=="on") $_SESSION['S_SHOW_MODE']=true;
		if ($_GET['debug']=="off") unset($_SESSION['S_SHOW_MODE']);
		//������������� ����� ����������� �������� ����������:
		if (isset($_GET['test_mode'])) 
		  { unset($_SESSION['SHOW_VARS']);
			$_SESSION['TEST_MODE']=true;
		  }			
		if ($_GET['show_vars']=="on"||$_GET['test_mode']=="off") unset($_SESSION['TEST_MODE']);
		//echo "<div style='padding:4px;' class='iborder'>TEST_MODE= ".$_SESSION['TEST_MODE']."<br>S_SHOW_MODE= $_SESSION[S_SHOW_MODE]<br>SHOW_VARS= $_SESSION[SHOW_VARS]</div>";
		//������� ��������� �������:
		if ( $_SESSION['TEST_MODE'] ||
			 $_SESSION['S_SHOW_MODE'] ||
			 $_SESSION['SHOW_VARS']
		   )
		  {	?><div id="test_mode_info" style="position:absolute; right:10px; background-color:#FFF; border:solid 2px #CCC; padding:4px; z-index:1000; cursor:move;"><?
			//$tshw=true;
			if ($tshw) echo "<div style='padding:4px;' class='iborder'>test_mode(1)= ".$_SESSION['TEST_MODE']."</div>";			
			if ($tshw) echo "<div style='padding:4px;' class='iborder'>test_mode(2)= ".$_SESSION['TEST_MODE']."</div>";
			
			//������������� ����� ������������ (�������� ����������, ����������� ��������� ������):
			 if ($mType) $this->reachIt($mType); 
			$bgcolor=' bgcolor="#';
			$tcolor=($_SESSION['SHOW_VARS'])? "FFFF33":"CCFFCC";
			$bgcolor.=$tcolor.'"';?>
			
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><table cellspacing="0" cellpadding="4" border="1" id="foreach_data" style="display:<? echo "none";?>;" bgcolor="#FFFFCC">
			  <tr>
				<td colspan="2"<? echo $bgcolor;?>>GET:</td>
			  </tr><? $this->reachIt($_GET);?>
			  <tr>
				<td colspan="2"<? echo $bgcolor;?>>POST:</td>
			  </tr><? $this->reachIt($_POST);?>
			</table>
				<td valign="top" style="padding:4px;"><div style="padding:4px; background-color:#<? echo $tcolor;?>;" class="iborder"><a href="#" onclick="switchDisplay ('foreach_data');return false;"><strong>&harr;</strong></a></div>
				<div class="padding4"><a href="<? echo $_SERVER['REQUEST_URI'];
				echo(strstr($_SERVER['REQUEST_URI'],"?"))? "&":"?";
				?>test_mode=off"><img src="<?=$_SESSION['SITE_ROOT']?>images/cog.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />������� �����...</a></div></td>
			  </tr>
			</table>
			<script language="JavaScript" type="text/javascript">
			/*function switchDisplay (objID,displayType)	{
			var tBlock=document.getElementById(objID);
			tBlock.style.display=(tBlock.style.display=='block'||tBlock.style.display=='inline')? 'none':displayType;
			}*/
			
			//������������ ������ ������� ������������� �������:
			mkTableRows=document.getElementById('foreach_data').getElementsByTagName('TR');
			tcnt=0;
			for (i=0;i<mkTableRows.length;i++)
			  { //�������� ������ ����� ������ ������, ������ - ������������:
				if (typeof(mkTableRows.item(i).uncolorized)=='undefined') 
				  { mkTableRows.item(i).style.backgroundColor=(tcnt==1)? "#eeeeee":"#ffffff";//
					tcnt++; 
					if (tcnt>1) tcnt=0;
				  } 
			  }
			//makeTableZebra('foreach_data','#FFFFFF','#E4E4E4');
			</script><?
			  
			if ($tshw) echo "<div style='padding:4px;' class='iborder'>test_mode(3)= ".$_SESSION['TEST_MODE']."</div>";
			 ?><div class="padding4 separatorTopLight"><a href="#" onclick="switchDisplay ('session_vars');return false;"><nobr><img src="<?=$_SESSION['SITE_ROOT']?>images/global_vars.png" width="24" height="16" hspace="4" border="0" align="absmiddle" />$_SESSION...</nobr></a></div>
             <div id="session_vars" class="padding8" style="display:<? echo "none";?>; background-color:#FF9"><?
             
			 foreach ($_SESSION as $key=>$sval) {?><div class="paddingTop4 separatorBottomLight"><nobr><? echo $key." => ".$sval;?></nobr></div><? } 
			 
			 ?></div>
           </div><?
		  }
	}	//����� ������
	
	//����� ������� ���������� ���������.
	//��������! 
	//1. ���������������� ����� ���������� ������ ���� �������� ���:	$time_start=localtime();
	//2. ������� ������ ���������� ��������������� ����� ���������� ���������
	function measureSec($time_start,$procedure) {
		//�����
		$time_start2=localtime();
		
		$tstart=$time_start[2]*3600+$time_start[1]*60+$time_start[0];
		$tfinish=$time_start2[2]*3600+$time_start2[1]*60+$time_start2[0];
		$tlen=$tfinish-$tstart;
		//����� �������:
		?><div style="padding:4px;" align="right" id="timeDiv">
		<table border="0" cellspacing="0" cellpadding="6">
		  <tr>
			<td bgcolor="#ffff66" class="iborder" id="timeMes">���������: <? echo $procedure;?> ����� ����������: <? echo $tlen;?> ���.</td>
			<td valign="top" bgcolor="#dddddd"><!--<img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/close_window.gif" width="16" height="14" onclick="switchDisplay ('timeMes','block');">--></td>
		  </tr>
		</table></div><?
	}	//����� ������
	
	//�������� ��������� �� ������ (�� ������ ��� ������ � ������� ��������� ���������). ���� ������� ���������� �� localhost - ����� HTML
	function errorMessage ( $counter, 	//����� ����� (���� ������� ���������� � ��)
							$i, 		//������� �����. ���� �� �������, ����������� ������ 1 ��������
							$errSubj, 	//"[���� ���������]"
							$queryVar, 	//��� �������
							$queryText,	//����� �������
							$global_var=false, //���������� ����������-��������� ���������� ������� ����� ��������� 
							$funcMess=false //��������� ������, ���������� ������
						  ) {	
						  
	//die("errorMessage complited");					  					  
		if ($errSubj=="") $errSubj="������ ������� � �� � ����� $_SERVER[REQUEST_URI]";
		if ( mysql_error() &&
			 mysql_error()!="MySQL server has gone away" && 
			 $_SESSION['ERROR_MESS_COUNT']<50 	//���������� ������� ������ �� ��������
			) { 
			$mssText="������ $queryVar: <pre class='txt110'>$queryText</pre><p>����: ".$_SERVER['REQUEST_URI'];
			$mssText.="<hr>����� ������: ".mysql_error(); 
			//������������ � ���������� - ���������� �� ������ ��� ���������� � ��������� ������� (��� � ��, � ������)
			//���� ������ ���������, ��������� ��������� �������� � ������� � �������� ��������� ������ �������� �������:
			//(���������� �� ����, ����ר� �� ����� ������������)
			if (strstr($_SERVER['HTTP_HOST'],"localhost")) die("<DIV onClick=\"nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';\" style='display:inline; color:blue; cursor:pointer;'>$errSubj</div><div style='display:none'>$mssText</div>");
			//�������� ������ ��������� �� ������.
			//��������� ������ ���� ��������, ����� �� ���������� ���������� ��������� � �����:
			else {
				//���������� ������� ����������� ������� ����� ��������� �� ������:
				if (!$global_var||!$_SESSION['ERR_'.$global_var]) {
					
					$qMess=nl2br($qSel."
		*********************************************************************************
		��������! ��������� ������� ��������� �� ������ ����������� ��� �������� �������!
		==================================================================================
		HTTP_HOST: $_SERVER[HTTP_HOST]
		================================================================
		HTTP_REFERER :$_SERVER[HTTP_REFERER]
		================================================================
		HTTP_USER_AGENT: $_SERVER[HTTP_USER_AGENT]
		================================================================
		REQUEST_URI: $_SERVER[REQUEST_URI]
		================================================================
		SERVER_PROTOCOL: $_SERVER[SERVER_PROTOCOL]
		================================================================
		REMOTE_HOST: $_SERVER[REMOTE_HOST]
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
		".$funcMess);					
					
					if (!$i) $this->sendErrorMess($errSubj,$mssText.$qMess); 
					
					$_SESSION['ERR_'.$global_var]=true;
				}
			}
			$_SESSION['ERROR_MESS_COUNT']++;
		  } 
		  return false;
	}	//����� ������
	//�������� ������������ �� ������:	
	function errorUserMess($mess) {?><div class="padding10"><div class="txtRed">������!</div>
<p><?=$mess?><br>�� �������� ������ ����������� � � ��������� ����� �������� ��������� ��������. </p>
<p>�� ������ ���������� ������������ ������� ��������� ������ ��������.</p>
</div><?
		$this->sendErrorMess($errSubj,$mess);	
	}	//����� ������		
	//�������� �� ������ ��������� �� ������ (���� �� �������� �������, ����� - ������� ����� �� ��������):
    function sendErrorMess ($errSubj,$mssText) {
		//���� �� �������� ���� ���������, ��������� � �������������:
		if (!$errSubj) $errSubj="������";
		//�������� ���������� �����:
		if (!$_SESSION['S_ADMIN_EMAIL']) $_SESSION['S_ADMIN_EMAIL']="sale@referats.info";
		//�����������:
		$reply_to=$_SESSION['S_ADMIN_EMAIL'];
		//���� ���������
		$errSubj.=", ���� ".$_SERVER['REQUEST_URI'];
		//���� ������ ���������, - ������� ������ ���������:
		if (strstr($_SERVER['HTTP_HOST'],"localhost")) 
		  {?><div class="iborder padding10" style="background-color:#FCC;">...�������� ��������� �� ������ (�� �������� �������):
          <hr>
		  <div class="padding10">
			<div>�����������: <? echo $reply_to;?></div>
			<div>����������: <? echo $_SESSION['S_ADMIN_EMAIL'];?></div>
            <hr>
			<div>���� ���������: <? echo $errSubj;?></div>
			<div>����� ���������: <? echo $mssText;?></div>
		  </div>
		  </div><? 
		  }
		//���� ������ ��������, - ���������� ��������� �� ������ ������ �������:
		else $send_warning=mail($_SESSION['S_ADMIN_EMAIL'],$errSubj,$mssText."<hr>mysql_error(): ".mysql_error(),"From: $_SESSION[S_ADMIN_EMAIL]".chr(13).chr(10)."Reply-To: $reply_to".chr(13).chr(10).'X-Mailer: PHP/'.phpversion()."Content-Type: text/html; charset=Windows-1251");
		if ($mssText) echo "<div class='txtRed padding10'>������! $mssText.</div>������������� ������� ���������������� � �������; ������ ����� ���������� � ��������� �����. �� ������ ���������� ������������ ������� ��������� �������.</div></div>"; 	
	}	//����� ������
	//���������� ������:
	function select($sql,$show=false,$inline=false) {
		
		$rSel=mysql_query($sql) or die("<div>select(\$sql) ERRORS: <pre>$sql</pre></div>");
		$rws=mysql_num_rows($rSel);
	//���� � �������� ������:
	?><div style='background-color:#CCFFCC;<? if ($inline){?> display:inline;<? }?>' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer;'>������ ���������� ������ (<? 
		  echo $rws;
		  if ($show) echo ", $show";?>):</DIV> 
		<div<? if (!$show){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
	
	}	//����� ������	
	//������� ��������� � ����������� �������, ���������� ��������� ��:
	function show_query_info($action)	{ 
		//		
		if (isset($_SESSION['SHOW_ALERTS']))
		  {?>
<script type="text/javascript">
alert("�������� ������ <? echo $action;?> ������!");
</script>
   <?     }
   		/*if (!$_SESSION['S_ALERT_COUNTER'])
		  {?>
<script type="text/javascript">
alert("�������� ������ <? echo $action;?> ������!");
</script>
   <?   	$_SESSION['S_ALERT_COUNTER']=0;  
		  }
		$_SESSION['S_ALERT_COUNTER']++;
		?><div style='padding:4px;' class='iborder'>�������� ������ # <? echo $_SESSION['S_ALERT_COUNTER'];?></div><? */
	}	//����� ������
	//���������� ������:
	function insert($sql,$show_default=false) {	//echo "<div>\$_SESSION['selected_db']= $_SESSION[selected_db]</div>";
		
		//���� � �������� ������:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline;cursor:pointer;color:blue;'>������ <span class="txtRed">����������</span> ������:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show_default){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		  }
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql) ;    
			$this->errorMessage(1,"","������ ���������� ������","[��� �������]",$sql);
			return true;
		  }	
		//����� ������ (����������/����������� ������ �������):					
		$this->show_query_info("����������");
	}	//����� ������
	//���������� ������:
	function update($sql) { 	
		//����������� - �������� �� ����� �������:
		global $show_default;	
		
		//���� � �������� ������:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer; color:#00F;'>������ <span class="txtOrange">����������</span> ������:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show_default){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		}
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql);
			$this->errorMessage(1,"","������ ���������� ������","[��� �������]",$sql);
		  }						
		//����� ������ (����������/����������� ������ �������):					
		$this->show_query_info("����������");
	}	//����� ������
	//�������� ������:
	function delete($sql,$show=false) { 	
		//����������� - �������� �� ����� �������:
		//���� � �������� ������:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer; color:#00F;'>������ <span class="bgPale">��������</span> ������:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		  }
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql);
			$this->errorMessage(1,"","������ �������� ������","[��� �������]",$sql);
		  }						
		//����� ������ (����������/����������� ������ �������):					
		$this->show_query_info("��������"); 
	}	//����� ������
}?>