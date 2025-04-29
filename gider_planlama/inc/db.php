<?php
// inc/db.php 
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gelirgider";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
}
?>

















