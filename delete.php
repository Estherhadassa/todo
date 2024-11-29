<?php
require 'db.php'; // Certifique-se de que a conexão com o banco está sendo incluída

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Consulta SQL para excluir a tarefa
    $sql = "DELETE FROM tasks WHERE id = :id";
    
    // Prepara a consulta
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro :id ao valor da tarefa
    $stmt->bindParam(':id', $task_id, PDO::PARAM_INT);

    // Executa a consulta
    if ($stmt->execute()) {
        // Redireciona para a página principal (index.php) após a exclusão
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao excluir a tarefa.";
    }
} else {
    echo "ID da tarefa não especificado.";
}
?>
