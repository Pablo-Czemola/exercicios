<?php
include("valida_sessao.php");

// Permite somente administrador (tipo = 1)
verifica_tipo(1);
include("topo.html");

$conn = new mysqli("localhost", "root", "", "comercio");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Faz join com marcas para pegar o nome da marca
$sql = "SELECT m.*, ma.nome_mar 
        FROM mercadorias m
        LEFT JOIN marcas ma ON m.marca = ma.id_mar
        ORDER BY m.id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Relatório de Mercadorias</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h2>Relatório de Mercadorias</h2>
    <a class="botao" href="cadastrar_mercadoria.php">Cadastrar Nova Mercadoria</a><br><br>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Marca</th>
            <th>Preço Compra</th>
            <th>Margem Lucro (%)</th>
            <th>Quantidade</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>" . htmlspecialchars($row['nome_mar'] ?? 'Sem marca') . "</td>
                <td>R$ " . number_format($row['preco_compra'], 2, ',', '.') . "</td>
                <td>{$row['margem_lucro']}%</td>
                <td>{$row['quantidade']}</td>
                <td>";
                if (!empty($row['imagem'])) {
                    echo "<img src='imagens/{$row['imagem']}' alt='{$row['nome']}' width='80'>";
                } else {
                    echo "Sem imagem";
                }
            echo "</td>
                <td>
                  <a href='editar_mercadoria.php?id={$row['id']}'>Editar</a> |
                  <a href='excluir_mercadoria.php?id={$row['id']}'>Excluir</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma mercadoria cadastrada.</p>";
    }

    $conn->close();
    ?>
  </div>

  <?php include("footer.html"); ?>
</body>
</html>
