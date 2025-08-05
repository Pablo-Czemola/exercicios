<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_mar'];
    $nome_mar = trim($_POST['nome_mar']);

    if (!empty($nome_mar)) {
        $stmt = $conexao->prepare("UPDATE marcas SET nome_mar = ? WHERE id_mar = ?");
        $stmt->bind_param("si", $nome_mar, $id);

        if (!$stmt->execute()) {
            die("Erro ao atualizar marca: " . $stmt->error);
        }

        $stmt->close();
        header("Location: relatorio_marcas.php");
        exit;
    } else {
        echo "<p class='erro'>O nome da marca não pode estar vazio.</p>";
    }
} else {
    echo "<p class='erro'>Requisição inválida.</p>";
}
?>
