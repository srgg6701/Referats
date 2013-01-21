// JavaScript Document
function addHTML (insObj)	{
	var txtAreaName;
	if (document.forms[0].elements['mess']) {txtAreaName='mess';document.forms[0].elements['mess'].value+=insObj+'\n';}

	if (document.forms[0].elements['inmess']) {txtAreaName=2;document.forms[0].elements['inmess'].value+=insObj+'\n';}
//alert (document.forms[0].elements['inmess'].value);
}
