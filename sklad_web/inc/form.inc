<script>
$(document).ready(function(){
$('#stext').keyup( function() {
		if($('#stext').val()==""){
			$('#suggest').css('padding','0');
			$('#suggest').css('display','none');
		}else{
			if($("input:checked").length >0){
				$('#suggest').css('display','block');
				$f="data=" + unescape($('#stext').val());

				$.ajax({
				type: "GET",
				url: "/suggest.php",
				data: $f,
				contentType: "application/x-www-form-urlencoded",
				success: function(data){
				$('#suggest').html(data);
				$('#suggest').css('display','block');
				$('#suggest').css('border','1px solid #0079c2');
				$('#suggest').css('z-index','1000');
				$('#suggest').css('background','#ffffff');
				$('#suggest').css('padding','10px');
				$('#suggest').css('position','relative');
				$('#suggest').css('top','15px');
				}
				});
			}
		}

});
});
</script>
<?
$ppageout="";
$ppage=array(30,50,100,500);
foreach($ppage as $ppage1){
	if($perpage==$ppage1){
		$ppageout.=" $ppage1 ";
	}else{
		$ppageout.=" <a href='/setrecordsperpage$ppage1'>$ppage1</a> ";
	}
}
$ppageout="&nbsp;&nbsp;&nbsp;Позиций на странице: $ppageout";
$examples=array(
'3х150',
'ААБл',
'АВВГ',
'АВВГнг-LS 5х120',
'АПвБбШп',
'АПвБбШп 4х120',
'АСБ',
'ВВГнг 4х16',
'ВВГнг-FRLS',
'КПСВВ',
'КУПЭВ 2х2',
'СИП',
'КПСВВнг-LS');
$e1=$e2=$e3=$e4=$e5=0;
while($e1==$e2 || $e1==$e3 || $e1==$e4 || $e1==$e5 || $e2==$e3 || $e2==$e4 || $e2==$e5 || $e3==$e4 || $e3==$e5 || $e4==$e5){
	$e1= rand ( 0, sizeof($examples)-1 );
	$e2= rand ( 0, sizeof($examples)-1 );
	$e3= rand ( 0, sizeof($examples)-1 );
	$e4= rand ( 0, sizeof($examples)-1 );
	$e5= rand ( 0, sizeof($examples)-1 );
}
$exstr=<<<EXSTR
<a href="/$examples[$e1]">$examples[$e1]</a>,
<a href="/$examples[$e2]">$examples[$e2]</a>,
<a href="/$examples[$e3]">$examples[$e3]</a>,
<a href="/$examples[$e4]">$examples[$e4]</a>,
<a href="/$examples[$e5]">$examples[$e5]</a>
EXSTR;
?>
<form action="/poisk/" name="poisk">
<table width=100% style="background-color: #f2f2f2">
<tr>
	<td valign="middle" width=90% style="padding-left: 30px;">
	<div style='float:right'>
<?
/*	if($authorized > 0){
			print "<div id='note' style='margin:20px 30px 0px 0px'></div>";
		}
*/
?>
	</div>
		<div class="search">
		<br>
			<h1 class=ord>Поиск кабеля из наличия<? if($_SESSION['informer_comp_name']!=""){print " со СКЛАДА ".$_SESSION['informer_comp_name'];}?>:</h1>
			<input type="text" id="stext" name="stext" value="<?=$ruri?>" class="rcSearchInput" style=" width: 95%; " placeholder="Ищите по марке, маркоразмеру, сечению, примеры запросов приведены ниже"/><input type="submit" value="&nbsp;" id="searchButton" class="rcSearchButton">
</td></tr>
<tr><td style="padding-left: 30px;"> <!--style="border-bottom: 1px solid #929292;"-->
<div style='height: 30px;margin-top: 10px;'>
			<div id="suggest"></div>
			<span >Например: <?=$exstr?></span>	<span style='position: relative; left: 40px;'><input type=checkbox name=smart> &larr;умный поиск (<a href='javascript:void(0);' id="whatis" title="<p><b>Умный поиск</b><br>
Начните вводить марку кабеля и умный поиск подскажет Вам какие похожие марки есть на СКЛАДе. А потом просто кликните по наиболее подходящему результату. Точность запроса экономит Ваше время!<br><b>Снимите галочку, если хотите пользоваться обычным поиском.</b></p>">что это?</a>)
		</span><span style='float:right; padding-right: 25px;'><?=$ppageout?></span>
		</div>
</td>
</tr>
</table>
</form>
<script>
if(document.getElementById('stext')) document.getElementById('stext').focus();
</script>