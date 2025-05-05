<?php
require_once('../database/conn.php');

// Pega os dados enviados via POST
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$completed = isset($_POST['completed']) ? (int)$_POST['completed'] : null;

if ($id !== false && $completed !== null) {
    try {
        $sql = $pdo->prepare("UPDATE task SET completed = :completed WHERE id = :id");
        $sql->bindValue(':completed', $completed, PDO::PARAM_INT);
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID ou status inválido']);
}
exit;
