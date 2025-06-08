<?php
session_start();
require_once('database/conn.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Por favor, preencha todos os campos.";
    } else {
        // Verifica se usuário já existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);

        if ($stmt->rowCount() > 0) {
            $error = "Nome de usuário já está em uso.";
        } else {
            // Cria hash da senha
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insere usuário novo
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                ':username' => $username,
                ':password' => $passwordHash
            ]);

            // Redireciona para login
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="src/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="to_do" style="max-width: 400px; margin: auto; padding: 2rem;">
        <h1>Criar Conta</h1>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form action="create-user.php" method="POST" class="to-do-form">
            <input type="text" name="username" placeholder="Nome de usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit" class="form-button">
                <i class="fa-solid fa-user-plus"></i>
            </button>
        </form>
        <p style="text-align:center; margin-top: 1rem;">
            <a href="login.php" style="color:#77ccff;">Voltar ao login</a>
        </p>
    </div>
</body>
</html>
