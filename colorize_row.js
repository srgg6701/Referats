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
  //���������� �������� � ���������� - ������� ��� ����������� � �����
  if (fAction=='delete') userMess='������� ���������� ��������� (���������)?';
  if (fAction=='archive') userMess='����������� ���������� ��������� (���������) � �����?';
  if (confirm("�� �������, ��� ������ "+userMess)) targForm.submit();
  //���� ����������� � ��������, ��������� ��������� �������� - ������� ��������� ��� ���������� ��� � �����
}
document.onclick=checkTargetRow;
