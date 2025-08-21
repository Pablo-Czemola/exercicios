<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");
include("conexao.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe dados do form
    $nome = $_POST['nome'];
    $marca = $_POST['marca']; // aqui será o id da marca selecionada
    $preco_compra = $_POST['preco_compra'];
    $margem_lucro = $_POST['margem_lucro'];
    $quantidade = $_POST['quantidade'];

    // Upload da imagem
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pasta = 'imagens/';
        $foto = basename($_FILES['foto']['name']);
        $destino = $pasta . $foto;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $mensagem = "Erro ao enviar a imagem.";
            $foto = null;
        }
    }

    // Prepared statement para evitar SQL Injection
    if ($foto) {
        $stmt = $conexao->prepare("INSERT INTO mercadorias (nome, marca, preco_compra, margem_lucro, quantidade, imagem) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siddis", $nome, $marca, $preco_compra, $margem_lucro, $quantidade, $foto);
    } else {
        $stmt = $conexao->prepare("INSERT INTO mercadorias (nome, marca, preco_compra, margem_lucro, quantidade) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siddi", $nome, $marca, $preco_compra, $margem_lucro, $quantidade);
    }

    if ($stmt->execute()) {
        $mensagem = "Mercadoria cadastrada com sucesso!";
    } else {
        $mensagem = "Erro: " . $stmt->error;
        if ($foto) unlink($destino); // Remove arquivo se deu erro
    }
    $stmt->close();
}

// Busca marcas para o select
$sqlMarcas = "SELECT id_mar, nome_mar FROM marcas ORDER BY nome_mar ASC";
$resultMarcas = $conexao->query($sqlMarcas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Cadastrar Mercadoria</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h2>Cadastrar Mercadoria</h2>

    <?php if ($mensagem): ?>
      <p class="sucesso"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form action="cadastrar_mercadoria.php" method="post" enctype="multipart/form-data">
      <label>Nome:</label>
      <input type="text" name="nome" required>

      <label>Marca:</label>
      <select name="marca" required>
        <option value="">Selecione a marca</option>
        <?php
        if ($resultMarcas->num_rows > 0) {
            while ($marca = $resultMarcas->fetch_assoc()) {
                echo "<option value='" . $marca['id_mar'] . "'>" . htmlspecialchars($marca['nome_mar']) . "</option>";
            }
        } else {
            echo "<option value=''>Nenhuma marca cadastrada</option>";
        }
        ?>
      </select>

      <label>Preço de Compra:</label>
      <input type="number" step="0.01" name="preco_compra" required>

      <label>Margem de Lucro (%):</label>
      <input type="number" step="0.01" name="margem_lucro" required>

      <label>Quantidade:</label>
      <input type="number" name="quantidade" required>

      <label>Imagem do Produto:</label>
      <input type="file" name="foto" accept="image/*">

      <button type="submit">Cadastrar</button>
    </form>

    <a class="link-voltar" href="relatorio_mercadorias.php">Ver Mercadorias</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>

<?php
$conexao->close();
?>
