<?php
	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	}

	$error = '';

	if(isset($_POST['enter']))
	{
		$number = getArr($_POST, 'number');
		$pincode = getArr($_POST, 'pincode');

		if(!empty($number) && !empty($pincode))
		{
			$query_string  = (TYPE != 'black' && isset($_SESSION['q'])) ? $_SESSION['q'] : 'page=member';
			//Проверочный доступ в мемберку
			if ($pincode == 'enter')
			{
				$_SESSION['vhod'] = true;
				header('Location: /' . PATH . '?'.$query_string);
				die();
			}

			$number = clean_msisdn($number);
			$operator = check_provider($number);

			if($operator != 'wrong')
			{
				include PROCESSING_PATH . '/enter/' . strtolower(BILLING_SUBS) . '/enter_c.php';

				if($b_type[$operator] == 'subs')  // Подписки
					$check = member_enter($number, $pincode, 'subs');
				else // Смс-доступ
					$check = member_enter($number, $pincode, 'sms');
			}

			if($check)
			{
				$_SESSION['vhod'] = true;
				header('Location: /' . PATH . '?'.$query_string);
				die();
			}
			else
				$error = 'Ошибка! Неверно введен Номер телефона или Код Доступа.';
		}
		else
			$error = 'Ошибка! Заполните Все поля.';
	}	