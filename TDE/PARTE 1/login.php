<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    // Buscar funcionário no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE nome_usuario = ?");
    $stmt->execute([$nome_usuario]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($funcionario && password_verify($senha, $funcionario['senha'])) {
        // Armazena os dados na sessão
        $_SESSION['funcionario_id'] = $funcionario['id'];
        $_SESSION['nome_usuario'] = $funcionario['nome_usuario'];

        // Redireciona para a área administrativa
        header("Location: admin.php");
        exit; // Sempre finalize com exit após header()
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Funcionários</title>
</head>
<body>
    <h1>Login de Funcionários</h1>
    <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
    <form action="login.php" method="POST">
        <label for="nome_usuario">Nome de Usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
