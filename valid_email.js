// JavaScript Document

function emailCheckReferats (focusTarget) {
//focusTarget - ������ ��� ����� ������
//����� ��������� ����, ������������ ���������� � ������ e-mail ������������� �������� - Srgg
cyr = new Array ('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�')
	var mySymbol;
		for (i=0; i < cyr.length; i++)
 		{
		if (focusTarget.value.indexOf(cyr[i])!=-1)	
			{
			mySymbol=1; 
			break; 
			}
		}
		if (mySymbol==1) 
		{ 
		alert('������������� �������������\n�������� � ������ e-mail\n�����������!'); 
		focusTarget.select();    return false;
		}

/* The following pattern is used to check if the entered e-mail address
fits the user@domain format. It also is used to separate the username
from the domain. 

������ ������ ������������ ��� �������� ��������� ������ � ������� user@domain
����� ������������ ��� �������� ���������� ������ � ������ */

var emailPat=/^(.+)@(.+)$/

/* The following string represents the pattern for matching all special
characters. We don't want to allow special characters in the address. 
These characters include ( ) < > @ , ; : \ " . [ ] */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"

/* The following string represents the range of characters allowed in a 
username or domainname. It really states which chars aren't allowed. 

��������� ������ ������������ �������, ������������ � ������ ������ ��� ������. */

var validChars="\[^\\s" + specialChars + "\]"

/* The following pattern applies if the "user" is a quoted string (in
which case, there are no rules about which characters are allowed
and which aren't; anything goes). E.g. "jiminy cricket"@disney.com
is a legal e-mail address. 

��������� ������ ��������� ������������ � ������ �������. ��������, �� ��������� ������������ ����� ������: "jiminy cricket"@disney.com */

var quotedUser="(\"[^\"]*\")"

/* The following pattern applies for domains that are IP addresses,
rather than symbolic names. E.g. joe@[123.124.233.4] is a legal
e-mail address. NOTE: The square brackets are required. 

������ ������ ��������� ��������� � �������� ������ IP-�����
����������: � ������ ������ ��������� ��������� IP-����� � ��.������ */

var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/

/* The following string represents an atom (basically a series of
non-special characters.) 

��������� ������ ������������ "����" - ����� ������������� (����������) �������� */

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

var matchArray=focusTarget.value.match(emailPat)

if (matchArray==null) {

/* Too many/few @'s or something; basically, this address doesn't
even fit the general mould of a valid e-mail address. */

alert("Email ����� ������ ����������� ��� �����������")
focusTarget.select();    return false;
}

var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid 
if (user.match(userPat)==null) {
// user is not valid
alert("��� ������������ ������� ������� ��� �����������.")
focusTarget.select();    return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
// this is an IP address
for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("IP ����� ���������� �������� ��� �����������!")
focusTarget.select();    return false;
}
}
return true
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
alert("������� ������� ��� ����������� ��� ������.")
return false
}

/* domain name seems valid, but now make sure that it ends in a
three-letter word (like com, edu, gov) or a two-letter word,
representing country (uk, nl), and that there's a hostname preceding 
the domain or country. */

/* Now we need to break up the domain to get a count of how many atoms
it consists of. */
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 ||domArr[domArr.length-1].length>3) 
	{

	if (domArr[domArr.length-1]!="info")
{
// the address must end in a two letter or three letter word.
alert("������!\n����� ������ �������������:\n----------------------------------------\n3 ������� ����� ����� ��� ������;\n���\n2 ������� ����� ����� ��� ������;\n���\n�� \".info\".")
return false
}
	}

// Make sure there's a host name preceding the domain.
if (len<2) {
var errStr="� ������ ��������� ��� ����������� ��� ��������!"
alert(errStr)
return false
}
// If we've gotten this far, everything's valid!
return true;
}
// End -->