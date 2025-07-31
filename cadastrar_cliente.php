<?php
include("topo.html");

include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO clientes (nome, cpf, email, celular, rua, bairro, cep, cidade, estado) 
            VALUES ('$nome', '$cpf', '$email', '$celular', '$rua', '$bairro', '$cep', '$cidade', '$estado')";
    
    if (mysqli_query($conexao, $sql)) {
        $mensagem = "Cliente cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar cliente: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Cliente</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Cadastrar Cliente</h2>

    <?php if (isset($mensagem)): ?>
      <p class="sucesso"><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="post" action="cadastrar_cliente.php">
      <label>Nome:</label>
      <input type="text" name="nome" required>

      <label>CPF:</label>
      <input type="text" name="cpf" required>

      <label>Email:</label>
      <input type="email" name="email" required>

      <label>Celular:</label>
      <input type="text" name="celular" required>

      <label>Rua:</label>
      <input type="text" name="rua" required>

      <label>Bairro:</label>
      <input type="text" name="bairro" required>

      <label>CEP:</label>
      <input type="text" name="cep" required>

      <label>Cidade:</label>
      <input type="text" name="cidade" required>

      <label>Estado:</label>
      <input type="text" name="estado" required>

      <button type="submit">Cadastrar</button>
    </form>

    <a class="link-voltar" href="relatorio_clientes.php">Ver Clientes</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
