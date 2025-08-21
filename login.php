<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include("conexao.php");

    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE login = '$email' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo'] = $usuario['tipo']; // guarda o tipo na sessão também

        // Redireciona conforme o tipo
        if ($usuario['tipo'] == 2) {
            header("Location: cliente_area.php");
        } else {
            header("Location: administração.php");
        }
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }

    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- CSS específico do login -->
    <link rel="stylesheet" href="login.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Script de Toggle -->
    <script defer src="script.js"></script>
</head>
<body>
    <div class="container" id="container">
        <!-- Sign Up (pode manter, ou remover se não for usar) -->
        <div class="form-container sign-up">
            <form>
                <h1>Criar Conta</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>ou use seu email para cadastro</span>
                <input type="text" placeholder="Nome">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Senha">
                <button type="button">Inscrever</button>
            </form>
        </div>

        <!-- Sign In adaptado ao PHP -->
        <div class="form-container sign-in">
            <form method="post" action="login.php">
                <h1>Entrar</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>ou use sua senha de email</span>

                <!-- Exibe erro, se existir -->
                <?php if (!empty($erro)): ?>
                    <p class="erro"><?= htmlspecialchars($erro) ?></p>
                <?php endif; ?>

                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <a href="#">Esqueceu sua senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>

        <!-- Painel de toggle -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem vindo de volta!</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <button id="login" type="button">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá, amigo!</h1>
                    <p>Registre-se com seus dados pessoais para usar todos os recursos do site</p>
                    <button id="register" type="button">Inscrever</button>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.html"); ?>
</body>
</html>
