<?php 

/**
* Generation of page of an error at access out of system
* Генерация страницы ошибки при доступе вне системы
*/
if(!defined('IRB_KEY'))
{
	header("HTTP/1.1 404 Not Found");
	exit();
} 

### class to work with subscriptions ###
class subs {
	private $sid = CONTENT_PROGECET_ID;
    public $ip;
	
	public function __construct($ip)
	{
	    $this->ip = $ip;
	}
	
	function do_request($params = array()) {
		# set user agent
		$old_ua = @ini_set('user_agent', 'code_checker');
		#make request
		$result = @file_get_contents('http://d.userend.info/subs/?'.http_build_query($params));
		if ($result !== false) {
			# everything ok, parse it
			preg_match('|<code>(.*?)</code>|is', $result, $code_raw);
			$code = trim($code_raw[1]);
			preg_match('|<desc>(.*?)</desc>|is', $result, $info_raw);
			$info = trim($info_raw[1]);
			preg_match('|<extra>(.*?)</extra>|is', $result, $id_raw);
			$id = !empty($id_raw[1]) ? trim($id_raw[1]) : NULL;				
		
			return array('code' => $code, 'info' => $info, 'id' => $id);
		} else {
			return array('code' => 500, 'info' => $this->translate('technical_error'));
		}
	}
	
	function check_provider($phone) 
    {
        if(strlen($phone) == 11)
        {
            if(preg_match('/^7(91|98)/', $phone))
                $provider = 'mts';
            elseif (preg_match('/^7(903|905|906|909|96)/', $phone))
                $provider = 'beeline';
            elseif (preg_match('/^7(92|93)/', $phone))
                $provider = 'megafon';
            elseif (preg_match('/^7/', $phone))
                $provider = 'other';
            else
                $provider = 'wrong';
        } 
        else
            $provider = 'wrong';
        
        return $provider;
    }

	function create_subs($phone) {
		$params = array(
			'command' => 'create',
			'sid' => $this->sid,
			'phone' => $phone,
			'ip' => $this->ip,
			'limit_ip' => 30,
		);
		$response = $this->do_request($params);
		return $response;
	}

	function check_phone($phone) {
		$params = array(
			'command' => 'check_phone',
			'sid' => $this->sid,
			'phone' => $phone,
			'ip' => $this->ip,
			'limit_ip' => 30,			
		);
		$response = $this->do_request($params);
		return $response;
	}

	function check_pin($phone, $pin) {
		$params = array(
			'command' => 'check_pin',
			'sid' => $this->sid,
			'phone' => $phone,
			'code' => $pin,
			'ip' => $this->ip,
			'limit_ip' => 30,			
		);
		$response = $this->do_request($params);
		return $response;
	}
	
	
	function clean_msisdn($phone) {
	  $phone = preg_replace('/[^0-9]/', '', trim($phone));
	  if (substr($phone, 0, 1) == '8') {
	   $phone = '7'.substr($phone, 1);
	  }
	  if (substr($phone, 0, 1) == '9') {
	   $phone = '7'.$phone;
	  }
	
	  return $phone;

	}

	function translate($string, $lang = 'ru') {
		$langs = array (
			'ru' => array (
				'technical_error' => 'Техническая ошибка, попробуйте заново',
				'phone_blacklisted' => 'Услуга недоступна для указанного номера телефона',
				'phone_have_active_subs_already' => 'Указанный номер телефона уже подписан',
				'too_much_subs_for_phone' => 'Для данного номера превышен лимит заказов',
				'too_much_subs_for_ip' => 'Для данного IP превышен лимит заказов',
				'pin_sent_for_phone_already' => 'PIN для этого номера уже отправлен',
				'subs_not_supported_for_provider' => 'Для данного провайдера услуга недоступна',
				'subs_not_supported_for_provider megafon' => 'Для данного провайдера услуга недоступна',				
				'error_on_insert' => 'техническая ошибка, повторите заново',
				'phone_good' => 'Для указанного номера услуга доступна',
				'code_created' => 'На указанный номер телефона был отправлен код активации',
				'pin_already_active' => 'Пароль уже активирован',
				'code_retries_overlimit' => 'Превышено допустимое количество попыток ввода PIN',
				'active_code_phone_combination_not_found' => 'Указан PIN, несоответствующий переданному для телефона',
				'pin_good' => 'Услуга активирована для вашего номера телефона',
			),
		);

		return $langs[$lang][$string];
	}
}
