<?php

if( ! defined('KEY'))
{
	header("HTTP/1.1 404 Not Found");
	exit();
}

if ( ! isset($_SESSION['war_face_players_top']))
{
	$nicks = array (
		'gans231',
		'andrew_89232',
		'sasha',
		'maxim444',
		'lidsn',
		'nm666',
		'misha11',
		'mega_farmer',
		'war_men',
		'wewe00',
		'mr_big_dick'
	);

	$codes = array(917, 914, 911, 924, 928, 930, 960, 961, 915);

	$_SESSION['war_face_players_top']['nicks'] = array();
	$_SESSION['war_face_players_top']['numbers'] = array('7', '7', '7', '7', '7');
	$_SESSION['war_face_players_top']['stars'] = array();
	$_SESSION['war_face_players_top']['battles'] = array();
	$_SESSION['war_face_players_top']['hours'] = array();

	shuffle($nicks);
	shuffle($codes);

	for ($i = 0; $i < 5; $i++)
	{
		$_SESSION['war_face_players_top']['nicks'][] = $nicks[$i];
		$_SESSION['war_face_players_top']['numbers'][$i] .= $codes[$i].rand(50000, 79000).'xx';
		$_SESSION['war_face_players_top']['stars'][] = rand(5000, 9999);
		$_SESSION['war_face_players_top']['hours'][] = rand(200, 600);
		$_SESSION['war_face_players_top']['battles'][] = rand(50, 100);
	}
	
	rsort($_SESSION['war_face_players_top']['stars']);
	rsort($_SESSION['war_face_players_top']['hours']);
	rsort($_SESSION['war_face_players_top']['battles']);
}