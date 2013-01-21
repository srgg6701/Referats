<?php
class mail_parser {

	var $letter;

	function setLetter($letter) {
		$this->letter=$letter;
	}
	
	function getBody() {
		
		$letter=str_replace(chr(10),chr(13),$this->letter);
//		echo("<table border=1 bordercolor='#ff0000'><tr><td>$letter</td></tr></table>");

		$p0=strpos($letter, 'This is a multi-part message in MIME format');
		if($p0===false){
			//обычное письмо
			$p0=strpos($letter,(chr(13).chr(13).chr(13)));
			$letter = substr($letter,$p0+1,strlen($letter));
		}else{ //мультипартовое письмо
			$s='';
			$p0=strpos($letter, '------=_NextPart_');
			while(!$p0===false){
				//выдернуть кусочек
				//найти конец
				//концом считаем следующий ------=_NextPart_
				//или если такового нет, то просто конец письма
			$p1=strpos($letter, '------=_NextPart_', $p0+10);
			if($p1===false){$p1=strlen($letter);}
			$fragment=substr($letter, $p0, $p1-$p0);
			$letter=substr($letter,$p1,strlen($letter));
			$this->recode($fragment);
			$s.=$fragment;
			$p0=strpos($letter, '------=_NextPart_');
		}
			$this->recode($letter);
			$letter = $s.$letter;
	}

		$p0=strpos($letter, "------==--bound.");
		if(!($p0===false)) {
			$letter = substr($letter,0,$p0);
		}
//		echo("<table border=1><tr><td>$letter</td></tr></table>");
		return $letter;
	}
	
	function getAttachList(&$list) {
		$detach=str_replace(chr(10),chr(13),$this->letter);
		$i=0;
		$detach=str_replace(' ', '', $detach);
		$p0=strpos($detach,'filename="');
		while($p0>0){
			$detach=substr($detach,$p0+10,strlen($detach));
			$p0=strpos($detach,'"');
			$filename=substr($detach,0,$p0);
			if($filename!=''){
				$list[$i]=$filename;
				$i++;
			}
			$p0=strpos($detach,chr(13).chr(13));
			$detach=substr($detach,$p0+2,strlen($detach));
			$p0=strpos($detach, "------==--bound.");
			$detach=substr($detach,$p0+16,strlen($detach));
			$p0=strpos($detach,'filename="');
		}
	}
	
	function getAttachById($id) {
		$res='';
		$detach=str_replace(chr(10),chr(13),$this->letter);
		$p0=strpos($detach,(chr(13).chr(13).chr(13)));
		$detach=substr($detach,$p0+1,strlen($detach));
		$p0=strpos($detach, "------==--bound.");
		$detach=substr($detach,$p0+16,strlen($detach));
		$i=0;
		while($p0>0){
			$p0=strpos($detach,'filename="');
			$detach=substr($detach,$p0+10,strlen($detach));
			$p0=strpos($detach,'"');
			$filename=substr($detach,0,$p0);
			$p0=strpos($detach,chr(13).chr(13));
			$detach=substr($detach,$p0+2,strlen($detach));
			$p0=strpos($detach, "------==--bound.");
			if(strlen($filename)>0 && strlen($detach)>0 && $i==$id){
				$res=base64_decode(substr($detach,0,$p0));
			}
			$detach=substr($detach,$p0+16,strlen($detach));
			$p0=strpos($detach, "------==--bound.");
			$detach=substr($detach,$p0+16,strlen($detach));
			$i++;
		}
		return $res;
	}
	
	function recode(&$s) {
		$p0=strpos($s,'Content-Transfer-Encoding: base64');
		if(!$p0===false){$t='base64';}
		$p0=strpos($s,'Content-Transfer-Encoding: quoted-printable');
		if(!$p0===false){$t='quoted-printable';}
		
		$p0=strpos($s,'charset="koi8-r"');
		if(!$p0===false){$koi8=true;}else{$koi8=false;}
		
		$p0=strpos($s,'Content-Type: text/plain');
		if(!$p0===false){$nlbr=true;}else{$nlbr=false;}
		
		if($t=='base64'){
			$p0=strpos($s,'base64');
			$s=substr($s,$p0+6,strlen($s));
			$s=base64_decode(trim($s));
		}
		if($t=='quoted-printable'){
			$p0=strpos($s,'quoted-printable');
			$s=substr($s,$p0+16,strlen($s));
			$s=quoted_printable_decode($s);
		}
		if($koi8){$s=convert_cyr_string($s,'k','w');}
		if($nlbr){$s=nl2br($s);}
	}
} ?>