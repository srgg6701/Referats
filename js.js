// JavaScript Document

//добавляем цитату исходного сообщения, заменяем теги переноса строки физическими переносами:
function addCitationToAnswer(area_id){
var text_source=document.getElementById('mess_source_'+area_id).innerHTML;

var res = new Array(/<br>/g,/<BR>/g,/<br \/>/g,/<BR \/>/g);
	//var result="None";
	for (i=0;i<res.length;i++) {
		if (res[i].test(text_source)) {
			text_source=text_source.replace(res[i],"\n");
		}
	}
	var txtarea=document.getElementById('txtarea_'+area_id);
	txtarea.value="\n\n***	Исходное сообщение:\n\n"+text_source;	
	txtarea.focus();
	document.getElementById('mess_source_'+area_id).style.display="none";
}
//
function applyPayment(paiment_id,order_id) {
	var go_page="?menu=money&action=apply&payment_id="+paiment_id+"&summ="+document.getElementById('summ_'+paiment_id).value;
	if (order_id) go_page+="&order_id="+order_id;
location.href=go_page;

}
//проверить заполнение полей формы:
function checkFields() { //alert('checkFields');
//массив сообщений об ошибках:	
var err=new Array();
var err_mess="Данные платежа не могут быть отправлены, потому что:\n";
var i=0;
	//если есть список выбора заказов:
	var basket_select=document.getElementById('order_id');
	if (basket_select&&basket_select.options[basket_select.selectedIndex].value=="0") {
		err[i]="Вы не выбрали заказ";
		i++;
	}
	//не выбрали способ оплаты:	
	if (document.getElementById('pay_method').options[document.getElementById('pay_method').selectedIndex].value==0) {
		err[i]="Вы не указали способ оплаты";
		i++;
	}
	//не указали сумму:	
	if (document.getElementById('summ').value<1) {
		err[i]="Вы не указали сумму оплаты";
		i++;
	}else if (isNaN(document.getElementById('summ').value)) { //не число:
		err[i]="Указанное вами значение для  суммы оплаты не является числом";
		i++;
	}
	
	if (err.length>0) {
		for(i=0;i<err.length;i++){
			//if errors caugth:
			if (err[i]) {
				if (i>0) err_mess+="\n";
				err_mess+="* "+err[i];
			}
		}
		alert(err_mess);
		return false;		
	}
}
//проверить НЕ-число:
function checkPriceInt(tBlock,id_sbstr) {  
	//target:
	var tbl=document.getElementById(tBlock).getElementsByTagName('INPUT');
	for (i=0;i<tbl.length;i++) { 
		if ( tbl.item(i).value &&
			 isNaN(tbl.item(i).value) &&
			 tbl.item(i).id.indexOf(id_sbstr)!=-1
		   ) { alert ('Введённое значение не является числом!');	
			   tbl.item(i).style.backgroundColor="yellow";
			   return false;
		}
	}
}
//проверим, есть ли хоть один отмеченный чекбокс:	
function checkTblBoxes(tObj) {
var tblLen=document.getElementById(tObj).getElementsByTagName("INPUT");
for (i=0;i<tblLen.length;i++)
  { if(tblLen.item(i).id.indexOf('box[')!=-1&&tblLen.item(i).checked==true) 
  	  { return true;
	    break;
	  } 
  } 
alert('Вы не отметили ни одной работы!');
return false;  
}
//вывод текста в HTML
function dwrite(content){

	document.write(content);

}

//////////////// Проверка корректности записи емэйла при заполнении пользователем формы.: ////////////////

function goFalse (alertMess,targetCell/*целевая ячейка*/) { //пакет действий при обнаружении некорректно заполненного поля формы для емэйла; используется в следующей (основной) функции
	alert(alertMess);
	targetCell.focus(); 
	targetCell.style.backgroundColor="#FFFF00";    
	//return false;
}

//проверка типа числа - целое/дробное
function isInt(x) { 
   var y=parseInt(x); 
   if (isNaN(y)) return false; 
   return x==y && x.toString()==y.toString(); 
} 
//
function manageFormVisibility(stat,elem) {
document.getElementById(elem).style.display=stat;
//document.getElementById('ask_user_email').style.display='none';
}
//
function searchWork(work_type) {
	document.getElementById('work_type').value=work_type;
	document.forms['form1'].action="index.php?mode=showcace";
	document.forms['form1'].submit();
}

