<?php

// Consulta principal
function consultaPrincipal($pdo) {
    $consulta = "SELECT * FROM country";
    $stmt = $pdo->prepare($consulta);
    $stmt->execute();
    return $stmt;
}

// Consulta secundaria
function consultaSecundaria($pdo, $poblacion) {
    $consulta = "SELECT Name, Population FROM country WHERE Population > :poblacion ORDER BY Population DESC";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':poblacion', $poblacion, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

// Consulta terciaria
function consultaTerciaria($pdo, $tipo_gobierno) {
    $consulta = "SELECT Name, GovernmentForm, Code FROM country WHERE GovernmentForm = :tipo_gobierno ORDER BY Code ASC";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':tipo_gobierno', $tipo_gobierno);
    $stmt->execute();
    return $stmt;
}
?>
