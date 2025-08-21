<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
$conn = new mysqli("localhost", "root", "", "comercio");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM mercadorias WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "Mercadoria excluída com sucesso.";
} else {
    echo "Erro ao excluir mercadoria: " . $stmt->error;
}
$stmt->close();

header("Location: relatorio_mercadorias.php");
exit;
?>
