<?php

$name = trim($_POST['jmeno']);
if(empty($name))
{
    echo "Nezadali jste jméno";
    exit;
}

$email = trim($_POST['email']);
if(empty($name))
{
    echo "Nezadali jste email ";
    exit;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) 
        && preg_match('/@.+\./', $email);
}

if  isValidEmail($email)  {
	echo "Neplatný email";
	exit;
}

if(empty($_POST['Filling']) || count($_POST['Filling']) > 4)
{
    $filling_error = "Vyberte maximálně 4 interprety";
    $error=true;
}
 
$filling = $_POST['Filling'];

echo '<pre>'.print_r($_POST,true).'</pre>';
?>