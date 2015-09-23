<?php

include dirname(dirname(__FILE__)).'/mail.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
include 'email_validation.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);


$error = '';

// Check name

if(!$name)
{
$error .= 'Por favor, ingresa tu nombre.<br />';
}

// Check email

if(!$email)
{
$error .= 'Por favor, ingresa tu correo.<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Por favor, ingresa un correo valido.<br />';
}

// Check message (length)

if(!$message || strlen($message) < 10)
{
$error .= "Por favor, ingresa tu mensaje. Este debe contener al menos 10 caracteres.<br />";
}


if(!$error)
{
$mail = mail(CONTACT_FORM, $subject, $message,
     "From: ".$name." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());


if($mail)
{
echo 'OK';
}

}
else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
?>