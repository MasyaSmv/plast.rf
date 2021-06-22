<?
ini_set('display_errors','on');
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
db_connect();

if($_SERVER['REQUEST_METHOD']=="GET"){
	$id=intval($_GET['uid']);
	$q="delete from sklad_tovar where comp_id=$id";
	mysql_query($q);
	header("Location: ".$_SERVER['HTTP_REFERER']);	
	exit;    
}