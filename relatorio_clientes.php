<?php
include("topo.html");
include("conexao.php");

$sql = " SELECT u.id, u.nome, u.cpf, u.login AS email, u.celular, u.rua, u.bairro, u.cep, u.cidade, e.sigla AS estado, u.tipo FROM usuarios u LEFT JOIN estados e ON u.estado = e.id ORDER BY u.nome";

$result = $conexao->query($sql);
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
    <a class="botao" href="cadastrar_usuario.php">Novo Cadastro</a><br><br>

    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Email (Login)</th>
          <th>Celular</th>
          <th>Rua</th>
          <th>Bairro</th>
          <th>CEP</th>
          <th>Cidade</th>
          <th>Estado</th>
          <th>Tipo</th>
          <th>Ações</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['cpf']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['celular']) ?></td>
            <td><?= htmlspecialchars($row['rua']) ?></td>
            <td><?= htmlspecialchars($row['bairro']) ?></td>
            <td><?= htmlspecialchars($row['cep']) ?></td>
            <td><?= htmlspecialchars($row['cidade']) ?></td>
            <td><?= htmlspecialchars($row['estado']) ?></td>
            <td>
              <?= $row['tipo'] == 1 ? 'Administrador' : 'Cliente' ?>
            </td>
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

    <?php $conexao->close(); ?>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
