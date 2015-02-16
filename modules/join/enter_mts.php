<?php 
	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	}

	$error = '';

	if(isset($_POST['enter']))
	{
		$query_string  = (TYPE != 'black' && isset($_SESSION['q'])) ? $_SESSION['q'] : 'page=member';
		$number = getArr($_POST, 'number');
		$number = clean_msisdn($number); // Чистим номер

		if(!empty($number) && mb_strlen($number, 'utf-8') > 10) {
			$operator = check_provider($number); // Узнаем оператора

			switch($operator)
			{
				case 'mts':
					include PROCESSING_PATH . '/enter/' . strtolower(BILLING_SUBS) . '/enter_c.php';

					$check = member_enter($number, '', 'subs');

					if($check)
					{
						$_SESSION['vhod'] = true;
						header('Location: /' . PATH . '?'.$query_string);
						die();
					}
					else
						$error = 'Ошибка! Пройдите <a href="'.src('?page=join','').'">Регистрацию.</a>';
				break;

				default:
					header('location: '. src('?page=join&action=activate&enter=code', ''));
					exit;
				break;
			}
		} else {
			$error = 'Ошибка! Введите Номер телефона.';
		}
	}	