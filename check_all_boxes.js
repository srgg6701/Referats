// JavaScript Document
arCheckboxes=new Array ();
//генерируем массив чекбоксов (сами переменные прописываются скриптом в body после описания чебокса)
function checkAllBoxes()	{
var def_value;
//переменная для определения отметки чекбокса
var stroke_color;
if (event.srcElement.checked==false) {def_value=false;stroke_color='';}
else	{def_value=true;stroke_color='yellow'}
for (i=0;i<arCheckboxes.length;i++)	{
	document.forms[0].elements[arCheckboxes[i]].checked=def_value;
	document.forms[0].elements[arCheckboxes[i]].parentNode.parentNode.style.backgroundColor=stroke_color;
	}
//отмечаем или разотмечаем все чекбоксы
}