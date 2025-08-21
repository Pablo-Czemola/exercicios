<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

/**
 * Função para verificar tipo de usuário
 * @param int $tipo_necessario Tipo necessário para acessar a página
 */
function verifica_tipo($tipo_necessario) {
    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != $tipo_necessario) {
        // Redireciona para a página correta se o tipo não corresponder
        switch ($_SESSION['tipo']) {
            case 1: // administrador
                header("Location: administração.php");
                break;
            case 2: // cliente
                header("Location: cliente_area.php");
                break;
            default:
                header("Location: login.php");
        }
        exit;
    }
}
?>
