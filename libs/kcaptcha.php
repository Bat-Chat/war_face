<?php

// Начинаем сессию, далее мы добавим в нее ключ 
    session_start(); 

// Получаю строку из пяти случайных символов 
    $string = getRandomString(5, 'int'); 

// Задаем размеры капчи (самой картинки) в пикселях 
    $width = 108; 
    $height = 25; 

// Строим пустое изображение. К высоте добавляется 15 пикселей, это будет белая 
// полосочка снизу с текстом "press to change" 
    $captcha = imagecreatetruecolor($width, $height); 

// Получаю случайный цвет для фона 
    $bg = imagecolorallocate($captcha, mt_rand(10, 50), mt_rand(10, 50), mt_rand(10, 50)); 

// Определяю цвет фона для строки 
    $font_color = imagecolorallocate($captcha, mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255)); 

    $white = imagecolorallocate($captcha, 255, 255, 255); 
    $black = imagecolorallocate($captcha, 0, 0, 0); 

// Заливаю капчу цветом фона, но оставляю снизу белую полоску 
    imagefill($captcha, 0, 0, $white); 
    imagefilledrectangle($captcha, 0, 0, $width, $height, $bg); 

// Пишу эту случайную строку в капче 
    imagestring($captcha, 5, 33, 4, $string, $font_color); 

// Сохраняю строку в сессии 
    $_SESSION['kcaptcha'] = $string; 

// Отсылаем заголовок браузеру, что ему сейчас будет передана картинка 
    header('Content-type: image/png'); 

// Отсылаем картинку в стандартный выходной поток (в браузер) 
    imagepng($captcha); 


/** 
 * Генерирует строку случайных символов 
 *  
 * @param int $length  - длина строки 
 * @param string $case - регистр генерируемых символов, может быть lower, upper, 
 *                       both. Если не передан ни один из вышеперечисленных, то 
 *                       используется lower 
 * @return string - строка, состоящая из случайных символов заданной длины 
 *                     
 */ 
    function getRandomString($length, $case = 'lower')  
    { 
        /* Латинские символы, похожие на символы кирилицы: 
         * в ниженем регистре: a b c e o p x l
         * в верхнем регистре: A B C E H K M O P T X 
         */ 
        $ban_chars = array('a', 'b', 'c', 'e', 'o', 'p', 'x', 'l', 
                           'A', 'B', 'C', 'E', 'H', 'K', 'M', 'O', 'P', 'T', 'X'); 

        // В зависимости от $case формирую массив диапазонов символов, из которых 
        // можно выбирать 
        switch ($case)  
        { 

            case 'int': 
                $random_chars = array_merge(range(0, 9)); 
            break;            
			
			case 'upper': 
                $random_chars = range('A', 'Z'); 
            break; 

            case 'both': 
                $random_chars = array_merge(range('a', 'z'), range('A', 'Z')); 
            break; 

            case 'lower': 
            default: 
                $random_chars = range('a', 'z'); 
            break; 
        } 
    // Добавляю цифр (ноль похож на O_o, по этому игнорируем) 
        $random_chars = array_merge(range(1, 9), $random_chars); 
    // Удаляю неоднозначные символы 
        $random_chars = array_diff($random_chars, $ban_chars); 
    // Перемешиваю массив 
        shuffle($random_chars); 
    // Беру первые $length элементов 
        $chars = array_slice($random_chars, 0, $length); 
    // Соединяю их в строку и - марш на выход. 
        return implode('', $chars); 
    }