<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
$conn = new mysqli("localhost", "root", "", "comercio");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$celular = $_POST['celular'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

$sql = "UPDATE clientes SET 
    nome='$nome', 
    cpf='$cpf', 
    email='$email', 
    celular='$celular', 
    rua='$rua', 
    bairro='$bairro', 
    cep='$cep', 
    cidade='$cidade', 
    estado='$estado' 
WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Cliente atualizado com sucesso!<br>";
    echo "<a href='relatorio_clientes.php'>Voltar ao relatório</a>";
} else {
    echo "Erro ao atualizar: " . $conn->error;
}

$conn->close();
?>
