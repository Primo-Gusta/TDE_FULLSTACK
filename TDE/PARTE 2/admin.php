<?php
session_start();
require 'config.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}

// Inserir bolo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $nome = $_POST['nome'];
    $url_imagem = $_POST['url_imagem'];

    if (empty($nome) || empty($url_imagem)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO bolos (nome, url_imagem) VALUES (?, ?)");
        $stmt->execute([$nome, $url_imagem]);
        $sucesso = "Bolo cadastrado com sucesso!";
    }
}

// Excluir bolo
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM bolos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// Buscar todos os bolos
$stmt = $pdo->query("SELECT * FROM bolos");
$bolos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa - Bolos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        .erro { color: red; }
        .sucesso { color: green; }
    </style>
</head>
<body>
    <h1>Área Administrativa</h1>
    <a href="logout.php">Sair</a>

    <h2>Cadastrar Novo Bolo</h2>
    <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <?php if (isset($sucesso)) echo "<p class='sucesso'>$sucesso</p>"; ?>
    <form action="admin.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="nome">Nome do Bolo:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="url_imagem">URL da Imagem:</label>
        <input type="text" id="url_imagem" name="url_imagem" required>
        <br>
        <button type="submit">Cadastrar</button>
    </form>

    <h2>Lista de Bolos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bolos as $bolo): ?>
                <tr>
                    <td><?php echo $bolo['id']; ?></td>
                    <td><?php echo htmlspecialchars($bolo['nome']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($bolo['url_imagem']); ?>" alt="<?php echo htmlspecialchars($bolo['nome']); ?>" width="100"></td>
                    <td>
                        <a href="editar_bolo.php?id=<?php echo $bolo['id']; ?>">Editar</a> | 
                        <a href="admin.php?acao=excluir&id=<?php echo $bolo['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este bolo?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
