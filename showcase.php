<?		   		
	if (isset($_SESSION['TEST_MODE'])) echo "<hr>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]<hr>";
	
	$limit_finish=(strstr($_SERVER['HTTP_HOST'],"localhost"))? 25:25;
	$Worx->setPagesLimit($limit_finish,$limit_start);
	  
	$work_subject=$_REQUEST['work_subject'];	
	
	if ($work_subject) $dbSearch=new dbSearch;
	
	//определить аргумент для типа работы - искомой по теме или выбор для всех:
	$work_type=($_REQUEST['work_type'])? $_REQUEST['work_type']:$_SESSION['S_WORK_TYPE_ALL'];
	$work_area=($_REQUEST['work_area'])? $_REQUEST['work_area']:$_SESSION['S_WORK_AREA_ALL'];

	//echo "<div>isset(\$request_work_type_all)=".isset($request_work_type_all).", work_type= $work_type</div>";
	//echo "<div>isset(\$request_work_area_all)=".isset($request_work_area_all).", work_area= $work_area</div>";
	//echo "<hr>";

	//if (isset($_SESSION['TEST_MODE'])) echo "<hr>S_WORK_TYPE_ALL= $_SESSION[S_WORK_TYPE_ALL]<hr>";
	//echo "<div>S_WORK_AREA_ALL= $_SESSION[S_WORK_AREA_ALL]</div>";

	//получить все данные доступных работ для отображения в таблице:
	$arrAll=$Worx->findAllWorx( $work_subject,
								$work_type,
								$work_area,
								$arrDplomZakazIDsWithFiles, //все доступные к продаже работы diplom_zakaz с файлами, как в директориях, так и приаттаченные
								$arr //массив отсортированных найденных значений
							  );
	$all_worx=count($arrAll);
	
	//$test_array=true;
	if ($test_array)
	for ($i=0;$i<count($arrAll);$i++) {
		foreach ($arrAll[$i] as $key=>$val)		
			if (isset($_SESSION['TEST_MODE'])) echo "<div>[$key] => $val</div>";
	}
	?><img src="images/spacer.gif" width="100%" height="12"><table width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td width="100%" class="bgPanel borderBottom1 borderColorGray paddingLeft10"><h1 class="txt130" style="margin-bottom:14px;"><img alt="Скачать реферат курсовую диплом диссертацию" src="images/shopping_plus-32.png" width="32" height="32" hspace="4" align="absbottom"><?
	    if ($work_subject) {?>Найденные<? $wcnt=count($arr);}
        else {?>Готовые<? $wcnt=$all_worx; }?> работы (<? echo $wcnt;?>):</h1></td>
      <td nowrap class="iborder borderColorGray padding10 bgPale"><noindex><a href="#" onClick="location.href='http://www.educationservice.ru/#take_order';return false;" style="color:#009;" class="txt110"><img alt="Заказать диплом, курсовую, реферат" src="images/star.gif" width="15" height="15" hspace="4" border="0">Нужен <strong>диплом на заказ</strong>?</a></noindex></td>
    </tr>
