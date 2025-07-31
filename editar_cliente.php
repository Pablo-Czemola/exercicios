<?php
include("topo.html");

$conn = new mysqli("localhost", "root", "", "comercio");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "<p class='erro'>ID do cliente não informado.</p>";
    include("footer.html");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $cliente = $result->fetch_assoc();
} else {
    echo "<p class='erro'>Cliente não encontrado!</p>";
    include("footer.html");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Cliente</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Editar Cliente</h2>

    <form action="atualizar_cliente.php" method="post">
      <input type="hidden" name="id" value="<?= $cliente['id']; ?>">

      <label>Nome:</label>
      <input type="text" name="nome" value="<?= $cliente['nome']; ?>" required>

      <label>CPF:</label>
      <input type="text" name="cpf" value="<?= $cliente['cpf']; ?>" required>

      <label>Email:</label>
      <input type="email" name="email" value="<?= $cliente['email']; ?>" required>

      <label>Celular:</label>
      <input type="text" name="celular" value="<?= $cliente['celular']; ?>" required>

      <label>Rua:</label>
      <input type="text" name="rua" value="<?= $cliente['rua']; ?>" required>

      <label>Bairro:</label>
      <input type="text" name="bairro" value="<?= $cliente['bairro']; ?>" required>

      <label>CEP:</label>
      <input type="text" name="cep" value="<?= $cliente['cep']; ?>" required>

      <label>Cidade:</label>
      <input type="text" name="cidade" value="<?= $cliente['cidade']; ?>" required>

      <label>Estado:</label>
      <input type="text" name="estado" value="<?= $cliente['estado']; ?>" required>

      <button type="submit">Atualizar</button>
    </form>

    <a class="link-voltar" href="listar_clientes.php">← Voltar para a lista de clientes</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
