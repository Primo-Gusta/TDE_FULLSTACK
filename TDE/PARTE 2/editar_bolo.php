<?php
session_start();
require 'config.php';

if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin.php");
    exit;
}

// Buscar informações do bolo
$stmt = $pdo->prepare("SELECT * FROM bolos WHERE id = ?");
$stmt->execute([$id]);
$bolo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bolo) {
    header("Location: admin.php");
    exit;
}

// Atualizar informações do bolo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $url_imagem = $_POST['url_imagem'];

    if (empty($nome) || empty($url_imagem)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        $stmt = $pdo->prepare("UPDATE bolos SET nome = ?, url_imagem = ? WHERE id = ?");
        $stmt->execute([$nome, $url_imagem, $id]);
        header("Location: admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bolo</title>
</head>
<body>
    <h1>Editar Bolo</h1>
    <a href="admin.php">Voltar</a>
    <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
    <form action="" method="POST">
        <label for="nome">Nome do Bolo:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($bolo['nome']); ?>" required>
        <br>
        <label for="url_imagem">URL da Imagem:</label>
        <input type="text" id="url_imagem" name="url_imagem" value="<?php echo htmlspecialchars($bolo['url_imagem']); ?>" required>
        <br>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
