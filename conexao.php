<?php
// Conecta ao banco de dados 'comercio'
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "comercio";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
