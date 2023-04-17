<?php 


function redirector($long_url){

    if(isset($long_url)){
        header("Location: $long_url");
        exit;
    }
}

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri_parts = explode('/', $request_uri);
$short_url = end($request_uri_parts);

$dsn = 'mysql:host=localhost;dbname=url_shortener';
$username = 'root';
$password = '';
$pdo = new PDO($dsn, $username, $password);
$stmt = $pdo->prepare("SELECT long_url FROM urls WHERE short_url = ?");
$stmt->bindParam(1,$short_url);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$long_url = $row['long_url'];



redirector($long_url);



if (!isset($long_url)){
    http_response_code(404);
    echo 'Page not found.';
}

?>