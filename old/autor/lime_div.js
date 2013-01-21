// JavaScript Document
currentPoint=new Array ('ed_works_ed','applications','worx','applications_paid4','applications_paid5','applications_paid6','my_messages','my_param','help','faq','feedback','home');
function colorizePoint (div_id) {
var wTarget=window.top.topFrame.document;
//<body> авторского меню
for (i=0;i<currentPoint.length;i++) 
	{
	if (div_id!=currentPoint[i]) wTarget.getElementById(currentPoint[i]).style.backgroundColor='';
	else wTarget.getElementById(currentPoint[i]).style.backgroundColor='lime';
	}
}
