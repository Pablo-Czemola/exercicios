<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");
include("conexao.php");

if (!isset($_GET['id'])) {
    echo "<p class='erro'>ID do estado não informado.</p>";
    include("footer.html");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM estados WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='erro'>Estado não encontrado.</p>";
    include("footer.html");
    exit;
}

$estado = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Estado</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Editar Estado</h2>

    <form action="atualizar_estado.php" method="post">
      <input type="hidden" name="id" value="<?php echo $estado['id']; ?>">

      <label>Nome do Estado:</label>
      <input type="text" name="nome_estado" value="<?php echo htmlspecialchars($estado['nome_estado']); ?>" required>

      <label>Sigla:</label>
      <input type="text" name="sigla" maxlength="2" value="<?php echo htmlspecialchars($estado['sigla']); ?>" style="text-transform: uppercase;" required>

      <button type="submit">Atualizar</button>
    </form>

    <a class="link-voltar" href="relatorio_estados.php">← Voltar para a lista</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
