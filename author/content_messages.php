<? 
//����� ���������:
if ($_REQUEST['action']=="compose") $Messages->composeNewMail();
//������� ������ ���������:
else {
	
	//��������� ���������� ���������:
	$Messages->handleOutcomingMessage();
	//��������� ������ ���������:
	$Messages->buildMessListing($rSel,"author",20);

}?>