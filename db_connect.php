<?php

$host = 'localhost';
$db = 'hospital';
$user = 'root';
$password = '';
$port = '3306';

$dsn = "mysql:host=$host;port=$port;dbname=$db";

try {
    $dbh = new PDO($dsn, $user, $password);

    //error mode to Exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!";

}catch (\PDOException $e) {
    //Shows the error message
    echo "Connection failed" . $e->getMessage();
}
?>

