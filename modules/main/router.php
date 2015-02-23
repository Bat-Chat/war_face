<?php 

if(!defined('IRB_KEY'))
{
	header("HTTP/1.1 404 Not Found");
	exit();
}

ob_start();

/* Отображать страницу со скачиванием игры, если есть вход */
if (isset($_SESSION['vhod']))
{
	include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/main/download.html';
} else {
	include IRB_ROOT.'skins/'.IRB_SKIN.'/tpl/main/main.html';
}

$content = ob_get_contents();
ob_end_clean();