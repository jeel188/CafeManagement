<?php
$host = 'localhost';
$dbName = 'cafe_manage';
$user = 'root'; //Default username for XAMPP
$password = ''; //No password set in XAMPP
$database  = new mysqli($host,$user,$password,$dbName);
if ($database->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}else{
    // echo"Connected To Database";
    
}
?>