<?
ini_set('display_errors','on');
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
db_connect();

if($_SERVER['REQUEST_METHOD']=="POST"){
	$id=intval($_POST['id']);
	
	$fpath=ssql("select `file` from `sklad_userfiles` where `id`=$id");
	$fext=ssql("select ext from sklad_userfiles where id=$id");
	$out=file_get_contents($fpath);
	$fname=preg_replace("{.*/}","",$fpath);
header("Content-Type: application/vnd.ms-excel; charset=windows-1251");
header("Content-length: ".filesize($fpath));
header("Content-Disposition: attachment; filename=$fname.$fext");

print $out;
}
exit;    
