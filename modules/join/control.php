<?php
	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	} 

	  

	$error = '';

	if (!empty($_POST['ok'])) 
	{			
		$number  = !empty($_POST['number']) ? $_POST['number'] : NULL;
		$number = clean_msisdn($number);	

		if(mb_strlen($number, 'utf-8') < 11) 
	       $error = '<span style="color: #ff0000">Ошибка! Длина номера меньше 11 символов.</span>';
		elseif(mb_strlen($number, 'utf-8') > 12) 
	       $error = '<span style="color: #ff0000">Ошибка! Длина номера слишком большая.</span>';
		else
		{
			include PROCESSING_PATH . '/control/' . strtolower(BILLING_SUBS) . '/control_c.php';

			$operator = check_provider($number); // Определяем оператора
			$check = control($number, $operator);

			if($check)
				$error = '<span style="color: #00FF00">Предоставление доступа к Подписке '.APPROVED_DOMAIN.' успешно прекращено.</span>';
			else
				$error = 'У вас нет Подписок на Контент';
		}
	}