<?php

require_once __DIR__ . '/../controller/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/login_cliente.php');
    exit;
}

$email = trim($_POST['email'] ?? $_POST['documento'] ?? '');
$senha = (string) ($_POST['senha'] ?? '');

$resultado = AuthController::loginCliente($email, $senha);

if ($resultado['ok']) {
    header('Location: ../view/logado_cliente.php');
    exit;
}

flash_set('erro', $resultado['mensagem']);
header('Location: ../view/login_cliente.php');
exit;
