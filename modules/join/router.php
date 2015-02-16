<?php 
	/**
	* Generation of page of an error at access out of system
	* Генерация страницы ошибки при доступе вне системы
	*/

	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	} 	
	
	if (isset($_SESSION['vhod']) && $_GET['action'] != 'control')
	{
		header('Location: ?page=member');
		exit();
	}

	ob_start();		
    // Папки для темлейтов регистрации 
	if(TYPE == 'black')
		define("JOIN",  'join_black');
	else
		define("JOIN",  'join');	

	switch($_GET['action'])
	{		
		case 'control':
			include IRB_ROOT.'/modules/join/control.php';				
			include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/join/control.html';
		break;		

		case 'j2':
			include IRB_ROOT.'/modules/join/activate.php';
			include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/join/activate_sms.html';
		break;		

		case 'activate':
			if($_GET['operator'] == 'mts' || $_GET['operator'] == 'beeline' || $_GET['operator'] == 'megafon' || $_GET['operator'] == 'other')
			{
				$operator = $_GET['operator'];
				include IRB_ROOT.'/modules/join/activate.php';
				if($b_type[$operator] == 'subs')
				{
				    if($_GET['operator'] == 'mts')
				        include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/' . JOIN . '/activate_mts.html'; 
				    else
				        include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/' . JOIN . '/activate.html';
				}
				else
				    include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/' . JOIN . '/activate_other.html';
			}
			else
			{
				if(isset($_GET['enter']) && $_GET['enter'] == 'code') {
					include IRB_ROOT.'/modules/join/enter.php';
					include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/join/enter.html';
				} else {
					include IRB_ROOT.'/modules/join/enter_mts.php';
					include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/join/enter_mts.tpl';
				}
			}
		break;
		
		
case 'captcha':
    ob_end_clean();
    if($_GET['operator'] == 'mts')
        include IRB_ROOT.'/modules/join/captcha_mts.php';
break;

		case 'enter':
			include IRB_ROOT.'/modules/join/activate_return.php';
			include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/join/activate_return.html';
		break;

		case 'check':
			include IRB_ROOT.'/modules/join/join_captcha.php';
			include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/' . JOIN . '/join_captcha.html';		
		break;

		default:
			include IRB_ROOT.'/modules/join/join.php';
		  	include IRB_ROOT.'/skins/' . IRB_SKIN . '/tpl/' . JOIN . '/join.html';
	}

	$content = ob_get_contents();
	ob_end_clean();