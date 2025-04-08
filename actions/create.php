<?php
require_once('../database/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $prioridade = $_POST['prioridade'] ?? 'Média';

    if (!empty($description)) {
        $stmt = $pdo->prepare("INSERT INTO task (description, prioridade) VALUES (:description, :prioridade)");
        $stmt->execute([
            ':description' => $description,
            ':prioridade' => $prioridade
        ]);
    }
}

header("Location: ../index.php");
exit;