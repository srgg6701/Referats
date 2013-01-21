<?
class catchErrors {
	
	//$mType - массивы GET или POST
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
	}	//КОНЕЦ МЕТОДА
	//будем сравнивать старые и новые данные:
	function showGetPostDataForeach($mType) {
		//
		//if ($_GET['debug']=="on") $_SESSION['S_SHOW_MODE']=true;
		if ($_GET['debug']=="off") unset($_SESSION['S_SHOW_MODE']);
		//устанавливаем режим отображения входящих переменных:
		if (isset($_GET['test_mode'])) 
		  { unset($_SESSION['SHOW_VARS']);
			$_SESSION['TEST_MODE']=true;
		  }			
		if ($_GET['show_vars']=="on"||$_GET['test_mode']=="off") unset($_SESSION['TEST_MODE']);
		//echo "<div style='padding:4px;' class='iborder'>TEST_MODE= ".$_SESSION['TEST_MODE']."<br>S_SHOW_MODE= $_SESSION[S_SHOW_MODE]<br>SHOW_VARS= $_SESSION[SHOW_VARS]</div>";
		//условие генерации таблицы:
		if ( $_SESSION['TEST_MODE'] ||
			 $_SESSION['S_SHOW_MODE'] ||
			 $_SESSION['SHOW_VARS']
		   )
		  {	?><div id="test_mode_info" style="position:absolute; right:10px; background-color:#FFF; border:solid 2px #CCC; padding:4px; z-index:1000; cursor:move;"><?
			//$tshw=true;
			if ($tshw) echo "<div style='padding:4px;' class='iborder'>test_mode(1)= ".$_SESSION['TEST_MODE']."</div>";			
			if ($tshw) echo "<div style='padding:4px;' class='iborder'>test_mode(2)= ".$_SESSION['TEST_MODE']."</div>";
			
			//устанавливаем режим тестирования (показать переменные, блокировать изменение данных):
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
				?>test_mode=off"><img src="<?=$_SESSION['SITE_ROOT']?>images/cog.png" width="16" height="16" hspace="4" border="0" align="absmiddle" />Рабочий режим...</a></div></td>
			  </tr>
			</table>
			<script language="JavaScript" type="text/javascript">
			/*function switchDisplay (objID,displayType)	{
			var tBlock=document.getElementById(objID);
			tBlock.style.display=(tBlock.style.display=='block'||tBlock.style.display=='inline')? 'none':displayType;
			}*/
			
			//раскрашиваем строки таблицы чередующимися цветами:
			mkTableRows=document.getElementById('foreach_data').getElementsByTagName('TR');
			tcnt=0;
			for (i=0;i<mkTableRows.length;i++)
			  { //нечётные строки будем делать белыми, чётные - контрастными:
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
	}	//КОНЕЦ МЕТОДА
	
	//замер времени выполнения процедуры.
	//ВНИМАНИЕ! 
	//1. Непостредственно перед процедурой должен быть размещён код:	$time_start=localtime();
	//2. Функция должна вызываться непосредственно после измеряемой процедуры
	function measureSec($time_start,$procedure) {
		//финиш
		$time_start2=localtime();
		
		$tstart=$time_start[2]*3600+$time_start[1]*60+$time_start[0];
		$tfinish=$time_start2[2]*3600+$time_start2[1]*60+$time_start2[0];
		$tlen=$tfinish-$tstart;
		//вывод времени:
		?><div style="padding:4px;" align="right" id="timeDiv">
		<table border="0" cellspacing="0" cellpadding="6">
		  <tr>
			<td bgcolor="#ffff66" class="iborder" id="timeMes">Процедура: <? echo $procedure;?> Время выполнения: <? echo $tlen;?> сек.</td>
			<td valign="top" bgcolor="#dddddd"><!--<img src="<?=$_SESSION['SITE_ROOT']?>images/pyctos/close_window.gif" width="16" height="14" onclick="switchDisplay ('timeMes','block');">--></td>
		  </tr>
		</table></div><?
	}	//КОНЕЦ МЕТОДА
	
	//отправка сообщения об ошибке (по емэйлу или запись в таблицу системных сообщений). Если событие происходит на localhost - вывод HTML
	function errorMessage ( $counter, 	//длина цикла (если функция вызывается в нём)
							$i, 		//счётчик цикла. Если не передан, выполняется только 1 итерация
							$errSubj, 	//"[тема сообщения]"
							$queryVar, 	//имя запроса
							$queryText,	//текст запроса
							$global_var=false, //глобальная переменная-индикатор блокировки отсылки копий сообщений 
							$funcMess=false //сообщение метода, вызвавшего ошибку
						  ) {	
						  
	//die("errorMessage complited");					  					  
		if ($errSubj=="") $errSubj="ОШИБКА ЗАПРОСА К БД в файле $_SERVER[REQUEST_URI]";
		if ( mysql_error() &&
			 mysql_error()!="MySQL server has gone away" && 
			 $_SESSION['ERROR_MESS_COUNT']<50 	//глобальный счётчик ошибок на странице
			) { 
			$mssText="ЗАПРОС $queryVar: <pre class='txt110'>$queryText</pre><p>Файл: ".$_SERVER['REQUEST_URI'];
			$mssText.="<hr>Текст ошибки: ".mysql_error(); 
			//ОПРЕДЕЛИТЬСЯ С СООБЩЕНИЕМ - ОТПРАВЛятЬ ПО ЕМЭЙЛУ ИЛИ ЗАПИСЫВАТЬ В ОТДЕЛЬНУЮ ТАБЛИЦУ (ИЛИ И ТО, И ДРУГОЕ)
			//если сервер локальный, прерываем генерацию контента и выводим в качестве сообщения первый аргумент функции:
			//(НЕЗАВИСИМО ОТ ТОГО, ВКЛЮЧЁН ЛИ РЕЖИМ ТЕСТИРОВАНИЯ)
			if (strstr($_SERVER['HTTP_HOST'],"localhost")) die("<DIV onClick=\"nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';\" style='display:inline; color:blue; cursor:pointer;'>$errSubj</div><div style='display:none'>$mssText</div>");
			//отправим админу сообщение об ошибке.
			//выполняем только одну итерацию, чтобы не отправлять одинаковые сообщения в цикле:
			else {
				//передавали команду блокировать отсылку копий сообщения об ошибке:
				if (!$global_var||!$_SESSION['ERR_'.$global_var]) {
					
					$qMess=nl2br($qSel."
		*********************************************************************************
		ВНИМАНИЕ! Повторная отсылка сообщения об ошибке блокирована для экономии трафика!
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
	}	//КОНЕЦ МЕТОДА
	//сообщаем пользователю об ошибке:	
	function errorUserMess($mess) {?><div class="padding10"><div class="txtRed">ОШИБКА!</div>
<p><?=$mess?><br>Мы получили данное уведомление и в ближайшее время устраним возникшую проблему. </p>
<p>Вы можете продолжать пользоваться другими разделами вашего аккаунта.</p>
</div><?
		$this->sendErrorMess($errSubj,$mess);	
	}	//КОНЕЦ МЕТОДА		
	//отправим по емэйлу сообщение об ошибке (если на удалённом сервере, иначе - выведем текст на странице):
    function sendErrorMess ($errSubj,$mssText) {
		//если не передали тему сообщения, установим её принудительно:
		if (!$errSubj) $errSubj="ОШИБКА";
		//проверим глобальный емэйл:
		if (!$_SESSION['S_ADMIN_EMAIL']) $_SESSION['S_ADMIN_EMAIL']="sale@referats.info";
		//отправитель:
		$reply_to=$_SESSION['S_ADMIN_EMAIL'];
		//тема сообщения
		$errSubj.=", файл ".$_SERVER['REQUEST_URI'];
		//если сервер локальный, - выводим данные сообщения:
		if (strstr($_SERVER['HTTP_HOST'],"localhost")) 
		  {?><div class="iborder padding10" style="background-color:#FCC;">...Отправка сообщения об ошибке (на удалённом сервере):
          <hr>
		  <div class="padding10">
			<div>Отправитель: <? echo $reply_to;?></div>
			<div>Получатель: <? echo $_SESSION['S_ADMIN_EMAIL'];?></div>
            <hr>
			<div>Тема сообщения: <? echo $errSubj;?></div>
			<div>Текст сообщения: <? echo $mssText;?></div>
		  </div>
		  </div><? 
		  }
		//если сервер удалённый, - отправляем сообщение об ошибке админу системы:
		else $send_warning=mail($_SESSION['S_ADMIN_EMAIL'],$errSubj,$mssText."<hr>mysql_error(): ".mysql_error(),"From: $_SESSION[S_ADMIN_EMAIL]".chr(13).chr(10)."Reply-To: $reply_to".chr(13).chr(10).'X-Mailer: PHP/'.phpversion()."Content-Type: text/html; charset=Windows-1251");
		if ($mssText) echo "<div class='txtRed padding10'>ОШИБКА! $mssText.</div>Администрация проекта проинформирована о событии; ошибка будет исправлена в ближайшее время. Вы можете продолжать пользоваться другими разделами системы.</div></div>"; 	
	}	//КОНЕЦ МЕТОДА
	//извлечение данных:
	function select($sql,$show=false,$inline=false) {
		
		$rSel=mysql_query($sql) or die("<div>select(\$sql) ERRORS: <pre>$sql</pre></div>");
		$rws=mysql_num_rows($rSel);
	//если в тестовом режиме:
	?><div style='background-color:#CCFFCC;<? if ($inline){?> display:inline;<? }?>' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer;'>ЗАПРОС извлечения данных (<? 
		  echo $rws;
		  if ($show) echo ", $show";?>):</DIV> 
		<div<? if (!$show){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
	
	}	//КОНЕЦ МЕТОДА	
	//выводим сообщение о выполненном запросе, изменяющем состояние БД:
	function show_query_info($action)	{ 
		//		
		if (isset($_SESSION['SHOW_ALERTS']))
		  {?>
<script type="text/javascript">
alert("Выполнен запрос <? echo $action;?> данных!");
</script>
   <?     }
   		/*if (!$_SESSION['S_ALERT_COUNTER'])
		  {?>
<script type="text/javascript">
alert("Выполнен запрос <? echo $action;?> данных!");
</script>
   <?   	$_SESSION['S_ALERT_COUNTER']=0;  
		  }
		$_SESSION['S_ALERT_COUNTER']++;
		?><div style='padding:4px;' class='iborder'>Выполнен запрос # <? echo $_SESSION['S_ALERT_COUNTER'];?></div><? */
	}	//КОНЕЦ МЕТОДА
	//добавление данных:
	function insert($sql,$show_default=false) {	//echo "<div>\$_SESSION['selected_db']= $_SESSION[selected_db]</div>";
		
		//если в тестовом режиме:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline;cursor:pointer;color:blue;'>ЗАПРОС <span class="txtRed">добавления</span> данных:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show_default){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		  }
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql) ;    
			$this->errorMessage(1,"","ОШИБКА ДОБАВЛЕНИЯ ДАННЫХ","[имя запроса]",$sql);
			return true;
		  }	
		//вывод алерта (включается/отключается внутри функции):					
		$this->show_query_info("ДОБАВЛЕНИЯ");
	}	//КОНЕЦ МЕТОДА
	//обновление данных:
	function update($sql) { 	
		//определимся - выводить ли текст запроса:
		global $show_default;	
		
		//если в тестовом режиме:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer; color:#00F;'>ЗАПРОС <span class="txtOrange">обновления</span> данных:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show_default){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		}
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql);
			$this->errorMessage(1,"","ОШИБКА ОБНОВЛЕНИЯ ДАННЫХ","[имя запроса]",$sql);
		  }						
		//вывод алерта (включается/отключается внутри функции):					
		$this->show_query_info("ОБНОВЛЕНИЯ");
	}	//КОНЕЦ МЕТОДА
	//удаление данных:
	function delete($sql,$show=false) { 	
		//определимся - выводить ли текст запроса:
		//если в тестовом режиме:
		if ($_SESSION['TEST_MODE']||$_SESSION['SHOW_QUERY']) {?>
		<div style='background-color: #CCFFCC;' class='iborder padding4'>  		
		  <DIV onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class='link' style='display:inline; cursor:pointer; color:#00F;'>ЗАПРОС <span class="bgPale">удаления</span> данных:</DIV> 
		<div<? if (!$_SESSION['SHOW_QUERY']&&!$show){?> style='display:none'<? }?>><pre class='txt120'><? echo $sql;?></pre></div>
	</div><?
		  }
		if (!isset($_SESSION['TEST_MODE']))				
		  { mysql_query($sql);
			$this->errorMessage(1,"","ОШИБКА УДАЛЕНИЯ ДАННЫХ","[имя запроса]",$sql);
		  }						
		//вывод алерта (включается/отключается внутри функции):					
		$this->show_query_info("УДАЛЕНИЯ"); 
	}	//КОНЕЦ МЕТОДА
}?>