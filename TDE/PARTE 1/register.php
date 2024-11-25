<?php
require 'config.php'; // Arquivo de configuração para conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validações básicas
    if (empty($nome_usuario) || empty($senha) || empty($confirmar_senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        // Verifica se o nome de usuário já existe
        $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE nome_usuario = ?");
        $stmt->execute([$nome_usuario]);
        if ($stmt->fetch()) {
            $erro = "Nome de usuário já existe.";
        } else {
            // Criptografa a senha e insere no banco de dados
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO funcionarios (nome_usuario, senha) VALUES (?, ?)");
            if ($stmt->execute([$nome_usuario, $senha_hash])) {
                $sucesso = "Registro realizado com sucesso!";
            } else {
                $erro = "Erro ao registrar o funcionário.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Funcionário</title>
</head>
<body>
    <h1>Registro de Funcionário</h1>
    <?php
    if (isset($erro)) {
        echo "<p style='color: red;'>$erro</p>";
    } elseif (isset($sucesso)) {
        echo "<p style='color: green;'>$sucesso</p>";
    }
    ?>
    <form action="registro.php" method="POST">
        <label for="nome_usuario">Nome de Usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <label for="confirmar_senha">Confirmar Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
    <p><a href="login.php">Já possui uma conta? Faça login aqui.</a></p>
</body>
</html>
