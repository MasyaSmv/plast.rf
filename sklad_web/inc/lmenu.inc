<?
if($PANEL!=1){exit;}
$menuId=intval($menuId);

$menu=array(
	"Маркет" => array(
		70 => array("/user/assets.html","Список товаров"),
		30 => array("/user/position_add.html","Добавить товар"),
		20 => array("/user/price.html","Импорт данных из Excel"),
		10 => array("/user/group.html","Операции с группами товаров"),		
		40 => array("/user/price-help.html","Справка по разделу","i"),		
	),
	"Спецпредложения" => array(
		50 => array("/user/speclist.html","Список спецпредложений"),
		60 => array("/user/spec-help.html","Справка по разделу","i"),
	
	),	
	"Персональное" => array(
		80 => array("/user/contact/","Контактные данные"),
		90 => array("/user/notebook.html","Мой список покупок"),
		//100 => array("/user/uved.html","Уведомления"),
	)
);
$c=0;

foreach($menu as $menuitem => $menucontent){
	if($market_cid != "" || $c>1){
		print $menuitem.'<ul style="list-style:none;line-height:1.5;margin-left:0px;margin-top:5px; padding-left:0px;">';
			foreach($menucontent as $menuIdbase => $menucontentcontent){
				$i1=$i2="";
				if($menucontentcontent[2]=="i"){
					$i1="<i>";
					$i2="</i>";
				}
				if($menuId!=$menuIdbase){				
					print "<li><a href='".$menucontentcontent[0]."'>".$i1.$menucontentcontent[1].$i2."</a></li>\n";
				
				}else{
					print "<li><a href='".$menucontentcontent[0]."' style='color:#ff0000;'>".$i1.$menucontentcontent[1].$i2."</a></li>\n";		
				}
			}
		print "</ul>";
	}
	$c++;
}



if($_SESSION['company_id']!=""){
	$manager=@ssql("select manager_id from company where id=".$_SESSION['company_id']);
	if($manager!=""){
		$r=sql("select fio, phone_mob, phone_work, phone_work_int, emails, icq, skype, jabber from staff where active=1 and manager=1 and id > 2 and id=$manager limit 0,1");
		if(sizeof($r)>0){
			foreach($r as $rr){
				list($mfio, $mphone_mob, $mphone_work, $mphone_work_int, $memails, $micq, $mskype, $mjabber)=$rr;
			}
		
?>	
<div id="predl_on_market" style="background-color: #B7B7B7;padding:1px; margin-top:20px;">
<div class="predl_on_market2" style="background-color: #F7F7F7;padding:8px;font-size:12px; line-height:16px; " data-corner="top 8px" >Ваш персональный менеджер на Market.RusCable.Ru:</div> 
<div class="predl_on_market2" style="background-color: #fff;" data-corner="bottom 8px">
<p style=" font-size:12px; line-height:16px; padding:10px; margin:0px;">
		<span style="color:#FE5A24;"><b><?=$mfio?></b></span>
		<br><br>
		<span style="color:#0079C2;">Рабочий телефон:</span>
		<br>
		<?=$mphone_work?>, добавочный <?=$mphone_work_int?><br><br>
		<?
			if($mphone_mob != ""){
			?>
			<span style="color:#0079C2;">Мобильный телефон:</span>
			<br>
			<?=$mphone_mob?><br><br>
			<?
			}
		?>
		
		<?
			if($memails != ""){
			?>
			<span style="color:#0079C2;">Email:</span>
			<br>
			<a href="mailto:<?=$memails?>" style="color:black;"><?=$memails?></a><br><br>
			<?
			}
		?>
		<?
			if($micq != ""){
				$micq=preg_replace("/[^0-9]/","",$micq);
			?>
			<span style="color:#0079C2;">ICQ:</span>
			<br>
			<?=$micq?> <a href="http://www.icq.com/whitepages/cmd.php?uin=<?=$micq?>&action=message"><img src="http://status.icq.com/online.gif?icq=<?=$micq?>&img=5" border=0></a>

			<br><br>
			<?
			}
		?>
		<?
			if($mskype != ""){
			?>
			<span style="color:#0079C2;">Skype:</span>
			<br>
			<?=$mskype?><br><br>
			<?
			}
		?>
<span style="color:#FE5A24;">Обращайтесь за консультацией по любым услугам Маркета!</b>
		</p>
		
		</div>
		</div> 

	
<?
		}
	}
}

?>