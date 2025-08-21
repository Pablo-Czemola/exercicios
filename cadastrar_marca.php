<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");
include("conexao.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_mar = trim($_POST['nome_mar']);

    if (!empty($nome_mar)) {
        $stmt = $conexao->prepare("INSERT INTO marcas (nome_mar) VALUES (?)");
        $stmt->bind_param("s", $nome_mar);

        if ($stmt->execute()) {
            $mensagem = "Marca cadastrada com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar marca: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensagem = "O nome da marca não pode estar vazio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Marca</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Cadastrar Marca</h2>

    <?php if (!empty($mensagem)): ?>
      <p class="sucesso"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form action="cadastrar_marca.php" method="post">
      <label>Nome da Marca:</label>
      <input type="text" name="nome_mar" required>

      <button type="submit">Cadastrar Marca</button>
    </form>

    <a href="cadastrar_mercadoria.php" class="link-voltar">← Voltar para Mercadorias</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>

<?php $conexao->close(); ?>
