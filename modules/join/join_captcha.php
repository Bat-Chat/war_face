<?php    
    if(!defined('KEY'))
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $error   = '';

    include PROCESSING_PATH . '/billing_config/' . strtolower(BILLING_SUBS) .'/'. BILLING_SCHEME .'/b_config.php';
    $partner = billing_id();


    if(/*BEELINE_CAPTCHA != 'on' || */TYPE != 'black')
    {
    	header('Location: /' . PATH . '?page=join');
    	die();
    }

    include PROCESSING_PATH . '/subs/' . strtolower(BILLING_SUBS) . '.php';
    $class = BILLING_SUBS;
	$subs = new $class(); 

    if(isset($_POST['captcha']))
    {
		$captcha = $subs->join_beeline_window($_POST['captcha']);
		
		if(!$captcha)
		{
			$operator = getFlashMessage('operator', '', false);
			header('Location: /' . PATH . '?page=join&action=activate&operator='. $operator);
			die();
		}
		else
		{
			//$error = 'Цифры введены неправильно';
			$error = getFlashMessage('error', '', true);
		}
    }
	else
		$captcha = $subs->join_beeline_window();