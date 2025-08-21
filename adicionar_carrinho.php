<?php
session_start();
include("conexao.php");

// só permite acesso se o usuário for cliente
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 2) {
    header("Location: login.php");
    exit;
}

// pega o ID do usuário logado
$id_usuario = $_SESSION['id'] ?? null;

if (!$id_usuario) {
    echo "ID do cliente não encontrado. Verifique se está salvando no login.";
    exit;
}

// pega o ID da mercadoria enviado por GET
$id_mercadoria = $_GET['id'] ?? null;

if (!$id_mercadoria) {
    echo "ID do produto não informado.";
    exit;
}

// verifica se o produto já está no carrinho
$sql_check = "SELECT id_car, quantidade FROM carrinho WHERE id_usuario = '$id_usuario' AND idmerc = '$id_mercadoria'";
$result_check = $conexao->query($sql_check);

if ($result_check && $result_check->num_rows > 0) {
    // se já existe, aumenta a quantidade em 1
    $row = $result_check->fetch_assoc();
    $id_car = $row['id_car'];
    $nova_quantidade = $row['quantidade'] + 1;

    $sql_update = "UPDATE carrinho SET quantidade = '$nova_quantidade' WHERE id_car = '$id_car'";
    if ($conexao->query($sql_update)) {
        header("Location: cliente_area.php?msg=Produto+atualizado+no+carrinho");
        exit;
    } else {
        echo "Erro ao atualizar a quantidade no carrinho.";
        exit;
    }
} else {
    // se não existe, insere um novo registro
    $sql_insert = "INSERT INTO carrinho (id_usuario, idmerc, quantidade) VALUES ('$id_usuario', '$id_mercadoria', 1)";
    if ($conexao->query($sql_insert)) {
        header("Location: cliente_area.php?msg=Produto+adicionado+ao+carrinho");
        exit;
    } else {
        echo "Erro ao adicionar produto no carrinho.";
        exit;
    }
}

$conexao->close();
?>
