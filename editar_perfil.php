<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 2) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id'];

// se o formulário for enviado, atualiza os dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $celular = $conexao->real_escape_string($_POST['celular']);
    $rua = $conexao->real_escape_string($_POST['rua']);
    $bairro = $conexao->real_escape_string($_POST['bairro']);
    $cep = $conexao->real_escape_string($_POST['cep']);
    $cidade = $conexao->real_escape_string($_POST['cidade']);
    $estado = $conexao->real_escape_string($_POST['estado']);

    $sql = "UPDATE usuarios SET nome='$nome', celular='$celular', rua='$rua', bairro='$bairro', cep='$cep', cidade='$cidade', estado='$estado' WHERE id='$id_usuario'";
    $conexao->query($sql);
    $msg = "Dados atualizados com sucesso!";
}

// pega os dados atuais
$sql = "SELECT * FROM usuarios WHERE id='$id_usuario'";
$result = $conexao->query($sql);
$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meu Perfil</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("topocli.html"); ?>

<div class="container">
    <h1>Editar Perfil</h1>
    <?php if(!empty($msg)) echo "<p>$msg</p>"; ?>
    <form method="post">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        <label>Celular:</label>
        <input type="text" name="celular" value="<?= htmlspecialchars($usuario['celular']) ?>">
        <label>Rua:</label>
        <input type="text" name="rua" value="<?= htmlspecialchars($usuario['rua']) ?>">
        <label>Bairro:</label>
        <input type="text" name="bairro" value="<?= htmlspecialchars($usuario['bairro']) ?>">
        <label>CEP:</label>
        <input type="text" name="cep" value="<?= htmlspecialchars($usuario['cep']) ?>">
        <label>Cidade:</label>
        <input type="text" name="cidade" value="<?= htmlspecialchars($usuario['cidade']) ?>">
        <label>Estado:</label>
        <input type="text" name="estado" value="<?= htmlspecialchars($usuario['estado']) ?>">
        <button type="submit">Salvar</button>
    </form>
</div>

<?php include("footer.html"); ?>
</body>
</html>
