<?php
include("topo.html");
include("conexao.php");

$conn = new mysqli("localhost", "root", "", "comercio");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM mercadorias WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mercadoria = $result->fetch_assoc();
    } else {
        echo "<p class='erro'>Mercadoria não encontrada.</p>";
        include("footer.html");
        exit;
    }
} else {
    echo "<p class='erro'>ID da mercadoria não informado.</p>";
    include("footer.html");
    exit;
}

// Busca marcas para o select
$sqlMarcas = "SELECT id_mar, nome_mar FROM marcas ORDER BY nome_mar ASC";
$resultMarcas = $conexao->query($sqlMarcas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Mercadoria</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Editar Mercadoria</h2>

    <form action="atualizar_mercadoria.php" method="post">
      <input type="hidden" name="id" value="<?php echo $mercadoria['id']; ?>">

      <label>Nome:</label>
      <input type="text" name="nome" value="<?php echo $mercadoria['nome']; ?>" required>

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
      <input type="number" step="0.01" name="preco_compra" value="<?php echo $mercadoria['preco_compra']; ?>" required>

      <label>Margem de Lucro (%):</label>
      <input type="number" step="0.01" name="margem_lucro" value="<?php echo $mercadoria['margem_lucro']; ?>" required>

      <label>Quantidade:</label>
      <input type="number" name="quantidade" value="<?php echo $mercadoria['quantidade']; ?>" required>

      <button type="submit">Atualizar</button>
    </form>

    <a class="link-voltar" href="relatorio_mercadorias.php">← Voltar para lista</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
