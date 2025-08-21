<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("conexao.php");

$id = $_GET['id'];
$stmt = $conexao->prepare("DELETE FROM estados WHERE id = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    $stmt->close();
    die("Erro ao excluir estado: " . $conexao->error);
}

$stmt->close();
header("Location: relatorio_estados.php");
exit;
?>
