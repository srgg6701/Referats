<?
session_start();
class Actors {
	
	function buildActorsPage($actor) {
	require_once '../classes/class.Tools.php';	
	global $catchErrors,$work_id;
	$work_id=$req_work_id=Tools::clearToIntegerAndStop($work_id);

	require_once ("class.Author.php");
	$Author=new Author; //echo "WORK ID IS HERE!"; ?>
    
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Список субъектов</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/txt.css" rel="stylesheet" type="text/css">
<link href="../css/padding.css" rel="stylesheet" type="text/css">
<link href="../css/border.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../email_check.js"></script>
<style>
body { 
	overflow:auto; 
	padding:0; 
	margin:0;
}
</style>
</head>
<body onLoad="if (document.getElementById('test_mode_info')) MM_dragLayer('test_mode_info','',0,0,0,0,true,false,-1,-1,-1,-1,false,false,0,'',false,'');">	
<script type="text/javascript">

//проверим отметку чекбоксов субъектов сообщения:
function checkSubjectsChecked() {
	//
	var aTable=document.getElementById('actors_table').getElementsByTagName('INPUT');
	var count=0;
	for (i=0;i<aTable.length;i++) {
		//
		if ( aTable.item(i).id.indexOf("actor_")!=-1 &&
			 aTable.item(i).checked==true
		   ) count++;
		
	} 
	if (count==0) {
		
		alert('Вы не отметили ни одного респондента для получения сообщения');
		return false;
		
	}
}
</script><?		
	
	$this->buildActorsTable($actor,$Author);
	
	echo "

</body>
</html>";

	
	} //КОНЕЦ МЕТОДА
	//
	function buildActorsTable($actor,$Author) {
		
		global $catchErrors;
		
		$table=$actor;
		$email="email";
		
		if ($actor=="author") {
			$table="user";
			$email="login";
		}
		//извлечём массив данных:
$qSel="SELECT * FROM ri_$table ORDER BY name ASC";
$rSel=mysql_query($qSel); 
$catchErrors->errorMessage(1,"","ОШИБКА ИЗВЛЕЧЕНИЯ ДАННЫХ","qSel",$qSel); ?>
<script type="text/javascript">

//point the actor type at parent page:
parent.document.getElementById('receiver_user_type').value='<?=$_REQUEST['actor']?>';

//инициализируем контейнер емэйлов субъектов:
var emails=new Array();

function manage_addresses () { 
	
	cbox=event.srcElement;
	
	if (cbox.tagName=="INPUT"&&cbox.id.indexOf("actor_")!=-1) {	
	
		var addr=parent.document.getElementById('addresses');
		//если чекбокс отмечен, добавляем емэйл в массив:	
		if (cbox.checked==true) emails.push(cbox.value);
		//иначе удалим из массива:
		else for(i=0;i<emails.length;i++) if (emails[i]==cbox.value) emails.splice(i,1);
		//преобразуем массив в строку и сохраним значение в hidden родительского фрейма, чтобы отправить с данными формы:
		addr.value=emails.join(",");		

	}
}
document.onclick=manage_addresses;
</script>
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
  <tr style="height:auto;" bgcolor="#F5F5F5">
    <td class="padding4 bold iborder borderColorGray" style="border-right:none; padding-left:3px;">
    	<span class="padding2 paddingLeft0" style="margin-left:0px;"><input name="allBoxes" type="checkbox" disabled title="Отметить/разотметить всех"></span>
    	<img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />id
        <img src="<?=$_SESSION['SITE_ROOT']?>images/unknown.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Имя, 
        <!--<span class="padding2">Емэйл,</span>-->
        <img src="<?=$_SESSION['SITE_ROOT']?>images/mobila.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Моб. тел,
    	<img src="<?=$_SESSION['SITE_ROOT']?>images/icq.gif" width="16" height="15" hspace="4" border="0" align="absmiddle" />Icq,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/skype_transparent.png" width="18" height="18" hspace="4" border="0" align="absmiddle" />Skype<? 
		if ($actor=="author") {?>,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/word2_mini.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />Работ<? }
		if ($actor!="workers") {?>,
        <img src="<?=$_SESSION['SITE_ROOT']?>images/basket_middle.png" width="21" height="20" hspace="4" border="0" align="absmiddle" />Заказов<?
		}?></td>
  </tr>
  <tr height="100%">
    <td colspan="2" valign="top">
      <div style="height:100%; overflow:auto;">
<?	//
	if (isset($_REQUEST['user_id'])) {
		
		$user_id=$_REQUEST['user_id'];		
		
		?>
<div class="padding10 bgYellowFadeTop txt120">Выбранный <? 
		if ($actor=="author"){?><img src="<?=$_SESSION['SITE_ROOT']?>images/author2.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />автор<?
		
		}else{
			
			?><img src="<?=$_SESSION['SITE_ROOT']?>images/user_small.png" width="14" height="16" hspace="4" border="0" align="absmiddle" />заказчик<? 
		
		}?>:</div>
<?
	}?>
      <table width="100%" cellpadding="4" cellspacing="0" rules="rows" id="actors_table">
        <colgroup>
          <col style="padding:2px;">
        </colgroup>
<?	$i=0;
	// 
	while ($arr = mysql_fetch_assoc($rSel)) { 
		
		if (!$user_id||$user_id==$arr['number']){?>
  <tr>
    <td align="center"><input type="checkbox" name="actor_<?=$arr['number']?>" id="actor_<?=$arr['number']?>" value="<?=$arr[$email]?>"<?
    
	if ($arr[$email]) {?> title="<?=$arr[$email]?>"<? } if ($user_id){?> checked<? }?>></td>
    
    <td align="right"><? if ($test){?>#<? } echo $arr['number'];?></td>
    <td width="100%" nowrap><a href="#"><? if ($test){?>name<? } 
	
	$name=$arr['name'];
	if ($name) {
		
		if (strlen($name)>18) {
			
			?><span title="<?=$name?>"><? echo substr($name,0,17)."...";?></span><?
		
		}else{
			
			echo $name;
			
		}
		
	}else{
		
		if ($arr['login']){ 
			
			if ($test){?>LOGIN<? } echo "<a href='#' title='Login'>".$arr['login']."</a>";

		}elseif ($arr['email']) {

			if ($test){?>EMAIL<? } echo "<a href='#' title='Email'>".$arr['email']."</a>";
		
		}
	} ?></a></td>
  
    <td nowrap><? if ($test){?>mobila<? } 
	
	$mobila=preg_replace("[^0-9+]","",$arr['mobila']);
	
	echo ($mobila)? $mobila:"&nbsp;";
	
	?></td>
    
    <td><? if ($test){?>icq<? } 
	
	$icq=preg_replace("[^0-9]","",$arr['icq']);
	echo ($icq)? $icq:"&nbsp;";
	
	?></td>
    
    <td><? if ($test){?>skype<? } echo ($arr['skype'])? $arr['skype']:"&nbsp;";?></td>
<?	if ($actor=="author"){?>    
    <td><? 
	
		//все работы данного автора:
		if (isset($_SESSION['TEST_MODE'])) echo "<div>class.Actors</div>";
		$arrAuthorWorks=$Author->getAllAuthorsWorxNumbers($arr['number']);
		echo count($arrAuthorWorks);
	
	?></td>
    <td><?
	
		echo count($Author->getAllAuthorsOrdersNumbers($arrAuthorWorks));
    
	?></td>
<?	}?>
  </tr>
<?		}
    } ?>
  <tr>
    <td align="center"><? ?>      <input name="send_copy_to_me" type="checkbox" value="<?=$_SESSION['S_MANAGER_EMAIL']?>" checked></td>
    <td colspan="2">Отправить мне копию сообщения <? //=$_SESSION['S_MANAGER_EMAIL']?></td>
    <td nowrap>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
        </table></div>
    </td>
    </tr>
</table>
	
<?	} //КОНЕЦ МЕТОДА
}?>