<?
if($_SERVER['HTTP_REFERER']==""){
        header("Location: /",true,302);
        exit;
}
include("inc/func.inc");
$id=intval($_GET['id']);
if(!isset($id))
{
	$id="error";
	$string="error1";
}

if($id!=="error")
{
	db_connect();
	$query="SELECT email FROM company WHERE id='$id'";
	$result=mysql_query($query);
	if(mysql_num_rows($result)>0){
		$string=mysql_result($result,0,0);
	}
	else
		$string="error2";
}

$len=strlen($string);
$x=$len*8;
$y=19;
$im=imageCreate($x,$y);

$color_ffffff=imageColorAllocate($im,255,255,255);
$color_000066=imageColorAllocate($im,0,0,102);

imageFill($im,0,0,$color_ffffff);
imageString($im,4,0,0,$string,$color_000066);

Header("Content-type: image/png");
imagePNG($im);
imageDestroy($im);

?>
