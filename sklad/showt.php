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

$site_nav[]=array("name"=>"Просмотр позиций","url"=>"/$document_admin/sklad/showt.php");

//====================================================

// ПЕРЕМЕННЫЕ

//====================================================



// имя таблицы в MySQL

$mysql_tablename="sklad_tovar";
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
$db_fields[]=array('id',		       'INT',		'ID',					'HIDDEN',	'',	'',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('comp_id',		       'VARCHAR|10',		'ID пользователя',		'TEXT|25',	'',	'SHOW ADD',			'SHOW EDIT',	'PREVIEW',		'');
$db_fields[]=array('title',		       'VARCHAR|255',	'Название',			'TEXT|255',	'FILL',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW|LINK',	'');
$db_fields[]=array('quant',		   'VARCHAR|255',	'Количество',			'TEXT|25',	'',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',	'');
$db_fields[]=array('unit_id',		       'VARCHAR|1',	'Ед. изм.',			'TEXT|1',	'',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'3 это км');
$db_fields[]=array('date_cr','VARCHAR|255','Дата добавления','TEXT|25',	'','SHOW ADD','SHOW EDIT','PREVIEW',	'');

$db_fields[]=array('views',		       'VARCHAR|5',	'Просмотров',			'TEXT|5',	'',	'SHOW ADD',	'SHOW EDIT',	'NO PREVIEW',	'');

$db_fields[]=array('visible',		       'VARCHAR|1',	'Видимость',			'TEXT|1',	'',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',	'1 или 0');

$db_fields[]=array('comments',		       'VARCHAR|3000',	'Дополн.',			'TEXT|255',	'',	'SHOW ADD',	'SHOW EDIT',	'PREVIEW',	'');




// Поле с ID
$db_id_field='id';
// Параметры сортировки
$db_sort='ORDER BY id DESC';
// Количество записей на странице
$rows_onpage=40;
//====================================================
// подключаем движок
db_connect();



//====================================================

// подключаем движок
$mass_del = true;
require ("$DOCUMENT_ROOT/$document_admin/engine1-5.php");

?>
