// JavaScript Document
//function emailCheck2(){alert('emailCheckReferats');}

function emailCheckReferats (targetCell,targetCell2) {//�������� ������ ��� ������, ��� ������ ��� ������ (������� �����) 

  	//alert ("targetCell.value="+targetCell.value);
	  
	//alert('targetCell.value='+'\n'+targetCell.value+'\ntargetCell.value2='+targetCell.value2);
	if (targetCell2&&targetCell.value&&targetCell2.value&&targetCell.value==targetCell2.value) { 
		
		alert("�������� � ������������� ����� ���������.");
		targetCell.style.backgroundColor="#FFFF00";
		targetCell2.style.backgroundColor="#FFFF00";
		targetCell2.focus();
		return false;
		
	  }
	//����� ��������� ����, ������������ ���������� � ������ e-mail ������������� �������� - Srgg
	cyr = new Array ('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�')
	
	var arrMails=new Array();
	
	arrMails[0]=targetCell;
	
	if (targetCell2&&targetCell2.value) arrMails[1]=targetCell2;  
	
	//alert(arrMails.length);
	
	for (cmls=0;cmls<arrMails.length;cmls++) { //alert('arrMails['+cmls+']');
		
		var emailStr;
		
		emailStr=(arrMails[cmls].value)? arrMails[cmls].value:'';
		
		var mySymbol;
		
		for (i=0; i < cyr.length; i++) { 
		
			if (emailStr.indexOf(cyr[i])!=-1) { 
				mySymbol=1; 
				break; 
			  } //alert(emailStr);
		}
		
		if (mySymbol==1) { 
			alert('������������� �������������\n�������� � ������ e-mail\n�����������!'); 
			arrMails[cmls].focus();
			return false;
		}
		
		//������ ������ ������������ ��� �������� ��������� ������ � ������� user@domain. ����� ������������ ��� �������� ���������� ������ � ������:
		var emailPat=/^(.+)@(.+)$/
		
		/* The following string represents the pattern for matching all special
		characters. We don't want to allow special characters in the address. 
		These characters include ( ) < > @ , ; : \ " . [ ] */
		
		var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
		//��������� ������ ������������ �������, ������������ � ������ ������ ��� ������.
		
		var validChars="\[^\\s" + specialChars + "\]"
		//��������� ������ ��������� ������������ � ������ �������. ��������, �� ��������� ������������ ����� ������: "jiminy cricket"@disney.com
		var quotedUser="(\"[^\"]*\")"
		//������ ������ ��������� ��������� � �������� ������ IP-�����. ����������: � ������ ������ ��������� ��������� IP-����� � ��.������
		var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
		//��������� ������ ������������ "����" - ����� ������������� (����������) ��������
		var atom=validChars + '+'
		/* The following string represents one word in the typical username.
		For example, in john.doe@somewhere.com, john and doe are words.
		Basically, a word is either an atom or quoted string. */
		var word="(" + atom + "|" + quotedUser + ")"
		// The following pattern describes the structure of the user
		var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
		/* The following pattern describes the structure of a normal symbolic
		domain, as opposed to ipDomainPat, shown above. */
		var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
		/* Finally, let's start trying to figure out if the supplied address is
		valid. */
		/* Begin with the coarse pattern to simply break up user@domain into
		different pieces that are easy to analyze. */
		var matchArray=emailStr.match(emailPat)
		//Too many/few @'s or something; basically, this address doesn't even fit the general mould of a valid e-mail address.
		if (matchArray==null) { 
			//alert(targetCell.value);
			var retMess="���� ����������� ����� ����� �����������";
			retMess=(arrMails[cmls]==targetCell2)? "�������������� a"+retMess:"�"+retMess+" ��� �����������";
			retMess+=".";
			alert(retMess)
			return false;
			
		}
		
		var user=matchArray[1]
		var domain=matchArray[2]
		// See if "user" is valid // user is not valid
		if (user.match(userPat)==null) { 
			//goFalse ("��� ������������ ������� ������� ��� �����������.",arrMails[cmls]);
			alert("��� ������������ ������� ������� ��� �����������.");
			return false;
		}
		// if the e-mail address is at an IP address (as opposed to a symbolic host name) make sure the IP address is valid. 
		var IPArray=domain.match(ipDomainPat)
		if (IPArray!=null) { // this is an IP address
			for (var i=1;i<=4;i++) if (IPArray[i]>255) {
				//goFalse ("IP ����� ���������� �������� ��� �����������!",arrMails[cmls]);
				alert("IP ����� ���������� �������� ��� �����������!");
				return false;
			}
		}
		
		// Domain is symbolic name
		var domainArray=domain.match(domainPat)
		if (domainArray==null) {
			//goFalse ("������� ������� ��� ����������� ��� ������.",arrMails[cmls]);
			alert("������� ������� ��� ����������� ��� ������.");
			return false;
		}
		//domain name seems valid, but now make sure that it ends in a three-letter word (like com, edu, gov) or a two-letter word,representing country (uk, nl), and that there's a hostname preceding  the domain or country.
		// Now we need to break up the domain to get a count of how many atoms it consists of.
		var atomPat=new RegExp(atom,"g")
		var domArr=domain.match(atomPat)
		var len=domArr.length
		if (domArr[domArr.length-1].length<2||domArr[domArr.length-1].length>4)  {
			//goFalse ("������!\n����� ����������� ����� ������ �������������:\n----------------------------------------\n3-4 ������� ����� ����� ��� ������;\n���\n2 ������� ����� ����� ��� ������.",arrMails[cmls]);
			alert("������!\n����� ����������� ����� ������ �������������:\n----------------------------------------\n3-4 ������� ����� ����� ��� ������;\n���\n2 ������� ����� ����� ��� ������.");
			return false;
		}
		// Make sure there's a host name preceding the domain.
		if (len<2)  {
			//goFalse ("� ������ ��������� ��� ����������� ��� ��������!",arrMails[cmls]); 
			alert("� ������ ��������� ��� ����������� ��� ��������!");
			return false;
		}
		// If we've gotten this far, everything's valid!
		//return true;
		// End -->
	  }
  
}
