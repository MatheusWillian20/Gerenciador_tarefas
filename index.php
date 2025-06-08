<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once('database/conn.php');

$tasks = [];

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM task WHERE user_id = :user_id ORDER BY id ASC");
$stmt->execute([':user_id' => $userId]);

if ($stmt->rowCount() > 0) {
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Contagem de tarefas concluídas
$completedCount = 0;
$totalCount = count($tasks);

foreach ($tasks as $task) {
    if ($task['completed'] == 'true' || $task['completed'] == 1) {
        $completedCount++;
    }
}
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TAREFAS</title>
</head>
<body>
    <div id="to_do">
        <p style="color: #e5f9ff; text-align: center;">
         Usuário: <?= $_SESSION['user'] ?> |
         <a href="logout.php" style="color: #77ccff;">Sair</a>
        </p>
        <h1>Minhas tarefas</h1>
        <p id="completed-counter" style="color: #e5f9ff; text-align: center;">
         Tarefas concluídas: <?= $completedCount ?> de <?= $totalCount ?>
        </p>
        <form action="actions/create.php" method="POST" class="to-do-form">
            <input type="text" name="description" placeholder="Escreva sua tarefa" required>
            <button type="submit" class="form-button">
            <i class="fa-solid fa-plus"></i>
            </button>
        </form>

        <div id="tasks">
            <?php foreach($tasks as $task): ?>
                <?php $prioridade = strtolower($task['prioridade']); ?>
                    <div class="task <?= $prioridade ?>">
                    <input 
                        type="checkbox" 
                        name="progress" 
                        class="progress <?= $task['completed'] ? 'done' : '' ?>"
                        data-task-id="<?= $task['id']?>"
                        <?= $task['completed'] ? 'checked' : '' ?>
                    >

                    <p class="task-description">
                        <?= $task['description'] ?>
                    </p>

                    <div class="task-actions">
                        <a class="action-button edit-button">
                        <i class="fa-solid fa-pen"></i>
                        </a>

                        <a href="actions/delete.php?id=<?= $task['id']?>" class="action-button delete-button">
                        <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>

                    <form action="actions/update.php" method="POST" class="to-do-form edit-task hidden">
                        <input type="text" class="hidden" name="id" value="<?= $task['id']?>">
                        <input 
                            type="text"
                            name="description" 
                            placeholder="Edite sua tarefa aqui" 
                            value="<?= $task['description']?>"
                        >
                        <button type="submit" class="form-button confirm-button">
                            <i class="fa-solid fa-check"></i>
                        </button>
                        <select name="prioridade" required>
                            <option value="Alta">Alta</option>
                            <option value="Média" <?= $task['prioridade'] === 'Média' ? 'selected' : '' ?>>Média</option>
                            <option value="Baixa" <?= $task['prioridade'] === 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                        </select>
                    </form>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <script src="src/javascript/script.js"></script>
</body>
</html>
