<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>
    <div id="to_do" style="max-width: 400px; margin: auto; padding: 2rem;">
        <h1>Login</h1>
        <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="actions/login.php" method="POST" class="to-do-form">
            <input type="text" name="username" placeholder="Nome de usuário" required />
            <input type="password" name="password" placeholder="Senha" required />
            <button type="submit" class="form-button">
                <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>
        <p style="text-align:center; margin-top: 1rem;">
            <a href="create-user.php" style="color:#77ccff;">Criar nova conta</a>
        </p>
    </div>
</body>
</html>
