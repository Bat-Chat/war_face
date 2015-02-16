<?php   
    if(!defined('KEY'))
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    } 


    $error = '';
    $greeting = '';
    $member_code = getFlashMessage('member_code', '', false);
    $redirect_url = getFlashMessage('redirect_url', '', false);	
    deleteFlashMessage('redirect_url');
    $subscription_id = getFlashMessage('subscription_id', '', false);
    $service_id = getFlashMessage('service_id', '', false);
    $service_id = ($service_id)? $service_id : getArr($_COOKIE, 'service_id');
    
    include PROCESSING_PATH . '/subs/' . strtolower(BILLING_SUBS) . '.php';

    $class = BILLING_SUBS;
    $subs = new $class();
    $check = $subs->activate_return();

    $query_string  = (TYPE != 'black' && isset($_SESSION['q'])) ? $_SESSION['q'] : 'page=member';

    if($check)
    {
	    $_SESSION['vhod'] = true;
	    $number = isset($_SESSION['number']) ? $_SESSION['number'] : null;

	    if($number) {
		    $operator = check_provider($number);
			if($operator == 'mts') {
				header('Location: '. src('?'.$query_string,''));
				exit;
			}
		}

	    $member_code = getFlashMessage('member_code', '', false);
		$greeting .= 'Пожалуйста запишите ваш код доступа: <strong>' . $member_code . '</strong>. Он вам понадобится для дальнейшего доступа без регистрации.' . '<br />Для входа нажмите <a href="/' . PATH . '?'. $query_string .'">Сюда</a>';
    }
    else
		$error = 'Ошибка! Вернитесь назад и повторите ввод номера';