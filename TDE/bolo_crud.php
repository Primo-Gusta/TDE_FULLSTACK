<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Operações CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $nome = $_POST['nome'];
        $imagem = $_POST['imagem'];

        $stmt = $pdo->prepare("INSERT INTO bolos (nome, imagem) VALUES (?, ?)");
        $stmt->execute([$nome, $imagem]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM bolos WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $imagem = $_POST['imagem'];

        $stmt = $pdo->prepare("UPDATE bolos SET nome = ?, imagem = ? WHERE id = ?");
        $stmt->execute([$nome, $imagem, $id]);
    }
}

// Listar bolos
$stmt = $pdo->query("SELECT * FROM bolos");
$bolos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Bolos</title>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['username']); ?></h1>
    <a href="logout.php">Sair</a>
    <h2>Cadastrar Bolo</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome do Bolo" required>
        <input type="text" name="imagem" placeholder="URL da Imagem" required>
        <button type="submit" name="add">Cadastrar</button>
    </form>
    <h2>Lista de Bolos</h2>
    <ul>
        <?php foreach ($bolos as $bolo): ?>
            <li>
                <img src="<?= htmlspecialchars($bolo['imagem']); ?>" alt="<?= htmlspecialchars($bolo['nome']); ?>" width="100">
                <p><?= htmlspecialchars($bolo['nome']); ?></p>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $bolo['id']; ?>">
                    <button type="submit" name="delete">Excluir</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $bolo['id']; ?>">
                    <input type="text" name="nome" value="<?= htmlspecialchars($bolo['nome']); ?>">
                    <input type="text" name="imagem" value="<?= htmlspecialchars($bolo['imagem']); ?>">
                    <button type="submit" name="edit">Salvar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
