<?php 
/** 
* Establish the charset and level of errors 
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
			

/**аа
* Connecting configuration files 
* Подключаем конфигурационные файлы 
*/ 	

	include  'config.php';
    include PROCESSING_PATH . '/config_c.php'; 		 

/** 
* Connecting file with general functions 
* Подключаем файлы с общими функциями
*/   
    include PROCESSING_PATH . '/libs/default_c.php';     
	include IRB_ROOT.'/libs/default.php';

/** 
* Working with DB
* Работа с БД
*/

    include PARTNER_PATH . '/libs/mysql.php';    	

/** 
* Connecting script with statistic
* Подключаем скрипт подсчета статистики
*/  	

    include PROCESSING_PATH . '/processing_request.php';

/**
*  Checking version
* Определение версии
*/   

	include PROCESSING_PATH . '/libs/check_adv_c.php';
	include_once PROCESSING_PATH . '/billing_config/' . strtolower(BILLING_SUBS) .'/'. BILLING_SCHEME .'/b_config.php';
	if(!isset($_POST['number'])) include_once PROCESSING_PATH . '/billing_config/'. strtolower(getFlashMessage('billing_pseudo', BILLING_PSEUDO, false)) .'/short_number.php';
	 	$partner = billing_id();
	$footer = str_replace('MEGAFON_STOP_PREFIX', MEGAFON_STOP_PREFIX, FOOTER);
	$footer = str_replace('BEELINE_STOP_PREFIX', BEELINE_STOP_PREFIX, $footer);
 	if(HOST_NAME != APPROVED_DOMAIN)
 		$footer = str_replace('APPROVED_DOMAIN', APPROVED_DOMAIN, $footer);
 	else
		$footer = str_replace('Сайт является клоном APPROVED_DOMAIN.', '', $footer);
 	define('FOOTER_M', $footer);
	 
	 include 'libs/database.php';
	 include 'libs/top.php';
	 include 'libs/session_social.php';

/** 
* The switch of modules 
* Переключатель страниц 
*/       

	include IRB_ROOT . '/router.php';