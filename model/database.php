<?php
$dsn = 'mysql:host=localhost;dbname=assignment_tracker';
$username = 'ehsan';
$password = '123';


try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    include('view/error.php');
    exit();
}
