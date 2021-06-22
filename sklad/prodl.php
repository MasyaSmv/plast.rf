<?
ini_set('display_errors','on');
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
db_connect();

if($_SERVER['REQUEST_METHOD']=="GET"){
	$id=intval($_GET['uid']);
    
	$q="UPDATE  sklad_tovar SET date_cr=date_add( date_cr , INTERVAL 5 DAY) where comp_id=$id";
	mysql_query($q);
	header("Location: ".$_SERVER['HTTP_REFERER']);	
	exit;    
}