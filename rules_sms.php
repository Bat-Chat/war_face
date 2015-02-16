<?php 
		
/*/ Установим ключ доступа к файлам */
    define ('IRB_KEY', true);
	define ('KEY', true);

/*/ Подключение файла конфигурации */
    include(dirname(__FILE__) .'/config.php'); 
	
	function parseTpl($cont, $data = '')  
	{  
		if(is_array($data))  
		{ 
			ob_start();  
				eval('?>'. $cont .'<?php ');  
				$cont = ob_get_contents(); 
			ob_end_clean(); 
		}  
		return $cont;  
	}  	
	
	$rules = file_get_contents('http://limoncash.com/rules/smsdostup/rules.html ');
	$rules = parseTpl($rules, array());	
	echo $rules;

?>
