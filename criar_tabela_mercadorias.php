<?php
include("conexao.php");

// Cria a tabela mercadorias
$sql = "CREATE TABLE IF NOT EXISTS mercadorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    marca VARCHAR(100),
    preco_compra DECIMAL(10,2),
    margem_lucro DECIMAL(10,2),
    quantidade INT
)";

if (mysqli_query($conexao, $sql)) {
    echo "Tabela mercadorias criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . mysqli_error($conexao);
}
?>
