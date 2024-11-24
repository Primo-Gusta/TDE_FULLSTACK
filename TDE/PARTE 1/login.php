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
        $_SESSION['funcionario_id'] = $funcionario['id'];
        $_SESSION['nome_usuario'] = $funcionario['nome_usuario'];
        header("Location: admin.php"); // Redirecionar para a área de administração
        exit;
    } else {
        echo "Usuário ou senha inválidos!";
    }
}
?>
