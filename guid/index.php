<? include("../header.php");
?>
<?
## СПРАВОЧНИК КПП 2.0 -------------------------------------
##
## Переработанный в структурном плане справочник.
## Использованы прежние данные, но переформатированы.
##
## ОСНОВНЫЕ НОВОВВЕДЕНИЯ
##
## 2.0
## + Глобальная переделка справочника
## + Вся информация помещена в БД
## + Каждая марка имеет собственную страницу
## + Перенесена в базу и вся остальная справочная инф-я о
##   КПП (теоретические основы, материалы и т.п.)
## + Привязка информации к компаниям
## + Добавление отрисованных для нас изображений кабелей
## + Полностью переформатированный вывод информации
## + Документирование основных моментов разработки

$incRightBlock = "info";
$menuId        = 514;
include("../dbconnect.php");
// db_connect();

//
// Переменные ---------------------------------------------
//

$base_dir      = '/info/polimer'; // директория раздела
$navArray      = array(
				//	array(
				//		'url'   => '/info/general/',
				//		'title' => 'Справочная информация по КПП',
				//		'img'   => 'general'
				//	),
					array(
						'url'   => $base_dir.'/',
						'title' => 'Технический справочник по КПП',
						'img'   => 'cable'
					),
					array(
						'url'   => $base_dir.'/group/',
						'title' => 'Группы кабельно-проводниковой продукции',
						'img'   => 'group'
					),
					array(
						'url'   => $base_dir.'/zavod/',
						'title' => 'Продукция заводов-производителей КПП',
						'img'   => 'zavod'
					),
				//	array(
				//		'url'   => $base_dir.'/company/',
				//		'title' => 'Организации предоставившие информацию',
				//		'img'   => 'company'
				//	),
					array(
						'url'   => $base_dir.'/mark/',
						'title' => 'Алфавитный указатель',
						'img'   => 'mark'
					)
				);


$subdir_list   = array('group', 'zavod', 'company', 'mark'); // список возможных поддиректорий после '/info/cable/'
$page_subdir   = ''; // текущая поддиректория из переменной $url_list
$page_filename = ''; // главный индекс всегда без имени файла!!!

//
// Обрабатываем URL ---------------------------------------
//

// $page_url      = $_SERVER['SCRIPT_URL'];
// if(substr($page_url,-1) != '/') $page_url .= '/';
// $page_url_arr  = explode('/', $page_url);
// array_shift($page_url_arr);
// array_pop($page_url_arr);

if(!isset($page_url_arr[2]) || $page_url_arr[2] == 'index.html') // главная
	$page_filename = '';
elseif($page_url_arr[2] == 'all.html') // все марки
	$page_filename = 'all.html';
elseif(in_array($page_url_arr[2], $subdir_list)) // поддиректории
{
	$page_subdir = $page_url_arr[2];
	if(!isset($page_url_arr[3]) || $page_url_arr[3] == 'index.html') // главная в поддиректории
		$page_filename = 'index.html';
	else // страница с записью в поддиректории
	{
		$page_filename = preg_replace("~[^a-zA-Z0-9\._-]+~", "", $page_url_arr[3]); // вычищаем недопустимые символы

		// проверяем существование записи
		if($page_subdir == 'group' && ssql("SELECT count(*) FROM rc_kpp_groups WHERE visible = '1' and cat_id = 13 and url_title='$page_filename'") == 0)
			$page_filename = 'index.html';
		elseif($page_subdir == 'zavod' && ssql("SELECT count(*) FROM company WHERE visible = '1' ( uslugi like '______1%' or uslugi like '_____1%' ) and seo_title='$page_filename'") == 0)
			$page_filename = 'index.html';
		elseif($page_subdir == 'company' && ssql("SELECT count(*) FROM company WHERE visible = '1' and seo_title='$page_filename'") == 0)
			$page_filename = 'index.html';
		elseif($page_subdir == 'mark' && ssql("SELECT count(*) FROM rc_kpp_marks WHERE visible = '1' and url_title='$page_filename'") == 0)
			$page_filename = 'index.html';
	}
}
else // несуществующая страница или поддиректория
	$page_filename = ''; // в остальных случаях отправляем на главную (хотя надо было бы ошибку выдавать)

//
// Логика -------------------------------------------------
//

if($page_subdir == '')
{
	if($page_filename == '')
	{
		$page = getMainIndex();
		$page['content'] = '<div class="infoWire">' . $page['content'] . '</div>';
	}
	elseif($page_filename == 'all.html')
		$page = getAllMarks();
}
elseif($page_subdir == 'group')
{
	if($page_filename == 'index.html')
		$page = getGroupIndex();
	else
		$page = getGroupPage($page_filename);
}
elseif($page_subdir == 'zavod')
{
	if($page_filename == 'index.html')
		$page = getZavodIndex();
	else
		$page = getZavodPage($page_filename);
}
elseif($page_subdir == 'company')
{
	if($page_filename == 'index.html')
		$page = getCompanyIndex();
	else
		$page = getCompanyPage($page_filename);
}
elseif($page_subdir == 'mark')
{

	if($page_filename == 'index.html'){
	    echo "<!-- zzz HERE 1 -->";
		$page = getMarkIndex();
	}else{
	    echo "<!-- zzz HERE 2 -->";
		$page = getMarkPage($page_filename);
	}
}

// окружение текущей страницы
// cat_id   - текущий раздел
// mark_id  - текущая марка
$page_env = getEnvironment($page_subdir, $page_filename);

//
// Вывод на экран -----------------------------------------
//

$title_tag = $page['title'];
$metadescription = "Кабельные полимеры. ".$page['title'];
$metakeywords = getKeywords($page['title'].' '.$page['content']);


$h1_dopstyle = '';
// Прикручиваем спонсора СИП
/*
if(isset($page_env['cat_id']) && $page_env['cat_id'] == 7)
{
	if(!isset($page_env['mark_id']))
		$h1_dopstyle = 'padding-right: 270px;';
}
*/

if($h1_dopstyle != '') $h1_dopstyle = 'style="'.$h1_dopstyle.'"';

if($page_subdir == 'mark' && $page_filename != 'index.html')
	print '<h1 class="noUpper noLine" '.$h1_dopstyle.'>'.$page['h1'].'</h1>';
else
	print '<h1 '.$h1_dopstyle.'>'.$page['h1'].'</h1>';


// Прикручиваем спонсора СИП
/*
if(isset($page_env['cat_id']) && $page_env['cat_id'] == 7)
{
	$HB_dopstyle = '';
	if(isset($page_env['mark_id']))
	{
		$HB_dopstyle = 'style="margin-top: -50px;"';
	}
	?>
	<a href="http://www.evro-lep.ru/" target="_blank" title='Спонсор раздела "СИП и арматура"' class="sponsorHeaderBlock" <?=$HB_dopstyle;?> >
		<div class="spLogo"><img border="0" title='Спонсор раздела "СИП и арматура"' alt='Компания «Евро-ЛЭП»' src="/info/sip/images/logo-evrolep-sponsor.png"></div>
		<div class="spTitle">Спонсор раздела<br>«СИП и арматура»</div>
	</a>
	<?
}
*/

print $page['content'];

//print "<hr style='clear: both;'>";

//print "<p>page_subdir: '$page_subdir'";
//print "<br>page_filename: '$page_filename'";

//print "<pre>";
//print var_dump($page_url_arr);
//print "</pre>";
//print "<hr>";


//
// Функции вывода -----------------------------------------
//

