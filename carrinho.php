<?php
session_start();
include("conexao.php");

// só permite acesso se o usuário for cliente
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 2) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id'] ?? null;

if (!$id_usuario) {
    echo "id do cliente não encontrado. Verifique se está salvando no login.";
    exit;
}

// busca os itens do carrinho desse cliente com nome da marca e imagem
$sql = "SELECT 
            c.id_car,
            m.nome AS produto,
            ma.nome_mar AS marca_nome,
            m.imagem,
            c.quantidade,
            (m.preco_compra * c.quantidade) AS valor
        FROM carrinho c
        INNER JOIN mercadorias m ON c.idmerc = m.id
        LEFT JOIN marcas ma ON m.marca = ma.id_mar
        WHERE c.id_usuario = '$id_usuario'";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("topocli.html"); ?>

    <div class="container">
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h1>
        <h2>Seu carrinho</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Marca</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['imagem'])): ?>
                                <img src="imagens/<?= htmlspecialchars($row['imagem']) ?>" alt="<?= htmlspecialchars($row['produto']) ?>" style="width:80px; height:auto;">
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['produto']) ?></td>
                        <td><?= htmlspecialchars($row['marca_nome']) ?></td>
                        <td><?= $row['quantidade'] ?></td>
                        <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                        <td>
                            <a href="delete_carrinho.php?id_car=<?= $row['id_car'] ?>" onclick="return confirm('Deseja remover este item do carrinho?')">Remover</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
    </div>

    <?php include("footer.html"); ?>
</body>
</html>
