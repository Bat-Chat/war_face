<?php  
/**
* Configuration file
* Конфигурационный файл
* @author IT studio IRBIS-team
* @copyright © 2009 IRBIS-team
*/
	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	} 

///////////////////////////////////////////////////////////////
//                THE GENERAL OPTIONS
//                  ОбЩИЕ НАСТРОЙКИ
///////////////////////////////////////////////////////////////
    define('FOLDER',  'limonbucks.com'); // папка с сайтом
    define('PATH',  'warface/'); // путь до сайта
	define('RETURN_URL',  'http://' . $_SERVER['HTTP_HOST'] . '/'.PATH .'?page=join&action=enter'); // возвратный урл после окон операторов
	define('PARTNER_PATH', '/home/sites/'. FOLDER . '/web/'); // путь к папке с партнеркой	
	define('PROCESSING_PATH', '/home/sites/'. FOLDER . '/web/processing_types/'); // путь к папке с общими скриптами
    define("IRB_SKIN",  'default'); // скин по умолчанию
	define('IMG', 'http://'. $_SERVER['HTTP_HOST'] .'/'.PATH.'/skins/'.IRB_SKIN.'/images/');	
	define('PIC_URL','http://91.202.63.117/sites-images/bonus_sites/pics/'); // путь к картинкам в черной мемберке	
define('SITE_NAME',  $_SERVER['HTTP_HOST']);

    define("US_ACTIVE",  0);
    define("US_DISABLE", 1); 

    /* hitback */
    define("HITBACK_OUR", 0);
    define("HITBACK_YOUR", 1); 

/**
* Includes mod rewrite
* Включает модуль перенаправления 
*/

    define('IRB_REWRITE', 'off');    

///////////////////////////////////////////////////////////////
//                       NOT TO CHANGE
//                        НЕ ИЗМЕНЯТЬ
///////////////////////////////////////////////////////////////  
/**
* Establishes a path to a script root for HTTP
* Устанавливает путь до корневой директории скрипта
* по протоколу HTTP
*/ 
    define('IRB_HOST', 'http://'. $_SERVER['HTTP_HOST'] .'/'.PATH);

/**
* Establishes a physical path to a root directory of a script
* Устанавливает физический путь до корневой директории скрипта
*/ 

    define('IRB_ROOT', dirname(__FILE__) .'/'); 