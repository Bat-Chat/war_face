<?php
	$file_url = 'files/WarfaceLoader.exe';
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
	header('Content-Length: '.filesize($file_url)); 
	readfile($file_url);
?>
