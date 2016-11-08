<?php

// sanitizace a validace jména

$name = trim($_POST['jmeno']);
if(empty($name))
{
    echo "Nezadali jste jméno";
    exit;
}

if (strpos($name, "'") > -1 ) { 
   echo "Špatný kód";
    exit; 
}

$name = filter_var($name, FILTER_SANITIZE_STRING);

// sanitizace a validace emailu

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

if (!isValidEmail($email))  {
	echo "Neplatný email";
	exit;
}

// validace počtu interpretů

if(empty($_POST['Filling']) || count($_POST['Filling']) > 4)
{
    $filling_error = "Vyberte maximálně 4 interprety";
    $error=true;
}

// převede POST na array
$interpret = $_POST['interpret'];


// doplňuje počet položek na 4 pomocí null, pokud je vybráno méně než 4 položky 
if (count($interpret) == 0) {
		$interpret_values="null,null,null,null"	;
}

if (count($interpret) == 1) {
		$interpret_values=implode("','", $interpret) . "',null,null,null"	;
}

if (count($interpret) == 2) {
		$interpret_values=implode("','", $interpret) . "',null,null"	;
}

if (count($interpret) == 3) {
		$interpret_values=implode("','", $interpret) . "',null";
}

if (count($interpret) == 4) {
		$interpret_values=implode("','", $interpret) . "'";
}


// vytváří token - devítimístné náhodné číslo + salt 

$token_hash = urlencode(crypt($email, 'kamnepuUS'));

// echo '<pre>'.print_r($_POST,true).'</pre>';


// připojení k DB 

require_once ("db.ini");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SET CHARACTER SET utf8";

    // připraví query
    $stmt = $conn->prepare($sql);

    // vykoná query
    $stmt->execute();

	$sql = "INSERT INTO hlasovani (jmeno, email, hlas1, hlas2, hlas3, hlas4, token) VALUES ('$name', '$email', '$interpret_values, '$token_hash')";

    // připraví query
    $stmt = $conn->prepare($sql);

    // vykoná query
    $stmt->execute();

//echo "Záznam přidán";

    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

// vytvoření URL s potvrzovacím skriptem

$confirm_url = "http://localhost:8888/horacek_to_wordpress/confirm.php?token=" . $token_hash;


// připojení k mandrill API - API_key je v db.ini



require_once 'mandrill-api-php/src/Mandrill.php'; 

try {
    $mandrill = new Mandrill($API_key);
    $message = array(
        'html' => '<p>Pro potvrzení vašeho hlasování na festivalu Písně s příběhem prosím <a href="' . $confirm_url . '">klikněte na tento odkaz</a>.</p>',
        'text' => 'Pro potvrzení vašeho hlasování na festivalu Písně s příběhem prosím jděte na stránku'. $confirm_url,
        'subject' => 'Potvrzení hlasování na festivalu Písně s příběhem',
        'from_email' => 'michal.berg@plnu.cz',
        'from_name' => 'Festival Písně s příběhem',
        'to' => array(
            array(
                'email' => $email,
                'name' => $name,
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'michal.berg@plnu.cz'),
        'important' => false,
        'track_opens' => true,
        'track_clicks' => true,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => true,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
    );
	
    $async = false;
    $result = $mandrill->messages->send($message, $async);
    // print_r($result); - pokud chci vypsat výsledek api callu

    /* - odpověď API, pokud by byla potřeba
    Array
    (
        [0] => Array
            (
                [email] => recipient.email@example.com
                [status] => sent
                [reject_reason] => hard-bounce
                [_id] => abc123abc123abc123abc123abc123
            )
    
    )
    */
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'Chyba odesílání emailu: ' . get_class($e) . ' - ' . $e->getMessage();
    throw $e;
}

$newURL = "http://localhost:8888/horacek_to_wordpress/email-kontrola";

header('Location: '.$newURL);

?>


