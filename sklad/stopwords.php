<?
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//====================================================
include("../droot.php");

//====================================================

// Административный модуль раздела 'Склад'

//====================================================

// подключаем конфиг

include_once("$DOCUMENT_ROOT/$document_admin/config.php");

// подключаем функции работы с базой

include_once("$DOCUMENT_ROOT/func.inc");

// добавляем новый элемент в массив навигации

$site_nav[]=array("name"=>"Просмотр позиций","url"=>"/$document_admin/sklad/stopwords.php");

//====================================================

// ПЕРЕМЕННЫЕ

//====================================================



// имя таблицы в MySQL

$mysql_tablename="sklad_stop_words";
// поля
/*
0 - fld_field    - имя поля в базе
1 - fld_type     - тип поля (через "|" прописываются дополнительные параметры (свои для каждого типа))
2 - fld_name     - название поля для отображения
3 - fld_form     - вид элемента формы (TEXT, TEXTAREA, RADIO, CHECKBOX, LISTBOX, FILE, HIDDEN,LISTDB|<название таблицы|поле с ID| поле со значением>, 
VISIBLE,MULTISELECT|<название таблицы|поле с ID| поле со значением>)
4 - fld_fill     - обязательно для заполнения (FILL)
5 - fld_showadd  - отображать поле при добавлении (SHOW ADD)
6 - fld_showedit - отображать поле при изменении (SHOW EDIT)
7 - fld_preview  - отображать поле в общем списке записей таблицы (PREVIEW|NO PREVIEW)
8 - fld_comment  - комментарии к элементу формы
*/

$db_fields=array();
$db_fields[]=array('id',		       'INT',		'ID',					'TEXT|5',	'',	'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('word',		       'VARCHAR|255',	'Слово',			'TEXT|255',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');



// Поле с ID
$db_id_field='id';
// Параметры сортировки
$db_sort='ORDER BY word';
// Количество записей на странице
$rows_onpage=40;
//====================================================
// подключаем движок
db_connect();

//====================================================
// подключаем движок

require ("$DOCUMENT_ROOT/$document_admin/engine.php");

?>