// Выводим варианты альтернативной навигации по справочнику
function getKppInfoNav()
{
	$content  = '';

	$menu = $GLOBALS['navArray'];
	$cur  = $GLOBALS['page_subdir'];
	$dir  = $GLOBALS['base_dir'];

	if($cur == '') $cur = 'cable'; // для главной

	$content .= "\n<div class='pageSpecial specialLightBlue' style='text-align: center;'>";
	for($i=0; $i<sizeof($menu); $i++)
	{
		if($menu[$i]['img'] == $cur)
		{
			$content .= "<a href='".$menu[$i]['url']."' class='infoIconNav infoIconNavActive'>";
			$content .= "<p class='icon1'><img src='".$dir."/i/info-nav-".$menu[$i]['img']."-hover.png' width='100' height='75' alt='".$menu[$i]['title']."'></p>";
		}
		else
		{
			$content .= "<a href='".$menu[$i]['url']."' class='infoIconNav'>";
			$content .= "<p class='icon1'><img src='".$dir."/i/info-nav-".$menu[$i]['img'].".png' width='100' height='75' alt='".$menu[$i]['title']."'></p>";
		}
		$content .= "<p class='icon2'><img src='".$dir."/i/info-nav-".$menu[$i]['img']."-hover.png' width='100' height='75' alt='".$menu[$i]['title']."'></p>";
		$content .= "<p class='title'>".$menu[$i]['title']."</p>";
		$content .= "</a>";
	}
	$content .= "\n<div class='clear'></div>";

	$content .= "\n<div class='infoNavLinks'>";
//	$content .= "\n<br>&mdash; <a href='".$dir."/'>Главная. Группы без марок</a>";
//	$content .= "\n<br>&mdash; <a href='".$dir."/all.html'>Все марки по разделам</a>";
	$content .= "\n<br>&mdash; <a href='/info/general/'>Справочная информация по КПП</a>";
	$content .= "\n<br>&mdash; <a href='".$dir."/company/'>Организации предоставившие информацию</a>";
	$content .= "\n<br>&mdash; <a href='/info/cable/'>Предыдущая версия справочника</a>";
	$content .= "\n</div>";

	$content .= "\n</div>";

	// return $content; // выводит синий блок, как в справочнике
}


