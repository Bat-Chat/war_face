<?php 

/** 
* We establish the charset and level of errors 
* Устанавливаем кодировку и уровень ошибок 
*/ 
    header("Content-Type: text/html; charset=utf-8"); 
    //error_reporting(E_ALL);  
error_reporting(0);

	session_start();

 /** 
* Installation of a key of access to files 
* Установка ключа доступа к файлам 
*/ 
	define('KEY', true); 
	define('IRB_KEY', true);  
   
/** 
* We connect a configuration file 
* Подключаем конфигурационный файл 
*/ 	
	include  dirname(dirname(__FILE__)) .'/config.php'; 
	
/**  
* Debug  
* Дебаггер 
* @TODO To clean in release 
*/ 
//   define('IRB_TRACE', true);
//   include IRB_ROOT.'/debug.php'; 
   
    include IRB_ROOT.'/mail/mail.php';  