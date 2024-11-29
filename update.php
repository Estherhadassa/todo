<?php
require 'db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Recupera o ID da tarefa
    $taskId = $_GET['id'];

    // Consulta para obter a tarefa atual
    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        echo "Tarefa não encontrada!";
        exit;
    }

    // Verifica se o formulário foi enviado para atualizar a tarefa
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        $updatedTask = $_POST['task'];

        // Atualiza a tarefa no banco de dados
        $updateSql = "UPDATE tasks SET task = :task WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':task', $updatedTask);
        $updateStmt->bindParam(':id', $taskId);

        if ($updateStmt->execute()) {
            // Redireciona para a página principal após a atualização
            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao atualizar tarefa.";
        }
    }
} else {
    echo "ID da tarefa não informado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-image: url('Banner-todo.png'); /* Altere para o caminho da sua imagem */
        }
        /* Barra de navegação */
        nav {
            width: 100%;
            background-color: rgba(214, 11, 187, 0.7);
            padding: 10px 0;
            position: absolute;
            top: 0;
            left: 0;
            text-align: center;
        }
        nav img {
            max-height: 80px; /* Ajuste conforme necessário */
            position: absolute;
            margin-top: 0px;
            top: -10px;
            left: 32px;
            cursor: pointer;
        }

        nav a {
            color: Black;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
        }

        nav a:hover {
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 20%;
            background: #fff;
            padding: 20px;
            background-color: #white; /* Fundo semi-transparente */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: rgba(214, 11, 187, 0.7);
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #6b0763;
        }
    </style>
</head>
<body>
    <!-- Barra de navegação -->
    <nav>
        <a href="index.php">
            <img src="Yellow_and_Black_E-Commerce_Logo.webp">
        </a>
        <a href="index.php">Home</a>
        <a href="login.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Editar Tarefa</h1>

        <!-- Formulário para editar a tarefa -->
        <form action="update.php?id=<?= htmlspecialchars($task['id']) ?>" method="POST">
            <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required>
            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
