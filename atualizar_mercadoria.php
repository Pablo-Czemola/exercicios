<?php
$conn = new mysqli("localhost", "root", "", "comercio");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$id = $_POST['id'];
$nome = $_POST['nome'];
$marca = $_POST['marca'];
$preco_compra = $_POST['preco_compra'];
$margem_lucro = $_POST['margem_lucro'];
$quantidade = $_POST['quantidade'];

$sql = "UPDATE mercadorias SET 
    nome='$nome', 
    marca='$marca', 
    preco_compra='$preco_compra', 
    margem_lucro='$margem_lucro', 
    quantidade='$quantidade'
    WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Mercadoria atualizada com sucesso.<br>";
    echo "<a href='relatorio_mercadorias.php'>Voltar ao Relatório</a>";
} else {
    echo "Erro ao atualizar: " . $conn->error;
}

$conn->close();
?>
