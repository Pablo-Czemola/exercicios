<?php
include("conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("DELETE FROM marcas WHERE id_mar = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Erro ao excluir marca: " . $stmt->error);
    }

    $stmt->close();
    header("Location: relatorio_marcas.php");
    exit;
} else {
    echo "ID da marca não informado.";
}
?>
