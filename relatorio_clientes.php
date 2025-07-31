<?php
include("topo.html");

$conn = new mysqli("localhost", "root", "", "comercio");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Clientes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Relatório de Clientes</h2>
    <a class="botao" href="cadastrar_cliente.php">Novo Cadastro</a><br><br>

    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Email</th>
          <th>Celular</th>
          <th>Rua</th>
          <th>Bairro</th>
          <th>CEP</th>
          <th>Cidade</th>
          <th>Estado</th>
          <th>Ações</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['cpf'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['celular'] ?></td>
            <td><?= $row['rua'] ?></td>
            <td><?= $row['bairro'] ?></td>
            <td><?= $row['cep'] ?></td>
            <td><?= $row['cidade'] ?></td>
            <td><?= $row['estado'] ?></td>
            <td>
              <a href="editar_cliente.php?id=<?= $row['id'] ?>">Editar</a> |
              <a href="excluir_cliente.php?id=<?= $row['id'] ?>" onclick="return confirm('Deseja excluir?');">Excluir</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>Nenhum cliente cadastrado.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
