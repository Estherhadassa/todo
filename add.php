<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task'])) {
    $task = $_POST['task'];
    $user_id = $_SESSION['user_id']; // O ID do usuário logado, que foi armazenado na sessão

    try {
        // Prepara a consulta SQL
        $stmt = $conn->prepare("INSERT INTO tasks (task, user_id) VALUES (:task, :user_id)");
        
        // Faz a vinculação dos parâmetros usando PDO
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':user_id', $user_id);
        
        // Executa a consulta
        $stmt->execute();
        
        // Redireciona para a página inicial após a inserção
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao inserir tarefa: " . $e->getMessage());
    }
}
?>
