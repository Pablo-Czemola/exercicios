<?php
session_start();
include("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 2) {
    header("Location: login.php");
    exit;
}

// Pega o ID do item no carrinho
$id_car = $_GET['id_car'] ?? null;
$id_usuario = $_SESSION['id'];

if (!$id_car) {
    echo "ID do item não informado.";
    exit;
}

// Remove o item do carrinho apenas se pertencer ao usuário logado
$sql = "DELETE FROM carrinho WHERE id_car = ? AND id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_car, $id_usuario);

if ($stmt->execute()) {
    // Redireciona de volta para o carrinho
    header("Location: carrinho.php");
    exit;
} else {
    echo "Erro ao remover item: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
