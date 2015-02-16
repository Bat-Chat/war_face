<?php

if (!isset($_SESSION['throne_vk_count']))
{
	$_SESSION['throne_vk_count'] = rand(10, 90);
	setcookie('vk_vote');
	setcookie('vk_count', $_SESSION['throne_vk_count']);
}
else
{
	$_SESSION['throne_vk_count'] = $_COOKIE['vk_count'];
}

if (!isset($_SESSION['throne_ok_count']))
{
	$_SESSION['throne_ok_count'] = rand(10000, 90000);
	setcookie('ok_vote');
	setcookie('ok_count', $_SESSION['throne_ok_count']);
}
else
{
	$_SESSION['throne_ok_count'] = $_COOKIE['ok_count'];
}

if (!isset($_SESSION['throne_fb_count']))
{
	$_SESSION['throne_fb_count'] = rand(10, 90);
	setcookie('fb_vote');
	setcookie('fb_count', $_SESSION['throne_fb_count']);
}
else
{
	$_SESSION['throne_fb_count'] = $_COOKIE['fb_count'];
}

if (!isset($_SESSION['throne_mra_count']))
{
	$_SESSION['throne_mra_count'] = rand(10, 98);
	setcookie('mra_vote');
	setcookie('mra_count', $_SESSION['throne_mra_count']);
}
else
{
	$_SESSION['throne_mra_count'] = $_COOKIE['mra_count'];
}

if (!isset($_SESSION['throne_twit_count']))
{
	$_SESSION['throne_twit_count'] = rand(10, 98);
	setcookie('twit_vote');
	setcookie('twit_count', $_SESSION['throne_twit_count']);
}
else
{
	$_SESSION['throne_twit_count'] = $_COOKIE['twit_count'];
}

?>