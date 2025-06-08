<?php
session_start();
require_once('../database/conn.php');

$id = $_POST['id'] ?? null;
$completed = $_POST['completed'] === 'true' ? true : false;
$userId = $_SESSION['user_id'] ?? null;

if ($id && $userId) {
    $check = $pdo->prepare("SELECT id FROM task WHERE id = :id AND user_id = :user_id");
    $check->execute([':id' => $id, ':user_id' => $userId]);

    if ($check->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE task SET completed = :completed WHERE id = :id");
        $stmt->execute([
            ':completed' => $completed,
            ':id' => $id
        ]);
    }
}
