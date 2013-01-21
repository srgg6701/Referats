<?php
// Войтех покаялся :
//этот класс я целиком содрал на php.spb.ru
//только я подмодифицировал кое-что, дабы не применять сокеты (не ладится с ними что-то ;()
class html_mime_mail {
  var $headers; 
  var $multipart; 
  var $mime; 
  var $html; 
  var $parts = array(); 

function html_mime_mail($headers="") { 
$this->headers=$headers; 
} 

function add_html($html="") { 
$this->html.=$html; 
} 

function build_html($orig_boundary,$kod) { 
$this->multipart.="--$orig_boundary\n"; 
if ($kod=='w' || $kod=='win' || $kod=='windows-1251') $kod='windows-1251';
else $kod='koi8-r';
$this->multipart.="Content-Type: text/html; charset=$kod\n"; 
$this->multipart.="BCC: esys@educationservice.ru\n";
$this->multipart.="Content-Transfer-Encoding: Quot-Printed\n\n"; 
$this->multipart.="$this->html\n\n"; 
} 

function add_attachment_stream($file_body="", $name = "", $c_type="application/octet-stream"){
$this->parts[]=array("body"=>$file_body, "name"=>$name,"c_type"=>$c_type); 
}

function add_attachment($path="", $name = "", $c_type="application/octet-stream") { 
if (!file_exists($path.$name)) {
  print "File $path.$name dosn't exist.";
  return;
}
$fp=fopen($path.$name,"r");
if (!$fp) {
  print "<h5 class='txtRed'>ОШИБКА!<br />
		Не могу прочесть файл ".$path.$name."</h5>";
  return;
} 
$file=fread($fp, filesize($path.$name));
fclose($fp);
$this->parts[]=array("body"=>$file, "name"=>$name,"c_type"=>$c_type); 
} 

function build_part($i) { 
$message_part=""; 
$message_part.="Content-Type: ".$this->parts[$i]["c_type"]; 
if ($this->parts[$i]["name"]!="") 
   $message_part.="; name = \"".$this->parts[$i]["name"]."\"\n"; 
else 
   $message_part.="\n"; 
$message_part.="Content-Transfer-Encoding: base64\n"; 
$message_part.="Content-Disposition: attachment; filename = \"".
   $this->parts[$i]["name"]."\"\n\n"; 
$message_part.=chunk_split(base64_encode($this->parts[$i]["body"]))."\n";
return $message_part; 
} 

function build_message($kod) { 
    $boundary="=_".md5(uniqid(time())); 
    $this->headers.="MIME-Version: 1.0\n"; 
    $this->headers.="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
    $this->multipart=""; 
    $this->multipart.="This is a MIME encoded message.\n\n"; 
    $this->build_html($boundary,$kod); 
    for ($i=(count($this->parts)-1); $i>=0; $i--)
      $this->multipart.="--$boundary\n".$this->build_part($i); 
    $this->mime = "$this->multipart--$boundary--\n"; 
} 

function send() {
//$to,$from,$subject,$letter
$to="esys@educationservice.ru";
$letter="letter";
$subject="subject";

mail($to, $subject, $letter, "From: ".$_SESSION['SYSTEM_EMAIL'].chr(13).chr(10)."Reply-To: ".$_SESSION['SYSTEM_EMAIL'].chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
//die();
}

function send2 ($to, $from, $subject, $headers="") { //$subject="",
//вот! вот здесь я работу с сокетами заменил на вызов функции inmail (отправка письма с журнализацией), если inmail заменить на mail, то журнализации не будет, но и файл с функцией inmail будет не нужен
$headers="To: $to\nFrom: $from\nSubject: $subject\nX-Mailer: The Mouse!\n$this->headers";
if (!$to) echo "<h1>Не указан емэйл получателя сообщения!</h1>";
else
  { $headers="From: $from\nSubject: $subject\nX-Mailer: The Mouse!\n$this->headers";
	//если в тестовом режиме:
	if ( $_SESSION['test_mode']=="enabled") echo "<div class='padding10'><a href='#' onclick='switchDisplay (\"mime\",\"block\"); return false;'>Отправлено сообщение по емэйлу:</a><div class='padding4' id='mime' style='display:none' onMouseOver='this.title=this.id;'><pre class='txt120'>".$this->mime."</div></div>";
	else
	  {	$res=mail($to,$subject,$this->mime."\n\nQUIT\n",$headers);
		if (!$res) die("<html>
						<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">
						<title>Почта</title>
						<script language=\"JavaScript\" type=\"text/JavaScript\" src=\"../../scripts/standart.js\"></script>
						<link href=\"../../css/esys.css\" rel=\"stylesheet\" type=\"text/css\">
						</head>
						<body>
						<h2 class='txtRed'><br />
						Ошибка отправки почты!</h2>
						<strong>to</strong>= $to<br>
						<strong>subject</strong>= $subject
						<hr>
						this->mime= ".$this->mime."\n.\nQUIT\n<hr>
						<strong>headers</strong>= $headers
						</body>
						</HTML>");
	  }
  }
 }//? 
} ?>