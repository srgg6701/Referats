<? 
//setcookie("user","srgg");
//setcookie("cnt",$c);

//var_dump("<pre>",$_COOKIE,"</pre>");
//
//echo "<hr>";
//
//echo "user= $_COOKIE[user]<br>";
//echo "cnt= $_COOKIE[cnt]<br>";
//$c=$_COOKIE['cnt']+1;
//
//echo "val = $_COOKIE[cnt], $c";
//
//echo "<p>Hello, $_COOKIE[user]! You are here $c time!</p>";
session_start();
require_once('connect_db.php');
//
require_once('classes/class.Actions.php');
$Actions=new Actions;
//
require_once("classes/class.Author.php");
$Author=new Author;
//
require_once('classes/class.Blocks.php');
$Blocks=new Blocks;
//����������� �����, �� �������: if ($work_subject)
require_once('classes/class.Errors.php');
$catchErrors=new catchErrors;
//
require_once('classes/class.Tools.php');
$Tools=new Tools;
//
require_once('classes/class.Worx.php');
$Worx=new Worx;

$end="</body></html>";?>  
<html>
<head>
<title>������� ��������, ������, �������. ���� ���������. </title>
<meta name="description" content="���� ���������, ��������, ��������� �����. ������� ������, ������� �� �����.">
<meta name="keywords" content="���� ���������, ��������, ������, �������, ��������, ������ �� �����, �������� ������ �� ����, ������ ������, �������� ��, ������� �� ����, ����������, �����, ��������, ���������, �����������, �������, ����������, �������� � ��������, ����������, ��������� ���������, ����������, ���������, ��������� ���������, �����������, ���, ���������, ����������� �����, ����������, ����������, ������, �����, ���������">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/border.css" rel="stylesheet" type="text/css">
<link href="css/padding.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/txt.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js.js"></script>
</head>
<body style="font-size:">
<? 
$inbox_variable="\*3-946/";
$pattern="/[^0-9]/";
echo "<div>inbox_variable= $inbox_variable</div>";
echo (preg_match("/[^0-9]/",$inbox_variable))? "FOUND":"NOT FOUND";
echo "<hr>";
echo preg_replace("/[^0-9]/",'',$inbox_variable);

die();
function checkDef($rights="0777"){

	echo "<h3>$rights</h3>";

}
checkDef();
//echo $Tools->clearToIntegerAndStop($_REQUEST['work_id']);
die($end);

$arr=array('one'=>'Один!<br>-<br>один<br>один!','two'=>"два (2)\n",'tree'=>"три\n");
$sArr=serialize($arr);
var_dump("<pre>",$sArr,"</pre>");

echo "<hr>";
$arr=unserialize($sArr);
var_dump("<pre>",$arr,"</pre>");
echo "<hr>";

$st=mktime(0,0,0,10,23,2012);
$st2=time();

echo "<nobr>$st : ".date("Y-m-d", $st)."</nobr><br><nobr>$st2 : ".date("Y-m-d H:i:s",time())."</nobr><hr>";
echo $st-$st2;
$sec=$st-$st2;
$min=round($sec/60);
$hours=round($sec/(60*60));
$days=round($sec/(60*60*24));
echo "<div>LINE: ".__LINE__.", FILE: ".__FILE__."</div>";

function getFuncName() {

	echo "<div>FUNCTION: ".__FUNCTION__."</div>";

}

getFuncName();

class myClass{

	function getMethod() {
	
		echo "<div>FUNCTION: ".__FUNCTION__.", METHOD: ".__METHOD__.", CLASS: ".__CLASS__."</div>";
	}
}

myClass::getMethod();


echo "<hr>";
echo "���/�����/�����/����: $sec / $min / $hours / $days";
echo "<hr>";
define(Def,'Definition is here!');

echo Def;

for ($i=0;$i<5;++$i) {
	if ($i==2) continue
	print "<br>$i<br>";
}

echo <<<LABEL

<p>� ��� ���-�� �����-�� "���������" ���� ������������������� ������....</p>
<p>���� �, �������, ������ �� '���������'...</p>


LABEL;

die($end);
echo "convert= ".$Tools->convertField2CPU( "diplom_worx_topix",
							   "predmet", //��� ����, �������� �������� ���� ��������
							   "pishchevye-produkty", //�������� �������� ��������
							   false //��������� ������������ ���
							 );
echo "<hr>";
echo "convert= ".$Tools->convertField2CPU( "diplom_worx_topix",
							   "predmet", //��� ����, �������� �������� ���� ��������
							   "������� ��������", //�������� �������� ��������
							   1 //��������� ������������ ���
							 );
die($end);
$msize=ini_get('post_max_size');
//var_dump('<pre>',$Worx->getWorkAreaAndTypeConverted(7004),'</pre>');
//var_dump('<pre>',$Worx->getWorkAreaAndTypeConverted(38,true),'</pre>');

echo "max_size: ${msize}!<hr>";
echo $msize{0};
echo "<br>";
echo $msize[1];
//ini_set('post_max_size','10M');

die("<hr>".ini_get('post_max_size'));
echo "<hr>";

$qSel="SELECT * FROM diplom_worx_types"; 
$rSel=mysql_query($qSel);
$catchErrors->errorMessage(1,"","������ ���������� ������","qSel",$qSel);
$sel_rows=mysql_num_rows($rSel);
if ($sel_rows)  {

	while ($arr = mysql_fetch_assoc($rSel)) { 
		
		$number=$Worx->convertWorkTypeData($arr['type']);
		$type=$Worx->convertWorkTypeData($arr['number']);
		
		echo "<div><nobr>Number: $number, Type: $type</nobr>, Latin: ";
		$Worx->convertToLatin($type);
		echo "</div>\n";
	} 
}

$Worx->buildWorxTypesList( $code,
								 $sel_type,
								 $show_worx_values //���������� � ������ �����. ����� ������� ����?
							   );
die("</body></html>");
$warea_name="������� ��������";

$arrQrs=array( $wtype_name=>"SELECT number FROM diplom_worx_types WHERE `type` = '$wtype_name'",
			   $warea_name=>"SELECT number FROM diplom_worx_topix WHERE `predmet` = '$warea_name'"
			 );

foreach($arrQrs as $field=>$query){

	if ($field) {
	
		$rSel=mysql_query($query);
		$catchErrors->errorMessage(1,"","������ ���������� ������, query()","query",$query);
		echo(mysql_num_rows($rSel))?  "<br>".mysql_result($rSel,0,'number')."<br>":"<br>No rows!<br>";
	
	}else echo "<br>No field!</br>";

}
die();
//$arr=array('������','������','������','��������');
foreach($arr as $key=>$val) $vd.="$key=>$val\n";
//$vd="var_dump($arr)";
echo nl2br($vd);?>
</body>
</html>