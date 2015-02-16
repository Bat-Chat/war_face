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
	
	   
/**  
* Array of variables for GET-parametres  
* Массив переменных для GET-параметров  
*/  
    $GET = array(  
                  'page' => 'main',
				  'action' => '',
				  'id' => 0,
				  'hand' => 1
                );  
				
/**  
* Initialization of variables GET-parametres  
* Инициализация переменных GET-параметров  
*/  
    if(IRB_REWRITE == 'on' && !empty($_GET['route']))  
    {  
        $get = explode('/', trim($_GET['route'], '/'));  
        $i = 0;  

        foreach($GET as $var => $val)  
        {  
            if(!empty($get[$i]))  
               $GET[$var] = $get[$i];  

            ++$i;  
        }  
    }  
    elseif(count($_GET))  
    {  
        foreach($GET as $var => $val)  
            if(!empty($_GET[$var]))  
                $GET[$var] = $_GET[$var];      
    } 				   


/** 
* Function of processing of data for a conclusion in a stream 
* Функция обработки данных для вывода в поток  
*/                                                     
    function htmlChars($data)    
    {    
        if(is_array($data))             
            $data = array_map("htmlChars", $data);  
        else               
            $data = htmlspecialchars($data);    
                                 
        return $data; 
    }

/** 
* We kill magic inverted commas 
* Убиваем магические кавычки 
*/         
    function stripslashesDeep($data)     
    {     
        if(is_array($data))      
            $data = array_map("stripslashesDeep", $data);      
        else    
            $data = stripslashes($data);      
        return $data; 
    } 

    if(get_magic_quotes_gpc())  
    {  
        $_GET = stripslashesDeep($_GET);   
        $_POST = stripslashesDeep($_POST);   
        $_COOKIE = stripslashesDeep($_COOKIE);  
    }
	
	function TranslateIt($text, $direct = 'ru_en') 
	{ 
	
	$L['ru'] = array( 
						  'Ё', 'Ж', 'Ц', 'Ч', 'Щ', 'Ш', 'Ы',  
						  'Э', 'Ю', 'Я', 'ё', 'ж', 'ц', 'ч',  
						  'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А',  
						  'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И',  
						  'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',  
						  'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ъ',  
						  'Ь', 'а', 'б', 'в', 'г', 'д', 'е',  
						  'з', 'и', 'й', 'к', 'л', 'м', 'н',  
						  'о', 'п', 'р', 'с', 'т', 'у', 'ф',  
						  'х', 'ъ', 'ь', ' ' 
						); 
			  
		$L['en'] = array( 
						  "YO", "ZH",  "CZ", "CH", "SHH","SH", "Y",  
						  "E", "YU",  "YA", "yo", "zh", "cz", "ch",  
						  "sh", "shh", "y", "e", "yu", "ya", "A",  
						  "B" , "V" ,  "G",  "D",  "E",  "Z",  "I",  
						  "J",  "K",   "L",  "M",  "N",  "O",  "P",  
						  "R",  "S",   "T",  "U",  "F",  "X",  "", 
						  "",  "a",   "b",  "v",  "g",  "d",  "e",  
						  "z",  "i",   "j",  "k",  "l",  "m",  "n",   
						  "o",  "p",   "r",  "s",  "t",  "u",  "f",   
						  "x",  "",  "", "_"  
						); 
	 
		// Конвертируем хилый и немощный в великий могучий... 
		if($direct == 'en_ru') 
		{ 
			$translated = str_replace($L['en'], $L['ru'], $text);         
			// Теперь осталось проверить регистр мягкого и твердого знаков. 
			$translated = preg_replace('/(?<=[а-яё])Ь/u', 'ь', $translated); 
			$translated = preg_replace('/(?<=[а-яё])Ъ/u', 'ъ', $translated); 
		} 
		else // И наоборот 
			$translated = str_replace($L['ru'], $L['en'], $text);         
		// Возвращаем получателю. 
		return $translated; 
	} 
	
	/**
* Function of reading of templates
* Функция чтения шаблонов
*/  
    function getTpl($tpl)
    {
        if(file_exists(IRB_ROOT .'/skins/' . IRB_SKIN . '/tpl/'. $tpl .'.tpl'))
            return file_get_contents(IRB_ROOT .'/skins/' . IRB_SKIN . '/tpl/'. $tpl .'.tpl');
        else
            die('The template <b>'. $tpl .'.tpl</b> is absent in the specification');
    }       
    
/**
* Function of analysis of a template
* Функция разбора шаблона
*/     
    function parseTpl($cont, $data = '')
    {
        
        if(is_array($data))
        {                
                    
            extract($data);

                ob_start();
                eval('?>'. $cont .'<?php '); 
                $cont = ob_get_contents();  
                ob_end_clean();  
    
        }

       return $cont;
    }	
	
	function menu($array,$selected="")
	{
		$selected = intval($selected);
		foreach($array as $key => $value)
		{	
			if($selected == $key)
				$out .= '<li class="active"><a href="'.src('?page=member&action=cat&id=','').$key.'">'.$value.'</a></li>'."\n";	
			else
				$out .= '<li><a href="'.src('?page=member&action=cat&id=','').$key.'">'.$value.'</a></li>'."\n";
		}
		return $out;
	}


