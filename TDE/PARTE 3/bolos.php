<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'loja_bolos';
$user = 'root'; // Substitua pelo usuário do seu banco
$password = ''; // Substitua pela senha do seu banco

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Consultar os bolos no banco de dados
$query = $pdo->query("SELECT id, nome, url_imagem FROM bolos");
$bolos = $query->fetchAll(PDO::FETCH_ASSOC);

// Retornar os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($bolos);
?>
