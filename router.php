<?php 

	/**
	* Generation of page of an error at access out of system
	* Генерация страницы ошибки при доступе вне системы
	*/
	if(!defined('IRB_KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	} 
    
    /** 
* The switch of modules 
* Переключатель страниц 
*/

	switch($GET['page'])  
   	{
		case 'member':
			$title = 'Онлайн игра "ИГРА ПРЕСТОЛОВ"'; #Заголовок страници мемберки мемберки
			$game_name = 'ИГРА ПРЕСТОЛОВ'; #Название пункта меню
			$white_show_menu = true; #Отображать пункт игры в меню на белой
			$black_show_menu = true; #Отображать пункт игры в меню на блеке
			$white_redirect = '?page=member&action=game&id=558'; #Редирект для белой версии
			$black_redirect = '?page=member&action=game&id=558'; #Редирект для блек версии
			include '../portal/member/router.php';
			exit();
	   	break;
		
		case 'join':
			include IRB_ROOT.'/modules/join/router.php';
		break;
	
		default:
			include IRB_ROOT.'/modules/main/router.php';		    
	}
	
	if (TYPE != 'black')
	{
		include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/index_black.html';
	}
	else
	{
		include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/index.html';
	}