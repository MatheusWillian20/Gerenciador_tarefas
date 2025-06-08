<?php
session_start();
require_once('../database/conn.php'); // Ajuste o caminho conforme sua estrutura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['login_error'] = "Por favor, preencha todos os campos.";
        header('Location: ../login.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login OK
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $user['username'];
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['login_error'] = "Usuário ou senha inválidos.";
        header('Location: ../login.php');
        exit;
    }
} else {
    // Acesso direto via GET — redirecionar para login
    header('Location: ../login.php');
    exit;
}
