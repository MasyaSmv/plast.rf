<?

header("Location: /prodavcu",true,302);

//setlocale(LC_ALL, 'ru_RU.CP1251');
include_once("../inc/func.inc");
$title_tag="Кабель  и провод из наличия  - СКЛАД :: Продавцам";
$navpage="add";
$text1="";
$txt="";
$company=array();
$page_dir="";
$dopurl="";
$gor=array();
$out="";
$ruri="";
$firtLevelMenuId=300;

include_once("../inc/header.inc");


?>



<table width="100%">
<tr>
	<td width="70%" valign=top>

		<h1>Продавцам</h1>

		<p>Сервис SKLAD.RusCable.Ru является незаменимым помощником в реализации продукции из наличия на складе Вашей организации.
		Разместив  в системе свою складскую справку абсолютно бесплатно, Вы получите максимальное внимание со стороны многотысячной аудитории портала RusCable.Ru.
		<br>
		Теперь не Вы будете искать покупателей, а они Вас!
		<h2>Как добавить склад</h2>

		<p>Чтобы разместить свои остатки кабельно-проводниковой продукции на нашем сайте нужно:</p>
		<ol>
			<li style="margin-bottom: 10px;">Подготовить файл формата Excel (.xls, .xlsx) с четырьмя колонками: наименование, количество, единица измерения, остатки по кускам (если есть).
			</li>

			<li style="margin-bottom: 10px;">
			<? if($authorized > 0): ?>
				В меню Вашего Личного кабинета (если Вы прошли регистрацию)  выбрать пункт  "Склад" &gt; <a href="http://www.ruscable.ru/users/sklad_ost.html">"Размещение остатков"</a> и загрузить подготовленный файл, воспользовавшись формой для загрузки.


			<? else: ?>
				<a href="http://www.ruscable.ru/users/registr.html" target=_new>Зарегистрироваться</a> на RusCable.Ru, затем в "Личном кабинете" выбрать раздел "Склад" &gt; "Размещение остатков", и отправить этот файл нам.
			<? endif; ?>
			</li>
		</ol>
		Для поддержания актуальности необходимо обновлять информацию в системе <b>НЕ РЕЖЕ одного раза в 14 дней</b>.

		<div style="background: #eee; padding: 5px 10px 5px 15px; margin-left:0; margin-top: 10px;">
		<p style="font-size:90%;"><b>Если Вы еще не зарегистрированы на RusCable.Ru:</b><br>
		<p style="font-size:90%;">Подготовьте файл в формате Word (.doc,.docx) с реквизитами вашего предприятия
		и кратким описанием его деятельности (производство, оптовая торговля, розничная торговля и т.д.), а также укажите
		ответственное лицо по работе с системой и контактное лицо (ФИО, раб. телефон, сот. телефон, ICQ, e-mail),
		которое будет указано на странице вашей организации.


		</p>
		<p style="font-size:90%;">Направьте оба файла (остатки в формате Excel и описание предприятия в формате Word) по адресу
		<a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a>
		</p>
		</div>

		<br>
		<h2>ВНИМАНИЕ!</h2>
		В настоящий момент идет тестовый период автоматического обновления складской справки.
		Уточнить возможность подключения можно у специалиста службы по адресу <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a>.
		<br>		<br>
		<h2>Дополнительная информация по работе с системой SKLAD.RusCable.Ru</h2>

		<p>Информация на СКЛАДЕ обновляется в течение одного рабочего дня.
		После размещения на Ваш контактный e-mail поступит подтверждение о размещении.
		В процессе работы, все уведомления с рекомендациями о своевременном обновлении информации, Вы также будете получать на контактный <nobr>e-mail</nobr>.</p>

		<p>Вынуждены предупредить о возможных санкциях за предоставление недостоверной или устаревшей информации: первый раз – предупреждение, полное исключение из системы SKLAD.RusCable.Ru в случае повторения.</p>

		<p><strong>Наша цель &mdash; предоставить потенциальным потребителям самую свежую,
		актуальную информацию, это в интересах каждой из сторон, участвующих на SKLAD.RusCable.Ru.</strong></p>
		<br>


	</td>
	<td width="5%">
		&nbsp;
	</td>
	<td style='padding:5px;vertical-align:top;'>
		<div style='background: #eee;margin-top:64px'>
		<p><img src=/img/info.png align=left ><i>Образец файла Excel (.xls, .xlsx) с остатками КПП, который надо отправить на email <a href="mailto:sklad@ruscable.ru">sklad@ruscable.ru</a> для размещения.<br>
		Структура файла - четыре колонки: наименование, количество, единица измерения, остатки по кускам (если есть).</i></p>
		<p><img src=/img/exmpl2.jpg></p>
		</div>
		<br>
		<h2>Не упустите возможности выделить Вашу организацию среди конкурентов!</h2>
<p>Установите информер "Склад on-line" на страничку Вашего корпоративного сайта. Информер является визуальным отображение краткой справки о состоянии складского наличия в реальном времени. Важным дополнением опции является указание того, что данные о наличии проверены порталом RusCable.Ru.
Установка информера – бесплатна. Код для установки находится одноименном разделе Вашего Личного кабинета.  </p>
		<center><img src=http://www.ruscable.ru/news/images/big-63074-1.jpg></center>

	</td>
</tr>
</table>
<?
include_once("../inc/footer.inc");
?>
