<?
//���������� ���������� ����������, �������������� ������� - zip, letters � �.�. - � ����������� �� ������������ ������� - ���������/��������
//������� (���������/��������):
  //document_root:   // W:/home/localhost/www/referats/
		  			 // /home/rossorig/domains/referats.info/public_html/
  //http_host: 		 //localhost/referats/
		  			 //www.referats.info/
function checkHost(&$document_root,&$http_host) {
//����� ���� � ����������� �������
if ($_SERVER['HTTP_HOST']&&$_SERVER['DOCUMENT_ROOT']) 
  { $http_host=$_SERVER['HTTP_HOST'];
  	$document_root=$_SERVER['DOCUMENT_ROOT'];
  }
//handler2.php
else
  { $http_host="www.referats.info";
    $document_root="/home/rossorig/domains/referats.info/public_html";
  }
if (strstr($_SERVER['HTTP_HOST'],"localhost")) //�� ������������ � handler!!!!, �.�. ��� ������ session_start()
  { $http_host.="/referats";//	http://localhost
	$document_root.="/Referats";// W:/home/localhost/www/Referats/
  } 
$http_host="http://$http_host/";
$document_root="$document_root/";
}
?>