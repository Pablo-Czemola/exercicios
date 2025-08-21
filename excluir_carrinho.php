<?php
session_start();
include("conexao.php");

// verifica se é cliente
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 2) {
    header("Location: login.php");
    exit;
}

$cpf = $_SESSION['cpf'] ?? null;
$id_car = $_GET['id_car'] ?? null;

if ($cpf && $id_car) {
    $sql = "DELETE FROM carrinho WHERE id_car = '$id_car' AND cpf = '$cpf'";
    $exe = $conexao->query($sql);

    if ($exe) {
        $_SESSION['msg'] = "Produto removido do carrinho.";
    } else {
        $_SESSION['msg'] = "Erro ao remover produto.";
    }
}

header("Location: cliente_area.php");
exit;
?>
