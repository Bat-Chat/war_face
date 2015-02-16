<?php   
    if(!defined('KEY'))
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    } 
	
	
	include_once PROCESSING_PATH . '/billing_config/' . strtolower(BILLING_SUBS) .'/'. BILLING_SCHEME .'/b_config.php';
	include PROCESSING_PATH . '/subs/' . strtolower(BILLING_SUBS) . '.php';

	$class = BILLING_SUBS;
	$subs = new $class();
    
	$captcha = $subs->requestCaptchaMts();

	echo $captcha;
	exit;
	/*
	header("Content-type: image/gif; charset=utf-8");
	echo $captcha;
	
	exit;*/