<?php

$host = 'localhost';
$dbname = 'to_do_list';
$user = 'postgres';
$pass = '1234';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão com o banco: " . $e->getMessage();
    exit;
}