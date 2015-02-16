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
    
	include IRB_ROOT.'/classes/Mailer.php'; 
	
	if (isset($_POST['send']))
	{
	 $to = 'schelpmail@gmail.com'; 
	//	 $to = 'denisg1979@gmail.com'; 
	 $subject = isset($_POST['subject'])?$_POST['subject'] : NULL ; 
	 $from = isset($_POST['email'])?$_POST['email'] : NULL ;     
	 $message = isset($_POST['message'])?$_POST['message'] : NULL ;
	 $number = isset($_POST['number'])?$_POST['number'] : NULL ;
	
	 $mail = new Mailer($message, $number);
	//     $mail -> setHtml();
	 $mail -> createTo($to);
	 $mail -> createFrom($from);
	 $mail -> createSubject($subject);
	 $error = $mail -> sendMail();
	
	if($_POST['captcha'] != $_SESSION['kcaptcha']) 
	   $error .= "\n Неверно введен защитный код"; 
	
	 if(empty($error)) 
	   header('location: ' . src('?page=mail&send=1', '') );   
	}  
	
	function success()
	{
	 $success = isset($_GET['send'])?'Сообщение успешно отправлено' : NULL ; 
	 return $success;
	}
	
	include  IRB_ROOT.'/skins/'.IRB_SKIN.'/tpl/mail/mailer.html';
	exit();
?>