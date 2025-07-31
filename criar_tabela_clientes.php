<?php
include("conexao.php");

// Cria a tabela clientes
$sql = "CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(14),
    email VARCHAR(100),
    celular VARCHAR(20),
    rua VARCHAR(100),
    bairro VARCHAR(50),
    cep VARCHAR(10),
    cidade VARCHAR(50),
    estado VARCHAR(2)
)";

if (mysqli_query($conexao, $sql)) {
    echo "Tabela clientes criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . mysqli_error($conexao);
}
?>

