<?php
session_start();
require_once('../database/conn.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description'] ?? '');
    $userId = $_SESSION['user_id'];

    if ($description !== '') {
        $stmt = $pdo->prepare("INSERT INTO task (description, completed, prioridade, user_id) VALUES (:description, false, 'Média', :user_id)");
        $stmt->execute([
            ':description' => $description,
            ':user_id' => $userId
        ]);
    }
}

header('Location: ../index.php');
exit;
