<?php

// kontrola zda vstup chybí, nebo zda neobsahuje apostrof

$token = trim($_GET['token']);
if(empty($token))
{
    echo "chybí kód";
    exit;
}

if (strpos($token, "'") > -1 ) { 
   echo "špatný kód";
    exit; 
}

$token = filter_var($token, FILTER_SANITIZE_STRING);


// připojení k DB

require_once ("db.ini");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $conn->prepare('SELECT confirmed, token FROM hlasovani WHERE token = :token');
    $stmt->bindParam(':token', $token); 
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_NUM);

    //echo "<pre>";
    //print_r($result);
    //echo "</pre>";

//kontrola, zda již tento token v databázi nebyl použít pro confirmed hlas

    if ($result[0][1] == $token and $result[0][0] == 1 ) {

    $conn = null;

    $newURL = "http://localhost:8888/horacek_to_wordpress/hlasovani-dvojite";

//pokud ano, směřujeme zpět na web

    header('Location: '.$newURL);
   
    }



//pokud ne, updatuje se confirmed na 1

    

    $sql = "UPDATE hlasovani SET confirmed=1 WHERE token='" . $token ."'";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo $stmt->rowCount() . " records UPDATED successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br> Error: " . $e->getMessage();
    }

$conn = null;

$newURL = "http://localhost:8888/horacek_to_wordpress/hlasovani-kontrola";

header('Location: '.$newURL);
?>





