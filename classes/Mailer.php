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

class Mailer 
{     
    public $to; 
    public $from;     
    public $subject;     
    public $message; 
    private $boundary;     
    private $headers;     
    private $multipart; 
    private $errors = array();         
/*  
Конструктор. Устанавливаем символ переноса строкии и разделитель,  
а так же готовим сообщение в текстовом виде     
*/     
    public function __construct($message = false, $number = '') 
    { 

        $this->boundary = '=='. md5(uniqid(time())); 
        
        if($message) 
        {
            $new_message = "\r\nНомер телефона: " . $number;
            $new_message .= "\r\nСайт ". SITE_NAME ."\r\n";
            $message = $new_message.$message;
            $this->message = $message; 
            $this->headers  =  '--'. $this->boundary ."\r\n";  
            $this->headers  .= "Content-type: text/plain; charset=\"utf-8\"\r\n"; 
            $this->headers  .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
            $this->multipart  = $this->headers . chunk_split(base64_encode($this->message)) ."\r\n";       
        } 
        else 
            $this->errors[] = 'Нет текста сообщения';       
    }       

# Cообщение в HTML формате   
    public function setHtml() 
    {  
        $this->multipart  =  $this->headers;  
        $this->multipart .= chunk_split(base64_encode(strip_tags($this->message))) ."\r\n";    
        $this->multipart .=  '--'. $this->boundary ."\r\n";       
        $this->multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";  
        $this->multipart .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
        $this->multipart .=  chunk_split(base64_encode($this->message)) ."\r\n";  
    }    
# Метод формирования адреса "кому"   
    public function createTo($to = false)  
    {  
        if(!$to)  
            $this->errors[] = 'There is no addressee';   
        elseif(!$this->checkEmail($to)) 
            $this->errors[] = 'Неверно введен адрес';  
        else 
            $this->to = $to; 
    }
# Метод формирования адреса "от кого"   
    public function createFrom($from = false)  
    {  
        if(!$from)     
            $this->errors[] = 'Нет е-мейла отправителя'; 
        elseif(!$this->checkEmail($from)) 
            $this->errors[] = 'Неправильный е-мейл отправителя';         
        else  
            $this->from = trim(preg_replace('/[\r\n]+/', ' ', $from));
    } 
# Метод ghjdthrb vskf    
   public function checkEmail($mail)   
   {   
       if (function_exists('filter_var'))  
           return filter_var($mail, FILTER_VALIDATE_EMAIL); 
       else 
           return preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $mail); 
   }     
        
# Метод формирования темы письма     
    public function createSubject($subject = false) 
    { 
        if($subject) 
        {
            $subject_new = 'Help ' . $subject;
            $this->subject = '=?utf-8?b?'. base64_encode($subject_new) .'?='; 
        }
        else 
            $this->errors[] = 'Нет темы письма';       
    } 
# Метод формирования заголовков    
    private function createHeader() 
    { 
        $header  = "Content-type: multipart/alternative; boundary=\"". $this->boundary ."\"\r\n";           
        $header .= "From: <". $this->from .">\r\n"; 
        $header .= "MIME-Version: 1.0\r\n"; 
        $header .= "Date: ". date('D, d M Y h:i:s O') ."\r\n"; 
        return $header;   
    }     
# Диагностика ошибок     
    private function checkData() 
    { 
        if(count($this->errors))  
            return implode("\n", $this->errors); 
        else 
            return false;   
    }      
# Отправка  
    public function sendMail() 
    {          
    
        if(!$error = $this->checkData()) 
        {    
            $header = $this->createHeader(); 
            
            if(!mail($this->to, $this->subject, $this->multipart, $header, '-f'. $this->from)) 
                return 'Отправка письма невозможна'; 
            else 
                return NULL;
        } 
        else  
            return $error;  
    }   
} 
  
