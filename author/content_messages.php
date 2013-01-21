<? 
//новое сообщение:
if ($_REQUEST['action']=="compose") $Messages->composeNewMail();
//вывести список сообщений:
else {
	
	//обработка исходящего сообщения:
	$Messages->handleOutcomingMessage();
	//построить список сообщений:
	$Messages->buildMessListing($rSel,"author",20);

}?>