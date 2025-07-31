<?php
include("topo.html");
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $tipo_texto = $_POST['tipo'];

    // Converte o valor textual para número: adm = 1, cliente = 2
    $tipo = ($tipo_texto === 'adm') ? 1 : 2;

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar e executar a inserção
    $sql = "INSERT INTO usuarios (login, senha, tipo) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $login, $senha_hash, $tipo);
        if (mysqli_stmt_execute($stmt)) {
            $mensagem = "Usuário cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $mensagem = "Erro na preparação da consulta: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Usuário</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Cadastrar Usuário</h2>

    <?php if (isset($mensagem)): ?>
      <p class="sucesso"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="post" action="cadastrar_usuario.php">
      <label>Login:</label>
      <input type="text" name="login" required>

      <label>Senha:</label>
      <input type="password" name="senha" required>

      <label>Tipo de usuário:</label>
      <select name="tipo" required>
        <option value="cliente">Cliente</option>
        <option value="adm">Administrador</option>
      </select>

      <button type="submit">Cadastrar</button>
    </form>

    <a class="link-voltar" href="relatorio_clientes.php">Ver Clientes</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
      