dg="@";
realm=".";
realm+="info";
var mContent="sale"+dg+"referats"+realm;
function showFeedBack(fcontent) {
	var tBlock=document.getElementById('feedbak_container');
	if (fcontent=="email") fcontent=mContent;
tBlock.innerHTML=fcontent;
}
//
function sendEmail() {
	location.href="mailto: "+mContent;
}
//
function callViaSkipe(dSkipe) {
	location.href="skype:"+dSkipe;
}
//добавить запись в поле:
function addOrderNote(mtype,order_id) {
var set_subject;
	switch(mtype) {
		case "order":
		set_subject="Сообщение по заказу id "+order_id;
		document.getElementById('ri_basket_id').value=order_id;
		break;
		
		default: set_subject="Новое сообщение администрации Referats.info.";
	}
document.getElementById('comment').value=set_subject+':\n----------------------------------------\n';
document.getElementById('set_subject').value=set_subject;
}

function makeAnswerArea(area_id){
var answerArea='<textarea rows="6" name="txtarea_'+area_id+'" id="txtarea_'+area_id+'" class="widthFull" title="Двойной щелчок увеличит высоту поля;\nОдиночный щелчок + Ctrl - уменьшит;\nДвойной + Ctrl - вернёт размер к начальному значению." onDblClick="if (event.ctrlKey) this.rows=4; else this.rows+=4"	onClick="if (event.ctrlKey&&this.rows>1) this.rows-=3;"></textarea>      <div class="paddingTop6 paddingBottom4"><input name="send_answer_'+area_id+'" type="submit" value="Отправить!"></div>';
document.getElementById('answer_area_'+area_id).innerHTML=answerArea;	
}
//пакетные действия с чекбоксами:	
function manageCheckBoxes(mBox,tObj) {
var tblLen=document.getElementById(tObj).getElementsByTagName("INPUT");
for (i=0;i<tblLen.length;i++) tblLen.item(i).checked=(mBox.checked==true)? true:false;
}
//
function manageGatewayIFrameUnread(ifra,mess_id) {
//message_read
//message_unread
document.getElementById(ifra).src="queries_background_gateway.php?message_unread="+mess_id;
}
function deleteMessage(ifra,mess_id) {
	if (confirm('Удалить сообщение из БД?')) document.getElementById(ifra).src="queries_background_gateway.php?message_delete="+mess_id;
	return false;
}
/*//управляем текстами сообщения:
function manageMessTexts(obj) { 
	
	var tNode=obj.parentNode.parentNode;
	
	alert("obj.tagName= "+obj.tagName+"\ntNode.nodeName= "+tNode.nodeName+"\ntNode.innerHTML= "+tNode.innerHTML);
	
	//строка, следующая (параллельная) строке, содержащей ячейку-источник события -> первая (по индексу) ячейка
	var nextSbl=obj.parentNode.nextSibling.getElementsByTagName('TD').item(0);	
	
				//td->tr
	//ссылки для ответа:
	var answ="<div class='paddingTop4 paddingLeft10 paddingBottom10' style='border-bottom: solid 1px #CCC;'><a href='#' onClick='makeAnswerArea("+obj.id+");showMessSource("+obj.id+");return false;'>Ответить</a> | <a href='#' onClick='makeAnswerArea("+obj.id+");addCitationToAnswer("+obj.id+");return false;'>Ответить с цитатой</a></div>";
		//alert(answ);
		//alert(nextSbl.innerHTML+'\n'+nextSbl.innerHTML.indexOf(answ));
	//если ссылки для ответа сгенерированы:
	if (nextSbl.innerHTML.indexOf(">Ответить с цитатой</")==-1) nextSbl.insertAdjacentHTML("afterBegin",answ);
	//придаём стилевые атрибуты контейнеру с текстом исходного сообщения:
	nextSbl.getElementsByTagName('div').item(2).className="padding10 bgPale";
	if (nextSbl.style.display=='none') nextSbl.style.display='block';
	//ПРЯЧЕМ блок исходного сообщения и удаляем поле для ответа:
	else {
		nextSbl.style.display='none';
		document.getElementById('answer_area_'+obj.id).innerHTML="";
		showMessSource(obj.id);
	}
	//загружаем фрейм для выполнения процедуры метки сообщения:
	document.getElementById('gateway_'+obj.id).src="queries_background_gateway.php?message_read="+obj.id;
	//alert('gateway_'+obj.id+'\nsrc= '+document.getElementById('gateway_'+obj.id).src);
	//'gateway_'+obj.id	
}*/
//
function manageTextBlocks ( area_id, //id родительского блока
							area_id_substr, //подстрока в id элементов
							obj_id, //id
							display //тип отображения элемента
						  ) {	
	var area=document.getElementById(area_id).getElementsByTagName('div'); //alert(area_id_substr);
	
	for(i=0;i<area.length;i++) 
		//если есть подстрока в id текущего элемента:
		if (area.item(i).id.indexOf(area_id_substr)!=-1) 
			//скроем элемент: 
			area.item(i).style.display='none';
	
	if (!display) display="block";
	document.getElementById(area_id_substr+obj_id).style.display=display;
}
//отправить субъекту напоминание пароля по его запросу:
function sendPass(actor_email,actor_type) { 
var stsend='/sections/register.php?email_to_send_password='+actor_email+'&actor_type='+actor_type;
//alert(stsend);
sendPassword.location.href=stsend; 
return false;
}
//вынужденное извращение, т.к. напрямую функция sendPass не передаёт значение глобальной пер. user_login
function sendMailAgain(actor_type) {
	//alert(user_login);
	sendPass(user_login,actor_type)
}
//генереруем емэйл:
function setMail (login,domain,after_dot,stclass) {
var mTo=new Array('m','a','i','l','t','o',': ','@','.');
var logon=login+mTo[7]+domain+mTo[8]+after_dot;
var mlt=mTo[0]+mTo[1]+mTo[2]+mTo[3]+mTo[4]+mTo[5]+mTo[6]+logon;
var sb="subject";
document.write("<nobr><a href='"+mlt+"?"+sb+"=' class='"+stclass+"'>"+logon+'</a></nobr>');	
}
//отобразить форму аутентификации:
function showAuthForm(reg_area) { document.title="Требуется аутентификация или регистрация!";

	if (reg_area) document.getElementById(reg_area).style.display='block';
	return false;

}
//отобразим текст исходного сообщения:
function showMessSource(obj_id) {
	document.getElementById('mess_source_'+obj_id).style.display="block";
}
//
function showMessAsTitle(obj) {	
obj.title=obj.parentNode.nextSibling.getElementsByTagName('TD').item(0).innerText;	
}
//переключить видимость блоков
function switchDisplay (block_name) {
	var tblock=document.getElementById(block_name);
	tblock.style.display=(tblock.style.display=='block'||!tblock.style.display)? 'none':'block';
}
//переключить текст переключателя:
function switchSwitcherText (obj_id,text1,text2) {
	//alert(text1+'\n'+text2);//obj.innerHTML
	var tobj=document.getElementById(obj_id);
	tobj.innerHTML=(tobj.innerHTML==text1)? text2:text1;
}
//
function txtAreaHeightIncrease(tArea,HStart,tHval) { //dblclick
	var currentHeight=parseInt(tArea.style.height);
	var pHeight=tHval+'px';
	    if (event.ctrlKey) tArea.style.height=HStart+'px'; 
		else tArea.style.height=currentHeight+tHval+'px';
}
//
function txtAreaHeightDecrease(tArea,HStart,tHval) { //click
	var currentHeight=parseInt(tArea.style.height);
	var pHeight=tHval+'px';
	if (event.ctrlKey&&currentHeight>HStart) tArea.style.height=currentHeight-tHval+'px';
}

