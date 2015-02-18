<?php 

if(!defined('IRB_KEY'))
{
	header("HTTP/1.1 404 Not Found");
	exit();
}

/* Переадресация в мемберку, если есть вход */

if (isset($_SESSION['vhod']))
{
	header('Location: ?page=member');
	exit();
}

ob_start();

if(isset($_GET['page']) && $_GET['page'] == 'download') {
	include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/main/download.html';
} else {
	include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/main/main.html';
}

$content = ob_get_contents();
ob_end_clean();