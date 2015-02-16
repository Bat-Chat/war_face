<?php

define('DBSERVER', 'mysql.local'); #Сервер БД
define('DBUSER', 'denis'); #Пользователь БД
define('DBPASSWORD', 'denisdenisik'); #Пароль БД
define('DATABASE', 'flash_games'); #Название базы

if(!isset($db_connect))
{
	$db_connect = db_connect(DBSERVER, DBUSER, DBPASSWORD, DATABASE);
	define('CONNECT', $db_connect);
}

?>