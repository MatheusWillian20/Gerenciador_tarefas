<?php
session_start();
require_once('../database/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $description = trim($_POST['description'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'Média';
    $userId = $_SESSION['user_id'] ?? null;

    if ($id && $description && $userId) {
        $check = $pdo->prepare("SELECT id FROM task WHERE id = :id AND user_id = :user_id");
        $check->execute([':id' => $id, ':user_id' => $userId]);

        if ($check->rowCount() > 0) {
            $stmt = $pdo->prepare("UPDATE task SET description = :description, prioridade = :prioridade WHERE id = :id");
            $stmt->execute([
                ':description' => $description,
                ':prioridade' => $prioridade,
                ':id' => $id
            ]);
        }
    }
}

header('Location: ../index.php');
exit;
