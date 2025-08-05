<?php
include("topo.html");
include("conexao.php");

$sql = "SELECT * FROM marcas ORDER BY nome_mar";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Marcas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Relatório de Marcas</h2>
    <a class="botao" href="cadastrar_marca.php">Cadastrar Nova Marca</a><br><br>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
          </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id_mar']}</td>
              <td>{$row['nome_mar']}</td>
              <td>
                <a href='editar_marca.php?id={$row['id_mar']}'>Editar</a> |
                <a href='excluir_marca.php?id={$row['id_mar']}'>Excluir</a>
              </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma marca cadastrada.</p>";
    }

    $conexao->close();
    ?>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
