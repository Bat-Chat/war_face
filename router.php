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
   		case 'downloadFile':
			include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/main/downloadFile.php';
			exit();
	   	break;

		case 'member':
			include IRB_ROOT.'/modules/main/router.php';
	   	break;
		
		case 'join':
			include IRB_ROOT.'/modules/join/router.php';
		break;
	
		default:
			include IRB_ROOT.'/modules/main/router.php';		    
	}
	
	if (TYPE == 'black')
	{
		include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/index_black.html';
	}
	else
	{
		include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/index.html';
	}