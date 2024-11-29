<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "admin"; 
$dbname = "todo_db";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Verificar se o nome de usuário já existe no banco de dados
    $check_user_sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($check_user_sql);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();

    // Se o nome de usuário já existe, não permite o cadastro
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Nome de usuário já existe. Por favor, escolha outro.');</script>";
    } else {
        // Caso o nome de usuário não exista, prosseguir com o cadastro
        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Sucesso no cadastro
            echo "<script>
                alert('Usuário cadastrado com sucesso!');
                window.location.href = 'index.php'; // Redireciona para a página inicial 
            </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao registrar o usuário.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        /* Estilos gerais */
        body {
            font-family: Arial, sans-serif;
            background-image: url('Banner-todo.png'); /* Altere para o caminho da sua imagem */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
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
            color: black;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
        }

        nav a:hover {
            color: #ffff;
        }
        .container {
            background-color: rgba(201, 191, 191, 0.5); /* Fundo semi-transparente */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #black;
        }
        label {
            font-size: 14px;
            color: #000;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: rgba(214, 11, 187, 0.7);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #6b0763;
        }
    </style>
</head>
<body>
    <!-- Barra de navegação -->
<nav>
    <a href="inicio.html">
        <img src="Yellow_and_Black_E-Commerce_Logo.webp">
    </a>
    <a href="inicio.html">Home</a>
    <a href="login.php">Login</a>
</nav>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form action="cadastro.php" method="POST">
            <label for="username">Nome de Usuário</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
