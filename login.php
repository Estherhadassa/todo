<?php
session_start();
require 'db.php';

$error_message = ''; // Mensagem de erro

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    // Verifica se o usuário foi encontrado
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica se a senha fornecida é válida
        if (password_verify($password, $user['password'])) {
            // Senha correta, iniciar sessão e redirecionar para a página inicial
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // Armazenando o user_id na sessão
            header("Location: index.php");
            exit;
        } else {
            // Senha incorreta
            $error_message = "Senha incorreta.";
        }
    } else {
        // Usuário não encontrado
        $error_message = "Usuário não encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('Banner-todo.png');
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            max-width: 400px;
            width: 100%;
            background-color: rgba(201, 191, 191, 0.5); /* Fundo semi-transparente */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: rgba(214, 11, 187, 0.7);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6b0763;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #000;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
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
    <h2>Login</h2>

    <?php if ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Nome de usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <div class="links">
        <a href="cadastro.php">Não tem uma conta? Cadastre-se</a>
    </div>
</div>

</body>
</html>
