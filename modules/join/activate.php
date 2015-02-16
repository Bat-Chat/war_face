<?php   
    if(!defined('KEY'))
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    } 
	
	
	$path = '';
    $error = '';
    deleteFlashMessage('captcha');

	if($GET['action'] == 'j2')
	{
		include PROCESSING_PATH . '/sms/join_c.php';
		include PROCESSING_PATH . '/sms/activate_c.php';
	}

    $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : '';

    if (isset($_POST['enter']))
    {
        //Проверочный доступ в мемберку
        if ($pincode == 'enter')
        {
	        $check = true;
	        $_SESSION['vhod'] = true;
			$path = '/' . PATH . '?page=member';
        } 
		
		if($path == '')
		{         
			$number = getFlashMessage('number', '', false);
        	$number = ($number)? $number : getArr($_COOKIE, 'number');

			if($GET['action'] == 'j2') // СМС
			{
				$c_id = $_POST['country_id'];
				$country_id = $country_tab[$c_id][8];
				$check = activate_sms($number, $pincode, $country_id);
			}		
       		elseif($b_type[$operator] == 'subs') // Подписки
			{
				if(!$number)
				{
					$error = 'Ошибка! Вернитесь назад и повторите ввод номера';
					$check = FALSE;
				}
				else
				{
					include_once PROCESSING_PATH . '/billing_config/' . strtolower(BILLING_SUBS) .'/'. BILLING_SCHEME .'/b_config.php';
					include PROCESSING_PATH . '/subs/' . strtolower(BILLING_SUBS) . '.php';

					$class = BILLING_SUBS;
					$subs = new $class();
                
					$check = $subs->activate_subs($number, $pincode);
				}
			}
			else // Псевдо
			{
				if(!$number)
				{
					$error = 'Ошибка! Вернитесь назад и повторите ввод номера';
					$check = FALSE;
				}
				else
				{
					$country = get_country($number);
					if($country == 'ru' || ($billing_pseudo = get_sng_billing($country)) === false) {
						$billing_pseudo = BILLING_PSEUDO;
					}

					include PROCESSING_PATH . '/pseudo/' . strtolower($billing_pseudo) . '/activate_c.php';
					$check = activate_psevdo($number, $pincode);
				}
			}
		}
		
		if($check)
		{
			$_SESSION['vhod'] = true;
			$path = '/' . PATH . '?page=member';
		}
		else
			$error = ($error)? $error : 'Ошибка! Неверно введен код доступа';
			
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {// Ajax
            $data['path'] = $path;
            $data['error'] = $error;
			$data['frame'] = '';
			
            echo json_encode($data);
            die();
        }
        else
        {// No Ajax
            if(!$error)
            {
				header('Location: '. $path);
                die();
            }
        }
		
    }