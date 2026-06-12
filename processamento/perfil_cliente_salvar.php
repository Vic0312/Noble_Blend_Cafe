<?php

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../model/Cliente.php';

AuthController::requireCliente('../view/login_cliente.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/perfil_cliente.php');
    exit;
}

$resultado = Cliente::atualizarPerfil(AuthController::clienteId(), $_POST);

if ($resultado['ok']) {
    $_SESSION['cliente_nome'] = trim($_POST['nome'] ?? $_SESSION['cliente_nome']);
    $_SESSION['cliente_email'] = trim($_POST['email'] ?? $_SESSION['cliente_email']);
}

flash_set($resultado['ok'] ? 'sucesso' : 'erro', $resultado['ok'] ? 'Perfil atualizado com sucesso.' : $resultado['mensagem']);
header('Location: ../view/perfil_cliente.php');
exit;
