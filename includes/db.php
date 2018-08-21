<?php 

try{
$name = 'king_ot';
$username = 'root';
$password = '';
$host = 'localhost';
$dsn = "mysql:host=$host;dbname=$name";
$pdo = new PDO($dsn,$username,$password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
// echo 'We are connected';

}
catch(PDOException $e){
    die("Could not connect to the database " . $e->getMessage());
}