<?
class Navigate {
	function getPageAddress($server_name,$domain_zone) {
		if (strstr($_SERVER['HTTP_HOST'],"localhost")) {
			$address="localhost";
			unset($domain_zone);
		}
		else $address="www.";
		$address.=$server_name.$domain_zone;
		return "http://$address/"; 	
	}
}
?>