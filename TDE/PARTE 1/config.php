<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'loja_bolos';
$user = 'root'; // Substitua pelo seu usuário do banco
$password = ''; // Substitua pela senha do banco

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
