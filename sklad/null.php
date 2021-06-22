<?
ini_set('display_errors','on');
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
db_connect();

if($_SERVER['REQUEST_METHOD']=="GET"){
	$cid=intval($_GET['clear']);
	$q="delete from sklad_free_access where c_id=$cid";
	mysql_query($q);
	header("Location: ".$_SERVER['HTTP_REFERER']);	
	exit;    
}