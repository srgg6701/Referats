// JavaScript Document
function checkTargetRow ()	{
if 	(event.srcElement.name!='get_all_checkboxes')	
  {
if (event.srcElement.type=='checkbox'&&event.srcElement.className.indexOf('Filter')==-1) 
	{
	if (event.srcElement.checked==true) event.srcElement.parentNode.parentNode.style.backgroundColor='yellow'; 
	else event.srcElement.parentNode.parentNode.style.backgroundColor='';	
	}
  }
}
function delSelect(targForm,targOpt,fAction)
{var userMess;
  targForm.elements[targOpt].value=fAction;
  //Определяет действие с сообщением - удалить или переместить в архив
  if (fAction=='delete') userMess='удалить отмеченное сообщение (сообщения)?';
  if (fAction=='archive') userMess='переместить отмеченное сообщение (сообщения) в архив?';
  if (confirm("Вы уверены, что хотите "+userMess)) targForm.submit();
  //Если соглашаемся с запросом, выполняет выбранное действие - удаляет сообщение или перемещает его в архив
}
document.onclick=checkTargetRow;
