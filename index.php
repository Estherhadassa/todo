<?php
session_start();
require 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Obtém o ID do usuário logado

// Consulta para buscar apenas as tarefas do usuário logado
$sql = "SELECT * FROM tasks WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('Banner-todo.png'); /* Altere para o caminho da sua imagem */
            padding: 0;
        }
        nav {
            width: 100%;
            background-color: rgba(214, 11, 187, 0.7);
            padding: 10px 0;
            position: fixed;
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
            color: black;
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
            margin: 120px auto 0;
            background: #fff;
            padding: 20px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        button.edit {
            background-color: #ffc107;
        }
        button.edit:hover {
            background-color: #ff9900;
        }
        button.delete {
            background-color: #dc3545;
        }
        button.delete:hover {
            background-color: #cc0000;
        }
        
    </style>
</head>
<body>
    <nav>
    <a href="index.php">
        <img src="Yellow_and_Black_E-Commerce_Logo.webp">
    </a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Suas Tarefas</h1>
        <form action="add.php" method="POST">
            <input type="text" name="task" placeholder="Nova tarefa" required>
            <button type="submit">Adicionar</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tarefa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($result) > 0): ?>
                    <?php foreach ($result as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td> <!-- Índice dinâmico -->
                            <td><?= htmlspecialchars($row['task']) ?></td>
                            <td>
                                <a href="update.php?id=<?= $row['id'] ?>"><button class="edit">Editar</button></a>
                                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"><button class="delete">Excluir</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Nenhuma tarefa encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
