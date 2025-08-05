<?php
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
