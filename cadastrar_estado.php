<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");
include("conexao.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_estado = trim($_POST['nome_estado']);
    $sigla = trim($_POST['sigla']);

    if (!empty($nome_estado) && !empty($sigla)) {
        $stmt = $conexao->prepare("INSERT INTO estados (nome_estado, sigla) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome_estado, $sigla);

        if ($stmt->execute()) {
            $mensagem = "Estado cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar estado: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensagem = "Todos os campos são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Estado</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Cadastrar Estado</h2>

    <?php if (!empty($mensagem)): ?>
      <p class="sucesso"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form action="cadastrar_estado.php" method="post">
      <label>Nome do Estado:</label>
      <input type="text" name="nome_estado" required>

      <label>Sigla do Estado (ex: PR):</label>
      <input type="text" name="sigla" maxlength="2" style="text-transform: uppercase;" required>

      <button type="submit">Cadastrar Estado</button>
    </form>

    <a href="index.php" class="link-voltar">← Voltar para o Início</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>

<?php $conexao->close(); ?>
