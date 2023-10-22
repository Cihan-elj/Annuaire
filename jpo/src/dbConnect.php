<?php
session_start();

$configFile = file_get_contents("src/dbConnect.json");
$configData = json_decode($configFile, true);

$db_name = $configData["db_name"];
$host = $configData["host"];
$username = $configData["username"];
$password = $configData["password"];
$port = $configData["port"];


// $db_name = "annuaire_nws";
// $host = "localhost";
// $username = "cihan";
// $password = "root";
// $port = 3306;

try{
    $connection = new PDO("mysql:dbname={$db_name};host={$host};port={$port}", $username, $password);
    
    // echo "La connexion a la bdd est réussi";
}   catch (PDOException $e){
    echo "Erreur PDO : " . $e->getMessage();
}

$_SESSION["connection"]=$connection;

?>