</table>
<div class="paddingBottom6 paddingTop6">
<? if (!$work_subject) {?>
	
	<? 	if ($test_worx_filter){?>{Отобразить таблицу выбора типа и предмета работ (фильтр)}<? }
		//
		$Worx->setFilterToWorxCriteria();?>
    
<? }?>
</div>
<?
if ($_REQUEST['show_wrong_ext']&&is_array($Worx->arrWrongExt)) {
	
	$arrWrongExt=$Worx->arrWrongExt;
?>
<div style='color:blue; cursor:pointer' onClick="nextSibling.style.display=(nextSibling.style.display=='none')? 'block':'none';" class="txt130 bold arial padding4 bgPale iborder">Всего неправильных файлов: <?=count($arrWrongExt)?></div>
	<div style="display:<?="none"?>;" id="container"><?
	
	for ($i=0;$i<count($arrWrongExt);$i++)
		foreach($arrWrongExt[$i] as $color=>$path) {?><div class="txt<?=$color?>"><?=$path?></div><? }
	
	?><div class="padding4"><a href="#" onClick="document.getElementById('container').style.display='none';return true;">Свернуть</a></div>
    </div><?
}?>
<!--<img src="images/spacer.gif" width="100%" height="14">--><table width="100%" border="1" cellpadding="4" cellspacing="0" rules="rows" id="tbl_customer">
  	  <tr bgcolor="#003399" class="borderBottom2 borderColorOrangePale">
  	    <td height="36" class="cellPassive<? //echo($_SESSION['S_SORT']=="subject")? "Active":"Passive";?>"><input type="checkbox" name="checAll" id="checkAll" onClick="manageCheckBoxes(this,'tbl_customer');"></td>
    	<td bgcolor="#003399" class="padding6 cellPassive<? //echo($_SESSION['S_SORT']=="subject"||$work_subject)? "Active":"Passive"; ?>"><strong><a <? 
		
		/*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=subject"<? }*/
		
		?>>Тема</a></strong></td>
    	
        <td class="padding6 cellPassive<? //echo(($_SESSION['S_SORT']=="typework"&&!$work_subject)||$_REQUEST['work_type'])? "Active":"Passive"; ?>"><strong><a <? /*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=typework"<? }*/ ?>>Тип</a></strong></td>
    	
        <td class="padding6 cellPassive<? //echo(strstr($_SESSION['S_SORT'],"predmet")&&!$work_subject)? "Active":"Passive"; ?>"><strong><a <? /*if ($work_subject){?>class=""<? }else{?>href="bank_referatov.php?sort=diplom_worx_topix.predmet"<? }*/
		
		?>>Предмет</a></strong></td>

  	  </tr>
	<?	//создадим массивы для генерации SEO-ссылок:
		$arrWrkTypes=array();
		$arrWrkAreas=array();
		//выясним, есть ли заказ в корзине; - выведем title, заблокируем чекбокс
		function findOrder($work_id,&$title_busy) {
			//проверим, нет ли уже у заказчика такого заказа в корзине:
			$qFindOrder="SELECT number FROM ri_basket WHERE user_id = $_SESSION[S_USER_ID] AND work_id = $work_id";
			if ($_SESSION['S_USER_TYPE']=='customer'&&mysql_num_rows(mysql_query($qFindOrder))) $checked_disabled=" checked disabled";

			//выведем title об отложенном в корзину заказе:
			if ($checked_disabled) $title_busy=' title="Заказ отложен в вашу корзину"'; 
			return $checked_disabled;
		}
		
		$bg_count=0; //background
        //errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel);
        //если загружаем результаты поиска:
        if ($work_subject) {
			 
            for ($r=0,$cnt=count($arr);$r<$cnt;$r++) {
				//сбрасываем метку заказа, отложенного в корзину:
				unset($checked_disabled); 
                $work_id=$arr[$r]['item_id'];
				//выясним, не находится ли заказ уже в корзине:
				$checked_disabled=findOrder($work_id,$title_busy);
				//если не давали команду добавить заказы из кабинета:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {
				
                	$work_subject=$arr[$r]['item_name'];
                	
					//predmet//typework:
					$work_table=$arr[$r]['item_table'];
					$Worx->getWorkAreaAndType($work_table,$work_id);
					$work_area=$Worx->work_area;
					$work_type=$Worx->work_type;?>
                    
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>

    <td><input type="checkbox" 
    		   name="order_<?=$work_table?>_<?=$work_id?>" 
    		   id="order_<?=$work_table?>_<?=$work_id?>" 
               value="<?=$work_id?>"<?=$checked_disabled?>></td>
    <td><a href="<?=$go_index?>?mode=skachat-rabotu&amp;work_table=<?=$work_table?>&amp;work_id=<?=$work_id?>"><?
					
				if ($work_subject||$work_id) 
					echo ($work_subject)? $work_subject:"id :".$work_id;
				elseif (isset($_SESSION['TEST_MODE'])) 
					echo "<div>work_table= $work_table, work_id= $work_id, work_subject= $work_subject, work_type= $work_type, work_area= $work_area</div>";
				
				?></a></td>
    <td><?=$work_type?></td>
    <td><?=$work_area?></td>
  </tr>
	  <?			$bg_count++; //инкременируем счётчик бэкграундов
	  			}
            }

        }elseif($all_worx){ //если загружаем список по умолчанию:

			//установим текущий лимит отображения записей на стр.:
			$current_limit=(($limit_start+$limit_finish)<$all_worx)? ($limit_start+$limit_finish):$all_worx;
			for ($i=$limit_start;$i<$current_limit;$i++) {
				//сбрасываем метку заказа, отложенного в корзину:
				unset($checked_disabled); 
				//выясним, не находится ли заказ уже в корзине:
				$checked_disabled=findOrder($arrAll[$i]['work_id'],$title_busy);
				//если не давали команду добавить заказы из кабинета:
				if (!$checked_disabled||$_REQUEST['filter']!="free_only") {?>
		
  <tr<? if(!is_int($bg_count/2)){?> class="bgF4FF"<? } echo $title_busy;?>>
        
    <td><input type="checkbox" 
    		   name="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               id="order_<?=$arrAll[$i]['work_table']?>_<?=$arrAll[$i]['work_id']?>" 
               value="<?=$arrAll[$i]['work_id']?>"<?=$checked_disabled?>>
   </td>
    <td><a href="<?=$go_index?>?mode=skachat-rabotu&amp;work_table=<?=$arrAll[$i]['work_table']?>&amp;work_id=<?=$arrAll[$i]['work_id']?>"><?
	
		
		if ($arrAll[$i]['work_subject']||$arrAll[$i]['work_id']) 
			echo ($arrAll[$i]['work_subject'])? $arrAll[$i]['work_subject']:"id :".$arrAll[$i]['work_id'];
		elseif (isset($_SESSION['TEST_MODE'])) 
			echo "<div>work_table= ".$arrAll[$i]['work_table'].", work_id= ".$arrAll[$i]['work_id'].", work_subject= ".$arrAll[$i]['work_subject'].", work_type= ".$arrAll[$i]['work_type'].", work_area= ".$arrAll[$i]['work_area']."</div>";

			
			?></a></td>
    <td><? 
					if (!in_array($arrAll[$i]['work_type'],$arrWrkTypes)) {
						
						?><a title="Отфильтровать работы по типу" href="<?=$go_index?>?mode=skachat-rabotu&amp;work_type=<? 
		echo $Tools->setWorkParamCpuLink($arrAll[$i]['work_type']);?>&amp;work_area=<? 
		
		$wapredmet=($_SESSION['S_WORK_AREA_ALL'])? $_SESSION['S_WORK_AREA_ALL']:$Tools->setWorkParamCpuLink($arrAll[$i]['work_area']);
		echo $wapredmet;?>"><?
						
						$arrWrkTypes[]=$arrAll[$i]['work_type'];
						
					} echo $arrAll[$i]['work_type'];
					
					if (!in_array($arrAll[$i]['work_type'],$arrWrkTypes)) {?></a><? }?></td>
    <td><? 
					if (!in_array($arrAll[$i]['work_area'],$arrWrkAreas)) {
						
						//echo "[work_type]= ".$arrAll[$i]['work_type'].", S_WORK_TYPE_ALL= ".$_SESSION['S_WORK_TYPE_ALL'];
						
						?><a title="Отфильтровать работы по предмету" href="<?=$go_index?>?mode=skachat-rabotu&amp;work_type=<? 
		
		$watype=($_SESSION['S_WORK_TYPE_ALL'])? $_SESSION['S_WORK_TYPE_ALL']:$Tools->setWorkParamCpuLink($arrAll[$i]['work_type']);
		echo $watype;?>&amp;work_area=<? 
		echo $Tools->setWorkParamCpuLink($arrAll[$i]['work_area'],"area");?>"><?
						//echo "<div>work_area=".$arrAll[$i]['work_area']."</div>";
						$arrWrkAreas[]=$arrAll[$i]['work_area'];
					
					} echo $arrAll[$i]['work_area'];
					
					if (!in_array($arrAll[$i]['work_area'],$arrWrkAreas)) {?></a><? }?></td>
  </tr>
<?					$bg_count++;
				}
    		} 
		}?>
    </table><? 
	//
	$Blocks->authorizeToAddToBasket();
	//отослать извещение о нераспаковываемых файлах:
	$Tools->wrongExtIssue()?>
    <table cellspacing="0" cellpadding="0">
  <tr>
    <td class="paddingBottom8 paddingTop8">
    <input name="order_action" type="hidden" value="add_to_basket">
    <input type="submit" value="Добавить в корзину заказов!" style="padding:8px; width:240px;" onClick="return checkAllBoxes('reg_area');"></td>
<?  if ($work_subject) {?>
	<td class="paddingLeft10">[<a href="index.php">сбросить результат поиска</a>]</td>
<? }?>
  </tr>
</table><?	  
	  //$test_pages=true;
	  if ($test_pages){?>{ Переход по страницам... }<? }
	  $Blocks->makePagesNext($all_worx,$limit_finish);?>

	