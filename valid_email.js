// JavaScript Document

function emailCheckReferats (focusTarget) {
//focusTarget - ячейка для ввода емэйла
//Автор фрагмента кода, проверяющего отсутствие в записи e-mail кириллических символов - Srgg
cyr = new Array ('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ы','ъ','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Э','Ю','Я')
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
		alert('Использование кириллических\nсимволов в записи e-mail\nнедопустимо!'); 
		focusTarget.select();    return false;
		}

/* The following pattern is used to check if the entered e-mail address
fits the user@domain format. It also is used to separate the username
from the domain. 

Данный шаблон используется для проверки введённого адреса в формате user@domain
Также используется для проверки разделения логина и домена */

var emailPat=/^(.+)@(.+)$/

/* The following string represents the pattern for matching all special
characters. We don't want to allow special characters in the address. 
These characters include ( ) < > @ , ; : \ " . [ ] */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"

/* The following string represents the range of characters allowed in a 
username or domainname. It really states which chars aren't allowed. 

Следующий скрипт представляет символы, недопустимые в записи логина или домена. */

var validChars="\[^\\s" + specialChars + "\]"

/* The following pattern applies if the "user" is a quoted string (in
which case, there are no rules about which characters are allowed
and which aren't; anything goes). E.g. "jiminy cricket"@disney.com
is a legal e-mail address. 

Следующий шаблон позволяет использовать в логине кавычки. Например, не запрещено использовать такую запись: "jiminy cricket"@disney.com */

var quotedUser="(\"[^\"]*\")"

/* The following pattern applies for domains that are IP addresses,
rather than symbolic names. E.g. joe@[123.124.233.4] is a legal
e-mail address. NOTE: The square brackets are required. 

Данный шаблон позволяет указывать в качестве домена IP-адрес
Примечание: в данном случае требуется заключить IP-адрес в кв.скобки */

var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/

/* The following string represents an atom (basically a series of
non-special characters.) 

Следующий скрипт представляет "атом" - набор неспециальных (допустимых) символов */

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

alert("Email адрес введен некорректно или отсутствует")
focusTarget.select();    return false;
}

var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid 
if (user.match(userPat)==null) {
// user is not valid
alert("Имя пользователя введено неверно или отсутствует.")
focusTarget.select();    return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
// this is an IP address
for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("IP адрес назначения неверный или отсутствует!")
focusTarget.select();    return false;
}
}
return true
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
alert("Неверно введено или отсутствует имя домена.")
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
alert("Ошибка!\nАдрес должен заканчиваться:\n----------------------------------------\n3 буквами после точки для домена;\nили\n2 буквами после точки для страны;\nили\nна \".info\".")
return false
}
	}

// Make sure there's a host name preceding the domain.
if (len<2) {
var errStr="У адреса пропущено или отсутствует имя хостинга!"
alert(errStr)
return false
}
// If we've gotten this far, everything's valid!
return true;
}
// End -->