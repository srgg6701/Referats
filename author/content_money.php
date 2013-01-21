<? 
require_once("../classes/class.Manager.php");
$Manager=new Manager; //нужно для извлечения имени автора выплаты
$Money->buildPayoutsTable($_SESSION['S_USER_ID']);?>