////////////////////////////////////////////////////

//DW scripts:
function MM_scanStyles(obj, prop) { //v9.0
  var inlineStyle = null; var ccProp = prop; var dash = ccProp.indexOf("-");
  while (dash != -1){ccProp = ccProp.substring(0, dash) + ccProp.substring(dash+1,dash+2).toUpperCase() + ccProp.substring(dash+2); dash = ccProp.indexOf("-");}
  inlineStyle = eval("obj.style." + ccProp);
  if(inlineStyle) return inlineStyle;
  var ss = document.styleSheets;
  for (var x = 0; x < ss.length; x++) { var rules = ss[x].cssRules;
	for (var y = 0; y < rules.length; y++) { var z = rules[y].style;
	  if(z[prop] && (rules[y].selectorText == '*[ID"' + obj.id + '"]' || rules[y].selectorText == '#' + obj.id)) {
        return z[prop];
  }  }  }  return "";
}

function MM_getProp(obj, prop) { //v8.0
  if (!obj) return ("");
  if (prop == "L") return obj.offsetLeft;
  else if (prop == "T") return obj.offsetTop;
  else if (prop == "W") return obj.offsetWidth;
  else if (prop == "H") return obj.offsetHeight;
  else {
    if (typeof(window.getComputedStyle) == "undefined") {
	    if (typeof(obj.currentStyle) == "undefined"){
		    if (prop == "P") return MM_scanStyles(obj,"position");
        else if (prop == "Z") return MM_scanStyles(obj,"z-index");
        else if (prop == "V") return MM_scanStyles(obj,"visibility");
	    } else {
	      if (prop == "P") return obj.currentStyle.position;
        else if (prop == "Z") return obj.currentStyle.zIndex;
        else if (prop == "V") return obj.currentStyle.visibility;
	    }
    } else {
	    if (prop == "P") return window.getComputedStyle(obj,null).getPropertyValue("position");
      else if (prop == "Z") return window.getComputedStyle(obj,null).getPropertyValue("z-index");
      else if (prop == "V") return window.getComputedStyle(obj,null).getPropertyValue("visibility");
    }
  }
}

