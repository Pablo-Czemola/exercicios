<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexao.php"); // arquivo que faz conexão com o banco (deve conter $conexao)

    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE login = '$email' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        header("Location: inicio.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php include("topo.html"); ?>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($erro)) : ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label>Email:</label>
            <input type="email" name="email" required />
            
            <label>Senha:</label>
            <input type="password" name="senha" required />
            
            <button type="submit">Entrar</button>
        </form>
    </div>
    <?php include("footer.html"); ?>
</body>
</html>
