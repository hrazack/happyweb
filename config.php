<?php
//$db = new ezSQL_mysql('user','password','dbname','localhost');
$db = new ezSQL_pdo('mysql:host=localhost;dbname=dbname', 'user', 'password');
?>