function MM_dragLayer(objId,x,hL,hT,hW,hH,toFront,dropBack,cU,cD,cL,cR,targL,targT,tol,dropJS,et,dragJS) { //v9.01
  //Copyright 2005-2006 Adobe Macromedia Software LLC and its licensors. All rights reserved.
  var i,j,aLayer,retVal,curDrag=null,curLeft,curTop,IE=document.all;
  var NS=(!IE&&document.getElementById); if (!IE && !NS) return false;
  retVal = true; if(IE && event) event.returnValue = true;
  if (MM_dragLayer.arguments.length > 1) {
    curDrag = document.getElementById(objId); if (!curDrag) return false;
    if (!document.allLayers) { document.allLayers = new Array();
      with (document){ if (NS) { var spns = getElementsByTagName("span"); var all = getElementsByTagName("div");
        for (i=0;i<spns.length;i++) if (MM_getProp(spns[i],'P')) allLayers[allLayers.length]=spns[i];}
        for (i=0;i<all.length;i++) {
	        if (MM_getProp(all[i],'P')) allLayers[allLayers.length]=all[i]; 
        }
    } }
    curDrag.MM_dragOk=true; curDrag.MM_targL=targL; curDrag.MM_targT=targT;
    curDrag.MM_tol=Math.pow(tol,2); curDrag.MM_hLeft=hL; curDrag.MM_hTop=hT;
    curDrag.MM_hWidth=hW; curDrag.MM_hHeight=hH; curDrag.MM_toFront=toFront;
    curDrag.MM_dropBack=dropBack; curDrag.MM_dropJS=dropJS;
    curDrag.MM_everyTime=et; curDrag.MM_dragJS=dragJS;
  
    curDrag.MM_oldZ = MM_getProp(curDrag,'Z');
    curLeft = MM_getProp(curDrag,'L');
    if (String(curLeft)=="NaN") curLeft=0; curDrag.MM_startL = curLeft;
    curTop = MM_getProp(curDrag,'T');
    if (String(curTop)=="NaN") curTop=0; curDrag.MM_startT = curTop;
    curDrag.MM_bL=(cL<0)?null:curLeft-cL; curDrag.MM_bT=(cU<0)?null:curTop-cU;
    curDrag.MM_bR=(cR<0)?null:curLeft+cR; curDrag.MM_bB=(cD<0)?null:curTop+cD;
    curDrag.MM_LEFTRIGHT=0; curDrag.MM_UPDOWN=0; curDrag.MM_SNAPPED=false; //use in your JS!
    document.onmousedown = MM_dragLayer; document.onmouseup = MM_dragLayer;
    if (NS) document.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
    } else {
    var theEvent = ((NS)?objId.type:event.type);
    if (theEvent == 'mousedown') {
      var mouseX = (NS)?objId.pageX : event.clientX + document.body.scrollLeft;
      var mouseY = (NS)?objId.pageY : event.clientY + document.body.scrollTop;
      var maxDragZ=null; document.MM_maxZ = 0;
      for (i=0; i<document.allLayers.length; i++) { aLayer = document.allLayers[i];
        var aLayerZ = MM_getProp(aLayer,'Z');
        if (aLayerZ > document.MM_maxZ) document.MM_maxZ = aLayerZ;
        var isVisible = (MM_getProp(aLayer,'V')).indexOf('hid') == -1;
        if (aLayer.MM_dragOk != null && isVisible) with (aLayer) {
          var parentL=0; var parentT=0;
          if (NS) { parentLayer = aLayer.parentNode;
            while (parentLayer != null && parentLayer != document && MM_getProp(parentLayer,'P')) {
              parentL += parseInt(MM_getProp(parentLayer,'L')); parentT += parseInt(MM_getProp(parentLayer,'T'));
              parentLayer = parentLayer.parentNode;
              if (parentLayer==document) parentLayer = null;
          } } else if (IE) { parentLayer = aLayer.parentElement;       
            while (parentLayer != null && MM_getProp(parentLayer,'P')) {
              parentL += MM_getProp(parentLayer,'L'); parentT += MM_getProp(parentLayer,'T');
              parentLayer = parentLayer.parentElement; } }
          var tmpX=mouseX-((MM_getProp(aLayer,'L'))+parentL+MM_hLeft);
          var tmpY=mouseY-((MM_getProp(aLayer,'T'))+parentT+MM_hTop);
          if (String(tmpX)=="NaN") tmpX=0; if (String(tmpY)=="NaN") tmpY=0;
          var tmpW = MM_hWidth;  if (tmpW <= 0) tmpW += MM_getProp(aLayer,'W');
          var tmpH = MM_hHeight; if (tmpH <= 0) tmpH += MM_getProp(aLayer,'H');
          if ((0 <= tmpX && tmpX < tmpW && 0 <= tmpY && tmpY < tmpH) && (maxDragZ == null
              || maxDragZ <= aLayerZ)) { curDrag = aLayer; maxDragZ = aLayerZ; } } }
      if (curDrag) {
        document.onmousemove = MM_dragLayer;
        curLeft = MM_getProp(curDrag,'L');
        curTop = MM_getProp(curDrag,'T');
        if (String(curLeft)=="NaN") curLeft=0; if (String(curTop)=="NaN") curTop=0;
        MM_oldX = mouseX - curLeft; MM_oldY = mouseY - curTop;
        document.MM_curDrag = curDrag;  curDrag.MM_SNAPPED=false;
        if(curDrag.MM_toFront) {
          var newZ = parseInt(document.MM_maxZ)+1;
          eval('curDrag.'+('style.')+'zIndex=newZ');
          if (!curDrag.MM_dropBack) document.MM_maxZ++; }
        retVal = false; if(!NS) event.returnValue = false;
    } } else if (theEvent == 'mousemove') {
      if (document.MM_curDrag) with (document.MM_curDrag) {
        var mouseX = (NS)?objId.pageX : event.clientX + document.body.scrollLeft;
        var mouseY = (NS)?objId.pageY : event.clientY + document.body.scrollTop;
        var newLeft = mouseX-MM_oldX; var newTop  = mouseY-MM_oldY;
        if (MM_bL!=null) newLeft = Math.max(newLeft,MM_bL);
        if (MM_bR!=null) newLeft = Math.min(newLeft,MM_bR);
        if (MM_bT!=null) newTop  = Math.max(newTop ,MM_bT);
        if (MM_bB!=null) newTop  = Math.min(newTop ,MM_bB);
        MM_LEFTRIGHT = newLeft-MM_startL; MM_UPDOWN = newTop-MM_startT;
        if (NS){style.left = newLeft + "px"; style.top = newTop + "px";}
        else {style.pixelLeft = newLeft; style.pixelTop = newTop;}
        if (MM_dragJS) eval(MM_dragJS);
        retVal = false; if(!NS) event.returnValue = false;
    } } else if (theEvent == 'mouseup') {
      document.onmousemove = null;
      if (NS) document.releaseEvents(Event.MOUSEMOVE);
      if (NS) document.captureEvents(Event.MOUSEDOWN); //for mac NS
      if (document.MM_curDrag) with (document.MM_curDrag) {
        if (typeof MM_targL =='number' && typeof MM_targT == 'number' &&
            (Math.pow(MM_targL-(MM_getProp(document.MM_curDrag,'L')),2)+
             Math.pow(MM_targT-(MM_getProp(document.MM_curDrag,'T')),2))<=MM_tol) {
          if (NS) {style.left = MM_targL + "px"; style.top = MM_targT + "px";}
          else {style.pixelLeft = MM_targL; style.pixelTop = MM_targT;}
          MM_SNAPPED = true; MM_LEFTRIGHT = MM_startL-MM_targL; MM_UPDOWN = MM_startT-MM_targT; }
        if (MM_everyTime || MM_SNAPPED) eval(MM_dropJS);
        if(MM_dropBack) {style.zIndex = MM_oldZ;}
        retVal = false; if(!NS) event.returnValue = false; }
      document.MM_curDrag = null;
    }
    if (NS) document.routeEvent(objId);
  } return retVal;
}
