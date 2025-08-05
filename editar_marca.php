<?php
include("topo.html");
include("conexao.php");

if (!isset($_GET['id'])) {
    echo "<p class='erro'>ID da marca não informado.</p>";
    include("footer.html");
    exit;
}

$id = $_GET['id'];
$stmt = $conexao->prepare("SELECT * FROM marcas WHERE id_mar = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='erro'>Marca não encontrada.</p>";
    include("footer.html");
    exit;
}

$marca = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Marca</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Editar Marca</h2>

    <form action="atualizar_marca.php" method="post">
      <input type="hidden" name="id_mar" value="<?php echo $marca['id_mar']; ?>">

      <label>Nome da Marca:</label>
      <input type="text" name="nome_mar" value="<?php echo htmlspecialchars($marca['nome_mar']); ?>" required>

      <button type="submit">Atualizar</button>
    </form>

    <a class="link-voltar" href="relatorio_marcas.php">← Voltar para lista de marcas</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