// Вывод индексной страницы. Разделы с группами. Без марок (кроме отдельных марок не отнесенных к группам)
function getMainIndex()
{
	$page = array(
		'title'   => 'Кабельные полимеры',
		'h1'      => 'Кабельные полимеры',
		'content' => '',
	);

	$content  = '';
	$content .= getKppInfoNav();

	// Было бы неплохо обойтись меньшим количеством запросов, но не придумал как, т.к.:
	// 1. Марки могут быть не привязанными ни к одной группе.
	// 2. Если в группе нет марок, но есть описание - надо выводить.

	$cat = GetDB("SELECT id, title FROM rc_kpp_cat WHERE id = 13 ORDER BY sort_order asc");
	for($i=0; $i<sizeof($cat); $i++)
	{
		$content .= "\n<h2>".$cat[$i]['title']."</h2>";
		$content .= "\n\n<ul>";

		// выводим группы, если есть марки привязанные к группе или описание группы
		$group = GetDB("SELECT id, title, url_title, description FROM rc_kpp_groups WHERE cat_id=13 and visible = '1'  ORDER BY id desc");
		for($k=0; $k<sizeof($group); $k++)
		{
			$mark_col = ssql("SELECT count(*) FROM rc_kpp_marks_groups WHERE group_id = '".$group[$k]['id']."'"); // здесь не учтена видимость марок
			if($mark_col > 0 || $group[$k]['description'] != 0)
				$content .= "\n\t<li>".genLink($group[$k]['title'], 'group/'.$group[$k]['url_title'].'/');
		}

		// выводим марки без групп
		$mark = GetDB("SELECT
			rc_kpp_marks.id,
			rc_kpp_marks.mark,
			rc_kpp_marks.url_title,
			rc_kpp_marks.subtitle
		FROM
			rc_kpp_marks
			LEFT JOIN rc_kpp_marks_groups
		ON
			rc_kpp_marks.id = rc_kpp_marks_groups.mark_id
		WHERE
			rc_kpp_marks_groups.mark_id IS NULL
			and rc_kpp_marks.cat_id = '".$cat[$i]['id']."'
			and rc_kpp_marks.visible = '1'
		");

		for($k=0; $k<sizeof($mark); $k++)
		{
			$content .= "\n\t<li>".genLink($mark[$k]['mark'].' - '.$mark[$k]['subtitle'], 'mark/'.$mark[$k]['url_title'].'/');
		}

		$content .= "\n</ul>";
	}


	$page['content'] = $content;

	return $page;
}

// Вывод всех марок по разделам
function getAllMarks()
{
	$page = array(
		'title'   => 'Общий перечень марок по разделам',
		'h1'      => 'Общий перечень марок по разделам',
		'content' => '',
	);

	$count   = 0;
	$content = '';
	$content .= getKppInfoNav();

	$lvl_1 = GetDB("SELECT id, title FROM rc_kpp_cat where id = 13 ORDER BY sort_order");

	$content .= "\n\n<div id='abc'>\n\n";
	for($i=0; $i<sizeof($lvl_1); $i++)
	{
		$lvl_2 = GetDB("SELECT id, cat_id, mark, url_title, zavod_id, date_add, date_edit FROM rc_kpp_marks WHERE visible = '1' and cat_id = 13 ORDER BY mark asc");

		$count += sizeof($lvl_2);

		$content .= "\n\n<h2>".$lvl_1[$i]['title']." (".sizeof($lvl_2).")</h2>\n\n";
		$content .= "\n\n<div class='kppMarkGroup'>\n\n";

		for($k=0; $k<sizeof($lvl_2); $k++)
		{
			$mark_dopinfo = array();
			if($lvl_2[$k]['zavod_id'] != 0)
			{
				$zavod = GetDB("SELECT uslugi, forma_sob, title, seo_title FROM company WHERE id = '".$lvl_2[$k]['zavod_id']."' AND visible = 1 ");
				if(sizeof($zavod) > 0)
				{
					if(substr($zavod[0]['uslugi'],6,1) == 1 || substr($zavod[0]['uslugi'],5,1) == 1)
					{
						//$mark_suffix = '<a href="/company/zavod/'.$zavod[0]['seo_title'].'/">'.$zavod[0]['title'].', '.$zavod[0]['forma_sob'].'</a>';
						$mark_dopinfo['type'] = 'zavod';
						$mark_dopinfo['text'] = 'Производитель:<br><a href="/company/'.$zavod[0]['seo_title'].'/">'.$zavod[0]['title'].'</a>';
					}
					else
					{
						//$mark_suffix = '<a href="/company/all/'.$zavod[0]['seo_title'].'/">'.$zavod[0]['title'].', '.$zavod[0]['forma_sob'].'</a>';
						$mark_dopinfo['type'] = 'company';
						$mark_dopinfo['text'] = 'Информация предоставлена:<br><a href="/company/'.$zavod[0]['seo_title'].'/">'.$zavod[0]['title'].'</a>';
					}
				}
			}
			$content .= genMarkLink($lvl_2[$k]['mark'], $lvl_2[$k]['url_title'], $lvl_2[$k]['date_add'], $lvl_2[$k]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n\n<br style='clear: both;'>";
		$content .= "\n</div>\n\n";
	}
	$content .= "\n\n</div>\n\n";



	$page['content'] = $content;
	$page['h1'] .= " ($count)";

	return $page;
}

// Вывод всех марок по группам
//
// ВНИМАНИЕ: 1. здесь не выводятся марки не привязанные ни к одной группе
function getGroupIndex()
{
	$page = array(
		'title'   => 'Общий перечень марок КПП по группам',
		'h1'      => 'Общий перечень марок КПП по группам',
		'content' => '',
	);

	$content = '';
	$content .= getKppInfoNav();

	//$content .= "\n\n<div>\n\n";

	$cat = GetDB("SELECT id, title FROM rc_kpp_cat where id = 13 ORDER BY sort_order asc");

	for($i=0; $i<sizeof($cat); $i++)
	{
		$content .= "\n<h2>".$cat[$i]['title']."</h2>";
		$content .= "\n<div>Полимеры являются основным изолирующим материалом, используемым для электрического и электронного сектора. Для выполнения некоторых функций они незаменимы, а их универсальность, и их ни с чем не сравнимый баланс свойств, в сочетании со свободой проектирования и обработки, часто позволяют вырабатывать экономические и инновационные решения, которые оправдывают их высокую стоимость на этом рынке.
			<br>
			Чтобы дополнить раздел, можете написать нам <a href='' class='writeUsLink' id='mailUs' title='Написать нам'>здесь</a>.</div>";
		$content .= "\n\n<div class='infoLeftIndent'>";
		// выводим группы, если есть марки привязанные к группе или описание группы
		$group = GetDB("SELECT id, title, url_title, description FROM rc_kpp_groups WHERE cat_id=13 and visible = '1' ORDER BY id asc");
		for($k=0; $k<sizeof($group); $k++)
		{
			$mark = GetDB("SELECT
				m.id,
				m.mark,
				m.url_title,
				m.zavod_id,
				m.date_add,
				m.date_edit
			FROM
				rc_kpp_marks as m,
				rc_kpp_marks_groups as g
			WHERE
				g.mark_id = m.id
				and g.group_id = '".$group[$k]['id']."'
				and m.visible = '1'
			ORDER BY m.mark asc, m.parent_id asc
			");

			if(sizeof($mark) > 0 || $group[$k]['description'] != '')
			{
				$h3_search  = array(" производства ", " поставляемые ");
				$h3_replace = array("<br />производства ", "<br />поставляемые ");
				$content .= "\n\t<h3>".genLink(str_replace($h3_search, $h3_replace, $group[$k]['title']), 'group/'.$group[$k]['url_title'].'/')."</h3>";

				$content .= "\n\n<div class='kppMarkGroup infoLeftIndent'>\n\n";
				for($m=0; $m<sizeof($mark); $m++)
				{
					$mark_dopinfo = array();
					if($mark[$m]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark[$m]['zavod_id'], true))
					{
						$mark_dopinfo['type'] = 'zavod';
						$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
					}
					$content .= genMarkLink($mark[$m]['mark'], $mark[$m]['url_title'], $mark[$m]['date_add'], $mark[$m]['date_edit'], $mark_dopinfo);
				}
				$content .= "\n<br style='clear: both;' />";
				$content .= "\n\n</div>\n\n";
			}
		}

		$content .= "\n</div>";
	}

	//$content .= "\n\n</div>\n\n";


	$page['content'] = $content;

	return $page;
}

// Вывод описания определенной группы кабелей + списка кабелей относящихся к этой группе (если есть)
function getGroupPage($group_url)
{
	$content = '';

	$group   = GetDB("SELECT id, cat_id, title, description FROM rc_kpp_groups WHERE visible = '1' and url_title='$group_url'");
	$group   = $group[0];
	$group['cat_name'] = ssql("SELECT title FROM rc_kpp_cat WHERE id = '".$group['cat_id']."'");

	$mark = GetDB("SELECT
		m.id,
		m.mark,
		m.url_title,
		m.zavod_id,
		m.date_add,
		m.date_edit
	FROM
		rc_kpp_marks as m,
		rc_kpp_marks_groups as g
	WHERE
		g.mark_id = m.id
		and g.group_id = '".$group['id']."'
		and m.visible = '1'
	ORDER BY m.mark asc, m.parent_id asc
	");

	//$content .= "\n<h2>".$group['title']."</h2>";
	//$content .= "\n<p><strong>Раздел: ".$group['cat_name']."</strong></p>";

	if(sizeof($mark) > 0)
	{
		$content .= "\n<div class='kppBlockTitle'><strong>Все марки группы</strong></div>";
		$content .= "\n<div class='kppBlockMore'>".genLink('Список групп', 'group/')."</div>";
		$content .= "\n<br style='clear: both;' />\n\n";
		$content .= "\n<div class='kppBlock'><div style='margin: 0 5px;'>\n\n";

		// для подсветки марок в тексте
		$mark_orig    = array(); // чтоб пропускать одинаковые марки от разных производителей
		$mark_search  = array();
		$mark_replace = array();

		for($m=0; $m<sizeof($mark); $m++)
		{
			// для подсветки марок в тексте
			if(!in_array($mark[$m]['mark'], $mark_orig))
			{
				$mark_orig[]    = $mark[$m]['mark'];
				$mark_search[]  = "~([ >,])".$mark[$m]['mark']."([ <:,&\.\*])~s";
				$mark_replace[] = "$1".genLink($mark[$m]['mark'], 'mark/'.$mark[$m]['url_title'].'/')."$2";
			}

			$mark_dopinfo = array();
			if($mark[$m]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark[$m]['zavod_id'], true))
			{
				$mark_dopinfo['type'] = 'zavod';
				$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
			}
			$content .= genMarkLink($mark[$m]['mark'], $mark[$m]['url_title'], $mark[$m]['date_add'], $mark[$m]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n<br style='clear: both;' />";
		$content .= "\n\n</div></div>\n\n";

		// подсветка марок в тексте
		$group['description'] = preg_replace($mark_search, $mark_replace, $group['description']);
	}

	$content .= "\n<div class='infoTextWrap'>";
	$content .= "\n".$group['description']."";
	$content .= "\n</div>\n\n";

	$page = array(
		'title'   => $group['title'],
		'h1'      => $group['title'],
		'content' => $content,
	);

	return $page;
}

// Вывод всех заводов в каталоге
function getZavodIndex()
{
	$page = array(
		'title'   => 'Продукция заводов-производителей КПП',
		'h1'      => 'Продукция заводов-производителей КПП',
		'content' => '',
	);

	$content = '';
	$content .= getKppInfoNav();

	$zavod = GetDB("SELECT
					distinct(cmp.id),
					cmp.forma_sob,
					cmp.title,
					cmp.seo_title,
					cmp.short_text,
					cmp.logo
				FROM
					company as cmp,
					rc_kpp_marks as m
				WHERE
					cmp.id = m.zavod_id
					and m.visible = '1'
					and cmp.visible = '1'
					and ( cmp.uslugi like '______1%' OR cmp.uslugi like '_____1%')
				ORDER BY
					cmp.sort_title asc
				");

	for($i=0; $i<sizeof($zavod); $i++)
	{
		$content .= "\n\n".'<div class="infoCmpShort">';

		if( $zavod[$i]['logo'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].$zavod[$i]['logo']) )
		{
			$img_wh = '';
			$size   = getimagesize($_SERVER['DOCUMENT_ROOT'].$zavod[$i]['logo']);
			$width  = $size[0];
			$height = $size[1];

			if($width=$height && $width>150)
			{
				$img_wh = 'width="150"';
			}
			elseif($width>$height && $width>150)
			{
				$img_wh = 'width="150"';
			}
			elseif($width<$height && $height>150)
			{
				$img_wh = 'height="150"';
			}

			$content .= '<div class="infoCmpLogo"><span><img '.$img_wh.' src="'.$zavod[$i]['logo'].'"></span></div>';
		}
		$content .= '<h2>'.genLink(cmpName($zavod[$i]['forma_sob'], $zavod[$i]['title']), 'zavod/'.$zavod[$i]['seo_title'].'/').'</h2>';
		$content .= '<div class="description">'.$zavod[$i]['short_text'].'</div>';


		$mark = GetDB("SELECT
					m.id,
					m.mark,
					m.url_title,
					m.zavod_id,
					m.date_add,
					m.date_edit
				FROM
					rc_kpp_marks as m
				WHERE
					m.zavod_id = '".$zavod[$i]['id']."'
					and m.visible = '1'
				ORDER BY m.mark asc
				");

		if(sizeof($mark) > 0)
		{
			$content .= "\n<div class='clear'></div>\n\n";
			$content .= "\n<div class='kppBlockTitle'><strong>Все марки завода</strong></div>";
			$content .= "\n<br style='clear: both;' />\n\n";
			$content .= "\n<div class='kppBlock'><div style='margin: 0 5px;'>\n\n";

			for($m=0; $m<sizeof($mark); $m++)
			{
				$mark_dopinfo['type'] = 'zavod';

			//	$mark_dopinfo = array();
			//	if($mark[$m]['zavod_id'] != 0 && $zavod = getZavodInfo($mark[$m]['zavod_id']))
			//	{
			//		$mark_dopinfo['type'] = 'zavod';
			//		$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
			//	}
				$content .= genMarkLink($mark[$m]['mark'], $mark[$m]['url_title'], $mark[$m]['date_add'], $mark[$m]['date_edit'], $mark_dopinfo);
			}
			$content .= "\n<br style='clear: both;' />";
			$content .= "\n\n</div></div>\n\n";

		}

		$content .= '<div class="clear"></div>';
		$content .= '</div>';
	}

	$page['content'] = $content;

	return $page;
}

// Вывод продукции определенной завода
function getZavodPage($zavod_url)
{
	$content = '';

	$zavod   = GetDB("SELECT id, forma_sob, title, short_text, logo, p_addr, phone, fax, url, seo_title FROM company WHERE visible = '1' and seo_title='$zavod_url'");
	$zavod   = $zavod[0];

	$z_name  = cmpName($zavod['forma_sob'], $zavod['title']);

	if( $zavod['logo'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].$zavod['logo']) )
	{
		$img_wh = '';
		$size   = getimagesize($_SERVER['DOCUMENT_ROOT'].$zavod['logo']);
		$width  = $size[0];
		$height = $size[1];

		if($width=$height && $width>150)
		{
			$img_wh = 'width="150"';
		}
		elseif($width>$height && $width>150)
		{
			$img_wh = 'width="150"';
		}
		elseif($width<$height && $height>150)
		{
			$img_wh = 'height="150"';
		}

		$content .= '<div class="infoCmpLogo"><span><img '.$img_wh.' src="'.$zavod['logo'].'"></span></div>';
	}
	//$content .= $zavod['id'];
	$content .= $zavod['short_text'];

	// выводим марки без групп
	$mark_no_group = GetDB("SELECT
		rc_kpp_marks.id,
		rc_kpp_marks.mark,
		rc_kpp_marks.url_title,
		rc_kpp_marks.date_add,
		rc_kpp_marks.date_edit
	FROM
		rc_kpp_marks
		LEFT JOIN rc_kpp_marks_groups
	ON
		rc_kpp_marks.id = rc_kpp_marks_groups.mark_id
	WHERE
		rc_kpp_marks_groups.mark_id IS NULL
		and rc_kpp_marks.zavod_id = '".$zavod['id']."'
		and rc_kpp_marks.visible = '1'
	ORDER BY rc_kpp_marks.mark asc
	");


	$mark = GetDB("SELECT
		m.id,
		m.mark,
		m.url_title,
		m.date_add,
		m.date_edit,
		g.title as g_title,
		g.url_title g_url
	FROM
		rc_kpp_marks as m,
		rc_kpp_marks_groups as mg,
		rc_kpp_groups as g
	WHERE
		mg.mark_id = m.id
		and mg.group_id = g.id
		and m.visible = '1'
		and g.visible = '1'
		and m.zavod_id = '".$zavod['id']."'
	ORDER BY g.id asc, m.mark asc
	");

	$content .= "\n".'<div class="clear"></div>';
	$content .= "\n\n<h2>Кабели и провода, производства ".$z_name."</h2>\n";

	if(sizeof($mark_no_group) > 0)
	{
		$content .= "\n".'<div class="kppMarkGroup">';
		for($i=0; $i<sizeof($mark_no_group); $i++)
		{
			$mark_dopinfo['type'] = 'zavod';
			$content .= genMarkLink($mark_no_group[$i]['mark'], $mark_no_group[$i]['url_title'], $mark_no_group[$i]['date_add'], $mark_no_group[$i]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n".'</div>';
	}



	if(sizeof($mark) > 0)
	{
		$cur_group = '';
		for($i=0; $i<sizeof($mark); $i++)
		{
			if($cur_group != $mark[$i]['g_title'])
			{
				if($i != 0) $content .= "\n".'</div>';
				$cur_group = $mark[$i]['g_title'];
				$content .= "\n".'<div class="clear"></div>';
				$content .= "\n\n".'<h3>'.$mark[$i]['g_title'].' <span class="noBold">/&nbsp;'.genLink('в&nbsp;группу', 'group/'.$mark[$i]['g_url'].'/').'&nbsp;/</span></h3>'."\n";
				$content .= "\n".'<div class="kppMarkGroup">';
			}

			$mark_dopinfo['type'] = 'zavod';
			$content .= genMarkLink($mark[$i]['mark'], $mark[$i]['url_title'], $mark[$i]['date_add'], $mark[$i]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n".'</div>';
	}
	$content .= "\n".'<div class="clear"></div>';


	$content .= "\n".'<div class="pageNotice">';
	$content .= "\n".'<h3>'.$z_name.'</h3>';

	$content .= "\n".'<table border="0" width="100%" cellpadding="0" cellspacing="0">';
	if($zavod['p_addr'] != '') $content .= "\n".'<tr><td width="70">Адрес:</td><td>'.$zavod['p_addr'].'</td></tr>';
	if($zavod['phone'] != '') $content .= "\n".'<tr><td width="70">Телефон:</td><td>'.$zavod['phone'].'</td></tr>';
	if($zavod['fax'] != '') $content .= "\n".'<tr><td width="70">Факс:</td><td>'.$zavod['fax'].'</td></tr>';
	if($zavod['url'] != '') $content .= "\n".'<tr><td width="70">Сайт:</td><td><a href="'.$zavod['url'].'" target="_blank">'.str_replace("http://", "", $zavod['url']).'</a></td></tr>';
	$content .= "\n".'</table>';

	$content .= "\n".'<div class="hLine"></div>';
	$content .= "\n".'<p>Страницы компании в разделе: <a href="/company/'.$zavod['seo_title'].'/">кабельные заводы</a> на RusCable.Ru</p>';
	$content .= "\n".'</div>';


	$page = array(
		'title'   => 'КПП производства '.$z_name,
		'h1'      => 'КПП производства '.$z_name,
		'content' => $content,
	);

	return $page;
}

// Вывод всех компаний, предоставивших информацию
function getCompanyIndex()
{
	$page = array(
		'title'   => 'Организации предоставившие информацию для справочника КПП',
		'h1'      => 'Организации предоставившие информацию',
		'content' => '',
	);

	$content = '';
	$content .= getKppInfoNav();

	$company = GetDB("SELECT
					distinct(cmp.id),
					cmp.forma_sob,
					cmp.title,
					cmp.seo_title,
					cmp.short_text,
					cmp.logo
				FROM
					company as cmp,
					rc_kpp_marks as m
				WHERE
					cmp.id = m.company_id
					and m.company_id <> m.zavod_id
					and m.visible = '1'
					and cmp.visible = '1'
				ORDER BY
					cmp.sort_title asc
				");

	for($i=0; $i<sizeof($company); $i++)
	{
		$content .= "\n\n".'<div class="infoCmpShort">';

		if( $company[$i]['logo'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].$company[$i]['logo']) )
		{
			$img_wh = '';
			$size   = getimagesize($_SERVER['DOCUMENT_ROOT'].$company[$i]['logo']);
			$width  = $size[0];
			$height = $size[1];

			if($width=$height && $width>150)
			{
				$img_wh = 'width="150"';
			}
			elseif($width>$height && $width>150)
			{
				$img_wh = 'width="150"';
			}
			elseif($width<$height && $height>150)
			{
				$img_wh = 'height="150"';
			}

			$content .= '<div class="infoCmpLogo"><span><img '.$img_wh.' src="'.$company[$i]['logo'].'"></span></div>';
		}
		$content .= '<h2>'.genLink(cmpName($company[$i]['forma_sob'], $company[$i]['title']), 'company/'.$company[$i]['seo_title'].'/').'</h2>';
		$content .= '<div class="description">'.$company[$i]['short_text'].'</div>';


		$mark = GetDB("SELECT
					m.id,
					m.mark,
					m.url_title,
					m.zavod_id,
					m.date_add,
					m.date_edit
				FROM
					rc_kpp_marks as m
				WHERE
					m.company_id = '".$company[$i]['id']."'
					and m.company_id <> m.zavod_id
					and m.visible = '1'
				ORDER BY m.mark asc
				");

		if(sizeof($mark) > 0)
		{
			$content .= "\n<div class='clear'></div>\n\n";
			$content .= "\n<div class='kppBlockTitle'><strong>Предоставленные марки</strong></div>";
			$content .= "\n<br style='clear: both;' />\n\n";
			$content .= "\n<div class='kppBlock'><div style='margin: 0 5px;'>\n\n";

			for($m=0; $m<sizeof($mark); $m++)
			{
			//	$mark_dopinfo['type'] = 'zavod';

				$mark_dopinfo = array();
				if($mark[$m]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark[$m]['zavod_id'], true))
				{
					$mark_dopinfo['type'] = 'zavod';
					$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
				}
				$content .= genMarkLink($mark[$m]['mark'], $mark[$m]['url_title'], $mark[$m]['date_add'], $mark[$m]['date_edit'], $mark_dopinfo);
			}
			$content .= "\n<br style='clear: both;' />";
			$content .= "\n\n</div></div>\n\n";

		}

		$content .= '<div class="clear"></div>';
		$content .= '</div>';
	}

	$page['content'] = $content;

	return $page;
}

// Вывод продукции определенной компании
function getCompanyPage($company_url)
{
	$content = '';

	$company   = GetDB("SELECT id, forma_sob, title, short_text, logo, p_addr, phone, fax, url, seo_title FROM company WHERE visible = '1' and seo_title='$company_url'");
	$company   = $company[0];

	$c_name  = cmpName($company['forma_sob'], $company['title']);

	if( $company['logo'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].$company['logo']) )
	{
		$img_wh = '';
		$size   = getimagesize($_SERVER['DOCUMENT_ROOT'].$company['logo']);
		$width  = $size[0];
		$height = $size[1];

		if($width=$height && $width>150)
		{
			$img_wh = 'width="150"';
		}
		elseif($width>$height && $width>150)
		{
			$img_wh = 'width="150"';
		}
		elseif($width<$height && $height>150)
		{
			$img_wh = 'height="150"';
		}

		$content .= '<div class="infoCmpLogo"><span><img '.$img_wh.' src="'.$company['logo'].'"></span></div>';
	}
	//$content .= $zavod['id'];
	$content .= $company['short_text'];

	// выводим марки без групп
	$mark_no_group = GetDB("SELECT
		rc_kpp_marks.id,
		rc_kpp_marks.mark,
		rc_kpp_marks.url_title,
		rc_kpp_marks.zavod_id,
		rc_kpp_marks.date_add,
		rc_kpp_marks.date_edit
	FROM
		rc_kpp_marks
		LEFT JOIN rc_kpp_marks_groups
	ON
		rc_kpp_marks.id = rc_kpp_marks_groups.mark_id
	WHERE
		rc_kpp_marks_groups.mark_id IS NULL
		and rc_kpp_marks.company_id = '".$company['id']."'
		and rc_kpp_marks.visible = '1'
	ORDER BY rc_kpp_marks.mark asc
	");

	$mark = GetDB("SELECT
		m.id,
		m.mark,
		m.url_title,
		m.zavod_id,
		m.date_add,
		m.date_edit,
		g.title as g_title,
		g.url_title g_url
	FROM
		rc_kpp_marks as m,
		rc_kpp_marks_groups as mg,
		rc_kpp_groups as g
	WHERE
		mg.mark_id = m.id
		and mg.group_id = g.id
		and m.visible = '1'
		and g.visible = '1'
		and m.company_id = '".$company['id']."'
		and m.company_id <> m.zavod_id
	ORDER BY g.id asc, m.mark asc
	");

	$content .= "\n".'<div class="clear"></div>';
	$content .= "\n\n<h2>Информация о кабелях и проводах, предоставленная ".$c_name."</h2>\n";

	if(sizeof($mark_no_group) > 0)
	{
		$content .= "\n".'<div class="kppMarkGroup">';
		for($i=0; $i<sizeof($mark_no_group); $i++)
		{
			$mark_dopinfo = array();
			if($mark_no_group[$i]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark_no_group[$i]['zavod_id'], true))
			{
				$mark_dopinfo['type'] = 'zavod';
				$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
			}
			$content .= genMarkLink($mark_no_group[$i]['mark'], $mark_no_group[$i]['url_title'], $mark_no_group[$i]['date_add'], $mark_no_group[$i]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n".'</div>';
	}


	if(sizeof($mark) > 0)
	{
		$cur_group = '';
		for($i=0; $i<sizeof($mark); $i++)
		{
			if($cur_group != $mark[$i]['g_title'])
			{
				if($i != 0) $content .= "\n".'</div>';
				$cur_group = $mark[$i]['g_title'];
				$content .= "\n".'<div class="clear"></div>';
				$content .= "\n\n".'<h3>'.$mark[$i]['g_title'].' <span class="noBold">/&nbsp;'.genLink('в&nbsp;группу', 'group/'.$mark[$i]['g_url'].'/').'&nbsp;/</span></h3>'."\n";
				$content .= "\n".'<div class="kppMarkGroup">';
			}

			$mark_dopinfo = array();
			if($mark[$i]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark[$i]['zavod_id'], true))
			{
				$mark_dopinfo['type'] = 'zavod';
				$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
			}
			$content .= genMarkLink($mark[$i]['mark'], $mark[$i]['url_title'], $mark[$i]['date_add'], $mark[$i]['date_edit'], $mark_dopinfo);
		}
		$content .= "\n".'</div>';
	}
	$content .= "\n".'<div class="clear"></div>';


	$content .= "\n".'<div class="pageNotice">';
	$content .= "\n".'<h3>'.$c_name.'</h3>';

	$content .= "\n".'<table border="0" width="100%" cellpadding="0" cellspacing="0">';
	if($company['p_addr'] != '') $content .= "\n".'<tr><td width="70">Адрес:</td><td>'.$company['p_addr'].'</td></tr>';
	if($company['phone'] != '') $content .= "\n".'<tr><td width="70">Телефон:</td><td>'.$company['phone'].'</td></tr>';
	if($company['fax'] != '') $content .= "\n".'<tr><td width="70">Факс:</td><td>'.$company['fax'].'</td></tr>';
	if($company['url'] != '') $content .= "\n".'<tr><td width="70">Сайт:</td><td><a href="'.$company['url'].'" target="_blank">'.str_replace("http://", "", $company['url']).'</a></td></tr>';
	$content .= "\n".'</table>';

	$content .= "\n".'<div class="hLine"></div>';
	$content .= "\n".'<p>Страницы компании в разделе: <a href="/company/'.$company['seo_title'].'/">каталог организаций</a> на RusCable.Ru</p>';
	$content .= "\n".'</div>';


	$page = array(
		'title'   => 'Информация о КПП предоставленная '.$c_name,
		'h1'      => 'Информация о КПП предоставленная '.$c_name,
		'content' => $content,
	);

	return $page;
}

// Вывод всех марок по алфавиту, без дублирующихся (parent_id=0)
function getMarkIndex()
{
	$page = array(
		'title'   => 'Алфавитный указатель по маркам кабеля и провода',
		'h1'      => 'Алфавитный указатель по маркам кабеля и провода',
		'content' => '',
	);

	$content = '';
	$content .= getKppInfoNav();


	$mark = GetDB("SELECT
		m.id,
		m.mark,
		m.url_title,
		m.zavod_id,
		m.date_add,
		m.date_edit
	FROM
		rc_kpp_marks as m
	WHERE
		m.visible = '1'
	ORDER BY m.mark asc, m.parent_id asc
	");


	$cur_letter  = '';
	$content_abc = ''; // для того, чтобы навигацию по буквам вывести перед алфавитным указателем
	$letter_nav  = array();

	$content_abc .= "\n\n<div id='abc'>\n\n";
	for($m=0; $m<sizeof($mark); $m++)
	{
		$first_letter = $mark[$m]['mark']{0};
		if(in_array($first_letter, array('(', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'))) $first_letter = '#';

		if($first_letter != $cur_letter)
		{
			if($m != 0) $content_abc .= "\n".'</div>';
			$cur_letter = $first_letter;
			$content_abc .= "\n".'<div class="clear"></div>';

			if($cur_letter == '#')
				$cur_letter_title = '(0-9)';
			else
				$cur_letter_title = $cur_letter;

			if(preg_match("~[a-zA-Z#]~", $cur_letter))
				$cur_letter_a = 'en_'.strtolower(str_replace("#", "123", $cur_letter));
			else
				$cur_letter_a = 'ru_'.strtolower(rus2lat($cur_letter));

			$content_abc .= "\n\n".'<h2><a name="'.$cur_letter_a.'"></a>'.$cur_letter_title.'</h2>'."\n";
			$letter_nav[] = array("a"=>$cur_letter_a, "title"=>$cur_letter_title);

			$content_abc .= "\n\n<div class='kppMarkGroup infoLeftIndent'>\n\n";
		}

		$mark_dopinfo = array();
		if($mark[$m]['zavod_id'] != 0 && $zavod = getCompanyInfo($mark[$m]['zavod_id'], true))
		{
			$mark_dopinfo['type'] = 'zavod';
			$mark_dopinfo['text'] = 'Производитель:<br><a href="'.$zavod['url'].'">'.$zavod['title'].'</a>';
		}
		$content_abc .= genMarkLink($mark[$m]['mark'], $mark[$m]['url_title'], $mark[$m]['date_add'], $mark[$m]['date_edit'], $mark_dopinfo);
	}

	$content_abc .= "\n\n</div>\n\n"; // class='kppMarkGroup'
	$content_abc .= "\n".'<div class="clear"></div>';
	$content_abc .= "\n\n</div>\n\n"; // id='abc'

	$content .= "\n\n<div id='abc_nav' style='margin: 20px 0 30px 0;'>\n";
	$new_line = false;
	for($i=0; $i<sizeof($letter_nav); $i++)
	{
		if(!$new_line && substr($letter_nav[$i]['a'], 0, 3) == 'ru_')
		{
			$content .= "\n".'<div class="clear"></div>'."\n";
			$new_line = true;
		}

		$content .= '<a href="#'.$letter_nav[$i]['a'].'" class="lightblueButton">'.$letter_nav[$i]['title'].'</a>';
	}
	$content .= "\n".'<div class="clear"></div>';
	$content .= "\n</div>\n\n";

	$content .= $content_abc; // id='abc'



//	if(sizeof($mark) > 0 || $group[$k]['description'] != '')
//	{
//		$h3_search  = array(" производства ", " поставляемые ");
//		$h3_replace = array("<br />производства ", "<br />поставляемые ");
//		$content .= "\n\t<h3>".genLink(str_replace($h3_search, $h3_replace, $group[$k]['title']), 'group/'.$group[$k]['url_title'].'/')."</h3>";
//		$content .= "\n<br style='clear: both;' />";
//	}



	$page['content'] = $content;

	return $page;
}

// Вывод определенной марки
function getMarkPage($mark_url)
{
	$dir     = $GLOBALS['base_dir'];
	$content = '';

	$mark   = GetDB("SELECT id, parent_id, mark, subtitle, text, addition, zavod_id, company_id, date_add, date_edit FROM rc_kpp_marks WHERE visible = '1' and url_title='$mark_url'");

	//echo "<!--zzz SELECT id, parent_id, mark, subtitle, text, addition, zavod_id, company_id, date_add, date_edit FROM rc_kpp_marks WHERE visible = '1' and url_title='$mark_url' -->";

	$mark   = $mark[0];


	$content .= "\n".'<div id="kppWrapper">';

	if($mark['subtitle'] != '') $content .= '<h2>'.$mark['subtitle'].'</h2>';

	// ИЗОБРАЖЕНИЯ
	$img = GetDB("SELECT id, filename, title, `desc`, ismain FROM entity_images WHERE entity='kpp' and entity_id='".$mark['id']."' ORDER BY ismain desc, id asc");
	if(sizeof($img) > 0)
	{
	//	for($i=0; $i<sizeof($img); $i++)
	//	{
		//	$img_full   = getImgSrc($img[$i]['filename']);
		//	$img_middle = getImgSrc($img[$i]['filename'], 'middle');
	//		$img_small  = getImgSrc($img[$i]['filename'], 'small');

		//	$content .= '<img src="'.$img_full.'" /><br>';
		//	$content .= '<img src="'.$img_middle.'" /><br>';
	//		$content .= '<img src="'.$img_small.'" /><br>';
	//	}


		$content .= '<script type="text/javascript" src="/rc2012/js/info-cable-mark.js"></script>';
		$content .= "\n".'<div id="markGallery">';

		$content .= "\n".'<div id="markImage">';
		for($i=0; $i<sizeof($img); $i++)
		{
			$img_middle = getImgSrc($img[$i]['filename'], 'middle');
			$img_small  = getImgSrc($img[$i]['filename'], 'small');

			if($i==0) $a_style = 'style="display: table-cell;"';
			else      $a_style = '';

			$content .= '<a rel="group" href="'.$img_middle.'" data-image="'.$img_small.'" '.$a_style.'><img src="'.$img_small.'" alt="'.$mark['mark'].'" title="'.$mark['mark'].'"></a>';
		}
		$content .= '</div>';

		if(sizeof($img) > 1)
		{
			$content .= "\n".'<div id="markImages">';
			for($i=0; $i<sizeof($img); $i++)
			{
				$img_small  = getImgSrc($img[$i]['filename'], 'small');

				$xy=GetImageSize($_SERVER['DOCUMENT_ROOT'].$img_small);
				$x=$xy[0];		// ширина
				$y=$xy[1];		// высота
				if($x>=$y) $img_wh = 'width="88"';
				else       $img_wh = 'height="88"';
//				$img_wh = 'width="66" height="66"';

				if($i==(sizeof($img)-1)) $div_style = 'style="margin-right: 0"';
				else      $div_style = '';

				if($i==0) $div_addclass = 'active';
				else      $div_addclass = '';

				//$content .= '<div class="markImage" data-image="'.$img_small.'" '.$div_style.'><img src="'.$img_small.'" '.$img_wh.' alt="'.$mark['mark'].'" title="'.$mark['mark'].'"></div>';
				$content .= '<div class="markImage '.$div_addclass.'" data-image="'.$img_small.'" '.$div_style.'><div><img src="'.$img_small.'" '.$img_wh.' alt="'.$mark['mark'].'" title="'.$mark['mark'].'"></div></div>';
			}
			$content .= "\n".'</div>';
		}
		$content .= "\n".'</div>';
	}


	//$content .= '<div class="clear"></div>';

	if(sizeof($img) > 0) $content .= "\n".'<div class="markInfo" style="margin-left: 330px; background-color: #ffede1;">';
	else                 $content .= "\n".'<div class="markInfo" style="background-color: #ffede1;">';

	$content .= "\n".'<div class="text">';

	// ГРУППЫ
	$group = GetDB("SELECT
		g.id,
		g.title,
		g.url_title,
		c.title as c_title
	FROM
		rc_kpp_marks_groups as mg,
		rc_kpp_groups as g,
		rc_kpp_cat as c
	WHERE
		mg.mark_id = '".$mark['id']."'
		and mg.group_id = g.id
		and g.cat_id = c.id
		and g.visible = '1'
	ORDER BY c.sort_order asc, g.id asc
	");

	if(sizeof($group) > 0)
	{
		$cur_cat = '';
		$content .= '<div class="partIcon"><a href="'.$dir.'/group/">';
		$content .= '<img src="'.$dir.'/i/icon-group-50x50.png" width="50" height="50" alt="Группы кабельно-проводниковой продукции" class="icon1">';
		$content .= '<img src="'.$dir.'/i/icon-group-50x50-hover.png" width="50" height="50" alt="Группы кабельно-проводниковой продукции" class="icon2">';
		$content .= '</a></div>';
		$content .= '<div class="partText">';
		$content .= '<h3>В группах</h3>';
		$content .= '<p>';
		for($i=0; $i<sizeof($group); $i++)
		{
			if($cur_cat != $group[$i]['c_title'])
			{
				$cur_cat  = $group[$i]['c_title'];
				$content .= ''.$cur_cat.'<br>';
			}
			$content .= '&mdash; '.genLink($group[$i]['title'], 'group/'.$group[$i]['url_title'].'/').'<br>';
		}
		$content .= '</p>';
		$content .= '</div>';
	}

	// ПРОИЗВОДИТЕЛЬ
	if($mark['zavod_id'] > 0)
	{
		$zavod = getCompanyInfo($mark['zavod_id'], true);
		if ( $zavod['visible'] ) {
			//print_r($zavod);
			$content .= '<div class="hLine"></div>';

			$content .= '<div class="partIcon"><a href="'.$dir.'/zavod/">';
			$content .= '<img src="'.$dir.'/i/icon-zavod-50x50.png" width="50" height="50" alt="Продукция заводов-производителей КПП" class="icon1">';
			$content .= '<img src="'.$dir.'/i/icon-zavod-50x50-hover.png" width="50" height="50" alt="Продукция заводов-производителей КПП" class="icon2">';
			$content .= '</a></div>';


			$content .= '<div class="partText">';
			$content .= '<h3>Производитель</h3>';
			$content .= '<p>'.$zavod['fulltitle'].' на RusCable.Ru:';
			// $content .= '<br>&mdash; '.genLink('все марки '.$zavod['fulltitle'], 'zavod/'.$zavod['seo_title'].'/').'';
			$content .= "<br>&mdash; <a href='https://www.ruscable.ru/info/wire/zavod/{$zavod['seo_title']}'>все марки {$zavod['fulltitle']}</a>";
			$content .= '<br>&mdash; <a href="'.$zavod['url'].'">страница '.$zavod['fulltitle'].'</a>';
			$content .= '</div>';
		}

	}

	$content .= "\n".'</div>'; // class="text"
	$content .= "\n".'</div>'; // class="markInfo"

	//$content .= '<div class="clear"></div>';



	// ИНФОРМАЦИЯ О РОДИТЕЛЯХ И ПОТОМКАХ
	$content_parent  = ''; // будет ТОЛЬКО у потомков
	$content_oZavod  = ''; // будет ТОЛЬКО у потомков
	$content_childes = ''; // будет ТОЛЬКО у родителя

	if($mark['parent_id'] > 0)
	{
		$parent_mark = GetDB("SELECT id, mark, url_title, subtitle, zavod_id, company_id, date_add, date_edit FROM rc_kpp_marks WHERE visible = '1' and id='".$mark['parent_id']."'");
		if(sizeof($parent_mark) > 0)
		{
			// ОСНОВНАЯ МАРКА
			$parent_mark = $parent_mark[0];

			if($parent_mark['zavod_id'] == 0 || $parent_mark['company_id'] == 0)
			{
				$content_parent .= '<div class="partText" style="width: 180px; float: left; margin-left: 20px;">';
				$content_parent .= '<h3>Общая информация<br>от RusCable.Ru</h3>';
				$content_parent .= '<p>по марке <a href="'.$dir.'/mark/'.$parent_mark['url_title'].'/">'.$parent_mark['mark'].'</a></p>';
				$content_parent .= '</div>';
			}

			// ДРУГИЕ ПРОИЗВОДИТЕЛИ
			$otherZavod  = getMarkChildes($parent_mark['id'], $mark['id']);
			if($otherZavod)
			{
				if($content_parent != '') $content_oZavod .= '<div class="partText" style="float: left;">';
				else                      $content_oZavod .= '<div class="partText" style="width: 300px; float: left; margin-left: 20px;">';

				$content_oZavod .= '<h3><span style="text-transform: none;">'.$parent_mark['mark'].'</span><br>от других производителей</h3>';
				$content_oZavod .= $otherZavod;
				$content_oZavod .= '<div class="clear"></div>';

				$content_oZavod .= '</div>';
			}
		}
	}

	// ЗАВОДЫ
	if($childes = getMarkChildes($mark['id'], $mark['id']))
	{
		$content_childes .= '<div class="partText" style="float: left; width: 80%; margin-left: 20px;">';

		$content_childes .= '<h3><span style="text-transform: none;">'.$mark['mark'].'</span><br>от заводов-производителей</h3>';
		$content_childes .= $childes;
		$content_childes .= '<div class="clear"></div>';

		$content_childes .= '</div>';
	}

	if($content_parent != '' || $content_oZavod != '' || $content_childes != '')
	{
		if(sizeof($img) > 0) $content .= "\n".'<div class="markInfo" style="margin-left: 330px; margin-top: 10px;">';
		else                 $content .= "\n".'<div class="markInfo" style="margin-top: 10px;">';
		$content .= "\n".'<div class="text">';
		$content .= '<div class="partIcon"><img src="'.$dir.'/i/icon-info-50x50.png" width="50" height="50" alt="Информация"></div>';

		$content .= $content_parent;
		$content .= $content_oZavod;
		$content .= $content_childes;

		$content .= '<div class="clear"></div>';
		$content .= "\n".'</div>'; // class="text"
		$content .= "\n".'</div>'; // class="markInfo"
	}


	// ОПИСАНИЕ МАРКИ
	$content .= "\n".'<div class="hLineNew"></div>';
	$content .= $mark['text'];
	if($mark['addition'] != '')
	{
		$content .= "\n".'<div class="hLineNew"></div>';
		$content .= $mark['addition'];
	}


	$content .= "\n".'<div class="markInfo" style="border-top: 2px solid #7A7A7A;">';

	// ПРЕДОСТАВИЛИ ИНФОРМАЦИЮ + СЛУЖЕБНАЯ ИНФОРМАЦИЯ
	if($mark['company_id'] > 0 && $mark['company_id'] <> $mark['zavod_id'])
	{
		$company = getCompanyInfo($mark['company_id']);
		if($company['visible'] > 0)
		{
			$content .= "\n".'<div class="text" style="float: left;">';
				$content .= '<div class="partIcon"><a href="'.$dir.'/company/">';
				$content .= '<img src="'.$dir.'/i/icon-company-50x50.png" width="50" height="50" alt="Организации предоставившие информацию" class="icon1">';
				$content .= '<img src="'.$dir.'/i/icon-company-50x50-hover.png" width="50" height="50" alt="Организации предоставившие информацию" class="icon2">';
				$content .= '</a></div>';

				$content .= '<div class="partText">';
				$content .= '<h3>Информация предоставлена</h3>';
				$content .= '<p>'.$company['fulltitle'].' на RusCable.Ru';
				// $content .= '<br>&mdash; '.genLink('все марки предоставленные '.$company['fulltitle'], 'company/'.$company['seo_title'].'/').'';
				$content .= "<br>&mdash; <a href='https://www.ruscable.ru/info/wire/zavod/{$company['url']}'>все марки предоставленные {$company['fulltitle']}</a>";
				$content .= '<br>&mdash; <a href="'.$company['url'].'">страница '.$company['fulltitle'].'</a>';
				$content .= '</div>';
			$content .= "\n".'</div>';
		}
	}

	$content .= "\n".'<div class="text" style="float: right; width: 180px;">';
		$content .= '<div class="partIcon"><img src="'.$dir.'/i/icon-info-50x50.png" width="50" height="50" alt="Информация"></div>';
		$content .= '<div class="partText">';
		$content .= '<h3>Обновлено</h3>';
		$content .= '<p>'.RCdateDayStr($mark['date_edit']).'';
		$content .= '</div>';
	$content .= "\n".'</div>';

	$content .= "\n".'<div class="clear"></div>';
	$content .= "\n".'</div>';


	$content .= "\n".'</div>';

	$page = array(
		'title'   => $mark['mark'].' - '.$mark['subtitle'],
		'h1'      => $mark['mark'],
		'content' => $content,
	);

	return $page;
}









//
// Общие функции ------------------------------------------
//

// Формируем блок с маркой кабеля
// $mark_dopinfo['type'] - тип дополнительной информации (zavod, company)
// $mark_dopinfo['text'] - выводимый текст
function genMarkLink($mark, $url, $date_add, $date_edit, $mark_dopinfo=array())
{
	$dir         = $GLOBALS['base_dir'];
	$icon        = "";
	$after_icon  = "padding-left: 25px;";
	$dop_text    = "<div class='dop_info' style='padding: 0 0 3px 25px;'>&nbsp;</div>";
	$flag_update = false;

	if( $date_edit > date('Y-m-d H:i:s', (time()-15*24*60*60)) )
	{
		$flag_update = true;
		$text_update = '<span style="color: #ff6600;">Обновлено: '.dateTransform($date_edit).'</span>';
		$icon        = "<img src='".$dir."/i/icon-point-15x15-orange.png' width='15' height='15'>";
	}
	if( $date_add > date('Y-m-d H:i:s', (time()-30*24*60*60)) )
	{
		$flag_update = true;
		$text_update = '<span style="color: #ff6600;">Добавлено: '.dateTransform($date_add).'</span>';
		$icon        = "<img src='".$dir."/i/icon-point-15x15-orange.png' width='15' height='15'>";
	}

	if( sizeof($mark_dopinfo) > 0 && $flag_update)
	{
		if($mark_dopinfo['type'] == 'zavod')
			$icon = "<img src='".$dir."/i/icon-zavod-15x15-orange.png' width='15' height='15'>";
		elseif($mark_dopinfo['type'] == 'company')
			$icon = "<img src='".$dir."/i/icon-company-15x15-orange.png' width='15' height='15'>";
	}
	elseif( sizeof($mark_dopinfo) > 0 )
	{
		if($mark_dopinfo['type'] == 'zavod')
			$icon = "<img src='".$dir."/i/icon-zavod-15x15.png' width='15' height='15'>";
		elseif($mark_dopinfo['type'] == 'company')
			$icon = "<img src='".$dir."/i/icon-company-15x15.png' width='15' height='15'>";
	}

	if($mark_dopinfo['text'] != "" && $flag_update)
		$dop_text = "<div class='dop_info'>".$text_update."<br>".$mark_dopinfo['text']."</div>";
	elseif($mark_dopinfo['text'] != "")
		$dop_text = "<div class='dop_info'>".$mark_dopinfo['text']."</div>";
	elseif($flag_update)
		$dop_text = "<div class='dop_info'>".$text_update."</div>";

	if($icon != "") $after_icon = "padding-left: 5px;";

	//$link = "\n<div class='kppMark'><div class='kpp_link'>".$icon."<span style='".$after_icon."'><a href='".$dir."/mark/".$url."/'>".$mark."</a></span></div>".$dop_text."</div>";
	$link = "\n<div class='kppMark'><a href='".$dir."/mark/".$url."/'><div class='kpp_link'>".$icon."<span style='".$after_icon."'>".$mark."</span></div></a>".$dop_text."</div>";

	return $link;
}

// по-сути, эта функция была нужна только в процессе разработки, чтобы можно было быстро менять директорию разработки
function genLink($title, $url)
{
	$dir  = $GLOBALS['base_dir'];

	$link = "<a href='".$dir."/".$url."'>".$title."</a>";

	return $link;
}
function getCompanyInfo($cmp_id, $zavod=false)
{
	if($zavod)
		$z = GetDB("SELECT forma_sob, title, seo_title, visible FROM company WHERE id = '".$cmp_id."' and ( uslugi like '______1%' OR uslugi like '_____1%')");
	else
		$z = GetDB("SELECT forma_sob, title, seo_title, visible FROM company WHERE id = '".$cmp_id."'");

	if(sizeof($z) > 0)
	{
		$cmp['title']     = $z[0]['title'];                              // без формы собственности - для краткости
		$cmp['fulltitle'] = cmpName($z[0]['forma_sob'], $z[0]['title']); // с формой собственности
		$cmp['seo_title'] = $z[0]['seo_title'];
		if($zavod)
			$cmp['url']   = '/company/'.$z[0]['seo_title'].'/';
		else
			$cmp['url']   = '/company/'.$z[0]['seo_title'].'/';
		$cmp['visible']   = $z[0]['visible'];

		return $cmp;
	}
	else return false;
}
// Получаем родителя со всеми потомками
// $mark_id - родитель
// $without_id - исключить из списка
function getMarkChildes($mark_id, $without_id=0)
{
	$dir = $GLOBALS['base_dir'];

	$childes = GetDB("SELECT id, mark, url_title, subtitle, zavod_id, company_id, date_add, date_edit FROM rc_kpp_marks WHERE visible = '1' and zavod_id != '0' and (id = '".$mark_id."' or parent_id='".$mark_id."') and id != '".$without_id."'");

	if(sizeof($childes) > 0)
	{
		$txt = '';
		for($i=0; $i<sizeof($childes); $i++)
		{
			$zavod = getCompanyInfo($childes[$i]['zavod_id'], true);

			//$txt .= genMarkLink($title, $childes[$i]['url_title'], $childes[$i]['date_add'], $childes[$i]['date_edit']);
			$txt .= '<p style="width: 240px; overflow: hidden; float: left; margin-bottom: 5px;"><a href="'.$dir.'/mark/'.$childes[$i]['url_title'].'/">'.$zavod['title'].'</a></p>';
		}
		return $txt;
	}
	else
		return false;
}
function dateTransform($date)
{
	$dt = explode(' ', $date);
	$d  = explode("-", $dt[0]);

	if( $dt[0] == date("Y-m-d") )
	{
		$sdate  = "сегодня";
	}
	elseif( $dt[0] == date("Y-m-d", mktime(0, 0, 0, date("m"), (date("d")-1), date("Y"))) )
	{
		$sdate  = "вчера";
	}
	else
	{
		$sdate  = $d[2].".".$d[1].".".$d[0];
	}

	return $sdate;
}
function cmpName($forma, $name)
{
	$name = trim($name);
	$name = preg_replace('/^"/', "", $name);
	$name = preg_replace('/"$/', "", $name);
	$name = preg_replace('/^«/', "", $name);
	$name = preg_replace('/»$/', "", $name);
	$name = trim($name);

	$name = str_replace(' "', " «", $name);
	$name = str_replace('" ', "» ", $name);

	if($forma != '') $name = "«".$name."»";
	elseif(strpos($name, "«") > 0) $name = $name."»";
	elseif(strpos($name, "»") > 0) $name = "«".$name;

	// AV: 28.11.2013: костыль для СУПРа
	//if($id == 2110) $title2=$title;

	$forma = fnc_strtoupper($forma);

	$res   = $forma." ".$name;

	return $res;
}
function getImgSrc($filename, $size='')
{
	$img_dir  = '/fupload';

	if($size != '')
	{
		$img_arr = explode("/", $filename);
		$img_src = $img_dir.'/'.$img_arr[0].'/'.$img_arr[1].'/'.$size.'-'.$img_arr[2];
	}
	else
	{
		$img_src = $img_dir.'/'.$filename;
	}

	if(file_exists($_SERVER['DOCUMENT_ROOT'].$img_src))
		return $img_src;
	else
		return false;
}

function getEnvironment($page_subdir, $page_filename)
{
	// никаких дополнительных проверок на корректность имени файла и директории не делаем, т.к. все это уже пройдено
	// и предполагаем, что логика данных не нарушена - т.е. на странице с мониторингом в админке все ОК

	$env = array();

	if($page_subdir == '')
	{
//		if($page_filename == '')
//		elseif($page_filename == 'all.html')
	}
	elseif($page_subdir == 'group')
	{
		if($page_filename != 'index.html')
		{
			$cat = GetDB("SELECT cat_id FROM rc_kpp_groups WHERE url_title='$page_filename'");
			$env['cat_id'] = $cat[0]['cat_id'];
		}
	}
//	elseif($page_subdir == 'zavod')
//	{
//		if($page_filename == 'index.html')
//		else
//	}
//	elseif($page_subdir == 'company')
//	{
//		if($page_filename == 'index.html')
//		else
//	}
	elseif($page_subdir == 'mark')
	{
		if($page_filename != 'index.html')
		{
			$mark = GetDB("SELECT id FROM rc_kpp_marks WHERE url_title='$page_filename'");
			$env['mark_id'] = $mark[0]['id'];

			$group = GetDB("SELECT group_id FROM rc_kpp_marks_groups WHERE mark_id='".$env['mark_id']."'");
			$cat   = GetDB("SELECT cat_id FROM rc_kpp_groups WHERE id='".$group[0]['group_id']."'");
			$env['cat_id']  = $cat[0]['cat_id'];
		}
	}

	return $env;
}
?>
<? include("../footer.php");
?>
