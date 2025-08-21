<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
$conn = new mysqli("localhost", "root", "", "comercio");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
} else {
    $stmt->close();
    die("Erro ao excluir cliente: " . $conn->error);
}

header("Location: relatorio_clientes.php");
exit;
?>
