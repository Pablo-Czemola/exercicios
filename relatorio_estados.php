<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");
include("conexao.php");

$sql = "SELECT * FROM estados ORDER BY nome_estado";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Relatório de Estados</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h2>Relatório de Estados</h2>
    <a class="botao" href="cadastrar_estado.php">Cadastrar Novo Estado</a><br><br>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Ações</th>
        </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome_estado']}</td>
                <td>{$row['sigla']}</td>
                <td>
                  <a href='editar_estado.php?id={$row['id']}'>Editar</a> |
                  <a href='excluir_estado.php?id={$row['id']}'>Excluir</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum estado cadastrado.</p>";
    }
    $conexao->close();
    ?>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
