<? //шлюз для выполнения фоновых запросов (iFrame)
session_start(); 
require_once("../connect_db.php");
require_once("../classes/class.Errors.php");
require_once("../classes/class.Messages.php");
$catchErrors=new catchErrors;
$Messages=new Messages;
$Messages->queryMessBackgroundGateway();?>