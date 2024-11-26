<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO funcionarios (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "Funcionário cadastrado com sucesso!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
</head>
<body>
    <h1>Cadastrar Funcionário</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
