<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "admin"; // Ajuste a senha conforme sua configuração
$dbname = "todo_db";

// Criação da conexão
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar se o usuário foi encontrado
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Verificar se a senha está correta
        if (password_verify($pass, $userData['password'])) {
            // Redirecionar para a página principal ou painel
            session_start();
            $_SESSION['user'] = $userData['username'];
            header("Location: index.php"); // Redirecionamento após login bem-sucedido
            exit();
        } else {
            // Senha incorreta
            echo "Senha incorreta.";
        }
    } else {
        // Usuário não encontrado
        echo "Usuário não encontrado.";
    }
}
?>
