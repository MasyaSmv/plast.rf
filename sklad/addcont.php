<?
ini_set('display_errors','on');
$where_am_i="sklad";
include("../droot.php");
include_once("$DOCUMENT_ROOT/$document_admin/config.php");
include_once("$DOCUMENT_ROOT/func.inc");
$site_nav[]=array("name"=>"Склад - Добавление и редактирование контактных данных</a>","url"=>"/$document_admin/sklad/addcont.php");

db_connect();
if($_SERVER['REQUEST_METHOD']=="POST"){
	if($_POST['action']=="edit"){
		$q="update sklad_contact set fio='".$_POST['fio']."', phone='".$_POST['phone']."', fax='".$_POST['fax']."', email='".$_POST['email']."' where cid=".$_POST['cid']." limit 1";	
	}else{
		$q="insert into sklad_contact set cid=".$_POST['cid'].", fio='".$_POST['fio']."', phone='".$_POST['phone']."', fax='".$_POST['fax']."', email='".$_POST['email']."'";		
	}
	mysql_query($q);
	header("Location: ".$_POST['loc']);
	exit;
}else{
	if($_GET['action']=="edit"){
		$z=@sql("select fio,phone,fax,email from sklad_contact where cid=".$_GET['cid']);
		foreach($z as $zz){
			list($fio,$phone,$fax,$email)=$zz;
		}
	}elseif($_GET['action']=="del"){
		mysql_query("delete from sklad_contact where cid=".$_GET['cid']." limit 1");
		header("Location: ".$_GET['loc']);
		exit;
	}else{
		$fio=$phone=$fax=$email="";
	}
}
include("$DOCUMENT_ROOT/$document_admin/top.php");
?>
<style>
table tr td {font-size:12px;}
.form, .form td{
	border-collapse: collapse;
	border: 1px solid #7E89B1;
	padding:5px;
	font-size: 12px;
}
.red{
	color:red;
}
.none_bord{
	border:none;
}
.none_bord td{
	border:none;
}
.form a{
	font-size: 12px;
}
</style>
<form method="POST">
<table border=0 width=50% cellpadding=3 cellspacing=1 class=color1>
<tr class=color4><td colspan=2>
<?
if($_GET['action']=="edit"){ print "Редактирование"; }else{print "Добавление";}
?> контактных данных по компании <?=$_GET['title']?>
</td></tr>
<tr class=color4><td width=150 valign=top>ФИО</td><td><input type=text name=fio value='<?=$fio?>'></td></tr>
<tr class=color4><td width=150 valign=top>Телефон</td><td><input type=text name=phone value='<?=$phone?>'></td></tr>
<tr class=color4><td width=150 valign=top>Факс</td><td><input type=text name=fax value='<?=$fax?>'></td></tr>
<tr class=color4><td width=150 valign=top>email</td><td><input type=text name=email value='<?=$email?>'></td></tr>
<tr class=color4><td colspan=3><input type=submit value="Добавить"></td></tr>
</table>
<input type=hidden name=action value='<?=$_GET['action']?>'>
<input type=hidden name='cid' value='<?=$_GET['cid']?>'>
<input type=hidden name='loc' value='<?=$_GET['loc']?>'>
</form>

<?
include("$DOCUMENT_ROOT/$document_admin/bottom.php"); 
?>


