// JavaScript Document
function sh_content(objContent)	{
if (document.getElementById(objContent).style.display=='none') 
{document.getElementById(objContent).style.display='block';event.srcElement.innerText='Скрыть содержание работы';}
else {document.getElementById(objContent).style.display='none';event.srcElement.innerText='Отобразить содержание работы';}
}
