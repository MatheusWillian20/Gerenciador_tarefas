<?php
require_once('../database/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $description = $_POST['description'] ?? '';
    $prioridade = $_POST['prioridade'] ?? 'Média';

    if (!empty($id) && !empty($description)) {
        $stmt = $pdo->prepare("UPDATE task SET description = :description, prioridade = :prioridade WHERE id = :id");
        $stmt->execute([
            ':description' => $description,
            ':prioridade' => $prioridade,
            ':id' => $id
        ]);
    }
}

header("Location: ../index.php");
exit;