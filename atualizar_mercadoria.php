<?php
include("valida_sessao.php");
verifica_tipo(1);
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $preco_compra = $_POST['preco_compra'];
    $margem_lucro = $_POST['margem_lucro'];
    $quantidade = $_POST['quantidade'];

    $imagem_nome = '';

    // Verifica se enviou uma nova imagem
    if (!empty($_FILES['imagem']['name'])) {
        $pasta = 'imagens/';
        $imagem_nome = basename($_FILES['imagem']['name']);
        $destino = $pasta . $imagem_nome;

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            echo "Erro ao enviar a imagem.";
            exit;
        }
    } else {
        // Mantém a imagem atual
        $sqlImg = "SELECT imagem FROM mercadorias WHERE id = $id";
        $resImg = $conexao->query($sqlImg);
        if ($resImg->num_rows > 0) {
            $row = $resImg->fetch_assoc();
            $imagem_nome = $row['imagem'];
        }
    }

    $stmt = $conexao->prepare("UPDATE mercadorias SET nome=?, marca=?, preco_compra=?, margem_lucro=?, quantidade=?, imagem=? WHERE id=?");
    $stmt->bind_param("siddisi", $nome, $marca, $preco_compra, $margem_lucro, $quantidade, $imagem_nome, $id);

    if ($stmt->execute()) {
        header("Location: relatorio_mercadorias.php");
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }
}
?>
