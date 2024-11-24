<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_usuario = $_POST['nome_usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Validação
    if (empty($nome_usuario) || empty($_POST['senha'])) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    // Inserir no banco de dados
    $stmt = $pdo->prepare("INSERT INTO funcionarios (nome_usuario, senha) VALUES (?, ?)");
    try {
        $stmt->execute([$nome_usuario, $senha]);
        echo "Funcionário cadastrado com sucesso!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código de erro para UNIQUE constraint
            echo "Nome de usuário já está em uso.";
        } else {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>
