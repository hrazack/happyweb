<?php
$host = "localhost";
$db_name = "happyweb";
$user = "user";
$password = "";
$db = new ezSQL_pdo('mysql:host='.$host.';dbname='.$db_name.';', $user, $password);
?>