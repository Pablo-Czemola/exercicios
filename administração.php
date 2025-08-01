<?php
include("topo.html");
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $tipo_texto = $_POST['tipo'];

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Converte o valor textual para número: adm = 1, cliente = 2
    $tipo = ($tipo_texto === 'adm') ? 1 : 2;

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar e executar a inserção
    $sql = "INSERT INTO usuarios (login, senha, tipo, nome, cpf, email, celular, rua, bairro, cep, cidade, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisssssssss", $login, $senha_hash, $tipo, $nome, $cpf, $email, $celular, $rua, $bairro, $cep, $cidade, $estado);
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

      <hr>

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
<select name="estado_id" required>
  <option value="">Selecione...</option>
  <?php
    $estados = $conexao->query("SELECT id, sigla FROM estados ORDER BY sigla");
    while ($estado = $estados->fetch_assoc()) {
        echo "<option value='" . $estado['id'] . "'>" . htmlspecialchars($estado['sigla']) . "</option>";
    }
  ?>
</select>

      <button type="submit">Cadastrar</button>
    </form>

    <a class="link-voltar" href="relatorio_clientes.php">Ver Clientes</a>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
