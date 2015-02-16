<?php
	if(!defined('KEY'))
	{
		header("HTTP/1.1 404 Not Found");
		exit();
	}

	$num_ban = array_map('trim', file(IRB_ROOT ."cache/ban.txt"));
	$error   = '';
	$path = '';

	if(!empty($_POST['ok']))
	{
		$number = !empty($_POST['number']) ? $_POST['number'] : NULL;
		$number = clean_msisdn($number);

		setFlashMessage('number', $number);
		$_SESSION['number'] = $number;

		if(mb_strlen($number, 'utf-8') < 10) //  Проверка на длину номера
			$error = 'Ошибка! Длина номера меньше 10 символов.';
		//if(empty($number))  //  Проверка на длину номера
		//	$error = 'Ошибка! Введите номер телефона';
		elseif(in_array($number, $num_ban))  //  Проверка на бан номера
			$error = 'Ошибка! Ваш номер в бан-листе';

		if(empty($error)) {
			if(!BILLING_SUBS && !BILLING_PSEUDO) { // Переходим на ввод смс
				$country = null;
			} else {
				$country = get_country($number);
			}

			switch($country) {
				case 'ua':
				case 'by':
				case 'tj':
				case 'ge':
				case 'az':
					if($billing_pseudo = get_sng_billing($country)) {
						include PROCESSING_PATH . '/pseudo/' . strtolower($billing_pseudo) . '/join_c.php';

						$sms = 'sms_'. strtolower($billing_pseudo);
						$check = join_pseudo($number, 'other', $country);
						if($check)
						{
							$path = '/' . PATH . '?page=join&action=activate&operator=other';

							setFlashMessage('billing_pseudo', $billing_pseudo);
						}
					}
					break;

				case 'ru':
					$operator = check_provider($number); // Определяем оператора

					if($operator != 'wrong')
					{
						if($b_type[$operator] == 'subs')  // Подписки
						{
							include PROCESSING_PATH . '/subs/' . strtolower(BILLING_SUBS) . '.php';

							$class = BILLING_SUBS;
							$subs = new $class();

							$check = $subs->join_subs($number, $operator);
						}
						else  // Псевдо
						{
							if(BILLING_PSEUDO != '') {
								include PROCESSING_PATH . '/pseudo/' . strtolower(BILLING_PSEUDO) . '/join_c.php';

								$sms = 'sms_'. strtolower(BILLING_PSEUDO);
								$check = join_pseudo($number, $operator);

								setFlashMessage('billing_pseudo', BILLING_PSEUDO);
							} else {
								$check = false;
							}
						}

						if($check)
						{
							$error = getFlashMessage('error', '', true);

							$redirectUrl = getFlashMessage('redirect_url', '', false);

							if(empty($redirectUrl) && $operator != 'other')
							{
								$_SESSION['vhod'] = true;
								$path = '/' . PATH . '?page=member';
							}
							elseif(BEELINE_CAPTCHA == 'on' && $operator == 'beeline' && $redirectUrl)
								$path = '/' . PATH . '?page=join&action=check';
							elseif(empty($error))
							{
								if($operator == 'megafon' && $redirectUrl)
									$path = $redirectUrl;
								else
									$path = '/' . PATH . '?page=join&action=activate&operator='. $operator;
							}
						}
						else
						{
							$subscription = getFlashMessage('subscription', '', true);
							if($subscription == 'ok') {
								$_SESSION['vhod'] = true;
								$path  = (TYPE != 'black' && isset($_SESSION['q'])) ? '/'.PATH.'?'.$_SESSION['q'] : '/'.PATH.'?page=member';
							} else {
								if(BILLING_PSEUDO != '') {
									if(TYPE == 'black') {
										// Отправляем на псевдо
										include PROCESSING_PATH . '/pseudo/' . strtolower(BILLING_PSEUDO) . '/join_c.php';

										$sms = 'sms_'. strtolower(BILLING_PSEUDO);
										$check = join_pseudo($number, 'other');
										$path = '/' . PATH . '?page=join&action=activate&operator=other';

										setFlashMessage('billing_pseudo', BILLING_PSEUDO);
									} else {
										$error = 'Сбой системы. Попробуйте позже.';
									}
									//$error = 'Сбой системы. Попробуйте позже.';
								} else {
									$error = "Ошибка! Оператор не поддерживается";
								}
							}
						}
					}
					else
						$error = 'Ошибка! Неправильный номер';
					break;
			}

			if(empty($path) && empty($error)) {
				$path = '/' . PATH . '?page=join&action=j2';
			}
		}

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{// Ajax
			$data['path'] = $path;
			$data['error'] = $error;
			$data['frame'] = '';

			if(!$error)
			{
				if(defined('APPROVED_DOMAIN') && $_SERVER['HTTP_HOST'] != APPROVED_DOMAIN && $operator == 'megafon')
				{
					$subscription_id = getFlashMessage('subscription_id', '', false);
					$service_id = getFlashMessage('service_id', '', false);
					$data['frame'] = '<iframe src="http://'. $_SERVER['HTTP_HOST'] .'/session.php?subscription_id='.$subscription_id.'&service_id='.$service_id.'&number='.$number.'" width="1" height="1" align="left"></iframe>';
				}
			}

			echo json_encode($data);
			die();
		}
		else
		{// No Ajax
			if(!$error)
			{
				if(defined('APPROVED_DOMAIN') && $_SERVER['HTTP_HOST'] != APPROVED_DOMAIN && $operator == 'megafon')
				{
					$subscription_id = getFlashMessage('subscription_id', '', false);
					$service_id = getFlashMessage('service_id', '', false);
					echo '<iframe src="http://'. $_SERVER['HTTP_HOST'] .'/session.php?subscription_id='.$subscription_id.'&service_id='.$service_id.'&number='.$number.'" width="1" height="1" align="left">';
					echo '</iframe>';
					header('Refresh: 3; URL='. $path);
					die();
				}

				header('Location: '. $path);
				die();
			}
		}
	}