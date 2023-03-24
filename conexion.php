<?php
// conexion a la bd
$servidor_db = "localhost";
$nombre_db = "world";
$usuario_db = "usuario_db";
$pass_db = "pass_db";
$link = "mysql:host=$servidor_db;dbname=$nombre_db";
try {
    $pdo = new PDO($link, $usuario_db, $pass_db);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
