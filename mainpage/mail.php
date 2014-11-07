<?php 
$to = 'ant1freezeca@gmail.com';
$subject  = "[HubPay Contact] ";

$name = stripslashes($_REQUEST['name']); 
$email = stripslashes($_REQUEST['email']); 
$company = stripslashes($_REQUEST['company']);

$msg  = "From: ".$name."\r\n";
$msg .= "E-mail: ".$email."\r\n";
$msg .= "Company: ".$company."\r\n";
$msg .= "Subject: ".$subject."\r\n\n";
$msg .= "\r\n\n"; 

$mail = @mail($to, $subject, $msg, "From:".$email);

if($mail) {
	echo 'Ваша заявка была успешно отправлена. Мы свяжемся с вами очень скоро :)';
} else {
	echo 'Заявка не ушла :( Попробуйте еще раз, пожалуйста.';
}
?>