<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome_estado = trim($_POST['nome_estado']);
    $sigla = trim($_POST['sigla']);

    if (!empty($nome_estado) && !empty($sigla)) {
        $stmt = $conexao->prepare("UPDATE estados SET nome_estado = ?, sigla = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome_estado, $sigla, $id);

        if (!$stmt->execute()) {
            die("Erro ao atualizar estado: " . $stmt->error);
        }

        $stmt->close();
        header("Location: relatorio_estados.php");
        exit;
    } else {
        echo "<p class='erro'>Todos os campos são obrigatórios.</p>";
    }
} else {
    echo "<p class='erro'>Requisição inválida.</p>";
}
?>
